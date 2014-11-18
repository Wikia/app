<?php

class ArticleNavigationHelper {

	public function onOverwriteTOC( &$title, &$toc ) {
		if ( F::app()->checkSkin( 'venus' ) ) {
			$toc = '';
		}
		return true;
	}

	public function extractDropdownData( $items ) {
		$dropdownItems = [];
		foreach ( $items as $item ) {
			if (
				!empty( $item['type'] )
				&& $item['type'] !== 'disabled'
				&& !empty( $item['href'] )
				&& !empty( $item['caption'] )
			) {
				$dropdownItem = [];

				$dropdownItem['title'] = $item['caption'];
				$dropdownItem['href'] = $item['href'];

				if ( !empty( $item['tracker-name'] ) ) {
					$dropdownItem['dataAttr'] = [
						'key' => 'name',
						'value' => $item['tracker-name']
					];
				}

				if ( $item['type'] == 'customize' ) {
					$dropdownItem['class'] = 'tools-customize';
				}

				if ( $item['type'] == 'menu' ) {
					$dropdownItem['sections'] = $this->extractDropdownData( $item['items'] );
				}

				$dropdownItems[] = $dropdownItem;
			}
		}

		return $dropdownItems;
	}
}
