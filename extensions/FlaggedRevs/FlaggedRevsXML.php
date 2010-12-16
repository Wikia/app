<?php
/**
 * Class containing utility XML functions for a FlaggedRevs.
 * Includes functions for selectors, icons, notices, CSS, and form aspects.
 */
class FlaggedRevsXML {
	/**
	 * Get a selector of reviewable namespaces
	 * @param int $selected, namespace selected
	 * @param $all Mixed: Value of an item denoting all namespaces, or null to omit
	 * @returns string
	 */
	public static function getNamespaceMenu( $selected = null, $all = null ) {
		global $wgContLang;
		$namespaces = FlaggedRevs::getReviewNamespaces();
		$s = "<label for='namespace'>" . wfMsgHtml( 'namespace' ) . "</label>";
		if ( $selected !== '' ) {
			if ( is_null( $selected ) ) {
				# No namespace selected; let exact match work without hitting Main
				$selected = '';
			} else {
				# Let input be numeric strings without breaking the empty match.
				$selected = intval( $selected );
			}
		}
		$s .= "\n<select id='namespace' name='namespace' class='namespaceselector'>\n";
		$arr = $wgContLang->getFormattedNamespaces();
		if ( !is_null( $all ) ) {
			$arr = array( $all => wfMsg( 'namespacesall' ) ) + $arr; // should be first
		}
		foreach ( $arr as $index => $name ) {
			# Content pages only (except 'all')
			if ( $index !== $all && !in_array( $index, $namespaces ) ) {
				continue;
			}
			$name = $index !== 0 ? $name : wfMsg( 'blanknamespace' );
			if ( $index === $selected ) {
				$s .= "\t" . Xml::element( "option", array( "value" => $index,
					"selected" => "selected" ), $name ) . "\n";
			} else {
				$s .= "\t" . Xml::element( "option", array( "value" => $index ), $name ) . "\n";
			}
		}
		$s .= "</select>\n";
		return $s;
	}

	/**
	 * Get a selector of review levels
	 * @param int $selected, selected level
	 * @param string $all, all selector msg?
	 * @param int $max max level?
	 * @returns string
	 */
	public static function getLevelMenu(
		$selected = null, $all = 'revreview-filter-all', $max = 2
	) {
		$s = "<label for='wpLevel'>" . wfMsgHtml( 'revreview-levelfilter' ) . "</label>&nbsp;";
		$s .= Xml::openElement( 'select', array( 'name' => 'level', 'id' => 'wpLevel' ) );
		if ( $all !== false )
			$s .= Xml::option( wfMsg( $all ), - 1, $selected === - 1 );
		$s .= Xml::option( wfMsg( 'revreview-lev-basic' ), 0, $selected === 0 );
		if ( FlaggedRevs::qualityVersions() )
			$s .= Xml::option( wfMsg( 'revreview-lev-quality' ), 1, $selected === 1 );
		if ( $max >= 2 && FlaggedRevs::pristineVersions() )
			$s .= Xml::option( wfMsg( 'revreview-lev-pristine' ), 2, $selected === 2 );
		# Note: Pristine not tracked at sp:QualityOversight (counts as quality)
		$s .= Xml::closeElement( 'select' ) . "\n";
		return $s;
	}

	/**
	 * Get a radio options of available precendents
	 * @param int $selected, selected level
	 * @returns string
	 */
	public static function getPrecedenceMenu( $selected = null ) {
		$s = Xml::openElement( 'select',
			array( 'name' => 'precedence', 'id' => 'wpPrecedence' ) );
		$s .= Xml::option( wfMsg( 'revreview-lev-basic' ), FLAGGED_VIS_LATEST,
			$selected == FLAGGED_VIS_LATEST );
		if ( FlaggedRevs::qualityVersions() )
			$s .= Xml::option( wfMsg( 'revreview-lev-quality' ), FLAGGED_VIS_QUALITY,
				$selected == FLAGGED_VIS_QUALITY );
		if ( FlaggedRevs::pristineVersions() )
			$s .= Xml::option( wfMsg( 'revreview-lev-pristine' ), FLAGGED_VIS_PRISTINE,
				$selected == FLAGGED_VIS_PRISTINE );
		$s .= Xml::closeElement( 'select' ) . "\n";
		return $s;
	}

