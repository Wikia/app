<?php


class ArticleTypeService  /*extends AbstractService*/ {

	/**
	 * Returns article type for given (wikiId, pageId) pair
	 * @param int $wikiId
	 * @param int $pageId
	 * @return string|null
	 */
	public function getArticleType( $wikiId, $pageId ) {
		//curl -X POST -H "Content-Type: application/json" "http://dev-arturd:8080/holmes/classifications/" --data "{\"title\": \"John Price\", \"wikiText\": \"asdfasfd\"}"


		$art = Article::newFromID(50);
		var_dump($art->getTitle()->getText());
		var_dump($art->getPage()->getRawText());
		$ch= curl_init();
		curl_setopt($ch,CURLOPT_URL, 'http://dev-arturd:8080/holmes/classifications/');
		cur_setopt($ch,CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, "{\"title\": \"John Price\", \"wikiText\": \"asdfasfd\"}");
		curl_setopt($ch,CURLOPT_HTTPHEADER,[ 'Content-Type: application/json' ] );

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		var_dump($result);
//close connection
		curl_close($ch);
	}
}
