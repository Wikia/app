<?php

class SpecialMoodBar extends SpecialPage {
	static $fields = array(
			'mbf_id' => 'id',
			'mbf_timestamp' => 'timestamp',
			'mbf_type' => 'type',
			'mbf_namespace' => 'namespace',
			'mbf_title' => 'page',
			'user-type' => 'usertype',
			'mbs_user_id' => 'user',
			'mbf_user_editcount' => 'user-editcount',
			'mbf_editing' => 'editmode',
			'mbf_bucket' => 'bucket',
			'mbf_system_type' => 'system',
			'mbf_locale' => 'locale',
			'mbf_user_agent' => 'useragent',
			'mbf_comment' => 'comment',
		);

	function __construct() {
		parent::__construct( 'MoodBar', 'moodbar-view' );
	}

	function getDescription() {
		return wfMessage( 'moodbar-admin-title' )->plain();
	}

	function execute($par) {
		global $wgUser, $wgOut;

		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		$wgOut->setPageTitle( wfMsg( 'moodbar-admin-title' ) );
		$wgOut->addWikiMsg( 'moodbar-admin-intro' );

		$pager = new MoodBarPager();

		if ( $pager->getNumRows() > 0 ) {
			$wgOut->addHTML(
				$pager->getNavigationBar() .
				$pager->getBody() .
				$pager->getNavigationBar()
			);
		} else {
			$wgOut->addWikiMsg( 'moodbar-admin-empty' );
		}
	}
}

class MoodBarPager extends TablePager {
	function getFieldNames() {
		static $headers = null;

		if ( is_null( $headers ) ) {
			$headers = array();
			foreach( SpecialMoodBar::$fields as $field => $property ) {
				$headers[$field] = wfMessage("moodbar-header-$property")->text();
			}
		}

		return $headers;
	}

	// Overridden from TablePager, it's just easier because
	// we're doing things with a proper object model
	function formatRow( $row ) {
		$out = '';

		$data = MBFeedbackItem::load( $row );
		$outData = null;

		foreach( SpecialMoodBar::$fields as $field ) {
			$outData = MoodBarFormatter::getHTMLRepresentation( $data, $field );
			$out .= Xml::tags( 'td', null, $outData );
		}

		$out = Xml::tags( 'tr', $this->getRowAttrs($row), $out ) . "\n";
		return $out;
	}

	function formatValue( $name, $value ) {
		return '';
	}

	function getQueryInfo() {
		$info = array(
			'tables' => array('moodbar_feedback', 'user'),
			'fields' => '*',
			'join_conds' => array(
				'user' => array(
					'left join',
					'user_id=mbf_user_id',
				),
			),
		);

		return $info;
	}

	function getDefaultSort() {
		return 'mbf_id';
	}

	function isFieldSortable( $name ) {
		$sortable = array(
			'mbf_id',
			'mbf_type',
			'mbf_user_id',
			'mbf_namespace',
		);

		return in_array( $name, $sortable );
	}

	function getTitle() {
		return SpecialPage::getTitleFor( 'MoodBar' );
	}
}
