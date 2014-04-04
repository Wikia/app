require(['jquery', 'wikia.nirvana'], function($, nirvana) {
	var
		controller = 'TasksSpecialController',
		taskEditor = $('#task_editor'),
		methodContainer = $('#method_selector'),
		form = $('#task_edit_form' ),
		classSelect = $('select[name="task_class"]'),
		methodSelect = $('select[name="task_method"]'),
		classMethodData = {};

	var fillTaskEditor = function(methodData) {
		var editor = "<table>",
			numericTypes = ['int', 'float', 'double'];
		$.each(methodData.params, function(i, param) {
			var inputType = 'text',
				inputAttrs = '',
				docs = [];


			if (numericTypes.indexOf(param.type) != -1) {
				inputType = 'number';
				if (param.type != 'int') {
					inputAttrs = 'step=".1"';
				}
			}

			if (param.type) {
				docs.push('('+param.type+')');
			}

			if (param.docs) {
				docs.push(param.docs);
			}

			docs = docs.join(' ');
			editor +=
				'<tr>' +
					'<td>'+param.name+': </td>' +
					'<td><input name="args[]" type="'+inputType+'" value="'+param.default+'" '+inputAttrs+' /></td>' +
					'<td>'+docs+'</td>' +
				'</tr>'
		});
		editor += "</table>";

		$('#task_edit_fields').html(editor);
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

		nirvana.sendRequest({
			controller: controller,
			method: 'getMethods',
			type: 'get',
			data: {
				class: taskClass
			},
			format: 'json',
			callback: function(response) {
				if (response.exception) {
					console.log(response.exception);
					return;
				}

				for (var i = 0; i < response.length; ++i) {
					methodSelect.append('<option value="'+response[i].name+'">'+response[i].name+'</option>');
					classMethodData[taskClass+'.'+response[i].name] = response[i];
				}

				methodContainer.show();
			}
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

		fillTaskEditor(methodData);

		taskEditor.show();
	});

	form.submit(function() {
		nirvana.sendRequest({
			controller: controller,
			method: 'createTask',
			data: $(this).serialize(),
			format: 'json',
			callback: function(response) {
				console.log(response);
			}
		});

		return false;
	});
});