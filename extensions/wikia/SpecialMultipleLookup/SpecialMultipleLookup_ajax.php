<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension and cannot be used standalone.\n";
	exit( 1 ) ;
}

# ############################# Ajax ##################################
############################## Ajax ##################################
class MultiLookupAjax {
	function __construct() { /* not used */ }

	public static function axData() {
		global $wgRequest, $wgUser,	$wgCityId, $wgDBname, $wgLang, $wgDevelEnvironment;

		wfProfileIn( __METHOD__ );

		$username 	= $wgRequest->getVal('username');
		$dbname		= $wgRequest->getVal('wiki');
		$limit		= $wgRequest->getVal('limit');
		$offset		= $wgRequest->getVal('offset');
		$loop		= $wgRequest->getVal('loop');
		$order		= $wgRequest->getVal('order');
		$numOrder	= $wgRequest->getVal('numOrder');

		$result = array(
			'sEcho' => intval($loop),
			'iTotalRecords' => 0,
			'iTotalDisplayRecords' => 0,
			'sColumns' => '',
			'aaData' => array()
		);

		//$dbname, $username, $mode, $limit = 25, $offset = 0, $nspace = -1

		if ( empty($wgUser) ) {
			wfProfileOut( __METHOD__ );
			return "";
		}
		if ( $wgUser->isBlocked() ) {
			wfProfileOut( __METHOD__ );
			return "";
		}
		if ( !$wgUser->isLoggedIn() ) {
			wfProfileOut( __METHOD__ );
			return "";
		}
		if ( !$wgUser->isAllowed( 'lookupcontribs' ) ) {
			wfProfileOut( __METHOD__ );
			return json_encode($result);
		}

		$oML = new MultipleLookupCore($username);
		if ( empty($dbname) ) {
			$oML->setLimit($limit);
			$oML->setOffset($offset);
			$count = $oML->countUserActivity();
			$data = $oML->checkUserActivity( $order );
			if ( !empty($data) ) {
				$result['iTotalRecords'] = intval($limit); #( isset( $records['cnt'] ) ) ?  intval( $records['cnt'] ) : 0;
				$result['iTotalDisplayRecords'] = $count;
				$result['sColumns'] = 'id,dbname,title,url,lastedit,options';
				$rows = array();
				$loop = 1;
				foreach ( $data as $row ) {
					$usernames = "";
					if (empty($wgDevelEnvironment)) {
						// do not run this section on the dev environment because the db's dont exist
						$oML->setDBname($row[0]);
						$user_data = $oML->fetchContribs();
						if (!empty($user_data) && is_array($user_data)) {
							$names = array_keys($user_data); #get
							foreach($names as &$name)
							{
								$uname = urlencode( str_replace(' ','_', $name) ); #encode
								$name = "<a href=\"{$row[2]}index.php?title=Special:Contributions&target={$uname}\">{$name}</a>"; #wrap
							}
							$usernames = implode(', ', $names); #compress
						}
					}
					$rows[] = array(
						$loop + $offset, // wiki Id
						$row[0], // wiki dbname
						$row[1], //wiki title
						$row[2], // wiki url
						$row[3], // last edit date
						$usernames // $username field
					);
					$loop++;
				}
				$result['aaData'] = $rows;
			}
		} else {
			$oML->setDBname($dbname);
			$oML->setLimit($limit);
			$oML->setOffset($offset);
			$data = $oML->fetchContribs( true );
			/* order by timestamp desc */
			$nbr_records = 0;
			if ( !empty($data) && is_array($data) ) {
				$result['iTotalRecords'] = intval($limit); #( isset( $records['cnt'] ) ) ?  intval( $records['cnt'] ) : 0;
				$result['iTotalDisplayRecords'] = $oML->getNumRecords();
				$result['sColumns'] = 'id,dbname,title,edit';
				$rows = array();
				if ( isset($data) ) {
					$loop = 1;
					foreach ($data as $user_name => $row) {
						list ($link, $last_edit) = array_values($oML->produceLine( $row ));
						$rows[] = array(
							$loop + $offset, // id
							$dbname,
							$link, // title
							$last_edit
						);
						$loop++;
					}
				}
				$result['aaData'] = $rows;
			}
		}

		wfProfileOut( __METHOD__ );
		return json_encode($result);
	}
}

global $wgAjaxExportList;
$wgAjaxExportList[] = "MultiLookupAjax::axData";
