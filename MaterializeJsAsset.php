<?php namespace webmaxx\materialize;
use yii\web\AssetBundle;
/**
 * Asset bundle for the Materialize css files.
 *
 * @author webmaxx <webmaxx@webmaxx.name>
 * @since 2.0
 */
class MaterializeJsAsset extends AssetBundle
{
    public $sourcePath = '@bower/materialize/dist';
    public $js = [
        'js/materialize.js',
    ];
}
