<?php
/**
 * Classes for InputBox extension
 *
 * @file
 * @ingroup Extensions
 */

// InputBox class
class InputBox {

	/* Fields */

	private $mParser;
	private $mType = '';
	private $mWidth = 50;
	private $mPreload = '';
	private $mEditIntro = '';
	private $mSummary = '';
	private $mMinor = '';
	private $mPage = '';
	private $mBR = 'yes';
	private $mDefaultText = '';
	private $mBGColor = 'transparent';
	private $mButtonLabel = '';
	private $mSearchButtonLabel = '';
	private $mFullTextButton = '';
	private $mLabelText = '';
	private $mHidden = '';
	private $mNamespaces = '';
	private $mID = '';
	private $mInline = false;
	private $mPrefix = '';

	/* Functions */

	public function __construct( $parser ) {
		$this->mParser = $parser;
	}

	public function render() {
		// Internationalization
		wfLoadExtensionMessages( 'InputBox' );

		// Handle various types
		switch( $this->mType ) {
			case 'create':
			case 'comment':
				return $this->getCreateForm();
			case 'commenttitle':
				return $this->getCommentForm();
			case 'search':
				return $this->getSearchForm('search');
			case 'fulltext':
				return $this->getSearchForm('fulltext');
			case 'search2':
				return $this->getSearchForm2();
			default:
				return Xml::tags( 'div', null,
					Xml::element( 'strong',
						array(
							'class' => 'error'
						),
						strlen( $this->mType ) > 0
						? wfMsgForContent( 'inputbox-error-bad-type', $this->mType ) 
						: wfMsgForContent( 'inputbox-error-no-type' ) 
					)
				);
		}
	}

	/**
	 * Generate search form
	 * @param $type 
	 */
	public function getSearchForm( $type ) {
		global $wgContLang;

		// Use button label fallbacks
		if ( !$this->mButtonLabel ) {
			$this->mButtonLabel = wfMsgHtml( 'tryexact' );
		}
		if ( !$this->mSearchButtonLabel ) {
			$this->mSearchButtonLabel = wfMsgHtml( 'searchfulltext' );
		}

		// Build HTML
		$htmlOut = Xml::openElement( 'div',
			array(
				'align' => 'center',
				'style' => 'background-color:' . $this->mBGColor
			)
		);
		$htmlOut .= Xml::openElement( 'form',
			array(
				'name' => 'searchbox',
				'id' => 'searchbox',
				'class' => 'searchbox',
				'action' => SpecialPage::getTitleFor( 'Search' )->escapeLocalUrl(),
			)
		);
		$htmlOut .= Xml::element( 'input',
			array(
				'class' => 'searchboxInput',
				'name' => 'search',
				'type' => $this->mHidden ? 'hidden' : 'text',
				'value' => $this->mDefaultText,
				'size' => $this->mWidth,
			)
		);
		
		if( $this->mPrefix != '' ){
			$htmlOut .= Xml::element( 'input',
				array(
					'name' => 'prefix',
					'type' => 'hidden',
					'value' => $this->mPrefix,
				)
			);	
		}
		
		$htmlOut .= $this->mBR;

		// Determine namespace checkboxes
		$namespaces = $wgContLang->getNamespaces();
		$namespacesArray = explode( ',', $this->mNamespaces );
		if ( $this->mNamespaces ) {
			foreach ( $namespacesArray as $userNamespace ) {
				$checked = array();
				// Namespace needs to be checked if flagged with "**" or if it's the only one
				if ( strstr( $userNamespace, '**' ) || count( $namespacesArray ) == 1 ) {
					$userNamespace = str_replace( '**', '', $userNamespace );
					$checked = array( 'checked' => 'checked' );
				}

				// Namespace checkboxes
				foreach ( $namespaces as $i => $name ) {
					if ( $i < 0 ) {
						continue;
					} elseif ( $i == 0 ) {
						$name = 'Main';
					}
					if ( $userNamespace == $name ) {
						// Checkbox
						$htmlOut .= Xml::element( 'input',
							array(
								'type' => 'checkbox',
								'name' => 'ns' . $i,
								'value' => 1,
								'id' => 'mw-inputbox-ns' . $i
							) + $checked
						);
						// Label
						$htmlOut .= '&nbsp;' . Xml::label( $userNamespace, 'mw-inputbox-ns' . $i );
					}
				}
			}

			// Line break
			$htmlOut .= $this->mBR;
		} else if( $type == 'search' ) {
			// Go button
			$htmlOut .= Xml::element( 'input',
				array(
					'type' => 'submit',
					'name' => 'go',
					'class' => 'searchboxGoButton',
					'value' => $this->mButtonLabel
				)
			);
			$htmlOut .= '&nbsp;';
		}

		// Search button
		$htmlOut .= Xml::element( 'input',
			array(
				'type' => 'submit',
				'name' => 'fulltext',
				'class' => 'searchboxSearchButton',
				'value' => $this->mSearchButtonLabel
			)
		);
		
		// Hidden fulltext param for IE (bug 17161)
		if( $type == 'fulltext' ) {
			$htmlOut .= Xml::hidden( 'fulltext', 'Search' );
		}
		
		$htmlOut .= Xml::closeElement( 'form' );
		$htmlOut .= Xml::closeElement( 'div' );

		// Return HTML
		return $htmlOut;
	}

