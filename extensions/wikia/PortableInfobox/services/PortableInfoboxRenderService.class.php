<?php

class PortableInfoboxRenderService extends WikiaService {
	const LOGGER_LABEL = 'portable-infobox-render-not-supported-type';

	private $templates = [
		'wrapper' => 'PortableInfoboxWrapper.mustache',
		'title' => 'PortableInfoboxItemTitle.mustache',
		'header' => 'PortableInfoboxItemTitle.mustache',
		'image' => 'PortableInfoboxItemImage.mustache',
		'pair' => 'PortableInfoboxItemKeyVal.mustache',
		'group' => 'PortableInfoboxItemGroup.mustache',
		'comparison' => 'PortableInfoboxItemComparison.mustache',
		'comparison-set' => 'PortableInfoboxItemComparisonSet.mustache',
		'comparison-set-header' => 'PortableInfoboxItemComparisonSetHeader.mustache',
		'comparison-set-item' => 'PortableInfoboxItemComparisonSetItem.mustache',
		'footer' => 'PortableInfoboxItemFooter.mustache'
	];
	private $templateEngine;

	function __construct() {
		$this->templateEngine = ( new Wikia\Template\MustacheEngine )
			->setPrefix( dirname( __FILE__ ) . '/../templates' );
	}

	/**
	 * renders infobox
	 *
	 * @param array $infoboxdata
	 * @return string - infobox HTML
	 */
	public function renderInfobox( array $infoboxdata ) {
		$infoboxHtmlContent = '';

		foreach ( $infoboxdata as $item ) {
			$data = $item[ 'data' ];
			$type = $item[ 'type' ];

			if ( $item['isEmpty'] ) {
				continue;
			}

			switch ( $type ) {
				case 'comparison':
					$infoboxHtmlContent .= $this->renderComparisonItem( $data['value'] );
					break;
				case 'group':
					$infoboxHtmlContent .= $this->renderGroup( $data['value'] );
					break;
				case 'footer':
					$infoboxHtmlContent .= $this->renderItem( 'footer', $data );
					break;
				default:
					if ( $this->validateType( $type ) ) {
						$infoboxHtmlContent .= $this->renderItem( $type, $data );
					};
			}
		}

		return $this->renderItem( 'wrapper', [ 'content' => $infoboxHtmlContent ] );
	}

	/**
	 * renders comparison infobox component
	 *
	 * @param array $comparisonData
	 * @return string - comparison HTML
	 */
	private function renderComparisonItem( $comparisonData ) {
		$comparisionHTMLContent = '';

		foreach ( $comparisonData as $set ) {
			$setHTMLContent = '';

			if ( $set['isEmpty'] ) {
				continue;
			}

			foreach ( $set['data']['value'] as $item ) {
				$type = $item[ 'type' ];

				if ( $item['isEmpty'] ) {
					continue;
				}

				if ( $type === 'header' ) {
					$setHTMLContent .= $this->renderItem( 'comparison-set-header', $item[ 'data' ] );
				} else {
					if ( $this->validateType( $type ) ) {
						$setHTMLContent .= $this->renderItem(
							'comparison-set-item',
							[ 'content' => $this->renderItem( $type, $item[ 'data' ] ) ]
						);
					}
				}
			}

			$comparisionHTMLContent .= $this->renderItem( 'comparison-set', [ 'content' => $setHTMLContent ] );
		}

		return $this->renderItem( 'comparison', [ 'content' => $comparisionHTMLContent ] );
	}

	/**
	 * renders group infobox component
	 *
	 * @param array $groupData
	 * @return string - group HTML markup
	 */
	private function renderGroup( $groupData ) {
		$groupHTMLContent = '';

		foreach ( $groupData as $item ) {
			$type = $item['type'];

			if ( $item['isEmpty'] ) {
				continue;
			}

			if ( $this->validateType( $type ) ) {
				$groupHTMLContent .= $this->renderItem( $type, $item['data'] );
			}
		}

		return $this->renderItem( 'group', [ 'content' => $groupHTMLContent ] );
	}

	/**
	 * renders part of infobox
	 *
	 * @param string $type
	 * @param array $data
	 * @return string - HTML
	 */
	private function renderItem( $type, array $data ) {
		return $this->templateEngine->clearData()
			->setData( $data )
			->render( $this->templates[ $type ] );
	}

	/**
	 * check if item type is supported and logs unsupported types
	 *
	 * @param string $type - template type
	 * @return bool
	 */
	private function validateType( $type ) {
		$isValid = true;

		if ( !isset( $this->templates[ $type ] ) ) {
			Wikia\Logger\WikiaLogger::instance()->info( self::LOGGER_LABEL, [
				'type' => $type
			] );

			$isValid = false;
		}

		return $isValid;
	}
}
