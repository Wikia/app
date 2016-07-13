<?php
use Wikia\Paginator\Paginator;

/**
 * Main Category Gallery class
 */
abstract class CategoryExhibitionSection {
	const CACHE_VERSION = 105;

	protected $thumbWidth = 130;
	protected $thumbHeight = 115;
	protected $thumbMedia = 130;

	protected $urlParams;
	protected $cacheHelper;
	protected $categoryTitle;

	protected $paginatorPosition;
	protected $templateName = 'item-regular';

	// Need to set those four in generateSectionData:
	/** @var string HTML ID for the section */
	protected $sectionId = null;
	/** @var Message message to display in the section header */
	protected $headerMessage = null;
	/** @var string[] the current page contents, one item at a time */
	protected $items = [];
	/** @var Paginator the paginator object */
	protected $paginator = null;

	/**
	 * You need to override this method to generate the four members mentioned above
	 * You should probably use generateData method to generate items and paginator
	 * You can then override getTemplateVarsForItem to modify what variables are
	 * passed to the item template. The file used may be changed by overriding $templateName
	 *
	 * @return void
	 */
	abstract protected function generateSectionData();

	public function __construct( Title $oCategoryTitle, CategoryUrlParams $urlParams = null ) {
		$this->categoryTitle = $oCategoryTitle;
		$this->urlParams = $urlParams;
		$this->paginatorPosition = max( 1, $this->urlParams->getPage() );
		$this->cacheHelper = new CategoryExhibitionCacheHelper();
		$this->generateSectionData();
	}

	/**
	 * Main read interface of the class
	 * Returns an array of the data needed to render the section-wrapper template.
	 * The same response is returned to AJAX-based paginator
	 *
	 * @return array
	 */
	public function getTemplateVars() {
		$vars = [
			'sectionId' => $this->sectionId,
			'headerMessage' => $this->headerMessage,
			'items' => join( PHP_EOL, $this->items ),
			'paginator' => '',
		];

		if ( $this->paginator ) {
			$vars['paginator'] = $this->paginator->getBarHTML();
		}

		return $vars;
	}

	/**
	 * @return Paginator|null
	 */
	public function getPaginator() {
		return $this->paginator;
	}

	/**
	 * Wrapper around CategoryDataService
	 * TODO: merge with getDataFromDataService
	 * @param $mNamespace mixed: int namespace or array of int for category query
	 * @param $exclude boolean: false = only include given namespaces, true = exclude given namespaces
	 * @return array
	 */
	private function fetchDataFromService( $mNamespace, $exclude, $sortType ) {
		$sCategoryDBKey = $this->categoryTitle->getDBkey();

		// Check if page is a redirect
		if ( $this->categoryTitle->isRedirect() ) {
			/* @var WikiPage $oTmpArticle */
			$oTmpArticle = new Article( $this->categoryTitle );
			if ( !is_null( $oTmpArticle ) ) {
				$rdTitle = $oTmpArticle->getRedirectTarget();
				if ( !is_null( $rdTitle ) && ( $rdTitle->getNamespace() == NS_CATEGORY ) ) {
					$sCategoryDBKey = $rdTitle->getDBkey();
				}
			}
		}
		if ( !is_array( $mNamespace ) ) {
			$ns = (int) $mNamespace;
		} else {
			$ns = implode( ',', $mNamespace );
		}

		if ( $sortType === 'mostvisited' ) {
			if ( !is_array( $mNamespace ) ) {
				$mNamespace = [ (int) $mNamespace ];
			}

			$res = CategoryDataService::getMostVisited( $sCategoryDBKey, $mNamespace, false, $exclude );
			if ( !empty( $res ) ) {
				return $res;
			}
		}

		return CategoryDataService::getAlphabetical( $sCategoryDBKey, $ns, $exclude );
	}

	/**
	 * Select items in (or not in) given namespace (or namespaces) from CategoryDataService,
	 * paginate, select the current page, render the items using getTemplateVarsForItem
	 * method to generate template context for each of the items. Save the array of the
	 * rendered items to $this->items. Save the paginator object in $this->paginator
	 *
	 * @param $namespace
	 * @param int $itemsPerPage
	 * @param bool $negative
	 */
	protected function generateData( $namespace, $itemsPerPage = 16, $negative = false ){
		$data = WikiaDataAccess::cache(
			$this->getKey(),
			60 * 30,
			function () use ( $namespace, $itemsPerPage, $negative ) {
				$serviceData = $this->fetchDataFromService(
					$namespace,
					$negative,
					$this->urlParams->getSortType()
				);

				if ( is_array( $serviceData ) ) {
					$paginator = $this->getPaginatorForData( $serviceData, $itemsPerPage );
					return [
						'paginator' => $paginator,
						'items' => $this->renderItems( $paginator->getCurrentPage( $serviceData ) ),
					];
				}
			}
		);

		if ( $data ) {
			$this->items = $data['items'];
			$this->paginator = $data['paginator'];
		}
	}

