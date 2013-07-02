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
	protected $core = 'xwiki';
}