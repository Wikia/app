<?php

class HubsSlotsForm extends FormBuilderService {
	public function __construct($prefix = '', $fields = []) {
		parent::__construct($prefix, $fields);

		$errorWidth = wfMessage(
			'manage-wikia-home-marketing-invalid-width',
			WikiaHomePageController::SLOT_IMG_WIDTH
		)->plain();

		$errorHeight =  wfMessage(
			'manage-wikia-home-marketing-invalid-height',
			WikiaHomePageController::SLOT_IMG_HEIGHT
		)->plain();

		if(empty($fields)) {
			$fields = [
				'hub_slot' => [
					'label' => wfMessage('manage-wikia-home-hubs-slot-name')->plain(),
					'type' => 'select',
					'isArray' => true
				],

			];
			$fields['marketing_slot_title'] = [
				'label' => 'Title',
				'type' => 'text',
				'isArray' => true
			];
			$fields['marketing_slot_image'] = [
				'type' => 'hidden',
				'validator' => new WikiaValidatorListValue(
						array(
							'validator' => new WikiaValidatorImageSize(
								array(
									'minWidth' => WikiaHomePageController::SLOT_IMG_WIDTH,
									'minHeight' => WikiaHomePageController::SLOT_IMG_HEIGHT,
									'maxWidth' => WikiaHomePageController::SLOT_IMG_WIDTH,
									'maxHeight' => WikiaHomePageController::SLOT_IMG_HEIGHT,
								),
								array(
									'min-width' => $errorWidth,
									'max-width' => $errorWidth,
									'min-height' => $errorHeight,
									'max-height' => $errorHeight,
									'wrong-size' => $errorHeight =  wfMessage(
											'manage-wikia-home-marketing-invalid-size',
											WikiaHomePageController::SLOT_IMG_WIDTH,
											WikiaHomePageController::SLOT_IMG_HEIGHT
										)->plain()
								)
							),
						)
					),
				'attributes' => array(
					'class' => 'required wmu-file-name-input'
				),
				'class' => 'hidden',
				'label' => 'Image',
				'isArray' => true
			];
			$fields['marketing_slot_link'] = [
				'label' => 'Link',
				'type' => 'text',
				'isArray' => true
			];
		}

		$this->setFields( $fields );
	}
}
