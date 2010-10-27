<?php

/**
 * Show a formatted view of the wikia_mailer table
 */


$wgSpecialPages[ "MailerLog" ] = "SpecialMailerLog";
	
class SpecialMailerLog extends UnlistedSpecialPage {
	private static $link_cache = array();

	public function __construct() {
		parent::__construct( 'MailerLog' );
	}

	public function execute( $subpage ) {
		global $wgOut, $wgUser, $wgCityId, $wgMessageCache, $wgRequest, $wgStyleVersion, $wgStylePath, $wgScriptPath;

		wfProfileIn( __METHOD__ );

		if ( !$wgUser || $wgUser->getID() == 0 ) {
			$login = SpecialPage::getTitleFor( 'UserLogin' );
			$wgOut->redirect( $login->getFullURL( 'returnto=Special:MailerLog' ) );
			return false;
		}

		// Setup extra resources
		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/SpecialMailerLog/css/oasis.scss' ) );

		// Keep track of the query parameters we need to add back to any URLs we write on this page
		$query = array();
		$filter_roster = array();

		// Create an array of filters based on was was passed to us
		$filter = self::getFilters(&$query, &$filter_roster);
	
		// Set sorting and page length
		$sort     = $wgRequest->getVal('new_sort', $wgRequest->getVal('sort', 'created'));
		$sort_dir = $wgRequest->getVal('new_sort_dir', $wgRequest->getVal('sort_dir', 'desc'));
		$limit    = $wgRequest->getVal('new_limit', $wgRequest->getVal('limit', 100));
		$offset   = $wgRequest->getVal('new_offset', $wgRequest->getVal('offset', '0'));

		// Add sorting terms
		if ($sort) $query[]     = "sort=$sort";
		if ($sort_dir) $query[] = "sort_dir=$sort_dir";

		// Make 500 a hard upper limit
		$limit = $limit > 500 ? 500 : $limit;
		if ($limit) $query[] = "limit=$limit";
		if ($offset) $query[] = "offset=$offset";

		$dbr = wfGetDB( DB_SLAVE, array(), 'wikia_mailer' );

		$num_rows = $dbr->selectField( 'mail', 'COUNT(*)', $filter, __METHOD__ );

		$res = $dbr->select( 'mail',
							 array( 'id', 'created', 'city_id', 'dst', 'hdr', 'subj', 'msg', 'locked', 'transmitted', 'is_error', 'error_status', 'error_msg', 'opened'),
							 $filter,
							 __METHOD__,
							 array('ORDER BY' => $sort.' '.$sort_dir,
							       'LIMIT'    => $limit,
							       'OFFSET'   => $offset,
							       )
						   );

		$mail_records = array();
		while ($row = $dbr->fetchObject($res)) {
			$body = self::getBody($row->msg);
			
			$mail_records[] = array('id'           => $row->id,
									'created'      => $row->created,
									'city_id'      => $row->city_id,
									'wiki_name'    => Wikifactory::IdtoDB( $row->city_id ),
									'to'           => $row->dst,
									'user_url'     => self::getUserURL($row->dst),
									'subject'      => $row->subj,
									'msg_full'     => $body,
									'msg_short'    => self::getShortBody($body),
									'attempted'    => $row->locked,
									'transmitted'  => $row->transmitted,
									'is_error'     => $row->is_error,
									'error_status' => $row->error_status,
									'error_msg'    => $row->error_msg,
									'opened'       => $row->opened,
								   );
		}

		$titleObj = SpecialPage::getTitleFor( "MailerLog" );
		$scriptURL = $titleObj->getLocalURL();

		$query_string = join('&', $query);

    	// Create a template object and give it all the data it needs
    	$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
    	$oTmpl->set_vars(array('wgUser'       => $wgUser,
    						   'wgStylePath'  => $wgStylePath,
    						   'records'      => $mail_records,
    						   'scriptURL'    => $scriptURL,
    						   'query_string' => $query_string,
       						   'cur_limit'    => $limit,
    						   'num_rows'     => $num_rows,
    						   'cur_offset'   => $offset,
       						   'query'        => $query,
       						   'filter_roster' => $filter_roster,
   						));
	    $wgOut->addHtml($oTmpl->execute("wikia-mailer-log"));

		wfProfileOut( __METHOD__ );
	}
	
