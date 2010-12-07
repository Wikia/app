<?php
/**
 * TranslationCount
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2010-11-26
 * @copyright Copyright © 2010 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialTranslationCount extends SpecialPage {
	var $mGroup;
	var $mLang;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'TranslationCount'/*class*/ );
//		wfLoadExtensionMessages( 'TranslationStatistics' ); // Load internationalization messages
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest;

		$this->mGroup = $wgRequest->getText( 'group', false );
		$this->mBreakdown = $wgRequest->getCheck( 'breakdown', false );

		$this->displayNavigation();

		$this->displayStats();
	}

	private function displayStats() {
		global $wgOut;

		if ( empty( $this->mGroup ) ) {
			$wgOut->addHTML( wfMsg( 'select-group' ) );
			return true;
		}

		$data['total'] = MessageGroupStatistics::forGroup( $this->mGroup );

		// need to get child groups for this meta group
		if ( !empty( $this->mBreakdown ) ) {
			$data[] = MessageGroupStatistics::forGroup( /* ... */ );
		}

		if ( empty( $data ) ) {
			$wgOut->addHTML( wfMsg( 'error' ) );
			return true;
		}

		foreach ( $data as $type => &$row ) {
			$this->processRow( &$row, $type );
		}

		$headers = array(
			wfMsg( 'language' ),
			wfMsg( 'translated' ),
			wfMsg( 'untranslated' ),
		);

		$attribs = array();

		$table = Xml::buildTable( $data, $attribs, $headers );

		$this->renderHeader();

		$wgOut->addHTML( $table );

		$this->renderFooter();

		return true;
	}

	private function displayNavigation() {
		global $wgOut;

		$groupSelector = new XmlSelect( 'group', 'group-select' );

		// pull groups
		$groups = MessageGroups::singleton()->getGroups();	

		foreach ( $groups as $group ) {
			if ( !$group->isMeta() ) {
				continue;
			}

			$groupSelector->addOption( $group->getLabel(), $group->getId() );
		}

		$fields = array();
		$fields[ wfMsg('choose-group') ] = $groupSelector->getHTML();
		$fields[ wfMsg('breakdown') ] = Xml::check( 'breakdown', false );

		$out = Xml::openElement( 'form' );

		$out .= Xml::buildForm( $fields );
		$out .= Xml::submitButton( wfMsg( 'submit' ) );

		$out .= Xml::closeElement( 'form' );

		$wgOut->addHTML( $out );
	}

	private function processRow( $row, $type = false ) {
		unset( $row['gs_group'] );
		unset( $row['gs_fuzzy'] );

		if ( $type == 'total' ) {
			$row['gs_group'] = wfMsg( 'total' );
		}
	}

	private function renderHeader() {
		global $wgOut;

	}

	private function renderFooter() {
		global $wgOut;
	}
}
