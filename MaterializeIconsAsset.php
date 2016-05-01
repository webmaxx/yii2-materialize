<?php

namespace altiore\materialize;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Materialize icons file.
 *
 * @author Razzwan <a href="mailto:">razvanlomov@gmail.com</a>
 * @package altiore\materialize
 */
class MaterializeIconsAsset extends AssetBundle
{
    public $sourcePath = null;

    public $css = [
        '//fonts.googleapis.com/icon?family=Material+Icons',
    ];

}
