<?php
namespace RecentChanges;

use FormOptions;
use SpecialRecentChanges;
use F;
use WikiaStyleGuideDropdownController;
use Xml;

class SpecialPage extends SpecialRecentChanges {
	const NS_PREF = 'wikia_rc_namespaces';
	const LOGTYPE_PREF = 'wikia_rc_logtypes';

	/** @var Dropdown $filter */
	protected $dropdown;

	public function __construct( Dropdown $dropdown = null ) {
		parent::__construct();

		$this->dropdown = $dropdown ?? new Dropdown();
	}

	function addRecentChangesJS() {
		parent::addRecentChangesJS();
		$this->getOutput()->addModules( 'ext.wikia.RecentChanges' );
	}

	/**
	 * @inheritdoc
	 */
	function getExtraOptions( $opts ) {
		$extraOpts = parent::getExtraOptions( $opts );

		$extraOpts['logtype'] = $this->logTypeFilterForm();

		return $extraOpts;
	}

	/**
	 * @inheritdoc
	 */
	public function buildMainQueryConds( FormOptions $opts ) {
		$conds = parent::buildMainQueryConds( $opts );
		$db = wfGetDB( DB_SLAVE );

		if ( !empty( $opts['logtype'] ) ) {
			$conds[] = 'rc_log_type IN ' . $db->makeList( $opts['logtype'] );
		}

		if ( !empty( $opts['namespace'] ) ) {
			$conds[] = 'rc_namespace IN ' . $db->makeList( $opts['namespace'] );
		}

		return $conds;
	}

	/**
	 * @inheritdoc
	 */
	protected function namespaceFilterForm( FormOptions $opts ) {
		$options = $this->dropdown->getNamespaceOptions();
		$selected = (array) $this->getUser()->getGlobalPreference( static::NS_PREF );

		$label = Xml::label( $this->msg( 'namespace' )->text(), 'namespace' );
		$dropdown = F::app()->renderView(
			WikiaStyleGuideDropdownController::class,
			'multiSelect',
			[
				'name' => 'namespace',
				'options' => $options,
			    'selected' => $selected,
			    'selectAll' => true
			]
		);

		return [ $label, $dropdown ];
	}

	/**
	 * Render a multiselect dropdown that allows filtering for log types
	 * @return string[] first element is label HTML, second is dropdown HTML
	 */
	protected function logTypeFilterForm() {
		$options = $this->dropdown->getLogTypeOptions();
		$selected = (array) $this->getUser()->getGlobalPreference( static::LOGTYPE_PREF );

		$label = 'Lorem ipsum';
		$dropdown = F::app()->renderView(
			WikiaStyleGuideDropdownController::class,
			'multiSelect',
			[
				'name' => 'logtype',
				'options' => $options,
			    'selected' => $selected,
			    'selectAll' => true
			]
		);

		return [ $label, $dropdown ];
	}
}
