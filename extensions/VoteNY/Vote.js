/**
 * JavaScript functions for Vote extension
 *
 * @file
 * @ingroup Extensions
 * @author Jack Phoenix <jack@countervandalism.net>
 * @date 4 January 2012
 */
var VoteNY = {
	MaxRating: 5,
	clearRatingTimer: null,
	voted_new: [],
	id: 0,
	last_id: 0,
	imagePath: wgScriptPath + '/extensions/VoteNY/images/',

	/**
	 * Called when voting through the green square voting box
	 *
	 * @param TheVote
	 * @param PageID Integer: internal ID number of the current article
	 */
	clickVote: function( TheVote, PageID ) {
		sajax_request_type = 'POST';
		sajax_do_call( 'wfVoteClick', [ TheVote, PageID ], function( request ) {
			document.getElementById( 'votebox' ).style.cursor = 'default';
			document.getElementById( 'PollVotes' ).innerHTML = request.responseText;
			document.getElementById( 'Answer' ).innerHTML =
				'<a href="javascript:void(0);" class="vote-unvote-link">' +
				mediaWiki.msg( 'vote-unvote-link' ) + '</a>';
		} );
	},

	/**
	 * Called when removing your vote through the green square voting box
	 *
	 * @param PageID Integer: internal ID number of the current article
	 * @param mk Mixed: random token
	 */
	unVote: function( PageID ) {
		sajax_request_type = 'POST';
		sajax_do_call( 'wfVoteDelete', [ PageID ], function( request ) {
			document.getElementById( 'votebox' ).style.cursor = 'pointer';
			document.getElementById( 'PollVotes' ).innerHTML = request.responseText;
			document.getElementById( 'Answer' ).innerHTML =
				'<a href="javascript:void(0);" class="vote-vote-link">' +
				mediaWiki.msg( 'vote-link' ) + '</a>';
		} );
	},

	/**
	 * Called when adding a vote after a user has clicked the yellow voting stars
	 *
	 * @param PageID Integer: internal ID number of the current article
	 * @param id Integer: ID of the current rating star
	 * @param action Integer: controls which AJAX function will be called
	 */
	clickVoteStars: function( TheVote, PageID, id, action ) {
		VoteNY.voted_new[id] = TheVote;
		var rsfun;
		if( action == 3 ) {
			rsfun = 'wfVoteStars';
		}
		if( action == 5 ) {
			rsfun = 'wfVoteStarsMulti';
		}

		var resultElement = document.getElementById( 'rating_' + id );
		sajax_request_type = 'POST';
		sajax_do_call( rsfun, [ TheVote, PageID ], resultElement );
	},

	/**
	 * Called when removing your vote through the yellow voting stars
	 *
	 * @param PageID Integer: internal ID number of the current article
	 * @param id Integer: ID of the current rating star
	 */
	unVoteStars: function( PageID, id ) {
		var resultElement = document.getElementById( 'rating_' + id );
		sajax_request_type = 'POST';
		sajax_do_call( 'wfVoteStarsDelete', [ PageID ], resultElement );
	},

	startClearRating: function( id, rating, voted ) {
		VoteNY.clearRatingTimer = setTimeout( function() {
			VoteNY.clearRating( id, 0, rating, voted );
		}, 200 );
	},

	clearRating: function( id, num, prev_rating, voted ) {
		if( VoteNY.voted_new[id] ) {
			voted = VoteNY.voted_new[id];
		}

		for( var x = 1; x <= VoteNY.MaxRating; x++ ) {
			var star_on, old_rating;
			if( voted ) {
				star_on = 'voted';
				old_rating = voted;
			} else {
				star_on = 'on';
				old_rating = prev_rating;
			}
			var ratingElement = document.getElementById( 'rating_' + id + '_' + x );
			if( !num && old_rating >= x ) {
				ratingElement.src = VoteNY.imagePath + 'star_' + star_on + '.gif';
			} else {
				ratingElement.src = VoteNY.imagePath + 'star_off.gif';
			}
		}
	},

	updateRating: function( id, num, prev_rating ) {
		if( VoteNY.clearRatingTimer && VoteNY.last_id == id ) {
			clearTimeout( VoteNY.clearRatingTimer );
		}
		VoteNY.clearRating( id, num, prev_rating );
		for( var x = 1; x <= num; x++ ) {
			document.getElementById( 'rating_' + id + '_' + x ).src = VoteNY.imagePath + 'star_voted.gif';
		}
		VoteNY.last_id = id;
	}
};

jQuery( document ).ready( function() {
	// Green voting box
	jQuery( '#votebox, a.vote-vote-link' ).click( function() {
		VoteNY.clickVote( 1, mw.config.get( 'wgArticleId' ) );
	} );

	jQuery( 'a.vote-unvote-link' ).click( function() {
		VoteNY.unVote( mw.config.get( 'wgArticleId' ) );
	} );

	// Rating stars
	jQuery( 'img.vote-rating-star' ).click( function() {
		var that = jQuery( this );
		VoteNY.clickVoteStars(
			that.data( 'vote-the-vote' ),
			mw.config.get( 'wgArticleId' ),
			that.data( 'vote-id' ),
			that.data( 'vote-action' )
		);
	} ).mouseover( function() {
		var that = jQuery( this );
		VoteNY.updateRating(
			that.data( 'vote-id' ),
			that.data( 'vote-the-vote' ),
			that.data( 'vote-rating' )
		);
	} ).mouseout( function() {
		var that = jQuery( this );
		VoteNY.startClearRating(
			that.data( 'vote-id' ),
			that.data( 'vote-rating' ),
			that.data( 'vote-voted' )
		);
	} );

	// Remove vote (rating stars)
	jQuery( 'a.vote-remove-stars-link' ).click( function() {
		VoteNY.unVoteStars(
			mw.config.get( 'wgArticleId' ),
			jQuery( this ).data( 'vote-id' )
		);
	} );
} );