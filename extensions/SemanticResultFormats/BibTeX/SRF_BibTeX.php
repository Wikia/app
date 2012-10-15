<?php
/**
 * Create BibTeX exports
 * @file
 * @ingroup SemanticResultFormats
 */

/*
See the end of the file for a total description of BibTeX attributes

Example of a book :

@Book{abramowitz1964homf,
  author =	 "Milton Abramowitz and Irene A. Stegun",
  title = 	 "Handbook of Mathematical Functions",
  publisher = 	 "Dover",
  year = 	 1964,
  address =	 "New York",
  edition =	 "ninth Dover printing, tenth GPO printing"
}

*/

/**
 * Printer class for creating BibTeX exports
 * @author Markus Krötzsch
 * @author Denny Vrandecic
 * @author Frank Dengler
 * @author Steren Giannini
 * @ingroup SemanticResultFormats
 */
class SRFBibTeX extends SMWResultPrinter {
	protected $m_title = '';
	protected $m_description = '';

	public function getMimeType( $res ) {
		return 'text/bibtex';
	}

	public function getFileName( $res ) {
		if ( $this->getSearchLabel( SMW_OUTPUT_WIKI ) != '' ) {
			return str_replace( ' ', '_', $this->getSearchLabel( SMW_OUTPUT_WIKI ) ) . '.bib';
		} else {
			return 'BibTeX.bib';
		}
	}

	public function getQueryMode( $context ) {
		return ( $context == SMWQueryProcessor::SPECIAL_PAGE ) ? SMWQuery::MODE_INSTANCES:SMWQuery::MODE_NONE;
	}

	public function getName() {
		return wfMsg( 'srf_printername_bibtex' );
	}

	protected function getResultText( SMWQueryResult $res, $outputmode ) {
		global $wgSitename;
		$result = '';
		
		if ( $outputmode == SMW_OUTPUT_FILE ) { // make file
			if ( $this->m_title == '' ) {
				$this->m_title = $wgSitename;
			}
			
			$items = array();
			
			while ( $row = $res->getNext() ) {
				$items[] = $this->getItemForResultRow( $row )->text();
			}
			
			$result = implode( '', $items );
		} else { // just make link to export
			if ( $this->getSearchLabel( $outputmode ) ) {
				$label = $this->getSearchLabel( $outputmode );
			} else {
				$label = wfMsgForContent( 'srf_bibtex_link' );
			}
			
			$link = $res->getQueryLink( $label );
			$link->setParameter( 'bibtex', 'format' );
			
			if ( $this->getSearchLabel( SMW_OUTPUT_WIKI ) != '' ) {
				$link->setParameter( $this->getSearchLabel( SMW_OUTPUT_WIKI ), 'searchlabel' );
			}
			
			$result .= $link->getText( $outputmode, $this->mLinker );
			$this->isHTML = ( $outputmode == SMW_OUTPUT_HTML ); // yes, our code can be viewed as HTML if requested, no more parsing needed
		}
		
		return $result;
	}
	
