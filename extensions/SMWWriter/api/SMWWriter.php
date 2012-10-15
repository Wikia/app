<?php
/**
 * The two classes in this file  are used to write and changes facts in the
 * wiki without having to change the text yourself, i.e. it manages the needed
 * text changes and thus encapsulates any intelligence needed for updating the
 * wiki text in order to achieve the requested change. It is a best effort API.
 * Since the task in general is really hard (i.e. only solvable with
 * human-levelintelligence) the API will not solve the request in all cases,
 * but it will do its best, and try to return useful information on why it
 * thinks it did not succeed. But due to the nature of the task even that may
 * be wrong.
 *
 * @file
 * @ingroup SMWWriter
 * @author Denny Vrandecic
 */

/**
 * Class for internally keeping and managing data about the requests. I would
 * prefer this to be an inner class, but PHP does not have those. It is just a
 * class used by SMWWriter and not meant to be used by the public.
 * Why was not SMWSemanticData used? The first version of this API (unreleased)
 * indeed did so, but then I noticed that I would need to extend it with too
 * many needed functionality. So I could either bloat up SMWSemanticData, or
 * create a data structure of my own here. Especially since it is planned in
 * the near future to further extend the data structure so that we do not have
 * to search for where a certain fact is stated (this can be saved alongside
 * the fact, I think, in order to speed up things) this would have extended
 * SMWSemanticData far too far.
 *
 * @ingroup SMWWriter
 * @author denny
 */
class SMWWriterData {

	/**
	 * The actual data.
	 *
	 * @var array of array of SMWDataValue (key on first array is strings with
	 * propertynames)
	 */
	private $data = array();

	/**
	 * Adds a single property value pair to the data. value may be null.
	 *
	 * @param SMWPropertyValue $property
	 * @param SMWDataValue $value
	 */
	public function addPropertyValue( SMWPropertyValue $property, SMWDataValue $value ) {
		$this->addPropertynameValue( $property->getWikiValue(), $value );
	}

	/**
	 * Adds a single property value pair to the data. Value may be null.
	 *
	 * @param string $propertyname Name of the property.
	 * @param SMWDataValue $value Value to be added
	 */
	private function addPropertynameValue( /* string */ $propertyname, SMWDataValue $value ) {
		if ( !array_key_exists( $propertyname, $this->data ) )
			$this->data[$propertyname] = array();
		if ( "_wpg" == $value->getTypeID() ) $value = $this->resolveRedirect( $value );
		$this->data[$propertyname][] = $value;
	}

	/**
	 * Removes a propertyname value pair from the given dataset. If it does not
	 * exist, nothing happens (spec. no exception is raised)
	 *
	 * @param string $propertyname The name of the property
	 * @param SMWDataValue $value The value to be removed
	 */
	public function removePropertynameValue( /* string */ $propertyname, SMWDataValue $value ) {
		if ( !array_key_exists( $propertyname, $this->data ) )
			return;
		if ( "_wpg" == $value->getTypeID() ) $value = $this->resolveRedirect( $value );
		$values = $this->getPropertyValues( $propertyname );
		$count = count( $values );
		$without = null;
		for ( $i = 0; $i < $count; $i++ )
			if ( $values[$i] != '' && $values[$i]->getHash() === $value->getHash() ) {
				unset( $this->data[$propertyname][$i] );
				break;
			}

		if ( count( $this->data[$propertyname] ) == 0 )
			unset( $this->data[$propertyname] );
	}

	/**
	 * Returns an array of strings with all the names of the properties
	 *
	 * @return array of strings With all propertynames
	 */
	public function getPropertynames() {
		return array_keys( $this->data );
	}

	/**
	 * Adds an existing SMWWriterData object's content to this SMWWriterData
	 *
	 * @param SMWWriterData $data to be added
	 */
	public function copy( SMWWriterData $data ) {
		$properties = $data->getPropertynames();
		foreach ( $properties as $property ) {
				$values = $data->getPropertyValues( $property );
				foreach ( $values as $value )
					$this->addPropertynameValue( $property, $value );
		}
	}

