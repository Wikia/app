<?php

/**
 * Action to edit a course.
 *
 * @since 0.1
 *
 * @file EditCourseAction.php
 * @ingroup EducationProgram
 * @ingroup Action
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class EditCourseAction extends EPEditAction {
	
	/**
	 * (non-PHPdoc)
	 * @see Action::getName()
	 */
	public function getName() {
		return 'editcourse';
	}

	/**
	 * (non-PHPdoc)
	 * @see Action::getDescription()
	 */
	protected function getDescription() {
		return wfMsgHtml( $this->isNew() ? 'ep-addcourse' : 'ep-editcourse' );
	}

	/**
	 * (non-PHPdoc)
	 * @see Action::getRestriction()
	 */
	public function getRestriction() {
		return 'ep-course';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see EPEditAction::onView()
	 */
	public function onView() {
		$this->getOutput()->addModules( array( 'ep.datepicker', 'ep.combobox' ) );

		$c = $this->getItemClass(); // Yeah, this is needed in PHP 5.3 >_>
		
		if ( !$this->isNewPost() && !$c::hasIdentifier( $this->getTitle()->getText() ) ) {
			$name = $this->getTitle()->getText();
			$bracketPos = strpos( $name, '(' );
			
			if ( $bracketPos !== false ) {
				if ( $bracketPos > 0 && in_array( $name{$bracketPos - 1}, array( ' ', '_' ) ) ) {
					$bracketPos -= 1;
				}
				
				$name = substr( $name, 0, $bracketPos );
			}
			
			EPCourse::displayAddNewRegion(
				$this->getContext(),
				array(
					'name' => $this->getRequest()->getText(
						'newname',
						$name
					),
					'term' => $this->getRequest()->getText( 'newterm', '' ),
				)
			);

			$this->isNew = true;
			$this->getOutput()->setSubtitle( $this->getDescription() );
			
			return '';
		}
		else {
			return parent::onView();
		}
	}
	
	protected function getItemClass() {
		return 'EPCourse';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see EPEditAction::getFormFields()
	 * @return array
	 */
	protected function getFormFields() {
		$fields = parent::getFormFields();

		$orgOptions = EPOrg::getOrgOptions();

		$fields['name'] = array (
			'type' => 'text',
			'label-message' => 'ep-course-edit-name',
			'required' => true,
		);
		
		$mcs = EPCourse::selectFields( 'mc', array(), array( 'DISTINCT' ) );
		
		if ( $this->getRequest()->getCheck( 'newname' ) ) {
			$newName = $this->getRequest()->getText( 'newname' );
			$mcs = array_merge( array( $newName => $newName ), $mcs );
		}
		else {
			$mcs = array_merge( array( '' => '' ), $mcs );
		}
		
		
		$fields['mc'] = array (
			'class' => 'EPHTMLCombobox',
			'label-message' => 'ep-course-edit-mc',
			'required' => true,
			'options' => array_combine( $mcs, $mcs ),
		);

		$fields['org_id'] = array (
			'type' => 'select',
			'label-message' => 'ep-course-edit-org',
			'required' => true,
			'options' => $orgOptions,
			'validation-callback' => function ( $value, array $alldata = null ) use ( $orgOptions ) {
				return in_array( (int)$value, array_values( $orgOptions ) ) ? true : wfMsg( 'ep-course-invalid-org' );
			},
		);

		$fields['token'] = array (
			'type' => 'text',
			'label-message' => 'ep-course-edit-token',
			'maxlength' => 255,
			'size' => 20,
			'validation-callback' => function ( $value, array $alldata = null ) {
				$strLen = strlen( $value );
				return ( $strLen !== 0 && $strLen < 2 ) ? wfMsgExt( 'ep-course-invalid-token', 'parsemag', 2 ) : true;
			} ,
		);

		$fields['term'] = array (
			'type' => 'text',
			'label-message' => 'ep-course-edit-term',
			'required' => true,
		);

		$fields['start'] = array (
			'class' => 'EPHTMLDateField',
			'label-message' => 'ep-course-edit-start',
			'required' => true,
		);

		$fields['end'] = array (
			'class' => 'EPHTMLDateField',
			'label-message' => 'ep-course-edit-end',
			'required' => true,
		);

		$fieldFields = EPCourse::selectFields( 'field', array(), array( 'DISTINCT' ) );
		$fieldFields = array_merge( array( '' => '' ), $fieldFields );
		$fields['field'] = array (
			'class' => 'EPHTMLCombobox',
			'label-message' => 'ep-course-edit-field',
			'required' => true,
			'options' => array_combine( $fieldFields, $fieldFields ),
		);

		$levels = EPCourse::selectFields( 'level', array(), array( 'DISTINCT' ) );
		$levels = array_merge( array( '' => '' ), $levels );
		$fields['level'] = array (
			'class' => 'EPHTMLCombobox',
			'label-message' => 'ep-course-edit-level',
			'required' => true,
			'options' => array_combine( $levels, $levels ),
		);

		$langOptions = EPUtils::getLanguageOptions( $this->getLanguage()->getCode() );
		$fields['lang'] = array (
			'type' => 'select',
			'label-message' => 'ep-course-edit-lang',
			'maxlength' => 255,
			'required' => true,
			'options' => $langOptions,
			'validation-callback' => function ( $value, array $alldata = null ) use ( $langOptions ) {
				return in_array( $value, $langOptions ) ? true : wfMsg( 'ep-course-invalid-lang' );
			}
		);

		$fields['description'] = array (
			'type' => 'textarea',
			'label-message' => 'ep-course-edit-description',
			'required' => true,
			'validation-callback' => function ( $value, array $alldata = null ) {
				return strlen( $value ) < 10 ? wfMsgExt( 'ep-course-invalid-description', 'parsemag', 10 ) : true;
			} ,
			'rows' => 10,
			'id' => 'wpTextbox1',
		);

		return $this->processFormFields( $fields );
	}

	/**
	 * (non-PHPdoc)
	 * @see EPEditAction::getNewData()
	 */
	protected function getNewData() {
		$data = parent::getNewData();

		if ( $this->isNewPost() ) {
			$data['org_id'] = $this->getRequest()->getVal( 'neworg' );
			
			$data['name'] = wfMsgExt(
				'ep-course-edit-name-format',
				'parsemag',
				$data['name'],
				$this->getRequest()->getVal( 'newterm' )
			);
			
			$data['term'] = $this->getRequest()->getVal( 'newterm' );
			
			$data['mc'] = $data['name'];
		}

		return $data;
	}

	/**
	 * (non-PHPdoc)
	 * @see EPEditAction::handleKnownField()
	 */
	protected function handleKnownField( $name, $value ) {
		if ( in_array( $name, array( 'end', 'start' ) ) ) {
			$value = wfTimestamp( TS_MW, strtotime( $value ) );
		}

		return $value;
	}
	
}