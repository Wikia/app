var StructureData = {
	selectTemplate: '<select class="objects-to-add">{{#list}}<option value="{{id}}" data-url="{{url}}" data-type="{{type}}">{{name}}</option>{{/list}}{{^list}}<option>No objects found!</option>{{/list}}</select> ',
	init: function() {
		var that = this;
		// Attach handlers
		$('#SDObject').on('click', 'td button', function(event) {
			event.preventDefault();
			var $target = $(event.target);
			that.getObjectsToAdd($target, $target.data('range'));
			$target.attr('disabled', 'disabled');
		});
	},
	// METHOD for fetching collection of SDS objects form a given class and rendering <select> element with them insiede
	getObjectsToAdd: function(postion, classes) {
		var that = this,
			classesStr = classes.split(' '),
			classesStr = classesStr.join(',');
		$.nirvana.sendRequest( {
			controller: 'StructuredDataController',
			method: 'getCollection',
			type: 'GET',
			data: {
				objectType: classesStr
			},
			callback: function(data) {
				var html = Mustache.render(that.selectTemplate, data);
				postion.after(html);
			}
		});
	}
}
$(function() {
	StructureData.init();
});
