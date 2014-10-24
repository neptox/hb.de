<?php

/* subscribe-buttons.twig */
class __TwigTemplate_2715acf678c380d630c83d3a7e40c2555c0b4cb21a16d95a1cc06a601f043e45 extends Twig_Template
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
        echo "<div class=\"ai1ec-subscribe-container ai1ec-btn-group ai1ec-pull-left
\t\tai1ec-tooltip-trigger\" data-placement=\"left\" title=\"";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["text"]) ? $context["text"] : null), "tooltip"), "html", null, true);
        echo "\">
\t<button
\t\ttype=\"button\"
\t\tclass=\"ai1ec-btn ai1ec-btn-default ai1ec-btn-sm ai1ec-dropdown-toggle
\t\t\tai1ec-subscribe ";
        // line 6
        echo twig_escape_filter($this->env, (isset($context["button_classes"]) ? $context["button_classes"] : null), "html", null, true);
        echo "\"
\t\t\tdata-toggle=\"ai1ec-dropdown\">
\t\t<i class=\"ai1ec-fa ai1ec-icon-rss ai1ec-fa-lg ai1ec-fa-fw\"></i>
\t\t<span class=\"ai1ec-hidden-xs\">
\t\t\t<span class=\"ai1ec-hidden-xs\">
\t\t\t";
        // line 11
        if ((!twig_test_empty((isset($context["subscribe_label"]) ? $context["subscribe_label"] : null)))) {
            // line 12
            echo "\t\t\t\t";
            echo twig_escape_filter($this->env, (isset($context["subscribe_label"]) ? $context["subscribe_label"] : null), "html", null, true);
            echo "
\t\t\t";
        } else {
            // line 14
            echo "\t\t\t\t";
            if ((isset($context["is_filtered"]) ? $context["is_filtered"] : null)) {
                // line 15
                echo "\t\t\t\t\t";
                echo twig_escape_filter($this->env, (isset($context["text_filtered"]) ? $context["text_filtered"] : null), "html", null, true);
                echo "
\t\t\t\t";
            } else {
                // line 17
                echo "\t\t\t\t\t";
                echo twig_escape_filter($this->env, (isset($context["text_subscribe"]) ? $context["text_subscribe"] : null), "html", null, true);
                echo "
\t\t\t\t";
            }
            // line 19
            echo "\t\t\t";
        }
        // line 20
        echo "\t\t\t</span>
\t\t\t<span class=\"ai1ec-caret\"></span>
\t\t</span>
\t</button>
\t";
        // line 24
        $context["url"] = (strtr((isset($context["export_url"]) ? $context["export_url"] : null), array("webcal://" => "http://")) . (isset($context["url_args"]) ? $context["url_args"] : null));
        // line 25
        echo "\t<ul class=\"ai1ec-dropdown-menu ai1ec-pull-right\" role=\"menu\">
\t\t<li>
\t\t\t<a class=\"ai1ec-tooltip-trigger ai1ec-tooltip-auto\"
\t\t\t   target=\"_blank\"
\t\t\t   data-placement=\"left\"
\t\t\t   href=\"";
        // line 30
        echo twig_escape_filter($this->env, (isset($context["url"]) ? $context["url"] : null), "html_attr");
        echo "\"
\t\t\t   title=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["text"]) ? $context["text"] : null), "title"), "timely"), "html", null, true);
        echo "\" >
\t\t\t\t<i class=\"ai1ec-fa ai1ec-fa-lg ai1ec-fa-fw ai1ec-icon-timely\"></i>
\t\t\t\t";
        // line 33
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["text"]) ? $context["text"] : null), "label"), "timely"), "html", null, true);
        echo "
\t\t\t</a>
\t\t</li>
\t\t<li>
\t\t\t<a class=\"ai1ec-tooltip-trigger ai1ec-tooltip-auto\"
\t\t\t   target=\"_blank\"
\t\t\t   data-placement=\"left\"
\t\t\t   href=\"http://www.google.com/calendar/render?cid=";
        // line 40
        echo twig_escape_filter($this->env, twig_urlencode_filter((isset($context["url"]) ? $context["url"] : null)), "html_attr");
        echo "\"
\t\t\t   title=\"";
        // line 41
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["text"]) ? $context["text"] : null), "title"), "google"), "html", null, true);
        echo "\" >
