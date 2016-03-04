<?php
namespace Wikia\ExactTarget;

use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Util\Assert;

class ExactTargetWikiTask extends BaseTask {

	private $client;

	const STATUS_OK = 'OK';

	public function __construct( $client = null ) {
		$this->client = $client;
	}

	/**
	 * Update wiki or create if doesn't exist
	 * @param int $wikiId
	 * @param array $wikiData
	 * @return string
	 * @throws \Wikia\Util\AssertionException
	 */
	public function updateWiki( $wikiId, array $wikiData ) {
		Assert::true( !empty( $wikiId ), 'Wiki ID missing' );

		$client = $this->getClient();

		/* Update or create Wiki in external service */
		$client->updateWiki( $wikiId, $wikiData );

		return self::STATUS_OK;
	}

	/**
	 * Delete wiki and categories mapping
	 * @param int $wikiId
	 * @return string
	 * @throws \Wikia\Util\AssertionException
	 */
	public function deleteWiki( $wikiId ) {
		Assert::true( !empty( $wikiId ), 'Wiki ID missing' );

		$client = $this->getClient();
		$oldCategories = $client->retrieveWikiCategories( $wikiId );

		Assert::true( !is_array( $wikiId ), 'Missing wiki categories' );
		/* Delete wiki and categories mapping */
		$client->deleteWikiCategoriesMapping( $oldCategories );
		$client->deleteWiki( $wikiId );

		return self::STATUS_OK;
	}

	/**
	 * Update wiki categories mapping
	 * @param int $wikiId
	 * @return string
	 * @throws \Wikia\Util\AssertionException
	 */
	public function updateWikiCategoriesMapping( $wikiId ) {
		Assert::true( !empty( $wikiId ), 'Wiki ID missing' );

		$client = $this->getClient();
		$oldCategories = $client->retrieveWikiCategories( $wikiId );

		Assert::true( !is_array( $wikiId ), 'Missing wiki categories' );
		$client->deleteWikiCategoriesMapping( $oldCategories );

		$oWikiFactoryHub = new \WikiFactoryHub();
		$aCategories = $oWikiFactoryHub->getWikiCategories( $wikiId );

		/* Update or create Wiki in external service */
		$client->updateWikiCategoriesMapping( $aCategories );

		return self::STATUS_OK;
	}

	protected function getClient() {
		if ( !isset( $this->client ) ) {
			$this->client = new ExactTargetClient();
		}
		return $this->client;
	}
}
