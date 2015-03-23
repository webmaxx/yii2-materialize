<?php namespace webmaxx\materialize;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Materialize javascript files.
 *
 * @author webmaxx <webmaxx@webmaxx.name>
 * @since 2.0
 */
class MaterializePluginAsset extends AssetBundle
{
    public $sourcePath = '@bower/materialize/dist';
    public $js = [
        'js/materialize.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'webmaxx\materialize\MaterializeAsset',
    ];
}
