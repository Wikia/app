<?php
/**
 * LinkOpenID.php - allow users to link their account to an external OpenID
 *
 * @author Michael Holzt <kju@fqdn.org>
 * @copyright 2008 Michael Holzt
 * @license GNU General Public License 2.0
 */

if ( !defined('MEDIAWIKI')) {
	echo('This file is an extension for the MediaWiki software and cannot be used standalone.\n');
	die(1);
}

$wgExtensionCredits['other'][] = array(
	'name'           => 'LinkOpenID',
	'author'         => 'Michael Holzt',
	'description'    => 'allow users to link their account to an external OpenID',
	'descriptionmsg' => 'linkopenid-desc',
	'svn-date'       => '$LastChangedDate: 2008-12-04 18:13:39 +0100 (czw, 04 gru 2008) $',
	'svn-revision'   => '$LastChangedRevision: 44237 $',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:LinkOpenID',
);

$wgHooks['ArticleViewHeader'][] = 'wfLinkOpenIDViewHeader';
$wgHooks['InitPreferencesForm'][] = 'wfLinkOpenIDInitPrefs';
$wgHooks['RenderPreferencesForm'][] = 'wfLinkOpenIDRenderPrefs';
$wgHooks['SavePreferences'][] = 'wfLinkOpenIDSavePrefs';
$wgHooks['ResetPreferences'][] = 'wfLinkOpenIDResetprefs';

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['LinkOpenID'] = $dir . 'LinkOpenID.i18n.php';

function wfLinkOpenIDViewHeader($article)
{
	global $wgOut;

	/* We only care about the main page of any user */
	$nt = $article->getTitle();
	if ( $nt && $nt->getNamespace() == NS_USER &&
	strpos($nt->getText(), '/') === false ) {

		$user = User::newFromName($nt->getText());
		if ( $user && $user->getID() != 0) {

			$openid = $user->getOption('wflinkopenid_openid');

			if ( $openid != '' ) {
				$v1url = $user->getOption('wflinkopenid_v1url');
				$v2url = $user->getOption('wflinkopenid_v2url');
				$xrdsurl = $user->getOption('wflinkopenid_xrdsurl');

				if ( $v1url != '' ) {
					$wgOut->addLink( array('rel' => 'openid.server', 'href' => $v1url) );
					$wgOut->addLink( array('rel' => 'openid.delegate', 'href' => $openid) );
				}

				if ( $v2url != '' ) {
					$wgOut->addLink( array('rel' => 'openid2.provider', 'href' => $v2url) );
					$wgOut->addLink( array('rel' => 'openid2.local_id', 'href' => $openid) );
				}

				if ( $xrdsurl != '' )
					$wgOut->addMeta('X-XRDS-Location', $xrdsurl);
			}
		}
	}

	return TRUE;
}

function wfLinkOpenIDInitPrefs($prefs, $request) {
	$prefs->wfLinkOpenID = Array();
	$prefs->wfLinkOpenID['openid'] = $request->getVal('wflinkopenid_openid');
	$prefs->wfLinkOpenID['v1url'] = $request->getVal('wflinkopenid_v1url');
	$prefs->wfLinkOpenID['v2url'] = $request->getVal('wflinkopenid_v2url');
	$prefs->wfLinkOpenID['xrdsurl'] = $request->getVal('wflinkopenid_xrdsurl');
	return TRUE;
}

function wfLinkOpenIDRenderPrefs($prefs, $out) {
	wfLoadExtensionMessages( 'LinkOpenID' );

	$out->addHTML( "<fieldset><legend>" .
		wfMsgHtml( 'linkopenid-prefs' ) .
		"</legend>");

	$out->addWikiMsg( 'linkopenid-prefstext-pre' );

	$out->addHTML(
		"<table>" .

			"<tr><td>" . wfMsgHtml( 'linkopenid-prefstext-openid' ) . "</td><td>" .
			"<input type='text' name='wflinkopenid_openid' size='60' value='" .
			htmlentities($prefs->wfLinkOpenID['openid']) . "'></td></tr>" .

			"<tr><td>" . wfMsgHtml( 'linkopenid-prefstext-v1url' ) . "</td><td>" .
			"<input type='text' name='wflinkopenid_v1url' size='60' value='" .
			htmlentities($prefs->wfLinkOpenID['v1url']) . "'></td></tr>" .

			"<tr><td>" . wfMsgHtml( 'linkopenid-prefstext-v2url' ) . "</td><td>" .
			"<input type='text' name='wflinkopenid_v2url' size='60' value='" .
			htmlentities($prefs->wfLinkOpenID['v2url']) . "'></td></tr>" .

			"<tr><td>" . wfMsgHtml( 'linkopenid-prefstext-xrdsurl' ) . "</td><td>" .
			"<input type='text' name='wflinkopenid_xrdsurl' size='60' value='" .
			htmlentities($prefs->wfLinkOpenID['xrdsurl']) . "'></td></tr>" .

		"</table></fieldset>"
	);

	return TRUE;
}

function wfLinkOpenIDSavePrefs($form, $user, &$message) {
	$user->setOption('wflinkopenid_openid', $form->wfLinkOpenID['openid'] );
	$user->setOption('wflinkopenid_v1url', $form->wfLinkOpenID['v1url'] );
	$user->setOption('wflinkopenid_v2url', $form->wfLinkOpenID['v2url'] );
	$user->setOption('wflinkopenid_xrdsurl', $form->wfLinkOpenID['xrdsurl'] );
	return TRUE;
}

function wfLinkOpenIDResetPrefs($prefs, $user) {
	$prefs->wfLinkOpenID = Array();
	$prefs->wfLinkOpenID['openid'] = $user->getOption('wflinkopenid_openid');
	$prefs->wfLinkOpenID['v1url'] = $user->getOption('wflinkopenid_v1url');
	$prefs->wfLinkOpenID['v2url'] = $user->getOption('wflinkopenid_v2url');
	$prefs->wfLinkOpenID['xrdsurl'] = $user->getOption('wflinkopenid_xrdsurl');
	return TRUE;
}
