<?php
/**
 * Statistics about message groups.
 *
 * @author Niklas Laxstrom
 * @author Siebrand Mazeland
 *
 * @copyright Copyright © 2007-2008, Niklas Laxström
 * @copyright Copyright © 2009, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

$mostSpokenLanguages = array(
	// 'language code' => array( position, speakers in millions, continent ),
	// Source: http://stats.wikimedia.org/EN/Sitemap.htm
	'en'       => array( 1, 1500, 'multiple' ),
	'zh-hans'  => array( 2, 1300, 'asia' ),
	'zh-hant'  => array( 2, 1300, 'asia' ),
	'hi'       => array( 3,  550, 'asia' ),
	'ar'       => array( 4,  530, 'multiple' ),
	'es'       => array( 5,  500, 'multiple' ),
	'ms'       => array( 6,  300, 'asia' ),
	'pt'       => array( 7,  290, 'multiple' ),
	'pt-br'    => array( 7,  290, 'america' ),
	'ru'       => array( 8,  278, 'multiple' ),
	'id'       => array( 9,  250, 'asia' ),
	'bn'       => array( 10, 230, 'asia' ),
	'fr'       => array( 11, 200, 'multiple' ),
	'de'       => array( 12, 185, 'europe' ),
	'ja'       => array( 13, 132, 'asia' ),
	'fa'       => array( 14, 107, 'asia' ),
	'pnb'      => array( 15, 104, 'asia' ), // Most spoken variant
	'tl'       => array( 16,  90, 'asia' ),
	'mr'       => array( 17,  90, 'asia' ),
	'vi'       => array( 18,  80, 'asia' ),
	'jv'       => array( 19,  80, 'asia' ),
	'te'       => array( 20,  80, 'asia' ),
	'ko'       => array( 21,  78, 'asia' ),
	'wuu'      => array( 22,  77, 'asia' ),
	'arz'      => array( 23,  76, 'africa' ),
	'th'       => array( 24,  73, 'asia' ),
	'yue'      => array( 25,  71, 'asia' ),
	'tr'       => array( 26,  70, 'multiple' ),
	'it'       => array( 27,  70, 'europe' ),
	'ta'       => array( 28,  66, 'asia' ),
	'ur'       => array( 29,  60, 'asia' ),
	'my'       => array( 30,  52, 'asia' ),
	'sw'       => array( 31,  50, 'africa' ),
	'nan'      => array( 32,  49, 'asia' ),
	'kn'       => array( 33,  47, 'asia' ),
	'gu'       => array( 34,  46, 'asia' ),
	'uk'       => array( 35,  45, 'europe' ),
	'pl'       => array( 36,  43, 'europe' ),
	'sd'       => array( 37,  41, 'asia' ),
	'ha'       => array( 38,  39, 'africa' ),
	'ml'       => array( 39,  37, 'asia' ),
	'gan-hans' => array( 40,  35, 'asia' ),
	'gan-hant' => array( 40,  35, 'asia' ),
	'hak'      => array( 41,  34, 'asia' ),
	'or'       => array( 42,  31, 'asia' ),
	'ne'       => array( 43,  30, 'asia' ),
	'ro'       => array( 44,  28, 'europe' ),
	'su'       => array( 45,  27, 'asia' ),
	'az'       => array( 46,  27, 'asia' ),
	'nl'       => array( 47,  27, 'europe' ),
	'zu'       => array( 48,  26, 'africa' ),
	'ps'       => array( 49,  26, 'asia' ),
	'ckb-arab' => array( 50,  26, 'asia' ),
	'ku-latn'  => array( 50,  26, 'asia' ),
);

$localisedWeights = array(
	'wikimedia' => array(
		'core-0-mostused'   => 40,
		'core'            => 30,
		'ext-0-wikimedia' => 30
	),
	'mediawiki' => array(
		'core-0-mostused'   => 30,
		'core'            => 30,
		'ext-0-wikimedia' => 20,
		'ext-0-all'       => 20
	)
);

// Code map to map localisation codes to Wikimedia project codes. Only
// exclusions and remapping is defined here. It is assumed that the first part
// of the localisation code is the WMF project name otherwise (zh-hans -> zh).
$wikimediaCodeMap = array(
	// Codes containing a dash
	'bat-smg' => 'bat-smg',
	'cbk-zam' => 'cbk-zam',
	'map-bms' => 'map-bms',
	'nds-nl' => 'nds-nl',
	'roa-rup' => 'roa-rup',
	'roa-tara' => 'roa-tara',

	// Remaps
	'be-tarask' => 'be-x-old',
	'gsw' => 'als',
	'ike-cans' => 'iu',
	'ike-latn' => 'iu',
	'lzh' => 'zh-classical',
	'nan' => 'zh-min-nan',
	'vro' => 'fiu-vro',
	'yue' => 'zh-yue',

	// Ignored language codes. See reason.
	'als' => '', // gsw
	'be-x-old' => '', // be-tarask
	'ckb' => '', // ckb-*
	'crh' => '', // crh-*
	'de-at' => '', // de
	'de-ch' => '', // de
	'de-formal' => '', // de, not reporting formal form
	'dk' => '', // da
	'en-gb' => '', // en
	'fiu-vro' => '', // vro
	'gan' => '', // gan-*
	'got' => '', // extinct. not reporting formal form
	'hif' => '', // hif-*
	'hu-formal' => '', // not reporting
	'iu' => '', // ike-*
	'kk' => '', // kk-*
	'kk-cn' => '', // kk-arab
	'kk-kz' => '', // kk-cyrl
	'kk-tr' => '', // kk-latn
	'ko-kp' => '', // ko
	'ku' => '', // ku-*
	'ku-arab' => '', // ckb-arab
	'nb' => '', // no
	'nl-be' => '', // no MW code
	'ruq' => '', // ruq-*
	'simple' => '', // en
	'sr' => '', // sr-*
	'tg' => '', // tg-*
	'tp' => '', // tokipona
	'tt' => '', // tt-*
	'ug' => '', // ug-*
	'zh' => '', // zh-*
	'zh-classical' => '', // lzh
	'zh-cn' => '', // zh
	'zh-sg' => '', // zh
	'zh-hk' => '', // zh
	'zh-min-nan' => '', //
	'zh-mo' => '', // zh
	'zh-my' => '', // zh
	'zh-tw' => '', // zh
	'zh-yue' => '', // yue
);

$optionsWithArgs = array( 'groups', 'output', 'skiplanguages', 'legenddetail', 'legendsummary' );
require( dirname( __FILE__ ) . '/cli.inc' );

class TranslateStatsOutput extends wikiStatsOutput {
	function heading() {
		echo '{| class="sortable wikitable" border="2" cellpadding="4" cellspacing="0" style="background-color: #F9F9F9; border: 1px #AAAAAA solid; border-collapse: collapse; clear:both;" width="100%"' . "\n";
	}

	function summaryheading() {
		echo "\n" . '{| class="sortable wikitable" border="2" cellpadding="4" cellspacing="0" style="background-color: #F9F9F9; border: 1px #AAAAAA solid; border-collapse: collapse; clear:both;"' . "\n";
	}

	function addFreeText( $freeText ) {
		echo $freeText;
	}
}

if ( isset( $options['help'] ) ) showUsage();

// Show help and exit if '--most' does not have a valid value and no groups set
if ( isset( $options['most'] ) && !isset( $localisedWeights[$options['most']] ) && !isset( $options['groups'] ) ) {
	showUsage();
}

if ( !isset( $options['output'] ) ) $options['output'] = 'default';

/** Print a usage message*/
function showUsage() {
	$msg = <<<END
	--help : this help message
	--groups LIST: comma separated list of groups
	--skiplanguages LIST: comma separated list of skipped languages
	--skipzero : skip languages that do not have any localisation at all
	--fuzzy : add column for fuzzy counts
	--output TYPE: select an another output engine
		* 'csv'      : Comma Separated Values.
		* 'wiki'     : MediaWiki syntax.
		* 'metawiki' : MediaWiki syntax used for Meta-Wiki.
		* 'text'     : Text with tabs.
	--most : [SCOPE]: report on the 50 most spoken languages. Skipzero is
			ignored. If a valid scope is defined, the group list
			and fuzzy are ignored and the localisation levels are
			weighted and reported.
		* mediawiki:
			core-0-mostused (30%)
			core (30%)
			ext-0-wikimedia (20%)
			ext-0-all (20%)
		* wikimedia:
			core-0-mostused (40%)
			core (30%)
			ext-0-wikimedia (30%)
	--speakers : add column for number of speakers (est.). Only valid when
		     combined with --most.
	--nol10n : do not add localised language name if I18ntags is installed.
	--continent : add a continent column. Only available when output is
		      'wiki' or not specified.
	--summary : add a summary with counts and scores per continent category
		    and totals. Only available for a valid 'most' value.
	--legenddetail : Page name for legend to be transcluded at the top of
			 the details table
	--legendsummary : Page name for legend to be transcluded at the top of
			  the summary table
	--wmfscore : Only output WMF language code and weighted score for all
		     language codes for weighing group 'wikimedia' in CSV. This
		     report must keep a stable layout as it is used/will be
		     used in the Wikimedia statistics.

END;
	STDERR( $msg );
	exit( 1 );
}

