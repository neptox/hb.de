<?php

/* pagination.twig */
class __TwigTemplate_f927e9ebb965697e227fa8ba7991946a80bc34917fe8e437edbc0c4567956326 extends Twig_Template
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
        echo "<div class=\"ai1ec-pagination ai1ec-btn-group\">
\t";
        // line 2
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["links"]) ? $context["links"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 3
            echo "\t\t";
            if (twig_test_iterable((isset($context["link"]) ? $context["link"] : null))) {
                // line 4
                echo "\t\t\t<a class=\"";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["link"]) ? $context["link"] : null), "class"), "html", null, true);
                echo " ai1ec-load-view ai1ec-btn ai1ec-btn-sm
\t\t\t\tai1ec-btn-default ";
                // line 5
                if ((!$this->getAttribute((isset($context["link"]) ? $context["link"] : null), "enabled"))) {
                    echo "ai1ec-disabled";
                }
                echo "\"
\t\t\t\t";
                // line 6
                echo (isset($context["data_type"]) ? $context["data_type"] : null);
                echo "
\t\t\t\thref=\"";
                // line 7
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["link"]) ? $context["link"] : null), "href"), "html_attr");
                echo "\">
\t\t\t\t";
                // line 8
                echo $this->getAttribute((isset($context["link"]) ? $context["link"] : null), "text");
                echo "
\t\t\t</a>
\t\t";
            } else {
                // line 11
                echo "\t\t\t";
                echo (isset($context["link"]) ? $context["link"] : null);
                echo "
\t\t";
            }
            // line 13
            echo "\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 14
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "pagination.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  66 => 14,  40 => 6,  34 => 5,  50 => 11,  28 => 5,  24 => 4,  166 => 73,  161 => 71,  157 => 70,  153 => 68,  151 => 67,  144 => 63,  139 => 61,  135 => 60,  125 => 53,  120 => 51,  116 => 50,  106 => 43,  101 => 41,  97 => 40,  87 => 33,  82 => 31,  78 => 30,  69 => 24,  60 => 13,  54 => 11,  45 => 14,  39 => 7,  37 => 11,  29 => 4,  22 => 2,  96 => 30,  85 => 25,  79 => 22,  75 => 21,  71 => 25,  67 => 19,  63 => 20,  59 => 17,  55 => 16,  48 => 8,  44 => 7,  36 => 9,  30 => 6,  26 => 3,  21 => 2,  19 => 1,);
    }
}
