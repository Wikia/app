<?php
/**
 * <videogallerypopulate> parser hook extension -- display a gallery of all
 * videos in a specific category
 *
 * @file
 * @ingroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

$wgHooks['ParserFirstCallInit'][] = 'wfVideoGalleryPopulate';

function wfVideoGalleryPopulate( $parser ) {
	$parser->setHook( 'videogallerypopulate', 'VideoGalleryPopulate' );
	return true;
}

function VideoGalleryPopulate( $input, $args, $parser ) {
	$parser->disableCache();

	$category = ( isset( $args['category'] ) ) ? $args['category'] : '';
	$limit = ( isset( $args['limit'] ) ) ? intval( $args['limit'] ) : 10;

	if( empty( $category ) ) {
		return '';
	}

	// Use Parser::recursivePreprocess() if available instead of creating another Parser instance
	if ( is_callable( array( $parser, 'recursivePreprocess' ) ) ) {
		$category = $parser->recursivePreprocess( $category );
	} else {
		$newParser = new Parser();
		$category = $newParser->preprocess( $category, $parser->getTitle(), $parser->getOptions() );
	}
	$category_title = Title::newFromText( $category );
	if( !( $category_title instanceof Title ) ) {
		return '';
	}

	// @todo FIXME: not overly i18n-friendly here...
	$category_title_secondary = Title::newFromText( $category . ' Videos' );
	if( !( $category_title_secondary instanceof Title ) ) {
		return '';
	}

	$params['ORDER BY'] = 'page_id';
	if( $limit ) {
		$params['LIMIT'] = $limit;
	}

	$dbr = wfGetDB( DB_SLAVE );
	$res = $dbr->select(
		array( 'page', 'categorylinks' ),
		'page_title',
		array(
			'cl_to' => array(
				$category_title->getDBkey(),
				$category_title_secondary->getDBkey()
			),
			'page_namespace' => NS_VIDEO
		),
		__METHOD__,
		$params,
		array( 'categorylinks' => array( 'INNER JOIN', 'cl_from = page_id' ) )
	);

	$gallery = new VideoGallery();
	$gallery->setParsing( true );
	$gallery->setShowFilename( true );

	foreach ( $res as $row ) {
		$video = Video::newFromName( $row->page_title, RequestContext::getMain() );
		$gallery->add( $video );
	}

	return $gallery->toHtml();
}
