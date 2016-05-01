<?php

namespace altiore\materialize;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Dropdown widget materialize
 * @author  Razzwan <a href="mailto:">razvanlomov@gmail.com</a>
 * @package altiore\materialize
 */
class Dropdown extends Widget
{
    const PLUGIN_NAME = 'dropdown';
    /**
     * Label fo dropdown list container
     * @var
     */
    public $label = 'Please configure label of widget!';
    /**
     * @var array list of menu items in the dropdown. Each array element can be either an HTML string,
     * or an array representing a single menu with the following structure:
     * - label: string, required, the label of the item link
     * - url: string|array, optional, the url of the item link. This will be processed by [[Url::to()]].
     * To insert divider use `<li class="divider"></li>`.
     */
    public $items = [];
    /**
     * If true - $this->toggleOptions add class btn
     * @var bool
     */
    public $isButton = false;
    /**
     * if true then default classes force will added
     * false - It is understood that classes will rewrite
     * @var bool
     */
    public $forceUseDefaultClasses = true;
    /**
     * default toggle html class
     * @var string
     */
    protected $defaultOptions = [
        'tag'              => 'a',
        'class'            => 'dropdown-button',
        'href'             => '#',
        'data-beloworigin' => "true",
    ];
    /**
     * Array of options of the toggle button
     * @var array
     *      example (default):
     *          [
     *              'tag'   => 'a',
     *              'class' => 'dropdown-button',
     *              'data-activates' => $this->getId(), // default activates element with id = $this->getId()
     *              'href'  => '#'  // === 'url'  => '#'
     *          ]
     */
    public $options = [];
    /**
     * default dropdown list container html class
     * @var string
     */
    protected $defaultDropdownOptions = [
        'class' => 'dropdown-content',
    ];
    /**
     * Array of options of the dropdown list container
     * @var array
     * @see $this->toggleOptions
     */
    public $dropdownOptions = [];
    /**
     * Array of client options used in configure js plugin of this widget
     * @var array
     */
    protected $defaultClientOptions = [
        //'inDuration'      => 300,
        //'outDuration'     => 225,
        'constrain_width' => true,    // Does not change width of dropdown to that of the activator
        'hover'           => false,   // Activate on hover
        //'gutter'          => 0,     // Spacing from edge
        //'belowOrigin'     => false, // Displays dropdown below the button
        //'alignment'       => 'left' // Displays dropdown with edge aligned to the left of button
    ];

    /**
     * @var string id html tag for dropdown list container
     */
    private $_dropdownId;

    /**
     * @return string id html tag for dropdown list container
     */
    public function getDropdownId()
    {
        if (empty($this->_dropdownId)) {
            $this->_dropdownId = $this->getId() . '-dropdown';
        }

        return $this->_dropdownId;
    }

    /**
     * Set id html tag for dropdown list container
     * @param $value string
     */
    public function setDropdownId($value)
    {
        $this->_dropdownId = $value;
    }

    /**
     * added default options to user settings
     */
    public function init()
    {
        parent::init();
        $this->addDefaultOptions($this->options, $this->defaultOptions, $this->forceUseDefaultClasses);
        $this->addDefaultOptions($this->dropdownOptions, $this->defaultDropdownOptions, $this->forceUseDefaultClasses);
        $this->addDefaultOptions($this->clientOptions, $this->defaultClientOptions);
        $this->dropdownOptions['id'] = $this->options['data-activates'] = $this->getDropdownId();
        if ($this->isButton) {
            Html::addCssClass($this->options, 'btn');
        }
    }

    /**
     * render widget
     */
    public function run()
    {
        echo Html::tag(
            ArrayHelper::remove($this->options, 'tag', 'a'),
            $this->label,
            $this->options
        );
        echo Html::beginTag(
            'ul',
            $this->dropdownOptions
        );
        $this->renderItems();
        echo Html::endTag('ul');
        $this->registerPlugin(static::PLUGIN_NAME);
    }

    /**
     * Render items
     * @throws InvalidConfigException
     */
    protected function renderItems()
    {
        foreach ($this->items as $item) {
            if (is_string($item)) {
                echo $item;
            } elseif (is_array($item)) {
                if (!array_key_exists('label', $item)) {
                    throw new InvalidConfigException("The 'label' option is required.");
                }
                if (array_key_exists('url', $item) && $item['url'] === Yii::$app->request->getUrl()) {
                    if (!empty($item['options'])) {
                        Html::addCssClass($item['itemOptions'], 'active');
                    } else {
                        $item['itemOptions'] = ['class' => 'active'];
                    }
                }
                echo Html::tag(
                    'li',
                    Html::a(
                        $item['label'],
                        empty($item['url']) ? null : $item['url'],
                        empty($item['linkOptions']) ? [] : $item['linkOptions']
                    ),
                    empty($item['itemOptions']) ? [] : $item['itemOptions']
                );
            }
        }
    }
}
