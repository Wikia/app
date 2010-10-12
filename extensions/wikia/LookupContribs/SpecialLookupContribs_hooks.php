<?PHP

/* 
	this practically does one thing: unsets memcached keys on article save
*/

/* grapple them hooks */
global $wgHooks;

/* Run after user really saved an article, and only if we _use_ memcache */
if (!LOOKUPCONTRIBS_NO_CACHE) {
	$wgHooks['ArticleSaveComplete'][] = 'LookupContribsHooks::ArticleSaveComplete';
}
$wgHooks['ContributionsToolLinks'][] = 'LookupContribsHooks::ContributionsToolLinks';

class LookupContribsHooks {
	static public function ArticleSaveComplete ($article, $user) {
		global $wgDBname, $wgMemc, $wgSharedDB, $wgUser ;
		/* unset the key for this user on this database */
		$username = $user->getName () ;
		$wgMemc->delete ("$wgSharedDB:LookupContribs:normal:$username:$wgDBname") ;
		$wgMemc->delete ("$wgSharedDB:LookupContribs:final:$username:$wgDBname") ;
		return true ;
	}

	static public function ContributionsToolLinks( $id, $nt, &$links ) {
		global $wgUser;
		if( $id != 0 && $wgUser->isAllowed( 'lookupcontribs' ) ) {
			wfLoadExtensionMessages( 'SpecialLookupContribs' );
			$attribs = array(
				'href' => 'http://community.wikia.com/wiki/Special:LookupContribs?target=' . urlencode( $nt->getText() ),
				'title' => wfMsg('right-lookupcontribs')
			);
			$links[] = Xml::openElement( 'a', $attribs ) . wfMsg( 'lookupcontribs' ) . Xml::closeElement( 'a' );
		}
		return true;
	}
}
