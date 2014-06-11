define('wikia.intMap.createMap.utils',
	[
		'jquery',
		'wikia.window',
		'wikia.mustache'
	],
	function($, w, mustache) {
	'use strict';

	/**
	 * @desc bind events to a modal
	 * @param {object} modal - modal component
	 * @param {object} events - object containing array of handlers for each event type
	 */

	function bindEvents(modal, events) {
		Object.keys(events).forEach(function(event) {
			events[event].forEach(function(handler) {
				modal.bind(event, handler);
			});
		});
	}

	/**
	 * @desc render template
	 * @param {string} template - mustache template
	 * @param {object} templateData - mustache template variables
	 * @param {object} partials - mustache partials
	 */

	function render(template, templateData, partials) {
		return mustache.render(template, templateData, (typeof partials === 'object' ? partials : null));
	}

	/**
	 * @desc configure buttons (set visibility + attach events)
	 * @param {object} modal - modal component
	 * @param {object} buttons - object with button ids as keys and event names as values
	 */

	function setButtons(modal, buttons) {
		// reset buttons visibility
		modal.$buttons.addClass('hidden');

		Object.keys(buttons).forEach(function(key) {
			modal.$buttons
				.filter(key)
				.data('event', buttons[key])
				.removeClass('hidden');
		});
	}

	/**
	 * @desc
	 * @param {object} modal - modal component
	 * @param {FormData} formData - FormData object with file input named wpUploadFile
	 * @param {string} uploadEntryPoint - URL to upload entry point in backend
	 * @param {function=} successCallback - optional callback to call after successful request
	 */

	function upload(modal, formData, uploadEntryPoint, successCallback) {
		$.ajax({
			contentType: false,
			data: formData,
			processData: false,
			type: 'POST',
			url: w.wgScriptPath + uploadEntryPoint,
			success: function(response) {
				var data = response.results;

				if (data && data.success) {
					modal.trigger('cleanUpError');

					if (typeof successCallback === 'function') {
						successCallback(data);
					}
				} else {
					modal.trigger('error', data.errors.pop());
				}
			},
			error: function(response) {
				modal.trigger('error', response.results.error);
			}
		});
	}

	/**
	 * @desc check if string is empty
	 * @param {string} value
	 * @returns {boolean}
	 */

	function isEmpty(value) {
		return value.trim().length === 0;
	}

	return {
		bindEvents: bindEvents,
		render: render,
		setButtons: setButtons,
		upload: upload,
		isEmpty: isEmpty
	}
});