	private function getBody ( $raw_body ) {
		// PHP doesn't seem to support backreferences in the pattern so this regex could
		// techinally be fooled if something looking like a boundary string appears within
		// the message.  Oh well.
		if (preg_match('/^--=_[a-f0-9]+(.+?)--=_[a-f0-9]+/s', $raw_body, $matches)) {
			$body = $matches[1];
			while (preg_match('/^[^:]+:\s+[^\n]+/', $body)) {
				$body = preg_replace('/^[^:]+:\s+[^\n]+/', '', $body);
			}
		} else {
			$body = $raw_body;
		}
		
		return $body;
	}
	
	private function getShortBody ( $body ) {

		// Match 70 chars plus any remaining non-whitespace (to finish any words)
		if (preg_match('/^(.{70}\S*)/s', $body, $matches)) {
			$body_short = $matches[1].'...';
		} else {
			$body_short = $body;
		}

		return $body_short;
	}

	private function getUserURL ( $email ) {
		$dbr_user = wfGetDB( DB_SLAVE );

		if (array_key_exists($email, self::$link_cache)) {
			$user_url = $link_cache[$row->dst];
		} else {
			$s = $dbr_user->selectRow( 'user', array( 'user_id' ), array( 'user_email' => $email ), __METHOD__ );
			if ($s) {
				$row_user = User::newFromId( $s->user_id );
				if ($row_user) {
					$user_url = $row_user->getUserPage()->getFullURL();
				}
			}

			if (isset($user_url)) {
				$link_cache[$email] = $user_url;
			} else {
				$link_cache[$email] = 0;
				$user_url = 0;
			}
		}

		return $user_url;
	}

