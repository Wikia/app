<?php
spl_autoload_register( function( $class ) {
	$prefix = 'FandomCreator\\';
	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		return;
	}

	$file = __DIR__ . '/' . str_replace( '\\', '/', substr( $class, $len ) ) . '.php';
	if ( file_exists( $file ) ) {
		require $file;
	}
} );

$wgHooks['NavigationApigetDataAfterExecute'][] = function( WikiaDispatchableObject $dispatchable ) {
	global $wgMaxLevelOneNavElements, $wgFandomCreatorCommunityId, $wgMaxLevelTwoNavElements, $wgMaxLevelThreeNavElements;

	\FandomCreator\Hooks::onNavigationApiGetData(
			$dispatchable,
			$wgFandomCreatorCommunityId,
			[$wgMaxLevelOneNavElements, $wgMaxLevelTwoNavElements, $wgMaxLevelThreeNavElements]
	);

	return true;
};
