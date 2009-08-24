/* JavaScript Document */

/* Prototypes */

/**
 * Generic global access system
 */
function CommunityVoicePool() {

	/* Private Members */

	var self = this;
	var objects = {};

	/* Public Functions */

	/**
	 * Adds an object to pool, and returns it's unique ID
	 * @param	object	Object reference to add
	 */
	this.add = function(
		object
	) {
		if ( typeof( object.getId ) == 'function' ) {
			objects[object.getId()] = object;
			return true;
		}
		return false;
	}
	/**
	 * Removes an object form pool
	 * @param	id	ID number of object to remove
	 */
	this.remove = function(
		id
	) {
		if ( objects[id] !== undefined ) {
			delete objects[id];
			return true;
		}
		return false;
	}
	/**
	 * Gets an object from pool
	 * @param	id	ID number of object to get
	 */
	this.get = function(
		id
	) {
		if ( objects[id] !== undefined ) {
			return objects[id];
		}
		return null;
	}
}

/**
 * Ratings Scale Object
 */
function CommunityVoiceRatingsScale(
	id,
	category,
	title,
	rating,
	messages,
	article
) {
	/* Members */

	var self = this;
	// Gets object references
	var element = document.getElementById( id );
	var stars = [];
	var labels = {};
	// Sets state
	var status = 'ready';
	var locked = true;

	/* Functions */

	this.getId = function() {
		return id;
	}

	this.rate = function(
		newRating
	) {
		// Checks if a save is already taking place
		if ( locked ) {
			// Exits function immediately
			return;
		}
		// Sets message to sending
		status = 'sending';
		// Updates UI
		self.update();
		// Don't allow any more requests
		self.lock();
		// Saves current request type
		var oldRequestType = sajax_request_type;
		// Changes request type to post
		sajax_request_type = "POST";
		// Performs asynchronous save on server
		sajax_do_call(
			"CommunityVoiceRatings::handleScaleVoteCall",
			[ category, title, newRating, article ],
			new Function(
				"request",
				"communityVoice.ratings.scales." +
				"get( '" + id + "' ).respond( request )"
			)
		);
		// Restores current request type
		sajax_request_type = oldRequestType;
	}

	this.respond = function(
		request
	) {
		/*
		 * If errors are happening, this will help with debugging:
		 * alert( request.responseText );
		 */
		if ( request.responseText.substr( 0, 1 ) !== '{' ) {
			// Something VERY wrong just happened
			// Changes message to error
			status = 'error';
			// Updates UI
			self.update();
			return;
		}
		// Parse JSON response
		eval( 'var response = ' + request.responseText );
		// Checks that an error did not occur
		if ( response.rating !== undefined && response.stats !== undefined ) {
			if ( response.rating >= 0 ) {
				// Changes message to received
				status = 'thanks';
				// Uses response data
				messages.stats = response.stats;
				rating = response.rating;
			} else {
				// Alerts user of error
				status = 'error';
			}
		} else {
			// Alerts user of error
			status = 'error';
		}
		// Updates UI
		self.update();
	}

	this.lock = function() {
		locked = true;
		for ( star in stars ) {
			stars[star].style.cursor = 'default';
		}
	}

	this.unlock = function() {
		locked = false;
		for ( star in stars ) {
			stars[star].style.cursor = 'pointer';
		}
	}

	this.update = function(
		hoveredStar
	) {
		var dir = egCommunityVoiceResourcesPath + '/Icons';
		var fraction = 0;
		// Change UI accordingly
		for ( star in stars ) {
			if ( Math.floor( rating ) > star ) {
				fraction = 6;
			} else if ( Math.floor( rating ) < star ) {
				fraction = 0;
			} else {
				fraction = Math.round(
					( 6 / 10 ) * ( ( rating - Math.floor( rating ) ) * 10 )
				);
			}
			if ( hoveredStar !== undefined && hoveredStar >= star && !locked ) {
				stars[star].src = dir + '/star-' + fraction + '-hover.png'
			} else {
				stars[star].src = dir + '/star-' + fraction + '.png'
			}
		}
		labels.stats.innerHTML = messages.stats;
		labels.stats.className = 'stats';
		labels.status.innerHTML = messages.status[status];
		labels.status.className = status;
	}

	// Loops 5 times (once per star)
	for ( var i = 0; i < 5; i++ ) {
		// Creates a new image
		stars[i] = document.createElement( 'img' );
		stars[i].style.borderWidth = '0px';
		stars[i].className = 'star';
		// Adds handlers to image
		addHandler(
			stars[i],
			'click',
			new Function(
				"communityVoice.ratings.scales." +
				"get( '" + id + "' ).rate( " + ( i + 1 ) + " )"
			)
		);
		addHandler(
			stars[i],
			'mouseover',
			new Function(
				"communityVoice.ratings.scales." +
				"get( '" + id + "' ).update( " + i + " )"
			)
		);
		addHandler(
			stars[i],
			'mouseout',
			new Function(
				"communityVoice.ratings.scales." +
				"get( '" + id + "' ).update()"
			)
		);
		// Inserts image into element
		element.appendChild( stars[i] );
	}
	// Adds labels
	labels.stats = document.createElement( 'span' );
	element.appendChild( labels.stats );
	labels.status = document.createElement( 'span' );
	element.appendChild( labels.status );
	this.unlock();
	this.update();
}

/* Globals */

var communityVoice = {};
communityVoice.ratings = {};
communityVoice.ratings.scales = new CommunityVoicePool();
