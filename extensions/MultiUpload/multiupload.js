/**
 * JavaScript helper function for MultiUpload extension
 */
function fillDestFilenameMulti( i ) {
	if( !document.getElementById )
		return;
	var path = document.getElementById('wpUploadFile_' + i).value;
	// Find trailing part
	var slash = path.lastIndexOf('/');
	var backslash = path.lastIndexOf('\\');
	var fname;
	if( slash == -1 && backslash == -1 ) {
		fname = path;
	} else if( slash > backslash ) {
		fname = path.substring(slash+1, 10000);
	} else {
		fname = path.substring(backslash+1, 10000);
	}

	// Capitalise first letter and replace spaces by underscores
	fname = fname.charAt(0).toUpperCase().concat(fname.substring(1,10000)).replace(/ /g, '_');

	// Output result
	var destFile = document.getElementById('wpDestFile_' + i);
	if( destFile )
		destFile.value = fname;
}