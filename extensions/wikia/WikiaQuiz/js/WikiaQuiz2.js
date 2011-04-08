/*
$('.question-label, .question-bubble').addClass('off-screen')
$('li:nth-child(4) img').css('-webkit-transform', 'matrix(2, 0, 0, 2, -480, -120)');$('li:nth-child(4)').siblings().addClass('wrong');$('.question-bubble').addClass('hide');$('li:nth-child(4) p').addClass('hi
*/

var WikiaQuiz = {
	cq: false,
	imageWidth: 190,
	score: 0,
	startTime: false,
	init: function() {
		$('.start-button').click(function() {
			$('.title-screen').hide();
			$('.count-down').show();
			WikiaQuiz.countDown();
		});
	},
	countDown: function() {
		var cadenceList = ['SET...', 'GO!'];
		var cadence = $('.count-down .cadence');
		var number = $('.count-down .number');
		var i = 0;
		var iHook = setInterval(function() {
			if(i == 2) {
				clearInterval(iHook);
				$('.count-down').fadeOut(500);
				$('.questions').fadeIn(1000, function() {
					WikiaQuiz.startQuiz();
				});
			} else {
				cadence.html(cadenceList[i]);
				number.html(3 - ++i);
			}
		}, 1000);
	},
	startQuiz: function() {
		WikiaQuiz.startTime = new Date();
		WikiaQuiz.initializeQuestion($('.questions .question-set:first-child'));	
	},
	initializeQuestion: function(cq) {
		WikiaQuiz.cq = cq;
		setTimeout(WikiaQuiz.initializeAnswers, 2000);
	},
	initializeAnswers: function() {
		WikiaQuiz.cq.find('.question-label, .question-bubble, .answers').addClass('off-screen');
		setTimeout(function() {
			WikiaQuiz.cq.find('.answer').click(WikiaQuiz.handleAnswerClick);
		}, 1000);
	},
	handleAnswerClick: function() {
		WikiaQuiz.cq.find('.answer').unbind('click');
		var answer = $(this).closest('.answer');
		var i = WikiaQuiz.cq.find('.answer').index(answer);
		var img = answer.find('.answer-pic');
		var translateX = 0 - (i * WikiaQuiz.imageWidth);
		var label = answer.find('p');
		var exp = WikiaQuiz.cq.find('.answer-label, .next-button');
		if(answer.data('correct')) {
			WikiaQuiz.score++;
			console.log('foo');
		}
		exp = exp.add(answer.data('correct') ? WikiaQuiz.cq.find('.answer-explanation.correct') : WikiaQuiz.cq.find('.answer-explanation.wrong'));
		WikiaQuiz.cq.find('.answer-label').html(label.html());
		//img.css('-webkit-transform', 'matrix(2, 0, 0, 2, ' + translateX + ', -120)');
		answer.addClass('correct').siblings().addClass('wrong');
		img.css('left', translateX + 'px');
		WikiaQuiz.cq.find('.question-bubble').addClass('hide');
		label.addClass('hide');
		exp.fadeIn(1000, function() {
			WikiaQuiz.cq.find('.next-button').click(function() {
				var next = WikiaQuiz.cq.next();
				WikiaQuiz.cq.fadeOut(1000, function() {
					if(next && next.length > 0) {
						next.fadeIn(1000, function() {
							WikiaQuiz.initializeQuestion(next);
						});
					} else {
						var now = new Date();
						var diff = now - WikiaQuiz.startTime;
						var ts = diff / 1000;
						var s = Math.floor(ts % 60);
						ts /= 60;
						var m = Math.floor(ts % 60);
						var time = m + ':' + (s < 10 ? '0' : '') + s;
						var qr = $('.quiz-result');
						qr.find('.points div').html(WikiaQuiz.score);
						qr.find('.time div').html(time);
						qr.fadeIn(1000);
					}
				});
			});
		});
	}
	
};

$(function() {
	WikiaQuiz.init();
});