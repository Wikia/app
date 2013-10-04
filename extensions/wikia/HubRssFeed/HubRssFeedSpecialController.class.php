<?php
/**
 * Created by JetBrains PhpStorm.
 * User: krzychu
 * Date: 04.10.13
 * Time: 13:08
 * To change this template use File | Settings | File Templates.
 */

class HubRssFeedSpecialController extends WikiaSpecialPageController {
	const PARAM_VERTICAL_ID = 'vertical';

	/**
	 * @var HubRssFeedModel
	 */
	protected $model;

	/**
	 * @param \HubRssFeedModel $model
	 */
	public function setModel( $model ) {
		$this->model = $model;
	}

	/**
	 * @return \HubRssFeedModel
	 */
	public function getModel() {
		return $this->model;
	}


	public function __construct() {
		parent::__construct( 'HubRssFeed', 'HubRssFeed', false );
		$this->model = new HubRssFeedModel();
	}

	public function index() {

		$verticalId = $this->request->getInt( self::PARAM_VERTICAL_ID, WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT );

		if ( !$this->model->isValidVerticalId( $verticalId ) ) {
			throw new InvalidHubAttributeException(self::PARAM_VERTICAL_ID);
		}

		$data = $this->model->getDataFromModules( $verticalId );
		$xml = $this->dataToXml( $data );
		$this->response->setFormat( WikiaResponse::FORMAT_RAW );
		$this->response->setBody( $xml );
		$this->response->setContentType( 'application/rss+xml' );
	}

	private function dataToXml( $data ) {
		ini_set( 'html_errors', 0 );
		$doc = new DOMDocument();
		$doc->loadXML( file_get_contents( dirname( __FILE__ ) . '/templates/rss.xml' ) );
		$rssList = $doc->getElementsByTagName( 'rss' );
		$rss = $rssList->item( 0 );
		self::appendTextNode($doc,$rss,'title');

		$channel = $rss->appendChild( new DOMElement('channel') );

		foreach ( $data[ 'items' ] as $url => $item ) {

			self::appendCDATA( $doc, $channel, 'title', $item[ 'title' ] );
			self::appendCDATA( $doc, $channel, 'description', '<img src="' . $item[ 'img' ] . '"/><p>' . $item[ 'description' ] . '</p>' );
			self::appendCDATA( $doc, $channel, 'url', $url );

			$channel->appendChild(new DOMElement('pubDate', date('D, m M Y H:i:s e'))); //date('c') ?
			$channel->appendChild(new DOMElement('creator','Wikia','http://purl.org/dc/elements/1.1/'));

		}

		return $doc->saveXML();
	}

	private static function appendCDATA( DOMDocument $doc, DOMElement $node, $name, $data = '' ) {
		$cdata = $doc->createCDATASection( $data );
		$element = $node->appendChild( new DOMElement($name) );
		$element->appendChild( $cdata );
	}


	private static function appendTextNode( DOMDocument $doc, DOMElement $node, $name, $data = '' ) {
		$cdata = $doc->createTextNode( $data );
		$element = $node->appendChild( new DOMElement($name) );
		$element->appendChild( $cdata );
	}

}