<?php

	/**
	 * Helper class for Related Video
	 * Used for hooks.
	 * 
	 * @author jakub
	 */
	class RelatedVideoHelper {


		/**
		 * onAfterAdModuleExecute - replaces leader board add with 5min video add.
		 *
		 * @param $adModule obj
		 *
		 * @return boolean
		 */

		static function onAfterAdModuleExecute( &$adModule ){

			global $wgTitle;
			
			if ( $wgTitle->isSpecial( 'RelatedVideo' ) && ( $adModule->slotname == 'TOP_LEADERBOARD' ) ){
				$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
				$adModule->ad = $oTmpl->execute( "leaderboard" );
				
			}
			return true;
		}

		/**
		 * onGetRailModuleList - adds 5min rail module.
		 *
		 * @param $railModuleList array
		 *
		 * @return boolean
		 */

		static function onGetRailModuleList( &$railModuleList ){

			global $wgUser, $wgExtraNamespaces, $wgTitle, $wgContentNamespaces, $wgRelatedVideosRailPosition;

			if ( $wgUser->isAnon() ){
				$namespace = $wgTitle->getNamespace();
				$subjectNamespace = MWNamespace::getSubject($namespace);

				if (	in_array($subjectNamespace, array (NS_CATEGORY, NS_CATEGORY_TALK, NS_FORUM)) ||
					in_array($subjectNamespace, $wgContentNamespaces) ||
					array_key_exists( $subjectNamespace, $wgExtraNamespaces ) ) {

					$railModuleList[$wgRelatedVideosRailPosition] = array('RelatedVideo', 'Index', null);
				}
			}
			return true;
		}

		/**
		 * onBeforeExecuteSpotlightsIndex - replaces middle spotligh footer with 5min video.
		 *
		 * @param $spotlightsModule obj
		 *
		 * @return boolean
		 */

		static function onBeforeExecuteSpotlightsIndex( &$spotlightsModule ){

			global $wgUser, $wgTitle;

			if ( $wgUser->isAnon() || $wgTitle->isSpecial('RelatedVideo') ){
				if ( isset($spotlightsModule) && ($spotlightsModule->adslots[2] == 'SPOTLIGHT_FOOTER_3')) {
					$forceContent = false;
					$forceContent = array();
					$forceContent[2] = wfRenderModule('RelatedVideo', 'Spotlight');
					$spotlightsModule->forceContent = $forceContent;
					if ( !empty($spotlightsModule->forceContent) && is_array( $spotlightsModule->forceContent )){
						foreach($spotlightsModule->forceContent as $key => $val){
							if ( !empty( $spotlightsModule->forceContent[$key] ) ){
								unset($spotlightsModule->adslots[$key]);
							}
						}
					}
				}
			}
			return true;
		}
		
	}
