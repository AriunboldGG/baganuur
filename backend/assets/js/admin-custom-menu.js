jQuery(document).ready(function () {
    'use strict';
    /* Required For Leave This Page */
    jQuery('.field-baganuur-ut.field-baganuur-ut-is-mega input').each(
        function () {
            if (jQuery(this).is(':checked')) {
                jQuery(this)
                    .closest('.field-baganuur-ut')
                    .siblings('.field-baganuur-ut.field-baganuur-ut-column')
                    .show();
            } else {
                jQuery(this)
                    .closest('.field-baganuur-ut')
                    .siblings('.field-baganuur-ut.field-baganuur-ut-column')
                    .hide();
            }
        }
    );

    jQuery('.field-baganuur-ut.field-baganuur-ut-is-mega input').live(
        'change',
        function () {
            if (jQuery(this).is(':checked')) {
                jQuery(this)
                    .closest('.field-baganuur-ut')
                    .siblings('.field-baganuur-ut.field-baganuur-ut-column')
                    .show();
            } else {
                jQuery(this)
                    .closest('.field-baganuur-ut')
                    .siblings('.field-baganuur-ut.field-baganuur-ut-column')
                    .hide();
            }
        }
    );
});
