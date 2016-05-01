<?php

namespace altiore\materialize;

use Yii;
use yii\helpers\Html;

/**
 * Class ActiveField
 *
 * @author  Razzwan <razvanlomov@gmail.com>
 * @package altiore\materialize
 */
class ActiveField extends \yii\widgets\ActiveField
{
    /**
     * @var array the HTML attributes (name-value pairs) for the field container tag.
     * The values will be HTML-encoded using [[Html::encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * The following special options are recognized:
     *
     * - tag: the tag name of the container element. Defaults to "div".
     *
     * If you set a custom `id` for the container element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'input-field'];
    /**
     * @var string the template that is used to arrange the label, the input field, the error message and the hint text.
     * The following tokens will be replaced when [[render()]] is called: `{label}`, `{input}`, `{error}` and `{hint}`.
     */
    public $template = "{icon}\n{input}\n{label}";
    /**
     * @var array the default options for the input tags. The parameter passed to individual input methods
     * (e.g. [[textInput()]]) will be merged with this property when rendering the input tag.
     *
     * If you set a custom `id` for the input element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $inputOptions = ['class' => 'validate'];
    /**
     * @var array the default options for the textarea tags.
     */
    public $textareaOptions = ['class' => 'materialize-textarea'];
    /**
     * @var array the default options for the error tags. The parameter passed to [[error()]] will be
     * merged with this property when rendering the error tag.
     * The following special options are recognized:
     *
     * - tag: the tag name of the container element. Defaults to "div".
     * - encode: whether to encode the error output. Defaults to true.
     *
     * If you set a custom `id` for the error element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $errorOptions = [];
    /**
     * @var array the default options for the label tags. The parameter passed to [[label()]] will be
     * merged with this property when rendering the label tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $labelOptions = [];
    /**
     * @var array the default options for the hint tags. The parameter passed to [[hint()]] will be
     * merged with this property when rendering the hint tag.
     * The following special options are recognized:
     *
     * - tag: the tag name of the container element. Defaults to "div".
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $hintOptions = [];
    /**
     * @var array the default options for the i tags. Materialize icons
     * @see http://materializecss.com/icons.html
     */
    public $iconOptions = ['class' => 'material-icons prefix'];

    public function init()
    {
        parent::init();
        // fix bag wrong render error if attribute is empty
        Yii::$app->getView()->registerJs(<<<JS
jQuery(".validate.invalid").on("focus", function() {
    $(this).val($(this).val().trim());
});
JS
        );
    }

    /**
     * Renders a text area.
     * The model attribute value will be used as the content in the textarea.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     *
     * If you set a custom `id` for the textarea element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @return $this the field object itself
     */
    public function textarea($options = [])
    {
        $options = array_merge($this->textareaOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeTextarea($this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * Renders the whole field.
     * This method will generate the label, error tag, input tag and hint tag (if any), and
     * assemble them into HTML according to [[template]].
     * @param string|callable $content the content within the field container.
     * If null (not set), the default methods will be called to generate the label, error tag and input tag,
     * and use them as the content.
     * If a callable, it will be called to generate the content. The signature of the callable should be:
     *
     * ```php
     * function ($field) {
     *     return $html;
     * }
     * ```
     *
     * @return string the rendering result
     */
    public function render($content = null)
    {
        if ($content === null) {
            if (!isset($this->parts['{icon}'])) {
                $this->icon();
            }
            if (!isset($this->parts['{error}'])) {
                $this->error();
            }
            if (!isset($this->parts['{input}'])) {
                $this->textInput();
            }
            if (!isset($this->parts['{label}'])) {
                $this->label();
            }
            if (!isset($this->parts['{hint}'])) {
                $this->hint(null);
            }
            $content = strtr($this->template, $this->parts);
        } elseif (!is_string($content)) {
            $content = call_user_func($content, $this);
        }

        return $this->begin() . "\n" . $content . "\n" . $this->end();
    }

    /**
     * @param array $options
     * @return $this
     */
    public function error($options = [])
    {
        if (!empty($error = $this->model->getFirstError($this->attribute))) {
            $this->labelOptions['data-error'] = $error;
            // this fix bag wrong render error if attribute is empty
            if (empty($this->model->{$this->attribute})) {
                $this->model->{$this->attribute} = ' ';
            }
            Html::addCssClass($this->inputOptions, 'invalid');
        } elseif (!empty($this->model->{$this->attribute})) {
            Html::addCssClass($this->inputOptions, 'valid');
        }

        return $this;
    }

    /**
     * @param null  $icon
     * @param array $options
     * @return $this
     */
    public function icon($icon = null, $options = [])
    {
        if (empty($icon)) {
            $this->parts['{icon}'] = '';
            return $this;
        }

        $options = array_merge($this->iconOptions, $options);
        $this->parts['{icon}'] = Html::tag('i', $icon, $options);

        return $this;
    }

    /**
     * Renders a checkbox.
     * This method will generate the "checked" tag attribute according to the model attribute value.
     *
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     * @param bool  $enclosedByLabel
     * @return $this the field object itself
     */
    public function checkbox($options = [], $enclosedByLabel = true)
    {
        return parent::checkbox($options, false);
    }
}
