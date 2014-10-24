<?php

interface I_Image_Protection_Manager
{
	function is_gallery_protected($gallery, $skip_cache = false);
	
	function protect_gallery($gallery, $force = false);
	
	function is_image_protected($image, $skip_cache = false);
	
	function protect_image($image, $force = false);
}
