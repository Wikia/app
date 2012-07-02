// http://www.intridea.com/2007/12/16/faking-onpaste-in-firefox

window.onload = populateRefName;

function populateRefName() {
	inpYear		= document.getElementById("inp_year");
	inpRefName = document.getElementById("inp_refname");
	var inpSurname = new Array();
	var i = 1;
	for( ; i <= 5; i++ ) {
		var str = "inp_surname"+i;
		inpSurname[i] = document.getElementById(str);
		if( inpSurname[i].value.length == 0 ) break;
	}
	var numAuthors = i-1;

	inpRefName.value = "";
	for( i=1; i <= 2; i++ ) {
		inpRefName.value += trim(inpSurname[i].value) + " ";
	}
	inpRefName.value += inpYear.value;
}

function wasPasted( e ) {
	var ret =(e.previousValue && e.value.length > e.previousValue.length + 1) ||
				(!e.previousValue && e.value.length > 1) ;

	e.previousValue = e.value;
	return ret;
}


function autoPopulateRefFields() {
	inpPasteArea	= document.getElementById("inp_pastearea");

	if( !wasPasted(inpPasteArea) ) return;

	inpPages			= document.getElementById("inp_pages");
	inpYear				= document.getElementById("inp_year");
	inpTitle			= document.getElementById("inp_articletitle");

	var str = inpPasteArea.value;
	//alert( "Autopopulate called! "+str );

	// find the page numbers
	var match = /([0-9]+)\s*[-–]\s*([0-9]+)/.exec( str );
	var pages_index = match.index;
	var firstpage = ""+match[1];
	var lastpage = ""+match[2];
	if( firstpage.length > lastpage.length ) {
		lastpage = 
			firstpage.substring(0, firstpage.length-lastpage.length)
			+ lastpage;
	}
	inpPages.value = firstpage + "-" + lastpage;

	// find the year
	match = /[^0-9](19[0-9]{2}|20[0-9]{2})[^0-9]/.exec( str );
	var year_index = match.index;
	inpYear.value = match[1];

	// find the title
	re = /[-\w\s:]{15,}\./
	match = re.exec(str);
	var title_index = match.index;
	inpTitle.value = trim(match[0]);
	
	// update the reference name
	populateRefName();
}
function setAuthorName( authorNum, second, first ) {
	var firstElem = document.getElementById("inp_author" + authorNum);
	var lastElem = document.getElementById("inp_surname" + authorNum);

	if( firstElem.value.length == 0 || lastElem.value.length == 0 ) {	
		firstElem.value = first;
		lastElem.value  = second;
	}
}

function updateFirstName( evnt ) {
	var e = evnt.target;

	if( !wasPasted(e) ) return;

	var match = /^inp_author([0-9]+)$/.exec( e.id );
	var authorNum = match[1];

	re = /^\s*([^,]+)\s*,\s*([^,]+)\s*$/
	if( re.test(e.value) ) {
		match = re.exec(e.value);
		setAuthorName( authorNum, match[1], match[2] );
		return;
	}

	re = /^\s*([a-zA-Z]{2,})[\s]*[,]?[\s]*((?:[\s.]+[A-Z]{1,2})+[.]?)$/
	if( re.test(e.value) ) {
		match = re.exec(e.value);
		setAuthorName( authorNum, match[1], match.slice(2) );
		return;
	}
}
function updateSurname( evnt ) {
	populateRefName();
}
