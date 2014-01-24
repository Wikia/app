<?php

/**
* Maintenance script to update Metadata for Ooyala
* This is one time use script
* @author Saipetch Kongkatong
*/

/**
 * remove field from Custom Metadata if the field is empty
 * @global integer $skipped
 * @global integer $failed
 * @global boolean $dryRun
 * @param array $video
 * @param string $title
 * @param string $removedField
 * @return type
 */
function removeCustomMetadata( $video, $title, $removedField ) {
	global $skipped, $failed, $dryRun;

	$metadata = array( $removedField => null );
	if ( !array_key_exists( $removedField, $video['metadata'] ) ) {
		echo "\tSKIP: $title - $removedField not found in Custom Metadata.\n";
		$skipped++;
		return;
	}

	if ( !empty( $video['metadata'][$removedField] ) ) {
		echo "\tSKIP: $title - $removedField field not empty in Custom Metadata. (value: {$video['metadata'][$removedField]}).\n";
		$skipped++;
		return;
	}

	if ( !$dryRun ) {
		$resp = OoyalaAsset::updateMetadata( $video['embed_code'], $metadata );
		if ( !$resp ) {
			$failed++;
		}
	}

	return;
}

/**
 * add age_required field to Custom Metadata
 * @global integer $skipped
 * @global integer $failed
 * @global boolean $dryRun
 * @param array $video
 * @param string $title
 * @param integer $ageRequired
 * @return type
 */
function addAgeRequired( $video, $title, $ageRequired ) {
	global $skipped, $failed, $dryRun;

	$metadata = array( 'age_required' => $ageRequired );

	if ( empty( $video['metadata']['agegate'] ) ) {
		echo "\tSKIP: $title - agegate not found in Custom Metadata.\n";
		$skipped++;
		return;
	}

	if ( !empty( $video['metadata']['age_required'] ) ) {
		echo "\tSKIP: $title - age_required is set in Custom Metadata (age_required: {$video['metadata']['age_required']}).\n";
		$skipped++;
		return;
	}

	if ( !$dryRun ) {
		$resp = OoyalaAsset::updateMetadata( $video['embed_code'], $metadata );
		if ( !$resp ) {
			$failed++;
		}
	}

	return;
}

/**
 * set player id
 * @global integer $skipped
 * @global integer $failed
 * @global boolean $dryRun
 * @param array $video
 * @param string $title
 * @param string $playerId
 * @return type
 */
function setPlayerId( $video, $title, $playerId ) {
	global $skipped, $failed, $dryRun;

	$ooyala = new OoyalaAsset();
	$player = $ooyala->getPlayer( $video['embed_code'] );
	if ( $player == false ) {
		$failed++;
		return;
	}

	echo "\tPlayer: $player[name] (ID: $player[id]).\n";
	if ( $player['id'] == $playerId ) {
		echo "\tSKIP: $title already uses the same player.\n";
		$skipped++;
		return;
	}

	if ( !$dryRun ) {
		$resp = $ooyala->setPlayer( $video['embed_code'], $playerId );
		if ( !$resp ) {
			$failed++;
		}
	}

	return;
}

/**
 * Update Metadata
 * @global integer $skipped
 * @global integer $failed
 * @global boolean $dryRun
 * @global boolean $isList
 * @param array $video
 * @param string $title
 * @param string $metaKey
 * @param string $metaFromValue
 * @param string $metaToValue
 */
function changeMetadata( $video, $title, $metaKey, $metaFromValue, $metaToValue ) {
	global $skipped, $failed, $dryRun, $isList;

	$metadata = $video['metadata'];
	if ( !isset( $metadata[$metaKey] ) ) {
		echo "\tSKIP: $title - metadata key ($metaKey) not found.\n";
		$skipped++;
		return;
	}

	if ( $isList ) {
		$metaValues = array_map( 'trim', explode( ',', $metadata[$metaKey] ) );
	} else {
		$metaValues = array( $metadata[$metaKey] );
	}

	$changed = false;
	foreach ( $metaValues as &$value ) {
		if ( strtolower( $value ) == $metaFromValue ) {
			$changed = true;
			$value = $metaToValue;
		}
	}

	if ( $changed ) {
		$metadata[$metaKey] = implode( ', ', $metaValues );
		/* for debuging
		echo "\n\tNEW Metadata (".$video['embed_code']."):\n";
		compareMetadata( $video['metadata'], $metadata );
		echo "\n";
		*/

		if ( !$dryRun ) {
			$resp = OoyalaAsset::updateMetadata( $video['embed_code'], $metadata );
			if ( !$resp ) {
				$failed++;
			}
		}
	} else {
		echo "\tSKIP: $title - value not equal to '$metaFromValue' ($metaKey: ".$metadata[$metaKey].").\n";
		$skipped++;
	}

	return;
}

/**
 * Compare metadata
 * @param array $oldMeta
 * @param array $newMeta
 */
