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

		static protected function checkEnabled() {
			// Enable in Oasis
			if (get_class(RequestContext::getMain()->getSkin()) == 'SkinOasis') {
				return true;
			}

			return false;
		}

		/**
		 * Send CSS and JS to the browser if have not been sent yet
		 */
		static public function setupScripts() {
			if (!self::$initialized) {
				global $wgOut;
				$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/CategoryGalleries/css/CategoryGalleries.scss'));
				$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/CategoryGalleries/css/CategoryGalleries.IE.scss'),
					'', /*condition*/ 'lte IE 8' );
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
			if (self::checkEnabled()) {
				self::$categoryPage = $categoryPage;
				self::$categoryProcessed = false;
			} else {
				self::$categoryPage = null;
				self::$categoryProcessed = false;
			}
			return true;
		}

		/**
		 * Hook entry for Category viewer in getCategoryTop() method
		 * Builds and sends the gallery to the browser
		 */
		static public function onCategoryPageGetCategoryTop( $viewer, &$content ) {
			wfProfileIn(__METHOD__.'::outer');
			if (self::$categoryPage && !self::$categoryProcessed) {
				self::$categoryProcessed = true;

				wfProfileIn(__METHOD__);

				// Nice trick to check if the current page is first page
				//   definition of this array is copied from CategoryViewer::__construct
				$nullArray = array('page' => null, 'subcat' => null, 'file' => null);
				if ($nullArray === $viewer->from && $nullArray === $viewer->until) {
					$gallery = new CategoryGallery(self::$categoryPage);
					$output = $gallery->render();

					if (!empty($output)) {
						global $wgOut;
						self::setupScripts();
						$wgOut->addHTML($output);
					}
				}

				wfProfileOut(__METHOD__);
			}

			wfProfileOut(__METHOD__.'::outer');
			return true;
		}

		/**
		 * Hook entry for Category Service to invalidate the cache
		 * Removes entries from memcached
		 */
		static public function onCategoryServiceInvalidateTopArticles( $title, $ns ) {
			if ($ns == NS_MAIN) {
				$categoryPage = Article::newFromTitle( $title, RequestContext::getMain() );
				$gallery = new CategoryGallery($categoryPage);
				$gallery->invalidate();
			}

			return true;
		}

		/**
		 * Hook entry when article is purged (purge the gallery cache if purging the category page
		 */
		static public function onArticlePurge( WikiPage $page ) {
			$title = $page->getTitle();
			$ns = $title->getNamespace();

			if ($ns == NS_CATEGORY) {
				// Invalidate category service and (by hooks) category gallery cache
				CategoryService::invalidateTopArticles($title, NS_MAIN);
			}

			return true;
		}

	}
