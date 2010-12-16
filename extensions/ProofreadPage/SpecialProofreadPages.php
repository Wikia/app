<?php
/**
 * @file
 * @ingroup SpecialPage
 */


if ( !defined( 'MEDIAWIKI' ) ) die( 1 );
global $wgHooks, $IP;
require_once "$IP/includes/QueryPage.php";


class ProofreadPages extends SpecialPage {

	function ProofreadPages() {
		SpecialPage::SpecialPage( 'IndexPages' );
	}

	function execute( $parameters ) {
		global $wgOut, $wgRequest, $wgDisableTextSearch;

		$this->setHeaders();
		list( $limit, $offset ) = wfCheckLimits();
		$wgOut->addWikiText( wfMsgForContentNoTrans( 'proofreadpage_specialpage_text' ) );
		$searchList = array();
		$searchTerm = $wgRequest->getText( 'key' );
		if( ! $wgDisableTextSearch ) {
			$wgOut->addHTML(
				Xml::openElement( 'form' ) .
				Xml::openElement( 'fieldset' ) .
				Xml::element( 'legend', null, wfMsg( 'proofreadpage_specialpage_legend' ) ) .
				Xml::input( 'key', 20, $searchTerm ) . ' ' .
				Xml::submitButton( wfMsg( 'ilsubmit' ) ) .
				Xml::closeElement( 'fieldset' ) .
				Xml::closeElement( 'form' )
			);
			if( $searchTerm ) {
				$index_namespace = pr_index_ns() ;
				$index_ns_index = MWNamespace::getCanonicalIndex( strtolower( $index_namespace ) );
				$searchEngine = SearchEngine::create();
				$searchEngine->setLimitOffset( $limit, $offset );
				$searchEngine->setNamespaces( array( $index_ns_index ) );
				$searchEngine->showRedirects = false;
				$textMatches = $searchEngine->searchText( $searchTerm );
				while( $result = $textMatches->next() ) {
					if ( preg_match( "/^$index_namespace:(.*)$/", $result->getTitle(), $m ) ) {
						array_push( $searchList, str_replace( ' ' , '_' , $m[1] ) );
					}
				}
			}
		}
		$cnl = new ProofreadPagesQuery( $searchList, $searchTerm );
		$cnl->doQuery( $offset, $limit );
	}
}

class ProofreadPagesQuery extends QueryPage {
	function ProofreadPagesQuery( $searchList, $searchTerm ) {
		$this->searchList = $searchList;
		$this->searchTerm = $searchTerm;
	}

	function getName() {
		return 'IndexPages';
	}

	function isExpensive() {
		return false;
	}

	function isSyndicated() {
		return false;
	}

	function linkParameters() {
		return array( 'key'=> $this->searchTerm );
	}

	function getSQL() {
		$dbr = wfGetDB( DB_SLAVE );
		$page = $dbr->tableName( 'page' );
		$pr_index = $dbr->tableName( 'pr_index' );

		$query = "SELECT page_title as title,
		pr_count,pr_q0,pr_q1,pr_q2,pr_q3,pr_q4
		FROM $pr_index LEFT JOIN $page ON page_id = pr_page_id";

		if( $this->searchTerm ) {
			if( $this->searchList ) {
				$index_namespace = pr_index_ns() ;
				$index_ns_index = MWNamespace::getCanonicalIndex( strtolower( $index_namespace ) );
				$querylist = '';
				foreach( $this->searchList as $item ) {
					if( $querylist ) $querylist .= ', ';
					$querylist .= "'" . $dbr->strencode( $item ). "'";
				}
				$query .= " WHERE page_namespace=$index_ns_index AND page_title IN ($querylist)";
			} else {
				# The SQL query is complete
			}
		}
		return $query;
	}

	function getOrder() {
		return ' ORDER BY 2*pr_q4+pr_q3 ' .
			($this->sortDescending() ? 'DESC' : '');
	}

	function sortDescending() {
		return true;
	}

	function formatResult( $skin, $result ) {
		global $wgLang;

		$index_namespace = pr_index_ns();
		$title = Title::newFromText( $index_namespace.":".$result->title );

		if ( !$title ) {
			return '<!-- Invalid title ' .  htmlspecialchars( $index_namespace.":".$result->title ). '-->';
		}
		$plink = $this->isCached()
		  ? $skin->link( $title , htmlspecialchars( $title->getText() ) )
			: $skin->linkKnown( $title , htmlspecialchars( $title->getText() ) );

		if ( !$title->exists() ) {
			return "<s>{$plink}</s>";
		}

		$size = $result->pr_count;
		$q0 = $result->pr_q0;
		$q1 = $result->pr_q1;
		$q2 = $result->pr_q2;
		$q3 = $result->pr_q3;
		$q4 = $result->pr_q4;
		$num_void = $size-$q1-$q2-$q3-$q4-$q0;
		$void_cell = $num_void ? "<td align=center style='border-style:dotted;background:#ffffff;border-width:1px;' width=\"{$num_void}\"></td>" : "";

		// FIXME: consider using $size in 'proofreadpage_pages' instead of glueing it together in $output
		$pages = wfMsgExt( 'proofreadpage_pages', 'parsemag', $size );
		$size = $wgLang->formatNum( $size );

		$output = "<table style=\"line-height:70%;\" border=0 cellpadding=5 cellspacing=0 >
<tr valign=\"bottom\">
<td style=\"white-space:nowrap;overflow:hidden;\">{$plink} [$size $pages]</td>
<td>
<table style=\"line-height:70%;\" border=0 cellpadding=0 cellspacing=0 >
<tr>
<td width=\"2\">&nbsp;</td>
<td align=center class='quality4' width=\"$q4\"></td>
<td align=center class='quality3' width=\"$q3\"></td>
<td align=center class='quality2' width=\"$q2\"></td>
<td align=center class='quality1' width=\"$q1\"></td>
<td align=center class='quality0' width=\"$q0\"></td>
$void_cell
</tr></table>
</td>
</tr></table>";

		return $output;
	}
}
