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

/* media-translation-table-row.twig */
class __TwigTemplate_df62680390e6f8c55ace8e5c1e27573b1a62d0f84cebf01e647452c48358b7a6 extends \WPML\Core\Twig\Template
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
        echo "<tr class=\"wpml-media-attachment-row\" data-attachment-id=\"";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "post", []), "ID", []), "html", null, true);
        echo "\"
\tdata-language-code=\"";
        // line 2
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["attachment"] ?? null), "language", []), "html", null, true);
        echo "\"
\tdata-language-name=\"";
        // line 3
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["languages"] ?? null), $this->getAttribute(($context["attachment"] ?? null), "language", []), [], "array"), "name", []), "html", null, true);
        echo "\"
\tdata-is-image=\"";
        // line 4
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["attachment"] ?? null), "is_image", []), "html", null, true);
        echo "\"
\tdata-thumb=\"";
        // line 5
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "thumb", []), "src", []), "html", null, true);
        echo "\"
\tdata-file-name=\"";
        // line 6
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["attachment"] ?? null), "file_name", []), "html", null, true);
        echo "\"
\tdata-mime-type=\"";
        // line 7
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["attachment"] ?? null), "mime_type", []), "html", null, true);
        echo "\"
\tdata-title=\"";
        // line 8
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "post", []), "post_title", []), "html", null, true);
        echo "\"
\tdata-caption=\"";
        // line 9
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "post", []), "post_excerpt", []), "html", null, true);
        echo "\"
\tdata-alt_text=\"";
        // line 10
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["attachment"] ?? null), "alt", []), "html", null, true);
        echo "\"
\tdata-description=\"";
        // line 11
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "post", []), "post_content", []), "html", null, true);
        echo "\"
\tdata-flag=\"";
        // line 12
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["languages"] ?? null), $this->getAttribute(($context["attachment"] ?? null), "language", []), [], "array"), "flag", []), "html", null, true);
        echo "\">
\t<td class=\"wpml-col-media-title\">
        <span title=\"";
        // line 14
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["languages"] ?? null), $this->getAttribute(($context["attachment"] ?? null), "language", []), [], "array"), "name", []), "html", null, true);
        echo "\" class=\"wpml-media-original-flag js-otgs-popover-tooltip\"
\t\t\t  data-tippy-distance=\"-12\">
            <img src=\"";
        // line 16
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["languages"] ?? null), $this->getAttribute(($context["attachment"] ?? null), "language", []), [], "array"), "flag", []), "html", null, true);
        echo "\" width=\"16\" height=\"12\" alt=\"";
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["attachment"] ?? null), "language", []), "html", null, true);
        echo "\">
        </span>
\t\t<span class=\"wpml-media-wrapper\">
            <img src=\"";
        // line 19
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "thumb", []), "src", []), "html", null, true);
        echo "\"
\t\t\t\t width=\"";
        // line 20
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "thumb", []), "width", []), "html", null, true);
        echo "\"
\t\t\t\t height=\"";
        // line 21
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "thumb", []), "height", []), "html", null, true);
        echo "\"
\t\t\t\t alt=\"";
        // line 22
        echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["attachment"] ?? null), "language", []), "html", null, true);
        echo "\"
\t\t\t\t ";
        // line 23
        if ( !$this->getAttribute(($context["attachment"] ?? null), "is_image", [])) {
            // line 24
            echo "\t\t\t\t\t class=\"is-non-image\"
\t\t\t\t ";
        } else {
            // line 26
            echo "\t\t\t\t\t data-tippy-boundary=\"viewport\"
\t\t\t\t\t data-tippy-flip=\"true\"
\t\t\t\t\t data-tippy-placement=\"right\"
\t\t\t\t\t data-tippy-maxWidth= \"";
            // line 29
            echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "preview", []), "width", []), "html", null, true);
            echo "px\"
\t\t\t\t\t data-tippy-content=\"";
            // line 30
            echo \WPML\Core\twig_escape_filter($this->env, (((("<img style=\"max-width:100%;width:auto;max-height:" . $this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "preview", []), "height", [])) . "px;height:auto;\" src=\"") . $this->getAttribute(($context["attachment"] ?? null), "url", [])) . "\" />"), "html", null, true);
            echo "\"
\t\t\t\t\t class=\"js-otgs-popover-tooltip\"
\t\t\t\t ";
        }
        // line 33
        echo "\t\t\t>
        </span>
