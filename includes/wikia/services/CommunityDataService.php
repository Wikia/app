<?php
class CommunityDataService
{
	const NEW_API_VERSION = 1;
	private $curatedContentData = null;

	function __construct( $cityId ) {
		$this->cityId = $cityId;
	}

	private $wgWikiaCuratedContent = [
		'curated' => [
			[
				'label' => 'lol',
				'image_id' => 54434,
				'items' => [
					'item1' => 'costam',
					'item2' => 'cos innego'
					]
			],
			[
				'label' => 'lol2',
				'image_id' => 54434,
				'items' => [
					'item1' => [
						'article_id' => 195822,
						'image_id' => 195822,
						'items' => "",
						'label' => "The Muppets on ABC in 2015",
						'title' => "The Muppets (2015)",
						'type' => "article",
						'node_type' => "item"
					],
					'item2' => [
						'article_id' => 195822,
						'image_id' => 195822,
						'items' => "",
						'label' => "The Muppets on ABC in 2015",
						'title' => "The Muppets (2015)",
						'type' => "article",
						'node_type' => "item"
					],
				]
			]
		],
		'featured' => [
			'label' => 'some another featured label',
			'items' => [
				[
					'label' => 'featured lol',
					'image_id' => 54434,
					'items' => [
						'item1' => 'costam',
						'item2' => 'cos innego'
					]
				],
				[
					'label' => 'optional lol2',
					'image_id' => 54434,
					'items' => [
						'item1' => 'costam',
						'item2' => 'cos innego'
					]
				]
			]
		],
		'optional' => [
			'label' => 'some label',
			'items' => [
				[
					'label' => 'optional lol',
					'image_id' => 54434,
					'items' => [
						'item1' => 'costam',
						'item2' => 'cos innego'
					]
				],
				[
					'label' => 'optional lol2',
					'image_id' => 54434,
					'items' => [
						'item1' => 'costam',
						'item2' => 'cos innego'
					]
				]
			]
		],
		'community_data' => [
			'description' => '',
			'image_id' => 162219,
			'image_crop' => [
				'square' => [
					'x' => 0,
					'y'=> 0,
				'width'=> 512,
				'height'=> 512
				]
			]
		]
	];

	private function curatedContentData() {
		if ( empty( $this->curatedContentData ) ) {
			$this->curatedContentData = WikiFactory::getVarValueByName( 'wgWikiaCuratedContent', $this->cityId );
		}

		return $this->curatedContentData;

	}
	public function getCuratedContent() {
		$value = $this->curatedContentData();
		var_dump($value);

		//new markup
		if ( $this->isNewFormat( $value ) ) {
			var_dump("is Assoc!");die;
			return $value;
		}

		$curatedContent['sections'] = $this->getSectionsOld( $value );
		$curatedContent['optional'] = $this->getSectionItemsOld( $value, '' );
		$curatedContent['featured'] = $this->getFeaturedSection( $value );
		$curatedContent['categories'] = $this->getItemsFromSections( $value, $curatedContent['sections'] );
	}

	/**
	 * @param $data
	 * @return array[errors, status]
	 */
	public function setCuratedContent( $data ) {
		global $wgCityId;
		$results = [
			'errors' => [],
			'status' => []
		];

		$status = false;

		//if somehow we've got old format of wgVar
		//TODO: do we need this?
		if ( !$this->isNewFormat( $data ) ) {
			$data = $this->prepareOldFormatToSave( $data );
		}

		$helper = new CuratedContentHelper();
		$sections = $helper->processSections( $data );
		$errors = ( new CuratedContentValidator )->validateData( $sections );

		if ( !empty( $errors ) ) {
			$results['errors'][] = $errors;
		} else {
			$status = WikiFactory::setVarByName( 'wgWikiaCuratedContent', $wgCityId, $sections );
			wfWaitForSlaves();

			if ( !empty( $status ) ) {
				//TODO: check this
				wfRunHooks( 'CuratedContentSave', [ $sections ] );
			}
		}
		$results['status'] = $status;

		return $results;
	}

