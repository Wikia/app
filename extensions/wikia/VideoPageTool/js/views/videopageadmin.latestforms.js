/* global Backbone */
define( 'views.videopageadmin.latestforms', [
		'jquery'
], function( $ ) {
	'use strict';
	var FormGroupView = Backbone.View.extend({
			initialize: function() {
			},
			events: {
				'keyup input[data-autocomplete]': 'handleKeyUp'
			},
			handleKeyUp: function( evt ) {
				evt.preventDefault();
				var $tar,
						$val
						keyCode;

				$tar = $( evt.target );
				keyCode = evt.keyCode;
				$val = $tar.val();

				if ( $tar.val().length > 2 ) {
					// collection fetch
				}
			}
	});

	return FormGroupView;
});
