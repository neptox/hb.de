<?php

class A_Image_Protection_Storage_Driver extends Mixin
{
	/**
	 * Returns the named sizes available for images
	 * @return array
	 */
	function get_image_sizes()
	{
		$ret = $this->call_parent('get_image_sizes');
		
		$ret[] = 'ecommerce';
		
		return $ret;
	}
	
	function get_image_abspath($image, $size=FALSE, $check_existance=FALSE)
	{
		$retval = NULL;
		
		if ($size == 'ecommerce') {
			$imgprot = $this->object->get_registry()->get_utility('I_Image_Protection_Manager');
			$imgprot->protect_gallery($image->galleryid);
			
			$retval = $this->get_backup_abspath($image);
		}
		else {
			$retval = $this->call_parent('get_image_abspath', $image, $size, $check_existance);
		}

		return $retval;
	}

	function get_image_url($image, $size='full', $check_existance=FALSE)
	{
		$retval = NULL;
		$imgprot = $this->object->get_registry()->get_utility('I_Image_Protection_Manager');

		if ($size == 'ecommerce') {
			$retval = NULL;
		}
		else {
			$retval = $this->call_parent('get_image_url', $image, $size, $check_existance);
		}

		return $retval;
	}
}
