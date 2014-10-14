<?php
/**
 * @author Piotr Bablok
 */

class SpecialAbTesting2Controller extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('AbTesting2', 'abtestpanel', false);
	}

	public function index() {
		if ( !$this->wg->User->isAllowed( 'abtestpanel' ) ) {
			$this->skipRendering();
			throw new PermissionsError( 'abtestpanel' );
		}

		$this->getResponse()->addModuleStyles('wikia.ext.abtesting.edit.styles');
		$this->getResponse()->addModuleStyles('wikia.ext.abtesting.edit2.styles');
		$this->getResponse()->addModules('wikia.ext.abtesting.edit');
		$this->getResponse()->addModules('wikia.ext.abtesting.edit2');
		$this->setHeaders();

		$abData = new AbTestingData();
		$experiments = $abData->getAll();
		foreach ($experiments as &$exp) {
			$exp['actions'] = array();
			$exp['actions'][] = array(
				'cmd' => 'delete-experiment',
				'class' => 'secondary',
				'spriteclass' => 'remove sprite',
				'text' => wfMessage('abtesting-remove-button')->text(),
			);

			// add "Cancel" button - only for ongoing experiments
			// does not remove experiment data, only removes it's
			// active state
			if ( $exp['status'] == AbTesting::STATUS_ACTIVE ) {
				$exp['actions'][] = array(
					'cmd' => 'cancel-experiment',
					'class' => 'secondary',
					'spriteclass' => '',
					'text' => wfMessage('abtesting-cancel-button')->text(),
				);
			}
			// add "Edit experiment" button
			$exp['actions'][] = array(
				'cmd' => 'edit-experiment',
				'class' => '',
				'spriteclass' => 'edit-pencil sprite',
				'text' => wfMessage('abtesting-edit-button')->text(),
			);
		}
		$this->setVal( 'experiments', $experiments );

		$actions = array();
		$actions[] = array(
			'cmd' => 'add-experiment',
			'class' => 'add sprite-small',
			'text' => wfMessage('abtesting-create-experiment')->text(),
		);
		$this->setVal( 'actions', $actions );

	}

}