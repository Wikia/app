define('wikia.dropdownNavigation.utils', function () {
	'use strict';

	/**
	 * @desc validates options sent to constructor
	 * @param {Object} params
	 * @throws error if validation fail
	 */
	function validateParams(params) {
		if (
			!params.render === false &&
			(!Array.isArray(params.sections) || params.sections.length < 1)
		) {
			throw new Error('"sections" param must be non empty array');
		}
		if (typeof params.trigger !== 'string' || params.trigger.length < 1) {
			throw new Error('"trigger" param must be a valid jQuery selector');
		}
	}

	/**
	 * @desc creates reference id for nested dropdown based on first level elements data-id attribute
	 * @param {Object} element - data object of first level dropdown element
	 * @param {Number} index - first level element positon in dropdown list
	 * @param {String} dropdownId - dropdown id
	 * @returns {Object} - data object used for creating second level dropdown element
	 */
	function createReferenceId(element, index, dropdownId) {
		element.referenceId = dropdownId + 'dropdownSection-' + index;

		return element;
	}

	/**
	 * @desc creates dropdown template data object
	 * @param {Object} data - dropdown data object
	 * @returns {Object} - dropdown data object with second level data
	 */
	function createSubsectionData(data) {
		var length = data.sections.length,
			item,
			i;

		data.subsections = [];

		for (i = 0; i < length; i++) {
			item = data.sections[i];

			if (item.sections.length > 0) {
				data.subsections.push(createReferenceId(item, i, data.id));
			}
		}

		return data;
	}

	/**
	 * @desc sets dropdown positions
	 * @param {jQuery} $dropdown - element being positioned
	 * @param {jQuery} $reference - reference element
	 */
	function setPosition($dropdown, $reference) {
		$dropdown.css('left', $reference.position().left + $reference.outerWidth());
	}

	return {
		validateParams: validateParams,
		createSubsectionData: createSubsectionData,
		setPosition: setPosition
	};
});
