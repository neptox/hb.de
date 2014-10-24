(function ($) {
	"use strict";
	jQuery(document).ready(function () {

		jQuery('#gaoo_options_property').focus();

		if (jQuery('#gaoo_options_yoast').is(':checked')) {
			jQuery('.form-table tr:eq(1)').hide();
		} else {
			jQuery('.form-table tr:eq(1)').show();
		}

		jQuery('#gaoo_options_yoast').click(function () {
			if (jQuery(this).is(':checked')) {
				jQuery('.form-table tr:eq(1)').hide();
			} else {
				jQuery('.form-table tr:eq(1)').show();
				jQuery('#gaoo_options_property').focus();
			}
		});

	});
})(jQuery);
