<?php

/**
 * PageLayoutBuilderJob 
 *
 * @file
 * @ingroup JobQueue
 *
 * @author Piotr Molski (MoLi) <moli@wikia-inc.com>
 * @date 2010-10-20
 * @version 0.1
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

$wgExtensionCredits['other'][] = array(
	'name' => 'PageLayoutBuilderJob',
	'version' => '0.1',
	'author' => array('Piotr Molski'),
	'description' => 'Page layout builder job',
);

$wgHooks					[ "RevisionInsertComplete" ][]	= "PageLayoutBuilderJob::revisionInsertComplete";
$wgJobClasses				[ "PageLayoutBuilder" ] 		= "PageLayoutBuilderJob";
$wgExtensionMessagesFiles	[ "PageLayoutBuilder" ]			= dirname(__FILE__) . '/PageLayoutBuilder.i18n.php';

class PageLayoutBuilderJob extends Job {

	const WELCOMEUSER = "Wikia";
	const PBLAYOUT = "PageLayoutBuilder";
	const NS_LAYOUT = 902;

	/**
	 * Construct a job
	 *
	 * @param Title $title The title linked to
	 * @param array $params Job parameters (table, start and end page_ids)
	 * @param integer $id job_id
	 */
	public function __construct( $title, $params, $id = 0 ) {
		wfLoadExtensionMessages( self::PBLAYOUT );
		parent::__construct( self::PBLAYOUT, $title, $params, $id );
	}

	/**
	 * main entry point
	 *
	 * @access public
	 */
	public function run() {
		global $wgUser, $wgTitle, $wgErrorLog, $wgParser;

		wfProfileIn( __METHOD__ );

		$oldValue = $wgErrorLog;
		$wgErrorLog = true;

		if( is_null( $this->title ) ) {
			$this->error = "PageLayoutBuilder: Invalid title";
			Wikia::log( __METHOD__, "pglayout", "Invalid title" );
			wfProfileOut( __METHOD__ );
			return false;
		}

		$page_id = $this->title->getArticleID();
		if ( empty($page_id) ) {
			$page_id = $this->title->getArticleID(GAID_FOR_UPDATE);			
		}
		if( empty( $page_id ) ) {
			$this->error = "PageLayoutBuilder: Invalid title (identifier not found)";
			Wikia::log( __METHOD__, "pglayout", "Invalid title (identifier not found) ");
			wfProfileOut( __METHOD__ );
			return false;
		}

		$revision = Revision::newFromTitle( $this->title );
		if ( !$revision ) {
			$this->error = "PageLayoutBuilder: Article not found '" . $this->title->getPrefixedDBkey() . "'";
			Wikia::log( __METHOD__, "pglayout", "Article not found '" . $this->title->getPrefixedDBkey() . "'");
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfProfileIn( __METHOD__.'-parse' );
		$options = new ParserOptions;
		$parserOutput = $wgParser->parse( $revision->getText(), $this->title, $options, true, true, $revision->getId() );
		wfProfileOut( __METHOD__.'-parse' );
		
		wfProfileIn( __METHOD__.'-update' );
		$update = new LinksUpdate( $this->title, $parserOutput, false );
		$update->doUpdate();
		wfProfileIn( __METHOD__.'-update' );
		
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 
			array( 'plb_page', 'page' ), 
			array( 'plb_p_page_id', 'page_title', 'page_namespace' ),
			array( 
				'plb_p_layout_id' => $page_id,
				'plb_p_page_id = page_id'
			), 
			__METHOD__
		);

		$jobs = array();
		foreach( $res as $row ) {
			$oTitle = Title::makeTitle( $row->page_namespace, $row->page_title );
			if ( is_null($oTitle) ) {
				Wikia::log( __METHOD__, "pglayout", "{$row->page_title} ({$row->page_namespace}) ");
				continue;				
			}
			$jobs[] = new RefreshLinksJob( $oTitle, '' );
		}
		
		if ( !empty($jobs) ) {
			Job::batchInsert( $jobs );		
		}
		
		$wgErrorLog = $oldValue;

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * revisionInsertComplete
	 *
	 * static method called as hook
	 *
	 * @static
	 * @access public
	 *
	 * @param Revision	$revision	revision object
	 * @param string	$url		url to external object
	 * @param string	$flags		flags for this revision
	 *
	 * @return true means process other hooks
	 */
	public static function revisionInsertComplete( &$revision, $url, $flags ) {
		global $wgUser, $wgCityId, $wgCommandLineMode, $wgSharedDB, $wgErrorLog, $wgMemc;

		wfProfileIn( __METHOD__ );

		$oldValue = $wgErrorLog;
		$wgErrorLog = true;
		if( !wfReadOnly() && ! $wgCommandLineMode ) {
			wfLoadExtensionMessages( self::PBLAYOUT );

			$Title = $revision->getTitle();
			if( !$Title ) {
				$Title = Title::newFromId( $revision->getPage(), GAID_FOR_UPDATE );
				$revision->setTitle( $Title );
			}

			if ( is_object($Title) && ( NS_LAYOUT == $Title->getNamespace() )  ) {	
				Wikia::log( __METHOD__, "pblayout", $Title->getDBkey() );
				$pbLayoutJob = new PageLayoutBuilderJob(
					$Title,
					array(
						"is_anon"   => $wgUser->isAnon(),
						"user_id"   => $wgUser->getId(),
						"user_ip"   => wfGetIP(),
						"user_name" => $wgUser->getName(),
					)
				);
				$pbLayoutJob->insert();
				Wikia::log( __METHOD__, "job" );
			}
		}
		$wgErrorLog = $oldValue;
		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * @access public
	 *
	 * @return Title instance of Title object
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @access private
	 *
	 * @return Title instance of Title object
	 */
	public function getPrefixedText() {
		return $this->title->getPrefixedText();
	}
}
