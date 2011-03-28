var WikiaTrivia = {
	sets: false,
	state: {},
	init: function() {
		$('.choices li').click(WikiaTrivia.handleAnswerClick);
	},
	handleAnswerClick: function(evt) {
		evt.preventDefault();
		var q = $(this).closest('.question-ui');
		q.fadeOut(400, function() {
			q.next('.answer-ui').fadeIn(400);
		});
	}
};

$(function() {
	WikiaTrivia.init();
});