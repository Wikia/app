<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Inez Korczyński (inez@wikia.com)
 *
 * Add 'wfRunHooks('ConfirmEmailComplete', array(&$user));' in SpecialConfirmemail.php at 86 line.
 */

if ( ! defined( 'MEDIAWIKI' ) )
	die();

/*
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 */
class PrivateDomains extends SpecialPage {

	function PrivateDomains() {
		wfLoadExtensionMessages( "PrivateDomains" );
		SpecialPage::SpecialPage( "PrivateDomains" );
	}

	function saveParam($name, $value) {
		$nameTitle = Title::newFromText($name, NS_MEDIAWIKI);
		$article = new Article($nameTitle);

		if ( $nameTitle->exists() ) {
			$article->quickEdit($value);
		} else {
			$article->insertNewArticle($value, '', false, false, false, false);
		}
	}

	static function getParam($name) {
		$nameTitle = Title::newFromText($name, NS_MEDIAWIKI);
		if ( $nameTitle->exists() ) {
			$article = new Article($nameTitle);
			return $article->getContent();
		} else {
			return "";
		}
	}

	function execute() {
		global $wgRequest,$wgUser,$wgOut;

		$wgOut->setPageTitle( wfMsg('privatedomains') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		$msg = '';

	    if( $wgRequest->wasPosted() ) {
			if ( 'submit' == $wgRequest->getText('action') ) {

				global $wgMessageCache;

				$this->saveParam('privatedomains_domains', $wgRequest->getText('listdata'));
				$this->saveParam('privatedomains_affiliatename', $wgRequest->getText('affiliateName'));
				$this->saveParam('privatedomains_emailadmin', $wgRequest->getText('optionalPrivateDomainsEmail'));

				$msg = wfMsgHtml('saveprivatedomains_success');
			}
		}
		$this->mainForm( $msg );
	}

	/**
	 * @access private
	 */
	function mainForm( $msg ) {
		global $wgUser, $wgOut, $wgLang, $wgDBname, $wgMessageCache;

		$titleObj = Title::makeTitle( NS_SPECIAL, 'PrivateDomains' );
		$action = $titleObj->escapeLocalUrl('action=submit');

		$userGroups = $wgUser->getGroups();
		if ( !in_array('staff', $userGroups ) && !in_array('bureaucrat', $userGroups) ) {

			$wgOut->addHTML(wfMsg('privatedomains_ifemailcontact'));

			$privatedomains_emailadmin = PrivateDomains::getParam("privatedomains_emailadmin");

			if ($privatedomains_emailadmin != '') {
				$wgOut->addWikiText(wfMsg('privatedomains_ifemailcontact', $privatedomains_emailadmin));
			}

			return false;
        }

		if ( $msg != '' ) {
			$wgOut->addHTML('<div class="errorbox" style="width:92%;"><h2>' . $msg . '</h2></div><br><br><br>');
		}

		$wgOut->addHTML("<form name=\"privatedomains\" id=\"privatedomains\" method=\"post\" action=\"{$action}\"><label for=\"affiliateName\">" . wfMsg('privatedomains_affiliatenamelabel') . "</label><input type='text' name=\"affiliateName\"  width=30 value=\"" . $this->getParam('privatedomains_affiliatename') ."\"><label for=\"optionalEmail\">" . wfMsg('privatedomains_emailadminlabel') . "</label><input type='text' name=\"optionalPrivateDomainsEmail\" value=\"" . $this->getParam('privatedomains_emailadmin') . "\">");
		$wgOut->addHTML(wfMsg('privatedomainsinstructions'));
		$wgOut->addHTML("<textarea name='listdata' rows=10 cols=40>" . $this->getParam('privatedomains_domains') . "</textarea>");
		$wgOut->addHTML("<br><input type='submit' name=\"saveList\" value=\"" . wfMsgHtml('saveprefs') . "\" />");
		$wgOut->addHTML("</form>");
	}
}