# Select an output engine
switch ( $options['output'] ) {
	case 'wiki':
		$out = new wikiStatsOutput();
		break;
	case 'metawiki':
		$out = new metawikiStatsOutput();
		break;
	case 'text':
		$out = new textStatsOutput();
		break;
	case 'csv':
		$out = new csvStatsOutput();
		break;
	case 'default':
		$out = new TranslateStatsOutput();
		break;
	default:
		showUsage();
}

$skipLanguages = array();
if ( isset( $options['skiplanguages'] ) ) {
	$skipLanguages = array_map( 'trim', explode( ',', $options['skiplanguages'] ) );
}

$reportScore = false;
// Check if score should be reported and prepare weights
if ( isset( $options['most'] ) && isset( $localisedWeights[$options['most']] ) ) {
	$reportScore = true;
	$weights = array();
	foreach ( $localisedWeights[$options['most']] as $weight ) {
		$weights[] = $weight;
	}
}

// check if l10n should be done
$l10n = false;
if ( ( $options['output'] == 'wiki' || $options['output'] == 'default' ) &&
	  !isset( $options['nol10n'] ) ) {
	$l10n = true;
}

$wmfscore = false;
if ( isset( $options['wmfscore'] ) ) {
	$wmfscore = true;
}

// Get groups from input
$groups = array();
if ( $reportScore ) {
	$reqGroups = array_keys( $localisedWeights[$options['most']] );
} elseif ( !$wmfscore ) {
	$reqGroups = array_map( 'trim', explode( ',', $options['groups'] ) );
} else {
	$reqGroups = array_keys( $localisedWeights['wikimedia'] );
}

