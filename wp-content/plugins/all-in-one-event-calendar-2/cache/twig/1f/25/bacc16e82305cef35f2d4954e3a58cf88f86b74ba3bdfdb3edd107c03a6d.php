<?php

/* filter-menu.twig */
class __TwigTemplate_1f25bacc16e82305cef35f2d4954e3a58cf88f86b74ba3bdfdb3edd107c03a6d extends Twig_Template
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
        echo "<div class=\"timely ai1ec-calendar-toolbar ai1ec-clearfix\">
\t<ul class=\"ai1ec-nav ai1ec-nav-pills ai1ec-pull-left ai1ec-filters\">
\t\t";
        // line 3
        echo (isset($context["categories"]) ? $context["categories"] : null);
        echo "
\t\t";
        // line 4
        echo (isset($context["tags"]) ? $context["tags"] : null);
        echo "
\t</ul>
  <div class=\"ai1ec-pull-right\">
  \t";
        // line 7
        echo (isset($context["contribution_buttons"]) ? $context["contribution_buttons"] : null);
        echo "
  </div>
</div>";
    }

    public function getTemplateName()
    {
        return "filter-menu.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  33 => 7,  23 => 3,  291 => 108,  287 => 106,  283 => 105,  276 => 104,  269 => 103,  267 => 102,  259 => 100,  254 => 97,  248 => 94,  245 => 93,  242 => 92,  236 => 89,  233 => 88,  231 => 87,  227 => 85,  224 => 84,  221 => 83,  219 => 82,  216 => 81,  210 => 78,  207 => 77,  204 => 76,  202 => 75,  199 => 74,  197 => 69,  189 => 65,  184 => 63,  180 => 62,  176 => 60,  174 => 59,  170 => 57,  164 => 55,  162 => 54,  149 => 50,  145 => 49,  140 => 47,  137 => 46,  134 => 41,  132 => 40,  128 => 38,  122 => 35,  117 => 34,  114 => 33,  112 => 32,  107 => 29,  99 => 26,  95 => 25,  91 => 24,  83 => 22,  74 => 19,  62 => 15,  58 => 14,  25 => 4,  35 => 6,  31 => 6,  27 => 4,  66 => 16,  40 => 10,  34 => 7,  50 => 12,  28 => 5,  24 => 4,  166 => 73,  161 => 71,  157 => 52,  153 => 51,  151 => 67,  144 => 63,  139 => 61,  135 => 60,  125 => 53,  120 => 51,  116 => 50,  106 => 43,  101 => 27,  97 => 40,  87 => 23,  82 => 31,  78 => 30,  69 => 24,  60 => 13,  54 => 11,  45 => 11,  39 => 7,  37 => 11,  29 => 5,  22 => 2,  96 => 30,  85 => 25,  79 => 21,  75 => 21,  71 => 25,  67 => 19,  63 => 20,  59 => 17,  55 => 13,  48 => 8,  44 => 7,  36 => 9,  30 => 6,  26 => 3,  21 => 2,  19 => 1,);
    }
}
