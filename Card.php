<?php
/**
 * Created by PhpStorm.
 * User: p0larbeer
 * Date: 10.07.15
 * Time: 12:37
 */

namespace altiore\materialize;

use yii\helpers\Html;

/**
 * Button renders a materialize button.
 *
 * For example,
 *
 * ```php
 * echo Card::widget([
 *     'title' => 'Title',
 *     'content' => 'Content',
 * ]);
 * ```
 * @see http://materializecss.com/cards.html
 * @author p0larbeer
 * @since 2.0
 */
class Card extends Widget
{
    /**
     * @var string src for render image block
     */
    public $image;
    /**
     * @var string the title of card
     */
    public $title;
    /**
     * @var boolean whether to show title section.     *
     */
    public $renderTitle = true;
    /**
     * @var string html code to render on content block of card
     */
    public $content;
    /**
     * @var string html code to render on action block of card;
     */
    public $action;
    /**
     * @var boolean whether the content should be HTML-encoded.
     */
    public $encodeContent = true;
    /**
     * @var boolean whether the action should be HTML-encoded.
     */
    public $encodeAction = true;
    /**
     * @var boolean whether the title should be HTML-encoded.
     */
    public $encodeTitle = true;
    /**
     * @var string default css class for card
     */
    public $defaultClass = 'card';

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
        //return Html::tag($this->tagName, $this->encodeLabel ? Html::encode($this->label) : $this->label, $this->options);
        $html = '';
        if ($this->image !== null) {
            $html .= $this->renderImage();
        }
        if ($this->content !== null) {
            $html .= $this->renderContent();
        }
        if ($this->action !== null) {
            $html .= $this->renderAction();
        }
        if ($this->defaultClass) {
            Html::addCssClass($this->options, $this->defaultClass);
        }
        return Html::tag('div', $html, $this->options);
    }

    /**
     * Renders the title.
     * @return string the rendering result.
     */
    public function renderTitle()
    {
        return Html::tag(
            'span',
            $this->encodeTitle ? Html::encode($this->title) : $this->title,
            ['class' => 'card-title']
        );
    }

    /**
     * Renders the action.
     * @return string the rendering result.
     */
    public function renderAction()
    {
        return Html::tag(
            'div',
            $this->encodeAction ? Html::encode($this->action) : $this->action,
            ['class' => 'card-action']
        );
    }

    /**
     * Renders the image.
     * @return string the rendering result.
     */
    public function renderImage()
    {
        $html = Html::img($this->image);
        if ($this->renderTitle) {
            $html .= $this->renderTitle();
        }
        return Html::tag(
            'div',
            $html,
            ['class' => 'card-image']
        );
    }

    /**
     * Renders the content.
     * @return string the rendering result.
     */
    public function renderContent()
    {
        if ($this->renderTitle) {
            $this->encodeContent = false;
        }
        if ($this->image === null) {
            $title = $this->renderTitle();
        } else {
            $title = '';
        }
        return Html::tag(
            'div',
            $this->encodeContent ? Html::encode($title . $this->content) : $title . $this->content,
            ['class' => 'card-content']
        );
    }

}

