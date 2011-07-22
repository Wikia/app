<?php
/* For the supplied text, look for exact matches in an external data store
 * and/or possible duplicate articles.
 *
 * NOTE: It appears that it's completely disabled from doing anything useful right now.
 */

class SuperDeduper {


	function __construct( $lang = "en", $db_name = "answers" ){
		$this->language = $lang;
		$this->db_name = $db_name;
	}

	/* For the supplied title, return a list of potential matches, ranked from highest to lowest*/
	public function getRankedMatches($text, $limit){

		$matches = array();

		$sText = self::normalizeTrivials($text);
		$sTextNoNoise = self::stripNoiseWords($sText);
		$sTextNoNoiseList = explode(' ', $sTextNoNoise);
		sort($sTextNoNoiseList);

		if (@$_GET['debug'] >= 4){
			echo "sText=$sText\n";
			echo "sTextNoNoise=$sTextNoNoise\n";
		}

		// If the text is only noise words, this isn't going to work out.
		if (empty($sTextNoNoise)){
			return $matches;
		}


		$potentials = $this->getPotentialMatchesFromMediawiki($sTextNoNoise, $limit);
		if (empty($potentials)){
			// nothing even close
			return $matches;
		}

		// Walk through the potentials, and find what type of match they are, if any.
		foreach ($potentials as $potential){
			// Items that are functionally identical.
			// Ie, they only* differ trivially by space, punctuation, or case.
			$sPotential = self::normalizeTrivials($potential);
			if ($sPotential == $sText){
				$matches[$potential] = .99;
				continue;
			}

			// Items that are the same without noise words
			$sPotentialNoNoise = self::stripNoiseWords($sPotential);
			if ($sPotentialNoNoise == $sTextNoNoise){
				$matches[$potential] = .85;
				continue;
			}

			// Items that have the same non noise words, but different order.
			$sPotentialNoNoiseList = explode(' ', $sPotentialNoNoise);
			sort($sPotentialNoNoiseList);
			if ($sPotentialNoNoiseList == $sTextNoNoiseList){
				$matches[$potential] = .75;
				continue;
			}

			// Check to see how many of the non noise words intersect
			$overlap = count(array_intersect($sPotentialNoNoiseList, $sTextNoNoiseList));
			if (@$_GET['debug'] >= 6){
				print_r($sPotentialNoNoiseList);
				print_r($sTextNoNoiseList);
				echo "overlap = $overlap\n";
			}

			if ($overlap >= count($sTextNoNoiseList)){ // Every word exists
				// Find what % of words are in the match
				$overlapRank = $overlap / count($sPotentialNoNoiseList);
				$matches[$potential] = $overlapRank;
				continue;
			}

			if (count($matches) >= $limit){
				break;
			}

		}

		// Sort by rank
		arsort($matches);

		if (!empty($_GET['debug'])){
			print_r($matches);
		}

		return $matches;
	}

	/* Strip the title down to it's essence, and search the db. Return raw potential matches */
	protected function getPotentialMatchesFromMediawiki($text, $limit) {

		// Nick wrote: Lock contention issues due to MyISAM
		// Disabling until we have a better solution
		// NOTE: Will need to get db ips and credentials from YAML file in getMediawikiDB() otherwise this won't connect anyway!
		return array();

		$db = getMediawikiDB( $this->db_name );
		if (!$db) return false;
		$sql = "SELECT page_title, si_title FROM searchindex
			INNER JOIN page ON searchindex.si_page = page.page_id
			WHERE MATCH (si_title)
			 AGAINST ('" . mysql_escape_string($text) . "' WITH QUERY EXPANSION)
			AND page.page_is_redirect = 0
			AND page_namespace = 0";

		if (!empty($limit)){
			$sql .= " LIMIT " . intval($limit)*2;
		}

		if (!empty($_GET['debug'])){
			echo $sql . "\n";
		}

		$result = mysql_query($sql);
		if (!$result){
			if (!empty($_GET['debug'])) echo "Mysql error: " . mysql_error();
			return false;
		}

		while ($row = mysql_fetch_assoc($result)){
			$out[] = str_replace('_', ' ', $row['page_title']);
		}
		return $out;
	}

	/* Remove punctuation and space, then lower case it */
	function normalizeTrivials($text){
		$out = preg_replace("/'s/", ' ', $text); // 's is noise
		$out = preg_replace('/[^\PP]+/', '', $out); // punctuation
		$out = preg_replace('/\s+/', ' ', $out);
		return strtolower($out);
	}


	function stripNoiseWords($text){
		$out = " " . $text . " "; // do this so we can operate with one regexp instead of 3
		$out = preg_replace(self::getNoiseRegExp(), ' ', $out);
		$out = trim(preg_replace('/\s+/', ' ', $out));
		if ($out != $text){
			// Keep stripping until it doesn't work. This is because regexp is to greedy. FIXME
			return self::stripNoiseWords($out);
		} else {
			return $out;
		}
	}

