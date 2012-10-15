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

class SpecialGroupStats extends SpecialPage {
	var $mGroup;
	var $mLang;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'GroupStats'/*class*/ );
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
		$this->mMode = $wgRequest->getInt( 'mode', 0 );
		$this->mLanglistPlain = $wgRequest->getText( 'langlist' );

		if ( !empty( $this->mLanglistPlain ) ) {
			$this->mLanglist = explode( ',', $this->mLanglistPlain );
		}

		$this->displayNavigation();

		$this->displayStats();
	}

	private function displayStats() {
		global $wgOut;

		if ( empty( $this->mGroup ) ) {
			$wgOut->addHTML( wfMsg( 'transstats-select-group' ) );
			return true;
		}

		if ( empty( $this->mLanglist ) ) {
			$data['total'] = MessageGroupStatistics::forGroup( $this->mGroup );
		} else {
			foreach( $this->mLanglist as $lang ) {
				$data['total'][$lang] = MessageGroupStatistics::forItem( $this->mGroup, $lang );
			}
		}

		if ( empty( $data ) ) {
			$wgOut->addHTML( wfMsg( 'transstats-error' ) );
			return true;
		}

		$displayData = array();
		foreach ( $data['total'] as $type => $row ) {
			$processed = $this->processRow( $row, $type );
			if ( $processed ) {
				$displayData[$type] = $processed;
			}
		}

		$headers = array(
			wfMsg( 'transstats-language' ),
			wfMsg( 'transstats-translated' ),
			wfMsg( 'transstats-percentage' ),
		);

		$attribs = array( 'class' => 'wikitable' );

		$table = Xml::buildTable( $displayData, $attribs, $headers );

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
		$fields['transstats-group-mode-all'] = Xml::radio( 'mode', 0, empty( $this->mMode ) );
		$fields['transstats-group-mode-supress0'] = Xml::radio( 'mode', 1, ( $this->mMode == 1 ) );
		$fields['transstats-group-mode-supress100'] =  Xml::radio( 'mode', 2, ( $this->mMode == 2 ) );
		$fields['transstats-group-mode-only100'] = Xml::radio( 'mode', 3, ( $this->mMode == 3 ) );
		$fields['transstats-group-langlist'] = Xml::input( 'langlist', false, $this->mLanglistPlain );

		$out = Xml::openElement( 'form' );

		$out .= Xml::buildForm( $fields );
		$out .= Html::hidden( 'title', 'Special:' . $this->getName() ); // FIXME: this is silly...
		$out .= Xml::submitButton( wfMsg( 'transstats-submit' ) );

		$out .= Xml::closeElement( 'form' );

		$wgOut->addHTML( $out );
	}

	private function processRow( $row, $type = false ) {
		$specialPage = Title::newFromText( 'NewLanguageStats', NS_SPECIAL );

		$row['gs_lang'] = "<a href=\"" . $specialPage->getLinkUrl( array( 'lang' => $row['gs_lang'] ) ) . "\">" . $row['gs_lang'] . "</a>";

		unset( $row['gs_group'] );
		unset( $row[0] );
		unset( $row[1] );
		unset( $row[2] );
		unset( $row[3] );
		unset( $row[4] );
		unset( $row['gs_fuzzy'] );

		$row['percent'] = round( ( ( $row['gs_translated'] * 100 ) / $row['gs_total'] ), 2 );

		// mode processing goes here
		if ( $this->mMode == 1 && $row['gs_translated'] == 0 ) {
			unset( $row );
			return false;
		} elseif ( $this->mMode == 2 && $row['percent'] == 100 ) {
			unset( $row );
			return false;
		} elseif ( $this->mMode == 3 && $row['percent'] != 100 ) {
			unset( $row );
			return false;
		}

		unset( $row['gs_total'] );

		if ( $type == 'total' ) {
			$rw['gs_group'] = wfMsg( 'transstats-total' );
		}

		return $row;
	}

	private function renderHeader() {
		global $wgOut;

	}

	private function renderFooter() {
		global $wgOut;
	}
}
