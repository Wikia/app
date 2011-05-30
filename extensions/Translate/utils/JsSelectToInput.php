<?php
/**
 * Code for JavaScript enhanced \<option> selectors.
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2010 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Code for JavaScript enhanced \<option> selectors.
 */
class JsSelectToInput {
	/// Id of the text field where stuff is appended
	protected $targetId;
	/// Id of the \<option> field
	protected $sourceId;
	/// XmlSelect
	protected $select;
	/// Id on the button
	protected $buttonId;
	/// Text for the append button
	protected $msg = 'translate-jssti-add';

	/// Constructor
	public function __construct( XmlSelect $select = null ) {
		$this->select = $select;
	}

	/**
	 * Set the source id of the selector
	 * @param $id \string
	 */
	public function setSourceId( $id ) {
		$this->sourceId = $id;
	}

	/// @return \string
	public function getSourceId() {
		return $this->sourceId;
	}

	/**
	 * Set the id of the target text field
	 * @param $id \string
	 */
	public function setTargetId( $id ) {
		$this->targetId = $id;
	}

	/// @return \string
	public function getTargetId() {
		return $this->targetId;
	}

	/**
	 * Set the message key.
	 * @param $message \string
	 */
	public function setMessage( $message ) {
		$this->msg = $message;
	}

	/// @return \string Message key.
	public function getMessage() {
		return $this->msg;
	}

	/**
	 * Returns the whole input element and injects needed JavaScript
	 * @return \string Html code.
	 */
	public function getHtmlAndPrepareJS() {
		if ( $this->sourceId === false ) {
			if ( is_callable( array( $select, 'getAttribute' ) ) ) {
				$this->sourceId = $select->getAttribute['id'];
			}

			if ( !$this->sourceId ) {
				throw new MWException( "ID needs to be specified for the selector" );
			}
		}

		self::injectJs();
		$html = $this->select->getHtml();
		$html .= $this->getButton( $this->msg, $this->sourceId, $this->targetId );

		return $html;
	}

	/**
	 * Constructs the append button.
	 * @param $msg \string Message key.
	 * @param $source \string Html id.
	 * @param $target \string Html id.
	 */
	protected function getButton( $msg, $source, $target ) {
		$source = Xml::escapeJsString( $source );
		$target = Xml::escapeJsString( $target );
		$html = Xml::element( 'input', array(
			'type' => 'button',
			'value' => wfMsg( $msg ),
			'onclick' => "appendFromSelect( '$source', '$target' );"
		) );

		return $html;
	}

	/// Inject needed JavaScript in the page.
	public static function injectJs() {
		static $done = false;
		if ( $done ) return;

		global $wgOut;
		$wgOut->addScriptFile( TranslateUtils::assetPath( 'utils/JsSelectToInput.js' ) );
	}
}
