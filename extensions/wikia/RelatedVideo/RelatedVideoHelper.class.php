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

			global $wgTitle, $wgRequest;
			
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
		
	}
