<?php
class wikiMap extends WikiaObject {
    private $title = null;

    public function __construct(Title $currentTitle = null) {
        parent::__construct();
        $this->title = $currentTitle;
    }
    public function getDB(){
        return $this->app->wf->getDB(DB_SLAVE, array(), $this->app->wg->DBname);
    }
    /*
        Method that returns required data to draw wikiMap
        Parameter: Name of Category, provided as a parameter
    */
    public function getColours(){

        $this->app->wf->profileIn( __METHOD__ );

        $result = SassUtil::getOasisSettings();
        $colours['line'] = $result['color-buttons'];
        $colours['labels'] = $result['color-links'];
        $colours['body'] = $result['color-page'];

        $this->app->wf->profileOut( __METHOD__ );
        return $colours;

    }
    public function getArticles($Category){
        $this->app->wf->profileIn( __METHOD__ );

        $result = null;

        //If there is no parameter specified, wikiMap will base on list of articles with most revisions
        if(is_null($Category)){
            $result = ApiService::call(array('action' =>'query',
                'list' => 'querypage',
                'qppage' => 'Mostrevisions',
                'qplimit' => '120'
            ));
            $result=$result['query']['querypage']['results'];
            //var_dump($result);
            $res = array();
            $map = array();
            foreach ($result as $i => $item){
                if ($item['ns']==0){
                    $res[] = array('title' => $item['title'], 'id' => $item['value'], 'connections' => array());
                    $map[$item['title']] = $i;
                }
            }
        }

        else
        {

            //Getting list of articles belonging to specified category using API
            $result = ApiService::call(array('action' =>'query',
                                'list' => 'categorymembers',
                                'cmtitle' => 'Category:' . $Category,
                                'cmnamespace' => '0',
                                'cmlimit' => '120'
                ));

            //Preparing arrays to be used as parameters for next method
            $result = $result['query']['categorymembers'];

        $res = array();
        $map = array();
        foreach ($result as $i => $item){
                    $res[] = array('title' => $item['title'], 'id' => $item['pageid'], 'connections' => array());
                    $map[$item['title']] = $i;
        }
        }
        $max=0;


        $new = $this->query($res, $map);
        foreach($new as $item){
            $localMax = count($item['connections']);
            if ($localMax>$max) $max=$localMax;
        }
        //var_dump($max);

        $this->app->wf->profileOut( __METHOD__ );
        return array('nodes' => $new, 'length' =>count($new), 'max' => $max);
    }

    //Method that performs query to database and format the data
    public function query($item, $map){

        $this->app->wf->profileIn( __METHOD__ );

        $dbr = $this->getDB();
        $revertIDs = array();
        for($i = 0; $i<count($item); $i++){
            $withoutSpace[$i] = str_replace(' ', '_', $item[$i]['title']);
            $keys[$i] = $item[$i]['id'];
            $revertIDs[$item[$i]['id']] = $item[$i]['title'];
        }

        //Performing query to database
        $result = $dbr->select(
            array( 'pagelinks' ),
            array( 'pl_from', 'pl_title' ),
            array( 'pl_from' => $keys, 'pl_title' => $withoutSpace),
            __METHOD__);

        while ($row = $this->getDB()->fetchObject($result)){
            $item[$map[str_replace('_', ' ', $row->pl_title)]]['connections'][] = $map[$revertIDs[$row->pl_from]];
        };

        $this->app->wf->profileOut( __METHOD__ );
        return $item;
    }
}