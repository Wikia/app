<?php
require_once __DIR__ . '/../Maintenance.php';

class ImportMessagingWiki extends Maintenance {

	/** @var string MESSAGING_WIKI_DB messaging wiki database name */
	const MESSAGING_WIKI_DB = 'messaging';

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
		$this->addOption( 'message', 'Message name to process', false, true /* $withArg */ );
		$this->addOption( 'prefix', 'Prefix for messages to process (e.g. "achievements-")', false, true /* $withArg */ );
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
		$sql = ( new WikiaSQL() )
			->SELECT( 'page_title', 'old_text', 'old_flags' )
			->FROM( 'page, revision, text' )
			->WHERE( 'page_namespace' )
			->EQUAL_TO( NS_MEDIAWIKI )
			->AND_( 'page_is_redirect' )
			->EQUAL_TO( 0 )
			->AND_( 'page_latest' )
			->EQUAL_TO_FIELD( 'rev_id' )
			->AND_( 'rev_text_id' )
			->EQUAL_TO_FIELD( 'old_id' );

		# handle --message argument
		$msg = $this->getOption('message');
		if ($msg) {
			# AND page_title LIKE 'Autocreatewiki-welcomebody/%'
			$sql->AND_('page_title')->LIKE( ucfirst( $msg ) . '/%' );
		}

		# handle --prefix argument
		$prefix = $this->getOption('prefix');
		if ($prefix) {
			# AND page_title LIKE 'Achievements-%'
			$sql->AND_('page_title')->LIKE( ucfirst( $prefix ) . '%' );
		}

		$res = $sql->runLoop( $db, function ( &$res, $row ) use ( &$i, $wgContLang ) {
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

			$res['messages'][$lang] = $res['messages'][$lang] ?? [];
			$res['messages'][$lang][$key] = $text;
			$i++;
		} );

		$this->messages = $res['messages'];

		$this->output( "Found $i messages in messaging DB.\n" );
		if ( $this->isDryRun ) {
			$this->output( "Running in dry run mode. Existing i18n files will not be changed.\n" );
		}

		return !empty( $this->messages );
	}

	/**
	 * @return array
	 */
	private function getMessagesFiles() {
		global $wgExtensionMessagesFiles;

		return array_unique(
			array_merge(
				GlobalMessagesService::getInstance()->getCoreMessageFiles(),
				GlobalMessagesService::getInstance()->getExtensionMessageFiles(),
				$wgExtensionMessagesFiles
			)
		);
	}

	/**
	 * Process all i18n files of enabled extensions, and update them if messaging wiki has a different version
	 */
	public function processExtensions() {
		foreach ( $this->getMessagesFiles() as $extension => $filePath ) {
			require $filePath;
			$changed = 0;
			/** @var array $messages */

			// iterate over data from Messaging Wiki and uodate i18n files when neeeded
			// this will also import values for languages defined on Messaging Wiki only
			foreach ( $this->messages as $lang => $translations ) {
				foreach ( $translations as $key => $text ) {
					if (
						( !isset( $messages[$lang][$key] ) && isset( $messages['en'][$key] ) ) // Messaging Wiki-powered localisation (entry in i18n file for English only)
						||
						( isset( $messages[$lang][$key] ) && ( $this->messages[$lang][$key] !== $messages[$lang][$key] ) ) ) // messages defined in both i18n and on Messaging Wiki
					{
						$messages[$lang][$key] = $this->messages[$lang][$key];
						$changed++;
					}
				}
			}

			if ( $changed === 0 ) {
				$this->output( "Nothing to update in $extension ($filePath).\n" ); // XXX: DEBUG
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
				$text = str_replace( "'", "\\'", $text );
				$contents .= "\t'$key' => '$text',\n";
			}
			$contents .= "];\n\n";
		}

		if ( $this->isDryRun ) {
			$file = tempnam( sys_get_temp_dir(), "$extension.i18n.php" );
			$this->output( "Stored i18n file in {$file} temporary file\n");
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
