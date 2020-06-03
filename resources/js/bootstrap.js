window.$ = window.jQuery = require('jquery');

require('bootstrap');

window.AOS = require('aos');

window.Drift = require('drift-zoom').default;

//window.Swipe = require('swipejs');

// My custom isotope plugin
// Reason is that it crashes with BS card-columns
//require('./customIsotope.js');

// My custom magicLine plugin
//require('./magicLine.js');

// My custom modal plugin
require('./imagePopup.js');

// Inifinity scroll
//require('jscroll');

//window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

//window.axios = require('axios');

//window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
