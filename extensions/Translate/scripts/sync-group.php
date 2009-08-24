<?php

$optionsWithArgs = array( 'group', 'lang', 'start', 'end' );
require( dirname( __FILE__ ) . '/cli.inc' );

# Override the memory limit for wfShellExec, 100 MB seems to be too little for svn
$wgMaxShellMemory = 1024 * 200;

function showUsage() {
	STDERR( <<<EOT
Options:
	--group	comma separated list of group ids or *
	--lang	comma separated list of language codes or *
	--norc	do not add entries to recent changes table
	--help	this help
	--noask	skip all conflicts
	--start	start of the last export (changes in wiki after this will conflict)
	--end	end of the last export (changes in source before this wont conflict)
	--nocolor	without colours
EOT
);
	exit( 1 );
}

if ( isset( $options['help'] ) ) showUsage();


if ( !isset( $options['group'] ) ) {
	STDERR( "ESG1: Message group id must be supplied with group parameter." );
	exit( 1 );
}

$group = MessageGroups::getGroup( $options['group'] );
if ( $group === null ) {
	if ( $options['group'] === '*' ) {
		$mg = MessageGroups::singleton();
		$groups = $mg->getGroups();
	} else {
		STDERR( "ESG2: Invalid message group was given." );
		exit( 1 );
	}
} else {
	$groups = array( $group );
}

if ( !isset( $options['lang'] ) ) {
	STDERR( "ESG3: List of language codes must be supplied with lang parameter." );
	exit( 1 );
}

$start = isset( $options['start'] ) ? strtotime( $options['start'] ) : false;
$end = isset( $options['end'] ) ? strtotime( $options['end'] ) : false;

STDOUT( "Conflict times: " . wfTimestamp( TS_ISO_8601, $start ) . " - " . wfTimestamp( TS_ISO_8601, $end ) );

$codes = array_filter( array_map( 'trim', explode( ',', $options['lang'] ) ) );

if ( $codes[0] === '*' ) {
	$langs = Language::getLanguageNames();
	ksort( $langs );
	$codes = array_keys( $langs );
}

foreach ( $groups as &$group ) {
	if ( $group->isMeta() ) continue;

	STDOUT( "{$group->getLabel()} ", $group );

	foreach ( $codes as $code ) {

		$file = $group->getMessageFileWithPath( $code );
		if ( !$file ) continue;

		if ( !file_exists( $file ) ) continue;

		$cs = new ChangeSyncer( $group );
		if ( isset( $options['norc'] ) ) $cs->norc = true;
		if ( isset( $options['noask'] ) ) $cs->interactive = false;
		if ( isset( $options['nocolor'] ) ) $cs->nocolor = true;

		$ts = $cs->getTimestampsFromSvn( $file );
		if ( !$ts ) $ts = $cs->getTimestampsFromFs( $file );

		STDOUT( "Modify time for $code: " . wfTimestamp( TS_ISO_8601, $ts ) );

		$count = $cs->checkConflicts( $code, $start, $end, $ts );

	}
	unset( $group );
}

class ChangeSyncer {
	public $group;
	public $norc = false;
	public $interactive = true;
	public $nocolor = false;

	public function __construct( MessageGroup $group ) {
		$this->group = $group;
	}

	// svn component from pecl doesn't seem to have this in quick sight
	public function getTimestampsFromSvn( $file ) {
		$file = escapeshellarg( $file );
		$retval = 0;
		$output = wfShellExec( "svn info $file 2>/dev/null", $retval );
		if ( $retval ) return false;


		$matches = array();
		// PHP doesn't allow foo || return false;
		// Thank
		// you
		// PHP (for being an ass)!
		$regex = '^Last Changed Date: (.*) \(';
		$ok = preg_match( "~$regex~m", $output, $matches );
		if ( $ok ) return strtotime( $matches[1] );

		return false;
	}

	public function getTimestampsFromFs( $file ) {
		if ( !file_exists( $file ) ) return false;
		$stat = stat( $file );
		return $stat['mtime'];
	}

