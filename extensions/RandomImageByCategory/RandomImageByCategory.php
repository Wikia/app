<?php
/**
 * RandomImageByCategory extension
 * Usage example: <randomimagebycategory width="200" categories="Featured Image"/>
 * Supported parameters: width, limit, categories
 *
 * @file
 * @ingroup Extensions
 * @author Aaron Wright <aaron.wright@gmail.com>
 * @author David Pean <david.pean@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @version 1.0
 * @link http://www.mediawiki.org/wiki/Extension:RandomImageByCategory Documentation
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "Not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'RandomImageByCategory',
	'version' => '1.0',
	'author' => array( 'Aaron Wright', 'David Pean', 'Jack Phoenix' ),
	'description' => 'Displays a random image from a given category',
	'url' => 'https://www.mediawiki.org/wiki/Extension:RandomImageByCategory',
);

$wgHooks['ParserFirstCallInit'][] = 'wfRandomImageByCategory';

function wfRandomImageByCategory( &$parser ) {
	$parser->setHook( 'randomimagebycategory', 'getRandomImage' );
	return true;
}

function getRandomImage( $input, $args, $parser ) {
	global $wgMemc;

	wfProfileIn( __METHOD__ );

	$parser->disableCache();

	$categories = ( isset( $args['categories'] ) ) ? trim( $args['categories'] ) : '';

	if ( isset( $args['limit'] ) && is_numeric( $args['limit'] ) ) {
		$limit = $args['limit'];
	} else {
		$limit = 10;
	}

	if ( isset( $args['width'] ) && is_numeric( $args['width'] ) ) {
		$width = $args['width'];
	} else {
		$width = 200;
	}

	$key = wfMemcKey( 'image', 'random', $limit, str_replace( ' ', '', $categories ) );
	$data = $wgMemc->get( $key );
	$image_list = array();
	if( !$data ) {
		wfDebug( "Getting random image list from DB\n" );
		$ctg = $parser->replaceVariables( $categories );
		$ctg = $parser->mStripState->unstripBoth( $ctg );
		$ctg = str_replace( "\,", '#comma#', $ctg );
		$aCat = explode( ',', $ctg );

		$category_match = array();
		foreach( $aCat as $sCat ) {
			if( $sCat != '' ) {
				$category_match[] = Title::newFromText( trim( str_replace( '#comma#', ',', $sCat ) ) )->getDBkey();
			}
		}

		if( count( $category_match ) == 0 ) {
			return '';
		}

		$params['ORDER BY'] = 'page_id';
		if( !empty( $limit ) ) {
			$params['LIMIT'] = $limit;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'page', 'categorylinks' ),
			array( 'page_title' ),
			array( 'cl_to' => $category_match, 'page_namespace' => NS_FILE ),
			__METHOD__,
			$params,
			array( 'categorylinks' => array( 'INNER JOIN', 'cl_from=page_id' ) )
		);
		$image_list = array();
		foreach ( $res as $row ) {
			$image_list[] = $row->page_title;
		}
		$wgMemc->set( $key, $image_list, 60 * 15 );
	} else {
		$image_list = $data;
		wfDebug( "Cache hit for random image list\n" );
	}

	$random_image = '';
	$thumbnail = '';
	if( count( $image_list ) > 1 ) {
		$random_image = $image_list[ array_rand( $image_list, 1 ) ];
	}

	if( $random_image ) {
		$image_title = Title::makeTitle( NS_FILE, $random_image );
		$render_image = wfFindFile( $random_image );

		$thumb_image = $render_image->transform( array( 'width' => $width ) );
		$thumbnail = "<a href=\"{$image_title->escapeFullURL()}\">{$thumb_image->toHtml()}</a>";
	}

	wfProfileOut( __METHOD__ );

	return $thumbnail;
}
