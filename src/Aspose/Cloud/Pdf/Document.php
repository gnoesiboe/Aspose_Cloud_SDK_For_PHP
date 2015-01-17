<?php
/**
 * Deals with PDF document level aspects.
 */
namespace Aspose\Cloud\Pdf;

use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Common\Utils;
use Aspose\Cloud\Event\SplitPageEvent;
use Aspose\Cloud\Exception\AsposeCloudException as Exception;
use Aspose\Cloud\Storage\Folder;

class Document
{

    public $fileName = '';

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Gets the page count of the specified PDF document.
     *
     * @return integer
     */
    public function getPageCount()
    {
        //build URI
        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/pages';

        //sign URI
        $signedURI = Utils::sign($strURI);

        //get response stream
        $responseStream = Utils::ProcessCommand($signedURI, 'GET', '');

        $json = json_decode($responseStream);

        return count($json->Pages->List);
    }

    /**
     * Merges two PDF documents.
     *
     * @param string $basePdf (name of the base/first PDF file)
     * @param string $newPdf (name of the second PDF file to merge with base PDF file)
     * @param string $startPage (page number to start merging second PDF: enter 0 to merge complete document)
     * @param string $endPage (page number to end merging second PDF: enter 0 to merge complete document)
     * @param string $sourceFolder (name of the folder where base/first and second input PDFs are present)
     *
     * @return string|boolean
     * @throws Exception
     */
    public function appendDocument($basePdf, $newPdf, $startPage = 0, $endPage = 0, $sourceFolder = '')
    {
        //check whether files are set or not
        if ($basePdf == '')
            throw new Exception('Base file not specified');
        if ($newPdf == '')
            throw new Exception('File to merge is not specified');

        //build URI to merge PDFs
        if ($sourceFolder == '')
            $strURI = Product::$baseProductUri . '/pdf/' . $basePdf .
                '/appendDocument?appendFile=' . $newPdf . ($startPage > 0 ? '&startPage=' . $startPage : '') .
                ($endPage > 0 ? '&endPage=' . $endPage : '');
        else
            $strURI = Product::$baseProductUri . '/pdf/' . $basePdf .
                '/appendDocument?appendFile=' . $sourceFolder . '/' . $newPdf .
                ($startPage > 0 ? '&startPage=' . $startPage : '') .
                ($endPage > 0 ? '&endPage=' . $endPage : '') .
                '&folder=' . $sourceFolder;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'POST', '', '');

        $json = json_decode($responseStream);

