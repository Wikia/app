<?php

class Citation extends TemplateAdventureBasic {

	protected $citeStyle = null;     # citation style
	protected $citeType = null;        # type of citation, e.g. 'news'
	                                 # currently only 'news' supported.
	protected $dSeparators = array(    # separators between names, items, etc.
		'section'    => ',',
		'end'        => '.',
		'author'     => '&#059;',
		'name'       => ',',
		'authorlast' => '&#32;&amp;',
		'beforepublication' => ':',
	);
	protected $dAuthorTruncate = 8;    # the amount of authors it should display,
	                                 # if truncated, 'et al' will be used instead.
	protected $dAuthors = array(null);     # array of authors
	protected $dAuthorLinks = array(null); # array of authorlinks (tied to authors).
	protected $dCoAuthors = null;          # coauthors is as far as I understand it
	                                     # just a string, but prove me wrong!
	protected $dEditors = array(null);     # array of editors
	protected $dEditorLinks = array(null); # array of editorlinks (tied to editors).
	                                     # they all contain 'junk' to avoid the
	                                     # usage of [0].
	protected $dAuthorBlock = null;    # authorblock of em length
	protected $dDate = null;           # the date set
	protected $dAccessDate = null;     # date accessed
	protected $dYear = null;           # year of authorship or publication
	protected $dYearNote = null;       # note to accompany the year
	protected $dWorkTitle = array(     # data related to the title
		'title'        => null,
		'transtitle'   => null,      # translated title (if original title is
		                             # in a foreign language).
	    'transitalic'  => null,      # translated title in italic
		'includedwork' => null,
		'type'         => null,      # the title type
		'note'         => null,
	);
	protected $dWorkLink = array(      # data related to the link
		'url'          => null,
		'originalurl'  => null,
		'includedwork' => null,
	);
	protected $dAt = null;             # wherein the source
	protected $dArchived = array(      # information about its archiving if archived
		'url'          => null,
		'date'         => null,
	);
	protected $dPubMed = array(
		'pmc'          => null,      # PMC link
		'pmid'         => null,      # PMID
	);
	protected $dSeries = null;         # whether it is part of a series
	protected $dQuote = null;          # quote
	protected $dPublisher = null;      # publisher
	protected $dPublication = array(   # publication
		'data'         => null,
		'place'        => null,
	);
	protected $dPlace = null;          # place of writing
	protected $dPeriodical = array(    # name of periodical, journal or magazine.
	    'name'  => null,             # ensures it will be rendered as such
	    'issue' => null,
	    'issn'  => null,
	);
	protected $dLibrary = null;        # library id
	protected $dBook = array(          # a book
		'title' => null,
		'isbn'  => null,
		'page'  => null
	);
	protected $dLayman = array(        # an article of the same publication, but
	                                 # written in more layman friendly fashion.
		'data'    => null,
		'summary' => null
	);
	protected $dLanguage = null;       # language of the publication
	protected $dId = null;             # misc id
	protected $dEdition = null;        # edition
	protected $dDoi = array(           # digital object identifier
		'id'     => null,
		'broken' => null,            # date broken
	);
	protected $dBibcode = null;        # bibcode id
	protected $dJournal = array(       # journal and its page
		'title'  => null,
		'page'   => null,
	);
	protected $dOther = null;          # other stuff

	protected $mSections = array();    # sections of the citation.
	protected $mTags = array();        # all tags

	/**
	 * Our construct function.
	 */
	public function __construct( $parser, $frame, $args ) {
		parent::__construct($parser, $frame, $args);
		# init data
		$this->dSeparators['section']    = wfMsg ( 'ta-citesep-section' );
		$this->dSeparators['author']     = wfMsg ( 'ta-citesep-author' );
		$this->dSeparators['name']       = wfMsg ( 'ta-citesep-name' );
		$this->dSeparators['authorlast'] = wfMsg ( 'ta-citesep-authorlast' );
		$this->dSeparators['beforepublication'] = wfMsg ( 'ta-citesep-beforepublication' );
		$this->dSeparators['end']        = wfMsg ( 'ta-citesep-end' );
		$this->readOptions( );
		$this->parseData();
	}

