<?php

class UpdateSpecialPagesScheduler {

	private static function isAllowed( User $user ) : bool {
		return $user->isAllowed( 'schedule-update-special-pages' );
	}

	/**
	 * @param SpecialStatistics $page
	 * @param string $text
	 */
	static public function onCustomSpecialStatistics( SpecialStatistics $page, string &$text ) {
		$context = $page->getContext();

		if ( !self::isAllowed( $context->getUser() )) {
			return;
		}

		$tpl = new EasyTemplate(__DIR__ . '/templates');

		$tpl->set( 'title', $context->getTitle() );
		$tpl->set( 'editToken', $context->getUser()->getEditToken() );

		$text .= $tpl->render('scheduler');
	}
}
