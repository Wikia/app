<?php
/** \file
* \brief Contains code for the ContributionScores Class (extends SpecialPage).
*/

/// Special page class for the Contribution Scores extension
/**
 * Special page that generates a list of wiki contributors based
 * on edit diversity (unique pages edited) and edit volume (total
 * number of edits.
 *
 * @ingroup Extensions
 * @author Tim Laqua <t.laqua@gmail.com>
 */
class ContributionScores extends IncludableSpecialPage {
	public function __construct() {
		parent::__construct( 'ContributionScores' );
	}

	/// Generates a "Contribution Scores" table for a given LIMIT and date range
	/**
	 * Function generates Contribution Scores tables in HTML format (not wikiText)
	 *
	 * @param $days int Days in the past to run report for
	 * @param $limit int Maximum number of users to return (default 50)
	 *
	 * @return HTML Table representing the requested Contribution Scores.
	 */
	function genContributionScoreTable( $days, $limit, $title = null, $options = 'none' ) {
		global $wgContribScoreIgnoreBots, $wgContribScoreIgnoreBlockedUsers, $wgContribScoresUseRealName, $wgLang;

		$opts = explode( ',', strtolower( $options ) );

		$dbr = wfGetDB( DB_SLAVE );

		$userTable = $dbr->tableName( 'user' );
		$userGroupTable = $dbr->tableName( 'user_groups' );
		$revTable = $dbr->tableName( 'revision' );
		$ipBlocksTable = $dbr->tableName( 'ipblocks' );

		$sqlWhere = "";
		$nextPrefix = "WHERE";

		if ( $days > 0 ) {
			$date = time() - ( 60 * 60 * 24 * $days );
			$dateString = $dbr->timestamp( $date );
			$sqlWhere .= " {$nextPrefix} rev_timestamp > '$dateString'";
			$nextPrefix = "AND";
		}

		if ( $wgContribScoreIgnoreBlockedUsers ) {
			$sqlWhere .= " {$nextPrefix} rev_user NOT IN (SELECT ipb_user FROM {$ipBlocksTable} WHERE ipb_user <> 0)";
			$nextPrefix = "AND";
		}

		if ( $wgContribScoreIgnoreBots ) {
			$sqlWhere .= " {$nextPrefix} rev_user NOT IN (SELECT ug_user FROM {$userGroupTable} WHERE ug_group='bot')";
			$nextPrefix = "AND";
		}

		$sqlMostPages = "SELECT rev_user,
						 COUNT(DISTINCT rev_page) AS page_count,
						 COUNT(rev_id) AS rev_count
						 FROM {$revTable}
						 {$sqlWhere}
						 GROUP BY rev_user
						 ORDER BY page_count DESC
						 LIMIT {$limit}";

		$sqlMostRevs  = "SELECT rev_user,
						 COUNT(DISTINCT rev_page) AS page_count,
						 COUNT(rev_id) AS rev_count
						 FROM {$revTable}
						 {$sqlWhere}
						 GROUP BY rev_user
						 ORDER BY rev_count DESC
						 LIMIT {$limit}";

		$sql = "SELECT user_id, " .
			"user_name, " .
			"user_real_name, " .
			"page_count, " .
			"rev_count, " .
			"page_count+SQRT(rev_count-page_count)*2 AS wiki_rank " .
			"FROM $userTable u JOIN (($sqlMostPages) UNION ($sqlMostRevs)) s ON (user_id=rev_user) " .
			"ORDER BY wiki_rank DESC " .
			"LIMIT $limit";

		$res = $dbr->query( $sql );

		$sortable = in_array( 'nosort', $opts ) ? '' : ' sortable';

		$output = "<table class=\"wikitable contributionscores plainlinks{$sortable}\" >\n" .
			"<tr class='header'>\n" .
			Html::element( 'th', array(), wfMsg( 'contributionscores-score' ) ) .
			Html::element( 'th', array(), wfMsg( 'contributionscores-pages' ) ) .
			Html::element( 'th', array(), wfMsg( 'contributionscores-changes' ) ) .
			Html::element( 'th', array(), wfMsg( 'contributionscores-username' ) );

		$altrow = '';

		foreach ( $res as $row ) {
			// Use real name if option used and real name present.
			if ( $wgContribScoresUseRealName && $row->user_real_name !== '' ) {
				$userLink = Linker::userLink(
					$row->user_id,
					$row->user_name,
					$row->user_real_name
				);
			} else {
				$userLink = Linker::userLink(
					$row->user_id,
					$row->user_name
				);
			}

			$output .= Html::closeElement( 'tr' );
			$output .= "<tr class='{$altrow}'>\n<td class='content'>" .
				$wgLang->formatNum( round( $row->wiki_rank, 0 ) ) . "\n</td><td class='content'>" .
				$wgLang->formatNum( $row->page_count ) . "\n</td><td class='content'>" .
				$wgLang->formatNum( $row->rev_count ) . "\n</td><td class='content'>" .
				$userLink;

			# Option to not display user tools
			if ( !in_array( 'notools', $opts ) ) {
				$output .= Linker::userToolLinks( $row->user_id, $row->user_name );
			}

			$output .= Html::closeElement( 'td' ) . "\n";

			if ( $altrow == '' && empty( $sortable ) ) {
				$altrow = 'odd ';
			} else {
				$altrow = '';
			}
		}
		$output .= Html::closeElement( 'tr' );
		$output .= Html::closeElement( 'table' );

		$dbr->freeResult( $res );

		if ( !empty( $title ) )
			$output = Html::rawElement( 'table', array( 'cellspacing' => 0, 'cellpadding' => 0,
				'class' => 'contributionscores-wrapper', 'lang' => $wgLang->getCode(), 'dir' => $wgLang->getDir() ),
			"\n" .
			"<tr>\n" .
			"<td style='padding: 0px;'>{$title}</td>\n" .
			"</tr>\n" .
			"<tr>\n" .
			"<td style='padding: 0px;'>{$output}</td>\n" .
			"</tr>\n" );

		return $output;
	}

