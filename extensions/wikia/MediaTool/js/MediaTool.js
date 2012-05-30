var MediaTool = MediaTool || (function(){

	/** @private **/
	function initInternal() {
		$().log('MediaTool: internal init');

		$("#tmpMediaToolButton").click(function(event) {
			showModal(event);
		});
	};

	function showModal(event) {
		$().getModal(
			'/wikia.php?controller=MediaTool&method=getModalContent&format=html',
			'#mediaToolDialog',
			{width:600});
	};

	/** @public **/
	return {
		init: function() {
			// init stuff here
			$.loadJQueryUI(initInternal);
		},

		showModal: showModal
	}

})();