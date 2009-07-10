<?php

if (!defined( 'MEDIAWIKI' ))
	die();

class AbuseFilterViewList extends AbuseFilterView {
	function show( ) {
		global $wgUser, $wgOut, $wgRequest;

		$sk = $wgUser->getSkin();
		
		// Status info...
		$this->showStatus();
		
		$wgOut->addWikiMsg( 'abusefilter-intro' );

		// New filter button
		$sk = $wgUser->getSkin();
		if ($this->canEdit()) {
			$title = $this->getTitle( 'new' );
			$link = $sk->link( $title, wfMsg( "abusefilter-new" ) );
			$links = Xml::tags( 'p', null, $link ) . "\n";
			$wgOut->addHTML( $links );
		}

		// Options.
		$conds = array();
		$deleted = $wgRequest->getVal( 'deletedfilters' );
		$hidedisabled = $wgRequest->getBool( 'hidedisabled' );
		if ($deleted == 'show') {
			## Nothing
		} elseif ($deleted == 'only') {
			$conds['af_deleted'] = 1;
		} else { ## hide, or anything else.
			$conds['af_deleted'] = 0;
			$deleted = 'hide';
		}
		if ($hidedisabled) {
			$conds['af_deleted'] = 0;
			$conds['af_enabled'] = 1;
		}

		$this->showList( $conds, compact( 'deleted', 'hidedisabled' ) );
	}

	function showList( $conds = array( 'af_deleted' => 0 ), $optarray = array() ) {
		global $wgOut,$wgUser;

		$sk = $this->mSkin = $wgUser->getSkin();

		$output = '';
		$output .= Xml::element( 'h2', null, 
			wfMsgExt( 'abusefilter-list', array( 'parseinline' ) ) );

		$pager = new AbuseFilterPager( $this, $conds );

		extract($optarray);

		## Options form
		$options = '';
		$fields = array();
		$fields['abusefilter-list-options-deleted'] = 
			Xml::radioLabel( 
				wfMsg( 'abusefilter-list-options-deleted-show' ), 
				'deletedfilters', 
				'show', 
				'mw-abusefilter-deletedfilters-show', 
				$deleted == 'show' 
			) .
			Xml::radioLabel( 
				wfMsg( 'abusefilter-list-options-deleted-hide' ), 
				'deletedfilters', 
				'hide', 
				'mw-abusefilter-deletedfilters-hide', 
				$deleted == 'hide' 
			) .
			Xml::radioLabel( 
				wfMsg( 'abusefilter-list-options-deleted-only' ), 
				'deletedfilters', 
				'only', 
				'mw-abusefilter-deletedfilters-only', 
				$deleted == 'only' );
		$fields['abusefilter-list-options-disabled'] = 
			Xml::checkLabel( 
				wfMsg( 'abusefilter-list-options-hidedisabled' ), 
				'hidedisabled', 
				'mw-abusefilter-disabledfilters-hide', 
				$hidedisabled 
			);
		$fields['abusefilter-list-limit'] = $pager->getLimitSelect();

		$options = Xml::buildForm( $fields, 'abusefilter-list-options-submit' );
		$options .= Xml::hidden( 'title', $this->getTitle()->getPrefixedText() );
		$options = Xml::tags( 'form', 
			array( 
				'method' => 'get', 
				'action' => $this->getTitle()->getFullURL() 
			), 
			$options );
		$options = Xml::fieldset( wfMsg( 'abusefilter-list-options' ), $options );

		$output .= $options;

		$output .=
			$pager->getNavigationBar() .
			$pager->getBody() .
			$pager->getNavigationBar();

		$wgOut->addHTML( $output );
	}

	function showStatus() {
		global $wgMemc,$wgAbuseFilterConditionLimit,$wgOut, $wgLang;

		$overflow_count = (int)$wgMemc->get( AbuseFilter::filterLimitReachedKey() );
		$match_count = (int) $wgMemc->get( AbuseFilter::filterMatchesKey() );
		$total_count = (int)$wgMemc->get( AbuseFilter::filterUsedKey() );

		if ($total_count>0) {
			$overflow_percent = sprintf( "%.2f", 100 * $overflow_count / $total_count );
			$match_percent = sprintf( "%.2f", 100 * $match_count / $total_count );

			$status = wfMsgExt( 'abusefilter-status', array( 'parseinline' ),
				$wgLang->formatNum($total_count),
				$wgLang->formatNum($overflow_count),
				$wgLang->formatNum($overflow_percent),
				$wgLang->formatNum($wgAbuseFilterConditionLimit),
				$wgLang->formatNum($match_count),
				$wgLang->formatNum($match_percent)
			);

			$status = Xml::tags( 'div', array( 'class' => 'mw-abusefilter-status' ), $status );
			$wgOut->addHTML( $status );
		}
	}
}


