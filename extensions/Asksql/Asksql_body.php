<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

/** Main class that define a new special page*/
class SpecialAsksql extends SpecialPage {

	function __construct() {
		parent::__construct( 'Asksql', 'asksql' );
	}

	function execute( $par ) {
		global $wgAllowSysopQueries, $wgUser, $wgRequest, $wgOut;



		if ( !$wgAllowSysopQueries ) {
			throw new ErrorPageError( 'nosuchspecialpage', 'nospecialpagetext' );
		}
		if ( !$wgUser->isAllowed( 'asksql' ) ) {
			$wgOut->permissionRequired( 'asksql' );
			return;
		}

		if ( $wgRequest->wasPosted() ) {
			$query = $wgRequest->getVal( 'wpSqlQuery' );
			$action = $wgRequest->getVal( 'action' );
		} else {
			$query = '';
			$action = '';
		}
		$f = new SqlQueryForm( $query );

		if ( "submit" == $action ) {
			$f->doSubmit();
		} else {
			$f->showForm( '' );
		}
	}
}

/**
 * @access private
 * @ingroup SpecialPage
 */
class SqlQueryForm {
	var $query = '';

	function __construct( $query ) {
		$this->query = $query;
	}

	function showForm( $err ) {
		global $wgOut, $wgUser, $wgLang;
		global $wgLogQueries;

		$wgOut->setPagetitle( wfMsg( 'asksql' ) );
		$note = wfMsg( 'asksqltext' );
		if ( $wgLogQueries )
			$note .= ' ' . wfMsg( 'sqlislogged' );
		$wgOut->addWikiText( $note );

		if ( '' != $err ) {
			$wgOut->addHTML( '<p><font color="red" size="+1">' . htmlspecialchars( $err ) . "</font>\n" );
		}
		if ( ! $this->query ) { $this->query = 'SELECT ... FROM ... WHERE ...'; }
		$q = wfMsg( 'sqlquery' );
		$qb = wfMsg( 'querybtn' );
		$titleObj = SpecialPage::getTitleFor( 'Asksql' );
		$action = $titleObj->escapeLocalURL( 'action=submit' );

		$wgOut->addHTML( "<p>
<form id=\"asksql\" method=\"post\" action=\"{$action}\">
<p>{$q}:</p>
<textarea name=\"wpSqlQuery\" cols='80' rows='4' tabindex='1' style='width:100%'>"
. htmlspecialchars( $this->query ) . "
</textarea>
<p><input type=submit name=\"wpQueryBtn\" value=\"{$qb}\"></p>
</form>\n" );

	}

	function doSubmit() {
		global $wgOut, $wgUser, $wgServer, $wgLang, $wgContLang;
		global $wgDBserver, $wgDBsqluser, $wgDBsqlpassword, $wgDBname, $wgSqlTimeout;
		global $wgDBtype;

		# Use a limit, folks!
		$this->query = trim( $this->query );
		if ( preg_match( '/^SELECT/i', $this->query )
			&& !preg_match( '/LIMIT/i', $this->query ) ) {
			$this->query .= ' LIMIT 100';
		}

		$conn = DatabaseBase::newFromType( $wgDBtype,
			array(
			     'host' => $wgDBserver,
			     'user' => $wgDBsqluser,
			     'password' => $wgDBsqlpassword,
			     'dbname' => $wgDBname
			)
		);

		$this->logQuery( $this->query );

		# Start timer, will kill the DB thread in $wgSqlTimeout seconds
		# FIXME: timer functions needed!
		# $conn->startTimer( $wgSqlTimeout );
		$res = $conn->query( $this->query, 'SpecialAsksql::doSubmit' );
		# $conn->stopTimer();
		$this->logFinishedQuery();

		$n = 0;
		@$n = $conn->numFields( $res );
		$titleList = false;

		if ( $n ) {
			$k = array();
			for ( $x = 0; $x < $n; ++$x ) {
				array_push( $k, $conn->fieldName( $res, $x ) );
			}

			if ( $n == 2 && in_array( 'page_title', $k ) && in_array( 'page_namespace', $k ) ) {
				$titleList = true;
			}

			$a = array();
			foreach ( $res as $s ) {
				array_push( $a, $s );
			}
			$conn->freeResult( $res );

			if ( $titleList ) {
				$r = "";
				foreach ( $a as $y ) {
					$sTitle = htmlspecialchars( $y->page_title );
					if ( $y->page_namespace ) {
						$sNamespace = $wgContLang->getNsText( $y->page_namespace );
						$link = "$sNamespace:$sTitle";
					} else {
						$link = "$sTitle";
					}
					$title = Title::newFromText( $link );
					$skin = $wgUser->getSkin();
					$link = $skin->makeLinkObj( $title );
					$r .= "* [[$link]]<br />\n";
				}
			} else {

				$r = "<table border=1 bordercolor=black cellspacing=0 " .
				  "cellpadding=2><tr>\n";
				foreach ( $k as $x ) $r .= "<th>" . htmlspecialchars( $x ) . "</th>";
				$r .= "</tr>\n";

				foreach ( $a as $y ) {
					$r .= '<tr>';
					foreach ( $k as $x ) {
						$o = $y->$x ;
						if ( $x == 'page_title'  or $x == 'rc_title' ) {
							$namespace = 0;
							if ( $x == 'page_title' && isset( $y->page_namespace ) ) $namespace = $y->page_namespace;
							if ( $x == 'rc_title' && isset( $y->rc_namespace ) ) $namespace = $y->rc_namespace;
							$title =& Title::makeTitle( $namespace, $o );
							$o = "<a href=\"" . $title->escapeLocalUrl() . "\" class='internal'>" .
							  htmlspecialchars( $y->$x ) . '</a>' ;
						} else {
							$o = htmlspecialchars( $o );
						}
						$r .= '<td>' . $o . "</td>\n";
					}
					$r .= "</tr>\n";
				}
				$r .= "</table>\n";
			}
		}
		$this->showForm( wfMsg( "querysuccessful" ) );
		$wgOut->addHTML( "<hr />{$r}\n" );
	}

	function logQuery( $q ) {
		global $wgSqlLogFile, $wgLogQueries, $wgUser;
		if ( !$wgLogQueries ) return;

		$f = fopen( $wgSqlLogFile, 'a' );
		fputs( $f, "\n\n" . wfTimestampNow() .
			" query by " . $wgUser->getName() .
			":\n$q\n" );
		fclose( $f );
		$this->starttime = wfTime();
	}

	function logFinishedQuery() {
		global $wgSqlLogFile, $wgLogQueries;
		if ( !$wgLogQueries ) return;

		$interval = wfTime() - $this->starttime;

		$f = fopen( $wgSqlLogFile, 'a' );
		fputs( $f, 'finished at ' . wfTimestampNow() . "; took $interval secs\n" );
		fclose( $f );
	}
}
