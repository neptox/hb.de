<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

/*
 * Plugin Name: NextGEN Plus by Photocrati
 * Description: A premium add-on for NextGEN Gallery with beautiful new gallery displays and a fullscreen, responsive Pro Lightbox with social sharing and commenting.
 * Version: 1.0
 * Plugin URI: http://www.nextgen-gallery.com
 * Author: Photocrati Media
 * Author URI: http://www.photocrati.com
 * License: GPLv2
 */

class NextGen_Plus
{
    var $_minimum_ngg_version = '2.0.63';

    // Initialize the plugin
    function __construct()
    {
        define('NGG_PLUS_PLUGIN_BASENAME', plugin_basename(__FILE__));
        define('NGG_PLUS_MODULE_URL', plugins_url(path_join(basename(dirname(__FILE__)), 'modules')));
        define('NGG_PLUS_PLUGIN_VERSION', '1.0');

        if (class_exists('C_Component_Registry') && did_action('load_nextgen_gallery_modules')) {
            $this->load_product(C_Component_Registry::get_instance());
        }
        else {
            add_action('load_nextgen_gallery_modules', array($this, 'load_product'));
        }

        $this->_register_hooks();
    }

    /**
     * Loads the product providing NextGEN Gallery Pro functionality
     * @param C_Component_Registry $registry
     */
    function load_product(C_Component_Registry $registry)
    {
        // Tell the registry where it can find our products/modules
        $dir = dirname(__FILE__);
        $registry->add_module_path($dir, TRUE, TRUE);
        $registry->initialize_all_modules();
        $registry->del_adapter('I_Page_Manager', 'A_NextGen_Pro_Upgrade_Page');
    }

    function _register_hooks()
    {
        add_action('activate_' . NGG_PLUS_PLUGIN_BASENAME, array(get_class(), 'activate'));
        add_action('deactivate_' . NGG_PLUS_PLUGIN_BASENAME, array(get_class(), 'deactivate'));

        // hooks for showing available updates
        add_action('after_plugin_row_' . NGG_PLUS_PLUGIN_BASENAME, array(get_class(), 'after_plugin_row'));
        add_action('admin_notices', array(&$this, 'admin_notices'));
        add_action('admin_init', array(&$this, 'deactivate_pro'));

        add_filter('pre_update_option_pope_module_list', array($this, 'detect_nextgen_reset'), 10, 2);
    }

    /**
     * Filters pre_update_option_pope_module_list to determine if photocrati-nextgen was amongst the
     * pope_module_list and has been removed.
     *
     * @todo This is temporary: it should be removed after NextGEN 2.0.67 or so
     * @param $new_value
     * @param $old_value
     * @return mixed
     */
    function detect_nextgen_reset($new_value, $old_value)
    {
        $old_nextgen_found = false;
        $new_nextgen_found = false;
        foreach ($old_value as $value) {
            if (strpos($value, 'photocrati-nextgen|') === FALSE)
                continue;
            $old_nextgen_found = TRUE;
            break;
        }
        foreach ($new_value as $value) {
            if (strpos($value, 'photocrati-nextgen|') === FALSE)
                continue;
            $new_nextgen_found = TRUE;
            break;
        }

        if ($old_nextgen_found && !$new_nextgen_found)
        {
            C_Photocrati_Installer::uninstall('photocrati-nextgen-plus');
            $new_value = $this->_filter_modules($new_value, P_Photocrati_NextGen_Plus::$modules);
            $search = array_search('photocrati-nextgen-plus|' . NGG_PLUS_PLUGIN_VERSION, $new_value);
            if (FALSE !== $search)
                unset($new_value[$search]);
        }
        return $new_value;
    }

    /**
     * Assistant method to detect_nextgen_reset()
     *
     * @param $pope_modules_list
     * @param $product
     * @return mixed
     */
    function _filter_modules($pope_modules_list, $product)
    {
        foreach ($product as $module_name) {
            $module = C_Component_Registry::get_instance()->get_module($module_name);
            $str = $module->module_id . '|' . $module->module_version;
            $search = array_search($str, $pope_modules_list);
            if (FALSE !== $search)
                unset($pope_modules_list[$search]);
        }
        return $pope_modules_list;
    }

    function deactivate_pro()
    {
        if (get_option('photocrati_plus_recently_activated', FALSE) && defined('NGG_PRO_PLUGIN_BASENAME')) {
            deactivate_plugins(NGG_PRO_PLUGIN_BASENAME);
        }
    }

