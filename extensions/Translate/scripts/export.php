<?php
/**
 * Script to export translations of one message group to file(s).
 *
 * @author Niklas Laxstrom
 * @author Siebrand Mazeland
 * @copyright Copyright © 2008-2012, Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

$optionsWithArgs = array( 'lang', 'skip', 'target', 'group', 'groupprefix', 'threshold', 'ppgettext' );
require( dirname( __FILE__ ) . '/cli.inc' );

function showUsage() {
	STDERR( <<<EOT
Message exporter.

Usage: php export.php [options...]

Options:
  --target      Target directory for exported files
  --lang        Comma separated list of language codes or *
  --skip        Languages to skip, comma separated list
  --group       Comma separated list of group IDs (cannot use groupprefix)
  --groupprefix Prefix of group IDs to be exported message groups (cannot use
                group)
  --help        This help message
  --threshold   Do not export under this percentage translated
  --ppgettext   Group root path for checkout of product. "msgmerge" will post
                process on the export result based on the current definitionFile
                in that location
  --no-location Only used combined with "ppgettext". This option will rebuild
                the gettext file without location information.
  --no-fuzzy    Do not include any messages marked as fuzzy/outdated.
EOT
);
	exit( 1 );
}

if ( isset( $options['help'] ) || $args === 1 ) {
	showUsage();
}

if ( !isset( $options['target'] ) ) {
	STDERR( "You need to specify target directory" );
	exit( 1 );
}

if ( !isset( $options['lang'] ) ) {
	STDERR( "You need to specify languages to export" );
	exit( 1 );
}

if ( isset( $options['skip'] ) ) {
	$skip = array_map( 'trim', explode( ',', $options['skip'] ) );
} else {
	$skip = array();
}

if ( !isset( $options['group'] ) && !isset( $options['groupprefix'] ) ) {
	STDERR( "You need to specify one or more groups using any of the options 'group' or 'groupprefix'" );
	exit( 1 );
}

if ( !is_writable( $options['target'] ) ) {
	STDERR( "Target directory is not writable (" . $options['target'] . ")" );
	exit( 1 );
}

if ( isset( $options['threshold'] ) && intval( $options['threshold'] ) ) {
	$threshold = $options['threshold'];
} else {
	$threshold = false;
}

if ( isset( $options['no-location'] ) ) {
	$noLocation = '--no-location ';
} else {
	$noLocation = '';
}

if ( isset( $options['no-fuzzy'] ) ) {
	$noFuzzy = true;
} else {
	$noFuzzy = false;
}

$reqLangs = Cli::parseLanguageCodes( $options['lang'] );

$groups = array();

// @todo FIXME: Code duplication with sync-group.php
if ( isset( $options['group'] ) ) {
	// Explode parameter
	$groupIds = explode( ',', trim( $options['group'] ) );

	// Get groups and add groups to array
	foreach ( $groupIds as $groupId ) {
		$group = MessageGroups::getGroup( $groupId );

		if ( $group !== null ) {
			$groups[$groupId] = $group;
		} else {
			STDERR( "Invalid group $groupId" );
		}
	}
} else {
	// Apparently using option groupprefix. Find groups that match.
	$allGroups = MessageGroups::singleton()->getGroups();

	// Add matching groups to groups array.
	foreach ( $allGroups as $groupId => $messageGroup ) {
		if ( strpos( $groupId, $options['groupprefix'] ) === 0 && !$messageGroup->isMeta() ) {
			$groups[$groupId] = $messageGroup;
		}
	}
}

foreach ( $groups as $groupId => $group ) {
	if ( !$group instanceof MessageGroup ) {
		STDERR( "Invalid group: " . $groupId );
		exit( 1 );
	}

	STDERR( 'Exporting ' . $groupId );

	$langs = $reqLangs;
	if ( $threshold ) {
		$stats = MessageGroupStats::forGroup( $groupId );
		foreach ( $langs as $index => $code ) {
			if ( !isset( $stats[$code] ) ) {
				unset( $langs[$index] );
			}

			list( $total, $translated, ) = $stats[$code];
			if ( $translated / $total * 100 < $threshold ) {
				unset( $langs[$index] );
			}
		}
	}

	if ( $group instanceof FileBasedMessageGroup ) {
		$ffs = $group->getFFS();
		$ffs->setWritePath( $options['target'] );
		$collection = $group->initCollection( 'en' );

		$definitionFile = false;

		if ( isset( $options['ppgettext'] ) && $ffs instanceof GettextFFS ) {
			global $wgMaxShellMemory;

			// Need more shell memory for msgmerge.
			$wgMaxShellMemory = 402400;

			$conf = $group->getConfiguration();
			$definitionFile = str_replace( '%GROUPROOT%', $options['ppgettext'], $conf['FILES']['definitionFile'] );
		}

		foreach ( $langs as $lang ) {
			// Do not export if language code is to be skipped or is not a valid language.
			if ( in_array( $lang, $skip ) || !$group->isValidLanguage( $lang ) ) {
				continue;
			}

			$collection->resetForNewLanguage( $lang );

			if ( $noFuzzy ) {
				$collection->filter( 'fuzzy' );
			}

			$ffs->write( $collection );

			// Do post processing if requested.
			if ( $definitionFile ) {
				if ( is_file( $definitionFile ) ) {
					$targetFileName = $ffs->getWritePath() . $group->getTargetFilename( $collection->code );
					$cmd = "msgmerge --quiet " . $noLocation . "--output-file=" . $targetFileName . ' ' . $targetFileName . ' ' . $definitionFile;
					wfShellExec( $cmd, $ret );

					// Report on errors.
					if ( $ret ) {
						STDERR( 'ERROR: ' . $ret );
					}
				} else {
					STDERR( $definitionFile . ' does not exist.' );
					exit( 1 );
				}
			}
		}
	} else {
		if ( $noFuzzy ) {
			STDERR( '--no-fuzzy is not supported for this message group.' );
		}

		$writer = $group->getWriter();
		$writer->fileExport( $langs, $options['target'] );
	}
}
