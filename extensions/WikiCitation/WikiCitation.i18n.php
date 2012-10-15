<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */

$messages = array ();


/** Pseudo-language with explanations */
$messages['qqq'] = array(
	'wc-description' => 'Description of the WikiCitation extension.',
	'wc-ws' => 'The normal delimiter or punctuation between two names. For example, if there are two authors, text would be placed between them, except when the citation is presented with surname first, for sorting within a bibliography (in which case "wc-name-punct" would be used).',
	'wc-name-punct' => 'The normal delimiter or punctuation between two names, when the citation is presented with surname first, for sorting within a bibliography',
	);


/** English */
$messages['en'] = array (

	# Extension description
	'wc-description' => 'Adds tags for fast standard reference citations and automatic bibliographies',


	# Name separators
	'wc-name-whitespace'           => ' ',            # whitespace, if any, between names
	'wc-name-sort-order-delimiter' => ', ',           # punctuation between names in name-sort mode
	'wc-surname-delimiter'         => ', ',           # punctuation after surname in name-sort mode
	'wc-name-suffix-delimiter'     => ' ',            # Delimiter before name suffix
	'wc-name-missing'              => '___',          # blank to represent a missing name

	'wc-names-delim'               => ', ',           # the normal delimiter between names
	'wc-names-et-al-delim'         => ', ',           # the delimiter before the "and others" designation
	'wc-names-and-2'               => ' and ',        # the delimiter between two names if there are only two
	'wc-names-and-3'               => ', and ',       # the last delimiter for three or more names
	'wc-names-and-others'          => 'et al.',       # "and others"

	# Citation separators and punctuation
	'wc-initial-exterior-quote'    => '"',            # initial exterior quote symbol. (Note: for now, typewriter quotes are widely used in English wikis.)
	'wc-final-exterior-quote'      => '"',            # final exterior quote symbol
	'wc-initial-interior-quote'    => "'",            # initial interior quote symbol
	'wc-final-interior-quote'      => "'",            # final interior quote symbol
	'wc-segment-missing'           => '___',          # blank to represent a missing segment
	'wc-range-delimiter'           => '–',            # delimiter for ranges (usually en-dash).

	# Date localization
	'wc-ad'                        => 'A.D.',
	'wc-ad-no-punct'               => 'AD',
	'wc-ce'                        => 'C.E.',
	'wc-ce-no-punct'               => 'CE',
	'wc-bc'                        => 'B.C.',
	'wc-bc-no-punct'               => 'BC',
	'wc-bce'                       => 'B.C.E.',
	'wc-bce-no-punct'              => 'BCE',
	'wc_spring'                    => 'spring',
	'wc_summer'                    => 'summer',
	'wc_autumn'                    => 'fall',
	'wc_winter'                    => 'winter',
	'wc_year'                      => 'year',        # 年
	'wc_month'                     => 'month',       # 月
	'wc_day'                       => 'day',         # 日

	/**
	 * Literal text
	 */
	'wc-personal-communication'          => 'personal communication',


	/**
	 * Labels
	 */
	'wc-author-long-singular'            => 'author',
	'wc-author-long-plural'              => 'authors',
	'wc-author-verb-singular'            => 'authored by',
	'wc-author-verb-plural'              => 'authored by',
	'wc-author-short-singular'           => 'auth.',
	'wc-author-short-plural'             => 'auths.',
	'wc-author-verb-short-singular'      => 'auth.',
	'wc-author-verb-short-plural'        => 'auth.',
	'wc-author-symbol-singular'          => 'auth.',
	'wc-author-symbol-plural'            => 'auths.',

	'wc-editor-long-singular'            => 'editor',
	'wc-editor-long-plural'              => 'editors',
	'wc-editor-verb-singular'            => 'edited by',
	'wc-editor-verb-plural'              => 'edited by',
	'wc-editor-short-singular'           => 'ed.',
	'wc-editor-short-plural'             => 'eds.',
	'wc-editor-verb-short-singular'      => 'ed.',
	'wc-editor-verb-short-plural'        => 'eds.',
	'wc-editor-symbol-singular'          => 'ed.',
	'wc-editor-symbol-plural'            => 'eds.',

	'wc-translator-long-singular'        => 'translator',
	'wc-translator-long-plural'          => 'translators',
	'wc-translator-verb-singular'        => 'translated by',
	'wc-translator-verb-plural'          => 'translated by',
	'wc-translator-short-singular'       => 'trans.',
	'wc-translator-short-plural'         => 'trans.',
	'wc-translator-verb-short-singular'  => 'trans.',
	'wc-translator-verb-short-plural'    => 'trans.',
	'wc-translator-symbol-singular'      => 'trans.',
	'wc-translator-symbol-plural'        => 'trans.',

	'wc-editor-translator-long-singular'          => 'editor and translator',
	'wc-editor-translator-long-plural'            => 'editors and translators',
	'wc-editor-translator-verb-singular'          => 'edited and translated by',
	'wc-editor-translator-verb-plural'            => 'edited and translated by',
	'wc-editor-translator-short-singular'         => 'ed. and trans.',
	'wc-editor-translator-short-plural'           => 'eds. and trans.',
	'wc-editor-translator-verb-short-singular'    => 'ed. and trans.',
	'wc-editor-translator-verb-short-plural'      => 'eds. and trans.',
	'wc-editor-translator-symbol-singular'        => 'ed. & trans.',
	'wc-editor-translator-symbol-plural'          => 'ed. & trans.',

	'wc-publisher-long-singular'         => 'publisher',
	'wc-publisher-long-plural'           => 'publishers',
	'wc-publisher-verb-singular'         => 'published by',
	'wc-publisher-verb-plural'           => 'published by',
	'wc-publisher-short-singular'        => 'pub.',
	'wc-publisher-short-plural'          => 'pubs.',
	'wc-publisher-verb-short-singular'   => 'pub. by',
	'wc-publisher-verb-short-plural'     => 'pubs. by',
	'wc-publisher-symbol-singular'       => 'pub.',
	'wc-publisher-symbol-plural'         => 'pubs.',

	'wc-interviewer-long-singular'       => 'interviewer',
	'wc-interviewer-long-plural'         => 'interviewers',
	'wc-interviewer-verb-singular'       => 'interview by',
	'wc-interviewer-verb-plural'         => 'interview by',
	'wc-interviewer-short-singular'      => 'interviewer',
	'wc-interviewer-short-plural'        => 'interviewers',
	'wc-interviewer-verb-short-singular' => 'interview by',
	'wc-interviewer-verb-short-plural'   => 'interview by',
	'wc-interviewer-symbol-singular'     => 'interviewer',
	'wc-interviewer-symbol-plural'       => 'interviewers',

	'wc-recipient-long-singular'       => 'recipient',
	'wc-recipient-long-plural'         => 'recipients',
	'wc-recipient-verb-singular'       => 'received by',
	'wc-recipient-verb-plural'         => 'received by',
	'wc-recipient-short-singular'      => 'to',
	'wc-recipient-short-plural'        => 'to',
	'wc-recipient-verb-short-singular' => 'to',
	'wc-recipient-verb-short-plural'   => 'to',
	'wc-recipient-symbol-singular'     => 'to',
	'wc-recipient-symbol-plural'       => 'to',

	'wc-composer-long-singular'       => 'composer',
	'wc-composer-long-plural'         => 'composers',
	'wc-composer-verb-singular'       => 'composed by',
	'wc-composer-verb-plural'         => 'composed by',
	'wc-composer-short-singular'      => 'composer',
	'wc-composer-short-plural'        => 'composers',
	'wc-composer-verb-short-singular' => 'composed by',
	'wc-composer-verb-short-plural'   => 'composed by',
	'wc-composer-symbol-singular'     => 'composer',
	'wc-composer-symbol-plural'       => 'composers',

	'wc-page-long-singular'              => 'page',
	'wc-page-long-plural'                => 'pages',
	'wc-page-verb-singular'              => 'page',
	'wc-page-verb-plural'                => 'pages',
	'wc-page-short-singular'             => 'p.',
	'wc-page-short-plural'               => 'pp.',
	'wc-page-verb-short-singular'        => 'p.',
	'wc-page-verb-short-plural'          => 'pp.',
	'wc-page-symbol-singular'            => 'p.',
	'wc-page-symbol-plural'              => 'pp.',

	'wc-section-long-singular'           => 'section',
	'wc-section-long-plural'             => 'sections',
	'wc-section-verb-singular'           => 'section',
	'wc-section-verb-plural'             => 'sections',
	'wc-section-short-singular'          => 'sec.',
	'wc-section-short-plural'            => 'secs.',
	'wc-section-verb-short-singular'     => 'sec.',
	'wc-section-verb-short-plural'       => 'sec.',
	'wc-section-symbol-singular'         => '§',
	'wc-section-symbol-plural'           => '§§',

	'wc-paragraph-long-singular'         => 'paragraph',
	'wc-paragraph-long-plural'           => 'paragraphs',
	'wc-paragraph-verb-singular'         => 'paragraph',
	'wc-paragraph-verb-plural'           => 'paragraphs',
	'wc-paragraph-short-singular'        => 'para.',
	'wc-paragraph-short-plural'          => 'paras.',
	'wc-paragraph-verb-short-singular'   => 'para.',
	'wc-paragraph-verb-short-plural'     => 'paras.',
	'wc-paragraph-symbol-singular'       => '¶',
	'wc-paragraph-symbol-plural'         => '¶¶',

	'wc-volume-long-singular'            => 'volume',
	'wc-volume-long-plural'              => 'volumes',
	'wc-volume-verb-singular'            => 'volume',
	'wc-volume-verb-plural'              => 'volumes',
	'wc-volume-short-singular'           => 'vol.',
	'wc-volume-short-plural'             => 'volss.',
	'wc-volume-verb-short-singular'      => 'vol.',
	'wc-volume-verb-short-plural'        => 'vols.',
	'wc-volume-symbol-singular'          => 'vol.',
	'wc-volume-symbol-plural'            => 'vols.',

	'wc-issue-long-singular'             => 'issue',
	'wc-issue-long-plural'               => 'issues',
	'wc-issue-verb-singular'             => 'issue',
	'wc-issue-verb-plural'               => 'issue',
	'wc-issue-short-singular'            => 'no.',
	'wc-issue-short-plural'              => 'nos.',
	'wc-issue-verb-short-singular'       => 'no.',
	'wc-issue-verb-short-plural'         => 'nos.',
	'wc-issue-symbol-singular'           => 'no.',
	'wc-issue-symbol-plural'             => 'nos.',

	'wc-circa-long-singular'             => 'circa',
	'wc-circa-long-plural'               => 'circa',
	'wc-circa-verb-singular'             => 'about',
	'wc-circa-verb-plural'               => 'about',
	'wc-circa-short-singular'            => 'c.',
	'wc-circa-short-plural'              => 'c.',
	'wc-circa-verb-short-singular'       => 'abt.',
	'wc-circa-verb-short-plural'         => 'abt.',
	'wc-circa-symbol-singular'           => 'c.',
	'wc-circa-symbol-plural'             => 'c.',

	/**
	 * Error messages
	 */
	'wc-style-not-recognized'    => 'Cite error: <code>$1</code> citation style not recognized.',
	'wc-flag-unknown'            => 'Cite error: unknown <code>$1</code>.',
	'wc-incompatible-flags'      => 'Cite error: citation cannot be <code>$1</code> and <code>$2</code>.',
	'wc-parameter_defined_twice' => 'Cite error: <code>$1</code> defined twice.',
	'wc-parameter-unknown'       => 'Cite error: <code>$1</code> not a recognized property.',
	'wc-type-parameter-unknown'  => 'Cite error: <code>$1</code> not a recognized <code>type</code>.',


);

