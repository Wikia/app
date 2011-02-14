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

	protected function getResultText( $res, $outputmode ) {
		global $smwgIQRunningNumber, $wgSitename, $wgServer, $wgRequest;
		$result = '';
		$items = array();
		if ( $outputmode == SMW_OUTPUT_FILE ) { // make file
			if ( $this->m_title == '' ) {
				$this->m_title = $wgSitename;
			}
			$row = $res->getNext();
			while ( $row !== false ) {
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

				foreach ( $row as $field ) {
					$req = $field->getPrintRequest();

					if ( ( strtolower( $req->getLabel() ) == "type" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$type = $value->getShortWikiText();
						}
					}


					if ( ( strtolower( $req->getLabel() ) == "address" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$address = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "annote" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$annote = $value->getShortWikiText();
						}
					}
					/* for flexibility, we permit 'author' or 'authors' */
					if ( ( strtolower( $req->getLabel() ) == "author" ) || ( strtolower( $req->getLabel() ) == "authors" )  ) {
						foreach ( $field->getContent() as $value ) {
							$author .= ( $author ? ' and ':'' ) . $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "booktitle" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$booktitle = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "chapter" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$chapter = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "crossref" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$crossref = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "doi" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$doi = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "edition" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$edition = $value->getShortWikiText();
						}
					}
					/* for flexibility, we permit 'editor' or 'editors' */
					if ( ( strtolower( $req->getLabel() ) == "editor" ) || ( strtolower( $req->getLabel() ) == "editors" ) ) {
						foreach ( $field->getContent() as $value ) {
							$editor .= ( $editor ? ' and ':'' ) . $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "eprint" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$eprint = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "howpublished" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$howpublished = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "institution" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$institution = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "journal" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$journal = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "key" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$key = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "note" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$note = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "number" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$number = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "organization" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$organization = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "pages" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$pages = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "publisher" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$publisher = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "school" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$school = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "series" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$series = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "title" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$title = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "url" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$url = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "volume" ) || ( strtolower( $req->getLabel() ) == "journal_volume" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$volume = $value->getShortWikiText();
						}
					}



					/*if we input a full date for the "month" and "year" BibTeX attributes, extract the month and year*/
					if ( ( strtolower( $req->getLabel() ) == "date" ) ) {
						$value = current( $field->getContent() );
						if ( get_class( $value ) == 'SMWTimeValue' ) {
							if ( $value !== false ) {
							$year = $value->getYear();
							$month = $value->getMonth();
							}
						}
					}

					if ( ( strtolower( $req->getLabel() ) == "year" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$year = $value->getShortWikiText();
						}
					}
					if ( ( strtolower( $req->getLabel() ) == "month" ) ) {
						$value = current( $field->getContent() );
						if ( $value !== false ) {
						$month = $value->getShortWikiText();
						}
					}


				}
				$items[] = new SMWBibTeXEntry( $type, $address, $annote, $author, $booktitle, $chapter, $crossref, $doi, $edition, $editor, $eprint, $howpublished, $institution, $journal, $key, $month, $note, $number, $organization, $pages, $publisher, $school, $series, $title, $url, $volume, $year );
				$row = $res->getNext();
			}
			foreach ( $items as $item ) {
				$result .= $item->text();
			}
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

	public function getParameters() {
		$params = parent::exportFormatParameters();
		return $params;
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

	public function SMWBibTeXEntry( $type, $address, $annote, $author, $booktitle, $chapter, $crossref, $doi, $edition, $editor, $eprint, $howpublished, $institution, $journal, $key, $month, $note, $number, $organization, $pages, $publisher, $school, $series, $title, $url, $volume, $year ) {
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
			$arrayAuthor = explode( ' ', $author );
			if ( array_key_exists( 1, $arrayAuthor ) ) $URI .= $arrayAuthor[1];
		}
		if ( $year ) $URI .= $year;
		if ( $title ) {
			$arrayTitle = explode( ' ', $title );
			foreach ( $arrayTitle as $titleWord ) {
						$charsTitleWord = preg_split( '//', $titleWord, - 1, PREG_SPLIT_NO_EMPTY );
						$URI .= $charsTitleWord[0];
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
