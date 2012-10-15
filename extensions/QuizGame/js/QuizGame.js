/**
 * Main JavaScript file for the QuizGame extension
 * Stuff from renderwelcomepage.js is prefixed with welcomePage_, i.e.
 * welcomePage_uploadError (otherwise we'd get conflicting method names).
 *
 * @file
 * @ingroup Extensions
 * @author Jack Phoenix <jack@countervandalism.net>
 * @date 28 June 2011
 */
var QuizGame = {
	continue_timer: '', // has to have an initial value...
	voted: 0,
	// time() JS function from http://phpjs.org/functions/time:562
	// This used to use the __quiz_time__ variable in the past
	current_timestamp: Math.floor( new Date().getTime() / 1000 ),
	current_level: 0,
	levels_array: [30, 19, 9, 0],
	points_array: [30, 20, 10, 0],
	timer: 30,
	count_second: '', // has to have an initial value...
	points: __quiz_js_points_value__,// 30,
	next_level: 0, // has to have an initial value; introduced by Jack

	deleteById: function( id, key ) {
		document.getElementById( 'items[' + id + ']' ).style.display = 'none';
		document.getElementById( 'items[' + id + ']' ).style.visibility = 'hidden';

		sajax_request_type = 'POST';
		sajax_do_call(
			'wfQuestionGameAdmin',
			[ 'deleteItem', key, id ],
			document.getElementById( 'ajax-messages' )
		);
	},

	unflagById: function( id, key ) {
		document.getElementById( 'items[' + id + ']' ).style.display = 'none';
		document.getElementById( 'items[' + id + ']' ).style.visibility = 'hidden';

		sajax_request_type = 'POST';
		sajax_do_call(
			'wfQuestionGameAdmin',
			[ 'unflagItem', key, id ],
			document.getElementById( 'ajax-messages' )
		);
	},

	unprotectById: function( id, key ) {
		document.getElementById( 'items[' + id + ']' ).style.display = 'none';
		document.getElementById( 'items[' + id + ']' ).style.visibility = 'hidden';

		sajax_request_type = 'POST';
		sajax_do_call(
			'wfQuestionGameAdmin',
			[ 'unprotectItem', key, id ],
			document.getElementById( 'ajax-messages' )
		);
	},

	protectById: function( id, key ) {
		sajax_request_type = 'POST';
		sajax_do_call(
			'wfQuestionGameAdmin',
			[ 'protectItem', key, id ],
			document.getElementById( 'ajax-messages' )
		);
	},

	/* this is from edititem.js */
	toggleCheck: function( thisBox ) {
		for( var x = 1; x <= ( __choices_count__ ); x++ ) {
			document.getElementById( 'quizgame-isright-' + x ).checked = false;
		}
		thisBox.checked = true;
	},

	uploadError: function( message ) {
		document.getElementById( 'ajax-messages' ).innerHTML = message;
		document.getElementById( 'quizgame-picture' ).innerHTML = '';

		document.getElementById( 'imageUpload-frame' ).src =
			'index.php?title=Special:QuestionGameUpload&wpThumbWidth=80&wpCategory=Quizgames&wpOverwriteFile=true&wpDestFile=' +
			document.getElementById( 'quizGamePicture' ).value;
		document.getElementById( 'quizgame-upload' ).style.display = 'block';
		document.getElementById( 'quizgame-upload' ).style.visibility = 'visible';
	},

	completeImageUpload: function() {
		document.getElementById( 'quizgame-upload' ).style.display = 'none';
		document.getElementById( 'quizgame-upload' ).style.visibility = 'hidden';
		document.getElementById( 'quizgame-picture' ).innerHTML =
			'<img src="' + wgServer + wgScriptPath +
			'/extensions/QuizGame/images/ajax-loader-white.gif" alt="" />';
	},

	uploadComplete: function( imgSrc, imgName, imgDesc ) {
		document.getElementById( 'quizgame-picture' ).innerHTML = imgSrc;

		document.getElementById( 'quizgame-picture' ).firstChild.src =
			document.getElementById( 'quizgame-picture' ).firstChild.src +
			'?' + Math.floor( Math.random() * 100 );

		document.quizGameEditForm.quizGamePicture.value = imgName;

		document.getElementById( 'imageUpload-frame' ).src =
			'index.php?title=Special:QuestionGameUpload&wpThumbWidth=80&wpCategory=Quizgames&wpOverwriteFile=true&wpDestFile=' +
			imgName;

		document.getElementById( 'quizgame-editpicture-link' ).innerHTML =
			'<a href="javascript:QuizGame.showUpload()">Edit Picture</a>';
		document.getElementById( 'quizgame-editpicture-link' ).style.display = 'block';
		document.getElementById( 'quizgame-editpicture-link' ).style.visibility = 'visible';
	},

	showUpload: function() {
		document.getElementById( 'quizgame-editpicture-link' ).style.display = 'none';
		document.getElementById( 'quizgame-editpicture-link' ).style.visibility = 'hidden';
		document.getElementById( 'quizgame-upload' ).style.display = 'block';
		document.getElementById( 'quizgame-upload' ).style.visibility = 'visible';
	},

	detectMacXFF: function() {
		var userAgent = navigator.userAgent.toLowerCase();
		if( userAgent.indexOf( 'mac' ) != -1 && userAgent.indexOf( 'firefox' ) != -1 ) {
			return true;
		}
	},

	deleteQuestion: function() {
		var gameKey = document.getElementById( 'quizGameKey' ).value;
		var gameId = document.getElementById( 'quizGameId' ).value;
		sajax_request_type = 'POST';
		sajax_do_call(
			'wfQuestionGameAdmin',
			[ 'deleteItem', gameKey, gameId ],
			function( t ) {
				document.getElementById( 'ajax-messages' ).innerHTML =
					t.responseText + '<br />' + __quiz_js_reloading__;
				document.location = wgScriptPath +
					'/index.php?title=Special:QuizGameHome&questionGameAction=launchGame';
			}
		);
	},

	showEditMenu: function() {
		document.location = wgServer + wgScriptPath + '/index.php?title=Special:QuizGameHome&questionGameAction=editItem&quizGameId=' +
			document.getElementById( 'quizGameId' ).value + '&quizGameKey=' +
			document.getElementById( 'quizGameKey' ).value;
	},

	flagQuestion: function() {
		document.getElementById( 'flag-comment' ).style.display = 'block';
		document.getElementById( 'flag-comment' ).style.visibility = 'visible';
	},

	doFlagQuestion: function() {
		var gameKey = document.getElementById( 'quizGameKey' ).value;
		var gameId = document.getElementById( 'quizGameId' ).value;
		var reason = document.getElementById( 'flag-reason' ).value;
		sajax_request_type = 'POST';
		sajax_do_call(
			'wfQuestionGameAdmin',
			[ 'flagItem', gameKey, gameId, reason ],
			function( t ) {
				document.getElementById( 'ajax-messages' ).innerHTML = t.responseText;
				document.getElementById( 'flag-comment' ).style.display = 'none';
				document.getElementById( 'flag-comment' ).style.visibility = 'hidden';
			}
		);
	},

	protectImage: function() {
		var gameKey = document.getElementById( 'quizGameKey' ).value;
		var gameId = document.getElementById( 'quizGameId' ).value;
		sajax_request_type = 'POST';
		sajax_do_call(
			'wfQuestionGameAdmin',
			[ 'protectItem', gameKey, gameId ],
			function( t ) {
				document.getElementById( 'ajax-messages' ).innerHTML = t.responseText;
			}
		);
	},

	/**
	 * @see QuizGameHome::launchGame
	 */
	showAnswers: function() {
		document.getElementById( 'loading-answers' ).style.display = 'none';
		document.getElementById( 'loading-answers' ).style.visibility = 'hidden';
		document.getElementById( 'quizgame-answers' ).style.display = 'block';
		document.getElementById( 'quizgame-answers' ).style.visibility = 'visible';
	},

	countDown: function( time_viewed ) {
		if( time_viewed ) {
			QuizGame.adjustTimer( time_viewed );
		}
		QuizGame.setLevel();

		if( ( QuizGame.timer - QuizGame.next_level ) == 3 ) {
			/* @todo FIXME: get rid of YUI and use jQuery instead
			var options = {
				ease: YAHOO.util.Easing.easeOut,
				seconds: .5,
				maxcount: 4
			};
			new YAHOO.widget.Effects.Pulse( 'quiz-points', options );
			*/
		}

		document.getElementById( 'time-countdown' ).innerHTML = QuizGame.timer;
		QuizGame.timer--;
		if( QuizGame.timer == -1 ) {
			document.getElementById( 'quiz-notime' ).innerHTML = __quiz_js_timesup__;
			if( QuizGame.count_second ) {
				clearTimeout( QuizGame.count_second );
			}
		} else {
			QuizGame.count_second = setTimeout( 'QuizGame.countDown(0)', 1000 );
		}
	},

	setLevel: function() {
		for( var x = 0; x <= QuizGame.levels_array.length - 1; x++ ) {
			if(
				( QuizGame.timer === 0 && x == QuizGame.levels_array.length - 1 ) ||
				( QuizGame.timer <= QuizGame.levels_array[x] && QuizGame.timer > QuizGame.levels_array[x +1] )
			)
			{
				//document.getElementById( 'quiz-level-' + ( x ) ).className = 'quiz-level-on';
				QuizGame.points = QuizGame.points_array[x];
				document.getElementById( 'quiz-points' ).innerHTML =
					QuizGame.points + ' ' + __quiz_js_points__;
				QuizGame.next_level = ( ( QuizGame.levels_array[x + 1] ) ? QuizGame.levels_array[x + 1] : 0 );
			} else {
				//document.getElementById( 'quiz-level-' + ( x ) ).className = 'quiz-level-off';
			}
		}
	},

	adjustTimer: function( timeViewed ) {
		var timeDiff = QuizGame.current_timestamp - timeViewed;
		if( timeDiff > 30 ) {
			QuizGame.timer = 0;
		} else {
			QuizGame.timer = 31 - timeDiff; // give them extra second for page load
		}
		if( QuizGame.timer > 30 ) {
			QuizGame.timer = 30;
		}
	},

	/**
	 * Go to a quiz when we know its ID (which is used in the permalink)
	 * @param id Integer: quiz ID number
	 */
	goToQuiz: function( id ) {
		window.location = wgServer + wgScriptPath +
			'/index.php?title=Special:QuizGameHome&questionGameAction=launchGame&permalinkID=' + id;
	},

	goToNextQuiz: function() {
		window.location = wgServer + wgScriptPath +
			'/index.php?title=Special:QuizGameHome&questionGameAction=launchGame&lastid=' +
			document.getElementById( 'quizGameId' ).value;
	},

	pauseQuiz: function() {
		if( document.getElementById( 'lightbox-loader' ) ) {
			document.getElementById( 'lightbox-loader' ).innerHTML = '';
		}
		if( QuizGame.continue_timer ) {
			clearTimeout( QuizGame.continue_timer );
		}
		document.getElementById( 'quiz-controls' ).innerHTML =
			'<a href="javascript:QuizGame.goToNextQuiz();" class="stop-button">' +
			__quiz_pause_continue__ + '</a> - <a href="' + wgScriptPath + '/index.php?title=Special:QuizLeaderboard" class="stop-button">' +
			__quiz_pause_view_leaderboard__ + '</a> - <a href="' + wgScriptPath + '/index.php?title=Special:QuizGameHome&questionGameAction=createForm" class="stop-button">' +
			__quiz_pause_create_question__ + '</a><br /><br /><a href="' +
			wgServer + wgScriptPath + '" class="stop-button">' + __quiz_main_page_button__ +
			'</a>';
	},

	getLoader: function() {
		var loader = '';
		loader += '<div id="lightbox-loader"><embed src="' + wgScriptPath +
			'/extensions/QuizGame/ajax-loading.swf" quality="high" wmode="transparent" bgcolor="#ffffff"' +
			'pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"' +
			'type="application/x-shockwave-flash" width="100" height="100"></embed></div>';
		return loader;
	},

	setLightboxText: function( txt ) {
		var textForLightBox = '';
		if( txt ) {
			textForLightBox = '<br /><br />' + txt;
		}
		if( !QuizGame.detectMacXFF() ) {
			LightBox.setText( QuizGame.getLoader() + textForLightBox );
		} else {
			LightBox.setText( __quiz_js_loading__ + textForLightBox );
		}
	},

	skipQuestion: function() {
		var objLink = {};

		objLink.href = '';
		objLink.title =  __quiz_js_loading__;

		LightBox.show( objLink );

		QuizGame.setLightboxText( '' );

		var gameKey = document.getElementById( 'quizGameKey' ).value;
		var gameId = document.getElementById( 'quizGameId' ).value;
		sajax_request_type = 'POST';
		sajax_do_call( 'wfQuestionGameVote', [ -1, gameKey, gameId, 0 ], function( t ) {
			QuizGame.goToNextQuiz( document.getElementById( 'quizGameId' ).value );
		});
	},

	// Casts a vote and forwards the user to a new question
	vote: function( id ) {
		if( QuizGame.count_second ) {
			clearTimeout( QuizGame.count_second );
		}

		if( QuizGame.voted == 1 ) {
			return 0;
		}

		QuizGame.voted = 1;

		document.getElementById( 'ajax-messages' ).innerHTML = '';

		var objLink = {};

		objLink.href = '';
		objLink.title = '';

		LightBox.show( objLink );

		var quiz_controls = '<div id="quiz-controls"><a href="javascript:void(0)" onclick="QuizGame.pauseQuiz()" class="stop-button">' +
			__quiz_lightbox_pause_quiz__ + '</a></div>';

		var view_results_button = '<a href="javascript:QuizGame.goToQuiz(' +
			document.getElementById( 'quizGameId' ).value +
			');" class="stop-button">' + __quiz_lightbox_breakdown__ + '</a>';

		var gameKey = document.getElementById( 'quizGameKey' ).value;
		var gameId = document.getElementById( 'quizGameId' ).value;
		sajax_request_type = 'POST';
		sajax_do_call( 'wfQuestionGameVote', [ id, gameKey, gameId, QuizGame.points ], function( t ) {
			var payload = eval( '(' + t.responseText + ')' );
			QuizGame.continue_timer = setTimeout( 'QuizGame.goToNextQuiz()', 3000 );
			//window.location = 'index.php?title=Special:QuizGameHome&questionGameAction=launchGame&lastid=' + document.getElementById( 'quizGameId' ).value;
			var percent_right = payload.percentRight + __quiz_lightbox_breakdown_percent__;
			if( payload.isRight == 'true' ) {
				QuizGame.setLightboxText(
					'<p class="quizgame-lightbox-righttext">' +
					__quiz_lightbox_correct__ + '<br /><br />' +
					__quiz_lightbox_correct_points__ + ' ' + QuizGame.points + ' ' +
					__quiz_js_points__ + '</p><br />' + percent_right +
					'<br /><br />' + view_results_button + '<br /><br />' +
					quiz_controls
				);
			} else {
				QuizGame.setLightboxText(
					'<p class="quizgame-lightbox-wrongtext">' +
					__quiz_lightbox_incorrect__ + '<br />' +
					__quiz_lightbox_incorrect_correct__ + ' ' +
					payload.rightAnswer + '</p><br />' + percent_right +
					'<br /><br />' + view_results_button + '<br /><br />' +
					quiz_controls
				);
			}
		});
	},

	welcomePage_uploadError: function( message ) {
		document.getElementById( 'imageUpload-frame' ).src =
			'index.php?title=Special:QuestionGameUpload&wpThumbWidth=75&wpCategory=Quizgames';
		var uploadElement = document.getElementById( 'quizgame-picture-upload' );
		if ( uploadElement ) {
			uploadElement.style.display = 'block';
			uploadElement.style.visibility = 'visible';
		}
	},

	welcomePage_completeImageUpload: function() {
		var uploadElement = document.getElementById( 'quizgame-picture-upload' );
		if ( uploadElement ) {
			uploadElement.style.display = 'none';
			uploadElement.style.visibility = 'hidden';
		}
		var preview = document.getElementById( 'quizgame-picture-preview' );
		if ( preview ) {
			preview.innerHTML = '<img src="' + wgScriptPath +
				'/extensions/QuizGame/images/ajax-loader-white.gif" alt="" />';
		}
	},

	welcomePage_uploadComplete: function( imgSrc, imgName, imgDesc ) {
		var previewElement = document.getElementById( 'quizgame-picture-preview' );
		if ( previewElement ) {
			previewElement.innerHTML = imgSrc;
		}
		// This line sets the value of the hidden "quizGamePictureName" field
		document.quizGameCreate.quizGamePictureName.value = imgName;
		document.getElementById( 'imageUpload-frame' ).src =
			'index.php?title=Special:QuestionGameUpload&wpThumbWidth=75&wpCategory=Quizgames';
		document.getElementById( 'quizgame-picture-reupload' ).style.display = 'block';
		document.getElementById( 'quizgame-picture-reupload' ).style.visibility = 'visible';
	},

	updateAnswerBoxes: function() {
		for( var x = 1; x <= ( __quiz_max_answers__ - 1 ); x++ ) {
			if( document.getElementById( 'quizgame-answer-' + x ).value ) {
				document.getElementById( 'quizgame-answer-container-' + ( x + 1 ) ).style.display = 'block';
				document.getElementById( 'quizgame-answer-container-' + ( x + 1 ) ).style.visibility = 'visible';
			}
		}
	},

	welcomePage_toggleCheck: function( thisBox ) {
		for( var x = 1; x <= ( __quiz_max_answers__ - 1 ); x++ ) {
			document.getElementById( 'quizgame-isright-' + x ).checked = false;
		}
		thisBox.checked = true;
	},

	startGame: function() {
		var errorText = '';

		var answers = 0;
		for( var x = 1; x <= __quiz_max_answers__; x++ ) {
			if( document.getElementById( 'quizgame-answer-' + x ).value ) {
				answers++;
			}
		}

		if( answers < 2 ) {
			errorText += __quiz_create_error_numanswers__ + '<p>';
		}
		if( !document.getElementById( 'quizgame-question' ).value ) {
			errorText += __quiz_create_error_noquestion__ + '<p>';
		}

		var right = 0;
		for( x = 1; x <= __quiz_max_answers__; x++ ) {
			if( document.getElementById( 'quizgame-isright-' + x ).checked ) {
				right++;
			}
		}

		if( right != 1 ) {
			errorText += __quiz_create_error_numcorrect__ + '<p>';
		}

		if( !errorText ) {
			document.getElementById( 'quizGameCreate' ).submit();
		} else {
			document.getElementById( 'quiz-game-errors' ).innerHTML = '<h2>' + errorText + '</h2>';
		}
	},

	showAttachPicture: function() {
		document.getElementById( 'quizgame-picture-preview' ).style.display = 'none';
		document.getElementById( 'quizgame-picture-preview' ).style.visibility = 'hidden';
		document.getElementById( 'quizgame-picture-reupload' ).style.display = 'none';
		document.getElementById( 'quizgame-picture-reupload' ).style.visibility = 'hidden';
		document.getElementById( 'quizgame-picture-upload' ).style.display = 'block';
		document.getElementById( 'quizgame-picture-upload' ).style.visibility = 'visible';
	},

	doHover: function( divID ) {
		document.getElementById( divID ).style.backgroundColor = '#FFFCA9';
	},

	endHover: function( divID ) {
		document.getElementById( divID ).style.backgroundColor = '';
	}
};