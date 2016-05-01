<?php namespace altiore\materialize;

use yii\helpers\Html;

/**
 * Badge renders a materialize button.
 *
 * For example,
 *
 * ```php
 * echo Progress::widget([
 *     'percent' => 70,
 *     'options' => ['class' => 'red'],
 * ]);
 * ```
 * or
 *
 * ```php
 * echo Progress::widget([
 *     'determinate' => false,
 *     'options' => ['class' => 'red'],
 * ]);
 * ```
 * @see http://materializecss.com/preloader.html
 * @author altiore <altiore@altiore.name>
 * @since 2.0
 */
class Progress extends Widget
{
    /**
     * @var integer the percent of progress
     */
    public $percent = 0;
    /**
     * @var bool the determinate or indeterminate progress
     */
    public $determinate = true;
    /**
     * @var array the HTML attributes for the widget container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $wrapOptions = [];

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        $this->clientOptions = false;
        Html::addCssClass($this->wrapOptions, 'progress');
        if ($this->determinate)
            Html::addCssClass($this->options, 'determinate');
        else
            Html::addCssClass($this->options, 'indeterminate');

        if ($this->percent) {
            if (!isset($this->options['style'])) {
                $this->options['style'] = 'width: ' . $this->percent . '%';
            } else {
                $this->options['style'] = explode(';', trim($this->options['style'], ';'));
                $this->options['style'][] = 'width: ' . $this->percent . '%;';
                $this->options['style'] = implode(';', $this->options['style']);
            }
        }
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        return Html::tag('div', Html::tag('div', '', $this->options), $this->wrapOptions);
    }
}
