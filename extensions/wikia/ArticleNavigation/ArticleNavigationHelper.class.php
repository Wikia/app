<?php

class ArticleNavigationHelper {

	public function getUserLanguageCode( $request ) {
		static $language = null;

		if ( $language === null ) {
			global $wgLang;

			$language  = $request->getVal( 'lang' );

			if ( !$language ) {
				$language = $wgLang->getCode();
			}
		}
		return $language;
	}

	public function isValidShareService( $service, $lang ) {

		// filter through include list, default ot true
		if ( array_key_exists( 'languages:include', $service ) && is_array( $service['languages:include'] ) ) {
			$allowedInLanguage = in_array( $lang, $service['languages:include']);
		} else {
			$allowedInLanguage = true;
		}

		// filter through exclude list
		if ( array_key_exists( 'languages:exclude', $service ) && is_array( $service['languages:exclude'] ) ) {
			$allowedInLanguage = $allowedInLanguage && !in_array( $lang, $service['languages:exclude']);
		}

		return $allowedInLanguage && array_key_exists( 'url', $service ) && array_key_exists( 'name', $service );
	}

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
