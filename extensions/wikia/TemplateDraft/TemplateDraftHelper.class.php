<?php

class TemplateDraftHelper {

	/**
	 * Checks if a Title is a new one and if it fits /Draft criteria.
	 *
	 * @param Title $title
	 * @return bool
	 */
	public function isTitleNewDraft( Title $title ) {
		return !$title->exists()
			&& $this->isTitleDraft( $title );
	}

	/**
	 * Checks if the Title object is a Draft subpage of a template
	 *
	 * @param Title $title
	 * @return bool
	 */
	public function isTitleDraft( Title $title ) {
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
