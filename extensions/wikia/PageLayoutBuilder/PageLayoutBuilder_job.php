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

	private
		$mUserId,
		$mUserName,
		$mUserIP,
		$mUser,
		$mAnon,
		$mSysop;

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
		global $wgUser, $wgTitle, $wgErrorLog;

		wfProfileIn( __METHOD__ );

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
