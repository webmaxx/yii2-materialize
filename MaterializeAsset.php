<?php

namespace altiore\materialize;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Materialize javascript and css files.
 *
 * @author Razzwan <a href="mailto:">razvanlomov@gmail.com</a>
 * @since 2.0
 */
class MaterializeAsset extends AssetBundle
{
    public $sourcePath = YII_ENV_DEV ? '@bower/materialize/dist' : null;

    public $css = [
        YII_ENV_DEV ? 'css/materialize.css' :
            '//cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css',
        ['//fonts.googleapis.com/css?family=Roboto:400,300,500', 'type' => 'text/css'],

    ];

    public $js = [
        YII_ENV_DEV ? 'js/materialize.js' :
            '//cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
