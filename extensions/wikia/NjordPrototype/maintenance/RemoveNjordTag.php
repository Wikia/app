<?php
/**
 * Maintenance script for removing NJORD (MOM)
 * Usage: $ SERVER_ID=1 php /usr/wikia/source/wiki/extensions/wikia/NjordPrototype/maintenance/RemoveNjordTag.php
 */

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class RemoveNjordTag extends Maintenance {
	/**
	 * Duplicated with NjordUsage script;
	 * Not refactoring as a part of feature sunset process
	 */
	const NJORD_ARTICLE_PROP_TITLE = 'TITLE';
	const NJORD_ARTICLE_PROP_DESCR = 'DESCRIPTION';
	const NJORD_ARTICLE_PROP_IMAGE = 'IMAGE';
	const NJORD_ARTICLE_CROP_POSITION = 'CROP_POSITION';
	const WIKI_CREATION_DATE = 'WIKI_CREATION_DATE';

	private $dryRun = true;

	function __construct() {
		$this->addOption( 'process', 'Do the real operation. As the operation is destructive, without this flag it will only perform dry-run' );
		parent::__construct();
	}

	public function execute() {
		global $wgDBname, $wgUser;

		// attribute automated edits to FandomBot
		$wgUser = User::newFromName( Wikia::BOT_USER );

		$this->dryRun = !$this->hasOption( 'process' );

		if ( $this->dryRun ) {
			$this->output( 'Dry run for ' . $wgDBname . PHP_EOL );
		} else {
			$this->output( PHP_EOL );
			$this->output( '!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!' . PHP_EOL );
			$this->output( 'REAL DESTRUCTIVE OPERATION: Removal for ' . $wgDBname . PHP_EOL );
			$this->output( '!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!' . PHP_EOL );
			$this->output( PHP_EOL );
		}

		$this->removeTag();
		$this->removeNjordPagePropsData();
		$this->output( PHP_EOL );

		$this->output( $wgDBname . ': cleanup completed' . PHP_EOL );
	}

	private function removeTag() {
		$this->output( 'Removing tag from pages' . PHP_EOL );

		$regex = "<hero[^>]+?/>\n";

		$title = Title::newMainPage();
		$page = new Article( $title );
		$content = $page->getContent();
		$newContent = mb_ereg_replace( $regex, '', $content );

		if(!$this->dryRun && $content !== $newContent) {
			$this->output( 'Saving change' . PHP_EOL );
			$page->doEdit( $newContent, 'Removal of a deprecated <hero> tag' );
		} else {
			$this->output( 'Dry run; Real one would change:' . PHP_EOL );
			$this->output( $content . PHP_EOL );
			$this->output( 'to:' . PHP_EOL );
			$this->output( $newContent . PHP_EOL );
		}
	}

	private function removeNjordPagePropsData() {
		if ( $this->dryRun ) {
			$this->output( 'Dry run; would remove data from page props' . PHP_EOL );
		} else {
			$this->output( 'Removing data from page_props' . PHP_EOL );

			$db = wfGetDB( DB_MASTER );

			$sql = ( new WikiaSQL() )
				->DELETE()
				->FROM( 'page_wikia_props' )
				->WHERE( 'propname' )
				->IN( array_values( $this->getNjordPropIds() ) );

			$sql->run( $db );
		}
	}

	private function getNjordPropIds() {
		return [
			self::NJORD_ARTICLE_PROP_DESCR => WikiDataModel::WIKI_HERO_DESCRIPTION_ID,
			self::NJORD_ARTICLE_PROP_TITLE => WikiDataModel::WIKI_HERO_TITLE_PROP_ID,
			self::NJORD_ARTICLE_PROP_IMAGE => WikiDataModel::WIKI_HERO_IMAGE_PROP_ID,
			self::NJORD_ARTICLE_CROP_POSITION => WikiDataModel::WIKI_HERO_IMAGE_CROP_POSITION_ID
		];
	}
}

$maintClass = 'RemoveNjordTag';
require_once( DO_MAINTENANCE );
