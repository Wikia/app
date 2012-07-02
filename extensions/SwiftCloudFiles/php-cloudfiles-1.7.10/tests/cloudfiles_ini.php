<?php
if ( php_sapi_name() !== 'cli' ) {
	die( "This is not a valid web entry point." );
}

$VERBOSE = False;                       # informational messages to stdout
$USER    = "";                          # Rackspace Cloud Username
$API_KEY = "";				# Rackspace Cloud API Key
$ACCOUNT = NULL;                        # account name
$HOST    = NULL;                        # authentication host URL

# Allow override by environment variable
if (isset($_ENV["RCLOUD_API_USER"])) {
    $USER = $_ENV["RCLOUD_API_USER"];
}

if (isset($_ENV["RCLOUD_API_KEY"])) {
    $API_KEY = $_ENV["RCLOUD_API_KEY"];
}

if (isset($_ENV["RCLOUD_API_VERBOSE"])) {
    $VERBOSE = $_ENV["RCLOUD_API_VERBOSE"];
}

# Make it global
define('USER', $USER);
define('API_KEY', $API_KEY);
define('ACCOUNT', $ACCOUNT);
define('VERBOSE', $VERBOSE);

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>
