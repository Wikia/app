<?PHP
/**
* AWC`s Mediawiki Forum Extension
* 
* License: <br />
* Another Web Compnay (AWC) 
* 
* All of Another Web Company's (AWC) MediaWiki Extensions are licensed under<br />
* Creative Commons Attribution-Share Alike 3.0 United States License<br />
* http://creativecommons.org/licenses/by-sa/3.0/us/
* 
* All of AWC's MediaWiki extension's can be freely-distribute, 
*  no profit of any kind is allowed to be made off of or because of the extension itself, this includes Donations.
* 
* All of AWC's MediaWiki extension's can be edited or modified and freely-distribute <br />
*  but these changes must be made public and viewable noting the changes are not original AWC code. <br />
*  A link to http://anotherwebcom.com must be visable in the source code 
*  along with being visable in render code for the public to see.
* 
* You are not allowed to remove the Another Web Company's (AWC) logo, link or name from any source code or rendered code.<br /> 
* You are not allowed to create your own code which will remove or hide Another Web Company's (AWC) logo, link or name.
* 
* This License can and will be change with-out notice. 
* 
* All of Another Web Company's (AWC) software/code/programs are distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
* 
* 4/2008 Another Web Compnay (AWC)<br />
* The above text must stay intact and not edited in any way.
* 
* @filepath /extensions/awc/forums/includes/to_wiki_dbase.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/

if ( !defined( 'MEDIAWIKI' ) ) die();



class awcs_forum_wikisearch_cls{
    

    
    var $rDB, $wDB;
    var $post, $old_post_text, $old_p_wiki_hidden, $title, $tID, $pID;
    var $text_to_save, $old_text;
    
    var $pageID, $insert_revID, $insert_textID ;
    var $time;
    
    var $mId, $mName;
    
    var $rev_comment = '';

    
    function __construct(){
    global $awcUser, $IP;
    
        $this->rDB = wfGetDB( DB_SLAVE );
        $this->wDB = wfGetDB( DB_MASTER );
        
        $this->mId = $awcUser->mId;
        $this->mName = $awcUser->mName;
        $this->time = $this->wDB->timestamp();
       // echo $this->time . "<br/>";
       
       /* 
        if ( !file_exists($IP . '/includes/AutoLoader.php')){
            require_once($IP . '/includes/SiteStats.php');
            require_once($IP . '/includes/Revision.php');
            require_once($IP . '/includes/SearchUpdate.php');
        }
        */
    }
    
    function delete_thread(){
        
        
        $this->wDB->delete( 'page', array( 'page_id' => $this->pageID ), '');
        $this->wDB->delete( 'searchindex', array( 'si_page' => $this->pageID ), '');
        $this->wDB->delete( 'revision', array( 'rev_page' => $this->pageID ), '');
                
        $u = new SiteStatsUpdate( +1, -1, -1, -1);
        $u->doUpdate();
    }
    
    function add_thread(){
        
        $this->text_to_save = $this->post . ' ' . $this->title;
        
       
        self::add_to_wiki();
        
         
        // ( $views, $edits, $good, $pages = 0, $users = 0 )
        $u = new SiteStatsUpdate( +1, 0, +1, +1);
        $u->doUpdate(); 
        
        
        $this->wDB->update( 'awc_f_threads',
                        array('t_wiki_pageid' => $this->pageID, ), 
                        array('t_id' => $this->tID),
                        '' ); 
    }
    
    function add_post(){
        
        // self::wiki_added_text_and_ver();
        $this->text_to_save = $this->post . ' ' . $this->title;
        self::text_size();
                   
        $wiki_page = $this->rDB->tableName( 'page' ); 
        $wiki_revision = $this->rDB->tableName( 'revision' ); 
        $wiki_text = $this->rDB->tableName( 'text' );          
        $sql = "SELECT wr.rev_text_id, wt.old_text, wp.page_len
                    FROM $wiki_page wp
                    JOIN $wiki_revision wr
                        ON wp.page_latest=wr.rev_id
                    JOIN $wiki_text wt
                        ON wr.rev_text_id=wt.old_id
                    WHERE wp.page_id = $this->pageID
                    LIMIT 1";
                    
        $res = $this->rDB->query($sql);
        
            $r = $this->rDB->fetchObject( $res );
            
        if(!empty($r)){
            $this->wDB->update( 'page', array('page_is_new'       => 0,
                                                'page_touched'      => $this->time,
                                                'page_len'      => ($r->page_len + $this->size),
                                                ), 
                                                array('page_id' => $this->pageID), '' );
            
            
            $this->wDB->update( 'text', array('old_text'  => ($r->old_text . "<!-- ". md5($this->p_wiki_hidden) ." -->".$this->text_to_save), ), 
                                                array('old_id' => $r->rev_text_id), '' );
 
                                                
            $search_text = preg_replace( "#\<\!--(.+?)--\>#is", ' ', $r->old_text );
            
            
            //$u = new SearchUpdate( $this->pageID, '', $search_text );
            //$u->doUpdate();
            $this->wDB->update( 'searchindex', array('si_text'  => ($search_text . ' ' . $this->text_to_save),
                                                    ), 
                                                array('si_page' => $this->pageID), '' );
                                                
            /*                                    
            $this->wDB->update( 'awc_f_posts',
                            array('p_wiki_ver_id' => $this->insert_revID, ), 
                            array('p_id' => $this->pID),
                            '' ); 
             */   
             
             
                         

            // $site_stats = $this->rDB->tableName( 'site_stats' );
            // $this->wDB->query( "UPDATE {$site_stats} SET ss_total_views = ss_total_views + 1, ss_total_edits = ss_total_edits + 1, WHERE ss_row_id=1" );
             
            // ( $views, $edits, $good, $pages = 0, $users = 0 )
            $u = new SiteStatsUpdate( +1, +1, 0);
            $u->doUpdate();
        }
    }
    
    function edit_post(){
    
        self::wiki_added_text_and_ver();
        
        $wiki_page = $this->rDB->tableName( 'page' ); 
        $wiki_revision = $this->rDB->tableName( 'revision' ); 
        $wiki_text = $this->rDB->tableName( 'text' );          
        $sql = "SELECT wr.rev_text_id, wt.old_text, wp.page_len
                    FROM $wiki_page wp
                    JOIN $wiki_revision wr
                        ON wp.page_latest=wr.rev_id
                    JOIN $wiki_text wt
                        ON wr.rev_text_id=wt.old_id
                    WHERE wp.page_id = $this->pageID
                    LIMIT 1";
                    
        $res = $this->rDB->query($sql);
        $r = $this->rDB->fetchObject( $res );
        
        self::text_size();
        $new_len = $this->size ; 
        self::text_size($this->old_post_text);
        $old_len = $this->size ;
        $page_len = ($r->page_len - $old_len) + $new_len;
        
        $this->wDB->begin();               
        
        $this->wDB->update( 'page', array('page_len' => $page_len,), array('page_id' => $this->pageID), '' );
        
        $new_post_text = str_replace("<!-- ". md5($this->old_p_wiki_hidden) ." -->" . $this->old_post_text, "<!-- ". md5($this->p_wiki_hidden) ." -->".$this->text_to_save, $r->old_text);
        $this->wDB->update( 'text', array('old_text'  => $new_post_text, ), 
                                            array('old_id' => $r->rev_text_id), '' );
                                            
                                            
        $search_text = preg_replace( "#\<\!--(.+?)--\>#is", ' ', $new_post_text );
        $this->wDB->update( 'searchindex', array('si_text'  => $search_text,
                                                ), 
                                            array('si_page' => $this->pageID), '' );
      /*  
        
        $this->wDB->update( 'revision', array('rev_deleted'  => 1, ), 
                                    array('rev_id' => $this->old_p_wiki_ver_id), '' );
                                    
        $this->wDB->update( 'awc_f_posts',
                        array('p_wiki_ver_id' => $this->insert_revID, ), 
                        array('p_id' => $this->pID),
                        '' ); 
                        
          */                           
        $this->wDB->commit();                                                 
        // ( $views, $edits, $good, $pages = 0, $users = 0 )
        $u = new SiteStatsUpdate( +1, +1, 0);
        $u->doUpdate();
    
    }
    
    function delete_post(){
    
        $wiki_page = $this->rDB->tableName( 'page' ); 
        $wiki_revision = $this->rDB->tableName( 'revision' ); 
        $wiki_text = $this->rDB->tableName( 'text' );          
        $sql = "SELECT wr.rev_text_id, wt.old_text, wp.page_len
                    FROM $wiki_page wp
                    JOIN $wiki_revision wr
                        ON wp.page_latest=wr.rev_id
                    JOIN $wiki_text wt
                        ON wr.rev_text_id=wt.old_id
                    WHERE wp.page_id = $this->pageID
                    LIMIT 1";
                    
        $res = $this->rDB->query($sql);
        $r = $this->rDB->fetchObject( $res );
        
        
        self::text_size($this->old_post_text);
        $old_len = $this->size ;
        $page_len = ($r->page_len - $old_len);
        
        $this->wDB->begin();               
        
        $this->wDB->update( 'page', array('page_len' => $page_len,), array('page_id' => $this->pageID), '' );
        
        
        $new_post_text = str_replace("<!-- ". md5($this->old_p_wiki_hidden) ." -->" . $this->old_post_text, '', $r->old_text);
        
        $this->wDB->update( 'text', array('old_text'  => $new_post_text, ), 
                                            array('old_id' => $r->rev_text_id), '' );
                                            
        $search_text = preg_replace( "#\<\!--(.+?)--\>#is", ' ', $new_post_text );
        $this->wDB->update( 'searchindex', array('si_text'  => $search_text,
                                                ), 
                                            array('si_page' => $this->pageID), '' );
         /*               
        $this->wDB->update( 'revision', array('rev_deleted'  => 1, ), 
                                    array('rev_id' => $this->old_p_wiki_ver_id), '' );
                                    
           */                                       
        $this->wDB->commit();
        // ( $views, $edits, $good, $pages = 0, $users = 0 )
        $u = new SiteStatsUpdate( +1, -1, 0);
        $u->doUpdate();
    
    
    }
    
    function add_to_wiki(){
    
        self::text_size();
        
        $this->wDB->commit();
        
        
        
         $this->wDB->begin();
         $page_id = $this->wDB->nextSequenceValue( 'page_page_id_seq' );
         
        $this->wDB->insert( 'page', array(
            'page_id'    => $page_id,
            'page_namespace'    => NS_AWC_FORUM,
            'page_title'        => "Special:AWCforum/st/id$this->tID/" . self::page_title(),
            'page_counter'      => 0,
            'page_restrictions' => '',
            'page_is_redirect'  => 0,
            'page_is_new'       => 1,
            'page_random'       => wfRandom(),
            'page_touched'      => $this->time,
            'page_latest'       => 0,
            'page_len'          => $this->size,
            ) );
        $this->pageID = $this->wDB->insertId();
        $this->wDB->commit();
       // die(">". $this->pageID);
        if($this->pageID == 0) return ;
        
        $this->wDB->begin();
        self::insert_text();
        self::insert_rev();
        /*        
                use the first text inserted and rev_id to "update" 
                when a post is added to the thread, this is used in the search options
        */
        $this->wDB->update( 'page',
                        array('page_latest' => $this->insert_revID, ), 
                        array('page_id' => $this->pageID),
                        '' );
       
        
         /*insert text a second time
         use this second inputed text-rev_id as the Main Threads Posts text
         use first inputed text-rev_id for search resultes
         add 'rev_parent_id' so we can call this text later... if we want.*/
         /*
        self::insert_text();
        
        
                      
        $this->wDB->insert( 'revision', array(
                'rev_page'        => $this->pageID,
                'rev_len'        => $this->size,
                'rev_text_id'       => $this->insert_textID,
                'rev_comment'        => 'main_thread_post',
                'rev_user'        => $this->mId,
                'rev_user_text'       => $this->mName,
                'rev_timestamp'        => $this->time,
                'rev_minor_edit'        => 0,
                'rev_deleted'       => 0,
                'rev_len'        => $this->size,
                'rev_parent_id'        => $this->pageID,
            ) );

         */
        $this->wDB->insert( 'searchindex', array(
                'si_page'        => $this->pageID,
                'si_title'        => $this->title,
                'si_text'       => $this->text_to_save,
            ) );
            
         $this->wDB->commit();
                         
  
            
    }
    
    function wiki_added_text_and_ver(){
        $this->text_to_save = $this->post . ' ' . $this->title;
        
        self::text_size();
        self::insert_text();
        self::insert_rev();
    }
    
    
    function page_title(){
        $PageTitle = str_replace(array(' ', ':', '.'), array('_', '', ''), $this->title);
       // $PageTitle = awcsforum_funcs::awc_htmlentities($PageTitle);
        
        if (function_exists('mb_strlen')) {
          // $PageTitle = mb_substr($PageTitle,0, 20, awc_forum_charset);
        } else {
         //  $PageTitle = substr($PageTitle,0, 20, awc_forum_charset);
        }
        
    
       // $PageTitle = urlencode($PageTitle);
        return $PageTitle;
    }
    
    function text_size($diff = null){
        
        $diff = ($diff === null) ? $this->text_to_save : $diff;
        if (function_exists('mb_strlen')) {
            $this->size = mb_strlen($diff); 
        } else {
            $this->size = strlen($diff);
        }
        
    }

    function insert_text(){
    global $wgDefaultExternalStore, $IP ;
        
        $inset_text = "<!-- ". md5($this->p_wiki_hidden) ." -->" . $this->text_to_save; 
        $flags = Revision::compressRevisionText($inset_text);
        if ( $wgDefaultExternalStore ) {
            $flags .= 'external';
        }
        
        $bs = $this->wDB->nextSequenceValue( 'text_old_id_seq' );
        $this->wDB->insert( 'text', array(
                'old_text'        => $inset_text,
                'old_flags'       => $flags,
            ) );
        $this->insert_textID = $this->wDB->insertId();
        
    }
    
    function insert_rev(){
        
    	$bs = $this->wDB->nextSequenceValue( 'revision_rev_id_seq' );
        $this->wDB->insert( 'revision', array(
                'rev_page'        => $this->pageID,
                'rev_text_id'       => $this->insert_textID,
                'rev_comment'        => $this->rev_comment,
                'rev_user'        => $this->mId,
                'rev_user_text'       => $this->mName,
                'rev_timestamp'        => $this->time,
                'rev_minor_edit'        => 0,
                'rev_deleted'       => 0,
                'rev_len'        => $this->size,
            ) );
        $this->insert_revID = $this->wDB->insertId();
    }   
    
    
    
   function __destruct() {
      // echo $this->time . "-<br/>";
   }

    
}