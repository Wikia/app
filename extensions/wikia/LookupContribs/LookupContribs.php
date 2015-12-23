<?php

$wgExtensionCredits['specialpage'][] = [
	"name" => "LookupContribs",
	"descriptionmsg" => "lookupcontribs-desc",
	"author" => array( "Bartek Lapinski", "Piotr Molski" ),
	"url" => "https://github.com/Wikia/app/tree/dev/extensions/wikia/LookupContribs",
];

$dir = dirname( __FILE__ ) . '/';

/**
 * classes
 */
$wgAutoloadClasses['LookupContribsCore'] =  $dir . 'SpecialLookupContribs_helper.php';
$wgAutoloadClasses['LookupContribsAjax'] =  $dir . 'SpecialLookupContribs_ajax.php';
$wgAutoloadClasses['LookupContribsPage'] =  $dir . 'SpecialLookupContribs_body.php';

/**
 * special pages
 */
$wgSpecialPages['LookupContribs'] = 'LookupContribsPage';
$wgSpecialPageGroups['LookupContribs'] = 'users';

/**
 * i18n
 */
$wgExtensionMessagesFiles["SpecialLookupContribs"] = $dir . 'SpecialLookupContribs.i18n.php';

/**
 * hooks
 */
$wgHooks['ArticleSaveComplete'][] = 'LookupContribsHooks::ArticleSaveComplete';
$wgHooks['ContributionsToolLinks'][] = 'LookupContribsHooks::ContributionsToolLinks';

/**
 * rights
 */
$wgAvailableRights[] = 'lookupcontribs';
$wgGroupPermissions['staff']['lookupcontribs'] = true;

$wgAjaxExportList[] = "LookupContribsAjax::axData";

class LookupContribsHooks {
	static public function ArticleSaveComplete ( $article, User $user ) {
		global $wgDBname, $wgMemc, $wgSharedDB;
		/* unset the key for this user on this database */
		$username = $user->getName() ;
		$wgMemc->delete( "$wgSharedDB:LookupContribs:normal:$username:$wgDBname" ) ;
		$wgMemc->delete( "$wgSharedDB:LookupContribs:final:$username:$wgDBname" ) ;
		return true ;
	}

	/**
	 * @param $id
	 * @param Title $nt
	 * @param $links
	 * @return bool
	 */
	static public function ContributionsToolLinks( $id, $nt, &$links ) {
		global $wgUser;
		if ( $id != 0 && $wgUser->isAllowed( 'lookupcontribs' ) ) {
			$attribs = array(
				'href' => 'http://community.wikia.com/wiki/Special:LookupContribs?target=' . urlencode( $nt->getText() ),
				'title' => wfMsg( 'right-lookupcontribs' )
			);
			$links[] = Xml::openElement( 'a', $attribs ) . wfMsg( 'lookupcontribs' ) . Xml::closeElement( 'a' );
		}
		return true;
	}
}
