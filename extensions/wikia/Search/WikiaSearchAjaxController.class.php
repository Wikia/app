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

    /**
     * Handles accessing paginated results via AJAX.
     */
    public function getNextResults(){
        wfProfileIn(__METHOD__);

        $this->response->setVal('status', true);

        $query = $this->request->getVal('query', $this->request->getVal('search'));

        $page = $this->request->getVal('page', 1);
        $rank = $this->request->getVal('rank', 'default');
        $crossWikia = $this->request->getBool('crossWikia');
        $hub = false;

        $isCorporateWiki = !empty($this->wg->EnableWikiaHomePageExt);

        $isInterWiki = $crossWikia ? true : $isCorporateWiki;

        $cityId = $isInterWiki ? 0 : $this->wg->CityId;

        $resultsPerPage = $isInterWiki ? WikiaSearchController::INTERWIKI_RESULTS_PER_PAGE : WikiaSearchController::RESULTS_PER_PAGE;
        $resultsPerPage = empty( $this->wg->SearchResultsPerPage ) ? $resultsPerPage : $this->wg->SearchResultsPerPage;
        $params = array(
			'page'   => $page,
			'limit'  => $resultsPerPage,
			'cityId' => $cityId,
			'rank'   => $rank,
			'hub'    => $hub,
		);
        $config = new Wikia\Search\Config( $params );
        $config->setInterWiki( $isInterWiki )
               ->setQuery( $query );
        $results = (new QueryService\Factory)->getFromConfig( $config )->search();

        $text = $this->app->getView('WikiaSearch', 'WikiaMobileResultList', array(
                'currentPage'=> $page,
                'isInterWiki' => $isInterWiki,
                'relevancyFunctionId' => 6,
                'results' => $results,
                'resultsPerPage' => $resultsPerPage,
                'query' => $config->getQuery()->getQueryForHtml())
        )->render();

        $this->response->setVal('text', $text);
        wfProfileOut(__METHOD__);
    }
}