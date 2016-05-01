<?php

namespace altiore\materialize;

/**
 * Class Widget
 *
 * @author Razzwan <a href="mailto:">razvanlomov@gmail.com</a>
 * @package altiore\materialize
 */
class Widget extends \yii\base\Widget
{
    use WidgetTrait;

    /**
     * @var array the HTML attributes for the widget container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
}
