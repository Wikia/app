<?php

class LinkValidator{
  
  var $spam_words_hard = array();
  var $spam_words_soft = array(); 
  var $superlatives = array(); 
   
  function LinkValidator(){
   
    $this->http_client = new wikia_http( HTTP_V10, false);
   
    $this->spam_words_hard = array(
    'adipex','advicer','baccarrat','blackjack','bllogspot','booker','byob','carbohydrate','car-rental-e-site','car-rentals-e-site',
    'carisoprodol','casino','casinos','cialis','coolcoolhu','coolhu','credit-report-4u','cwas','cyclen','cyclobenzaprine',
    'dating-e-site','day-trading','debt','debt-consolidation-consultant','drug','discreetordering','duty-free','dutyfree','equityloans','financing',
    'fioricet','flowers-leading-site','freenet-shopping','freenet','gambling','gay','health-insurancedeals-4u','homeequityloans','homefinance',
    'holdem','holdempoker','holdemsoftware','holdemtexasturbowilson','hotel-dealse-site','hotele-site','hotelse-site','incest',
    'insurance-quotesdeals-4u','insurancedeals-4u','jrcreations','levitra','loan','macinstruct','mortgage-4-u','mortgagequotes','online-gambling',
    'onlinegambling-4u','ottawavalleyag','ownsthis','palm-texas-holdem-game','paxil','penis','pharmacy','phentermine','poker','poker-chip',
    'rental-car-e-site','roulette','sex','shemale','slot-machine',
    'texas-holdem','thorcarlson','top-site','top-e-site','tramadol','trim-spa','ultram','valeofglamorganconservatives','viagra',
    'vioxx','xanax','zolus ','replica'
    );
    
    $this->spam_words_soft = array(
    'affordable','ambien','bargain','buy','chatroom','cheap','insurance','investment','poze',
    'pre-approved','soma','taboo','teen','wholesale'
    );
    
    $this->superlatives = array(
    'ablest','achiest','acutest','airworthiest','airiest','amplest','angriest','aptest','artiest','ashiest',
    'worst','baggiest','baldest','balkiest','balmiest','barest','battiest','beadiest','beastliest','beefiest','best',
    'biggest','bitterest','blackest','blandest','blankest','bleakest','bleariest','blindest','blithest','blondest',
    'bloodthirstiest','bloodiest','blotchiest','blowziest','bluest','bluntest','blurriest','boggiest','boldest','bonniest',
    'boniest','bossiest','botchiest','bounciest','brainiest','brambliest','brashest','brassiest','brattiest','bravest',
    'brawniest','breathiest','breeziest','briefest','brightest','briniest','briskest','bristliest','broadest','broodiest',
    'brownest','bruskest','bubbliest','bulgiest','bulkiest','bumpiest','bunchiest','burliest','bushiest','busiest',
    'cagiest','calmest','campiest','canniest','catchiest','cattiest','chalkiest','chanciest','chastest','chattiest',
    'cheapest','cheekiest','cheeriest','cheesiest','chewiest','chilliest','chintziest','choicest','choosiest','choppiest',
    'chubbiest','chummiest','chunkiest','civilest','clammiest','classiest','cleanest','cleanliest','clearest','cleverest',
    'clingiest','cliquiest','cloddiest','closest','cloudiest','clumpiest','clumsiest','coarsest','coldest','comeliest',
    'comfiest','commonest','coolest','corkiest','corniest','costliest','coyest','coziest','crabbiest','crackliest',
    'craftiest','craggiest','crankiest','crassest','crawliest','craziest','creakiest','creamiest','creepiest','crinkliest',
    'crispest','crispiest','croakiest','crossest','croupiest','cruelest','crummiest','crunchiest','crustiest','cuddliest',
    'curliest','curtest','curviest','cushiest','cutest','daffiest','daftest','daintiest','dampest','dandiest',
    'dankest','darkest','deadest','deadliest','deafest','dearest','deepest','deftest','demurest','densest',
    'dewiest','diciest','dimmest','dingiest','dippiest','direst','dirtiest','dizziest','dopiest','dottiest',
    'doughtiest','doughiest','dowdiest','downiest','drabbest','draftiest','dreamiest','dreariest','dressiest','droopiest',
    'drowsiest','driest','duckiest','dullest','dumbest','dumpiest','duskiest','dustiest','earliest','earthiest',
    'easiest','edgiest','eeriest','emptiest','faintest','fairest','falsest','fanciest','farthest','furthest',
    'fastest','fattest','fattiest','faultiest','feeblest','fewest','fiercest','fieriest','filmiest','filthiest',
    'finest','firmest','fishiest','fittest','flabbiest','flakiest','flashiest','flattest','fleeciest','fleetest',
    'flightiest','flimsiest','flippest','floppiest','fluffiest','foamiest','foggiest','folksiest','fondest','foolhardiest',
    'foulest','foxiest','frailest','frankest','freakiest','freest','freshest','friendliest','frizziest','frostiest',
    'frothiest','frumpiest','fullest','funkiest','funniest','furriest','fussiest','fuzziest','gabbiest','gamest',
    'gamiest','gaudiest','gauntest','gauziest','gawkiest','gentlest','germiest','ghastliest','giddiest','gladdest',
    'glairiest','glassiest','gleamiest','glibbest','gloomiest','glossiest','gluiest','glummest','godliest','best',
    'goodliest','gooiest','goofiest','goriest','goutiest','grabbiest','grainiest','grandest','grassiest','gravest',
    'grayest','greasiest','greatest','greediest','greenest','greyest','grimmest','grimiest','grippiest','gripiest',
    'grisliest','grittiest','grizzliest','groggiest','grooviest','grossest','grouchiest','grubbiest','gruffest','grumpiest',
    'grungiest','guiltiest','gummiest','gushiest','gustiest','gutsiest','hairiest','hammiest','handsomest','handiest',
    'happiest','hardest','hardiest','harshest','hastiest','haughtiest','haziest','headiest','healthiest','heartiest',
    'heaviest','heftiest','highest','hippest','hoarsest','hokiest','holiest','homeliest','homiest','hottest',
    'huffiest','hugest','humblest','hungriest','huskiest','ickiest','iciest','idlest','illest','inkiest',
    'itchiest','jauntiest','jazziest','jerkiest','jolliest','jounciest','juiciest','jumpiest','keenest','kindest',
    'kindliest','kingliest','knobbiest','knottiest','kookiest','laciest','lamest','lankest','lankiest','largest',
    'latest','laxest','laziest','leafiest','leakiest','leanest','leeriest','lengthiest','lightest','likeliest',
    'lintiest','lithest','littlest','liveliest','loamiest','loftiest','loneliest','longest','looniest','loosest',
    'lordliest','loudest','lousiest','loveliest','lowest','lowliest','luckiest','lumpiest','maddest','mangiest',
    'manliest','marshiest','maturest','mealiest','meanest','measliest','meatiest','meekest','mellowest','merest',
    'merriest','messiest','mightiest','mildest','milkiest','mintiest','minutest','mistiest','moistest','moldiest',
    'moodiest','mopiest','mossiest','mouldiest','mousiest','mouthiest','muckiest','muddiest','muggiest','murkiest',
    'mushiest','mustiest','naivest','narrowest','nastiest','nattiest','naughtiest','nearest','neatest','neediest',
    'nerviest','newest','newsiest','nicest','niftiest','nimblest','nippiest','noblest','noisiest','nosiest',
    'numbest','nuttiest','obscurest','oddest','oiliest','eldest','oldest','ooziest','palest','palmiest',
    'paltriest','pastiest','patchiest','pearliest','pebbliest','peppiest','perkiest','pertest','peskiest','pettiest',
    'phlegmiest','phoniest','pickiest','piggiest','pimpliest','pinkest','pithiest','plainest','pluckiest','plumpest',
    'plumiest','plushest','pointiest','pokiest','politest','poorest','porkiest','portliest','poshest','prettiest',
    'prickliest','primmest','prissiest','profoundest','prosiest','proudest','pudgiest','puffiest','pulpiest','punchiest',
    'puniest','purest','pushiest','quaintest','quakiest','queasiest','quickest','quietest','quirkiest','rainiest',
    'rangiest','rankest','rarest','raspiest','rattiest','rawest','readiest','realest','reddest','reediest',
    'remotest','richest','ripest','riskiest','ritziest','rockiest','roomiest','rosiest','rottenest','roughest',
    'rowdiest','ruddiest','rudest','runniest','runtiest','rustiest','saddest','safest','sagest','saggiest',
    'saintliest','saltiest','sandiest','sanest','sappiest','sassiest','sauciest','scabbiest','scaliest','scantiest',
    'scarcest','scariest','schmaltziest','scraggliest','scrappiest','scratchiest','scrawniest','screechiest','scrimpiest','scrubbiest',
    'scruffiest','scurviest','securest','seemliest','severest','shabbiest','shadiest','shaggiest','shakiest','shallowest',
    'shapeliest','sharpest','shiftiest','shiniest','shoddiest','shortest','showiest','shrewdest','shrillest','shyest',
    'sickest','sickliest','sightliest','silkiest','silliest','siltiest','simplest','sincerest','sketchiest','skinniest',
    'slangiest','slaphappiest','sleekest','sleepiest','sleetiest','slenderest','slickest','slightest','slimmest','slimiest',
    'slipperiest','sloppiest','sloshiest','slouchiest','slowest','sludgiest','slushiest','sliest','slyest','smallest',
    'smartest','smeariest','smelliest','smoggiest','smokiest','smoothest','smudgiest','smuggest','snakiest','snappiest',
    'snarliest','sneakiest','sneeziest','snidest','snippiest','snobbiest','snoopiest','snootiest','snowiest','snuggest',
    'soapiest','soberest','softest','soggiest','solidest','soonest','sootiest','soppiest','sorest','sorriest',
    'soundest','soupiest','sourest','sparest','sparsest','speediest','spiciest','spiffiest','spikiest','spindliest',
    'spiniest','splashiest','splotchiest','spongiest','sportiest','spottiest','sprightliest','springiest','spriest','spryest',
    'spunkiest','squabbiest','squarest','squashiest','squattiest','squeakiest','squirmiest','stagiest','staidest','stalest',
    'starchiest','starkest','starriest','stateliest','steadiest','stealthiest','steamiest','steeliest','steepest','sternest',
    'stickiest','stiffest','stillest','stingiest','stinkiest','stockiest','stodgiest','stoniest','stormiest','stoutest',
    'straggliest','straightest','strangest','streakiest','stretchiest','strictest','stringiest','strongest','stubbornest','stubbiest',
    'stuffiest','stumpiest','stupidest','sturdiest','sudsiest','sulkiest','sultriest','sunniest','supplest','surest',
    'surliest','sveltest','swampiest','swankiest','swarthiest','sweatiest','sweetest','swiftest','tackiest','talkiest',
    'tallest','tamest','tannest','tangiest','tardiest','tartest','tastiest','tautest','tawdriest','tawniest',
    'teariest','teeniest','tensest','tersest','testiest','tetchiest','thickest','thinnest','thirstiest','thorniest',
    'threadiest','thriftiest','throatiest','tidiest','tightest','tinniest','tiniest','tipsiest','toothiest','touchiest',
    'toughest','trendiest','trickiest','trimmest','tritest','truest','trustiest','twangiest','tweediest','ugliest',
    'unhealthiest','unruliest','vaguest','vilest','wackiest','wannest','warmest','wartiest','wariest','waviest',
    'waxiest','weakest','wealthiest','weariest','weediest','weepiest','weightiest','weirdest','wettest','wheeziest',
    'whiniest','whitest','widest','wildest','wiliest','windiest','wintriest','wiriest','wisest','wispiest',
    'wittiest','wobbliest','woodsiest','woodiest','woolliest','wooziest','wordiest','worldliest','wormiest','worthiest',
    'wriggliest','wriest','yeastiest','youngest','yummiest','zaniest','zippiest'
    );	
  
  }
  