// List of all groups
$allGroups = MessageGroups::singleton()->getGroups();

// Get list of valid groups
foreach ( $reqGroups as $id ) {
	if ( isset( $allGroups[$id] ) ) {
		$groups[$id] = $allGroups[$id];
	} else {
		STDERR( "Unknown group: $id" );
	}
}

if ( $wmfscore ) {
	// Override/set parameters
	$out = new csvStatsOutput();
	$reportScore = true;

	$weights = array();
	foreach ( $localisedWeights['wikimedia'] as $weight ) {
		$weights[] = $weight;
	}
	$wmfscores = array();
}

if ( !count( $groups ) ) {
	showUsage();
}

// List of all languages.
$languages = Language::getLanguageNames( false );
// Default sorting order by language code, users can sort wiki output.
ksort( $languages );

if ( isset( $options['legenddetail'] ) ) {
	$out->addFreeText( "{{" . $options['legenddetail'] . "}}\n" );
}

$totalWeight = 0;
if ( $reportScore ) {
	if ( $wmfscore ) {
		foreach ( $localisedWeights['wikimedia'] as $weight ) {
			$totalWeight += $weight;
		}
	} else {
		foreach ( $localisedWeights[$options['most']] as $weight ) {
			$totalWeight += $weight;
		}
	}
}