        if ($json->Code == 200) {
            $folder = new Folder();
            $path = "";
            if ($sourceFolder == "") {
                $path = $basePdf;
            } else {
                $path = $sourceFolder . '/' . $basePdf;
            }
            $outputStream = $folder->GetFile($path);
            $outputPath = AsposeApp::$outPutLocation . $basePdf;
            Utils::saveFile($outputStream, $outputPath);
        } else {
            return false;
        }
    }

    /**
     * Merges tow or more PDF documents.
     *
     * @param array $sourceFiles List of PDF files to be merged
     *
     * @return boolean
     * @throws Exception
     */
    public function mergeDocuments(array $sourceFiles = array())
    {
        $mergedFileName = $this->getFileName();
        //check whether files are set or not
        if ($mergedFileName == '')
            throw new Exception('Output file not specified');
        if (empty($sourceFiles))
            throw new Exception('File to merge are not specified');
        if (count($sourceFiles) < 2)
            throw new Exception('Two or more files are requred to merge');


        //Build JSON to post
        $documentsList = array('List' => $sourceFiles);
        $json = json_encode($documentsList);

        $strURI = Product::$baseProductUri . '/pdf/' . $mergedFileName . '/merge';

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = json_decode(Utils::processCommand($signedURI, 'PUT', 'json', $json));

        if ($responseStream->Code == 200)
            return true;
        else
            return false;
    }

    /**
     * Creates a PDF from HTML.
     *
     * @param string $pdfFileName Name of the PDF file to create.
     * @param string $htmlFileName Name of the HTML template file.
     *
     * @return string Return the file path.
     * @throws Exception
     */
    public function createFromHtml($pdfFileName, $htmlFileName)
    {
        //check whether files are set or not
        if ($pdfFileName == '')
            throw new Exception('PDF file name not specified');
        if ($htmlFileName == '')
            throw new Exception('HTML template file name not specified');

        //build URI to create PDF
        $strURI = Product::$baseProductUri . '/pdf/' . $pdfFileName .
            '?templateFile=' . $htmlFileName . '&templateType=html';

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'PUT', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            //Save PDF file on server
            $folder = new Folder();
            $outputStream = $folder->GetFile($pdfFileName);
            $outputPath = AsposeApp::$outPutLocation . $pdfFileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    /**
     * Creates a PDF from XML.
     *
     * @param string $pdfFileName Name of the PDF file to create.
     * @param string $xsltFileName Name of the XSLT template file.
     * @param string $xmlFileName Name of the XML file.
     *
     * @return string Returns the file path
     * @throws Exception
     */
    public function createFromXml($pdfFileName, $xsltFileName, $xmlFileName)
    {
        //check whether files are set or not
        if ($pdfFileName == '')
            throw new Exception('PDF file name not specified');
        if ($xsltFileName == '')
            throw new Exception('XSLT file name not specified');
        if ($xmlFileName == '')
            throw new Exception('XML file name not specified');

        //build URI to create PDF
        $strURI = Product::$baseProductUri . '/pdf/' . $pdfFileName . '?templateFile=' .
            $xsltFileName . '&dataFile=' . $xmlFileName . '&templateType=xml';

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'PUT', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            //Save PDF file on server
            $folder = new Folder();
            $outputStream = $folder->GetFile($pdfFileName);
            $outputPath = AsposeApp::$outPutLocation . $pdfFileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    /**
     * Gets the FormField count of the specified PDF document.
     *
     * @return integer
     */
    public function getFormFieldCount()
    {
        //build URI
        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/fields';

        //sign URI
        $signedURI = Utils::sign($strURI);

        //get response stream
        $responseStream = Utils::ProcessCommand($signedURI, 'GET', '');

        $json = json_decode($responseStream);

        return count($json->Fields->List);
    }

    /**
     * Gets the list of FormFields from the specified PDF document.
     *
     * @return array
     */
    public function getFormFields()
    {
        //build URI
        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/fields';

        //sign URI
        $signedURI = Utils::sign($strURI);

        //get response stream
        $responseStream = Utils::ProcessCommand($signedURI, 'GET', '');

        $json = json_decode($responseStream);

        return $json->Fields->List;
    }

    /**
     * Gets a particular form field.
     *
     * @param string $fieldName Name of the field.
     *
     * @return object
     */
    public function getFormField($fieldName)
    {
        //build URI
        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/fields/' . $fieldName;

        //sign URI
        $signedURI = Utils::sign($strURI);

        //get response stream
        $responseStream = Utils::ProcessCommand($signedURI, 'GET', '');

        $json = json_decode($responseStream);

        return $json->Field;
    }

    /**
     * Creates an Empty Pdf document.
     *
     * @param string $pdfFileName Name of the PDF file to create.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function createEmptyPdf($pdfFileName)
    {
        //check whether files are set or not
        if ($pdfFileName == '')
            throw new Exception('PDF file name not specified');

        //build URI to create PDF
        $strURI = Product::$baseProductUri . '/pdf/' . $pdfFileName;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'PUT', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            //Save PDF file on server
            $folder = new Folder();
            $outputStream = $folder->GetFile($pdfFileName);
            $outputPath = AsposeApp::$outPutLocation . $pdfFileName;
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    /**
     * Adds new page to opened Pdf document.
     *
     * @return string Return the file path.
     * @throws Exception
     */
    public function addNewPage()
    {

        //build URI to add page
        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/pages';

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'PUT', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            //Save PDF file on server
            $folder = new Folder();
            $outputStream = $folder->GetFile($this->getFileName());
            $outputPath = AsposeApp::$outPutLocation . $this->getFileName();
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    /**
     * Deletes selected page from Pdf document.
     *
     * @param integer $pageNumber Number of the page.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function deletePage($pageNumber)
    {

        //build URI to delete page
        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/pages/' . $pageNumber;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'DELETE', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            //Save PDF file on server
            $folder = new Folder();
            $outputStream = $folder->GetFile($this->getFileName());
            $outputPath = AsposeApp::$outPutLocation . $this->getFileName();
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    /**
     * Moves selected page in Pdf document to new location.
     *
     * @param integer $pageNumber Number of the page.
     * @param integer $newLocation New number for the page.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function movePage($pageNumber, $newLocation)
    {
        //build URI to move page
        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/pages/' . $pageNumber .
            '/movePage?newIndex=' . $newLocation;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'POST', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            //Save PDF file on server
            $folder = new Folder();
            $outputStream = $folder->GetFile($this->getFileName());
            $outputPath = AsposeApp::$outPutLocation . $this->getFileName();
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    /**
     * Replaces Image in PDF File using Local Image Stream.
     *
     * @param integer $pageNumber Number of the page.
     * @param integer $imageIndex Index of the image.
     * @param string $imageStream The image stream.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function replaceImageUsingStream($pageNumber, $imageIndex, $imageStream)
    {
        //build URI to replace image
        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/pages/' . $pageNumber .
            '/images/' . $imageIndex;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'POST', '', $imageStream);

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            //Save PDF file on server
            $folder = new Folder();
            $outputStream = $folder->GetFile($this->getFileName());
            $outputPath = AsposeApp::$outPutLocation . $this->getFileName();
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    /**
     * Replaces Image in PDF File using Local Image Stream.
     *
     * @param integer $pageNumber Number of the page.
     * @param integer $imageIndex Index of the image.
     * @param string $fileName The file name.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function replaceImageUsingFile($pageNumber, $imageIndex, $fileName)
    {

        //build URI to replace image
        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/pages/' . $pageNumber .
            '/images/' . $imageIndex . '?imageFile=' . $fileName;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'POST', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            //Save PDF file on server
            $folder = new Folder();
            $outputStream = $folder->GetFile($this->getFileName());
            $outputPath = AsposeApp::$outPutLocation . $this->getFileName();
            Utils::saveFile($outputStream, $outputPath);
            return $outputPath;
        } else
            return $v_output;
    }

    /**
     * Get all the properties of the specified document    .
     *
     * @return array
     * @throws Exception
     */
    public function getDocumentProperties()
    {

        //build URI to replace image
        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/documentProperties';

        //sign URI
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $response_arr = json_decode($responseStream);

        return $response_arr->DocumentProperties->List;
    }

    /**
     * Get specified properity of the document.
     *
     * @param string $propertyName Name of the property.
     *
     * @return object
     * @throws Exception
     */
    public function getDocumentProperty($propertyName = '')
    {

        if ($propertyName == '')
            throw new Exception('Property name not specified');

        //build URI to replace image
        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/documentProperties/' . $propertyName;

        //sign URI
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $response_arr = json_decode($responseStream);

        return $response_arr->DocumentProperty;
    }

    /**
     * Set specified properity of the document.
     *
     * @param string $propertyName Name of the property.
     * @param string $propertyValue Value of the property.
     *
     * @return object
     * @throws Exception
     */
    public function setDocumentProperty($propertyName = '', $propertyValue = '')
    {

        if ($propertyName == '')
            throw new Exception('Property name not specified');

        //build URI to replace image
        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/documentProperties/' . $propertyName;

        $putArray['Value'] = $propertyValue;
        $json = json_encode($putArray);

        //sign URI
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'PUT', 'json', $json);

        $response_arr = json_decode($responseStream);

        return $response_arr->DocumentProperty;
    }

    /**
     * Remove all properties of the document.
     *
     * @return boolean
     * @throws Exception
     */
    public function removeAllProperties()
    {
        //build URI to replace image
        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/documentProperties';

        //sign URI
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'DELETE', '', '');

        $response_arr = json_decode($responseStream);

        return $response_arr->Code == 200 ? true : false;
    }

    /**
     * Split page into multiple documents.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function splitAllPages()
    {
        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/split';
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'POST', '', '');
        $json = json_decode($responseStream);

        $dispatcher = AsposeApp::getEventDispatcher();

        $pageNumber = 1;
        foreach ($json->Result->Documents as $splitPage) {
            $splitFileName = basename($splitPage->Href);
            $strURI = Product::$baseProductUri . '/storage/file/' . $splitFileName;
            $signedURI = Utils::sign($strURI);
            $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

            $fileName = $this->getFileName() . '_' . $pageNumber . '.pdf';
            $outputFile = AsposeApp::$outPutLocation . $fileName;

            Utils::saveFile($responseStream, $outputFile);
            echo $outputFile . '<br />'; // FIXME what is the function of this, why let the API echo?

            $event = new SplitPageEvent($outputFile, $pageNumber);
            $dispatcher->dispatch(SplitPageEvent::PAGE_IS_SPLIT, $event);

            $pageNumber++;
        }
    }

    /**
     * Split page into documents as specified in the range.
     *
     * @param integer $from From page number.
     * @param integer $to To page number.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function splitPages($from, $to)
    {

        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/split?from=' . $from . '&to=' . $to;
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'POST', '', '');
        $json = json_decode($responseStream);

        $dispatcher = AsposeApp::getEventDispatcher();

        $pageNumber = 1;
        foreach ($json->Result->Documents as $splitPage) {
            $splitFileName = basename($splitPage->Href);
            $strURI = Product::$baseProductUri . '/storage/file/' . $splitFileName;
            $signedURI = Utils::sign($strURI);
            $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

            $fileName = $this->getFileName() . '_' . $pageNumber . '.pdf';
            $outputFile = AsposeApp::$outPutLocation . $fileName;

            Utils::saveFile($responseStream, $outputFile);
            echo $outputFile . '<br />';

            $event = new SplitPageEvent($outputFile, $pageNumber);
            $dispatcher->dispatch(SplitPageEvent::PAGE_IS_SPLIT, $event);

            $pageNumber++;
        }
    }

    /**
     * Split pages to specified format.
     *
     * @param integer $from From page number.
     * @param integer $to To page number.
     * @param string $format Returns file in the specified format.
     *
     * @return string Returns the file path.
     * @throws Exception
     */
    public function splitPagesToAnyFormat($from, $to, $format)
    {
        $strURI = Product::$baseProductUri . '/pdf/' . $this->getFileName() . '/split?from=' . $from . '&to=' . $to . '&format=' . $format;
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'POST', '', '');
        $json = json_decode($responseStream);

        $dispatcher = AsposeApp::getEventDispatcher();

        $pageNumber = 1;
        foreach ($json->Result->Documents as $splitPage) {
            $splitFileName = basename($splitPage->Href);
            $strURI = Product::$baseProductUri . '/storage/file/' . $splitFileName;
            $signedURI = Utils::sign($strURI);
            $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

            $fileName = $this->getFileName() . '_' . $pageNumber . '.' . $format;
            $outputFile = AsposeApp::$outPutLocation . $fileName;

            Utils::saveFile($responseStream, $outputFile);
            echo $outputFile . '<br />';

            $event = new SplitPageEvent($outputFile, $pageNumber);
            $dispatcher->dispatch(SplitPageEvent::PAGE_IS_SPLIT, $event);

            $pageNumber++;
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

}