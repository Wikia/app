<?php

class SpecialNewEditors extends SpecialPage {
	public function __construct() {
		parent::__construct( 'NewEditors' );
	}

	public function execute( $par ) {
		$this->setHeaders();
		$this->outputHeader();

		$out = $this->getOutput();
		$pager = new NewEditorsPager( $this->getContext() );

		$out->addHTML( $pager->getNavigationBar() );
		$out->addHTML( $pager->getBody() );
		$out->addHTML( $pager->getNavigationBar() );

		$out->setSquidMaxage( WikiaResponse::CACHE_SHORT );
	}
}

class NewEditorsPager extends ReverseChronologicalPager {
	/** @var ChangesList|EnhancedChangesList|OldChangesList $changesList */
	private $changesList;
	/** @var int $count */
	private $count;

	public function __construct( IContextSource $context = null ) {
		parent::__construct( $context );

		$this->changesList = ChangesList::newFromContext( $this->getContext() );
		$this->count = 0;
	}

	function getQueryInfo() {
		return [
			'tables' => 'recentchanges',
			'fields' => '*',
			'conds' => [
				'rc_bot' => 0,
				'rc_type < ' . RC_MOVE,
			],
			'options' => [
				'GROUP BY' => 'rc_user',
				'HAVING' => 'rc_this_oldid = (SELECT min(rev_id) from revision where rev_user = rc_user)'
			]
		];
	}

	function getIndexField() {
		return 'rc_timestamp';
	}

	function getStartBody() {
		return Html::openElement( 'div', [ 'class' => 'rc-conntent' ] ) . $this->changesList->beginRecentChangesList();
	}

	function formatRow( $row ) {
		$this->count++;

		$rc = RecentChange::newFromRow( $row );
		$rc->counter = $this->count;
		return $this->changesList->recentChangesLine( $rc, false, $this->count );
	}

	function getEndBody() {
		return $this->changesList->endRecentChangesList() . Html::closeElement( 'div' );
	}
}
