<?php

class RT {

	/**
	 * Register the hook with ParserFirstCallInit
	 */
	public static function registerHook( &$parser ) {
		$parser->setHook( 'rt', array( 'RT::render' ) );
		return true;
	}
	
	// This is called to process <rt>...</rt> within a page
	public static function render( $input, $args = array(), $parser = null ) {
   
		global $wgRequestTracker_Cachepage,
			$wgRequestTracker_Active,
			$wgRequestTracker_DBconn,
			$wgRequestTracker_Sortable,
			$wgRequestTracker_TIMEFORMAT_LASTUPDATED,
			$wgRequestTracker_TIMEFORMAT_LASTUPDATED2,
			$wgRequestTracker_TIMEFORMAT_CREATED,
			$wgRequestTracker_TIMEFORMAT_CREATED2,
			$wgRequestTracker_TIMEFORMAT_RESOLVED,
			$wgRequestTracker_TIMEFORMAT_RESOLVED2,
			$wgRequestTracker_TIMEFORMAT_NOW;
   
		wfLoadExtensionMessages( 'RT' );
   
		// Grab the number if one was given between the <tr> tags
		$ticketnum = 0;
		$matches = array();
		if ( preg_match( '/^\s*(\d+)\s*$/', $input, $matches ) ) {
			$ticketnum = $matches[0];
		}
   
		// Disable all caching unless told not to
		if ( !$wgRequestTracker_Cachepage ) {
			$parser->disableCache();
		}
   
		// Try and connect to the database if we are active
		if ( $wgRequestTracker_Active ) {
			global $wgUser;
			$dbh = pg_connect( $wgRequestTracker_DBconn );
			if ( $dbh == false ) {
				wfDebug( "DB connection error\n" );
				wfDebug( "Connection string: $wgRequestTracker_DBconn\n" );
				$wgRequestTracker_Active = 0;
			}
			$tz = $wgUser->getOption( 'timecorrection' );
			if ( $tz ) {
				$found = array();
				if ( preg_match ( '/((-?\d\d?):(\d\d))/', $tz, $found ) ) {
					if ( $found[3] === '00' ) {
						pg_query( "SET TIME ZONE $found[2]" );
					}
					else {
						print( "SET TIME ZONE INTERVAL '$found[1]' HOUR TO MINUTE" );
					}
				}
			}
		}
   
		// If we are not 'active', we leave right away, with minimal output
		if ( !$wgRequestTracker_Active ) {
			if ( $ticketnum ) {
				return "<span class='rt-ticket-inactive'>RT #$ticketnum</span>";
			}
			$msg = wfMsg( 'rt-inactive' );
			return "<table class='rt-table-inactive' border='1'><tr><td>$msg</td></tr></table>";
		}
   
		// Standard info we gather
		$TZ = "AT TIME ZONE 'GMT'";
		$ticketinfo = 't.id, t.subject, t.priority, INITCAP(t.status) AS status, q.name AS queue,'
			. ' COALESCE(u.realname, u.name) AS owner,'
			. ' u.name AS username,'
			. ' COALESCE(u2.realname, u2.name) AS creator,'
			. " TO_CHAR(t.lastupdated $TZ, '$wgRequestTracker_TIMEFORMAT_LASTUPDATED'::text) AS lastupdated,"
			. " TO_CHAR(t.lastupdated $TZ, '$wgRequestTracker_TIMEFORMAT_LASTUPDATED2'::text) AS lastupdated2,"
			. " TO_CHAR(now() $TZ, '$wgRequestTracker_TIMEFORMAT_NOW'::text) AS nowtime,"
			. " TO_CHAR(t.created $TZ, '$wgRequestTracker_TIMEFORMAT_CREATED'::text) AS created,"
			. " TO_CHAR(t.created $TZ, '$wgRequestTracker_TIMEFORMAT_CREATED2'::text) AS created2,"
			. " TO_CHAR(t.resolved $TZ, '$wgRequestTracker_TIMEFORMAT_RESOLVED'::text) AS resolved,"
			. " TO_CHAR(t.resolved $TZ, '$wgRequestTracker_TIMEFORMAT_RESOLVED2'::text) AS resolved2,"
			. " ROUND(EXTRACT('epoch' FROM t.lastupdated $TZ)) AS lastupdated_epoch,"
			. " ROUND(EXTRACT('epoch' FROM t.created $TZ)) AS created_epoch,"
			. " ROUND(EXTRACT('epoch' FROM t.resolved $TZ)) AS resolved_epoch,"
			. "	CASE WHEN (now() $TZ - t.created) <= '1 second'::interval THEN '1 second' ELSE"
			. " CASE WHEN (now() $TZ - t.created) <= '2 minute'::interval THEN EXTRACT(seconds FROM now() $TZ - t.created) || ' seconds' ELSE"
			. " CASE WHEN (now() $TZ - t.created) <= '2 hour'::interval THEN EXTRACT(minutes FROM now() $TZ - t.created) || ' minutes' ELSE"
			. " CASE WHEN (now() $TZ - t.created) <= '2 day'::interval THEN EXTRACT(hours FROM now() $TZ - t.created) || ' hours' ELSE"
			. " EXTRACT(days FROM now() $TZ - t.created) || ' days' END END END END AS age";
   
		$ticketquery = "SELECT $ticketinfo\nFROM tickets t, queues q, users u, users u2";
		$whereclause = "WHERE t.queue = q.id\nAND t.owner = u.id\nAND t.creator = u2.id";
   
		// If just a single number, treat it as <rt>#</rt>
		if ( 1 === count( $args ) ) {
			if ( preg_match( '/^\d+$/', key( $args ) ) ) {
				$ticketnum = key( $args );
			}
		}
   
		// Look up a single ticket number
		if ( $ticketnum ) {
			$SQL = "$ticketquery $whereclause\nAND t.id = $ticketnum";
			$res = pg_query( $dbh, $SQL );
			if ( !$res ) {
				die ( wfMsg( 'rt-badquery' ) );
			}
			$info = pg_fetch_array( $res );
			if ( !$info ) {
				return "<span class='rt-nosuchticket'>RT #$ticketnum</span>";
			}
			return self::fancyLink( $info, $args, $parser, 0 );
		}
   
		// Add in a LIMIT clause if l=xx or limit=xx was used
		$limit = '';
		if ( array_key_exists( 'limit', $args ) ) {
			$args['l'] = $args['limit'];
		}
		if ( array_key_exists( 'l', $args ) ) {
			$limit = trim( $args['l'] );
			if ( !preg_match( '/^ *\d+ *$/', $limit ) ) {
				die ( wfMsg ( 'rt-badlimit', $limit ) );
			}
			$limit = " LIMIT $limit";
		}
   
		// Change the default ORDER BY clause if ob=xx was used
		$orderby = 'ORDER BY t.lastupdated DESC, t.id';
		$valid_orderby = array
			(
			 'id'          => 't.id',
			 'subject'     => 't.subject',
			 'priority'    => 't.priority',
			 'status'      => 't.status',
			 'queue'       => 'q.name',
			 'owner'       => 'COALESCE(u.realname, u.name)',
			 'creator'     => 'COALESCE(u2.realname, u2.name)',
			 'lastupdated' => 't.lastupdated',
			 'created'     => 't.created',
			 'resolved'    => 't.resolved',
			 );
		if ( array_key_exists( 'ob', $args ) ) {
			$orderby = 'ORDER BY';
			$orderbyargs = trim( strtolower( $args['ob'] ) );
			foreach ( preg_split( '/\s*,\s*/', $orderbyargs ) as $word ) {
				$oldlen = strlen( $word );
				$word = ltrim( $word, '!' );
				$mod = $oldlen !== strlen( $word ) ? ' DESC' : '';
				if ( !preg_match( '/^\w+$/', $word ) ) {
					die ( wfMsg ( 'rt-badorderby', $word ) );
				}
				if ( array_key_exists( $word, $valid_orderby ) ) {
					$word = $valid_orderby[$word];
				}
				else if ( !preg_match ( '/^\d+$/', $word ) ) {
					die ( wfMsg ( 'rt-badorderby', $word ) );
				}
				$orderby .= " $word$mod,";
			}
			$orderby = rtrim( $orderby, ',' );
		}
   
		// Determine what status to use. Default is new and open:
		$searchstatus = "t.status IN ('new','open')";
		$valid_status = array( 'new', 'open', 'resolved', 'deleted', 'stalled', 'rejected' );
		if ( array_key_exists( 's', $args ) ) {
			$statusargs = trim( strtolower( $args['s'] ) );
			if ( $statusargs === 'all' ) {
				$searchstatus = '';
			}
			else {
				$searchstatus = 't.status IN (';
				foreach ( preg_split( '/\s*,\s*/', $statusargs ) as $word ) {
					if ( !in_array( $word, $valid_status ) ) {
						die ( wfMsg ( 'rt-badstatus', $word ) );
					}
					$searchstatus .= "'$word',";
				}
				$searchstatus = preg_replace( '/.$/', ')', $searchstatus );
			}
		}
		if ( strlen( $searchstatus) ) {
			$whereclause .= "\nAND $searchstatus";
		}

		// See if we are limiting to one or more queues
		$searchq = '';
		if ( array_key_exists( 'q', $args ) ) {
			$qargs = trim( strtolower( $args['q'] ) );
			$searchq = 'LOWER(q.name) IN (';
			foreach ( preg_split( '/\s*,\s*/', $qargs ) as $word ) {
				$word = trim( $word );
				if ( !preg_match( '/^[\w \.-]+$/', $word ) ) {
					die ( wfMsg ( 'rt-badqueue', $word ) );
				}
				$searchq .= "'$word',";
			}
			$searchq = preg_replace( '/.$/', ')', $searchq );
			$whereclause .= "\nAND $searchq";
		}
   
		// See if we are limiting to one or more owners
		$searchowner = '';
		if ( array_key_exists( 'o', $args ) ) {
			$oargs = trim( strtolower( $args['o'] ) );
			$searchowner = 'LOWER(u.name) IN (';
			foreach ( preg_split( '/\s*,\s*/', $oargs ) as $word ) {
				$word = trim( $word );
				if ( !preg_match( '/^[\w\@\.\-\:\/]+$/', $word ) ) {
					die ( wfMsg ( 'rt-badowner', $word ) );
				}
				$searchowner .= "'$word',";
			}
			$searchowner = preg_replace( '/.$/', ')', $searchowner );
			$whereclause .= "\nAND $searchowner";
		}
   
		// Allow use of custom fields
		$searchcustom = '';
		if ( array_key_exists('custom', $args ) ) {
			$searchcustom = trim( $args['custom'] );
			$cfargs = trim( strtolower( $args['custom'] ) );
			$ticketquery .= ', customfields cf, objectcustomfieldvalues ov';
			$whereclause .= "\nAND ov.objectid = t.id\nAND ov.customfield=cf.id";
			$whereclause .= "\nAND LOWER(cf.name) IN (";
			foreach ( preg_split( '/\s*,\s*/', $cfargs ) as $word ) {
				$word = trim( $word );
				if ( !preg_match( '/^[\w \.-]+$/', $word ) ) {
					die ( wfMsg ( 'rt-badcfield', $word ) );
				}
				$whereclause .= "'$word',";
				$ticketquery = preg_replace( '/COALESCE/', "\nov.content AS custom, COALESCE", $ticketquery);
			}
			$whereclause = preg_replace( '/.$/', ')', $whereclause );
		}

		// Build and run the final query
		$SQL = "$ticketquery $whereclause $orderby $limit";
		$res = pg_query( $dbh, $SQL );
		if ( !$res ) {
			die ( wfMsg( 'rt-badquery' ) );
		}
		$info = pg_fetch_all( $res );
		if ( !$info ) {
			$msg = wfMsg( 'rt-nomatches' );
			return "<table class='rt-table-empty' border='1'><tr><th>$msg</th><tr></table>";
		}

		// Figure out what columns to show
		// Anything specifically requested is shown
		// Everything else is either on or off by default, but can be overidden
		$output = '';

		// The queue: show by default unless searching a single queue
		$showqueue = 1;
		if ( array_key_exists( 'noqueue', $args )
			|| ( $searchq
				&& false === strpos( $searchq, ',' )
				&& !array_key_exists( 'queue', $args ) ) ) {
			$showqueue = 0;
		}
   
		// The owner: show by default unless searching a single owner
		$showowner = 1;
		if ( array_key_exists( 'noowner', $args )
			|| ( $searchowner
				&& false === strpos( $searchowner, ',' )
				&& !array_key_exists( 'owner', $args ) ) ) {
			$showowner = 0;
		}
   
		// The status: show by default unless searching a single status
		$showstatus = 1;
		if ( array_key_exists( 'nostatus', $args )
			|| ( false === strpos( $searchstatus, ',' )
				&& !array_key_exists( 'status', $args ) ) ) {
			$showstatus = 0;
		}
   
		// Things we always show unless told not to:
		$showsubject = ! array_key_exists( 'nosubject', $args );
		$showupdated = ! array_key_exists( 'noupdated', $args );
		$showticket  = ! array_key_exists( 'noticket',  $args );
   
		// Things we don't show unless asked to:
		$showpriority  = array_key_exists( 'priority',  $args );
		$showupdated2  = array_key_exists( 'updated2',  $args );
		$showcreated   = array_key_exists( 'created',   $args );
		$showcreated2  = array_key_exists( 'created2',  $args );
		$showresolved  = array_key_exists( 'resolved',  $args );
		$showresolved2 = array_key_exists( 'resolved2', $args );
		$showage       = array_key_exists( 'age',       $args );
		$showcustom    = array_key_exists( 'custom',    $args );
   
		// Unless 'tablerows' has been set, output the table and header tags
		if ( !array_key_exists( 'tablerows', $args ) ) {
   
			$class = $wgRequestTracker_Sortable ? 'wikitable sortable' : 'rt-table';

			// Allow override of the default sortable table option
			if (array_key_exists('sortable', $args ) ) {
				$class = 'wikitable sortable';
			}
			if (array_key_exists('nosortable', $args ) ) {
				$class = 'rt-table';
			}

			$output = "<table class='$class' border='1'>\n<tr>\n";

			if ( $showticket )    { $output .= "<th style='white-space: nowrap'>Ticket</th>\n";       }
			if ( $showcustom )    {
				foreach ( preg_split( '/\s*,\s*/', $searchcustom ) as $word ) {
					$word = trim( $word );
					$output .= "<th style='white-space: nowrap'>$word</th>\n";
					break;
				}
			}
			if ( $showqueue )     { $output .= "<th style='white-space: nowrap'>Queue</th>\n";        }
			if ( $showsubject )   { $output .= "<th style='white-space: nowrap'>Subject</th>\n";      }
			if ( $showstatus )    { $output .= "<th style='white-space: nowrap'>Status</th>\n";       }
			if ( $showpriority )  { $output .= "<th style='white-space: nowrap'>Priority</th>\n";     }
			if ( $showowner )     { $output .= "<th style='white-space: nowrap'>Owner</th>\n";        }
			if ( $showupdated )   { $output .= "<th style='white-space: nowrap'>Last updated</th>\n"; }
			if ( $showupdated2 )  { $output .= "<th style='white-space: nowrap'>Last updated</th>\n"; }
			if ( $showcreated )   { $output .= "<th style='white-space: nowrap'>Created</th>\n";      }
			if ( $showcreated2 )  { $output .= "<th style='white-space: nowrap'>Created</th>\n";      }
			if ( $showresolved )  { $output .= "<th style='white-space: nowrap'>Resolved</th>\n";     }
			if ( $showresolved2 ) { $output .= "<th style='white-space: nowrap'>Resolved</th>\n";     }
			if ( $showage )       { $output .= "<th style='white-space: nowrap'>Age</th>\n";          }
   
			$output .= "</tr>\n";
		}
   
		foreach ( $info as $row ) {
   
			if ( $showticket )  {
				$id = self::fancyLink( $row, $args, $parser, 1 );
				$output .= "<td style='white-space: nowrap'>$id</td>";
			}
			if ( $showcustom )    { $output .= '<td>' . htmlspecialchars( $row['custom'] ) . "</td>\n";  }
			if ( $showqueue )     { $output .= '<td>' . htmlspecialchars( $row['queue'] )    . "</td>\n"; }
			if ( $showsubject )   { $output .= '<td>' . htmlspecialchars( $row['subject'] )  . "</td>\n"; }
			if ( $showstatus )    { $output .= '<td>' . htmlspecialchars( $row['status'] )   . "</td>\n"; }
			if ( $showpriority )  { $output .= '<td>' . htmlspecialchars( $row['priority'] ) . "</td>\n"; }
			if ( $showowner )     {
				$prettyowner = $row['owner'] == 'Nobody in particular' ? 'Nobody' : $row['owner'];
				$output .= '<td>' . htmlspecialchars( $prettyowner )   . "</td>\n";
			}
			if ( $showupdated )   { $output .= "<td><span style='display:none'>"
					. $row['lastupdated_epoch'] . "</span>" . $row['lastupdated']  . "</td>\n"; }
			if ( $showupdated2 )  { $output .= "<td><span style='display:none'>"
					. $row['lastupdated_epoch'] . "</span>" . $row['lastupdated2'] . "</td>\n"; }
			if ( $showcreated )   { $output .= "<td><span style='display:none'>"
					. $row['created_epoch']     . "</span>" . $row['created']      . "</td>\n"; }
			if ( $showcreated2 )  { $output .= "<td><span style='display:none'>"
					. $row['created_epoch']     . "</span>" . $row['created2']     . "</td>\n"; }
			if ( $showresolved )  { $output .= "<td><span style='display:none'>"
					. $row['resolved_epoch']    . "</span>" . $row['resolved']     . "</td>\n"; }
			if ( $showresolved2 )  { $output .= "<td><span style='display:none'>"
					. $row['resolved_epoch']    . "</span>" . $row['resolved2']    . "</td>\n"; }
			if ( $showage )       { $output .= '<td>' . $row['age'] . "</td>\n"; }
			$output .= "\n</tr>\n";
		}
   
		if ( !array_key_exists( 'tablerows', $args ) ) {
			$output .= "\n</table>\n";
		}
   
		return $output;
	}