	/**
	 * Add a section to mSections.
	 *
	 * @param $content The content of section.
	 * @param $tags [default: array()] Some information regarding the content.
	 * @param $separator [default: true] Whether it shall have a separator at
	 *                                   the end.
	 */
	protected function addSection ( $content, $tags = array (), $separator = true ) {
		$this->mSections[] = array (
			$content,
			$tags,
			$separator
		);
		$this->mTags = array_merge ( $this->mTags, $tags );
	}

	/**
	 * Detect if a tag has been set in a section.
	 *
	 * Note that parent means the first tag of a section's array tag, which
	 * describes - in most cases at least - what the content is, while the
	 * other tags further details this.  It may sometimes be important to find
	 * a tag only if its parent tag is something specific.
	 *
	 * @param $tag Tag to search for.
	 * @param $parent [optional] The tag's parent.
	 * @return Boolean True if found, false if not.
	 */
	protected function isTagInSections ( $tag, $parent = null ) {
		if ( $this->notNull ( $parent ) ) {
			foreach ( $this->mSection as $section ) {
				if ( in_array ( $tag, $section[1] )
					&& $section[1][0] == $parent )
					return true;
			}
			return false;
		} else {
			return in_array ( $tag, $this->mTags );
		}
	}

	/**
	 * Render the data after the data have been read.
	 *
	 * TODO: Clean this baby up, probably be assigning some help functions.
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

	/**
	 * Combines the sections to output.
	 */
	protected function finishRender () {
		$this->mOutput = '';

		$len = count ( $this->mSections );

		foreach ( $this->mSections as $i => $section ) {
			$this->mOutput .= $section[0];
			if ( ( $i + 1 < $len )
				&& $section[2] )
				$this->mOutput .= $this->getSeparator ( 'section' );
		}

		$this->mOutput .= $this->getSeparator ( 'end' );

		# if the end 'separator' is blank, so we trim
		$this->mOutput = wfMsg ( 'ta-citationspan', trim($this->mOutput), $this->citeType );

	}

	/**
	 * Create the rendered version of an ISBN number.
	 *
	 * @param $isbn The raw ISBN number.
	 * @return $isbn The rendered version.
	 */
	protected function createDisplayISBN ( $isbn ) {
		return $isbn[0] . '-' . $isbn[1] . $isbn[2] . $isbn[3] . $isbn[4] . '-' . $isbn[5] . $isbn[6] . $isbn[7] . $isbn[8] . '-' . $isbn[9];
	}

	/**
	 * Surround the string in a span tag that tells the css not to render it
	 * unless it for print.
	 *
	 * @param $string
	 * @return $string
	 */
	protected function printOnly ( $string ) {
		return wfMsg ( 'ta-citeprintonlyspan', $string );
	}

	/**
	 * Return something if it is not null.
	 *
	 * @param $check Variable to check against.
	 * @param $add String to add.
	 * @return $add if check is not null else ''
	 */
	protected function addNotNull ( $check, $add ) {
		if ( $this->notNull ( $check ) )
			return $add;
		return '';
	}

	/**
	 * Clean a string for characters that might confuse the parser.
	 *
	 * @param $value The string to be cleaned.
	 * @return The cleaned string.
	 */
	protected function clean ( $value ) {
		return str_replace ( "'", '&#39;', $value );
	}

