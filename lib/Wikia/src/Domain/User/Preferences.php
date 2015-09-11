<?php

namespace Wikia\Domain\User;

use Wikia\Util\Assert;

class Preferences {

    private $globalPreferences;
    private $localPreferences;

    function __construct( $globalPreferences, $localPreferences ) {

        $this->globalPreferences = $globalPreferences;
        $this->localPreferences = $localPreferences;
    }

    public function getGlobalPreferences() {
        return $this->globalPreferences;
    }

    public function getLocalPreferences() {
        return $this->localPreferences;
    }

}
