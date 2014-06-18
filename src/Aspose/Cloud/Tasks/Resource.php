<?php
/*
 * Deals with Project Resource level aspects
 */ 
namespace Aspose\Cloud\Tasks;

use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Utils;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Storage\Folder;
use Aspose\Cloud\Exception\AsposeCloudException as Exception;

class Resource {

    public $fileName = '';

    public function __construct($fileName) {
        $this->fileName = $fileName;
    }

    /*
     * Get all resources 
     */
    public function getResources() {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/resources/';

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);
        
        if ($json->Code == 200)
            return $json->Resources->ResourceItem;
        else
            return false;
    }
    
    /*
     * Get resource information 
     * @param integer $resourceId
     */
    public function getResource($resourceId) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($resourceId == '')
            throw new Exception('Resource ID not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/resources/' . $resourceId;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return $json->Resource;
        else
            return false;
    }

    /*
     * Add new resource
     * @param string $resourceName
     * @param integer $afterResourceId
     * @param string $changedFileName
     */
    public function addResource($resourceName, $afterResourceId, $changedFileName) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($resourceName == '')
            throw new Exception('Resource Name not specified');

        if ($afterResourceId == '')
            throw new Exception('Resource ID not specified');

        //build URI 
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/resources?resourceName=' . $resourceName . '&afterResourceId=' . $afterResourceId;
        if ($changedFileName != '') {
            $strURI .= '&fileName=' . $changedFileName;
            $this->fileName = $changedFileName;
        }    

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'POST', '', '');
        
        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            $folder = new Folder();
            $outputStream = $folder->GetFile($this->fileName);
            $outputPath = AsposeApp::$outPutLocation . $this->fileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        }
        else
            return $v_output;
    }
    
    /*
     * Delete Resource
     * @param integer $resourceId
     * @param string $changedFileName
     */
    public function deleteResource($resourceId, $changedFileName) {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($resourceId == '')
            throw new Exception('Resource ID not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/resources/' . $resourceId;
        if ($changedFileName != '') {
            $strURI .= '?fileName=' . $changedFileName;
            $this->fileName = $changedFileName;
        }    

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'DELETE', '', '');
        
        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            $folder = new Folder();
            $outputStream = $folder->GetFile($this->fileName);
            $outputPath = AsposeApp::$outPutLocation . $this->fileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        }
        else
            return $v_output;
    }
    
}