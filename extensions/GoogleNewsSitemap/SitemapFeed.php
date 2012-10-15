<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

class SitemapFeed extends ChannelFeed {
	private $writer;
	private $publicationName;
	private $publicationLang;

	function __construct() {
		global $wgSitename, $wgLanguageCode;

		$this->writer = new XMLWriter();
		$this->publicationName = $wgSitename;
		$this->publicationLang = $wgLanguageCode;
	}

	/**
	 * Set the publication language code. Only used if different from
	 * $wgLanguageCode, which could happen if Google disagrees with us
	 * on say what code zh gets.
	 * @param String $lang Language code (like en)
	 */
	public function setPublicationLang( $lang ) {
		$this->publicationLang = $lang;
	}

	/**
	 * Set the publication name. Normally $wgSitename, but could
	 * need to be changed, if Google gives the publication a different
	 * name then $wgSitename.
	 * @param String $name The name of the publication
	 */
	public function setPublicationName( $name ) {
		$this->publicationName = $name;
	}

	function contentType() {
		return 'application/xml';
	}

	/**
	 * Output feed headers.
	 */
	public function outHeader() {
		$this->httpHeaders();

		$this->writer->openURI( 'php://output' );
		$this->writer->setIndent( true );
		$this->writer->startDocument( '1.0', 'UTF-8' );
		$this->writer->startElement( 'urlset' );
		$this->writer->writeAttribute( 'xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9' );
		$this->writer->writeAttribute( 'xmlns:news', 'http://www.google.com/schemas/sitemap-news/0.9' );
	}

	/**
	 * Output a SiteMap 0.9 item
	 * @param FeedSMItem $item to be output
	 */
	public function outItem( $item ) {
		if ( !( $item instanceof FeedItem ) ) {
			throw new MWException( 'Requires a FeedItem or subclass.' );
		}

		wfProfileIn( __METHOD__ );
		if ( !( $item instanceof FeedSMItem ) ) {
			$item = FeedSMItem::newFromFeedItem( $item );
		}

		$this->writer->startElement( 'url' );

		$this->writer->startElement( 'loc' );
		$this->writer->text( $item->getUrl() );
		$this->writer->endElement();

		$this->writer->startElement( 'news:news' );

		$this->writer->startElement( 'news:publication_date' );
		$this->writer->text( wfTimestamp( TS_ISO_8601, $item->getDate() ) );
		$this->writer->endElement();

		$this->writer->startElement( 'news:title' );
		$this->writer->text( $item->getTitle() );
		$this->writer->endElement();

		$this->writer->startElement( 'news:publication' );
		$this->writer->startElement( 'news:name' );
		$this->writer->text( $this->publicationName );
		$this->writer->endElement();
		$this->writer->startElement( 'news:language' );
		$this->writer->text( $this->publicationLang );
		$this->writer->endElement();
		$this->writer->endElement();

		if ( $item->getKeywords() ) {
			$this->writer->startElement( 'news:keywords' );
			$this->writer->text( $item->getKeywords() );
			$this->writer->endElement();
		}

		$this->writer->endElement(); // end news:news
		if ( $item->getLastMod() ) {
			$this->writer->startElement( 'lastmod' );
			$this->writer->text( wfTimestamp( TS_ISO_8601, $item->getLastMod() ) );
			$this->writer->endElement();
		}
		$this->writer->endElement(); // end url
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Output SiteMap 0.9 footer
	 */
	public function outFooter() {
		$this->writer->endDocument();
		$this->writer->flush();
	}
}
