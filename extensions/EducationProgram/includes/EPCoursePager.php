<?php

/**
 * Course pager.
 *
 * @since 0.1
 *
 * @file EPCoursePager.php
 * @ingroup EductaionProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class EPCoursePager extends EPPager {

	/**
	 * When in read only mode, the pager should not show any course editing controls.
	 * 
	 * @since 0.1
	 * @var boolean
	 */
	protected $readOnlyMode;
	
	/**
	 * Constructor.
	 *
	 * @param IContextSource $context
	 * @param array $conds
	 * @param boolean $readOnlyMode
	 */
	public function __construct( IContextSource $context, array $conds = array(), $readOnlyMode = false ) {
		$this->readOnlyMode = $readOnlyMode;
		parent::__construct( $context, $conds, 'EPCourse' );
		
		$this->context->getOutput()->addModules( 'ep.pager.course' );
	}

	/**
	 * (non-PHPdoc)
	 * @see EPPager::getFields()
	 */
	public function getFields() {
		return array(
			'name',
			'org_id',
			'term',
			'lang',
			'students',
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see TablePager::getRowClass()
	 */
	function getRowClass( $row ) {
		return 'ep-course-row';
	}

	/**
	 * (non-PHPdoc)
	 * @see TablePager::getTableClass()
	 */
	public function getTableClass() {
		return 'TablePager ep-courses';
	}

	/**
	 * (non-PHPdoc)
	 * @see EPPager::getFormattedValue()
	 */
	public function getFormattedValue( $name, $value ) {
		switch ( $name ) {
			case 'name':
				$value = EPCourse::getLinkFor( $value );
				break;
			case 'org_id':
				$value = EPOrg::selectRow( 'name', array( 'id' => $value ) )->getLink();
				break;
			case 'term':
				$value = htmlspecialchars( $value );
				break;
			case 'lang':
				$langs = LanguageNames::getNames( $this->getLanguage()->getCode() );
				if ( array_key_exists( $value, $langs ) ) {
					$value = htmlspecialchars( $langs[$value] );
				}
				else {
					$value = '<i>' . htmlspecialchars( $this->getMsg( 'invalid-lang' ) ) . '</i>';
				}

				break;
			case 'start': case 'end':
				$value = htmlspecialchars( $this->getLanguage()->date( $value ) );
				break;
			case '_status':
				$value = htmlspecialchars( EPCourse::getStatusMessage( $this->currentObject->getStatus() ) );
			case 'students':
				$value = htmlspecialchars( $this->getLanguage()->formatNum( $value ) );
				break;
		}

		return $value;
	}

	/**
	 * (non-PHPdoc)
	 * @see EPPager::getSortableFields()
	 */
	protected function getSortableFields() {
		return array(
			'name',
			'term',
//			'start',
//			'end',
			'lang',
			'students',
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see EPPager::getFieldNames()
	 */
	public function getFieldNames() {
		$fields = parent::getFieldNames();

//		if ( array_key_exists( 'mc_id', $this->conds ) && array_key_exists( 'org_id', $fields ) ) {
//			unset( $fields['org_id'] );
//		}

		$fields = wfArrayInsertAfter( $fields, array( '_status' => 'status' ), 'students' );

		return $fields;
	}

	/**
	 * (non-PHPdoc)
	 * @see EPPager::getFilterOptions()
	 */
	protected function getFilterOptions() {
		$options = array();

		$options['org_id'] = array(
			'type' => 'select',
			'options' => array_merge(
				array( '' => '' ),
				EPOrg::getOrgOptions( EPOrg::select( array( 'name', 'id' ) ) )
			),
			'value' => '',
			'datatype' => 'int',
		);

		$terms = EPCourse::selectFields( 'term', array(), array( 'DISTINCT' ), array(), true );
		natcasesort( $terms );
		$terms = array_merge( array( '' ), $terms );
		$terms = array_combine( $terms, $terms );

		$options['term'] = array(
			'type' => 'select',
			'options' => $terms,
			'value' => '',
		);
		
//		$options['lang'] = array(
//			'type' => 'select',
//			'options' => EPUtils::getLanguageOptions( $this->getLanguage()->getCode() ),
//			'value' => '',
//		);

		$options['status'] = array(
			'type' => 'select',
			'options' => array_merge(
				array( '' => '' ),
				EPCourse::getStatuses()
			),
			'value' => 'current',
		);

		return $options;
	}

	/**
	 * (non-PHPdoc)
	 * @see EPPager::getControlLinks()
	 */
	protected function getControlLinks( EPDBObject $item ) {
		$links = parent::getControlLinks( $item );

		$links[] = $item->getLink( 'view', wfMsgHtml( 'view' ) );

		if ( !$this->readOnlyMode && $this->getUser()->isAllowed( 'ep-course' ) ) {
			$links[] = $item->getLink(
				'edit',
				wfMsgHtml( 'edit' ),
				array(),
				array( 'wpreturnto' => $this->getTitle()->getFullText() )
			);

			$links[] = $this->getDeletionLink(
				ApiDeleteEducation::getTypeForClassName( $this->className ),
				$item->getId(),
				$item->getIdentifier()
			);
		}

		return $links;
	}

	/**
	 * (non-PHPdoc)
	 * @see EPPager::getMultipleItemActions()
	 */
	protected function getMultipleItemActions() {
		$actions = parent::getMultipleItemActions();

		if ( !$this->readOnlyMode && $this->getUser()->isAllowed( 'ep-course' ) ) {
			$actions[wfMsg( 'ep-pager-delete-selected' )] = array(
				'class' => 'ep-pager-delete-selected',
				'data-type' => ApiDeleteEducation::getTypeForClassName( $this->className )
			);
		}
		
		return $actions;
	}

	/**
	 * (non-PHPdoc)
	 * @see EPPager::getConditions()
	 */
	protected function getConditions() {
		$conds = parent::getConditions();

		if ( array_key_exists( 'status', $conds ) ) {
			$now = wfGetDB( DB_SLAVE )->addQuotes( wfTimestampNow() );

			switch ( $conds['status'] ) {
				case 'passed':
					$conds[] = 'end < ' . $now;
					break;
				case 'planned':
					$conds[] = 'start > ' . $now;
					break;
				case 'current':
					$conds[] = 'end >= ' . $now;
					$conds[] = 'start <= ' . $now;
					break;
			}

			unset( $conds['status'] );
		}

		return $conds;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see EPPager::hasActionsColumn()
	 */
	protected function hasActionsColumn() {
		return !$this->readOnlyMode;
	}

}