	/**
	 * Get a selector of "approved"/"unapproved"
	 * @param int $selected, selected level
	 * @returns string
	 */
	public static function getStatusFilterMenu( $selected = null ) {
		$s = "<label for='wpStatus'>" . wfMsgHtml( 'revreview-statusfilter' ) . "</label>&nbsp;";
		$s .= Xml::openElement( 'select', array( 'name' => 'status', 'id' => 'wpStatus' ) );
		$s .= Xml::option( wfMsg( "revreview-filter-all" ), - 1, $selected === - 1 );
		$s .= Xml::option( wfMsg( "revreview-filter-approved" ), 1, $selected === 1 );
		$s .= Xml::option( wfMsg( "revreview-filter-reapproved" ), 2, $selected === 2 );
		$s .= Xml::option( wfMsg( "revreview-filter-unapproved" ), 3, $selected === 3 );
		$s .= Xml::closeElement( 'select' ) . "\n";
		return $s;
	}

	/**
	 * Get a selector of "auto"/"manual"
	 * @param int $selected, selected level
	 * @returns string
	 */
	public static function getAutoFilterMenu( $selected = null ) {
		$s = "<label for='wpApproved'>" . wfMsgHtml( 'revreview-typefilter' ) . "</label>&nbsp;";
		$s .= Xml::openElement( 'select', array( 'name' => 'automatic', 'id' => 'wpApproved' ) );
		$s .= Xml::option( wfMsg( "revreview-filter-all" ), - 1, $selected === - 1 );
		$s .= Xml::option( wfMsg( "revreview-filter-manual" ), 0, $selected === 0 );
		$s .= Xml::option( wfMsg( "revreview-filter-auto" ), 1, $selected === 1 );
		$s .= Xml::closeElement( 'select' ) . "\n";
		return $s;
	}