	public function getList( $section, $limit, $offset ) {
		//global $wgWikiaCuratedContent;

		//WIP: to be removed!
		$wgWikiaCuratedContent = $this->wgWikiaCuratedContent;
		$response = [];

		wfProfileIn( __METHOD__ );

		if ( empty( $wgWikiaCuratedContent ) ) {
			return $this->getCategories( $limit, $offset );
		} else {
			//new markup
			if ( $this->isNewFormat( $wgWikiaCuratedContent ) ) {

				if ( empty( $section ) ) {
					$response = $this->prepareGGData();
				} else {
					$items = $this->getSectionItemsByTitle( $section );
					$response['items'] = $this->prepareSectionItemsResponse( $items );
				}

			} else { //old markup, to be removed after migration
				if ( empty( $section ) ) {
					$response = $this->setSectionsInResponse( $wgWikiaCuratedContent );
					$featuredContent = $this->getFeaturedSection();

					if ( $featuredContent ) {
						$response['featured'] = $featuredContent;
					}
				} else {
					$items = $this->setSectionItemsInResponse( $wgWikiaCuratedContent, $section );
					$response['items'] = $items;
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $response;
	}

	/**
	 * This is an adapter which prepares the CuratedContent data
	 * format to be aligned with what the mobile apps are expecting
	 * @return array
	 */
	private function prepareGGData() {
		$response = [];

		if ( $this->wgWikiaCuratedContent['optional']['items'] ) {
			$response['sections'] = $this->getSectionItemsDetails( $this->wgWikiaCuratedContent['optional']['items'] );
		}

		// there also might be some curated content items (optionally)
		if ( $this->wgWikiaCuratedContent['curated'] ) {
			$response['items'] = $this->wgWikiaCuratedContent['curated'];
		}

		if ( isset( $this->wgWikiaCuratedContent['featured']['items'] ) ) {
			$response['featured'] = $this->wgWikiaCuratedContent['featured']['items'];
		}

		return $response;
	}

	// TODO: do we need this? Only one CC editor is this on Mercury
	private function prepareOldFormatToSave( $data ) {
		$properData = [];

		// strip excessive data used in mercury interface (added in self::getData method)
		foreach ( $data as $section ) {

			// strip node_type and image_url from section
			unset( $section['node_type'] );
			unset( $section['image_url'] );

			// fill label for featured and rename section.title to section.label
			if ( empty( $section['label'] ) && !empty( $section['featured'] ) ) {
				$section['title'] = wfMessage( 'wikiacuratedcontent-featured-section-name' )->text();
			} else {
				$section['title'] = $section['label'];
				unset( $section['label'] );
			}

			// strip node_type and image_url from items inside section and add it to new data
			if ( is_array( $section['items'] ) && !empty( $section['items'] ) ) {
				// strip node_type and image_url
				foreach ( $section['items'] as &$item ) {
					unset( $item['node_type'] );
					unset( $item['image_url'] );
				}

				$properData[] = $section;
			}
		}

		return $properData;
	}

	/**
	 * Needs to be removed after migration of wgWikiaCuratedContent
	 * to new format
	 *
	 * @param $curatedContent array
	 * @return bool true if wgWikiaCuratedContent has new format
	 */
	private function isNewFormat( $curatedContent ) {
		return ( array_values( $curatedContent ) !== $curatedContent );
	}

	public function getCuratedContentWithData() {
		//global $wgWikiaCuratedContent;

		$wgWikiaCuratedContent = $this->wgWikiaCuratedContent;
		//var_dump($wgWikiaCuratedContent);die;

		$data = [];

		if ( !empty( $wgWikiaCuratedContent ) && is_array( $wgWikiaCuratedContent ) ) {

			//new markup
			if ( $this->isNewFormat( $wgWikiaCuratedContent ) ) {
				//var_dump("is Assoc!");die;
				return $wgWikiaCuratedContent;
			}

			//old markup
			foreach ( $wgWikiaCuratedContent as $section ) {
				// update information about node type
				$section['node_type'] = 'section';

				// rename $section['title'] to $section['label']
				$section['label'] = $section['title'];
				unset( $section['title'] );

				if ( !empty( $section['label'] ) && empty( $section['featured'] ) ) {
					// load image for curated content sections (not optional, not featured)
					$section['image_url'] = CuratedContentHelper::findImageUrl( $section['image_id'] );
				}

				foreach ( $section['items'] as $i => $item ) {
					// load image for all items
					$section['items'][$i]['image_url'] = CuratedContentHelper::findImageUrl( $item['image_id'] );

					// update information about node type
					$section['items'][$i]['node_type'] = 'item';
				}

				$data[] = $section;
			}
		}

		return $data;
	}

	private function getSectionItemsDetails( $tems ) {
		wfProfileIn( __METHOD__ );

		$detailedItems = array_map( function( $item ) {
			$imageId = $item['image_id'] != 0 ? $item['image_id'] : null;
			$val = [
				'title' => $item['label'],
				'image_id' => $item['image_id'] != 0 ? $item['image_id'] : null,
				'image_url' => CuratedContentHelper::findImageUrl( $imageId )
			];

			if ( !empty( $item['image_id'] ) && array_key_exists( 'image_crop', $item ) ) {
				$val['image_crop'] = $item['image_crop'];
			}

			return $val;
		}, $tems );

		wfProfileOut( __METHOD__ );

		return $detailedItems;
	}

	/**
	 * Old functions supporting old format of wgWikiaCuratedContent variable.
	 * To be removed as soon as all wikias will be migrated to use new format.
	 */

	 /**
	 * @param $content
	 * @param $sections
	 * @return array
	 */
	private function getItemsFromSections( $content, $sections ) {
		$items = [ ];
		if ( is_array( $sections ) ) {
			foreach ( $sections as $section ) {
				$categoriesForSection = $this->getSectionItemsOld( $content, $section['title'] );
				foreach ( $categoriesForSection as $category ) {
					$items[] = $category;
				}
			}
		}
		return $items;
	}

	/**
	 * @param $content array wgWikiaCuratedContent
	 * @param $requestSection
	 * @return array
	 */
	private function getSectionItemsOld( $content, $requestSection ) {
		$return = [ ];

		foreach ( $content as $section ) {
			if ( $requestSection == $section['title'] && empty( $section['featured'] ) ) {
				$return = $section['items'];
			}
		}

		return $return;
	}

	/**
	 * @param $sectionTitle
	 * @return array
	 */
	private function getSectionItemsByTitle( $sectionTitle ) {
		$return = [ ];

		foreach ( $this->wgWikiaCuratedContent['curated'] as $section) {
			if ( $sectionTitle == $section['label'] ) {
				$return = $section['items'];
			}
		}

		return $return;
	}

	private function getFeaturedSection( ) {
		$return = [ ];
		foreach ( $this->wgWikiaCuratedContent as $section ) {
			if ( $section['featured'] ) {
				$return = $section['items'];
			}
		}

		return $return;
	}

	private function getSectionsOld( $content ) {
		var_dump($content);die;
		wfProfileIn( __METHOD__ );
		$sections = array_reduce(
			$content,
			function ( $ret, $item ) {
				//optional
				if ( $item['title'] !== '' && empty( $item['featured'] ) ) {
					$imageId = $item['image_id'] != 0 ? $item['image_id'] : null;
					$val = [
						'title' => $item['title'],
						'image_id' => $item['image_id'] != 0 ? $item['image_id'] : null,
						'image_url' => CuratedContentHelper::findImageUrl( $imageId )
					];

					if ( !empty( $item['image_id'] ) && array_key_exists( 'image_crop', $item ) ) {
						$val['image_crop'] = $item['image_crop'];
					}

					$ret[] = $val;
				}

				return $ret;
			}
		);

		wfProfileOut( __METHOD__ );

		return $sections;
	}

	/**
	 * @param $content array wgWikiaCuratedContent
	 * @param $requestSection
	 * @return array requested section
	 * @throws \CuratedContentSectionNotFoundException
	 */
	private function setSectionItemsInResponse( $content, $requestSection ) {
		$response = [];
		$sectionItems = $this->getSectionItemsOld( $content, $requestSection );
		if ( !empty( $sectionItems ) ) {
			$response['items'] = $this->prepareSectionItemsResponse( $sectionItems );
		} else if ( $requestSection !== '' ) {
			throw new CuratedContentSectionNotFoundException( $requestSection );
		}

		return $response;
	}

	/**
	 * @param $ret
	 *
	 * @return mixed
	 */
	private function prepareSectionItemsResponse( $ret ) {
		foreach ( $ret as &$value ) {
			list( $imageId, $imageUrl ) = CuratedContentHelper::findImageIdAndUrl(
				$value['image_id'],
				$value['article_id']
			);
			$value['image_id'] = $imageId;
			$value['image_url'] = $imageUrl;
		}

		return $ret;
	}

	/**
	 * @param $content Array content of a wgWikiaCuratedContent
	 *
	 * @responseReturn Array sections List of sections on a wiki
	 * @responseReturn See getSectionItemsOld
	 */
	private function setSectionsInResponse( $content ) {
		wfProfileIn( __METHOD__ );
		$response['sections'] = $this->getSectionsOld( $content );

		// there also might be some categories without SECTION, lets find them as well (optional section)
		$response['items'] = $this->getSectionItemsOld( $content, '' );

		wfProfileOut( __METHOD__ );

		return $response;
	}

	/**
	 *
	 * Returns list of categories on a wiki in batches by self::LIMIT
	 *
	 * @requestParam Integer limit
	 * @requestParam String offset
	 *
	 * @response items
	 * @response offset
	 */
	private function getCategories( $limit, $offset ) {
		wfProfileIn( __METHOD__ );

		$items = WikiaDataAccess::cache(
			wfMemcKey( __METHOD__, $offset, $limit, self::NEW_API_VERSION ),
			WikiaResponse::CACHE_SHORT,
			function () use ( $limit, $offset ) {
				return ApiService::call(
					[
						'action' => 'query',
						'list' => 'allcategories',
						'redirects' => true,
						'aclimit' => $limit,
						'acfrom' => $offset,
						'acprop' => 'id|size',
						// We don't want empty items to show up
						'acmin' => 1
					]
				);
			}
		);

		$allCategories = $items['query']['allcategories'];
		if ( !empty( $allCategories ) ) {

			$ret = [ ];
			$app = F::app();
			$categoryName = $app->wg->contLang->getNsText( NS_CATEGORY );

			foreach ( $allCategories as $value ) {
				if ( $value['size'] - $value['files'] > 0 ) {
					$ret[] = $this->getJsonItem(
						$value['*'],
						$categoryName,
						isset( $value['pageid'] ) ? (int) $value['pageid'] : 0
					);
				}
			}

			$response['items'] = $ret;

			if ( !empty( $items['query-continue'] ) ) {
				$response['offset'] = $items['query-continue']['allcategories']['acfrom'] ;
			}
		} else {
			wfProfileOut( __METHOD__ );
			throw new NotFoundApiException( 'No Curated Content' );
		}

		wfProfileOut( __METHOD__ );

		return $response;
	}

	//TODO: public?
	function getJsonItem( $titleName, $ns, $pageId ) {
		$title = Title::makeTitle( $ns, $titleName );
		list( $imageId, $imageUrl ) = CuratedContentHelper::findImageIdAndUrl( null, $pageId );

		return [
			'title' => $ns . ':' . $title->getFullText(),
			'label' => $title->getFullText(),
			'image_id' => $imageId,
			'article_id' => $pageId,
			'type' => 'category',
			'image_url' => $imageUrl
		];
	}

	public function getCommunityData() {
		$data = $this->curatedContentData();
		return isset( $data['community_data'] ) ? $data['community_data'] : [];
	}

	public function getCommunityDescription() {
		$data = $this->curatedContentData();
		return isset( $data['community_data']['description'] ) ? $data['community_data']['description'] : [];
	}

	public function getCommunityImageId() {
		$data = $this->curatedContentData();
		return isset( $data['community_data']['image_id']) ? $data['community_data']['image_id'] : 0;
	}

	public function getCommunityDescription() {
		return "some description";
	}
}