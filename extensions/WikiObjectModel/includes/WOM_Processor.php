<?php
/**
 * @author ning
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

/**
 * Static class for accessing public static functions to generate and execute semantic queries
 * and to serialise their results.
 */
class WOMProcessor {
	private static $isParsersRegistered = false;
	private static $parsers = array();
	private static $base_parser;

	private static function setupParsers() {
		if ( self::$isParsersRegistered ) return;

		global $wgOMParsers;
		foreach ( $wgOMParsers as $p ) {
			$parser = new $p();
			self::$parsers[$parser->getParserID()] = $parser;
		}
		self::$base_parser = self::$parsers[WOM_PARSER_ID_TEXT];

		self::$isParsersRegistered = true;
	}

	public static function getObjectParser( WikiObjectModel $obj ) {
		$fname = 'WikiObjectModel::getObjectParser (WOM)';
		wfProfileIn( $fname );

		if ( !self::$isParsersRegistered ) {
			self::setupParsers();
		}
		global $wgOMModelParserMapping;
		if ( isset( $wgOMModelParserMapping[$obj->getTypeID()] ) ) {
			$id = $wgOMModelParserMapping[$obj->getTypeID()];
			if ( isset( self::$parsers[$id] ) ) {
				wfProfileOut( $fname );
				return self::$parsers[$id];
			}
		}
		wfProfileOut( $fname );

		return self::$base_parser;
	}

	private static function applyObjID( WikiObjectModel $wom, WOMPageModel $root ) {
		$wom->setObjectID( $root->getNextId() );
		$root->addToPageObjectSet( $wom );
		if ( $wom instanceof WikiObjectModelCollection ) {
			foreach ( $wom->getObjects() as $obj ) {
				self::applyObjID( $obj, $root );
			}
		}
	}

	public static function parseToWOM( $text ) {
		$fname = 'WikiObjectModel::parseToWOM (WOM)';
		wfProfileIn( $fname );

		if ( !self::$isParsersRegistered ) {
			self::setupParsers();
		}

		$root = new WOMPageModel();
		self::parseNext( $text, $root, $root );
		self::parseParagraphs( $root );
		self::parseSentences( $root );
		self::applyObjID( $root, $root );
		wfProfileOut( $fname );
		return $root;
	}

	/**
	 * Special case, paragraphs and sentences are not standard wiki object
	 *
	 * @param WOMPageModel $rootObj
	 */
	private static function parseParagraphs( WikiObjectModelCollection $wom ) {
		global $wgOMParagraphObjectTypes;
		$in_paragraph = false;
		$new_objs = array();
		$paragraphObj = null;
		foreach ( $wom->getObjects() as $id => $obj ) {
			if ( in_array( $obj->getTypeID(), $wgOMParagraphObjectTypes ) ) {
				if ( !$in_paragraph ) {
					$paragraphObj = new WOMParagraphModel();
					$new_objs[] = $paragraphObj;
					$in_paragraph = true;
				}
				$paragraphObj->insertObject( $obj );
				// parse paragraph break
				if ( $obj->getTypeID() == WOM_TYPE_TEXT ) {
					$text = $obj->getWikiText();
					$offset = 0;
					$len = strlen( $text );
					// HTML tag <p> is not valid 'paragraph' syntax in WOM
					$r = preg_match_all( '/\n[ \t]*\n/', $text, $ms, PREG_SET_ORDER | PREG_OFFSET_CAPTURE );
					if ( $r ) {
						foreach ( $ms as $m ) {
							$end = $m[0][1] + strlen( $m[0][0] );
							$obj->setText( substr( $text, $offset, $m[0][1] - $offset ) );
							$offset = $end;
							$paragraphObj = new WOMParagraphModel();
							$new_objs[] = $paragraphObj;
							$obj = new WOMTextModel( substr( $text, $end ) );
							$paragraphObj->insertObject( $obj );
						}
					}
				}
			} else {
				$in_paragraph = false;
				$paragraphObj = null;

				if ( $obj->getTypeID() == WOM_TYPE_HTMLTAG ) {
					// special case, html tag
				} elseif ( $obj instanceof WikiObjectModelCollection ) {
					self::parseParagraphs( $obj );
				}
				$new_objs[] = $obj;
			}
		}

		$wom->reset();

		foreach ( $new_objs as $obj ) {
			$wom->insertObject( $obj );
		}
	}

