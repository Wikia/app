<?php

	/**
	 * Helper class for Category Galleries
	 *
	 * @author wladek
	 */
	class CategoryGalleriesHelper {

		/**
		 * Has been CSS and JS sent to the browser?
		 *
		 * @var bool
		 */
		static private $initialized = false;

		/**
		 * Last istantiated CategoryPage object
		 *
		 * @var CategoryPage
		 */
		static private $categoryPage = null;

		/**
		 * Has been the gallery already injected into output? (HTML out?)
		 *
		 * @var bool
		 */
		static private $categoryProcessed = false;

		/**
		 * Send CSS and JS to the browser if have not been sent yet
		 */
		static public function setupScripts() {
			if (!self::$initialized) {
				global $wgOut, $wgExtensionsPath, $wgScriptPath;
				$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/CategoryGalleries/css/CategoryGalleries.scss' ) /*. "?cb=".(int)time()*/ );
				$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/CategoryGalleries/css/CategoryGalleries.IE.scss' ) /*. "?cb=".(int)time()*/,
					'', /*condition*/ 'lte IE 8' );
				$wgOut->addScriptFile("$wgScriptPath/extensions/wikia/CategoryGalleries/js/CategoryGalleries.js");
				self::$initialized = true;
			}
		}

		/**
		 * Hook entry for adding parser magic words
		 */
		static public function onLanguageGetMagic(&$magicWords, $langCode){
			$magicWords[CATGALLERY_ENABLED] = array( 0, '__FORCECATEGORYGALLERY__' );
			$magicWords[CATGALLERY_DISABLED] = array( 0, '__NOCATEGORYGALLERY__' );
			return true;
		}

		/**
		 * Hook entry for removing the magic words from displayed text
		 */
		static public function onInternalParseBeforeLinks(&$parser, &$text, &$strip_state) {
			global $wgRTEParserEnabled;
			if (empty($wgRTEParserEnabled)) {
				MagicWord::get('CATGALLERY_ENABLED')->matchAndRemove($text);
				MagicWord::get('CATGALLERY_DISABLED')->matchAndRemove($text);
			}
			return true;
		}

		/**
		 * Hook entry for catching the actual category page beeing shown
		 */
		static public function onCategoryPageView( $categoryPage ) {
			self::$categoryPage = $categoryPage;
			self::$categoryProcessed = false;
			return true;
		}

		/**
		 * Hook entry for old method of injecting HTML output
		 * @deprecated
		 */
		static public function onCategoryViewerAddPage( $viewer, $title, $row ) {
			/*
			if (self::$categoryPage && !self::$categoryProcessed) {
				self::$categoryProcessed = true;

				$gallery = new CategoryGallery(self::$categoryPage);
				$output = $gallery->render();

				if (!empty($output)) {
					global $wgOut;
					self::setupScripts();
					$wgOut->addHTML($output);
				}
			}
			*/
			return true;
		}

		/**
		 * Hook entry for Category viewer in getCategoryTop() method
		 * Builds and sends the gallery to the browser
		 */
		static public function onCategoryPageGetCategoryTop( $viewer, &$content ) {
			if (self::$categoryPage && !self::$categoryProcessed) {
				self::$categoryProcessed = true;

				// Nice trick to check if the current page is first page
				if (is_null($viewer->from) && (is_null($viewer->until) || is_null($viewer->nextPage))) {
					$gallery = new CategoryGallery(self::$categoryPage);
					$output = $gallery->render();

					if (!empty($output)) {
						global $wgOut;
						self::setupScripts();
						$wgOut->addHTML($output);
					}
				}
			}
			return true;
		}

		/**
		 * Hook entry for Category Service to invalidate the cache
		 * Removes entries from memcached
		 */
		static public function onCategoryServiceInvalidateTopArticles( $title, $ns ) {
			if ($ns == NS_MAIN) {
				$categoryPage = MediaWiki::articleFromTitle($title);
				$gallery = new CategoryGallery($categoryPage);
				$gallery->invalidate();
			}

			return true;
		}

		/**
		 * Hook entry when article is purged (purge the gallery cache if purging the category page
		 */
		static public function onArticlePurge( Article $article ) {
			$title = $article->getTitle();
			$ns = $title->getNamespace();

			if ($ns == NS_CATEGORY) {
				// Invalidate category service and (by hooks) category gallery cache
				CategoryService::invalidateTopArticles($title, NS_MAIN);
			}

			return true;
		}

	}
