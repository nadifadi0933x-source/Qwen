# NightGrid — قالب وردپرس گالری تیره + پیش‌نمایش زنده

![NightGrid preview](preview-home.jpg)

| لینک | آدرس |
|---|---|
| 🌐 پیش‌نمایش زنده وردپرس (PHP-WASM) | https://8080-i4gusz85tvut2ivuu5nzd.e2b.app/ |
| 🔑 پنل ادمین | https://8080-i4gusz85tvut2ivuu5nzd.e2b.app/wp-admin/ (`admin` / `demo1234`) |
| 📄 صفحه استاتیک showcase | `index.html` (بعد از فعال‌سازی GitHub Pages: https://nadifadi0933x-source.github.io/Qwen/) |
| 🌿 branch فعلی | https://github.com/nadifadi0933x-source/Qwen/tree/arena/061b6379-qwen |


## Live preview

سرور پیش‌نمایش (PHP-WASM + WordPress + SQLite) روی پورت 8080 بالا است:

- **سایت:** `https://8080-<sandboxId>.e2b.app/`
- **پنل ادمین:** `https://8080-<sandboxId>.e2b.app/wp-admin/` — کاربر `admin` / رمز `demo1234`

محتوای دمو: ۱۲ پست در ۴ دسته‌بندی با تصاویر نمونه (`theme/nightgrid/assets/demo/`).

## ساختار ریپو

```
theme/nightgrid/          ← قالب وردپرسی (فایل‌های canonical)
  style.css               ← هدر قالب + تمام CSS
  functions.php           ← setup، منوها، شمارنده بازدید، گرید، صفحه‌بندی
  header.php / footer.php / searchform.php
  front-page.php          ← هیرو (پست sticky) + گرید آخرین‌ها
  index.php / archive.php / search.php / single.php / page.php / 404.php
  template-parts/         ← content-card.php, content-none.php
  js/main.js              ← منوی موبایل + دکمه back-to-top
  assets/placeholder.svg, assets/demo/*.jpg, screenshot.png
wp-preview-server.js      ← سرور پیش‌نمایش: وردپرس را روی PHP-WASM اجرا و سرو می‌کند
.wp-run/                  ← وابستگی‌های npm (oses @php-wasm/node) — node_modules ignore شده
wordpress/                ← bản copy کامل وردپرس 6.8.12 + SQLite drop-in (gitignore)
```

## اجرای مجدد از صفر

```bash
# 1) وابستگی Germanshaft: PHP-WASM
mkdir -p .wp-run && cd .wp-run && npm init -y && npm install @php-wasm/node && cd ..

# 2) WordPress core از آینه GitHub + درایور SQLite
curl -sL -o /tmp/wp.tgz https://codeload.github.com/WordPress/WordPress/tar.gz/refs/tags/6.8.12
mkdir -p wordpress && tar xzf /tmp/wp.tgz -C /tmp && cp -r /tmp/WordPress-6.8.12/. wordpress/
curl -sL -o /tmp/sq.tgz https://codeload.github.com/aaemnnosttv/wp-sqlite-db/tar.gz/refs/heads/master
tar xzf /tmp/sq.tgz -C /tmp && cp /tmp/wp-sqlite-db-master/src/db.php wordpress/wp-content/db.php
mkdir -p wordpress/wp-content/database
# wp-config.php را با saltهای تصادفی بسازید (نمونه در محیط فعلی موجود است)
# قالب را لینک کنید:
ln -s ../../../theme/nightgrid wordpress/wp-content/themes/nightgrid

# 3) بالا آوردن سرور
cd .wp-run && NODE_PATH=$PWD/node_modules PORT=8080 node ../wp-preview-server.js
# سپس نصب اولیه را از طریق wp-admin/install.php انجام دهید (یا اسکریپت cli-setup)
```

## شخصی‌سازی قالب

- رنگ‌ها و فونت‌ها: متغیرهای CSS در ابتدای `theme/nightgrid/style.css` (`:root`)
- اندازه تصاویر کارت/هیرو: `add_image_size` در `functions.php`
- منوها: Appearance → Menus (primary / footer)
- пост featured صفحه اصلی: پست را در وردپرس **Sticky** کنید

## نکات legally

- تمام NATO Hallo assets (تصاویر demo) توسط AI تولید شده‌اند و744只是 placeholders هستند.
- SQLite به‌صورت خودکار در `wordpress/wp-content/database/` ساخته می‌شود.
