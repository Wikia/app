<?php

require( dirname( __FILE__ ).'/cli.inc' );

$usage = <<<EOT
Usage:
  php convertVotes.php [options] --name <election name>
  php convertVotes.php [options] <dump file>

Options are:
  --no-proof-protection    Disable protection for proof of vote (vote buying)
EOT;


if ( !isset( $options['name'] ) && !isset( $args[0] ) ) {
	spFatal( $usage );
}

if ( !class_exists( 'SecurePoll_Context' ) ) {
	if ( isset( $options['name'] ) ) {
		spFatal( "Cannot load from database when SecurePoll is not installed" );
	}
	require( dirname( __FILE__ ) . '/../SecurePoll.php' );
}

$conv = new SecurePoll_ConvertVotes;

if ( !isset( $options['name'] ) ) {
	$conv->convertFile( $args[0] );
} else {
	$conv->convertLocalElection( $options['name'] );
}


class SecurePoll_ConvertVotes {
	var $context;

	function convertFile( $fileName ) {
		$this->context = SecurePoll_Context::newFromXmlFile( $fileName );
		if ( !$this->context ) {
			spFatal( "Unable to parse XML file \"$fileName\"" );
		}
		$electionIds = $this->context->getStore()->getAllElectionIds();
		if ( !count( $electionIds ) ) {
			spFatal( "No elections found in XML file \"$fileName\"" );
		}
		$electionId = reset( $electionIds );
		$this->election = $this->context->getElection( reset( $electionIds ) );
		$this->convert( $electionId );
	}

	function convertLocalElection( $name ) {
		$this->context = new SecurePoll_Context;
		$this->election = $this->context->getElectionByTitle( $name );
		if ( !$this->election ) {
			spFatal( "The specified election does not exist." );
		}
		$this->convert( $this->election->getId() );
	}

	function convert( $electionId ) {
		$this->votes = array();
		$this->crypt = $this->election->getCrypt();
		$this->ballot = $this->election->getBallot();

		$status = $this->context->getStore()->callbackValidVotes( $electionId, array( $this, 'convertVote' ) );
		if ( !$status->isOK() ) {
			spFatal( "Error: " . $status->getWikiText() );
		}
		$s = '';
		foreach ( $this->election->getQuestions() as $question ) {
			if ( $s !== '' ) {
				$s .= str_repeat( '-', 80 ) . "\n\n";
			}
			$s .= $question->getMessage( 'text' ) . "\n";
			$names = array();
			foreach ( $question->getOptions() as $option ) {
				$names[$option->getId()] = $option->getMessage( 'text' );
			}
			ksort( $names );
			$names = array_values( $names );
			foreach ( $names as $i => $name ) {
				$s .= ( $i + 1 ) . '. ' . $name . "\n";
			}
			$votes = $this->votes[$question->getId()];
			sort( $votes );
			$s .= implode( "\n", $votes ) . "\n";
		}
		echo $s;
	}

	function convertVote( $store, $record ) {
		if ( $this->crypt ) {
			$status = $this->crypt->decrypt( $record );
			if ( !$status->isOK() ) {
				return $status;
			}
			$record = $status->value;
		}
		$record = rtrim( $record );
		$record = $this->ballot->convertRecord( $record );
		if ( $record === false ) {
			spFatal( 'Error: missing question in vote record' );
		}
		foreach ( $record as $qid => $qrecord ) {
			$this->votes[$qid][] = $qrecord;
		}
		return Status::newGood();
	}
}

function spFatal( $message ) {
	fwrite( STDERR, rtrim( $message ) . "\n" );
	exit( 1 );
}