	/**
	 * Create the section for authors, editors, etc. in a neat similar function.
	 *
	 * @param $writers Authors, editors, etc. array
	 * @param $links Their links if any
	 * @param $truncate When to truncate the amount of data.
	 * @return The created area.
	 */
	protected function createWriterSection ( $writers, $links, $truncate ) {
		$area = '';
		$n = 1;
		foreach ( $writers as $i => $writer ) {
			if ( $i == 0 )
				continue;
			if ( $i > 1 && $truncate <= $i ) {
				$area = wfMsg( "ta-citeetal", $area );
				break;
			}
			if ( $n == count($writers)-1 && $i != 1 )
				$area .= $this->getSeparator( 'authorlast' );
			elseif ( $n > 1 )
				$area .= $this->getSeparator( 'author' );
			$tmp = '';
			if ( $writer[0] ) {
				if ( $writer[1][1] == null )
					continue;
				$tmp .= $writer[1][1];
				if ( $writer[1][0] != null )
					$tmp .= $this->getSeparator( 'name' ) . $writer[1][0];
			} else {
				if ( is_array ( $writer[1] ) ) {
					# maybe we shan't support no surname/given name structure
					# in the future, but we'll leave it like this for now.
					$tmp .= $writer[1][1];
				} else {
					$tmp .= $writer[1];
				}
			}
			if ( isset ( $links[$i] ) )
				$tmp = "[{$links[$i]} $tmp]";
			$area .= $tmp;
			$n++;
		}
		return $area;
	}

	/**
	 * Create a wikilink.  If no $url, return the $title.
	 *
	 * @param $url The url
	 * @param $title Title for the URL.
	 * @return $title if no $url otherwise the link.
	 */
	protected function makeLink ( $url, $title ) {
		if ( !$url )
			return $title;
		return "[$url $title]";
	}

	/**
	 * Check if $check is not null, where blank ('') is considered null.
	 *
	 * @param $check Variable to check
	 * @return Boolean
	 */
	protected function notNull ( $check ) {
		return !( $check == null && trim ( $check ) === '' );
	}

	/**
	 * This function should in the future do some wfMsg() magic to check if
	 * they are using a set separator message or just using a default one.
	 *
	 * @param $name Name of separator; section, author, name or authorlast
	 * @param $addSpace Whether to add a space at the end; default true
	 * @return $separator Blank if none found.
	 */
	protected function getSeparator ( $name, $addSpace=true ) {
		if ( !isset($this->dSeparators[$name]) )
			return '';
		$sep = $this->dSeparators[$name];
		if ( $addSpace )
			return $sep.' ';
		return $sep;
	}

	/**
	 * This function parses the data the given to it during the readOptions()
	 * run.  Basically to disregard data and such that has been found to be
	 * outside the allowed logic of this 'template'.
	 */
	protected function parseData() {
		# check $dAuthors for only 'given' names.
		$tmpAuthors = array(null);
		foreach( $this->dAuthors as $i => $author ) {
			if ( $i == 0 )
				continue;
			if ( $author[0] && $author[1][1] == null )
				continue;
			$tmpAuthors[$i] = $author;
		}
		$this->dAuthors = $tmpAuthors;
	}

	/**
	 * This is the editor function section.  These functions are designed to
	 * add editors (which are considered different from authors) to the
	 * template, as there can be an inf amount of editors/authors.
	 *
	 * This adds the link for the editor.
	 *
	 * @param $name Editor-reference.
	 * @param $value Link
	 */
	protected function addEditorLink( $name, $value ) {
		if ( $name[1] == null )
			return;
		$this->dEditorLinks[$name[1]] = $value;
	}

	/**
	 * Adds a new editor, but does not divide it into first and last names.
	 *
	 * @param $name Editor-reference.
	 * @param $value Name
	 */
	protected function addEditor( $name, $value ) {
		$this->appendEditorData ( $name[1], $value );
	}

	/**
	 * Adds surname.
	 *
	 * @param $name Editor-reference.
	 * @param $value Surname
	 */
	protected function addEditorSurname( $name, $value ) {
		$this->appendEditorData ( $name[1], array ( null, $value ) );
	}

	/**
	 * Adds first name.
	 *
	 * @param $name Editor-reference.
	 * @param $value Given name
	 */
	protected function addEditorGivenName ( $name, $value ) {
		$this->appendEditorData ( $name[1], array ( $value, null ) );
	}