    static function activate()
    {
        // admin_notices will check for this later
        update_option('photocrati_plus_recently_activated', 'true');
    }

    static function deactivate()
    {
        if (class_exists('C_Photocrati_Installer')) {
            C_Photocrati_Installer::uninstall(NGG_PLUS_PLUGIN_BASENAME);
        }
    }

    static function _get_update_admin()
    {
        if (class_exists('C_Component_Registry') && method_exists('C_Component_Registry', 'get_instance')) {
            $registry = C_Component_Registry::get_instance();
            $update_admin = $registry->get_module('photocrati-auto_update-admin');

            return $update_admin;
        }

        return null;
    }

    static function _get_update_message()
    {
        $update_admin = self::_get_update_admin();

        if ($update_admin != NULL && method_exists($update_admin, 'get_update_page_url')) {
            $url = $update_admin->get_update_page_url();

            return sprintf(__('There are updates available. You can <a href="%s">Update Now</a>.', 'nggallery'), $url);
        }

        return null;
    }

    static function has_updates()
    {
        $update_admin = self::_get_update_admin();

        if ($update_admin != NULL && method_exists($update_admin, '_get_update_list')) {
            $list = $update_admin->_get_update_list();

            if ($list != NULL) {
                $ngg_pro_count = 0;

                foreach ($list as $update) {
                    if (isset($update['info']['product-id']) && $update['info']['product-id'] == 'photocrati-nextgen-plus') {
                        $ngg_pro_count++;
                    }
                }

                if ($ngg_pro_count > 0) {
                    return true;
                }
            }
        }

        return false;
    }

    static function after_plugin_row()
    {
        if (self::has_updates()) {
            $update_message = self::_get_update_message();

            if ($update_message != NULL) {
                echo '<tr style=""><td colspan="5" style="padding: 6px 8px; ">' . $update_message . '</td></tr>';
            }
        }
    }

    function admin_notices()
    {
        // Ensure that NextGEN Gallery is activated
        if (!defined('NGG_PLUGIN_VERSION')) {
            $message = 'Please install &amp; activate <a href="http://wordpress.org/plugins/nextgen-gallery/" target="_blank">NextGEN Gallery</a> to allow NextGEN Plus to work.';
            echo '<div class="updated"><p>' . $message . '</p></div>';
        }

        // Ensure that the minimum version of NextGEN Gallery required has been activated
        else if (version_compare(NGG_PLUGIN_VERSION, $this->_minimum_ngg_version) == -1) {
            $ngg_version 	 = NGG_PLUGIN_VERSION;
            $ngg_pro_version = NGG_PLUS_PLUGIN_VERSION;
            $upgrade_url 	 = admin_url('/plugin-install.php?tab=plugin-information&plugin=nextgen-gallery&section=changelog&TB_iframe=true&width=640&height=250');
            $message = "NextGEN Gallery {$ngg_version} is incompatible with NextGEN Plus {$ngg_pro_version}. Please update <a class='thickbox' href='{$upgrade_url}'>NextGEN Gallery</a> to version {$this->_minimum_ngg_version} or higher. NextGEN Pro has been deactivated.";
            echo '<div class="updated"><p>' . $message . '</p></div>';
            deactivate_plugins(NGG_PLUS_PLUGIN_BASENAME);
        }
        // Display a dismissable message about how to activate the Pro Lightbox
        else if (delete_option('photocrati_plus_recently_activated')) {
                $message = 'To activate the NextGEN Gallery Pro Lightbox please go to Gallery > Other Options > Lightbox Effects.';
                echo '<div class="updated"><p>' . $message . '</p></div>';
        }

        // Display updates
        if (class_exists('C_Page_Manager'))
        {
            $pages = C_Page_Manager::get_instance();

            if (isset($_REQUEST['page']))
            {
                if (in_array($_REQUEST['page'], array_keys($pages->get_all()))
                    ||  preg_match("/^nggallery-/", $_REQUEST['page'])
                    ||  $_REQUEST['page'] == 'nextgen-gallery')
                {
                    if (self::has_updates())
                    {
                        $update_message = self::_get_update_message();
                        echo '<div class="updated"><p>' . $update_message . '</p></div>';
                    }
                }
            }
        }
    }
}

new NextGen_Plus();
