<?php
/**
 * Special:Gadgets, provides a preview of MediaWiki:Gadgets.
 *
 * @file
 * @ingroup SpecialPage
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @license GNU General Public License 2.0 or later
 */

class SpecialGadgets extends SpecialPage {

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct( 'Gadgets', '', true );
	}

	/**
	 * Main execution function
	 * @param $par array Parameters passed to the page
	 */
	function execute( $par ) {
		$parts = explode( '/', $par );

		if ( count( $parts ) == 2 && $parts[0] == 'export' ) {
			$this->showExportForm( $parts[1] );
		} else {
			$this->showMainForm();
		}
	}

	/**
	 * Displays form showing the list of installed gadgets
	 */
	public function showMainForm() {
		global $wgOut, $wgUser, $wgLang, $wgContLang;

		$this->setHeaders();
		// begin wikia change
		// VOLDEV-186: wfMsg cleanup
		$wgOut->setPagetitle( $this->msg( 'gadgets-title' )->escaped() );
		// end wikia change
		$wgOut->addWikiMsg( 'gadgets-pagetext' );

		$gadgets = Gadget::loadStructuredList();
		if ( !$gadgets ) return;

		$lang = "";
		if ( $wgLang->getCode() != $wgContLang->getCode() ) {
			$lang = "/" . $wgLang->getCode();
		}

		$listOpen = false;

		$editInterfaceAllowed = $wgUser->isAllowed( 'editinterface' );

		foreach ( $gadgets as $section => $entries ) {
			if ( $section !== false && $section !== '' ) {
				$t = Title::makeTitleSafe( NS_MEDIAWIKI, "Gadget-section-$section$lang" );
				if ( $editInterfaceAllowed ) {
					$lnkTarget = $t
						// begin wikia change
						// VOLDEV-186: wfMsg cleanup
						? Linker::link( $t, $this->msg( 'edit' )->escaped(), array(), array( 'action' => 'edit' ) )
						// end wikia change
						: htmlspecialchars( $section );
					$lnk =  "&#160; &#160; [$lnkTarget]";
				} else {
					$lnk = '';
				}

				// begin wikia change
				// VOLDEV-186: wfMsg cleanup
				$ttext = $this->msg( "gadget-section-$section" )->parse();
				// end wikia change

				if ( $listOpen ) {
					$wgOut->addHTML( Xml::closeElement( 'ul' ) . "\n" );
					$listOpen = false;
				}

				$wgOut->addHTML( Html::rawElement( 'h2', array(), $ttext . $lnk ) . "\n" );
			}

			/**
			 * @var $gadget Gadget
			 */
			foreach ( $entries as $gadget ) {
				$t = Title::makeTitleSafe( NS_MEDIAWIKI, "Gadget-{$gadget->getName()}$lang" );

				if ( !$t ) {
					continue;
				}

				$links = array();
				if ( $editInterfaceAllowed ) {
					// begin wikia change
					// VOLDEV-186: wfMsg cleanup
					$links[] = Linker::link( $t, $this->msg( 'edit' )->escaped(), array(), array( 'action' => 'edit' ) );
					// end wikia change
				}

				// begin wikia change
				// VOLDEV-186: wfMsg cleanup
				$links[] = Linker::link( $this->getTitle( "export/{$gadget->getName()}" ), $this->msg( 'gadgets-export' )->escaped() );

				$ttext = $this->msg( "gadget-{$gadget->getName()}" )->parse();
				// end wikia change

				if ( !$listOpen ) {
					$listOpen = true;
					$wgOut->addHTML( Xml::openElement( 'ul' ) );
				}

				// begin wikia change
				// VOLDEV-186: wfMsg cleanup
				$lnk = '&#160;&#160;' . $this->msg( 'parentheses', $wgLang->pipeList( $links ) )->plain();
				$wgOut->addHTML( Xml::openElement( 'li' ) .
						$ttext . $lnk . "<br />" .
						$this->msg( 'gadgets-uses' )->escaped() . $this->msg( 'colon-separator' )->escaped()
				);
				// end wikia change

				$lnk = array();
				foreach ( $gadget->getScriptsAndStyles() as $codePage ) {
					$t = Title::makeTitleSafe( NS_MEDIAWIKI, $codePage );

					if ( !$t ) {
						continue;
					}

					$lnk[] = Linker::link( $t, htmlspecialchars( $t->getText() ) );
				}
				$wgOut->addHTML( $wgLang->commaList( $lnk ) );

				$rights = array();
				foreach ( $gadget->getRequiredRights() as $right ) {
					// wikia change
					// VOLDEV 186: Convert wfMessage to $this->msg
					$rights[] = '* ' . $this->msg( "right-$right" )->plain();
					// end wikia change
				}
				if ( count( $rights ) ) {
					$wgOut->addHTML( '<br />' .
						// wikia change
						// VOLDEV 186: Convert wfMessage to $this->msg
						$this->msg( 'gadgets-required-rights', implode( "\n", $rights ), count( $rights ) )->parse()
						// end wikia change
					);
				}

				$skins = array();
				$validskins = Skin::getSkinNames();
				foreach ( $gadget->getRequiredSkins() as $skinid ) {
					if ( isset( $validskins[$skinid] ) ) {
						// wikia change
						// VOLDEV 186: Convert wfMessage to $this->msg
						$skins[] = $this->msg( "skinname-$skinid" )->plain();
						// end wikia change
					} else {
						$skins[] = $skinid;
					}
				}
				if ( count( $skins ) ) {
					$wgOut->addHTML( '<br />' .
						// wikia change
						// VOLDEV 186: Convert wfMessage to $this->msg
						$this->msg( 'gadgets-required-skins', $wgLang->commaList( $skins ), count( $skins ) )->parse()
						// end wikia change
					);
				}

				if ( $gadget->isOnByDefault() ) {
					// wikia change
					// VOLDEV 186: Convert wfMessage to $this->msg
					$wgOut->addHTML( '<br />' . $this->msg( 'gadgets-default' )->parse() );
					// end wikia change
				}

				$wgOut->addHTML( Xml::closeElement( 'li' ) . "\n" );
			}
		}

		if ( $listOpen ) {
			$wgOut->addHTML( Xml::closeElement( 'ul' ) . "\n" );
		}
	}

	/**
	 * Exports a gadget with its dependencies in a serialized form
	 * @param $gadget String Name of gadget to export
	 */
	public function showExportForm( $gadget ) {
		global $wgOut, $wgScript;

		$gadgets = Gadget::loadList();
		if ( !isset( $gadgets[$gadget] ) ) {
			$wgOut->showErrorPage( 'error', 'gadgets-not-found', array( $gadget ) );
			return;
		}

		/**
		 * @var $g Gadget
		 */
		$g = $gadgets[$gadget];
		$this->setHeaders();
		// begin wikia change
		// VOLDEV-186: wfMsg cleanup
		$wgOut->setPagetitle( $this->msg( 'gadgets-export-title' )->escaped() );
		// end wikia change
		$wgOut->addWikiMsg( 'gadgets-export-text', $gadget, $g->getDefinition() );

		$exportList = "MediaWiki:gadget-$gadget\n";
		foreach ( $g->getScriptsAndStyles() as $page ) {
			$exportList .= "MediaWiki:$page\n";
		}

		$wgOut->addHTML( Html::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript ) )
			. Html::hidden( 'title', SpecialPage::getTitleFor( 'Export' )->getPrefixedDBKey() )
			. Html::hidden( 'pages', $exportList )
			. Html::hidden( 'wpDownload', '1' )
			. Html::hidden( 'templates', '1' )
			// begin wikia change
			// VOLDEV-186: wfMsg cleanup
			// escaping handled by submitButton in this case
			. Xml::submitButton( $this->msg( 'gadgets-export-download' )->plain() )
			// end wikia change
			. Html::closeElement( 'form' )
		);
	}
}
