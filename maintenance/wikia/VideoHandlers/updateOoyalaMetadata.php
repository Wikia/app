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
 * @return boolean
 */
function removeCustomMetadata( $video, $title, $removedField ) {
	global $skipped, $failed, $dryRun;

	$metadata = array( $removedField => null );
	if ( !array_key_exists( $removedField, $video['metadata'] ) ) {
		echo "\tSKIP: $title - $removedField not found in Custom Metadata.\n";
		$skipped++;
		return false;
	}

	if ( !empty( $video['metadata'][$removedField] ) ) {
		echo "\tSKIP: $title - $removedField field not empty in Custom Metadata. (value: {$video['metadata'][$removedField]}).\n";
		$skipped++;
		return false;
	}

	if ( !$dryRun ) {
		$resp = OoyalaAsset::updateMetadata( $video['embed_code'], $metadata );
		if ( !$resp ) {
			$failed++;
		}
	}

	return $resp;
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
 * @return boolean $changed - status of the metadata
 */
function changeMetadata( $video, $title, $metaKey, $metaFromValue, $metaToValue ) {
	global $skipped, $failed, $dryRun, $isList;

	$metadata = $video['metadata'];
	if ( !isset( $metadata[$metaKey] ) ) {
		echo "\tSKIP: $title - metadata key ($metaKey) not found.\n";
		$skipped++;
		return false;
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
		$metadata[$metaKey] = implode( ', ', array_filter( $metaValues ) );
		// for debugging
		//echo "\n\tNEW Metadata (".$video['embed_code']."):\n";
		//compareMetadata( $video['metadata'], $metadata );
		//echo "\n";

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

	return $changed;
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
		} elseif ( isset( $newMeta[$field] ) && !isset( $oldMeta[$field] ) ) {
			echo "\t\t[NEW] $field: $newMeta[$field]\n";
		} elseif ( strcasecmp( $oldMeta[$field], $newMeta[$field] ) == 0 ) {
			echo "\t\t$field: $newMeta[$field]\n";
		} else {
			echo "\t\t[UPDATED]$field: $newMeta[$field] (Old value: ".$oldMeta[$field].")\n";
		}
	}
}

/**
 * Update Metadata (VID-1716)
 * @global boolean $dryRun
 * @global integer $failed
 * @global integer $skipped
 * @param array $video
 * @return array|false $newValues
 */
function updateMetadata1716( $video ) {
	global $dryRun, $failed, $skipped;

	$newValues = false;
	if ( !empty( $video['metadata']['update1716'] ) ) {
		echo "\tSKIP: $video[name] (Id: $video[embed_code]) - Already updated.\n";
		$skipped++;

		return $newValues;
	}

	$newMetadata = $video['metadata'];

	// remove empty page categories
	$cntPageCategories = 0;
	if ( !empty( $video['metadata']['pagecategories'] ) ) {
		$patternPageCategories = [ '/,\s,/', '/,\s$/' ];
		$newMetadata['pagecategories'] = preg_replace( $patternPageCategories, '', $video['metadata']['pagecategories'], -1, $cntPageCategories );
	}

	// update expiration date
	if ( !empty( $video['time_restrictions']['end_date'] ) || !empty( $video['metadata']['expirationdate'] ) ) {
		$newMetadata['update1716'] = 1;
		if ( empty( $video['time_restrictions']['end_date'] ) ) {
			$newValues['expirationDate'] = '';
			$newMetadata['expirationdate'] = null;
		} else {
			$newValues['expirationDate'] = strtotime( $video['time_restrictions']['end_date'] );
			$newMetadata['expirationdate'] = date( 'Y-m-d', $newValues['expirationDate'] );
		}
	}

	// get regional restrictions
	if ( !empty( $video['metadata']['regional_restrictions'] ) ) {
		$newMetadata['update1716'] = 1;
		$newValues['regionalRestriction'] = strtoupper( $video['metadata']['regional_restrictions'] );
	}

	if ( $cntPageCategories > 0 || !empty( $newMetadata['update1716'] ) ) {
		// for debugging
		//echo "\n\tNEW Metadata (".$video['embed_code']."):\n";
		//compareMetadata( $video['metadata'], $newMetadata );
		//echo "\n";

		if ( !$dryRun ) {
			$resp = OoyalaAsset::updateMetadata( $video['embed_code'], $newMetadata );
			if ( !$resp ) {
				$newValues = false;
				$failed++;
			} else {
				echo "\tUPDATED: $video[name] (Id: $video[embed_code])...DONE.\n";
			}
		}
	} else {
		echo "\tSKIP: $video[name] (Id: $video[embed_code]) - No changes.\n";
		$skipped++;
	}

	return $newValues;
}

/**
 * Update metadata in Video wiki
 * @global int $failedWiki
 * @param string $videoId
 * @param array $newValues
 * @return boolean
 */
