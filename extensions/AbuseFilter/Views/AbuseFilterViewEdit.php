<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

class AbuseFilterViewEdit extends AbuseFilterView {
	function __construct( $page, $params ) {
		parent::__construct( $page, $params );
		$this->mFilter = $page->mFilter;
		$this->mHistoryID = $page->mHistoryID;
	}

	function show() {
		$user = $this->getUser();
		$out = $this->getOutput();
		$request = $this->getRequest();

		$filter = $this->mFilter;
		$history_id = $this->mHistoryID;

		if ( $filter == 'new' && !$user->isAllowed( 'abusefilter-modify' ) ) {
			$out->addWikiMsg( 'abusefilter-edit-notallowed' );
			return;
		}

		$editToken = $request->getVal( 'wpEditToken' );
		$didEdit = $this->canEdit()
			&& $user->matchEditToken( $editToken, array( 'abusefilter', $filter ) );

		if ( $didEdit ) {
			// Check syntax
			$syntaxerr = AbuseFilter::checkSyntax( $request->getVal( 'wpFilterRules' ) );
			if ( $syntaxerr !== true ) {
				$out->addHTML(
					$this->buildFilterEditor(
						wfMsgExt(
							'abusefilter-edit-badsyntax',
							array( 'parse' ),
							array( $syntaxerr[0] )
						),
						$filter, $history_id
					)
				);
				return;
			}

			$dbw = wfGetDB( DB_MASTER );

			list( $newRow, $actions ) = $this->loadRequest( $filter );

			$differences = AbuseFilter::compareVersions(
				array( $newRow, $actions ),
				array( $newRow->mOriginalRow, $newRow->mOriginalActions )
			);

			$origActions = $newRow->mOriginalActions;
			unset( $newRow->mOriginalRow );
			unset( $newRow->mOriginalActions );

			// Check for non-changes
			if ( !count( $differences ) ) {
				$out->redirect( $this->getTitle()->getLocalURL() );
				return;
			}

			// Check for restricted actions
			global $wgAbuseFilterRestrictedActions;
			$allActions = array_keys( array_merge(
						array_filter( $actions ),
						array_filter( $origActions )
					) );

			if (
				count( array_intersect(
						$wgAbuseFilterRestrictedActions,
						$allActions
				) )
				&& !$user->isAllowed( 'abusefilter-modify-restricted' )
			) {
				$out->addHTML(
					$this->buildFilterEditor(
						wfMsgExt( 'abusefilter-edit-restricted', 'parse' ),
						$this->mFilter,
						$history_id
					)
				);
				return;
			}

			// If we've activated the 'tag' option, check the arguments for validity.
			if ( !empty( $actions['tag'] ) ) {
				$bad = false;
				foreach ( $actions['tag']['parameters'] as $tag ) {
					$t = Title::makeTitleSafe( NS_MEDIAWIKI, 'tag-' . $tag );
					if ( !$t ) {
						$bad = true;
					}

					if ( $bad ) {
						$out->addHTML(
							$this->buildFilterEditor(
								wfMsgExt( 'abusefilter-edit-bad-tags', 'parse' ),
								$this->mFilter,
								$history_id
							)
						);
						return;
					}
				}
			}

			$newRow = get_object_vars( $newRow ); // Convert from object to array

			// Set last modifier.
			$newRow['af_timestamp'] = $dbw->timestamp( wfTimestampNow() );
			$newRow['af_user'] = $user->getId();
			$newRow['af_user_text'] = $user->getName();

			$dbw->begin();

			// Insert MAIN row.
			if ( $filter == 'new' ) {
				$new_id = $dbw->nextSequenceValue( 'abuse_filter_af_id_seq' );
				$is_new = true;
			} else {
				$new_id = $this->mFilter;
				$is_new = false;
			}

			// Reset throttled marker, if we're re-enabling it.
			$newRow['af_throttled'] = $newRow['af_throttled'] && !$newRow['af_enabled'];
			$newRow['af_id'] = $new_id; // ID.

			$dbw->replace( 'abuse_filter', array( 'af_id' ), $newRow, __METHOD__ );

			if ( $is_new ) {
				$new_id = $dbw->insertId();
			}

			// Actions
			global $wgAbuseFilterAvailableActions;
			$deadActions = array();
			$actionsRows = array();
			foreach ( $wgAbuseFilterAvailableActions as $action ) {
				// Check if it's set
				$enabled = isset( $actions[$action] ) && (bool)$actions[$action];

				if ( $enabled ) {
					$parameters = $actions[$action]['parameters'];

					$thisRow = array(
						'afa_filter' => $new_id,
						'afa_consequence' => $action,
						'afa_parameters' => implode( "\n", $parameters )
					);
					$actionsRows[] = $thisRow;
				} else {
					$deadActions[] = $action;
				}
			}

			// Create a history row
			$afh_row = array();

			foreach ( AbuseFilter::$history_mappings as $af_col => $afh_col ) {
				$afh_row[$afh_col] = $newRow[$af_col];
			}

			// Actions
			$displayActions = array();
			foreach ( $actions as $action ) {
				$displayActions[$action['action']] = $action['parameters'];
			}
			$afh_row['afh_actions'] = serialize( $displayActions );

			$afh_row['afh_changed_fields'] = implode( ',', $differences );

			// Flags
			$flags = array();
			if ( $newRow['af_hidden'] ) {
				$flags[] = 'hidden';
			}
			if ( $newRow['af_enabled'] ) {
				$flags[] = 'enabled';
			}
			if ( $newRow['af_deleted'] ) {
				$flags[] = 'deleted';
			}
			if ( $newRow['af_global'] ) {
				$flags[] = 'global';
			}

			$afh_row['afh_flags'] = implode( ',', $flags );

			$afh_row['afh_filter'] = $new_id;
			$afh_row['afh_id'] = $dbw->nextSequenceValue( 'abuse_filter_af_id_seq' );

			// Do the update
			$dbw->insert( 'abuse_filter_history', $afh_row, __METHOD__ );
			$history_id = $dbw->insertId();
			if ( $filter != 'new' ) {
				$dbw->delete(
					'abuse_filter_action',
					array( 'afa_filter' => $filter ),
					__METHOD__
				);
			}
			$dbw->insert( 'abuse_filter_action', $actionsRows, __METHOD__ );

			$dbw->commit();

			// Logging

			$lp = new LogPage( 'abusefilter' );

			$lp->addEntry( 'modify', $this->getTitle( $new_id ), '', array( $history_id, $new_id ) );

			// Special-case stuff for tags -- purge the tag list cache.
			if ( isset( $actions['tag'] ) ) {
				global $wgMemc;
				$wgMemc->delete( wfMemcKey( 'valid-tags' ) );
			}

			AbuseFilter::resetFilterProfile( $new_id );

			$out->redirect(
				$this->getTitle()->getLocalURL( 'result=success&changedfilter=' . $new_id ) );
		} else {
			if ( $history_id ) {
				$out->addWikiMsg(
					'abusefilter-edit-oldwarning', $this->mHistoryID, $this->mFilter );
			}

			$out->addHTML( $this->buildFilterEditor( null, $this->mFilter, $history_id ) );

			if ( $history_id ) {
				$out->addWikiMsg(
					'abusefilter-edit-oldwarning', $this->mHistoryID, $this->mFilter );
			}
		}
	}

