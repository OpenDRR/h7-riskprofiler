<?php

namespace WPML\Core;

use \WPML\Core\Twig\Environment;
use \WPML\Core\Twig\Error\LoaderError;
use \WPML\Core\Twig\Error\RuntimeError;
use \WPML\Core\Twig\Markup;
use \WPML\Core\Twig\Sandbox\SecurityError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedTagError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedFilterError;
use \WPML\Core\Twig\Sandbox\SecurityNotAllowedFunctionError;
use \WPML\Core\Twig\Source;
use \WPML\Core\Twig\Template;

/* template.twig */
class __TwigTemplate_3f1b38868ebad10c99f29a0ba25c0aaf9d4ffbdbfbd51024ab8cd00ebb2036cc extends \WPML\Core\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        $context["css_classes_flag"] = \WPML\Core\twig_trim_filter(("wpml-ls-flag " . $this->getAttribute(($context["backward_compatibility"] ?? null), "css_classes_flag", [])));
        // line 2
        $context["css_classes_native"] = \WPML\Core\twig_trim_filter(("wpml-ls-native " . $this->getAttribute(($context["backward_compatibility"] ?? null), "css_classes_native", [])));
        // line 3
        $context["css_classes_display"] = \WPML\Core\twig_trim_filter(("wpml-ls-display " . $this->getAttribute(($context["backward_compatibility"] ?? null), "css_classes_display", [])));
        // line 4
        $context["css_classes_bracket"] = \WPML\Core\twig_trim_filter(("wpml-ls-bracket " . $this->getAttribute(($context["backward_compatibility"] ?? null), "css_classes_bracket", [])));
        // line 5
        echo "
";
        // line 6
        $this->loadTemplate("flag.twig", "template.twig", 6)->display(twig_array_merge($context, ["language" => ["flag_url" => ($context["flag_url"] ?? null), "flag_alt" => ($context["flag_alt"] ?? null), "flag_width" => ($context["flag_width"] ?? null), "flag_height" => ($context["flag_height"] ?? null)], "css_classes_flag" => ($context["css_classes_flag"] ?? null)]));
        // line 9
        if (($context["native_name"] ?? null)) {
            // line 10
            echo "<span class=\"";
            echo \WPML\Core\twig_escape_filter($this->env, ($context["css_classes_native"] ?? null), "html", null, true);
            echo "\" lang=\"";
            echo \WPML\Core\twig_escape_filter($this->env, ($context["code"] ?? null), "html", null, true);
            echo "\">";
            echo \WPML\Core\twig_escape_filter($this->env, ($context["native_name"] ?? null), "html", null, true);
            echo "</span>";
        }
        // line 13
        if ((($context["display_name"] ?? null) && (($context["display_name"] ?? null) != ($context["native_name"] ?? null)))) {
            // line 14
            echo "<span class=\"";
            echo \WPML\Core\twig_escape_filter($this->env, ($context["css_classes_display"] ?? null), "html", null, true);
            echo "\">";
            // line 15
            if (($context["native_name"] ?? null)) {
                echo "<span class=\"";
                echo \WPML\Core\twig_escape_filter($this->env, ($context["css_classes_bracket"] ?? null), "html", null, true);
                echo "\"> (</span>";
            }
            // line 16
            echo \WPML\Core\twig_escape_filter($this->env, ($context["display_name"] ?? null), "html", null, true);
            // line 17
            if (($context["native_name"] ?? null)) {
                echo "<span class=\"";
                echo \WPML\Core\twig_escape_filter($this->env, ($context["css_classes_bracket"] ?? null), "html", null, true);
                echo "\">)</span>";
            }
            // line 18
            echo "</span>";
        }
    }

    public function getTemplateName()
    {
        return "template.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  76 => 18,  70 => 17,  68 => 16,  62 => 15,  58 => 14,  56 => 13,  47 => 10,  45 => 9,  43 => 6,  40 => 5,  38 => 4,  36 => 3,  34 => 2,  32 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{% set css_classes_flag    = ('wpml-ls-flag ' ~ backward_compatibility.css_classes_flag)|trim %}
{% set css_classes_native  = ('wpml-ls-native ' ~ backward_compatibility.css_classes_native)|trim %}
{% set css_classes_display = ('wpml-ls-display ' ~ backward_compatibility.css_classes_display)|trim %}
{% set css_classes_bracket = ('wpml-ls-bracket ' ~ backward_compatibility.css_classes_bracket)|trim %}

{% include 'flag.twig'  with {language: {flag_url: flag_url, flag_alt: flag_alt, flag_width: flag_width, flag_height: flag_height}, css_classes_flag: css_classes_flag} %}


{%- if native_name -%}
    <span class=\"{{ css_classes_native }}\" lang=\"{{ code }}\">{{ native_name }}</span>
{%- endif -%}

{%- if display_name and (display_name != native_name) -%}
    <span class=\"{{ css_classes_display }}\">
    {%- if native_name -%}<span class=\"{{ css_classes_bracket }}\"> (</span>{%- endif -%}
        {{- display_name -}}
        {%- if native_name -%}<span class=\"{{ css_classes_bracket }}\">)</span>{%- endif -%}
    </span>
{%- endif -%}
", "template.twig", "/Users/phil/Sites/habitatseven/riskprofiler/site/assets/plugins/sitepress-multilingual-cms/templates/language-switchers/menu-item/template.twig");
    }
}
