<?php
namespace common\components;

use yii\helpers\Url;
use \Yii;
class View extends \yii\web\View
{
    public $themeName = "basic";

    public function getAssetsBaseUrl()
    {
        $assetsPath = $this->getAssetsPath();
        $rs = \Yii::$app->assetManager->publish($assetsPath);
        return $rs[1];
    }

    /**
     * @return \common\components\Controller
     */
    public function getController(){
        return $this->context;
    }

    public function getAssetsPath()
    {
        return $this->getViewsPath()."/assets";
    }

    public function getViewsPath()
    {
        return \Yii::getAlias("@app/themes/{$this->themeName}");
    }

    public function to($url){
        return Url::to($url);
    }

    public function getCsrfToken()
    {
        return Yii::$app->request->getCsrfToken();
    }

    public function getCsrfParam()
    {
        return Yii::$app->request->csrfParam;
    }

} 