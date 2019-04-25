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
	var answer = null;
	var isLoading = false;

	function init() {
		$.ajaxSetup({
			crossDomain: true,
			xhrFields: {
				withCredentials: true
			}
		});

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
				$('.scavenger-hunt button').prop('disabled', true);

				validateNick(nick);
			}
		}.bind(this));
	}

	function validateNick(nick) {
		$.post(
			'https://services.fandom.com/pyrkon-scavenger-hunt/games/verify',
			JSON.stringify({
				userName: nick
			})
		).done(function () {
			$.cookie('pyrkon-scavenger-hunt.nick', nick, {domain: wgCookieDomain});
			goToQuestion(0);
		}).fail(function () {
			new window.BannerNotification('This nick is already taken by someone else')
				.setType('error')
				.show();

			isLoading = false;
		});
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
			if (data.text) {
				$('.scavenger-hunt').html(getQuestionBoxMarkup(data.text));
			}

			initListeners();
		});
	}

	function initListeners() {
		clearListeners();

		$questionBox = $('.pyrkon-question-box');

		$questionBox.find('form').on('submit', onSubmit.bind(this));
		$questionBox.find('.pyrkon-question-box__skip-link').on('click', function () {
			if (!isLoading) {
				$('.scavenger-hunt button').prop('disabled', true);
				saveCurrentAnswerInCookies.bind(this)(false);
				goToNextQuestion.bind(this)();

				isLoading = true;
			}
		});
	}

	function goToNextQuestion() {
		setCurrentQuestionIndex(currentQuestionIndex + 1);

		goToQuestion(
			currentQuestionIndex
		);
	}

	function onSubmit(evt) {
		evt.preventDefault();

		answer = $questionBox.find('input').val().trim().toLowerCase();

		if (answer) {
			if (!isLoading) {
				validateAnswer(answer).done(onAnswerValidated);

				isLoading = true;
			}
		}
	}

	function saveCurrentAnswerInCookies(isValid) {
		var answers = $.cookie('pyrkon-scavenger-hunt.answers');
		var answersParsed = answers ? JSON.parse(answers) : [];

		answersParsed.push({
			questionId: currentQuestionIndex,
			value: answer,
			isValid: isValid
		});

		$.cookie('pyrkon-scavenger-hunt.answers', JSON.stringify(answersParsed), {domain: wgCookieDomain});
	}

	function onAnswerValidated(data) {
		var isValid = data['is-valid'];
		var score = Number($.cookie('pyrkon-scavenger-hunt.score'));

		if (isValid) {
			$.cookie('pyrkon-scavenger-hunt.score', score + 1, {domain: wgCookieDomain});
		}

		saveCurrentAnswerInCookies(isValid);

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

		saveScorePermanently().always(function () {
			resetGame();

			$('.scavenger-hunt button').on('click', function () {
				$('.scavenger-hunt').html(getInitialMarkup());
				initNickListener();
			});
		}.bind(this));
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
		$.cookie('pyrkon-scavenger-hunt.answers', null, {domain: wgCookieDomain});
		$.cookie('pyrkon-scavenger-hunt.nick', null, {domain: wgCookieDomain});
		$.cookie('pyrkon-scavenger-hunt.time', null, {domain: wgCookieDomain});
		$.cookie('pyrkon-scavenger-hunt.question', null, {domain: wgCookieDomain});

		currentQuestionIndex = null;
		$questionBox = null;
		isLoading = false;
	}

	function clearListeners() {
		$('.scavenger-hunt button').off('click');
		$('.pyrkon-question-box__form').off('submit');
		$('.pyrkon-question-box__skip-link').off('click');
	}

	function saveScorePermanently() {
		var nick = $.cookie('pyrkon-scavenger-hunt.nick');
		var time = $.cookie('pyrkon-scavenger-hunt.time');
		var answers = JSON.parse($.cookie('pyrkon-scavenger-hunt.answers'));

		return $.post('https://services.fandom.com/pyrkon-scavenger-hunt/games', JSON.stringify({
			userName: nick,
			totalTime: time,
			answers: answers
		}));
	}

	window.resetPyrkon = resetGame.bind(this);

	init();
});
