<?php
/**
 DPLforum v3.2 -- DynamicPageList-based forum extension

 Author: Ross McClure
 http://www.mediawiki.org/wiki/User:Algorithm

 DynamicPageList written by: n:en:User:IlyaHaykinson n:en:User:Amgine
 http://en.wikinews.org/wiki/User:Amgine
 http://en.wikinews.org/wiki/User:IlyaHaykinson

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along
 with this program; if not, write to the Free Software Foundation, Inc.,
 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 http://www.gnu.org/copyleft/gpl.html

 * @file
 * @ingroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and is not a valid access point" );
	die( 1 );
}

class DPLForum {
	var $minCategories = 1;           // Minimum number of categories to look for
	var $maxCategories = 6;           // Maximum number of categories to look for
	var $maxResultCount = 50;         // Maximum number of results to allow
	var $unlimitedResults = true;     // Allow unlimited results
	var $unlimitedCategories = false; // Allow unlimited categories
	var $requireCache = false;        // Only clear the cache on purge

	// Restricted namespaces cannot be searched for page author or creation time.
	// Unless this array is empty, namespace-free searches are also restricted.
	// Note: Only integers in this array are checked.
	var $restrictNamespace = array(); // No restrictions

	var $bTableMode;
	var $bTimestamp;
	var $bLinkHistory;
	var $bEmbedHistory;
	var $bShowNamespace;
	var $bAddAuthor;
	var $bAddCreationDate;
	var $bAddLastEdit;
	var $bAddLastEditor;
	var $bCompactAuthor;
	var $bCompactEdit;
	var $sInput;
	var $sOmit;
	var $vMarkNew;

	function cat( &$parser, $name ) {
		$cats = array();
		if ( preg_match_all( "/^\s*$name\s*=\s*(.*)/mi", $this->sInput, $matches ) ) {
			foreach ( $matches[1] as $cat ) {
				$title = Title::newFromText( $parser->replaceVariables( trim( $cat ) ) );
				if ( !is_null( $title ) )
					$cats[] = $title;
			}
		}
		return $cats;
	}

	function get( $name, $value = null, $parser = null ) {
		if ( preg_match( "/^\s*$name\s*=\s*(.*)/mi", $this->sInput, $matches ) ) {
			$arg = trim( $matches[1] );
			if ( is_int( $value ) )
				return intval( $arg );
			elseif ( is_null( $parser ) )
				return htmlspecialchars( $arg );
			else
				return $parser->replaceVariables( $arg );
		}
		return $value;
	}

	function link( &$parser, $count, $page = '', $text = '' ) {
		wfLoadExtensionMessages( 'DPLforum' );
		$count = intval( $count );
		if ( $count < 1 )
			return '';

		if ( $this->requireCache )
			$offset = 0;
		else {
			global $wgRequest;
			$parser->disableCache();
			$offset = intval( $wgRequest->getVal( 'offset', '' ) );
		}

		$i = intval( $page );
		if ( ( $i != 0 ) && ctype_digit( $page[0] ) )
			$i -= 1;
		else
			$i += intval( $offset / $count );
		if ( $this->link_test( $i, $page ) )
			return '';

		if ( $text === '' )
			$text = ( $i + 1 );
		$page = ( $count * $i );
		if ( $page == $offset )
			return $text;

		return '[' . $parser->replaceVariables( '{{fullurl:{{FULLPAGENAME}}|offset=' . $page . '}} ' ) . $text . ']';
	}

	function link_test( $page, $cond ) {
		if ( preg_match( "/\\d+(\\D+)(\\d+)/", $cond, $m ) ) {
			$m[1] = strtr( $m[1], array( ( '&l' . 't;' ) => '<', ( '&g' . 't;' ) => '>' ) );
			$m[2] = intval( $m[2] ) - 1;
			switch( $m[1] ) {
				case '<':
					return ( $page >= $m[2] );
				case '>':
					return ( $page <= $m[2] );
				case '<=':
					return ( $page > $m[2] );
				case '>=':
					return ( $page < $m[2] );
			}
		}
		return ( $page < 0 );
	}

	function msg( $type, $error = null ) {
		if ( $error && ( $this->get( 'suppresserrors' ) == 'true' ) )
			return '';

		return htmlspecialchars( wfMsg( $type ) );
	}

	function parse( &$input, &$parser ) {
		global $wgContLang;

		wfLoadExtensionMessages( 'DPLforum' );

		$this->sInput =& $input;
		$sPrefix = $this->get( 'prefix', '', $parser );
		$this->sOmit = $this->get( 'omit', $sPrefix, $parser );
		$this->bAddAuthor = ( $this->get( 'addauthor' ) == 'true' );
		$this->bTimestamp = ( $this->get( 'timestamp' ) != 'false' );
		$this->bAddLastEdit = ( $this->get( 'addlastedit' ) != 'false' );
		$this->bAddLastEditor = ( $this->get( 'addlasteditor' ) == 'true' );
		$this->bAddCreationDate = ( $this->get( 'addcreationdate' ) == 'true' );

		switch( $this->get( 'historylink' ) ) {
			case 'embed':
			case 'true':
				$this->bEmbedHistory = true;
			case 'append':
			case 'show':
				$this->bLinkHistory = true;
		}
		$sOrder = 'rev_timestamp';
		switch( $this->get( 'ordermethod' ) ) {
			case 'categoryadd':
			case 'created':
				$sOrder = 'first_time';
			break;
			case 'pageid':
				$sOrder = 'page_id';
		}

		$arg = $this->get( 'compact' );
		if ( $arg == 'all' || strpos( $arg, 'edit' ) === 0 )
		$this->bCompactEdit = $this->bAddLastEdit;
		$this->bCompactAuthor = ( $arg == 'author' || $arg == 'all' );

		$arg = $this->get( 'namespace', '', $parser );
		$iNamespace = $wgContLang->getNsIndex( $arg );
		if ( !$iNamespace ) {
			if ( ( $arg ) || ( $arg === '0' ) )
				$iNamespace = intval( $arg );
			else
				$iNamespace = - 1;
		}
		if ( $iNamespace < 0 )
			$this->bShowNamespace = ( $this->get( 'shownamespace' ) != 'false' );
		else
			$this->bShowNamespace = ( $this->get( 'shownamespace' ) == 'true' );

		$this->bTableMode = false;
		$sStartItem = $sEndItem = '';
		$bCountMode = false;
		$arg = $this->get( 'mode' );
		switch( $arg ) {
			case 'none':
				$sEndItem = '<br />';
			break;
			case 'count':
				$bCountMode = true;
			break;
			case 'list':
			case 'ordered':
			case 'unordered':
				$sStartItem = '<li>';
				$sEndItem = '</li>';
			break;
			case 'table':
			default:
				$this->bTableMode = true;
				$sStartItem = '<tr>';
				$sEndItem = '</tr>';
		}
		$aCategories = $this->cat( $parser, 'category' );
		$aExcludeCategories = $this->cat( $parser, 'notcategory' );
		$cats = count( $aCategories );
		$nocats = count( $aExcludeCategories );
		$total = $cats + $nocats;
		$output = '';

		if ( $sPrefix === '' && ( ( $cats < 1 && $iNamespace < 0 ) ||
		( $total < $this->minCategories ) ) )
			return $this->msg( 'dplforum-toofew', 1 );
		if ( ( $total > $this->maxCategories ) && ( !$this->unlimitedCategories ) )
			return $this->msg( 'dplforum-toomany', 1 );

		$count = 1;
		$start = $this->get( 'start', 0 );
		$title = Title::newFromText( $parser->replaceVariables(
			trim( $this->get( 'title' ) ) ) );
		if ( !( $bCountMode || $this->requireCache || $this->get( 'cache' ) == 'true' ) ) {
			$parser->disableCache();

			if ( is_null( $title ) ) {
				global $wgRequest;
				$start += intval( $wgRequest->getVal( 'offset' ) );
			}
		}
		if ( $start < 0 )
			$start = 0;

		if ( is_null( $title ) ) {
			$count = $this->get( 'count', 0 );
			if ( $count > 0 ) {
				if ( $count > $this->maxResultCount )
					$count = $this->maxResultCount;
			} elseif ( $this->unlimitedResults )
				$count = 0x7FFFFFFF; // maximum integer value
			else
				$count = $this->maxResultCount;
		}

		// build the SQL query
		$dbr = wfGetDB( DB_SLAVE );
		$sPageTable = $dbr->tableName( 'page' );
		$sRevTable = $dbr->tableName( 'revision' );
		$categorylinks = $dbr->tableName( 'categorylinks' );
		$sSqlSelectFrom = "SELECT page_namespace, page_title,"
			. " r.rev_user_text, r.rev_timestamp";
		$arg = " FROM $sPageTable INNER JOIN $sRevTable"
			. " AS r ON page_latest = r.rev_id";

		if ( $bCountMode ) {
			$sSqlSelectFrom = "SELECT COUNT(*) AS num_rows FROM $sPageTable";
		} elseif ( ( $this->bAddAuthor || $this->bAddCreationDate ||
		( $sOrder == 'first_time' ) ) && ( ( !$this->restrictNamespace ) ||
		( $iNamespace >= 0 && !in_array( $iNamespace, $this->restrictNamespace ) ) ) ) {
			$sSqlSelectFrom .= ", o.rev_user_text AS first_user, o.rev_timestamp AS"
			. " first_time" . $arg . " INNER JOIN $sRevTable AS o"
			. " ON o.rev_id =( SELECT MIN(q.rev_id) FROM $sRevTable"
			. " AS q WHERE q.rev_page = page_id )";
		} else {
			if ( $sOrder == 'first_time' )
				$sOrder = 'page_id';
			$sSqlSelectFrom .= $arg;
		}

		$sSqlWhere = ' WHERE 1=1';
		if ( $iNamespace >= 0 )
			$sSqlWhere = ' WHERE page_namespace=' . $iNamespace;

		if ( $sPrefix !== '' ) {
			// Escape SQL special characters
			$sPrefix = strtr( $sPrefix, array( '\\' => '\\\\\\\\',
			' ' => '\\_', '_' => '\\_', '%' => '\\%', '\'' => '\\\'' ) );
			$sSqlWhere .= " AND page_title LIKE BINARY '" . $sPrefix . "%'";
		}

		switch( $this->get( 'redirects' ) ) {
			case 'only':
				$sSqlWhere .= ' AND page_is_redirect = 1';
			case 'include':
			break;
			case 'exclude':
			default:
				$sSqlWhere .= ' AND page_is_redirect = 0';
			break;
		}

		$n = 1;
		for ( $i = 0; $i < $cats; $i++ ) {
			$sSqlSelectFrom .= " INNER JOIN $categorylinks AS" .
			" c{$n} ON page_id = c{$n}.cl_from AND c{$n}.cl_to=" .
			$dbr->addQuotes( $aCategories[$i]->getDBkey() );
			$n++;
		}
		for ( $i = 0; $i < $nocats; $i++ ) {
			$sSqlSelectFrom .= " LEFT OUTER JOIN $categorylinks AS" .
			" c{$n} ON page_id = c{$n}.cl_from AND c{$n}.cl_to=" .
			$dbr->addQuotes( $aExcludeCategories[$i]->getDBkey() );
			$sSqlWhere .= " AND c{$n}.cl_to IS NULL";
			$n++;
		}

		if ( !$bCountMode ) {
			$sSqlWhere .= " ORDER BY $sOrder ";

			if ( $this->get( 'order' ) == 'ascending' ) {
				$sSqlWhere .= 'ASC';
			} else {
				$sSqlWhere .= 'DESC';
			}
		}
		$sSqlWhere .= " LIMIT $start, $count";

		// DEBUG: output SQL query
		// $output .= 'QUERY: [' . $sSqlSelectFrom . $sSqlWhere . "]<br />";

		// process the query
		$res = $dbr->query( $sSqlSelectFrom . $sSqlWhere, __METHOD__ );

		$this->vMarkNew = $dbr->timestamp( time() -
			intval( $this->get( 'newdays', 7 ) * 86400 ) );

		if ( $bCountMode ) {
			if ( $row = $dbr->fetchObject( $res ) ) {
				$output .= $row->num_rows;
			} else {
				$output .= '0';
			}
		} elseif ( is_null( $title ) ) {
			while ( $row = $dbr->fetchObject( $res ) ) {
				if( isset( $row->first_time ) ) {
					$first_time = $row->first_time;
				} else {
					$first_time = '';
				}

				if( isset( $row->first_user ) ) {
					$first_user = $row->first_user;
				} else {
					$first_user = '';
				}

				$title = Title::makeTitle( $row->page_namespace, $row->page_title );
				$output .= $sStartItem;
				$output .= $this->buildOutput( $title, $title, $row->rev_timestamp,
					$row->rev_user_text, $first_user, $first_time );
				$output .= $sEndItem . "\n";
			}
		} else {
			$output .= $sStartItem;
			if ( $row = $dbr->fetchObject( $res ) ) {
				$output .= $this->buildOutput( Title::makeTitle( $row->page_namespace,
					$row->page_title ), $title, $row->rev_timestamp, $row->rev_user_text );
			} else {
				$output .= $this->buildOutput( null, $title, $this->msg( 'dplforum-never' ) );
			}
			$output .= $sEndItem . "\n";
		}
		return $output;
	}

	// Generates a single line of output.
	function buildOutput( $page, $title, $time, $user = '', $author = '', $made = '' ) {
		global $wgLang, $wgUser;

		$sk = $wgUser->getSkin();
		$tm =& $this->bTableMode;
		$output = '';

		if ( $this->bAddCreationDate ) {
			if ( is_numeric( $made ) ) {
				$made = $wgLang->date( $made, true );
			}

			if ( $page && $this->bLinkHistory && !$this->bAddLastEdit ) {
				if ( $this->bEmbedHistory ) {
					$made = $sk->makeKnownLinkObj( $page, $made, 'action=history' );
				} else {
					$made .= ' (' . $sk->makeKnownLinkObj( $page,
						wfMsg( 'hist' ), 'action=history' ) . ')';
				}
			}

			if ( $tm ) {
				$output .= "<td class='forum_created'>$made</td>";
			} elseif ( $made ) {
				$output = "{$made}: ";
			}
		}

		if ( $tm ) {
			$output .= "<td class='forum_title'>";
		}

		$text = $query = $props = '';

		if ( $this->bShowNamespace == true ) {
			$text = $title->getEscapedText();
		} else {
			$text = htmlspecialchars( $title->getText() );
		}

		if ( ( $this->sOmit ) && strpos( $text, $this->sOmit ) === 0 ) {
			$text = substr( $text, strlen( $this->sOmit ) );
		}

		if ( is_numeric( $time ) ) {
			if ( $this->bTimestamp ) {
				$query = 't=' . $time;
			}

			if ( $time > $this->vMarkNew ) {
				$props = " class='forum_new'";
			}
		}

		$output .= $sk->makeKnownLinkObj( $title, $text, $query, '', '', $props );
		$text = '';

		if ( $this->bAddAuthor ) {
			$author = Title::newFromText( $author, NS_USER );

			if ( $author ) {
				$author = $sk->makeKnownLinkObj( $author, $author->getText() );
			}

			if ( $tm ) {
				if ( $this->bCompactAuthor ) {
					if ( $author ) {
						$byAuthor = wfMsg( 'word-separator' ) . wfMsgHtml( 'dplforum-by', $author );
						$output .= " <span class='forum_author'>$byAuthor</span>";
					} else {
						$output .= " <span class='forum_author'>&nb" . "sp;</span>";
					}
				} else {
					$output .= "</td><td class='forum_author'>$author";
				}
			} elseif ( $author ) {
				$byAuthor = wfMsg( 'word-separator' ) . wfMsgHtml( 'dplforum-by', $author );
				$output .= $byAuthor;
			}
		}

		if ( $this->bAddLastEdit ) {
			if ( is_numeric( $time ) ) {
				$time = $wgLang->timeanddate( $time, true );
			}

			if ( $page && $this->bLinkHistory ) {
				if ( $this->bEmbedHistory ) {
					$time = $sk->makeKnownLinkObj( $page, $time, 'action=history' );
				} else {
					$time .= ' (' . $sk->makeKnownLinkObj( $page,
						wfMsg( 'hist' ), 'action=history' ) . ')';
				}
			}

			if ( $tm ) {
				$output .= "</td><td class='forum_edited'>$time";
			} else {
				$text .= "$time ";
			}
		}

		if ( $this->bAddLastEditor ) {
			$user = Title::newFromText( $user, NS_USER );

			if ( $user ) {
				$user = $sk->makeKnownLinkObj( $user, $user->getText() );
			}

			if ( $tm ) {
				if ( $this->bCompactEdit ) {
					if ( $user ) {
						$byUser = wfMsgHtml( 'dplforum-by', $user );
						$output .= " <span class='forum_editor'>$byUser</span>";
					} else {
						$output .= " <span class='forum_editor'>&nb" . "sp;</span>";
					}
				} else {
					$output .= "</td><td class='forum_editor'>$user";
				}
			} elseif ( $user ) {
				$byUser = wfMsgHtml( 'dplforum-by', $user );
				$text .= $byUser;
			}
		}

		if ( $tm ) {
			$output .= '</td>';
		} elseif ( $text ) {
			$output .= wfMsg( 'word-separator' ) . $this->msg( 'dplforum-edited' ) . " $text";
		}

		return $output;
	}
}
