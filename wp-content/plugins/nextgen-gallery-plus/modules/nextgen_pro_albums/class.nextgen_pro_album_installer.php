<?php

class C_NextGen_Pro_Album_Installer extends C_Gallery_Display_Installer
{
	function install()
	{
		$this->install_display_type(
			NGG_PRO_LIST_ALBUM, array(
				'title'					=>	__('NextGEN Pro List Album', 'nggallery'),
				'entity_types'			=>	array('gallery', 'album'),
				'default_source'		=>	'albums',
				'preview_image_relpath'	=>	'photocrati-nextgen_pro_albums#list_preview.jpg',
				'view_order' => NGG_DISPLAY_PRIORITY_BASE + (NGG_DISPLAY_PRIORITY_STEP * 10) + 200
			)
		);

		$this->install_display_type(
			NGG_PRO_GRID_ALBUM, array(
				'title'					=>	__('NextGEN Pro Grid Album', 'nggallery'),
				'entity_types'			=>	array('gallery', 'album'),
				'default_source'		=>	'albums',
				'preview_image_relpath'	=>	'photocrati-nextgen_pro_albums#grid_preview.jpg',
				'view_order' => NGG_DISPLAY_PRIORITY_BASE + (NGG_DISPLAY_PRIORITY_STEP * 10) + 210
			)
		);
	}

	function uninstall($hard=TRUE)
	{
		if ($hard) {
			$mapper = C_Display_Type_Mapper::get_instance();
			foreach (array(NGG_PRO_GRID_ALBUM, NGG_PRO_LIST_ALBUM) as $display_type_name) {
				if (($display_type = $mapper->find_by_name($display_type_name))) {
					$mapper->destroy($display_type);
				}
			}
		}
	}
}
