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
		// wfMsg cleanup
		$wgOut->setPagetitle( wfMessage( 'gadgets-title' )->escaped() );
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
						// wfMsg cleanup
						? Linker::link( $t, wfMessage( 'edit' )->escaped(), array(), array( 'action' => 'edit' ) )
						// end wikia change
						: htmlspecialchars( $section );
					$lnk =  "&#160; &#160; [$lnkTarget]";
				} else {
					$lnk = '';
				}

				// begin wikia change
				// wfMsg cleanup
				$ttext = wfMessage( "gadget-section-$section" )->parse();
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
					// wfMsg cleanup
					$links[] = Linker::link( $t, wfMessage( 'edit' )->escaped(), array(), array( 'action' => 'edit' ) );
					// end wikia change
				}

				// begin wikia change
				// wfMsg cleanup
				$links[] = Linker::link( $this->getTitle( "export/{$gadget->getName()}" ), wfMessage( 'gadgets-export' )->escaped() );

				$ttext = wfMessage( "gadget-{$gadget->getName()}" )->parse();
				// end wikia change

				if ( !$listOpen ) {
					$listOpen = true;
					$wgOut->addHTML( Xml::openElement( 'ul' ) );
				}

				// begin wikia change
				// wfMsg cleanup
				$lnk = '&#160;&#160;' . wfMessage( 'parentheses', $wgLang->pipeList( $links ) )->plain();
				$wgOut->addHTML( Xml::openElement( 'li' ) .
						$ttext . $lnk . "<br />" .
						wfMessage( 'gadgets-uses' )->escaped() . wfMessage( 'colon-separator' )->escaped()
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
					$rights[] = '* ' . wfMessage( "right-$right" )->plain();
				}
				if ( count( $rights ) ) {
					$wgOut->addHTML( '<br />' .
						wfMessage( 'gadgets-required-rights', implode( "\n", $rights ), count( $rights ) )->parse()
					);
				}

				$skins = array();
				$validskins = Skin::getSkinNames();
				foreach ( $gadget->getRequiredSkins() as $skinid ) {
					if ( isset( $validskins[$skinid] ) ) {
						$skins[] = wfMessage( "skinname-$skinid" )->plain();
					} else {
						$skins[] = $skinid;
					}
				}
				if ( count( $skins ) ) {
					$wgOut->addHTML( '<br />' .
						wfMessage( 'gadgets-required-skins', $wgLang->commaList( $skins ), count( $skins ) )->parse()
					);
				}

				if ( $gadget->isOnByDefault() ) {
					$wgOut->addHTML( '<br />' . wfMessage( 'gadgets-default' )->parse() );
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
		// wfMsg cleanup
		$wgOut->setPagetitle( wfMessage( 'gadgets-export-title' )->escaped() );
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
			// wfMsg cleanup
			. Xml::submitButton( wfMessage( 'gadgets-export-download' )->escaped() )
			// end wikia change
			. Html::closeElement( 'form' )
		);
	}
}
