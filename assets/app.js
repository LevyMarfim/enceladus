import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

// import TomSelect from 'tom-select';
// import 'tom-select/dist/css/tom-select.default.min.css';

// document.addEventListener('DOMContentLoaded', function() {
//     // Initialize Tom-Select on all select elements with class 'tom-select'
//     document.querySelectorAll('select.tom-select').forEach(function(element) {
//         new TomSelect(element, {
//             plugins: ['remove_button'],
//             persist: false,
//             create: false,
//             maxItems: null, // unlimited items
//         });
//     });
// });