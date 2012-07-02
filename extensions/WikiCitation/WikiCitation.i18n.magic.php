<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */

$magicWords = array();

$magicWords['en'] = array(

	/**
	 * Parser function and tag extension elements and attributes.
	 */
	'wc_cite_tag'         => array( 1, 'cite' ),       # {{#cite:______}}
	'wc_biblio_tag'       => array( 1, 'biblio' ),     # <biblio>...</biblio>
	'wc_note_tag'         => array( 1, 'note' ),       # <note>...</note>
	'wc_notes_tag'        => array( 1, 'notes' ),      # <notes/>
	'wc_section_tag'      => array( 1, 'notesection'), # <notesection>...</notesection>

	'wc_citestyle_attrib' => array( 1, 'citestyle' ),  # attribute for <biblio> and <section> tags
	'wc_type_attrib'      => array( 1, 'type' ),       # attribute for <biblio> and <section> tags


	/**
	 * Words used by WCArgumentReader.php
	 */
	# name of defined styles, including default
	'wc_default'        => array( 0, 'default' ),
	'wc_Chicago'        => array( 0, 'Chicago' ),
	'wc_Bluebook'       => array( 0, 'Bluebook' ),


	/**
	 * Flags
	 */
	# citation type
	'wc_inline'         => array( 0, 'inline' ),
	'wc_bibliography'   => array( 0, 'bibliography', 'biblio' ),
	'wc_note'           => array( 0, 'note' ),
	'wc_author_date'    => array( 0, 'author-date' ), # indicates author-date style variant

	# citation length
	'wc_long'           => array( 0, 'long' ),
	'wc_short'          => array( 0, 'short' ),

	/**
	 * Scope and type parameters
	 */
	# Combining parameters denoting works or names relating to the work. These
	# will be prefixes.
	'wc_work'                   => array( 0, 'work' ), # This will be the default.
	'wc_container'              => array( 0, 'container' ),
	'wc_series'                 => array( 0, 'series', 'periodical', 'journal' ),
	'wc_original'               => array( 0, 'original' ),
	'wc_subject'                => array( 0, 'subject' ),

	/**
	 * Parameters defining data about the work as a whole.
	 */
	# Type of reference (e.g., book, article, etc.). See below
	'wc_type'                   => array( 0, 'type' ),

	# links
	'wc_link'                => array( 0, 'link' ),      # wikilink to page about source. In English, this needs to be processed before authors, to avoid conflict.
	'wc_URL'                 => array( 0, 'url', 'uri' ),

	# reference numbers
	'wc_call_number'         => array( 0, 'call-number' ),
	'wc_DOI'                 => array( 0, 'DOI' ),
	'wc_ISBN'                => array( 0, 'ISBN' ),

	# date variables
	'wc_date'                => array( 0, 'date', 'dates', 'year', 'years' ),
	'wc_accessed'            => array( 0, 'accessed' ),
	'wc_issued'              => array( 0, 'issued' ),
	'wc_filed'               => array( 0, 'filed' ),

	# other data parameters
	'wc_title'               => array( 0, 'title' ),
	'wc_short_title'         => array( 0, 'short-title' ),
	'wc_place'               => array( 0, 'place', 'publisher-place', 'publication-place', 'archive-location', 'archive-place' ),
	'wc_edition'             => array( 0, 'edition' ),
	'wc_volume'              => array( 0, 'volume' ),
	'wc_issue'               => array( 0, 'issue' ),
	'wc_first_page'          => array( 0, 'first-page' ),
	'wc_version'             => array( 0, 'version' ),
	'wc_number'              => array( 0, 'number' ),
	'wc_opus'                => array( 0, 'opus' ),
	'wc_archive'             => array( 0, 'archive' ),
	'wc_jurisdiction'        => array( 0, 'jurisdiction' ),
	'wc_keyword'             => array( 0, 'keyword' ),

	/**
	 * Parameters denoting one or more locations within a work (i.e., locators).
	 */
	'wc_book_loc'            => array( 0, 'book', 'books' ), # i.e., biblical "book," book III of Lord of the Rings, etc.
	'wc_part'                => array( 0, 'part', 'parts' ),
	'wc_chapter_loc'         => array( 0, 'chapter', 'chapters' ),
	'wc_page'                => array( 0, 'page', 'pages' ),
	'wc_page_range'          => array( 0, 'page-range' ),
	'wc_folio'               => array( 0, 'folio', 'folios' ),
	'wc_column'              => array( 0, 'column', 'columns' ),
	'wc_table'               => array( 0, 'table', 'tables' ),
	'wc_figure'              => array( 0, 'figure', 'figures' ),
	'wc_section'             => array( 0, 'section', 'sections' ),
	'wc_paragraph'           => array( 0, 'paragraph', 'paragraphs' ),
	'wc_note_loc'            => array( 0, 'note', 'notes' ),
		'wc_footnote'        => array( 0, 'footnote', 'footnotes' ),
		'wc_endnote'         => array( 0, 'endnote', 'endnotes' ),
	'wc_verse'               => array( 0, 'verse', 'verses' ),
	'wc_line'                => array( 0, 'line', 'lines' ),
	'wc_locator'             => array( 0, 'locator', 'locators' ), # a generic or descriptive locator

	# Values for type of reference
	'wc_general'                      => array( 0, 'general' ), # the default: could be any type of reference
	'wc_book'                         => array( 0, 'book' ),
		'wc_dictionary'               => array( 0, 'dictionary' ),
		'wc_encyclopedia'             => array( 0, 'encyclopedia' ),
	'wc_periodical'                   => array( 0, 'periodical' ),
		'wc_magazine'                 => array( 0, 'magazine' ),
		'wc_newspaper'                => array( 0, 'newspaper' ),
		'wc_journal'                  => array( 0, 'journal' ),
	'wc_entry'                        => array( 0, 'entry' ),
		'wc_article'                  => array( 0, 'article' ),
		'wc_chapter'                  => array( 0, 'chapter' ),
		'wc_review'                   => array( 0, 'review' ),
	'wc_paper'                        => array( 0, 'paper' ),
		'wc_manuscript'               => array( 0, 'manuscript' ),
		'wc_musical_score'            => array( 0, 'musical-score' ),
		'wc_pamphlet'                 => array( 0, 'pamphlet' ),
		'wc_conference_paper'         => array( 0, 'conference-paper' ),
		'wc_thesis'                   => array( 0, 'thesis' ),
		'wc_report'                   => array( 0, 'report' ),
		'wc_poem'                     => array( 0, 'poem' ),
		'wc_song'                     => array( 0, 'song' ),
	'wc_enactment'                    => array( 0, 'enactment', 'legislation' ),
		'wc_bill'                     => array( 0, 'bill' ),
		'wc_statute'                  => array( 0, 'statute' ),
		'wc_treaty'                   => array( 0, 'treaty' ),
		'wc_rule'                     => array( 0, 'rule' ),
		'wc_regulation'               => array( 0, 'regulation' ),
	'wc_legal_document'               => array( 0, 'legal-document' ),
		'wc_patent'                   => array( 0, 'patent' ),
		'wc_deed'                     => array( 0, 'deed' ),
		'wc_government_grant'         => array( 0, 'government-grant' ),
		'wc_filing'                   => array( 0, 'filing' ),
			'wc_patent_application'   => array( 0, 'patent-application' ),
			'wc_regulatory_filing'    => array( 0, 'regulatory-filing' ),
	'wc_litigation'                   => array( 0, 'litigation' ),
		'wc_legal_opinion'            => array( 0, 'legal-opinion' ),
		'wc_legal_case'               => array( 0, 'legal-case' ),
	'wc_graphic'                      => array( 0, 'graphic' ),
		'wc_photograph'               => array( 0, 'photograph' ),
		'wc_map'                      => array( 0, 'map' ),
	'wc_statement'                    => array( 0, 'statement'),
		'wc_press_release'            => array( 0, 'press-release'),
		'wc_interview'                => array( 0, 'interview' ),
		'wc_speech'                   => array( 0, 'speech' ),
		'wc_personal_communication'   => array( 0, 'personal-communication' ),
	'wc_internet_resource'            => array( 0, 'internet-resource' ),
		'wc_web_page'                 => array( 0, 'web-page', 'webpage' ),
		'wc_post'                     => array( 0, 'post' ),
	'wc_production'                   => array( 0, 'production' ),
		'wc_motion_picture'           => array( 0, 'motion-picture' ),
		'wc_recording'                => array( 0, 'recording' ),
		'wc_play'                     => array( 0, 'play' ),
		'wc_broadcast'                => array( 0, 'broadcast' ),
			'wc_television_broadcast' => array( 0, 'television-broadcast' ),
			'wc_radio_broadcast'      => array( 0, 'radio-broadcast' ),
			'wc_internet_broadcast'   => array( 0, 'internet-broadcast' ),
	'wc_object'                       => array( 0, 'object' ),
		'wc_star'                     => array( 0, 'star' ),
		'wc_gravestone'               => array( 0, 'gravestone', 'headstone' ),
		'wc_monument'                 => array( 0, 'monument' ),
		'wc_real_property'            => array( 0, 'real-property' ),

	/**
	 * Name parameters
	 */
	# Parameters denoting names, including persons
	'wc_author'              => array( 0, 'author' ),
	'wc_publisher'           => array( 0, 'publisher' ),
	'wc_editor_translator'   => array( 0, 'editor-translator', 'translator-editor' ),
	'wc_editor'              => array( 0, 'editor' ),
	'wc_translator'          => array( 0, 'translator' ),
	'wc_interviewer'         => array( 0, 'interviewer' ),
	'wc_recipient'           => array( 0, 'recipient' ),
	'wc_composer'            => array( 0, 'composer' ),

	# words denoting types of name data
	'wc_surname'             => array( 0, 'surname', 'last' ),
	'wc_given'               => array( 0, 'given', 'first' ),
	'wc_namelink'            => array( 0, 'link' ),
	'wc_suffix'              => array( 0, 'suffix' ),
	'wc_droppingparticle'    => array( 0, 'dropping-particle' ),
	'wc_nondroppingparticle' => array( 0, 'non-dropping-particle' ),
	'wc_literalname'         => array( 0, 'literal', 'organization' ),


	/**
	 * Other magic words
	 */
	'wc_ad_magic_word'              => array( 1, 'A.D.', 'AD', 'C.E.', 'CE' ),
	'wc_bc_magic_word'              => array( 1, 'B.C.', 'BC', 'B.C.E.', 'BCE' ),
	'wc_circa'                      => array( 0, 'circa', 'c.', 'around', 'about' ),
	'wc_spring'                     => array( 0, 'spring' ),
	'wc_summer'                     => array( 0, 'summer' ),
	'wc_autumn'                     => array( 0, 'autumn', 'fall' ),
	'wc_winter'                     => array( 0, 'winter' ),
	'wc_year'                       => array( 0, 'year' ),        # 年
	'wc_month'                      => array( 0, 'month' ),       # 月
	'wc_day'                        => array( 0, 'day' ),         # 日

	'wc_list_delimiter'             => array( 0, ',', 'and', '&' ), # Delimits various discrete numbers or number ranges
	'wc_range_delimiter'            => array( 0, 'to' ), # Indicates a continuous number range

	'wc_initial_exterior_quote'     => array( 0, '"', '“', ),     # initial exterior quote symbol for input purposes
	'wc_final_exterior_quote'       => array( 0, '"', '”', ),     # final exterior quote symbol
	'wc_initial_interior_quote'     => array( 0, "'", '‘', ),     # initial interior quote symbol
	'wc_final_interior_quote'       => array( 0, "'", '’', ),     # final interior quote symbol
	'wc_articles'                   => array( 0, 'a', 'an', 'the', 'el', 'la' ),
	'wc_prepositions'               => array( 0, 'aboard', 'about', 'abaft', 'aboard', 'about', 'above', 'absent', 'across', 'afore', 'after', 'against', 'along', 'alongside', 'amid', 'amidst', 'among', 'amongst', 'apropos', 'around', 'as', 'aside', 'astride', 'at', 'athwart', 'atop',
	                                             'barring', 'before', 'behind', 'below', 'beneath', 'beside', 'besides', 'between', 'betwixt', 'beyond', 'but', 'by',
	                                             'circa', 'c.', 'ca.', 'concerning',
	                                             'despite', 'down', 'during',
	                                             'except', 'excluding',
	                                             'failing', 'following', 'for', 'from',
	                                             'given',
	                                             'in', 'including', 'inside', 'into',
	                                             'like',
	                                             'mid,', 'midst', 'minus',
	                                             'near', 'next', 'notwithstanding',
	                                             'of', 'off', 'on', 'onto', 'opposite', 'out', 'outside', 'over',
	                                             'pace', 'past', 'per', 'plus', 'pro',
	                                             'qua',
	                                             'regarding', 'round',
	                                             'sans', 'save', 'since',
	                                             'than', 'through,', 'thru,', 'throughout,', 'thruout', 'till', 'times', 'to', 'toward', 'towards',
	                                             'under', 'underneath', 'unlike', 'until', 'up', 'upon',
	                                             'versus', 'vs.', 'v.', 'via', 'vice',
	                                             'with', 'within', 'without', 'worth'
	                                            ),
	'wc_coordinating_conjunctions'  => array( 0, 'and', 'but', 'for', 'nor', 'or', 'so', 'yet' ),
	'wc_subordinating_conjunctions' => array( 0, 'after', 'although', 'as', 'because', 'before', 'both', 'either',
		                                         'how', 'however', 'if', 'neither', 'now', 'once', 'only', 'provided',
		                                         'since', 'than', 'that', 'though', 'till', 'unless', 'until',
		                                         'when', 'whenever', 'where', 'whereas', 'wherever', 'whether', 'while' ),


);
