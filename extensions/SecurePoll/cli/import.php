<?php

require( dirname( __FILE__ ) . '/cli.inc' );

$usage = <<<EOT
Import configuration files into the local SecurePoll database. Files can be 
generated with dump.php.

Usage: import.php [options] <file>

Options are:
	--update-msgs       Update the internationalised text for the elections, do 
                        not update configuration.

	--replace           If an election with a conflicting title exists already, 
                        replace it, updating its configuration. The default is 
						to exit with an error.

Note that any vote records will NOT be imported.

For the moment, the entity IDs are preserved, to allow easier implementation of 
the message update feature. This means conflicting entity IDs in the local 
database will generate an error. This restriction will be removed in the 
future.

EOT;

# Most of the code here will eventually be refactored into the update interfaces 
# of the entity and context classes, but that project can wait until we have a
# setup UI.

if ( !isset( $args[0] ) ) {
	echo $usage;
	exit( 1 );
}
if ( !file_exists( $args[0] ) ) {
	echo "The specified file \"{$args[0]}\" does not exist\n";
	exit( 1 );
}

foreach ( array( 'update-msgs', 'replace' ) as $optName ) {
	if ( !isset( $options[$optName] ) ) {
		$options[$optName] = false;
	}
}

$success = spImportDump( $args[0], $options );
exit( $success ? 0 : 1 );

function spImportDump( $fileName, $options ) {
	$store = new SecurePoll_XMLStore( $fileName );
	$success = $store->readFile();
	if ( !$success ) {
		echo "Error reading XML dump, possibly corrupt\n";
		return false;
	}
	$electionIds = $store->getAllElectionIds();
	if ( !count( $electionIds ) ) {
		echo "No elections found to import.\n";
		return true;
	}

	$xc = new SecurePoll_Context;
	$xc->setStore( $store );
	$dbw = wfGetDB( DB_MASTER );

	# Start the configuration transaction
	$dbw->begin();
	foreach ( $electionIds as $id ) {
		$elections = $store->getElectionInfo( array( $id ) );
		$electionInfo = reset( $elections );
		$existingId = $dbw->selectField( 
			'securepoll_elections', 
			'el_entity', 
			array( 'el_title' => $electionInfo['title'] ), 
			__METHOD__, 
			array( 'FOR UPDATE' ) );
		if ( $existingId !== false ) {
			if ( $options['replace'] ) {
				spDeleteElection( $existingId );
				$success = spImportConfiguration( $store, $electionInfo );
			} elseif ( $options['update-msgs'] ) {
				# Do the message update and move on to the next election
				$success = spUpdateMessages( $store, $electionInfo );
			} else {
				echo "Conflicting election title found \"{$electionInfo['title']}\"\n";
				echo "Use --replace to replace the existing election.\n";
				$success = false;
			}
		} elseif ( $options['update-msgs'] ) {
			echo "Cannot update messages: election \"{$electionInfo['title']}\" not found.\n";
			echo "Import the configuration first, without the --update-msgs switch.\n";
			$success = false;
		} else {
			$success = spImportConfiguration( $store, $electionInfo );
		}
		if ( !$success ) {
			$dbw->rollback();
			return false;
		}
	}
	$dbw->commit();
	return true;
}

function spDeleteElection( $electionId ) {
	$dbw = wfGetDB( DB_MASTER );

	# Get a list of entity IDs and lock them
	$questionIds = array();
	$res = $dbw->select( 'securepoll_questions', array( 'qu_entity' ),
		array( 'qu_election' => $electionId ),
		__METHOD__, array( 'FOR UPDATE' ) );
	foreach ( $res as $row ) {
		$questionIds[] = $row->qu_entity;
	}

	$res = $dbw->select( 'securepoll_options', array( 'op_entity' ),
		array( 'op_election' => $electionId ),
		__METHOD__, array( 'FOR UPDATE' ) );
	$optionIds = array();
	foreach ( $res as $row ) {
		$optionIds[] = $row->op_entity;
	}

	$entityIds = array_merge( $optionIds, $questionIds, array( $electionId ) );

	# Delete the messages and properties
	$dbw->delete( 'securepoll_msgs', array( 'msg_entity' => $entityIds ) );
	$dbw->delete( 'securepoll_properties', array( 'pr_entity' => $entityIds ) );

	# Delete the entities
	$dbw->delete( 'securepoll_options', array( 'op_entity' => $optionIds ), __METHOD__ );
	$dbw->delete( 'securepoll_questions', array( 'qu_entity' => $questionIds ), __METHOD__ );
	$dbw->delete( 'securepoll_elections', array( 'el_entity' => $electionId ), __METHOD__ );
	$dbw->delete( 'securepoll_entity', array( 'en_id' => $entityIds ), __METHOD__ );
}

