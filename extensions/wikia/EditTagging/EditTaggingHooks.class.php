<?php

/**
 * This class contains hook handlers used to store additional tags on edits
 */
class EditTaggingHooks {
	const API_EDIT_TAG = 'apiedit';
	const CATEGORYSELECT_EDIT_TAG = 'categoryselect';
	const GALLERY_EDIT_TAG = 'gallery';
	const ROLLBACK_TAG = 'rollback';
	const RTE_SOURCE_MODE = 'source';
	const RTE_WYSIWYG_MODE = 'wysiwyg';
	const RTE_SOURCE_MODE_TAG = 'rte-source';
	const RTE_WYSIWYG_MODE_TAG = 'rte-wysiwyg';
	const SOURCE_EDIT_TAG = 'sourceedit';

	static $tagBlacklist = [
		self::API_EDIT_TAG,
		self::CATEGORYSELECT_EDIT_TAG,
		self::GALLERY_EDIT_TAG,
		self::ROLLBACK_TAG,
		self::RTE_SOURCE_MODE_TAG,
		self::RTE_WYSIWYG_MODE_TAG,
		self::SOURCE_EDIT_TAG
	];

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
		$remainingTags = [ ];

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
	 * @return bool
	 */
	public static function onSuccessfulApiEdit( $revision_id ) {
		self::AddRevisionTag( $revision_id, self::API_EDIT_TAG );
		return true;
	}

	/**
	 * Handle tagging new revisions on Article Save Completion
	 * @return bool
	 */
	public static function onArticleSaveComplete( &$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ) {
		if ( !$revision instanceof Revision ) {
			// We are only tagging real revisions, so no tag change
			return true;
		}

		$request = RequestContext::getMain()->getRequest();
		$revision_id = $revision->getId();

		// Iterate over all handlers until out of handlers or a handler returns true
		// for this request
		$handler_iterator = self::getHandlers()->getIterator();
		while ( $handler_iterator->valid() ) {
			$result = call_user_func( $handler_iterator->current(), $revision_id, $request );
			if ( $result ) {
				break;
			} else {
				$handler_iterator->next();
			}
		}

		return true;
	}

	/**
	 * @param WikiPage $wikiPage
	 * @param User $user
	 * @param $revision
	 * @param $current
	 * @return bool
	 */
	public static function onArticleRollbackComplete( WikiPage $wikiPage, User $user, $revision, $current ) {
		if ( $revision instanceof Revision ) {
			$revision_id = $revision->getId();
			self::AddRevisionTag( $revision_id, self::ROLLBACK_TAG );
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

	/**
	 * @param $revision_id
	 * @param $request WebRequest
	 * @return bool
	 */
	private static function tagRevisionIfCategoryEdit( $revision_id, $request ) {
		$controller = $request->getVal( 'controller', null );
		$method = $request->getVal( 'method', null );
		$is_category_edit = ( $controller === 'CategorySelect' && $method === 'save' );

		if ( $is_category_edit ) {
			self::AddRevisionTag( $revision_id, self::CATEGORYSELECT_EDIT_TAG );
			return true;
		}

		return false;
	}

	/**
	 * @param $revision_id
	 * @param $request WebRequest
	 * @return bool
	 */
	private static function tagRevisionIfSourceEdit( $revision_id, $request ) {
		$is_source_mode = $request->getVal( 'isMediaWikiEditor', null );
		if ( $is_source_mode ) {
			self::AddRevisionTag( $revision_id, self::SOURCE_EDIT_TAG );
			return true;
		}

		return false;
	}

	/**
	 * @param $revision_id
	 * @param $request WebRequest
	 * @return bool
	 */
	private static function tagRevisionIfRTESourceEdit( $revision_id, $request ) {
		if ( $request->getVal( 'RTEMode', null ) == self::RTE_SOURCE_MODE ) {
			self::AddRevisionTag( $revision_id, self::RTE_SOURCE_MODE_TAG );
			return true;
		}

		return false;
	}

	/**
	 * @param $revision_id
	 * @param $request WebRequest
	 * @return bool
	 */
	private static function tagRevisionIfRTEWysiwygEdit( $revision_id, $request ) {
		if ( $request->getVal( 'RTEMode', null ) == self::RTE_WYSIWYG_MODE ) {
			self::AddRevisionTag( $revision_id, self::RTE_WYSIWYG_MODE_TAG );
			return true;
		}

		return false;
	}

	/**
	 * @param $revision_id
	 * @param $request WebRequest
	 * @return bool
	 */
	private static function tagRevisionIfGalleryEdit( $revision_id, $request ) {
		$action = $request->getVal( 'action', null );
		$handler = $request->getVal( 'rs', null );
		$method = $request->getVal( 'method', null );
		$is_post_request = $request->wasPosted();

		$is_gallery_edit = (
			$action == 'ajax'
			&& $handler == 'WikiaPhotoGalleryAjax'
			&& $method == 'saveGalleryData'
			&& $is_post_request );

		if ( $is_gallery_edit ) {
			self::AddRevisionTag( $revision_id, self::GALLERY_EDIT_TAG );
			return true;
		}

		return false;
	}

	/**
	 * Get ArrayObject containing list of handler callables
	 * to process the edit
	 * @return ArrayObject
	 */
	private static function getHandlers() {
		$handlers = new ArrayObject();
		$handlers->append( [ self, 'tagRevisionIfCategoryEdit' ] );
		$handlers->append( [ self, 'tagRevisionIfGalleryEdit' ] );
		$handlers->append( [ self, 'tagRevisionIfRTESourceEdit' ] );
		$handlers->append( [ self, 'tagRevisionIfRTEWysiwygEdit' ] );
		$handlers->append( [ self, 'tagRevisionIfSourceEdit' ] );
		return $handlers;
	}
}
