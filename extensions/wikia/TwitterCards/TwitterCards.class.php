<?php

/**
 * Class TwitterCards
 */
class TwitterCards extends WikiaModel {

	const DESCRIPTION_MAX_LENGTH = 200;
	const TITLE_MAX_LENGTH = 70;

	/**
	 * Get meta tags
	 * @param OutputPage $output
	 * @return array
	 */
	public function getMeta( $output ) {
		$title = $output->getTitle();
		if ( !( $title instanceof Title ) ) {
			return [];
		}

		$meta['twitter:card'] = 'summary';
		$meta['twitter:site'] = $this->wg->TwitterAccount;
		$meta['twitter:url'] = $title->getFullURL();

		$titleText = $output->getHTMLTitle();
		$meta['twitter:title'] = wfShortenText( $titleText, self::TITLE_MAX_LENGTH, true );

		$description = $this->getDescription( $output );
		$meta['twitter:description'] = wfShortenText( $description, self::DESCRIPTION_MAX_LENGTH, true );

		return $meta;
	}

	/**
	 * Get page description
	 * @param OutputPage $output
	 * @return string
	 */
	private function getDescription( $output ) {
		$description = '';

		if ( !empty( $output->mDescription ) ) {
			$description = $output->mDescription;
		}

		if ( empty( $description ) ) {
			$description = $output->getHTMLTitle();
		}

		return $description;
	}
}
