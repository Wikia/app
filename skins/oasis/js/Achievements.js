(function( window, $ ) {
	var AchievementsModule = {
		init: function() {
			this.page = 0;
			this.module = $( '.AchievementsModule, .WikiaLatestEarnedBadgesModule' );

			var data = this.module.find( '.data' );

			this.user = data.attr( 'data-user' );
			this.badgesCount = ~~data.attr( 'data-badges-count' );
			this.badgesPerPage = ~~data.attr( 'data-badges-per-page' );
			this.pageCount = Math.floor( this.badgesCount / this.badgesPerPage );
			this.badgesUl = this.module.find( '.badges-icons' );
			this.next = this.module.find( '.badges-next' );
			this.prev = this.module.find( '.badges-prev' );

			// this width is based on bootstrap popover max-width from popover.scss
			this.badgeDescWidth = 400;

			if ( this.next && this.prev ) {
				this.next.click( $.proxy( this.loadBadges, this ) );
				this.prev.click( $.proxy( this.loadBadges, this ) );
			}

			// Show badge description when hovering over the badge
			this.showBadgesDescription();

			// Track sponsored badges
			this.trackSponsoredBadges();

			if ( wgOasisResponsive ) {
				$( window ).on( 'resize', this.resizeBadgesDescription );
			}
		},

		prepareBadgesDescription: function( badge ) {
			var placement = 'left';
			var html = badge.prevAll( '.profile-hover' ).clone().wrap( '<div>' ).parent().html();

			if ( badge.offset().left - this.badgeDescWidth < 0 ) {
				placement = 'right';
			}

			badge.popover({
				content: html,
				placement: placement
			});
		},

		resizeBadgesDescription: function() {
			var self = this;
			self.module.find( '.badges li > img' ).each(function() {
				var badge = $( this );
				badge.popover( 'destroy' );
				self.prepareBadgesDescription( badge );
			});
		},

		showBadgesDescription: function() {
			var self = this;
			self.module.find( '.badges li > img, .badges .sponsored-link' ).add( '#LeaderboardTable .badge-icon' ).each(function() {
				var badge = $( this );
				self.prepareBadgesDescription( badge );
			});
		},

		trackSponsoredBadges: function() {
			var self = this;
			self.module.find( '.sponsored-link img' ).each(function() {
				self.trackSponsored( $( this ).parent().attr( 'data-badgetrackurl' ) );
			});
		},

		trackSponsored: function( url ) {
			var cb, i;

			if ( typeof url != 'undefined' ) {
				cb = Math.floor( Math.random() * 1000000 );
				url = url.replace( '[timestamp]', cb );
				i = new Image( 1, 1 );

				i.src = url;
			}
		},

		loadBadges: function( event ) {
			var element = event.currentTarget,
				self = this;

			self.badgesUl.startThrobbing();
			self.page = ( element.getAttribute( 'class' ) == 'badges-prev' ) ? self.page - 1 : self.page + 1;

			$.nirvana.sendRequest({
				controller: 'Achievements',
				method: 'Badges',
				format: 'html',
				type: 'GET',
				data: {
					user: self.user,
					page: self.page
				},
				callback: function( html ) {
					self.badgesUl.html( html );
					self.showBadgesDescription();
					self.trackSponsoredBadges();

					if ( self.page >= self.pageCount ) {
						self.prev.show();
						self.next.hide();
					} else if ( self.page <= 0 ) {
						self.next.show();
						self.prev.hide();
					} else {
						self.next.show();
						self.prev.show();
					}

					self.badgesUl.stopThrobbing();
				}
			});
		}
	};

	$(function() {
		AchievementsModule.init();
	});
})( this, jQuery );
