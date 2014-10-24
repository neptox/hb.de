<?php

class A_NextGen_Pro_Film_Forms extends Mixin
{
    function initialize()
    {
        $this->add_form(
            NGG_DISPLAY_SETTINGS_SLUG, NGG_PRO_FILM
        );
    }
}