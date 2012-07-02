<?php

class APCCacheMode {
	protected $opts, $title;
	protected $userMode = false;
	protected $fieldKey;

	public function __construct( FormOptions $opts, Title $title ) {
		$this->opts = $opts;
		$this->title = $title;
		$this->userMode = $opts->getValue( 'mode' ) === SpecialAPC::MODE_USER_CACHE;
		$this->fieldKey = $this->userMode ? 'info' : ( ini_get( 'apc.stat' ) ? 'inode' : 'filename' );
	}

	protected $scopes = array(
		'A' => 'cache_list',
		'D' => 'deleted_list'
	);

	protected function displayObject( $object ) {
		global $wgLang;

		$cache = apc_cache_info( $this->userMode ? 'user' : 'opcode' );

		$s =
			Xml::openElement( 'div', array( 'class' => 'mw-apc-listing' ) ) .
			Xml::openElement( 'table' ) . Xml::openElement( 'tbody' ) .
			Xml::openElement( 'tr' ) .
				Xml::element( 'th', null, wfMsg( 'viewapc-display-attribute' ) ) .
				Xml::element( 'th', null, wfMsg( 'viewapc-display-value' ) ) .
			Xml::closeElement( 'tr' );

		$r = 1;
		foreach ( $this->scopes as $list ) {
			foreach ( $cache[$list] as $entry ) {
				if ( md5( $entry[$this->fieldKey] ) !== $object ) continue;

				$size = 0;
				foreach ( $entry as $key => $value ) {
					switch ( $key ) {
						case 'num_hits':
							$value = $wgLang->formatNum( $value ) .
								$wgLang->formatNum( sprintf( " (%.2f%%)", $value * 100 / $cache['num_hits'] ) );
							break;
						case 'deletion_time':
							$value = $this->formatValue( $key, $value );
							if ( !$value ) {
								$value = wfMsg( 'viewapc-display-no-delete' );
								break;
							}
						case 'mem_size':
							$size = $value;
						default:
							$value = $this->formatValue( $key, $value );
					}

					$s .= APCUtils::tableRow( $r = 1 - $r,
						wfMsgHtml( 'viewapc-display-' . $key ),
						htmlspecialchars( $value ) );

				}

				if ( $this->userMode ) {
					if ( $size > 1024 * 1024 ) {
						$s .= APCUtils::tableRow( $r = 1 - $r,
						wfMsgHtml( 'viewapc-display-stored-value' ),
						wfMsgExt( 'viewapc-display-too-big', 'parseinline' ) );
					} else {
						$value = var_export( apc_fetch( $entry[$this->fieldKey] ), true );
						$s .= APCUtils::tableRow( $r = 1 - $r,
							wfMsgHtml( 'viewapc-display-stored-value' ),
							Xml::element( 'pre', null, $value ) );
					}
				}
			}
		}

		$s .= '</tbody></table></div>';
		return $s;
	}

	// sortable table header in "scripts for this host" view
	protected function sortHeader( $title, $overrides ) {
		$changed = $this->opts->getChangedValues();
		$target = $this->title->getLocalURL( wfArrayToCGI( $overrides, $changed ) );
		return Xml::tags( 'a', array( 'href' => $target ), $title );
	}

	protected function formatValue( $type, $value ) {
		global $wgLang;
		switch ( $type ) {
			case 'deletion_time':
				if ( !$value ) {
					$value = false; break;
				}
			case 'mtime':
			case 'creation_time':
			case 'access_time':
				$value = $wgLang->timeanddate( $value );
				break;
			case 'ref_count':
			case 'num_hits':
				$value = $wgLang->formatNum( $value );
				break;
			case 'mem_size':
				$value = $wgLang->formatSize( $value );
				break;
			case 'ttl':
				$value = $wgLang->formatTimePeriod( $value );
				break;
			case 'type':
				$value = wfMsg( 'viewapc-display-type-' . $value );
				break;
		}
		return $value;
	}

