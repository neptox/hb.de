<?php

class A_Ecommerce_Pages extends Mixin
{
	function initialize()
	{
        add_menu_page(
            __('Ecommerce Options', 'nggallery'),
            __('Ecommerce', 'nggallery'),
            'NextGEN Gallery overview',
            'ngg_ecommerce_options',
            '',
            path_join(NGGALLERY_URLPATH, 'admin/images/nextgen_16_color.png')
        );

        $this->object->add(NGG_PRO_ECOMMERCE_OPTIONS_PAGE, array(
            'adapter' => 'A_Ecommerce_Options_Controller',
            'parent' => 'ngg_ecommerce_options'
        ));

        $this->object->add('ngg_manage_pricelists', array(
			'url'        => '/edit.php?post_type=ngg_pricelist',
			'menu_title' => __('Manage Pricelists', 'nggallery'),
			'permission' => 'NextGEN Change options',
			'parent'     => 'ngg_ecommerce_options'
		));

        $this->object->add('ngg_manage_orders', array(
            'url'           =>  '/edit.php?post_type=ngg_order',
            'menu_title'    =>  __('View Orders', 'nggallery'),
            'permission'    =>  'NextGEN Change options',
            'parent'        =>  'ngg_ecommerce_options'
        ));

        $this->object->add(NGG_PRO_ECOMMERCE_INSTRUCTIONS_PAGE, array(
            'adapter'   =>  'A_Ecommerce_Instructions_Controller',
            'parent'    =>  'ngg_ecommerce_options'
        ));
	}
}