<!--

/*
Takin from the MediaWiki /common/wikibits.js file and edited slightly.
*/

function fillDestFilename(IDis) {
	
	if (!document.getElementById) return;
	var path = document.getElementById('file_'+IDis).value;
	
	// Find trailing part
	var slash = path.lastIndexOf( '/' );
	var backslash = path.lastIndexOf( '\\' );
	var fname;
	if ( slash == -1 && backslash == -1 ) {
		fname = path;
	} else if ( slash > backslash ) {
		fname = path.substring( slash+1, 10000 );
	} else {
		fname = path.substring( backslash+1, 10000 );
	}
	
	// Capitalise first letter and replace spaces by underscores
	fname = fname.charAt(0).toUpperCase().concat(fname.substring(1,10000)).replace( / /g, '_' );
	
	// Output result
	var destFile = document.getElementById('filename_'+IDis);
	if (destFile) destFile.value = fname;
}


// -->