	private function renderItems( $items ) {
		$oTmpl = new EasyTemplate( __DIR__ . '/templates/' );
		$out = [];
		foreach ( $items as $item ) {
			$articleData = $this->getTemplateVarsForItem( $item['page_id'] );
			if ( is_array( $articleData ) ) {
				$oTmpl->set( 'row', $articleData );
				$out[] = $oTmpl->render( $this->templateName );
			}
		};
		return $out;
	}

	private function getPaginatorForData( $serviceData, $itemsPerPage ) {
		$paginator = new Paginator(
			count( $serviceData ),
			$itemsPerPage,
			$this->categoryTitle->getFullURL( [
				'display' => $this->urlParams->getDisplayParam(),
				'sort' => $this->urlParams->getSortParam(),
			] )
		);
		$paginator->setActivePage( $this->paginatorPosition );
		return $paginator;
	}

	/**
	 * Returns image from page.
	 * @param $mPageId int page id
	 * @return string - image url
	 */
	protected function getImageFromPageId( $mPageId ) {
		if ( !is_array( $mPageId ) ){
			$mPageId = array( $mPageId );
		}

		$imageServing = new ImageServing( $mPageId, $this->thumbWidth , array( "w" => $this->thumbWidth, "h" => $this->thumbHeight ) );
		$imageUrl = '';

		foreach ( $imageServing->getImages( 1 ) as $value ){
			if ( !empty( $value[0]['name'] ) ){
				$tmpTitle = Title::newFromText( $value[0]['name'], NS_FILE );
				$image = wfFindFile( $tmpTitle );
				if ( empty( $image ) ){
					return '';
				}
				// ImageServing is not re-entrant, it has internal state which can break cropping
				$cropper = new ImageServing( $mPageId, $this->thumbWidth , array( "w" => $this->thumbWidth, "h" => $this->thumbHeight ) );
				$imageUrl = wfReplaceImageServer(
					$image->getThumbUrl(
						$cropper->getCut( $image->getWidth(), $image->getHeight() )."-".$image->getName()
					)
				);
			}
		}
		return $imageUrl;
	}

	protected function getTemplateVarsForItem( $pageId ) {
		$oTitle = Title::newFromID( $pageId );
		if ( !( $oTitle instanceof Title ) ) {
			return false;
		}

		$oMemCache = F::App()->wg->memc;
		$sKey = wfMemcKey(
			'category_exhibition_category_cache_1',
			$pageId,
			$this->cacheHelper->getTouched( $oTitle )
		);

		$cachedResult = $oMemCache->get( $sKey );

		if ( !empty( $cachedResult ) ) {
			return $cachedResult;
		}

		$snippetText = '';
		$imageUrl = $this->getImageFromPageId( $pageId );

		if ( empty( $imageUrl ) ) {
			$snippetService = new ArticleService ( $oTitle );
			$snippetText = $snippetService->getTextSnippet();
		}

		$returnData = array(
			'id' => $pageId,
			'img' => $imageUrl,
			'width' => $this->thumbWidth,
			'height' => $this->thumbHeight,
			'snippet' => $snippetText,
			'title' => $oTitle->getText(),
			'url' => $oTitle->getFullURL(),
		);

		// will be purged elsewhere after edit
		$oMemCache->set( $sKey, $returnData, 60 * 60 * 24 );

		return $returnData;
	}

	/**
	 * Caching functions.
	 */
	protected function getKey() {
		return wfMemcKey(
			'category_exhibition_section_0',
			self::CACHE_VERSION,
			md5( $this->categoryTitle->getDBKey() ),
			get_class( $this ),
			$this->paginatorPosition,
			$this->urlParams->getDisplayType(),
			$this->urlParams->getSortType(),
			$this->cacheHelper->getTouched( $this->categoryTitle ),
			// Those are mentioned separately because they modify the pagination URL
			$this->urlParams->getDisplayParam(),
			$this->urlParams->getSortParam()
		);
	}
}
