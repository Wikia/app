
var WikiStickies = {
	clickMoreNewpages: function( ev ) {
		if( ev ) {
			ev.preventDefault();
		}

			var params = [
                        'format=json',
                        'action=query', 
			'list=recentchanges',
			'rcprop=title',
			'rcnamespace=0',
			'rctype=new',
			'rclimit=50',
                	]; 
			
		$.getJSON( wgServer + '/api.php?' + params.join('&'), function( response ) {
						


		} );
	},
	clickMoreWantedpages: function( ev ) {
		if( ev ) {
			ev.preventDefault();
		}

			var params = [
                        'format=json',
                        'action=query', 
			'list=wantedpages',
			'wnoffset=3',
			'wnlimit=50',
                	]; 
			
		$.getJSON( wgServer + '/api.php?' + params.join('&'), function( response ) {
						


		} );
	},
	clickMoreWantedimages: function( ev ) {
		if( ev ) {
			ev.preventDefault();
		}

			var params = [
                        'format=json',
                        'action=query', 
			'list=wantedimages',
			'wnoffset=3',
			'wnlimit=50',
                	]; 
			
		$.getJSON( wgServer + '/api.php?' + params.join('&'), function( response ) {
						


		} );
	},

};


