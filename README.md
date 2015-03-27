
# yii2-xslt

View component to integrate xslt with yii2.

  A within-class to integrate XSLT to yii2.
  
  Usage:
  
  Copy this file(View.php) to [@app/components/View.php] in your yii2 project.
 
  #config.php
  
    return [
       ...
       
       'components' =>[
       
           ...
           
           'view' => [
           
               'class'=>'app\components\View',
               
               // 'xml' => 'xmls',
               
               // 'onlyXML' => true
               
               // 'enableHack' => false
               
               //  defaultExtension => 'xsl'
               
           ],
           
           ...
           
       ];
       
       ...
    ];
  
 
 