	private static function parseSentences( WikiObjectModelCollection $wom ) {
		global $wgOMSentenceObjectTypes;
		$in_sentence = false;
		$new_objs = array();
		$sentenceObj = null;
		foreach ( $wom->getObjects() as $id => $obj ) {
			if ( in_array( $obj->getTypeID(), $wgOMSentenceObjectTypes ) ) {
				if ( !$in_sentence ) {
					$sentenceObj = new WOMSentenceModel();
					$new_objs[] = $sentenceObj;
					$in_sentence = true;
				}
				$sentenceObj->insertObject( $obj );
				// parse sentence break
				if ( $obj->getTypeID() == WOM_TYPE_TEXT ) {
					$text = $obj->getWikiText();
					$offset = 0;
					$len = strlen( $text );
					// FIXME: sentence algorithm here, for now, just think of
					// \n
					// [.?!]((['"]|'{2,6})?)<space>
					// shall think of other language, e.g., Chinese
					$r = preg_match_all( '/(\n[^\n])|(([\.!?](([\'"]|\'{2,6})?))([ \t]))/',
						$text, $ms, PREG_SET_ORDER | PREG_OFFSET_CAPTURE );
					if ( $r ) {
						foreach ( $ms as $m ) {
							if ( $m[1][1] >= 0 ) {
								$end = $m[0][1] + 1;
							} else {
								$end = $m[0][1] + strlen( $m[0][0] );
							}
							$obj->setText( substr( $text, $offset, $end - $offset ) );
							$offset = $end;
							if ( $end == $len ) break;
							$sentenceObj = new WOMSentenceModel();
							$new_objs[] = $sentenceObj;
							$obj = new WOMTextModel( substr( $text, $end ) );
							$sentenceObj->insertObject( $obj );
						}
					}
				}
			} else {
				$in_sentence = false;
				$sentenceObj = null;

				if ( $obj->getTypeID() == WOM_TYPE_HTMLTAG ) {
					// special case, html tag
				} elseif ( $obj instanceof WikiObjectModelCollection ) {
					self::parseSentences( $obj );
				}
				$new_objs[] = $obj;
			}
		}

		$wom->reset();

		foreach ( $new_objs as $obj ) {
			$wom->insertObject( $obj );
		}
	}

	private static function assemble( &$next_obj ) {
		$parentObj = $next_obj->getParent();
		$brother = $parentObj->getLastObject();

		if ( $next_obj->getTypeID() == WOM_TYPE_TEXT &&
			$brother != null && $brother->getTypeID() == WOM_TYPE_TEXT ) {
				// special case, merge text token to previous text node
				$brother->append( $next_obj->getWikiText() );
		} else {
			$parentObj->insertObject( $next_obj );
		}
	}

