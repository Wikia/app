<?php
/**
 * Different tasks which encapsulate the processing of messages to requested
 * format for the web interface.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2007-2010 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Container for options that are passed to tasks.
 */
class TaskOptions {
	/// \string Language code.
	protected $language;
	/// \int Number of items to show.
	protected $limit = 0;
	/// \int Offset to the results.
	protected $offset = 0;
	/// \mixed Callback which is called to provide information about the result counts.
	protected $pagingCB;

	/**
	 * @param $language \string Language code.
	 * @param $limit \int Number of items to show.
	 * @param $offset \int Offset to the results.
	 * @param $pagingCB \mixed Callback which is called to provide information
	 * about the result counts. The callback is provided with three parameters:
	 * provided offset, number of messages to show, number of messages in total.
	 */
	public function __construct( $language, $limit = 0, $offset = 0, $pagingCB = null ) {
		$this->language = $language;
		$this->limit = $limit;
		$this->offset = $offset;
		$this->pagingCB = $pagingCB;
	}

	/**
	 * @return \string Language code.
	 */
	public function getLanguage() {
		return $this->language;
	}

	/**
	 * @return \int Number of items to show.
	 */
	public function getLimit() {
		return $this->limit;
	}

	/**
	 * @return \int Offset to the results.
	 */
	public function getOffset() {
		return $this->offset;
	}

	/**
	 * @return \mixed Callback which is called to provide information about the result counts.
	 */
	public function getPagingCB() {
		return $this->pagingCB;
	}
}

/**
 * Basic implementation and interface for tasks.
 * Task is a combination of filters and output format that are applied to
 * messages of given message group in given language.
 */
abstract class TranslateTask {
	/// \string Task identifier.
	protected $id = '__BUG__';

	// We need $id here because staticness prevents subclass overriding.
	/**
	 * Get label for task.
	 * @param $id \string.
	 * @return \string
	 */
	public static function labelForTask( $id ) {
		return wfMsg( 'translate-task-' . $id );
	}

	/**
	 * Get task identifier.
	 * @return \string
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Indicates whether the task itself will hand the full output page.
	 * If false, the result is embedded in the normal results page.
	 * @return \bool
	 */
	public function plainOutput() {
		return false;
	}

	protected $group; ///< \type{MessageGroup} Message group.
	protected $collection; ///< \type{MessageCollection} Messages.
	protected $options; ///< \type{TaskOptions} Options.

	/**
	 * Constructor.
	 * @param $group \type{MessageGroup} Message group.
	 * @param $options \type{TaskOptions} Options.
	 */
	public final function init( MessageGroup $group, TaskOptions $options ) {
		$this->group = $group;
		$this->options = $options;
	}

	/**
	 * Outputs the results.
	 * @return \string
	 */
	abstract protected function output();

	/// Processes messages before paging is done.
	abstract protected function preinit();

	/// Processes messages after paging is done.
	abstract protected function postinit();

	/**
	 * Executes the task with given options and outputs the results.
	 * @return \string Html.
	 */
	public final function execute() {
		$this->preinit();
		$this->doPaging();
		$this->postinit();

		return $this->output();
	}

	/**
	 * Takes a slice of messages according to limit and offset given
	 * in option at initialisation time. Calls the callback to provide
	 * information how much messages there is.
	 */
	protected function doPaging() {
		$total = count( $this->collection );
		$this->collection->slice(
			$this->options->getOffset(),
			$this->options->getLimit()
		);
		$left  = count( $this->collection );

		$callback = $this->options->getPagingCB();
		call_user_func( $callback, $this->options->getOffset(), $left, $total );
	}
}

/**
 * Lists all non-optional messages with translation if any.
 */
class ViewMessagesTask extends TranslateTask {
	protected $id = 'view';

	protected function preinit() {
		$code = $this->options->getLanguage();
		$this->collection = $this->group->initCollection( $code );
		$this->collection->setInfile( $this->group->load( $code ) );
		$this->collection->filter( 'ignored' );
		$this->collection->filter( 'optional' );
	}

	protected function postinit() {
		$this->collection->loadTranslations();
	}

	protected function output() {
		$code = $this->options->getLanguage();
		$table = new MessageTable( $this->collection, $this->group, $code );
		$table->appendEditLinkParams( 'loadtask', $this->getId() );

		return $table->fullTable();
	}
}