	public function checkConflicts( $code, $startTs = false, $endTs = false, $changeTs = false ) {
		$messages = $this->group->load( $code );
		if ( !count( $messages ) ) return;

		$collection = $this->group->initCollection( $code );
		$this->group->fillCollection( $collection );

		foreach ( $messages as $key => $translation ) {

			if ( !isset( $collection[$key] ) ) {
				// STDOUT( "Unknown key $key" );
				continue;
			}



			$title = Title::makeTitleSafe( $this->group->namespaces[0], "$key/$code" );

			$page = $title->getPrefixedText();

			if ( $collection[$key]->database === null ) {
				STDOUT( "Importing $page as a new translation" );
				$this->import( $title, $translation, 'Importing a new translation' );
				continue;
			}

			$current = str_replace( TRANSLATE_FUZZY, '', $collection[$key]->translation );
			$translation = str_replace( TRANSLATE_FUZZY, '', $translation );
			if ( $translation === $current ) continue;

			STDOUT( "Conflict in " . $this->color( 'bold', $page ) . "!", $page );

			global $wgLang;
			$iso = 'xnY-xnm-xnd"T"xnH:xni:xns';

			// Finally all is ok, now lets start comparing timestamps
			// Make sure we are comparing timestamps in same format
			$wikiTs = $this->getLastGoodChange( $title, $startTs );
			if ( $wikiTs ) {
				$wikiTs = wfTimestamp( TS_UNIX, $wikiTs );
				$wikiDate = $wgLang->sprintfDate( $iso, wfTimestamp( TS_MW, $wikiTs ) );
			} else {
				$wikiDate = 'Unknown';
			}

			if ( $startTs ) {
				$startTs = wfTimestamp( TS_UNIX, $startTs );
				$startDate = $wgLang->sprintfDate( $iso, wfTimestamp( TS_MW, $startTs ) );
			} else {
				$startDate = 'Unknown';
			}

			if ( $endTs ) {
				$endTs = wfTimestamp( TS_UNIX, $endTs );
				$endDate = $wgLang->sprintfDate( $iso, wfTimestamp( TS_MW, $endTs ) );
			} else {
				$endDate = 'Unknown';
			}

			if ( $changeTs ) {
				$changeTs = wfTimestamp( TS_UNIX, $changeTs );
				$changeDate = $wgLang->sprintfDate( $iso, wfTimestamp( TS_MW, $changeTs ) );
			} else {
				$changeDate = 'Unknown';
			}

			if ( $changeTs ) {
				if ( $wikiTs > $startTs && $changeTs <= $endTs ) {
					STDOUT( " →Changed in wiki after export: IGNORE", $page );
					continue;
				} elseif ( !$wikiTs || ( $changeTs > $endTs && $wikiTs < $startTs ) ) {
					STDOUT( " →Changed in source after export: IMPORT", $page );
					$this->import( $title, $translation, 'Updating translation from external source' );
					continue;
				}

			}

			if ( !$this->interactive ) continue;
			STDOUT( " →Needs manual resolution", $page );

			STDOUT( "Source translation at $changeDate:" );
			STDOUT( $this->color( 'blue', $translation ) . "\n" );
			STDOUT( "Wiki translation at $wikiDate:" );
			STDOUT( $this->color( 'green', $current ) . "\n" );

			do {
				STDOUT( "Resolution: [S]kip [I]mport [C]onflict: ", 'foo' );
				$action = fgets( STDIN );
				$action = strtoupper( trim( $action ) );
				if ( $action === 'S' ) break;
				if ( $action === 'I' ) {
					$this->import( $title, $translation, 'Updating translation from external source' );
					break;
				}
				if ( $action === 'C' ) {
					$this->import( $title, TRANSLATE_FUZZY . $translation, 'Edit conflict between wiki and source' );
					break;
				}
			} while ( true );

		}
	}

	public function color( $color, $text ) {
		switch ( $color ) {
			case 'blue':
				return "\033[1;34m$text\033[0m";
			case 'green':
				return "\033[1;32m$text\033[0m";
			case 'bold':
				return "\033[1m$text\033[0m";
			default:
				return $text;
		}
	}

	public function getLastGoodChange( $title, $startTs = false ) {
		global $wgTranslateFuzzyBotName;

		$wikiTs = false;
		$revision = Revision::newFromTitle( $title );
		while ( $revision ) {
			// No need to go back further
			if ( $startTs && $wikiTs && ( $wikiTs < $startTs ) ) break;

			if ( $revision->getRawUserText() === $wgTranslateFuzzyBotName ) {
				$revision = $revision->getPrevious();
				continue;
			}

			$wikiTs = wfTimestamp( TS_UNIX, $revision->getTimestamp() );
			break;
		}

		return $wikiTs;
	}

	public function getImportUser() {
		static $user = null;
		if ( $user === null ) {
			global $wgTranslateFuzzyBotName;
			$user = User::newFromName( $wgTranslateFuzzyBotName );

			if ( !$user->isLoggedIn() ) {
				STDOUT( "Creating user $wgTranslateFuzzyBotName" );
				$user->addToDatabase();
			}
		}

		return $user;
	}

	public function import( $title, $translation, $comment ) {
		global $wgUser;
		$old = $wgUser;
		$wgUser = $this->getImportUser();

		$flags = EDIT_FORCE_BOT;
		if ( $this->norc ) $flags |= EDIT_SUPPRESS_RC;

		$article = new Article( $title );
		STDOUT( "Importing {$title->getPrefixedText()}: ", $title );
		$status = $article->doEdit( $translation, $comment, $flags );
		$success = $status === true || ( is_object( $status ) && $status->isOK() );
		STDOUT( $success ? 'OK' : 'FAILED', $title );

		$wgUser = $old;
	}

}

STDOUT( wfTimestamp( TS_RFC2822 ) );
