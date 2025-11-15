/**
 * My Plugin Scripts
 * Description: Handles frontend interactivity.
 */

(function ($) {
    'use strict';

    $(document).ready(function () {
        console.log('My Plugin scripts loaded!');

        // Example: Handle a click event on a button
        $('.my-plugin-button').on('click', function () {
            alert('Button clicked! Site name: ' + myPluginData.site_name);

        });
    });

})(jQuery);
