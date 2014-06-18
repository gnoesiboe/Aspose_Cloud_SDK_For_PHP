<?php
/*
 * Deals with Project Assignment level aspects
 */ 
namespace Aspose\Cloud\Tasks;

use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Utils;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Storage\Folder;
use Aspose\Cloud\Exception\AsposeCloudException as Exception;

class Assignment {

    public $fileName = '';

    public function __construct($fileName) {
        $this->fileName = $fileName;
    }

    /*
     * Get all assignments 
     */
    public function getAssignments() {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/assignments/';

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);
        
        if ($json->Code == 200)
            return $json->Assignments->AssignmentItem;
        else
            return false;
    }
    
    /*
     * Get assignment information 
     * @param integer $assignmentId
     */
    public function getAssignment($assignmentId) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($assignmentId == '')
            throw new Exception('Assignment ID not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/assignments/' . $assignmentId;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);
        
        if ($json->Code == 200)
            return $json->Assignment;
        else
            return false;
    }

    /*
     * Add Assignment
     * @param integer $taskUid
     * @param integer $resourceUid
     * @param double $units
     * @param string $changedFileName
     */
    public function addAssignment($taskUid, $resourceUid, $units, $changedFileName = '') {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($taskUid == '')
            throw new Exception('Task Uid not specified');

        if ($resourceUid == '')
            throw new Exception('Resource Uid not specified');

        //build URI 
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/assignments?taskUid=' . $taskUid . '&resourceUid=' . $resourceUid . '&units' . $units;
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
     * Delete Assignment
     * @param integer $assignmentUid
     * @param string $changedFileName
     */
    public function deleteAssignment($assignmentUid, $changedFileName) {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($assignmentUid == '')
            throw new Exception('Assignment Uid not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/assignments/' . $assignmentUid;
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