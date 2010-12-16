<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of QPoll.
 * Uses parts of code from Quiz extension (c) 2007 Louis-Rémi BABE. All rights reserved.
 *
 * QPoll is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * QPoll is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with QPoll; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * QPoll is a poll tool for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named QPoll into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/QPoll/qp_user.php";
 *
 * @version 0.6.4
 * @link http://www.mediawiki.org/wiki/Extension:QPoll
 * @author QuestPC <questpc@rambler.ru>
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

class PollResults extends SpecialPage {

	public function __construct() {
		parent::__construct( 'PollResults', 'delete' );
		wfLoadExtensionMessages( 'QPoll' );
	}

	static $skin = null;
	static $UsersLink = "";
	static $PollsLink = "";

	public function execute( $par ) {
		global $wgOut, $wgRequest;
		global $wgServer; // "http://www.yourserver.org"
							// (should be equal to 'http://'.$_SERVER['SERVER_NAME'])
		global $wgScript;   // "/subdirectory/of/wiki/index.php"
		global $wgUser;
		if ( !$wgUser->isAllowed( 'delete' ) ) {
			$wgOut->permissionRequired( 'delete' );
			return;
		}
		$wgOut->addExtensionStyle( qp_Setup::$ScriptPath . '/qp_results.css' );
		if ( self::$skin == null ) {
			self::$skin = $wgUser->getSkin();
		}
		if ( self::$UsersLink == "" ) {
			self::$UsersLink = self::$skin->link( $this->getTitle(), wfMsg( 'qp_users_list' ), array( "style" => "font-weight:bold;" ), array( 'action' => 'users' ) );
		}
		if ( self::$PollsLink == "" ) {
			self::$PollsLink = self::$skin->link( $this->getTitle(), wfMsg( 'qp_polls_list' ), array( "style" => "font-weight:bold;" ) );
		}
		$wgOut->addHTML( '<div class="qpoll">' );
		$output = "";
		$this->setHeaders();
		$db = & wfGetDB( DB_SLAVE );
		if ( ( $result = $this->checkTables( $db ) ) !== true ) {
			# tables check failed
			$wgOut->addHTML( $result );
			return;
		}
		# normal processing
		$cmd = $wgRequest->getVal( 'action' );
		if ( $cmd === null ) {
			list( $limit, $offset ) = wfCheckLimits();
			$qpl = new qp_PollsList();
			$qpl->doQuery( $offset, $limit );
		} else {
			$pid = $wgRequest->getVal( 'id' );
			$uid = $wgRequest->getVal( 'uid' );
			$question_id = $wgRequest->getVal( 'qid' );
			$proposal_id = $wgRequest->getVal( 'pid' );
			$cid = $wgRequest->getVal( 'cid' );
			switch ( $cmd ) {
				case 'stats':
					if ( $pid !== null ) {
						$pid = intval( $pid );
						$output = self::getPollsLink();
						$output .= self::getUsersLink();
						$output .= $this->showVotes( $pid );
					}
					break;
				case 'stats_xls':
						if ( $pid !== null ) {
							$pid = intval( $pid );
							$this->votesToXLS( $pid );
						}
					break;
				case 'uvote':
					if ( $pid !== null && $uid !== null ) {
						$pid = intval( $pid );
						$uid = intval( $uid );
						$output = self::getPollsLink();
						$output .= self::getUsersLink();
						$output .= $this->showUserVote( $pid, $uid );
					}
					break;
				case 'qpcusers':
					if ( $pid !== null && $question_id !== null && $proposal_id !== null && $cid !== null ) {
						$pid = intval( $pid );
						$question_id = intval( $question_id );
						$proposal_id = intval( $proposal_id );
						$cid = intval( $cid );
						list( $limit, $offset ) = wfCheckLimits();
						$qucl = new qp_UserCellList( $cmd, $pid, $question_id, $proposal_id, $cid );
						$qucl->doQuery( $offset, $limit );
					}
					break;
				case 'users':
				case 'users_a':
					list( $limit, $offset ) = wfCheckLimits();
					$qul = new qp_UsersList( $cmd );
					$qul->doQuery( $offset, $limit );
					break;
				case 'upolls':
				case 'nupolls':
					if ( $uid !== null ) {
						$uid = intval( $uid );
						list( $limit, $offset ) = wfCheckLimits();
						$qupl = new qp_UserPollsList( $cmd, $uid );
						$qupl->doQuery( $offset, $limit );
					}
					break;
				case 'pulist':
				case 'npulist':
					if ( $pid !== null ) {
						$pid = intval( $pid );
						list( $limit, $offset ) = wfCheckLimits();
						$qpul = new qp_PollUsersList( $cmd, $pid );
						$qpul->doQuery( $offset, $limit );
					}
					break;
			}
		}
		$wgOut->addHTML( $output . '</div>' );
	}