if ( !$wmfscore ) {
	// Output headers
	$out->heading();

	$out->blockstart();

	if ( isset( $options['most'] ) ) {
		$out->element( ( $l10n ? "{{int:translate-gs-pos}}" : 'Pos.' ), true );
	}

	$out->element( ( $l10n ? "{{int:translate-gs-code}}" : 'Code' ), true );
	$out->element( ( $l10n ? "{{int:translate-page-language}}" : 'Language' ), true );
	if ( isset( $options['continent'] ) ) {
		$out->element( ( $l10n ? "{{int:translate-gs-continent}}" : 'Continent' ), true );
	}

	if ( isset( $options['most'] ) && isset( $options['speakers'] ) ) {
		$out->element( ( $l10n ? "{{int:translate-gs-speakers}}" : 'Speakers' ), true );
	}

	if ( $reportScore ) {
		$out->element( ( $l10n ? "{{int:translate-gs-score}}" : 'Score' ) . ' (' . $totalWeight . ')', true );
	}


	foreach ( $groups as $g ) {
		// Add unprocessed description of group as heading
		if ( $reportScore ) {
			$gid = $g->getId();
			$heading = $g->getLabel() . " (" . $localisedWeights[$options['most']][$gid] . ")";
		} else {
			$heading = $g->getLabel();
		}
		$out->element( $heading, true );
		if ( !$reportScore && isset( $options['fuzzy'] ) ) {
			$out->element( ( $l10n ? "{{int:translate-percentage-fuzzy}}" : 'Fuzzy' ), true );
		}
	}

	$out->blockend();
}

$rows = array();
foreach ( $languages as $code => $name ) {
	// Skip list
	if ( in_array( $code, $skipLanguages ) ) continue;
	$rows[$code] = array();
}

$cache = new ArrayMemoryCache( 'groupstats' );

foreach ( $groups as $groupName => $g ) {
	// Initialise messages
	$collection = $g->initCollection( 'en' );

	// Perform the statistic calculations on every language
	foreach ( $languages as $code => $name ) {
		// Skip list
		if ( !isset( $options['most'] ) && in_array( $code, $skipLanguages ) ) {
			continue;
		}

		// Do not calculate if we do not need it for anything.
		if ( $wmfscore && isset( $wikimediaCodeMap[$code] ) && $wikimediaCodeMap[$code] == '' ) {
			continue;
		}

		// If --most is set, skip all other
		if ( isset( $options['most'] ) && !isset( $mostSpokenLanguages[$code] ) ) {
			continue;
		}

		$incache = $cache->get( $groupName, $code );
		if ( $incache !== false ) {
			list( $fuzzy, $translated, $total ) = $incache;
		} else {
			$collection->resetForNewLanguage( $code );
			$collection->filter( 'ignored' );
			$collection->filter( 'optional' );
			// Store the count of real messages for later calculation.
			$total = count( $collection );

			// Count fuzzy first
			$collection->filter( 'fuzzy' );
			$fuzzy = $total - count( $collection );

			// Count the completion percent
			$collection->filter( 'hastranslation', false );
			$translated = count( $collection );

			$cache->set( $groupName, $code, array( $fuzzy, $translated, $total ) );
		}

		$rows[$code][] = array( false, $translated, $total );

		if ( isset( $options['fuzzy'] ) ) {
			$rows[$code][] = array( true, $fuzzy, $total );
		}
	}

	$cache->commit(); // Do not keep open too long to avoid concurrent access

	unset( $collection );
}

// init summary array
$summarise = false;
if ( isset( $options['summary'] ) ) {
	$summarise = true;
	$summary = array();
}

