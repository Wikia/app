<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\Lucene\CrossWikiLucene
 * @author relwell
 *
 */
namespace Wikia\Search\QueryService\Select\Lucene;
/**
 * This is the version of Lucene with the cross-wiki core.
 * @author relwell
 */
class CrossWikiLucene extends Lucene
{
	/**
	 * Because this service uses a different core, we need different requested fields.
	 * @var array
	 */
	protected $requestedFields = [
				'id',
				'headline_txt',
				'wam_i',
				'description',
				'sitename_txt',
				'url',
				'articles_i',
				'videos_i',
				'images_i',
				'image_s',
				'hot_b',
				'promoted_b',
				'new_b',
				'official_b',
				'hub_s',
				'lang_s'
			];
	
	protected $core = 'xwiki';
}