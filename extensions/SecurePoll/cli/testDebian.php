<?php

require( dirname(__FILE__).'/cli.inc' );
$testDir = dirname(__FILE__).'/debtest';
if ( !is_dir( $testDir ) ) {
	mkdir( $testDir );
}

$spDebianVoteDir = '/home/tstarling/src/voting/debian-vote/debian-vote-0.8-fixed';

if ( count( $args ) ) {
	foreach ( $args as $arg ) {
		if ( !file_exists( $arg ) ) {
			echo "File not found: $arg\n";
			exit( 1 );
		}
		$debResult = spRunDebianVote( $arg );
		if ( spRunTest( $arg, $debResult ) ) {
			echo "$arg OK\n";
		}
	}
	exit( 0 );
}

for ( $i = 1; true; $i++ ) {
	$fileName = "$testDir/$i.in";
	spGenerateTest( $fileName );
	$debResult = spRunDebianVote( $fileName );
	if ( spRunTest( $fileName, $debResult ) ) {
		unlink( $fileName );
	}
	if ( $i % 1000 == 0 ) {
		echo "$i tests done\n";
	}
}

function spRunTest( $fileName, $debResult ) {
	$file = fopen( $fileName, 'r' );
	if ( !$file ) {
		echo "Unable to open file \"$fileName\" for input\n";
		return;
	}

	$votes = array();
	$numCands = 0;
	while ( !feof( $file ) ) {
		$line = fgets( $file );
		if ( $line === false ) {
			break;
		}
		$line = trim( $line );
		if ( !preg_match( '/^V: ([0-9-]*)$/', $line, $m ) ) {
			echo "Skipping unrecognised line $line\n";
			continue;
		}

		$record = array();
		for ( $i = 0; $i < strlen( $m[1] ); $i++ ) {
			$pref = substr( $m[1], $i, 1 );
			if ( $i == strlen( $m[1] ) - 1 ) {
				$id = 'X';
			} else {
				$id = chr( ord( 'A' ) + $i );
			}
			if ( $pref === '-' ) {
				$record[$id] = 1000;
			} else {
				$record[$id] = intval( $pref );
			}
		}
		$votes[] = $record;
		$numCands = max( $numCands, count( $record ) );
	}

	$options = array();
	for ( $i = 0; $i < $numCands - 1; $i++ ) {
		$id = chr( ord( 'A' ) + $i );
		$options[$id] = $id;
	}
	$options['X'] = 'X';
	$question = new SecurePoll_FakeQuestion( $options );
	$tallier = new SecurePoll_SchulzeTallier( false, $question );
	foreach ( $votes as $vote ) {
		$tallier->addVote( $vote );
	}
	$tallier->finishTally();
	$ranks = $tallier->getRanks();
	$winners = array();
	foreach ( $ranks as $oid => $rank ) {
		if ( $rank === 1 ) {
			$winners[] = $oid;
		}
	}
	if ( count( $winners ) > 1 ) {
		$expected = 'result: tie between options ' . implode( ', ', $winners );
	} else {
		$expected = 'result: option ' . reset( $winners ) . ' wins';
	}
	if ( $debResult === $expected ) {
		return true;
	}

	echo "Mismatch in file $fileName\n";
	echo "Debian got: $debResult\n";
	echo "We got: $expected\n\n";
	echo $tallier->getTextResult();
	return false;
}

function spRunDebianVote( $fileName ) {
	global $spDebianVoteDir;
	$result = wfShellExec(
		wfEscapeShellArg(
			"$spDebianVoteDir/debian-vote",
			$fileName 
		)
	);
	if ( !$result ) {
		echo "Error running debian vote!\n";
		exit( 1 );
	}
	$result = rtrim( $result );
	$lastLineEnd = strrpos( $result, "\n" );
	$lastLine = substr( $result, $lastLineEnd + 1 );
	return $lastLine;
}

function spGetRandom( $min, $max ) {
	return mt_rand( 0, mt_getrandmax() ) / mt_getrandmax() * ( $max - $min ) + $min;
}

function spGenerateTest( $fileName ) {
	global $spDebianVoteDir;
	wfShellExec(
		wfEscapeShellArg( "$spDebianVoteDir/votegen" ) . ' > ' . 
		wfEscapeShellArg( $fileName )
	);
}

class SecurePoll_FakeQuestion {
	var $options;

	function __construct( $options ) {
		$this->options = array();
		foreach ( $options as $i => $option ) {
			$this->options[] = new SecurePoll_FakeOption( $i, $option );
		}
	}

	function getOptions() {
		return $this->options;
	}
}

class SecurePoll_FakeOption {
	var $id, $name;

	function __construct( $id, $name ) {
		$this->id = $id;
		$this->name = $name;
	}

	function getMessage( $key ) {
		return $this->name;
	}

	function parseMessage( $key ) {
		return htmlspecialchars( $this->name );
	}

	function getId() {
		return $this->id;
	}
}

