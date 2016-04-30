<?php namespace altiore\materialize;

use yii\helpers\Html;

/**
 * Button renders a materialize button.
 *
 * For example,
 *
 * ```php
 * echo Collection::widget([
 *     'options' => [
 *         'class' => 'with-header',
 *     ],
 *     'items' => [
 *         ['label' => Html::tag('h4', 'header'), 'type' => 'header'],
 *         ['label' => 'test'],
 *         ['label' => 'test2'],
 *     ],
 * ]);
 * ```
 * or
 *
 * ```php
 * echo Collection::widget([
 *     'tagName' => 'div',
 *     'itemTagName' => 'a',
 *     'items' => [
 *         ['label' => 'test', 'options' => ['href' => '/']],
 *         ['label' => 'test2', 'options' => ['href' => '/', 'class' => 'active']],
 *         ['label' => 'test3', 'options' => ['href' => '/']],
 *     ],
 * ]);
 * ```
 * @see http://materializecss.com/collections.html
 * @author altiore <altiore@altiore.name>
 * @since 2.0
 */
class Collection extends Widget
{
    /**
     * @var string the tag to use to render the collection
     */
    public $tagName = 'ul';
    /**
     * @var array list of items. Each array element represents a single item
     * which can be specified as a string or an array of the following structure:
     *
     * - label: string, required, the button label.
     * - options: array, optional, the HTML attributes of the button.
     */
    public $items = [];
    /**
     * @var string the tag to use to render the collection item
     */
    public $itemTagName = 'li';
    /**
     * @var boolean whether to HTML-encode the item labels.
     */
    public $encodeLabels = true;
    /**
     * @var string default css class for collection
     */
    public $defaultClass = 'collection';

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
        return Html::tag($this->tagName, $this->renderItems(), $this->options);
    }

    /**
     * Generates the buttons that compound the group as specified on [[buttons]].
     * @return string the rendering result.
     */
    protected function renderItems()
    {
        $buttons = [];
        foreach ($this->items as $item) {
            if (is_array($item)) {
                $item['view'] = $this->getView();
                if (!isset($item['tagName'])) {
                    $item['tagName'] = $this->itemTagName;
                }
                if (!isset($item['encodeLabel'])) {
                    $item['encodeLabel'] = $this->encodeLabels;
                }
                if (!isset($item['type'])) {
                    Html::addCssClass($item['options'], 'collection-item');
                } else {
                    Html::addCssClass($item['options'], 'collection-' . $item['type']);
                }
                if (!isset($item['options'])) {
                    $item['options'] = [];
                }

                $items[] = Html::tag($item['tagName'], $item['label'], $item['options']);
            } else {
                $items[] = $item;
            }
        }

        return implode("\n", $items);
    }
}
