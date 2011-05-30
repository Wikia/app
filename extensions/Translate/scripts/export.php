<?php
/**
 * Script to export translations of one message group to file(s).
 *
 * @author Niklas Laxstrom
 * @author Siebrand Mazeland
 * @copyright Copyright © 2008-2010, Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

$optionsWithArgs = array( 'lang', 'skip', 'target', 'group', 'groups', 'grouptrail', 'threshold', 'ppgettext' );
require( dirname( __FILE__ ) . '/cli.inc' );

function showUsage() {
	STDERR( <<<EOT
Message exporter.

Usage: php export.php [options...]

Options:
  --target      Target directory for exported files
  --lang        Comma separated list of language codes or *
  --skip        Languages to skip, comma separated list
  --group       Group ID (cannot use groups grouptrial)
  --groups      Group IDs, comma separated list (cannot use group or grouptrial)
  --grouptrail  Trial for IDs of to be exported message groups (cannot use
                group or grouptrial)
  --threshold   Do not export under this percentage translated
  --ppgettext   Group root path for checkout of product. "msgmerge" will post
                process on the export result based on the current definitionFile
                in that location
  --no-location Only used combined with "ppgettext". This option will rebuild
                the gettext file without location information.
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

if ( !isset( $options['group'] ) && !isset( $options['groups'] ) && !isset( $options['grouptrail'] ) ) {
	STDERR( "You need to specify one or more groups using any of the options 'group', 'groups' or 'grouptrail'" );
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

$reqLangs = Cli::parseLanguageCodes( $options['lang'] );

$groups = array();

if ( isset( $options['group'] ) ) {
	$groups[$options['group']] = MessageGroups::getGroup( $options['group'] );
} elseif ( isset( $options['groups'] ) ) {
	// Explode parameter
	$groupIds = explode( ',', trim( $options['groups'] ) );

	// Get groups and add groups to array
	foreach ( $groupIds as $groupId ) {
		$groups[$groupId] = MessageGroups::getGroup( $groupId );
	}
} else {
	// Apparently using option grouptrail. Find groups that match.
	$allGroups = MessageGroups::singleton()->getGroups();

	// Add matching groups to groups array.
	foreach ( $allGroups as $groupId => $messageGroup ) {
		if ( strpos( $groupId, $options['grouptrail'] ) === 0 && !$messageGroup->isMeta() ) {
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

	if ( $threshold ) {
		$langs = TranslationStats::getPercentageTranslated(
			$groupId,
			$reqLangs,
			$threshold,
			true
		);
	} else {
		$langs = $reqLangs;
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
		$writer = $group->getWriter();
		$writer->fileExport( $langs, $options['target'] );
	}
}
