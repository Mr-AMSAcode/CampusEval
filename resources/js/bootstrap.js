/**
 * Bootstrap file for JavaScript application
 * Initializes common JavaScript utilities and configuration
 */

import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next, we will create a fresh JavaScript instance and attach all the event
 * listeners for the various events that our JavaScript will need to handle.
 */