	private static function parseNext( $text, WikiObjectModelCollection $parentObj, WOMPageModel $rootObj, &$offset = 0 ) {
//		$fname = 'WikiObjectModel::parseNext (WOM)';
//		wfProfileIn( $fname );

		$len = strlen( $text );

		while ( $offset < $len ) {
			if ( self::getObjectParser( $parentObj ) != null ) {
				$objectClosed = self::getObjectParser( $parentObj )
					->isObjectClosed( $parentObj, $text, $offset );
				if ( $objectClosed !== false ) {
					$offset += $objectClosed;
//					wfProfileOut( $fname );
					return;
				}
			}

			$result = null;
			$parserId = self::getObjectParser( $parentObj )->getSubParserID( $parentObj );
			if ( $parserId == '' ) {
				$parserInstance = null;
				foreach ( self::$parsers as $parser ) {
					$parser_res = $parser->parseNext( $text, $parentObj, $offset );
					if ( $parser_res == null ) continue;
					if ( $parserInstance == null || $parser->subclassOf( $parserInstance ) ) {
						$parserInstance = $parser;
						$result = $parser_res;
					}
				}
				if ( $parserInstance == null ) {
					$parserInstance = self::$base_parser;
					$result = $parserInstance->parseNext( $text, $parentObj, $offset );
				}
			} else {
				$parserInstance = self::$parsers[$parserId];
				$result = $parserInstance->parseNext( $text, $parentObj, $offset );
				if ( $result == null ) {
					// FIXME: just omit current char, this will not fit for Wiki parser
					++ $offset;
					continue;
				}
			}

			$next_obj = $result['obj'];
			// just reparse
			if ( $next_obj->getParent() != null && $next_obj->getParent() != $parentObj ) {
//				wfProfileOut( $fname );
				return;
			}

			$offset += $result['len'];

			if ( $next_obj->getParent() == null ) {
				$next_obj->setParent( $parentObj );
			}

			self::assemble( $next_obj );

			if ( $next_obj->isCollection() && !( isset( $result['closed'] ) && $result['closed'] ) ) {
				$collection_start = $offset;
				$d = self::parseNext( $text, $next_obj, $rootObj, $offset );
				if ( $d == 100 && $parserInstance->isObjectClosed( $next_obj, $text, $offset ) === false ) {
					// rollback
					if ( ! ( $parentObj instanceof WOMPageModel ) ) {
						$p = self::getObjectParser( $parentObj );
						if ( $p != null && $p->isObjectClosed( $parentObj, $text, $offset ) === false ) {
							return $d;
						}
					}
					$parentObj->rollback();
					$offset = $collection_start - $result['len'];
					$result = self::$base_parser->parseNext( $text, $parentObj, $offset );
					$offset += $result['len'];
					$next_obj = $result['obj'];
					$next_obj->setParent( $parentObj );
					self::assemble( $next_obj );
				} else {
					$next_obj->updateOnNodeClosed();
				}
			}
		}
		// FIXME: just announce that we've reached the end of wiki text
		return 100;

//		wfProfileOut( $fname );
	}

/*
	public static function getTemplateEditor( $template_name, $form_name = null ) {
		$fname = 'WikiObjectModel::getTemplateEditor (WOM)';
		wfProfileIn( $fname );
		wfProfileOut( $fname );
		return $result;
	}

	public static function getTemplateFieldEditor( $template_name, $field ) {
		$fname = 'WikiObjectModel::getTemplateFieldEditor (WOM)';
		wfProfileIn( $fname );

		wfProfileOut( $fname );
		return array(
			'type' => ( is_array( $result ) ? $result[0] : $result ),
			'possible_values' => $possible_values,
			'is_list' => false,
		);
	}

	public static function getPropertyEditor( $property ) {
		$fname = 'WikiObjectModel::getPropertyEditor (WOM)';
		wfProfileIn( $fname );

		$proptitle = Title::makeTitleSafe( SMW_NS_PROPERTY, $property );
		if ( $proptitle === NULL ) {
			wfProfileOut( $fname );
			return null;
		}

		$property = SMWPropertyValue::makeUserProperty( $property );
		$store = smwfGetStore();
		if ( class_exists( 'SMWPropertyValue' ) ) {
			$allowed_values = $store->getPropertyValues( $proptitle, SMWPropertyValue::makeUserProperty( "Allows value" ) );
		} else {
			$allowed_values = $store->getSpecialValues( $proptitle, SMW_SP_POSSIBLE_VALUE );
		}
		$possible_values = array();
		foreach ( $allowed_values as $value ) {
			$possible_values[] = html_entity_decode( $value->getWikiValue() );
		}
		if ( count( $possible_values ) > 0 ) {
			$result = self::getSemanticEditor( 'enumeration' );
		} else {
			$result = self::getSemanticEditor( $property->getPropertyTypeID() );
		}

		wfProfileOut( $fname );
		return array(
			'type' => ( is_array( $result ) ? $result[0] : $result ),
			'possible_values' => $possible_values,
			'is_list' => false,
		);
	}

	private static function getSemanticEditor( $semantic_type_id ) {
		if ( $semantic_type_id == '_str' ||
			$semantic_type_id == '_num' ||
			$semantic_type_id == '_tel' ||
			$semantic_type_id == '_uri' ||
			$semantic_type_id == '_ema' ) {
				return array( 'text' );
		} elseif ( $semantic_type_id == '_txt' || $semantic_type_id == '_cod' ) {
			return array( 'textarea' );
		} elseif ( $semantic_type_id == '_boo' ) {
			return array( 'checkbox' );
		} elseif ( $semantic_type_id == '_dat' ) {
			return array( 'date', 'datetime', 'datetime with timezone', 'year' );
		} elseif ( $semantic_type_id == 'enumeration' ) {
			// not real type, from semantic allow value
			return array( 'dropdown', 'radiobutton' );
		} elseif ( $semantic_type_id == '_wpg' ) {
			return array( 'text' );
		} else { // blank or an unknown type
			// SMW 1.5
//			'_geo' => 'Geographic coordinate', // name of the geocoord type
//			'_tem' => 'Temperature',  // name of the temperature type
//			'_anu' => 'Annotation URI',  // name of the annotation URI type (OWL annotation property)
//			'_rec' => 'Record', // name of record data type
			return array( 'textarea', 'text' );
		}
	}
*/

