require(['wikia.document', 'venus.nodeFinder'], function(d, nodeFinder){
	'use strict';

	/**
	 * Create module container
	 *
	 * @param {String} id identifier for module container
	 * @param {String} className class name for module container
	 * @returns {Node} module container
	 */
	function createModuleContainer(id, className) {
		var container = d.createElement('div');

		container.id = id;
		container.classList.add(className);

		return container;
	}

	/**
	 * Insert module before selected element
	 *
	 * @param {Node} container parent container
	 * @param {Node} module module to insert
	 * @param {Node} element element before which module will be inserted
	 */
	function insertModuleBeforeElement(container, module, element) {
		container.insertBefore(module, element);
	}

	/**
	 * Insert module as a last child in container
	 *
	 * @param container parent container
	 * @param module module to insert
	 */
	function insertModuleAsLastChild(container, module) {
		container.appendChild(module);
	}

	/**
	 * Add video recommendations in correct place in content
	 * (before first h2 header below boundary offset top)
	 */
	function addVideoRecommendations() {
		var boundaryOffsetTop = 1500,
			contentContainer = d.getElementById('mw-content-text'),
			headerSelector = '#mw-content-text > h2',
			videoRecommendations, header;

		videoRecommendations = createModuleContainer('videoRecommendations', 'video-recommendations');
		header = nodeFinder.findNodeByOffsetTop(contentContainer, headerSelector, boundaryOffsetTop);

		if (header !== null) {
			insertModuleBeforeElement(contentContainer, videoRecommendations, header);
		} else {
			insertModuleAsLastChild(contentContainer, videoRecommendations);
		}
	}

	addVideoRecommendations();
});