	# check whether the extension tables exist in DB
	# @param    $db - MediaWiki database object
	# @return   true if tables are found, string with error message otherwise
	private function checkTables( $db ) {
		$sql_tables = array(
			"qp_poll_desc",
			"qp_question_desc",
			"qp_question_categories",
			"qp_question_proposals",
			"qp_question_answers",
			"qp_users_polls",
			"qp_users" );
		// check whether the tables were initialized
		$tablesFound = 0;
		$result = true;
		foreach ( $sql_tables as $table ) {
			$tname = str_replace( "`", "'", $db->tableName( $table ) );
			$res = $db->query( "SHOW TABLE STATUS LIKE $tname" );
			if ( $db->numRows( $res ) > 0 ) {
				$tablesFound++;
			}
		}
		if ( $tablesFound  == 0 ) {
			# no tables were found, initialize the DB completely
			$r = $db->sourceFile( qp_Setup::$ExtDir . "/qpoll.src" );
			if ( $r === true ) {
				$result = 'Tables were initialized.<br />Please <a href="#" onclick="window.location.reload()">reload</a> this page to view future page edits.';
			} else {
				$result = $r;
			}
		} else {
			if ( $tablesFound != count( $sql_tables ) ) {
				# some tables are missing, serious DB error
				$result = "Some of the extension database tables are missing.<br />Please restore from backup or drop the remaining extension tables, then reload this page.";
		  }
		}
		return $result;
	}

	private function showUserVote( $pid, $uid ) {
		$output = "";
		if ( $pid !== null && $uid !== null ) {
			$pollStore = new qp_PollStore( array( 'from' => 'pid', 'pid' => $pid ) );
			if ( $pollStore->pid !== null ) {
				$pollStore->loadQuestions();
				$userName = $pollStore->getUserName( $uid );
				if ( $userName !== false ) {
					$userTitle = Title::makeTitleSafe( NS_USER, $userName );
					$user_link = self::$skin->link( $userTitle, $userName );
					$pollStore->setLastUser( $userName, false );
					if ( $pollStore->loadUserVote() ) {
						$poll_title = $pollStore->getTitle();
						# 'parentheses' is unavailable in 1.14.x
						$poll_link = self::$skin->link( $poll_title, $poll_title->getPrefixedText() . wfMsg( 'word-separator' ) . wfMsg( 'qp_parentheses', $pollStore->mPollId ) );
						$output .= wfMsg( 'qp_browse_to_user', $user_link ) . "<br />\n";
						$output .= wfMsg( 'qp_browse_to_poll', $poll_link ) . "<br />\n";
						foreach ( $pollStore->Questions as $qkey => &$qdata ) {
							$output .= "<br />\n<b>" . $qkey . ".</b> " . qp_Setup::entities( $qdata->CommonQuestion ) . "<br />\n";
							$output .= $this->displayUserQuestionVote( $qdata );
						}
					}
				}
			}
		}
		return $output;
	}

	private function categoryentities( $cat ) {
		$cat['name'] = qp_Setup::entities( $cat['name'] );
		return $cat;
	}

	private function displayUserQuestionVote( &$qdata ) {
		$output = "<div class=\"qpoll\">\n" . "<table class=\"pollresults\">\n";
		$output .= qp_Renderer::displayRow( array_map( array( $this, 'categoryentities' ), $qdata->CategorySpans ), array( 'class' => 'spans' ), 'th', array( 'count' => 'colspan', 'name' => 0 ) );
		$output .= qp_Renderer::displayRow( array_map( array( $this, 'categoryentities' ), $qdata->Categories ), '', 'th', array( 'name' => 0 ) );
		# multiple choice polls doesn't use real spans, instead, every column is like "span"
		$spansUsed = count( $qdata->CategorySpans ) > 0 || $qdata->type == "multipleChoice";
		foreach ( $qdata->ProposalText as $propkey => &$proposal_text ) {
			$row = Array();
			foreach ( $qdata->Categories as $catkey => &$cat_name ) {
				$cell = Array( 0 => "" );
				if ( array_key_exists( $propkey, $qdata->ProposalCategoryId ) &&
							( $id_key = array_search( $catkey, $qdata->ProposalCategoryId[ $propkey ] ) ) !== false ) {
					$text_answer = $qdata->ProposalCategoryText[ $propkey ][ $id_key ];
					if ( $text_answer != '' ) {
						if ( strlen( $text_answer ) > 20 ) {
							$cell[ 0 ] = array( '__tag' => 'div', 'style' => 'width:10em; height:5em; overflow:auto', 0 => qp_Setup::entities( $text_answer ) );
						} else {
							$cell[ 0 ] = qp_Setup::entities( $text_answer );
						}
					} else {
						$cell[ 0 ] = '+';
					}
				}
				if ( $spansUsed ) {
					if ( $qdata->type == "multipleChoice" ) {
						$cell[ "class" ] = ( ( $catkey & 1 ) === 0 ) ? "spaneven" : "spanodd";
					} else {
						$cell[ "class" ] = ( ( $qdata->Categories[ $catkey ][ "spanId" ] & 1 ) === 0 ) ? "spaneven" : "spanodd";
					}
				} else {
					$cell[ "class" ] = "stats";
				}
				$row[] = $cell;
			}
			$row[] = array( 0 => qp_Setup::entities( $proposal_text ), "style" => "text-align:left;" );
			$output .= qp_Renderer::displayRow( $row );
		}
		$output .= "</table>\n" . "</div>\n";
		return $output;
	}