	public static function getPageObject( $title, $rid = 0 ) {
		$fname = 'WikiObjectModel::getPageObject (WOM)';
		wfProfileIn( $fname );

		$revision = Revision::newFromTitle( $title, $rid );
		if ( $revision == null ) {
			throw new MWException( __METHOD__ . ": Page not exist '{$title} ({$rid})'" );
		}
		$content = $revision->getText();

		$wom = self::parseToWOM( $content );
		$wom->setTitle( $title );
		$wom->setRevisionID( $revision->getId() );

		wfProfileOut( $fname );

		return $wom;
	}

	public static function getPageDom( $title, $rid = 0 ) {
		$fname = 'WikiObjectModel::getObjIdByXPath (WOM)';
		wfProfileIn( $fname );

		$xml = self::getPageObject( $title, $rid )->toXML();
		$xObj = simplexml_load_string( $xml );

		wfProfileOut( $fname );
		return $xObj;
	}
	public static function getObjIdByXPath2( WOMPageModel $wom_obj, $xpath, $extra_msg = '' ) {
		$fname = 'WikiObjectModel::getObjIdByXPath2 (WOM)';
		wfProfileIn( $fname );

		$xml = $wom_obj->toXML();
		$xObj = simplexml_load_string( $xml );
		try {
			$objs = $xObj->xpath( $xpath );
		} catch ( Exception $e ) {
			throw new MWException( __METHOD__ . ": {$e->getMessage()}" );
		}

		$ret = array();
		if ( $objs ) {
			foreach ( $objs as $o ) {
				$ret[] = strval( $o['id'] );
			}
		} else {
			throw new MWException( __METHOD__ . ": XML element not found{$extra_msg}, xpath: {$xpath}" );
		}
		wfProfileOut( $fname );
		return $ret;
	}
	public static function getObjIdByXPath( $title, $xpath, $rid = 0 ) {
		$fname = 'WikiObjectModel::getObjIdByXPath (WOM)';
		wfProfileIn( $fname );

		$ret = self::getObjIdByXPath2( self::getPageObject( $title, $rid ), $xpath, " in {$title} ({$rid})" );

		wfProfileOut( $fname );
		return $ret;
	}

	public static function getSubObjectsByParentId( $title, $obj_id, $rid = 0 ) {
		$fname = 'WikiObjectModel::getSubPageObjectsByParentId (WOM)';
		wfProfileIn( $fname );

		$wom = self::getPageObject( $title, $rid );

		$obj = $wom->getObject( $obj_id );

		wfProfileOut( $fname );
		if ( $obj instanceof WikiObjectModelCollection )
			return $obj->getObjects();
		else
			return null;
	}

