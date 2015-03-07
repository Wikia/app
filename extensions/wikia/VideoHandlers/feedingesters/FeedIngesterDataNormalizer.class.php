<?php

/**
 * Class FeedIngesterDataNormalizer
 *
 * Class used to map provider specific data values to a normalized
 * version. Eg, when it comes to a category for a video, one provider
 * might use the term 'movie' for a clip, while another might use
 * 'movie interview', and another might use 'theatrical'. We want
 * to normalize all of those to just 'Movies' when we save the video
 * onto Wikia.
 */
class FeedIngesterDataNormalizer {

	/**
	 * Get normalized industry rating
	 * @param string $rating
	 * @return string
	 */
	public function getNormalizedIndustryRating( $rating ) {
		$rating = trim( $rating );
		$name = strtolower( $rating );
		switch( $name ) {
			case 'everyone':
			case 'early childhood':
				$normalizedRating = 'EC';
				break;
			case 'everyone 10 or older':
				$normalizedRating = 'E10+';
				break;
			case 'little or no violence':
				$normalizedRating = 'E';
				break;
			case 'teen':
			case 'some violence':
				$normalizedRating = 'T';
				break;
			case 'mature':
			case 'extreme or graphic violence':
				$normalizedRating = 'M';
				break;
			case 'adults only':
				$normalizedRating = 'AO';
				break;
			case 'pending':
			case 'rating pending':
				$normalizedRating = '';
				break;
			case 'not rated':
				$normalizedRating = 'NR';
				break;
			case 'redband':
			case 'red band':
				$normalizedRating = 'Redband';
				break;
			case 'greenband':
			case 'green band':
				$normalizedRating = 'Greenband';
				break;
			default: $normalizedRating = $rating;
		}

		return $normalizedRating;
	}

	/**
	 * Get age required from industry rating
	 * @param string $rating
	 * @return int
	 */
	public function getNormalizedAgeRequired( $rating ) {
		switch( $rating ) {
			case 'M':
			case 'R':
			case 'TV-MA':
			case 'Redband':
				$ageRequired = 17;
				break;
			case 'AO':
			case 'NC-17':
				$ageRequired = 18;
				break;
			default: $ageRequired = 0;
		}

		return $ageRequired;
	}

	/**
	 * get normalized category
	 * @param string $category
	 * @return string
	 */
	public function getNormalizedCategory( $category ) {
		$category = trim( $category );
		switch( strtolower( $category ) ) {
			case 'movie':
			case 'movie interview':
			case 'movie behind the scenes':
			case 'movie sceneorsample':
			case 'movie alternate version':
			case 'theatrical';
				$normalizedCategory = 'Movies';
				break;
			case 'series':
			case 'season':
			case 'episode':
			case 'tv show':
			case 'episodic interview':
			case 'episodic behind the scenes':
			case 'episodic sceneorsample':
			case 'episodic alternate version':
			case 'tv trailer':
				$normalizedCategory = 'TV';
				break;
			case 'game':
			case 'gaming':
			case 'games scenerrsample':
			case 'video game':
				$normalizedCategory = 'Games';
				break;
			case 'movie fan-made':
			case 'game fan-made':
			case 'song fan-made':
			case 'other fan-made':
			case 'episodic fan-made':
				$normalizedCategory = 'Fan-Made';
				break;
			case 'live event':
			case 'live event interview':
			case 'live event behind the scenes':
			case 'live event sceneorsample':
			case 'live event alternate version':
			case 'live event fan-made':
				$normalizedCategory = 'Live Event';
				break;
			case 'mind & body':
			case 'personal care & style':
				$normalizedCategory = 'Beauty';
				break;
			case 'performing arts':
				$normalizedCategory = 'Arts';
				break;
			case 'crafts & hobbies':
				$normalizedCategory = 'Crafts';
				break;
			case 'sports & fitness':
			case 'health & nutrition':
				$normalizedCategory = 'Health';
				break;
			case 'business & finance':
				$normalizedCategory = 'Business';
				break;
			case 'first aid & safety':
				$normalizedCategory = 'Safety';
				break;
			case 'kids':
			case 'pets':
			case 'parenting & family':
				$normalizedCategory = 'Family';
				break;
			case 'careers & education':
				$normalizedCategory = 'Education';
				break;
			case 'sex & relationships':
				$normalizedCategory = 'Relationships';
				break;
			case 'language & reference':
				$normalizedCategory = 'Reference';
				break;
			case 'cars & transportation':
				$normalizedCategory = 'Auto';
				break;
			case 'holidays & celebrations':
				$normalizedCategory = 'Holidays';
				break;
			case 'religion & spirituality':
				$normalizedCategory = 'Religion';
				break;
			case 'none':
			case 'not set':
			case 'home video':
			case 'open-ended':
			case 'other interview':
			case 'other behind the scenes':
			case 'other sceneorsample':
			case 'other alternate version':
				$normalizedCategory = '';
				break;
			default: $normalizedCategory = $category;
		}

		return $normalizedCategory;
	}

