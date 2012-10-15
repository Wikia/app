<?php
/**
 * Class that enhances Title with stuff related to message groups
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2011-2012 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Class for pointing to messages, like Title class is for titles.
 * @since 2011-03-13
 */
class MessageHandle {
	/// @var Title
	protected $title = null;
	/// @var String
	protected $key = null;
	/// @var String
	protected $code = null;
	/// @var String
	protected $groupIds = null;
	/// @var MessageGroup
	protected $group = false;

	public function __construct( Title $title ) {
		$this->title = $title;
	}

	/**
	 * Check if a title is in a message namespace.
	 * @return bool If title is in a message namespace.
	 */
	public function isMessageNamespace() {
		global $wgTranslateMessageNamespaces;
		$namespace = $this->getTitle()->getNamespace();
		return in_array( $namespace, $wgTranslateMessageNamespaces );
	}

	/**
	 * @return Array of the message and the language
	 */
	public function figureMessage() {
		if ( $this->key === null ) {
			$title = $this->getTitle();
			// Check if this is a valid message first
			$ns = $title->getNamespace();
			$text = $title->getDBkey();
			$known = TranslateUtils::messageKeyToGroups( $ns, $text );

			$pos = strrpos( $text, '/' );
			if ( $known || $pos === false ) {
				$this->code = '';
				$this->key = $text;
			} else {
				$this->code = substr( $text, $pos + 1 );
				$this->key = substr( $text, 0, $pos );
			}
		}
		return array( $this->key, $this->code );
	}

	/**
	 * @return String
	 */
	public function getKey() {
		$this->figureMessage();
		return $this->key;
	}

	/**
	 * @return String
	 */
	public function getCode() {
		$this->figureMessage();
		return $this->code;
	}

	/**
	 * Determine whether the current handle is for message documentation.
	 * @return bool
	 */
	public function isDoc() {
		global $wgTranslateDocumentationLanguageCode;
		return $this->getCode() === $wgTranslateDocumentationLanguageCode;
	}

	/**
	 * Determine whether the current handle is for page translation feature.
	 * @return bool
	 */
	public function isPageTranslation() {
		return $this->getTitle()->getNamespace() == NS_TRANSLATIONS;
	}

	public function getGroupIds() {
		if ( $this->groupIds === null ) {
			$this->groupIds = TranslateUtils::messageKeyToGroups( $this->getTitle()->getNamespace(), $this->getKey() );
		}
		return $this->groupIds;
	}

	/**
	 * Get the primary MessageGroup this message belongs to.
	 * You should check first that the handle is valid.
	 * @return MessageGroup
	 */
	public function getGroup() {
		$ids = $this->getGroupIds();
		return MessageGroups::getGroup( $ids[0] );
	}

	/**
	 * Checks if the title corresponds to a known message.
	 * @since 2011-03-16
	 * @return \bool
	 */
	public function isValid() {
		return $this->isMessageNamespace() && $this->getGroupIds();
	}

	/**
	 * @return Title
	*/
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Check if a string contains the fuzzy string.
	 *
	 * @param $text \string Arbitrary text
	 * @return \bool If string contains fuzzy string.
	 */
	public static function hasFuzzyString( $text ) {
		return strpos( $text, TRANSLATE_FUZZY ) !== false;
	}

	/**
	 * Check if a title is marked as fuzzy.
	 * @return bool If title is marked fuzzy.
	 */
	public function isFuzzy() {
		$dbr = wfGetDB( DB_SLAVE );

		$tables = array( 'page', 'revtag' );
		$field = 'rt_type';
		$conds  = array(
			'page_namespace' => $this->title->getNamespace(),
			'page_title' => $this->title->getDBkey(),
			'rt_type' => RevTag::getType( 'fuzzy' ),
			'page_id=rt_page',
			'page_latest=rt_revision'
		);

		$res = $dbr->selectField( $tables, $field, $conds, __METHOD__ );

		return $res !== false;
	}

}
