/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
// import './bootstrap';

// ---------------------------------------------------------------------------------
//                                JAVASCRIPT
// ---------------------------------------------------------------------------------

// document.removeEventListener("DOMContentLoaded", () => {
	const sideMenu = document.querySelector("aside");
	// const menuBtn = document.querySelector("#menu-btn");
	const closeBtn = document.querySelector("#close-btn");
	const themeToggler = document.querySelector(".theme-toggler");

	// // show sidebar
	// menuBtn.addEventListener('click', () => {
	// 	sideMenu.style.display = 'block';
	// })

	// // close sidebar
	// closeBtn.addEventListener('click', () => {
	// 	sideMenu.style.display = 'none';
	// })

	// change theme
	themeToggler.addEventListener('click', () => {
		document.body.classList.toggle('dark-theme-variables');
		themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
		themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');
	})

// });

// ---------------------------------------------------------------------------------
//                              END JAVASCRIPT
// ---------------------------------------------------------------------------------