<?php

use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Imaging\Image;

class ImageTest extends PHPUnit_Framework_TestCase {
    
    protected $image;

    protected function setUp()
    {        
        Product::$baseProductUri = $_SERVER['BASE_PRODUCT_URI'];
        AsposeApp::$appSID = $_SERVER['APP_SID'];
        AsposeApp::$appKey = $_SERVER['APP_KEY'];
        AsposeApp::$outPutLocation = getcwd(). '/Data/Output/';

        $this->image = new Image('Test.tiff');
    } 
        
    public function testConvertTiffToFax()
    {  
        $this->image->convertTiffToFax();
        $this->assertFileExists(getcwd(). '/Data/Output/Test.tiff');
    }
    
    public function testAppendTiff()
    {  
        $this->image->appendTiff('Append.tiff');
        $this->assertFileExists(getcwd(). '/Data/Output/Append.tiff');
    }
    
}    