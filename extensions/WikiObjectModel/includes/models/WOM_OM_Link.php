<?php
/**
 * This model implements Link models.
 *
 * @author Ning
 * @file
 * @ingroup WikiObjectModels
 *
 */

class WOMLinkModel extends WikiObjectModel {
	protected $m_link;
	protected $m_caption;

	public function __construct( $link, $caption = null ) {
		parent::__construct( WOM_TYPE_LINK );
		$this->m_link = $link;
		$this->m_caption = $caption;
	}

	private function isInline() {
		if ( preg_match( '/^(?:' . wfUrlProtocols() . ')[^][<>"\\x00-\\x20\\x7F]+/', $this->m_link ) )
			return false;

		return true;
	}
	public function getLink() {
		return $this->m_link;
	}

	public function setLink( $link ) {
		$this->m_link = $link;
	}

	public function getCaption() {
		return $this->m_caption;
	}

	public function setCaption( $caption ) {
		$this->m_caption = $caption;
	}

	public function getWikiText() {
		if ( $this->isInline() ) {
			return "[[{$this->m_link}" . ( $this->m_caption ? "|{$this->m_caption}" : "" ) . "]]";
		} else {
			if ( $this->m_caption === null ) {
				return $this->m_link;
			} else {
				return "[{$this->m_link}" . ( $this->m_caption ? " {$this->m_caption}" : "" ) . "]";
			}
		}
	}

	protected function getXMLContent() {
		return "
<url><![CDATA[{$this->m_link}]]></url>
<caption><![CDATA[{$this->m_caption}]]></caption>
";
	}
}
