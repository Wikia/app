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

	var currentQuestionIndex = null;
	var cookieData = {
		domain: window.wgCookieDomain,
		path: window.wgCookiePath
	};
	var $questionBox = null;

	function init() {
		$(document.body).append('<div class="scavenger-hunt"></div>');

		if (!$.cookie('pyrkon-scavenger-hunt.nick')) {
			$('.scavenger-hunt').html(getInitialMarkup());
			initNickListener();
		} else {
			initQuestion();
		}
	}

	function initNickListener() {
		clearListeners();

		$('.scavenger-hunt form').on('submit', function (evt) {
			evt.preventDefault();

			var nick = $('.scavenger-hunt input').val();

			if (nick) {
				$.cookie('pyrkon-scavenger-hunt.nick', nick, {domain: wgCookieDomain});

				goToQuestion(0);
			}
		}.bind(this));
	}

	function initQuestion() {
		setCurrentQuestionIndex(
			Number($.cookie('pyrkon-scavenger-hunt.question') || 0)
		);

		if (currentQuestionIndex === 0) {
			$.cookie('pyrkon-scavenger-hunt.time', Date.now(), {domain: wgCookieDomain});
			$.cookie('pyrkon-scavenger-hunt.score', 0, {domain: wgCookieDomain});
		}

		getQuestion().done(function (data) {
			$('.scavenger-hunt').html(getQuestionBoxMarkup(data.text));

			initListeners();
		});
	}

	function initListeners() {
		clearListeners();

		$questionBox = $('.pyrkon-question-box');

		$questionBox.find('form').on('submit', onSubmit.bind(this));
		$questionBox.find('.pyrkon-question-box__skip-link').on('click', goToNextQuestion.bind(this));
	}

	function goToNextQuestion() {
		setCurrentQuestionIndex(currentQuestionIndex + 1);

		goToQuestion(
			currentQuestionIndex
		);
	}

	function onSubmit(evt) {
		evt.preventDefault();

		var answer = $questionBox.find('input').val();
		if (answer) {
			validateAnswer(answer).done(onAnswerValidated);
		}
	}

	function onAnswerValidated(data) {
		var isValid = data['is-valid'];
		var score = Number($.cookie('pyrkon-scavenger-hunt.score'));

		if (isValid) {
			$.cookie('pyrkon-scavenger-hunt.score', score + 1, {domain: wgCookieDomain});
		}

		goToNextQuestion();
	}

	function setCurrentQuestionIndex (index) {
		currentQuestionIndex = index;
		$.cookie('pyrkon-scavenger-hunt.question', index, {domain: wgCookieDomain});
	}

	function goToQuestion(index) {
		$.get(
			'/wikia.php?controller=PyrkonScavengerHuntApiController&method=getQuestionUrl&index=' +
			index
		).done(function (data) {
			if (!data) {
				return;
			}

			if (data.url) {
				window.location.href = data.url;
			}

			if (data['is-over']) {
				resolveGame();
			}
		});
	}

	function resolveGame() {
		var time = Date.now() - Number($.cookie('pyrkon-scavenger-hunt.time'));
		console.log(time);

		$('.scavenger-hunt').html(getFinalMarkup());

		clearListeners();

		$('.scavenger-hunt button').on('click', function () {
			resetGame();

			$('.scavenger-hunt').html(getInitialMarkup());
			initNickListener();
		});
	}

	function validateAnswer(submittedAnswer) {
		return $.get(
			'/wikia.php?controller=PyrkonScavengerHuntApiController&method=validateAnswer&index=' +
			currentQuestionIndex +
			'&answer=' +
			submittedAnswer
		);
	}

	function getQuestionBoxMarkup(question) {
		return mustache.render(templates['questionBox'], {
			question: question
		});
	}

	function getInitialMarkup() {
		return mustache.render(templates['questionBoxInitial']);
	}

	function getFinalMarkup() {
		return mustache.render(templates['questionBoxFinal'], {
			time: Math.round((Date.now() - Number($.cookie('pyrkon-scavenger-hunt.time'))) / 1000) + 's',
			nick: $.cookie('pyrkon-scavenger-hunt.nick'),
			score: $.cookie('pyrkon-scavenger-hunt.score') + ' points'
		});
	}

	function getQuestion() {
		return $.get(
			'/wikia.php?controller=PyrkonScavengerHuntApiController&method=getQuestion&index=' +
			currentQuestionIndex
		);
	}

	function resetGame() {
		$.cookie('pyrkon-scavenger-hunt.score', null, {domain: wgCookieDomain});
		$.cookie('pyrkon-scavenger-hunt.nick', null, {domain: wgCookieDomain});
		$.cookie('pyrkon-scavenger-hunt.time', null, {domain: wgCookieDomain});
		$.cookie('pyrkon-scavenger-hunt.question', null, {domain: wgCookieDomain});

		currentQuestionIndex = null;
		$questionBox = null;
	}

	function clearListeners() {
		$('.scavenger-hunt button').off('click');
		$('.pyrkon-question-box__form').off('submit');
		$('.pyrkon-question-box__skip-link').off('click');

	}

	window.resetPyrkon = resetGame.bind(this);

	init();
});
