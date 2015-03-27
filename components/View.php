<?php
/**
 * Created by PhpStorm.
 * User: Maslow
 * Date: 2015/3/27
 * Time: 1:23
 */
namespace app\components;

use Yii;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;
use yii\helpers\StringHelper;

/**
 * A within-class to integrate XSLT to yii2.
 * Usage:
 * Copy this file(View.php) to [@app/components/View.php] in your yii2 project.
 * ~~
 * #config.php
 * return [
 *      ...
 *      'components' =>[
 *          ...
 *          'view' => [
 *              'class'=>'app\components\View',
 *              // 'xml' => 'xmls',
 *              // 'onlyXML' => true
 *              // 'enableHack' => false
 *              //  defaultExtension => 'xsl'
 *          ],
 *          ...
 *      ];
 *      ...
 * ];
 * ~~
 * @package app\components
 */
class View extends \yii\web\View
{
    /**
     * The Name of the directory in which  xml files would be located.
     * @var string
     */
    public $xml = 'xmls';

    /**
     * @var string
     */
    public $defaultExtension = 'xsl';

    /**
     * Determine whether enable "hack" which is used for compatible with Controller::render().
     * !Important:
     *      If you stay the value of $enableHack true which is also its default value.
     *      Don't take $this to the third parameter of the method Controller::render()
     *      called $context . Please just maintain it's default value which is null.
     *
     * If you configure this to value of true , it has two ways to instead:
     * 1. To call [Controller::getView()->render()  instead of Controller::render() in your action method,
     *    your code maybe like following:
     *    ~~
     *     return $this->getView()->render('view name',$params);
     *     // instead of
     *     return $this->render('view name',$params);
     *    ~~
     * 2. Override the  Controller::render() method in your own Controller components;
     *    ~~
     *      public function render($view, $params){
     *           return $this->getView()->render($view,$params);
     *      }
     *    ~~
     *
     * @var bool
     */
    public $enableHack = true;

    /**
     * Determine whether just output xml's content without being transformed to xslt.
     * @var bool
     */
    public $onlyXML = false;

    /**
     * @return string
     * @throws ErrorException
     */
    public function getXmlLayoutFile(){
        $DS = DIRECTORY_SEPARATOR;
        $layout = 'layouts';
        if (Yii::$app->controller->layout) {
            $layout .= $DS . Yii::$app->controller->layout;
        } else {
            $layout .= $DS . 'main';
        }
        $layout = $this->getXmlPath() . $DS . $layout . '.php';
        if(!is_file($layout)) {
            throw new ErrorException('the layout file is not exist : '.$layout);
        }
        return $layout;
    }
    /**
     * @param $view
     * @throws ErrorException
     * @return string
     */
    public function getXmlFile($view)
    {
        $controller = Yii::$app->controller;
        $path = $this->getXmlPath() . DIRECTORY_SEPARATOR . $controller->id;
        $file = $path . DIRECTORY_SEPARATOR . $view . '.php';
        if(!is_file($file)){
            throw new ErrorException('the xml file is not exist : '.$file);
        }
        return $file;
    }

    /**
     * @throws ErrorException
     * @return string
     */
    public function getXmlPath()
    {
        $controller = Yii::$app->controller;
        $basePath = $controller->module->getBasePath();
        $path = $basePath . DIRECTORY_SEPARATOR . $this->xml;
        if(!file_exists($path)){
            throw new ErrorException('the xml path is not exist: '.$path);
        }
        return $path;
    }

    /**
     * @param $view
     * @throws ErrorException
     * @throws InvalidConfigException
     * @return string
     */
    public function getXsltFile($view)
    {
        $viewFile = $this->findViewFile($view, Yii::$app->controller);
        // fix defaultExtension from .php to current defaultExtension
        if (!StringHelper::endsWith($viewFile, $this->defaultExtension)) {
            $viewFile = StringHelper::dirname($viewFile);
            $viewFile = $viewFile . DIRECTORY_SEPARATOR . $view . '.' . $this->defaultExtension;
        }
        if ($this->theme) {
            $viewFile = $this->theme->applyTo($viewFile);
        }
        if(!is_file($viewFile)){
            throw new ErrorException('the xsl file is not exsit: '.$viewFile);
        }
        return $viewFile;
    }

    /**
     * @param string $view
     * @param array $params
     * @param null $context
     * @return string
     * @throws ErrorException
     */
    public function render($view, $params = [], $context = null)
    {
        $xmlContent = $this->renderFile($this->getXmlFile($view), $params);
        $xmlStr = $this->renderFile($this->getXmlLayoutFile(), ['content' => $xmlContent]);

        $xml = new \DOMDocument();
        $xsl = new \DOMDocument();
        $xslt = new \XSLTProcessor();

        $xml->loadXML($xmlStr);
        if($this->onlyXML){
            return $xml->saveXML();
        }
        $xsl->load($this->getXsltFile($view));
        $xslt->importStylesheet($xsl);
        return $xslt->transformToXml($xml);
    }

    /**
     *  Hack for compatible with Controller::render().
     *  Alternatively you can configure $enableHack to false
     *  while you render views in Controller like that:
     * ~~
     *  public function actionIndex(){
     *    return  $this->getView()->render('index',$params);
     *  }
     * ~~
     * @param string $viewFile
     * @param array $params
     * @param null $context
     * @return string
     */
    public function renderFile($viewFile, $params = [], $context = null)
    {
        if ($this->enableHack && $context) {
            return $params['content'];
        }
        return parent::renderFile($viewFile, $params, $context);
    }
}