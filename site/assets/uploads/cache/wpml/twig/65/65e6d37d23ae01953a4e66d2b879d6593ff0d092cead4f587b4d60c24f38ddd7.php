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

/* media-translation-filters.twig */
class __TwigTemplate_52ceeabd0fd6b36f52d5dd867c07bc735e496e81b21485b3df0e623d0bbcb1e3 extends \WPML\Core\Twig\Template
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
        echo "<form id=\"posts-filter\" method=\"get\">
    <input type=\"hidden\" name=\"page\" value=\"wpml-media\"/>
    <input type=\"hidden\" name=\"sm\" value=\"media-translation\"/>
    ";
        // line 4
        echo ($context["nonce"] ?? null);
        echo "
    <label for=\"filter-by-date\" class=\"screen-reader-text\">";
        // line 5
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "filter_by_date", []), "html", null, true);
        echo "</label>
    <select id=\"filter-by-date\" name=\"m\">
        <option ";
        // line 7
        if ((($context["selected_month"] ?? null) == 0)) {
            echo "selected=\"selected\"";
        }
        // line 8
        echo "                value=\"0\">";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "all_dates", []), "html", null, true);
        echo "</option>
        ";
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["months"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["month"]) {
            // line 10
            echo "            <option ";
            if ((($context["selected_month"] ?? null) == $this->getAttribute($context["month"], "id", []))) {
                echo "selected=\"selected\"";
            }
            // line 11
            echo "                    value=\"";
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["month"], "id", []), "html", null, true);
            echo "\">";
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["month"], "label", []), "html", null, true);
            echo "</option>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['month'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "    </select>
    ";
        // line 14
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "in", []), "html", null, true);
        echo "
    <label for=\"filter-by-language\" class=\"screen-reader-text\">";
        // line 15
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "filter_by_language", []), "html", null, true);
        echo "</label>
    <select id=\"filter-by-language\" name=\"slang\">
        <option value=\"\">";
        // line 17
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "any_language", []), "html", null, true);
        echo "</option>
        ";
        // line 18
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["languages"] ?? null));
        foreach ($context['_seq'] as $context["code"] => $context["language"]) {
            // line 19
            echo "            <option ";
            if ((($context["from_language"] ?? null) == $context["code"])) {
                echo "selected=\"selected\"";
            }
            // line 20
            echo "                    value=\"";
            echo \WPML\Core\twig_escape_filter($this->env, $context["code"], "html", null, true);
            echo "\">";
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["language"], "name", []), "html", null, true);
            echo "</option>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['code'], $context['language'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 22
        echo "    </select>
    ";
        // line 23
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "to", []), "html", null, true);
        echo "
    <select id=\"filter-by-language\" name=\"tlang\">
        <option value=\"\">";
        // line 25
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "any_language", []), "html", null, true);
        echo "</option>
        ";
        // line 26
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["languages"] ?? null));
        foreach ($context['_seq'] as $context["code"] => $context["language"]) {
            // line 27
            echo "            <option ";
            if ((($context["to_language"] ?? null) == $context["code"])) {
                echo "selected=\"selected\"";
            }
            // line 28
            echo "                    value=\"";
            echo \WPML\Core\twig_escape_filter($this->env, $context["code"], "html", null, true);
            echo "\">";
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["language"], "name", []), "html", null, true);
            echo "</option>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['code'], $context['language'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 30
        echo "    </select>

    <label for=\"filter-by-translation-status\" class=\"screen-reader-text\">";
        // line 32
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "filter_by_status", []), "html", null, true);
        echo "</label>
    <select id=\"filter-by-translation-status\" name=\"status\">
        <option ";
        // line 34
        if ((\WPML\Core\twig_length_filter($this->env, ($context["selected_status"] ?? null)) == 0)) {
            echo "selected=\"selected\"";
        }
        // line 35
        echo "                value=\"\">";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "status_all", []), "html", null, true);
        echo "</option>
        <option ";
        // line 36
        if (((($context["selected_status"] ?? null) == $this->getAttribute(($context["statuses"] ?? null), "not_translated", [])) && (\WPML\Core\twig_length_filter($this->env, ($context["selected_status"] ?? null)) > 0))) {
            echo "selected=\"selected\"";
        }
        // line 37
        echo "                value=\"";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["statuses"] ?? null), "not_translated", []), "html", null, true);
        echo "\">";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "status_not", []), "html", null, true);
        echo "</option>
        <option ";
        // line 38
        if (((($context["selected_status"] ?? null) == $this->getAttribute(($context["statuses"] ?? null), "in_progress", [])) && (\WPML\Core\twig_length_filter($this->env, ($context["selected_status"] ?? null)) > 0))) {
            echo "selected=\"selected\"";
        }
        // line 39
        echo "                value=\"";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["statuses"] ?? null), "in_progress", []), "html", null, true);
        echo "\">";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "status_in_progress", []), "html", null, true);
        echo "</option>
        <option ";
        // line 40
        if ((($context["selected_status"] ?? null) == $this->getAttribute(($context["statuses"] ?? null), "translated", []))) {
            echo "selected=\"selected\"";
        }
        // line 41
        echo "                value=\"";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["statuses"] ?? null), "translated", []), "html", null, true);
        echo "\">";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "status_translated", []), "html", null, true);
        echo "</option>
        <option ";
        // line 42
        if ((($context["selected_status"] ?? null) == $this->getAttribute(($context["statuses"] ?? null), "needs_translation", []))) {
            echo "selected=\"selected\"";
        }
        // line 43
        echo "                value=\"";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["statuses"] ?? null), "needs_translation", []), "html", null, true);
        echo "\">";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "status_needs_translation", []), "html", null, true);
        echo "</option>
    </select>

    <label class=\"screen-reader-text\" for=\"media-search-input\">";
        // line 46
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "search_media", []), "html", null, true);
        echo "</label>
    <input size=\"25\" type=\"search\" id=\"media-search-input\" placeholder=\"";
        // line 47
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "search_placeholder", []), "html", null, true);
        echo "\" name=\"s\"
           value=\"";
        // line 48
        echo \WPML\Core\twig_escape_filter($this->env, ($context["search"] ?? null), "html", null, true);
        echo "\">
    <input type=\"submit\" class=\"button action\" value=\"";
        // line 49
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "search_button_label", []), "html", null, true);
        echo "\">
