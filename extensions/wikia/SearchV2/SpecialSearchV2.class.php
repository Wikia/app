<?php

class SpecialSearchV2 extends SpecialSearch
{

  public function __construct(&$request, &$user)
  {
    parent::__construct(&$request, &$user);
    $this->active = $this->getActiveTab($request);
    $this->searchEngine = SearchEngine::create();
  }

  public function getPowerSearchBox($term)
  {
    return $this->active == 'advanced' ? $this->prepare($this->powerSearchBox($term)) : '';
  }

  public function getFormHeader($term, $resultsShown, $totalNum)
  {
    return $this->prepare($this->formHeader($term, $resultsShown, $totalNum));
  }


  private function prepare($string)
  {
    return str_replace('&fulltext=Search', '',
                       str_replace('search=', 'query=',
                                   str_replace('Special:Search', 'Special:WikiaSearch', $string)));
  }


	protected function powerSearchBox( $term ) {
		global $wgScript, $wgContLang;

		// Groups namespaces into rows according to subject
		$rows = array();
		foreach( SearchEngine::searchableNamespaces() as $namespace => $name ) {
			$subject = MWNamespace::getSubject( $namespace );
			if( !array_key_exists( $subject, $rows ) ) {
				$rows[$subject] = "";
			}
			$name = str_replace( '_', ' ', $name );
			if( $name == '' ) {
				$name = wfMsg( 'blanknamespace' );
			}
			$rows[$subject] .=
				Xml::openElement(
					'td', array( 'style' => 'white-space: nowrap' )
				) .
				Xml::checkLabel(
					$name,
					"ns{$namespace}",
					"mw-search-ns{$namespace}",
					in_array( $namespace, $this->namespaces )
				) .
				Xml::closeElement( 'td' );
		}
		$rows = array_values( $rows );
		$numRows = count( $rows );

		// Lays out namespaces in multiple floating two-column tables so they'll
		// be arranged nicely while still accommodating different screen widths
		$namespaceTables = '';
		for( $i = 0; $i < $numRows; $i += 4 ) {
			$namespaceTables .= Xml::openElement(
				'table',
				array( 'cellpadding' => 0, 'cellspacing' => 0, 'border' => 0 )
			);
			for( $j = $i; $j < $i + 4 && $j < $numRows; $j++ ) {
				$namespaceTables .= Xml::tags( 'tr', null, $rows[$j] );
			}
			$namespaceTables .= Xml::closeElement( 'table' );
		}
		// Show redirects check only if backend supports it
		$redirects = '';
		if( $this->searchEngine->acceptListRedirects() ) {
			$redirects =
				Xml::check(
					'redirs', $this->searchRedirects, array( 'value' => '1', 'id' => 'redirs' )
				) .
				' ' .
				Xml::label( wfMsg( 'powersearch-redir' ), 'redirs' );
		}
		$hidden = Xml::hidden( 'advanced', $this->searchAdvanced );
		// Return final output
		return
			Xml::openElement(
				'fieldset',
				array( 'id' => 'mw-searchoptions', 'style' => 'margin:0em;' )
			) .
			Xml::element( 'legend', null, wfMsg('powersearch-legend') ) .
			Xml::tags( 'h4', null, wfMsgExt( 'powersearch-ns', array( 'parseinline' ) ) ) .
			Xml::tags(
				'div',
				array( 'id' => 'mw-search-togglebox' ),
				Xml::label( wfMsg( 'powersearch-togglelabel' ), 'mw-search-togglelabel' ) .
					Xml::element(
						'input',
						array(
							'type'=>'button',
							'id' => 'mw-search-toggleall',
							'onclick' => 'mwToggleSearchCheckboxes("all");',
							'value' => wfMsg( 'powersearch-toggleall' )
						)
					) .
					Xml::element(
						'input',
						array(
							'type'=>'button',
							'id' => 'mw-search-togglenone',
							'onclick' => 'mwToggleSearchCheckboxes("none");',
							'value' => wfMsg( 'powersearch-togglenone' )
						)
					)
			) .
			Xml::element( 'div', array( 'class' => 'divider' ), '', false ) .
			$namespaceTables .
			Xml::element( 'div', array( 'class' => 'divider' ), '', false ) .
			$redirects .
			$hidden .
			Xml::closeElement( 'fieldset' );
	}


