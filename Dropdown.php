<?php namespace altiore\materialize;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Dropdown renders a Materialize dropdown menu component.
 *
 * For example,
 *
 * ```php
 * echo Dropdown::widget([
 *     'items' => [
 *         ['label' => 'DropdownA', 'url' => '/'],
 *         ['label' => 'DropdownB', 'url' => '#'],
 *     ],
 * ]);
 * ```
 * @see http://materializecss.com/dropdown.html
 * @author altiore <altiore@altiore.name>
 * @since 2.0
 */
class Dropdown extends Widget
{
    /**
     * @var string the tag to use to render the button
     */
    public $buttontagName = 'a';
    /**
     * @var string the button label
     */
    public $buttonLabel = 'Dropdown';
    /**
     * @var boolean whether the label should be HTML-encoded.
     */
    public $buttonEncodeLabel = true;
    /**
     * @var array the HTML attributes of the button.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $buttonOptions = [];
    /**
     * @var array list of menu items in the dropdown. Each array element can be either an HTML string,
     * or an array representing a single menu with the following structure:
     *
     * - label: string, required, the label of the item link
     * - url: string|array, optional, the url of the item link. This will be processed by [[Url::to()]].
     *   If not set, the item will be treated as a menu header when the item has no sub-menu.
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item link.
     * - options: array, optional, the HTML attributes of the item.
     * - items: array, optional, the submenu items. The structure is the same as this property.
     *
     * To insert divider use `<li class="divider"></li>`.
     */
    public $items = [];
    /**
     * @var boolean whether the labels for header items should be HTML-encoded.
     */
    public $encodeLabels = true;

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, 'dropdown-content');
        Html::addCssClass($this->buttonOptions, 'btn');
        Html::addCssClass($this->buttonOptions, 'dropdown-button');
        $this->buttonOptions['id'] = $this->id . '-btn';
        $this->buttonOptions['data-activates'] = $this->id;
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerClientEvents();
        $this->getView()->registerJs("
$('#{$this->id}-btn').dropdown({
      inDuration: 300,
      outDuration: 225,
      constrain_width: false, // Does not change width of dropdown to that of the activator
      hover: false, // Activate on click
      alignment: 'left', // Aligns dropdown to left or right edge (works with constrain_width)
      gutter: 0, // Spacing from edge
      belowOrigin: false // Displays dropdown below the button
});
        ");
        if ($this->buttonLabel !== null) {
            return Html::tag($this->buttontagName, $this->buttonLabel, $this->buttonOptions) . $this->renderItems($this->items, $this->options);
        } else {
            return $this->renderItems($this->items, $this->options);
        }
    }

    /**
     * Renders menu items.
     * @param array $items the menu items to be rendered
     * @param array $options the container HTML attributes
     * @return string the rendering result.
     * @throws InvalidConfigException if the label option is not specified in one of the items.
     */
    protected function renderItems($items, $options = [])
    {
        $lines = [];
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            if (is_string($item)) {
                $lines[] = $item;
                continue;
            }
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $itemOptions = ArrayHelper::getValue($item, 'options', []);
            $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
            $linkOptions['tabindex'] = '-1';
            $url = array_key_exists('url', $item) ? $item['url'] : null;
            if (empty($item['items'])) {
                if ($url === null) {
                    $content = $label;
                    Html::addCssClass($itemOptions, 'dropdown-header');
                } else {
                    $content = Html::a($label, $url, $linkOptions);
                }
            } else {
                $submenuOptions = $options;
                unset($submenuOptions['id']);
                $content = Html::a($label, $url === null ? '#' : $url, $linkOptions)
                    . $this->renderItems($item['items'], $submenuOptions);
                Html::addCssClass($itemOptions, 'dropdown-submenu');
            }

            $lines[] = Html::tag('li', $content, $itemOptions);
        }

        return Html::tag('ul', implode("\n", $lines), $options);
    }
}
