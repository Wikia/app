<?php

class CommunityPageExperimentHooks {
	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		$out->addModules( 'ext.communityPageExperimentEntryPointInit' );
		return true;
	}
}
