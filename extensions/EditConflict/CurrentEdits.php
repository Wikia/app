<?php
/*
 * Group-level based edit page access for MediaWiki. Monitors current edit sessions.
 * Version 0.4.2
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the EditConflict extension. It is not a valid entry point.\n" );
}

define( 'EC_DEFAULT_ORDER_KEY', 'page' );


class ec_CurrentEdits extends SpecialPage {

	var $db;

	public function __construct() {
		parent::__construct( 'CurrentEdits', 'delete' );
		wfLoadExtensionMessages('EditConflict');
	}

	public function execute( $par ) {
		global $wgOut, $wgRequest;
		global $wgUser;
		if ( !$wgUser->isAllowed( 'delete' ) ) {
			$wgOut->permissionRequired('delete');
			return;
		}
		$skin = $wgUser->getSkin();
		$this->setHeaders();
		$this->db = wfGetDB( DB_SLAVE );
		if ( ( $result = $this->checkTables( $this->db ) ) !== true ) {
			$wgOut->addHTML( $result );
			return;
		}
		# normal processing
		list( $limit, $offset ) = wfCheckLimits();
		$cmd = $wgRequest->getVal( 'action' );
		$order = $wgRequest->getVal( 'order' );
		# null means default order (by page name)
		if ( !in_array( $order, array( null, 'user', 'time' ) ) ) {
			$order = null;
		}
		if ( $cmd == null ) {
			$cel = new ec_CurrentEditsList( $order );
			$cel->doQuery( $offset, $limit );
		} elseif ( $cmd == 'delete' ) {
			if ( ( $edit_id = $wgRequest->getVal( 'id' ) ) !== null ) {
				$this->deleteSession( $edit_id );
				if ( $order == null ) {
					$wgOut->redirect( $this->getTitle()->getFullURL() );
				} else {
					$wgOut->redirect( $this->getTitle()->getFullURL( 'order=' . $order ) );
				}
			}
		}
	}

	private function checkTables() {
		$sql_tables = array(
			'ec_edit_conflict',
			'ec_current_edits'
		);
		// check whether the tables were initialized
		$tablesFound = 0;
		$result = true;
		foreach ( $sql_tables as $table ) {
			$tname = str_replace( "`", "'", $this->db->tableName( $table ) );
			$res = $this->db->query( "SHOW TABLE STATUS LIKE $tname" );
			if ( $this->db->numRows( $res ) > 0 ) {
				$tablesFound++;
			}
		}
		if ( $tablesFound  == 0 ) {
			# no tables were found, initialize the DB completely
			$r = $this->db->sourceFile( EditConflict::$ExtDir . "/tables.src" );
			if ( $r === true ) {
				$result = 'Tables were initialized.<br />Please <a href="#" onclick="window.location.reload()">reload</a> this page to view future page edits.';
			} else {
				$result = $r;
			}
		} else {
			if ( $tablesFound != count( $sql_tables ) ) {
				# some tables are missing, serious DB error
				$result = "Some of the extension database tables are missing.<br />Please restore from backup or drop extension tables, then reload this page.";
		  }
		}
		return $result;
	}

	private function deleteSession( $edit_id ) {
		$this->db->delete( 'ec_current_edits', array( 'edit_id'=>$edit_id ), __METHOD__ );
	}
}

if ( !class_exists( 'ec_QueryPage' ) ) {
	abstract class ec_QueryPage extends QueryPage {

		static $skin = null;

		public function __construct() {
			global $wgUser;
			if ( self::$skin == NULL ) {
				self::$skin = $wgUser->getSkin();
			}
		}

		function doQuery( $offset, $limit, $shownavigation=true ) {
			global $wgUser, $wgOut, $wgLang, $wgContLang;

			$res = $this->getIntervalResults( $offset, $limit );
			$num = count($res);

			$sk = $wgUser->getSkin();
			$sname = $this->getName();

			if($shownavigation) {
				$wgOut->addHTML( $this->getPageHeader() );

				// if list is empty, display a warning
				if( $num == 0 ) {
					$wgOut->addHTML( '<p>' . wfMsgHTML('specialpage-empty') . '</p>' );
					return;
				}

				$top = wfShowingResults( $offset, $num );
				$wgOut->addHTML( "<p>{$top}\n" );

				// often disable 'next' link when we reach the end
				$atend = $num < $limit;

				$sl = wfViewPrevNext( $offset, $limit ,
					$wgContLang->specialPage( $sname ),
					wfArrayToCGI( $this->linkParameters() ), $atend );
				$wgOut->addHTML( "<br />{$sl}</p>\n" );
			}
			if ( $num > 0 ) {
				$s = array();
				if ( ! $this->listoutput )
					$s[] = $this->openList( $offset );

				foreach ($res as $r) {
					$format = $this->formatResult( $sk, $r );
					if ( $format ) {
						$s[] = $this->listoutput ? $format : "<li>{$format}</li>\n";
					}
				}

				if ( ! $this->listoutput )
					$s[] = $this->closeList();
				$str = $this->listoutput ? $wgContLang->listToText( $s ) : implode( '', $s );
				$wgOut->addHTML( $str );
			}
			if($shownavigation) {
				$wgOut->addHTML( "<p>{$sl}</p>\n" );
			}
			return $num;
		}

		function getName() {
			return "CurrentEdits";
		}

		function isExpensive() {
			return false; // disables caching
		}

		function isSyndicated() {
			return false;
		}

	}
}

class ec_CurrentEditsList extends ec_QueryPage {

	var $order;
	var $order_key;
	var $order_string;
	var $order_strings = array (
		'page'=>'page_namespace, page_title, user_name, start_time',
		'user'=>'user_name, page_namespace, page_title, start_time',
		'time'=>'start_time, page_namespace, page_title, user_name'
	);
	var $order_queries = array ();

	public function __construct( $order ) {
		global $wgUser;
		parent::__construct();
		$skin = $wgUser->getSkin();
		$this->order = $order;
		$this->order_key = ($order === null) ? 'page' : $order;
		$this->order_string = &$this->order_strings[ $this->order_key ];
		foreach ( $this->order_strings as $order_key => &$order_val ) {
			# default order requires no pass of order GET param
			if ( $order_key == EC_DEFAULT_ORDER_KEY ) {
				$action = '';
			} else {
				$action = 'order=' . $order_key;
			}
			$msg = wfMsg( 'ec_order_' . $order_key );
			if ( $order_key == $this->order_key ) {
				# do not link the selected order
				$this->order_queries[ $order_key ] = $msg;
			} else {
				# link all other orders
				$this->order_queries[ $order_key ] = $skin->makeKnownLinkObj( $this->getTitle(), $msg , $action );
			}
		}
	}

	function sec2hours( $seconds ) {
		$ss = $seconds;
		$hh = $mm = 0;
		if ( $ss > 59 ) {
			$mm = floor( $ss / 60 );
			$ss = fmod( $ss, 60 );
			if ( $mm > 59 ) {
				$hh = floor( $mm / 60 );
				$mm = fmod( $mm, 60 );
			}
		}
		return sprintf( wfMsg( 'ec_time_sprintf' ), $hh, $mm, $ss );
	}

	function getEditingTime( $start_timestamp ) {
		$start_seconds = wfTimestamp( TS_UNIX, $start_timestamp );
		$current_seconds = wfTimestamp( TS_UNIX, time() );
		return $this->sec2hours( floatval( $current_seconds ) - floatval( $start_seconds ) );
	}

	function getIntervalResults( $offset, $limit ) {
		$result = array();
		$db = & wfGetDB( DB_SLAVE );
		EditConflict::deleteExpiredData( $db );
		$res = $db->select(
			'ec_current_edits',
			array( 'edit_id', 'page_namespace as ns', 'page_title as title', 'start_time', 'user_name' ),
			'',
			__METHOD__,
			array( 'ORDER BY'=>$this->order_string,
						'OFFSET'=>intval( $offset ),
						'LIMIT'=>intval( $limit ) ) );
		while( $row = $db->fetchObject( $res ) ) {
			$result[] = $row;
		}
		return $result;
	}

	function formatResult( $skin, $result ) {
		global $wgLang, $wgContLang;
		$title = Title::makeTitle( $result->ns, $result->title );
		$title_link = $skin->makeKnownLinkObj( $title );
		$user = User::newFromName( $result->user_name );
		if ( $user instanceof User ) {
			$user_weight = EditConflict::getGroupWeight( $user );
		} else {
			$user_weight = -1;
		}
		if ( $user instanceof User ) {
			$user_page = $user->getUserPage();
			$user_page_link = $skin->makeKnownLinkObj( $user_page );
		} else {
			$user_page_link = htmlspecialchars( $result->user_name );
		}
		$start_time = $wgLang->timeAndDate( $result->start_time, true );
		$editing_time = $this->getEditingTime( $result->start_time );
		$action = 'action=delete&id=' . $result->edit_id;
		if ( $this->order_key != EC_DEFAULT_ORDER_KEY ) {
			$action .= '&order=' . $this->order_key;
		}
		$session_close_link = $skin->makeKnownLinkObj( $this->getTitle(), '&#8251;', $action, '', '', 'title="Close this session."' );
		return wfMsg( 'ec_list_order_' . $this->order_key, $title_link, $user_page_link, htmlspecialchars( $user_weight ), htmlspecialchars( $editing_time ), $session_close_link );
	}

	function getPageHeader() {
		list( $link1, $link2, $link3 ) = array_values( $this->order_queries );
		return '<div style="font-size:9pt;font-style:italic;">' . wfMsg( 'ec_header_warning' ) . '</div><div style="margin-top:5px;font-size:12pt;font-weight:bold;">' . wfMsg( 'ec_header_order', $link1, $link2, $link3 ) .'</div>';
	}

	function linkParameters() {
		$params = Array();
		if ( $this->order_key != EC_DEFAULT_ORDER_KEY ) {
			$params[ "order" ] = $this->order_key;
		}
		return $params;
	}

}