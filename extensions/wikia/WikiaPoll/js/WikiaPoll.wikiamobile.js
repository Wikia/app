$(function(){
	require(['modal', 'loader'], function(modal, loader){
		var d = document,
			body = d.body,
			toolbar = '<span class=modalTitle>' + $.msg('wikiamobile-wikiapoll-poll') + '</span>',
			thanks = '<div class=wkThanks>' + $.msg('wikiamobile-wikiapoll-thanks-voting') + '</div>',
			vote = $.msg('wikiapoll-vote'),
			currentPoll,
			modalWrapper,
			pollId,
			buildContent = function(elm){
				var answers = elm.getElementsByClassName('answer'),
					question = elm.getElementsByClassName('pollHeader')[0].outerHTML,
					answer,
					i = 0,
					form = question + '<form class=wkPollForm>';

				pollId = elm.getAttribute('data-id');

				while(answer = answers[i]){
					form += '<input class=pollInput name=wpAnswer type=radio id=ans' + i + ' value=' + i + '><label for=ans' + (i++) + '>' + answer.innerHTML + '</label>';
				}

				form += '<input type=submit class="wkBtn wkVote" value="' + vote + '"></form>';

				return form;
			};

		body.addEventListener('click', function(ev){
			var t = ev.target,
				className = t.className;

			//handle click on What do you think? button
			if(className.indexOf('openPoll') > -1) {
				currentPoll = t.parentElement;
				modal.open({
					toolbar: toolbar,
					content: buildContent(currentPoll),
					classes: 'WikiaPollModal',
					stopHiding: true
				});

				window.scrollTo(0,1);

				modalWrapper = modal.getWrapper();

			//handle vote button in modal
			} else if (className.indexOf('wkVote') > -1) {
				ev.stopPropagation();
				ev.preventDefault();

				var form = t.parentElement,
					checked = modalWrapper.querySelector(':checked');

				if(checked) {
					loader.show(form, {center: true});

					$.ajax({
						url: wgScript,
						data: {
							action: 'ajax',
							rs: 'WikiaPollAjax',
							method: 'vote',
							pollId: pollId,
							answer: checked.value,
							title: wgPageName
						},
						dataType: 'json',
						success: function (res) {
							if (res && res.html) {
								loader.hide(form);
								form.removeChild(t);
								form.insertAdjacentHTML('afterend', thanks);
								form.className += ' voted';
								currentPoll.outerHTML = res.html;
							}
						}
					});
				}
			//handle making vote button active when you tap on one of options
			} else if (className.indexOf('pollInput') > -1) {
				t.parentElement.lastElementChild.className += ' active';
			}
		});
	});
});
