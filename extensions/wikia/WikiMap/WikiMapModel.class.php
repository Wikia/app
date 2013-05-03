<?php
class WikiMapModel extends WikiaObject {
    private $title = null;

    public function __construct(Title $currentTitle = null) {
        parent::__construct();
        $this->title = $currentTitle;
    }
    private function getDB(){
        return wfgetDB(DB_SLAVE, array(), $this->app->wg->DBname);
    }
    /*
        Method that returns required data to draw wikiMap
        Parameter: Name of Category, provided as a parameter
    */
    public function getColours(){

        wfProfileIn( __METHOD__ );

            $result = SassUtil::getOasisSettings();
            $colours['line'] = $result['color-buttons'];
            $colours['labels'] = $result['color-links'];
            $colours['body'] = $result['color-page'];

        wfProfileOut( __METHOD__ );
        return $colours;

    }

    public function getListOfCategories(){

        wfProfileIn( __METHOD__ );

        $key = wfMemcKey('wikiMap', 'categories' );
        $data = $this->app->wg->memc->get($key);

        if (is_array($data)){
            $out = $data;
        }
        else
        {
            $result = ApiService::call(array('action' =>'query',
                'list' => 'querypage',
                'qppage' => 'Mostpopularcategories',
                'qplimit' => '20'));
            $result = $result['query']['querypage']['results'];
            $i = 0;
            $res = array();
            foreach($result as $item){
                $res[] = array('title' => $item['title'], 'titleNoSpaces' => str_replace(' ', '_', $item['title']));
                $i++;
            }
            $out = array('data' => $res, 'length' => $i);
            $this->app->wg->memc->set($key, $out, 86400);
        }
        wfProfileOut( __METHOD__ );
        return $out;
    }

    public function getActualNamespace(){

        return $this->app->wg->Title->getNamespace();

    }

    private function getMostRevisedArticles(){

        wfProfileIn( __METHOD__ );

        $result = ApiService::call(array('action' =>'query',
            'list' => 'querypage',
            'qppage' => 'Mostrevisions',
            'qplimit' => '120'
        ));

        $result = $result['query']['querypage']['results'];
        $res = array();
        $map = array();
        foreach ($result as $i => $item){
            if ($item['ns'] == 0){
                $title = Title::newFromText($item['title']);
                if($title instanceof Title)  {
                    $articleId = $title->getArticleId();
                    $res[] = array('title' => $item['title'], 'id' => $articleId, 'connections' => array());
                    $map[$item['title']] = $i;
                }
            }
        }
        $query = $this->query($res, $map);
        $new = array( 'nodes' => $query, 'all' => 0);

        wfProfileOut( __METHOD__ );

        return $new;

    }

    private function getMostPopularArticlesFromCat($Category){

        wfProfileIn( __METHOD__ );

        //Getting list of articles belonging to specified category using API
        $result = ApiService::call(array('action' =>'query',
            'list' => 'categorymembers',
            'cmtitle' => 'Category:' . $Category,
            'cmnamespace' => '0',
            'cmlimit' => '5000'
        ));

        //Preparing arrays to be used as parameters for next method
        $result = $result['query']['categorymembers'];
        $ids = array();

        foreach ($result as $item){
            $ids[] = $item['pageid'];
        }
        $allArticlesCount = count($ids);
        $dbr = $this->getDB();
        $resultSecondQuery = array();
        $newquery = $dbr->select(
            array( 'revision', 'page' ),
            array( 'page_id',
                'page_title AS title',
                'COUNT(*) AS value'),
            array( 'page_id = rev_page', 'page_id' => $ids),
            __METHOD__,
            array ('GROUP BY' => 'page_title',
                'ORDER BY' => 'value desc',
                'LIMIT' => '120')
        );
        while ($row = $dbr->fetchObject($newquery)){
            $resultSecondQuery[] = $row;
        };
        $res = array();
        $map = array();
        foreach ($resultSecondQuery as $i => $item){
            $articleTitle = str_replace('_', ' ', $item->title);
            $res[] = array('title' => $articleTitle, 'id' => $item->page_id, 'connections' => array());
            $map[$articleTitle] = $i;
        }
        $new = array( 'nodes' => $this->query($res, $map), 'all' => $allArticlesCount);

        wfProfileOut( __METHOD__ );

        return $new;
    }

    public function getArticles($Category){

        wfProfileIn( __METHOD__ );
        $result = null;

        $key = wfMemcKey( 'wikiMap', 'articles', $Category );
        //$data = $this->app->wg->memc->get($key);
        $data=null;
        if (is_array($data)){
            $new = $data;
        }
        else
        {
            //If there is no parameter specified, wikiMap will base on list of articles with most revisions
            if(is_null($Category)){

                $new =  $this->getMostRevisedArticles();
                $this->app->wg->memc->set($key, $new, 86400);
            }

            else{

                $new = $this->getMostPopularArticlesFromCat($Category);
                $this->app->wg->memc->set($key, $new, 900);
            }

        }

        $max=0;
        foreach($new['nodes'] as $item){
            $localMax = count($item['connections']);
            if ($localMax > $max) $max = $localMax;
        }

        wfProfileOut( __METHOD__ );
        return array('nodes' => $new['nodes'], 'length' =>count($new['nodes']), 'max' => $max, 'all' => $new['all']);
    }

    //Method that performs query to database and format the data
    private function query($item, $map){

        wfProfileIn( __METHOD__ );

        $dbr = $this->getDB();
        $keysRev = array();
        $withoutSpace = array();
        $keys = array();
        $revertIDs = array();
        for($i = 0; $i < count($item); $i++){
            $withoutSpace[$i] = str_replace(' ', '_', $item[$i]['title']);
            $keys[$i] = $item[$i]['id'];
            $keysRev[$item[$i]['id']] = $i;

            $revertIDs[$item[$i]['id']] = $item[$i]['title'];
        }

        //Performing query to database
        $result = $dbr->select(
            array( 'pagelinks' ),
            array( 'pl_from', 'pl_title' ),
            array( 'pl_from' => $keys, 'pl_title' => $withoutSpace),
            __METHOD__);

        while ($row = $dbr->fetchObject($result)){
            $item[$keysRev[$row->pl_from]]['connections'][] = $map[str_replace('_', ' ', $row->pl_title)];
        };

        wfProfileOut( __METHOD__ );
        return $item;
    }
}
