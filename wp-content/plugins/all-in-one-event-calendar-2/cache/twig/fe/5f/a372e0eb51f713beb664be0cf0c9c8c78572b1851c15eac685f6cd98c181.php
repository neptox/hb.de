<?php

/* calendar.twig */
class __TwigTemplate_fe5fa372e0eb51f713beb664be0cf0c9c8c78572b1851c15eac685f6cd98c181 extends Twig_Template
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
        // line 2
        echo "<!-- START All-in-One Event Calendar Plugin - Version ";
        echo (isset($context["version"]) ? $context["version"] : null);
        echo " -->
<div id=\"ai1ec-container\" class=\"ai1ec-main-container\">
\t<!-- AI1EC_PAGE_CONTENT_PLACEHOLDER -->
\t<div id=\"ai1ec-calendar\" class=\"timely ai1ec-calendar\">
\t\t";
        // line 6
        echo $this->getAttribute((isset($context["filter_menu"]) ? $context["filter_menu"] : null), "get_content", array(), "method");
        echo "
\t\t<div id=\"ai1ec-calendar-view-container\" class=\"ai1ec-calendar-view-container\">
\t\t\t<div id=\"ai1ec-calendar-view-loading\" class=\"ai1ec-loading ai1ec-calendar-view-loading\"></div>
\t\t\t<div id=\"ai1ec-calendar-view\" class=\"ai1ec-calendar-view\">
\t\t\t\t";
        // line 10
        echo (isset($context["view"]) ? $context["view"] : null);
        echo "
\t\t\t</div>
\t\t</div>

\t\t<div class=\"ai1ec-pull-right\">";
        // line 14
        echo (isset($context["subscribe_buttons"]) ? $context["subscribe_buttons"] : null);
        echo "</div>
\t</div><!-- /.timely -->
</div>
<!-- END All-in-One Event Calendar Plugin -->
";
    }

    public function getTemplateName()
    {
        return "calendar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  41 => 14,  33 => 7,  23 => 3,  291 => 108,  287 => 106,  283 => 105,  276 => 104,  269 => 103,  267 => 102,  259 => 100,  254 => 97,  248 => 94,  245 => 93,  242 => 92,  236 => 89,  233 => 88,  231 => 87,  227 => 85,  224 => 84,  221 => 83,  219 => 82,  216 => 81,  210 => 78,  207 => 77,  204 => 76,  202 => 75,  199 => 74,  197 => 69,  189 => 65,  184 => 63,  180 => 62,  176 => 60,  174 => 59,  170 => 57,  164 => 55,  162 => 54,  149 => 50,  145 => 49,  140 => 47,  137 => 46,  134 => 41,  132 => 40,  128 => 38,  122 => 35,  117 => 34,  114 => 33,  112 => 32,  107 => 29,  99 => 26,  95 => 25,  91 => 24,  83 => 22,  74 => 19,  62 => 15,  58 => 14,  25 => 4,  35 => 6,  31 => 6,  27 => 6,  66 => 16,  40 => 10,  34 => 10,  50 => 12,  28 => 5,  24 => 4,  166 => 73,  161 => 71,  157 => 52,  153 => 51,  151 => 67,  144 => 63,  139 => 61,  135 => 60,  125 => 53,  120 => 51,  116 => 50,  106 => 43,  101 => 27,  97 => 40,  87 => 23,  82 => 31,  78 => 30,  69 => 24,  60 => 13,  54 => 11,  45 => 11,  39 => 7,  37 => 11,  29 => 5,  22 => 2,  96 => 30,  85 => 25,  79 => 21,  75 => 21,  71 => 25,  67 => 19,  63 => 20,  59 => 17,  55 => 13,  48 => 8,  44 => 7,  36 => 9,  30 => 6,  26 => 3,  21 => 2,  19 => 2,);
    }
}
