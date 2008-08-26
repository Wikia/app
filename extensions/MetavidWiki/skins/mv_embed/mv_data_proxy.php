<?
/*
* a simple proxy for offsite requests 
* sends back type text/plain
* 
* @@todo enhance so the payload is transmitable via javascript object payload 
* (so that remote use of mv_embed can load remote xml ) 
*/

//NOTE THIS IS DISABLED BY DEFAULT simply comment out the line below to enable; 
//die('note mv_data_proxy is disabled by default');
if(isset($_POST['url'])){
	$req_url = $_POST['url'];
}else{
	//try the get object ( and de-htmlentities it) 
	$req_url = $_GET['url'];
}
$wrap_function=$callback_index='';
if(isset($_GET['cb'])){
	$wrap_function=$_GET['cb'];
}
$callback_index=(isset($_GET['cb_inx']))?$_GET['cb_inx']:'0';

$req_url = str_replace('__amp__', '&', $req_url);

if(function_exists('curl_init') ){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTP_VERSION, 1.0);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true); //if we wanted to look at the content
	curl_setopt($ch, CURLOPT_URL, $req_url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$pay_load = curl_exec ($ch);	
	$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
	curl_close($ch);
	//don't send javascript content type: 
	if(strpos($content_type, 'javascript')!==false)
		$content_type='text/plain';			
}else{ 		
	//not as clean as using curl
	$pay_load = file_get_contents($req_url);
	if(substr($pay_load, 0,5)=='<?xml' || $pay_load($out, 0,4)=='<rss'){
		$content_type = 'text/xml';	
	}else{
		$content_type = 'text/plain';
	}	
}
//output: 
if($wrap_function==''){
	header('Content-Type: ' . $content_type);
	print $pay_load;
}else{
	header('Content-Type: text/javascript');
	print $wrap_function.'('. PhpArrayToJsObject_Recurse(
		array(	'req_url'=>$req_url,
				'cb_inx'=>$callback_index, 
				'content-type'=>$content_type,
				'pay_load'=>$pay_load
			)
		).');';	
}

function PhpArrayToJsObject_Recurse($array){
   // Base case of recursion: when the passed value is not a PHP array, just output it (in quotes).
   if(! is_array($array) && !is_object($array) ){
       // Handle null specially: otherwise it becomes "".
       if ($array === null)
       {
           return 'null';
       }      
       return '"' . javascript_escape($array) . '"';
   }  
   // Open this JS object.
   $retVal = "{";
   // Output all key/value pairs as "$key" : $value
   // * Output a JS object (using recursion), if $value is a PHP array.
   // * Output the value in quotes, if $value is not an array (see above).
   $first = true;
   foreach($array as $key => $value){
       // Add a comma before all but the first pair.
       if (! $first ){
           $retVal .= ', ';
       }
       $first = false;      
       // Quote $key if it's a string.
       if (is_string($key) ){
           $key = '"' . $key . '"';
       }	         
       $retVal .= $key . ' : ' . PhpArrayToJsObject_Recurse($value);
   }   
   // Close and return the JS object.
   return $retVal . "}";
}
function javascript_escape($val){
	//first strip /r
	$val = str_replace("\r", '', $val);
	return str_replace(	array('"', "\n", '{', '}'), 
						array('\"', '"'."+\n".'"', '\{', '\}'),
						$val);	
}