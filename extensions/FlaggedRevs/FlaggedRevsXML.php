<?php

class FlaggedRevsXML {
	/**
	 * Get a selector of reviewable namespaces
	 * @param int $selected, namespace selected
	 */
	public static function getNamespaceMenu( $selected=null ) {
		global $wgContLang, $wgFlaggedRevsNamespaces;
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
		foreach( $arr as $index => $name ) {
			# Content only
			if($index < NS_MAIN || !in_array($index, $wgFlaggedRevsNamespaces) ) {
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
	 * Get a selector of review levels
	 * @param int $selected, selected level
	 */
	public static function getLevelMenu( $selected=null ) {
		$s = Xml::openElement( 'select', array('name' => 'level') );
		$s .= Xml::option( wfMsg( "revreview-filter-level-0" ), 0, $selected===0 );
		if( FlaggedRevs::qualityVersions() )
			$s .= Xml::option( wfMsg( "revreview-filter-level-1" ), 1, $selected===1 );
		$s .= Xml::closeElement('select')."\n";
		return $s;
	}

	/**
	 * Get a selector of "approved"/"unapproved"
	 * @param int $selected, selected level
	 */
	public static function getStatusFilterMenu( $selected=null ) {
		$s  = "<label for='status'>" . wfMsgHtml('revreview-statusfilter') . "</label>&nbsp;";
		$s .= Xml::openElement( 'select', array('name' => 'status') );
		$s .= Xml::option( wfMsg( "revreview-filter-all" ), -1, $selected===-1 );
		$s .= Xml::option( wfMsg( "revreview-filter-approved" ), 1, $selected===1 );
		$s .= Xml::option( wfMsg( "revreview-filter-reapproved" ), 2, $selected===2 );
		$s .= Xml::option( wfMsg( "revreview-filter-unapproved" ), 3, $selected===3 );
		$s .= Xml::closeElement('select')."\n";
		return $s;
	}

	/**
	 * Get a selector of "auto"/"manual"
	 * @param int $selected, selected level
	 */
	public static function getAutoFilterMenu( $selected=null ) {
		$s  = "<label for='approved'>" . wfMsgHtml('revreview-typefilter') . "</label>&nbsp;";
		$s .= Xml::openElement( 'select', array('name' => 'automatic') );
		$s .= Xml::option( wfMsg( "revreview-filter-all" ), -1, $selected===-1 );
		$s .= Xml::option( wfMsg( "revreview-filter-manual" ), 0, $selected===0 );
		$s .= Xml::option( wfMsg( "revreview-filter-auto" ), 1, $selected===1 );
		$s .= Xml::closeElement('select')."\n";
		return $s;
	}

	/**
	 * Get tag dropdown select
	 * @param int $selected, selected level
	 */
	public static function getTagMenu( $selected = '' ) {
		$s  = "<label for='ratingtag'>" . wfMsgHtml('revreview-tagfilter') . "</label>&nbsp;";
		$s .= Xml::openElement( 'select', array('name' => 'ratingtag', 'id' => 'ratingtag') );
		foreach( FlaggedRevs::getFeedbackTags() as $tag => $weight ) {
			$s .= Xml::option( wfMsg( "readerfeedback-$tag" ), $tag, $selected===$tag );
		}
		# Aggregate for all tags
		$s .= Xml::option( wfMsg( "readerfeedback-overall" ), 'overall', $selected==='overall' );
		$s .= Xml::closeElement('select')."\n";
		return $s;
	}

	/**
	 * @param int $quality
	 * @return string, css color for this quality
	 */
	public static function getQualityColor( $quality ) {
		if( $quality === false )
			return 'flaggedrevs-color-0';
		switch( $quality ) {
			case 2:
				$css = 'flaggedrevs-color-3';
				break;
			case 1:
				$css = 'flaggedrevs-color-2';
				break;
			case 0:
				$css = 'flaggedrevs-color-1';
				break;
		}
		return $css;
	}

	/**
	 * @param array $flags
	 * @param bool $prettybox
	 * @param string $css, class to wrap box in
	 * @return string
	 * Generates a review box/tag
	 */
    public static function addTagRatings( $flags, $prettyBox = false, $css='' ) {
        global $wgFlaggedRevTags;

        $tag = '';
        if( $prettyBox ) {
        	$tag .= "<table id='mw-revisionratings-box' align='center' class='$css' cellpadding='0'>";
		}
		foreach( FlaggedRevs::getDimensions() as $quality => $value ) {
			$level = isset( $flags[$quality] ) ? $flags[$quality] : 0;
			$encValueText = wfMsgHtml("revreview-$quality-$level");
            $level = $flags[$quality];
            $minlevel = $wgFlaggedRevTags[$quality];
            if( $level >= $minlevel )
                $classmarker = 2;
            elseif( $level > 0 )
                $classmarker = 1;
            else
                $classmarker = 0;

            $levelmarker = $level * 20 + 20;
            if( $prettyBox ) {
            	$tag .= "<tr><td class='fr-text' valign='middle'>" . wfMsgHtml("revreview-$quality") .
					"</td><td class='fr-value$levelmarker' valign='middle'>" .
					$encValueText . "</td></tr>\n";
            } else {
				$tag .= "&nbsp;<span class='fr-marker-$levelmarker'><strong>" .
					wfMsgHtml("revreview-$quality") .
					"</strong>: <span class='fr-text-value'>$encValueText&nbsp;</span>&nbsp;" .
					"</span>\n";
			}
		}
		if( $prettyBox ) {
			$tag .= '</table>';
		}
		return $tag;
    }

	/**
	 * @param Row $trev, flagged revision row
	 * @param string $html, the short message HTML
	 * @param int $revsSince, revisions since review
	 * @param bool $stable, are we referring to the stable revision?
	 * @param bool $synced, does stable=current and this is one of them?
	 * @param bool $old, is this an old stable version?
	 * @return string
	 * Generates a review box using a table using FlaggedRevsXML::addTagRatings()
	 */
	public static function prettyRatingBox( $frev, $shtml, $revsSince, $stable=true, $synced=false, $old=false ) {
		global $wgLang;
		# Get quality level
		$flags = $frev->getTags();
		$quality = FlaggedRevs::isQuality( $flags );
		$pristine = FlaggedRevs::isPristine( $flags );
		$time = $wgLang->date( $frev->getTimestamp(), true );
		# Some checks for which tag CSS to use
		if( $pristine ) {
			$tagClass = 'flaggedrevs-box3';
			$color = 'flaggedrevs-color-3';
		} else if( $quality ) {
			$tagClass = 'flaggedrevs-box2';
			$color = 'flaggedrevs-color-2';
		} else {
			$tagClass = 'flaggedrevs-box1';
			$color = 'flaggedrevs-color-1';
		}
        # Construct some tagging
		if( $synced ) {
			$msg = $quality ? 'revreview-quality-same' : 'revreview-basic-same';
			$html = wfMsgExt($msg, array('parseinline'), $frev->getRevId(), $time, $revsSince );
		} else if( $old ) {
			$msg = $quality ? 'revreview-quality-old' : 'revreview-basic-old';
			$html = wfMsgExt($msg, array('parseinline'), $frev->getRevId(), $time );
		} else {
			if( $stable ) {
				$msg = $quality ? 'revreview-quality' : 'revreview-basic';
			} else {
				$msg = $quality ? 'revreview-newest-quality' : 'revreview-newest-basic';
			}
			# uses messages 'revreview-quality-i', 'revreview-basic-i', 'revreview-newest-quality-i', 'revreview-newest-basic-i'
			$msg .= ($revsSince == 0) ? '-i' : '';
			$html = wfMsgExt($msg, array('parseinline'), $frev->getRevId(), $time, $revsSince );
		}
		# Make fancy box...
		$box = "<table border='0' cellspacing='0' style='background: none;'>";
		$box .= "<tr style='white-space:nowrap;'><td>$shtml&nbsp;&nbsp;</td>";
		$box .= "<td align='right'>" . self::ratingToggle() . "</td></tr>\n";
		$box .= "<tr><td id='mw-revisionratings'>$html<br/>";
		# Add ratings if there are any...
		if( $stable && !empty($flags) ) {
			$box .= self::addTagRatings( $flags, true, $color );
		}
		$box .= "</td><td></td></tr></table>";

        return $box;
	}

	public static function ratingToggle() {
		return "<a id='mw-revisiontoggle' class='flaggedrevs_toggle' style='display:none;'" .
			" onclick='toggleRevRatings()' title='" . wfMsgHtml('revreview-toggle-title') . "' >" .
			wfMsg( 'revreview-toggle' ) . "</a>";
	}

	/**
	 * Add user preference to form HTML
	 */
	public static function stabilityPreferences( $form ) {
		global $wgUser;

		$html = Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', null, wfMsgHtml('flaggedrevs-prefs') ) .
			Xml::openElement( 'table' ) .
			Xml::openElement( 'tr' ) .
				'<td>' . wfCheck( 'wpFlaggedRevsStable', $form->mFlaggedRevsStable,
					array('id' => 'wpFlaggedRevsStable') ) . '</td><td> ' .
					wfLabel( wfMsg( 'flaggedrevs-prefs-stable' ), 'wpFlaggedRevsStable' ) . '</td>' .
			Xml::closeElement( 'tr' ) .
			Xml::openElement( 'tr' ) .
				'<td>' .
					Xml::radio( 'wpFlaggedRevsSUI', 0, $form->mFlaggedRevsSUI==0, array('id' => 'standardUI') ) .
				'</td><td> ' .
					Xml::label( wfMsgHtml('flaggedrevs-pref-UI-0'), 'standardUI' ) .
				'</td>' .
			Xml::closeElement( 'tr' ) .
			Xml::openElement( 'tr' ) .
				'<td>' .
					Xml::radio( 'wpFlaggedRevsSUI', 1, $form->mFlaggedRevsSUI==1, array('id' => 'simpleUI') ) .
				'</td><td> ' .
					Xml::label( wfMsgHtml('flaggedrevs-pref-UI-1'), 'simpleUI' ) .
				'</td>';
		if( $wgUser->isAllowed( 'review' ) ) {
			$html .= Xml::closeElement( 'tr' ) .
				Xml::openElement( 'tr' ) . '<td><br/></td>' . Xml::closeElement( 'tr' ) .
				Xml::openElement( 'tr' ) .
					'<td>' . wfCheck( 'wpFlaggedRevsWatch', $form->mFlaggedRevsWatch, array('id' => 'wpFlaggedRevsWatch') ) .
					'</td><td> ' . wfLabel( wfMsg( 'flaggedrevs-prefs-watch' ), 'wpFlaggedRevsWatch' ) . '</td>';
		}
		$html .= Xml::closeElement( 'tr' ) .
			Xml::closeElement( 'table' ) .
			Xml::closeElement( 'fieldset' );

		return $html;
	}
}
