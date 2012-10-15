/* Copyright (c) 2010 Travis Kriplean (http://www.cs.washington.edu/homes/travis/)
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * DOM manipulations for the Reflect research surveys. Basically drop in 
 * a short survey when the user takes specific actions (like adding bullet).
 * 
 * See server/api/ApiReflectStudyAction for high level about research study. 
 */


/////////////////////
//enclosure
if ( typeof Reflect == 'undefined' ) {
	Reflect = {};
	// ///////////////////
}

	
function filter(a, fun){
	var len = a.length >>> 0;
	if (typeof fun != "function")
	throw new TypeError();
	
	var res = [];
	var thisp = arguments[1];
	for (var i = 0; i < len; i++) {
		if (i in a) {
		  var val = a[i]; // in case fun mutates this
		  if (fun.call(thisp, val, i, a))
		  		res.push(val);
		}
	}
 return res;
}

var $j = jQuery.noConflict();

Reflect.study = {

	load_surveys : function () {
		var bullets = [],
			user = Reflect.utils.get_logged_in_user();
		// in a but not in b
		function relative_complement ( a, b ) {
			return filter(a,function ( elem ) {
				for ( var i in b ) {
					if ( b[i] == elem ) {
						return false;
					}
				}
				return true;
			} );
		}
		$j( '.bullet' ).each( function () {
			var bullet = $j( this ).data( 'bullet' );
			if ( bullet.id
				&& (bullet.user == user || bullet.comment.user == user) ) 
			{
				bullets.push( bullet.id );
			}
		} );
		Reflect.api.server.get_survey_bullets( {
				bullets : JSON.stringify( bullets )
			}, function ( data ) {
				// for each candidate bullet NOT in data, lay down
				// appropriate survey
				var needs_surveys = relative_complement( bullets, data );
				for (var i in needs_surveys) {
					try {
				   	var bullet = $j('#bullet-' + needs_surveys[i]).data('bullet');
				   	if (bullet.comment.user == user &&
				   	bullet.responses.length > 0 &&
				   	bullet.responses[0].data('response').id) {
				   		Reflect.study.new_bullet_reaction_survey(bullet, bullet.comment, bullet.$elem);
				   	}
				   	else 
				   		if (bullet.user == user) {
				   			Reflect.study.new_bullet_survey(bullet, bullet.comment, bullet.$elem);
				   		}
				   } catch( err ) {}
				}

			} );
	},
	_bullet_survey_base : function ( comment, bullet, title, checkbox_name,
			checkboxes, survey_id, element ) 
	{
		if ( Reflect.data[comment.id][bullet.id]
                  && Reflect.data[comment.id][bullet.id].survey_responses ) {
			return;
		}

		fields = '';
		for ( var i in checkboxes) {
			var box = checkboxes[i];
			if ( box == 'other' ) {
				fields += '<input type="checkbox" name="'
						+ checkbox_name + '-' + bullet.id + '" id="other-' + bullet.id
						+ '" value="' + i
						+ '" class="other survey_check" /><label for="other-' + bullet.id
						+ '">other</label> <input type="text" class="other_text" name="other_text" /><br>';
			} else {
				fields += '<input type="checkbox" name="' + checkbox_name + '-'
						+ bullet.id + '" id="' + box + '-' + bullet.id
						+ '" value="' + i + '" class="survey_check" />'
						+ '<label for="' + box + '-' + bullet.id + '">' + box
						+ '</label><br>';
			}
		}

		// TODO: move this to html template
		var prompt = $j( ''
				+ '<div class="survey_prompt">'
				+ '	<div class="survey_intro">'
				+ '			<ul>'
				+ '				<li class="survey_label"><span>'
				+ title
				+ '</span></li>'
				+ '				<li class="cancel_survey"><button class="skip"><img title="Skip this survey" src="'
				+ Reflect.api.server.media_dir
				+ '/cancel_black.png" ></button></li>'
				+ '				<li style="clear:both"></li>'
				+ '			</ul>'
				+ '	</div>'
				+ '	<div class="survey_detail">'
				+ '	<p class="validateTips">Check all that apply. Your response will not be shown to others.</p>'
				+ '	<form>' + '	<fieldset>' + fields + '</fieldset>'
				+ '<button class="done" type="button">Done</button>'
				+ '<button class="skip" type="button">Skip</button>'
				+ '	</form>' + '	</div>' + '</div>' );

		prompt.find( '.survey_detail' ).hide();
		prompt.find( '.done' ).attr( 'disabled', true );
		prompt.find( 'input' ).click( function () {
			prompt.find( '.done' )
				.attr( 'disabled', prompt.find( 'input:checked' ).length == 0 );
		} );

		function open () {
			$j( this ).parents( '.survey_prompt' ).find( '.survey_detail' )
					.slideDown();
			$j( this ).unbind( 'click' );
			$j( this ).click( close );
		}
		function close () {
			$j( this ).parents( '.survey_prompt' ).find( '.survey_detail' )
					.slideUp();
			$j( this ).unbind( 'click' );
			$j( this ).click( open );
		}
		prompt.find( '.survey_label' ).click( open );

		prompt.find( '.done' ).click( function () {
			prompt.find( ':checkbox:checked' ).each( function () {
				var response_id = $j( this ).val();
				if ( $j( this ).attr( 'id' ) == 'other' ) {
					var text = prompt.find( 'input:text' ).val();
				} else {
					var text = '';
				}

				var params = {
					bullet_id : bullet.id,
					comment_id : comment.id,
					text : text,
					survey_id : survey_id,
					response_id : response_id,
					bullet_rev : bullet.rev
				};
				var vals = {
					params : params,
					success : function ( data ) {
					},
					error : function ( data ) {
					}
				};

				Reflect.api.server.post_survey_bullets( vals );

			} );

			prompt.fadeTo( "slow", 0.01, function () { // fade
				prompt.slideUp( "slow", function () { // slide up
					prompt.remove(); // then remove from the DOM
				} );
			} );

		} );
		prompt.find( '.skip' ).click( function () {
			var response_id = $j( this ).val();
			if ( $j( this ).attr( 'id' ) == 'other' ) {
				var text = prompt.find( 'input:text' ).val();
			} else {
				var text = '';
			}

			var params = {
				bullet_id : bullet.id,
				bullet_rev : bullet.rev,
				comment_id : comment.id,
				text : text,
				survey_id : survey_id,
				response_id : -1
			};
			var vals = {
				params : params,
				success : function ( data ) {
				},
				error : function ( data ) {
				}
			};

			Reflect.api.server.post_survey_bullets( vals );

			prompt.fadeTo( "slow", 0.01, function () { // fade
				prompt.slideUp( "slow", function () { // slide up
					prompt.remove(); // then remove from the DOM
				} );
			} );
		} );
		prompt.hide();
		element.append( prompt );
		prompt.fadeIn( 'slow' );

	},
	new_bullet_survey : function ( bullet, comment, element ) {
		var commenter = comment.user_short, 
			checkboxes = [
				'make sure other people will see the point',
				'teach ' + comment.user_short + ' something',
				'show other readers that you understand',
				'show ' + comment.user_short + ' that you understand',
				'help you understand the comment better', 'other' ], 
			title = 'Why did you add this point?', 
			checkbox_name = 'point_reaction', 
			survey_id = 1;

		Reflect.study._bullet_survey_base( 
				comment, bullet, title, checkbox_name, 
				checkboxes, survey_id, element );
	},

	new_bullet_reaction_survey : function ( bullet, comment, element ) {

		var checkboxes = [ 'I guess someone heard what I said',
				'I need to, or don\'t need to, clarify',
				'I had not thought of phrasing my point that way',
				'thanks, ' + bullet.user,
				'Other people will now find this point more easily',
				'Other people will understand my point better now', 'other' ], 
			title = 'What do you think of this summary?', 
			checkbox_name = 'adding_point', 
			survey_id = 2;

		Reflect.study._bullet_survey_base( 
				comment, bullet, title, checkbox_name, 
				checkboxes, survey_id, element );
	}
};
