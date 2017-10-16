<?php
/**
 * Printer class for creating BibTeX exports
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * For details on availble keys see the README
 *
 * Example of a book :
 *
 * @Book{abramowitz1964homf,
 *   author =	 "Milton Abramowitz and Irene A. Stegun",
 *   title = 	 "Handbook of Mathematical Functions",
 *   publisher = 	 "Dover",
 *   year = 	 1964,
 *   address =	 "New York",
 *   edition =	 "ninth Dover printing, tenth GPO printing"
 * }
 * @file
 * @ingroup SemanticResultFormats
 *
 * @author Markus Krötzsch
 * @author Denny Vrandecic
 * @author Frank Dengler
 * @author Steren Giannini
 * @ingroup SemanticResultFormats
 */
class SRFBibTeX extends SMWExportPrinter {
	protected $m_title = '';
	protected $m_description = '';

	/**
	 * @see SMWIExportPrinter::getMimeType
	 *
	 * @since 1.8
	 *
	 * @param SMWQueryResult $queryResult
	 *
	 * @return string
	 */
	public function getMimeType( SMWQueryResult $queryResult ) {
		return 'text/bibtex';
	}

	/**
	 * @see SMWIExportPrinter::getFileName
	 *
	 * @since 1.8
	 *
	 * @param SMWQueryResult $queryResult
	 *
	 * @return string|boolean
	 */
	public function getFileName( SMWQueryResult $queryResult ) {
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
		return wfMessage( 'srf_printername_bibtex' )->text();
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
				$label = wfMessage( 'srf_bibtex_link' )->inContentLanguage()->text();
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
	 * @param $row array of SMWResultArray
	 *
	 * @return SMWBibTeXEntry
	 */
	protected function getItemForResultRow( array /* of SMWResultArray */ $row ) {
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
						} else {
							$editor = $wikiText;
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
			$authors = explode( wfMessage( 'and' )->text(), $authors[0] );
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
