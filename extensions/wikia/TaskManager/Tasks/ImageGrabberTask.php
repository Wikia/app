<?php

/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Bartek Lapinski <bartek@wikia.com> for Wikia.com
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @license GNU General Public Licence 2.0 or later
 * @version: $Id$
 */


class ImageGrabberTask extends BatchTask {

	private $mType, $mVisible, $mBaseUrl, $mMediaWikiVersion;


	/* constructor */
	function __construct () {
        $this->mType = 'imagegrabber' ;
		$this->mVisible = true ;
		parent::__construct();
	}

	/**
	 * listImages
	 *
	 * get images urls, then download them all
     *
     * @access public
     * @author bartek@wikia
     * @author eloy@wikia
     *
     * @param string $wikiurl: url to /index.php
     * @param integer $taskid: task identifier
	 */
	public function listImages( $wikiurl )
    {
        echo "Hi! its ".__METHOD__." {$this->getID()}\n";

		ini_set( 'allow_url_fopen', 1 );
        $taskfolder = $this->getTaskDirectory();

		if (!file_exists ($taskfolder)) {
			$this->addLog( "Error creating temporary folder {$taskfolder}" ) ;
			return false ;
		}

		$wikiurl .= "?title=Special:Imagelist&limit=1000" ;

        #--- standard method from MW
        $this->addLog( "Getting {$wikiurl}" );
        $html = Http::get( $wikiurl, 60 );

		if ( !$html ) {
			$this->addLog ("Unable to get image list") ;
			return false;
		}

		/*
			many, many, many documents are badly formed,
			I can't rely on xml, no
		*/

		$num_match = preg_match_all ('/<td class="TablePager_col_links">.*<\/td>/i', $html, $matches ) ;

		if (preg_match ('/[^\/]*:\/\/[^\/]*/', $wikiurl, $domain)) {
			$base_url = $domain [0] ;
		}

		if ($num_match > 0) {
			foreach ($matches[0] as $match) {
				$num_href = preg_match_all ('/\| <a href=".*"/i', $match, $href) ;
				if ($num_href > 0) {
					$turl = $href [0][0] ;

					if (preg_match ('/http:\/\/[^"]*/', $turl, $purl)) {
						$url = $purl [0]  ;
						// not all of them are images, mind you...
						if (preg_match ('/jpeg|jpg|png|svg|gif/i', $url)) {
							$this->saveFile( $url ) ;
						}
					} else {
						// those can be relative links, mind you
						if (preg_match ('/\/[^"]*/', $turl, $rurl)) {
							$url = $base_url . $rurl [0] ;
							if (preg_match ('/jpeg|jpg|png|svg|gif/i', $url)) {
                                $this->saveFile( $url );
							}
						}
					}
				}
			}
			$this->addLog ("finishing task successfully") ;
			return true ;
		} else {
			// beautiful MW can have different set of tables depending on version
			// this is for MW 1.12alpha
			$num_matches = preg_match_all ('/<td class="TablePager_col_img_name">.*<\/td>/i', $html, $matches ) ;
			if ($num_matches > 0) {
				foreach ($matches[0] as $match) {
					$num_href = preg_match_all ('/\(<a href=".*"/i', $match, $href) ;
					if ($num_href > 0) {
						$turl = $href [0][0] ;

						if (preg_match ('/http:\/\/[^"]*/', $turl, $purl)) {
							$url = $purl [0]  ;

							if (preg_match ('/jpeg|jpg|png|svg|gif/i', $url)) {
                                $this->saveFile( $url );
							}
						} else {
							// those can be relative links, mind you
							preg_match ('/\/[^"]*/', $turl, $rurl) ;
							$url = $base_url . $rurl [0] ;
							if (preg_match ('/jpeg|jpg|png|svg|gif/i', $url)) {
                                $this->saveFile( $url );
							}
						}
					}
				}
				$this->addLog ("finishing task successfully") ;
				return true ;
			}
		}
	}

    /**
     * saveFile
     *
     * simple wrapper for Http::get & file_put_content. some basic checking is
     * provided.
     *
     * @author eloy@wikia
     * @access public
     *
     * @param string $url: image url
     * @param string $path: image local path, if null will take last part of url
     *
     * @return bollean: status
     */
    private function saveFile($url, $path = null )
    {
        if ( is_null( $path) ) {
            $aElements = explode( "/", $url );
            $path = array_pop( $aElements );
            $path = sprintf( "%s/%s", $this->getTaskDirectory(), $path );
        }
        $mStatus = file_put_contents( $path, Http::get($url, 60) );
        if ( ! empty( $mStatus ) ) {
            $this->addLog( "Store {$url} as {$path} OK" );
            return true;
        }
        else {
            $this->addLog( "Store {$url} as {$path} FAILED" );
            return false;
        }
    }

	/**
	 * the real deal
	 */
	function execute ($params = null)
    {
        echo "Hi! its ".__METHOD__."\n";

		$this->mTaskID = $params->task_id;
		$data = unserialize ($params->task_arguments) ;
		$sourceWiki = $data ["source_wiki"] ;

        $this->mBaseUrl = $sourceWiki;

		if  ( $this->listImages( $sourceWiki ) ) {
			return true ;
		}
        else {
			return false ;
		}
	}

	function getForm ($title, $data = false ) {
		global $wgOut;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/ImageGrabberTask/" );
		$oTmpl->set_vars( array(
			"data" => $data ,
			"type" => $this->mType ,
			"title" => $title ,
			"desc" => wfMsg ("imagegrabbertask_add")
		));
		return $oTmpl->execute( "form" ) ;
	}

	function getType()
	{
		return $this->mType;
	}

	function isVisible()
	{
		return $this->mVisible;
	}

	/**
	 * submitForm
	 *
	 * write task parameters to database or return to form if errors
	 *
	 * @access public
	 * @author bartek@wikia
	 * @author eloy@wikia
	 *
	 * @return boolean: status of operation; true if success, false otherwise
	 */ 
	function submitForm()
	{
		global $wgRequest, $wgOut, $IP, $wgUser ;

		#---
		# used fields
		# "task-source-wiki" - name of source wiki
		# "task-auto-import" - checkbox, automatically create an image import task after this one
		$autoImport = $wgRequest->getCheck( "task-auto-import" );
		$sourceWiki = $wgRequest->getText ("task-source-wiki") ;

		if ( empty($sourceWiki) ) {
			$aFormData = array();
			$aFormData["errors"] = array();
			$aFormData["values"] = array(
				"task-auto-import" => $autoImport,
				"task-source-wiki" => $sourceWiki
			);

			if ( empty($sourceWiki) ) {
				$aFormData["errors"]["task-source-wiki"] = "This field must not be empty.";
			}
			return $aFormData;
		}
		else {
            $this->createTask( array(
                "auto_import" => $autoImport,
				"source_wiki" => $sourceWiki
			));
			$wgOut->addHTML("<div class=\"successbox\" style=\"clear:both;\">Task added</div><hr style=\"clear: both;\"/>");
			return true ;
 		}
	}

}
