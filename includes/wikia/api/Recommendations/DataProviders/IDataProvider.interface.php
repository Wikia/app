<?php
namespace Wikia\Api\Recommendations\DataProviders;

interface IDataProvider {
	public function get( $articleId, $limit );
}
