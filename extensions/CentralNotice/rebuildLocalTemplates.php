<?php

require_once dirname( dirname( dirname( __FILE__ ) ) ) . "/maintenance/commandLine.inc";

if ( !$wgNoticeLocalDirectory ) {
	echo "\$wgNoticeLocalDirectory isn't set -- we're not configured to build static templates.";
}

if ( isset( $options['help'] ) ) {
	echo "Rebuilds templates for local sitenotices for this DB.\n";
	echo "Usage:\n";
	echo "  php extensions/CentralNotice/rebuildLocalTemplates.php --wiki=<dbname>\n";
} else {
	echo "Rebuilding templates ...\n";

	// Hack for parser to avoid barfing from no $wgTitle
	$wgTitle = Title::newFromText( wfMsg( 'mainpage' ) );

	$notices = array( 'sitenotice.js', 'anonnotice.js' );
	foreach ( $notices as $notice ) {
		$key = $notice;
		echo "$wgDBname/$key\n";

		$builder = new SpecialNoticeLocal();
		$js = $builder->getJsOutput( $key );

		$outputDir = $wgNoticeLocalDirectory;
		if ( wfMkDirParents( $outputDir ) ) {
			$outputFile = "$outputDir/$notice";
			$ok = file_put_contents( $outputFile, $js );
			if ( !$ok ) {
				echo "FAILED to write $outputFile!\n";
			}
		} else {
			echo "FAILED to create $outputDir!\n";
		}
	}
}
