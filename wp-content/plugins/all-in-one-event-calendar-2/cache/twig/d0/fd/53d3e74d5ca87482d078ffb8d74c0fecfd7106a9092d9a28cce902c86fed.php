<?php

/* event-single.twig */
class __TwigTemplate_d0fd53d3e74d5ca87482d078ffb8d74c0fecfd7106a9092d9a28cce902c86fed extends Twig_Template
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
        echo "<div class=\"timely ai1ec-single-event
\tai1ec-event-id-";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "get", array(0 => "post_id"), "method"), "html", null, true);
        echo "
\t";
        // line 3
        if ($this->getAttribute((isset($context["event"]) ? $context["event"] : null), "is_multiday")) {
            echo "ai1ec-multiday";
        }
        // line 4
        echo "\t";
        if ($this->getAttribute((isset($context["event"]) ? $context["event"] : null), "is_allday")) {
            echo "ai1ec-allday";
        }
        echo "\">

<a id=\"ai1ec-event\"></a>

";
        // line 8
        if (((isset($context["show_subscribe_buttons"]) ? $context["show_subscribe_buttons"] : null) || (!twig_test_empty($this->getAttribute((isset($context["event"]) ? $context["event"] : null), "get", array(0 => "ticket_url"), "method"))))) {
            // line 9
            echo "\t<div class=\"ai1ec-actions\">
\t\t<div class=\"ai1ec-btn-group-vertical ai1ec-clearfix\">
\t\t\t";
            // line 11
            echo (isset($context["back_to_calendar"]) ? $context["back_to_calendar"] : null);
            echo "
\t\t</div>

\t\t<div class=\"ai1ec-btn-group-vertical ai1ec-clearfix\">
\t\t\t";
            // line 15
            if ((!twig_test_empty($this->getAttribute((isset($context["event"]) ? $context["event"] : null), "get", array(0 => "ticket_url"), "method")))) {
                // line 16
                echo "\t\t\t\t<a href=\"";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "get", array(0 => "ticket_url"), "method"), "html_attr");
                echo "\" target=\"_blank\"
\t\t\t\t\tclass=\"ai1ec-tickets ai1ec-btn ai1ec-btn-sm ai1ec-btn-primary
\t\t\t\t\t\tai1ec-tooltip-trigger\"
\t\t\t\t\t\ttitle=\"";
                // line 19
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "get_runtime", array(0 => "tickets_url_label"), "method"), "html_attr");
                echo "\"
\t\t\t\t\t\tdata-placement=\"left\">
\t\t\t\t\t<i class=\"ai1ec-fa ai1ec-fa-ticket ai1ec-fa-fw\"></i>
\t\t\t\t\t<span class=\"ai1ec-hidden-xs\">
\t\t\t\t\t\t";
                // line 23
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "get_runtime", array(0 => "tickets_url_label"), "method"), "html", null, true);
                echo "
\t\t\t\t\t</span>
\t\t\t\t</a>
\t\t\t";
            }
            // line 27
            echo "\t\t\t";
            if ((isset($context["show_subscribe_buttons"]) ? $context["show_subscribe_buttons"] : null)) {
                // line 28
                echo "\t\t\t\t";
                $this->env->loadTemplate("subscribe-buttons.twig")->display(array_merge($context, array("button_classes" => "ai1ec-btn-dropdown", "export_url" => (isset($context["subscribe_url"]) ? $context["subscribe_url"] : null), "export_url_no_html" => (isset($context["subscribe_url_no_html"]) ? $context["subscribe_url_no_html"] : null), "subscribe_label" => (isset($context["text_add_calendar"]) ? $context["text_add_calendar"] : null), "text" => (isset($context["subscribe_buttons_text"]) ? $context["subscribe_buttons_text"] : null))));
                // line 35
                echo "\t\t\t";
            }
            // line 36
            echo "\t\t</div>
\t\t\t";
            // line 37
            if ((isset($context["extra_buttons"]) ? $context["extra_buttons"] : null)) {
                // line 38
                echo "\t\t\t\t";
                echo (isset($context["extra_buttons"]) ? $context["extra_buttons"] : null);
                echo "
\t\t\t";
            }
            // line 40
            echo "\t</div>
";
        }
        // line 42
        echo "
";
        // line 43
        if (twig_test_empty((isset($context["map"]) ? $context["map"] : null))) {
            // line 44
            echo "\t";
            $context["col1"] = "ai1ec-col-sm-3";
            // line 45
            echo "\t";
            $context["col2"] = "ai1ec-col-sm-9";
            // line 46
            echo "\t<div class=\"ai1ec-event-details ai1ec-clearfix\">
";
        } else {
            // line 48
            echo "\t";
            $context["col1"] = "ai1ec-col-sm-4 ai1ec-col-md-5";
            // line 49
            echo "\t";
            $context["col2"] = "ai1ec-col-sm-8 ai1ec-col-md-7";
            // line 50
            echo "\t<div class=\"ai1ec-event-details ai1ec-row\">
\t\t<div class=\"ai1ec-map ai1ec-col-sm-5 ai1ec-col-sm-push-7\">
\t\t\t";
            // line 52
            echo (isset($context["map"]) ? $context["map"] : null);
            echo "
\t\t</div>
\t\t<div class=\"ai1ec-col-sm-7 ai1ec-col-sm-pull-5\">
";
        }
        // line 56
        echo "
