/* -- (c) Aaron Schulz 2009 */

var showResults = function(size, cidr) {
	$( '#mw-checkuser-cidr-res' ).val( cidr );
	$( '#mw-checkuser-ipnote' ).text( size );
};

/*
* This function calculates the common range of a list of
* IPs. It should be set to update on keyUp.
*/
var updateCIDRresult = function() {
	var form = document.getElementById( 'mw-checkuser-cidrform' );
	if( !form ) {
		return; // no JS form
	}
	form.style.display = 'inline'; // unhide form (JS active)
	var iplist = document.getElementById( 'mw-checkuser-iplist' );
	if( !iplist ) {
		return; // no JS form
	}
	var text = iplist.value, ips;
	// Each line should have one IP or range
	if( text.indexOf("\n") != -1 ) {
		ips = text.split("\n");
	// Try some other delimiters too...
	} else if( text.indexOf("\t") != -1 ) {
		ips = text.split("\t");
	} else if( text.indexOf(",") != -1 ) {
		ips = text.split(",");
	} else if( text.indexOf("-") != -1 ) {
		ips = text.split("-");
	} else if( text.indexOf(" ") != -1 ) {
		ips = text.split(" ");
	} else {
		ips = text.split(";");
	}
	var bin_prefix = 0;
	var prefix_cidr = 0;
	var prefix = new String( '' );
	var foundV4 = false;
	var foundV6 = false;
	var ip_count;
	// Go through each IP in the list, get its binary form, and
	// track the largest binary prefix among them...
	for( var i = 0; i < ips.length; i++ ) {
		// ...in the spirit of mediawiki.special.block.js, call this "addy"
		var addy = ips[i].replace(/^\s*|\s*$/, '' ); // trim
		// Match the first IP in each list (ignore other garbage)
		var ipV4 = mw.util.isIPv4Address( addy, true );
		var ipV6 = mw.util.isIPv6Address( addy, true );
		var ip_cidr = addy.match(/^(.*)(?:\/(\d+))?$/);
		// Binary form
		var bin = new String( '' );
		// Convert the IP to binary form: IPv4
		if( ipV4 ) {
			foundV4 = true;
			if ( foundV6 ) { // disjoint address space
				prefix = '';
				break;
			}
			var ip = ip_cidr[1];
			var cidr = ip_cidr[2] ? ip_cidr[2] : null; // CIDR, if it exists
			// Get each quad integer
			var blocs = ip.split('.');
			// IANA 1.0.0.0/8, 2.0.0.0/8
			if( blocs[0] <= 2 ) continue;
			for( var x = 0; x < blocs.length; x++ ) {
				bloc = parseInt( blocs[x], 10 );
				var bin_block = bloc.toString( 2 ); // concat bin with binary form of bloc
				while( bin_block.length < 8 ) {
					bin_block = '0' + bin_block; // pad out as needed
				}
				bin += bin_block;
			}
			prefix = ''; // Rebuild formatted bin_prefix for each IP
			// Apply any valid CIDRs
			if( cidr ) {
				bin = bin.substring( 0, cidr ); // truncate bin
			}
			// Init bin_prefix
			if( bin_prefix === 0 ) {
				bin_prefix = new String( bin );
			// Get largest common bin_prefix
			} else {
				for( var x = 0; x < bin_prefix.length; x++ ) {
					// Bin_prefix always smaller than bin unless a CIDR was used on bin
					if( bin[x] == undefined || bin_prefix[x] != bin[x] ) {
						bin_prefix = bin_prefix.substring( 0, x ); // shorten bin_prefix
						break;
					}
				}
			}
			// Build the IP in CIDR form
			prefix_cidr = bin_prefix.length;
			// CIDR too small?
			if( prefix_cidr < 16 ) {
				showResults( '!',  '>' + Math.pow( 2, 32 - prefix_cidr ) );
				return; // too big
			}
			// Build the IP in dotted-quad form
			for( var z = 0; z <= 3; z++ ) {
				var bloc = 0;
				var start = z * 8;
				var end = start + 7;
				for( var x = start; x <= end; x++ ) {
					if( bin_prefix[x] == undefined ) {
						break;
					}
					bloc += parseInt( bin_prefix[x], 10 ) * Math.pow( 2, end - x );
				}
				prefix += ( z == 3 ) ? bloc : bloc + '.';
			}
			// Get IPs affected
			ip_count = Math.pow( 2, 32 - prefix_cidr );
			// Is the CIDR meaningful?
			if( prefix_cidr == 32 ) {
				prefix_cidr = false;
			}
		// Convert the IP to binary form: IPv6
		} else if( ipV6 ) {
			foundV6 = true;
			if ( foundV4 ) { // disjoint address space
				prefix = '';
				break;
			}
			var ip = ip_cidr[1];
			var cidr = ip_cidr[2] ? ip_cidr[2] : null; // CIDR, if it exists
			// Expand out "::"s
			var abbrevs = ip.match( /::/g );
			if( abbrevs && abbrevs.length > 0 ) {
				var colons = ip.match( /:/g );
				var needed = 7 - ( colons.length - 2 ); // 2 from "::"
				var insert = '';
				while( needed > 1 ) {
					insert += ':0';
					needed--;
				}
				ip = ip.replace( '::', insert + ':' );
				// For IPs that start with "::", correct the final IP
				// so that it starts with '0' and not ':'
				if( ip[0] == ':' ) {
					ip = '0' + ip;
				}
			}
			// Get each hex octant
			var blocs = ip.split(':');
			for( var x = 0; x <= 7; x++ ) {
				bloc = blocs[x] ? blocs[x] : '0';
				var int_block = hex2int( bloc ); // convert hex -> int
				bin_block = int_block.toString( 2 ); // concat bin with binary form of bloc
				while( bin_block.length < 16 ) {
					bin_block = '0' + bin_block; // pad out as needed
				}
				bin += bin_block;
			}
			prefix = ''; // Rebuild formatted bin_prefix for each IP
			// Apply any valid CIDRs
			if( cidr ) {
				bin = bin.substring( 0, cidr ); // truncate bin
			}
			// Init bin_prefix
			if( bin_prefix === 0 ) {
				bin_prefix = new String( bin );
			// Get largest common bin_prefix
			} else {
				for( var x = 0; x < bin_prefix.length; x++ ) {
					// Bin_prefix always smaller than bin unless a CIDR was used on bin
					if( bin[x] == undefined || bin_prefix[x] != bin[x] ) {
						bin_prefix = bin_prefix.substring( 0, x ); // shorten bin_prefix
						break;
					}
				}
			}
			// Build the IP in CIDR form
			var prefix_cidr = bin_prefix.length;
			// CIDR too small?
			if( prefix_cidr < 96 ) {
				showResults('!', '>' + Math.pow( 2, 128 - prefix_cidr ) );
				return; // too big
			}
			// Build the IP in dotted-quad form
			for( var z = 0; z <= 7; z++ ) {
				var bloc = 0;
				var start = z*16;
				var end = start + 15;
				for( var x = start; x <= end; x++ ) {
					if( bin_prefix[x] == undefined ) {
						break;
					}
					bloc += parseInt( bin_prefix[x], 10 ) * Math.pow( 2, end - x );
				}
				bloc = bloc.toString( 16 ); // convert to hex
				prefix += ( z == 7 ) ? bloc : bloc + ':';
			}
			// Get IPs affected
			ip_count = Math.pow( 2, 128 - prefix_cidr );
			// Is the CIDR meaningful?
			if( prefix_cidr == 128 ) {
				prefix_cidr = false;
			}
		}
	}
	// Update form
	if( prefix != '' ) {
		var full = prefix;
		if( prefix_cidr != false ) {
			full += '/' + prefix_cidr;
		}
		showResults( '~' + ip_count, full );
	} else {
		showResults( '?', '' );
	}

};

// Utility function to convert hex to integers
var hex2int = function( hex ) {
	hex = new String( hex );
	hex = hex.toLowerCase();
	var intform = 0;
	for( var i = 0; i < hex.length; i++ ) {
		var digit = 0;
		switch( hex[i] ) {
			case 'a':
				digit = 10;
				break;
			case 'b':
				digit = 11;
				break;
			case 'c':
				digit = 12;
				break;
			case 'd':
				digit = 13;
				break;
			case 'e':
				digit = 14;
				break;
			case 'f':
				digit = 15;
				break;
			default:
				digit = parseInt( hex[i], 10 );
				break;
		}
		intform += digit * Math.pow( 16, hex.length - 1 - i );
	}
	return intform;
};

$( function() {
	updateCIDRresult();
	$('#mw-checkuser-iplist').bind('keyup click', function() {
		updateCIDRresult();
	});
});
