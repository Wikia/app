<?php

/**
 * Org pager, primarily for Special:Institutions.
 *
 * @since 0.1
 *
 * @file EPOrgPager.php
 * @ingroup EductaionProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class EPOrgPager extends EPPager {

	/**
	 * Constructor.
	 *
	 * @param IContextSource $context
	 * @param array $conds
	 */
	public function __construct( IContextSource $context, array $conds = array() ) {
		parent::__construct( $context, $conds, 'EPOrg' );
		$this->context->getOutput()->addModules( 'ep.pager.org' );
	}

	/**
	 * (non-PHPdoc)
	 * @see EPPager::getFields()
	 */
	public function getFields() {
		return array(
			'name',
			'city',
			'country',
			'courses',
			'students',
			'active',
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see TablePager::getRowClass()
	 */
	function getRowClass( $row ) {
		return 'ep-org-row';
	}

	/**
	 * (non-PHPdoc)
	 * @see TablePager::getTableClass()
	 */
	public function getTableClass() {
		return 'TablePager ep-orgs';
	}

	/**
	 * (non-PHPdoc)
	 * @see EPPager::getFormattedValue()
	 */
	public function getFormattedValue( $name, $value ) {
		switch ( $name ) {
			case 'name':
				$value = EPOrg::getLinkFor( $value );
				break;
			case 'country':
				$countries = array_flip( EPUtils::getCountryOptions( $this->getLanguage()->getCode() ) );
				$value = htmlspecialchars( $countries[$value] );
				break;
			case 'courses': case 'students':
				$rawValue = $value;
				$value = htmlspecialchars( $this->getLanguage()->formatNum( $value ) );

				if ( $rawValue > 0 && $name === 'courses' ) {
					$value = Linker::linkKnown(
						SpecialPage::getTitleFor( $this->getLanguage()->ucfirst( $name ) ),
						$value,
						array(),
						array( 'org_id' => $this->currentObject->getId() )
					);
				}

				break;
			case 'active':
				$value = wfMsgHtml( 'eporgpager-' . ( $value == '1' ? 'yes' : 'no' ) );
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
			'city',
			'country',
			'courses',
			'students',
			'active',
		);
	}

	function getDefaultSort() {
		$c = $this->className; // Yeah, this is needed in PHP 5.3 >_>
		return $c::getPrefixedField( 'name' );
	}

	/**
	 * (non-PHPdoc)
	 * @see EPPager::getFilterOptions()
	 */
	protected function getFilterOptions() {
		return array(
			'country' => array(
				'type' => 'select',
				'options' => EPUtils::getCountryOptions( $this->getLanguage()->getCode() ),
				'value' => ''
			),
			'active' => array(
				'type' => 'select',
				'options' => array(
					'' => '',
					wfMsg( 'eporgpager-yes' ) => '1',
					wfMsg( 'eporgpager-no' ) => '0',
				),
				'value' => '',
			),
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see EPPager::getControlLinks()
	 */
	protected function getControlLinks( EPDBObject $item ) {
		$links = parent::getControlLinks( $item );

		$links[] = $item->getLink( 'view', wfMsgHtml( 'view' ) );

		if ( $this->getUser()->isAllowed( 'ep-org' ) ) {
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

		if ( $this->getUser()->isAllowed( 'ep-org' ) ) {
			$actions[wfMsg( 'ep-pager-delete-selected' )] = array(
				'class' => 'ep-pager-delete-selected',
				'data-type' => ApiDeleteEducation::getTypeForClassName( $this->className )
			);
		}
		
		return $actions;
	}

}
