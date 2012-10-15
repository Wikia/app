<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

class CategoryMultisortHooks {

	function __construct() {
		global $wgHooks;
		
		foreach ( array(
			'LoadExtensionSchemaUpdates',
			'ParserFirstCallInit',
			'ParserClearState',
			'ParserBeforeTidy',
			'LinksUpdate',
			'ArticleDeleteComplete',
			'CategoryPageView',
			'GetPreferences',
		) as $hook ) {
			$wgHooks[$hook][] = $this;
		}
		
		$this->integrate = false;
	}
	
	function setIntegrate( $integrate = true ) {
		$this->integrate = $integrate;
	}

	function onLoadExtensionSchemaUpdates( $updater = null ) {
		if ( $updater === null ) {
			global $wgExtNewTables, $wgDBtype;
			$sql = dirname( __FILE__ ) . "/tables.$wgDBtype.sql";
			if ( file_exists( $sql ) ) {
				$wgExtNewTables[] = array( 'categorylinks_multisort', $sql );
			}
		} else {
			$sql = dirname( __FILE__ ) . '/tables.' . $updater->getDB()->getType() . '.sql';
			if ( file_exists( $sql ) ) {
				$updater->addExtensionUpdate( array( 'addTable', 'categorylinks_multisort', $sql, true ) );
			}
		}

		return true;
	}
	
	function onParserFirstCallInit( $parser ) {
		$parser->setFunctionHook(
			'CategoryMultisort',
			array( $this, 'parserCategoryMultisort' )
		);
		$parser->setFunctionHook(
			'CategoryDefaultMultisort',
			array( $this, 'parserCategoryDefaultMultisort' )
		);
		$parser->setFunctionHook(
			'CategoryUseMultisort',
			array( $this, 'parserCategoryUseMultisort' )
		);
		if ( $this->integrate ) {
			$this->coreCategoryLinkHook = $parser->setLinkHook(
				NS_CATEGORY, array( $this, 'parserCategoryLink' )
			);
			$this->coreDefaultSortHook = $parser->setFunctionHook(
				'defaultsort', array( $this, 'parserDefaultSort' ), SFH_NO_HASH
			);
		}
		return true;
	}
	
	function onParserClearState( $parser ) {
		$parser->getOutput()->mCategoryMultisorts = array();
		$parser->getOutput()->mCategoryDefaultMultisorts = array();
		return true;
	}
	
	function onParserBeforeTidy( $parser, $text ) {
		$categoryMultisorts = &$parser->getOutput()->mCategoryMultisorts;
		$categoryMultisorts = array_intersect_key( $categoryMultisorts, $parser->getOutput()->getCategories() );
		$categoryDefaultMultisorts = $parser->getOutput()->mCategoryDefaultMultisorts;
		foreach ( $parser->getOutput()->getCategories() as $cat => $sk ) {
			if ( !array_key_exists( $cat, $categoryMultisorts ) ) {
				$categoryMultisorts[$cat] = array();
			}
			foreach ( $categoryDefaultMultisorts as $dskn => $dskv ) {
				if ( !array_key_exists( $dskn, $categoryMultisorts[$cat] ) ) {
					$categoryMultisorts[$cat][$dskn] = $dskv;
				}
			}
			wfRunHooks( 'CategoryMultisortSortkeys', array( $parser, $cat, &$categoryMultisorts[$cat] ) );
		}
		return true;
	}
	
