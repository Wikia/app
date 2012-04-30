<?php

class AmazonCSClient extends WikiaSearchClient {

	protected $searchEndpoint;
	protected $rankName;
	protected $httpProxy;

	public function __construct( $searchEndpoint, $rankName, $httpProxy ) {
		$this->searchEndpoint = $searchEndpoint;
		$this->rankName = $rankName;
		$this->httpProxy = $httpProxy;
	}

	public function search( $query, Array $methodOptions = array() ) {
		$params = array(
			'q' => $query,
			'rank' => $this->rankName,
			'start' => $methodOptions['start'],
			'size' => $methodOptions['size'],
			'return-fields' => 'title,url,text,canonical,text_relevance,cityid,indextank,bl,bl2,bl3,backlinks'
		);
		if( !empty( $cityId ) ) {
			// inter-wiki search
			$params['bq'] = "cityid:" . $methodOptions['cityId'];
		}

		list($responseCode, $response) = $this->apiCall( $this->searchEndpoint, $params );

		if($responseCode == 200) {
			$response = json_decode( $response );
			$results = array();
			foreach($response->hits->hit as $hit) {
				$results[] = $this->getWikiaResult($hit);
			}

			return F::build( 'WikiaSearchResultSet', array( 'results' => $results, 'resultsFound' => $response->hits->found, 'resultsStart' => $response->hits->start ) );
		}
		else {
			throw new WikiaException('Search Failed: ' . $response);
		}
	}

	private function getWikiaResult(stdClass $amazonHit) {
		$result = F::build( 'WikiaSearchResult', array( 'id' => $amazonHit->id ) );
		$result->setCityId($amazonHit->data->cityid);
		$result->setTitle($amazonHit->data->title);
		$result->setText(substr($amazonHit->data->text, 0, 250).'...');
		$result->setUrl($amazonHit->data->url);
		if(isset($amazonHit->data->canonical)) {
			$result->setCanonical($amazonHit->data->canonical);
		}

		$result->setVar('backlinks', $amazonHit->data->backlinks);
		$result->setVar('text_relevance', $amazonHit->data->text_relevance);
		$result->setVar('rank_indextank', $amazonHit->data->indextank);
		$result->setVar('rank_bl', $amazonHit->data->bl);
		$result->setVar('rank_bl2', $amazonHit->data->bl2);
		$result->setVar('rank_bl3', $amazonHit->data->bl3);

		return $result;
	}

	private function apiCall( $url, $params = array()) {
		$paramsEncoded = '';
		foreach($params as $key => $value ) {
			$paramsEncoded .= ( !empty($paramsEncoded) ? '&' : '' ) . $key . '=' . urlencode($value);
		}

		$session = curl_init($url . '?' . $paramsEncoded);
		curl_setopt($session, CURLOPT_CUSTOMREQUEST, 'GET'); // Tell curl to use HTTP method of choice
		curl_setopt($session, CURLOPT_HEADER, false); // Tell curl not to return headers
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // Tell curl to return the response

		if( !empty($this->httpProxy) ) {
			curl_setopt($session, CURLOPT_PROXY, $this->httpProxy);
		}

		$response = curl_exec($session);
		$responseCode = curl_getinfo($session, CURLINFO_HTTP_CODE);
		curl_close($session);

		return array( $responseCode, $response );
	}

