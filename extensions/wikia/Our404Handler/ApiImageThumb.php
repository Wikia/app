<?php

/**
 * @package MediaWiki
 * @subpackage API
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com> for Wikia, Inc.
 * @copyright (C) 2007 Wikia, Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id: ApiImageThumb.php 8945 2008-01-31 09:56:59Z emil $
 */

if (!defined('MEDIAWIKI')) {
	// Eclipse helper - will be ignored in production
	require_once ('ApiBase.php');
}

/**
 * A query action to get image information and upload history.
 *
 * @addtogroup API
 */
class ApiImageThumb extends ApiBase {

    const TAG = "ti";
    public $mData, $mParams;

    public function __construct($main, $action)
    {
        parent::__construct($main, $action, self::TAG );
    }

    public function execute()
	{
        wfProfileIn(__METHOD__);

        $this->mParams = $this->getParams();
        $this->mData = $this->getData();
        $this->setOutput();

        wfProfileOut(__METHOD__);
	}

	protected function getParams()
	{
		wfProfileIn(__METHOD__);

		$this->mParams = $this->extractRequestParams();

		wfProfileOut(__METHOD__);
		return $this->mParams;
	}

    public function getData()
    {
        wfProfileIn( __METHOD__ );

        $this->mData = array();
        if( isset( $this->mParams["image"] ) && isset($this->mParams["width"]) ) {
            #--- do the Bartman!
            $oImage = wfLocalFile( $this->mParams["image"] );

            if( $oImage && ( $sThumbName = $oImage->thumbName( $this->mParams ) ) != false ) {

                $this->mData["thumb"] = array();
                $this->mData["thumb"]["name"] = $sThumbName;

                $sThumbPath = $oImage->getThumbPath( $sThumbName );
                $this->mData["thumb"]["path"] = $sThumbPath;

                try {
                    $oThumb = $oImage->transform( $this->mParams, File::RENDER_NOW );
                }
                catch( Exception $ex ) {
                    $oThumb = false;
                }
                $this->mData["thumb"]["exists"] = file_exists( $sThumbPath ) ? 1 : 0;
                if ( $this->mData["thumb"]["exists"] ) {
                    $this->mData["thumb"]["url"] = $oThumb->getUrl();
                    $this->mData["thumb"]["width"] = $oThumb->getWidth();
                    $this->mData["thumb"]["height"] = $oThumb->getHeight();
                }
            }
        }

        wfProfileOut( __METHOD__ );

        return $this->mData;
    }

    protected function setOutput()
    {
		wfProfileIn(__METHOD__);

        $result = $this->getResult();
        $result->setIndexedTagName($this->mData, self::TAG );
        $result->addValue( "query", $this->getModuleName(), $this->mData);

        wfProfileOut(__METHOD__);
	}

    public function getAllowedParams()
    {
        return array (
            "image" => array(
                ApiBase :: PARAM_TYPE => 'string',
            ),
            "width" => array(
                ApiBase :: PARAM_TYPE => 'integer',
                ApiBase :: PARAM_DFLT => 800,
            )
        );
    }

	public function getParamDescription()
	{
		return array (
            "image" => "Image file name",
            "width" => "Width of generated thumbnail"
		);
	}

    public function getDescription()
    {
        return array (
            'This module is used to to create thumbnail for image.',
        );
    }

	public function getExamples()
	{
		return array(
            sprintf("api.php?action=imagethumb&%simage=Wiki.png&%swidth=50", self::TAG, self::TAG)
		);
	}

	public function getVersion()
	{
		return __CLASS__ . ': $Id: ApiImageThumb.php 8945 2008-01-31 09:56:59Z emil $';
	}

}
