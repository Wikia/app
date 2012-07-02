<?php

class ApiAbuseFilterEvalExpression extends ApiBase {
	public function execute() {
		$params = $this->extractRequestParams();

		$result = AbuseFilter::evaluateExpression( $params['expression'] );

		$this->getResult()->addValue( null, $this->getModuleName(), array( 'result' => $result ) );
	}

	public function getAllowedParams() {
		return array(
			'expression' => array(
				ApiBase::PARAM_REQUIRED => true,
			),
		);
	}

	public function getParamDescription() {
		return array(
			'expression' => 'The expression to evaluate',
		);
	}

	public function getDescription() {
		return array(
			'Evaluates an AbuseFilter expression'
		);
	}

	public function getExamples() {
		return array(
			'api.php?action=abusefilterevalexpression&expression=lcase("FOO")'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiAbuseFilterEvalExpression.php 108852 2012-01-13 21:36:51Z reedy $';
	}
}
