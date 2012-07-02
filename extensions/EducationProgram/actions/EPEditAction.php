<?php

/**
 * Abstract action for editing EPPageObject items.
 *
 * @since 0.1
 *
 * @file EPEditAction.php
 * @ingroup EducationProgram
 * @ingroup Action
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class EPEditAction extends FormlessAction {
	
	/**
	 * Instance of the object being edited or created.
	 *
	 * @since 0.1
	 * @var EPPageObject|false
	 */
	protected $item = false;

	/**
	 * If the action is in insert mode rather then edit mode.
	 * 
	 * @since 0.1
	 * @var boolean|null
	 */
	protected $isNew = null;

	/**
	 * Returns the class name of the EPPageObject this action handles.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	protected abstract function getItemClass();
	
	/**
	 * (non-PHPdoc)
	 * @see FormlessAction::onView()
	 */
	public function onView() {
		$this->getOutput()->addModules( 'ep.formpage' );
		
		if ( $this->getRequest()->wasPosted() && $this->getUser()->matchEditToken( $this->getRequest()->getVal( 'wpEditToken' ) ) ) {
			$this->showForm();
		}
		else {
			$this->showContent();
		}
		
		return '';
	}
	
	/**
	 * Returns the page title.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	protected function getPageTitle() {
		$action = $this->isNew() ? 'add' : 'edit';
		return wfMsgExt(
			'ep-' . strtolower( $this->getName() ) . '-' . $action,
			'parsemag',
			$this->getTitle()->getText()
		);
	}

	/**
	 * Display the form and set the item field, or redirect the user.
	 *
	 * @since 0.1
	 */
	protected function showContent() {
		$c = $this->getItemClass(); // Yeah, this is needed in PHP 5.3 >_>

		$data = $this->getNewData();
		
		$object = $c::selectRow( null, $data );

		if ( $object !== false && $this->getRequest()->getText( 'redlink' ) === '1' ) {
			$this->getOutput()->redirect( $this->getTitle()->getLocalURL() );
		}
		else {
			if ( $object === false ) {
				$this->isNew = true;
				$object = new $c( $data, true );
			}
			elseif ( $this->isNewPost() ) {
				$this->showWarning( wfMessage( 'ep-' . strtolower( $this->getName() ) . '-exists-already' ) );
			}

			$this->getOutput()->setPageTitle( $this->getPageTitle() );
			$this->getOutput()->setSubtitle( $this->getDescription() );

			$this->item = $object;
			$this->showForm();
		}
	}
	
	/**
	 * Show a message in a warning box.
	 *
	 * @since 0.1
	 *
	 * @param Message $message
	 */
	protected function showWarning( Message $message ) {
		$this->getOutput()->addHTML(
			'<p class="visualClear warningbox">' . $message->parse() . '</p>'
			. '<hr style="display: block; clear: both; visibility: hidden;" />'
		);
	}

	/**
	 * Returns if the page should work in insertion mode rather then modification mode.
	 *
	 * @since 0.1
	 *
	 * @return boolean
	 */
	protected function isNew() {
		if ( is_null( $this->isNew ) ) {
			$this->isNew = $this->isNewPost();
		}

		return $this->isNew;
	}
	
	protected function isNewPost() {
		return $this->getRequest()->wasPosted() &&
			( $this->getRequest()->getCheck( 'isnew' ) || $this->getRequest()->getCheck( 'wpisnew' ) );
	}

	/**
	 * Show the form.
	 *
	 * @since 0.1
	 */
	protected function showForm() {
		$form = $this->getForm();

		if ( $this->getRequest()->wasPosted() && $this->getRequest()->getCheck( 'isnew' ) ) {
			$form->prepareForm();
			$form->displayForm( Status::newGood() );
		}
		else {
			if ( $form->show() ) {
				$this->onSuccess();
			}
		}
	}

	/**
	 * Returns the data to use as condition for selecting the object,
	 * or in case nothing matches the selection, the data to initialize
	 * it with. This is typically an identifier such as name or id.
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	protected function getNewData() {
		$data = array();

		if ( $this->isNewPost() ) {
			$data['name'] = $this->getRequest()->getVal( 'newname' );
		}
		else {
			$data['name'] = $this->getTitle()->getText();
		}

		$data['name'] = $this->getLanguage()->ucfirst( $data['name'] );

		return $data;
	}

	/**
	 * Get the query conditions to obtain the item based on the page title.
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	protected function getTitleConditions() {
		return array( 'name' => $this->getTitle()->getText() );
	}

	/**
	 * (non-PHPdoc)
	 * @see FormSpecialPage::getForm()
	 * @return HTMLForm|null
	 */
	protected function getForm() {
		$fields = $this->getFormFields();

		if ( $this->isNew() ) {
			$fields['isnew'] = array(
				'type' => 'hidden',
				'default' => 1,
			);
		}

		if ( $this->getRequest()->getCheck( 'wpreturnto' ) ) {
			$fields['returnto'] = array(
				'type' => 'hidden',
				'default' => $this->getRequest()->getText( 'wpreturnto' ),
			);
		}

		$form = new EPFailForm( $fields, $this->getContext() );

		$form->setQuery( array( 'action' => 'edit' ) );
		
		$form->setSubmitCallback( array( $this, 'handleSubmission' ) );
		$form->setSubmitText( wfMsg( 'educationprogram-org-submit' ) );
		$form->setSubmitTooltip( 'ep-form-save' );

		$action = $this->isNew() ? 'add' : 'edit';
		$form->setWrapperLegend( $this->msg( strtolower( $this->getName() ) . '-' . $action . '-legend' ) );

		$form->addButton(
			'cancelEdit',
			wfMsg( 'cancel' ),
			'cancelEdit',
			array(
				'target-url' => $this->getReturnToTitle()->getFullURL(),
			)
		);

//		$form->addButton(
//			'deleteEdit',
//			wfMsg( 'delete' ),
//			'deleteEdit'
//		);

		return $form;
	}

	/**
	 * (non-PHPdoc)
	 * @see FormSpecialPage::getFormFields()
	 * @return array
	 */
	protected function getFormFields() {
		$fields = array();

		$fields['id'] = array( 'type' => 'hidden' );

		$req = $this->getRequest();

		// This sort of sucks as well. Meh, HTMLForm is odd.
		if ( $req->wasPosted()
			&& $this->getUser()->matchEditToken( $req->getVal( 'wpEditToken' ) )
			&& $req->getCheck( 'wpitem-id' ) ) {
			$fields['id']['default'] = $req->getInt( 'wpitem-id' );
		}

		return $fields;
	}

	/**
	 * Populates the form fields with the data of the item
	 * and prefixes their names.
	 *
	 * @since 0.1
	 *
	 * @param array $fields
	 *
	 * @return array
	 */
	protected function processFormFields( array $fields ) {
		if ( $this->item !== false ) {
			foreach ( $fields as $name => &$data ) {
				if ( !array_key_exists( 'default', $data ) ) {
					$data['default'] = $this->getDefaultFromItem( $this->item, $name );
				}
			}
		}

		$mappedFields = array();

		foreach ( $fields as $name => $field ) {
			if ( $this->getRequest()->getCheck( 'isnew' ) ) {
				// HTML form is being a huge pain in running the validation on post,
				// so just remove it if when not appropriate.
				unset( $field['validation-callback'] );
				unset( $field['required'] );
			}

			$mappedFields['item-' . $name] = $field;
		}

		return $mappedFields;
	}

	/**
	 * Gets the default value for a field from the item.
	 *
	 * @since 0.1
	 *
	 * @param EPPageObject $item
	 * @param string $name
	 *
	 * @return mixed
	 */
	protected function getDefaultFromItem( EPPageObject $item, $name ) {
		return $item->getField( $name );
	}

	/**
	 * Gets called after the form is saved.
	 *
	 * @since 0.1
	 */
	public function onSuccess() {
		$this->getOutput()->redirect( $this->getReturnToTitle( true )->getLocalURL() );
	}
	
	/**
	 * Returns the title to return to after the form has been submitted,
	 * or when form use is aborted for some other reason.
	 * 
	 * @since 0.1
	 * 
	 * @param boolean $addedItem
	 * 
	 * @return Title
	 */
	protected function getReturnToTitle( $addedItem = false ) {
		if ( $this->getRequest()->getCheck( 'wpreturnto' ) ) {
			return Title::newFromText( $this->getRequest()->getText( 'wpreturnto' ) );
		}
		elseif ( !$addedItem && $this->isNew() ) {
			$c = $this->getItemClass(); // Yeah, this is needed in PHP 5.3 >_>
			return SpecialPage::getTitleFor( $c::getListPage() );
		}
		elseif ( $this->item !== false ) {
			return $this->item->getTitle();
		}
		else {
			$c = $this->getItemClass(); // Yeah, this is needed in PHP 5.3 >_>
			$fieldName = 'wpitem-' . $c::getIdentifierField();
			
			if ( $this->getRequest()->getCheck( $fieldName ) ) {
				return $c::getTitleFor( $this->getRequest()->getText( $fieldName ) );
			}
			else {
				return $this->getTitle();
			}
		}
	}

	/**
	 * Process the form.  At this point we know that the user passes all the criteria in
	 * userCanExecute().
	 *
	 * @param array $data
	 *
	 * @return Bool|Array
	 */
	public function handleSubmission( array $data ) {
		$fields = array();
		$unknownValues = array();

		$c = $this->getItemClass(); // Yeah, this is needed in PHP 5.3 >_>

		foreach ( $data as $name => $value ) {
			$matches = array();

			if ( preg_match( '/item-(.+)/', $name, $matches ) ) {
				if ( $matches[1] === 'id' && ( $value === '' || $value === '0' ) ) {
					$value = null;
				}

				if ( $c::canHasField( $matches[1] ) ) {
					$fields[$matches[1]] = $value;
				}
				else {
					$unknownValues[$matches[1]] = $value;
				}
			}
		}

		$keys = array_keys( $fields );
		$fields = array_combine( $keys, array_map( array( $this, 'handleKnownField' ), $keys, $fields ) );

		/* EPPageObject */ $item = new $c( $fields, is_null( $fields['id'] ) );

		foreach ( $unknownValues as $name => $value ) {
			$this->handleUnknownField( $item, $name, $value );
		}
		
		$revAction = new EPRevisionAction();
		$revAction->setUser( $this->getUser() );
		$revAction->setComment( '' ); // TODO
		$revAction->setMinor( false ); // TODO

		$success = $item->revisionedSave( $revAction );

		if ( $success ) {
			return true;
		}
		else {
			return array(); // TODO
		}
	}

	/**
	 * Gets called for evey unknown submitted value, so they can be dealt with if needed.
	 *$title = SpecialPage::getTitleFor( $this->itemPage, $this->subPage )->getLocalURL();
	 * @since 0.1
	 *
	 * @param EPDBObject $item
	 * @param string $name
	 * @param string $value This is a string, since it comes from request data, but might be a number or other type.
	 */
	protected function handleUnknownField( EPDBObject $item, $name, $value ) {
		// Override to use.
	}

	/**
	 * Gets called for evey known submitted value, so they can be dealt with if needed.
	 *
	 * @since 0.1
	 *
	 * @param string $name
	 * @param string $value This is a string, since it comes from request data, but might be a number or other type.
	 *
	 * @return mixed The new value
	 */
	protected function handleKnownField( $name, $value ) {
		// Override to use.
		return $value;
	}
	
	
}