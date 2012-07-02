<?php
/*

 Purpose:       outputs a bulleted list of most recent
                items residing in a category, or a union
                of several categories.

 Contributors: n:en:User:IlyaHaykinson n:en:User:Amgine
 http://en.wikinews.org/wiki/User:Amgine
 http://en.wikinews.org/wiki/User:IlyaHaykinson

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along
 with this program; if not, write to the Free Software Foundation, Inc.,
 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 http://www.gnu.org/copyleft/gpl.html

 Current feature request list
	 1. Unset cached of calling page
	 2. RSS feed output? (GNSM extension?)

 To install, add following to LocalSettings.php
   include("$IP/extensions/intersection/DynamicPageList.php");

*/

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point to MediaWiki.' );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'DynamicPageList',
	'version'        => '1.5',
	'descriptionmsg' => 'intersection-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Intersection',
	'author'         => array( '[http://en.wikinews.org/wiki/User:Amgine Amgine]', '[http://en.wikinews.org/wiki/User:IlyaHaykinson IlyaHaykinson]' ),
);

// Internationalization file
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['DynamicPageList'] = $dir . 'DynamicPageList.i18n.php';

// Parser tests
$wgParserTestFiles[] = $dir . 'DynamicPageList.tests.txt';

# Configuration variables. Warning: These use DLP instead of DPL
# for historical reasons (pretend Dynamic list of pages)
$wgDLPmaxCategories = 6;                // Maximum number of categories to look for
$wgDLPMaxResultCount = 200;             // Maximum number of results to allow
$wgDLPAllowUnlimitedResults = false;    // Allow unlimited results
$wgDLPAllowUnlimitedCategories = false; // Allow unlimited categories
// How long to cache pages using DPL's in seconds. Default to 1 day. Set to
// false to not decrease cache time (most efficient), Set to 0 to disable
// cache altogether (inefficient, but results will never be outdated)
$wgDLPMaxCacheTime = 60*60*24;          // How long to cache pages

$wgHooks['ParserFirstCallInit'][] = 'wfDynamicPageList';
/**
 * Set up the <DynamicPageList> tag.
 *
 * @param $parser Object: instance of Parser
 * @return Boolean: true
 */
function wfDynamicPageList( &$parser ) {
	$parser->setHook( 'DynamicPageList', 'renderDynamicPageList' );
	return true;
}

