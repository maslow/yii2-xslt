<?php
namespace common\components;

class Controller extends \yii\web\Controller
{
    public $layout = 'main.xml';
    public $extension = 'xml';
    public $xmlPath = "@frontend/xmls";

    public function render($view, $params = [])
    {
        $path = "{$this->xmlPath}/{$this->id}/{$view}.{$this->extension}";
        $content = parent::renderFile($path, $params);
        $xmlStr = parent::renderFile("{$this->xmlPath}/layouts/{$this->layout}", ['content' => $content]);

        $xml = new \DOMDocument();
        $xml->loadXML($xmlStr);

        $xsl = new \DOMDocument();
        $xsl->load($this->getView()->getViewsPath() . "/{$this->id}/{$view}.xsl");

        $xslt = new \XSLTProcessor();
        $xslt->importStylesheet($xsl);
        //return $xml->saveXML();
        return $xslt->transformToXml($xml);
    }

    /**
     * @return \common\components\View|\yii\web\View
     */
    public function getView()
    {
        return parent::getView();
    }
}