	private static function fancyLink( $row, $args, $parser, $istable ) {
   
		global $wgRequestTracker_URL, $wgRequestTracker_Formats, $wgRequestTracker_Useballoons;
   
		$ticketnum = $row['id'];
		$ret = "[$wgRequestTracker_URL=$ticketnum RT #$ticketnum]";
   
		# Check for any custom format args in the rt tag.
		# If any are found, use that and ignore any other args
		$foundformat = 0;
		foreach ( array_keys( $args ) as $val ) {
			if ( array_key_exists( $val, $wgRequestTracker_Formats ) ) {
				$format = $wgRequestTracker_Formats[$val];
				foreach ( array_keys( $row ) as $rev ) {
					$format = str_replace( "?$rev?", "$row[$rev]", $format );
				}
				$ret .= " $format";
				$foundformat = 1;
				break;
			}
		}
   
		# Process any column-based args to the rt tag
		if ( !$foundformat and !$istable ) {
			foreach ( array_keys( $args ) as $val ) {
				if ( array_key_exists( $val, $row ) ) {
					$format = $args[$val];
					if ( false === strpos( $format, '?' ) ) {
						$showname = $val === 'lastupdated' ? 'Last updated' : ucfirst( $val );
						$ret .= " $showname: $row[$val]";
					}
					else {
						$ret .= " " . str_replace( '?', $row[$val], $format );
					}
				}
			}
		}
   
		$ret = $parser->recursiveTagParse( $ret );
   
		// Not using balloons? Just return the current text
		if ( !$wgRequestTracker_Useballoons || array_key_exists( 'noballoon', $args ) ) {
			return "<span class='rt-ticket-noballoon'>$ret</span>";
		}
   
		$safesub = preg_replace( '/\"/', '\"', $row['subject'] );
		$safesub = preg_replace( '/\'/', "\'", $safesub );
		$safesub = htmlspecialchars( $safesub );
   
		$safeowner = $row['owner'];
		if ( $row['owner'] !== $row['username'] ) {
			$safeowner .= " ($row[username])";
		}
		$safeowner = preg_replace( '/\"/', '\"', $safeowner );
		$safeowner = preg_replace( '/\'/', "\'", $safeowner );
		$safeowner = htmlspecialchars( $safeowner );
   
		$safeq = preg_replace( '/\"/', '\"', $row['queue'] );
		$safeq = preg_replace( '/\'/', "\'", $safeq );
		$safeq = htmlspecialchars( $safeq );
   
		$text = "RT #<b>$ticketnum</b>";
		$text .= "<br />Status: <b>$row[status]</b>";
		$text .= "<br />Subject: <b>$safesub</b>";
		$text .= "<br />Owner: <b>$safeowner</b>";
		$text .= "<br />Queue: <b>$safeq</b>";
		$text .= "<br />Created: <b>$row[created]</b>";
		if ( $row['status'] === 'Resolved' ) {
			$text .= "<br />Resolved: <b>$row[resolved]</b>";
		}
		else {
			$text .= "<br />Last updated: <b>$row[lastupdated]</b>";
		}
   
		# Prepare some balloon-tek
		$link   = isset( $args['link'] )   ? $args['link']   : '';
		$target = isset( $args['target'] ) ? $args['target'] : '';
		$sticky = isset( $args['sticky'] ) ? $args['sticky'] : '0';
		$width  = isset( $args['width'] )  ? $args['width']  : '0';
   
		$event  = isset( $args['click'] ) && $args['click'] && !$link ? 'onclick' : 'onmouseover';
		$event2 = '';
		$event  = "$event=\"balloon.showTooltip(event,'${text}',${sticky},${width})\"";
   
		if ( preg_match( '/onclick/', $event ) && $args['hover'] ) {
			$event2 = " onmouseover=\"balloon.showTooltip(event,'" . $args['hover'] . "',0,${width})\"";
		}
   
		$has_style = isset( $args['style'] ) && $args['style'];
		$style  = "style=\"" . ( $has_style ? $args['style'] . ";cursor:pointer\"" : "cursor:pointer\"" );
		$target = $target ? "target=${target}" : '';
		$output = "<span class='rt-ticket' ${event} ${event2} ${style}>$ret</span>";
   
		return $output;
	}
}