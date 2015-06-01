<?php

/**
 * A class used to parse text and fetch templates with their parameters.
 *
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags;


class FlagsExtractor {

	const
		// Number of opening and ending brackets
		BRACKETS_NUMBER = 2,
		//Flags default tag
		FLAGS_DEFAULT_TAG = '__FLAGS__',
		// Actions
		ACTION_ADD_FIRST_FLAG = 1,
		ACTION_ADD_ALL_FLAGS = 2,
		ACTION_REMOVE_FIRST_FLAG = 4,
		ACTION_REMOVE_ALL_FLAGS = 8,
		ACTION_REPLACE_FIRST_FLAG = 16,
		ACTION_REPLACE_ALL_FLAGS = 32;

	private
		$app,
		$offset,
		$templateOffsetStart,
		$inProgress,
		$templates = [],
		$text,
		$templateName,
		$isFirst = true,
		$actions,
		$actionParams;

	public function __construct() {
		$this->app = \F::app();
	}

	public function init( $text, $templateName, $actions = [], $actionParams = [] ) {
		$this->text = $text;
		$this->templateName = $templateName;
		$this->offset = 0;
		$this->templates = [];
		$this->actions = $actions;
		$this->actionParams = $actionParams;
		$this->isFirst = true;
	}

	/**
	 * Get text
	 *
	 * @return string
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * Check if there is another template in text
	 *
	 * @return bool
	 */
	public function hasTemplate() {
		return (bool) $this->templateOffsetStart;
	}

	/**
	 * Get all templates.
	 *
	 * @see getTemplate
	 * @return Array templates
	 */
	public function getAllTemplates() {
		do {
			$this->getTemplate();
		} while ( $this->hasTemplate() );

		return $this->templates;
	}

	/**
	 * Parse text to fetch template and it's params
	 * Array contains template name, wikitext and it's params
	 *
	 * @return array|bool
	 */
	public function getTemplate() {
		if ( empty( $this->text ) || empty ( $this->templateName ) ) {
			return false;
		}

		$template = [];
		$templateParams = [];

		$templateBracketsCounter = self::BRACKETS_NUMBER;
		$linkBracketsCounter = 0;

		$paramOffsetStart = null;

		$this->inProgress = true;
		$isParamWithName = false;
		$paramsCounter = 1;

		$templateBegin = '{{' . $this->templateName;

		// Position of template begin
		$this->templateOffsetStart = $this->findTemplatePosition( $templateBegin, $this->offset );

		if ( $this->templateOffsetStart !== false ) {
			$this->offset = $this->templateOffsetStart + strlen( $templateBegin );
			$textLength = strlen( $this->text ) - 1;

			while( $this->inProgress && $this->offset <= $textLength ) {

				switch ( $this->text[$this->offset] ) {
					case '}' : $templateBracketsCounter--; break;
					case '{' : $templateBracketsCounter++; break;
					case ']' : $linkBracketsCounter--; break;
					case '[' : $linkBracketsCounter++; break;
					// Looking for template parameters - check if it's not link or nested template parameter
					case '|' : if ( $templateBracketsCounter == self::BRACKETS_NUMBER && !$linkBracketsCounter ) {
						// First parameter
						if ( is_null( $paramOffsetStart ) ) {
							$paramOffsetStart = $this->offset + 1;
							// Next parameter
						} else {
							$templateParams += $this->getTemplateParam( $isParamWithName, $paramsCounter, $paramOffsetStart );
							$paramsCounter++;
							$isParamWithName = false;
							$paramOffsetStart = $this->offset + 1;
						}
					}
						break;
					// Check if param has name and it's not in link or nested template
					case '=' : if ( !is_null( $paramOffsetStart ) && $templateBracketsCounter == self::BRACKETS_NUMBER && !$linkBracketsCounter ) {
						$isParamWithName = true;
					}
						break;
				}

				$this->offset++;

				// End of template
				if ( $templateBracketsCounter === 0 ) {
					$this->inProgress = false;

					$template['name'] = $this->templateName;
					$template['template'] = substr( $this->text, $this->templateOffsetStart, $this->offset - $this->templateOffsetStart );

					// Check if there is last template parameter
					if ( !is_null( $paramOffsetStart ) ) {
						$templateParams += $this->getTemplateParam( $isParamWithName, $paramsCounter, $paramOffsetStart );
					}

					$template['params'] = $templateParams;
					$this->templates[] = $template;

					$this->doTemplateActions();

					if ( $this->isFirst ) {
						$this->isFirst = false;
					}
				}
			}
		}

		return $this->templates;
	}

	/**
	 * Get last parsed template
	 *
	 * @return mixed
	 */
	public function getLastTemplate() {
		if ( !empty( $this->templates ) ) {
			return end( $this->templates );
		}
		return null;
	}

	/**
	 * Find template (from given list) which is first in the text
	 *
	 * @param array $templateNames list with allowed templates
	 * @return null|string template name
	 */
	public function findFirstTemplateFromList( Array $templateNames, $text = null ) {
		$minPosition = null;
		$firstTemplate = null;

		if ( !is_null( $text ) ) {
			$this->text = $text;
		}

		foreach ( $templateNames as $templateName ) {
			$templateBegin = "{{{$templateName}";
			if ( ( $position = $this->findTemplatePosition( $templateBegin, 0 ) ) !== false ) {
				if ( $position === 0 ) {
					return $templateName;
				}

				if ( is_null( $minPosition ) || $position < $minPosition ) {
					$minPosition = $position;
					$firstTemplate = $templateName;
				}
			}
		}

		return $firstTemplate;
	}

	/**
	 * Do some action after template is parsed
	 *
	 * Actions:
	 *
	 * - Add first template as flag (@see ACTION_ADD_FIRST_FLAG)
	 * - Add all templates as flags (@see ACTION_ADD_ALL_FLAGS)
	 * - Remove first template from text (@see ACTION_REMOVE_FIRST_FLAG)
	 * - Remove all templates from text (@see ACTION_REMOVE_ALL_FLAGS)
	 * - Replace first template by tag (@see ACTION_REPLACE_FIRST_FLAG)
	 * - Replace all templates by tag (@see ACTION_REMOVE_ALL_FLAGS)
	 *
	 * Actions for first template have higher priority
	 * For example:
	 *
	 * If we set "replace first template" and "remove all templates",
	 * first template will be replaced, all others will be removed
	 *
	 * How to use:
	 *
	 * if we want: add first template as flag, replace first template and removed all others we need to pass array
	 * [
	 * 		self::ACTION_ADD_FIRST_FLAG,
	 * 		self::ACTION_REPLACE_FIRST_FLAG,
	 * 		self::ACTION_REMOVE_ALL_FLAGS
	 * ]
	 *
	 * @return bool
	 */
	private function doTemplateActions() {
		if ( empty( $this->actions ) ) {
			return false;
		}

		$sum = array_sum( $this->actions );

		$actionForFirstFlag = ( $sum & ( self::ACTION_REPLACE_FIRST_FLAG | self::ACTION_REMOVE_FIRST_FLAG ) ) && $this->isFirst;
		$actionForAllFlags = $sum & ( self::ACTION_REMOVE_ALL_FLAGS | self::ACTION_REPLACE_ALL_FLAGS );

		if ( ( $sum & ( self::ACTION_ADD_FIRST_FLAG ) && $this->isFirst )
			|| ( $sum & self::ACTION_ADD_ALL_FLAGS ) ) {
			$this->addFlagToPage();
		}

		if ( $actionForFirstFlag ) {
			if ( $sum & self::ACTION_REPLACE_FIRST_FLAG ) {
				$this->replaceTemplateByTag();
			} else {
				$this->removeTemplate();
			}
		} elseif ( $actionForAllFlags ) {
			if ( $sum & self::ACTION_REPLACE_ALL_FLAGS ) {
				$this->replaceTemplateByTag();
			} else {
				$this->removeTemplate();
			}
		}
	}

	/**
	 * Add flag to page
	 *
	 * Parameters:
	 * - wiki_id (required)
	 * - page_id (required)
	 * - flag_type_id (optional)
	 *
	 * @return bool
	 */
	private function addFlagToPage() {
		if ( !empty( $this->actionParams )
			&& isset( $this->actionParams['wiki_id'] )
			&& isset( $this->actionParams['page_id'] )
		) {
			$flagsToPages = $this->prepareParameters();

			if ( !$flagsToPages ) {
				return false;
			}

			$response = $this->app->sendRequest( 'FlagsApiController',
				'addFlagsToPage',
				$flagsToPages
			)->getData();

			return $response['status'];
		}

		return false;
	}

	/**
	 * Prepare parameters required to add flag to page
	 *
	 * @return array|bool
	 */
	private function prepareParameters() {
		$params = [];

		$template = $this->getLastTemplate();

		if ( !$template ) {
			return false;
		}

		if ( !empty( $template['params'] ) ) {
			$params = $template['params'];
		}

		if ( !isset( $this->actionParams['flag_type_id'] ) || empty( $this->actionParams['flag_type_id'] ) ) {
			if ( $flagTypeId = $this->getFlagTypeIdByTemplate( $template['name'] ) ) {
				$this->actionParams['flag_type_id'] =  $flagTypeId;
			} else {
				return false;
			}

		}

		$flagsToPages = [
			'wiki_id' => $this->actionParams['wiki_id'],
			'page_id' => $this->actionParams['page_id'],
			'flags' => [
				[
					'flag_type_id' => $this->actionParams['flag_type_id'],
					'params' => $params
				]
			]
		];

		return $flagsToPages;
	}

	/**
	 * Get flag type id based on template name
	 *
	 * @param String $viewName
	 * @return mixed
	 */
	private function getFlagTypeIdByTemplate( $viewName ) {
		$response = $this->app->sendRequest( 'FlagsApiController',
			'getFlagTypeIdByTemplate',
			[
				'wiki_id' => $this->actionParams['wiki_id'],
				'flag_view' => $viewName
			]
		)->getData();

		return $response['data'];
	}

	/**
	 * Remove template from text
	 */
	private function removeTemplate() {
		$this->replaceTemplateByTag( '' );
	}

	/**
	 * Replace template in text by given tag
	 *
	 * @param null $tag
	 */
	private function replaceTemplateByTag( $tag = null ) {
		if ( is_null( $tag ) ) {
			$tag = $this->getReplacementTag();
		}

		$template = $this->getLastTemplate();

		$templateLength = strlen( $template['template'] );

		$this->text = substr_replace( $this->text, $tag, $this->templateOffsetStart, $templateLength );
	}

	public function isTagAdded( $tag = null, $text = null ) {
		if ( is_null( $tag ) ) {
			$tag = $this->getReplacementTag();
		}

		if ( is_null( $text ) ) {
			$text = $this->text;
		}

		return strpos( $text, $tag ) !== false;
	}

	/**
	 * Get tag to replace template
	 *
	 * @return string
	 */
	private function getReplacementTag() {
		if ( !empty( $this->actionParams )
			&& isset( $this->actionParams['replacementTag'] )
		) {
			return $this->actionParams['replacementTag'];
		} else {
			return self::FLAGS_DEFAULT_TAG;
		}
	}

	/**
	 * Check if template is wrapped by <nowiki> tag
	 *
	 * @param int $offset position of template beginning in text
	 * @return bool
	 */
	private function isWrappedByNoWikiTag( $offset ) {
		$offset--;
		while( $offset > 0 && ( $this->text[$offset] == ' ' || $this->text[$offset] == "\n" ) ) {
			$offset--;
		};

		if ( $offset >= 7 ) {
			$offset -= 7;

			$tag = substr( $this->text, $offset, 8 );

			if ( strcasecmp( $tag, '<nowiki>' ) == 0 ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Find template position in text
	 *
	 * @param string $templateName template name
	 * @param int $offset
	 */
	private function findTemplatePosition( $templateName, $offset ) {
		while ( ( $offsetStart = stripos( $this->text, $templateName, $offset ) ) !== false ) {
			$offset = $offsetStart + strlen( $templateName );
			if ( $this->isSearchedTemplate( $templateName, $offsetStart ) ) {
				return $offsetStart;
			}
		}
		return false;
	}

	/**
	 * Check if it's template we are looking and it's not wrapped by <nowiki> tag
	 *
	 * @param $templateName
	 * @param $offsetStart
	 * @return bool
	 */
	private function isSearchedTemplate( $templateName, $offsetStart ) {
		$offset = $offsetStart + strlen( $templateName );

		while ( $this->text[$offset] == ' ' || $this->text[$offset] == "\n" ) {
			$offset++;
		}

		return !$this->isWrappedByNoWikiTag( $offsetStart )
		&& ( $this->text[$offset] == '}' || $this->text[$offset] == '|' );
	}

	/**
	 * Get template from params
	 *
	 * @param bool $isParamWithName does the parameter have name (preceded by '=')
	 * @param int $paramsCounter parameter number
	 * @param int $paramOffsetStart offset of parameter begin
	 * @return mixed
	 */
	private function getTemplateParam( $isParamWithName, $paramsCounter, $paramOffsetStart ) {
		$paramEndChars = $this->inProgress ? 0 : self::BRACKETS_NUMBER;

		$param = substr(
			$this->text,
			$paramOffsetStart,
			$this->offset - $paramOffsetStart - $paramEndChars
		);

		if ( $isParamWithName ) {
			list( $paramName, $paramValue ) = explode( '=', $param, 2 );
			$paramName = trim( $paramName );
			$paramValue = trim( $paramValue );
			$templateParams[$paramName] = $paramValue;
		} else {
			$templateParams[$paramsCounter] = $param;
		}

		return $templateParams;
	}
} 