function updateMetadataVideoWiki( $videoId, $newValues ) {
	global $failedWiki;

	$resp = false;

	$asset = OoyalaAsset::getAssetById( $videoId );

	if ( $asset['asset_type'] == 'remote_asset' ) {
		$isRemoteAsset = true;
		$provider = $asset['metadata']['source'];
	} else {
		$isRemoteAsset = false;
		$provider = 'ooyala';
	}

	$duplicates = WikiaFileHelper::findVideoDuplicates( $provider, $asset['embed_code'], $isRemoteAsset );
	if ( count( $duplicates ) > 0 ) {
		$resp = updateMetadataWiki( $duplicates[0], $newValues );
	} else {
		echo "\tError: VideoId: $videoId - FILE not found.\n";
		$failedWiki++;
	}

	return $resp;
}

/**
 * Update metadata in the wiki
 * @global boolean $dryRun
 * @global int $failedWiki
 * @global int $skippedWiki
 * @param array $video
 * @param array $newValues
 * @return boolean
 */
function updateMetadataWiki( $video, $newValues ) {
	global $dryRun, $failedWiki, $skippedWiki;

	$name = $video['img_name'];
	echo "Updated (Wiki): $name";

	$title = Title::newFromText( $name, NS_FILE );
	if ( !$title instanceof Title ) {
		$failedWiki++;
		echo "...FAILED. (Error: Title NOT found)\n";
		return false;
	}

	$file = wfFindFile( $title );
	if ( empty( $file ) ) {
		$failedWiki++;
		echo "...FAILED. (Error: File NOT found)\n";
		return false;
	}

	$metadata = unserialize( $video['img_metadata'] );
	if ( !$metadata ) {
		$failedWiki++;
		echo "...FAILED. (Error: Cannot unserialized metadata)\n";
		return false;
	}

	// check for videoId
	if ( empty( $metadata['videoId'] ) ) {
		$skippedWiki++;
		echo "...SKIPPED. (empty videoId in metadata).\n";
		return false;
	}

	// check for title
	if ( empty( $metadata['title'] ) ) {
		$skippedWiki++;
		echo "...SKIPPED. (empty title in metadata).\n";
		return false;
	}

	if ( !isset( $metadata['canEmbed'] ) ) {
		$skippedWiki++;
		echo "...SKIPPED. (canEmbed field NOT found in metadata).\n";
		return false;
	}

	// update metadata
	$newMetadata = array_merge( $metadata, $newValues );

	// for debugging
	//echo "\n\tNEW Metadata (WIKI):\n";
	//compareMetadata( $metadata, $newMetadata );
	//echo "\n";

	if ( !$dryRun ) {
		$serializedMeta = serialize( $newMetadata );

		if ( wfReadOnly() ) {
			die( "Read only mode.\n" );
		}

		$dbw = wfGetDB( DB_MASTER );

		$dbw->begin();

		// update database
		$dbw->update(
			'image',
			array( 'img_metadata' => $serializedMeta ),
			array( 'img_name' => $name ),
			__METHOD__
		);

		$dbw->commit();

		// clear cache
		$file->purgeEverything();
	}

	echo "...DONE.\n";

	return true;
}

// ----------------------------- Main ------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../" );
ini_set( 'display_errors', 1 );

require_once( "commandLine.inc" );

if ( isset( $options['help'] ) ) {
	die( "Usage: php updateOoyalaMetadata.php [--help] [--age=123] [--dry-run] [--player=xyz] [extra=abc] [--remove=age_required] [--update=metakey] [--from=abc] [to=def]
	--age              set age_required value in metadata
	--player           set player id
	--remove           remove field from custom metadata (only if the field is empty)
	--extra            extra conditions to get video assets from ooyala (use ' AND ' to separate each condition)
	--update           update metadata (will required --from and --to options)
	--from             metadata value that will be updated from (required for --update option)
	--to               metadata value that will be updated to (required for --update option)
	--list             set if the metadata value is a list (used with --update option, optional)
	--videoWiki        update metadata in video wiki if the metadata in backlot is changed
	--update1716       update pageCategories, regional restrictions and expiration date
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
$videoWiki = isset( $options['videoWiki'] );
$update1716 = isset( $options['update1716'] );

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
$failedWiki = 0;
$skippedWiki = 0;

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
		$newValues = false;
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

		if ( !empty( $update1716 ) ) {
			$newValues = updateMetadata1716( $video );
		}

		if ( !empty( $videoWiki ) ) {
			if ( empty( $newValues ) ) {
				$skippedWiki++;
				echo "\tSKIP (WIKI): $video[name] (Id: $video[embed_code]) - No changes.\n";
			} else {
				updateMetadataVideoWiki( $video['embed_code'], $newValues );
			}
		}
	}

	$page++;
} while ( !empty( $nextPage ) && $total < $limit );

echo "\nTotal videos: ".$total.", Success: ".( $total - $failed - $skipped ).", Failed: $failed, Skipped: $skipped\n\n";

if ( !empty( $videoWiki ) ) {
echo "Updated in Wiki: Total videos: ".$total.", Success: ".( $total - $failedWiki - $skippedWiki ).", Failed: $failedWiki, Skipped: $skippedWiki\n\n";
}
