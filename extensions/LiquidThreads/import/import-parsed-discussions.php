<?php
require_once ( getenv( 'MW_INSTALL_PATH' ) !== false
	? getenv( 'MW_INSTALL_PATH' ) . "/maintenance/commandLine.inc"
	: dirname( __FILE__ ) . '/../../maintenance/commandLine.inc' );

# # Imports JSON-encoded discussions from parse-wikitext-discussions.pl

// die( var_dump( $argv ) );

$structure = json_decode( file_get_contents( $argv[0] ), true );

$article = new Article( Title::newFromText( $argv[1] ) );

$wgOut->_unstub();
$wgOut->setTitle( $article->getTitle() );

$subject = '';
$rootPost = null;

recursiveParseArray( $structure );

function recursiveParseArray( $array ) {
	static $recurseLevel = 0;

	$recurseLevel++;

	if ( $recurseLevel > 90 ) {
		print var_dump( $array );
		die( wfBacktrace() );
	}

	global $subject, $rootPost;
	if ( is_array( $array ) && isset( $array['title'] ) ) {
		$subject = $array['title'];
		recursiveParseArray( $array['content'] );

		$rootPost = null;
	} elseif ( is_array( $array ) && isset( $array['user'] ) ) {
		// We have a post.
		$t = createPost( $array, $subject, $rootPost );

		if ( !$rootPost ) {
			$rootPost = $t;
		}
	} elseif ( is_array( $array ) ) {
		foreach ( $array as $info ) {
			recursiveParseArray( $info );
		}

		$rootPost = null;
	}

	$recurseLevel--;
}

function createPost( $info, $subject, $super = null ) {
	$userName = $info['user'];
	if ( strpos( $userName, '#' ) !== false ) {
		$pos = strpos( $userName, '#' );

		$userName = substr( $userName, 0, $pos );
	}

	$user = User::newFromName( $userName, /* no validation */ false );

	if ( !$user ) {
		throw new MWException( "Username " . $info['user'] . " is invalid." );
	}

	global $article;

	if ( $super ) {
		$title = Threads::newReplyTitle( $super, $user );
	} else {
		$title = Threads::newThreadTitle( $subject, $article );
	}

	print "Creating thread $title as a subthread of " . ( $super ? $super->title() : 'none' ) . "\n";

	$root = new Article( $title );
	$root->doEdit( $info['content'], 'Imported from JSON', EDIT_NEW, false, $user );

	$t = LqtView::postEditUpdates( $super ? 'reply' : 'new', $super, $root, $article,
									$subject, 'Imported from JSON', null );

	$t = Threads::withId( $t->id() ); // Some weirdness.

	return $t;
}
