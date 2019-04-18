require([
	'jquery',
	'wikia.cookies',
	'templates.pyrkon',
	'wikia.mustache'
], function (
	$,
	cookies,
	templates,
	mustache
) {
	'use strict';

	var currentQuestionIndex = 0;

	function init() {
		debugger;
		setCurrentQuestionIndex(
			cookies.get('pyrkon-scavenger-hunt.question')
		);

		getQuestion().done(function () {
			setCurrentQuestionIndex();

			document.body.appendChild(
				getQuestionBoxMarkup()
			);
		});
	}

	function setCurrentQuestionIndex (index) {
		currentQuestionIndex = index;
		cookies.set('pyrkon-scavenger-hunt.question', index, wgCookieDomain);
	}

	function goToUrl(url) {
		window.location.href = url;
	}

	function validateAnswer(questionIndex, submittedAnswer) {
		return $.get(
			'/index.php?controller=PyrkonScavengerHuntApiController&method=validateAnswer&index=' +
			currentQuestionIndex +
			'&answer=' +
			submittedAnswer
		).done(onAnswerValidated);
	}

	function onAnswerValidated(data) {
		setCurrentQuestionIndex();

		window.location.href = data.url;
	}

	function getQuestionBoxMarkup(question) {
		return mustache.render(templates['questionBox'], {
			question: question
		});
	}

	function getQuestion() {
		return $.get(
			'/index.php?controller=PyrkonScavengerHuntApiController&method=getQuestion&index=' +
			currentQuestionIndex
		);
	}

	init();
});