  function checkHTML( $html ) {

    $html = strtolower( $html );
    $spam_words_hard = $this->spam_words_hard();

    foreach ( $spam_words_hard as $sw ) {
        if ( strpos( $html, $sw ) !== false ) {
            return false;
        }
    }

    return true;
 }

function checkTitleDesc( $title, $desc, $url, $super ) {

    $title = strtolower( $title );
    $desc  = strtolower( $desc );

    $superlatives    = $this->superlatives;
    $spam_words_soft = $this->spam_words_soft;
    $spam_words_hard = $this->spam_words_hard;

    if ( $super ) {
        foreach ( $superlatives as $sw ) {
            if ( strpos( $title, $sw ) !== false || strpos( $desc, $sw ) !== false ) {
                return 'superlatives';
            }
        }
    }

    foreach ( $spam_words_hard as $sw ) {
        if ( strpos( $title, $sw ) !== false || strpos( $desc, $sw ) !== false ) {
            return 'text';
        }
        if ( strpos( $url, $sw ) !== false ) {
            return 'url';
        }
    }

    $myscore = 0;

    foreach ( $spam_words_soft as $sw ) {
        if ( strpos( $title, $sw ) !== false || strpos( $desc, $sw ) !== false ) {
            $myscore+=50;
        }
    }

    if ( $myscore > 100 ) {
        return 'text';
    }

    return true;
}
  
function do_test( $params,&$pr,&$lex ){  

  $err = false;
  
  $url = parse_url( $params['data.site_url'] );
  
  $host = str_replace( 'www.', '', strtolower( $url['host'] ) );
  if( !empty( $url['path'] ) ){
    $host .= ereg_replace( "^(.*)/.*$", '\\1', strtolower( $url['path'] ) ); 
  }

  $this->link['host'] = $host;
  
  if( !eregi( '.{5,50}$', $params['data.site_name'] ) ){ $err .= "<li>Title too short or too long" ; };
  if( !eregi( '[\.\-\_a-zA-Z0-9]{4,200}$', $host)){ $err .="<li>Invalid URL"; };
  if( strlen( $params['data.site_description'] ) > 255 ){ $err .= "<li>Description too long" ; };
  if( !eregi( '[\.\-\_@a-zA-Z0-9]{5,100}$', $params['data.site_email'] ) ){ $err .="<li>Invalid E-mail"; };
		
  if( ( $params['data.captcha_generated'] != $params['data.captcha_entered']) || ( $params['data.captcha_entered'] == '' ) ){
	 $err .= "<li>Invalid security code";
  }
        
  $repurl = parse_url( $params['data.site_receip'] );
  $rephost = str_replace( 'www.', '', strtolower( $repurl['host'] ) );
  
  if( !empty( $repurl['path'] ) ){
    $rephost .= ereg_replace( "^(.*)/.*$", '\\1', strtolower( $repurl['path'] ) );
  }  
    if( !eregi( '[\.\-\_a-zA-Z0-9]{4,200}$', $host ) ){ $err .="<li>Invalid Reciprocal Link"; };
		
    if ( $repurl['host'] != $url['host'] ){
       $err .= "<li>The reciprocal link must be placed under the same (sub)domain as your link is!";
	}

	$test = $this->checkTitleDesc( $params['data.site_name'], $params['data.site_description'], $params['data.site_url'], 1 );
	 if ( $test === true ){
	   $test = '';
	 }elseif ( $test == 'superlatives' ){
	   $err .= "<li>Please don't use words like best, biggest, cheapest, largest in title and description!";
	 }elseif ( $test == 'text' ){
       $err .= "<li>Your link failed SPAM test, we are forced to reject it.";
     }elseif ( $test == 'url' ){
       $err .= "<li>Your link failed SPAM test, we are forced to reject it.";
     }
	 
	 /* Check for duplicate links */
	 $sql = "select * from `" . $lex->conf['BASE']['database'] . "`.`" . $lex->conf['BASE']['table'] . "` where site_url='http://" . $lex->db_str( $url['host'] ) . "' or site_url='http://www." . $lex->db_str( $url['host'] ) . "' or site_url='http://". str_replace('www.','', strtolower( $lex->db_str( $url['host'] ) ) ) . "'";
	    
	 if(  count( $lex->runsql( $sql, false, true ) ) > 0 ){ 
    	$err .= "<li>Please don't submit the same website more than once or we will be forced to delete all your links!";
     }
	    
	 $sql = "select site_receip from `" . $lex->conf['BASE']['database'] . "`.`" . $lex->conf['BASE']['table'] . "` where site_receip='" . $lex->db_str( $params['data.site_receip'] ) . "'";

   	 if( count( $lex->runsql( $sql, false, true ) ) > 0 ){
   	  	$err .= "<li>Please don't submit multiple websites with the same reciprocal link URL or we will be forced to delete all your links!";
   	 }
   	    
	 /* Get HTML code of the reciprocal link URL */
	
	 if( !$html = $this->get_url_content( $params['data.site_receip'] ) ){ $err .= "<li>Can't open reciprocal link URL!"; };
	
	 $html = strtolower( $html );
	 $site_url = strtolower( $params['data.homesite'] );

	 /* Block links with the meta "robots" noindex or nofollow tags? */
	 if ( preg_match( '/<meta([^>]+)(noindex|nofollow)(.*)>/siU', $html, $meta ) ){	
  		$err .= "<li>Please don't place the reciprocal link to a page with the meta robots noindex or nofollow tag:<br />" . htmlspecialchars($meta[0]);
	 }

	 $found    = 0;
	 $nofollow = 0;

	 if ( preg_match_all( '/<a\s[^>]*href=([\"\']??)([^" >]*?)\\1([^>]*)>/siU', $html, $matches, PREG_SET_ORDER ) ) {
		foreach($matches as $match){
        	if ( strtolower( $match[2] ) == strtolower( $params['data.homesite'] ) || strtolower( $match[2] ) == strtolower( $params['data.homesite'] ) .'/' ){
            	$found = 1;
            	if ( strstr($match[0],'nofollow' ) ) {
                	$nofollow = 1;
            	}
            	break;
        	}
    	 }
	  }

	 if ( $found == 0 ){
    		$err .= '<li>Our URL (<a href="'.$params['data.homesite'].'">'.$params['data.homesite']. '</a>) was not found on your reciprocal links page. Please link to us first!' ;
	 }

	 if ( $nofollow == 1 ){
    		$err .= "<li>Please don't use <b>nofollow</b> link attribute for the reciprocal link!";
	 }

	 /* Check Google PageRank */
	 $linkpr = $lex->pr->getpr( $params['data.site_url'] );
     $linkpr = empty( $linkpr ) ? 0 : $linkpr;
    	
    	
    if ( $linkpr < $params['data.min_pr'] ){
        	$err .= "<li>Unfortunately we only accept websites with Google PageRank <b>".$params['data.min_pr']."</b> or higher.";
    }

    if ( $params['data.min_pr_rec'] ) {
        $pr_rec = $lex->pr->getpr( $params['data.site_receip'] );
        $pr_rec = empty( $pr_rec ) ? 0 : $pr_rec;
        if ( $pr_rec < $params['data.min_pr_rec'] ){
           $err .= "<li>Please place the reciprocal link to us on a page with Google PageRank ".$params['data.min_pr_rec']."/10 or higher.";
        }
    }
   
   return $err;
   
  }
  
  
   function get_url_content( $_url, $method='GET', $formdata = array() , $referer='', $headers = false ) {
  //fake browser fake	
    
    $url = parse_url( $_url );
    
	$this->http_client->host = $url['host'];
	
	if( empty( $url['path'] ) ){
		$url['path'] = "/";
	}
	
	if( !empty($url['query']) ){
	    $query = $url['path'] . '?' . $url['query']; 
	  }else{
	    $query = $url['path'];
	}
	
	$query = str_replace(' ','_',$query);

	//do get
	if( $method == 'GET' ){
	    
		if ( $this->http_client->get( $query, true, $referer ) == HTTP_STATUS_OK ){
		    if( $headers ){
			  $rs = $this->http_client->get_response();	
		      return $rs;	
		    }else{
		      $rs = $this->http_client->get_response_body();
			  return $rs;	
		    } 
		  }else{
		    return false;
		}
	}
	
	if( $method == 'POST' ){
	  if ( $this->http_client->post( $query, $formdata ) == HTTP_STATUS_OK ){
		$rs = $this->http_client->get_response_body();
		    if($headers){
			  $rs = $this->http_client->get_response();	
		      return $rs;	
		    }else{
		      $rs = $this->http_client->get_response_body();
			  return $rs;	
		    } 
	  }else{
	    return false;
	  }
	}
  }	  
}//end LinkValidator 
?>
