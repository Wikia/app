<?php

class MultiLookupRowFormatter extends ContextSource {
	/** @var string $comma */
	private $comma;

	public function __construct( IContextSource $context ) {
		$this->setContext( $context );
		$this->comma = $this->msg( 'comma-separator' )->escaped();
	}

	public function formatWikiUrl( $url ) {
		return Html::element( 'a', [ 'href' => $url ], $url );
	}

	public function formatTimestamp( $timestamp ) {
		return $this->getLanguage()->timeanddate( $timestamp );
	}

	public function formatUsers( $row ) {
		$links = [];

		foreach ( $row->users as $user ) {
			$title = GlobalTitle::newFromText( "Contributions/$user", NS_SPECIAL, $row->ml_city_id );
			$links[] = Linker::linkKnown( $title, htmlspecialchars( $user ) );
		}

		return implode( $this->comma, $links );
	}
}
