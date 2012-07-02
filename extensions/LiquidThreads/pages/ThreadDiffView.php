<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class ThreadDiffView extends LqtView {
	function customizeTabs( $skintemplate, &$content_actions ) {
		unset( $content_actions['edit'] );
		unset( $content_actions['viewsource'] );
		unset( $content_actions['talk'] );

		$content_actions['history']['class'] = 'selected';
	}

	function customizeNavigation( $skin, &$links ) {
		$remove = array( 'views/edit', 'views/viewsource' );

		foreach ( $remove as $rem ) {
			list( $section, $item ) = explode( '/', $rem, 2 );
			unset( $links[$section][$item] );
		}

		$links['views']['history']['class'] = 'selected';
	}
}
