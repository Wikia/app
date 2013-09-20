<?php

/**
* Maintenance script to get video global usages by provider and export to csv file
* @author Saipetch Kongkatong
*/

/**
 * write data to file (csv)
 * @global boolean $export
 * @global file pointer $fp
 * @param array $data
 */
function writeToFile( $data ) {
	global $export, $fp;

	if ( $export ) {
		fputcsv( $fp, $data );
	}
}

/**
 * print text if not in quiet mode
 * @global type $quiet
 * @param type $text
 */
function printText( $text ) {
	global $quiet;

	if ( !$quiet ) {
		echo $text;
	}
}

// ----------------------------- Main ------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../" );
ini_set( "display_errors", 1 );

require_once( "commandLine.inc" );

if ( isset($options['help']) ) {
	die( "Usage: php getVideoGlobalUsage.php [--help] [--provider=xyz] [--export] [--keyword=xyz]
	--provider               provider name (required)
	--export                 export to csv file (path = /tmp/video_globalusage_<provider>.csv)
	--keyword                keyword in video title (lowercase)
	--quiet                  show summary result only
	--help                   you are reading it right now\n\n" );
}

$provider = isset( $options['provider'] ) ? $options['provider'] : '';
$export = isset( $options['export'] );
$quiet = isset( $options['quiet'] );
$keyword = isset( $options['keyword'] ) ? $options['keyword'] : '';

if ( empty( $wgCityId ) ) {
	die( "Error: Invalid wiki id.\n" );
}

echo "Wiki: $wgCityId\n";

if ( empty( $provider ) ) {
	die( "Error: Invalid provider.\n" );
}

echo "Provider: $provider\n";

if ( $export ) {
	$filename = '/tmp/video_globalusage_'.$provider.'.csv';
	$fp = fopen( $filename, 'w' );

	echo "Export to file: $filename\n";
}

$header = array ( 'Title', 'Video Embedded Url' );
writeToFile( $header );

$limit = 1000;
$total = 1;
$totalEmbed = 0;
$lastTitle = '';

$db = wfGetDB( DB_SLAVE );

$conds = array(
	'img_media_type' => 'VIDEO',
	'img_minor_mime' => $provider,
);

if ( !empty( $keyword ) ) {
	$conds[] = 'lower(img_name) '.$db->buildLike( $keyword, $db->anyString() );
}

do {
	$conds[] = 'img_name > '.$db->addQuotes( $lastTitle );
	$result = $db->select(
		array( 'image' ),
		array( '*' ),
		$conds,
		__METHOD__,
		array( 'LIMIT' => $limit )
	);

	$cnt = 1;
	$subTotal = $result->numRows();

	while ( $row = $db->fetchRow( $result ) ) {
		$videoTitle = $row['img_name'];
		echo "\n[Total: $total ($cnt of $subTotal)] Video: $videoTitle\n";

		// add URLs of pages where they are embedded for each video title
		$query = new GlobalUsageQuery( $videoTitle );
		$query->execute();
		$globalUsages = $query->getSingleImageResult();

		if ( empty( $globalUsages ) ) {
			$video = array( $videoTitle, '' );
			writeToFile( $video );
		} else {
			foreach( $globalUsages as $wiki => $articles ) {
				echo "\tGlobalUsages: Wiki: $wiki\n";
				foreach ( $articles as $article ) {
					echo "\t\tArticle: Namespace:$article[namespace], Name:$article[title]\n";
					$url = rtrim( WikiFactory::DBtoURL( $article['wiki'] ), '/' );
					$title = Title::newFromText( $article['title'], $article['namespace_id']);
					if ( $title instanceof Title ) {
						$url .= $title->getLocalURL();
						echo "\t\t\tURL: $url\n";
					}
					$video = array( $videoTitle, $url );
					writeToFile( $video );

					$totalEmbed++;
				}
			}
		}

		$lastTitle = $row['img_name'];

		$cnt++;
		$total++;
	}
	array_pop( $conds );
} while ( $subTotal );

$db->freeResult( $result );

if ( $export ) {
	fclose( $fp );
}

echo "\nWiki: $wgCityId, Provider: $provider, ";
if ( !empty( $keyword ) ) {
	echo "Keyword: $keyword, ";
}
echo "Total Videos: ".( $total - 1 ).", Total Embed: $totalEmbed.\n\n";
