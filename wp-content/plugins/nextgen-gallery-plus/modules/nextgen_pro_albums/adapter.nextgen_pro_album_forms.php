<?php

class A_NextGen_Pro_Album_Forms extends Mixin
{
    function initialize()
    {
        $this->add_form(
            NGG_DISPLAY_SETTINGS_SLUG, NGG_PRO_LIST_ALBUM
        );
        $this->add_form(
            NGG_DISPLAY_SETTINGS_SLUG, NGG_PRO_GRID_ALBUM
        );
    }
}