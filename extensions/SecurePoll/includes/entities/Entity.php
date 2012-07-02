<?php

/**
 * There are three types of entity: elections, questions and options. The 
 * entity abstraction provides generic i18n support, allowing localised message
 * text to be attached to the entity, without introducing a dependency on the 
 * editability of the MediaWiki namespace. Users are only allowed to edit messages
 * for the elections that they administer.
 *
 * Entities also provide a persistent key/value pair interface for non-localised 
 * properties, and a descendant tree which is used to accelerate message loading.
 */
class SecurePoll_Entity {
	var $id;
	var $electionId;
	var $context;
	var $messagesLoaded = array();
	var $properties;

	/**
	 * Create an entity of the given type. This is typically called from the 
	 * child constructor.
	 * @param $context SecurePoll_Context
	 * @param $type string
	 * @param $info Associative array of entity info
	 */
	function __construct( $context, $type, $info ) {
		$this->context = $context;
		$this->type = $type;
		$this->id = isset( $info['id'] ) 
			? $info['id'] 
			: false;
		$this->electionId = isset( $info['election'] ) 
			? $info['election'] 
			: null;
	}

	/**
	 * Get the type of the entity.
	 * @return string
	 */
	function getType() {
		return $this->type;
	}

	/**
	 * Get a list of localisable message names. This is used to provide the 
	 * translate subpage with a list of messages to localise.
	 * @return Array
	 */
	function getMessageNames() {
		# STUB
		return array();
	}

	/**
	 * Get the entity ID.
	 */
	function getId() {
		return $this->id;
	}
	
	/**
	 * Get the parent election
	 * @return SecurePoll_Election
	 */
	public function getElection() {
		return $this->electionId !== null
			? $this->context->getElection( $this->electionId )
			: null;
	}

	/**
	 * Get the child entity objects. When the messages of an object are loaded,
	 * the messages of the children are loaded automatically, to reduce the 
	 * query count.
	 *
	 * @return array
	 */
	function getChildren() {
		return array();
	}

	/**
	 * Get all children, grandchildren, etc. in a single flat array of entity 
	 * objects.
	 * @return array
	 */
	function getDescendants() {
		$descendants = array();
		$children = $this->getChildren();
		foreach ( $children as $child ) {
			$descendants[] = $child;
			$descendants = array_merge( $descendants, $child->getDescendants() );
		}
		return $descendants;
	}

	/**
	 * Load messages for a given language. It's not generally necessary to call 
	 * this since getMessage() does it automatically.
	 */
	function loadMessages( $lang = false ) {
		if ( $lang === false ) {
			$lang = reset( $this->context->languages );
		}
		$ids = array( $this->getId() );
		foreach ( $this->getDescendants() as $child ) {
			$ids[] = $child->getId();
		}
		$this->context->getMessages( $lang, $ids );
		$this->messagesLoaded[$lang] = true;
	}

	/**
	 * Load the properties for the entity. It is not generally necessary to 
	 * call this function from another class since getProperty() does it 
	 * automatically.
	 */
	function loadProperties() {
		$properties = $this->context->getStore()->getProperties( array( $this->getId() ) );
		if ( count( $properties ) ) {
			$this->properties = reset( $properties );
		} else {
			$this->properties = array();
		}
	}

	/**
	 * Get a message, or false if the message does not exist. Does not use
	 * the fallback sequence.
	 *
	 * @param $name string
	 * @param $language string
	 */
	function getRawMessage( $name, $language ) {
		if ( empty( $this->messagesLoaded[$language] ) ) {
			$this->loadMessages( $language );
		}
		return $this->context->getMessage( $language, $this->getId(), $name );
	}

	/**
	 * Get a message, and go through the fallback sequence if it is not found.
	 * If the message is not found even after looking at all possible languages,
	 * a placeholder string is returned.
	 *
	 * @param $name string
	 */
	function getMessage( $name ) {
		foreach ( $this->context->languages as $language ) {
			if ( empty( $this->messagesLoaded[$language] ) ) {
				$this->loadMessages( $language );
			}
			$message = $this->getRawMessage( $name, $language );
			if ( $message !== false ) {
				return $message;
			}
		}
		return "[$name]";
	}

	/**
	 * Get a message, and interpret it as wikitext, converting it to HTML.
	 */
	function parseMessage( $name, $lineStart = true ) {
		global $wgParser, $wgTitle;
		$parserOptions = $this->context->getParserOptions();
		if ( $wgTitle ) {
			$title = $wgTitle;
		} else {
			$title = SpecialPage::getTitleFor( 'SecurePoll' );
		}
		$wikiText = $this->getMessage( $name );
		$out = $wgParser->parse( $wikiText, $title, $parserOptions, $lineStart );
		return $out->getText();
	}

	/**
	 * Get a message and convert it from wikitext to HTML, without <p> tags.
	 */
	function parseMessageInline( $name ) {
		return $this->parseMessage( $name, false );
	}

	/**
	 * Get a list of languages for which we have translations, for this entity 
	 * and its descendants.
	 */
	function getLangList() {
		$ids = array( $this->getId() );
		foreach ( $this->getDescendants() as $child ) {
			$ids[] = $child->getId();
		}
		return $this->context->getStore()->getLangList( $ids );
	}

	/**
	 * Get a property value. If it does not exist, the $default parameter
	 * is passed back.
	 * @param $name string
	 * @param $default mixed
	 */
	function getProperty( $name, $default = false ) {
		if ( $this->properties === null ) {
			$this->loadProperties();
		}
		if ( isset( $this->properties[$name] ) ) {
			return $this->properties[$name];
		} else {
			return $default;
		}
	}

	/**
	 * Get all defined properties as an associative array
	 */
	function getAllProperties() {
		if ( $this->properties === null ) {
			$this->loadProperties();
		}
		return $this->properties;
	}

	/**
	 * Get configuration XML. Overridden by most subclasses.
	 */
	function getConfXml( $params = array() ) {
		return "<{$this->type}>\n" .
			$this->getConfXmlEntityStuff( $params ) .
			"</{$this->type}>\n";
	}

	/**
	 * Get an XML snippet giving the messages and properties
	 */
	function getConfXmlEntityStuff( $params = array() ) {
		$s = Xml::element( 'id', array(), $this->getId() ) . "\n";
		$blacklist = $this->getPropertyDumpBlacklist( $params );
		foreach ( $this->getAllProperties() as $name => $value ) {
			if ( !in_array( $name, $blacklist ) ) {
				$s .= Xml::element( 'property', array( 'name' => $name ), $value ) . "\n";
			}
		}
		if ( isset( $params['langs'] ) ) {
			$langs = $params['langs'];
		} else {
			$langs = $this->context->languages;
		}
		foreach ( $this->getMessageNames() as $name ) {
			foreach ( $langs as $lang ) {
				$value = $this->getRawMessage( $name, $lang );
				if ( $value !== false ) {
					$s .= Xml::element( 
							'message', 
							array( 'name' => $name, 'lang' => $lang ),
							$value 
						) . "\n";
				}
			}
		}
		return $s;
	}

	/**
	 * Get property names which aren't included in an XML dump.
	 * Overloaded by Election.
	 */
	function getPropertyDumpBlacklist( $params = array() ) {
		return array();
	}

}
