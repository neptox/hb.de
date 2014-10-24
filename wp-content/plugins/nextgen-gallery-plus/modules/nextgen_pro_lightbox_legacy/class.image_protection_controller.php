<?php

class C_Image_Protection_Controller extends C_MVC_Controller
{
	static $_instances = array();

	function define($context=FALSE)
	{
		parent::define($context);
		$this->implement('I_Image_Protection_Controller');
	}

	/**
	 * Returns an instance of this class
	 *
	 * @param string $context
	 * @return C_Image_Protection_Controller
	 */
	static function get_instance($context=FALSE)
	{
		if (!isset(self::$_instances[$context])) {
			$klass = get_class();
			self::$_instances[$context] = new $klass($context);
		}
		return self::$_instances[$context];
	}

	function index_action()
	{
		$imgprot = $this->get_registry()->get_utility('I_Image_Protection_Manager');
		$image_id = $this->param('nggid');

		if ($image_id != null)
		{
			$storage = $this->get_registry()->get_utility('I_Gallery_Storage');
			$size = 'ecommerce';
			$abspath = $storage->get_image_abspath($image_id, $size, true);
			$valid = false;
			
			if ($valid) {
				$storage->render_image($image_id, $size);
			}
		}
	}
}