	public function cacheView() {
		global $wgOut, $wgLang;

		$object = $this->opts->getValue( 'display' );
		if ( $object ) {
			$wgOut->addHTML( $this->displayObject( $object ) );
			return;
		}

		$wgOut->addHTML( $this->options() );
		$wgOut->addHTML( '<div><table><tbody><tr>' );

		$fields = array( 'name', 'hits', 'size', 'accessed', 'modified', 'created' );
		if ( $this->userMode ) $fields[] = 'timeout';
		$fields[] = 'deleted';

		$fieldKeys = array(
			'name' => $this->userMode ? 'info' : 'filename',
			'hits' => 'num_hits',
			'size' => 'mem_size',
			'accessed' => 'access_time',
			'modified' => 'mtime',
			'created'  => 'creation_time',
			'timeout' => 'ttl',
			'deleted' => 'deletion_time',
		);

		$scope = $this->opts->getValue( 'scope' );
		$sort = $this->opts->getValue( 'sort' );
		$sortdir = $this->opts->getValue( 'sortdir' );
		$limit = $this->opts->getValue( 'limit' );
		$offset = $this->opts->getValue( 'offset' );
		$search = $this->opts->getValue( 'searchi' );

		foreach ( $fields as $field ) {
			$extra = array();
			if ( $sort === $field ) {
				$extra = array( 'sortdir' => 1 - $sortdir );
			}

			$wgOut->addHTML(
				Xml::tags( 'th', null, $this->sortHeader(
					wfMsgHtml( 'viewapc-ls-header-' . $field ),
					array( 'sort' => $field ) + $extra ) )
			);
		}

		$wgOut->addHTML( '</tr>' );

		$cache = apc_cache_info( $this->userMode ? 'user' : 'opcode' );
		$list = array();
		if ( $scope === 'active' || $scope === 'both' ) {
			foreach ( $cache['cache_list'] as $entry ) {
				if ( $search && stripos( $entry[$fieldKeys['name']], $search ) === false ) continue;
				$sortValue = sprintf( '%015d-', $entry[$fieldKeys[$sort]] );
				$list[$sortValue . $entry[$fieldKeys['name']]] = $entry;
			}
		}

		if ( $scope === 'deleted' || $scope === 'both' ) {
			foreach ( $cache['deleted_list'] as $entry ) {
				if ( $search && stripos( $entry[$fieldKeys['name']], $search ) === false ) continue;
				$sortValue = sprintf( '%015d-', $entry[$fieldKeys[$sort]] );
				$list[$sortValue . $entry[$fieldKeys['name']]] = $entry;
			}
		}

		$sortdir ? krsort( $list ) : ksort( $list );

		$i = 0;
		if ( count( $list ) ) {
			$r = 1;

			foreach ( $list as $name => $entry ) {
				if ( $limit === $i++ ) break;
				$wgOut->addHTML(
					Xml::openElement( 'tr', array( 'class' => 'mw-apc-tr-' . ( $r = 1 - $r ) ) )
				);

				foreach ( $fields as $field ) {
					$index = $fieldKeys[$field];
					if ( $field === 'name' ) {
						if ( !$this->userMode ) {
							$pos = strrpos( $entry[$index], '/' );
							if ( $pos !== false ) $value = substr( $entry[$index], $pos + 1 );
						} else {
							$value = $entry[$index];
						}
						$value = $this->sortHeader( htmlspecialchars( $value ), array( 'display' => md5( $entry[$this->fieldKey] ) ) );
					} elseif ( $field === 'deleted' && $this->userMode && !$entry[$index] ) {
						$value = $this->sortHeader(
							wfMsgHtml( 'viewapc-ls-delete' ),
							array( 'delete' => $entry[$this->fieldKey] )
						);
					} else {
						$value = $this->formatValue( $index, $entry[$index] );
					}

					$wgOut->addHTML( Xml::tags( 'td', null, $value ) );
				}

				$wgOut->addHTML( '</tr>' );
			}
		}

		if ( $i < count( $list ) ) {
			$left = $wgLang->formatNum( count( $list ) - ( $i + $offset ) );
			$wgOut->addHTML(
				Xml::tags( 'tr', array( 'colspan' => count( $fields ) ),
					Xml::tags( 'td', null, $this->sortHeader(
						wfMsgExt( 'viewapc-ls-more', 'parseinline', $left ),
						array( 'offset' => $offset + $limit ) ) ) )
				);
		} elseif ( !count( $list ) ) {
			$wgOut->addHTML(
				Xml::tags( 'tr', array( 'colspan' => count( $fields ) ),
					Xml::tags( 'td', null, wfMsgExt( 'viewapc-ls-nodata', 'parseinline' ) ) )
				);
		}

		$wgOut->addHTML( '</tbody></table></div>' );
	}

