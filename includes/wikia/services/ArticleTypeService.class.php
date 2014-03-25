<?php


class ArticleTypeService {
	const KNOWLEDGE_DB = "dataknowledge";

	/**
	 * @var DatabaseBase
	 */
	private $knowledgeDbConnection = null;

	function __construct( DatabaseBase $knowledgeDbConnection = null ) {
		if ( $knowledgeDbConnection == null ) {
			$knowledgeDbConnection = wfGetDB( DB_SLAVE, array(), self::KNOWLEDGE_DB);
		}

		$this->knowledgeDbConnection = $knowledgeDbConnection;
	}

	/**
	 * Returns article type for given (wikiId, pageId) pair
	 * @param int $wikiId
	 * @param int $pageId
	 * @return string|null
	 */
	public function getArticleType( $wikiId, $pageId ) {
		return (new WikiaSQL())->SELECT("a.type")
			->FROM("article_types")->AS_("a")
				->LEFT_OUTER_JOIN("wiki_types")->AS_("w")->ON("a.wiki_id = w.wiki_id")
			->WHERE("(w.type IS NULL OR w.type = 'canonical')")
				->AND_("a.wiki_id")->EQUAL_TO( $wikiId )
				->AND_("a.page_id")->EQUAL_TO( $pageId )
			->cache( 60 * 60 )
			->run( $this->knowledgeDbConnection, function( ResultWrapper $result ) {
				$row = $result->fetchObject( $result );

				if ( $row && isset( $row->type ) ) {
					return $row->type;
				}

				return null;
			});
	}
}
