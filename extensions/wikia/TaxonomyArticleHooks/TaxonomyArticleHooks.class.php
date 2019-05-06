<?php

use Wikia\Rabbit\ConnectionBase;

/**
 * @author Lore team
 *
 * Something
 */

use Wikia\Tasks\Tasks\GenerateArticlePlaintextTask;

class TaxonomyArticleHooks {

	static public function onArticleSaveComplete($article) {
        global $wgCityId;

        $task = new GenerateArticlePlaintextTask();
        $task->wikiId( $wgCityId );
        $task->call( 'generateArticlePlaintext', $wgCityId, $article );
        $task->queue();

        return true;
	}
}