function compareMetadata( $oldMeta, $newMeta ) {
	$fields = array_unique( array_merge( array_keys( $newMeta ), array_keys( $oldMeta ) ) );
	foreach ( $fields as $field ) {
		if ( ( !isset( $newMeta[$field] ) || is_null( $newMeta[$field] ) ) && isset( $oldMeta[$field] ) ) {
			echo "\t\t[DELETED] $field: ".$oldMeta[$field]."\n";
		} else if ( isset( $newMeta[$field] ) && !isset( $oldMeta[$field] ) ) {
			echo "\t\t[NEW] $field: $newMeta[$field]\n";
		} else if ( strcasecmp( $oldMeta[$field], $newMeta[$field] ) == 0 ) {
			echo "\t\t$field: $newMeta[$field]\n";
		} else {
			echo "\t\t[UPDATED]$field: $newMeta[$field] (Old value: ".$oldMeta[$field].")\n";
		}
	}
}

// ----------------------------- Main ------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../" );
ini_set( 'display_errors', 1 );

require_once( "commandLine.inc" );

if ( isset( $options['help'] ) ) {
	die( "Usage: php maintenance.php [--help] [--age=123] [--dry-run] [--player=xyz] [extra=abc] [--remove=age_required] [--update=metakey] [--from=abc] [to=def]
	--age              set age_required value in metadata
	--player           set player id
	--remove           remove field from custom metadata (only if the field is empty)
	--extra            extra conditions to get video assets from ooyala (use ' AND ' to separate each condition)
	--change           update metadata (will required --from and --to options)
	--from             metadata value that will be updated from (required for --update option)
	--to               metadata value that will be updated to (required for --update option)
	--list             set if the metadata value is a list (used with --change option)
	--limit            limit
	--dry-run          dry run
	--help             you are reading it right now\n\n" );
}

$dryRun = isset( $options['dry-run'] );
$ageRequired = isset( $options['age'] ) ? $options['age'] : 0;
$playerId = isset( $options['player'] ) ? $options['player'] : '';
$extra = isset( $options['extra'] ) ? explode( ' AND ', $options['extra'] ) : array();
$remove = isset( $options['remove'] ) ? $options['remove'] : '';
$update = isset( $options['update'] ) ? $options['update'] : '';
$from = isset( $options['from'] ) ? $options['from'] : '';
$to = isset( $options['to'] ) ? $options['to'] : '';
$limit = empty( $options['limit'] ) ? '' : $options['limit'];
$isList = isset( $options['list'] );

if ( !is_numeric( $ageRequired ) ) {
	die( "Invalid age.\n" );
}

if ( !empty( $update ) && ( !isset( $options['from'] ) || !isset( $options['to'] ) ) ) {
	die( "--from and --to options are required.\n" );
}

$apiPageSize = 100;
if ( !empty( $limit ) && $limit < $apiPageSize ) {
	$apiPageSize = $limit;
}

$nextPage = '';
$page = 1;
$total = 0;
$failed = 0;
$skipped = 0;

// set condition to get age gated videos
if ( !empty( $ageRequired ) ) {
	$extra[] = "labels INCLUDES 'Age gated'";
}

if ( !empty( $update ) ) {
	$extra[] = "metadata.$update = '$from'";
}

do {
	// connect to provider API
	$url = OoyalaAsset::getApiUrlAssets( $apiPageSize, $nextPage, $extra );
	echo "\nConnecting to $url...\n" ;

	$response = OoyalaAsset::getApiContent( $url );
	if ( $response === false ) {
		exit();
	}

	$videos = empty( $response['items'] ) ? array() : $response['items'] ;
	$nextPage = empty( $response['next_page'] ) ? '' : $response['next_page'] ;

	$total += count( $videos );

	$cnt = 0;
	foreach ( $videos as $video ) {
		$cnt++;
		$title = trim( $video['name'] );
		echo "[Page $page: $cnt of $total] Video: $title ({$video['embed_code']})\n";
		echo "\tMetadata for {$video['embed_code']}: \n";
		foreach( explode( "\n", var_export( $video['metadata'], TRUE ) ) as $line ) {
			echo "\t\t:: $line\n";
		}

		if ( !empty( $ageRequired ) ) {
			addAgeRequired( $video, $title, $ageRequired );
		}

		if ( !empty( $playerId ) ) {
			setPlayerId( $video, $title, $playerId );
		}

		if ( !empty( $remove ) ) {
			removeCustomMetadata( $video, $title, $remove );
		}

		if ( !empty( $update ) ) {
			changeMetadata( $video, $title, $update, $from, $to );
		}
	}

	$page++;
} while ( !empty( $nextPage ) && $total < $limit );

echo "\nTotal videos: ".$total.", Success: ".( $total - $failed - $skipped ).", Failed: $failed, Skipped: $skipped\n\n";
