<?php

/**
 * Parameter criterion stating that the value must be either 'title' or 'all'
 *
 * @since 0.7
 *
 * @file CriterionLine.php
 * @ingroup Maps
 * @ingroup Criteria
 *
 * @author Kim Eik
 */
class CriterionSearchMarkers extends ItemParameterCriterion
{
	/**
	 * Returns true if $value is either title or all
	 * @param string $value
	 * @param Parameter $parameter
	 * @param array $parameters
	 * @return bool
	 */
	protected function doValidation($value, Parameter $parameter, array $parameters)
	{
		$value = strtolower($value);
		return $value == 'title' || $value == 'all';
	}

	/**
	 * Gets an internationalized error message to construct a ValidationError with
	 * when the criteria validation failed. (for non-list values)
	 *
	 * @param Parameter $parameter
	 *
	 * @since 0.4
	 *
	 * @return string
	 */
	protected function getItemErrorMessage(Parameter $parameter)
	{
		return wfMsgExt('validation-error-invalid-searchmarkers-param', 'parsemag', $parameter->getOriginalName());
	}
}