/**
 * List messages which has been changed since last export.
 */
class ReviewMessagesTask extends ViewMessagesTask {
	protected $id = 'review';

	protected function preinit() {
		$code = $this->options->getLanguage();
		$this->collection = $this->group->initCollection( $code );
		$this->collection->setInfile( $this->group->load( $code ) );
		$this->collection->filter( 'ignored' );
		$this->collection->filter( 'hastranslation', false );
		$this->collection->filter( 'changed', false );
	}

	protected function output() {
		$code = $this->options->getLanguage();
		$table = new MessageTable( $this->collection, $this->group, $code );
		$table->appendEditLinkParams( 'loadtask', $this->getId() );
		$table->setReviewMode();

		return $table->fullTable();
	}
}

/**
 * Lists untranslated non-optional messages.
 */
class ViewUntranslatedTask extends ViewMessagesTask {
	protected $id = 'untranslated';

	protected function preinit() {
		$code = $this->options->getLanguage();
		$this->collection = $this->group->initCollection( $code );
		$this->collection->setInfile( $this->group->load( $code ) );
		$this->collection->filter( 'ignored' );
		$this->collection->filter( 'optional' );

		// Update the cache while we are at it.
		$total = count( $this->collection );
		$this->collection->filter( 'translated' );
		$translated = $total - count( $this->collection );
		$fuzzy = count( $this->collection->getTags( 'fuzzy' ) );

		$cache = new ArrayMemoryCache( 'groupstats' );
		$cache->set( $this->group->getID(), $code, array( $fuzzy, $translated, $total ) );
	}
}

/**
 * Lists optional messages.
 */
class ViewOptionalTask extends ViewMessagesTask {
	protected $id = 'optional';

	protected function preinit() {
		$code = $this->options->getLanguage();
		$this->collection = $this->group->initCollection( $code );
		$this->collection->setInfile( $this->group->load( $code ) );
		$this->collection->filter( 'ignored' );
		$this->collection->filter( 'optional', false );
	}
}

/**
 * Lists messages with good translation memory suggestions.
 * The number of results is limited by the speed of translation memory.
 */
class ViewWithSuggestionsTask extends ViewMessagesTask {
	protected $id = 'suggestions';

	protected function preinit() {
		$code = $this->options->getLanguage();
		global $wgTranslateTranslationServices;
		$config = $wgTranslateTranslationServices['tmserver'];
		$server = $config['server'];
		$port   = $config['port'];
		$timeout = $config['timeout-sync'];

		$this->collection = $this->group->initCollection( $code );
		$this->collection->setInfile( $this->group->load( $code ) );
		$this->collection->filter( 'ignored' );
		$this->collection->filter( 'optional' );
		$this->collection->filter( 'translated' );
		$this->collection->filter( 'fuzzy' );
		$this->collection->loadTranslations();

		$start = time();

		foreach ( $this->collection->keys() as $key => $_ ) {
			// Allow up to 10 seconds to search for suggestions.
			if ( time() - $start > 10 || TranslationHelpers::checkTranslationServiceFailure( 'tmserver' ) ) {
				unset( $this->collection[$key] );
				continue;
			}

			$def = rawurlencode( $this->collection[$key]->definition() );
			$url = "$server:$port/tmserver/en/$code/unit/$def";
			$suggestions = Http::get( $url, $timeout );

			if ( $suggestions !== false ) {
				$suggestions = FormatJson::decode( $suggestions, true );
				foreach ( $suggestions as $s ) {
					// We have a good suggestion, do not filter.
					if ( $s['quality'] > 0.80 ) {
						continue 2;
					}
				}
			} else {
				TranslationHelpers::reportTranslationServiceFailure( 'tmserver' );
			}
			unset( $this->collection[$key] );
		}
	}
}

/**
 * Lists untranslated optional messages.
 */
class ViewUntranslatedOptionalTask extends ViewOptionalTask {
	protected $id = 'untranslatedoptional';

	protected function preinit() {
		$code = $this->options->getLanguage();
		$this->collection = $this->group->initCollection( $code );
		$this->collection->setInfile( $this->group->load( $code ) );
		$this->collection->filter( 'ignored' );
		$this->collection->filter( 'optional', false );
		$this->collection->filter( 'translated' );
	}
}

/**
 * Lists all translations for reviewing.
 */