	function buildFilterEditor( $error, $filter, $history_id = null ) {
		if ( $filter === null ) {
			return false;
		}

		// Build the edit form
		$out = $this->getOutput();
		$lang = $this->getLanguage();
		$user = $this->getUser();
		$sk = $this->getSkin();

		// Load from request OR database.
		list( $row, $actions ) = $this->loadRequest( $filter, $history_id );

		if ( !$row ) {
			$out->addWikiMsg( 'abusefilter-edit-badfilter' );
			$out->addHTML( $sk->link( $this->getTitle(), wfMsg( 'abusefilter-return' ) ) );
			return;
		}

		$out->setSubtitle( wfMsg( 'abusefilter-edit-subtitle', $filter, $history_id ) );

		// Hide hidden filters.
		if ( ( ( isset( $row->af_hidden ) && $row->af_hidden ) ||
				AbuseFilter::filterHidden( $filter ) )
			&& !$this->canViewPrivate() ) {
			return wfMsg( 'abusefilter-edit-denied' );
		}

		$output = '';
		if ( $error ) {
			$out->addHTML( "<span class=\"error\">$error</span>" );
		}

		// Read-only attribute
		$readOnlyAttrib = array();
		$cbReadOnlyAttrib = array(); // For checkboxes

		if ( !$this->canEdit() ) {
			$readOnlyAttrib['readonly'] = 'readonly';
			$cbReadOnlyAttrib['disabled'] = 'disabled';
		}

		$fields = array();

		$fields['abusefilter-edit-id'] =
			$this->mFilter == 'new' ? wfMsg( 'abusefilter-edit-new' ) : $lang->formatNum( $filter );
		$fields['abusefilter-edit-description'] =
			Xml::input(
				'wpFilterDescription',
				45,
				isset( $row->af_public_comments ) ? $row->af_public_comments : '',
				$readOnlyAttrib
			);

		// Hit count display
		if ( !empty( $row->af_hit_count ) ) {
			$count = (int)$row->af_hit_count;
			$count_display = wfMsgExt( 'abusefilter-hitcount', array( 'parseinline' ),
				$lang->formatNum( $count )
			);
			$hitCount = $sk->makeKnownLinkObj(
				SpecialPage::getTitleFor( 'AbuseLog' ),
				$count_display,
				'wpSearchFilter=' . $row->af_id
			);

			$fields['abusefilter-edit-hitcount'] = $hitCount;
		}

		if ( $filter !== 'new' ) {
			// Statistics
			global $wgMemc;
			$matches_count = $wgMemc->get( AbuseFilter::filterMatchesKey( $filter ) );
			$total = $wgMemc->get( AbuseFilter::filterUsedKey() );


			if ( $total > 0 ) {
				$matches_percent = sprintf( '%.2f', 100 * $matches_count / $total );
				list( $timeProfile, $condProfile ) = AbuseFilter::getFilterProfile( $filter );

				$fields['abusefilter-edit-status-label'] =
					wfMsgExt( 'abusefilter-edit-status', array( 'parsemag', 'escape' ),
						array(
							$lang->formatNum( $total ),
							$lang->formatNum( $matches_count ),
							$lang->formatNum( $matches_percent ),
							$lang->formatNum( $timeProfile ),
							$lang->formatNum( $condProfile )
						)
					);
			}
		}

		$fields['abusefilter-edit-rules'] =
			AbuseFilter::buildEditBox( $row->af_pattern, 'wpFilterRules', true,
										$this->canEdit() );
		$fields['abusefilter-edit-notes'] =
			Xml::textarea(
				'wpFilterNotes',
				( isset( $row->af_comments ) ? $row->af_comments . "\n" : "\n" ),
				40, 5,
				$readOnlyAttrib
			);

		// Build checkboxen
		$checkboxes = array( 'hidden', 'enabled', 'deleted' );
		$flags = '';

		global $wgAbuseFilterIsCentral;
		if ( $wgAbuseFilterIsCentral ) {
			$checkboxes[] = 'global';
		}

		if ( isset( $row->af_throttled ) && $row->af_throttled ) {
			global $wgAbuseFilterEmergencyDisableThreshold;
			$threshold_percent = sprintf( '%.2f', $wgAbuseFilterEmergencyDisableThreshold * 100 );
			$flags .= $out->parse(
				wfMsg(
					'abusefilter-edit-throttled',
					$lang->formatNum( $threshold_percent )
				)
			);
		}

		foreach ( $checkboxes as $checkboxId ) {
			$message = "abusefilter-edit-$checkboxId";
			$dbField = "af_$checkboxId";
			$postVar = 'wpFilter' . ucfirst( $checkboxId );

			$checkbox = Xml::checkLabel(
				wfMsg( $message ),
				$postVar,
				$postVar,
				isset( $row->$dbField ) ? $row->$dbField : false,
				$cbReadOnlyAttrib
			);
			$checkbox = Xml::tags( 'p', null, $checkbox );
			$flags .= $checkbox;
		}

		$fields['abusefilter-edit-flags'] = $flags;
		$tools = '';

		if ( $filter != 'new' && $user->isAllowed( 'abusefilter-revert' ) ) {
			$tools .= Xml::tags(
				'p', null,
				$sk->link(
					$this->getTitle( 'revert/' . $filter ),
					wfMsg( 'abusefilter-edit-revert' )
				)
			);
		}

		if ( $filter != 'new' ) {
			// Test link
			$tools .= Xml::tags(
				'p', null,
				$sk->link(
					$this->getTitle( "test/$filter" ),
					wfMsgExt( 'abusefilter-edit-test-link', 'parseinline' )
				)
			);
			// Last modification details
			$userLink =
				$sk->userLink( $row->af_user, $row->af_user_text ) .
				$sk->userToolLinks( $row->af_user, $row->af_user_text );
			$userName = $row->af_user_text;
			$fields['abusefilter-edit-lastmod'] =
				wfMsgExt(
					'abusefilter-edit-lastmod-text',
					array( 'parseinline', 'replaceafter' ),
					array( $lang->timeanddate( $row->af_timestamp, true ),
						$userLink,
						$lang->date( $row->af_timestamp, true ),
						$lang->time( $row->af_timestamp, true ),
						$userName
					)
				);
			$history_display = wfMsgExt( 'abusefilter-edit-viewhistory', array( 'parseinline' ) );
			$fields['abusefilter-edit-history'] =
				$sk->makeKnownLinkObj( $this->getTitle( 'history/' . $filter ), $history_display );
		}

		// Add export
		$exportText = json_encode( array( 'row' => $row, 'actions' => $actions ) );
		$tools .= Xml::tags( 'a', array( 'href' => '#', 'id' => 'mw-abusefilter-export-link' ),
								wfMsgExt( 'abusefilter-edit-export', 'parseinline' ) );
		$tools .= Xml::element( 'textarea',
			array( 'readonly' => 'readonly', 'id' => 'mw-abusefilter-export' ),
			$exportText
		);

		$fields['abusefilter-edit-tools'] = $tools;

		$form = Xml::buildForm( $fields );
		$form = Xml::fieldset( wfMsg( 'abusefilter-edit-main' ), $form );
		$form .= Xml::fieldset(
			wfMsg( 'abusefilter-edit-consequences' ),
			$this->buildConsequenceEditor( $row, $actions )
		);

		if ( $this->canEdit() ) {
			$form .= Xml::submitButton( wfMsg( 'abusefilter-edit-save' ), array( 'accesskey' => 's' ) );
			$form .= Html::hidden(
				'wpEditToken',
				$user->getEditToken( array( 'abusefilter', $filter ) )
			);
		}

		$form = Xml::tags( 'form',
			array(
				'action' => $this->getTitle( $filter )->getFullURL(),
				'method' => 'post'
			),
			$form
		);

		$output .= $form;

		return $output;
	}