\t</td>
\t<td class=\"wpml-col-media-translations\">
\t\t";
        // line 37
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["languages"] ?? null));
        foreach ($context['_seq'] as $context["code"] => $context["language"]) {
            // line 38
            echo "\t\t\t";
            if ((twig_test_empty(($context["target_language"] ?? null)) || (($context["target_language"] ?? null) == $context["code"]))) {
                // line 39
                echo "\t\t\t\t";
                if (($this->getAttribute(($context["attachment"] ?? null), "language", []) == $context["code"])) {
                    // line 40
                    echo "\t\t\t\t\t<span class=\"js-otgs-popover-tooltip\" data-tippy-distance=\"-12\"
\t\t\t\t\t\t  title=\"";
                    // line 41
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["languages"] ?? null), $this->getAttribute(($context["attachment"] ?? null), "language", []), [], "array"), "name", []), "html", null, true);
                    echo ": ";
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["strings"] ?? null), "original_language", []), "html", null, true);
                    echo "\">
                                    <i class=\"otgs-ico-original\"></i>
                                </span>
\t\t\t\t";
                } else {
                    // line 45
                    echo "\t\t\t\t\t<span class=\"wpml-media-wrapper js-otgs-popover-tooltip\"
\t\t\t\t\t\t  id=\"media-attachment-";
                    // line 46
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "post", []), "ID", []), "html", null, true);
                    echo "-";
                    echo \WPML\Core\twig_escape_filter($this->env, $context["code"], "html", null, true);
                    echo "\"
\t\t\t\t\t\t  data-file-name=\"";
                    // line 47
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "translations", []), $context["code"], [], "array"), "file_name", []), "html", null, true);
                    echo "\"
\t\t\t\t\t\t  title=\"";
                    // line 48
                    echo \WPML\Core\twig_escape_filter($this->env, sprintf($this->getAttribute(($context["strings"] ?? null), "edit_translation", []), $this->getAttribute($this->getAttribute(($context["languages"] ?? null), $context["code"], [], "array"), "name", [])), "html", null, true);
                    echo "\"
                            ";
                    // line 49
                    if ( !$this->getAttribute($this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "translations", []), $context["code"], [], "array"), "media_is_translated", [])) {
                        // line 50
                        echo "\t\t\t\t\t\t\t\tdata-tippy-distance=\"-12\"
\t\t\t\t\t\t\t";
                    }
                    // line 52
                    echo "                          data-attachment-id=\"";
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "translations", []), $context["code"], [], "array"), "id", []), "html", null, true);
                    echo "\"
\t\t\t\t\t\t  data-language-code=\"";
                    // line 53
                    echo \WPML\Core\twig_escape_filter($this->env, $context["code"], "html", null, true);
                    echo "\"
\t\t\t\t\t\t  data-language-name=\"";
                    // line 54
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($context["language"], "name", []), "html", null, true);
                    echo "\"
\t\t\t\t\t\t  data-url=\"";
                    // line 55
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["attachment"] ?? null), "url", []), "html", null, true);
                    echo "\"
\t\t\t\t\t\t  data-thumb=\"";
                    // line 56
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "translations", []), $context["code"], [], "array"), "thumb", []), "src", []), "html", null, true);
                    echo "\"
\t\t\t\t\t\t  data-title=\"";
                    // line 57
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "translations", []), $context["code"], [], "array"), "title", []), "html", null, true);
                    echo "\"
\t\t\t\t\t\t  data-caption=\"";
                    // line 58
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "translations", []), $context["code"], [], "array"), "caption", []), "html", null, true);
                    echo "\"
\t\t\t\t\t\t  data-alt_text=\"";
                    // line 59
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "translations", []), $context["code"], [], "array"), "alt", []), "html", null, true);
                    echo "\"
\t\t\t\t\t\t  data-description=\"";
                    // line 60
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "translations", []), $context["code"], [], "array"), "description", []), "html", null, true);
                    echo "\"
\t\t\t\t\t\t  data-flag=\"";
                    // line 61
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["languages"] ?? null), $context["code"], [], "array"), "flag", []), "html", null, true);
                    echo "\"
\t\t\t\t\t\t  data-media-is-translated=\"";
                    // line 62
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "translations", []), $context["code"], [], "array"), "media_is_translated", []), "html", null, true);
                    echo "\">
                                    <a class=\"js-open-media-translation-dialog ";
                    // line 63
                    if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "translations", []), $context["code"], [], "array"), "media_is_translated", [])) {
                        echo "wpml-media-translation-image";
                    }
                    echo "\">
                                        <img src=\"";
                    // line 64
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "translations", []), $context["code"], [], "array"), "thumb", []), "src", []), "html", null, true);
                    echo "\"
