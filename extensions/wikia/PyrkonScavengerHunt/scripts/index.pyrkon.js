define('index.pyrkon', ['jquery'], function ($) {
	'use strict';

	var currentQuestionIndex = 0;

	function init() {
		getQuestions().then(function () {
			setCurrentQuestionIndex();

			document.body.appendChild(
				getQuestionBoxMarkup()
			);
		});
	}
	function setCurrentQuestionIndex (index) {
		currentQuestionIndex = index;
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
		).then(onAnswerValidated);
	}

	function onAnswerValidated(data) {
		setCurrentQuestionIndex();

		window.location.href = data.url;
	}

	function getQuestionBoxMarkup() {

	}

	function getQuestions() {
		return $.get('/index.php?controller=PyrkonScavengerHuntApiController&method=getQuestions');
	}
});
