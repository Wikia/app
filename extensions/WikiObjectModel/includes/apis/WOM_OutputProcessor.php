<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

global $wgHooks, $wgParser;
if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'WOMOutputProcessor::smwgWTregisterParserFunctions';
} else {
	if ( class_exists( 'StubObject' ) && !StubObject::isRealObject( $wgParser ) ) {
		$wgParser->_unstub();
	}
	WOMOutputProcessor::smwgWTregisterParserFunctions( $wgParser );
}

global $wgOMOutputHookedParserFunctions;
$wgOMOutputHookedParserFunctions = array(
	'ask',
	'sparql',
);

global $wgOMIP;
require_once( $wgOMIP . '/includes/apis/WOM_OM_QueryResult.php' );

class WOMOutputProcessor {
	static function smwfProcessSPARQLQueryParserFunctionGTP( &$parser ) {
		global $smwgWebserviceEndpoint;
		if ( !isset( $smwgWebserviceEndpoint ) ) return '';

		global $smwgIQRunningNumber;
		$smwgIQRunningNumber++;
		$params = func_get_args();
		array_shift( $params ); // we already know the $parser ...

		SMWSPARQLQueryProcessor::processFunctionParams( $params, $querystring, $params, $printouts );
		$query  = SMWSPARQLQueryProcessor::createQuery( $querystring, $params, SMWQueryProcessor::INLINE_QUERY, '', $printouts );

		if ( !( ( $query->querymode == SMWQuery::MODE_INSTANCES ) || ( $query->querymode == SMWQuery::MODE_NONE ) ) ) {
			return '';
		}
		self::prequery( $params, $printouts, $label, $wom_id );

		// source from SMWHalo, SMW_SPARQLQueryProcessor.php

		// Query routing allows extensions to provide alternative stores as data sources
		// The while feature is experimental and is not properly integrated with most of SMW's architecture. For instance, some query printers just fetch their own store.
		// / TODO: case-insensitive
		global $smwgQuerySources;

		$query->params = $params; // this is a hack

		if ( array_key_exists( "source", $params ) && array_key_exists( $params["source"], $smwgQuerySources ) ) {
			$store = new $smwgQuerySources[$params["source"]]();
		} else {
			$store = smwfGetStore(); // default store
		}

		$res = $store->getQueryResult( $query );

		if ( !is_array( $res ) ) {
			$qResults['tsc'] = $res;
		} else {
			$qResults = $res;
		}

		foreach ( $qResults as $source => $res ) {
			while ( $row = $res->getNext() ) {
				$firstcol = true;
				foreach ( $row as $field ) {
					$object = $field->getNextObject();
					$text = $object->getWikiValue();
					self::$queryProps[$wom_id][$label][] = $text;

					// get the first column only
					break;
				}
			}
		}

		return '';
	}
	private static function prequery( &$params, $printouts, &$label, &$wom_id ) {
		if ( isset( $params['mainlabel'] ) ) {
			$label = $params['mainlabel'];
			if ( $label == '-' ) {
				$pr = $printouts[0];
				$label = $pr->getLabel();
			}
		} else {
			$label = '{Query #' . self::$queryId . '}';
			self::$queryId ++;
		}

		if ( !isset( $params['limit'] ) ) {
			$params['limit'] = 20; // limit to 20 result by default
		}
		$wom_id = '';
		if ( isset( $params['wom_id'] ) ) {
			$wom_id = $params['wom_id'];
		}
	}
	static function smwfProcessInlineQueryParserFunctionGTP( &$parser ) {
		global $smwgQEnabled, $smwgIQRunningNumber;
		if ( $smwgQEnabled ) {
			$smwgIQRunningNumber++;
			$rawparams = func_get_args();
			array_shift( $rawparams ); // we already know the $parser ...

			SMWQueryProcessor::processFunctionParams( $rawparams, &$querystring, &$params, &$printouts );
			self::prequery( $params, $printouts, $label, $wom_id );

			$query  = SMWQueryProcessor::createQuery(
					$querystring,
					$params,
					SMWQueryProcessor::INLINE_QUERY,
					SMW_OUTPUT_WIKI,
					$printouts
				);
			$res = smwfGetStore()->getQueryResult( $query );

			while ( $row = $res->getNext() ) {
				$firstcol = true;
				foreach ( $row as $field ) {
					$object = $field->getNextObject();
					$text = $object->getWikiValue();
					self::$queryProps[$wom_id][$label][] = $text;

					// get the first column only
					break;
				}
			}
		}
		return '';
	}