	/*
	 * Generate search form version 2
	 */
	public function getSearchForm2() {

		// Use button label fallbacks
		if ( !$this->mButtonLabel ) {
			$this->mButtonLabel = wfMsgHtml( 'tryexact' );
		}

		$id = Sanitizer::escapeId( $this->mID, 'noninitial' );
		$htmlLabel = '';
		if ( isset( $this->mLabelText ) && strlen( trim( $this->mLabelText ) ) ) {
			$this->mLabelText = $this->mParser->recursiveTagParse( $this->mLabelText );
			$htmlLabel = Xml::openElement( 'label', array( 'for' => 'bodySearchInput' . $id ) );
			$htmlLabel .= $this->mLabelText;
			$htmlLabel .= Xml::closeElement( 'label' );
		}
		$htmlOut = Xml::openElement( 'form',
			array(
				'name' => 'bodySearch' . $id,
				'id' => 'bodySearch' . $id,
				'class' => 'bodySearch',
				'action' => SpecialPage::getTitleFor( 'Search' )->escapeLocalUrl(),
				'style' => $this->mInline ? 'display: inline;' : ''
			)
		);
		$htmlOut .= Xml::openElement( 'div',
			array(
				'class' => 'bodySearchWrap',
				'style' => 'background-color:' . $this->mBGColor . ';' .
					$this->mInline ? 'display: inline;' : ''
			)
		);
		$htmlOut .= $htmlLabel;
		$htmlOut .= Xml::element( 'input',
			array(
				'type' => $this->mHidden ? 'hidden' : 'text',
				'name' => 'search',
				'size' => $this->mWidth,
				'id' => 'bodySearchInput' . $id
			)
		);
		$htmlOut .= Xml::element( 'input',
			array(
				'type' => 'submit',
				'name' => 'go',
				'value' => $this->mButtonLabel,
				'class' => 'bodySearchBtnGo' . $id
			)
		);

		// Better testing needed here!
		if ( !empty( $this->mFullTextButton ) ) {
			$htmlOut .= Xml::element( 'input',
				array(
					'type' => 'submit',
					'name' => 'fulltext',
					'class' => 'bodySearchBtnSearch',
					'value' => $this->mSearchButtonLabel
				)
			);
		}

		$htmlOut .= Xml::closeElement( 'div' );
		$htmlOut .= Xml::closeElement( 'form' );

		// Return HTML
		return $htmlOut;
	}

	/**
	 * Generate create page form
	 */
	public function getCreateForm() {
		global $wgScript;

		if ( $this->mType == "comment" ) {
			if ( !$this->mButtonLabel ) {
				$this->mButtonLabel = wfMsgHtml( "postcomment" );
			}
		} else {
			$comment = '';
			if ( !$this->mButtonLabel ) {
				$this->mButtonLabel = wfMsgHtml( 'createarticle' );
			}
		}

		$htmlOut = Xml::openElement( 'div',
			array(
				'align' => 'center',
				'style' => 'background-color:' . $this->mBGColor
			)
		);
		$htmlOut .= Xml::openElement( 'form',
			array(
				'name' => 'createbox',
				'id' => 'createbox',
				'class' => 'createbox',
				'action' => $wgScript,
				'method' => 'get'
			)
		);
		$htmlOut .= Xml::openElement( 'input',
			array(
				'type' => 'hidden',
				'name' => 'action',
				'value' => 'edit',
			)
		);
		$htmlOut .= Xml::openElement( 'input',
			array(
				'type' => 'hidden',
				'name' => 'preload',
				'value' => $this->mPreload,
			)
		);
		$htmlOut .= Xml::openElement( 'input',
			array(
				'type' => 'hidden',
				'name' => 'editintro',
				'value' => $this->mEditIntro,
			)
		);
		$htmlOut .= Xml::openElement( 'input',
			array(
				'type' => 'hidden',
				'name' => 'summary',
				'value' => $this->mSummary,
			)
		);
		$htmlOut .= Xml::openElement( 'input',
			array(
				'type' => 'hidden',
				'name' => 'minor',
				'value' => $this->mMinor,
			)
		);
		if ( $this->mType == 'comment' ) {
			$htmlOut .= Xml::openElement( 'input',
				array(
					'type' => 'hidden',
					'name' => 'section',
					'value' => 'new',
				)
			);
		}
		$htmlOut .= Xml::openElement( 'input',
			array(
				'type' => $this->mHidden ? 'hidden' : 'text',
				'name' => 'title',
				'class' => 'createboxInput',
				'value' => $this->mDefaultText,
				'size' => $this->mWidth
			)
		);
		$htmlOut .= $this->mBR;
		$htmlOut .= Xml::openElement( 'input',
			array(
				'type' => 'submit',
				'name' => 'create',
				'class' => 'createboxButton',
				'value' => $this->mButtonLabel
			)
		);
		$htmlOut .= Xml::closeElement( 'form' );
		$htmlOut .= Xml::closeElement( 'div' );

		// Return HTML
		return $htmlOut;
	}
	
