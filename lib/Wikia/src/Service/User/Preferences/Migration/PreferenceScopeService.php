<?php

namespace Wikia\Service\User\Preferences\Migration;

interface PreferenceScopeService {
	public function splitLocalPreference( $option );
	public function isLocalPreference( $option );
	public function isGlobalPreference( $option );
}
