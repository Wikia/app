/* Categorize Mediawiki Extension
 *
 * @author Andreas Rindler (mediawiki at jenandi dot com) and Thomas Fauré (faure dot thomas at gmail dot com)
 * @credits Jared Milbank, Leon Weber <leon.weber@leonweber.de> & Manuel Schneider <manuel.schneider@wikimedia.ch>, Daniel Friesen http://wiki-tools.com
 * @licence GNU General Public Licence 2.0 or later
 * @description Adds input box to edit and upload page which allows users to assign categories to the article. When a user starts typing the name of a category, the extension queries the database to find categories that match the user input."
 *
*/


String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}
Array.prototype.unique = function () {
	var r = new Array();
	o:for(var i = 0, n = this.length; i < n; i++)
	{
		for(var x = 0, y = r.length; x < y; x++)
		{
			if(r[x]==this[i])
			{
				continue o;
			}
		}
		r[r.length] = this[i];
	}
	return r;
}

var csQuery = '';
addEvent(document, "mouseup",keyPressHandler);

function sendRequest(q,e) {
	if ([e.keyCode||e.which] == 27 ) {
		var resultDiv = document.getElementById('searchResults');
		resultDiv.style.visibility = 'hidden';
	        e.preventDefault? e.preventDefault() : e.returnValue = false;
	}

	// remove characters that don't work in category names
	strQuery = new String(q.value);

	//CUT OFF EXISTING, COMPLETE CATEGORIES
	if(strQuery.lastIndexOf(';')!=-1){
		var intIndex = strQuery.lastIndexOf(';', strQuery.length-1);
		strQuery = strQuery.substring(intIndex+1, strQuery.length);
	}

	strQueryR = strQuery.replace(/\>|\</g,"");
	if ( strQueryR != strQuery ) {
		strQuery = strQueryR;
		q.value = strQueryR;
	}


	if ( strQuery.toString() != csQuery.toString() ) {
		strQuery = strQuery.replace(/ /g,"_");
		csQuery = strQuery;
		$.getJSON("api.php?action=query&format=json&list=categorize&catstrquery="+strQuery,
		function(data) {
			var resultDiv = document.getElementById('searchResults');
			displayType = document.getElementById('txtCSDisplayType').name;
			resultDiv.innerHTML = '';
			resultDiv.style.display = 'block';
			if (!data) {resultDiv.style.display = 'none'; } // TODO
			else{
				resultDiv.style.visibility = 'visible';
				wideResult = false;
				$.each(data.query.categorize, function(i,item){
					if ( displayType != 'Cloud' ) {
						var result=document.createElement("p");
					}
					else {
						var result=document.createElement("span");
					}
					result.name = item.replace(/_/g," ");
					csWord = result.name;

					csHTML = '<span class="csSelect">' + csWord.substr(0, csQuery.length) + '</span>' + csWord.substr(csQuery.length) + " ";
					result.innerHTML = csHTML;
					result.onmouseover = highlight;
					result.onmouseout = unHighlight;
					result.onmousedown = selectEntry;
					result.title = 'Click here to add category to the category list!';
					result.className="cs";
					resultDiv.style.lineHeight='1';
					resultDiv.appendChild(result);
				});
			}


		});


	}
}
// WAIT FOR SERVER RESPONSE AND DISPLAY SUGGESTIONS
ajaxResponse = function handleResponse(response) {
	resultSet = response.responseText;
	var resultDiv = document.getElementById('searchResults');
	displayType = document.getElementById('txtCSDisplayType').name;
	resultDiv.innerHTML = '';
	resultDiv.style.display = 'block';
	// remove extra chars from sajax (should use delimiters to find this)
	//resultSet = resultSet.substr(10);
	if (!resultSet || resultSet == "<" ) resultDiv.style.display = 'none';
	else{
		resultDiv.style.visibility = 'visible';
		wideResult = false;
		resultSet = resultSet.split("<");
		for(var f=0; f<resultSet.length; ++f){
			if ( displayType != 'Cloud' ) {
				var result=document.createElement("p");
			}
			else {
				var result=document.createElement("span");
			}
			result.name = resultSet[f].replace(/_/g," ");
			csWord = result.name;

			csHTML = '<span class="csSelect">' + csWord.substr(0, csQuery.length) + '</span>' + csWord.substr(csQuery.length) + " ";
			result.innerHTML = csHTML;
			result.onmouseover = highlight;
			result.onmouseout = unHighlight;
			result.onmousedown = selectEntry;
			result.title = 'Click here to add category to the category list!';
			result.className="cs";
			resultDiv.style.lineHeight='1';
			resultDiv.appendChild(result);
		}
	}
}


// SELECT CATEGORY FROM SUGGEST DIV AND ADD IT TO THE INPUT BOX
function selectEntry () {
	  	var strExistingValues = document.getElementById('txtSelectedCategories2').value;
	  	if(strExistingValues.lastIndexOf(';')!=-1){
			var intIndex = strExistingValues.lastIndexOf(';');
			strExistingValues = strExistingValues.substr(0, intIndex+1);
		  	document.getElementById('txtSelectedCategories2').value = strExistingValues + this.name;
		} else {
			document.getElementById('txtSelectedCategories2').value = this.name;
		}
		document.getElementById('searchResults').style.visibility='hidden';
		document.getElementById('searchResults').innerHTML='';
	}

// HIGHLIGHT CATEGORY ON MOUSEOVER
function highlight (){
	this.className='highlight';
}

function unHighlight (){
	this.className='cs';
}

// SET CURSOR BACK TO ENF OF INPUT BOX AFTER SELECTION
var range=0
function setCursor(obj) {
	currentSelection = obj.value.length
	if(obj.createTextRange){ //IE, Opera
		if (range == 0) range = obj.createTextRange();
		range.moveEnd("character",obj.value.length);
		range.moveStart("character",currentSelection);
		setTimeout('range.select()', 10);
	} else if (obj.setSelectionRange){ //Gecko-FireFox
		obj.select();
		obj.setSelectionRange(currentSelection,obj.value.length);
	} else { //Other
	 obj.blur();
	}
}

function addEvent(el, sEvt, PFnc)
{
	if(el)
	{
		if(el.addEventListener)
			el.addEventListener(sEvt, PFnc, false);
		else
			el.attachEvent("on" + sEvt, PFnc);
	}
}

   function keyPressHandler(e) {
		var resultDiv = document.getElementById('searchResults');
		resultDiv.style.visibility = 'hidden';
	    e.preventDefault? e.preventDefault() : e.returnValue = false;
      //}
   }

$(document).ready(function() {
	$('.xlabel').click(function(){
		var xvalue = $(this).text();
		var categories = '';
		if(!$(this).hasClass('xselected'))
		{
			// var existingcategories = $('#txtSelectedCategories2').val();
			$(this).addClass('xselected');
			xSelectedLabels[xvalue]=1;
		}
		else
		{
			$(this).removeClass('xselected');
			xSelectedLabels[xvalue]=0;
		}
		for(value in xSelectedLabels)
		{
			if(xSelectedLabels[value]==1)
			categories+=value+';'
		}
		$('#txtSelectedCategories2').val(categories);
	});
});
