<?php
spl_autoload_register( function( $class ) {
	$prefix = 'FandomCreatorEmail\\';
	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		return;
	}

	$file = __DIR__ . '/' . str_replace( '\\', '/', substr( $class, $len ) ) . '.php';
	if ( file_exists( $file ) ) {
		require $file;
	}
} );

// WikiaDispatcher looks for classes in this array and doesn't utilize the autoloader :|
$wgAutoloadClasses['FandomCreatorEmail\Api\SendEmailController'] = __DIR__ . '/Api/SendEmailController.php';
$wgAutoloadClasses['FandomCreatorEmail\Controller\ContentUpdatedController'] = __DIR__ . '/Controller/ContentUpdatedController.php';
