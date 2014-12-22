<?php
/**
 * Converts pages or document into different formats.
 */
namespace Aspose\Cloud\Slides;

use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Common\Utils;
use Aspose\Cloud\Exception\AsposeCloudException as Exception;

class Converter
{

    public $fileName = '';
    public $saveFormat = '';

    public function __construct($fileName, $saveFormat = 'PPT')
    {
        //set default values
        $this->fileName = $fileName;

        $this->saveFormat = $saveFormat;
    }

    /**
     * Saves a particular slide into various formats with specified width and height.
     *
     * @param integer $slideNumber The number of slide.
     * @param string $imageFormat The image format.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function convertToImage($slideNumber, $imageFormat)
    {


        $strURI = Product::$baseProductUri . '/slides/' . $this->getFileName() . '/slides/' . $slideNumber . '?format=' . $imageFormat;

        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output == '') {
            $outputPath = AsposeApp::$outPutLocation . Utils::getFileName($this->getFileName()) . '.' . $imageFormat;
            Utils::saveFile($responseStream, $outputPath);
            return $outputPath;
        } else {
            return $v_output;
        }
    }

    /**
     * Convert a particular slide into various formats with specified width and height.
     *
     * @param integer $slideNumber The slide number.
     * @param string $imageFormat The image format.
     * @param integer $width The width of image.
     * @param integer $height The height of image.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function convertToImagebySize($slideNumber, $imageFormat, $width, $height)
    {


        $strURI = Product::$baseProductUri . '/slides/' . $this->getFileName() . '/slides/' . $slideNumber . '?format=' . $imageFormat . '&width=' . $width . '&height=' . $height;

        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output == '') {
            $outputPath = AsposeApp::$outPutLocation . 'output.' . $imageFormat;
            Utils::saveFile($responseStream, $outputPath);
            return $outputPath;
        } else {
            return $v_output;
        }
    }

    /**
     * Convert a document to the specified format.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function convert()
    {


        $strURI = Product::$baseProductUri . '/slides/' . $this->getFileName() . '?format=' . $this->saveFormat;

        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            if ($this->saveFormat == 'html') {
                $save_format = 'zip';
            } else {
                $save_format = $this->saveFormat;
            }
            $outputPath = AsposeApp::$outPutLocation . Utils::getFileName($this->getFileName()) . '.' . $save_format;
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
        if ($this->fileName == '') {
            throw new Exception('No File Name Specified');
        }
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
        return $this;
    }

}