\t\t\t\t\t\t\t\t\t\t\t width=\"";
                    // line 65
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "thumb", []), "width", []), "html", null, true);
                    echo "\" height=\"";
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "thumb", []), "height", []), "html", null, true);
                    echo "\"
\t\t\t\t\t\t\t\t\t\t\t alt=\"";
                    // line 66
                    echo \WPML\Core\twig_escape_filter($this->env, $this->getAttribute(($context["attachment"] ?? null), "language", []), "html", null, true);
                    echo "\"
\t\t\t\t\t\t\t\t\t\t\t ";
                    // line 67
                    if ( !$this->getAttribute(($context["attachment"] ?? null), "is_image", [])) {
                        echo "class=\"is-non-image\"";
                    }
                    // line 68
                    echo "\t\t\t\t\t\t\t\t\t\t\t";
                    if ( !$this->getAttribute($this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "translations", []), $context["code"], [], "array"), "media_is_translated", [])) {
                        echo "style=\"display:none\"";
                    }
                    echo ">
                                        <i class=\"";
                    // line 69
                    if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "translations", []), $context["code"], [], "array"), "id", [])) {
                        echo "otgs-ico-edit";
                    } else {
                        echo "otgs-ico-add";
                    }
                    echo "\"
\t\t\t\t\t\t\t\t\t\t   ";
                    // line 70
                    if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["attachment"] ?? null), "translations", []), $context["code"], [], "array"), "media_is_translated", [])) {
                        echo "style=\"display:none\"";
                    }
                    echo "></i>
                                    </a>
                                </span>
\t\t\t\t";
                }
                // line 74
                echo "\t\t\t";
            }
            // line 75
            echo "\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['code'], $context['language'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 76
        echo "\t</td>
