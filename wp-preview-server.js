/**
 * wp-preview-server.js
 *
 * Runs the WordPress copy in ./wordpress on PHP-WASM (@php-wasm/node)
 * and serves it over HTTP on 0.0.0.0:8080 (visible as a live preview).
 * No MySQL needed: wp-content/db.php is the SQLite drop-in.
 *
 * Run from the .wp-run folder so node_modules resolves:
 *   cd .wp-run && NODE_PATH=$PWD/node_modules PORT=8080 node ../wp-preview-server.js
 */
const http = require('http');
const path = require('path');
const { PHP, PHPRequestHandler } = require('@php-wasm/universal');
const { loadNodeRuntime, useHostFilesystem } = require('@php-wasm/node');

const WP_DIR = path.resolve(__dirname, 'wordpress');
const PORT = Number(process.env.PORT || 8080);

(async () => {
  const runtimeId = await loadNodeRuntime('8.3', {
    emscriptenOptions: { processId: 1 },
  });
  const php = new PHP(runtimeId);
  useHostFilesystem(php); // mount the real host filesystem into the PHP VFS
  php.chdir(WP_DIR);

  php.requestHandler = new PHPRequestHandler({
    php,
    documentRoot: WP_DIR,
    absoluteUrl: 'http://127.0.0.1:' + PORT,
    // WordPress-style routing: existing files are served as-is,
    // everything else goes through index.php (pretty permalinks, 404s...).
    getFileNotFoundAction: () => ({ type: 'internal-redirect', uri: '/index.php' }),
  });

  console.log('[wp-preview] PHP-WASM ready, docroot:', WP_DIR);

  const server = http.createServer(async (req, res) => {
    try {
      const chunks = [];
      for await (const c of req) chunks.push(c);
      const body = Buffer.concat(chunks);

      const headers = {};
      for (const [k, v] of Object.entries(req.headers)) {
        headers[k] = Array.isArray(v) ? v.join(', ') : String(v);
      }
      // The sandbox preview proxy terminates TLS; let WordPress know the real scheme.
      if (headers['x-forwarded-proto'] === 'https') headers['https'] = 'on';

      const response = await php.request({
        method: req.method.toUpperCase(),
        url: 'http://127.0.0.1:' + PORT + req.url,
        headers,
        body: body.length ? new Uint8Array(body) : undefined,
      });

      res.statusCode = response.httpStatusCode || 200;
      for (const [k, vals] of Object.entries(response.headers || {})) {
        const key = k.toLowerCase();
        if (['content-length', 'transfer-encoding', 'connection'].includes(key)) continue;
        for (const v of vals) res.appendHeader(k, v);
      }
      if (response.errors) console.error('[php-stderr]', response.errors.slice(0, 800));
      res.end(Buffer.from(response.bytes));
    } catch (e) {
      console.error('[wp-preview] error:', e);
      res.statusCode = 500;
      res.end('Internal error: ' + (e && e.message));
    }
  });

  server.listen(PORT, '0.0.0.0', () => {
    console.log('[wp-preview] listening on http://0.0.0.0:' + PORT);
  });
})().catch((e) => {
  console.error('[wp-preview] FATAL', e);
  process.exit(1);
});