	private static function getPageObjectsByTypeID( $type_id, $title, $rid = 0 ) {
		$fname = 'WikiObjectModel::getPageObjectsByTypeID (WOM)';
		wfProfileIn( $fname );

		$wom = self::getPageObject( $title, $rid );

		$result = $wom->getObjectsByTypeID( $type_id );

		wfProfileOut( $fname );

		return $result;
	}

	public static function getPageTemplates( $title, $name = '', $rid = 0 ) {
		$fname = 'WikiObjectModel::getPageTemplates (WOM)';
		wfProfileIn( $fname );

		$result = self::getPageObjectsByTypeID(
			WOM_TYPE_TEMPLATE, $title, $rid );

		if ( $name == '' ) {
			$result2 = $result;
		} else {
			$result2 = array();
			foreach ( $result as $id => $obj ) {
				if ( $obj->getName() == $name ) {
					$result2[$id] = $obj;
				}
			}
		}

		wfProfileOut( $fname );

		return $result2;
	}

	public static function getPageCategories( $title, $rid = 0 ) {
		$fname = 'WikiObjectModel::getPageCategories (WOM)';
		wfProfileIn( $fname );

		$result = self::getPageObjectsByTypeID(
			WOM_TYPE_CATEGORY, $title, $rid );

		wfProfileOut( $fname );

		return $result;
	}

	public static function getPageLinks( $title, $rid = 0 ) {
		$fname = 'WikiObjectModel::getPageLinks (WOM)';
		wfProfileIn( $fname );

		$result = self::getPageObjectsByTypeID(
			WOM_TYPE_LINK, $title, $rid );

		wfProfileOut( $fname );

		return $result;
	}

	public static function getPageProperties( $title, $rid = 0 ) {
		$fname = 'WikiObjectModel::getPageProperties (WOM)';
		wfProfileIn( $fname );

		// do not return properties which are binding template fields, in current version
		$result = self::getPageObjectsByTypeID(
			WOM_TYPE_PROPERTY, $title, $rid );

		wfProfileOut( $fname );

		return $result;
	}

	public static function getParserFunctions( $title, $function_key = '', $rid = 0 ) {
		$fname = 'WikiObjectModel::getParserFunctions (WOM)';
		wfProfileIn( $fname );

		$result = self::getPageObjectsByTypeID(
			WOM_TYPE_PARSERFUNCTION, $title, $rid );

		if ( $function_key == '' ) {
			$result2 = $result;
		} else {
			$result2 = array();
			foreach ( $result as $id => $obj ) {
				if ( $obj->getFunctionKey() == $function_key ) {
					$result2[$id] = $obj;
				}
			}
		}

		wfProfileOut( $fname );

		return $result2;
	}

	public static function insertPageObject( $object, $title, $obj_id = '', $summary = '', $revision_id = 0, $force_update = true ) {
		$fname = 'WikiObjectModel::insertPageObject (WOM)';
		wfProfileIn( $fname );
		if ( $revision_id > 0 ) {
			$revision = Revision::newFromTitle( $title );
			$id = $revision->getId();
			if ( $id != $revision_id && !$force_update ) {
				throw new MWException( __METHOD__ . ": Page revision id does not match '{$title} ({$revision_id}) - {$id}'" );

				wfProfileOut( $fname );
				return;
			}
		}
		$wom = self::getPageObject( $title, $revision_id );
		$wom->insertPageObject( $object, $obj_id );

		// save to wiki
		$article = new Article( $title );
		$content = $wom->getWikiText();
		$article->doEdit( $content, $summary );

		wfProfileOut( $fname );
	}

