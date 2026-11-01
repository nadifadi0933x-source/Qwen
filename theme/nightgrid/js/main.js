/* NightGrid front-end behaviour: mobile menu + back-to-top. */
document.addEventListener('DOMContentLoaded', function () {
	var toggle = document.querySelector('.nav-toggle');
	var nav = document.querySelector('.main-navigation');
	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			var open = nav.classList.toggle('open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
	}

	var btt = document.querySelector('.back-to-top');
	if (btt) {
		window.addEventListener('scroll', function () {
			btt.classList.toggle('show', window.scrollY > 600);
		}, { passive: true });
		btt.addEventListener('click', function () {
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});
	}
});