// Probably no need to autoload this class, as it will only be called from the class above.
class AbuseFilterPager extends TablePager {

	function __construct( $page, $conds ) {
		$this->mPage = $page;
		$this->mConds = $conds;
		parent::__construct();
	}

	function getQueryInfo() {
		$dbr = wfGetDB( DB_SLAVE );
		$abuse_filter = $dbr->tableName( 'abuse_filter' );
		return array( 
			'tables' => array('abuse_filter'),
			'fields' => array( 
				'af_id', 
				'af_enabled',
				'af_deleted',
				'af_global',
			 	'af_public_comments', 
				'af_hidden', 
				'af_hit_count', 
				'af_timestamp', 
				'af_user_text', 
				'af_user', 
				'af_actions' 
			),
			'conds' => $this->mConds,
		);
	}

	function getFieldNames() {
		static $headers = null;

		if (!empty($headers)) {
			return $headers;
		}

		$headers = array( 
			'af_id' => 'abusefilter-list-id', 
			'af_public_comments' => 'abusefilter-list-public', 
			'af_actions' => 'abusefilter-list-consequences', 
			'status' => 'abusefilter-list-status', 
			'af_timestamp' => 'abusefilter-list-lastmodified', 
			'af_hidden' => 'abusefilter-list-visibility', 
			'af_hit_count' => 'abusefilter-list-hitcount' );

		$headers = array_map( 'wfMsg', $headers );

		return $headers;
	}

	function formatValue( $name, $value ) {
		global $wgOut,$wgLang;

		static $sk=null;

		if (empty($sk)) {
			global $wgUser;
			$sk = $wgUser->getSkin();
		}

		$row = $this->mCurrentRow;

		switch($name) {
			case 'af_id':
				return $sk->link( 
					SpecialPage::getTitleFor( 'AbuseFilter', intval($value) ), intval($value) );
			case 'af_public_comments':
				return $sk->link( 
					SpecialPage::getTitleFor( 'AbuseFilter', intval($row->af_id) ), 
					$wgOut->parseInline( $value ) 
				);
			case 'af_actions':
				$actions = explode(',', $value);
				$displayActions = array();
				foreach( $actions as $action ) {
					$displayActions[] = AbuseFilter::getActionDisplay( $action );;
				}
				return htmlspecialchars( implode( ', ', $displayActions ) );
			case 'status':
				$statuses = array();
				if ($row->af_deleted)
					$statuses[] = wfMsgExt( 'abusefilter-deleted', 'parseinline' );
				elseif ($row->af_enabled)
					$statuses[] = wfMsgExt( 'abusefilter-enabled', 'parseinline' );
				else
					$statuses[] = wfMsgExt( 'abusefilter-disabled', 'parseinline' );
				
				global $wgAbuseFilterIsCentral;
				if ($row->af_global && $wgAbuseFilterIsCentral)
					$statuses[] = wfMsgExt( 'abusefilter-status-global', 'parseinline' );
					
				return $wgLang->commaList( $statuses );
			case 'af_hidden':
				$msg = $value ? 'abusefilter-hidden' : 'abusefilter-unhidden';
				return wfMsgExt( $msg, 'parseinline' );
			case 'af_hit_count':
				$count_display = wfMsgExt( 
					'abusefilter-hitcount', 
					array( 'parseinline' ), 
					$wgLang->formatNum( $value ) 
				);
				$link = $sk->makeKnownLinkObj( 
					SpecialPage::getTitleFor( 'AbuseLog' ), 
					$count_display, 
					'wpSearchFilter='.$row->af_id 
				);
				return $link;
			case 'af_timestamp':
				$userLink = 
					$sk->userLink( 
						$row->af_user, 
						$row->af_user_text 
					) . 
					$sk->userToolLinks( 
						$row->af_user, 
						$row->af_user_text 
					);
				$user = $row->af_user_text;
				return wfMsgExt( 
					'abusefilter-edit-lastmod-text', 
					array( 'replaceafter', 'parseinline' ), 
					array( $wgLang->timeanddate( $value, true ),
						$userLink,
						$wgLang->date( $value, true ),
						$wgLang->time( $value, true ),
						$user ) 
				);
			default:
				throw new MWException( "Unknown row type $name!" );
		}
	}

	function getDefaultSort() {
		return 'af_id';
	}

	function getRowClass( $row ) {
		if ($row->af_enabled) {
			return 'mw-abusefilter-list-enabled';
		} elseif ($row->af_deleted) {
			return 'mw-abusefilter-list-deleted';
		} else {
			return 'mw-abusefilter-list-disabled';
		}
	}

	function isFieldSortable($name) {
		$sortable_fields = array( 
			'af_id', 
			'status', 
			'af_hit_count', 
			'af_throttled', 
			'af_user_text', 
			'af_timestamp' );
		return in_array( $name, $sortable_fields );
	}
}