	public function getNoiseRegExp(){
		static $regExp; // Only do this once for performance
		if (empty($regExp)){
			$regExp = '/\s(' . implode('|', self::getNoiseWords()) . ')\s/';
		}
		return $regExp;
	}

	public function getNoiseWords (){
	    $noise_words["en"] = array(
		"a","about","after","again","ago","all",
		"almost","also","always","am","am","an",
		"and","another","any","anybody","anyhow","anyone",
		"anything","anyway","are","are","as","at",
		"away","back","be","became","because","been",
		"before","being","between","but","by","came",
		"can","cannot","come","could","did","do",
		"does","does","doing","done","down","each",
		"each","else","even","ever","every","everyone",
		"everything","everything","for","from","front","get",
		"getting","go","goes","going","gone","got",
		"gotten","had","has","has","have","have",
		"having","he","her","here","him","his",
		"how","i","if","in","into","is",
		"is","isn't","it","just","last","least",
		"left","less","let","like","make","many",
		"may","maybe","me","mine","mine","more",
		"most","much","my","my","myself","never",
		"no","none","not","now","of","off",
		"on","one","onto","or","our","ourselves",
		"out","over","per","put","putting","same",
		"saw","see","seen","shall","shall","she",
		"she","should","should","so","some","somebody",
		"someone","something","stand","such","sure","take",
		"than","that","the","their","their","them",
		"them","then","there","these","they","this",
		"this","those","through","till","to","too",
		"two","unless","until","up","upon",
		"us","us","very","was","was",
		"we","went","were","were","what",
		"what's","whatever","when","where","whether",
		"which","while","who","who","whoever",
		"whom","whose","whose","why","will",
		"will","with","within","without","won't",
		"would","wouldn't","yet","you","your",
	    );

	    $noise_words["de"] = array("alle","alles","als","am","beachten","bedeuten","bedeutet","bei",
		    "beste","besten","bezeichnen","bezeichnet","bieten","bietet","bin",
		    "bis","bleiben","bleibt","brauchen","braucht","bringen","circa",
		    "das","dein","deine","der","die","diese","dieser","egal","eigen",
		    "eigene","ein","eine","einer","er","es","etwa","etwas","fast","funktionieren",
		    "funktioniert","f�r","geben","geh�ren","geh�rt","gibt","gut","gute","haben",
		    "hat","hei�en","hei�t","hinter","ich","ihr","ihre","im","immer",
		    "in","inwiefern","inwieweit","ist","jede","jeder","jemand","kann",
		    "kommen","kommt","k�nnen","k�nnte","lange","lassen","l�sst","machen",
		    "man","mehr","mein","mein","meine","meiner","m�glich","muss","m�ssen",
		    "m�sste","nach","nennen","nennt","nicht","nie","noch","nur","oder",
		    "passieren","passiert","pl�tzlich","schlechte","sein","seine","selten",
		    "sie","sinnvoll","so","tun","tut","�ber","unbedingt","und","uns","viel",
		    "von","vor","vorher","wann","warum","was","weg","weil","welche","welcher",
		    "wenig","weniger","wer","werden","weshalb","wie","wieder","wielange",
		    "wieso","wird","wo","zu","zur�ck","zwischen");

	    $noise_words["fr"] = array("le","la","les","du","de","des","une","un","mon","ton","son","ma","ta","sa","mes","tes",
		    "	ses","notre","votre","leur","nos","vos","leurs");

	    if( isset($noise_words[ $this->language ]) ){
		    return $noise_words[ $this->language ];
	    }else{
		     return $noise_words[ "en" ];
	    }
	}

}

function getMediawikiDB( $dbname ){
        static $con;
	if (!empty($con)){
		return $con;
	}

	// Yes, I wish I could have used the Mediawiki stack here. Too bad it's not high performance enough
	// so we will have to live with duplicated configs
	// Update: THERE IS A YAML FILE WITH THE CORRECT CONFIGS. SHOULD PARSE THAT TO GET THIS INFO.
	if (substr(`hostname`, 0, 3) == 'dev'){
		$host = '10.8.2.XX';
	} else {
		$host = '10.8.2.XX';
	}
	$username = 'dbusernamegoeshere';
	$password = 'dbpasswordgoeshere';

	$con = mysql_connect($host, $username, $password);
	if (!$con){
		if (!empty($_GET['debug'])) echo "Error connecting to database: " . mysql_error();
		return false;
	}
	if (! mysql_select_db($dbname)){
		if (!empty($_GET['debug'])) echo "Error selecting database: " . mysql_error();
		return false;
	}

	return $con;
}

?>