	/**
	 * Gets a SMWBibTeXEntry for the row.
	 * 
	 * @since 1.6
	 * 
	 * @param array of SMWResultArray $row
	 * 
	 * @return SMWBibTeXEntry
	 */
	protected function getItemForResultRow( array /* of SMWResultArray */ $row ) {
		$type = '';
		$address = '';
		$annote = '';
		$author = '';
		$booktitle = '';
		$chapter = '';
		$crossref = '';
		$doi = '';
		$edition = '';
		$editor = '';
		$eprint = '';
		$howpublished = '';
		$institution = '';
		$journal = '';
		$key = '';
		$month = '';
		$note = '';
		$number = '';
		$organization = '';
		$pages = '';
		$publisher = '';
		$school = '';
		$series = '';
		$title = '';
		$type = '';
		$url = '';
		$volume = '';
		$year = '';
		
		foreach ( $row as /* SMWResultArray */ $field ) {
			$req = $field->getPrintRequest();
			$label = strtolower( $req->getLabel() );
			$var = false;
			
			switch ( $label ) {
				case 'type': $var =& $type; break;
				case 'address': $var =& $address; break;
				case 'annote': $var =& $annote; break;
				case 'booktitle': $var =& $booktitle; break;
				case 'chapter': $var =& $chapter; break;
				case 'crossref': $var =& $crossref; break;
				case 'doi': $var =& $doi; break;
				case 'edition': $var =& $edition; break;
				case 'eprint': $var =& $eprint; break;
				case 'howpublished': $var =& $howpublished; break;
				case 'institution': $var =& $institution; break;
				case 'journal': $var =& $journal; break;
				case 'key': $var =& $key; break;
				case 'note': $var =& $note; break;
				case 'number': $var =& $number; break;
				case 'organization': $var =& $organization; break;
				case 'pages': $var =& $pages; break;
				case 'publisher': $var =& $publisher; break;
				case 'school': $var =& $school; break;
				case 'series': $var =& $series; break;
				case 'title': $var =& $title; break;
				case 'url': $var =& $url; break;
				case 'year': $var =& $year; break;
				case 'month': $var =& $month; break;
				case 'volume': case 'journal_volume': $var =& $volume; break;
			}
			
			if ( $var !== false ) {
				$dataValue = $field->getNextDataValue();
				
				if ( $dataValue !== false ) {
					$var = $dataValue->getShortWikiText();
				}
				
				unset( $var );
			}
			else {
				switch ( $label ) {
					case 'author': case 'authors': case 'editor' : case 'editors':
						$wikiTexts = array();
						while ( ( /* SMWDataValue */ $dataValue = $field->getNextDataValue() ) !== false ) {
							$wikiTexts[] = $dataValue->getShortWikiText();
						}
						$wikiText = $GLOBALS['wgLang']->listToText( $wikiTexts );
						
						if ( $label == 'author' || $label == 'authors' ) {
							$author = $wikiText;
						}
						else {
							$author = $editor;
						}
						break;
					case 'date':
						$dataValue = $field->getNextDataValue();
						
						if ( $dataValue !== false && get_class( $dataValue ) == 'SMWTimeValue' ) {
							$year = $dataValue->getYear();
							$month = $dataValue->getMonth();
						}
						break;
				}
			}
		}

		return new SMWBibTeXEntry( $type, $address, $annote, $author, $booktitle, $chapter, $crossref, $doi, $edition, $editor, $eprint, $howpublished, $institution, $journal, $key, $month, $note, $number, $organization, $pages, $publisher, $school, $series, $title, $url, $volume, $year );
	}

	public function getParameters() {
		return array_merge( parent::getParameters(), $this->exportFormatParameters() );
	}

}

/**
 * Represents a single entry in an BibTeX
 * @ingroup SMWQuery
 */
class SMWBibTeXEntry {
	private $bibTeXtype;
	private $URI;
	private $fields = array();

	public function __construct( $type, $address, $annote, $author, $booktitle, $chapter, $crossref, $doi, $edition, $editor, $eprint, $howpublished, $institution, $journal, $key, $month, $note, $number, $organization, $pages, $publisher, $school, $series, $title, $url, $volume, $year ) {
		if ( $type ) $this->bibTeXtype = ucfirst( $type ); else $this->bibTeXtype = 'Book';

		$fields = array();

		if ( $address ) $fields['address'] = $address;
		if ( $annote ) $fields['annote'] = $annote;
		if ( $author ) $fields['author'] = $author;
		if ( $booktitle ) $fields['booktitle'] = $booktitle;
		if ( $chapter ) $fields['chapter'] = $chapter;
		if ( $crossref ) $fields['crossref'] = $crossref;
		if ( $doi ) $fields['doi'] = $doi;
		if ( $edition ) $fields['edition'] = $edition;
		if ( $editor ) $fields['editor'] = $editor;
		if ( $eprint ) $fields['eprint'] = $eprint;
		if ( $howpublished ) $fields['howpublished'] = $howpublished;
		if ( $institution ) $fields['institution'] = $institution;
		if ( $journal ) $fields['journal'] = $journal;
		if ( $key ) $fields['key'] = $key;
		if ( $month ) $fields['month'] = $month;
		if ( $note ) $fields['note'] = $note;
		if ( $number ) $fields['number'] = $number;
		if ( $organization ) $fields['organization'] = $organization;
		if ( $pages ) $fields['pages'] = $pages;
		if ( $publisher ) $fields['publisher'] = $publisher;
		if ( $school ) $fields['school'] = $school;
		if ( $series ) $fields['series'] = $series;
		if ( $title ) $fields['title'] = $title;
		if ( $url ) $fields['url'] = $url;
		if ( $volume ) $fields['volume'] = $volume;
		if ( $year ) $fields['year'] = $year;

		$this->fields = $fields;

		// generating the URI: author last name + year + first letters of title
		$URI = '';
		if ( $author ) {
			$authors = explode( ',', $author );
			$authors = explode( wfMsg( 'and' ), $authors[0] );
			$arrayAuthor = explode( ' ', $authors[0], 2 );
			$URI .= str_replace( ' ', '', $arrayAuthor[array_key_exists( 1, $arrayAuthor ) ? 1 : 0] );
		}
		
		if ( $year ) {
			$URI .= $year;
		}
		
		if ( $title ) {
			foreach ( explode( ' ', $title ) as $titleWord ) {
				$charsTitleWord = preg_split( '//', $titleWord, - 1, PREG_SPLIT_NO_EMPTY );
				
				if ( !empty( $charsTitleWord ) ) {
					$URI .= $charsTitleWord[0];
				}
			}
		}
		
		$this->URI = strtolower( $URI );
	}


