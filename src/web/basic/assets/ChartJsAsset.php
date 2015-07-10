<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Гузалия
 * Date: 06.07.15
 * Time: 2:38
 * To change this template use File | Settings | File Templates.
 */

namespace app\assets;


use yii\web\AssetBundle;

class ChartJsAsset extends AssetBundle{
    public $sourcePath = '@bower/chartjs';

    //public $basePath = "@webroot";

    //public $baseUrl = "@web";

    public $jsOptions = ['position' => \yii\web\View::POS_END];

    public function init() {
        $this->js = YII_DEBUG ? ['Chart.js'] : ['Chart.min.js'];
    }
}