<?php
namespace Wikia\Helios;

class AuthPlugin extends \AuthPlugin {

    public function authenticate( $sUsername, $sPassword ) {
        $oClient = new Client;
        return $oClient->authenticate();
    }

}

class AuthPluginUser extends \AuthPluginUser {
}