	/**
	 * Takes a SMWSemanticData and adds all its property - values to this
	 * SMWWriterData object.
	 *
	 * @param SMWSemanticData $data to be added
	 */
	public function copySemanticData( SMWSemanticData $data ) {
		$properties = $data->getProperties();
		foreach ( $properties as $property ) {
			// if ( $property->isUserDefined() ) { // TODO Rethink!
				$values = $data->getPropertyValues( $property );
				foreach ( $values as $value )
					$this->addPropertyValue( $property, $value );
			// } // TODO Rethink!
		}
	}

	/**
	 * Formats the content of this object into a SMWSemanticData object
	 *
	 * @param Title $title Title of the page this SMWWriterData refers to
	 * @return SMWSemanticData The conent of this SMWWriterData object as a
	 * SMWSemanticData object
	 */
	public function getSemanticData( Title $title ) {
		$result = new SMWSemanticData( SMWWikiPageValue::makePageFromTitle( $title ), 0 );
		$propertynames = $this->getPropertynames();
		foreach ( $propertynames as $propertyname ) {
			$property = SMWPropertyValue::makeUserProperty( $propertyname );
			$values = $this->getPropertyValues( $propertyname );
			foreach ( $values as $value ) {
				$result->addPropertyObjectValue( $property, $value );
			}
		}

		return $result;
	}

	/**
	 * Returns an array of SMWDataValue for the given property, or an empty
	 * array() if no such value exists. The property must be given by its name.
	 *
	 * @param string $propertyname name of the property requested
	 * @return array of SMWDataValue with all the values for the propery
	 */
	public function getPropertyValues( /* string */ $propertyname ) {
		if ( $propertyname instanceof SMWPropertyValue ) $propertyname = $propertyname->getWikiValue();
		if ( !array_key_exists( $propertyname, $this->data ) ) return array();
		return $this->data[$propertyname];
	}

	/**
	 * Checks if the current object contains the given property - value pair
	 *
	 * @param string $propertyname Name of the property
	 * @param SMWDataValue $value value to be checked. Value will be normalized
	 * @return boolean true if it contains the property value pair, false else
	 */
	public function contains( /* string */ $propertyname, SMWDataValue $value ) {
		if ( "_wpg" == $value->getTypeID() ) $value = $this->resolveRedirect( $value );
		$values = $this->getPropertyValues( $propertyname );
		foreach ( $values as $check )
			if ( $check->getHash() === $value->getHash() )
				return true;
		return false;
	}

	/**
	 * Returns a new SMWWriterData object where all proeprty value pairs that
	 * are in the argument $remove are removed from this object.
	 *
	 * @param SMWWriterData $remove the data that needs to be removed from this
	 * SMWWriterData object
	 * @return SMWWriterData new data object that is a copy of this one but has
	 * all the property value pairs removed
	 */
	public function remove( SMWWriterData $remove ) {
		$result = new SMWWriterData();

		$propertiesRemove = $remove->getPropertynames();
		$propertiesThis = $this->getPropertynames();

		foreach ( $propertiesThis as $property )
			if ( in_array( $property, $propertiesRemove ) ) {
				$valuesRemove = $remove->getPropertyValues( $property );
				$valuesThis = $this->getPropertyValues( $property );
				foreach ( $valuesThis as $value ) {
					$onlyconst = TRUE;
					foreach ( $valuesRemove as $check )
						if ( $value->getHash() === $check->getHash() )
							$onlyconst = FALSE;
					if ( $onlyconst )
						$result->addPropertynameValue( $property, $value );
				}
			} else {
				$valuesThis = $this->getPropertyValues( $property );
				foreach ( $valuesThis as $value )
					$result->addPropertynameValue( $property, $value );
			}

		return $result;
	}

	/**
	 * Resolves a redirect from a page, if any
	 *
	 * @param SMWWikiPageValue $value page to resolve
	 * @return SMWWikiPageValue resolved page
	 */
	public static function resolveRedirect( SMWWikiPageValue $value ) {
		$entity = smwfGetStore()->getSemanticData( $value->getTitle() );
		return $entity->getSubject();
	}
}

/**
 * Class for writing and changing facts in Semantic MediaWiki. The functions of
 * this class try their best, but there is no guarantuee at all that they may
 * succeed or not. All changes are done in the name of the current user.
 *
 * @ingroup SMWWriter
 * @author denny
 */
