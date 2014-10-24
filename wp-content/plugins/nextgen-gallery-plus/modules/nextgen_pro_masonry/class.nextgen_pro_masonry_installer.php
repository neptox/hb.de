<?php

class C_NextGen_Pro_Masonry_Installer extends C_Gallery_Display_Installer
{
    function install($reset=FALSE)
    {
        $this->install_display_type(
            NGG_PRO_MASONRY, array(
                'title'                 => __('NextGEN Pro Masonry', 'nggallery'),
                'entity_types'          => array('image'),
                'preview_image_relpath' => 'photocrati-nextgen_pro_masonry#preview.jpg',
                'default_source'        => 'galleries',
                'view_order'            => NGG_DISPLAY_PRIORITY_BASE + (NGG_DISPLAY_PRIORITY_STEP * 10) + 50
            )
        );
    }

	function uninstall($hard=FALSE)
	{
		if ($hard) {
			$mapper = C_Display_Type_Mapper::get_instance();
			if (($entity = $mapper->find_by_name(NGG_PRO_MASONRY))) {
				$mapper->destroy($entity);
			}
		}
	}
}