	public static function appendPageObject( $object, $title, $obj_id = '', $summary = '', $revision_id = 0, $force_update = true ) {
		$fname = 'WikiObjectModel::appendPageObject (WOM)';
		wfProfileIn( $fname );
		if ( $revision_id > 0 ) {
			$revision = Revision::newFromTitle( $title );
			$id = $revision->getId();
			if ( $id != $revision_id && !$force_update ) {
				throw new MWException( __METHOD__ . ": Page revision id does not match '{$title} ({$revision_id}) - {$id}'" );

				wfProfileOut( $fname );
				return;
			}
		}
		$wom = self::getPageObject( $title, $revision_id );
		$parent = $wom->getObject( $obj_id );
		if ( !( $parent instanceof WikiObjectModelCollection ) ) {
			throw new MWException( __METHOD__ . ": Object is not a collection object '{$title} ({$revision_id}) - {$obj_id}'" );
			wfProfileOut( $fname );
			return;
		}
		$wom->appendChildObject( $object, $obj_id );

		// save to wiki
		$article = new Article( $title );
		$content = $wom->getWikiText();
		$article->doEdit( $content, $summary );

		wfProfileOut( $fname );
	}

	public static function updatePageObject( $object, $title, $obj_id, $summary = '', $revision_id = 0, $force_update = true ) {
		$fname = 'WikiObjectModel::updatePageObject (WOM)';
		wfProfileIn( $fname );
		if ( $revision_id > 0 ) {
			$revision = Revision::newFromTitle( $title );
			$id = $revision->getId();
			if ( $id != $revision_id && !$force_update ) {
				throw new MWException( __METHOD__ . ": Page revision id does not match '{$title} ({$revision_id}) - {$id}'" );

				wfProfileOut( $fname );
				return;
			}
		}
		$wom = self::getPageObject( $title, $revision_id );
		$wom->updatePageObject( $object, $obj_id );

		// save to wiki
		$article = new Article( $title );
		$content = $wom->getWikiText();
		$article->doEdit( $content, $summary );

		wfProfileOut( $fname );
	}

	public static function removePageObject( $title, $obj_id, $summary = '', $revision_id = 0, $force_update = true ) {
		$fname = 'WikiObjectModel::removePageObject (WOM)';
		wfProfileIn( $fname );
		if ( $revision_id > 0 ) {
			$revision = Revision::newFromTitle( $title );
			$id = $revision->getId();
			if ( $id != $revision_id && !$force_update ) {
				throw new MWException( __METHOD__ . ": Page revision id does not match '{$title} ({$revision_id}) - {$id}'" );

				wfProfileOut( $fname );
				return;
			}
		}
		$wom = self::getPageObject( $title, $revision_id );
		$wom->removePageObject( $obj_id );

		// save to wiki
		$article = new Article( $title );
		$content = $wom->getWikiText();
		$article->doEdit( $content, $summary );

		wfProfileOut( $fname );
	}

	public static function insertPageText( $text, $title, $obj_id = '', $summary = '', $revision_id = 0, $force_update = true ) {
		$fname = 'WikiObjectModel::insertPageText (WOM)';
		wfProfileIn( $fname );
		if ( $revision_id > 0 ) {
			$revision = Revision::newFromTitle( $title );
			$id = $revision->getId();
			if ( $id != $revision_id && !$force_update ) {
				throw new MWException( __METHOD__ . ": Page revision id does not match '{$title} ({$revision_id}) - {$id}'" );

				wfProfileOut( $fname );
				return;
			}
		}
		$wom = self::getPageObject( $title, $revision_id );
		$text = self::getValidText( $text, $wom->getObject( $obj_id )->getParent(), $wom );
		// no need to parse or merge object model but use text
		$wom->insertPageObject( new WOMTextModel( $text ), $obj_id );

		// save to wiki
		$article = new Article( $title );
		$content = $wom->getWikiText();
		$article->doEdit( $content, $summary );

		wfProfileOut( $fname );
	}