	function buildConsequenceEditor( $row, $actions ) {
		global $wgAbuseFilterAvailableActions;

		$setActions = array();
		foreach ( $wgAbuseFilterAvailableActions as $action ) {
			$setActions[$action] = array_key_exists( $action, $actions );
		}

		$output = '';

		foreach ( $wgAbuseFilterAvailableActions as $action ) {
			$output .= $this->buildConsequenceSelector(
				$action, $setActions[$action], @$actions[$action]['parameters'] );
		}

		return $output;
	}

	function buildConsequenceSelector( $action, $set, $parameters ) {
		global $wgAbuseFilterAvailableActions;

		if ( !in_array( $action, $wgAbuseFilterAvailableActions ) ) {
			return;
		}

		$readOnlyAttrib = array();
		$cbReadOnlyAttrib = array(); // For checkboxes

		if ( !$this->canEdit() ) {
			$readOnlyAttrib['readonly'] = 'readonly';
			$cbReadOnlyAttrib['disabled'] = 'disabled';
		}

		switch( $action ) {
			case 'throttle':
				$throttleSettings = Xml::checkLabel(
					wfMsg( 'abusefilter-edit-action-throttle' ),
					'wpFilterActionThrottle',
					"mw-abusefilter-action-checkbox-$action",
					$set,
					array(  'class' => 'mw-abusefilter-action-checkbox' ) + $cbReadOnlyAttrib );
				$throttleFields = array();

				if ( $set ) {
					array_shift( $parameters );
					$throttleRate = explode( ',', $parameters[0] );
					$throttleCount = $throttleRate[0];
					$throttlePeriod = $throttleRate[1];

					$throttleGroups = implode( "\n", array_slice( $parameters, 1 ) );
				} else {
					$throttleCount = 3;
					$throttlePeriod = 60;

					$throttleGroups = "user\n";
				}

				$throttleFields['abusefilter-edit-throttle-count'] =
					Xml::input( 'wpFilterThrottleCount', 20, $throttleCount, $readOnlyAttrib );
				$throttleFields['abusefilter-edit-throttle-period'] =
					wfMsgExt(
						'abusefilter-edit-throttle-seconds',
						array( 'parseinline', 'replaceafter' ),
						array(
							Xml::input( 'wpFilterThrottlePeriod', 20, $throttlePeriod,
								$readOnlyAttrib
						) )
					);
				$throttleFields['abusefilter-edit-throttle-groups'] =
					Xml::textarea( 'wpFilterThrottleGroups', $throttleGroups . "\n",
									40, 5, $readOnlyAttrib );
				$throttleSettings .=
					Xml::tags(
						'div',
						array( 'id' => 'mw-abusefilter-throttle-parameters' ),
						Xml::buildForm( $throttleFields )
					);
				return $throttleSettings;
			case 'flag':
				$checkbox = Xml::checkLabel(
					wfMsg( 'abusefilter-edit-action-flag' ),
					'wpFilterActionFlag',
					"mw-abusefilter-action-checkbox-$action",
					true,
					array( 'disabled' => '1', 'class' => 'mw-abusefilter-action-checkbox' ) );
				return Xml::tags( 'p', null, $checkbox );
			case 'warn':
				$output = '';
				$checkbox = Xml::checkLabel(
					wfMsg( 'abusefilter-edit-action-warn' ),
					'wpFilterActionWarn',
					"mw-abusefilter-action-checkbox-$action",
					$set,
					array( 'class' => 'mw-abusefilter-action-checkbox' ) + $cbReadOnlyAttrib );
				$output .= Xml::tags( 'p', null, $checkbox );
				$warnMsg = empty( $set ) ? 'abusefilter-warning' : $parameters[0];

				$warnFields['abusefilter-edit-warn-message'] =
					$this->getExistingSelector( $warnMsg );
				$warnFields['abusefilter-edit-warn-other-label'] =
					Xml::input(
						'wpFilterWarnMessageOther',
						45,
						$warnMsg ? $warnMsg : 'abusefilter-warning-',
						array( 'id' => 'mw-abusefilter-warn-message-other' ) + $cbReadOnlyAttrib
					);

				$previewButton = Xml::element(
					'input',
					array(
						'type' => 'button',
						'id' => 'mw-abusefilter-warn-preview-button',
						'value' => wfMsg( 'abusefilter-edit-warn-preview' )
					)
				);
				$editButton = Xml::element(
					'input',
					array(
						'type' => 'button',
						'id' => 'mw-abusefilter-warn-edit-button',
						'value' => wfMsg( 'abusefilter-edit-warn-edit' )
					)
				);
				$previewHolder = Xml::element(
					'div',
					array( 'id' => 'mw-abusefilter-warn-preview' ), ''
				);
				$warnFields['abusefilter-edit-warn-actions'] =
					Xml::tags( 'p', null, "$previewButton $editButton" ) . "\n$previewHolder";
				$output .=
					Xml::tags(
						'div',
						array( 'id' => 'mw-abusefilter-warn-parameters' ),
						Xml::buildForm( $warnFields )
					);
				return $output;
			case 'tag':
				if ( $set ) {
					$tags = $parameters;
				} else {
					$tags = array();
				}
				$output = '';

				$checkbox = Xml::checkLabel(
					wfMsg( 'abusefilter-edit-action-tag' ),
					'wpFilterActionTag',
					"mw-abusefilter-action-checkbox-$action",
					$set,
					array( 'class' => 'mw-abusefilter-action-checkbox' ) + $cbReadOnlyAttrib
				);
				$output .= Xml::tags( 'p', null, $checkbox );

				$tagFields['abusefilter-edit-tag-tag'] =
					Xml::textarea( 'wpFilterTags', implode( "\n", $tags ), 40, 5, $readOnlyAttrib );
				$output .=
					Xml::tags( 'div',
						array( 'id' => 'mw-abusefilter-tag-parameters' ),
						Xml::buildForm( $tagFields )
					);
				return $output;
			default:
				$message = 'abusefilter-edit-action-' . $action;
				$form_field = 'wpFilterAction' . ucfirst( $action );
				$status = $set;

				$thisAction = Xml::checkLabel(
					wfMsg( $message ),
					$form_field,
					"mw-abusefilter-action-checkbox-$action",
					$status,
					array( 'class' => 'mw-abusefilter-action-checkbox' ) + $cbReadOnlyAttrib
				);
				$thisAction = Xml::tags( 'p', null, $thisAction );
				return $thisAction;
		}
	}

