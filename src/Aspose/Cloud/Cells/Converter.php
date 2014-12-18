<?php
/**
 * Converts pages or document into different formats.
 */
namespace Aspose\Cloud\Cells;

use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Utils;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Exception\AsposeCloudException as Exception;

class Converter {

    protected $fileName = '';
    protected $worksheetName = '';
    protected $saveFormat = '';

	public function __construct() {
		$parameters = func_get_args();

		//set default values
		if (isset($parameters[0])) {
			$this->fileName = $parameters[0];
		}
		if (isset($parameters[1])) {
			$this->worksheetName = $parameters[1];
		}
		$this->saveFormat = 'xls';
	}

	/**
	 * Converts a document to saveformat using Aspose cloud storage.
         * 
         * @return string Returns the file path.
         * @throws Exception
	 */
	public function convert() {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        //Build URI
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '?format=' . $this->saveFormat;
        //Sign URI
        $signedURI = Utils::sign($strURI);
        //Send request and receive response stream
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        //Validate output
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output === '') {
            if ($this->saveFormat == 'html') {
                $saveFormat = 'zip';
            } else {
                $saveFormat = $this->saveFormat;
            }
            $outputPath = Utils::saveFile($responseStream, AsposeApp::$outPutLocation . Utils::getFileName($this->fileName) . '.' . $saveFormat);
            return $outputPath;
        } else {
            return $v_output;
        }
	}

	/**
	 * Converts a sheet to image.
         * 
	 * @param string $worksheetName Name of the sheet.
	 * @param string $imageFormat Returns image in the specified format.
         * 
         * @return string Returns the file path.
         * @throws Exception
	 */
	public function convertToImage($imageFormat, $worksheetName) {
        //check whether file and sheet is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        //Build URI
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '/worksheets/' . $worksheetName . '?format=' . $imageFormat;
        //Sign URI
        $signedURI = Utils::sign($strURI);
        //Send request and receive response stream
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        //Validate output
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output === '') {
            //Save ouput file
            $outputPath = AsposeApp::$outPutLocation . Utils::getFileName($this->fileName) . '_' . $worksheetName . '.' . $imageFormat;
            Utils::saveFile($responseStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
	}

	/**
	 * Converts a document to outputFormat.
         * 
	 * @param string $outputFormat Returns document in the specified format.
         * 
         * @return string Returns the file path.
         * @throws Exception
	 */
	public function save($outputFormat) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        //Build URI
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '?format=' . $outputFormat;
        //Sign URI
        $signedURI = Utils::sign($strURI);
        //Send request and receive response stream
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        //Validate output
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output === '') {
            //Save ouput file
            $outputPath = AsposeApp::$outPutLocation . Utils::getFileName($this->fileName) . '.' . $outputFormat;
            Utils::saveFile($responseStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
	}

	/**
	 * Converts a sheet to image.
         * 
	 * @param string $imageFormat Returns image in the specified format.
         * 
         * @return string Returns the file path.
         * @throws Exception
	 */
	public function worksheetToImage($imageFormat) {
        //check whether file and sheet is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        if ($this->worksheetName == '')
            throw new Exception('No worksheet specified');
        //Build URI
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '/worksheets/' . $this->worksheetName . '?format=' . $imageFormat;
        //Sign URI
        $signedURI = Utils::sign($strURI);
        //Send request and receive response stream
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        //Validate output
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output === '') {
            //Save ouput file
            $outputPath = AsposeApp::$outPutLocation . Utils::getFileName($this->fileName) . '_' . $this->worksheetName . '.' . $imageFormat;
            Utils::saveFile($responseStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
	}

	/**
	 * Saves a specific picture from a specific sheet as image.
         * 
	 * @param integer $pictureIndex Index of the picture.
	 * @param string $imageFormat Returns image in the specified format.
         * 
         * @return string Returns the file path.
         * @throws Exception
	 */
	public function pictureToImage($pictureIndex, $imageFormat) {
        //check whether file and sheet is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        if ($this->worksheetName == '')
            throw new Exception('No worksheet specified');
        //Build URI
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '/worksheets/' . $this->worksheetName . '/pictures/' . $pictureIndex . '?format=' . $imageFormat;
        //Sign URI
        $signedURI = Utils::sign($strURI);
        //Send request and receive response stream
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        //Validate output
        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            //Save ouput file
            $outputPath = AsposeApp::$outPutLocation . Utils::getFileName($this->fileName) . '_' . $this->worksheetName . '.' . $imageFormat;
            Utils::saveFile($responseStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
	}

	/**
	 * Saves a specific OleObject from a specific sheet as image.
         * 
	 * @param integer $objectIndex Index of the object.
	 * @param string $imageFormat Returns image in the specified format.
         * 
         * @return string Returns the file path.
         * @throws Exception
	 */
	public function oleObjectToImage($objectIndex, $imageFormat) {
        //check whether file and sheet is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        if ($this->worksheetName == '')
            throw new Exception('No worksheet specified');
        //Build URI
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '/worksheets/' . $this->worksheetName . '/oleobjects/' . $objectIndex . '?format=' . $imageFormat;
        //Sign URI
        $signedURI = Utils::sign($strURI);
        //Send request and receive response stream
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        //Validate output
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output === '') {
            //Save ouput file
            $outputPath = AsposeApp::$outPutLocation . Utils::getFileName($this->fileName) . '_' . $this->worksheetName . '.' . $imageFormat;
            Utils::saveFile($responseStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
	}

	/**
	 * Saves a specific chart from a specific sheet as image.
         * 
	 * @param integer $chartIndex Index of the chart.
	 * @param string $imageFormat Returns image in the specified format.
         * 
         * @return string Returns the path file.
         * @throws Exception
	 */
	public function chartToImage($chartIndex, $imageFormat) {
        //check whether file and sheet is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        if ($this->worksheetName == '')
            throw new Exception('No worksheet specified');
        //Build URI
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '/worksheets/' . $this->worksheetName . '/charts/' . $chartIndex . '?format=' . $imageFormat;
        //Sign URI
        $signedURI = Utils::sign($strURI);
        //Send request and receive response stream
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        //Validate output
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output === '') {
            //Save ouput file
            $outputPath = AsposeApp::$outPutLocation . Utils::getFileName($this->fileName) . '_' . $this->worksheetName . '.' . $imageFormat;
            Utils::saveFile($responseStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
	}

	/**
	 * Saves a specific auto-shape from a specific sheet as image.
         * 
	 * @param integer $shapeIndex Index of the shape.
	 * @param string $imageFormat Returns image in the specified format.
         * 
         * @return string Returns the file path.
         * @throws Exception
	 */
	public function autoShapeToImage($shapeIndex, $imageFormat) {
        //check whether file and sheet is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        if ($this->worksheetName == '')
            throw new Exception('No worksheet specified');
        //Build URI
        $strURI = Product::$baseProductUri . '/cells/' . $this->fileName . '/worksheets/' . $this->worksheetName . '/autoshapes/' . $shapeIndex . '?format=' . $imageFormat;
        //Sign URI
        $signedURI = Utils::sign($strURI);
        //Send request and receive response stream
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        //Validate output
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output === '') {
            //Save ouput file
            $outputPath = AsposeApp::$outPutLocation . Utils::getFileName($this->fileName) . '_' . $this->worksheetName . '.' . $imageFormat;
            Utils::saveFile($responseStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
	}
        
        /**
         * Convert file into specified format without using Aspose cloud storage.
         * @param type $inputFile Path of the source file.
         * @param type $outputFile Name of the output file.
         * @param type $saveFormat Returns document in the specified format.
         * 
         * @return string Returns the file path.
         * @throws Exception
         */
	public function convertLocalFile($inputFile, $outputFile, $saveFormat) {
        if ($inputFile == '') {
            throw new Exception('Please Specify Input File Name along with path');
        }
        if ($outputFile == '') {
            throw new Exception('Please Specify Output File Name along with Extension');
        }
        if ($saveFormat == '') {
            throw new Exception('Please Specify a Save Format');
        }
        $strURI = Product::$baseProductUri . '/cells/convert?format=' . $saveFormat;
        $signedURI = Utils::sign($strURI);
        if (!file_exists($inputFile)) {
            throw new Exception('Input File Doesnt Exists');
        }
        $responseStream = Utils::uploadFileBinary($signedURI, $inputFile, 'xml');
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output === '') {
            if ($saveFormat == 'html') {
                $outputFormat = 'zip';
            } else {
                $outputFormat = $saveFormat;
            }
            if ($outputFile == '') {
                $outputFileName = Utils::getFileName($inputFile) . '.' . $outputFormat;
            } else {
      $outputFileName = Utils::getFileName($outputFile) . '.' . $outputFormat;
    }
            Utils::saveFile($responseStream, AsposeApp::$outPutLocation . $outputFileName);
            return $outputFileName;
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

    /**
     * @return string
     */
    public function getWorksheetName()
    {
        return $this->worksheetName;
    }

    /**
     * @param string $worksheetName
     */
    public function setWorksheetName($worksheetName)
    {
        $this->worksheetName = $worksheetName;
    }

}
