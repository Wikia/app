<?php

/**
 * This class together with some javascript implements the ajax translation
 * page.
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2009 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class TranslationEditPage {
	// Instance of an Title object
	protected $title;

	/**
	 * Constructor.
	 * @param $title  Title  A title object
	 */
	public function __construct( Title $title ) {
		$this->setTitle( $title );
	}

	public static function newFromRequest( WebRequest $request ) {
		$title = Title::newFromText( $request->getText( 'page' ) );
		if ( !$title ) return null;
		return new self( $title );
	}


	public function setTitle( Title $title ) { $this->title = $title; }
	public function getTitle() { return $this->title; }

	/**
	 * Generates the html snippet for ajax edit. Echoes it to the output and 
	 * disabled all other output.
	 */
	public function execute() {
		$data = $this->getEditInfo();
		$helpers = new TranslationHelpers( $this->getTitle() );

		// jQuery borks on something, probably to :, thus, don't use special chars
		$id = Sanitizer::escapeId( sha1( $this->getTitle()->getPrefixedText() ) );
		$helpers->setTextareaId( $id );

		global $wgServer, $wgScriptPath, $wgOut;
		$wgOut->disable();

		$translation = $helpers->getTranslation();
		$short = strpos( $translation, "\n" ) === false && strlen( $translation ) < 200;
		$textareaParams = array(
			'name' => 'text',
			'class' => 'mw-translate-edit-area',
			'rows' =>  $short ? 3: 10,
			'id' => $id,
		);
		$textarea = Html::element( 'textarea', $textareaParams, $translation );

		$hidden = array();
		$hidden[] = Xml::hidden( 'title', $this->getTitle()->getPrefixedDbKey() );
		if ( isset( $data['revisions'][0]['timestamp'] ) )
			$hidden[] = Xml::hidden( 'basetimestamp', $data['revisions'][0]['timestamp'] );
		$hidden[] = Xml::hidden( 'starttimestamp', $data['starttimestamp'] );
		$hidden[] = Xml::hidden( 'token', $data['edittoken'] );
		$hidden[] = Xml::hidden( 'format', 'json' );
		$hidden[] = Xml::hidden( 'action', 'edit' );

		$summary = Xml::inputLabel( wfMsg( 'summary' ), 'summary', 'summary', 40 );
		$save = Xml::submitButton( wfMsg( 'savearticle' ), array( 'style' => 'font-weight:bold' ) );
		$normal = Xml::element( 'input', array( 'class' => 'mw-translate-fb',
			'value' => wfMsg( 'translate-js-fb' ), 'type' => 'button' ) );

		// Use the api to submit edits
		$formParams = array(
			'action' => "{$wgServer}{$wgScriptPath}/api.php",
			'method' => 'post',
		);

		$form = Html::rawElement( 'form', $formParams,
			implode( "\n", $hidden ) . "\n" .
			$helpers->getBoxes() . "\n" .
			"$textarea\n$summary$save$normal"
		);

		echo $form;
	}

	/**
	 * Gets the edit token and timestamps in some ugly array structure. Needs to
	 * be cleaned up.
	 * @return Array
	 */
	protected function getEditInfo() {
		$params = new FauxRequest( array(
			'action' => 'query',
			'prop' => 'info|revisions',
			'intoken' => 'edit',
			'titles' => $this->getTitle(),
			'rvprop' => 'timestamp',
		) );

		$api = new ApiMain( $params );
		$api->execute();
		$data = $api->getResultData();
		$data = $data['query']['pages'];
		$data = array_shift( $data );
		return $data;
	}

	public static function jsEdit( Title $title ) {
		global $wgUser;

		if ( !$wgUser->isAllowed( 'translate' ) ) return array();
		if ( !$wgUser->getOption( 'translate-jsedit' ) ) return array();

		$jsTitle = Xml::escapeJsString( $title->getPrefixedDbKey() );
		return array( 'onclick' => "return trlOpenJsEdit( \"$jsTitle\" );" );
	}

}