\t\t\t\t<i class=\"ai1ec-fa ai1ec-icon-google ai1ec-fa-lg ai1ec-fa-fw\"></i>
\t\t\t\t";
        // line 43
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["text"]) ? $context["text"] : null), "label"), "google"), "html", null, true);
        echo "
\t\t\t</a>
\t\t</li>
\t\t<li>
\t\t\t<a class=\"ai1ec-tooltip-trigger ai1ec-tooltip-auto\"
\t\t\t   target=\"_blank\"
\t\t\t   data-placement=\"left\"
\t\t\t   href=\"";
        // line 50
        echo twig_escape_filter($this->env, ((isset($context["export_url_no_html"]) ? $context["export_url_no_html"] : null) . (isset($context["url_args"]) ? $context["url_args"] : null)), "html_attr");
        echo "\"
\t\t\t   title=\"";
        // line 51
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["text"]) ? $context["text"] : null), "title"), "outlook"), "html", null, true);
        echo "\" >
\t\t\t\t<i class=\"ai1ec-fa ai1ec-icon-windows ai1ec-fa-lg ai1ec-fa-fw\"></i>
\t\t\t\t";
        // line 53
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["text"]) ? $context["text"] : null), "label"), "outlook"), "html", null, true);
        echo "
\t\t\t</a>
\t\t</li>
\t\t<li>
\t\t\t<a class=\"ai1ec-tooltip-trigger ai1ec-tooltip-auto\"
\t\t\t   target=\"_blank\"
\t\t\t   data-placement=\"left\"
\t\t\t   href=\"";
        // line 60
        echo twig_escape_filter($this->env, ((isset($context["export_url_no_html"]) ? $context["export_url_no_html"] : null) . (isset($context["url_args"]) ? $context["url_args"] : null)), "html_attr");
        echo "\"
\t\t\t   title=\"";
        // line 61
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["text"]) ? $context["text"] : null), "title"), "apple"), "html", null, true);
        echo "\" >
\t\t\t\t<i class=\"ai1ec-fa ai1ec-icon-apple ai1ec-fa-lg ai1ec-fa-fw\"></i>
\t\t\t\t";
        // line 63
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["text"]) ? $context["text"] : null), "label"), "apple"), "html", null, true);
        echo "
\t\t\t</a>
\t\t</li>
\t\t<li>
\t\t\t";
        // line 67
        $context["export_url_no_html_http"] = strtr((isset($context["export_url_no_html"]) ? $context["export_url_no_html"] : null), array("webcal://" => "http://"));
        // line 68
        echo "\t\t\t<a class=\"ai1ec-tooltip-trigger ai1ec-tooltip-auto\"
\t\t\t   data-placement=\"left\"
\t\t\t   href=\"";
        // line 70
        echo twig_escape_filter($this->env, ((isset($context["export_url_no_html_http"]) ? $context["export_url_no_html_http"] : null) . (isset($context["url_args"]) ? $context["url_args"] : null)), "html_attr");
        echo "\"
\t\t\t   title=\"";
        // line 71
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["text"]) ? $context["text"] : null), "title"), "plaintext"), "html", null, true);
        echo "\" >
\t\t\t\t<i class=\"ai1ec-fa ai1ec-icon-calendar ai1ec-fa-fw\"></i>
\t\t\t\t";
        // line 73
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["text"]) ? $context["text"] : null), "label"), "plaintext"), "html", null, true);
        echo "
\t\t\t</a>
\t\t</li>
\t</ul>
</div>
";
    }

    public function getTemplateName()
    {
        return "subscribe-buttons.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  166 => 73,  161 => 71,  157 => 70,  153 => 68,  151 => 67,  144 => 63,  139 => 61,  135 => 60,  125 => 53,  120 => 51,  116 => 50,  106 => 43,  101 => 41,  97 => 40,  87 => 33,  82 => 31,  78 => 30,  69 => 24,  60 => 19,  54 => 17,  45 => 14,  39 => 12,  37 => 11,  29 => 6,  22 => 2,  96 => 30,  85 => 25,  79 => 22,  75 => 21,  71 => 25,  67 => 19,  63 => 20,  59 => 17,  55 => 16,  48 => 15,  44 => 14,  36 => 9,  30 => 6,  26 => 5,  21 => 2,  19 => 1,);
    }
}