	private function getTextExcerpt($text, $words, $length = 250, $prefix="...", $suffix = null, $options = array()) {
		// Set default score modifiers [tweak away...]
		$options = array_merge(array(
      'exact_case_bonus'  => 2,
      'exact_word_bonus'  => 3,
      'abs_length_weight' => 0.0,
      'rel_length_weight' => 1.0,

      'debug' => true
		), $options);

		// Null suffix defaults to same as prefix
		if (is_null($suffix)) {
			$suffix = $prefix;
		}

		// Not enough to work with?
		if (strlen($text) <= $length) {
			return $text;
		}

		// Just in case
		if (!is_array($words)) {
			$words = array($words);
		}

		// Build the event list
		// [also calculate maximum word length for relative weight bonus]
		$events = array();
		$maxWordLength = 0;

		foreach ($words as $word) {

			if (strlen($word) > $maxWordLength) {
				$maxWordLength = strlen($word);
			}

			$i = -1;
			while ( ($i = stripos($text, $word, $i+1)) !== false ) {

				// Basic score for a match is always 1
				$score = 1;

				// Apply modifiers
				if (substr($text, $i, strlen($word)) == $word) {
					// Case matches exactly
					$score += $options['exact_case_bonus'];
				}
				if ($options['abs_length_weight'] != 0.0) {
					// Absolute length weight (longer words count for more)
					$score += strlen($word) * $options['abs_length_weight'];
				}
				if ($options['rel_length_weight'] != 0.0) {
					// Relative length weight (longer words count for more)
					$score += strlen($word) / $maxWordLength * $options['rel_length_weight'];
				}
				if (preg_match('/\W/', substr($text, $i-1, 1))) {
					// The start of the word matches exactly
					$score += $options['exact_word_bonus'];
				}
				if (preg_match('/\W/', substr($text, $i+strlen($word), 1))) {
					// The end of the word matches exactly
					$score += $options['exact_word_bonus'];
				}

				// Push event occurs when the word comes into range
				$events[] = array(
          'type'  => 'push',
          'word'  => $word,
          'pos'   => max(0, $i + strlen($word) - $length),
          'score' => $score
				);
				// Pop event occurs when the word goes out of range
				$events[] = array(
          'type' => 'pop',
          'word' => $word,
          'pos'  => $i + 1,
          'score' => $score
				);
				// Bump event makes it more attractive for words to be in the
				// middle of the excerpt [@todo: this needs work]
				$events[] = array(
          'type' => 'bump',
          'word' => $word,
          'pos'  => max(0, $i + floor(strlen($word)/2) - floor($length/2)),
          'score' => 0.5
				);

			}
		}

		// If nothing is found then just truncate from the beginning
		if (empty($events)) {
			return substr($text, 0, $length) . $suffix;
		}

		// We want to handle each event in the order it occurs in
		// [i.e. we want an event queue]
		$events = ksort($events);
		//$events = sortByKey($events, 'pos');

		$scores = array();
		$score = 0;
		$current_words = array();

		// Process each event in turn
		foreach ($events as $idx => $event) {
			$thisPos = floor($event['pos']);

			$word = strtolower($event['word']);

			switch ($event['type']) {
				case 'push':
					if (empty($current_words[$word])) {
						// First occurence of a word gets full value
						$current_words[$word] = 1;
						$score += $event['score'];
					}
					else {
						// Subsequent occurrences mean less and less
						$current_words[$word]++;
						$score += $event['score'] / sizeof($current_words[$word]);
					}
					break;
				case 'pop':
					if (($current_words[$word])==1) {
						unset($current_words[$word]);
						$score -= ($event['score']);
					}
					else {
						$current_words[$word]--;
						$score -= $event['score'] / sizeof($current_words[$word]);
					}
					break;
				case 'bump':
					if (!empty($event['score'])) {
						$score += $event['score'];
					}
					break;
				default:
			}

			// Close enough for government work...
			$score = round($score, 2);

			// Store the position/score entry
			$scores[$thisPos] = $score;

			// For use with debugging
			$debugWords[$thisPos] = $current_words;

			// Remove score bump
			if ($event['type'] == 'bump') {
				$score -= $event['score'];
			}
		}

		// Calculate the best score
		// Yeah, could have done this in the main event loop
		// but it's better here
		$bestScore = 0;
		foreach ($scores as $pos => $score) {
			if ($score > $bestScore) {
				$bestScore = $score;
			}
		}

		// Find all positions that correspond to the best score
		$positions = array();
		foreach ($scores as $pos => $score) {
			if ($score == $bestScore) {
				$positions[] = $pos;
			}
		}

		if (sizeof($positions) > 1) {
			// Scores are tied => do something clever to choose one
			// @todo: Actually do something clever here
			$pos = $positions[0];
		}
		else {
			$pos = $positions[0];
		}

		// Extract the excerpt from the position, (pre|ap)pend the (pre|suf)fix
		$excerpt = substr($text, $pos, $length);
		if ($pos > 0) {
			$excerpt = $prefix . $excerpt;
		}
		if ($pos + $length < strlen($text)) {
			$excerpt .= $suffix;
		}

		return $excerpt;
	}
}