</tr>
";
    }

    public function getTemplateName()
    {
        return "media-translation-table-row.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  285 => 76,  279 => 75,  276 => 74,  267 => 70,  259 => 69,  252 => 68,  248 => 67,  244 => 66,  238 => 65,  234 => 64,  228 => 63,  224 => 62,  220 => 61,  216 => 60,  212 => 59,  208 => 58,  204 => 57,  200 => 56,  196 => 55,  192 => 54,  188 => 53,  183 => 52,  179 => 50,  177 => 49,  173 => 48,  169 => 47,  163 => 46,  160 => 45,  151 => 41,  148 => 40,  145 => 39,  142 => 38,  138 => 37,  132 => 33,  126 => 30,  122 => 29,  117 => 26,  113 => 24,  111 => 23,  107 => 22,  103 => 21,  99 => 20,  95 => 19,  87 => 16,  82 => 14,  77 => 12,  73 => 11,  69 => 10,  65 => 9,  61 => 8,  57 => 7,  53 => 6,  49 => 5,  45 => 4,  41 => 3,  37 => 2,  32 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("<tr class=\"wpml-media-attachment-row\" data-attachment-id=\"{{ attachment.post.ID }}\"
\tdata-language-code=\"{{ attachment.language }}\"
\tdata-language-name=\"{{ languages[attachment.language].name }}\"
\tdata-is-image=\"{{ attachment.is_image }}\"
\tdata-thumb=\"{{ attachment.thumb.src }}\"
\tdata-file-name=\"{{ attachment.file_name }}\"
\tdata-mime-type=\"{{ attachment.mime_type }}\"
\tdata-title=\"{{ attachment.post.post_title }}\"
\tdata-caption=\"{{ attachment.post.post_excerpt }}\"
\tdata-alt_text=\"{{ attachment.alt }}\"
\tdata-description=\"{{ attachment.post.post_content }}\"
\tdata-flag=\"{{ languages[attachment.language].flag }}\">
\t<td class=\"wpml-col-media-title\">
        <span title=\"{{ languages[attachment.language].name }}\" class=\"wpml-media-original-flag js-otgs-popover-tooltip\"
\t\t\t  data-tippy-distance=\"-12\">
            <img src=\"{{ languages[attachment.language].flag }}\" width=\"16\" height=\"12\" alt=\"{{ attachment.language }}\">
        </span>
\t\t<span class=\"wpml-media-wrapper\">
            <img src=\"{{ attachment.thumb.src }}\"
\t\t\t\t width=\"{{ attachment.thumb.width }}\"
\t\t\t\t height=\"{{ attachment.thumb.height }}\"
\t\t\t\t alt=\"{{ attachment.language }}\"
\t\t\t\t {% if not attachment.is_image %}
\t\t\t\t\t class=\"is-non-image\"
\t\t\t\t {% else %}
\t\t\t\t\t data-tippy-boundary=\"viewport\"
\t\t\t\t\t data-tippy-flip=\"true\"
\t\t\t\t\t data-tippy-placement=\"right\"
\t\t\t\t\t data-tippy-maxWidth= \"{{ attachment.preview.width }}px\"
\t\t\t\t\t data-tippy-content=\"{{ '<img style=\\\"max-width:100%;width:auto;max-height:' ~ attachment.preview.height ~ 'px;height:auto;\\\" src=\"' ~ attachment.url ~ '\" />' }}\"
\t\t\t\t\t class=\"js-otgs-popover-tooltip\"
\t\t\t\t {% endif %}
\t\t\t>
        </span>
\t</td>
\t<td class=\"wpml-col-media-translations\">
\t\t{% for code, language in languages %}
\t\t\t{% if target_language is empty or target_language == code %}
\t\t\t\t{% if attachment.language == code %}
\t\t\t\t\t<span class=\"js-otgs-popover-tooltip\" data-tippy-distance=\"-12\"
\t\t\t\t\t\t  title=\"{{ languages[attachment.language].name }}: {{ strings.original_language }}\">
                                    <i class=\"otgs-ico-original\"></i>
                                </span>
\t\t\t\t{% else %}
\t\t\t\t\t<span class=\"wpml-media-wrapper js-otgs-popover-tooltip\"
\t\t\t\t\t\t  id=\"media-attachment-{{ attachment.post.ID }}-{{ code }}\"
\t\t\t\t\t\t  data-file-name=\"{{ attachment.translations[code].file_name }}\"
\t\t\t\t\t\t  title=\"{{ strings.edit_translation | format(languages[code].name ) }}\"
                            {% if not attachment.translations[code].media_is_translated %}
\t\t\t\t\t\t\t\tdata-tippy-distance=\"-12\"
\t\t\t\t\t\t\t{% endif %}
                          data-attachment-id=\"{{ attachment.translations[code].id }}\"
\t\t\t\t\t\t  data-language-code=\"{{ code }}\"
\t\t\t\t\t\t  data-language-name=\"{{ language.name }}\"
\t\t\t\t\t\t  data-url=\"{{ attachment.url }}\"
\t\t\t\t\t\t  data-thumb=\"{{ attachment.translations[code].thumb.src }}\"
\t\t\t\t\t\t  data-title=\"{{ attachment.translations[code].title }}\"
\t\t\t\t\t\t  data-caption=\"{{ attachment.translations[code].caption }}\"
\t\t\t\t\t\t  data-alt_text=\"{{ attachment.translations[code].alt }}\"
\t\t\t\t\t\t  data-description=\"{{ attachment.translations[code].description }}\"
\t\t\t\t\t\t  data-flag=\"{{ languages[code].flag }}\"
\t\t\t\t\t\t  data-media-is-translated=\"{{ attachment.translations[code].media_is_translated }}\">
                                    <a class=\"js-open-media-translation-dialog {% if attachment.translations[code].media_is_translated %}wpml-media-translation-image{% endif %}\">
                                        <img src=\"{{ attachment.translations[code].thumb.src }}\"
\t\t\t\t\t\t\t\t\t\t\t width=\"{{ attachment.thumb.width }}\" height=\"{{ attachment.thumb.height }}\"
\t\t\t\t\t\t\t\t\t\t\t alt=\"{{ attachment.language }}\"
\t\t\t\t\t\t\t\t\t\t\t {% if not attachment.is_image %}class=\"is-non-image\"{% endif %}
\t\t\t\t\t\t\t\t\t\t\t{% if not attachment.translations[code].media_is_translated %}style=\"display:none\"{% endif %}>
                                        <i class=\"{% if attachment.translations[code].id %}otgs-ico-edit{% else %}otgs-ico-add{% endif %}\"
\t\t\t\t\t\t\t\t\t\t   {% if attachment.translations[code].media_is_translated %}style=\"display:none\"{% endif %}></i>
                                    </a>
                                </span>
\t\t\t\t{% endif %}
\t\t\t{% endif %}
\t\t{% endfor %}
\t</td>
</tr>
", "media-translation-table-row.twig", "/Users/phil/Sites/habitatseven/riskprofiler/site/assets/plugins/wpml-media-translation/templates/menus/media-translation-table-row.twig");
    }
}