	function onLinksUpdate( $linksUpdate ) {
		global $wgUseDumbLinkUpdate;
		
		$categoryMultisorts = $linksUpdate->mParserOutput->mCategoryMultisorts;
		
		$invalidates = array();
		
		$existing = $this->onLinksUpdate_getExistingCategoryMultisorts( $linksUpdate );
		
		if ( $wgUseDumbLinkUpdate ) {
			$invalidates = array_merge( $invalidates, array_keys( $existing ) );
			$insertions = $this->onLinksUpdate_getCategoryMultisortInsertions(
				$linksUpdate, $categoryMultisorts, $invalidates
			);
			$linksUpdate->dumbTableUpdate( 'categorylinks_multisort', $insertions, 'clms_from' );
		} else {
			$categoryDeletes = $this->onLinksUpdate_getCategoryMultisortDeletions(
				$categoryMultisorts, $invalidates, $existing
			);
			$categoryInserts = $this->onLinksUpdate_getCategoryMultisortInsertions(
				$linksUpdate, $categoryMultisorts, $invalidates, $existing
			);
			
			# incrTableUpdate
			$to = array();
			foreach ( $categoryDeletes as $cat => $sk ) {
				foreach ( $sk as $skn => $skv ) {
					$to[] = $linksUpdate->mDb->makeList( array(
						'clms_to' => $cat,
						'clms_sortkey_name' => $skn,
					), LIST_AND );
				}
			}
			if ( count( $to ) ) {
				$where = array( 'clms_from' => $linksUpdate->mId );
				$where[] = $linksUpdate->mDb->makeList( $to, LIST_OR );
				$linksUpdate->mDb->delete( 'categorylinks_multisort' , $where, __METHOD__ );
			}
			
			if ( count( $categoryInserts ) ) {
				$linksUpdate->mDb->insert( 'categorylinks_multisort', $categoryInserts, __METHOD__, 'IGNORE' );
			}
		}
		
		# No need to update count. It will be done in LinksUpdate.php.
		# This affects only its associated information in categories, not whether it's in them.

		$linksUpdate->invalidatePages( NS_CATEGORY, array_unique( $invalidates ) );

		return true;
	}
	
	function onLinksUpdate_getExistingCategoryMultisorts( $linksUpdate ) {
		$res = $linksUpdate->mDb->select( 'categorylinks_multisort',
			array( 'clms_to', 'clms_sortkey_name', 'clms_sortkey' ),
			array( 'clms_from' => $linksUpdate->mId ), __METHOD__, $linksUpdate->mOptions );
		$arr = array();
		while ( $row = $linksUpdate->mDb->fetchObject( $res ) ) {
			$arr[$row->clms_to][$row->clms_sortkey_name] = $row->clms_sortkey;
		}
		$linksUpdate->mDb->freeResult( $res );
		return $arr;
	}
		
	function onLinksUpdate_getCategoryMultisortInsertions(
		$linksUpdate, &$categoryMultisorts, &$invalidates, $existing = array()
	) {
		$arr = array();
		
		foreach ( $categoryMultisorts as $cat => $sk ) {
			if ( !array_key_exists( $cat, $existing ) ) {
				$invalidates[] = $cat;
				foreach ( $sk as $skn => $skv ) {
					$this->onLinksUpdate_getCategoryMultisortInsertions_addCategoryInsertion(
						$linksUpdate, $arr, $cat, $skn, $skv
					);
				}
			} else {
				$exsk = $existing[$cat];
				foreach ( $sk as $skn => $skv ) {
					# PHP thinks '02' == '002'
					if ( !array_key_exists( $skn, $exsk ) || $exsk[$skn] !== $skv ) {
						$invalidates[] = $cat;
						$this->onLinksUpdate_getCategoryMultisortInsertions_addCategoryInsertion(
							$linksUpdate, $arr, $cat, $skn, $skv
						);
					}
				}
			}
		}
		
		return $arr;
	}
	
	function onLinksUpdate_getCategoryMultisortInsertions_addCategoryInsertion(
		$linksUpdate, &$arr, $cat, $skn, $skv
	) {
		global $wgContLang;
		
		$nt = Title::makeTitleSafe( NS_CATEGORY, $cat );
		$wgContLang->findVariantLink( $cat, $nt, true );
		$arr[] = array(
			'clms_from' => $linksUpdate->mId,
			'clms_to' => $cat,
			'clms_sortkey_name' => $skn,
			'clms_sortkey' => $skv,
		);
	}
	
	function onLinksUpdate_getCategoryMultisortDeletions( &$categoryMultisorts, &$invalidates, $existing ) {
		$arr = array();
		foreach ( $existing as $cat => $sk ) {
			if ( !array_key_exists( $cat, $categoryMultisorts ) ) {
				$invalidates[] = $cat;
				$arr[$cat] = $sk;
			} else {
				$cmsk = $categoryMultisorts[$cat];
				foreach ( $sk as $skn => $skv ) {
					# PHP thinks '02' == '002'
					if ( !array_key_exists( $skn, $cmsk ) || $cmsk[$skn] !== $skv ) {
						$invalidates[] = $cat;
						$arr[$cat][$skn] = $skv;
					}
				}
			}
		}
		return $arr;
	}
	