	private function showVotes( $pid ) {
		$output = "";
		if ( $pid !== null ) {
			$pollStore = new qp_PollStore( array( 'from' => 'pid', 'pid' => $pid ) );
			if ( $pollStore->pid !== null ) {
				$pollStore->loadQuestions();
				$pollStore->loadTotals();
				$pollStore->calculateStatistics();
				$poll_title = $pollStore->getTitle();
				# 'parentheses' is unavailable in 1.14.x
				$poll_link = self::$skin->link( $poll_title, $poll_title->getPrefixedText() . wfMsg( 'word-separator' ) . wfMsg( 'qp_parentheses', $pollStore->mPollId ) );
				$output .= wfMsg( 'qp_browse_to_poll', $poll_link ) . "<br />\n";
				$output .= self::$skin->link( $this->getTitle(), wfMsg( 'qp_export_to_xls' ), array( "style" => "font-weight:bold;" ), array( 'action' => 'stats_xls', 'id' => $pid ) );
				foreach ( $pollStore->Questions as $qkey => &$qdata ) {
					$output .= "<br />\n<b>" . $qkey . ".</b> " . qp_Setup::entities( $qdata->CommonQuestion ) . "<br />\n";
					$output .= $this->displayQuestionStats( $pid, $qdata );
				}
			}
		}
		return $output;
	}

	private function votesToXLS( $pid ) {
		$output = "";
		if ( $pid !== null ) {
			$pollStore = new qp_PollStore( array( 'from' => 'pid', 'pid' => $pid ) );
			if ( $pollStore->pid !== null ) {
				$poll_id = $pollStore->getPollId();
				$pollStore->loadQuestions();
				$pollStore->loadTotals();
				$pollStore->calculateStatistics();
				try {
					require_once( qp_Setup::$ExtDir . '/Excel/Excel_Writer.php' );
					$xls_fname = tempnam( "", ".xls" );
					$xls_workbook = new Spreadsheet_Excel_Writer_Workbook( $xls_fname );
					$xls_workbook->setVersion( 8 );
					$xls_worksheet = &$xls_workbook->addworksheet();
					$xls_worksheet->setInputEncoding( "utf-8" );
					$xls_worksheet->setPaper( 9 );
					$xls_rownum = 0;
					$percent_num_format = '[Blue]0.0%;[Red]-0.0%;[Black]0%';
					$format_heading = &$xls_workbook->addformat( array( 'bold' => 1 ) );
					$format_percent = &$xls_workbook->addformat( array( 'fgcolor' => 0x1A, 'border' => 1 ) );
					$format_percent->setAlign( 'left' );
					$format_percent->setNumFormat( $percent_num_format );
					$format_even = &$xls_workbook->addformat( array( 'fgcolor' => 0x2A, 'border' => 1 ) );
					$format_even->setAlign( 'left' );
					$format_even->setNumFormat( $percent_num_format );
					$format_odd = &$xls_workbook->addformat( array( 'fgcolor' => 0x23, 'border' => 1 ) );
					$format_odd->setAlign( 'left' );
					$format_odd->setNumFormat( $percent_num_format );
					$first_question = true;
					foreach ( $pollStore->Questions as $qkey => &$qdata ) {
						if ( $first_question ) {
							$totalUsersAnsweredQuestion = $pollStore->totalUsersAnsweredQuestion( $qdata );
							$xls_worksheet->write( $xls_rownum, 0, $totalUsersAnsweredQuestion, $format_heading );
							$xls_worksheet->write( $xls_rownum++, 1, wfMsgExt( 'qp_users_answered_questions', array( 'parsemag' ), $totalUsersAnsweredQuestion ), $format_heading );
							$xls_rownum++;
							$first_question = false;
						}
						$xls_worksheet->write( $xls_rownum, 0, $qdata->question_id, $format_heading );
						$xls_worksheet->write( $xls_rownum++, 1, qp_Excel::prepareExcelString( $qdata->CommonQuestion ), $format_heading );
						if ( count( $qdata->CategorySpans ) > 0 ) {
							$row = array();
							foreach ( $qdata->CategorySpans as &$span ) {
								$row[] = qp_Excel::prepareExcelString( $span[ "name" ] );
								for ( $i = 1; $i < $span[ "count" ]; $i++ ) {
									$row[] = "";
								}
							}
							$xls_worksheet->writerow( $xls_rownum++, 0, $row );
						}
						$row = array();
						foreach ( $qdata->Categories as &$categ ) {
							$row[] = qp_Excel::prepareExcelString( $categ[ "name" ] );
						}
						$xls_worksheet->writerow( $xls_rownum++, 0, $row );
/*
						foreach( $qdata->Percents as $pkey=>&$percent ) {
							$xls_worksheet->writerow( $xls_rownum + $pkey, 0, $percent );
						}
*/
						$percentsTable = Array();
						$spansUsed = count( $qdata->CategorySpans ) > 0 || $qdata->type == "multipleChoice";
						foreach ( $qdata->ProposalText as $propkey => &$proposal_text ) {
							if ( isset( $qdata->Percents[ $propkey ] ) ) {
								$row = $qdata->Percents[ $propkey ];
								foreach ( $row as $catkey => &$cell ) {
									$cell = array( 0 => $cell );
									if ( $spansUsed ) {
										if ( $qdata->type == "multipleChoice" ) {
											$cell[ "format" ] = ( ( $catkey & 1 ) === 0 ) ? $format_even : $format_odd;
										} else {
											$cell[ "format" ] = ( ( $qdata->Categories[ $catkey ][ "spanId" ] & 1 ) === 0 ) ? $format_even : $format_odd;
										}
									}
								}
							} else {
								$row = array_fill( 0, count( $qdata->Categories ), '' );
							}
							$percentsTable[] = $row;
						}
						qp_Excel::writeFormattedTable( $xls_worksheet, $xls_rownum, 0, $percentsTable, $format_percent );
						$row = array();
						foreach ( $qdata->ProposalText as $ptext ) {
							$row[] = qp_Excel::prepareExcelString( $ptext );
						}
						$xls_worksheet->writecol( $xls_rownum, count( $qdata->Categories ), $row );
						$xls_rownum += count( $qdata->ProposalText ) + 1;
					}
					$xls_workbook->close();
					header( 'Content-Type: application/x-msexcel; name="' . $poll_id . '.xls"' );
					header( 'Content-Disposition: inline; filename="' . $poll_id . '.xls"' );
					$fxls = @fopen( $xls_fname, "rb" );
					@fpassthru( $fxls );
					@unlink( $xls_fname );
					exit();
				} catch ( Exception $e ) {
					die( "Error while exporting poll statistics to Excel table\n" );
				}
			}
		}
	}

