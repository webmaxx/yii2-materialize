<?php namespace webmaxx\materialize;

use yii\helpers\Html;

/**
 * Icon renders a materialize icon.
 *
 * For example,
 *
 * ```php
 * echo Icon::widget([
 *     'name' => 'editor-mode-edit',
 *     'options' => ['class' => 'large'],
 * ]);
 * ```
 * @see http://materializecss.com/buttons.html
 * @author webmaxx <webmaxx@webmaxx.name>
 * @since 2.0
 */
class Icon extends Widget
{
    /**
     * @var string the tag to use to render the icon
     */
    public $tagName = 'i';
    /**
     * @var string the icon name
     */
    public $name;

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        $this->clientOptions = false;
        Html::addCssClass($this->options, 'mdi-' . $this->name);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        return Html::tag($this->tagName, '', $this->options);
    }
}
