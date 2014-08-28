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
use Aspose\Cloud\Common\Utils;
use Aspose\Cloud\Common\Product;
use Aspose\Cloud\Exception\AsposeCloudException as Exception;

class Converter {

    public $fileName = '';
    public $saveFormat = '';

    public function __construct($fileName) {
        //set default values
        $this->fileName = $fileName;

        $this->saveFormat = 'msg';
    }

    /**
     * Convert a document to SaveFormat using Aspose storage.
     * 
     * @param string $saveFormat Returns document in the specified format.
     * 
     * @return string Return the file path.
     * @throws Exception
     */
    public function convert() {
        //check whether file is set or not
        if ($this->fileName == '')
            throw new Exception('No file name specified');

        //build URI
        $strURI = Product::$baseProductUri . '/email/' . $this->fileName . '?format=' . $this->saveFormat;

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

}