require(['modal', 'loader'], function(modal, loader){
	var d = document,
		body = d.body,
		toolbar = '<span class=modalTitle>' + $.msg('wikiamobile-wikiapoll-poll') + '</span>',
		thanks = '<div class=wkThanks>' + $.msg('wikiamobile-wikiapoll-thanks-voting') + '</div>',
		currentPoll,
		// send AJAX request to extension's ajax dispatcher in MW
		ajax = function(method, params, callback) {
			$.ajax({
				url: wgScript + '?action=ajax&rs=WikiaPollAjax&method=' + method,
				data: params,
				dataType: 'json',
				success: callback
			});
		},
		pollId,
		buildContent = function(elm){
			var answers = elm.getElementsByClassName('answer'),
				question = elm.getElementsByClassName('pollHeader')[0].outerHTML,
				answer,
				i = 0,
				form = question + '<form class=wkPollForm>';

			pollId = elm.getAttribute('data-id');

			while(answer = answers[i]){
				form += '<input name=wpAnswer type=radio id=ans' + i + ' value=' + i + '><label for=ans' + (i++) + '>' + answer.innerHTML + '</label>';
			}

			form += '<input type=submit class="wkBtn wkVote" value=Vote></form>';

			return form;
		};

	body.addEventListener('click', function(ev){
		var t = ev.target,
			className = t.className;

		if(className.indexOf('openPoll') > -1) {
			currentPoll = t.parentElement;
			modal.open({
				toolbar: toolbar,
				content: buildContent(currentPoll),
				classes: 'WikiaPollModal',
				stopHiding: true
			});
		} else if (className.indexOf('wkVote') > -1 ) {
			ev.stopPropagation();
			ev.preventDefault();

			loader.show(t);

			ajax('vote', {
				pollId: pollId,
				answer: modal.getWrapper().querySelector(':checked').value,
				title: wgPageName
			}, function(res) {
				if(res && res.html){
					var form = t.parentElement;
					form.removeChild(t);
					form.insertAdjacentHTML('afterend', thanks);
					form.className += ' voted';
					currentPoll.outerHTML = res.html;
				}
			});
		}
	}, true);
});
