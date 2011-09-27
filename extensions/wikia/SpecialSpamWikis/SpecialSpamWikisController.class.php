<?php
/**
 * 
 */
class SpecialSpamWikisController extends WikiaController {
    public function __construct() {
        parent::__construct();
    }
    
    public function getSpamWikis() {
        if ( !$this->wg->User->isAllowed( 'specialspamwikis' ) ) {
            return null;
        }
        
        $loop = $this->request->getInt( 'loop', 0 );
        $limit = $this->request->getInt( 'limit', 0 );
        $offset = $this->request->getInt( 'offset', 0 );
        $wiki = $this->request->getVal( 'wiki', null );
        $criteria = $this->request->getVal( 'criteria', '' );
        
        $criteria = explode( ',', $criteria );
        
        $data = new SpecialSpamWikisData();
        $list = $data->getList($limit, $offset, $wiki, $criteria);
        
        $this->response->setVal( 'sEcho', $loop );
        $this->response->setVal( 'iTotalRecords', $limit );
        $this->response->setVal( 'iTotalDisplayRecords', $list['count'] );
        $this->response->setVal( 'sColumns', 'close,wiki,created,founder,email' );
        $this->response->setVal( 'aaData', $list['items'] );
    }
}