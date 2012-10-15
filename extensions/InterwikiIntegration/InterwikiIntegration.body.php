<?php
class InterwikiIntegrationFunctions {
	public static function modifyDisplayQuery( &$tables, &$fields,  &$conds,
			&$join_conds, &$options, $filter_tag = false ) {
		global $wgRequest, $wgUseTagFilter;

		if( $filter_tag === false ) {
			$filter_tag = $wgRequest->getVal( 'tagfilter' );
		}

		// Figure out which conditions can be done.
		$join_field = '';
		if ( in_array( 'integration_recentchanges', $tables ) ) {
			$join_cond = 'rc_id';
                        $join_cond2 = 'integration_rc_id';
                } elseif( in_array( 'integration_watchlist', $tables ) ) {
			$join_cond = 'wl_id';
                        $join_cond2 = 'integration_wl_id';
		} elseif( in_array( 'logging', $tables ) ) {
			$join_cond = 'log_id';
		} elseif ( in_array( 'revision', $tables ) ) {
			$join_cond = 'rev_id';
		} else {
			throw new MWException( 'Unable to determine appropriate JOIN condition for tagging.' );
		}

		// JOIN on tag_summary
		$tables[] = 'tag_summary';
                if ( !isset ( $join_cond )) {
                    $join_cond2 = $join_cond;
                }
		$join_conds['tag_summary'] = array( 'LEFT JOIN', "ts_$join_cond=$join_cond2" );
		$fields[] = 'ts_tags';

		if( $wgUseTagFilter && $filter_tag ) {
			// Somebody wants to filter on a tag.
			// Add an INNER JOIN on change_tag

			// FORCE INDEX -- change_tags will almost ALWAYS be the correct query plan.
			global $wgOldChangeTagsIndex;
			$index = $wgOldChangeTagsIndex ? 'ct_tag' : 'change_tag_tag_id';
			$options['USE INDEX'] = array( 'change_tag' => $index );
			unset( $options['FORCE INDEX'] );
			$tables[] = 'change_tag';
			$join_conds['change_tag'] = array( 'INNER JOIN', "ct_$join_cond=$join_cond" );
			$conds['ct_tag'] = $filter_tag;
		}
	}
}

class IntegrationInterwikiTitle extends Title {
    /**
	 * Create a new Title from a namespace index and a DB key.
	 * It's assumed that $ns and $title are *valid*, for instance when
	 * they came directly from the database or a special page name.
	 * For convenience, spaces are converted to underscores so that
	 * eg user_text fields can be used directly.
	 *
	 * @param $ns \type{\int} the namespace of the article
	 * @param $title \type{\string} the unprefixed database key form
	 * @param $fragment \type{\string} The link fragment (after the "#")
	 * @return \type{Title} the new object
	 */
	public static function &makeTitle( $ns, $title, $fragment = '', $database = '', $interwiki = '' ) {
                global $wgInterwikiIntegrationPrefix, $wgDBname;
                if ( $database != '' && $database != $wgDBname ) {
                    $prefixes = array_keys ( $wgInterwikiIntegrationPrefix, $database );
                    if ( $prefixes ) {
                        $interwiki = $prefixes[0];
                    }
                    if ( $ns ) {
                        $dbr = wfGetDB( DB_SLAVE );
                        $namespaceResult = $dbr->selectRow (
                                'integration_namespace',
                                'integration_namespace_title',
                                array (
                                       'integration_dbname' => $database,
                                       'integration_namespace_index' => $ns
                                )
                        );
                        if ( $namespaceResult ) {
                            $nsTitle = $namespaceResult->integration_namespace_title;
                            $title = $nsTitle . ':' . $title;
                        }
                        $ns = 0;
                    }
				}
		$interwiki = ucfirst( $interwiki );
		$t = Title::makeTitle( $ns, $title, $fragment, $interwiki );
		return $t;
	}	
}