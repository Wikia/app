<?php

/**
 * Article in layer namespace with maps layer specific information rendering at
 * beginning and top of the page.
 *
 * @since 3.0 (class with same name in 0.7.1+ but different purpose, 100% rewritten in 3.0)
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Daniel Werner
 */
class MapsLayerPage extends Article {

	protected $usageTitles = null;

	function __construct( Title $title, $oldId = null ) {
		parent::__construct( $title, $oldId );
	}

	/**
	 * Designed similar to CategoryPage.
	 *
	 * @see Article::view
	 *
	 * @since 3.0
	 */
	public function view() {
		global $wgRequest, $wgUser;

		$diff = $wgRequest->getVal( 'diff' );
		$diffOnly = $wgRequest->getBool( 'diffonly', $wgUser->getOption( 'diffonly' ) );

		if( isset( $diff ) && $diffOnly ) {
			return parent::view();
		}

		if( !Hooks::run( 'MapsLayerPageView', array( &$this ) ) ) {
			return;
		}

		if( Maps_NS_LAYER == $this->mTitle->getNamespace() ) {
			$this->openShowLayer();
		}

		parent::view();

		if( Maps_NS_LAYER == $this->mTitle->getNamespace() ) {
			$this->closeShowLayer();
		}
	}

	/**
	 * Function called before page rendering.
	 *
	 * @since 3.0
	 */
	protected function openShowLayer() {
	}

	/**
	 * Function called at the end of page rendering.
	 *
	 * @since 3.0
	 */
	protected function closeShowLayer() {
		$this->renderUsage();
	}

	/**
	 * Renders the category-page like view which shows the usage of this
	 * layer page in other pages.
	 *
	 * @since 3.0
	 */
	public function renderUsage() {
		global $wgOut;
		$out = '';

		$titles = $this->getUsageTitles();

		$viewer = new CategoryViewer( $this->mTitle, $this->getContext() );
		$viewer->limit = 9999; // just overwrite the default limit of pages displayed in a normal category

		// now add apges in sorted order to category viewer:
		foreach( $titles as $title ) {
			$viewer->addPage( $title, $title->getPrefixedText(), null );
		}

		//$wgOut->addHTML( $viewer->formatList( $viewer->articles, '' ) );
		$out  = "<div id=\"mw-pages\">\n";
		$out .= '<h2>' . wfMessage( 'maps-layerpage-usage', $this->mTitle->getText() )->text() . "</h2>\n";

		if( !empty( $viewer->articles ) ) {
			$out .= $viewer->formatList( $viewer->articles, $viewer->articles_start_char );
		} else {
			$out .= wfMessage( 'maps-layerpage-nousage' )->text();
		}
		$out .= "\n</div>";

		$wgOut->addHTML( $out );
	}

	/**
	 * returns all Titles using this layer page
	 *
	 * @since 3.0
	 *
	 * @return Array
	 */
	public function getUsageTitles() {
		// cached result:
		if( $this->usageTitles !== null ) {
			return $this->usageTitles;
		}

		$db = wfGetDB( DB_SLAVE );
		$items = $db->select(
			'templatelinks',
			'*',
			array(
				'tl_title = "' . $this->mTitle->getDBkey() . '"',
				'tl_namespace = ' . $this->mTitle->getNamespace(),
			),
			__METHOD__
		);

		// get pages and sort them first:
		$titles = array();
		foreach( $items as $item ) {
			$title = Title::newFromID( $item->tl_from );

			if( $title !== null ) {
				$titles[ $title->getPrefixedText() ] = $title;
			}
		}
		unset( $items, $item );
		ksort( $titles, SORT_STRING );

		return $this->usageTitles = $titles;
	}

	/**
	 * Returns if the layer page has any layer defined which has a definition that is 'ok',
	 * meaning, the layer can be used in a map.
	 *
	 * @since 3.0
	 *
	 * @param string $name if set, only for the layer definition with this name will be searched.
	 * @param string $service if set, only layers supporthing this service will be taken in account.
	 *
	 * @return boolean
	 */
	public function hasUsableLayer( $name = null, $service = null ) {
		// if name is given, get only that layer to check on, otherwise all:
		if( $name !== null ) {
			$layer = MapsLayers::loadLayer( $this->getTitle(), $name );

			if( $layer === null ) {
				return false;
			}
			$layers = array( $layer );
		} else {
			$layers = MapsLayers::loadLayerGroup( $this->getTitle() );
			$layers = $layers->getLayers();
		}

		// datermine whether any layer is usable:
		foreach( $layers as $layerName => $layer )  {
			if(
				$layer->isOk() // doesn't have to be 100% valid, just valid enough to be usable!
				&& ( $service === null || $layer->isSupportingService( $service ) )
			) {
				return true;
			}
		}
		return false;
	}
}
