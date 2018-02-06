<?php

namespace Wikia\Tasks\Tasks;

use Article;
use Revision;

class TagsReportTask extends BaseTask {
	const TAGS = [
		"activityfeed" => "<activityfeed(.*?)>",
		"ask" => "\{\{#ask",
		"badge" => "<badge(.*?)>",
		"bloglist" => "<bloglist(.*?)>",
		"categorytree" => "<categorytree(.*?)>",
		"chem" => "<chem>",
		"chess" => "<chess>",
		"choose" => "<choose(.*?)>",
		"createbox" => "<createbox(.*?)>",
		"dpl" => "\{\{\#dpl|<dpl>|\{\{#dplchapter|<dynamicpagelist>",
		"embed" => "<embed(.*?)>",
		"fb_like" => "<fb:like-box(.*?)>",
		"fb_stream" => "<fb:live-stream(.*?)>",
		"flite" => "<flite(.*?)>",
		"gallery" => "<gallery(.*?)>",
		'googlecalendar' => "<googlecalendar(.*?)>",
		"googleform" => "<googleform(.*?)>",
		"googlemap" => "<googlemap(.*?)>",
		"googlespreadsheet" => "<googlespreadsheet(.*?)>",
		"iframe" => "<iframe(.*?)>",
		"imagelink" => "<imagelink(.*?)>",
		"imagemap" => "<imagemap(.*?)>",
		"infobox" => "<infobox(.*?)>",
		"inputbox" => "<inputbox(.*?)>",
		"linkedimage" => "<linkedimage>",
		"jwplayer" => "<jwplayer(.*?)>",
		"listpages" => "<listpages(.*?)>",
		"mainpage" => "<mainpage-leftcolumn-start(.*?)>|<mainpage-endcolumn(.*?)>|<mainpage-rightcolumn-start(.*?)>",
		"math" => "<math>",
		"object" => "<object(.*?)>",
		"poem" => "<poem(.*?)>",
		"poll" => "<poll(.*?)>",
		"polldaddy" => "<polldaddy(.*?)>",
		"pollsnack" => "<pollsnack(.*?)>",
		"ppch" => "<ppch>",
		"rss" => "<rss(.*?)>",
		"slider" => '<gallery(.*?)type=([" ]*)slider([" ]+.*>|>)',
		"slideshow" => '<gallery(.*?)type=([" ]*)slideshow([" ]+.*>|>)',
		"soundcloud" => "<soundcloud(.*?)>",
		"source" => "<source(.*?)>",
		"spotify" => "<spotify(.*?)>",
		"tabview" => "<tabview(.*?)>",
		"tabber" => "\{\{#tabber|<tabber(.*?)>",
		"tex" => "<batik>|<feyn>|<go>|<greek>|<graph>|<ling>|<music>|<plot>|<schem>|<teng>|<tipa>",
		"timeline" => "<timeline(.*?)>",
		"twitter" => "<twitter(.*?)>",
		"verbatim" => "<verbatim>",
		"videogallery" => "<videogallery(.*?)>",
		"vk" => "<vk(.*?)>",
		"weibo" => "<weibo(.*?)>",
		"widget" => "<widget(.*?)>",
		"youtube" => "<youtube(.*?)>|<gvideo(.*?)>|<aovideo(.*?)>|<aoaudio(.*?)>|<wegame(.*?)>|<tangler>|<gtrailer>|<nicovideo>|<ggtube>|<cgamer>|<longtail>",
	];
	const TABLE_NAME = "city_used_tags";

	private $dbr = null;

	public function __construct() {
		$this->dbr = wfGetDB( DB_SLAVE );
	}

	public function processArticle( $pageId ) {
		$startTime = microtime(true);
		$this->removeCurrentTagsForArticle( $pageId );
		$revision = $this->getRevision( $pageId );

		if ( $revision ) {
			$numberOfFoundTags = $this->updateTagsForRevision( $revision );

			$time = round(microtime(true) - $startTime, 4);
			$this->debug( "Processing of page #{$pageId} took {$time}s ({$numberOfFoundTags} tags found)" );
		} else {
			$this->error( "Wiki {$this->getWikiId()}: failed to get the content of article #{$pageId}!" );
		}
	}

	private function removeCurrentTagsForArticle( $pageId ) {
		$this->dbr->delete( self::TABLE_NAME, [
			'ct_wikia_id' => $this->getWikiId(),
			'ct_page_id' => $pageId,
		] );
	}

	public function addTag( $pageId, $tagName ) {
		$page_namespace = ""; // TODO
		$this->debug("Page {$pageId} - tag `{$tagName}` added");

		$this->dbr->insert( self::TABLE_NAME, [
			'ct_wikia_id' => $this->getWikiId(),
			'ct_page_id' => $pageId,
			'ct_namespace' => $page_namespace,
			'ct_kind' => $this->dbw->quote( $tagName ),
			'ct_timestamp' => new \DateTime(),
		], __METHOD__ );
	}

	/**
	 * @param $page_id
	 * @return Revision
	 */
	public function getRevision( $page_id ): Revision {
		$article = Article::newFromID( $page_id );
		$revision = Revision::newFromId( $article->getTitle()->getLatestRevID() );

		return $revision;
	}

	/**
	 * @param Revision $revision
	 * @return int number of found tags
	 */
	public function updateTagsForRevision( Revision $revision ): int {
		$rev_text = $revision->getText();
		$tagsFound = 0;

		if ( $rev_text ) {
			foreach ( self::TAGS as $name => $pattern ) {
				if ( preg_match( "/{$pattern}/i", $rev_text ) ) {
					$this->addTag( $revision->getPage(), $name );
					$tagsFound++;
				}
			}
		}

		return $tagsFound;
	}
}