	protected function formHeader( $term, $resultsShown, $totalNum ) {
		global $wgContLang, $wgLang;

		/* Wikia change begin - @author: Macbre */
		$out = Xml::openElement( 'table', array( 'id'=>'mw-search-top-table', 'border'=>0, 'cellpadding'=>0, 'cellspacing'=>0 ) ) .
			Xml::openElement( 'tr' ) .
			Xml::openElement( 'td' ) . "\n"	.
			$this->shortDialog( $term ) .
			Xml::closeElement('td') .
			Xml::closeElement('tr') .
			Xml::closeElement('table');
		/* Wikia change end */

		$out .= Xml::openElement('div', array( 'class' =>  'mw-search-formheader' ) );

		$bareterm = $term;
		if( $this->startsWithImage( $term ) ) {
			// Deletes prefixes
			$bareterm = substr( $term, strpos( $term, ':' ) + 1 );
		}


		$profiles = $this->getSearchProfiles();

		// Outputs XML for Search Types
		$out .= Xml::openElement( 'div', array( 'class' => 'search-types' ) );
		$out .= Xml::openElement( 'ul' );
		foreach ( $profiles as $id => $profile ) {
			$tooltipParam = isset( $profile['namespace-messages'] ) ?
				$wgLang->commaList( $profile['namespace-messages'] ) : null;
			$out .= Xml::tags(
				'li',
				array(
					'class' => $this->active == $id ? 'current' : 'normal'
				),
				$this->makeSearchLink(
					$bareterm,
					$profile['namespaces'],
					wfMsg( $profile['message'] ),
					wfMsg( $profile['tooltip'], $tooltipParam ),
					isset( $profile['parameters'] ) ? $profile['parameters'] : array()
				)
			);
		}
		$out .= Xml::closeElement( 'ul' );
		$out .= Xml::closeElement('div') ;

		// Results-info
		if ( $resultsShown > 0 ) {
			if ( $totalNum > 0 ){
				$top = wfMsgExt( 'showingresultsheader', array( 'parseinline' ),
					$wgLang->formatNum( $this->offset + 1 ),
					$wgLang->formatNum( $this->offset + $resultsShown ),
					$wgLang->formatNum( $totalNum ),
					wfEscapeWikiText( $term ),
					$wgLang->formatNum( $resultsShown )
				);
			} elseif ( $resultsShown >= $this->limit ) {
				$top = wfShowingResults( $this->offset, $this->limit );
			} else {
				$top = wfShowingResultsNum( $this->offset, $this->limit, $resultsShown );
			}
			$out .= Xml::tags( 'div', array( 'class' => 'results-info' ),
				Xml::tags( 'ul', null, Xml::tags( 'li', null, $top ) )
			);
		}
		$out .= Xml::element( 'div', array( 'style' => 'clear:both' ), '', false );
		$out .= Xml::closeElement('div');

		// Adds hidden namespace fields
		if ( !$this->searchAdvanced ) {
			foreach( $this->namespaces as $ns ) {
				$out .= Xml::hidden( "ns{$ns}", '1' );
			}
		}

		return $out;
	}
	protected function makeSearchLink( $term, $namespaces, $label, $tooltip, $params=array() ) {
		$opt = $params;
		foreach( $namespaces as $n ) {
			$opt['ns' . $n] = 1;
		}
		$opt['redirs'] = $this->searchRedirects ? 1 : 0;

		$st = SpecialPage::getTitleFor( 'WikiaSearch' );
		$stParams = array_merge(
			array(
				'search' => $term,
				'fulltext' => wfMsg( 'search' )
			),
			$opt
		);

		return Xml::element(
			'a',
			array(
				'href' => $st->getLocalURL( $stParams ),
				'title' => $tooltip,
				'onmousedown' => 'mwSearchHeaderClick(this);',
				'onkeydown' => 'mwSearchHeaderClick(this);'),
			$label
		);
	}


	protected function shortDialog( $term ) {
		$searchTitle = SpecialPage::getTitleFor( 'WikiaSearch' );
		$searchable = SearchEngine::searchableNamespaces();
		// Keep redirect setting
		$out = Html::hidden( "redirs", (int)$this->searchRedirects ) . "\n";
		// Term box
		$out .= Html::input( 'query', $term, 'query', array(
			'id' => $this->searchAdvanced ? 'powerSearchText' : 'searchText',
			'size' => '50',
			#'autofocus' // Wikia - commented out due to BugId:4016
		) ) . "\n";

		$out .= Xml::submitButton( wfMsg( 'searchbutton' ) ) . "\n";

		// Wikia change (ADi) /begin
		wfRunHooks( 'SpecialSearchShortDialog', array( $term, &$out ) );
		// Wikia change (ADi) /end

		return $out . $this->didYouMeanHtml;
	}

    protected function getActiveTab($request)
    {
      if ($request->getVal('advanced')) {
	return 'advanced';
      }
      
      $namespaces = array_keys(SearchEngine::searchableNamespaces());
      $nsVals = array();

      foreach ($namespaces as $ns) {
	if ($val = $request->getVal('ns'.$ns)) {
	  $nsVals[] = $ns;
	} 
      }

      if (empty($nsVals)) {
	return 'default';
      }

      if ($nsVals == $namespaces) {
	return 'all';
      }

      if ($nsVals == array( NS_FILE )) {
	return 'images';
      }

      if ($nsVals == SearchEngine::helpNamespaces()) {
	return 'help';
      }

      if ($nsVals == SearchEngine::defaultNamespaces()) {
	return 'default';
      }

      return 'advanced';

    }

}