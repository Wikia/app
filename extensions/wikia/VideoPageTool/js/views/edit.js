define( 'vpt.views.edit', [
	'jquery'
], function( $ ) {

	function VPTEdit() {
		this.$form = $( '.vpt-form' );
		this.init();
	}

	VPTEdit.prototype = {
		init: function() {
			this.$form.validate({
				//debug: true
			});
		}
	};

	return VPTEdit;
});

require(['vpt.views.edit'], function(EditView) {
	$(function() {
		new EditView();
	});
});