	protected function options() {
		global $wgLang, $wgScript;

		$s =
			Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', null, wfMsg( 'viewapc-ls-options-legend' ) ) .
			Xml::openElement( 'form', array( 'action' => $wgScript ) );

		$s .= Html::Hidden( 'title', $this->title->getPrefixedText() );

		$options = array();
		$scope = $this->opts->consumeValue( 'scope' );
		$scopeOptions = array( 'active', 'deleted', 'both' );
		foreach ( $scopeOptions as $name ) {
			$options[] = Xml::option( wfMsg( 'viewapc-ls-scope-' . $name ), $name, $scope === $name );
		}
		$scopeSelector = Xml::tags( 'select', array( 'name' => 'scope' ), implode( "\n", $options ) );

		$options = array();
		$sort = $this->opts->consumeValue( 'sort' );
		$sortOptions = array( 'hits', 'size', 'name', 'accessed', 'modified', 'created', 'deleted' );
		if ( $this->userMode ) $sortOptions[] = 'timeout';
		foreach ( $sortOptions as $name ) {
			$options[] = Xml::option( wfMsg( 'viewapc-ls-sort-' . $name ), $name, $sort === $name );
		}
		$sortSelector = Xml::tags( 'select', array( 'name' => 'sort' ), implode( "\n", $options ) );

		$options = array();
		$sortdir = $this->opts->consumeValue( 'sortdir' );
		$options[] = Xml::option( wfMsg( 'ascending_abbrev' ), 0, !$sortdir );
		$options[] = Xml::option( wfMsg( 'descending_abbrev' ), 1, $sortdir );
		$sortdirSelector =  Xml::tags( 'select', array( 'name' => 'sortdir' ), implode( "\n", $options ) );


		$options = array();
		$limit = $this->opts->consumeValue( 'limit' );
		$limitOptions = array( 10, 20, 50, 150, 200, 500, $limit );
		sort( $limitOptions );
		foreach ( $limitOptions as $name ) {
			$options[] = Xml::option( $wgLang->formatNum( $name ), $name, $limit === $name );
		}
		$options[] = Xml::option( wfMsg( 'viewapc-ls-limit-none' ), 0, $limit === $name );
		$limitSelector = Xml::tags( 'select', array( 'name' => 'limit' ), implode( "\n", $options ) );


		$searchBox = Xml::input( 'searchi', 25, $this->opts->consumeValue( 'searchi' ) );
		$submit = Xml::submitButton( wfMsg( 'viewapc-ls-submit' ) );

		foreach ( $this->opts->getUnconsumedValues() as $key => $value ) {
			$s .= Html::Hidden( $key, $value );
		}

		$s .= wfMsgHtml( 'viewapc-ls-options', $scopeSelector, $sortSelector,
			$sortdirSelector, $limitSelector, $searchBox, $submit );
		$s .= '</form></fieldset><br />';

		return $s;
	}
}
