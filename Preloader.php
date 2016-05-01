<?php namespace altiore\materialize;

use yii\helpers\Html;

/**
 * Button renders a materialize button.
 *
 * For example,
 *
 * ```php
 * echo Preloader::widget([
 *     'color' => 'red' // 'red', 'blue', 'yellow', 'green'
 * ]);
 * ```
 * or
 *
 * ```php
 * echo Preloader::widget([
 *     'color' => ['red', 'blue', 'yellow', 'green']
 * ]);
 * ```
 * @see http://materializecss.com/preloader.html
 * @author altiore <altiore@altiore.name>
 * @since 2.0
 */
class Preloader extends Widget
{
    /**
     * @var string the tag to use to render the button
     */
    public $color = 'blue';
    /**
     * @var string default css class for button
     */
    public $defaultClass = 'preloader-wrapper active';

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
        MaterializeAsset::register($this->getView());
        return Html::tag('div', $this->renderItems(), $this->options);
    }

    /**
     * Generates the preloader items that compound the group as specified on [[preloader]].
     * @return string the rendering result.
     */
    protected function renderItems()
    {
        $items = [];
        if (is_array($this->color)) {
            $items = [];
            foreach ($this->color as $color) {
                $items[] = $this->renderItem($color);
            }
        } else {
            $items[] = $this->renderItem($this->color . '-only');
        }

        return implode("\n", $items);
    }

    /**
     * Generates the preloader item.
     * @return string the rendering result.
     */
    protected function renderItem($color)
    {
        return Html::tag('div', (
            Html::tag('div', Html::tag('div', '', ['class' => 'circle']), ['class' => 'circle-clipper left'])
            . Html::tag('div', Html::tag('div', '', ['class' => 'circle']), ['class' => 'gap-patch'])
            . Html::tag('div', Html::tag('div', '', ['class' => 'circle']), ['class' => 'circle-clipper right'])
        ), ['class' => 'spinner-layer spinner-' . $color]);
    }
}
