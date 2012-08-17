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
			$wgOut->addHTML( wfMsg( 'transstats-select-group' ) );
			return true;
		}

		$data['total'] = MessageGroupStatistics::forGroup( $this->mGroup );

		// need to get child groups for this meta group
		if ( !empty( $this->mBreakdown ) ) {
			$data[] = MessageGroupStatistics::forGroup( $this->mBreakdown );
		}

		if ( empty( $data ) ) {
			$wgOut->addHTML( wfMsg( 'transstats-error' ) );
			return true;
		}

		foreach ( $data['total'] as $type => &$row ) {
			$this->processRow( $row, $type );
		}

		$headers = array(
			wfMsg( 'transstats-language' ),
			wfMsg( 'transstats-translated' ),
			wfMsg( 'transstats-untranslated' ),
		);

		$attribs = array( 'class' => 'wikitable' );

		$table = Xml::buildTable( $data['total'], $attribs, $headers );

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
		$fields['transstats-choose-group'] = $groupSelector->getHTML();
		$fields['transstats-breakdown'] = Xml::check( 'breakdown', false );

		$out = Xml::openElement( 'form' );

		$out .= Xml::buildForm( $fields );
		$out .= Xml::submitButton( wfMsg( 'transstats-submit' ) );

		$out .= Xml::closeElement( 'form' );

		$wgOut->addHTML( $out );
	}

	private function processRow( &$row, $type = false ) {
		unset( $row['gs_group'] );
		unset( $row[0] );
		unset( $row[1] );
		unset( $row[2] );
		unset( $row[3] );
		unset( $row[4] );
		unset( $row['gs_fuzzy'] );

		$row['gs_untranslated'] = $row['gs_total'] - $row['gs_translated'];

		unset( $row['gs_total'] );

		if ( $type == 'total' ) {
			$rw['gs_group'] = wfMsg( 'transstats-total' );
		}
	}

	private function renderHeader() {
		global $wgOut;

	}

	private function renderFooter() {
		global $wgOut;
	}
}
