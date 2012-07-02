<?php

# Initialise common code
require_once( './includes/WebStart.php' );

require_once( './WebDavServer.php' );

$server = new WebDavServer;
$server->handleRequest();

