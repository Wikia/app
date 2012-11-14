var StructureData = {
	selectTemplate: '<select class="objects-to-add">{{#list}}<option data-value="{{id}}" data-url="{{url}}" data-type="{{type}}">{{name}}</option>{{/list}}{{^list}}<option>No objects found!</option>{{/list}}</select> ',
	objectTemplate: '<li><input type="hidden" name="{{type}}[]" value="{{id}}"><a href="{{url}}">{{name}}</a> <button class="secondary remove">Remove</button></li>',
	init: function() {
		var that = this;
		// Attach handlers
		$('#SDObject').on('click', 'td button.load-dropdown', function(event) {
			event.preventDefault();
			var $target = $(event.target);
			that.getObjectsToAdd($target, $target.data('range'));
			$target.attr('disabled', 'disabled');
		});
		$('#SDObject').on('change', 'select.objects-to-add', function() {
			that.addObject($(this));
		});
		$('#SDObject').on('click', 'td button.remove', function(event) {
			event.preventDefault();
			$(event.target).parent().remove();
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
	},
	addObject: function(objectsList) {
		var selectedObject = objectsList.children(':selected'),
			placeToAdd = objectsList.siblings('ol') || objectsList.siblings('ul'),
			i,
			alreadyExists = false;
		placeToAdd.find('input[type="hidden"]').each(function(){
			if ($(this).val() === selectedObject.data('value')) {
				alert('Object already in the list!');
				alreadyExists = true;
			}
		});
		if (!alreadyExists) {
			var	objectData = {
					name: selectedObject.text(),
					url: selectedObject.data('url'),
					id: selectedObject.data('value'),
					type: placeToAdd.data('field-name')
				},
				html = Mustache.render(this.objectTemplate, objectData);
			placeToAdd.append(html);
		}
	}
}
$(function() {
	StructureData.init();
});
