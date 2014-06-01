<?php

/**
* Maintenance script to add, remove, replace page category on file page (video only)
* This is one time use script
* @author Saipetch Kongkatong
*/

function getCategoryTag( $catgory ) {
	$cat = F::app()->wg->ContLang->getFormattedNsText( NS_CATEGORY );
	return '[['.ucfirst($cat).':'.$catgory.']]';
}

function addCategories( $content, $categories ) {
	foreach ( $categories as $category ) {
		$categoryTag = getCategoryTag( $category );
	if ( stristr( $content, $categoryTag ) === false ) {
			$content .= $categoryTag;
		}
	}

	return $content;
}

function removeCategories( $content, $categories ) {
	foreach ( $categories as $category ) {
		$categoryTag = getCategoryTag( $category );
		$content = str_ireplace( $categoryTag, '',$content );
	}

	return $content;
}

// ----------------------------- Main ------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../" );

require_once( "commandLine.inc" );

if ( isset($options['help']) ) {
	die( "Usage: php addPageCategory.php [--help] [--dry-run] [--provider=xyz] [--limit=123] [--add=abc] [--addPageCategories] [--remove=def] [--replace] [--old=def] [--new=abc] [--name=wxy]
	--dry-run                   dry run
	--provider                  provider name
	--limit                     limit number of videos
	--add                       add page category (seperate by semicolon)
	--addPageCategories         add page category using category from pageCategories field in metadata to pages that have pageCategories field
	--remove                    remove page category (seperate by semicolon)
	--replace                   replace page category
	--old                       old page category (for 'replace' only [required]) - case sensitive
	--new                       new page category (for 'replace' only [required])
	--name                      name of the file page
	--help                      you are reading it right now\n\n" );
}

if ( empty($wgCityId) ) {
	die( "Error: Invalid wiki id.\n" );
}

$dryRun = isset( $options['dry-run'] );

// provider
$provider = isset( $options['provider'] ) ? $options['provider'] : '';
if ( empty( $provider ) ) {
	die( "Error: Invalid provider.\n" );
}

// limit
$limit = isset( $options['limit'] ) ? $options['limit'] : 0;
if ( !is_numeric( $limit ) ) {
	die( "Error: Invalid limit.\n" );
}

// page name
$name = isset( $options['name'] ) ? $options['name'] : '';

// using pageCategories field in metadata
$addPageCategories = isset( $options['addPageCategories'] );

// categories to be added
if ( !empty( $options['add'] ) && $options['add'] != 1 ) {
	$addCategories = array_map( 'trim', explode( ';', $options['add'] ) );
} else {
	$addCategories = array();
}

// categories to be removed
if ( !empty( $options['remove'] ) && $options['remove'] != 1 ) {
	$removeCategories = array_map( 'trim', explode( ';', $options['remove'] ) );
} else {
	$removeCategories = array();
}

// replace
$replace = isset( $options['replace'] );
$old = empty( $options['old'] ) ? '' : $options['old'];
$new = empty( $options['new'] ) ? '' : $options['new'];
if ( $replace && ( empty( $old ) || empty( $new ) ) ) {
	die( "Error: Invalid category. Please enter 'old' and 'new' categories.\n" );
}

echo "Wiki: $wgCityId ($wgDBname)\n";

if ( !empty( $addCategories ) ) {
	echo "ADD Categories: ".implode( ', ', $addCategories )."\n";
}

if ( !empty( $removeCategories ) ) {
	echo "REMOVE Categories: ".implode( ', ', $removeCategories )."\n";
}

if ( $replace ) {
	echo "REPLACE Categories: $old with $new\n";
}

$botUser = User::newFromName( 'WikiaBot' );

$db = wfGetDB( DB_SLAVE );

$sqlWhere = array(
	'img_media_type' => 'VIDEO',
	'img_minor_mime' => $provider,

);

if ( $addPageCategories ) {
	$sqlWhere[] = "img_metadata like '%\"pageCategories%\"'";
}

if ( $replace ) {
	$sqlWhere[] = "exists ( select 1 from page left join categorylinks on page_id = cl_from where cl_to = ".$db->addQuotes( $old )." and page_namespace = ".NS_FILE." and page_title = img_name )";
}

if ( !empty( $name ) ) {
	$sqlWhere[] = "img_name >= ".$db->addQuotes( $name );
}

$result = $db->select(
	array( 'image' ),
	array( 'img_name', 'img_metadata' ),
	$sqlWhere,
	__METHOD__,
	array( 'LIMIT' => $limit, 'ORDER BY' => 'img_name' )
);

$total = $result->numRows();
$success = 0;
$noChanges = 0;
$counter = 0;
while ( $row = $db->fetchObject( $result ) ) {
	$counter++;
	$content = '';
	$name = $row->img_name;

	// use categories from pageCategories field in metadata
	if ( $addPageCategories ) {
		$metadata = serialize( $row->img_metadata );
		if ( !empty( $metadata['pageCategories'] ) ) {
			$addCategories = array_map( 'trim', explode( ',', $metadata['pageCategories'] ) );
		}
	}

	if ( $replace ) {
		$addCategories = array( $new );
		$removeCategories = array( $old );
	}

	echo "\t[$counter of $total] Title:".$name;
	$title = Title::newFromText( $name, NS_FILE );
	if ( $title instanceof Title && $title->exists() ) {
		$article = Article::newFromID( $title->getArticleID() );
		$oldContent = $article->getContent();

		// set default value
		$msg = array();
		$content = $oldContent;
		$status = Status::newGood();

		//remove category
		if ( !empty( $removeCategories ) ) {
			$content = removeCategories( $content, $removeCategories );
			$msg[] = 'Removed: '.implode( ', ', $removeCategories );
		}

		// add category
		if ( !empty( $addCategories ) ) {
			$content = addCategories( $content, $addCategories );
			$msg[] = 'Added: '.implode( ', ', $addCategories );
		}

		// edit page
		if ( strcmp( $oldContent, $content ) !== 0 ) {
			if ( !$dryRun ) {
				$status = $article->doEdit( $content, 'Changing categories', EDIT_UPDATE | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT, false, $botUser );
			}
		} else {
			$noChanges++;
			$status = null;
			echo "...FAILED (no category changes).\n";
		}

		if ( $status instanceof Status ) {
			if ( $status->isOK() ) {
				$success++;
				echo "...DONE (".  implode( ', ', $msg ).").\n";
			} else {
				echo "...FAILED (".$status->getMessage().").\n";
			}
		}
	} else {
		echo "...FAILED (Title not found).\n";
	}
}

echo "Total Videos: $total, Success: $success, Failed: ".( $total - $success )." (No category changes: $noChanges)\n\n";