	/**
	 * Generate new section form
	 */
	public function getCommentForm() {
		global $wgScript;

		if ( !$this->mButtonLabel ) {
				$this->mButtonLabel = wfMsgHtml( "postcomment" );
		}

		$htmlOut = Xml::openElement( 'div',
			array(
				'align' => 'center',
				'style' => 'background-color:' . $this->mBGColor
			)
		);
		$htmlOut .= Xml::openElement( 'form',
			array(
				'name' => 'commentbox',
				'id' => 'commentbox',
				'class' => 'commentbox',
				'action' => $wgScript,
				'method' => 'get'
			)
		);
		$htmlOut .= Xml::openElement( 'input',
			array(
				'type' => 'hidden',
				'name' => 'action',
				'value' => 'edit',
			)
		);
		$htmlOut .= Xml::openElement( 'input',
			array(
				'type' => 'hidden',
				'name' => 'preload',
				'value' => $this->mPreload,
			)
		);
		$htmlOut .= Xml::openElement( 'input',
			array(
				'type' => 'hidden',
				'name' => 'editintro',
				'value' => $this->mEditIntro,
			)
		);
		$htmlOut .= Xml::openElement( 'input',
			array(
				'type' => $this->mHidden ? 'hidden' : 'text',
				'name' => 'preloadtitle',
				'class' => 'commentboxInput',
				'value' => $this->mDefaultText,
				'size' => $this->mWidth
			)
		);
		$htmlOut .= Xml::openElement( 'input',
			array(
				'type' => 'hidden',
				'name' => 'section',
				'value' => 'new',
			)
		);
		$htmlOut .= Xml::openElement( 'input',
			array(
				'type' => 'hidden',
				'name' => 'title',
				'value' => $this->mPage
			)
		);
		$htmlOut .= $this->mBR;
		$htmlOut .= Xml::openElement( 'input',
			array(
				'type' => 'submit',
				'name' => 'create',
				'class' => 'commentboxButton',
				'value' => $this->mButtonLabel
			)
		);
		$htmlOut .= Xml::closeElement( 'form' );
		$htmlOut .= Xml::closeElement( 'div' );

		// Return HTML
		return $htmlOut;
	}

	/**
	 * Extract options from a blob of text
	 *
	 * @param string $text Tag contents
	 */
	public function extractOptions( $text ) {
		wfProfileIn( __METHOD__ );

		// Parse all possible options
		$values = array();
		foreach ( explode( "\n", $text ) as $line ) {
			if ( strpos( $line, '=' ) === false )
				continue;
			list( $name, $value ) = explode( '=', $line, 2 );
			$values[ strtolower( trim( $name ) ) ] = trim( $value );
		}

		// Build list of options, with local member names
		$options = array(
			'type' => 'mType',
			'width' => 'mWidth',
			'preload' => 'mPreload',
			'page' => 'mPage',
			'editintro' => 'mEditIntro',
			'summary' => 'mSummary',
			'minor' => 'mMinor',
			'break' => 'mBR',
			'default' => 'mDefaultText',
			'bgcolor' => 'mBGColor',
			'buttonlabel' => 'mButtonLabel',
			'searchbuttonlabel' => 'mSearchButtonLabel',
			'fulltextbutton' => 'mFullTextButton',
			'namespaces' => 'mNamespaces',
			'labeltext' => 'mLabelText',
			'hidden' => 'mHidden',
			'id' => 'mID',
			'inline' => 'mInline',
			'prefix' => 'mPrefix',
		);
		foreach ( $options as $name => $var ) {
			if ( isset( $values[$name] ) ) {
				$this->$var = $values[$name];
			}
		}

		// Insert a line break if configured to do so
		$this->mBR = ( strtolower( $this->mBR ) == "no" ) ? ' ' : '<br />';

		// Validate the width; make sure it's a valid, positive integer
		$this->mWidth = intval( $this->mWidth <= 0 ? 50 : $this->mWidth );

		// Validate background color
		if ( !$this->isValidColor( $this->mBGColor ) ) {
			$this->mBGColor = 'transparent';
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Do a security check on the bgcolor parameter
	 */
	public function isValidColor( $color ) {
		$regex = <<<REGEX
			/^ (
				[a-zA-Z]* |       # color names
				\# [0-9a-f]{3} |  # short hexadecimal
				\# [0-9a-f]{6} |  # long hexadecimal
				rgb \s* \( \s* (
					\d+ \s* , \s* \d+ \s* , \s* \d+ |    # rgb integer
					[0-9.]+% \s* , \s* [0-9.]+% \s* , \s* [0-9.]+%   # rgb percent
				) \s* \)
			) $ /xi
REGEX;
		return (bool) preg_match( $regex, $color );
	}
}
