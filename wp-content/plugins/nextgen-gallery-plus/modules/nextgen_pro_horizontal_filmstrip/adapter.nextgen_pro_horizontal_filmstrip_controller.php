<?php

class A_NextGen_Pro_Horizontal_Filmstrip_Controller extends A_Galleria_Controller
{
	function get_custom_css_rules($displayed_gallery)
	{
		// Calculate how far from the bottom the carousel should appear. The
		// extra 2 pixels is for the border-top/border-bottom of the thumbnails.
		// The last 4 pixels is to match what Photocrati Slideshows look like
		$displayed_gallery->display_settings['stage_bottom'] =
				$displayed_gallery->display_settings['thumbnail_height'] +
				$displayed_gallery->display_settings['border_size']+2+4;

		// Return the CSS overrides for this displayed gallery
		return $this->object->render_partial(
			'photocrati-nextgen_pro_horizontal_filmstrip#nextgen_pro_horizontal_filmstrip_css',
			$displayed_gallery->display_settings,
			TRUE
		);
	}
}