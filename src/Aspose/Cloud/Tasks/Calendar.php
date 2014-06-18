<?php
/*
 * Deals with Project Calendar level aspects
 */ 
namespace Aspose\Cloud\Tasks;

use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Utils;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Storage\Folder;
use Aspose\Cloud\Exception\AsposeCloudException as Exception;

class Calendar {

    public $fileName = '';

    public function __construct($fileName) {
        $this->fileName = $fileName;
    }

    /*
     * Get Calendars
     */
    public function getCalendars() {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/calendars/';

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);
        
        if ($json->Code == 200)
            return $json->Calendars->List;
        else
            return false;
    }
    
    /*
     * Get calendar information 
     * @param integer $calendarUid
     */
    public function getCalendar($calendarUid) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($calendarUid == '')
            throw new Exception('Calendar Uid not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/calendars/' . $calendarUid;
        
        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);
        
        if ($json->Code == 200)
            return $json->Calendar;
        else
            return false;
    }

    /*
     * Delete calendar
     * @param integer $calendarUid
     * @param string $changedFileName
     */
    public function deleteCalendar($calendarUid, $changedFileName) {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('Base file not specified');

        if ($calendarUid == '')
            throw new Exception('Calendar Uid not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '/calendars/' . $calendarUid;
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