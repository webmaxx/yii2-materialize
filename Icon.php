<?php namespace altiore\materialize;

use yii\helpers\Html;

/**
 * Icon renders a materialize icon.
 *
 * For example,
 *
 * ```php
 * echo Icon::widget([
 *     'name' => 'grade',
 *     'size' => 'large',
 * ]);
 * ```
 *
 * or
 *
 * ```php
 * echo Icon::show('grade', 'large');
 * ```
 * @see http://materializecss.com/icons.html
 * @author altiore <altiore@altiore.name>
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
     * @var string the icon size (tiny, small, medium or large)
     */
    public $size = '';

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        $this->clientOptions = false;
        Html::addCssClass($this->options, $this->size);
        Html::addCssClass($this->options, 'material-icons');
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        return Html::tag($this->tagName, $this->name, $this->options);
    }

    /**
     * Render icon.
     */
    public static function show($name, $size='', $class = '')
    {
        return self::widget(['name' => $name, 'size' => $size, 'options' => [
            'class' => $class,
        ]]);
    }
}
