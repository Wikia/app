<?PHP
if ( !defined( 'MEDIAWIKI' ) ) die();

  function lang_getinfo($lang_code = null, $fields_are){
  
       $dbr = wfGetDB( DB_SLAVE );
       
       #$fields_are = array();
       $array_fields = array();
       $single_fields = array();
       
        $no_serial = array('lang_code', 'lang_id');
        
        if($lang_code == null){
            $where = '';
        } else {
            $where = "lang_code= '$lang_code'";
        }
        
        
        $cols = implode(",", $fields_are);
        $cols .= ",lang_code,lang_id";
        $awc_f_langs = $dbr->tableName( 'awc_f_langs' );
        $sql = "SELECT $cols FROM $awc_f_langs $where"; 
        
        $res = $dbr->select( 'awc_f_langs', 
                     array( $cols ),
                     $where,
                     array(__METHOD__),
                     array('OFFSET' => 0 , 'LIMIT' => 1) );


                     
       $fields_are = array_merge($fields_are, $no_serial);
       
       foreach($res as $r){
       
            foreach($fields_are as $id => $field){
                
                if(!in_array($field, $no_serial)){
                    $lang_info[$r->lang_id][$field] = unserialize($r->$field) ;
                   # $array_fields[] = $field ;
                } else {
                   $lang_info[$r->lang_id][$field] = $r->$field ;
                   #$single_fields[] = $field ;
                }
            
            }
       
       }
            

       # awc_pdie("kj");
       
       
        /*
        $fields_are = array_merge($fields_are, $no_serial);
          
        $res = $dbr->query($sql);
        while ($r = $dbr->fetchObject( $res )) {
            
            foreach($fields_are as $id => $field){
                
                if(!in_array($field, $no_serial)){
                    $lang_info[$r->lang_id][$field] = unserialize($r->$field) ;
                   # $array_fields[] = $field ;
                } else {
                   $lang_info[$r->lang_id][$field] = $r->$field ;
                   #$single_fields[] = $field ;
                }
            
            }
        }
        $dbr->freeResult( $res );
        */
        unset($fields_are, $r);
        
        
		#awc_pdie($lang_info);  

        return $lang_info;
  
  }
  
  
  function lang_sql_update($langs, $id){
      
      $dbw = wfGetDB( DB_MASTER );
      
                    if(isset($langs['array_fields'])){          
                           foreach($langs['array_fields'] as $i => $field){
                                   if(isset($langs[$field]))$sql_array[$field] = serialize($langs[$field]) ;
                            }
                            
                            $dbw->update( 'awc_f_langs',$sql_array, array('lang_id' => $id ), '');
                            unset($langs, $sql_array);
                    }
                    
                    unset($langs);
  }
  
  
    function arr_AddTo($add, $current){
        
        if(empty($current) OR !isset($current)) $current = array('tmp'=>'tmp');
        $return = array_merge($add, $current);
        return $return;
    }
    
    function arr_CheckIn($chk, $current, $AddTo = false, $wPhase = false){
     global $wgOut;
        
        if(!isset($chk) || empty($chk)) return $current ;
        //if(!isset($current)) return  ;
        
        //if(empty($current)) $current = array('tmp' => 'tmp')  ;
        if(empty($current) OR !isset($current)) $current = array('tmp' => 'tmp')  ;
        
        $re_arry = array();
        $re_arry = array_diff_key($chk, $current);
        
        if(!empty($re_arry)){
            
                if($AddTo) {
                    
                    $r = array();
                    $r['updated'] = arr_AddTo($re_arry, $current);
                    $r['dif'] = $re_arry ;
                    
                    if($wPhase){
                        foreach($r['dif'] as $k => $v){
                            $r['dif'][$k] = awc_wikipase($v, $wgOut);
                        }
                        $r['phased'] = $r['dif']; 
                    }
                    
                    return $r ;
                    
                } else {
                    
                    return $re_arry;
                    
                }
        
        }
        
        unset($re_arry);
        
        return $current;
        
       

    
    }
    
    
    
    
    
    function update_admin_lang_check($update_array, $db_array, $new_array = array()){
  
    $tmp = array();
    $new = array(); 
    $save = array(); 
    
    $re_arry = array();
    
    $re_arry = array_diff_key($update_array, $db_array);
    
    die(print_r($re_arry));
    // manul add _raw colum, its not being passed bacause it is not an array in the update_lang.txt file
    
   # die(print_r($new_array));
    
    foreach($update_array as $k => $v){
    
        if (!array_key_exists($k, $db_array)) {
            $new[$k] = $v;
        } else {
            $new['tmp'] = "tmp";
        }
    
    }
    

    $save = array_merge($update_array, $db_array);
    $save = array_unique($save);
    
    $re_arry = array(1=> $save, 2=> $new);
    unset($tmp, $save, $new);
    
    return $re_arry;
  
  }
  
  
  
  
  function import_admin_lang($update_array, $db_array, $new_array){
  
    $tmp = array();
    $new = array(); 
    $save = array(); 
    
    $tmp = array_diff_assoc($update_array, $db_array);
    
    if(empty($tmp)){
        $new['tmp'] = "tmp";  
        $new = $new_array ;
    }  else {
        $new = array_merge($tmp, $new_array);
    }
    
    $save = array_merge($update_array, $db_array);
    $save = array_unique($save);
    
    
    $re_arry = array(1=> $save, 2=> $new);
    unset($tmp, $save, $new);
    
    return $re_arry;
  
  }
  
  
  
  
function awc_admin_wikipase($info){
global $wgOut;

        $out = $wgOut->parse($info);
        
        $out = str_replace("<p>", "", $out);
        $out = str_replace("</p>", "", $out);
        
        $spl = explode('title="Image:', $out);
        if(isset($spl[1])){
            $spl = explode('">', $spl[1]);
                if(isset($spl[1])){
                    $spl = explode('</a>', $spl[1]);
                        if(isset($spl)){
                          $out = $spl[0]; 
                        }
                }
        }
        
        return $out;
        
}
  
