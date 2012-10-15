<?php
/**
 * FolkTagCloud
 * @author Katharina Wäschle
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is an extension to the MediaWiki package and cannot be run standalone.' );
}

define( 'FolkTagCloud_VERSION', '1.2 alpha' );

# credits
$wgExtensionCredits['parserhook'][] = array (
	'name' => 'FolkTagCloud',
	'path' => __FILE__,
	'url' => 'https://www.mediawiki.org/wiki/Extension:FolkTagCloud',
	'version' => FolkTagCloud_VERSION,
	'author' => 'Katharina Wäschle',
	'descriptionmsg' => 'folktagcloud-desc'
);

$wgExtensionMessagesFiles['FolkTagCloud'] = dirname( __FILE__ ) . '/FolkTagCloud.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'registerFolkTagCloudExtension';
$wgHooks['smwInitProperties'][] = 'initFolkTagProperty';

# registering extension
function registerFolkTagCloudExtension( $parser ) {
	$parser->setHook( 'folktagcloud', 'renderFolkTagCloud' );
	return true;
}

# initialising predefined property 'FolkTag'
function initFolkTagProperty() {
	SMWPropertyValue::registerProperty( '_FT_TAG', '_str', 'FolkTag', true );
	return true;
}

# user defined sort function
function compareLowercase( $x, $y )
{
	if ( strtolower( $x ) == strtolower( $y ) )
		return 0;
	elseif ( strtolower( $x ) < strtolower( $y ) )
		return -1;
	else
		return 1;
}

# parser function
function renderFolkTagCloud( $input, $args, $parser ) {
	# definition of variables
	$append = '';
	$count = 0;
	$max_tags = 1000;
	$min_count = 1;
	$increase_factor = 100;
	$min_font_size = 77;
	$font_size = 0;
	$htmlout = '';

	# disable cache
	$parser->disableCache();

	# not needed with searchlink data
	# build URL path
	# global $wgServer, $wgArticlePath;
	# $path = $wgServer . $wgArticlePath;

	# default tagging property
	$tag_name = 'FolkTag';

	# use a user-defined tagging property as default
	global $wgFTCTagName;
	if ( isset( $wgFTCTagName ) ) {
		$tag_name = $wgFTCTagName;
	}

	# use a user-defined tagging property for this tag cloud
	if ( isset( $args['property'] ) ) {
		$tag_name = str_replace( ' ', '_', ucfirst( $args['property'] ) );
	}

	# maximum of tags shown
	if ( isset( $args['maxtags'] ) ) {
		$max_tags = intval( $args['maxtags'] );
	}

	# minimum frequency for tags to be shown
	if ( isset( $args['mincount'] ) ) {
		$min_count = intval( $args['mincount'] );
	}

	# increase factor
	if ( isset( $args['increasefactor'] ) ) {
		$increase_factor = intval( $args['increasefactor'] );
	}

	# minimum font size
	if ( isset( $args['minfontsize'] ) ) {
		$min_font_size = intval( $args['minfontsize'] );
	}

	# get database
	$db = &wfGetDB( DB_SLAVE );
	$store = new SMWSQLStore2;
	extract( $db->tableNames( 'categorylinks', 'page' ) );

	# make tagging property an SMWPorpertyValue in order to access store
	$property = SMWPropertyValue::makeProperty( $tag_name );

	# initialising result arrays
	$values = array();
	$result = array();
	$links = array();

	# if there is no filter category:
	if ( $input == NULL ) {
		$values = ft_getPropertyValues( $property, $store );
		# $values = $store->getPropertyValues(NULL, $property);
	}
	# if there are one or more filter catgories:
	else {
		$categories = explode( ',', $input );

		# include subcategories:
		if ( isset( $args['subcategorylevel'] ) ) {
			$subcategories = array();
			foreach ( $categories as $category ) {
				$subcategories = array_merge( $subcategories,
				getSubCategories( $category, intval( $args['subcategorylevel'] ) ) );
			}
			$categories = array_merge( $categories, $subcategories );
		}

		# start building sql
		$sql = "SELECT page_title, page_namespace
				FROM $page
				INNER JOIN $categorylinks
				ON $page.page_id = $categorylinks.cl_from
				AND (";

		# disjunction of filter categories
		foreach ( $categories as $category ) {
			$category = trim( $category );
			$category = str_replace( ' ', '_', $category );
			$category = str_replace( "'", "\'", $category );

			$sql .= "$categorylinks.cl_to = '$category' OR ";
		}

		# remainder of sql (FALSE is required to absorb the last OR)
		$sql .= "FALSE) GROUP BY page_title";
		# query
		$res = $db->query( $sql );

		# parsing result of sql query: get name and namespace of pages placed in the
		# filter categories and look up all values of the given property for each page
		for ( $i = 0; $i < $db->numRows( $res ); $i++ ) {
			$row = $db->fetchObject( $res );
			$pagename = $row->page_title;
			$namespace = $row->page_namespace;
			$values = array_merge( $values,
				$store->getPropertyValues( SMWWikiPageValue::makePage( $pagename,
					$namespace ), $property ) );
		}

		$db->freeResult( $res );
	}


	# counting frequencies
	foreach ( $values as $value ) {
		# get surface form of property value
		$tag = $value->getShortHTMLText();
		# get Searchlink data for property and current property value
		$link = SMWInfolink::newPropertySearchLink( $tag,
			$tag_name, $tag )->getHTML();
		if ( array_key_exists( $tag, $result ) ) {
			$result[$tag] += 1;
		}
		else {
			$result[$tag] = 1;
			$links[$tag] = $link;
		}
	}

	# sorting results
	arsort( $result );

	# if too many tags are found, remove rear part of result array
	if ( count( $result ) > $max_tags ) {
		$result = array_slice( $result, 0, $max_tags, true );
	}

	# get minimum and maximum frequency for computing font sizes
	$min = end( $result ) or $min = 0;
	$max = reset( $result ) or $max = 1;

	if ( $max == $min ) { $max += 1; }

	# sorting results by frequency
	if ( isset( $args['order'] ) ) {
		if ( $args['order'] != "frequency" ) {
			# ksort($result, SORT_STRING);
			uksort( $result, 'compareLowercase' );
		}
	}
	else { uksort( $result, 'compareLowercase' ); } ;

	# start building html output
	$htmlOut = $htmlOut . "<div align=justify>";

	foreach ( $result as $label => $count ) {
		if ( $count >= $min_count ) {
			if ( isset( $args['increase'] ) ) {
				# computing font size (logarithmic)
				if ( $args[increase] = 'log' ) {
					$font_size = $min_font_size +
						$increase_factor *
						( log( $count ) -log( $min ) ) / ( log( $max ) -log( $min ) );
				}
				# computing font size (linear)
				else { $font_size = $min_font_size +
					$increase_factor * ( $count -$min ) / ( $max -$min ); }
			}
			else { $font_size = $min_font_size +
				$increase_factor * ( $count -$min ) / ( $max -$min ); }
			$style = "font-size: $font_size%;";
			# link to special page search by property with parameters
			# property=tagging property and value=current tag

			# find URL in searchlink data
			$matches = array();
			preg_match( '/href="(.)*"/U', $links[$label], $matches );
			$url = $matches[0];
			# include freqency in brackets in output
			if ( $args['count'] ) {
				$append = " ($count)";
			}
			# appending tag
			$currentRow = "<a style=\"{$style}\" {$url}>" . $label . $append .
				"</a>&#160; ";
			$htmlOut = $htmlOut . $currentRow;
		}
	}

	$htmlOut = $htmlOut . "</div>";
	return $htmlOut;
}

# modified version of SMWSQLStore2::getPropertyValues in order to get all values
# of a property, not only distinct ones
function ft_getPropertyValues( $property, $store ) {
	$pid = $store->getSMWPropertyID( $property );
	$db =& wfGetDB( DB_SLAVE );
	$result = array();
	$mode = SMWSQLStore2::getStorageMode( $property->getPropertyTypeID() );
		switch ( $mode ) {
			case SMW_SQL2_TEXT2:
				$res = $db->select( 'smw_text2', 'value_blob',
									'p_id=' . $db->addQuotes( $pid ) );
				while ( $row = $db->fetchObject( $res ) ) {
					$dv = SMWDataValueFactory::newPropertyObjectValue( $property );
					$dv->setOutputFormat( $outputformat );
					$dv->setDBkeys( array( $row->value_blob ) );
					$result[] = $dv;
				}
				$db->freeResult( $res );
			break;
			case SMW_SQL2_RELS2:
				$res = $db->select( array( 'smw_rels2', 'smw_ids' ),
									'smw_namespace, smw_title, smw_iw',
									'p_id=' . $db->addQuotes( $pid ) . ' AND o_id=smw_id' );
				while ( $row = $db->fetchObject( $res ) ) {
					$dv = SMWDataValueFactory::newPropertyObjectValue( $property );
					$dv->setOutputFormat( $outputformat );
					$dv->setDBkeys( array( $row->smw_title, $row->smw_namespace, $row->smw_iw ) );
					$result[] = $dv;
				}
				$db->freeResult( $res );
			break;
			case SMW_SQL2_ATTS2:
				if ( ( $requestoptions !== NULL ) && ( $requestoptions->boundary !== NULL ) ) {
					$value_column = $requestoptions->boundary->isNumeric() ? 'value_num':'value_xsd';
				} else {
					$testval = SMWDatavalueFactory::newTypeIDValue( $property->getPropertyTypeID() );
					$value_column = $testval->isNumeric() ? 'value_num':'value_xsd';
				}
				$sql = 'p_id=' . $db->addQuotes( $pid );
				$res = $db->select( 'smw_atts2', 'value_unit, value_xsd',
									'p_id=' . $db->addQuotes( $pid ) );
				while ( $row = $db->fetchObject( $res ) ) {
					$dv = SMWDataValueFactory::newPropertyObjectValue( $property );
					$dv->setOutputFormat( $outputformat );
					$dv->setDBkeys( array( $row->value_xsd, $row->value_unit ) );
					$result[] = $dv;
				}
				$db->freeResult( $res );
			break;
		}
	return $result;
}

# derived from Semantic Drilldown (http://www.mediawiki.org/wiki/Extension:Semantic_Drilldown)
function getSubCategories( $category_name, $levels ) {
	if ( $levels == 0 ) {
		return array();
	}

	# result arrays
	$result = array();
	$subcategories = array();

	# get database and table names
	$db = wfGetDB( DB_SLAVE );
	extract( $db->tableNames( 'page', 'categorylinks' ) );

	$cat_ns = NS_CATEGORY;

	# preparing categories
	$query_category = trim( $category_name );
	$query_category = str_replace( ' ', '_', $query_category );
	$query_category = str_replace( "'", "\'", $query_category );

	$sql = "SELECT p.page_title, p.page_namespace
			FROM $categorylinks cl
			JOIN $page p on cl.cl_from = p.page_id
			WHERE cl.cl_to = '$query_category'
			AND p.page_namespace = $cat_ns
			ORDER BY cl.cl_sortkey";

	$res = $db->query( $sql );

	# parsing result
	while ( $row = $db->fetchRow( $res ) ) {
		$subcategories[] = $row[0];
		$result[] = $row[0];
	}

	$db->freeResult( $res );

	# merging recursive
	foreach ( $subcategories as $subcategory ) {
		$result = array_merge( $result,
			getSubCategories( $subcategory, $levels -1 ) );
	}

	return $result;
}
