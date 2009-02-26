<?php
/**
 *
 * Special page to list all Abandoned or Trash builds that were not touched since two weeks
 * Based on SpecialAncientpages.php
 * 
 * Started 4 Aug 2007 by Hhhippo
 *
 */


class GraceExpiredSpecialPage extends SpecialPage {
    private $mpa = null;

        function __construct() {
                wfLoadExtensionMessages('Graceexpired');
                parent::__construct( 'Graceexpired' );
        }

        function execute($article_id = null, $limit = "", $offset = "", $show = true) {
                if (empty($limit) && empty($offset)) {
            list( $limit, $offset ) = wfCheckLimits();
        }
        $this->ge = new GraceExpiredPage($article_id, $show);

                if (!empty($show)) {
            $this->setHeaders();
        } else {
            // return data as array - not like <LI> list
            $this->ge->setListoutput(TRUE);
        }
        $this->ge->doQuery( $offset, $limit, $show );
    }

    function getResult() { return $this->ge->getResult(); }
}

class GraceExpiredPage extends QueryPage {
	var $mName = "Graceexpired";

	function getName() {
		return "GraceExpired";
	}

	function isExpensive() {
		return true;
	}

	function isSyndicated() { return false; }

	function getSQL() {
		global $wgDBtype;
		$db =& wfGetDB( DB_SLAVE );
		$page = $db->tableName( 'page' );
		$cl = $db->tableName( 'categorylinks' );
		$revision = $db->tableName( 'revision' );
		#$use_index = $db->useIndexClause( 'cur_timestamp' ); # FIXME! this is gone
		$epoch = $wgDBtype == 'mysql' ? 'UNIX_TIMESTAMP(rev_timestamp)' :
			'EXTRACT(epoch FROM rev_timestamp)';
		$gdate=date('YmdHis', strtotime('-2 week'));

		# get all Abandoned/Trash builds with the last revision older than 2 weeks
		return
			"SELECT 'GraceExpired' as type,
				page_namespace as namespace,
			        page_title as title,
			        $epoch as value,
                                cl_to as cat
			FROM $page, $revision, $cl
			WHERE page_namespace=100 AND page_is_redirect=0
			  AND page_latest=rev_id
			  AND cl_from=page_id AND ((cl_to LIKE 'Abandoned' OR cl_to LIKE 'Trash_builds')
					        OR (cl_to LIKE 'Build_stubs' OR cl_to LIKE 'Trial_Builds'))
                          AND rev_timestamp<$gdate";

	}

	function sortDescending() {
		return false;
	}

	function formatResult( $skin, $result ) {
		global $wgLang, $wgContLang;
		$cat='';
		if ($result->cat=="Abandoned") {
		    $cat='abandoned';
		}
		if ($result->cat=="Build_stubs") {
		    $cat='stub';
		}
		if ($result->cat=="Trial_Builds") {
		    $cat='trial';
		}
		if ($result->cat=="Trash_builds") {
		        $cat='trash';
		}
		$d = "<i>$cat</i>, ".$wgLang->timeanddate( wfTimestamp( TS_MW, $result->value ), true );
		$title = Title::makeTitle( $result->namespace, $result->title );
		$link = $skin->makeKnownLinkObj( $title, htmlspecialchars( $wgContLang->convert( $title->getPrefixedText() ) ) );
		return wfSpecialList($link, $d);
	}

	function getPageHeader() {
	    return "This page lists all builds that are either
                    <a href=\"http://www.pvxwiki.com/wiki/Category:Abandoned\">abandoned</a>,
                    <a href=\"http://www.pvxwiki.com/wiki/Category:Trash_builds\">trash</a>,
                    <a href=\"http://www.pvxwiki.com/wiki/Category:Build_stubs\">stubs</a> or
                    <a href=\"http://www.pvxwiki.com/wiki/Category:Trial_Builds\">trial</a>,
                    and have not been edited for at least two weeks.
                    <br>
                    Activity on rating pages is <i>not</i> taken into account here.
                    <hr>";
	}


}



function wfSpecialGraceExpired() {
	list( $limit, $offset ) = wfCheckLimits();

	$app = new GraceExpiredPage();

	$app->doQuery( $offset, $limit );
}

?>
