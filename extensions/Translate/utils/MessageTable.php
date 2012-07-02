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
	protected $collection;
	protected $group;
	protected $editLinkParams = array();

	protected $headers = array(
		'table' => array( 'msg', 'allmessagesname' ),
		'current' => array( 'msg', 'allmessagescurrent' ),
		'default' => array( 'msg', 'allmessagesdefault' ),
	);

	public function __construct( MessageCollection $collection, MessageGroup $group ) {
		$this->collection = $collection;
		$this->group = $group;
		$this->setHeaderText( 'table', $group->getLabel() );
		$this->appendEditLinkParams( 'loadgroup', $group->getId() );
	}

	public function setEditLinkParams( array $array ) {
		$this->editLinkParams = $array;
	}

	public function appendEditLinkParams( /*string*/ $key, /*string*/ $value ) {
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
		$pages = array();
		foreach ( $this->collection->getTitles() as $title ) {
			$pages[] = $title->getPrefixedDBKey();
		}
		$vars = array( 'trlKeys' => $pages );
		$wgOut->addScript( Skin::makeVariablesScript( $vars ) );
		$wgOut->addModules( 'ext.translate.messagetable' );
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
		$optional = wfMsgHtml( 'translate-optional' );

		$this->doLinkBatch();

		$sourceLang = Language::factory( $this->group->getSourceLanguage() );
		$targetLang = Language::factory( $this->collection->getLanguage() );
		$titleMap = $this->collection->keys();

		$output =  '';

		$this->collection->initMessages(); // Just to be sure
		foreach ( $this->collection as $key => $m ) {
			$tools = array();
			$title = $titleMap[$key];

			$original = $m->definition();

			if ( $m->translation() !== null ) {
				$message = $m->translation();
				$rclasses = self::getLanguageAttributes( $targetLang );
				$rclasses['class'] = 'translated';
			} else {
				$message = $original;
				$rclasses = self::getLanguageAttributes( $sourceLang );
				$rclasses['class'] = 'untranslated';
			}

			global $wgLang;
			$niceTitle = htmlspecialchars( $wgLang->truncate( $title->getPrefixedText(), -35 ) );

			$linker = class_exists( 'DummyLinker' ) ? new DummyLinker() : new Linker();
			$tools['edit'] = $linker->link(
				$title,
				$niceTitle,
				TranslationEditPage::jsEdit( $title, $this->group->getId() ),
				array( 'action' => 'edit' ) + $this->editLinkParams,
				'known'
			);

			$anchor = 'msg_' . $key;
			$anchor = Xml::element( 'a', array( 'id' => $anchor, 'href' => "#$anchor" ), "↓" );

			$extra = '';
			if ( $m->hasTag( 'optional' ) ) {
				$extra = '<br />' . $optional;
			}

			$leftColumn = $this->getReviewButton( $m ) . $anchor . $tools['edit'] . $extra . $this->getReviewStatus( $m );

			if ( $this->reviewMode && $original !== $message ) {
				$output .= Xml::tags( 'tr', array( 'class' => 'orig' ),
					Xml::tags( 'td', array( 'rowspan' => '2' ), $leftColumn ) .
					Xml::tags( 'td', self::getLanguageAttributes( $sourceLang ),
						TranslateUtils::convertWhiteSpaceToHTML( $original ) )
				);

				$output .= Xml::tags( 'tr', array( 'class' => 'new' ),
					Xml::tags( 'td', $rclasses, TranslateUtils::convertWhiteSpaceToHTML( $message ) )
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

	protected static function getLanguageAttributes( Language $language ) {
		global $wgTranslateDocumentationLanguageCode;
		$code = $language->getCode();
		$dir = $language->getDir();
		if ( $code === $wgTranslateDocumentationLanguageCode ) {
			// Should be good enough for now
			$code = 'en';
		}

		return array( 'lang' => $code, 'dir' => $dir );
	}

	protected function getReviewButton( TMessage $message ) {
		global $wgUser;
		$revision = $message->getProperty( 'revision' );
		if ( !$this->reviewMode || !$wgUser->isAllowed( 'translate-messagereview' ) || !$revision ) {
			return '';
		}

		$attribs = array(
			'type' => 'button',
			'class' => 'mw-translate-messagereviewbutton',
			'data-token' => ApiTranslationReview::getToken( 0, '' ),
			'data-revision' => $revision,
			'name' => 'acceptbutton-' . $revision, // Otherwise Firefox disables buttons on page load
		);

		$reviewers = (array) $message->getProperty( 'reviewers' );
		if ( in_array( $wgUser->getId(), $reviewers ) ) {
			$attribs['value'] = wfMessage( 'translate-messagereview-done' )->text();
			$attribs['disabled'] = 'disabled';
			$attribs['title'] = wfMessage( 'translate-messagereview-doit' )->text();
		} elseif ( $message->hasTag( 'fuzzy' ) ) {
			$attribs['value'] = wfMessage( 'translate-messagereview-submit' )->text();
			$attribs['disabled'] = 'disabled';
			$attribs['title'] = wfMessage( 'translate-messagereview-no-fuzzy' )->text();
		} elseif ( $wgUser->getName() === $message->author() ) {
			$attribs['value'] = wfMessage( 'translate-messagereview-submit' )->text();
			$attribs['disabled'] = 'disabled';
			$attribs['title'] = wfMessage( 'translate-messagereview-no-own' )->text();
		} else {
			$attribs['value'] = wfMessage( 'translate-messagereview-submit' )->text();
		}


		$review = Html::element( 'input', $attribs );
		return $review;
	}

	protected function getReviewStatus( TMessage $message ) {
		global $wgUser;
		if ( !$this->reviewMode ) {
			return '';
		}

		$reviewers = (array) $message->getProperty( 'reviewers' );
		if ( count( $reviewers ) === 0 ) {
			return '';
		}

		$you = $wgUser->getId();
		if ( in_array( $you, $reviewers ) ) {
			if ( count( $reviewers ) === 1 ) {
				$msg = wfMessage( 'translate-messagereview-reviewsyou' )->parse();
			} else {
				$msg = wfMessage( 'translate-messagereview-reviewswithyou' )->numParams( count( $reviewers ) )->parse();
			}
		} else {
			$msg = wfMessage( 'translate-messagereview-reviews' )->numParams( count( $reviewers ) )->parse();
		}
		return Html::rawElement( 'div', array( 'class' => 'mw-translate-messagereviewstatus' ), $msg );
	}

	protected function doLinkBatch() {
		$batch = new LinkBatch();
		$batch->setCaller( __METHOD__ );
		foreach ( $this->collection->getTitles() as $title ) {
			$batch->addObj( $title );
		}
		$batch->execute();
	}

}
