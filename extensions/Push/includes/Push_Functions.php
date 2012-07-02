<?php

/**
 * Statis class with utility methods for the Push extension.
 *
 * @since 0.2
 *
 * @file Push_Functions.php
 * @ingroup Push
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class PushFunctions {
	
	/**
	 * Adds the needed JS messages to the page output.
	 * This is for backward compatibility with pre-RL MediaWiki.
	 * 
	 * @since 0.2
	 */
	public static function addJSLocalisation() {
		global $egPushJSMessages, $wgOut;
		
		$data = array();
	
		foreach ( $egPushJSMessages as $msg ) {
			$data[$msg] = wfMsgNoTrans( $msg );
		}
	
		$wgOut->addInlineScript( 'var wgPushMessages = ' . FormatJson::encode( $data ) . ';' );		
	}
	
	/**
	 * Returns the latest revision.
	 * Has support for the Approvedrevs extension, and will 
	 * return the latest approved revision where appropriate.
	 * 
	 * @since 0.2
	 * 
	 * @param Title $title
	 * 
	 * @return integer
	 */
	public static function getRevisionToPush( Title $title ) {
		if ( defined( 'APPROVED_REVS_VERSION' ) ) {
			$revId = ApprovedRevs::getApprovedRevID( $title );
			return $revId ? $revId : $title->getLatestRevID();
		}
		else {
			return $title->getLatestRevID();
		}
	}

	/**
	 * Expand a list of pages to include templates used in those pages.
	 * 
	 * @since 0.4
	 * 
	 * @param $inputPages array list of titles to look up
	 * @param $pageSet array associative array indexed by titles for output
	 * 
	 * @return array associative array index by titles
	 */
	public static function getTemplates( $inputPages, $pageSet ) {
		return self::getLinks( $inputPages, $pageSet,
			'templatelinks',
			array( 'tl_namespace AS namespace', 'tl_title AS title' ),
			array( 'page_id=tl_from' )
		);
	}
	
	/**
	 * Expand a list of pages to include items used in those pages.
	 * 
	 * @since 0.4
	 */
	protected static function getLinks( $inputPages, $pageSet, $table, $fields, $join ) {
		$dbr = wfGetDB( DB_SLAVE );
		
		foreach( $inputPages as $page ) {
			$title = Title::newFromText( $page );
			
			if( $title ) {
				$pageSet[$title->getPrefixedText()] = true;
				/// @todo Fixme: May or may not be more efficient to batch these
				///        by namespace when given multiple input pages.
				$result = $dbr->select(
					array( 'page', $table ),
					$fields,
					array_merge(
						$join,
						array(
							'page_namespace' => $title->getNamespace(),
							'page_title' => $title->getDBkey()
						)
					),
					__METHOD__
				);
				
				foreach( $result as $row ) {
					$template = Title::makeTitle( $row->namespace, $row->title );
					$pageSet[$template->getPrefixedText()] = true;
				}
			}
		}
		
		return $pageSet;
	}
	
	/**
	 * Function to change the keys of $egPushLoginUsers and $egPushLoginPasswords
	 * from target url to target name using the $egPushTargets array.
	 * 
	 * @since 0.5
	 * 
	 * @param array $arr
	 * @param string $id Some string to identify the array and keep track of it having been flipped.
	 */
	public static function flipKeys( array &$arr, $id ) {
		static $handledArrays = array();
		
		if ( !in_array( $id, $handledArrays ) ) {
			$handledArrays[] = $id;
			
			global $egPushTargets;
			
			$flipped = array();
			
			foreach ( $arr as $key => $value ) {
				if ( array_key_exists( $key, $egPushTargets ) ) {
					$flipped[$egPushTargets[$key]] = $value;
				}
			}

			$arr = $flipped;			
		}
	}
	
	/**
	 * Returns a new instance of the (MW)HttpRequest class.
	 * This is needed to take care of the rename that happened in MediaWiki 1.17.
	 * 
	 * @since 0.5
	 * 
	 * @param string $target
	 * @param array $args
	 * 
	 * @return (MW)HttpRequest
	 */
	public static function getHttpRequest( $target, $args ) {
		return call_user_func_array(
			array( ( class_exists( 'MWHttpRequest' ) ? 'MWHttpRequest' : 'HttpRequest' ), 'factory' ),
			array( $target, $args )
		);
	}
	
}