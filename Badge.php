<?php namespace altiore\materialize;

use yii\helpers\Html;

/**
 * Badge renders a materialize button.
 *
 * For example,
 *
 * ```php
 * echo Badge::widget([
 *     'label' => 'Action',
 *     'options' => ['class' => 'new'],
 * ]);
 * ```
 * @see http://materializecss.com/badges.html
 * @author altiore <altiore@altiore.name>
 * @since 2.0
 */
class Badge extends Widget
{
    /**
     * @var string the tag to use to render the badge
     */
    public $tagName = 'span';
    /**
     * @var string the button label
     */
    public $label = '';
    /**
     * @var boolean whether the label should be HTML-encoded.
     */
    public $encodeLabel = true;
    /**
     * @var string default css class for badge
     */
    public $defaultClass = 'badge';

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
        return Html::tag($this->tagName, $this->encodeLabel ? Html::encode($this->label) : $this->label, $this->options);
    }
}
