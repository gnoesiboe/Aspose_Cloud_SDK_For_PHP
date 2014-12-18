<?php
/**
 * @author Imran Anwar <imran.anwar@Aspose.com>
 * @author Assad Mahmood <assadvirgo@gmail.com>
 * @author Rvanlaak
 */
namespace Aspose\Cloud\Common;

class AsposeApp
{
	
	/**
    * Represents AppSID for the app.
	*/
	public static $appSID  = '';

	/**
    * Represents AppKey for the app.
	*/
	public static $appKey = '';

    /**
     * Location where files get stored
     */
	public static $outPutLocation = 'E:\\';

    /**
     * @return string
     */
    public static function getAppKey()
    {
        return self::$appKey;
    }

    /**
     * @param string $appKey
     * @return self
     */
    public static function setAppKey($appKey)
    {
        self::$appKey = $appKey;
        return self;
    }

    /**
     * @return string
     */
    public static function getAppSID()
    {
        return self::$appSID;
    }

    /**
     * @param string $appSID
     * @return self
     */
    public static function setAppSID($appSID)
    {
        self::$appSID = $appSID;
        return self;
    }

    /**
     * @return string
     */
    public static function getOutPutLocation()
    {
        return self::$outPutLocation;
    }

    /**
     * @param string $outPutLocation
     * @return self
     */
    public static function setOutPutLocation($outPutLocation)
    {
        self::$outPutLocation = $outPutLocation;
        return self;
    }
}