<?php
/**
 * Michał Roszka (Mix) <michal@wikia-inc.com>
 * 
 * The Special:SpamWikis staff tool.
 * 
 * Controller handling all the AJAX requests.
 */
class SpecialSpamWikisController extends WikiaController {
    /*
     * The constructor
     */
    public function __construct() {
        parent::__construct();
    }
    
    /*
     * Returns the list of wikis matching the specified criteria and options.
     */
    public function getSpamWikis() {
        // access control
        if ( !$this->wg->User->isAllowed( 'specialspamwikis' ) ) {
            return null;
        }
        
        // the input data: setting the default or the actual values if provided
        $loop = $this->request->getInt( 'loop', 0 );
        $limit = $this->request->getInt( 'limit', 0 );
        $offset = $this->request->getInt( 'offset', 0 );
        $wiki = $this->request->getVal( 'wiki', null );
        $criteria = $this->request->getVal( 'criteria', '' );
        
        // the input data: processing
        $criteria = explode( ',', $criteria );
        
        // the input data: handle unsupported or malformed $order
        $order = 'city_created DESC';        
        $matches = array();
        
        $match = preg_match_all( '/^(wiki|created):(asc|desc)$/', $this->request->getVal( 'order', 'created:desc' ), $matches);
        if ( $match ) {
            $order = str_replace(
                    array( 'wiki',     'created'      ),
                    array( 'city_url', 'city_created' ),
                    "{$matches[1][0]} {$matches[2][0]}"
            );
        }
        
        // fetch the data
        $data = new SpecialSpamWikisData();
        $list = $data->getList($limit, $offset, $wiki, $criteria, $order);
        
        // prepare the output
        $this->response->setVal( 'sEcho', $loop );
        $this->response->setVal( 'iTotalRecords', $limit );
        $this->response->setVal( 'iTotalDisplayRecords', $list['count'] );
        $this->response->setVal( 'sColumns', 'close,wiki,created,founder,email' );
        $this->response->setVal( 'aaData', $list['items'] );
    }
    /**
     * a StaffLog::formatRow hook
     * 
     * Formats a log entry to be displayed on Special:StaffLog
     */
    public static function formatLog($type, $result, $time, $linker, &$out) {
        if ( 'spamwiki' == $type ) {
            $l = new Linker();
            $out = "{$time} {$type} - user {$l->userLink( $result->slog_user, $result->slog_user_name )} {$result->slog_comment}.";
        }
        return true;
    }
}