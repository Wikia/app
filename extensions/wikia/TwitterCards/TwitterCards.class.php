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
		$meta['twitter:title'] = $this->getPageTitle( $title );

		// add description
		$description = $this->getDescription( $output );
		if ( !empty( $description ) ) {
			$meta['twitter:description'] = $description;
		}

		return $meta;
	}

	/**
	 * Get page title
	 * @param Title $title
	 * @return string
	 */
	protected function getPageTitle( $title ) {
		if ( $title->isMainPage() ) {
			$pageTitle = $this->wg->Sitename;
		} else if ( !empty( $this->wg->EnableBlogArticles )
			&& ( $title->getNamespace() == NS_BLOG_ARTICLE || $title->getNamespace() == NS_BLOG_ARTICLE_TALK ) )
		{
			$pageTitle = $title->getSubpageText();
		} else {
			$pageTitle = $title->getText();
		}

		return mb_substr( $pageTitle, 0, self::TITLE_MAX_LENGTH );
	}

	/**
	 * Get page description
	 * @param OutputPage $output
	 * @return string
	 */
	protected function getDescription( $output ) {
		$description = '';
		if ( !empty( $output->mDescription ) ) {
			$description = mb_substr( $output->mDescription, 0, self::DESCRIPTION_MAX_LENGTH );
		}

		return $description;
	}

}
