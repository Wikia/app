<?php
/**
 * Contains classes to build tables for MessageCollection objects.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2007-2010 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Pretty formatter for MessageCollection objects.
 */
class MessageTable {
	protected $reviewMode = false;
	protected $collection = null;
	protected $group = null;
	protected $code = null;
	protected $editLinkParams = array();

	protected $headers = array(
		'table' => array( 'msg', 'allmessagesname' ),
		'current' => array( 'msg', 'allmessagescurrent' ),
		'default' => array( 'msg', 'allmessagesdefault' ),
	);

	public function __construct( MessageCollection $collection, MessageGroup $group, $code ) {
		$this->collection = $collection;
		$this->group = $group;
		$this->code = $code;
		$this->setHeaderText( 'table', $group->getLabel() );
		$this->appendEditLinkParams( 'loadgroup', $group->getId() );
	}

	public function setEditLinkParams( array $array ) {
		$this->editLinkParams = $array;
	}

	public function appendEditLinkParams( $key, $value ) {
		$this->editLinkParams[$key] = $value;
	}

	public function setReviewMode( $mode = true ) {
		$this->reviewMode = $mode;
	}

	public function setHeaderTextMessage( $type, $value ) {
		if ( !isset( $this->headers[$type] ) ) {
			throw new MWException( "Unexpected type $type" );
		}

		$this->headers[$type] = array( 'msg', $value );
	}

	public function setHeaderText( $type, $value ) {
		if ( !isset( $this->headers[$type] ) ) {
			throw new MWException( "Unexpected type $type" );
		}

		$this->headers[$type] = array( 'raw', htmlspecialchars( $value ) );
	}

	public function includeAssets() {
		global $wgOut;
		TranslationHelpers::addModules( $wgOut );
		$vars = array( 'trlKeys' => array_values( $this->collection->keys() ) );
		$wgOut->addScript( Skin::makeVariablesScript( $vars ) );
		TranslateUtils::addModules( $wgOut, 'ext.translate.messagetable' );
	}

	public function header() {
		$tableheader = Xml::openElement( 'table', array(
			'class'   => 'mw-sp-translate-table'
		) );

		if ( $this->reviewMode ) {
			$tableheader .= Xml::openElement( 'tr' );
			$tableheader .= Xml::element( 'th',
				array( 'rowspan' => '2' ),
				$this->headerText( 'table' )
			);
			$tableheader .= Xml::tags( 'th', null, $this->headerText( 'default' ) );
			$tableheader .= Xml::closeElement( 'tr' );

			$tableheader .= Xml::openElement( 'tr' );
			$tableheader .= Xml::tags( 'th', null, $this->headerText( 'current' ) );
			$tableheader .= Xml::closeElement( 'tr' );
		} else {
			$tableheader .= Xml::openElement( 'tr' );
			$tableheader .= Xml::tags( 'th', null, $this->headerText( 'table' ) );
			$tableheader .= Xml::tags( 'th', null, $this->headerText( 'current' ) );
			$tableheader .= Xml::closeElement( 'tr' );
		}

		return $tableheader . "\n";
	}

	public function contents() {
		global $wgUser;

		$sk = $wgUser->getSkin();

		$optional = wfMsgHtml( 'translate-optional' );

		$mlang = Language::factory( $this->code );
		$mespa = array( 'dir' => $mlang->getDir(), 'lang' => $this->code );
		unset( $mlang );

		$batch = new LinkBatch();
		if ( method_exists( $batch, 'setCaller' ) ) {
			$batch->setCaller( __METHOD__ );
		}

		$ns = $this->group->getNamespace();

		foreach ( $this->collection->keys() as $key ) {
			$batch->add( $ns, $key );
		}

		$batch->execute();

		$output =  '';
		$this->collection->initMessages(); // Just to be sure
		foreach ( $this->collection as $key => $m ) {
			$tools = array();
			$title = $this->keyToTitle( $key );

			$original = $m->definition();
			# @todo Handle directionality of fallback language(s)
			if ( $m->translation() ) {
				$message = $m->translation();
				$rclasses = array_merge ( $mespa, array( 'class' => 'translated' ) );
			} else {
				$message = $original;
				$rclasses = array( 'class' => 'untranslated' );
			}

			global $wgLang;

			$niceTitle = htmlspecialchars( $wgLang->truncate( $key, - 30 ) );

			$tools['edit'] = $sk->link(
				$title,
				$niceTitle,
				TranslationEditPage::jsEdit( $title ),
				array( 'action' => 'edit' ) + $this->editLinkParams,
				'known'
			);

			$anchor = 'msg_' . $key;
			$anchor = Xml::element( 'a', array( 'id' => $anchor, 'href' => "#$anchor" ), "↓" );

			$extra = '';
			if ( $m->hasTag( 'optional' ) ) {
				$extra = '<br />' . $optional;
			}

			$leftColumn = $anchor . $tools['edit'] . $extra;

			if ( $this->reviewMode && $original !== $message ) {
				$output .= Xml::tags( 'tr', array( 'class' => 'orig' ),
					Xml::tags( 'td', array( 'rowspan' => '2' ), $leftColumn ) .
					Xml::tags( 'td', null, TranslateUtils::convertWhiteSpaceToHTML( $original ) )
				);

				$output .= Xml::tags( 'tr', array( 'class' => 'new' ),
					Xml::tags( 'td', $mespa, TranslateUtils::convertWhiteSpaceToHTML( $message ) )
				);
			} else {
				$output .= Xml::tags( 'tr', array( 'class' => 'def' ),
					Xml::tags( 'td', null, $leftColumn ) .
					Xml::tags( 'td', $rclasses, TranslateUtils::convertWhiteSpaceToHTML( $message ) )
				);
			}
			$output .= "\n";
		}

		return $output;
	}

	public function fullTable() {
		$this->includeAssets();

		return $this->header() . $this->contents() . '</table>';
	}

	protected function headerText( $type ) {
		if ( !isset( $this->headers[$type] ) ) {
			throw new MWException( "Unexpected type $type" );
		}

		list( $format, $value ) = $this->headers[$type];
		if ( $format === 'msg' ) {
			return wfMsgExt( $value, array( 'parsemag', 'escapenoentities' ) );
		} elseif ( $format === 'raw' ) {
			return $value;
		} else {
			throw new MWException( "Unexcepted format $format" );
		}
	}

	protected function keyToTitle( $key ) {
		$titleText = TranslateUtils::title( $key, $this->collection->code );
		$namespace = $this->group->getNamespace();

		return Title::makeTitle( $namespace, $titleText );
	}
}
