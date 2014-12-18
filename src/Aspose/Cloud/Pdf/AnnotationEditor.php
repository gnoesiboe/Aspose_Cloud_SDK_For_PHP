<?php
/**
 * Deals with Annotations, Bookmarks, Attachments and Links in PDF document.
 */
namespace Aspose\Cloud\Pdf;

use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Utils;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Exception\AsposeCloudException as Exception;

class AnnotationEditor {

    protected $fileName = '';

    public function __construct($fileName) {
        $this->fileName = $fileName;
    }

    /**
     * Gets number of annotations on a specified document page.
     * 
     * @param ineger $pageNumber Number of the page.
     * 
     * @return integer
     * @throws Exception
     */
    public function getAnnotationsCount($pageNumber) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        $strURI = Product::$baseProductUri . '/pdf/' . $this->fileName . '/pages/' . $pageNumber . '/annotations';
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $json = json_decode($responseStream);
        return count($json->Annotations->List);
    }

    /**
     * Gets a specfied annotation on a specified document page.
     * 
     * @param integer $pageNumber Number of the page.
     * @param integer $annotationIndex Index of th annotation.
     * 
     * @return object
     * @throws Exception
     */
    public function getAnnotation($pageNumber, $annotationIndex) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        $strURI = Product::$baseProductUri . '/pdf/' . $this->fileName . '/pages/' . $pageNumber . '/annotations/' . $annotationIndex;
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $json = json_decode($responseStream);
        return $json->Annotation;
    }

    /**
     * Gets list of all the annotations on a specified document page.
     * 
     * @param integer $pageNumber Number of the page.
     * 
     * @return array
     * @throws Exception
     */
    public function getAllAnnotations($pageNumber) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        $iTotalAnnotation = $this->GetAnnotationsCount($pageNumber);
        $listAnnotations = array();
        for ($index = 1; $index <= $iTotalAnnotation; $index++) {
            array_push($listAnnotations, $this->GetAnnotation($pageNumber, $index));
        }
        return $listAnnotations;
    }

    /**
     * Gets total number of Bookmarks in a Pdf document.
     * 
     * @return integer
     * @throws Exception
     */
    public function getBookmarksCount() {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        $strURI = Product::$baseProductUri . '/pdf/' . $this->fileName . '/bookmarks';
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $json = json_decode($responseStream);
        return count($json->Bookmarks->List);
    }

    /**
     * Gets number of child bookmarks in a specfied parent bookmark.
     * 
     * @param integer $parent
     * 
     * @return ingeter
     * @throws Exception
     */
    public function getChildBookmarksCount($parent) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        $strURI = Product::$baseProductUri . '/pdf/' . $this->fileName . '/bookmarks/' . $parent . '/bookmarks';
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $json = json_decode($responseStream);
        return count($json->Bookmarks->List);
    }

    /**
     * Gets a specfied Bookmark from a PDF document.
     * 
     * @param integer $bookmarkIndex Index of the bookmark.
     * 
     * @return object
     * @throws Exception
     */
    public function getBookmark($bookmarkIndex) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        $strURI = Product::$baseProductUri . '/pdf/' . $this->fileName . '/bookmarks/' . $bookmarkIndex;
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $json = json_decode($responseStream);
        return $json->Bookmark;
    }

    /**
     * Gets a specfied child Bookmark for selected parent bookmark in Pdf document.
     * 
     * @param integer $parentIndex Parent index.
     * @param integer $childIndex Child index.
     * 
     * @return object
     * @throws Exception
     */
    public function getChildBookmark($parentIndex, $childIndex) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        $strURI = Product::$baseProductUri . '/pdf/' . $this->fileName . '/bookmarks/' . $parentIndex . '/bookmarks/' . $childIndex;
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $json = json_decode($responseStream);
        return $json->Bookmark;
    }

    /**
     * Checks whether selected bookmark is parent or child Gets a specfied child 
     * Bookmark for selected parent bookmark in Pdf document.
     * 
     * @param ingeter $bookmarkIndex Index of the bookmark.
     * 
     * @return object
     * @throws Exception
     */
    public function isChildBookmark($bookmarkIndex) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        if ($bookmarkIndex === '')
            throw new Exception('bookmark index not specified');
        $strURI = Product::$baseProductUri . '/pdf/' . $this->fileName . '/bookmarks/' . $bookmarkIndex;
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $json = json_decode($responseStream);
        return $json->Bookmark;
    }

    /**
     * Gets list of all the Bookmarks in a Pdf document.
     * 
     * @return array
     * @throws Exception
     */
    public function getAllBookmarks() {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        $iTotalBookmarks = $this->GetBookmarksCount();
        $listBookmarks = array();
        for ($index = 1; $index <= $iTotalBookmarks; $index++) {
            array_push($listBookmarks, $this->GetBookmark($index));
        }
        return $listBookmarks;
    }

    /**
     * Gets number of attachments in the Pdf document.
     * 
     * @return integer
     * @throws Exception
     */
    public function getAttachmentsCount() {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        $strURI = Product::$baseProductUri . '/pdf/' . $this->fileName . '/attachments';
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $json = json_decode($responseStream);
        return count($json->Attachments->List);
    }

    /**
     * Gets selected attachment from Pdf document.
     * 
     * @param integer $attachmentIndex Index of the attachment.
     * 
     * @return object
     * @throws Exception
     */
    public function getAttachment($attachmentIndex) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        $strURI = Product::$baseProductUri . '/pdf/' . $this->fileName . '/attachments/' . $attachmentIndex;
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $json = json_decode($responseStream);
        return $json->Attachment;
    }

    /**
     * Gets List of all the attachments in Pdf document.
     * 
     * @return array
     * @throws Exception
     */
    public function getAllAttachments() {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        $iTotalAttachments = $this->GetAttachmentsCount();
        $listAttachments = array();
        for ($index = 1; $index <= $iTotalAttachments; $index++) {
            array_push($listAttachments, $this->GetAttachment($index));
        }
        return $listAttachments;
    }

    /**
     * Download the selected attachment from Pdf document.
     * 
     * @param string $attachmentIndex Index of the attachment.
     * 
     * @return string Returns the file path.
     * @throws Exception
     */
    public function downloadAttachment($attachmentIndex) {
        //check whether files are set or not
        if ($this->fileName == '')
            throw new Exception('PDF file name not specified');
        $fileInformation = $this->GetAttachment($attachmentIndex);
        //build URI to download attachment
        $strURI = Product::$baseProductUri . '/pdf/' . $this->fileName . '/attachments/' . $attachmentIndex . '/download';
        //sign URI
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $v_output = Utils::validateOutput($responseStream);
        if ($v_output === '') {
            Utils::saveFile($responseStream, AsposeApp::$outPutLocation . $fileInformation->Name);
            return '';
        }
        else
            return $v_output;
    }

    /**
     * Gets number of links on a specified document page.
     * 
     * @param integer $pageNumber Number of the page.
     * 
     * @return integer
     * @throws Exception
     */
    public function getLinksCount($pageNumber) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        $strURI = Product::$baseProductUri . '/pdf/' . $this->fileName . '/pages/' . $pageNumber . '/links';
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $json = json_decode($responseStream);
        return count($json->Links->List);
    }

    /**
     * Gets a specfied link on a specified document page
     * 
     * @param integer $pageNumber Number of the page.
     * @param integer $linkIndex Index of the link.
     * 
     * @return object
     * @throws Exception
     */
    public function getLink($pageNumber, $linkIndex) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        $strURI = Product::$baseProductUri . '/pdf/' . $this->fileName . '/pages/' . $pageNumber . '/links/' . $linkIndex;
        $signedURI = Utils::sign($strURI);
        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');
        $json = json_decode($responseStream);
        return $json->Link;
    }

    /**
     * Gets list of all the links on a specified document page.
     * 
     * @param integer $pageNumber Number of the page.
     * 
     * @return array
     * @throws Exception
     */
    public function getAllLinks($pageNumber) {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');
        $iTotalLinks = $this->GetLinksCount($pageNumber);
        $listLinks = array();
        for ($index = 1; $index <= $iTotalLinks; $index++) {
            array_push($listLinks, $this->GetLink($pageNumber, $index));
        }
        return $listLinks;
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