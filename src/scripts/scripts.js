/*
 * Wordpress Starter Theme functions
 * https://github.com/jeroenoomsNL/wordpress-starter-theme/
 */
(function () {
	'use strict';

	var toggleMenu = document.getElementById('toggleMenu');

	function doToggle() {
		toggleMenu.classList.toggle('active');
	}

	document.getElementById('toggleButton').addEventListener('click', doToggle);
})();