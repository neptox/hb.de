<?php

class C_NextGen_Pro_Horizontal_Filmstrip_Installer extends C_Gallery_Display_Installer
{
	function install()
	{
		$this->install_display_type(
			NGG_PRO_HORIZONTAL_FILMSTRIP, array(
				'title'						=>	__('NextGEN Pro Horizontal Filmstrip', 'nggallery'),
				'entity_types'				=>	array('image'),
				'default_source'			=>	'galleries',
				'preview_image_relpath'		=>	'photocrati-nextgen_pro_horizontal_filmstrip#preview.jpg',
				'view_order' => NGG_DISPLAY_PRIORITY_BASE + (NGG_DISPLAY_PRIORITY_STEP * 10) + 20
			)
		);
	}

	function uninstall($hard)
	{
		if ($hard) {
			$mapper = C_Display_Type_Mapper::get_instance();
			if (($entity = $mapper->find_by_name(NGG_PRO_HORIZONTAL_FILMSTRIP))) {
				$mapper->destroy($entity);
			}
		}
	}
}
