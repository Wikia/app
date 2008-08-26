<?php

if (!defined('MEDIAWIKI')) {
	echo "InspectCache extension";
	exit(1);
}

class InspectCache extends SpecialPage
{
	function InspectCache() {
		wfLoadExtensionMessages( 'InspectCache' );
		SpecialPage::SpecialPage("InspectCache");
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgTitle, $inspectcacheget, $inspectcachedelete;
		$inspectcacheget = wfMsgHtml('inspectcache-get');
		$inspectcachedelete = wfMsgHtml('inspectcache-delete');
		$inspectcachelist = wfMsgHtml('inspectcache-list');
		$this->setHeaders();

		$key = $wgRequest->getVal( 'key' );
		$delete = $wgRequest->getBool( 'delete' ) && $wgRequest->wasPosted();
		$list = $wgRequest->getBool( 'list' );
		$group = $wgRequest->getVal( 'group' );

		$encQ = htmlspecialchars( $key );
		$action = $wgTitle->escapeLocalUrl();
		$ok = htmlspecialchars( wfMsg( 'inspectcache-ok' ) );

		$groups = array(
			'main' => array( wfMsg('inspectcache-general'), 'wfGetMainCache' ),
			'parser' => array( wfMsg('inspectcache-parser'), 'wfGetParserCacheStorage' ),
			'message' => array( wfMsg('inspectcache-message'), 'wfGetMessageCacheStorage' ),
		);
		if( !isset( $groups[$group] ) ) {
			$group = 'main';
		}
		$cache = $groups[$group][1]();

		$radios = '';
		foreach( $groups as $type => $bits ) {
			list( $desc ) = $bits;
			$radios .=
				Xml::radioLabel( $desc, 'group', $type, "mw-cache-$type",
					$group == $type ) . " ";
		}

		$wgOut->addHTML( <<<END
<form name="ucf" method="post" action="$action">
<input type="text" size="80" name="key" value="$encQ"/><br />
<div>$radios</div>
<input type="submit" name="submit" value={$inspectcacheget} />
<input type="submit" name="delete" value={$inspectcachedelete} />
<input type="submit" name="list"   value={$inspectcachelist} />
<br /><br />
</form>
END
);

		if ( $delete && !is_null( $key ) ) {
			$cache->delete( $key );
			$wgOut->addHTML( wfMsg('inspectcache-deleted')."\n" );
		} else if ( $list ) {
			$list = $cache->keys();
			$str = "<ul>\n";
			foreach( $list as $li ) {
				$keyEncoded = urlencode( $li );
				$url = $wgTitle->getFullUrl( "key={$keyEncoded}&group={$group}" );
				$urlEncoded = htmlspecialchars( $url );
				$liEncoded = htmlspecialchars( $li );
				$str .= "<li><a href=\"{$urlEncoded}\">{$liEncoded}</a></li>\n";
			}
			$str .= "</ul>\n";
			$wgOut->addHTML( $str );
		} else if ( !is_null( $key ) ) {
			$value = $cache->get( $key );
			if ( !is_string( $value ) ) {
				$value = var_export( $value, true );
			}
			$wgOut->addHTML( "<pre>" . htmlspecialchars( $value ) . "</pre>" );
		}
	}
}