\t<div class=\"ai1ec-time ai1ec-row\">
\t\t<div class=\"ai1ec-field-label ";
        // line 58
        echo twig_escape_filter($this->env, (isset($context["col1"]) ? $context["col1"] : null), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, (isset($context["text_when"]) ? $context["text_when"] : null), "html", null, true);
        echo "</div>
\t\t<div class=\"ai1ec-field-value ";
        // line 59
        echo twig_escape_filter($this->env, (isset($context["col2"]) ? $context["col2"] : null), "html", null, true);
        echo " dt-duration\">
\t\t\t";
        // line 60
        echo $this->env->getExtension('ai1ec')->timespan((isset($context["event"]) ? $context["event"] : null));
        echo "
\t\t\t";
        // line 61
        $this->env->loadTemplate("recurrence.twig")->display($context);
        // line 62
        echo "\t\t</div>
\t\t<div class=\"ai1ec-hidden dt-start\">";
        // line 63
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "get", array(0 => "start"), "method"), "html", null, true);
        echo "</div>
\t\t<div class=\"ai1ec-hidden dt-end\">";
        // line 64
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "get", array(0 => "end"), "method"), "html", null, true);
        echo "</div>
\t</div>

\t";
        // line 67
        if ((!twig_test_empty((isset($context["location"]) ? $context["location"] : null)))) {
            // line 68
            echo "\t\t<div class=\"ai1ec-location ai1ec-row\">
\t\t\t<div class=\"ai1ec-field-label ";
            // line 69
            echo twig_escape_filter($this->env, (isset($context["col1"]) ? $context["col1"] : null), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, (isset($context["text_where"]) ? $context["text_where"] : null), "html", null, true);
            echo "</div>
\t\t\t<div class=\"ai1ec-field-value ";
            // line 70
            echo twig_escape_filter($this->env, (isset($context["col2"]) ? $context["col2"] : null), "html", null, true);
            echo " p-location\">
\t\t\t\t";
            // line 71
            echo (isset($context["location"]) ? $context["location"] : null);
            echo "
\t\t\t</div>
\t\t</div>
\t";
        }
        // line 75
        echo "
\t";
        // line 76
        if (((!twig_test_empty($this->getAttribute((isset($context["event"]) ? $context["event"] : null), "get", array(0 => "cost"), "method"))) || $this->getAttribute((isset($context["event"]) ? $context["event"] : null), "is_free"))) {
            // line 77
            echo "\t\t<div class=\"ai1ec-cost ai1ec-row\">
\t\t\t<div class=\"ai1ec-field-label ";
            // line 78
            echo twig_escape_filter($this->env, (isset($context["col1"]) ? $context["col1"] : null), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, (isset($context["text_cost"]) ? $context["text_cost"] : null), "html", null, true);
            echo "</div>
\t\t\t<div class=\"ai1ec-field-value ";
            // line 79
            echo twig_escape_filter($this->env, (isset($context["col2"]) ? $context["col2"] : null), "html", null, true);
            echo "\">
\t\t\t\t";
            // line 80
            echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["event"]) ? $context["event"] : null), "is_free")) ? ((isset($context["text_free"]) ? $context["text_free"] : null)) : ($this->getAttribute((isset($context["event"]) ? $context["event"] : null), "get", array(0 => "cost"), "method"))), "html", null, true);
            echo "
\t\t\t</div>
\t\t</div>
\t";
        }
        // line 84
        echo "
\t";
        // line 85
        if ((!twig_test_empty((isset($context["contact"]) ? $context["contact"] : null)))) {
            // line 86
            echo "\t\t<div class=\"ai1ec-contact ai1ec-row\">
\t\t\t<div class=\"ai1ec-field-label ";
            // line 87
            echo twig_escape_filter($this->env, (isset($context["col1"]) ? $context["col1"] : null), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, (isset($context["text_contact"]) ? $context["text_contact"] : null), "html", null, true);
            echo "</div>
\t\t\t<div class=\"ai1ec-field-value ";
            // line 88
            echo twig_escape_filter($this->env, (isset($context["col2"]) ? $context["col2"] : null), "html", null, true);
            echo "\">";
            echo (isset($context["contact"]) ? $context["contact"] : null);
            echo "</div>
\t\t</div>
\t";
        }
        // line 91
        echo "