	public static function appendPageText( $text, $title, $obj_id = '', $summary = '', $revision_id = 0, $force_update = true ) {
		$fname = 'WikiObjectModel::appendPageText (WOM)';
		wfProfileIn( $fname );
		if ( $revision_id > 0 ) {
			$revision = Revision::newFromTitle( $title );
			$id = $revision->getId();
			if ( $id != $revision_id && !$force_update ) {
				throw new MWException( __METHOD__ . ": Page revision id does not match '{$title} ({$revision_id}) - {$id}'" );

				wfProfileOut( $fname );
				return;
			}
		}
		$wom = self::getPageObject( $title, $revision_id );
		$parent = $wom->getObject( $obj_id );
		if ( !( $parent instanceof WikiObjectModelCollection ) ) {
			throw new MWException( __METHOD__ . ": Object is not a collection object '{$title} ({$revision_id}) - {$obj_id}'" );
			wfProfileOut( $fname );
			return;
		}
		$text = self::getValidText( $text, $parent, $wom );
		// no need to parse or merge object model but use text
		$wom->appendChildObject( new WOMTextModel( $text ), $obj_id );

		// save to wiki
		$article = new Article( $title );
		$content = $wom->getWikiText();
		$article->doEdit( $content, $summary );

		wfProfileOut( $fname );
	}

	public static function updatePageText( $text, $title, $obj_id, $summary = '', $revision_id = 0, $force_update = true ) {
		$fname = 'WikiObjectModel::updatePageText (WOM)';
		wfProfileIn( $fname );
		if ( $revision_id > 0 ) {
			$revision = Revision::newFromTitle( $title );
			$id = $revision->getId();
			if ( $id != $revision_id && !$force_update ) {
				throw new MWException( __METHOD__ . ": Page revision id does not match '{$title} ({$revision_id}) - {$id}'" );

				wfProfileOut( $fname );
				return;
			}
		}
		$wom = self::getPageObject( $title, $revision_id );
		$text = self::getValidText( $text, $wom->getObject( $obj_id )->getParent(), $wom );
		// no need to parse or merge object model but use text
		$wom->updatePageObject( new WOMTextModel( $text ), $obj_id );

		// save to wiki
		$article = new Article( $title );
		$content = $wom->getWikiText();
		$article->doEdit( $content, $summary );

		wfProfileOut( $fname );
	}

	public static function getValidText( $text, $parent, $wom ) {
		if ( $parent != null ) {
			$parserId = self::getObjectParser( $parent )->getSubParserID( $parent );
			if ( $parserId != '' ) {
				$offset = 0;
				$p2 = clone ( $parent );
				$p2->reset();
				self::parseNext( $text, $p2, $wom, $offset );
				$text = '';
				foreach ( $p2->getObjects() as $obj ) {
					$text .= $obj->getWikiText();
				}
			}
		}
		return $text;
	}

	public static function getToc( $title, $rid = 0 ) {
		$fname = 'WikiObjectModel::getToc (WOM)';
		wfProfileIn( $fname );

		$wom = self::getPageObject( $title, $revision_id );

		$arr = array();
		self::saveToToc( $wom, $arr );

		wfProfileOut( $fname );

		return $arr;
	}

	private static function saveToToc( $wom, &$arr ) {
		foreach ( $wom->getObjects() as $obj ) {
			if ( $obj->getTypeID() == WOM_TYPE_SECTION ) {
				$sec = array( 'section' => $obj->getName(), 'sub' => array() );
				self::saveToToc( $obj, $sec['sub'] );
				$arr[] = $sec;
			}
		}
	}

	public static function objectsToWikiText( $objs ) {
		$fname = 'WikiObjectModel::objectsToWikiText (WOM)';
		wfProfileIn( $fname );

		$result = '';
		if ( is_array( $objs ) ) {
			foreach ( $objs as $obj ) {
				$result .= $obj->getWikiText();
			}
		} else {
			$result .= $objs->getWikiText();
		}

		wfProfileOut( $fname );

		return $result;
	}

	public static function objectToWikiText( $title, $obj_id, $rid = 0 ) {
		$fname = 'WikiObjectModel::objectToWikiText (WOM)';
		wfProfileIn( $fname );

		$wom = self::getPageObject( $title, $revision_id );

		$obj = $wom->getObject( $obj_id );

		// shall through error, not for now
		$result = isset( $obj ) ? $obj->getWikiText() : "";

		wfProfileOut( $fname );

		return $result;
	}
}
