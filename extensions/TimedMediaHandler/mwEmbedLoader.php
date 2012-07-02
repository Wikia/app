<?php 
// This is a stub entry point to load.php This is need to support valid paths for the stand alone 
// mwEmbed module html test files. 

// This is useful for running stand alone test of mwEmbed components in the TimedMediaHandler
// extension. ( ie MwEmbedModules/EmbedPlayer/tests/*.html files )

$_GET['modules'] = 'startup';
$_GET['only'] = 'scripts';

// NOTE this won't work so well with symbolic links
$loaderPath = dirname(__FILE__) . '/../../load.php';
if( is_file( $loaderPath ) ){	
	chdir( dirname( $loaderPath ) );
	include_once( $loaderPath );
} else {
	print "if( console && typeof console.log == 'function' ){ console.log('Error can't find load.php for stand alone tests' ) }";
}
// Bootstrap some js code to make the "loader" work in stand alone tests: 
// Note this has to be wrapped in a document.write to run after other document.writes
$pageStartupScript = Html::inlineScript(
	ResourceLoader::makeLoaderConditionalScript(
		Xml::encodeJsCall( 'mw.loader.go', array() )
	)
);
echo Xml::encodeJsCall( 'document.write', array( $pageStartupScript ) );
