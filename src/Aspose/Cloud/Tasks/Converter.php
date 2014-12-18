<?php
/**
 * Converts document into different formats.
 */
namespace Aspose\Cloud\Tasks;

use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Common\Utils;
use Aspose\Cloud\Exception\AsposeCloudException as Exception;

class Converter
{

    protected $fileName = '';
    protected $saveFormat = '';

    public function __construct($fileName, $saveFormat = 'mpp')
    {
        //set default values
        $this->fileName = $fileName;

        $this->saveFormat = $saveFormat;
    }

    /**
     * Convert a document to SaveFormat using Aspose storage.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function convert()
    {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');

        //build URI
        $strURI = Product::$baseProductUri . '/tasks/' . $this->fileName . '?format=' . $this->saveFormat;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            if ($this->saveFormat == 'html') {
                $save_format = 'zip';
            } else {
                $save_format = $this->saveFormat;
            }

            $outputPath = AsposeApp::$outPutLocation . Utils::getFileName($this->fileName) . '.' . $save_format;
            Utils::saveFile($responseStream, $outputPath);
            return $outputPath;
        } else {
            return $v_output;
        }
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
    }

    /**
     * @return string
     */
    public function getSaveFormat()
    {
        return $this->saveFormat;
    }

    /**
     * @param string $saveFormat
     */
    public function setSaveFormat($saveFormat)
    {
        $this->saveFormat = $saveFormat;
    }
}