function spInsertEntity( $type, $id ) {
	$dbw = wfGetDB( DB_MASTER );
	$dbw->insert( 'securepoll_entity', 
		array( 
			'en_id' => $id,
			'en_type' => $type,
		),
		__METHOD__
	);
}

function spImportConfiguration( $store, $electionInfo ) {
	$dbw = wfGetDB( DB_MASTER );
	$sourceIds = array();

	# Election
	spInsertEntity( 'election', $electionInfo['id'] );
	$dbw->insert( 'securepoll_elections',
		array(
			'el_entity' => $electionInfo['id'],
			'el_title' => $electionInfo['title'],
			'el_ballot' => $electionInfo['ballot'],
			'el_tally' => $electionInfo['tally'],
			'el_primary_lang' => $electionInfo['primaryLang'],
			'el_start_date' => $dbw->timestamp( $electionInfo['startDate'] ),
			'el_end_date' => $dbw->timestamp( $electionInfo['endDate'] ),
			'el_auth_type' => $electionInfo['auth']
		),
		__METHOD__ );
	$sourceIds[] = $electionInfo['id'];


	# Questions
	$index = 1;
	foreach ( $electionInfo['questions'] as $questionInfo ) {
		spInsertEntity( 'question', $questionInfo['id'] );
		$dbw->insert( 'securepoll_questions',
			array(
				'qu_entity' => $questionInfo['id'],
				'qu_election' => $electionInfo['id'],
				'qu_index' => $index++,
			),
			__METHOD__ );
		$sourceIds[] = $questionInfo['id'];

		# Options
		$insertBatch = array();
		foreach ( $questionInfo['options'] as $optionInfo ) {
			spInsertEntity( 'option', $optionInfo['id'] );
			$insertBatch[] = array(
				'op_entity' => $optionInfo['id'],
				'op_election' => $electionInfo['id'],
				'op_question' => $questionInfo['id']
			);
			$sourceIds[] = $optionInfo['id'];
		}
		$dbw->insert( 'securepoll_options', $insertBatch, __METHOD__ );
	}

	# Messages
	spInsertMessages( $store, $sourceIds );

	# Properties
	$properties = $store->getProperties( $sourceIds );
	$insertBatch = array();
	foreach ( $properties as $id => $entityProps ) {
		foreach ( $entityProps as $key => $value ) {
			$insertBatch[] = array(
				'pr_entity' => $id,
				'pr_key' => $key,
				'pr_value' => $value
			);
		}
	}
	if ( $insertBatch ) {
		$dbw->insert( 'securepoll_properties', $insertBatch, __METHOD__ );
	}
	return true;
}

function spInsertMessages( $store, $entityIds ) {
	$langs = $store->getLangList( $entityIds );
	$insertBatch = array();
	foreach ( $langs as $lang ) {
		$messages = $store->getMessages( $lang, $entityIds );
		foreach ( $messages as $id => $entityMsgs ) {
			foreach ( $entityMsgs as $key => $text ) {
				$insertBatch[] = array(
					'msg_entity' => $id,
					'msg_lang' => $lang,
					'msg_key' => $key,
					'msg_text' => $text
				);
			}
		}
	}
	if ( $insertBatch ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert( 'securepoll_msgs', $insertBatch, __METHOD__ );
	}
}

function spUpdateMessages( $store, $electionInfo ) {
	$entityIds = array( $electionInfo['id'] );
	foreach ( $electionInfo['questions'] as $questionInfo ) {
		$entityIds[] = $questionInfo['id'];
		foreach ( $questionInfo['options'] as $optionInfo ) {
			$entityIds[] = $optionInfo['id'];
		}
	}
	
	# Delete existing messages
	$dbw = wfGetDB( DB_MASTER );
	$dbw->delete( 'securepoll_msgs', array( 'msg_entity' => $entityIds ), __METHOD__ );

	# Insert new messages
	spInsertMessages( $store, $entityIds );
}

