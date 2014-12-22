<?php
/**
 * Deals with project calendar level aspects.
 */
namespace Aspose\Cloud\Tasks;

use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Common\Utils;
use Aspose\Cloud\Exception\AsposeCloudException as Exception;
use Aspose\Cloud\Storage\Folder;

class Calendar
{

    public $fileName = '';

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Get project calendar items. Each calendar item has a link to get full
     * calendar representation in the project.
     *
     * @return array Returns the calendar items.
     * @throws Exception
     */
    public function getCalendars()
    {
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

    /**
     * Get project calendar.
     *
     * @param integer $calendarUid The uid of the project calendar.
     *
     * @return array Returns the calendar.
     * @throws Exception
     */
    public function getCalendar($calendarUid)
    {
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

    /**
     * Delete a project calendar.
     *
     * @param integer $calendarUid The uid of the project calendar.
     * @param string $changedFileName The name of the project document to save changes to. If this parameter is omitted then the changes will be saved to the source project document.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function deleteCalendar($calendarUid, $changedFileName)
    {
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
        } else
            return $v_output;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

}