	private function displayQuestionStats( $pid, &$qdata ) {
		$current_title = $this->getTitle();
		$output = "<div class=\"qpoll\">\n" . "<table class=\"pollresults\">\n";
		$output .= qp_Renderer::displayRow( array_map( array( $this, 'categoryentities' ), $qdata->CategorySpans ), array( 'class' => 'spans' ), 'th', array( 'count' => 'colspan', 'name' => 0 ) );
		$output .= qp_Renderer::displayRow( array_map( array( $this, 'categoryentities' ), $qdata->Categories ), '', 'th', array( 'name' => 0 ) );
		# multiple choice polls doesn't use real spans, instead, every column is like "span"
		$spansUsed = count( $qdata->CategorySpans ) > 0 || $qdata->type == "multipleChoice";
		foreach ( $qdata->ProposalText as $propkey => &$proposal_text ) {
			if ( isset( $qdata->Votes[ $propkey ] ) ) {
				if ( $qdata->Percents === null ) {
					$row = $qdata->Votes[ $propkey ];
				} else {
					$row = $qdata->Percents[ $propkey ];
					foreach ( $row as $catkey => &$cell ) {
						$formatted_cell = str_replace( " ", "&ensp;", sprintf( '%3d%%', intval( round( 100 * $cell ) ) ) );
						# only percents !=0 are displayed as link
						if ( $cell == 0.0 && $qdata->question_id !== null ) {
							$cell = array( 0 => $formatted_cell, "style" => "color:gray" );
						} else {
							$cell = array( 0 => self::$skin->link( $current_title, $formatted_cell,
								array( "title" => wfMsgExt( 'qp_votes_count', array( 'parsemag' ), $qdata->Votes[ $propkey ][ $catkey ] ) ),
								array( "action" => "qpcusers", "id" => $pid, "qid" => $qdata->question_id, "pid" => $propkey, "cid" => $catkey ) ) );
						}
						if ( $spansUsed ) {
							if ( $qdata->type == "multipleChoice" ) {
								$cell[ "class" ] = ( ( $catkey & 1 ) === 0 ) ? "spaneven" : "spanodd";
							} else {
								$cell[ "class" ] = ( ( $qdata->Categories[ $catkey ][ "spanId" ] & 1 ) === 0 ) ? "spaneven" : "spanodd";
							}
						} else {
							$cell[ "class" ] = "stats";
						}
					}
				}
			} else {
				# this proposal has no statistics (no votes)
				$row = array_fill( 0, count( $qdata->Categories ), '' );
			}
			$row[] = array( 0 => qp_Setup::entities( $proposal_text ), "style" => "text-align:left;" );
			$output .= qp_Renderer::displayRow( $row );
		}
		$output .= "</table>\n" . "</div>\n";
		return $output;
	}

	static function getUsersLink() {
		return "<div>" . self::$UsersLink . "</div>\n";
	}

	static function getPollsLink() {
		return "<div>" . self::$PollsLink . "</div>\n";
	}

}

abstract class qp_QueryPage extends QueryPage {

	static $skin = null;

	public function __construct() {
		global $wgUser;
		if ( self::$skin == null ) {
			self::$skin = $wgUser->getSkin();
		}
	}