	function onArticleDeleteComplete( $article, $user, $reason, $id ) {
		$dbw = wfGetDB( DB_MASTER );
		if ( !$dbw->cascadingDeletes() ) {
			$dbw->delete( 'categorylinks_multisort', array( 'clms_from' => $id ) );
		}
		return true;
	}
	
	function parserCategoryLink(
		$parser, $holders, $markers, $title, $titleText, &$sortText = null, &$leadingColon = false
	) {
		global $wgContLang;
		
		# When a category link starts with a : treat it as a normal link
		if ( $leadingColon ) {
			return true;
		}
		
		if ( isset( $sortText ) && $markers->findMarker( $sortText ) ) {
			# There are links inside of the sortText
			# For backwards compatibility the deepest links are dominant so this
			# link should not be handled
			$sortText = $markers->expand( $sortText );
			# Return false so that this link is reverted back to WikiText
			return false;
		}
		
		# No sortkeys at all
		$sort = $sortText ? $sortText : '';
		
		# If there is only one part (including set to '' above), it will be shifted later and then no multisorts.
		$sorts = explode( '|', $sort );
		
		# Reserve the first for core hook, for compatibility.
		$sort = array_shift( $sorts );
		if ( !$sort ) { # Blank string
			$sort = null;
		}
		if ( is_callable( $this->coreCategoryLinkHook ) ) {
			# Will it return any error message?
			call_user_func_array( $this->coreCategoryLinkHook, array(
				$parser, $holders, $markers, $title, $titleText, &$sort, &$leadingColon
			) );
		}
		
		$category = $title->getDBkey();
		$categoryMultisorts = &$parser->getOutput()->mCategoryMultisorts;
		foreach ( $this->parseMultisortArgs( $sorts ) as $skn => $skv ) {
			$categoryMultisorts[$category][$skn] = $skv;
		}
		
		return '';
	}
	
	function parserDefaultSort() {
		$args = func_get_args();
		$parser = array_shift( $args );
		$defaultSort = array_shift( $args );
		$categoryDefaultMultisorts = &$parser->getOutput()->mCategoryDefaultMultisorts;
		
		foreach ( $this->parseMultisortArgs( $args ) as $skn => $skv ) {
			$categoryDefaultMultisorts[$skn] = $skv;
		}
		
		if ( is_callable( $this->coreDefaultSortHook ) ) {
			return call_user_func_array( $this->coreDefaultSortHook, array(
				$parser, $defaultSort
			) );
		} else {
			return '';
		}
	}
	
	function parserCategoryMultisort() {
		$args = func_get_args();
		$parser = array_shift( $args );
		$category = Title::newFromText( array_shift( $args ), NS_CATEGORY );
		if ( is_null( $category ) ) {
			return '';
		}
		$category = $category->getDBkey();
		$categoryMultisorts = &$parser->getOutput()->mCategoryMultisorts;
		
		foreach ( $this->parseMultisortArgs( $args ) as $skn => $skv ) {
			$categoryMultisorts[$category][$skn] = $skv;
		}
		
		return '';
	}
	
	function parserCategoryDefaultMultisort() {
		$args = func_get_args();
		$parser = array_shift( $args );
		$categoryDefaultMultisorts = &$parser->getOutput()->mCategoryDefaultMultisorts;
		
		foreach ( $this->parseMultisortArgs( $args ) as $skn => $skv ) {
			$categoryDefaultMultisorts[$skn] = $skv;
		}
		
		return '';
	}
	
	function parserCategoryUseMultisort( $parser, $use ) {
		$parser->getOutput()->mCategoryUseMultisort = trim( $use );
		
		return '';
	}
	
