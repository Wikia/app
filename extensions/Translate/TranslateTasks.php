<?php
/**
 * Different tasks which encapsulate the processing of messages to requested
 * format for the web interface.
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2007-2008 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

/**
 * Container for options that are passed to tasks.
 */
class TaskOptions {
	private $language = null;
	private $limit = 0;
	private $offset = 0;
	private $pagingCB = null;

	public function __construct( $language, $limit = 0, $offset = 0, $pagingCB = null ) {
		$this->language = $language;
		$this->limit = $limit;
		$this->offset = $offset;
		$this->pagingCB = $pagingCB;
	}

	public function getLanguage() {
		return $this->language;
	}

	public function getLimit() {
		return $this->limit;
	}

	public function getOffset() {
		return $this->offset;
	}

	public function getPagingCB() {
		return $this->pagingCB;
	}

}

/**
 * Implements the core of TranslateTask.
 */
abstract class TranslateTask {
	protected $id = '__BUG__';

	/* We need $id here because staticness prevents subclass overriding */
	public static function labelForTask( $id ) {
		wfLoadExtensionMessages( 'Translate' );
		return wfMsg( TranslateUtils::MSG . 'task-' . $id );
	}

	public function getId() {
		return $this->id;
	}

	public function plainOutput() {
		return false;
	}

	protected $group = null;
	protected $messages = null;
	protected $options = null;
	public final function init( MessageGroup $group, TaskOptions $options ) {
		$this->group = $group;
		$this->options = $options;
	}

	protected $process = array();
	abstract protected function setProcess();
	abstract protected function output();

	public final function execute() {
		$this->setProcess();
		foreach ( $this->process as $function ) {
			call_user_func( $function );
		}
		return $this->output();
	}

	protected function doPaging() {
		$total = count( $this->collection );

		$this->collection->slice(
			$this->options->getOffset(),
			$this->options->getLimit()
		);

		$left = count( $this->collection );

		$callback = $this->options->getPagingCB();
		call_user_func( $callback, $this->options->getOffset(), $left, $total );
	}
}

class ViewMessagesTask extends TranslateTask {
	protected $id = 'view';

	protected function setProcess() {
		$this->process = array(
			array( $this, 'preinit' ),
			array( $this, 'filterOptional' ),
			array( $this, 'doPaging' ),
			array( $this, 'postinit' ),
		);
	}

	protected function preinit() {
		$code = $this->options->getLanguage();
		$this->collection = $this->group->initCollection( $code );
	}

	protected function filterOptional() {
		$this->collection->filter( 'optional' );
	}

	protected function postinit() {
		$this->group->fillCollection( $this->collection );
	}

	protected function output() {
		$tableheader = TranslateUtils::tableHeader( $this->group->getLabel() );
		$tablefooter = Xml::closeElement( 'table' );

		return
			$tableheader .
			TranslateUtils::makeListing(
				$this->collection,
				$this->group->getId(),
				false,
				$this->group->namespaces
			) .
			$tablefooter;
	}

}

class ViewUntranslatedTask extends ViewMessagesTask {
	protected $id = 'untranslated';

	protected function setProcess() {
		$this->process = array(
			array( $this, 'preinit' ),
			array( $this, 'filterOptional' ),
			array( $this, 'postinit' ),
			array( $this, 'filterTranslated' ),
			array( $this, 'doPaging' ),
		);
	}

	/**
	 * Filters all translated messages. Fuzzy messages are not considered to be
	 * translated, because they need attention from translators. Also optional
	 * messages can not have identical translations.
	 */
	protected function filterTranslated() {
		$this->collection->filter( 'translated' );
	}

}

class ViewOptionalTask extends ViewMessagesTask {
	protected $id = 'optional';

	protected function setProcess() {
		$this->process = array(
			array( $this, 'preinit' ),
			array( $this, 'filterNonOptional' ),
			array( $this, 'doPaging' ),
			array( $this, 'postinit' ),
		);
	}

	protected function filterNonOptional() {
		$this->collection->filter( 'optional', false );
	}

}

