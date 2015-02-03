<?php

/**
 * This class contains hook handlers used to store additional tags on edits
 */
class EditTaggingHooks {
	const RTE_SOURCE_MODE = 'source';
	const RTE_WYSIWYG_MODE = 'wysiwyg';
	const RTE_SOURCE_MODE_TAG = 'rte-source';
	const RTE_WYSIWYG_MODE_TAG = 'rte-wysiwyg';
	const API_EDIT_TAG = 'apiedit';

	static $tagBlacklist = [ self::RTE_SOURCE_MODE_TAG, self::RTE_WYSIWYG_MODE_TAG, self::API_EDIT_TAG ];

	/**
	 * Removes tags from listings
	 */
	public static function onFormatSummaryRow( &$tags ) {
		$tags = array_diff( $tags, self::$tagBlacklist );

		return true;
	}

	/**
	 * Removes tags from Listings like Special:Tags
	 * each tag is an array structured:
	 * [ 'ct_tag' => TAG_NAME, 'hitcount' => TAG_USAGES ]
	 */
	public static function onUsedTags( &$tags ) {
		$remainingTags = [];

		foreach ( $tags as $tag ) {
			if ( !in_array( $tag['ct_tag'], self::$tagBlacklist ) ) {
				$remainingTags [] = $tag;
			}
		}

		$tags = $remainingTags;

		return true;
	}

    /**
     * Handle tagging new revisions made from API
     */
    public static function onSuccessfulApiEdit( $revision_id ) {
        self::AddRevisionTag( $revision_id, self::API_EDIT_TAG );
        return true;
    }


	/**
	 * Handle tagging new revisions made from RTE
	 */
	public static function onArticleSaveComplete( &$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ) {
		if ( !$revision instanceof Revision ) {
			// We are only tagging real revisions, so no tag change
			return true;
		}

		$request = RequestContext::getMain()->getRequest();
		$rte_mode = $request->getVal( 'RTEMode', null );
		$revision_id = $revision->getId();

		switch ( $rte_mode ) {
			case self::RTE_SOURCE_MODE:
				self::AddRevisionTag( $revision_id, self::RTE_SOURCE_MODE_TAG );
				break;
			case self::RTE_WYSIWYG_MODE:
				self::AddRevisionTag( $revision_id, self::RTE_WYSIWYG_MODE_TAG );
				break;
			default:
				break;
		}

		return true;
	}

	/**
	 * Adds tag to specified revision ID
	 *
	 * @param $revision_id integer
	 * @param $tag string
	 */
	protected static function AddRevisionTag( $revision_id, $tag ) {
		if ( !ChangeTags::addTags( $tag, null, $revision_id ) ) {
			\Wikia\Logger\WikiaLogger::instance()->error( 'Failed to add tag to revision', [ 'revision_id' => $revision_id, 'tag' => $tag ] );
		}
	}
}
