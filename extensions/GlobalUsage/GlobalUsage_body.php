<?php

class GlobalUsage extends SpecialPage {
	private static $database = array();
	private static $interwiki = null;

	function __construct() {
		parent::__construct('GlobalUsage');
		wfLoadExtensionMessages( 'GlobalUsage' );
	}
	
	static function getDatabase( $dbFlags = DB_MASTER ) {
		global $wgguIsMaster, $wgguMasterDatabase;
		if ( !isset( self::$database[$dbFlags] ) )
			self::$database[$dbFlags] = wfGetDB( $dbFlags, array(), $wgguMasterDatabase );
		return self::$database[$dbFlags];
	}
	static function getLocalInterwiki() {
		global $wgguInterwikiStyle, $wgLocalInterwiki, $wgServerName;
		if (!self::$interwiki) {
			switch ($wgguInterwikiStyle) {
				case GUIW_LOCAL:
					self::$interwiki = $wgLocalInterwiki;
					break;
				case GUIW_SERVER_NAME:
					self::$interwiki = $wgServerName;
					break;
				default:
					self::$interwiki = $wgLocalInterwiki;
			}
		}
		return self::$interwiki;
	}
	
	static function updateLinks( $linksUpdater ) {
		$title = $linksUpdater->getTitle();
		$dbr = wfGetDB(DB_SLAVE);
		$dbw = self::getDatabase();
		$dbw->immediateBegin();
		self::doUpdate($title->getArticleID(), self::getLocalInterwiki(),
			$title->getNsText(), $title->getDBkey(), $dbr, $dbw );
		$dbw->immediateCommit();
		
		return true;
	}
	
	/*
	 * Perform the update for a certain page on a certain database. The caller is
	 * responsible for creating a master datbase object and performing 
	 * immediateBegin() and immediateCommit().
	 */
	static function doUpdate( $pageId, $wiki, $pageNamespace, $pageTitle, 
			&$dbr, &$dbw ) {
		$query = 'SELECT il_to, img_name IS NOT NULL AS is_local '.
			'FROM '.$dbr->tableName('imagelinks').' '.
			'LEFT JOIN '.$dbr->tableName('image').' ON '. 
			'il_to = img_name WHERE il_from = '.$pageId;
		$res = $dbr->query($query, __METHOD__);
		
		$rows = array();
		while ($row = $res->fetchRow()) {
			$rows[] = array(
				"gil_wiki" => $wiki, 
				"gil_page" => $pageId,
				"gil_page_namespace" => $pageNamespace,
				"gil_page_title" => $pageTitle,
				"gil_to" => $row['il_to'],
				"gil_is_local" => $row['is_local']);
		}
		$res->free();
		
		$dbw->delete('globalimagelinks', array(
			'gil_wiki' => $wiki, 'gil_page' => $pageId),
			__METHOD__);
		$dbw->insert( 'globalimagelinks', $rows, __METHOD__, 'IGNORE' );
	}
	
	
	// Set gil_is_local for an image
	static function setLocalFlag( $imageName, $isLocal ) {
		$dbw = self::getDatabase();
		$dbw->immediateBegin();
		$dbw->update( 'globalimagelinks', array( 'gil_is_local' => $isLocal ), array(
				'gil_wiki' => self::getLocalInterwiki(),
				'gil_to' => $imageName),
			__METHOD__ );
		$dbw->immediateCommit();
	}
	
	// Set gil_is_local to false
	static function fileDeleted( &$file, &$oldimage, &$article, &$user, $reason ) {
		if ( !$oldimage ) 
			self::setLocalFlag( $article->getTitle()->getDBkey(), 0 );
		return true;
	}
	// Set gil_is_local to true
	static function fileUndeleted( &$title, $versions, &$user, $reason ) {
		self::setLocalFlag( $title->getDBkey(), 1 );
		return true;
	}
	static function imageUploaded( $uploadForm ) {
		$imageName = $uploadForm->mLocalFile->getTitle()->getDBkey();		
		self::setLocalFlag( $imageName, 1 );
		return true;		
	}	
	
		
	static function articleDeleted( &$article, &$user, $reason ) {
		$dbw = self::getDatabase();
		$dbw->immediateBegin();
		$dbw->delete( 'globalimagelinks', array(
				'gil_wiki' => self::getLocalInterwiki(),
				// Use GAID_FOR_UPDATE to make sure the old id is fetched from 
				// the link cache
				'gil_page' => $article->getTitle()->getArticleId(GAID_FOR_UPDATE)),
			__METHOD__ );
		$dbw->immediateCommit();
		
		return true;
	}
	
	static function articleMoved( &$movePageForm, &$from, &$to ) {
		$dbw = self::getDatabase();
		$dbw->immediateBegin();
		$dbw->update( 'globalimagelinks', array(
				'gil_page_namespace' => $to->getNsText(),
				'gil_page_title' => $to->getDBkey()
			), array(
				'gil_wiki' => self::getLocalInterwiki(),
				'gil_page' => $to->getArticleId()
			), __METHOD__ );
		$dbw->immediateCommit();
		
		return true;
	}

	public function execute( $par ) {	
		global $wgOut, $wgScript, $wgRequest;
		
		$this->setHeaders();
		
		$self = Title::makeTitle( NS_SPECIAL, 'GlobalUsage' );
		$target= Title::makeTitleSafe( NS_IMAGE, $wgRequest->getText( 'target', $par ) );
		
		$wgOut->addWikiText( wfMsg( 'globalusage-text' ) );
		
		$form = Xml::openElement( 'form', array( 
			'id' => 'mw-globalusage-form',
			'method' => 'get', 
			'action' => $wgScript ));
		$form .= Xml::hidden( 'title', $self->getPrefixedDbKey() );
		$form .= Xml::openElement( 'fieldset' );
		$form .= Xml::element( 'legend', array(), wfMsg( 'globalusage' ));
		$form .= Xml::inputLabel( wfMsg( 'filename' ), 'target', 
			'target', 50, $target->getDBkey() );
		$form .= Xml::submitButton( wfMsg( 'globalusage-ok' ) );
		$form .= Xml::closeElement( 'fieldset' );
		$form .= Xml::closeElement( 'form' );
		
		$wgOut->addHtml( $form );
		
		if ( !$target->getDBkey() ) return;
		
		$dbr = self::getDatabase( DB_SLAVE );
		$res = $dbr->select( 'globalimagelinks',
			array( 'gil_wiki', 'gil_page_namespace', 'gil_page_title' ),
			array( 'gil_to' => $target->getDBkey(), 'gil_is_local' => 0 ),
			__METHOD__ );
			
		// Quick dirty list output
		while ( $row = $dbr->fetchObject($res) )
			$wgOut->addWikiText(self::formatItem( $row ) );
		$dbr->freeResult($res);
	}
	
	public static function formatItem( $row ) {
		$out = '* [[';
		if ( self::getLocalInterwiki() != $row->gil_wiki )
			$out .= ':'.$row->gil_wiki;
		if ( $row->gil_page_namespace )
			$out .= ':'.str_replace('_', ' ', $row->gil_page_namespace);
		$out .= ':'.str_replace('_', ' ', $row->gil_page_title)."]]\n";
		return $out;
	}
}
