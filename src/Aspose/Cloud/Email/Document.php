<?php
/**
 * Copyright (c) Aspose 2002-2014. All Rights Reserved.
 *
 * LICENSE: This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://opensource.org/licenses/gpl-3.0.html>;.
 *
 * @package Aspose_Cloud_SDK_For_PHP
 * @author  Masood Anwer <masood.anwer@aspose.com>
 * @link    https://github.com/asposeforcloud/Aspose_Cloud_SDK_For_PHP
 */

namespace Aspose\Cloud\Email;

use Aspose\Cloud\Common\AsposeApp;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Common\Utils;
use Aspose\Cloud\Exception\AsposeCloudException as Exception;

class Document
{

    public $fileName = '';

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Get resource properties information like From, To, Subject.
     *
     * @param string $propertyName The name of property.
     *
     * @return string Returns value of the property.
     * @throws Exception
     */
    public function getProperty($propertyName)
    {
        if ($propertyName == '')
            throw new Exception('Property Name not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/email/' . $this->getFileName() . '/properties/' . $propertyName;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return $json->EmailProperty->Value;
        else
            return false;
    }

    /**
     * Set document property.
     *
     * @param string $propertyName The name of property.
     * @param string $propertyValue The value of property.
     *
     * @return string|boolean Return value if property is set or FALSE if it is not set.
     * @throws Exception
     */
    public function setProperty($propertyName, $propertyValue)
    {
        if ($propertyName == '')
            throw new Exception('Property Name not specified');

        if ($propertyValue == '')
            throw new Exception('Property Value not specified');

        //build URI 
        $strURI = Product::$baseProductUri . '/email/' . $this->getFileName() . '/properties/' . $propertyName;

        $put_data_arr['Value'] = $propertyValue;

        $put_data = json_encode($put_data_arr);

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'PUT', 'json', $put_data);

        $json = json_decode($responseStream);

        if ($json->Code == 200)
            return $json->EmailProperty->Value;
        else
            return false;
    }

    /**
     * Get email attachment.
     *
     * @param string $attachmentName The name of attached file.
     *
     * @return string Return path of the attached file.
     * @throws Exception
     */
    public function getAttachment($attachmentName)
    {
        if ($attachmentName == '')
            throw new Exception('Attachment Name not specified');

        //build URI
        $strURI = Product::$baseProductUri . '/email/' . $this->getFileName() . '/attachments/' . $attachmentName;

        //sign URI
        $signedURI = Utils::sign($strURI);

        $responseStream = Utils::processCommand($signedURI, 'GET', '', '');

        $v_output = Utils::validateOutput($responseStream);

        if ($v_output === '') {
            $outputFilename = $attachmentName;
            Utils::saveFile($responseStream, AsposeApp::$outPutLocation . $outputFilename);
            return $outputFilename;
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

}