	function doQuery( $offset, $limit, $shownavigation = true ) {
		global $wgUser, $wgOut, $wgLang, $wgContLang;

		$res = $this->getIntervalResults( $offset, $limit );
		$num = count( $res );

		$sk = $wgUser->getSkin();
		$sname = $this->getName();

		if ( $shownavigation ) {
			$wgOut->addHTML( $this->getPageHeader() );

			// if list is empty, display a warning
			if ( $num == 0 ) {
				$wgOut->addHTML( '<p>' . wfMsgHTML( 'specialpage-empty' ) . '</p>' );
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

			foreach ( $res as $r ) {
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
		if ( $shownavigation ) {
			$wgOut->addHTML( "<p>{$sl}</p>\n" );
		}
		return $num;
	}

	function getName() {
		return "PollResults";
	}

	function isExpensive() {
		return false; // disables caching
	}

	function isSyndicated() {
		return false;
	}

}

/* list of all users */
class qp_UsersList extends qp_QueryPage {
	var $cmd;
	var $order_by;
	var $different_order_by_link;

	public function __construct( $cmd ) {
		parent::__construct();
		$this->cmd = $cmd;
		if ( $cmd == 'users' ) {
			$this->order_by = 'count(pid) DESC, name ASC ';
			$this->different_order_by_link = self::$skin->link( $this->getTitle(), wfMsg( 'qp_order_by_username' ), array(), array( "action" => "users_a" ) );
		} else {
			$this->order_by = 'name ';
			$this->different_order_by_link = self::$skin->link( $this->getTitle(), wfMsg( 'qp_order_by_polls_count' ), array(), array( "action" => "users" ) );
		}
	}

	function getIntervalResults( $offset, $limit ) {
		$result = array();
		$db = & wfGetDB( DB_SLAVE );
		$qp_users = $db->tableName( 'qp_users' );
		$qp_users_polls = $db->tableName( 'qp_users_polls' );
		$res = $db->select( "$qp_users_polls qup, $qp_users qu",
			array( 'qu.uid as uid', 'name as username', 'count(pid) as pidcount' ),
			'qu.uid=qup.uid',
			__METHOD__,
			array( 'GROUP BY' => 'qup.uid',
						'ORDER BY' => $this->order_by,
						'OFFSET' => intval( $offset ),
						'LIMIT' => intval( $limit ) ) );
		while ( $row = $db->fetchObject( $res ) ) {
			$result[] = $row;
		}
		return $result;
	}

	function formatResult( $skin, $result ) {
		global $wgLang, $wgContLang;
		$link = "";
		if ( $result !== null ) {
			$uid = intval( $result->uid );
			$userName = $result->username;
			$userTitle = Title::makeTitleSafe( NS_USER, $userName );
			$user_link = self::$skin->link( $userTitle, $userName );
			$user_polls_link = self::$skin->link( $this->getTitle(), wfMsgExt( 'qp_user_polls_link', array( 'parsemag' ), $result->pidcount, $userName ) , array(), array( "uid" => $uid, "action" => "upolls" ) );
			$user_missing_polls_link = self::$skin->link( $this->getTitle(), wfMsgExt( 'qp_user_missing_polls_link', 'parsemag', $userName ) , array(), array( "uid" => $uid, "action" => "nupolls" ) );
			$link = $user_link . ': ' . $user_polls_link . ', ' . $user_missing_polls_link;
		}
		return $link;
	}

	function linkParameters() {
		$params[ 'action' ] = $this->cmd;
		return $params;
	}

	function getPageHeader() {
		return PollResults::getPollsLink() . '<div class="head">' . wfMsg( 'qp_users_list' ) . '<div>' . $this->different_order_by_link . '</div></div>';
	}

}

/* list of polls in which selected user (did not|participated) */
class qp_UserPollsList extends qp_QueryPage {
	var $uid;
	var $inverse;
	var $cmd;

	public function __construct( $cmd, $uid ) {
		parent::__construct();
		$this->uid = intval( $uid );
		$this->cmd = $cmd;
		$this->inverse = ( $cmd == "nupolls" );
	}

	function getPageHeader() {
		global $wgLang, $wgContLang;
		# fake pollStore to get username by uid: avoid to use this trick as much as possible
		$pollStore = new qp_PollStore();
		$userName = $pollStore->getUserName( $this->uid );
		$db = & wfGetDB( DB_SLAVE );
		$res = $db->select(
			array( 'qp_users_polls' ),
			array( 'count(pid) as pidcount' ),
			'uid=' . $db->addQuotes( $this->uid ),
			__METHOD__ );
		if ( $row = $db->fetchObject( $res ) ) {
			$pidcount = $row->pidcount;
		} else {
			$pidcount = 0;
		}
		if ( $userName !== false ) {
			$userTitle = Title::makeTitleSafe( NS_USER, $userName );
			$user_link = self::$skin->link( $userTitle, $userName );
			return PollResults::getPollsLink() . PollResults::getUsersLink() . '<div class="head">' . $user_link . ': ' . ( $this->inverse ? wfMsgExt( 'qp_user_missing_polls_link', 'parsemag', $userName ) : wfMsgExt( 'qp_user_polls_link', array( 'parsemag' ), $pidcount, $userName ) ) . ' ' . '</div>';
		}
	}

	function getIntervalResults( $offset, $limit ) {
		$result = Array();
		$db = & wfGetDB( DB_SLAVE );
		$page = $db->tableName( 'page' );
		$qp_poll_desc = $db->tableName( 'qp_poll_desc' );
		$qp_users_polls = $db->tableName( 'qp_users_polls' );
		$query = "SELECT pid, page_namespace AS ns, page_title AS title, poll_id ";
		$query .= "FROM ($qp_poll_desc, $page) ";
		$query .= " WHERE page_id=article_id AND pid " . ( $this->inverse ? "NOT " : "" ) . "IN ";
		$query .= "(SELECT pid ";
		$query .= "FROM $qp_users_polls ";
		$query .= "WHERE uid=" . $db->addQuotes( $this->uid ) . ") ";
		$query .= "ORDER BY page_namespace, page_title, poll_id ";
		$query .= "LIMIT " . intval( $offset ) . ", " . intval( $limit );
		$res = $db->query( $query, __METHOD__ );
		while ( $row = $db->fetchObject( $res ) ) {
			$result[] = $row;
		}
		return $result;
	}

	function formatResult( $skin, $result ) {
		global $wgLang, $wgContLang;
		$poll_title = Title::makeTitle( $result->ns, $result->title, qp_AbstractPoll::getPollTitleFragment( $result->poll_id, '' ) );
		$pagename = qp_Setup::specialchars( $wgContLang->convert( $poll_title->getPrefixedText() ) );
		$pollname = qp_Setup::specialchars( $result->poll_id );
		$goto_link = self::$skin->link( $poll_title, wfMsg( 'qp_source_link' ) );
		$voice_link = self::$skin->link( $this->getTitle(), wfMsg( 'qp_voice_link' . ( $this->inverse ? "_inv" : "" ) ), array(), array( "id" => intval( $result->pid ), "uid" => $this->uid, "action" => "uvote" ) );
		$link = wfMsg( 'qp_results_line_qupl', $pagename, $pollname, $voice_link );
		return $link;
	}

	function linkParameters() {
		$params[ "action" ] = $this->cmd;
		if ( $this->uid !== null ) {
			$params[ "uid" ] = $this->uid;
		}
		return $params;
	}

}

/* list of all polls */
class qp_PollsList extends qp_QueryPage {

	function getIntervalResults( $offset, $limit ) {
		$result = array();
		$db = & wfGetDB( DB_SLAVE );
		$res = $db->select(
			array( 'page', 'qp_poll_desc' ),
			array( 'page_namespace as ns', 'page_title as title', 'pid', 'poll_id', 'order_id' ),
			'page_id=article_id',
			__METHOD__,
			array( 'ORDER BY' => 'page_namespace, page_title, order_id',
						'OFFSET' => intval( $offset ),
						'LIMIT' => intval( $limit ) ) );
		while ( $row = $db->fetchObject( $res ) ) {
			$result[] = $row;
		}
		return $result;
	}

	function formatResult( $skin, $result ) {
		global $wgLang, $wgContLang;
		$poll_title = Title::makeTitle( $result->ns, $result->title, qp_AbstractPoll::getPollTitleFragment( $result->poll_id, '' ) );
		$pagename = qp_Setup::specialchars( $wgContLang->convert( $poll_title->getPrefixedText() ) );
		$pollname = qp_Setup::specialchars( $result->poll_id );
		$goto_link = self::$skin->link( $poll_title, wfMsg( 'qp_source_link' ) );
		$voices_link = self::$skin->link( $this->getTitle(), wfMsg( 'qp_stats_link' ), array(), array( "id" => intval( $result->pid ), "action" => "stats" ) );
		$users_link = self::$skin->link( $this->getTitle(), wfMsg( 'qp_users_link' ), array(), array( "id" => intval( $result->pid ), "action" => "pulist" ) );
		$not_participated_link = self::$skin->link( $this->getTitle(), wfMsg( 'qp_not_participated_link' ), array(), array( "id" => intval( $result->pid ), "action" => "npulist" ) );
		$link = wfMsg( 'qp_results_line_qpl', $pagename, $pollname, $goto_link, $voices_link, $users_link, $not_participated_link );
		return $link;
	}

	function getPageHeader() {
		return PollResults::getUsersLink() . '<div class="head">' . wfMsg( 'qp_polls_list' ) . '</div>';
	}

}

/* list of users, (not|participated) in particular poll, defined by pid */
class qp_PollUsersList extends qp_QueryPage {

	var $pid;
	var $inverse;
	var $cmd;

	public function __construct( $cmd, $pid ) {
		parent::__construct();
		$this->pid = intval( $pid );
		$this->cmd = $cmd;
		$this->inverse = ( $cmd == "npulist" );
	}

	function getPageHeader() {
		global $wgLang, $wgContLang;
		$link = "";
		$db = & wfGetDB( DB_SLAVE );
		$res = $db->select(
			array( 'page', 'qp_poll_desc' ),
			array( 'page_namespace as ns', 'page_title as title', 'poll_id' ),
			'page_id=article_id and pid=' . $db->addQuotes( $this->pid ),
			__METHOD__ );
		if ( $row = $db->fetchObject( $res ) ) {
			$poll_title = Title::makeTitle( intval( $row->ns ), $row->title, qp_AbstractPoll::getPollTitleFragment( $row->poll_id, '' ) );
			$pagename = qp_Setup::specialchars( $wgContLang->convert( $poll_title->getPrefixedText() ) );
			$pollname = qp_Setup::specialchars( $row->poll_id );
			$goto_link = self::$skin->link( $poll_title, wfMsg( 'qp_source_link' ) );
			$spec = wfMsg( 'qp_header_line_qpul', wfMsg( $this->inverse ? 'qp_not_participated_link' : 'qp_users_link' ), $pagename, $pollname );
			$head[] = PollResults::getPollsLink();
			$head[] = PollResults::getUsersLink();
			$head[] = array( '__tag' => 'div', 'class' => 'head', 0 => $spec );
			$head[] = ' (' . $goto_link . ')';
			$link = qp_Renderer::renderHTMLobject( $head );
		}
		return $link;
	}

	function getIntervalResults( $offset, $limit ) {
		$result = Array();
		$db = & wfGetDB( DB_SLAVE );
		$qp_users = $db->tableName( 'qp_users' );
		$qp_users_polls = $db->tableName( 'qp_users_polls' );
		$query = "SELECT uid, name as username ";
		$query .= "FROM $qp_users ";
		$query .= "WHERE uid " . ( $this->inverse ? "NOT " : "" ) . "IN ";
		$query .= "(SELECT uid FROM $qp_users_polls WHERE pid=" . $db->addQuotes( $this->pid ) . ") ";
		$query .= "ORDER BY uid ";
		$query .= "LIMIT " . intval( $offset ) . ", " . intval( $limit );
		$res = $db->query( $query, __METHOD__ );
		while ( $row = $db->fetchObject( $res ) ) {
			$result[] = $row;
		}
		return $result;
	}

	function formatResult( $skin, $result ) {
		global $wgLang, $wgContLang;
		$link = "";
		if ( $result !== null ) {
			$uid = intval( $result->uid );
			$userName = $result->username;
			$userTitle = Title::makeTitleSafe( NS_USER, $userName );
			$user_link = self::$skin->link( $userTitle, $userName );
			$voice_link = self::$skin->link( $this->getTitle(), wfMsg( 'qp_voice_link' . ( $this->inverse ? "_inv" : "" ) ), array(), array( "id" => intval( $this->pid ), "uid" => $uid, "action" => "uvote" ) );
			$link = wfMsg( 'qp_results_line_qpul', $user_link, $voice_link );
		}
		return $link;
	}

	function linkParameters() {
		$params[ "action" ] = $this->cmd;
		if ( $this->pid !== null ) {
			$params[ "id" ] = $this->pid;
		}
		return $params;
	}

}

/* list of users who voted for particular choice of particular proposal of particular question */
class qp_UserCellList extends qp_QueryPage {
	var $cmd;
	var $pid = null;
	var $ns, $title, $poll_id;
	var $question_id, $proposal_id, $cat_id;
	var $inverse = false;

	public function __construct( $cmd, $pid, $question_id, $proposal_id, $cid ) {
		parent::__construct();
		$this->cmd = $cmd;
		$this->question_id = $question_id;
		$this->proposal_id = $proposal_id;
		$this->cat_id = $cid;
		$db = & wfGetDB( DB_SLAVE );
		$qp_poll_desc = $db->tableName( 'qp_poll_desc' );
		$page = $db->tableName( 'page' );
		$query = "SELECT pid, page_namespace as ns, page_title as title, poll_id ";
		$query .= "FROM ($qp_poll_desc, $page) ";
		$query .= "WHERE page_id=article_id AND pid=" . $db->addQuotes( $pid ) . "";
		$res = $db->query( $query, __METHOD__ );
		if ( $row = $db->fetchObject( $res ) ) {
			$this->pid = intval( $row->pid );
			$this->ns = intval( $row->ns );
			$this->title = $row->title;
			$this->poll_id = $row->poll_id;
		}
	}

	function getPageHeader() {
		global $wgLang, $wgContLang;
		$link = "";
		$db = & wfGetDB( DB_SLAVE );
		if ( $this->pid !== null ) {
			$pollStore = new qp_PollStore( array( 'from' => 'pid', 'pid' => $this->pid ) );
			if ( $pollStore->pid !== null ) {
				$pollStore->loadQuestions();
				$poll_title = Title::makeTitle( intval( $this->ns ), $this->title, qp_AbstractPoll::getPollTitleFragment( $this->poll_id, '' ) );
				$pagename = qp_Setup::specialchars( $wgContLang->convert( $poll_title->getPrefixedText() ) );
				$pollname = qp_Setup::specialchars( $this->poll_id );
				$goto_link = self::$skin->link( $poll_title, wfMsg( 'qp_source_link' ) );
				$spec = wfMsg( 'qp_header_line_qpul', wfMsg( 'qp_users_link' ), $pagename, $pollname );
				$head[] = PollResults::getPollsLink();
				$head[] = PollResults::getUsersLink();
				$head[] = array( '__tag' => 'div', 'class' => 'head', 0 => $spec );
				# 'parentheses' are unavailable in MW 1.14.x
				$head[] = wfMsg( 'qp_parentheses',  $goto_link ) . '<br />';
				$ques_found = false;
				foreach ( $pollStore->Questions as &$ques ) {
					if ( $ques->question_id == $this->question_id ) {
						$ques_found = true;
						break;
					}
				}
				if ( $ques_found ) {
					$qpa = wfMsg( 'qp_header_line_qucl', $this->question_id, qp_Setup::entities( $ques->CommonQuestion ) );
					if ( array_key_exists( $this->cat_id, $ques->Categories ) ) {
						$categ = &$ques->Categories[ $this->cat_id ];
						$proptext = $ques->ProposalText[ $this->proposal_id ];
						$cat_name = $categ['name'];
						if ( array_key_exists( 'spanId', $categ ) ) {
							$cat_name =  wfMsg( 'qp_full_category_name', $cat_name, $ques->CategorySpans[ $categ['spanId'] ]['name'] );
						}
						$qpa = wfMsg( 'qp_header_line_qucl',
							$this->question_id,
							qp_Setup::entities( $ques->CommonQuestion ),
							qp_Setup::entities( $proptext ),
							qp_Setup::entities( $cat_name ) ) . '<br />';
						$head[] = array( '__tag' => 'div', 'class' => 'head', 'style' => 'padding-left:2em;', 0 => $qpa );
						$link = qp_Renderer::renderHTMLobject( $head );
					}
				}
			}
		}
		return $link;
	}

	function getIntervalResults( $offset, $limit ) {
		$result = Array();
		$db = & wfGetDB( DB_SLAVE );
		$qp_users = $db->tableName( 'qp_users' );
		$qp_question_answers = $db->tableName( 'qp_question_answers' );
		$query = "SELECT qqa.uid as uid, name as username, text_answer ";
		$query .= "FROM $qp_question_answers qqa ";
		$query .= "INNER JOIN $qp_users qu ON qqa.uid = qu.uid ";
		$query .= "WHERE pid=" . $db->addQuotes( $this->pid ) . " AND question_id=" . $db->addQuotes( $this->question_id ) . " AND proposal_id=" . $db->addQuotes( $this->proposal_id ) . " AND cat_id=" . $db->addQuotes( $this->cat_id ) . " ";
		$query .= "LIMIT " . intval( $offset ) . ", " . intval( $limit );
		$res = $db->query( $query, __METHOD__ );
		while ( $row = $db->fetchObject( $res ) ) {
			$result[] = $row;
		}
		return $result;
	}

	function formatResult( $skin, $result ) {
		global $wgLang, $wgContLang;
		$link = "";
		if ( $result !== null ) {
			$uid = intval( $result->uid );
			$userName = $result->username;
			$userTitle = Title::makeTitleSafe( NS_USER, $userName );
			$user_link = self::$skin->link( $userTitle, $userName );
			$voice_link = self::$skin->link( $this->getTitle(), wfMsg( 'qp_voice_link' . ( $this->inverse ? "_inv" : "" ) ), array(), array( "id" => intval( $this->pid ), "uid" => $uid, "action" => "uvote" ) );
			$text_answer = ( $result->text_answer == '' ) ? '' : '<i>' . qp_Setup::entities( $result->text_answer ) . '</i>';
			$link = wfMsg( 'qp_results_line_qucl', $user_link, $voice_link, $text_answer );
		}
		return $link;
	}

	function linkParameters() {
		$params[ "action" ] = $this->cmd;
		if ( $this->pid !== null ) {
			$params[ "id" ] = $this->pid;
			$params[ "qid" ] = $this->question_id;
			$params[ "pid" ] = $this->proposal_id;
			$params[ "cid" ] = $this->cat_id;
		}
		return $params;
	}

}

class qp_Excel {

	static function prepareExcelString( $s ) {
		if ( preg_match( '`^=.?`', $s ) ) {
			return "'" . $s;
		}
		return $s;
	}

	static function writeFormattedTable( $worksheet, $rownum, $colnum, &$table, $format = null ) {
		foreach ( $table as $rnum => &$row ) {
			foreach ( $row as $cnum => &$cell ) {
				if ( is_array( $cell ) ) {
					if ( array_key_exists( "format", $cell ) ) {
						$worksheet->write( $rownum + $rnum, $colnum + $cnum, $cell[ 0 ], $cell[ "format" ] );
					} else {
						$worksheet->write( $rownum + $rnum, $colnum + $cnum, $cell[ 0 ], $format );
					}
				} else {
					$worksheet->write( $rownum + $rnum, $colnum + $cnum, $cell, $format );
				}
			}
		}
	}

}