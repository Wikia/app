<?php

/**
 * Helps extract assessments from a parsed $DOM file
 **/
class AssessmentsExtractor
{
	/** @todo document */
	private $mText;

	/**
	 * @todo Document
	 * @param string $preparedText TODO: what is it for?
	 */
	function __construct( $preparedText ) {
		$this->mText = $preparedText;
	}

	/**
	 * Once AssessmentsExtractor is built, call this method to generate
	 * an array of assessment.
	 * @todo Describe the returned array
	 * @todo What happens if the preparedText does not match the expected format?
	 * @return array Assessments
	 */
	public function extractAssessments() {
		// Am going to a special level in hell for using Regex to parse HTML, am I not?
		$regex = '/<span data-project-name="(?P<project>.*)" data-importance="(?P<importance>\w*)" data-quality="(?P<quality>\w*)"\s*>/';
		$matches = array();
		preg_match_all($regex, $this->mText, $matches, PREG_SET_ORDER);

		$assessments = array();
		foreach($matches as $match) {
			$assessments[$match['project']] = array(
				'importance' => $match['importance'],
				'quality' => $match['quality']
			);
		}
		return $assessments;
	}
}
