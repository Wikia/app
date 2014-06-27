<?php

class HubsSlotsForm extends FormBuilderService {
	const SLOT_IMG_WIDTH = 330;
	const SLOT_IMG_HEIGHT = 210;

	public function __construct($prefix = '', $fields = []) {
		parent::__construct($prefix, $fields);

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
									'min-width' => 'manage-wikia-home-marketing-invalid-width',
									'max-width' => 'manage-wikia-home-marketing-invalid-width',
									'min-height' => 'manage-wikia-home-marketing-invalid-height',
									'max-height' => 'manage-wikia-home-marketing-invalid-height',
									'wrong-size' => 'manage-wikia-home-marketing-invalid-size'
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
