<?php

class ReaderFeedbackXML {
	/**
	 * Get a selector of rateable namespaces
	 * @param int $selected, namespace selected
	 * @param $all Mixed: Value of an item denoting all namespaces, or null to omit
	 * @returns string
	 */
	public static function getNamespaceMenu( $selected=null, $all=null ) {
		global $wgContLang, $wgFeedbackNamespaces;
		$s = "<label for='namespace'>" . wfMsgHtml('namespace') . "</label>";
		if( $selected !== '' ) {
			if( is_null( $selected ) ) {
				# No namespace selected; let exact match work without hitting Main
				$selected = '';
			} else {
				# Let input be numeric strings without breaking the empty match.
				$selected = intval($selected);
			}
		}
		$s .= "\n<select id='namespace' name='namespace' class='namespaceselector'>\n";
		$arr = $wgContLang->getFormattedNamespaces();
		if( !is_null($all) ) {
			$arr = array( $all => wfMsg( 'namespacesall' ) ) + $arr; // should be first
		}
		foreach( $arr as $index => $name ) {
			# Content pages only (except 'all')
			if( $index !== $all && !in_array($index, $wgFeedbackNamespaces) ) {
				continue;
			}
			$name = $index !== 0 ? $name : wfMsg('blanknamespace');
			if( $index === $selected ) {
				$s .= "\t" . Xml::element("option", array("value" => $index, "selected" => "selected"), $name) . "\n";
			} else {
				$s .= "\t" . Xml::element("option", array("value" => $index), $name) . "\n";
			}
		}
		$s .= "</select>\n";
		return $s;
	}
	/**
	 * Get tag dropdown select
	 * @param int $selected, selected level
	 * @returns string
	 */
	public static function getTagMenu( $selected = '' ) {
		wfLoadExtensionMessages( 'ReaderFeedback' );
		$s  = "<label for='wpRatingTag'>" . wfMsgHtml('readerfeedback-tagfilter') . "</label>&nbsp;";
		$s .= Xml::openElement( 'select', array('name' => 'ratingtag', 'id' => 'wpRatingTag') );
		foreach( ReaderFeedback::getFeedbackTags() as $tag => $weight ) {
			$s .= Xml::option( wfMsg( "readerfeedback-$tag" ), $tag, $selected===$tag );
		}
		$s .= Xml::closeElement('select')."\n";
		return $s;
	}

	/**
	 * Get rating tier dropdown select
	 * @param int $selected, selected tier
	 * @returns string
	 */	
	 public static function getRatingTierMenu( $selected = '' ) {
		wfLoadExtensionMessages( 'ReaderFeedback' );
		$s  = "<label for='wpRatingTier'>" . wfMsgHtml('readerfeedback-tierfilter') . "</label>&nbsp;";
		$s .= Xml::openElement( 'select', array('name' => 'ratingtier', 'id' => 'wpRatingTier') );
		$s .= Xml::option( wfMsg( "readerfeedback-tier-high" ), 3, $selected===3);
		$s .= Xml::option( wfMsg( "readerfeedback-tier-medium" ), 2, $selected===2 );
		$s .= Xml::option( wfMsg( "readerfeedback-tier-poor" ), 1, $selected===1 );
		$s .= Xml::closeElement('select')."\n";
		return $s;
	}
}
