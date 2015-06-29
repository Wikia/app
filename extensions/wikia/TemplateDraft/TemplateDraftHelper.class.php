<?php

class TemplateDraftHelper {

	/**
	 * Checks if the Title object is a Draft subpage of a template
	 *
	 * @param Title $title
	 * @return bool
	 */
	public function isTitleDraft( Title $title ) {
		/**
		 * TODO: Improve this check (i18n)
		 */
		return $title->getNamespace() === NS_TEMPLATE
			&& $title->isSubpage()
			&& ( $title->getSubpageText() === wfMessage( 'templatedraft-subpage' )->inContentLanguage()->escaped()
				|| $title->getSubpageText() === wfMessage( 'templatedraft-subpage' )->inLanguage( 'en' )->escaped() );
	}

	/**
	 * Retrieves parent Title object from provided $title
	 *
	 * @param Title $title
	 * @return Title Parent Title
	 * @throws MWException
	 */
	public function getParentTitle( Title $title ) {
		return Title::newFromText( $title->getBaseText(), NS_TEMPLATE );
	}
}
