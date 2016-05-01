<?php

namespace altiore\materialize;

use \yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class WidgetTrait
 *
 * @author  Razzwan <razvanlomov@gmail.com>
 * @package altiore\materialize
 */
trait WidgetTrait
{
    /**
     * @var array the options for the underlying Bootstrap JS plugin.
     * Please refer to the corresponding Bootstrap plugin Web page for possible options.
     * For example, [this page](http://getbootstrap.com/javascript/#modals) shows
     * how to use the "Modal" plugin and the supported options (e.g. "remote").
     */
    public $clientOptions = [];
    /**
     * @var array the event handlers for the underlying Bootstrap JS plugin.
     * Please refer to the corresponding Bootstrap plugin Web page for possible events.
     * For example, [this page](http://getbootstrap.com/javascript/#modals) shows
     * how to use the "Modal" plugin and the supported events (e.g. "shown").
     */
    public $clientEvents = [];

    /**
     * Initializes the widget.
     * This method will register the bootstrap asset bundle. If you override this method,
     * make sure you call the parent implementation first.
     */
    public function init()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }

    /**
     * Registers a specific Bootstrap plugin and the related events
     * @param string $name the name of the Bootstrap plugin
     */
    protected function registerPlugin($name)
    {
        $view = $this->getView();

        $id = $this->options['id'];

        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '' : Json::htmlEncode($this->clientOptions);
            $js = "jQuery('#$id').$name($options);";
            $view->registerJs($js);
        }

        $this->registerClientEvents();
    }

    /**
     * Registers JS event handlers that are listed in [[clientEvents]].
     * @since 2.0.2
     */
    protected function registerClientEvents()
    {
        if (!empty($this->clientEvents)) {
            $id = $this->options['id'];
            $js = [];
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "jQuery('#$id').on('$event', $handler);";
            }
            $this->getView()->registerJs(implode("\n", $js));
        }
    }

    /**
     * Added default options to array options
     *
     * @param      $options
     * @param      $defaultOptions
     * @param bool $forceUseDefaultClasses
     * @return array
     */
    protected function addDefaultOptions(&$options, $defaultOptions, $forceUseDefaultClasses = false)
    {
        if ($forceUseDefaultClasses) {
            Html::addCssClass($options, ArrayHelper::remove($defaultOptions, 'class', ''));
        }
        if (isset($options['url'])) {
            $options['href'] = ArrayHelper::remove($options, 'url');
        }
        return $options = ArrayHelper::merge($defaultOptions, $options);
    }
}
