<?php

require_once __DIR__ . '/includes/WebStart.php';

call_user_func( function () {
	global $wgRequest;

	$database = wfGetDB( DB_SLAVE );
	$fileRepo = RepoGroup::singleton()->getLocalRepo();

	$imageService = new DatabaseImageService( $database, $fileRepo );
	$vignetterUrlRedirector = new VignetteUrlRedirector( $imageService );

	$vignetterUrlRedirector->process( $wgRequest );
} );