	private function getFilters ( &$query, &$filter_roster ) {
		global $wgRequest, $wgUser;

		$filter = array();

		$created_type = $wgRequest->getVal('new_created_type',
										   $wgRequest->getVal('created_type', 'exactly'));
		$created_num  = $wgRequest->getVal('new_created_number',
										   $wgRequest->getVal('created_number', null));
		$created_unit = $wgRequest->getVal('new_created_unit',
										   $wgRequest->getVal('created_unit', 'day'));
		if ($created_num) {
			$filter[] = "DATE(created) ".($created_type == 'exactly' ? '=' : '>=')." DATE(DATE_SUB(NOW(), INTERVAL $created_num $created_unit))";
			$query[] = "created_type=$created_type";
			$query[] = "created_number=$created_num";
			$query[] = "created_unit=$created_unit";
			if ($created_type == 'exactly') $filter_roster['CreatedTypeExact'] = 1;
			if ($created_type == 'after')   $filter_roster['CreatedTypeAfter'] = 1;
			if ($created_unit == 'day')     $filter_roster['CreatedUnitDays']  = 1;
			if ($created_unit == 'week')    $filter_roster['CreatedUnitWeeks'] = 1;
			$filter_roster['CreatedNum'] = $created_num;
		}

		$attempted_type = $wgRequest->getVal('new_attempted_type',
										   $wgRequest->getVal('attempted_type', 'exactly'));
		$attempted_num  = $wgRequest->getVal('new_attempted_number',
										   $wgRequest->getVal('attempted_number', null));
		$attempted_unit = $wgRequest->getVal('new_attempted_unit',
										   $wgRequest->getVal('attempted_unit', 'day'));
		if ($attempted_num) {
			$filter[] = "DATE(attempted) ".($attempted_type == 'exactly' ? '=' : '>=')." DATE(DATE_SUB(NOW(), INTERVAL $attempted_num $attempted_unit))";
			$query[] = "attempted_type=$attempted_type";
			$query[] = "attempted_number=$attempted_num";
			$query[] = "attempted_unit=$attempted_unit";
			if ($attempted_type == 'exactly') $filter_roster['AttemptedTypeExact'] = 1;
			if ($attempted_type == 'after')   $filter_roster['AttemptedTypeAfter'] = 1;
			if ($attempted_unit == 'day')     $filter_roster['AttemptedUnitDays']  = 1;
			if ($attempted_unit == 'week')    $filter_roster['AttemptedUnitWeeks'] = 1;
			$filter_roster['attemptedNum'] = $attempted_num;
		}

		$transmitted_type = $wgRequest->getVal('new_transmitted_type',
										   $wgRequest->getVal('transmitted_type', 'exactly'));
		$transmitted_num  = $wgRequest->getVal('new_transmitted_number',
										   $wgRequest->getVal('transmitted_number', null));
		$transmitted_unit = $wgRequest->getVal('new_transmitted_unit',
										   $wgRequest->getVal('transmitted_unit', 'day'));
		if ($transmitted_num) {
			$filter[] = "DATE(transmitted) ".($transmitted_type == 'exactly' ? '=' : '>=')." DATE(DATE_SUB(NOW(), INTERVAL $transmitted_num $transmitted_unit))";
			$query[] = "transmitted_type=$transmitted_type";
			$query[] = "transmitted_number=$transmitted_num";
			$query[] = "transmitted_unit=$transmitted_unit";
			if ($transmitted_type == 'exactly') $filter_roster['TransmittedTypeExact'] = 1;
			if ($transmitted_type == 'after')   $filter_roster['TransmittedTypeAfter'] = 1;
			if ($transmitted_unit == 'day')     $filter_roster['TransmittedUnitDays']  = 1;
			if ($transmitted_unit == 'week')    $filter_roster['TransmittedUnitWeeks'] = 1;
			$filter_roster['TransmittedNum'] = $transmitted_num;
		}
		
		$filter_wiki_name = $wgRequest->getVal('new_filter_wiki_name', null);
		if ($filter_wiki_name) {
			$filter_wiki_name = preg_replace('!^http://|/$!', '', $filter_wiki_name);
			$filter_wiki_name = preg_replace('!\.wikia\.com!', '', $filter_wiki_name);

			$wgRequest->setVal('new_filter_wiki_id', Wikifactory::DBtoId( $filter_wiki_name ));
		}

		$filter_wiki_id = $wgRequest->getVal('new_filter_wiki_id',
											 $wgRequest->getVal('filter_wiki_id', null));
		$filter_dst    = $wgRequest->getVal('new_filter_dst',
											 $wgRequest->getVal('filter_dst', null));

		// Force a few values depending on who the viewer is
		if( !$wgUser->isAllowed( "staff" ) ) {
			$filter_dst = $wgUser->getEmail();
			$forced_dst = true;
		}

		if ($wgRequest->getVal('off_filter_wiki_id', null) && !isset($forced_wiki_id)) $filter_wiki_id = null;

		if ($filter_wiki_id) {
			$filter[] = "city_id = $filter_wiki_id";
			if (!isset($forced_wiki_id)) {
				$query[] = "filter_wiki_id=$filter_wiki_id";
				$filter_roster['Wiki'] = array('value' => Wikifactory::IdtoDB( $filter_wiki_id ),
											   'off'   => 'off_filter_wiki_id');
			}
		}
		
		if ($wgRequest->getVal('off_filter_dst', null) && !isset($forced_dst)) $filter_dst = null;
		
		if ($filter_dst) {
			$filter[] = "dst = '$filter_dst'";
			if (!isset($forced_dst)) {
				$query[] = "filter_dst=$filter_dst";
				$filter_roster['Email'] = array('value' => $filter_dst,
												'off'   => 'off_filter_dst');
			}
		}

		$filter_subject = $wgRequest->getVal('new_filter_subject',
											 $wgRequest->getVal('filter_subject', null));

		if ($filter_subject) {
			$filter[] = "subj LIKE '%$filter_subject%'";
			$query[] = "filter_subject=$filter_subject";
			$filter_roster['Subject'] = $filter_subject;
		}

		$filter_body = $wgRequest->getVal('new_filter_body',
										  $wgRequest->getVal('filter_body', null));

		if ($filter_body) {
			$filter[] = "msg LIKE '%$filter_body%'";
			$query[] = "filter_body=$filter_body";
			$filter_roster['Body'] = $filter_body;
		}

		$filter_errors = $wgRequest->getVal('new_filter_errors',
											$wgRequest->getVal('filter_errors', null));
		if ($wgRequest->getVal('off_filter_errors', null)) $filter_errors = null;
		
		if ($filter_errors) {
			$filter[] = 'error_msg IS NOT NULL';
			$query[] = "filter_errors=$filter_errors";
			$filter_roster['Errors'] = 'Show';
		}

		return $filter;
	}
}