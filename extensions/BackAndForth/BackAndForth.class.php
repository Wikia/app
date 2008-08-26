<?php

/**
 * Class file for the BackAndForth extension
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */
class BackAndForth {

	/**
	 * Article::view() hook
	 *
	 * @param Article $article
	 * @return bool
	 */
	public static function viewHook( $article ) {
		global $wgOut, $wgUser;
		$title = $article->getTitle();
		if( Namespace::isContent( $title->getNamespace() ) ) {
			$wgOut->addHtml( self::buildLinks( $title ) );
			$wgOut->addHeadItem( 'backandforth', self::buildHeadItem() );
		}
		return true;
	}

	/**
	 * Build a set of next/previous links for a given title
	 *
	 * @param Title $title
	 * @return string
	 */
	private static function buildLinks( $title ) {
		$links = '';
		foreach( array( 'prev' => '<', 'next' => '>' ) as $kind => $op ) {
			if( ( $link = self::buildLink( $title, $op, $kind ) ) !== false )
				$links .= "<div class=\"mw-backforth-{$kind}\">{$link}</div>";
		}
		return "{$links}<div style=\"clear: both;\"></div>";
	}
	
	/**
	 * Build a single link for a given title
	 *
	 * @param Title $title
	 * @param string $op
	 * @param string $label
	 * @return mixed
	 */
	private static function buildLink( $title, $op, $label ) {
		wfProfileIn( __METHOD__ );
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'page',
			array( 'page_namespace', 'page_title' ),
			array(
				'page_is_redirect' => 0,
				'page_namespace' => $title->getNamespace(),
				"page_title {$op} " . $dbr->addQuotes( $title->getDBkey() ),
			),
			__METHOD__,
			array(
				'ORDER BY' => 'page_title' . ( $op == '<' ? ' DESC' : '' ),
				'LIMIT' => 1,
			)
		);
		if( $dbr->numRows( $res ) > 0 ) {
			$row = $dbr->fetchObject( $res );
			$dbr->freeResult( $res );
			$target = Title::makeTitleSafe( $row->page_namespace, $row->page_title );
			if( $target instanceof Title ) {
				$label = htmlspecialchars( wfMsg( "backforth-{$label}", $target->getPrefixedText() ) );
				wfProfileOut( __METHOD__ );
				return $GLOBALS['wgUser']->getSkin()->makeKnownLinkObj( $target, $label );
			}
		}
		wfProfileOut( __METHOD__ );
		return false;
	}
	
	/**
	 * Generate a CSS fragment for inclusion on the page
	 *
	 * @return string
	 */
	private static function buildHeadItem() {
		$css = file_get_contents( dirname( __FILE__ ) . '/BackAndForth.css' );
		return <<<EOT
<style type="text/css">
/*<![CDATA[*/
{$css}
/*]]>*/
</style>
EOT
		;
	}

}