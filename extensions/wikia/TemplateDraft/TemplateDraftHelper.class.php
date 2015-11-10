<?php

class TemplateDraftHelper {

	/**
	 * Checks if a Title is a new one and if it fits /Draft criteria.
	 *
	 * @param Title $title
	 * @return bool
	 */
	public static function isTitleNewDraft( Title $title ) {
		return !$title->exists()
			&& self::isTitleDraft( $title );
	}

	/**
	 * Checks if the Title object is a Draft subpage of a template
	 *
	 * @param Title $title
	 * @return bool
	 */
	public static function isTitleDraft( Title $title ) {
		return $title->getNamespace() === NS_TEMPLATE
			&& $title->isSubpage()
			&& ( $title->getSubpageText() === wfMessage( 'templatedraft-subpage' )->inContentLanguage()->escaped()
				|| $title->getSubpageText() === wfMessage( 'templatedraft-subpage' )->inLanguage( 'en' )->escaped() );
	}

	/**
	 * Determines whether a title is a draft in infobox conversion mode
	 * @param Title $title
	 * @return bool
	 */
	public static function isInfoboxDraftConversion( Title $title ) {
		return self::isTitleDraft( $title ) && \TemplateConverter::isConversion();
	}

	/**
	 * Check if the basic conditions for displaying a right rail module are met by the given Title.
	 * @param Title $title
	 * @return bool
	 */
	public static function allowedForTitle( Title $title ) {
		return $title->exists()
			&& $title->getNamespace() === NS_TEMPLATE;
	}

	/**
	 * Retrieves parent Title object from provided $title
	 * If $title is already a top parent page it returns the same title.
	 * @param Title $title
	 * @return Title Parent Title
	 * @throws MWException
	 */
	public static function getParentTitle( Title $title ) {
		return Title::newFromText( $title->getBaseText(), NS_TEMPLATE );
	}

	/**
	 * Checks conditions that a Title object has to meet to have a right rail module displayed.
	 * @param Title $title
	 * @return bool
	 */
	public function isRailModuleAllowed( Title $title ) {
		return self::allowedForTitle( $title )
			&& $title->userCan( 'templatedraft' );
	}

	/**
	 * Attaches a new module to right rail which is an entry point to convert a given template
	 * or to approve a draft. Decides if a module should be added and what kind of it is required.
	 * @param array $railModuleList
	 */
	public function addRailModule( Title $title, Array &$railModuleList ) {
		if ( self::isTitleDraft( $title ) ) {
			/**
			 * $title is a draft page.
			 * Add rail module for draft approval
			 */
			$railModuleList[1502] = [ 'TemplateDraftModule', 'Approve', null ];
		} elseif ( $this->shouldDisplayCreateModule( $title ) ) {
			/**
			 * $title is a parent page
			 * Check if the template has not been classified before
			 */
			$railModuleList[1502] = [ 'TemplateDraftModule', 'Create', null ];
		}
	}

	/**
	 * Checks if the template has already been classified.
	 * We display the create module only if the type is empty (nobody classified it yet)
	 * or is classified as an infobox one.
	 * @param Title $title
	 * @return bool
	 */
	public function shouldDisplayCreateModule( Title $title ) {
		global $wgCityId;
		$tc = new TemplateClassificationService();

		try {
			$type = $tc->getType( $wgCityId, $title->getArticleID() );
			return empty( $type )
				|| $type === TemplateClassificationService::TEMPLATE_CUSTOM_INFOBOX
				|| ( $type === TemplateClassificationService::TEMPLATE_INFOBOX
					&& !self::titleHasPortableInfobox( $title ) );
		} catch ( Swagger\Client\ApiException $e ) {
			// If we cannot reach the service assume false to avoid overwriting data
			return false;
		}
	}

	public static function titleHasPortableInfobox( Title $title ) {
		$portableData = PortableInfoboxDataService::newFromTitle( $title )->getData();
		return !empty( $portableData );
	}
}
