<?php

namespace Wikia\Domain\User;

class Preferences {

    /** @var GlobalPreference[] */
    private $globalPreferences;

    /** @var LocalPreference[] */
    private $localPreferences;

    /**
     * @param GlobalPreference[] $globalPreferences
     * @param LocalPreference[] $localPreferences
     */
    function __construct( $globalPreferences, $localPreferences ) {

        $this->globalPreferences = $globalPreferences;
        $this->localPreferences = $localPreferences;
    }

    /**
     * @return GlobalPreference[]
     */
    public function getGlobalPreferences() {
        return $this->globalPreferences;
    }

    /**
     * @return LocalPreference[]
     */
    public function getLocalPreferences() {
        return $this->localPreferences;
    }

}
