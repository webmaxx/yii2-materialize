<?php namespace altiore\materialize;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * NavBar renders a navbar HTML component.
 *
 * Any content enclosed between the [[begin()]] and [[end()]] calls of NavBar
 * is treated as the content of the navbar. You may use widgets such as [[Nav]]
 * or [[\yii\widgets\Menu]] to build up such content. For example,
 *
 * ```php
 * use altiore\materialize\Nav;
 * use altiore\materialize\NavBar;
 *
 * NavBar::begin(['brandLabel' => 'NavBar Test']);
 * echo Nav::widget([
 *     'items' => [
 *         ['label' => 'Home', 'url' => ['/site/index']],
 *         ['label' => 'About', 'url' => ['/site/about']],
 *     ],
 * ]);
 * NavBar::end();
 * ```
 * @see http://materializecss.com/navbar.html
 * @author altiore <altiore@altiore.name>
 * @since 2.0
 */
class NavBar extends Widget
{
    const DEFAULT_OPTIONS = 'blue-grey darken-2';
    const DEFAULT_WRAPPER_CONTAINER_OPTIONS = 'nav-wrapper container';
    /**
     * @var array the HTML attributes for the widget container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "nav", the name of the container tag.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
    /**
     * @var string|boolean the text of the brand of false if it's not used. Note that this is not HTML-encoded.
     */
    public $brandLabel = false;
    /**
     * @param array|string|boolean $url the URL for the brand's hyperlink tag. This parameter will be processed by [[Url::to()]]
     * and will be used for the "href" attribute of the brand link. Default value is false that means
     * [[\yii\web\Application::homeUrl]] will be used.
     */
    public $brandUrl = false;
    /**
     * @var array the HTML attributes of the brand link.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $brandOptions = [];
    /**
     * @var boolean if true, then navbar fixed on scroll
     */
    public $fixed = false;
    /**
     * @var array the HTML attributes of the fixed container.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $fixedContainerOptions = [];
    /**
     * @var array the HTML attributes of the wrapper container.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $wrapperContainerOptions = [];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $this->clientOptions = false;
        if (empty($this->options['class'])) {
            Html::addCssClass($this->options, self::DEFAULT_OPTIONS);
        }
        if (empty($this->options['role'])) {
            $this->options['role'] = 'navigation';
        }
        if (empty($this->wrapperContainerOptions['class'])) {
            Html::addCssClass($this->wrapperContainerOptions, self::DEFAULT_WRAPPER_CONTAINER_OPTIONS);
        }
        $this->clientOptions = false;
        if ($this->fixed) {
            if (!isset($this->fixedContainerOptions['class'])) {
                Html::addCssClass($this->fixedContainerOptions, 'navbar-fixed');
            }
            echo Html::beginTag('div', $this->fixedContainerOptions);
        }
        Html::addCssClass($this->brandOptions, 'brand-logo');
        $tag = ArrayHelper::remove($this->options, 'tag', 'nav');
        echo Html::beginTag($tag, $this->options);
        echo Html::beginTag('div', $this->wrapperContainerOptions);
        if ($this->brandLabel !== false) {
            Html::addCssClass($this->brandOptions, 'brand-logo');
            echo Html::a(
                $this->brandLabel,
                $this->brandUrl === false ? Yii::$app->homeUrl : $this->brandUrl,
                $this->brandOptions
            );
        }
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $tag = ArrayHelper::remove($this->options, 'tag', 'nav');
        echo Html::endTag($tag, $this->options);
        if ($this->fixed) {
            echo Html::endTag('div');
        }
    }
}
