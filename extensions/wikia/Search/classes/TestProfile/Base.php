<?php
/**
 * Class definition for Wikia\Search\TestProfile\Base
 */
namespace Wikia\Search\TestProfile;
/**
 * This class provides for default values for our search A/B testing platform.
 * The default values here allow us to treat all search requests identically, 
 * and to specify new test groups as extensions of this class.
 * The base profile is for users who do not belong to an A/B group.
 * In order to keep backend/front-end parity, we should create a TestProfile instance for 
 * each experimental group, extending from Base. This group does _not_ need any additional logic if,
 * for instance, we are only testing front-end changes.
 * @author relwell
 */
class Base
{
	/**
	 * Query fields to boosts for the main core
	 * @var array
	 */
	protected $defaultQueryFields = [
			'title'             => 100,
			'html'              => 5,
			'redirect_titles'   => 50,
			'categories'        => 25,
			'nolang_txt'        => 10,
			'backlinks_txt'     => 25,
			];
	
	/**
	 * Query fields to boost for the cross-wiki core
	 * @var unknown_type
	 */
	protected $interWikiQueryFields = [
			'headline_txt' => 300,
			'description' => 250,
			'categories' => 50,
			'articles' => 75,
			'top_categories' => 150,
			'top_articles' => 200,
			'sitename_txt' => 500
			];
	
	/**
	 * Language-specific fields added for i18n
	 * @var unknown_type
	 */
	protected $videoQueryFields = [
			'title'                 => 100,
			'html'                  => 5,
			'redirect_titles'       => 50,
			'categories'            => 25,
			'nolang_txt'            => 10,
			'backlinks_txt'         => 25,
			'title_en'              => 100,
			'html_en'               => 5,
			'redirect_titles_mv_en' => 50,
			'video_actors_txt'      => 100,
			'video_genres_txt'      => 50,
			'html_media_extras_txt' => 20,
			'video_description_txt' => 100,
			'video_keywords_txt'    => 60,
			'video_tags_txt'        => 40,
			];
	
	protected $tieParams = [
			'default' => 0.01,
			];
	
	
	/**
	 * Returns query fields to be injected into the config.
	 * @return array
	 */
	public function getQueryFieldsToBoosts( $queryService = null ) {
		switch ( $queryService ) {
		    case '\\Wikia\\Search\\QueryService\\Select\\Dismax\\InterWiki':
		    	return $this->interWikiQueryFields;
		    case '\\Wikia\\Search\\QueryService\\Select\\Dismax\\Video':
		    case '\\Wikia\\Search\\QueryService\\Select\\Dismax\\VideoEmbedTool':
		    case '\\Wikia\\Search\\QueryService\\Select\\Dismax\\CombinedMedia':
		    	return $this->videoQueryFields;
		}
		return $this->defaultQueryFields;
	}
	
	/**
	 * Provides a tie param configured for the provided query service, with a default back-off
	 * @return int
	 */
	public function getTieParam( $queryService = null ) {
		$key = 'default';
		if ( ( $queryService !== null ) && isset( $this->tieParams[$queryService] ) ) {
			$key = $queryService;
		}
		return $this->tieParams[$key];
	}
	
}