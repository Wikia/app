<?php
/**
 * Class definition for WikiaSearchAjaxController
 */
use Wikia\Search\QueryService;
/**
 * Responsible for handling AJAX requests in search.
 * @author relwell
 * @package Search
 * @subpackage Controller
 */
class WikiaSearchAjaxController extends WikiaController {

    const RESULTS_PER_PAGE = 25;

    /**
     * Handles accessing paginated results via AJAX.
     */
    public function getNextResults(){
        $this->wf->ProfileIn(__METHOD__);

        $this->response->setVal('status', true);

        $query = $this->request->getVal('query', $this->request->getVal('search'));
        $query = htmlentities( Sanitizer::StripAllTags ( $query ), ENT_COMPAT, 'UTF-8' );

        $page = $this->request->getVal('page', 1);
        $rank = $this->request->getVal('rank', 'default');
        $crossWikia = $this->request->getBool('crossWikia');
        $hub = false;

        $isCorporateWiki = !empty($this->wg->EnableWikiaHomePageExt);

        $isInterWiki = $crossWikia ? true : $isCorporateWiki;

        $cityId = $isInterWiki ? 0 : $this->wg->CityId;

        $params = array(
			'page'			=>	$page,
			'length'		=>	self::RESULTS_PER_PAGE,
			'cityId'		=>	$cityId,
			'rank'			=>	$rank,
			'hub'			=>	$hub,
			'query'			=>	$query,
		);
        $config = new Wikia\Search\Config( $params );
        $config->setIsInterWiki( $isInterWiki )
               ->setGroupResults( $isInterWiki );
        $results = (new QueryService\Factory)->getFromConfig( $config )->search();

        $text = $this->app->getView('WikiaSearch', 'WikiaMobileResultList', array(
                'currentPage'=> $page,
                'isInterWiki' => $isInterWiki,
                'relevancyFunctionId' => 6,
                'results' => $results,
                'resultsPerPage' => self::RESULTS_PER_PAGE,
                'query' => $query)
        )->render();

        $this->response->setVal('text', $text);
        $this->wf->ProfileOut(__METHOD__);
    }
}