<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Гузалия
 * Date: 06.07.15
 * Time: 3:02
 * To change this template use File | Settings | File Templates.
 */

namespace app\assets\views;


use yii\web\AssetBundle;

class SiteIndexAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $jsOptions = ['position' => \yii\web\View::POS_END];

    public $js = [
        'js/views/site-index.view.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'app\assets\ChartJsAsset',
    ];
}