	function getExistingSelector( $warnMsg ) {
		$existingSelector = new XmlSelect(
			'wpFilterWarnMessage',
			'mw-abusefilter-warn-message-existing',
			$warnMsg == 'abusefilter-warning' ? 'abusefilter-warning' : 'other'
		);

		// Find other messages.
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'page',
			array( 'page_title' ),
			array(
				'page_namespace' => 8,
				'page_title LIKE ' . $dbr->addQuotes( 'Abusefilter-warning%' )
			),
			__METHOD__
		);

		$existingSelector->addOption( 'abusefilter-warning' );

		$lang = $this->getLanguage();
		foreach( $res as $row ) {
			if ( $lang->lcfirst( $row->page_title ) == $lang->lcfirst( $warnMsg ) ) {
				$existingSelector->setDefault( $lang->lcfirst( $warnMsg ) );
			}

			if ( $row->page_title != 'Abusefilter-warning' ) {
				$existingSelector->addOption( $lang->lcfirst( $row->page_title ) );
			}
		}

		$existingSelector->addOption( wfMsg( 'abusefilter-edit-warn-other' ), 'other' );

		return $existingSelector->getHTML();
	}

	function loadFilterData( $id ) {
		if ( $id == 'new' ) {
			$obj = new stdClass;
			$obj->af_pattern = '';
			$obj->af_enabled = 1;
			$obj->af_hidden = 0;
			$obj->af_global = 0;
			return array( $obj, array() );
		}

		// Load from master to avoid unintended reversions where there's replication lag.
		$dbr = wfGetDB( DB_MASTER );

		// Load certain fields only. This prevents a condition seen on Wikimedia where
		// a schema change adding a new field caused that extra field to be selected.
		// Since the selected row may be inserted back into the database, this will cause
		// an SQL error if, say, one server has the updated schema but another does not.
		$loadFields = array(
			'af_id',
			'af_pattern',
			'af_user',
			'af_user_text',
			'af_timestamp',
			'af_enabled',
			'af_comments',
			'af_public_comments',
			'af_hidden',
			'af_hit_count',
			'af_throttled',
			'af_deleted',
			'af_actions',
			'af_global',
		);

		// Load the main row
		$row = $dbr->selectRow( 'abuse_filter', $loadFields, array( 'af_id' => $id ), __METHOD__ );

		if ( !isset( $row ) || !isset( $row->af_id ) || !$row->af_id ) {
			return null;
		}

		// Load the actions
		$actions = array();
		$res = $dbr->select( 'abuse_filter_action',
			'*',
			array( 'afa_filter' => $id ),
			__METHOD__
		);
		foreach( $res as $actionRow ) {
			$thisAction = array();
			$thisAction['action'] = $actionRow->afa_consequence;
			$thisAction['parameters'] = explode( "\n", $actionRow->afa_parameters );

			$actions[$actionRow->afa_consequence] = $thisAction;
		}

		return array( $row, $actions );
	}

	function loadRequest( $filter, $history_id = null ) {
		static $row = null;
		static $actions = null;
		$request = $this->getRequest();

		if ( !is_null( $actions ) && !is_null( $row ) ) {
			return array( $row, $actions );
		} elseif ( $request->wasPosted() ) {
			# Nothing, we do it all later
		} elseif ( $history_id ) {
			return $this->loadHistoryItem( $history_id );
		} else {
			return $this->loadFilterData( $filter );
		}

		// We need some details like last editor
		list( $row, $origActions ) = $this->loadFilterData( $filter );

		$row->mOriginalRow = clone $row;
		$row->mOriginalActions = $origActions;

		// Check for importing
		$import = $request->getVal( 'wpImportText' );
		if ( $import ) {
			$data = json_decode( $import );

			$importRow = $data->row;
			$actions = wfObjectToArray( $data->actions );

			$copy = array(
				'af_public_comments',
				'af_pattern',
				'af_comments',
				'af_deleted',
				'af_enabled',
				'af_hidden',
			);

			foreach ( $copy as $name ) {
				$row->$name = $importRow->$name;
			}
		} else {
			$textLoads = array(
				'af_public_comments' => 'wpFilterDescription',
				'af_pattern' => 'wpFilterRules',
				'af_comments' => 'wpFilterNotes'
			);

			foreach ( $textLoads as $col => $field ) {
				$row->$col = trim( $request->getVal( $field ) );
			}

			$row->af_deleted = $request->getBool( 'wpFilterDeleted' );
			$row->af_enabled = $request->getBool( 'wpFilterEnabled' ) && !$row->af_deleted;
			$row->af_hidden = $request->getBool( 'wpFilterHidden' );
			global $wgAbuseFilterIsCentral;
			$row->af_global = $request->getBool( 'wpFilterGlobal' ) && $wgAbuseFilterIsCentral;

			// Actions
			global $wgAbuseFilterAvailableActions;
			$actions = array();
			foreach ( $wgAbuseFilterAvailableActions as $action ) {
				// Check if it's set
				$enabled = $request->getBool( 'wpFilterAction' . ucfirst( $action ) );

				if ( $enabled ) {
					$parameters = array();

					if ( $action == 'throttle' ) {
						// We need to load the parameters
						$throttleCount = $request->getIntOrNull( 'wpFilterThrottleCount' );
						$throttlePeriod = $request->getIntOrNull( 'wpFilterThrottlePeriod' );
						$throttleGroups = explode( "\n",
							trim( $request->getText( 'wpFilterThrottleGroups' ) ) );

						$parameters[0] = $this->mFilter; // For now, anyway
						$parameters[1] = "$throttleCount,$throttlePeriod";
						$parameters = array_merge( $parameters, $throttleGroups );
					} elseif ( $action == 'warn' ) {
						$specMsg = $request->getVal( 'wpFilterWarnMessage' );

						if ( $specMsg == 'other' )
							$specMsg = $request->getVal( 'wpFilterWarnMessageOther' );

						$parameters[0] = $specMsg;
					} elseif ( $action == 'tag' ) {
						$parameters = explode( "\n", $request->getText( 'wpFilterTags' ) );
					}

					$thisAction = array( 'action' => $action, 'parameters' => $parameters );
					$actions[$action] = $thisAction;
				}
			}
		}

		$row->af_actions = implode( ',', array_keys( array_filter( $actions ) ) );

		return array( $row, $actions );
	}

	function loadHistoryItem( $id ) {
		$dbr = wfGetDB( DB_SLAVE );

		// Load the row.
		$row = $dbr->selectRow( 'abuse_filter_history',
			'*',
			array( 'afh_id' => $id ),
			__METHOD__
		);

		return AbuseFilter::translateFromHistory( $row );
	}
}
