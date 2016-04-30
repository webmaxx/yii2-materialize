<?php namespace altiore\materialize;

use yii\helpers\Html;

/**
 * Button renders a materialize button.
 *
 * For example,
 *
 * ```php
 * echo Button::widget([
 *     'label' => 'Action',
 *     'options' => ['class' => 'btn-large'],
 * ]);
 * ```
 * @see http://materializecss.com/buttons.html
 * @author altiore <altiore@altiore.name>
 * @since 2.0
 */
class Button extends Widget
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
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        $this->clientOptions = false;
        if ($this->defaultClass)
            Html::addCssClass($this->options, $this->defaultClass);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerPlugin('button');
        return Html::tag($this->tagName, $this->encodeLabel ? Html::encode($this->label) : $this->label, $this->options);
    }
}
