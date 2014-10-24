<?php

/* navigation.twig */
class __TwigTemplate_08e44d5fc50332367b2d7e81902230ac0e7ea950ee003ec7a490752fc6534c00 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"ai1ec-clearfix\">
\t";
        // line 2
        echo (isset($context["views_dropdown"]) ? $context["views_dropdown"] : null);
        echo "
\t<div class=\"ai1ec-title-buttons ai1ec-btn-toolbar\">
\t\t";
        // line 4
        echo (isset($context["before_pagination"]) ? $context["before_pagination"] : null);
        echo "
\t\t";
        // line 5
        echo (isset($context["pagination_links"]) ? $context["pagination_links"] : null);
        echo "
\t\t";
        // line 6
        echo (isset($context["after_pagination"]) ? $context["after_pagination"] : null);
        echo "
\t</div>
</div>
";
    }

    public function getTemplateName()
    {
        return "navigation.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  35 => 6,  31 => 5,  27 => 4,  66 => 14,  40 => 6,  34 => 5,  50 => 11,  28 => 5,  24 => 4,  166 => 73,  161 => 71,  157 => 70,  153 => 68,  151 => 67,  144 => 63,  139 => 61,  135 => 60,  125 => 53,  120 => 51,  116 => 50,  106 => 43,  101 => 41,  97 => 40,  87 => 33,  82 => 31,  78 => 30,  69 => 24,  60 => 13,  54 => 11,  45 => 14,  39 => 7,  37 => 11,  29 => 4,  22 => 2,  96 => 30,  85 => 25,  79 => 22,  75 => 21,  71 => 25,  67 => 19,  63 => 20,  59 => 17,  55 => 16,  48 => 8,  44 => 7,  36 => 9,  30 => 6,  26 => 3,  21 => 2,  19 => 1,);
    }
}
