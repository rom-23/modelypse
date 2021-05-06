
import('../css/app.scss');
const $ = require('jquery');
// global.$ = global.jQuery = $;
import { Tooltip, Toast, Popover } from 'bootstrap';
import('../bootstrap.js');
import('./main.js');

$('#contactButton').click(e => {
    e.preventDefault();
    $('#contactForm').slideDown();
    $('#contactButton').slideUp();
});
