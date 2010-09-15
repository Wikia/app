<?php

class Checksite extends SpecialPage {

	function  __construct() {
		parent::__construct( 'Checksite' , '' /*restriction*/);
		wfLoadExtensionMessages('Checksite');
	}

	function execute($par) {
		global $wgRequest, $wgOut, $wgTitle;

		$param = $wgRequest->getText('param');
		$parcheck = $wgRequest->getText('parcheck');
		$action = $wgTitle->getFullURL();

		wfLoadExtensionMessages('Checksite');
		$description = wfMsgExt('checksite-description', array('parse'));
		$label = wfMsgExt('checksite-label', array('parseinline'));
		$submit = wfMsg('checksite-submit');

		$post = "
			<form action=\"$action\" method=\"get\">
			$description
			$label
			<input type=\"text\" name=\"parcheck\" value=\"$param\" size=\"40\" maxlength=\"80\" />
			<input type=\"submit\" value=\"$submit\" />
			</form>";

		$this->setHeaders();

		if (!isset($parcheck) || strlen($parcheck) < 5) {
			$wgOut->addHTML($post);
			return;
		}

		$newdom = check_validate_domain($parcheck);
		if (!$newdom) {
			$parcheck = htmlspecialchars($parcheck);
			$wgOut->addWikiMsg('checksite-cant-check', $parcheck);
			return;
		}

		$newpage = $newdom;
		$newpage{0} = strtoupper($newpage{0});

		$title = Title::newFromUrl($newpage);
		if (!is_object($title)) {
			$wgOut->addWikiMsg('checksite-not-found', $newpage);
			return;
		}

		if (!$title->exists()) {
			$wgOut->addWikiMsg('checksite-not-exist', $newpage);
			return;
		}

		$newhost = check_get_host($newdom);
		if (!$newhost) {
			$wgOut->addWikiMsg('checksite-url-not-found', $newdom);
			return;
		}

		if ($rob = @fopen("http://$newhost/robots.txt", 'r')) {
			$txt = fread($rob, 4096);

			while (!feof($rob)) {
				$txt .= fread($rob, 4096);
				if (strlen($txt) > 20000) {
					break;
				}
			}

			fclose($rob);

			if (eregi("User-agent:[ \t\n]*WebsiteWiki[ \t\r\n]*Disallow:[ \t\r\n]*/", $txt)) {
				global $wgUser;

				$output = wfMsg('checksite-robots', $newhost, $newpage);

				$orgUser = $wgUser;
				//TODO: should this hardcoded user be here?
				$wgUser = User::newFromName('Sysop');

				$article = new Article($title);
				$restrict = Array('edit' => 'sysop', 'move' => 'sysop');
				$article->updateRestrictions($restrict, $output);
				$redirectUrl = wfMsg('checksite-redirect-url');
				$redirectComment = wfMsg('checksite-redirect-comment');
				$article->updateArticle("#REDIRECT [[$redirectUrl]]", $redirectComment, false, false);

				$wgUser = $orgUser;
				return;
			}
		}

		//TODO: check if this hardcoded URL should remain here
		if (stristr($newhost, 'duckshop.de')) {
			$wgOut->addWikiMsg('checksite-screenshot-error');
			return;
		}

		$output = wfMsg('checksite-screenshot-updating', $newpage);

		/**
		 * @todo -- lines below do nothing, so why they are there?
		 * 
		 * $url = fopen("http://thumbs.websitewiki.de/newthumb.php?name=$newdom", 'r');
		 * fclose($url);
		 */

		# Output
		$wgOut->addHTML( $output);
	}
}

function check_validate_domain($dom) {
	global $exDomainList;

	$d = strtolower(ltrim(trim($dom)));

	$d = preg_replace('#^http://#i', '', $d);
	$d = preg_replace('#^www\.#i', '', $d);

	if ($p = strpos($d, ' '))
		$d = substr($d, 0, $p);
	if ($p = strpos($d, '/'))
		$d = substr($d, 0, $p);

	if (preg_match('#[^-.\w]#', $d))
		return '';
	if (preg_match('#^[-.]#', $d))
		return '';
	if (preg_match('#\.\.#', $d))
		return '';

	//TODO: change it to preg_match - but it has to be changed in any files that is using exDomainList AND this variable has to be changed to match preg requirements
	if (!ereg($exDomainList, $d))
		return '';

	return $d;
}

function check_get_host($dom) {
	$dnsrec = dns_get_record("www.$dom", DNS_A);
	if (isset($dnsrec[0]) && array_key_exists('ip', $dnsrec[0])) {
		return "www.$dom";
	}

	$dnsrec = dns_get_record($dom, DNS_A);
	if (isset($dnsrec[0]) && array_key_exists('ip', $dnsrec[0])) {
		return $dom;
	}

	return '';
}