	/**
	 * Appends the editor to the editor array.
	 *
	 * @param $num Editor-reference.
	 * @param $name Details
	 */
	protected function appendEditorData( $num, $name ) {
		$this->appendWriterData( $this->dEditors, $num, $name );
	}

	/**
	 * These functions are similar to the editor functions and does the same,
	 * but for the author variables.  Their functionality could possibly be
	 * referenced in grouped help functions, but right now they are all so
	 * short that it seems to be an overhead of useless work.
	 *
	 * @param $name Author-reference
	 * @param $value Link
	 */
	protected function addAuthorLink( $name, $value ) {
		if ( $name[1] == null )
			return;
		$this->dAuthorLinks[$name[1]] = $value;
	}

	/**
	 * @param $name Author-reference
	 * @param $value Full name
	 */
	protected function addAuthor( $name, $value ) {
		$this->appendAuthorData ( $name[1], $value );
	}

	/**
	 * @param $name Author-reference
	 * @param $value Surname
	 */
	protected function addAuthorSurname( $name, $value ) {
		$this->appendAuthorData ( $name[1], array ( null, $value ) );
	}

	/**
	 * @param $name Author-reference
	 * @param $value Given name
	 */
	protected function addAuthorGivenName ( $name, $value ) {
		$this->appendAuthorData ( $name[1], array ( $value, null ) );
	}

	/**
	 * @param $num Author-reference
	 * @param $name Details
	 */
	protected function appendAuthorData( $num, $name ) {
		$this->appendWriterData( $this->dAuthors, $num, $name );
	}

	/**
	 * This function appends the details (link and name) of authors or editors
	 * to their respective arrays.
	 *
	 * @param $array The array.
	 * @param $num The location in the array (0 is always set, but never used)
	 * @param $name The name and link of the author/editor.
	 */
	protected function appendWriterData( &$array, $num, $name ) {
		$split = is_array( $name );
		if ( $num == null )
			# if no number, assume it is the first.
			$num = 1;
		if ( isset($array[$num]) && $array[$num][0] ) {
			if ( $name[0] != null )
				$array[$num][1][0] = $name[0];
			else
				$array[$num][1][1] = $name[1];
		} else {
			$array[$num] = array (
				$split,
				$name
			);
		}
	}

	/**
	 * This is a generic function to add more parameters that don't need special
	 * treatment to their correct locations.
	 *
	 * @param $name Name of the parameter.
	 * @param $value The value to be inserted.
	 */
	protected function addOtherStringValue ( $name, $value ) {
		switch ( $name[0] ) {
			case 'url':
				$this->dWorkLink['url'] = $value;
				break;
			case 'title':
				switch ( $this->citeType ) {
					case 'book':
						$this->dBook['title'] = $value;
						break;
					case 'journal':
					case 'web':
					case 'news':
					default:
						$this->dWorkTitle['title'] = $value;
						break;
				}
				break;
			case 'transtitle':
				$this->dWorkTitle['transtitle'] = $value;
				break;
			case 'language':
				$this->dLanguage = $value;
				break;
			case 'includedworktitle':
				$this->dWorkTitle['includedwork'] = $value;
				break;
			case 'periodical':
				$this->dPeriodical['name'] = $value;
				break;
			case 'year':
				$this->dYear = $value;
				break;
			case 'date':
				$this->dDate = $value;
				break;
			case 'place':
				$this->dPlace = $value;
				break;
			case 'publisher':
				$this->dPublisher = $value;
				break;
			case 'coauthors':
				$this->dCoAuthors = $value;
				break;
			case 'accessdate':
				$this->dAccessDate = $value;
				break;
			case 'journal':
				$this->dJournal['title'] = $value;
				break;
			case 'page':
				switch ( $this->citeType ) {
					case 'journal':
						$this->dJournal['page'] = $value;
						break;
					case 'book':
						$this->dBook['page'] = $value;
						break;
				}
				break;
			case 'isbn':
				$this->dBook['isbn'] = str_replace ( '-', '', $value );
				break;
		}
	}

