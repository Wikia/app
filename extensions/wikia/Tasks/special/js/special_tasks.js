require(['jquery', 'wikia.nirvana'], function($, nirvana) {
	var
		taskEditor = $('#task_editor'),
		methodContainer = $('#method_selector' ),
		classSelect = $('select[name="task_class"]'),
		methodSelect = $('select[name="task_method"]'),
		classMethodData = {},
		reqest = function(method, data, type, format, callback) {
			nirvana.sendRequest({
				controller: 'TasksSpecialController',
				method: method,
				data: data,
				format: format,
				type: type,
				callback: function(response) {
					if (response.exception) {
						console.log(response.exception);
					} else {
						callback(response);
					}
				}
			});
		};

	classSelect.change(function() {
		var taskClass = $(this).val();

		methodSelect
			.find('option:gt(0)')
				.remove();
		methodContainer.hide();
		taskEditor.hide();

		if (taskClass == '') {
			return;
		}

		reqest('getMethods', { 'class': taskClass }, 'get', 'json', function(response) {
			for (var i = 0; i < response.length; ++i) {
				methodSelect.append('<option value="'+response[i].name+'">'+response[i].name+'</option>');
				classMethodData[taskClass+'.'+response[i].name] = response[i];
			}

			methodContainer.show();
		});
	});

	methodSelect.change(function() {
		var
			taskClass = classSelect.val(),
			classMethod = $(this).val(),
			methodData = classMethodData[taskClass+'.'+classMethod];

		taskEditor
			.hide()
			.find('pre')
				.text(methodData.docs)
			.end();

		taskEditor.show();
	});
});