class ReviewAllMessagesTask extends ReviewMessagesTask {
	protected $id = 'reviewall';

	protected function preinit() {
		$code = $this->options->getLanguage();
		$this->collection = $this->group->initCollection( $code );
		$this->collection->setInfile( $this->group->load( $code ) );
		$this->collection->filter( 'ignored' );
		$this->collection->filter( 'hastranslation', false );
	}
}

/**
 * Exports messages to their native format with embedded textarea.
 */
class ExportMessagesTask extends ViewMessagesTask {
	protected $id = 'export';

	protected function preinit() {
		$code = $this->options->getLanguage();
		$this->collection = $this->group->initCollection( $code );
		$this->collection->setInfile( $this->group->load( $code ) );
	}

	// No paging should be done.
	protected function doPaging() {}

	public function output() {
		if ( $this->group instanceof MessageGroupBase ) {
			$ffs = $this->group->getFFS();
			$data = $ffs->writeIntoVariable( $this->collection );
		} else {
			$writer = $this->group->getWriter();
			$data = $writer->webExport( $this->collection );
		}

		return Xml::openElement( 'textarea', array( 'id' => 'wpTextbox1', 'rows' => '50' ) ) .
			$data .
			"</textarea>";
	}
}

/**
 * Exports messages to their native format as whole page.
 */
class ExportToFileMessagesTask extends ExportMessagesTask {
	protected $id = 'export-to-file';

	public function plainOutput() {
		return true;
	}

	public function output() {
		if ( $this->group instanceof MessageGroupBase ) {
			if ( !$this->group instanceof FileBasedMessageGroup ) {
				$data = 'Not supported';
			} else {
				$ffs = $this->group->getFFS();
				$data = $ffs->writeIntoVariable( $this->collection );
			}
		} else {
			$writer = $this->group->getWriter();
			$data = $writer->webExport( $this->collection );
		}
		return $data;
	}
}

/**
 * Exports messages to xliff format.
 */
class ExportToXliffMessagesTask extends ExportToFileMessagesTask {
	protected $id = 'export-to-xliff';

	public function output() {
		$writer = new XliffFormatWriter( $this->group );
		return $writer->webExport( $this->collection );
	}
}

/**
 * Exports messages as special Gettext format that is suitable for off-line
 * translation with tools that support Gettext. These files can later be
 * imported back to the wiki.
 */
class ExportAsPoMessagesTask extends ExportMessagesTask {
	protected $id = 'export-as-po';

	public function plainOutput() {
		return true;
	}

	public function output() {
		$ffs = null;
		if ( $this->group instanceof FileBasedMessageGroup ) {
			$ffs = $this->group->getFFS();
		}

		if ( !$ffs instanceof GettextFFS ) {
			$group = FileBasedMessageGroup::newFromMessageGroup( $this->group );
			$ffs = new GettextFFS( $group );
		}

		$ffs->setOfflineMode( 'true' );

		$code = $this->options->getLanguage();
		$id = $this->group->getID();
		$filename = "${id}_$code.po";
		header( "Content-Disposition: attachment; filename=\"$filename\"" );
		return $ffs->writeIntoVariable( $this->collection );
	}
}

/**
 * Collection of functions to get tasks.
 */
class TranslateTasks {

	/**
	 * Return list of available tasks.
	 * @param $pageTranslation Whether this group is page translation group.
	 * @todo Make the above parameter a group and check its class?
	 * @return \list{String} Task identifiers.
	 */
	public static function getTasks( $pageTranslation = false ) {
		global $wgTranslateTasks, $wgTranslateTranslationServices;

		// Tasks not to be available in page translation.
		$filterTasks = array(
			'optional',
			'untranslatedoptional',
			'review',
			'export-to-file',
			'export-to-xliff'
		);

		$allTasks = array_keys( $wgTranslateTasks );

		if ( $pageTranslation ) {
			foreach ( $allTasks as $id => $task ) {
				if ( in_array( $task, $filterTasks ) ) {
					unset( $allTasks[$id] );
				}
			}
		}

		if ( !isset( $wgTranslateTranslationServices['tmserver'] ) ) {
			unset( $allTasks['suggestions'] );
		}

		return $allTasks;
	}

	/**
	 * Get task by id.
	 * @param $id \string Task identifier.
	 * @return \types{TranslateTask,Null} The task or null if no such task.
	 */
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
