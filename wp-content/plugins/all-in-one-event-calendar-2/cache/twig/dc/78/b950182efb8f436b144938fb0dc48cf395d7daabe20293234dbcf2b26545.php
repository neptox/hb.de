<?php

/* recurrence.twig */
class __TwigTemplate_dc78b950182efb8f436b144938fb0dc48cf395d7daabe20293234dbcf2b26545 extends Twig_Template
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
        if ((!twig_test_empty((isset($context["recurrence"]) ? $context["recurrence"] : null)))) {
            // line 2
            echo "\t<div class=\"ai1ec-recurrence ai1ec-btn-group\">
\t\t<button class=\"ai1ec-btn ai1ec-btn-default ai1ec-btn-xs
\t\t\tai1ec-tooltip-trigger ai1ec-disabled ai1ec-text-muted\"
\t\t\tdata-html=\"true\"
\t\t\ttitle=\"";
            // line 6
            ob_start();
            // line 7
            echo "\t\t\t\t";
            echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, (isset($context["recurrence"]) ? $context["recurrence"] : null)), "html_attr");
            echo "
\t\t\t\t";
            // line 8
            if ((!twig_test_empty((isset($context["exclude"]) ? $context["exclude"] : null)))) {
                // line 9
                echo "\t\t\t\t\t";
                echo twig_escape_filter($this->env, ((("<div class=\"ai1ec-recurrence-exclude\">" . Ai1ec_I18n::__("Excludes: ")) . (isset($context["exclude"]) ? $context["exclude"] : null)) . "</div>"), "html_attr");
                echo "
\t\t\t\t";
            }
            // line 11
            echo "\t\t\t";
            echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
            echo "\">
\t\t\t<i class=\"ai1ec-fa ai1ec-fa-repeat\"></i>
\t\t\t";
            // line 13
            echo twig_escape_filter($this->env, Ai1ec_I18n::__("Repeats"), "html", null, true);
            echo "
\t\t</button>

\t\t";
            // line 16
            if ((!twig_test_empty((isset($context["edit_instance_url"]) ? $context["edit_instance_url"] : null)))) {
                // line 17
                echo "\t\t\t<a class=\"ai1ec-btn ai1ec-btn-default ai1ec-btn-xs ai1ec-tooltip-trigger
\t\t\t\tai1ec-text-muted\"
\t\t\t\ttitle=\"";
                // line 19
                echo twig_escape_filter($this->env, (isset($context["edit_instance_text"]) ? $context["edit_instance_text"] : null), "html_attr");
                echo "\"
\t\t\t\thref=\"";
                // line 20
                echo twig_escape_filter($this->env, (isset($context["edit_instance_url"]) ? $context["edit_instance_url"] : null), "html", null, true);
                echo "\">
\t\t\t\t<i class=\"ai1ec-fa ai1ec-fa-pencil\"></i>
\t\t\t</a>
\t\t";
            }
            // line 24
            echo "\t</div>
";
        }
    }

    public function getTemplateName()
    {
        return "recurrence.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  71 => 24,  64 => 20,  60 => 19,  56 => 17,  54 => 16,  48 => 13,  36 => 9,  21 => 2,  321 => 132,  316 => 129,  313 => 125,  310 => 124,  308 => 123,  305 => 122,  302 => 120,  300 => 119,  297 => 117,  295 => 116,  292 => 115,  285 => 111,  281 => 110,  276 => 108,  271 => 106,  268 => 105,  266 => 104,  263 => 103,  256 => 99,  252 => 98,  247 => 96,  242 => 94,  239 => 93,  237 => 92,  234 => 91,  226 => 88,  220 => 87,  217 => 86,  215 => 85,  212 => 84,  205 => 80,  201 => 79,  195 => 78,  192 => 77,  190 => 76,  187 => 75,  180 => 71,  176 => 70,  170 => 69,  167 => 68,  165 => 67,  159 => 64,  155 => 63,  152 => 62,  150 => 61,  146 => 60,  142 => 59,  136 => 58,  132 => 56,  125 => 52,  121 => 50,  118 => 49,  115 => 48,  111 => 46,  108 => 45,  105 => 44,  103 => 43,  100 => 42,  96 => 40,  90 => 38,  88 => 37,  85 => 36,  82 => 35,  79 => 28,  76 => 27,  69 => 23,  62 => 19,  55 => 16,  53 => 15,  46 => 11,  42 => 11,  30 => 4,  26 => 3,  51 => 20,  47 => 18,  40 => 8,  34 => 8,  32 => 11,  29 => 7,  27 => 6,  24 => 3,  22 => 2,  19 => 1,);
    }
}
