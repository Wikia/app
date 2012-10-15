<?php

/**
 * Class for the style Wikipedia uses.
 */

class CitationStyleWiki extends Citation {

	/**
	 * Our construct function.
	 */
	public function __construct( $parser, $frame, $args ) {
		parent::__construct($parser, $frame, $args);
	}

	/**
	 * Our rendition
	 */
	public function render() {
		# authors
		if ( count( $this->dAuthors ) > 1 ) {
			# remember element 0 is always set
			$authorArea = $this->createWriterSection (
				$this->dAuthors,
				$this->dAuthorLinks,
				$this->dAuthorTruncate );
			if ( $this->notNull ( $this->dCoAuthors ) )
				$authorArea = wfMsg ( 'ta-citecoauthors',
					$authorArea,
					$this->getSeparator( 'author' ),
					$this->dCoAuthors );
			if ( $this->notNull ( $this->dDate )
				|| $this->notNull ( $this->dYear ) ) {
				$authorArea = wfMsg ( 'ta-citeauthordate',
					$authorArea,
					$this->notNull ( $this->dDate ) ? $this->dDate : $this->dYear );
				if ( $this->notNull ( $this->dYearNote ) )
					$authorArea = wfMsg ( 'ta-citeauthoryearnote',
						$authorArea,
						$this->dYearNote );
			}
			$this->addSection ( $authorArea, array ( 'writer', 'author' ) );
		# editors
		} elseif ( count ( $this->dEditors ) > 1 ) {
			# remember element 0 is always set
			$editorArea = $this->createWriterSection (
				$this->dEditors,
				$this->dEditorLinks,
				$this->dEditorTruncate );
			if ( count ( $this->dEditors ) > 2 )
				$editorArea = wfMsg ( 'ta-citeeditorsplural', $editorArea );
			else
				$editorArea = wfMsg ( 'ta-citeeditorssingular', $editorArea );
			$editorArea .= $this->getSeparator ( 'section' );
			if ( $this->notNull ( $this->dDate )
				|| $this->notNull ( $this->dYear ) ) {
				$editorArea = wfMsg ( 'ta-citeauthordate',
					$editorArea,
					$this->notNull ( $this->dDate ) ? $this->dDate : $this->dYear );
				if ( $this->notNull ( $this->dYearNote ) )
					$editorArea .= wfMsg ( 'ta-citeauthoryearnote',
					$editorArea, $this->dYearNote );
			}
			$this->addSection ( $editorArea, array ( 'writer', 'editor' ) );
		}
		# included work title
		if ( $this->notNull( $this->dWorkTitle['includedwork'] )
			&& ( $this->notNull( $this->dPeriodical['name'] )
				|| $this->notNull( $this->dWorkTitle['transitalic'] )
				|| $this->notNull( $this->dWorkTitle['transtitle'] ) ) ) {
			# let's get the url
			if ( $this->notNull ( $this->dWorkLink['includedwork'] ) ) {
				$url = $this->dWorkLink['includedwork'];
			} else {
				if ( $this->notNull ( $this->dWorkLink['url'] ) ) {
					$url = $this->dWorkLink['url'];
				} else {
					# some explain to me what exactly the following is supposed to mean:
					# <!-- Only link URL if to a free full text - as at PubMedCentral (PMC)-->
					# |{{#ifexpr:{{#time: U}} > {{#time: U | {{{Embargo|2001-10-10}}} }}
					if ( $this->notNull ( $this->dPubMed['pmc'] ) ) {
						$url = wfMsg ( 'ta-citepubmed-url', $this->dPubMed['pmc'] );
					}
				}
			}
			# and now the title
			if ( $this->notNull ( $this->dPeriodical['name'] ) ) {
				$tmp = $this->clean( $this->dWorkTitle['includedwork'] );
				$title = wfMsg ( 'ta-citeincludedworktitle', $tmp );
			} else {
				$tmp = ( $this->notNull ( $this->dWorkTitle['includedwork'] )
					? $this->dWorkTitle['includedwork']
					: '' );
				if ( $this->dWorkTitle['transtitle'] ) {
					if ( $tmp != '' )
						$tmp .= ' ';
					$tmp .= wfMsg( 'ta-citetranstitle-render', $this->dWorkTitle['transtitle'] );
				}
				$title = $tmp;
			}
			$this->addSection ( $this->makeLink ( $url, $title ),
				array ( 'title', 'includedlink' ) );
		} elseif ( $this->notNull ( $this->dWorkTitle['title'] ) ) {
			# if only the title is set, assume url is the URL of the title
			$url = $this->dWorkLink['url'];
			if ( $this->notNull ( $this->dWorkTitle['transtitle'] ) ) {
				$title = wfMsg ( 'ta-citetitletrans',
					$this->dWorkTitle['title'],
					$this->dWorkTitle['transtitle'] );
				if ( $this->notNull ( $this->dLanguage ) ) {
					$this->addSection ( wfMsg ( 'ta-citeinlanguage',
						$this->makeLink ( $url, $title ), $this->dLanguage ),
						array ( 'title', 'transtitle', 'language' ) );
				} else {
					$this->addSection ( $this->makeLink ( $url, $title ),
						array ( 'title', 'transtitle' ) );
				}
			} else {
				$title = $this->dWorkTitle['title'];
				$this->addSection ( $this->makeLink ( $url, $title ),
					array ( 'title' ) );
			}
			$urlDisplayed = true;
		} elseif ( $this->citeType == 'book'
			&& $this->notNull ( $this->dBook['title'] ) ) {
			$this->addSection ( wfMsg ( 'ta-citebooktitle', $this->dBook['title'] ),
				array ( 'title', 'book' ) );
		}
		# place, but only if different from publication place.
		if ( $this->notNull ( $this->dPlace )
			&& (
				!$this->notNull ( $this->dPublication['place'] )
				|| $this->dPlace != $this->dPublication['place']
			) && (
				$this->isTagInSections ( 'writer' )
				|| $this->notNull ( $this->dWorkTitle['includedwork'] )
			) && ( !in_array ( $this->citeType, array ( 'news', 'book' ) ) )
		) {
			if ( $this->notNull ( $this->dPublisher )
				&& ( $this->citeType != 'news' ) ) {
				$this->addSection ( wfMsg ( 'ta-citeplacepublisher',
					$this->dPlace, $this->dPublisher ),
					array ( 'place', 'publisher' ) );
			} else {
				$this->addSection ( wfMsg ( 'ta-citewrittenat', $this->dPlace ),
					array ( 'place' ) );
			}
		}
		if ( ( $this->citeType == 'news' )
			&& $this->notNull ( $this->dPublisher ) ) {
			if ( $this->notNull ( $this->dPlace ) ) {
				$this->addSection ( wfMsg ( 'ta-citenewspublisherplace',
					$this->dPublisher, $this->dPlace ),
					array ( 'publisher', 'place', 'news' ) );
			} else {
				$this->addSection ( wfMsg ( 'ta-citenewspublisher',
					$this->dPublisher ),
					array ( 'publisher', 'news' ) );
			}
		}
		if ( ( $this->citeType == 'journal' )
			&& $this->notNull ( $this->dJournal['title'] ) ) {
			if ( $this->notNull ( $this->dJournal['page'] ) ) {
				$this->addSection ( wfMsg ( 'ta-citejournalpage',
					$this->dJournal['title'],
					$this->dJournal['page'] ),
					array ( 'journal', 'page' ) );
			} else {
				$this->addSection ( wfMsg ( 'ta-citejournal',
					$this->dJournal['title'] ),
					array ( 'journal' ) );
			}
		}
		if ( ( $this->citeType == 'book' )
			&& $this->notNull ( $this->dPublisher ) ) {
			if ( $this->notNull ( $this->dPlace ) ) {
				$this->addSection ( wfMsg ( 'ta-citebookpubplace',
					$this->dPlace, $this->dPublisher ),
					array ( 'publisher', 'place', 'book' ) );
			} else {
				$this->addSection ( wfMsg ( 'ta-citebookpublisher',
					$this->dPublisher ),
					array ( 'publisher', 'book' ) );
			}
			if ( $this->notNull ( $this->dBook['page'] ) ) {
				$this->addSection ( wfMsg ( 'ta-citebookpage',
					$this->dBook['page'] ),
					array ( 'page', 'book' ) );
			}
		}
		# editor of complication... eerrr...
		# TODO: we'll do this later...

		# periodicals
		if ( $this->notNull ( $this->dPeriodical['name'] ) ) {
			$perArea = '';
			if ( $this->notNull ( $this->dOther ) )
				$perArea .= wfMsg ( 'ta-citeother', $this->dOther );
			# make the link!
			if ( $this->notNull ( $this->dWorkTitle['title'] ) || $this->notNull ( $this->dWorkTitle['transtitle'] ) ) {
				# let's get the url
				if ( $this->notNull ( $this->dWorkTitle['includedwork'] ) ) {
					if ( $this->notNull ( $this->dWorkLink['includedwork'] ) ) {
						if ( $this->notNull ( $this->dWorkLink['url'] ) ) {
							$url = $this->dWorkLink['url'];
						} else {
						# some explain to me what exactly the following is supposed to mean:
						# <!-- Only link URL if to a free full text - as at PubMedCentral (PMC)-->
						# |{{#ifexpr:{{#time: U}} > {{#time: U | {{{Embargo|2001-10-10}}} }}
							if ( $this->dPubMed['pmc'] != null ) {
								$url = wfMsg ( 'ta-citepubmed-url', $this->dPubMed['pmc'] );
							}
						}
					}
				} else {
					if ( $this->notNull ( $this->dWorkLink['url'] ) ) {
						$url = $this->dWorkLink['url'];
					} else {
					# some explain to me what exactly the following is supposed to mean:
					# <!-- Only link URL if to a free full text - as at PubMedCentral (PMC)-->
					# |{{#ifexpr:{{#time: U}} > {{#time: U | {{{Embargo|2001-10-10}}} }}
						if ( $this->dPubMed['pmc'] != null ) {
							$url = wfMsg ( 'ta-citepubmed-url', $this->dPubMed['pmc'] );
						}
					}
				}
				# and now the title
				$tmp = $this->notNull ( $this->dWorkTitle['title'] )
					? $this->dWorkTitle['title']
					: '';
				if ( $this->notNull ( $this->dWorkTitle['transtitle'] ) ) {
					if ( $tmp != '' )
						$tmp .= ' ';
					$tmp .= wfMsg ( 'ta-citetranstitle-render', $this->dWorkTitle['transtitle'] );
				}
				$title = "\"$tmp\"";
				$perArea .= $this->makeLink ( $url, $title ) . $this->getSeparator ( 'section' );
				if ( $this->notNull ( $this->dWorkTitle['note'] ) ) {
					$perArea .= $this->dWorkTitle['note'] . $this->getSeparator ( 'section' );
				}
			}
			$this->addSection ( $perArea,
				array ( 'title', 'periodicals' ) );
		}
		# language
		if ( $this->notNull ( $this->dLanguage )
			&& !$this->isTagInSections ( 'language' ) ) {
			$this->addSection ( wfMsg ( 'ta-citeinlanguage',
				$this->dLanguage ), array ( 'language' ) );
		}
		# format
		if ( $this->notNull ( $this->dFormat ) ) {
			$this->addSection ( wfMsg ( 'ta-citeformatrender',
				$this->dFormat ), array ( 'format' ) );
		}
		# more periodical!
		if ( $this->notNull ( $this->dPeriodical['name'] ) ) {
			$newPerArea = '';
			$newPerArea .= wfMsg ( 'ta-citeperiodical', $this->clean ( $this->dPeriodical['name'] ) );
			if ( $this->notNull ( $this->dSeries ) ) {
				$newPerArea .= wfMsg ( 'ta-citeseries', $this->dSeries );
			}
			if ( $this->notNull ( $this->dPublication['place'] ) ) {
				if ( $this->notNull ( $this->dPublisher ) ) {
					$newPerArea .= wfMsg ( 'ta-citepublicationplaceandpublisher', $this->dPublication['place'], $this->dPublisher );
				} else {
					$newPerArea .= wfMsg ( 'ta-citepublicationplace', $this->dPublication['place'] );
				}
			}
			if ( $this->notNull ( $this->dVolume ) ) {
				$newPerArea .= wfMsg ( 'ta-citevolumerender', $this->dVolume );
				if ( $this->notNUll ( $this->dIssue ) ) {
					$newPerArea .= wfMsg ( 'ta-citeissuerender', $this->dIssue );
				}
			} else {
				if ( $this->notNUll ( $this->dIssue ) ) {
					$newPerArea .= wfMsg ( 'ta-citeissuerender', $this->dIssue );
				}
			}
			if ( $this->notNull ( $this->dAt ) ) {
				$newPerArea .= wfMsg ( 'ta-citeatrender', $this->dAt );
			}
			$newPerArea .= $this->getSeparator ( 'section' );
			# now we get to the title!  Exciting stuff!
			if ( $this->notNull ( $this->dWorkTitle['title'] )
				|| $this->notNull ( $this->dWorkTitle['transitalic'] ) ) {
				# let's get the url
				if ( $this->notNull ( $this->dWorkTitle['includedwork'] ) ) {
					if ( $this->notNull ( $this->dWorkLink['includedwork'] ) ) {
						if ( $this->notNull ( $this->dWorkLink['url'] ) ) {
							$url = $this->dWorkLink['url'];
						} else {
						# some explain to me what exactly the following is supposed to mean:
						# <!-- Only link URL if to a free full text - as at PubMedCentral (PMC)-->
						# |{{#ifexpr:{{#time: U}} > {{#time: U | {{{Embargo|2001-10-10}}} }}
							if ( $this->dPubMed['pmc'] != null ) {
								$url = wfMsg ( 'ta-citepubmed-url', $this->dPubMed['pmc'] );
							}
						}
					}
				} else {
					if ( $this->notNull ( $this->dWorkLink['url'] ) ) {
						$url = $this->dWorkLink['url'];
					} else {
					# some explain to me what exactly the following is supposed to mean:
					# <!-- Only link URL if to a free full text - as at PubMedCentral (PMC)-->
					# |{{#ifexpr:{{#time: U}} > {{#time: U | {{{Embargo|2001-10-10}}} }}
						if ( $this->dPubMed['pmc'] != null ) {
							$url = wfMsg ( 'ta-citepubmed-url', $this->dPubMed['pmc'] );
						}
					}
				}
				# and now the title
				$tmp = $this->notNull ( $this->dWorkTitle['title'] )
					? $this->dWorkTitle['title']
					: '';
				if ( $this->notNull ( $this->dWorkTitle['transitalic'] ) ) {
					if ( $tmp != '' )
						$tmp .= ' ';
					$tmp .= wfMsg ( 'ta-citetranstitle-render', $this->dWorkTitle['transitalic'] );
				}
				$tmp = $this->clean ( $tmp );
				$title = wfMsg ( 'ta-citeperiodicaltitle', $tmp );
				$newPerArea .= $this->makeLink ( $url, $title );
			}
			# may change this into some if () statements though,
			# it is easier to write this, but it also means that all of the
			# second input is actually evaluated, even if it contains nothing.
			$newPerArea .= $this->addNotNull ( $this->dWorkTitle['type'],
				wfMsg ( 'ta-citetitletyperender', $this->dWorkTitle['type'] ) . $this->getSeparator ( 'section' ) );
			$newPerArea .= $this->addNotNull ( $this->dSeries,
				wfMsg ( 'ta-citeseries', $this->dSeries ) . $this->getSeparator ( 'section' ) );
			$newPerArea .= $this->addNotNull ( $this->dVolume,
				wfMsg ( 'ta-citevolumerender', $this->dVolume ) . $this->getSeparator ( 'section' ) );
			$newPerArea .= $this->addNotNull ( $this->dOther,
				wfMsg ( 'ta-citeother', $this->dOther ) );
			$newPerArea .= $this->addNotNull ( $this->dEdition,
				wfMsg ( 'ta-citeeditionrender', $this->dEdition ) . $this->getSeparator ( 'section' ) );
			$newPerArea .= $this->addNotNull ( $this->dPublication['place'],
				wfMsg ( 'ta-citepublication', $this->dPublication['place'] ) );
			if ( $this->notNull ( $this->dPublisher ) ) {
				if ( $this->notNull ( $this->dPublication['place'] ) ) {
					$sep = $this->getSeparator ( 'beforepublication' );
				} else {
					$sep = $this->getSeparator ( 'section' );
				}
				$newPerArea .= $sep . wfMsg ( 'ta-citepublisherrender', $this->dPublisher );
			}
			$this->addSection ( $newPerArea,
				array ( 'details', 'periodicals' ) );
		}
		# date if no author/editor
		if ( !$this->isTagInSections ( 'writer' ) ) {
			if ( $this->notNull ( $this->dDate )
				|| $this->notNull ( $this->dYear ) ) {
				$tmp = wfMsg ( 'ta-citealonedate', $this->notNull ( $this->dDate ) ? $this->dDate : $this->dYear );
				if ( $this->notNull ( $this->dYearNote ) ) {
					$tmp = wfMsg ( 'ta-citeauthoryearnote', $tmp, $this->dYearNote );
				}
				$this->addSection ( $tmp, array ( 'date' ) );
			}
		}
		# publication date
		if ( $this->notNull ( $this->dPublication['date'] )
			&& $this->dPublication['date'] != $this->dDate ) {
			if ( $this->isTagInSections ( 'editor' ) ) {
				if ( $this->isTagInSections ( 'author' ) ) {
					$this->addSection ( wfMsg ( 'ta-citepublicationdate', $this->dPublication['date'] ),
						array ( 'publication date', 'periodical' ) );
				} else {
					$this->addSection ( wfMsg ( 'ta-citepublished', $this->dPublication['date'] ),
						array ( 'publication date', 'periodical' ) );
				}
			} else {
				if ( $this->notNull ( $this->dPeriodical['name'] ) ) {
					$this->addSection ( wfMsg ( 'ta-citepublicationdate', $this->dPublication['date'] ),
						array ( 'publication date', 'periodical' ) );
				} else {
					$this->addSection ( wfMsg ( 'ta-citepublished', $this->dPublication['date'] ),
						array ( 'publication date', 'periodical' ) );
				}
			}
		}
		# page within included work
		if ( !$this->notNull ( $this->dPeriodical['name'] )
			&& $this->notNull ( $this->dAt ) ) {
			$this->addSection ( wfMsg ( 'ta-citeatseparated', $this->dAt ),
				array ( 'at', 'periodical' ) );
		}
		# doi
		# TODO:  I'll do this code later:
		# {{{Sep|,}}}&#32;{{citation/identifier  |identifier=doi |input1={{{DOI|}}}  |input2={{{DoiBroken|}}} }}

		# misc identifier
		# TODO: Awh shit.
		# #if: {{{ID|}}}
        #  |{{
        #     #if: {{{Surname1|}}}{{{EditorSurname1|}}}{{{IncludedWorkTitle|}}}{{{Periodical|}}}{{{Title|}}}{{{TransItalic|}}}
        #     |{{{Sep|,}}}&#32;{{{ID}}}
        #     |{{{ID}}}
        #   }}
		# isbn
		if ( $this->citeType == 'book'
			&& $this->notNull ( $this->dBook['isbn'] ) ) {
			$this->addSection ( wfMsg ( 'ta-citebookisbn',
				$this->dBook['isbn'],
				$this->createDisplayISBN ( $this->dBook['isbn'] ) ),
				array ( 'isbn' ) );
		}

		# more identifiers:
		# TODO: Do all this crap.
		/*
<!--============  ISSN ============-->
  #if: {{{ISSN|}}}
  |{{{Sep|,}}}&#32;{{citation/identifier  |identifier=issn |input1={{{ISSN|}}} }}
}}{{
<!--============  OCLC ============-->
  #if: {{{OCLC|}}}
  |{{{Sep|,}}}&#32;{{citation/identifier  |identifier=oclc |input1={{{OCLC|}}} }}
}}{{
<!--============  PMID ============-->
  #if: {{{PMID|}}}
  |{{{Sep|,}}}&#32;{{citation/identifier  |identifier=pmid |input1={{{PMID|}}} }}
}}{{
<!--============  PMC ============-->
  #if: {{{PMC|}}}
  |{{
     #if: {{{URL|}}}
     |{{{Sep|,}}}&#32;{{citation/identifier  |identifier=pmc |input1={{{PMC|}}} }}
     |{{only in  print|{{{Sep|,}}}&#32;{{citation/identifier  |identifier=pmc |input1={{{PMC|}}} }} }}<!--Should  only display by default in print-->
   }}
}}{{
<!--============ BIBCODE ============-->
  #if: {{{Bibcode|}}}
  |{{{Sep|,}}}&#32;{{citation/identifier  |identifier=bibcode |input1={{{Bibcode|}}} }}
}}
		*/

		# archive data, etc.
		# TODO: Yeah, O_O

		# URL and accessdate
		if ( $this->notNull ( $this->dWorkLink['url'] )
			|| $this->notNull ( $this->dWorkLink['includedwork'] ) ) {
			if ( !$urlDisplayed ) {
				if ( $this->notNull ( $this->dWorkTitle['title'] )
					|| $this->notNull ( $this->dWorkTitle['includedwork'] )
					|| $this->notNull ( $this->dWorkTitle['transtitle'] ) ) {
					$this->addSection ( $this->printOnly (
							( $this->notNull ( $this->dWorkLink['includedwork'] )
								? $this->dWorkLink['includedwork']
								: $this->dWorkLink['url'] ) ),
							array ( 'url', 'printonly' ),
							false );
				} else {
					$this->addSection (
						( $this->notNull ( $this->dWorkLink['includedwork'] )
							? $this->dWorkLink['includedwork']
							: $this->dWorkLink['url'] ),
						array ( 'url' ),
						false );
				}
			}
			if ( $this->notNull ( $this->dAccessDate ) ) {
				if ( $this->getSeparator ( 'section', false ) == '.' )
					$tmp = wfMsg ( 'ta-citeretrievedupper', $this->dAccessDate );
				else
					$tmp = wfMsg ( 'ta-citeretrievedlower', $this->dAccessDate );
				$this->addSection ( wfMsg ( 'ta-citeaccessdatespan', $tmp ),
					array ( 'accessdate' ) );
			}
		}

		# layman stuff
		# TODO

		# quote
		# TODO

		# some other shit nobody cares about.
		# COinS?  waaaaat
		# TODO

		$this->finishRender();
	}
}
