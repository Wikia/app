<?php

namespace Wikia\PotentialMemberPageExperiments;

class Hooks extends \ContextSource {

	public static function register() {
		$hooks = new self();
		\Hooks::register( 'BeforePageDisplay', [ $hooks, 'onBeforePageDisplay' ] );
	}

	public function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		$user = $this->getUser();

		if ( !$user->isLoggedIn() || $user->getEditCount() === 0 ) {
			$out->addScriptFile( '/extensions/wikia/PotentialMemberPageExperiments/scripts/entry-point-experiment.js' );
		}

		return true;
	}
}
