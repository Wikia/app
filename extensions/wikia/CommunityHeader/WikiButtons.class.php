<?php

namespace Wikia\CommunityHeader;

class WikiButtons {
	public $buttons;
	public $moreButtons;

	public function __construct( \DesignSystemCommunityHeaderModel $model ) {
		$buttons = [];
		$moreButtons = [];

		foreach ( $model->getActionButtons() as $item ) {
			switch ( $item['type'] ) {
				case 'link-button':
					$buttons[] = $this->createButtonFromArray( $item );
					break;
				case 'link-group':
					foreach ( $item['items'] as $dropdownItem ) {
						$moreButtons[] = $this->createButtonFromArray( $dropdownItem );
					}

					$moreButtons[] = new WikiButton(
						'#',
						new Label( 'community-header-all-shortcuts', Label::TYPE_TRANSLATABLE_TEXT ),
						null,
						null,
						'more-all-shortcuts',
						'wiki-button-all-shortcuts'
					);
					break;
			}
		}

		$this->buttons = $buttons;
		$this->moreButtons = $moreButtons;
	}

	private function createButtonFromArray( array $item ): WikiButton {
		return new WikiButton(
			$item['href'],
			!empty( $item['label'] ) ? new Label( $item['label']['key'], $item['label']['type'] ) : null,
			!empty( $item['title'] ) ? new Label( $item['title']['key'], $item['title']['type'] ) : null,
			!empty( $item['image-data'] ) ? $item['image-data']['name'] : null,
			$item['tracking_label'],
			$this->getAdditionalClasses( $item )
		);
	}

	private function getAdditionalClasses( array $buttonData ): string {
		switch ( $buttonData['tracking_label'] ) {
			case 'add-new-page':
				return 'createpage';
			case 'more-add-new-video':
				return 'wiki-button-add-video';
			default:
				return '';
		}
	}
}
