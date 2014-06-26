<?php

class HubsSlotsForm extends FormBuilderService {
	const SLOT_IMG_WIDTH = 330;
	const SLOT_IMG_HEIGHT = 210;

	public function __construct($prefix = '', $fields = []) {
		parent::__construct($prefix, $fields);

		$errorWidth = wfMessage(
			'manage-wikia-home-marketing-invalid-width',
			self::SLOT_IMG_WIDTH
		)->plain();

		$errorHeight =  wfMessage(
			'manage-wikia-home-marketing-invalid-height',
			self::SLOT_IMG_HEIGHT
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
									'minWidth' => self::SLOT_IMG_WIDTH,
									'minHeight' => self::SLOT_IMG_HEIGHT,
									'maxWidth' => self::SLOT_IMG_WIDTH,
									'maxHeight' => self::SLOT_IMG_HEIGHT,
								),
								array(
									'min-width' => $errorWidth,
									'max-width' => $errorWidth,
									'min-height' => $errorHeight,
									'max-height' => $errorHeight,
									'wrong-size' => $errorHeight =  wfMessage(
											'manage-wikia-home-marketing-invalid-size',
											self::SLOT_IMG_WIDTH,
											self::SLOT_IMG_HEIGHT
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
