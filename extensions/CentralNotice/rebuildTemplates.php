<?php

require_once dirname( dirname( dirname( __FILE__ ) ) ) . "/maintenance/commandLine.inc";

if ( !$wgNoticeCentralDirectory ) {
	echo "\$wgNoticeCentralDirectory isn't set -- we're not configured to build static templates.";
}

if ( isset( $options['help'] ) ) {
	echo "Rebuilds templates for all notices in DB.\n";
	echo "Usage:\n";
	echo "  php extensions/CentralNotice/rebuildTemplates [-o|Output to disk] [-n test/en|Output just a single notice]\n";
} else {
	echo "Rebuilding templates ...\n";

	// Hack for parser to avoid barfing from no $wgTitle
	$wgTitle = Title::newFromText( wfMsg( 'mainpage' ) );

        if ( isset( $options['n'] ) ) {
           $notice = explode( "/", $args[0] );
           $projects = array( $notice[0] );
           $langs = array( $notice[1] );
        } else {
	    $projects = $wgNoticeProjects;
	    $langs = array_keys( Language::getLanguageNames() );
        }
	foreach ( $projects as $project ) {
		foreach ( $langs as $lang ) {
			$key = "$project/$lang";
			echo "$key\n";

			$builder = new SpecialNoticeText();
			$js = $builder->getJsOutput( $key );

                        if ( isset( $options['o'] ) ) {
			    $outputDir = "$wgNoticeCentralDirectory/$project/$lang";
                            if ( wfMkDirParents( $outputDir ) ) {
                                    $outputFile = "$outputDir/centralnotice.js";
                                    $ok = file_put_contents( $outputFile, $js );
                                    if ( !$ok ) {
                                            echo "FAILED to write $outputFile!\n";
                                    }
                            } else {
                                    echo "FAILED to create $outputDir!\n";
                            }
                        } else {
                            echo $js;
                        }
		}
	}
}