class SMWWriter {

	// Flags for the update call
	/** Try to change the fact within the text. Also change the text.*/
	const CHANGE_TEXT = 1;
	/** Ignore facts that are recognized as being not updateable when
	 *  considering errors or atomicity of updates */
	const IGNORE_CONSTANT = 2;
	/** Only perform the complete update, otherwise discard it. */
	const ATOMIC_CHANGE = 4;
	/** regard the edit as a minor one for the history */
	const EDIT_MINOR = 8;

	/**
	 * Contains the edit summary for a change.
	 * @var string Edit summary for the history
	 */
	var $editsummary = '';

	/** Page Object Model of the page to change */
	private $pom = null;

	/** Title of the page to change */
	private $title = null;

	/**
	 * @var SMWWriterData with all property value pairs that the API thinks it
	 * can change.
	 */
	private $updateable = null;
	/**
	 * @var SMWWriterData with all property value pairs that the API thinks the
	 * page currently has
	 */
	private $current = null;
	/**
	 * @var SMWWriterData with all property value pairs that the API thinks it
	 * can not change.
	 */
	private $fixed = null;

	/**
	 * @var SMWWriterData with all the normalized property value pairs that the
	 * API should remove
	 */
	private $remove = null;
	/**
	 * @var SMWWriterData with all the normalized property value pairs that the
	 * API should add
	 */
	private $add = null;

	/** The current state of collected errormessages. */
	private $error = '';

	/** If the remove object has a subject or not, i.e. if it is *** or not */
	private $nosubject = false;

	/** Flags that parametrize the calls to the API */
	private $flags = 0;

	/**
	 * Constructor. Requires the Title of the page on which to operate.
	 * Note that each new page will require a new SMWWriter object.
	 * @param Title $title Title of the page to edit
	 */
	public function __construct( Title $title ) {
		if ( !$title->exists() ) { $this->addError( "Title of page to change does not exist." ); return; }
		$article = new Article( $title );
		if ( !$article ) { $this->addError( "Article to change not found." ); return; }
		$this->title = $title;
	}

	/**
	 * Replaces the data in remove with the data in add.
	 *
	 * @param SMWSemanticData $remove Facts to be removed. If $remove is on a
	 * null title, no data will be removed. If it is a SMWSemanticData object
	 * with only the subject set but no properties given, all data of the
	 * subject will be removed and replaced with the newly added facts. If the
	 * object has properties, but the properties have a null value, all
	 * properties with a null value will loose all their values before the data
	 * in add will be added.
	 * @param SMWSemanticData $add Facts to be added.
	 * @param String $editsummary Text to be saved for edit summary
	 * @param Integer bitfield $flags 0 means no special flags,
	 * @return String if empty, the system thinks that everything went well.
	 * Otherwise a String explaining what the system thinks just happened.
	 * If a non-empty string is returned, the state of the wiki was not changed.
	 */
	public function update( SMWSemanticData $remove, SMWSemanticData $add, $editsummary, $flags = 0 ) {
		if ( !empty( $this->error ) ) return;

		if ( empty( $editsummary ) ) $editsummary = "Changed by calling SMWWriter::Update"; // TODO make this more intelligent
		$this->editsummary = $editsummary;
		$this->flags = $flags;

		if ( !$this->checkSubject( $remove->getSubject()->getTitle(), $add->getSubject()->getTitle() ) ) {
			$this->addError( "Not fitting subjects in add or remove." ); return;
		}

		$this->normalizeRequest( $remove, $add );

		if ( empty( $this->error ) ) $this->doUpdate();
	}

	/**
	 * Returns a SMWSemanticData object that contains all the property-value
	 * pairs that the API thinks can be changed and removed.
	 *
	 * @return SMWSemanticData Updateable data
	 */
	public function getUpdateable() {
		$this->initUpdateable();
		return $this->updateable->getSemanticData( $this->title );
	}

	/**
	 * Returns the current, accumulated error message.
	 *
	 * @return string The current error message
	 */
	public function getError() {
		return $this->error;
	}