\t";
        // line 92
        if ((!twig_test_empty((isset($context["categories"]) ? $context["categories"] : null)))) {
            // line 93
            echo "\t\t<div class=\"ai1ec-categories ai1ec-row\">
\t\t\t<div class=\"ai1ec-field-label ";
            // line 94
            echo twig_escape_filter($this->env, (isset($context["col1"]) ? $context["col1"] : null), "html", null, true);
            echo " ai1ec-col-xs-1\">
\t\t\t\t<i class=\"ai1ec-fa ai1ec-fa-folder-open ai1ec-tooltip-trigger\"
\t\t\t\t\ttitle=\"";
            // line 96
            echo twig_escape_filter($this->env, (isset($context["text_categories"]) ? $context["text_categories"] : null), "html_attr");
            echo "\"></i>
\t\t\t</div>
\t\t\t<div class=\"ai1ec-field-value ";
            // line 98
            echo twig_escape_filter($this->env, (isset($context["col2"]) ? $context["col2"] : null), "html", null, true);
            echo " ai1ec-col-xs-10\">
\t\t\t\t";
            // line 99
            echo (isset($context["categories"]) ? $context["categories"] : null);
            echo "
\t\t\t</div>
\t\t</div>
\t";
        }
        // line 103
        echo "
\t";
        // line 104
        if ((!twig_test_empty((isset($context["tags"]) ? $context["tags"] : null)))) {
            // line 105
            echo "\t\t<div class=\"ai1ec-tags ai1ec-row\">
\t\t\t<div class=\"ai1ec-field-label ";
            // line 106
            echo twig_escape_filter($this->env, (isset($context["col1"]) ? $context["col1"] : null), "html", null, true);
            echo " ai1ec-col-xs-1\">
\t\t\t\t<i class=\"ai1ec-fa ai1ec-fa-tags ai1ec-tooltip-trigger\"
\t\t\t\t\ttitle=\"";
            // line 108
            echo twig_escape_filter($this->env, (isset($context["text_tags"]) ? $context["text_tags"] : null), "html_attr");
            echo "\"></i>
\t\t\t</div>
\t\t\t<div class=\"ai1ec-field-value ";
            // line 110
            echo twig_escape_filter($this->env, (isset($context["col2"]) ? $context["col2"] : null), "html", null, true);
            echo " ai1ec-col-xs-10\">
\t\t\t\t";
            // line 111
            echo (isset($context["tags"]) ? $context["tags"] : null);
            echo "
\t\t\t</div>
\t\t</div>
\t";
        }
        // line 115
        echo "
";
        // line 116
        if (twig_test_empty((isset($context["map"]) ? $context["map"] : null))) {
            // line 117
            echo "\t</div>";
        } else {
            // line 119
            echo "\t\t</div>";
            // line 120
            echo "\t</div>";
        }
        // line 122
        echo "
";
        // line 123
        if ((!(isset($context["hide_featured_image"]) ? $context["hide_featured_image"] : null))) {
            // line 124
            echo "\t";
            if (twig_test_empty($this->getAttribute((isset($context["event"]) ? $context["event"] : null), "get_runtime", array(0 => "content_img_url"), "method"))) {
                // line 125
                echo "\t\t";
                echo $this->env->getExtension('ai1ec')->avatar((isset($context["event"]) ? $context["event"] : null), array(0 => "post_thumbnail", 1 => "location_avatar", 2 => "category_avatar"), "timely alignleft", false);
                // line 129
                echo "
\t";
            }
        }
        // line 132
        echo "
</div>
";
    }

    public function getTemplateName()
    {
        return "event-single.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  321 => 132,  316 => 129,  313 => 125,  310 => 124,  308 => 123,  305 => 122,  302 => 120,  300 => 119,  297 => 117,  295 => 116,  292 => 115,  285 => 111,  281 => 110,  276 => 108,  271 => 106,  268 => 105,  266 => 104,  263 => 103,  256 => 99,  252 => 98,  247 => 96,  242 => 94,  239 => 93,  237 => 92,  234 => 91,  226 => 88,  220 => 87,  217 => 86,  215 => 85,  212 => 84,  205 => 80,  201 => 79,  195 => 78,  192 => 77,  190 => 76,  187 => 75,  180 => 71,  176 => 70,  170 => 69,  167 => 68,  165 => 67,  159 => 64,  155 => 63,  152 => 62,  150 => 61,  146 => 60,  142 => 59,  136 => 58,  132 => 56,  125 => 52,  121 => 50,  118 => 49,  115 => 48,  111 => 46,  108 => 45,  105 => 44,  103 => 43,  100 => 42,  96 => 40,  90 => 38,  88 => 37,  85 => 36,  82 => 35,  79 => 28,  76 => 27,  69 => 23,  62 => 19,  55 => 16,  53 => 15,  46 => 11,  42 => 9,  30 => 4,  26 => 3,  51 => 20,  47 => 18,  40 => 8,  34 => 12,  32 => 11,  29 => 10,  27 => 4,  24 => 3,  22 => 2,  19 => 1,);
    }
}
