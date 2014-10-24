<?php

class A_Image_Protection_Routes extends Mixin
{
	function initialize()
	{
		$this->object->add_pre_hook(
			'serve_request',
			'Adds Image Protection routes',
			get_class(),
			'add_image_protection_routes'
		);
	}

	function add_image_protection_routes()
	{
  	$app = $this->create_app('/ngg-priv-image');

		$app->route('/', 'I_Image_Protection_Controller#index');
	}
}
