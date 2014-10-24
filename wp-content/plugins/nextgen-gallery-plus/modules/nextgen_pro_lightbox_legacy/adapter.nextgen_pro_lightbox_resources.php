<?php

class A_Nextgen_Pro_Lightbox_Resources extends Mixin
{
    protected $run_once = FALSE;

    function initialize()
    {
        $settings	= C_NextGen_Settings::get_instance();
        if ($settings->thumbEffect == NGG_PRO_LIGHTBOX) {
            $this->object->add_post_hook(
                'enqueue_lightbox_resources',
                get_class(),
                get_class(),
                'enqueue_pro_lightbox_resources'
            );
        }
    }

    function enqueue_pro_lightbox_resources($displayed_gallery=FALSE)
    {
        $settings	= C_NextGen_Settings::get_instance();
        if ($settings->thumbEffect == NGG_PRO_LIGHTBOX) {
            $router = C_Router::get_instance();

            if ($displayed_gallery)
            {
                $this->object->_add_script_data(
                    'ngg_common',
                    'galleries.gallery_' . $displayed_gallery->id() . '.wordpress_page_root',
                    get_permalink(),
                    FALSE
                );
            }

            wp_enqueue_script('underscore');
            wp_enqueue_script('backbone');
            wp_enqueue_script(
                'velocity',
                $router->get_static_url('photocrati-nextgen_pro_lightbox_legacy#jquery.velocity.min.js')
            );

            if (!wp_style_is('fontawesome', 'registered'))
                $this->object->get_registry()
                    ->get_utility('I_Display_Type_Controller')
                    ->enqueue_displayed_gallery_trigger_buttons_resources();
            wp_enqueue_style('fontawesome');

            if (!$this->run_once)
            {
                // retrieve the lightbox so we can examine its settings
                $mapper = $this->object->get_registry()->get_utility('I_Lightbox_Library_Mapper');
                $library = $mapper->find_by_name(NGG_PRO_LIGHTBOX, TRUE);

                wp_localize_script(
                    'photocrati-nextgen_pro_lightbox-0',
                    'nplModalSettings',
                    array(
                        'is_front_page' => is_front_page() ? 1 : 0,
                        'enable_routing' => $library->display_settings['enable_routing'],
                        'router_slug' => $library->display_settings['router_slug'],
                        'gallery_url' => $router->get_url('/nextgen-pro-lightbox-gallery/{gallery_id}/'),
                        'icon_color' => $library->display_settings['icon_color'],
                        'background_color' => $library->display_settings['background_color']
                    )
                );
            }

            $this->run_once = TRUE;
        }
    }
}
