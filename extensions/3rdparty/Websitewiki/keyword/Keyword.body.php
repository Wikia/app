<?php

class Keyword extends SpecialPage {

	static $specialKeywordUrl;

	function  __construct() {
		parent::__construct( 'Keyword' , '' /*restriction*/);
		wfLoadExtensionMessages('Keyword');
		self::$specialKeywordUrl = Skin::makeSpecialUrl('Keyword');
	}

	function kwlink($kw) {
		$kwu = $kw;
		$kwu{0} = strtoupper($kwu{0});
		return '<a href="' . self::$specialKeywordUrl . '/' . htmlspecialchars($kw) . "\">$kwu</a>";
	}

	function execute($par) {
		global $wgRequest, $wgOut;

		$action = Skin::makeSpecialUrl('Keyword');

		wfLoadExtensionMessages('Keyword');
		$label = wfMsgExt('keyword-label', array('parseinline'));
		$submit = wfMsg('keyword-submit');
		$specialKeywordCommonUrl = Skin::makeSpecialUrl('Keyword', 'target=common');
		$list = wfMsg('keyword-keywords-list', $specialKeywordCommonUrl);

		$post = '<p />
			<form action="' . self::$specialKeywordUrl . "\" method=\"get\">
			$label
			<input type=\"text\" name=\"kw\" size=\"40\" maxlength=\"80\" />
			<input type=\"submit\" value=\"$submit\" />
			</form><p />
			$list<p />";

		$output = '';
		$this->setHeaders();
		$wgOut->setRobotPolicy('index,follow');

		// Google
		//TODO: "summary" is hardcoded in German, should this whole block be moved to message?
		$google = '<table border="1" cellspacing="0" cellpadding="4" style="float:right; margin:0 0 .5em 1em;
		 width:260px; background:#fff; border-collapse:collapse; border:1px solid #999;
		 font-size:smaller; line-height:1.5; " summary="Anzeigen"><tr><td align="center" height="250" style="background:#ffffff;">';
		$google .= AdEngine::getInstance()->getAd( 'WEBSITEWIKI_KEYWORDS' );
		$google .= '</td></tr></table>';

		# Get request data from, e.g.
		$kwp = $wgRequest->getText('kw');
		$tar = $wgRequest->getText('target');
		$doall = $wgRequest->getText('all');
		$kwt = substr(strstr($wgRequest->getVal('title'), '/'), 1);
		$kw = $kwp ? $kwp : $kwt;

		# Do stuff

		$dbr = wfGetDB(DB_SLAVE, 'vslow');

		if ($tar == 'common') {
			$wgOut->setPagetitle(wfMsg('keyword-common-page-title'));
			$label = wfMsg('keyword-common-label');
			$wgOut->addHTML("$label<ol>\n");

			$res = $dbr->doQuery('SELECT kw_word, kw_count FROM kw_keywords ORDER BY kw_count DESC LIMIT 100');
			while ($res && $row = mysql_fetch_row($res)) {
				$kword = $row[0];
				$kcount = $row[1];
				$output .= '<li>' . kwlink($kword) . " ($kcount)</li>\n";
			}
			$output .= "</ol>\n";
			$wgOut->addHTML($google . $output);

			return;
		}

		if (!isset($kw) || strlen($kw) < 2) {
			$wgOut->addHTML($post);
			return;
		}

		$keyword = strtolower(trim(str_replace('_', ' ', $kw)));
		$gnkeyword = $keyword;
		$keyword{0} = strtoupper($keyword{0});

		$wgOut->setPagetitle(wfMsg('keyword-page-title', $keyword));

		$kw = $dbr->strencode(strtolower(trim(str_replace('_', ' ', $kw))));

		$res = $dbr->doQuery('SELECT COUNT(*) FROM kw_keywords');
		if ($res && $row = mysql_fetch_row($res)) {
			$diffkeys = $row[0];
		} else {
			$wgOut->addWikiMsg('keyword-bad-length');
			return;
		}

		$res = $dbr->doQuery('SELECT kw_count FROM kw_keywords ORDER BY kw_count DESC LIMIT 1');
		if ($res && $row = mysql_fetch_row($res)) {
			$maxkeycount = $row[0];
		} else {
			$wgOut->addWikiMsg('keyword-bad-length');
			return;
		}

		$res = $dbr->doQuery("SELECT kw_count, kw_id FROM kw_keywords WHERE kw_word='$kw'");
		if ($res && $row = mysql_fetch_row($res)) {
			$thiskeycount = $row[0];
			$thiskeyid = $row[1];
		} else {
			$wgOut->addWikiMsg('keyword-not-used', $keyword);
			return;
		}

		$thisrelcomm = round(($thiskeycount / $maxkeycount * 100), 2);

		$output .= '<ul>';
		$output .= wfMsg('keyword-description', $keyword, $gnkeyword, $specialKeywordCommonUrl);

		$res = $dbr->doQuery("SELECT kw_page,kw_ptype FROM kw_page WHERE kw_key = $thiskeyid LIMIT 50;");  // 50 was 100
		$similpages = array();
		$porncount = 0;
		while ($res && $row = mysql_fetch_row($res)) {
			$similpages[] = $row[0];
			$porncount += $row[1];
		}
		// $output .= "<li>npc = $porncount</li>\n";

		$similstring = '(';
		foreach( $similpages as $spage)
			$similstring .= $spage . ",";

		$similstring .= '0)';

		$res = $dbr->doQuery("SELECT kw_word FROM kw_keywords,kw_page WHERE kw_page IN $similstring AND kw_key=kw_id GROUP BY kw_key ORDER BY COUNT(kw_key) DESC LIMIT 15 OFFSET 1");
		while ($res && $row = mysql_fetch_row($res)) {
			$sameword = $row[0];
			$output .= '<li>' . kwlink($sameword) . "</li>\n";
		}
		$output .= "</ul></li>\n";

		if (!$doall && $thiskeycount > 25) {
			srand($thiskeyid);
			$off = rand(0, $thiskeycount - 25);
			$ua = wfMsg('keyword-incl');
			$alleanz = ' [<a href="?all=1"' . wfMsg('keyword-show-all') . '</a>]';
			$limi = "LIMIT 25 OFFSET $off";
		} else {
			$ua = '';
			$off = 0;
			$alleanz = '';
			$limi = '';
		}

		// randomized, slow $res = $dbr->doQuery("select page_title from kw_page,page where kw_key=$thiskeyid and page_id=kw_page order by rand($thiskeyid) limit 25");

		$res = $dbr->doQuery("SELECT page_title FROM kw_page, page WHERE kw_key=$thiskeyid AND page_id=kw_page $limi");
		$usedOn = wfMsg('keyword-used-on', $keyword, $alleanz);
		$output .= "<li>$usedOn</li>\n</ul>\n<ul>\n";
		while ($res && $row = mysql_fetch_row($res)) {
			$pgtitle = $row[0];
			$output .= '<li><a href="/' . htmlspecialchars($pgtitle) . "\">$pgtitle</a></li>\n";
		}
		$output .= "</ul></li>\n";
		$output .= "</ul>\n";

//		$output .= "KW: $kw num $diffkeys this $thiskeycount id $thiskeyid max $maxkeycount\n";

		if ($porncount == 0) {
			$wgOut->addHTML( $google.$output );
		} else {
			$wgOut->addHTML( $output );
		}
	}
}