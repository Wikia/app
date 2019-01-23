<?php

interface FandomArticleService {
	public function getTrendingFandomArticles( int $limit ): array;
}