	/**
	 * Adds a new error message. This should be a string, giving a sentence,
	 * that ends with a fullstop.
	 *
	 * @param $errormessage the errormessage to add
	 */
	private function addError( /* string */ $errormessage ) {
		$this->error = $this->error .= " " . $errormessage;
	}

	/**
	 * This function initalizes the class by finding all updateable facts and
	 * saving those in updateable
	 */
	private function initUpdateable() {

		if ( $this->updateable != null ) return;

		$article = new Article( $this->title );
		if ( !$article ) { $this->addError( "Article to change not found." ); return; }
		$articletext = $article->fetchContent();

		// FIXME make more sense out of this -- adds a closing new line. Seems
		// to be required by POM, otherwise POM dies.
		if ( "\n" != substr( $articletext, -1 ) ) $articletext .= "\n";

		global $IP;
		require_once( "$IP/extensions/PageObjectModel/POM.php" );

		// Parse the article text
		$this->pom = new POMPage( $articletext );

		$this->updateable = new SMWWriterData();

		// get all set facts
		if ( array_key_exists( '#set', $this->pom->templates ) )
			foreach ( array_keys( $this->pom->templates['#set'] ) as $key ) {
				$set = $this->pom->templates['#set'][$key];
				$count = $set->getParametersCount();
				for ( $i = 0; $i < $count; $i++ ) {
					$name = $set->getParameterName( $i );
					$item = $set->getParameterByNumber( $i );
					if ( !empty( $name ) && !empty( $item ) ) {
						$property = SMWPropertyValue::makeUserProperty( $name );
						$value = SMWDataValueFactory::newPropertyObjectValue( $property, $item );
						$this->updateable->addPropertyValue( $property, $value );
					}
				}
			}

		// get all text annotated facts
		if ( array_key_exists( 'links', $this->pom->c ) ) {
			foreach ( $this->pom->c['links'] as $link ) {
				$properties = $link->getProperties();
				$destination = $link->getDestination();
				foreach ( $properties as $property ) {
					$p = SMWPropertyValue::makeUserProperty( $property );
					$v = SMWDataValueFactory::newPropertyObjectValue( $p, $destination );
					$this->updateable->addPropertyValue( $p, $v );
				}
			}
		}

		// get all template declared facts
		foreach ( array_keys( $this->pom->templates ) as $name ) {
			if ( strpos( $name, "#" ) === FALSE ) {
				$templatetitle = Title::newFromText( $name, NS_TEMPLATE );
				if ( !$templatetitle->exists() ) continue;
				$templatearticle = new Article( $templatetitle );
				if ( !$templatearticle ) continue;
				$templatetext = $templatearticle->fetchContent();
				$tmplpom = new POMPage( $templatetext );
				if ( array_key_exists( '#declare', $tmplpom->templates ) ) {
					foreach ( $tmplpom->templates['#declare'] as $declaration ) {
						$count = $declaration->getParametersCount();
						for ( $i = 0; $i < $count; $i++ ) {
							$argument = $declaration->getParameterByNumber( $i );
							$property = $declaration->getParameterName( $i );
							if ( empty( $property ) )
								$property = $argument;
							foreach ( $this->pom->templates[$name] as $tmpl ) {
								$value = $tmpl->getParameter( $argument );
								if ( !is_null( $value ) ) {
									$p = SMWPropertyValue::makeUserProperty( $property );
									if ( $p->isValid() ) {
										$type = $p->getPropertyTypeID();
										if ( $type == "_wpg" ) {
											$matches = array();
											preg_match_all( "/\[\[([^\[\]]*)\]\]/", $value, $matches );
											$objects = $matches[1];
											if ( count( $objects ) == 0 ) {
												$v = SMWDataValueFactory::newPropertyObjectValue( $p, $value );
												$this->updateable->addPropertyValue( $p, $v );
											} else {
												foreach ( $objects as $object ) {
													$v = SMWDataValueFactory::newPropertyObjectValue( $p, $object );
													$this->updateable->addPropertyValue( $p, $v );
												}
											}
										} else {
											$v = SMWDataValueFactory::newPropertyObjectValue( $p, $value );
											$this->updateable->addPropertyValue( $p, $v );
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}

	/**
	 * This procedure iniializes the current data in the object.
	 */
	private function initCurrent() {
		if ( $this->current != null ) return;
		$this->current = new SMWWriterData();
		$data = smwfGetStore()->getSemanticData( $this->title );
		$this->current->copySemanticData( $data );
	}

	/**
	 * This procedure initializes the fixed data in the object, i.e. all
	 * current data that is not updateable. Also known as constant data.
	 */
	private function initFixed() {
		if ( $this->fixed != null ) return;
		$this->initCurrent();
		$this->initUpdateable();
		$this->fixed = $this->current->remove( $this->updateable );
	}

	/**
	 * Checks if the subject of the remove and add properties is actually the
	 * one this object is initialized with. If not, the return with a false,
	 * else with a true. Also it notices if the subject of add is actually
	 * empty, so that it used for *** kind of adds, i.e. nothing is being
	 * removed.
	 *
	 * @param Title $remove The title that facts are meant to be removed from
	 * @param Title $add The title that facts are meant to be added to
	 * @return boolean true if everything is OK
	 */
	private function checkSubject( Title $remove, Title $add ) {
		// if ( !$add->equals($this->title) ) return false; // TODO Rethink!
		if ( $remove->exists() ) {
			if ( !$remove->equals( $this->title ) ) return false;
		} else {
			$this->nosubject = true;
		}
		return true;
	}

	/**
	 * Takes the request and turns requests like ***, s** and sp* into actual
	 * remove and add requests which are saved in this objects remove and add
	 * value.
	 *
	 * @param SMWSemanticData $remove All the facts meant to be removed
	 * @param SMWSemanticData $add All the facts meant to be added
	 */
	private function normalizeRequest( SMWSemanticData $remove, SMWSemanticData $add ) {

		$this->initCurrent();
		$this->initUpdateable();
		$this->initFixed();

		// if remove = ***, then nothing needs to be removed
		if ( $this->nosubject ) {
			$this->remove = new SMWWriterData();
			$this->add = new SMWWriterData();
			$this->add->copySemanticData( $add );

			// for each spv in a :
			$propertiesAdd = $this->add->getPropertynames();
			foreach ( $propertiesAdd as $propertyname ) {
				$values = $this->add->getPropertyValues( $propertyname );
				foreach ( $values as $value ) {
				// if spv in current : a -= spv
				if ( $this->current->contains( $propertyname, $value ) )
					$this->add->removePropertynameValue( $propertyname, $value );
				}
			}
			return;
		}

		// rr = requested to remove and removable
		$rr = new SMWWriterData();
		// rc = requested to remove but constant
		$rc = new SMWWriterData();
		// rx = requested to remove but not existent
		$rx = new SMWWriterData();

		// if remove = s**
		if ( count( $remove->getProperties() ) == 0 ) {
			$rr->copy( $this->updateable );
			$rc->copy( $this->fixed );
		} else {
			$properties = $remove->getProperties();
			foreach ( $properties as $property ) {
				if ( !$property->isUserDefined() ) continue;
				$propertyname = $property->getWikiValue();
				$values = $remove->getPropertyValues( $property );
				// is sp*?
				$vals = $values;
				foreach ( $values as $value ) {
					if ( count( $values ) > 1 ) break;
					$hash = $value->getHash();
					if ( empty( $hash ) )
						$vals = $this->current->getPropertyValues( $property );
				}
				// and spo
				foreach ( $vals as $value )
					if ( $this->updateable->contains( $propertyname, $value ) )
						$rr->addPropertyValue( $property, $value );
					elseif ( $this->fixed->contains( $propertyname, $value ) )
						$rc->addPropertyValue( $property, $value );
					else
						$rx->addPropertyValue( $property, $value );
			}
		}

		// a = what to add
		$a = new SMWWriterData();
		$a->copySemanticData( $add );

		// if ATOM and rx not empty : raise error
		if ( ( $this->flags & SMWWriter::ATOMIC_CHANGE ) && ( count( $rx->getPropertynames() ) > 0 ) ) {
			$this->addError( "There is metadata that was asked to be removed, but does not exist." );
			return;
		}

		// for each spv in a :
		$propertiesAdd = $a->getPropertynames();
		foreach ( $propertiesAdd as $propertyname ) {
			$values = $a->getPropertyValues( $propertyname );
			foreach ( $values as $value ) {
				// if spv in rr : rr -= spv, a -= spv
				if ( $rr->contains( $propertyname, $value ) ) {
					$rr->removePropertynameValue( $propertyname, $value );
					$a->removePropertynameValue( $propertyname, $value );
				}
				// if spv in rc : rc -= spv, a -= spv
				if ( $rc->contains( $propertyname, $value ) ) {
					$rc->removePropertynameValue( $propertyname, $value );
					$a->removePropertynameValue( $propertyname, $value );
				}
				// if spv in current : a -= spv
				if ( $this->current->contains( $propertyname, $value ) )
					$a->removePropertynameValue( $propertyname, $value );
			}
		}


		// if ATOM and not CONSTIGNORE and rc not empty : raise error
		if ( ( $this->flags & SMWWriter::ATOMIC_CHANGE ) && !( $this->flags & SMWWriter::IGNORE_CONSTANT ) && ( count( $rc->getPropertynames() ) > 0 ) ) {
			$this->addError( "There is metadata that was asked to be removed, but cannot be removed." );
			return;
		}

		$this->add = $a;
		$this->remove = $rr;
	}

	/**
	 * Everything is set up. Do the actual update.
	 */
	private function doUpdate() {

		$rp = $this->remove->getPropertynames();
		$ap = $this->add->getPropertynames();

		// for each property only in remove :
		//   remove spv for that p
		$onlyinremove = array_diff( $rp, $ap );
		foreach ( $onlyinremove as $removeproperty )
			$this->removePropertyValues( $removeproperty, $this->remove->getPropertyValues( $removeproperty ) );

		// for each property only in add :
		//   add spv for that p
		$onlyinadd = array_diff( $ap, $rp );
		foreach ( $onlyinadd as $addproperty )
			$this->addPropertyValues( $addproperty, $this->add->getPropertyValues( $addproperty ) );

		// for each other property :
		//   replace removing v with adding v
		$inboth = array_intersect( $ap, $rp );
		foreach ( $inboth as $property )
			$this->updatePropertyValues( $property, $this->remove->getPropertyValues( $property ), $this->add->getPropertyValues( $property ) );

		if ( !empty( $this->error ) ) return;

		$articletext = $this->pom->asString();
		if ( $this->flags & SMWWriter::EDIT_MINOR )
			$editflags = EDIT_MINOR;
		else
			$editflags = 0;
		$article = new Article( $this->title );
		$article->doEdit( $articletext, $this->editsummary, $editflags );
	}

	/**
	 * Returns if $value is within $values
	 * @param array of SMWDataValue $values The haystack
	 * @param SMWDataValue $value The needle
	 * @return boolean true if inside, false if not
	 */
	private function in_values( /* array of SMWDataValue */ $values, SMWDataValue $value ) {
		if ( $value->getTypeID() == "_wpg" )
			$value = SMWWriterData::resolveRedirect( $value );
		foreach ( $values as $check )
			if ( $check->getHash() === $value->getHash() )
				return true;
		return false;
	}

	/**
	 * Removes $value from $values
	 * @param array of SMWDataValue $values The haystack
	 * @param SMWDataValue $value The needle
	 * @return array of SMWDataValue The new haystack
	 */
	private function remove_value( /* array of SMWDataValue */ $values, SMWDataValue $value ) {
		if ( $value->getTypeID() == "_wpg" )
			$value = SMWWriterData::resolveRedirect( $value );
		$count = count( $values );
		for ( $i = 0; $i < $count; $i++ )
			if ( $values[$i] != '' && $values[$i]->getHash() === $value->getHash() ) {
				unset( $values[$i] );
				$values = array_values( $values );
				return $values;
			}
	}

	/**
	 * Removes the properties value pairs from the article
	 *
	 * @param $propertyname string The name of the property where the values should
	 * be removed
	 * @param $values array of SMWWikiPageValue the values to be remove
	 */
	private function removePropertyValues( /* string */ $propertyname, /* array of SMWDataValue */ $values ) {
		$property = SMWPropertyValue::makeUserProperty( $propertyname );

		// look in the set facts
		if ( array_key_exists( '#set', $this->pom->templates ) )
			foreach ( array_keys( $this->pom->templates['#set'] ) as $key ) {
				$set = $this->pom->templates['#set'][$key];
				$count = $set->getParametersCount();
				$removeindices = array();
				for ( $i = 0; $i < $count; $i++ ) {
					$name = $set->getParameterName( $i );
					$setproperty = SMWPropertyValue::makeUserProperty( $name );
					if ( $setproperty->getHash() !== $property->getHash() ) continue;
					$item = $set->getParameterByNumber( $i );
					if ( !empty( $item ) ) {
						$value = SMWDataValueFactory::newPropertyObjectValue( $property, $item );
						if ( $this->in_values( $values, $value ) ) {
							array_push( $removeindices, $i );
							$values = $this->remove_value( $values, $value );
						}
					}
				}
				while ( !empty( $removeindices ) ) {
					$i = array_pop( $removeindices );
					$set->removeParameterByNumber( $i );
				}
				if ( $set->getParametersCount() < 2 )
					if ( ( ( $set->getParametersCount() == 1 ) && ( trim( $set->getParameterName( 0 ) ) === "" ) ) || ( $set->getParametersCount() == 0 ) )
						$set->hide();
				if ( count( $values ) == 0 ) return;
			}

		// look in the annotated links
		if ( array_key_exists( 'links', $this->pom->c ) ) {
			foreach ( $this->pom->c['links'] as $link ) {
				$properties = $link->getProperties();
				$destination = $link->getDestination();
				$count = count( $properties );
				for ( $i = 0; $i < $count; $i++ ) {
					$p = SMWPropertyValue::makeUserProperty( $properties[$i] );
					if ( $p->getHash() !== $property->getHash() ) continue;
					$v = SMWDataValueFactory::newPropertyObjectValue( $p, $destination );
					if ( $this->in_values( $values, $v ) ) {
						$link->removePropertyByNumber( $i );
						$values = $this->remove_value( $values, $v );
					}
				}
				if ( count( $values ) == 0 ) return;
			}
		}

		// looking for the facts in templates
		foreach ( array_keys( $this->pom->templates ) as $name ) {
			if ( strpos( $name, "#" ) === FALSE ) {
				$templatetitle = Title::newFromText( $name, NS_TEMPLATE );
				if ( !$templatetitle->exists() ) continue;
				$templatearticle = new Article( $templatetitle );
				if ( !$templatearticle ) continue;
				$templatetext = $templatearticle->fetchContent();
				$tmplpom = new POMPage( $templatetext );
				if ( array_key_exists( '#declare', $tmplpom->templates ) ) {
					foreach ( $tmplpom->templates['#declare'] as $declaration ) {
						$count = $declaration->getParametersCount();
						for ( $i = 0; $i < $count; $i++ ) {
							$argument = $declaration->getParameterByNumber( $i );
							$templateproperty = $declaration->getParameterName( $i );
							if ( empty( $templateproperty ) )
								$templateproperty = $argument;
							$p = SMWPropertyValue::makeUserProperty( $templateproperty );
							if ( $p->getHash() !== $property->getHash() ) continue;
							foreach ( $this->pom->templates[$name] as $tmpl ) {
								$value = $tmpl->getParameter( $argument );
								if ( !is_null( $value ) ) {
									if ( $p->isValid() ) {
										$type = $p->getPropertyTypeID();
										if ( $type == "_wpg" ) {
											$matches = array();
											preg_match_all( "/\[\[([^\[\]]*)\]\]/", $value, $matches );
											$objects = $matches[1];
											if ( count( $objects ) == 0 ) {
												$v = SMWDataValueFactory::newPropertyObjectValue( $p, $value );
												if ( $this->in_values( $values, $v ) ) {
													$i = $tmpl->getNumberByName( $argument );
													$tmpl->removeParameterByNumber( $i );
													$values = $this->remove_value( $values, $v );
												}
											} else {
												foreach ( $objects as $object ) {
													// TODO This is a very stupid way to do it. Actually this
													// needs to be thoroughly rethought.
													$v = SMWDataValueFactory::newPropertyObjectValue( $p, $object );
													if ( $this->in_values( $values, $v ) ) {
														$text = "[[" . $object . "]]";
														$value = str_replace( $text, "", $value );
														if ( trim( $value ) === "" ) {
															$i = $tmpl->getNumberByName( $argument );
															$tmpl->removeParameterByNumber( $i );
														} else {
															$tmpl->setParameter( $argument, $value );
														}
														$values = $this->remove_value( $values, $v );
													}
												}
											}
										} else {
											$v = SMWDataValueFactory::newPropertyObjectValue( $p, $value );
											if ( $this->in_values( $values, $v ) ) {
												$i = $tmpl->getNumberByName( $argument );
												$tmpl->removeParameterByNumber( $i );
												$values = $this->remove_value( $values, $v );
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}


	/**
	 * Adds the properties value pairs to the article
	 *
	 * @param $propertyname string The name of the property where the values
	 * should be added
	 * @param $values array of SMWWikiPageValue the values to be added
	 */
	private function addPropertyValues( /* string */ $propertyname, /* array of SMWDataValue */ $values ) {
		$property = SMWPropertyValue::makeUserProperty( $propertyname );

		// What about existing links? Adding annotations to existing links
		// though is a bad idea, I think, because it will not be able to tell
		// if this is the right place to add it, think of the following example:
		// A was born in [[Moscow]] and he also died in [[Moscow]].
		// Adding the annotation [[place of birth::Moscow]] is OK with the first,
		// but not with the second sentence. And this can only be done with
		// a system that understands the sentence, and thus would make the whole
		// idea of SMW somehow superfluous :) -- denny

		// We first check if there is a fitting template where we can add the
		// missing values
		foreach ( array_keys( $this->pom->templates ) as $name ) {
			if ( strpos( $name, "#" ) === FALSE ) {
				$templatetitle = Title::newFromText( $name, NS_TEMPLATE );
				if ( !$templatetitle->exists() ) continue;
				$templatearticle = new Article( $templatetitle );
				if ( !$templatearticle ) continue;
				$templatetext = $templatearticle->fetchContent();
				$tmplpom = new POMPage( $templatetext );
				if ( array_key_exists( '#declare', $tmplpom->templates ) ) {
					foreach ( $tmplpom->templates['#declare'] as $declaration ) {
						$count = $declaration->getParametersCount();
						for ( $i = 0; $i < $count; $i++ ) {
							$argument = $declaration->getParameterByNumber( $i );
							$templateproperty = $declaration->getParameterName( $i );
							if ( empty( $templateproperty ) )
								$templateproperty = $argument;
								$p = SMWPropertyValue::makeUserProperty( $templateproperty );
							if ( $p->getHash() !== $property->getHash() ) continue;
							foreach ( $this->pom->templates[$name] as $tmpl ) {
								$value = $tmpl->getParameter( $argument );
								if ( !is_null( $value ) ) continue;
								if ( count( $values ) == 0 ) break;
								$value = array_pop( $values );
								$tmpl->setParameter( $argument, $value->getWikiValue() );
							}
						}
					}
				}
			}
		}

		$set = null;
		// if there is no #set yet, then add one
		if ( !array_key_exists( '#set', $this->pom->templates ) ) {
			$set = new POMTemplate( "{{#set:\n}}" );
			$this->pom->addChild( $set );
		} else {
			// grab the first set and add all the stated facts
			$set = $this->pom->templates['#set'][0];
		}



		foreach ( $values as $value )
			$set->addParameter( $propertyname, $value->getWikiValue() . "\n" );

		if ( $set->hidden() ) $set->unhide();
	}

	/**
	 * Changes the properties value pairs in the article
	 *
	 * @param $propertyname string The name of the property to update
	 * @param $remove array of SMWWikiPageValue the values to be removed
	 * @param $add array of SMWWikiPageValue the values to be added
	 */
	private function updatePropertyValues( /* string */ $propertyname, /* array of SMWDataValue */ $remove, /* array of SMWDataValue */ $add ) {
		// TODO Really, this is not how it should be done, but much more clever.
		// It should rather be like: find the place where the annotation is,
		// check if this is one of the ones to be removed, and replace it with
		// the values to be added instead of doing this quick and dirty approach

		$this->removePropertyValues( $propertyname, $remove );
		$this->addPropertyValues( $propertyname, $add );
	}
}