// The callback function for converting the input text to HTML output
function renderDynamicPageList( $input, $args, $mwParser ) {
	global $wgUser, $wgContLang;
	global $wgDisableCounters; // to determine if to allow sorting by #hits.
	global $wgDLPmaxCategories, $wgDLPMaxResultCount, $wgDLPMaxCacheTime;
	global $wgDLPAllowUnlimitedResults, $wgDLPAllowUnlimitedCategories;

	if ( $wgDLPMaxCacheTime !== false ) {
		$mwParser->getOutput()->updateCacheExpiry( $wgDLPMaxCacheTime );
	}

	$countSet = false;

	$startList = '<ul>';
	$endList = '</ul>';
	$startItem = '<li>';
	$endItem = '</li>';
	$inlineMode = false;

	$useGallery = false;
	$galleryFileSize = false;
	$galleryFileName = true;
	$galleryImageHeight = 0;
	$galleryImageWidth = 0;
	$galleryNumbRows = 0;
	$galleryCaption = '';
	$gallery = null;

	$orderMethod = 'categoryadd';
	$order = 'descending';
	$redirects = 'exclude';
	$stable = $quality = 'include';
	$flaggedRevs = false;

	$namespaceFiltering = false;
	$namespaceIndex = 0;

	$offset = 0;

	$googleHack = false;

	$suppressErrors = false;
	$showNamespace = true;
	$addFirstCategoryDate = false;
	$dateFormat = '';
	$stripYear = false;

	$linkOptions = array();
	$categories = array();
	$excludeCategories = array();

	$parameters = explode( "\n", $input );

	$parser = new Parser;
	$poptions = new ParserOptions;

	foreach ( $parameters as $parameter ) {
		$paramField = explode( '=', $parameter, 2 );
		if( count( $paramField ) < 2 ) {
			continue;
		}
		$type = trim( $paramField[0] );
		$arg = trim( $paramField[1] );
		switch ( $type ) {
			case 'category':
				$title = Title::makeTitleSafe(
					NS_CATEGORY,
					$parser->transformMsg( $arg, $poptions )
				);
				if( is_null( $title ) ) {
					continue;
				}
				$categories[] = $title;
				break;
			case 'notcategory':
				$title = Title::makeTitleSafe(
					NS_CATEGORY,
					$parser->transformMsg( $arg, $poptions )
				);
				if( is_null( $title ) ) {
					continue;
				}
				$excludeCategories[] = $title;
				break;
			case 'namespace':
				$ns = $wgContLang->getNsIndex( $arg );
				if ( $ns != null ) {
					$namespaceIndex = $ns;
					$namespaceFiltering = true;
				} else {
					// Note, since intval("some string") = 0
					// this considers pretty much anything
					// invalid here as the main namespace.
					// This was probably originally a bug,
					// but is now depended upon by people
					// writing things like namespace=main
					// so be careful when changing this code.
					$namespaceIndex = intval( $arg );
					if ( $namespaceIndex >= 0 )	{
						$namespaceFiltering = true;
					} else {
						$namespaceFiltering = false;
					}
				}
				break;
			case 'count':
				// ensure that $count is a number;
				$count = intval( $arg );
				$countSet = true;
				break;
			case 'offset':
				$offset = intval( $arg );
				break;
			case 'imagewidth':
				$galleryImageWidth = intval( $arg );
				break;
			case 'imageheight':
				$galleryImageHeight = intval( $arg );
				break;
			case 'imagesperrow':
				$galleryNumbRows = intval( $arg );
				break;
			case 'mode':
				switch ( $arg ) {
					case 'gallery':
						$useGallery = true;
						$gallery = new ImageGallery;
						$startList = '';
						$endList = '';
						$startItem = '';
						$endItem = '';
						break;
					case 'none':
						$startList = '';
						$endList = '';
						$startItem = '';
						$endItem = '<br />';
						$inlineMode = false;
						break;
					case 'ordered':
						$startList = '<ol>';
						$endList = '</ol>';
						$startItem = '<li>';
						$endItem = '</li>';
						$inlineMode = false;
						break;
					case 'inline':
						// aka comma seperated list
						$startList = '';
						$endList = '';
						$startItem = '';
						$endItem = '';
						$inlineMode = true;
						break;
					case 'unordered':
					default:
						$startList = '<ul>';
						$endList = '</ul>';
						$startItem = '<li>';
						$endItem = '</li>';
						$inlineMode = false;
						break;
				}
				break;
			case 'gallerycaption':
				// Should perhaps actually parse caption instead
				// as links and what not in caption might be useful.
				$galleryCaption = $parser->transformMsg( $arg, $poptions );
				break;
			case 'galleryshowfilesize':
				switch ( $arg ) {
					case 'no':
					case 'false':
						$galleryFileSize = false;
						break;
					case 'true':
					default:
						$galleryFileSize = true;
				}
				break;
			case 'galleryshowfilename':
				switch ( $arg ) {
					case 'no':
					case 'false':
						$galleryFileName = false;
						break;
					case 'true':
					default:
						$galleryFileName = true;
						break;
				}
				break;
			case 'order':
				switch ( $arg ) {
					case 'ascending':
						$order = 'ascending';
						break;
					case 'descending':
					default:
						$order = 'descending';
						break;
				}
				break;
			case 'ordermethod':
				switch ( $arg ) {
					case 'lastedit':
						$orderMethod = 'lastedit';
						break;
					case 'length':
						$orderMethod = 'length';
						break;
					case 'created':
						$orderMethod = 'created';
						break;
					case 'sortkey':
					case 'categorysortkey':
						$orderMethod = 'categorysortkey';
						break;
					case 'popularity':
						if ( !$wgDisableCounters ) {
							$orderMethod = 'popularity';
						} else {
							$orderMethod = 'categoyadd'; // default if hitcounter disabled.
						}
						break;
					case 'categoryadd':
					default:
						$orderMethod = 'categoryadd';
						break;
				}
				break;
			case 'redirects':
				switch ( $arg ) {
					case 'include':
						$redirects = 'include';
						break;
					case 'only':
						$redirects = 'only';
						break;
					case 'exclude':
					default:
						$redirects = 'exclude';
						break;
				}
				break;
			case 'stablepages':
				switch ( $arg ) {
					case 'include':
						$stable = 'include';
						break;
					case 'only':
						$flaggedRevs = true;
						$stable = 'only';
						break;
					case 'exclude':
					default:
						$flaggedRevs = true;
						$stable = 'exclude';
						break;
				}
				break;
			case 'qualitypages':
				switch ( $arg ) {
					case 'include':
						$quality = 'include';
						break;
					case 'only':
						$flaggedRevs = true;
						$quality = 'only';
						break;
					case 'exclude':
					default:
						$flaggedRevs = true;
						$quality = 'exclude';
						break;
				}
				break;
			case 'suppresserrors':
				if ( $arg == 'true' ) {
					$suppressErrors = true;
				} else {
					$suppressErrors = false;
				}
				break;
			case 'addfirstcategorydate':
				if ( $arg == 'true' ) {
					$addFirstCategoryDate = true;
				} elseif ( preg_match( '/^(?:[ymd]{2,3}|ISO 8601)$/', $arg ) )  {
					// if it more or less is valid dateformat.
					$addFirstCategoryDate = true;
					$dateFormat = $arg;
					if ( strlen( $dateFormat ) == 2 ) {
						$dateFormat = $dateFormat . 'y'; # DateFormatter does not support no year. work around
						$stripYear = true;
					}
				} else {
					$addFirstCategoryDate = false;
				}
				break;
			case 'shownamespace':
				if ( 'false' == $arg ) {
					$showNamespace = false;
				} else {
					$showNamespace = true;
				}
				break;
			case 'googlehack':
				if ( 'false' == $arg ) {
					$googleHack = false;
				} else {
					$googleHack = true;
				}
				break;
			case 'nofollow': # bug 6658
				if ( 'false' != $arg ) {
					$linkOptions['rel'] = 'nofollow';
				}
				break;
		} // end main switch()
	} // end foreach()

	$catCount = count( $categories );
	$excludeCatCount = count( $excludeCategories );
	$totalCatCount = $catCount + $excludeCatCount;

	if ( $catCount < 1 && false == $namespaceFiltering ) {
		if ( $suppressErrors == false ) {
			return htmlspecialchars( wfMsgForContent( 'intersection_noincludecats' ) ); // "!!no included categories!!";
		} else {
			return '';
		}
	}

	if ( $totalCatCount > $wgDLPmaxCategories && !$wgDLPAllowUnlimitedCategories ) {
		if ( $suppressErrors == false ) {
			return htmlspecialchars( wfMsgForContent( 'intersection_toomanycats' ) ); // "!!too many categories!!";
		} else {
			return '';
		}
	}

	if ( $countSet ) {
		if ( $count < 1 ) {
			$count = 1;
		}
		if ( $count > $wgDLPMaxResultCount ) {
			$count = $wgDLPMaxResultCount;
		}
	} elseif ( !$wgDLPAllowUnlimitedResults ) {
		$count = $wgDLPMaxResultCount;
		$countSet = true;
	}

	// disallow showing date if the query doesn't have an inclusion category parameter
	if ( $catCount < 1 ) {
		$addFirstCategoryDate = false;
		// don't sort by fields relating to categories if there are no categories.
		if ( $orderMethod == 'categoryadd' || $orderMethod == 'categorysortkey' ) {
			$orderMethod = 'created';
		}
	}

	// build the SQL query
	$dbr = wfGetDB( DB_SLAVE );
	$tables = array( 'page' );
	$fields = array( 'page_namespace', 'page_title' );
	$where = array();
	$join = array();
	$options = array();

	if ( $googleHack ) {
		$fields[] = 'page_id';
	}

	if ( $addFirstCategoryDate ) {
		$fields[] = 'c1.cl_timestamp';
	}

	if ( $namespaceFiltering == true ) {
		$where['page_namespace'] = $namespaceIndex;
	}

	// Bug 14943 - Allow filtering based on FlaggedRevs stability.
	// Check if the extension actually exists before changing the query...
	if ( $flaggedRevs && defined( 'FLAGGED_REVISIONS' ) ) {
		$tables[] = 'flaggedpages';
		$join['flaggedpages'] = array( 'LEFT JOIN', 'page_id = fp_page_id' );

		switch( $stable ) {
			case 'only':
				$where[] = 'fp_stable IS NOT NULL';
				break;
			case 'exclude':
				$where['fp_stable'] = null;
				break;
		}

		switch( $quality ) {
			case 'only':
				$where[] = 'fp_quality >= 1';
				break;
			case 'exclude':
				$where[] = 'fp_quality = 0 OR fp_quality IS NULL';
				break;
		}
	}

	switch ( $redirects ) {
		case 'only':
			$where['page_is_redirect'] = 1;
			break;
		case 'exclude':
			$where['page_is_redirect'] = 0;
			break;
	}

	$currentTableNumber = 1;
	$categorylinks = $dbr->tableName( 'categorylinks' );

	for ( $i = 0; $i < $catCount; $i++ ) {
		$join["$categorylinks AS c$currentTableNumber"] = array(
			'INNER JOIN',
			array(
				"page_id = c{$currentTableNumber}.cl_from",
			 	"c{$currentTableNumber}.cl_to={$dbr->addQuotes( $categories[$i]->getDBKey() )}"
			)
		);
		$tables[] = "$categorylinks AS c$currentTableNumber";

		$currentTableNumber++;
	}

	for ( $i = 0; $i < $excludeCatCount; $i++ ) {
		$join["$categorylinks AS c$currentTableNumber"] = array(
			'LEFT OUTER JOIN',
			array(
				"page_id = c{$currentTableNumber}.cl_from",
				"c{$currentTableNumber}.cl_to={$dbr->addQuotes( $excludeCategories[$i]->getDBKey() )}"
			)
		);
		$tables[] = "$categorylinks AS c$currentTableNumber";
		$where["c{$currentTableNumber}.cl_to"] = null;
		$currentTableNumber++;
	}

	if ( 'descending' == $order ) {
		$sqlOrder = 'DESC';
	} else {
		$sqlOrder = 'ASC';
	}

	switch ( $orderMethod ) {
		case 'lastedit':
			$sqlSort = 'page_touched';
			break;
		case 'length':
			$sqlSort = 'page_len';
			break;
		case 'created':
			$sqlSort = 'page_id'; # Since they're never reused and increasing
			break;
		case 'categorysortkey':
			$sqlSort = "c1.cl_type $sqlOrder, c1.cl_sortkey";
			break;
		case 'popularity':
			$sqlSort = 'page_counter';
			break;
		case 'categoryadd':
		default:
			$sqlSort = 'c1.cl_timestamp';
			break;
	}

	$options['ORDER BY'] = "$sqlSort $sqlOrder";

	if ( $countSet ) {
		$options['LIMIT'] = $count;
	}
	if ( $offset > 0 ) {
		$options['OFFSET'] = $offset;
	}

	// process the query
	$res = $dbr->select( $tables, $fields, $where, __METHOD__, $options, $join );
	$sk = $wgUser->getSkin();

	if ( $dbr->numRows( $res ) == 0 ) {
		if ( $suppressErrors == false ) {
			return htmlspecialchars( wfMsgForContent( 'intersection_noresults' ) );
		} else {
			return '';
		}
	}

	// start unordered list
	$output = $startList . "\n";

	$categoryDate = '';
	$df = null;
	if ( $dateFormat != '' && $addFirstCategoryDate ) {
		$df = DateFormatter::getInstance();
	}

	// process results of query, outputing equivalent of <li>[[Article]]</li>
	// for each result, or something similar if the list uses other
	// startlist/endlist
	$articleList = array();
	foreach ( $res as $row ) {
		$title = Title::makeTitle( $row->page_namespace, $row->page_title );
		if ( true == $addFirstCategoryDate ) {
			if ( $dateFormat != '' ) {
				# this is a tad ugly
				# use DateFormatter, and support disgarding year.
				$categoryDate = wfTimestamp( TS_ISO_8601, $row->cl_timestamp );
				if ( $stripYear ) {
					$categoryDate = $wgContLang->getMonthName( substr( $categoryDate, 5, 2 ) )
						. ' ' . substr ( $categoryDate, 8, 2 );
				} else {
					$categoryDate = substr( $categoryDate, 0, 10 );
				}
				$categoryDate = $df->reformat( $dateFormat, $categoryDate, array( 'match-whole' ) );
			} else {
				$categoryDate = $wgContLang->date( wfTimestamp( TS_MW, $row->cl_timestamp ) );
			}
			if ( !$useGallery ) {
				$categoryDate .= wfMsgForContent( 'colon-separator' );
			} else {
				$categoryDate .= ' ';
			}
		}

		$query = array();

		if ( $googleHack == true ) {
			$query['dpl_id'] = intval( $row->page_id );
		}

		if ( $showNamespace == true ) {
			$titleText = $title->getPrefixedText();
		} else {
			$titleText = $title->getText();
		}

		if ( $useGallery ) {
			# Note, $categoryDate is treated as raw html
			# this is safe since the only html present
			# would come from the dateformatter <span>.
			$gallery->add( $title, $categoryDate );
		} else {
			$articleList[] = $categoryDate .
				$sk->link(
					$title,
					htmlspecialchars( $titleText ),
					$linkOptions,
					$query,
					array( 'forcearticlepath', 'known' )
				);
		}
	}

	// end unordered list
	if ( $useGallery ) {
		$gallery->setHideBadImages();
		$gallery->setShowFilename( $galleryFileName );
		$gallery->setShowBytes( $galleryFileSize );
		if ( $galleryImageHeight > 0 ) {
			$gallery->setHeights( $galleryImageHeight );
		}
		if ( $galleryImageWidth > 0 ) {
			$gallery->setWidths( $galleryImageWidth );
		}
		if ( $galleryNumbRows > 0 ) {
			$gallery->setPerRow( $galleryNumbRows );
		}
		if ( $galleryCaption != '' ) {
			$gallery->setCaption( $galleryCaption ); # gallery class escapes string
		}
		$output = $gallery->toHtml();
	} else {
		$output .= $startItem;
		if ( $inlineMode ) {
			$output .= $wgContLang->commaList( $articleList );
		} else {
			$output .= implode( "$endItem \n$startItem", $articleList );
		}
		$output .= $endItem;
		$output .= $endList . "\n";
	}

	return $output;
}
