<?php
namespace Wikia\Helios;

class ExternalUser extends \ExternalUser_Wikia {

    public function authenticate($sPassword) {
        $oClient = new Client;
        return $oClient->authenticate();
    }

}