	/**
	 * @param int $quality
	 * @returns string, css color for this quality
	 */
	public static function getQualityColor( $quality ) {
		if ( $quality === false )
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
	 * @returns string
	 * Generates a review box/tag
	 */
    public static function addTagRatings( $flags, $prettyBox = false, $css = '' ) {
        $tag = '';
        if ( $prettyBox ) {
        	$tag .= "<table id='mw-fr-revisionratings-box' align='center' class='$css' cellpadding='0'>";
		}
		foreach ( FlaggedRevs::getDimensions() as $quality => $x ) {
			$level = isset( $flags[$quality] ) ? $flags[$quality] : 0;
			$encValueText = wfMsgHtml( "revreview-$quality-$level" );
            $level = $flags[$quality];
            $minlevel = FlaggedRevs::getMinQL( $quality );
            if ( $level >= $minlevel ) {
                $classmarker = 2;
            } elseif ( $level > 0 ) {
                $classmarker = 1;
            } else {
                $classmarker = 0;
			}
            $levelmarker = $level * 20 + 20;
            if ( $prettyBox ) {
            	$tag .= "<tr><td class='fr-text' valign='middle'>" .
					wfMsgHtml( "revreview-$quality" ) .
					"</td><td class='fr-value$levelmarker' valign='middle'>" .
					$encValueText . "</td></tr>\n";
            } else {
				$tag .= "&nbsp;<span class='fr-marker-$levelmarker'><strong>" .
					wfMsgHtml( "revreview-$quality" ) .
					"</strong>: <span class='fr-text-value'>$encValueText&nbsp;</span>&nbsp;" .
					"</span>\n";
			}
		}
		if ( $prettyBox ) {
			$tag .= '</table>';
		}
		return $tag;
    }

	/**
	 * @param FlaggedRevision $frev, the reviewed version
	 * @param string $html, the short message HTML
	 * @param int $revsSince, revisions since review
	 * @param string $type (stable/draft/oldstable)
	 * @param bool $stable, are we referring to the stable revision?
	 * @param bool $synced, does stable=current and this is one of them?
	 * @returns string
	 * Generates a review box using a table using FlaggedRevsXML::addTagRatings()
	 */
	public static function prettyRatingBox(
		$frev, $shtml, $revsSince, $type = 'oldstable', $synced = false
	) {
		global $wgLang;
		# Get quality level
		$flags = $frev->getTags();
		$quality = FlaggedRevs::isQuality( $flags );
		$pristine = FlaggedRevs::isPristine( $flags );
		$time = $wgLang->date( $frev->getTimestamp(), true );
		# Some checks for which tag CSS to use
		if ( $pristine ) {
			$color = 'flaggedrevs-color-3';
		} elseif ( $quality ) {
			$color = 'flaggedrevs-color-2';
		} else {
			$color = 'flaggedrevs-color-1';
		}
        # Construct some tagging
		if ( $synced && ( $type == 'stable' || $type == 'draft' ) ) {
			$msg = $quality ?
				'revreview-quality-same' : 'revreview-basic-same';
			$html = wfMsgExt( $msg, array( 'parseinline' ), $frev->getRevId(), $time, $revsSince );
		} elseif ( $type == 'oldstable' ) {
			$msg = $quality ?
				'revreview-quality-old' : 'revreview-basic-old';
			$html = wfMsgExt( $msg, array( 'parseinline' ), $frev->getRevId(), $time );
		} else {
			if ( $type == 'stable' ) {
				$msg = $quality ?
					'revreview-quality' : 'revreview-basic';
			} else { // draft
				$msg = $quality ?
					'revreview-newest-quality' : 'revreview-newest-basic';
			}
			# For searching: uses messages 'revreview-quality-i', 'revreview-basic-i',
			# 'revreview-newest-quality-i', 'revreview-newest-basic-i'
			$msg .= ( $revsSince == 0 ) ? '-i' : '';
			$html = wfMsgExt( $msg, array( 'parseinline' ), $frev->getRevId(), $time, $revsSince );
		}
		# Make fancy box...
		$box = "<table style='background: none; border-spacing: 0px;'>";
		$box .= "<tr style='white-space:nowrap;'><td>$shtml</td>";
		$box .= "<td style='text-align:right;'>" . self::ratingToggle() . "</td></tr>\n";
		$box .= "<tr><td id='mw-fr-revisionratings'>$html<br />";
		# Add any rating tags as needed...
		if ( $flags && ( $type == 'stable' || $type == 'oldstable' ) ) {
			$box .= self::addTagRatings( $flags, true, $color );
		}
		$box .= "</td><td></td></tr></table>";
        return $box;
	}

	/**
	 * @returns string
	 * Generates (+/-) JS toggle HTML
	 */
	public static function ratingToggle() {
		return '<a id="mw-fr-revisiontoggle" class="flaggedrevs_toggle" style="display:none;"' .
			' onclick="FlaggedRevs.toggleRevRatings()" title="' .
			wfMsgHtml( 'revreview-toggle-title' ) . '" >' .
			wfMsgHtml( 'revreview-toggle' ) . '</a>';
	}

	/**
	 * @returns string
	 * Generates (+/-) JS toggle HTML
	 */
	public static function diffToggle() {
		return '<a id="mw-fr-difftoggle" class="flaggedrevs_toggle" style="display:none;"' .
			' onclick="FlaggedRevs.toggleDiff()" title="' .
			wfMsgHtml( 'revreview-diff-toggle-title' ) . '" >' .
			wfMsgHtml( 'revreview-diff-toggle-show' ) . '</a>';
	}

	/**
	 * @returns string
	 * Generates (+/-) JS toggle HTML
	 */
	public static function logToggle() {
		return '<a id="mw-fr-logtoggle" class="flaggedrevs_toggle" style="display:none;"' .
			' onclick="FlaggedRevs.toggleLog()" title="' .
			wfMsgHtml( 'revreview-log-toggle-show' ) . '" >' .
			wfMsgHtml( 'revreview-log-toggle-show' ) . '</a>';
	}
	
	/**
	 * @param array $flags, selected flags
	 * @param array $config, page config
	 * @param bool $disabled, form disabled
	 * @param bool $reviewed, rev already reviewed
	 * @returns string
	 * Generates a main tag inputs (checkboxes/radios/selects) for review form
	 */
	public static function ratingInputs( $flags, $config, $disabled, $reviewed ) {
		$form = '';
		# Get all available tags for this page/user
		list( $labels, $minLevels ) = self::ratingFormTags( $flags, $config );
		if ( $labels === false ) {
			$disabled = true; // a tag is unsettable
		}
		$dimensions = FlaggedRevs::getDimensions();
		$tags = array_keys( $dimensions );
		# If there are no tags, make one checkbox to approve/unapprove
		if ( FlaggedRevs::binaryFlagging() ) {
			return '';
		}
		$items = array();
		# Build rating form...
		if ( $disabled ) {
			// Display the value for each tag as text
			foreach ( $dimensions as $quality => $levels ) {
				$selected = isset( $flags[$quality] ) ? $flags[$quality] : 0;
				$items[] = "<b>" . FlaggedRevs::getTagMsg( $quality ) . ":</b> " .
					FlaggedRevs::getTagValueMsg( $quality, $selected );
			}
		} else {
			$size = count( $labels, 1 ) - count( $labels );
			foreach ( $labels as $quality => $levels ) {
				$item = '';
				$numLevels = count( $levels );
				$minLevel = $minLevels[$quality];
				# Determine the level selected by default
				if ( !empty( $flags[$quality] ) && isset( $levels[$flags[$quality]] ) ) {
					$selected = $flags[$quality]; // valid non-zero value
				} else {
					$selected = $minLevel;
				}
				# Show label as needed
				if ( !FlaggedRevs::binaryFlagging() ) {
					$item .= "<b>" . Xml::tags( 'label', array( 'for' => "wp$quality" ),
						FlaggedRevs::getTagMsg( $quality ) ) . ":</b>\n";
				}
				# If the sum of qualities of all flags is above 6, use drop down boxes.
				# 6 is an arbitrary value choosen according to screen space and usability.
				if ( $size > 6 ) {
					$attribs = array( 'name' => "wp$quality", 'id' => "wp$quality",
						'onchange' => "FlaggedRevs.updateRatingForm()" );
					$item .= Xml::openElement( 'select', $attribs );
					foreach ( $levels as $i => $name ) {
						$optionClass = array( 'class' => "fr-rating-option-$i" );
						$item .= Xml::option( FlaggedRevs::getTagMsg( $name ), $i,
							( $i == $selected ), $optionClass ) . "\n";
					}
					$item .= Xml::closeElement( 'select' ) . "\n";
				# If there are more than two levels, current user gets radio buttons
				} elseif ( $numLevels > 2 ) {
					foreach ( $levels as $i => $name ) {
						$attribs = array( 'class' => "fr-rating-option-$i",
							'onchange' => "FlaggedRevs.updateRatingForm()" );
						$item .= Xml::radioLabel( FlaggedRevs::getTagMsg( $name ), "wp$quality",
							$i,	"wp$quality" . $i, ( $i == $selected ), $attribs ) . "\n";
					}
				# Otherwise make checkboxes (two levels available for current user)
				} else if ( $numLevels == 2 ) {
					$i = $minLevel;
					$attribs = array( 'class' => "fr-rating-option-$i",
						'onchange' => "FlaggedRevs.updateRatingForm()" );
					$attribs = $attribs + array( 'value' => $i );
					$item .= Xml::checkLabel( wfMsg( 'revreview-' . $levels[$i] ),
						"wp$quality", "wp$quality", ( $selected == $i ), $attribs ) . "\n";
				}
				$items[] = $item;
			}
		}
		# Wrap visible controls in a span
		$form = Xml::openElement( 'span', array( 'class' => 'fr-rating-options' ) ) . "\n";
		$form .= implode( '&nbsp;&nbsp;&nbsp;', $items );
		$form .= Xml::closeElement( 'span' ) . "\n";
		return $form;
	}
	
	protected static function ratingFormTags( $selected, $config ) {
		$labels = array();
		$minLevels = array();
		# Build up all levels available to user
		foreach ( FlaggedRevs::getDimensions() as $tag => $levels ) {
			if ( isset( $selected[$tag] ) &&
				!RevisionReview::userCan( $tag, $selected[$tag], $config ) )
			{
				return array( false, false ); // form will have to be disabled
			}
			$labels[$tag] = array(); // applicable tag levels
			$minLevels[$tag] = false; // first non-zero level number
			foreach ( $levels as $i => $msg ) {
				# Some levels may be restricted or not applicable...
				if ( !RevisionReview::userCan( $tag, $i, $config ) ) {
					continue; // skip this level
				} else if ( $i > 0 && !$minLevels[$tag] ) {
					$minLevels[$tag] = $i; // first non-zero level number
				}
				$labels[$tag][$i] = $msg; // set label
			}
			if ( !$minLevels[$tag] ) {
				return array( false, false ); // form will have to be disabled
			}
		}
		return array( $labels, $minLevels );
	}

	/**
	 * @param FlaggedRevision $frev, the flagged revision, if any
	 * @param bool $disabled, is the form disabled?
	 * @param bool $rereview, force the review button to be usable?
	 * @returns string
	 * Generates one or two button submit for the review form
	 */
	public static function ratingSubmitButtons( $frev, $disabled, $rereview = false ) {
		$disAttrib = array( 'disabled' => 'disabled' );
		# Add the submit button
		if ( FlaggedRevs::binaryFlagging() ) {
			# We may want to re-review to change the notes ($wgFlaggedRevsComments)
			$s = Xml::submitButton( wfMsg( 'revreview-submit-review' ),
				array(
					'name'  	=> 'wpApprove',
					'id' 		=> 'mw-fr-submitreview',
					'accesskey' => wfMsg( 'revreview-ak-review' ),
					'title' 	=> wfMsg( 'revreview-tt-flag' ) . ' [' .
						wfMsg( 'revreview-ak-review' ) . ']'
				) + ( ( $disabled || ($frev && !$rereview) ) ? $disAttrib : array() )
			);
			$s .= ' ';
			$s .= Xml::submitButton( wfMsg( 'revreview-submit-unreview' ),
				array(
					'name'  => 'wpUnapprove',
					'id' 	=> 'mw-fr-submitunreview',
					'title' => wfMsg( 'revreview-tt-unflag' )
				) + ( ( $disabled || !$frev ) ? $disAttrib : array() )
			);
		} else {
			$s = Xml::submitButton( wfMsg( 'revreview-submit' ),
				array(
					'id' 		=> 'mw-fr-submitreview',
					'accesskey' => wfMsg( 'revreview-ak-review' ),
					'title' 	=> wfMsg( 'revreview-tt-review' ) . ' [' .
						wfMsg( 'revreview-ak-review' ) . ']'
				) + ( $disabled ? $disAttrib : array() )
			);
		}
		return $s;
	}

	/*
	* Creates CSS draft page icon
	* @returns string
	*/
	public static function draftStatusIcon() {
		return '<span class="fr-icon-current" title="'.
			wfMsgHtml( 'revreview-draft-title' ).'"></span>';
	}
	
	/*
	* Creates CSS stable page icon
	* @param bool $isQuality
	* @returns string
	*/
	public static function stableStatusIcon( $isQuality ) {
		$class = $isQuality
			? 'fr-icon-quality'
			: 'fr-icon-stable';
		$tooltip = $isQuality
			? 'revreview-quality-title'
			: 'revreview-basic-title';
		return '<span class="'.$class.'" title="'. wfMsgHtml( $tooltip ).'"></span>';
	}

	/*
	* Creates CSS lock icon if page is locked/unlocked
	* @param FlaggedArticle $flaggedArticle
	* @returns string
	*/
	public static function lockStatusIcon( $flaggedArticle ) {
		if ( $flaggedArticle->isPageLocked() ) {
			return "<span class='fr-icon-locked' title=\"" .
				wfMsgHtml( 'revreview-locked-title' ) . "\"></span>";
		} elseif ( $flaggedArticle->isPageUnlocked() ) {
			return "<span class='fr-icon-unlocked' title=\"" .
				wfMsgHtml( 'revreview-unlocked-title' ) . "\"></span>";
		}
	}
	
	/*
	* @param FlaggedArticle $flaggedArticle
	* @param FlaggedRevision $frev
	* @param int $revsSince
	* @returns string
	* Creates "stable rev reviewed on"/"x pending edits" message
	*/
	public static function pendingEditNotice( $flaggedArticle, $frev, $revsSince ) {
		global $wgLang;
		if( $revsSince < 1 ) {
			return ''; // only for pending edits
		}
		$flags = $frev->getTags();
		$time = $wgLang->date( $frev->getTimestamp(), true );
		# Add message text for pending edits
		$msg = FlaggedRevs::isQuality( $flags )
			? 'revreview-pending-quality'
			: 'revreview-pending-basic';
		$tag = wfMsgExt( $msg, array( 'parseinline' ), $frev->getRevId(), $time, $revsSince );
		return $tag;
	}

	/*
	* @param Article $article
	* @returns string
	* Creates a stability log excerpt
	*/
	public static function stabilityLogExcerpt( $article ) {
		$logHtml = '';
		LogEventsList::showLogExtract( $logHtml, 'stable',
			$article->getTitle()->getPrefixedText(), '', array( 'lim' => 1 ) );
		return "<div id=\"mw-fr-logexcerpt\">$logHtml</div>";
	}
}