	/**
	 * Checks whether the data provided is a known option.
	 *
	 * @param $var The variable
	 * @param $value The value
	 * @return True if option, false if not.
	 */
	protected function optionParse( $var, $value ) {
		if ( !$this->notNull ( $value ) )
			return;
		$name = self::parseOptionName( $var );
		switch ( $name[0] ) {
			case 'author':
				$this->addAuthor( $name, $value );
				break;
			case 'authorsurname':
				$this->addAuthorSurname( $name, $value );
				break;
			case 'authorgiven':
				$this->addAuthorGivenName( $name, $value );
				break;
			case 'authorlink':
				$this->addAuthorLink( $name, $value );
				break;
			case 'editor':
				$this->addEditor( $name, $value );
				break;
			case 'editorsurname':
				$this->addEditorSurname( $name, $value );
				break;
			case 'editorgiven':
				$this->addEditorGivenName( $name, $value );
				break;
			case 'editorlink':
				$this->addEditorLink( $name, $value );
				break;
			case 'coauthors':
			case 'url':
			case 'title':
			case 'pmc':
			case 'includedworktitle':
			case 'periodical':
			case 'transitalic':
			case 'transtitle':
			case 'year':
			case 'date':
			case 'place':
			case 'publisher':
			case 'language':
			case 'accessdate':
			case 'journal':
			case 'page':
			case 'isbn':
				$this->addOtherStringValue( $name, $value );
				break;
			default:
				# Wasn't an option after all
				return false;
		}
		return true;
	}

	/**
	 * This function handles the first item of the variable.  For {{#citation:}}
	 * the first item defines the type of the citation; which is important the
	 * rendering of the function.
	 *
	 * @param $item The raw item.
	 */
	protected function handlePrimaryItem( $item ) {
		if ( in_array ( $item, array ( 'web', 'news', 'journal', 'book' ) ) )
			$this->citeType = $item;
	}

	/**
	 * This one parses the variable name given to optionParse to figure out
	 * whether this is a known parameter to this template.
	 *
	 * @param $value The parameter.
	 * @return The parameter's true name (for localisations purposes, etc.) as
	 *         well as its numeral found with it or false if not.
	 */
	protected function parseOptionName( $value ) {
		global $wgContLang;

		static $magicWords = null;
		if ( $magicWords === null ) {
			$magicWords = new MagicWordArray( array(
				'ta_cc_author', 'ta_cc_authorgiven',
				'ta_cc_authorsurname', 'ta_cc_authorlink',
				'ta_cc_coauthors',
				'ta_cc_editor', 'ta_cc_editorgiven',
				'ta_cc_editorsurname', 'ta_cc_editorlink',
				'ta_cc_url', 'ta_cc_title', 'ta_cc_pmc',
				'ta_cc_includedworktitle', 'ta_cc_periodical',
				'ta_cc_transitalic', 'ta_cc_transtitle',
				'ta_cc_year', 'ta_cc_publisher',
				'ta_cc_place', 'ta_cc_transtitle',
				'ta_cc_language', 'ta_cc_date',
				'ta_cc_accessdate', 'ta_cc_page',
				'ta_cc_journal', 'ta_cc_isbn',
			) );
		}

		$num = preg_replace("@.*?([0-9]+)$@is", '\1', $value);
		if ( is_numeric( $num ) )
			$name = preg_replace("@(.*?)[0-9]+$@is", '\1', $value);
		else {
			$name = $value;
			$num = null;
		}

		$name = $wgContLang->lc( $name );

		if ( $name = $magicWords->matchStartToEnd( trim($name) ) ) {
			return array(
				str_replace( 'ta_cc_', '', $name ),
				$num,
			);
		}

		# blimey, so not an option!?
		return array( false, null );
	}
}
