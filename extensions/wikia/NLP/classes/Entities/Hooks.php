<?php
/**
 * Class definition for Wikia\NLP\Entities\Hooks
 */
namespace Wikia\NLP\Entities;
/**
 * This class is for registering MediaWiki hooks against
 * @author relwell
 */
class Hooks
{

	/**
	 * Registers DFP key values for entities
	 * @param Article $article
	 * @param bool $outputDone
	 * @param bool $pcache
	 * @return boolean
	 */
	public static function onArticleViewHeader( &$article, &$outputDone, &$pcache ) {
		(new WikiEntitiesService)->registerEntitiesWithDFP();
		return true;
	}
	
}