	static function smwgWTregisterParserFunctions( &$parser ) {
		global $wgWOMOutputHooked;
		if ( $wgWOMOutputHooked === true ) {
			if (	defined( 'SMW_VERSION' ) ) {
				$parser->setFunctionHook( 'ask', 'WOMOutputProcessor::smwfProcessInlineQueryParserFunctionGTP' );
			}
			if (	defined( 'SMW_HALO_VERSION' ) ) {
				$parser->setFunctionHook( 'sparql', 'WOMOutputProcessor::smwfProcessSPARQLQueryParserFunctionGTP' );
			}
		}
		return true; // always return true, in order not to stop MW's hook processing!
	}

	private static function removeSubWOMIds( WikiObjectModelCollection $parent ) {
		foreach ( $parent->getObjects() as $wobj ) {
			$wobj->setObjectID( '' );
			if ( $wobj instanceof WikiObjectModelCollection ) {
				self::removeSubWOMIds( $wobj );
			}
		}
	}

	static $queryProps = null;
	static $queryId = 0;
	static function getOutputData( $title, $rid = 0 ) {
		// normal page
		global $wgTitle, $wgUser;
		$wgTitle = $title;
		$revision = Revision::newFromTitle( $title, $rid );
		if ( $revision === NULL ) {
			throw new MWException( __METHOD__ . ": Page not exist '{$page_name} ({$rid})'" );
		}
		$text = $revision->getText();
		$wom = WOMProcessor::parseToWOM( $text );

		global $wgOMOutputHookedParserFunctions;
		$pfs = $wom->getObjectsByTypeID( WOM_TYPE_PARSERFUNCTION );
		foreach ( $pfs as $id => $obj ) {
			self::removeSubWOMIds( $obj );
			foreach ( $wgOMOutputHookedParserFunctions as $function_key ) {
				if ( $obj->getFunctionKey() == $function_key ) {
					// add wom id to parser function, with specified parameter 'wom_id'
					$param = new WOMParameterModel( 'wom_id' );
					$pv = new WOMParamValueModel();
					$param->insertObject( $pv );
					$pv->insertObject( new WOMTextModel( $id ) );
					$obj->insertObject( $param );
				}
			}
		}
		// FIXME: template values may have object ids
		$tmpls = $wom->getObjectsByTypeID( WOM_TYPE_TEMPLATE );
		foreach ( $tmpls as $id => $obj ) {
			self::removeSubWOMIds( $obj );
		}

		global $wgParser, $wgOut, $wgWOMOutputHooked;
		$wgWOMOutputHooked = true;
		$options = ParserOptions::newFromUser( $wgUser );

		self::$queryProps = array();
		self::$queryId = 1;
		$wgParser->parse( $wom->getWikiText(), $title, $options );

		$output = SMWParseData::getSMWdata( $wgParser );

		if ( !isset( $output ) ) {
			$semdata = smwfGetStore()->getSemanticData( $title );
		} else {
			$semdata = $output;
		}

		$tmp_id = 0;
		// fill in semantic properties
		$properties = array();
		foreach ( $semdata->getProperties() as $property ) {
			$label = '';
			if ( !$property->isShown() ) { // showing this is not desired, hide
				continue;
			} elseif ( $property->isUserDefined() ) { // user defined property
				if ( version_compare ( SMW_VERSION, '1.6', '>=' ) ) {
					$label = $property->getLabel();
				} else {
					$property->setCaption( preg_replace( '/[ ]/u', '&nbsp;', $property->getWikiValue(), 2 ) );
					// / NOTE: the preg_replace is a slight hack to ensure that the left column does not get too narrow
					$label = $property->getWikiValue();
				}
			} else {
				if ( version_compare ( SMW_VERSION, '1.6', '>=' ) ) {
					$label = $property->getLabel();
				} else {
					if ( $property->isVisible() ) { // predefined property
						$label = $property->getWikiValue();
					} else { // predefined, internal property
						continue;
					}
				}
			}
			$properties[$label] = array();

			$propvalues = $semdata->getPropertyValues( $property );
			foreach ( $propvalues as $propvalue ) {
				if ( version_compare ( SMW_VERSION, '1.6', '>=' ) ) {
					if ( $propvalue->getDIType() == SMWDataItem::TYPE_ERROR ) continue;
					$properties[$label][$propvalue->getSerialization()] = false;
				} else {
					$properties[$label][$propvalue->getWikiValue()] = false;
				}
			}
		}
		$props = $wom->getObjectsByTypeID( WOM_TYPE_PROPERTY );
		foreach ( $props as $prop ) {
			$id = $prop->getObjectID();
			if ( $id == '' ) continue;
			$name = $prop->getPropertyName();
			$value = $prop->getPropertyValue();
			if ( !isset( $properties[$name][$value] ) ) {
				// remove category not match to output
				$wom->removePageObject( $id );
			} else {
				$properties[$name][$value] = true;
			}
		}
		foreach ( $properties as $name => $values ) {
			foreach ( $values as $val => $flag ) {
				if ( $flag !== true ) {
					$p = new WOMPropertyModel( $name, $val );
					$p->setObjectID( 'output' . ( $tmp_id ++ ) );
					$wom->insertObject( $p );
					$wom->addToPageObjectSet( $p );
				}
			}
		}

		// fill in ask query results
		foreach ( self::$queryProps as $wom_id => $queries ) {
			$query_res = new WOMQueryResult();
			if ( $wom_id != '' ) {
				$parent = $wom->getObject( $wom_id );
			} else {
				$parent = new WOMParserFunctionModel( 'ask' );
				$parent->setObjectID( 'output' . ( $tmp_id ++ ) );
				$wom->insertObject( $parent );
				$wom->addToPageObjectSet( $parent );
			}
			$parent->insertObject( $query_res );
			$query_res->setObjectID( 'output' . ( $tmp_id ++ ) );
			$wom->addToPageObjectSet( $query_res );
			foreach ( $queries as $label => $vals ) {
				$vals = array_unique( $vals );
				foreach ( $vals as $val ) {
					$query_res->insertObject( new WOMPropertyModel( $label, $val ) );
				}
			}
		}

		// fill in categories
		$categories = $title->getParentCategories();
		$cates = $wom->getObjectsByTypeID( WOM_TYPE_CATEGORY );
		foreach ( $cates as $cate ) {
			$id = $cate->getObjectID();
			if ( $id == '' ) continue;
			$name = Title::newFromText( $cate->getName(), NS_CATEGORY )->getFullText();
			if ( !isset( $categories[$name] ) ) {
				// remove category not match to output
				$wom->removePageObject( $id );
			} else {
				$categories[$name] = true;
			}
		}
		foreach ( $categories as $cate => $flag ) {
			if ( $flag !== true ) {
				$c = new WOMCategoryModel( Title::newFromText( $cate )->getText() );
				$c->setObjectID( 'output' . ( $tmp_id ++ ) );
				$wom->insertObject( $c );
				$wom->addToPageObjectSet( $c );
			}
		}

		return $wom;
	}
}
