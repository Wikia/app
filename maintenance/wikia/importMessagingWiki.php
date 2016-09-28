<?php
require_once __DIR__ . '/../Maintenance.php';

class ImportMessagingWiki extends Maintenance {

	/** @var string MESSAGING_WIKI_DB messaging wiki database name */
	const MESSAGING_WIKI_DB = 'messaging';

	/**
	 * @var array Array of titles to delete (strings)
	 */
	protected $articlesToDelete = [];

	/**
	 * @var array Array of messages from messaging wiki (same format as in i18n php files
	 */
	protected $messages = [];

	/**
	 * @var bool Whether to modify source files in app repo or write to tmp
	 */
	protected $isDryRun = true;

	public function __construct() {
		parent::__construct();

		$this->addOption( 'dry-run', 'Don\'t make any changes to i18n files - print output in /tmp/ folder.' );
	}

	/**
	 * Main entry point
	 */
	public function execute() {
		$this->isDryRun = $this->getOption( 'dry-run', false );
		$hasData = $this->getMessagingWikiData();

		if ( $hasData ) {
			$this->processExtensions();
		}
	}

	/**
	 * Load customized messages from messaging wiki
	 * @return bool if we found any data
	 */
	protected function getMessagingWikiData() {
		global $wgContLang;

		$i = 0;

		$db = wfGetDB( DB_SLAVE, [], static::MESSAGING_WIKI_DB );
		$res = ( new WikiaSQL() )
			->SELECT( 'page_title', 'old_text', 'old_flags' )
			->FROM( 'page, revision, text' )
			->WHERE( 'page_namespace' )
			->EQUAL_TO( NS_MEDIAWIKI )
			->AND_( 'page_is_redirect' )
			->EQUAL_TO( 0 )
			->AND_( 'page_latest' )
			->EQUAL_TO_FIELD( 'rev_id' )
			->AND_( 'rev_text_id' )
			->EQUAL_TO_FIELD( 'old_id' )
		->runLoop( $db, function ( &$res, $row ) use ( &$i, $wgContLang ) {
			$text = Revision::getRevisionText( $row );
			$lckey = $wgContLang->lcfirst( $row->page_title );
			if ( strpos( $lckey, '/' ) ) {
				$t = explode( '/', $lckey );
				$key = $t[0];
				$lang = $t[1];
			} else {
				$key = $lckey;
				$lang = 'en';
			}

			$res['articlesToDelete'][] = $row->page_title;
			$res['messages'][$lang] = $res['messages'][$lang] ?? [];
			$res['messages'][$lang][$key] = $text;
			$i++;
		} );

		$this->messages = $res['messages'];
		$this->articlesToDelete = $res['articlesToDelete'];

		$this->output( "Found $i messages in messaging DB.\n" );
		if ( $this->isDryRun ) {
			$this->output( "Running in dry run mode. Existing i18n files will not be changed.\n" );
		}

		return !empty( $this->messages );
	}

	/**
	 * Process all i18n files of enabled extensions, and update them if messaging wiki has a different version
	 */
	public function processExtensions() {
		global $wgExtensionMessagesFiles;

		foreach ( $wgExtensionMessagesFiles as $extension => $filePath ) {
			require $filePath;
			$changed = 0;
			/** @var array $messages */
			foreach ( $messages as $lang => $translations ) {
				if ( !isset( $this->messages[$lang] ) ) {
					continue;
				}

				foreach ( $translations as $key => $text ) {
					if ( isset( $this->messages[$lang][$key] ) &&
						$this->messages[$lang][$key] !== $messages[$lang][$key]
					) {
						$messages[$lang][$key] = $this->messages[$lang][$key];
					}
				}
			}

			if ( $changed === 0 ) {
				$this->output( "Nothing to update in $extension ($filePath).\n" );
			} else {
				$this->output( "Found $changed messages to update in $extension ($filePath). Updating...\n" );
				$this->updateI18nFile( $extension, $filePath, $messages );
			}
		}
	}

	/**
	 * Regenerate a PHP i18n file
	 * @param string $extension Extension name
	 * @param string $filePath i18n file path in app repo
	 * @param array $messages Messages array in the same format as in i18n files
	 */
	protected function updateI18nFile( $extension, $filePath, array $messages ) {
		$contents = "<?php\n";
		$contents .= "/** Internationalization file for $extension extension. */\n";
		$contents .= "\$messages = [];\n\n";

		foreach ( $messages as $lang => $translations ) {
			$contents .= "\$messages['$lang'] = [\n";
			foreach ( $translations as $key => $text ) {
				$contents .= "\t'$key' => '$text',\n";
			}
			$contents .= "];\n\n";
		}

		if ( $this->isDryRun ) {
			$file = tempnam( sys_get_temp_dir(), "$extension.i18n.php" );
		} else {
			$file = $filePath;
		}

		$res = file_put_contents( $file, $contents );

		if ( $res === false ) {
			$this->output( "Failed to update $file.\n" );
		} else {
			$this->output( "Successfully updated $file.\n" );
		}
	}
}

$maintClass = ImportMessagingWiki::class;
require_once RUN_MAINTENANCE_IF_MAIN;
