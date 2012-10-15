<?php

class GroupsSidebar {
	/**
	 * Gets called by Hook SkinBuildSidebar
	 */
	function efHideSidebar( $skin, &$bar ) {
		global $wgUser;
		foreach ( $wgUser->getEffectiveGroups() as $group ) {
			$message = 'sidebar-'.$group;
			# addToSidebar currently won't throw errors if we call it
			# with nonexisting pages, but better check and be sure
			if ( Title::newFromText( $message, NS_MEDIAWIKI )->exists() )
				$skin->addToSidebar( $bar, $message );
		}
		return true;
	}
}
