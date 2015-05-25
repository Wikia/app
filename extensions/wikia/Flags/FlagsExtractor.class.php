<?php

namespace Flags;


class FlagsExtractor {

	const
		// Number of opening and ending brackets
		BRACKETS_NUMBER = 2;

	private
		$offset,
		$templateOffsetStart,
		$inProgress,
		$templates = [],
		$text,
		$templateName;

	public function init( $text, $templateName ) {
		$this->text = $text;
		$this->templateName = $templateName;
		$this->offset = 0;
		$this->templates = [];
	}

	public function hasTemplate() {
		return (bool) $this->templateOffsetStart;
	}

	public function getAllTemplates() {
		do {
			$this->getTemplate();
		} while ( $this->hasTemplate() );

		return $this->templates;
	}

	public function getTemplate() {
		if ( empty( $this->text ) || empty ( $this->templateName ) ) {
			echo 'You need to set up text and template name.';
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

		$templateName = '{{' . $this->templateName;

		// Position of template begin
		$this->templateOffsetStart = $this->findTemplatePosition( $templateName, $this->offset );

		if ( $this->templateOffsetStart !== false ) {
			$this->offset = $this->templateOffsetStart + strlen( $templateName );
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

					$template['template'] = substr( $this->text, $this->templateOffsetStart, $this->offset - $this->templateOffsetStart );

					// Check if there is last template parameter
					if ( !is_null( $paramOffsetStart ) ) {
						$templateParams += $this->getTemplateParam( $isParamWithName, $paramsCounter, $paramOffsetStart );
					}

					$template['params'] = $templateParams;
					$this->templates[] = $template;
				}
			}
		}

		return $this->templates;
	}

	/**
	 * Check if template is wrapped by <nowiki> tag
	 */
	private function isWrappedByNoWikiTag( $offset ) {
		while( $offset > 0 && $this->text[--$offset] == ' ' ) {};
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
	 */
	private function findTemplatePosition( $templateName, $offset ) {
		while ( ( $offsetStart = stripos($this->text, $templateName, $offset) ) !== false ) {
			$offset = $offsetStart + strlen($templateName);
			if ( $this->isSearchedTemplate( $templateName, $offsetStart ) ) {
				return $offsetStart;
			}
		}
		return false;
	}

	private function isSearchedTemplate( $templateName, $offsetStart ) {
		$offset = $offsetStart + strlen($templateName);

		return !$this->isWrappedByNoWikiTag( $offsetStart )
			&& ( $this->text[$offset] == '}' || $this->text[$offset] == '|' );
	}

	/**
	 * Get template from params
	 */
	private function getTemplateParam( $isParamWithName, $paramsCounter, $paramOffsetStart ) {
		$paramEndChars = $this->inProgress ? 0 : self::BRACKETS_NUMBER;

		$param = substr(
			$this->text,
			$paramOffsetStart,
			$this->offset - $paramOffsetStart - $paramEndChars
		);

		if ( $isParamWithName ) {
			list($paramName, $paramValue) = explode('=', $param, 2);
			$paramName = trim($paramName);
			$paramValue = trim($paramValue);
			$templateParams[$paramName] = $paramValue;
		} else {
			$templateParams[$paramsCounter] = $param;
		}

		return $templateParams;
	}
} 