	/**
	 * Creates the BibTeX output for a single item.
	 */
	public function text() {
		$text  = '@' . $this->bibTeXtype . '{' . $this->URI . ",\r\n";
		
		foreach ( $this->fields as $key => $value ) {
			$text .= '  ' . $key . ' = "' . $value . '", ' . "\r\n";
		}
		
		$text .= "}\r\n\r\n";

		return $text;
	}

}

/*
info from http://en.wikipedia.org/wiki/Bibtex

# address: Publisher's address (usually just the city, but can be the full address for lesser-known publishers)
# annote: An annotation for annotated bibliography styles (not typical)
# author: The name(s) of the author(s) (in the case of more than one author, separated by and)
# booktitle: The title of the book, if only part of it is being cited
# chapter: The chapter number
# crossref: The key of the cross-referenced entry
# doi: The DOI number of the entry
# edition: The edition of a book, long form (such as "first" or "second")
# editor: The name(s) of the editor(s)
# eprint: A specification of an electronic publication, often a preprint or a technical report
# howpublished: How it was published, if the publishing method is nonstandard
# institution: The institution that was involved in the publishing, but not necessarily the publisher
# journal: The journal or magazine the work was published in
# key: A hidden field used for specifying or overriding the alphabetical order of entries (when the "author" and "editor" fields are missing). Note that this is very different from the key (mentioned just after this list) that is used to cite or cross-reference the entry.
# month: The month of publication (or, if unpublished, the month of creation)
# note: Miscellaneous extra information
# number: The "number" of a journal, magazine, or tech-report, if applicable. (Most publications have a "volume", but no "number" field.)
# organization: The conference sponsor
# pages: Page numbers, separated either by commas or double-hyphens. For books, the total number of pages.
# publisher: The publisher's name
# school: The school where the thesis was written
# series: The series of books the book was published in (e.g. "The Hardy Boys" or "Lecture Notes in Computer Science")
# title: The title of the work
# type: The type of tech-report, for example, "Research Note"
# url: The WWW address
# volume: The volume of a journal or multi-volume book
# year: The year of publication (or, if unpublished, the year of creation)



article
	An article from a journal or magazine.
	Required fields: author, title, journal, year
	Optional fields: volume, number, pages, month, note, key
book
	A book with an explicit publisher.
	Required fields: author/editor, title, publisher, year
	Optional fields: volume, series, address, edition, month, note, key, pages
booklet
	A work that is printed and bound, but without a named publisher or sponsoring institution.
	Required fields: title
	Optional fields: author, howpublished, address, month, year, note, key
conference
	The same as inproceedings, included for Scribe compatibility.
	Required fields: author, title, booktitle, year
	Optional fields: editor, pages, organization, publisher, address, month, note, key
inbook
	A part of a book, usually untitled. May be a chapter (or section or whatever) and/or a range of pages.
	Required fields: author/editor, title, chapter/pages, publisher, year
	Optional fields: volume, series, address, edition, month, note, key
incollection
	A part of a book having its own title.
	Required fields: author, title, booktitle, year
	Optional fields: editor, pages, organization, publisher, address, month, note, key
inproceedings
	An article in a conference proceedings.
	Required fields: author, title, booktitle, year
	Optional fields: editor, pages, organization, publisher, address, month, note, key
manual
	Technical documentation.
	Required fields: title
	Optional fields: author, organization, address, edition, month, year, note, key
mastersthesis
	A Master's thesis.
	Required fields: author, title, school, year
	Optional fields: address, month, note, key
misc
	For use when nothing else fits.
	Required fields: none
	Optional fields: author, title, howpublished, month, year, note, key
phdthesis
	A Ph.D. thesis.
	Required fields: author, title, school, year
	Optional fields: address, month, note, key
proceedings
	The proceedings of a conference.
	Required fields: title, year
	Optional fields: editor, publisher, organization, address, month, note, key
techreport
	A report published by a school or other institution, usually numbered within a series.
	Required fields: author, title, institution, year
	Optional fields: type, number, address, month, note, key
unpublished
	A document having an author and title, but not formally published.
	Required fields: author, title, note
	Optional fields: month, year, key
*/
