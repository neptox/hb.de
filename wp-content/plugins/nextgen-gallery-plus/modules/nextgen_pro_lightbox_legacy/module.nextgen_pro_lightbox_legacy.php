<?php
/*
{
    Module: photocrati-nextgen_pro_lightbox_legacy,
    Depends: { photocrati-lightbox }
}
 */

define('NGG_PRO_LIGHTBOX', 'photocrati-nextgen_pro_lightbox');
define('NGG_PRO_LIGHTBOX_TRIGGER', NGG_PRO_LIGHTBOX);
define('NGG_PRO_LIGHTBOX_COMMENT_TRIGGER', 'photocrati-nextgen_pro_lightbox_comments');

class M_NextGen_Pro_Lightbox_Legacy extends C_Base_Module
{
    function define($context=FALSE)
    {
        parent::define(
            'photocrati-nextgen_pro_lightbox_legacy',
            'NextGEN Pro Lightbox',
            'Provides a lightbox with integrated commenting, social sharing, and e-commerce functionality',
            '0.21',
            'http://www.nextgen-gallery.com',
            'Photocrati Media',
            'http://www.photocrati.com',
            $context
        );

        $this->add_mixin('A_NextGen_Pro_Lightbox_Resources');

        include_once('class.nextgen_pro_lightbox_installer.php');
        C_Photocrati_Installer::add_handler($this->module_id, 'C_NextGen_Pro_Lightbox_Installer');
    }

    function initialize()
    {
        parent::initialize();

        // Add triggers
        $triggers = C_Displayed_Gallery_Trigger_Manager::get_instance();
        $triggers->add(NGG_PRO_LIGHTBOX_TRIGGER,           'C_NextGen_Pro_Lightbox_Trigger');
        $triggers->add(NGG_PRO_LIGHTBOX_COMMENT_TRIGGER,   'C_NextGen_Pro_Lightbox_Trigger');
    }

    function _register_adapters()
    {
        // controllers & their helpers
        $this->get_registry()->add_adapter('I_Display_Type_Controller', 'A_Nextgen_Pro_Lightbox_Resources');
        $this->get_registry()->add_adapter('I_Display_Type_Controller', 'A_NextGen_Pro_Lightbox_Effect_Code');
        $this->get_registry()->add_adapter('I_Lightbox_Library_Mapper', 'A_Pro_Lightbox_Mapper');

        // routes & rewrites
        $this->get_registry()->add_adapter('I_Router', 'A_NextGen_Pro_Lightbox_Routes');

        if (is_admin()) {
            $this->get_registry()->add_adapter('I_Display_Type_Form', 'A_NextGen_Pro_Lightbox_Triggers_Form');
            $this->get_registry()->add_adapter('I_Form', 'A_NextGen_Pro_Lightbox_Form', NGG_PRO_LIGHTBOX.'_basic');
        }

        // e-commerce stuff
        $this->get_registry()->add_adapter('I_Router', 'A_Image_Protection_Routes');
    }

    function _register_utilities()
    {
        // The second controller is for handling lightbox display
        $this->get_registry()->add_utility('I_NextGen_Pro_Lightbox_Controller', 'C_NextGen_Pro_Lightbox_Controller');
        $this->get_registry()->add_utility('I_OpenGraph_Controller', 'C_OpenGraph_Controller');

        $this->get_registry()->add_utility('I_Image_Protection_Manager', 'C_Image_Protection_Manager');
        $this->get_registry()->add_utility('I_Image_Protection_Controller', 'C_Image_Protection_Controller');
    }

    function _register_hooks()
    {
        add_action('admin_init', array(&$this, 'register_forms'));
        add_action('wp_enqueue_scripts', array(&$this, 'enqueue_pro_lightbox_resources'));
        add_action('wp_enqueue_scripts', array(&$this, 'use_legacy_resources'), PHP_INT_MAX-5);
    }

    /**
     * In 1.0.17, there was no legacy module. Therefore, all scripts are registered from the
     * nextgen_pro_lightbox module directory. We apply a hotfix for any registered libraries to point
     * to the correct path
     */
    function use_legacy_resources()
    {
        if (isset(M_Lightbox::$_registered_lightboxes)) {
            global $wp_scripts;
            foreach (M_Lightbox::$_registered_lightboxes as $handle) {
                $script = $wp_scripts->registered[$handle];
                $script->src = str_replace('/nextgen_pro_lightbox/', '/nextgen_pro_lightbox_legacy/', $script->src);
            }
        }
    }

    function register_forms()
    {
        // Add forms
        $forms = C_Form_Manager::get_instance();
        $forms->add_form(NGG_LIGHTBOX_OPTIONS_SLUG, NGG_PRO_LIGHTBOX.'_basic');
    }

    function get_type_list()
    {
        return array(
            'A_Pro_Lightbox_Mapper'                 => 'adapter.pro_lightbox_mapper.php',
            'A_Nextgen_Pro_Lightbox_Resources'      =>  'adapter.nextgen_pro_lightbox_resources.php',
            'A_NextGen_Pro_Lightbox_Pages'          =>  'adapter.nextgen_pro_lightbox_pages.php',
            'A_Nextgen_Pro_Lightbox_Effect_Code'    => 'adapter.nextgen_pro_lightbox_effect_code.php',
            'A_Nextgen_Pro_Lightbox_Form'           => 'adapter.nextgen_pro_lightbox_form.php',
            'C_NextGen_Pro_Lightbox_Installer'      => 'class.nextgen_pro_lightbox_installer.php',
            'A_Nextgen_Pro_Lightbox_Triggers_Form'  => 'adapter.nextgen_pro_lightbox_triggers_form.php',
            'C_NextGen_Pro_Lightbox_Trigger'        =>  'class.nextgen_pro_lightbox_trigger.php',
            'A_Nextgen_Pro_Lightbox_Routes'         => 'adapter.nextgen_pro_lightbox_routes.php',
            'C_Nextgen_Pro_Lightbox_Controller'     => 'class.nextgen_pro_lightbox_controller.php',
            'C_Opengraph_Controller'                => 'class.opengraph_controller.php',
            'I_Nextgen_Pro_Lightbox_Controller'     => 'interface.nextgen_pro_lightbox_controller.php',
            'I_Opengraph_Controller'                => 'interface.opengraph_controller.php',
            'A_Image_Protection_Storage_Driver'     => 'adapter.image_protection_storage_driver.php',
            'A_Image_Protection_Routes'             => 'adapter.image_protection_routes.php',
            'C_Image_Protection_Controller'         => 'class.image_protection_controller.php',
            'C_Image_Protection_Manager'            => 'class.image_protection_manager.php',
            'I_Image_Protection_Controller'         => 'interface.image_protection_controller.php',
            'I_Image_Protection_Manager'            => 'interface.image_protection_manager.php',
            'M_NextGen_Pro_Lightbox_Legacy'         => 'module.nextgen_pro_lightbox.php',
        );
    }
}

new M_NextGen_Pro_Lightbox_Legacy;