	function onCategoryPageView( $categoryArticle ) {
		global $wgRequest, $wgOut, $wgUser, $wgCategoryMultisortSortkeySettings;
		
		
		
		$title = $categoryArticle->getTitle();
		
		if ( $title->getNamespace() != NS_CATEGORY ) {
			return true;
		} else {
			# If a sortkey is designated to be used, don't do more check
			if ( is_null( $skn = $wgRequest->getVal( 'sortkey' ) ) ) {
				# Check whether a sortkey is set for this category
				
				$parsetOutput = $categoryArticle->getParserOutput();
				
				# If a corresponding property exists, and
				# (1) such property is a blank string
				# or (2) such property is allowed by $wgCategoryMultisortSortkeySettings
				# then use it. Otherwise, use user preference.
				if ( !( isset( $parsetOutput->mCategoryUseMultisort )
					&& ( !( $skn = $parsetOutput->mCategoryUseMultisort )
						|| array_key_exists( $skn, $wgCategoryMultisortSortkeySettings )
					)
				) ) {
					$skn = $wgUser->getOption( 'categorymultisort-sortkey' );
				}
			}
			
			$wgOut->addHTML( $this->onCategoryPageView_buildSortkeySelectForm( $skn, $title ) );
			
			if ( !$skn || !array_key_exists( $skn, $wgCategoryMultisortSortkeySettings ) ) {
				return true;
			} else {
				$article = new Article( $title );
				$article->view();
			
				$from = $wgRequest->getVal( 'from' );
				$until = $wgRequest->getVal( 'until' );
				$viewer = new CategoryMultisortViewer(
					$title, $categoryArticle->getContext(), $skn,
					$from, $until
				);
				$wgOut->addHTML( $viewer->getHTML() );
				
				return false;
			}
		}
	}
	
	function onCategoryPageView_buildSortkeySelectForm( $current, $title ) {
		global $wgCategoryMultisortSortkeySettings, $wgScript, $wgContLang;
		
		$html = '';
		
		if ( count( $wgCategoryMultisortSortkeySettings ) ) {
			
			$html = Html::element( 'option',
				array_merge( array( 'value' => '' ), ( $current == '' ? array( 'selected' ) : array() ) ),
				wfMsgNoTrans( 'categorymultisort-defaultsortkey-name' )
			);
			foreach ( $wgCategoryMultisortSortkeySettings as $skn => $sks ) {
				$html .= Html::element( 'option',
					array_merge( array( 'value' => $skn ), ( $current == $skn ? array( 'selected' ) : array() ) ),
					wfMsgNoTrans( "categorymultisort-sortkey-name-$skn" )
				);
			}
			$html = Html::rawElement( 'select', array(
				'name' => 'sortkey',
				'id' => 'categorymultisort-select',
				'onchange' => 'this.parentNode.submit();',
			), $html );
			$html = Html::element( 'label', array(
				'for' => 'categorymultisort-select',
			), wfMsgExt( 'categorymultisort-sortkey', 'parseinline' ) ) . $html;
			$html .= Html::rawElement( 'noscript', array(),
				Html::input( '', wfMsgNoTrans( 'categorymultisort-go' ), 'submit' , array(
				'id' => 'categorymultisort-select-go',
			) ) );
			$html = Html::hidden( 'title', $title->getPrefixedDBkey() ) . $html;
			$html = Html::rawElement( 'form', array(
				'action' => $wgScript,
				'method' => 'get',
				'id' => 'categorymultisort-select-form',
				'style' => "float: {$wgContLang->alignEnd()};",
			), $html );
		}
		
		return $html;
	}
	
	function onGetPreferences( $user, &$preferences ) {
		global $wgCategoryMultisortSortkeySettings;
		
		
		
		$options = array(
			wfMsgNoTrans( 'categorymultisort-defaultsortkey-name' ) => '',
		);
		foreach ( $wgCategoryMultisortSortkeySettings as $skn => $sks ) {
			$options[wfMsgNoTrans( "categorymultisort-sortkey-name-$skn" )] = $skn;
		}
		
		$preferences['categorymultisort-sortkey'] = array(
			'type' => 'select',
			'section' => 'misc/category',
			'options' => $options,
			'label-message' => 'categorymultisort-default-sortkey',
		);
		
		return true;
	}
	
	function parseMultisortArgs( $args ) {
		$arr = array();
		
		while ( !is_null( $sk = array_shift( $args ) ) ) {
			$sk = explode( '=', $sk, 2 );
			if ( count( $sk ) != 2 ) {
				continue;
			}
			list( $skn, $skv ) = $sk;
			$skn = $this->cleanSortkey( $skn );
			$skv = $this->cleanSortkey( $skv );
			if ( $skn ) {
				$arr[$skn] = $skv;
			}
		}
		
		return $arr;
	}
	
	function cleanSortkey( $skx ) {
		global $wgContLang;
		
		$skx = trim( $skx );
		$skx = Sanitizer::decodeCharReferences( $skx );
		$skx = str_replace( "\n", '', $skx );
		$skx = $wgContLang->convertCategoryKey( $skx );
		return $skx;
	}
}
