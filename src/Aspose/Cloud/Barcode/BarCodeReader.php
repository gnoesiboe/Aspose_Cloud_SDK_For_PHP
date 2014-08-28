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

	public $fileName = '';

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

}