</form>";
    }

    public function getTemplateName()
    {
        return "media-translation-filters.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  219 => 49,  215 => 48,  211 => 47,  207 => 46,  198 => 43,  194 => 42,  187 => 41,  183 => 40,  176 => 39,  172 => 38,  165 => 37,  161 => 36,  156 => 35,  152 => 34,  147 => 32,  143 => 30,  132 => 28,  127 => 27,  123 => 26,  119 => 25,  114 => 23,  111 => 22,  100 => 20,  95 => 19,  91 => 18,  87 => 17,  82 => 15,  78 => 14,  75 => 13,  64 => 11,  59 => 10,  55 => 9,  50 => 8,  46 => 7,  41 => 5,  37 => 4,  32 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("<form id=\"posts-filter\" method=\"get\">
    <input type=\"hidden\" name=\"page\" value=\"wpml-media\"/>
    <input type=\"hidden\" name=\"sm\" value=\"media-translation\"/>
    {{ nonce|raw }}
    <label for=\"filter-by-date\" class=\"screen-reader-text\">{{ strings.filter_by_date }}</label>
    <select id=\"filter-by-date\" name=\"m\">
        <option {% if( selected_month == 0 ) %}selected=\"selected\"{% endif %}
                value=\"0\">{{ strings.all_dates }}</option>
        {% for month in months %}
            <option {% if( selected_month == month.id ) %}selected=\"selected\"{% endif %}
                    value=\"{{ month.id }}\">{{ month.label }}</option>
        {% endfor %}
    </select>
    {{ strings.in }}
    <label for=\"filter-by-language\" class=\"screen-reader-text\">{{ strings.filter_by_language }}</label>
    <select id=\"filter-by-language\" name=\"slang\">
        <option value=\"\">{{ strings.any_language }}</option>
        {% for code, language in languages %}
            <option {% if( from_language == code ) %}selected=\"selected\"{% endif %}
                    value=\"{{ code }}\">{{ language.name }}</option>
        {% endfor %}
    </select>
    {{ strings.to }}
    <select id=\"filter-by-language\" name=\"tlang\">
        <option value=\"\">{{ strings.any_language }}</option>
        {% for code, language in languages %}
            <option {% if( to_language == code ) %}selected=\"selected\"{% endif %}
                    value=\"{{ code }}\">{{ language.name }}</option>
        {% endfor %}
    </select>

    <label for=\"filter-by-translation-status\" class=\"screen-reader-text\">{{ strings.filter_by_status }}</label>
    <select id=\"filter-by-translation-status\" name=\"status\">
        <option {% if( selected_status|length == 0 ) %}selected=\"selected\"{% endif %}
                value=\"\">{{ strings.status_all }}</option>
        <option {% if( selected_status == statuses.not_translated and selected_status|length > 0 ) %}selected=\"selected\"{% endif %}
                value=\"{{ statuses.not_translated }}\">{{ strings.status_not }}</option>
        <option {% if( selected_status == statuses.in_progress and selected_status|length > 0 ) %}selected=\"selected\"{% endif %}
                value=\"{{ statuses.in_progress }}\">{{ strings.status_in_progress }}</option>
        <option {% if( selected_status == statuses.translated ) %}selected=\"selected\"{% endif %}
                value=\"{{ statuses.translated }}\">{{ strings.status_translated }}</option>
        <option {% if( selected_status == statuses.needs_translation ) %}selected=\"selected\"{% endif %}
                value=\"{{ statuses.needs_translation }}\">{{ strings.status_needs_translation }}</option>
    </select>

    <label class=\"screen-reader-text\" for=\"media-search-input\">{{ strings.search_media }}</label>
    <input size=\"25\" type=\"search\" id=\"media-search-input\" placeholder=\"{{ strings.search_placeholder }}\" name=\"s\"
           value=\"{{ search }}\">
    <input type=\"submit\" class=\"button action\" value=\"{{ strings.search_button_label }}\">
</form>", "media-translation-filters.twig", "/Users/phil/Sites/habitatseven/riskprofiler/site/assets/plugins/wpml-media-translation/templates/menus/media-translation-filters.twig");
    }
}