	/**
	 * get normalized type
	 * @param string $type
	 * @return string
	 */
	public function getNormalizedType( $type ) {

		$type = trim( $type );
		switch( strtolower( $type ) ) {
			case 'movie behind the scenes':
			case 'episodic behind the scenes':
			case 'other behind the scenes':
			case 'live event behind the scenes':
				$normalizedType = 'Behind the Scenes';
				break;
			case 'movie fan-made':
			case 'game fan-made':
			case 'song fan-made':
			case 'other fan-made':
			case 'episodic fan-made':
			case 'live event fan-made':
				$normalizedType = 'Fan-Made';
				break;
			case 'game':
				$normalizedType = 'Games';
				break;
			case 'movie interview':
			case 'episodic interview':
			case 'other interview':
			case 'live event interview':
			case 'song interview':
				$normalizedType = 'Interview';
				break;
			case 'movie':
				$normalizedType = 'Movies';
				break;
			case 'movie sceneorsample':
			case 'extra (clip)':
				$normalizedType = 'Clip';
				break;
			case 'trailer':
				$normalizedType = 'Trailer';
				break;
			case 'none':
			case 'not set':
			case 'song sceneorsample':
			case 'song behind the scenes':
			case 'movie alternate version':
			case 'games sceneorsample':
			case 'game alternate version':
			case 'episodic sceneorsample':
			case 'episodic alternate version':
			case 'other sceneorsample':
			case 'other alternate version':
			case 'live event sceneorsample':
			case 'live event alternate version':
				$normalizedType = '';
				break;
			default: $normalizedType = $type;
		}

		return $normalizedType;
	}


	/**
	 * get normalized genre
	 * @param string $genre
	 * @return string
	 */
	public function getNormalizedGenre( $genre ) {
		$genre = trim( $genre );
		switch( strtolower( $genre ) ) {
			case 'parenting & family':
				$normalizedGenre = 'Parenting';
				break;
			case 'health & nutrition':
				$normalizedGenre = 'Nutrition';
				break;
			case 'technology':
			case 'environment':
			case 'food & drink':
			case 'entertainment':
			case 'house & garden':
			case 'performing arts':
			case 'crafts & hobbies':
			case 'business & finance':
			case 'first aid & safety':
			case 'careers & education':
			case 'sex & relationships':
			case 'language & reference':
			case 'cars & transportation':
			case 'personal care & style':
			case 'holidays & celebrations':
			case 'religion & spirituality':
			case 'games':
			case 'music':
			case 'other':
			case 'comedy':
			case 'travel':
			case 'fashion':
			case 'education':
				$normalizedGenre = '';
				break;
			case 'sports & fitness':
				$normalizedGenre = 'Fitness';
				break;
			default: $normalizedGenre = $genre;
		}

		return $normalizedGenre;

	}

	/**
	 * get normalized page category
	 * @param string $pageCategory
	 * @return string
	 */
	public function getNormalizedPageCategory( $pageCategory ) {
		$pageCategory = trim( $pageCategory );
		switch( strtolower( $pageCategory ) ) {
			case 'clip':
				$normalizedCategory = 'Clips';
				break;
			case 'trailer':
				$normalizedCategory = 'Trailers';
				break;
			case 'game':
			case 'gaming':
				$normalizedCategory = 'Games';
				break;
			case 'none':
				$normalizedCategory = '';
				break;
			default: $normalizedCategory = $pageCategory;
		}

		return $normalizedCategory;

	}

	/**
	 * Get normalized additional page category
	 * @param string $category
	 * @return string
	 */
	public function getNormalizedAdditionalPageCategory( $category ) {
		switch ( strtolower( $category ) ) {
			case 'movies':
			case 'tv':
			case 'movie trailers':
				$additionalCategory = 'Entertainment';
				break;
			case 'travel':
			case 'beauty':
			case 'fashion':
			case 'food':
			case 'food & drink':
			case 'crafts':
			case 'howto':
				$additionalCategory = 'Lifestyle';
				break;
			default: $additionalCategory = '';
		}

		return $additionalCategory;
	}

	/**
	 * @param $value
	 * @param $type
	 * @param $code
	 * @return mixed|string
	 */
	public function getCLDRCode( $value, $type, $code ) {
		$value = trim( $value );
		if ( !empty( $value ) ) {

			// Initialize some variables that will be overwritten by the following include
			$languageNames = $countryNames = [];

			// include cldr extension for language code
			include( dirname( __FILE__ ).'/../../../cldr/CldrNames/CldrNamesEn.php' );
			$cldrNames = [
				'languageNames' => $languageNames,
				'countryNames' => $countryNames,
			];

			// $languageNames, $countryNames comes from cldr extension
			$paramName = ( $type == 'country' ) ? 'countryNames' : 'languageNames';
			if ( !empty( $cldrNames ) ) {
				if ( $code ) {
					$code = array_search( $value, $cldrNames[$paramName] );
					if ( $code != false ) {
						$value = $code;
					}
				} else {
					if ( array_key_exists( $value, $cldrNames[$paramName] ) ) {
						$value = $cldrNames[$paramName][$value];
					}
				}
			}
		}

		return $value;
	}
}