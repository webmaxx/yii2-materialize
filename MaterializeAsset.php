<?php namespace altiore\materialize;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Materialize javascript files.
 *
 * @author altiore <altiore@altiore.name>
 * @since 2.0
 */
class MaterializeAsset extends AssetBundle
{
    public $sourcePath = YII_ENV_DEV ? '@bower/materialize/dist' : null;

    public $css = [
        YII_ENV_DEV ? 'css/materialize.min.css' :
            '//cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css',
    ];

    public $js = [
        YII_ENV_DEV ? 'js/materialize.min.js' :
            '//cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
