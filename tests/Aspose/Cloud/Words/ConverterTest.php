<?php

use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Words\Converter;

class ConverterTest extends PHPUnit_Framework_TestCase {
    
    protected $object;

    protected function setUp()
    {        
        Product::$baseProductUri = $_SERVER['BASE_PRODUCT_URI'];
        AsposeApp::$appSID = $_SERVER['APP_SID'];
        AsposeApp::$appKey = $_SERVER['APP_KEY'];
        AsposeApp::$outPutLocation = getcwd(). '/Data/Output/';

        $this->object = new Converter('Test.docx');
    } 
    
    public function testConvert()
    {  
        $this->object->saveFormat = 'pdf';
        $this->object->convert();
        $this->assertFileExists(getcwd(). '/Data/Output/Test.pdf');
    }
    
    public function testConvertLocalFile()
    {
        $inputPath = getcwd() . '/Data/Input/MyFile.docx';
        $outputPath = '';
        $outputFormat = 'pdf';
        $this->object->convertLocalFile($inputPath, $outputPath, $outputFormat);
        $this->assertFileExists(getcwd(). '/Data/Output/MyFile.pdf');
    }   
    
}