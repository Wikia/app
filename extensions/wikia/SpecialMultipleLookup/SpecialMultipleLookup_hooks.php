<?PHP

/* 
	this practically does one thing: unsets memcached keys on article save
*/

/* grapple them hooks */
global $wgHooks;

/* Run after user really saved an article, and only if we _use_ memcache */
$wgHooks['ContributionsToolLinks'][] = 'MultiLookupHooks::ContributionsToolLinks';

class MultiLookupHooks {
	static public function ContributionsToolLinks( $id, $nt, &$links ) {
		global $wgUser;
		if ( $id == 0 && $wgUser->isAllowed( 'multilookup' ) ) {
			wfLoadExtensionMessages( 'MultiLookup' );
			$attribs = array(
				'href' => 'http://community.wikia.com/wiki/Special:MultiLookup?target=' . urlencode( $nt->getText() ),
				'title' => wfMsg( 'multilookupselectuser' )
			);
			$links[] = Xml::openElement( 'a', $attribs ) . wfMsg( 'multilookup' ) . Xml::closeElement( 'a' );
		}
		return true;
	}
}
