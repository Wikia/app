<?php

// Don't include DevBoxSettings when running unit tests
$wgRunningUnitTests = true;
$wgDevelEnvironment = true;

if ( !defined( 'WIKIA_DC_SJC' ) ) {
	define( 'WIKIA_DC_SJC', 'sjc' );
	define( 'WIKIA_DC_RES', 'res' );
	define( 'WIKIA_DC_POZ', 'poz' );

	define( 'WIKIA_ENV_DEV', 'dev' );
	define( 'WIKIA_ENV_PREVIEW', 'preview' );
	define( 'WIKIA_ENV_PROD', 'prod' );
	define( 'WIKIA_ENV_SANDBOX', 'sandbox' );
	define( 'WIKIA_ENV_VERIFY', 'verify' );
	define( 'WIKIA_ENV_STABLE', 'stable' );
	define( 'WIKIA_ENV_STAGING', 'staging' );
}

require_once __DIR__ . '/../maintenance/commandLine.inc';

$wgExternalSharedDB = false;

$directoryIterator = new DirectoryIterator( __DIR__ . '/../extensions/wikia' );

foreach ( $directoryIterator as $file ) {
	if ( $file->isDir() && !$file->isDot() ) {
		$extensionDirectoryIterator = new DirectoryIterator( $file->getPathname() );
		$extensionName = $file->getFilename();
		$extensionLoaderFile = "$extensionName.php";

		foreach ( $extensionDirectoryIterator as $extFile ) {
			$fileName = $extFile->getFilename();
			if ( $extFile->isFile() && ( $fileName === $extensionLoaderFile || preg_match( '/setup\.php$/', $fileName ) )	) {
				require_once $extFile->getPathname();
			}
		}
	}
}
