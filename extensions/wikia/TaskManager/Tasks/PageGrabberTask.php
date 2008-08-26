<?php
/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Inez Korczyński (inez@wikia.com)
 * @copyright (C) 2007, Wikia Inc.
 * @license GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

class PageGrabberTask extends BatchTask {

	public $mType, $mVisible, $mSourceWikiUrl, $mErrors, $mParams, $mWorkDir;

	/* constructor */
	function __construct () {
		$this->mType = 'pagegrabber' ;
		$this->mVisible = true ;
		parent::__construct () ;
	}

	function listPages() {

		ini_set( 'allow_url_fopen', 1 );
		// First get the namespace list
		$html = file_get_contents( $this->mSourceWikiUrl . "?title=Special:Allpages" );

		if(!$html) {
			$this->mErrors[] = "Unable to get namespace list";
			return false;
		}

		$doc = new DOMDocument;
		@$doc->loadHTML( $html );
		$xpath = new DOMXPath( $doc );
		$options = $xpath->query( '//option' );
		$this->namespaces = array();
		foreach ( $options as $option ) {
			$namespaceID = intval( $option->getAttribute( 'value' ) );
			$namespaceName = $option->textContent;
			if ( $namespaceID != 8 && $namespaceID != 9 ) {
				$this->namespaces[$namespaceID] = $namespaceName;
			}
		}

		$urlParts = parse_url( $this->mSourceWikiUrl );
		$server = "{$urlParts['scheme']}://{$urlParts['host']}";

		$pageList = '';

		$file = fopen( $this->mWorkDir . "/pages.txt", "w" );
		$wikilinkfile = fopen( $this->mWorkDir . "/wikilinkedpages.txt", "w" );

		foreach ( $this->namespaces as $namespaceID => $namespaceName ) {
			$html = Http::get( $this->mSourceWikiUrl . "?title=Special:Allpages&namespace=$namespaceID", 60 );
			$doc = new DOMDocument;
			@$doc->loadHTML( $html );
			$xpath = new DOMXPath( $doc );
			$tables = $xpath->query( '//table' );
			if ($tables->item (1)->getAttribute ( "id" ) !="nsselect") {
				$rows= $xpath->query( './/tr',$tables->item (1) );
				$links=array ();
				foreach ( $rows as $row ) {
					$link = $xpath->query( './/a',$row )->item( 0 );
					$url = $server . $link->getAttribute ("href");
					$links = array_merge($links, $this->getlinksfromurl($url,$namespaceID));
				}
			} else {
				$links = $this->getlinksfromdocument ($doc,$namespaceID);
			}
			if ( $links ) {
				fwrite( $file, implode ("\r\n",$links)."\r\n" );
				fwrite( $wikilinkfile, "# [[" . implode("]]\r\n# [[", $links ) . "]]\r\n" );
			}
		}

		fclose( $file );
		fclose( $wikilinkfile );

		return true;
	}

	function getlinksfromurl ($url,$namespaceID) {
		$html = Http::get( $url, 120 );
		$doc = new DOMDocument;
		@$doc->loadHTML( $html );
		return $this->getlinksfromdocument ($doc,$namespaceID);
	}

	function getlinksfromdocument ($doc,$namespaceID) {
		$xpath = new DOMXPath( $doc );
		$table = $xpath->query( '//table' )->item( 2 );
		$links = $xpath->query( './/a', $table );
		$linksarray=array ();
		foreach ( $links as $link ) {
			if ( $namespaceID == 0 ) {
				$title = $link->textContent;
			} else {
				$title = $this->namespaces[$namespaceID] . ':' . $link->textContent;
			}
			$linksarray[] = $title;
		}
		return $linksarray;
	}

	/**
	 * execute
	 *
	 * Main entry point, TaskManagerExecutor run this method
	 *
	 * @access public
	 * @author Inez Korczynski (inez@wikia.com)
	 * @author bartek@wikia
	 * @author eloy@wikia
	 *
	 * @param mixed $params default null: task params from wikia_tasks table
	 *
	 * @return boolean: status of operation, true = success, false = failure
	 */
	public function execute ($params = null) {
		$this->mParams = $params;
		$this->mTaskID = $params->task_id;

		$aArgs = unserialize($params->task_arguments);
		$this->mSourceWikiUrl = $aArgs["source-wiki-url"];
		$this->mWorkDir = $this->getTaskDirectory();
		if ( $this->listPages() ) {
			return true;
		}
		return false;
	}

	function getForm ($title, $data = false ) {
		global $wgOut;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/PageGrabberTask/" );
		$oTmpl->set_vars( array(
					"data" => $data ,
					"type" => $this->mType ,
					"title" => $title ,
					"desc" => wfMsg ("pagegrabbertask_add")
				       ));
		return $oTmpl->execute( "form" ) ;
	}

	function getType() {
		return $this->mType;
	}

	function isVisible() {
		return $this->mVisible;
	}

	/**
	 * submitForm
	 *
	 * write task parameters to database or return to form if errors
	 *
	 * @access public
	 * @author Inez Korczynski (inez@wikia.com)
	 * @author bartek@wikia
	 * @author eloy@wikia
	 *
	 * @return boolean: status of operation; true if success, false otherwise
	 */ 
	public function submitForm() {
		global $wgRequest, $wgOut;

		$sourceWikiUrl = $wgRequest->getVal("task-source-wiki-url"); // url to source wiki

		if(empty($sourceWikiUrl)) {
			$aFormData = array();
			$aFormData["errors"]["task-source-wiki-url"] = "This field must not be empty.";
			$aFormData["values"]["task-source-wiki-url"] = $sourceWikiUrl;
			return $aFormData;
		} else {
			$this->createTask( array("source-wiki-url" => $sourceWikiUrl) );
			$wgOut->addHTML("<div class=\"successbox\" style=\"clear:both;\">Task added</div><hr style=\"clear: both;\"/>");
			return true ;
		}
	}
}
