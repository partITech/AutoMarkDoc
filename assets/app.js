
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import 'bootstrap/dist/css/bootstrap.min.css';
import './vendor/bootstrap/bootstrap.index.js';
import '@fortawesome/fontawesome-free/css/all.css';
import './styles/app.scss';
import 'prismjs/themes/prism.min.css'
import 'prism-themes/themes/prism-cb.css'
// import jquery globally
import 'jquery'
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// start the Stimulus application
import './bootstrap.js';
console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
