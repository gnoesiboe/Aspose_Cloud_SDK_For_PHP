<?php
/**
 * Reads barcodes from images.
 */
namespace Aspose\Cloud\Barcode;

use Aspose\Cloud\Common\Utils;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Storage\Folder;
use Aspose\Cloud\Exception\AsposeCloudException as Exception;

class BarcodeReader {

	protected $fileName = '';

	public function __construct($fileName) {
		$this->fileName = $fileName;
	}

    /**
     * Reads all or specific barcodes from images.
     * 
     * @param string $symbology Type of barcode.
     * 
     * @return array
     * @throws Exception
     */
	public function read($symbology) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        //build URI to read barcode
        $strURI = Product::$baseProductUri . '/barcode/' . $this->fileName . '/recognize?' . (!isset($symbology) || trim($symbology) === '' ? 'type=' : 'type=' . $symbology);
        //sign URI
        $signedURI = Utils::sign($strURI);
        //get response stream
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);

        //returns a list of extracted barcodes
        return $json -> Barcodes;
	}
        
    /**
     * Read Barcode from Aspose Cloud Storage
     * 
     * @param string $remoteImageName Name of the remote image.
     * @param string $remoteFolder Name of the folder.
     * @param string $readType Type to read barcode.
     * 
     * @return array
     * @throws Exception
     */
	public function readR($remoteImageName, $remoteFolder, $readType) {
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        $uri = $this->uriBuilder($remoteImageName, $remoteFolder, $readType);
        $signedURI = Utils::sign($uri);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $json = json_decode($responseStream);
        return $json -> Barcodes;
	}
        
    /**
     * Read Barcode from Local Image.
     * 
     * @param string $localImage Path of the local image.
     * @param string $remoteFolder Name of the remote folder.
     * @param string $barcodeReadType Type to read barcode.
     * 
     * @return array
     * @throws Exception
     */
	public function readFromLocalImage($localImage, $remoteFolder, $barcodeReadType) {
			if ($this->fileName == '')
				throw new Exception('No file name specified');
			$folder = new Folder();
			$folder -> UploadFile($localImage, $remoteFolder);
			$data = $this->ReadR(basename($localImage), $remoteFolder, $barcodeReadType);
			return $data;
	}
        
        /**
         * Read Barcode from External Image URL 
         * 
         * @param type $url URL of the barcode image.
         * @param type $symbology Type of barcode.
         * 
         * @return array
         * @throws Exception
         */
        public function readFromURL($url, $symbology) {
            if ($url == '')
                throw new Exception('URL not specified');
            
            if ($symbology == '')
                throw new Exception('Symbology not specified');
            
            //build URI to read barcode
            $strURI = Product::$baseProductUri . '/barcode/recognize?type=' . $symbology . '&url=' . $url;
            
            //sign URI
            $signedURI = Utils::sign($strURI);            
            
            $responseStream = Utils::processCommand($signedURI, 'POST', '', '');

            $json = json_decode($responseStream);

            if ($json->Code == 200)
                return $json->Barcodes;
            else
                return false;
        }
        
        /**
         * Read Barcode from Specific Region of Image
         * 
         * @param type $symbology Type of barcode.
         * @param type $rectX
         * @param type $rectY
         * @param type $rectWidth
         * @param type $rectHeight
         * 
         * @return array
         * @throws Exception
         */
        public function readSpecificRegion($symbology, $rectX, $rectY, $rectWidth, $rectHeight) {
            if ($this->fileName == '')
                throw new Exception('No file name specified');
            
            if ($symbology == '')
                throw new Exception('Symbology not specified');
            
            if ($rectX == '')
                throw new Exception('X position not specified');
            
            if ($rectY == '')
                throw new Exception('Y position not specified');
            
            if ($rectWidth == '')
                throw new Exception('Width not specified');
            
            if ($rectHeight == '')
                throw new Exception('Height not specified');
            
            //build URI to read barcode
            $strURI = Product::$baseProductUri . '/barcode/' . $this->fileName . '/recognize?type=' . $symbology . '&rectX=' . $rectX . '&rectY=' . $rectY
			. '&rectWidth=' . $rectWidth . '&rectHeight=' . $rectHeight;
            
            //sign URI
            $signedURI = Utils::sign($strURI);            
            
            $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

            $json = json_decode($responseStream);

            if ($json->Code == 200)
                return $json->Barcodes;
            else
                return false;
        }
        
        /**
         * Recognize Barcode with Checksum Option from Storage 
         * 
         * @param type $symbology Type of barcode.
         * @param type $checksumValidation Checksum validation parameter. 
         * 
         * @return array
         * @throws Exception
         */
        public function readWithChecksum($symbology, $checksumValidation) {
            if ($this->fileName == '')
                throw new Exception('No file name specified');
            
            if ($symbology == '')
                throw new Exception('Symbology not specified');
            
            if ($checksumValidation == '')
                throw new Exception('Checksum not specified');
            
            //build URI to read barcode
            $strURI = Product::$baseProductUri . '/barcode/' . $this->fileName . '/recognize?type=' . $symbology . '&checksumValidation=' . $checksumValidation;
            
            //sign URI
            $signedURI = Utils::sign($strURI);            
            
            $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

            $json = json_decode($responseStream);

            if ($json->Code == 200)
                return $json->Barcodes;
            else
                return false;
        }
        
        /**
         * Recognize Specified count of Barcodes 
         * 
         * @param type $symbology Type of barcode.
         * @param type $barcodesCount Recognize specified count of barcodes. 
         * 
         * @return array
         * @throws Exception
         */
        public function readBarcodeCount($symbology, $barcodesCount) {
            if ($this->fileName == '')
                throw new Exception('No file name specified');
            
            if ($symbology == '')
                throw new Exception('Symbology not specified');
            
            if ($barcodesCount == '')
                throw new Exception('Barcodes count not specified');
            
            //build URI to read barcode
            $strURI = Product::$baseProductUri . '/barcode/' . $this->fileName . '/recognize?type=' . $symbology . '&barcodesCount=' . $barcodesCount;
            
            //sign URI
            $signedURI = Utils::sign($strURI);            
            
            $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

            $json = json_decode($responseStream);

            if ($json->Code == 200)
                return $json->Barcodes;
            else
                return false;
        }

    /**
     * Build uri.
     * 
     * @param string $remoteImage Name of the image.
     * @param string $remoteFolder Name of the folder.
     * @param string $readType Type to read barcode.
     * 
     * @return string
     */
	public function uriBuilder($remoteImage, $remoteFolder, $readType) {
		$uri = Product::$baseProductUri . '/barcode/';
		if ($remoteImage != null)
			$uri .= $remoteImage . '/';
		$uri .= 'recognize?';
		if ($readType == 'AllSupportedTypes')
			$uri .= 'type=';
		else
			$uri .= 'type=' . $readType;
		if ($remoteFolder != null && trim($remoteFolder) === '')
			$uri .= '&format=' . $remoteFolder;
		if ($remoteFolder != null && trim($remoteFolder) === '')
			$uri .= '&folder=' . $remoteFolder;
		return $uri;
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

}