class ViewUntranslatedOptionalTask extends ViewOptionalTask {
	protected $id = 'untranslatedoptional';

	protected function setProcess() {
		$this->process = array(
			array( $this, 'preinit' ),
			array( $this, 'filterNonOptional' ),
			array( $this, 'postinit' ),
			array( $this, 'filterTranslated' ),
			array( $this, 'doPaging' ),
		);
	}

	protected function filterTranslated() {
		$this->collection->filter( 'translated' );
	}

}

class ViewProblematicTask extends ReviewMessagesTask {
	protected $id = 'problematic';

	protected function setProcess() {
		$this->process = array(
			array( $this, 'preinit' ),
			array( $this, 'postinit' ),
			array( $this, 'filterNonProblematic' ),
			array( $this, 'doPaging' ),
		);
	}

	protected function filterNonProblematic() {
		$code = $this->options->getLanguage();
		$problematic = $this->group->getProblematic( $code );
		$checker = MessageChecks::getInstance();
		$type = $this->group->getType();

		foreach ( $this->collection->keys() as $key ) {
			$item = $this->collection[$key];
			if ( in_array( $key, $problematic ) ) {
			 if ( $checker->doFastChecks( $item, $type, $code ) ) continue;
			}

			unset( $this->collection[$key] );
		}
	}

}


class ReviewMessagesTask extends ViewMessagesTask {
	protected $id = 'review';

	protected function setProcess() {
		$this->process = array(
			array( $this, 'preinit' ),
			array( $this, 'postinit' ),
			array( $this, 'filterUnchanged' ),
			array( $this, 'doPaging' ),
		);
	}

	protected function filterUnchanged() {
		$this->collection->filter( 'changed', false );
	}

	protected function output() {
		$tableheader = TranslateUtils::tableHeader( $this->group->getLabel() );
		$tablefooter = Xml::closeElement( 'table' );

		return
			$tableheader .
			TranslateUtils::makeListing(
				$this->collection,
				$this->group->getId(),
				true, /* Review mode */
				$this->group->namespaces
			) .
			$tablefooter;
	}

}

class ReviewAllMessagesTask extends ReviewMessagesTask {
	protected $id = 'reviewall';

	protected function setProcess() {
		$this->process = array(
			array( $this, 'preinit' ),
			array( $this, 'postinit' ),
			array( $this, 'filterUntranslated' ),
			array( $this, 'doPaging' ),
		);
	}

	protected function filterUntranslated() {
		$this->collection->filter( 'translated', false );
	}

}

class ExportMessagesTask extends ViewMessagesTask {
	protected $id = 'export';

	protected function setProcess() {
		$this->process = array(
			array( $this, 'preinit' ),
			array( $this, 'postinit' ),
		);
	}


	public function output() {
		$writer = $this->group->getWriter();
		$data = $writer->webExport( $this->collection );
		
		return Xml::openElement( 'textarea', array( 'id' => 'wpTextbox1', 'rows' => '50' ) ) .
			$data .
			"</textarea>";
	}
}

class ExportToFileMessagesTask extends ExportMessagesTask {
	protected $id = 'export-to-file';

	public function plainOutput() {
		return true;
	}

	public function output() {
		$writer = $this->group->getWriter();
		$this->collection->filter( 'translation', null );
		return $writer->webExport( $this->collection );
	}
}

class ExportToXliffMessagesTask extends ExportToFileMessagesTask {
	protected $id = 'export-to-xliff';

	public function output() {
		$writer = new XliffFormatWriter( $this->group );
		return $writer->webExport( $this->collection );
	}
}

class ExportAsPoMessagesTask extends ExportMessagesTask {
	protected $id = 'export-as-po';

	public function plainOutput() {
		return true;
	}