foreach ( $languages as $code => $name ) {
	// Skip list
	if ( !isset( $options['most'] ) && in_array( $code, $skipLanguages ) ) {
		continue;
	}

	// Skip unneeded
	if ( $wmfscore && isset( $wikimediaCodeMap[$code] ) && $wikimediaCodeMap[$code] == '' ) {
		continue;
	}

	// If --most is set, skip all other
	if ( isset( $options['most'] ) && !isset( $mostSpokenLanguages[$code] ) ) {
		continue;
	}

	$columns = $rows[$code];

	$allZero = true;
	foreach ( $columns as $fields ) {
		if ( intval( $fields[1] ) !== 0 ) $allZero = false;
	}

	// Skip dummy languages if requested
	if ( $allZero && isset( $options['skipzero'] ) ) continue;

	// Output the the row
	if ( !$wmfscore ) {
		$out->blockstart();
	}

	// Fill language position field
	if ( isset( $options['most'] ) ) {
		$out->element( $mostSpokenLanguages[$code][0] );
	}

	// Fill language name field
	if ( !$wmfscore ) {
		// Fill language code field
		$out->element( $code );

		if ( $l10n && function_exists( 'efI18nTagsInit' ) ) {
			$out->element( "{{#languagename:" . $code . "}}" );
		} else {
			$out->element( $name );
		}
	}

	// Fill continent field
	if ( isset( $options['continent'] ) ) {
		if ( $mostSpokenLanguages[$code][2] == 'multiple' ) {
			$continent = ( $l10n ? "{{int:translate-gs-multiple}}" : 'Multiple' );
		} else {
			$continent = $l10n ?
				"{{int:timezoneregion-" . $mostSpokenLanguages[$code][2] . "}}" :
				ucfirst ( $mostSpokenLanguages[$code][2] );
		}

		$out->element( $continent );
	}

	// Fill speakers field
	if ( isset( $options['most'] ) && isset( $options['speakers'] ) ) {
		$out->element( number_format( $mostSpokenLanguages[$code][1] ) );
	}

	// Fill the score field
	if ( $reportScore ) {
		// Keep count
		$i = 0;
		// Start with 0 points
		$score = 0;

		foreach ( $columns as $fields ) {
			list( $invert, $upper, $total ) = $fields;
			// Weigh the score and add it to the current score
			$score += ( $weights[$i] * $upper ) / $total;
			$i++;
		}

		// Report a round numbers
		$score = number_format( $score, 0 );

		if ( $summarise ) {
			$continent = $mostSpokenLanguages[$code][2];
			if ( isset( $summary[$continent] ) ) {
				$newcount = $summary[$continent][0] + 1;
				$newscore = $summary[$continent][1] + $score;
			} else {
				$newcount = 1;
				$newscore = $score;
			}

			$summary[$continent] = array( $newcount, $newscore );
		}

		if ( $wmfscore ) {
			// Multiple variants can be used for the same wiki.
			// Store the scores in an array and output them later
			// when they can be averaged.
			if ( isset( $wikimediaCodeMap[$code] ) ) {
				$wmfcode = $wikimediaCodeMap[$code];
			} else {
				$codeparts = explode( '-', $code );
				$wmfcode = $codeparts[0];
			}

			if ( isset( $wmfscores[$wmfcode] ) ) {
				$count = $wmfscores[$wmfcode]['count'] + 1;
				$score = ( ( $wmfscores[$wmfcode]['count'] * $wmfscores[$wmfcode]['score'] ) + $score ) / $count;
				$wmfscores[$wmfcode] = array( 'score' => $score, 'count' => $count );
			} else {
				$wmfscores[$wmfcode] = array( 'score' => $score, 'count' => 1 );
			}
		} else {
			$out->element( $score );
		}
	}

	// Fill fields for groups
	if ( !$wmfscore ) {
		foreach ( $columns as $fields ) {
			list( $invert, $upper, $total ) = $fields;
			$c = $out->formatPercent( $upper, $total, $invert );
			$out->element( $c );
		}

		$out->blockend();
	}
}

$out->footer();

if ( $reportScore && isset( $options['summary'] ) ) {
	if ( $reportScore && isset( $options['legendsummary'] ) ) {
		$out->addFreeText( "{{" . $options['legendsummary'] . "}}\n" );
	}

	$out->summaryheading();

	$out->blockstart();

	$out->element( $l10n ? "{{int:translate-gs-continent}}" : 'Continent', true );
	$out->element( $l10n ? "{{int:translate-gs-count}}" : 'Count', true );
	$out->element( $l10n ? "{{int:translate-gs-avgscore}}" : 'Avg. score', true );

	$out->blockend();

	ksort( $summary );

	$totals = array( 0, 0 );

	foreach ( $summary as $key => $values ) {
		$out->blockstart();

		if ( $key == 'multiple' ) {
			$out->element( $l10n ? "{{int:translate-gs-multiple}}" : 'Multiple' );
		} else {
			$out->element( $l10n ? "{{int:timezoneregion-" . $key . "}}" : ucfirst( $key ) );
		}
		$out->element( $values[0] );
		$out->element( number_format( $values[1] / $values[0] ) );

		$out->blockend();

		$totals[0] += $values[0];
		$totals[1] += $values[1];
	}

	$out->blockstart();
	$out->element( $l10n ? "{{int:translate-gs-total}}" : 'Total' );
	$out->element( $totals[0] );
	$out->element( number_format( $totals[1] / $totals[0] ) );
	$out->blockend();

	$out->footer();
}

// Custom output
if ( $wmfscore ) {
	ksort( $wmfscores );

	foreach ( $wmfscores as $code => $stats ) {
		echo $code . ';' . number_format( $stats['score'] ) . ";\n";
	}
}
