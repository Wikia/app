<?php
if (!defined('MEDIAWIKI'))
	die();

class SpecialDeleteQueue extends SpecialPage {
	function __construct() {
		parent::__construct( 'DeleteQueue' );
	}

	public function execute( $par ) {
		global $wgOut;

		wfLoadExtensionMessages('DeleteQueue');
		$wgOut->setPageTitle( wfMsg( 'deletequeue' ) );

		$this->loadSearch();

		// Intro text
		$wgOut->addWikiMsg( 'deletequeue-list-text' );

		// Search box
		$searchBox = array();

		//// Queue selector
		$selector = Xml::openElement( 'select', array( 'name' => 'queue' ) ) . "\n";
		$queues = array( 'speedy', 'prod', 'deletediscuss' );
		$attribs = array( 'value' => '' );
		if ( in_array( $this->mQueue, $queues ) )
			$attribs['selected'] = 'selected';
		$selector .= Xml::element( 'option', $attribs, wfMsg( 'deletequeue-list-anyqueue' ) );
		foreach( $queues as $queue ) {
			$attribs = array( 'value' => $queue );
			if ($this->mQueue == $queue)
				$attribs['selected'] = 'selected';
			$selector .= Xml::element( 'option', $attribs, wfMsg( "deletequeue-queue-$queue" ) );
		}
		$selector .= Xml::closeElement( 'select' );

		$searchBox['deletequeue-list-queue'] = $selector;
		$searchBox['deletequeue-list-status'] = Xml::checkLabel( wfMsg( 'deletequeue-list-expired' ), 'expired', 'mw-dq-expired', $this->mExpired );

		$searchBox = Xml::buildForm( $searchBox, 'deletequeue-list-search' );
		$searchBox .= Xml::hidden( 'title', $this->getTitle()->getPrefixedText() );
		$searchBox = Xml::tags( 'form', array( 'action' => $this->getTitle()->getFullURL(), 'method' => 'get' ), $searchBox );
		$searchBox = Xml::fieldset( wfMsg( 'deletequeue-list-search-legend' ), $searchBox );

		$wgOut->addHTML( $searchBox );

		$conds = array('dq_active' => 1);

		if ($this->mQueue)
			$conds['dq_queue'] = $this->mQueue;

		if ($this->mExpired) {
			$dbr = wfGetDB(DB_SLAVE);
			$conds[] = 'dq_expiry<'.$dbr->addQuotes($dbr->timestamp( wfTimestampNow() ) );
		}

		// Headers

		$body = '';
		$headers = array( 'page', 'queue', 'votes', 'expiry', 'discusspage' );
		foreach( $headers as $header ) {
			$body .= Xml::element( 'th', null, wfMsg( "deletequeue-list-header-$header" ) ) . "\n";
		}

		$body = Xml::tags( 'tr', null, $body );

		// The list itself
		$pager = new DeleteQueuePager($conds);
		$body .= $pager->getBody();
		$body = Xml::tags( 'table', array( 'class' => 'wikitable' ), $body );

		$wgOut->addHTML( $pager->getNavigationBar() . $body . $pager->getNavigationBar() );
	}

	public function loadSearch() {
		global $wgRequest;

		$this->mQueue = $wgRequest->getText( 'queue' );
		$this->mExpired = $wgRequest->getBool( 'expired' );
	}
}

class DeleteQueuePager extends ReverseChronologicalPager {
	function __construct( $conds ) {
		parent::__construct();
		$this->mConds = $conds;
	}

	function formatRow( $row ) {
		static $sk=null;

		if (is_null($sk)) {
			global $wgUser;
			$sk = $wgUser->getSkin();
		}

		$a = Article::newFromID($row->dq_page);
		$t = $a->mTitle;
		$dqi = DeleteQueueItem::newFromArticle( $a );
		$dqi->loadFromRow( $row );
		$queue = $dqi->getQueue();
		global $wgLang;

		if ($dqi->getQueue() == 'deletediscuss') {
			$discusspage = $sk->makeKnownLinkObj( $dqi->getDiscussionPage()->mTitle );
		} else $discusspage = '';

		if ($row->dq_expiry > $row->dq_timestamp) {
			$expirestr = $wgLang->timeanddate( $row->dq_expiry );
		} else $expirestr = '';

		$tr = '';

		$tr .= Xml::tags( 'td', null, $sk->makeKnownLinkObj( $t, $t->getPrefixedText() ) );
		$tr .= Xml::element( 'td', null, wfMsg( "deletequeue-queue-$queue" ) );
		$tr .= Xml::tags( 'td', null, $sk->makeKnownLinkObj( $t, wfMsg( 'deletequeue-list-votecount', $dqi->getActiveEndorseCount(), $dqi->getActiveObjectCount() ), 'action=delviewvotes' ) );
		$tr .= Xml::element( 'td', null, $expirestr );
		$tr .= Xml::tags( 'td', null, $discusspage );

		return Xml::tags( 'tr', null, $tr ) . "\n";
	}

	function getQueryInfo() {
		return array(
			'tables' => 'delete_queue',
			'fields' => '*',
			'conds' => $this->mConds,
		);
	}

	function getIndexField() {
		return 'dq_case';
	}
}