	public function output() {
		global $IP, $wgServer, $wgTranslateDocumentationLanguageCode;

		$lang = Language::factory( 'en' );

		$out = '';
		$now = wfTimestampNow();
		$label = $this->group->getLabel();
		$code = $this->options->getLanguage();
		$languageName = TranslateUtils::getLanguageName( $code );

		$filename = $code . '_' . $this->group->getID() . '.po';
		header( "Content-Disposition: attachment; filename=\"$filename\"" );

		$headers = array();
		$headers['Project-Id-Version'] = 'MediaWiki ' . SpecialVersion::getVersion();
		// TODO: make this customisable or something
		$headers['Report-Msgid-Bugs-To'] = $wgServer;
		// TODO: sprintfDate doesn't support any time zone flags
		$headers['POT-Creation-Date'] = $lang->sprintfDate( 'xnY-xnm-xnd xnH:xni:xns+0000', $now );
		$headers['Language-Team'] = TranslateUtils::getLanguageName( $this->options->getLanguage() );
		$headers['Content-Type'] = 'text-plain; charset=UTF-8';
		$headers['Content-Transfer-Encoding'] = '8bit';
		$headers['X-Generator'] = 'MediaWiki Translate extension ' . TRANSLATE_VERSION;
		$headers['X-Language-Code'] = $this->options->getLanguage();
		$headers['X-Message-Group'] = $this->group->getId();

		$headerlines = array( '' );
		foreach ( $headers as $key => $value ) {
			$headerlines[] = "$key: $value\n";
		}

		$out .= "# Translation of $label to $languageName\n";
		$out .= self::formatmsg( '', $headerlines  );

		foreach ( $this->collection as $key => $m ) {
			$flags = array();

			$translation = $m->translation;
			# CASE2: no translation
			if ( $translation === null ) $translation = '';

			# CASE3: optional messages; accept only if different
			if ( $m->optional ) $flags[] = 'optional';

			# Remove fuzzy markings before export
			if ( strpos( $translation, TRANSLATE_FUZZY ) !== false ) {
				$translation = str_replace( TRANSLATE_FUZZY, '', $translation );
				$flags[] = 'fuzzy';
			}

			$comments = '';
			if ( $wgTranslateDocumentationLanguageCode ) {
				$documentation = TranslateUtils::getMessageContent( $key, $wgTranslateDocumentationLanguageCode );
				if ( $documentation ) $comments = $documentation;
			}

			$out .= self::formatcomments( $comments, $flags );
			$out .= self::formatmsg( $m->definition, $translation, $key, $flags );

		}

		return $out;
	}

	private static function escape( $line ) {
		$line = addcslashes( $line, '\\"' );
		$line = str_replace( "\n", '\n', $line );
		$line = '"' . $line . '"';
		return $line;
	}

	private static function formatcomments( $comments = false, $flags = false ) {
		$output = array();
		if ( $comments ) {
			$output[] = '#. ' . implode( "\n#. ", explode( "\n", $comments ) );
		}

		if ( $flags ) {
			$output[] = '#, ' . implode( ', ', $flags );
		}

		if ( !count( $output ) ) {
			$output[] = '#:';
		}

		return implode( "\n", $output ) . "\n";
	}

	private static function formatmsg( $msgid, $msgstr, $msgctxt = false ) {
		$output = array();

		if ( $msgctxt ) {
			$output[] = 'msgctxt ' . self::escape( $msgctxt );
		}

		if ( !is_array( $msgid ) ) { $msgid = array( $msgid ); }
		if ( !is_array( $msgstr ) ) { $msgstr = array( $msgstr ); }
		$output[] = 'msgid ' . implode( "\n", array_map( array( __CLASS__, 'escape' ), $msgid ) );
		$output[] = 'msgstr ' . implode( "\n", array_map( array( __CLASS__, 'escape' ), $msgstr ) );

		$out = implode( "\n", $output ) . "\n\n";
		return $out;

	}
}

class TranslateTasks {
	public static function getTasks() {
		global $wgTranslateTasks;

		return array_keys( $wgTranslateTasks );
	}

	public static function getTask( $id ) {
		global $wgTranslateTasks;
		if ( array_key_exists( $id, $wgTranslateTasks ) ) {
			if ( is_callable( $wgTranslateTasks[$id] ) ) {
				return call_user_func( $wgTranslateTasks[$id], $id );
			} else {
				return new $wgTranslateTasks[$id];
			}
		} else {
			return null;
		}
	}
}
