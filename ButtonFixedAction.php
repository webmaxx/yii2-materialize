<?php namespace altiore\materialize;

use yii\helpers\Html;
use altiore\materialize\Button;

/**
 * Button renders a materialize button.
 *
 * For example,
 *
 * ```php
 * echo ButtonFixedAction::widget([
 *     'label' => 'Action',
 *     'options' => ['class' => 'btn-large'],
 *     'wrapOptions' => ['style' => 'bottom: 45px; right: 24px;'],
 *     'buttons' => [
 *         Button::widget(['label' => 'A']),
 *         ['label' => 'B'],
 *     ],
 * ]);
 * ```
 * @see http://materializecss.com/buttons.html
 * @author altiore <altiore@altiore.name>
 * @since 2.0
 */
class ButtonFixedAction extends Widget
{
    /**
     * @var string the tag to use to render the button
     */
    public $tagName = 'button';
    /**
     * @var string the button label
     */
    public $label = 'Button';
    /**
     * @var boolean whether the label should be HTML-encoded.
     */
    public $encodeLabel = true;
    /**
     * @var string default css class for button
     */
    public $defaultClass = 'btn';
    /**
     * @var array the HTML attributes for the widget container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $wrapOptions = [];
    /**
     * @var string default css class for button wrapper
     */
    public $defaultWrapClass = 'fixed-action-btn';
    /**
     * @var array list of buttons. Each array element represents a single button
     * which can be specified as a string or an array of the following structure:
     *
     * - label: string, required, the button label.
     * - options: array, optional, the HTML attributes of the button.
     */
    public $buttons = [];
    /**
     * @var boolean whether to HTML-encode the button labels.
     */
    public $encodeLabels = true;

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        $this->clientOptions = false;
        if ($this->defaultWrapClass)
            Html::addCssClass($this->wrapOptions, $this->defaultWrapClass);
        if ($this->defaultClass)
            Html::addCssClass($this->options, $this->defaultClass);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        MaterializeAsset::register($this->getView());
        return Html::tag(
            'div',
            Html::tag($this->tagName, $this->encodeLabel ? Html::encode($this->label) : $this->label, $this->options) . Html::tag('ul', $this->renderButtons()),
            $this->wrapOptions
        );
    }

    /**
     * Generates the buttons that compound the group as specified on [[buttons]].
     * @return string the rendering result.
     */
    protected function renderButtons()
    {
        $buttons = [];
        foreach ($this->buttons as $button) {
            if (is_array($button)) {
                $button['view'] = $this->getView();
                $button['defaultClass'] = false;
                if (!isset($button['encodeLabel'])) {
                    $button['encodeLabel'] = $this->encodeLabels;
                }
                $buttons[] = Html::tag('li', Button::widget($button));
            } else {
                $buttons[] = Html::tag('li', $button);
            }
        }

        return implode("\n", $buttons);
    }
}