	function execute( $par ) {
		$this->setHeaders();

		if ( $this->including() ) {
			$this->showInclude( $par );
		} else {
			$this->showPage();
		}

		return true;
	}

	/**
	 * Called when being included on a normal wiki page.
	 * Cache is disabled so it can depend on the user language.
	 * @param $par
	 */
	function showInclude( $par ) {
		global $wgOut, $wgLang;

		$days = null;
		$limit = null;
		$options = 'none';

		if ( !empty( $par ) ) {
			$params = explode( '/', $par );

			$limit = intval( $params[0] );

			if ( isset( $params[1] ) ) {
				$days = intval( $params[1] );
			}

			if ( isset( $params[2] ) ) {
				$options = $params[2];
			}
		}

		if ( empty( $limit ) || $limit < 1 || $limit > CONTRIBUTIONSCORES_MAXINCLUDELIMIT ) {
			$limit = 10;
		}
		if ( is_null( $days ) || $days < 0 ) {
			$days = 7;
		}

		if ( $days > 0 ) {
			$reportTitle = wfMsgExt( 'contributionscores-days', 'parsemag', $wgLang->formatNum( $days ) );
		} else {
			$reportTitle = wfMsg( 'contributionscores-allrevisions' );
		}
		$reportTitle .= " " . wfMsgExt( 'contributionscores-top', 'parsemag', $wgLang->formatNum( $limit ) );
		$title = Xml::element( 'h4', array( 'class' => 'contributionscores-title' ), $reportTitle ) . "\n";
		$wgOut->addHTML( $this->genContributionScoreTable( $days, $limit, $title, $options ) );
	}

	/**
	 * Show the special page
	 */
	function showPage() {
		global $wgOut, $wgLang, $wgContribScoreReports;

		if ( !is_array( $wgContribScoreReports ) ) {
			$wgContribScoreReports = array(
				array( 7, 50 ),
				array( 30, 50 ),
				array( 0, 50 )
			);
		}

		$wgOut->addWikiMsg( 'contributionscores-info' );

		foreach ( $wgContribScoreReports as $scoreReport ) {
			list( $days, $revs ) = $scoreReport;
			if ( $days > 0 ) {
				$reportTitle = wfMsgExt( 'contributionscores-days', 'parsemag', $wgLang->formatNum( $days ) );
			} else {
				$reportTitle = wfMsg( 'contributionscores-allrevisions' );
			}
			$reportTitle .= " " . wfMsgExt( 'contributionscores-top', 'parsemag', $wgLang->formatNum( $revs ) );
			$title = Xml::element( 'h2', array( 'class' => 'contributionscores-title' ), $reportTitle ) . "\n";
			$wgOut->addHTML( $title );
			$wgOut->addHTML( $this->genContributionScoreTable( $days, $revs ) );
		}
	}
}
