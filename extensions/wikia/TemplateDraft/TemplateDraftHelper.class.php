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
			&& $title->getSubpageText() === 'Draft';
	}

	/**
	 * Retrieves an ID of a parent Title object
	 *
	 * @param Title $title
	 * @return Int
	 * @throws MWException
	 */
	public function getParentTitleId( Title $title ) {
		$prefix = MWNamespace::getCanonicalName( NS_TEMPLATE );
		$baseText = $title->getBaseText();
		$prefixedText = "{$prefix}:{$baseText}";
		return Title::newFromText( $prefixedText, NS_TEMPLATE )->getArticleID();
	}
}
