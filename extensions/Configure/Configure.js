/**
 * Main function
 * create JavaScript buttons to allow to modify the form to have more
 * flexibility
 */

 var allSettings = undefined;

function setupConfigure(){

	// For old versions
	if( typeof getElementsByClassName != "function" )
		return;

	// Tabs and TOC
	// ------------

	var configform = document.getElementById( 'configure' );
	if (!configform || !document.createElement) {
		return;
	}

	configform.className = configform.className + 'jsprefs';
	var sections = [];
	var children = configform.childNodes;
	var hid = 0;
	var toc = document.createElement('ul');
	toc.className = 'configtoc';
	toc.id = 'configtoc';
	toc.subLen = {};
	toc.confSec = 1;
	toc.confSub = -1;
	for( var i = 0; i < children.length; i++ ){
		if (children[i].nodeName.toLowerCase() == 'fieldset') {
			children[i].id = 'config-section-' + i;
			children[i].className = 'configsection';
			var legends = children[i].getElementsByTagName( 'legend' );
			if (legends[0] && legends[0].firstChild.nodeValue) {
				var legend = legends[0].firstChild.nodeValue;
			} else {
				var legend = '# ' + seci;
			}

			var li = document.createElement('li');
			if (i === 0) {
				li.className = 'selected';
			}

			var headers = children[i].getElementsByTagName( 'h2' );
			var tables = getElementsByClassName( children[i], 'table', 'configure-table' );

			if (headers.length > 1 && headers.length == tables.length) {
				var a = document.createElement('a');
				a.onmousedown = a.onclick = configTocToggleElement;
				a.tocId = i;
				a.collapsed = true;
				a.appendChild( document.createTextNode( '[+]' ) );
				li.appendChild(a);
			}

			var a = document.createElement('a');
			a.href = '#' + children[i].id;
			a.id = 'toc-link-'+children[i].id;
			a.onmousedown = a.onclick = configToggle;
			a.confSec = i;
			a.confSub = -1;
			if (hid != 1) {
				a.className = 'selected';
			}
			a.appendChild( document.createTextNode( legend ) );
			li.appendChild(a);

			if( headers.length == tables.length && headers.length > 1 ){
				var len = headers.length;
				toc.subLen[i] = len;
				var span = document.createElement( 'span' );
				span.className = 'config-toc-delimiter';
				li.appendChild( span );
				var ul = document.createElement( 'ul' );
				ul.style.display = "none";
				ul.id = "config-toc-" + i;

				for( var subsect = 0; subsect < len; subsect++ ){
					headers[subsect].id = 'config-head-' + i + '-' + subsect;
					tables[subsect].id = 'config-table-' + i + '-' + subsect;
					var a = document.createElement('a');
					a.href = '#' + headers[subsect].id;
					a.onmousedown = a.onclick = configToggle;
					a.confSec = i;
					a.confSub = subsect;
					a.appendChild( document.createTextNode( headers[subsect].firstChild.nodeValue ) );
					var li2 = document.createElement('li');
					li2.appendChild( a );
					ul.appendChild( li2 );
				}
				li.appendChild( ul );
			} else {
				toc.subLen[i] = 0;
			}
			toc.appendChild( li );
			if( hid == 1 ){
				children[i].style.display = 'none';
			}
			hid = 1;
		}
	}

	var toggleToc = document.createElement( 'a' );
	toggleToc.style.align = "right";
	toggleToc.onmousedown = toggleToc.onclick = configTocToggle;
	toggleToc.appendChild( getArrowImg( 'l' ) );

	var table = document.createElement( 'table' );
	var tbody = document.createElement( 'tbody' );
	var tr = document.createElement( 'tr' );
	var tdToc = document.createElement( 'td' );
	var tdForm = document.createElement( 'td' );
	tdToc.appendChild( toggleToc );
	tdToc.appendChild( toc );
	tdToc.className = 'config-col-toc';
	tdForm.appendChild( configform );
	tdForm.className = 'config-col-form';
	tr.appendChild( tdToc );
	tr.appendChild( tdForm );
	tbody.appendChild( tr );
	table.appendChild( tbody );
	document.getElementById( 'configure-form' ).appendChild( table );

	// Associative tables
	// ------------------

	var tables = getElementsByClassName( configform, 'table', 'assoc' );
	var reg = new RegExp( '(^| )disabled($| )' );
	for( var t = 0; t < tables.length ; t++ ){
		table = tables[t];
  		if( reg.test( table.className ) )
  			continue;
		// Button "remove this row"
		var trs = table.getElementsByTagName( 'tr' );
		for( var r = 0; r < trs.length; r++ ){
			tr = trs[r];
			if( r == 0 ){ // header
				var th = document.createElement( 'th' );
				th.appendChild( document.createTextNode( wgConfigureRemove ) );
				tr.appendChild( th );
			} else {
				var td = document.createElement( 'td' );
				td.className = 'button';
				var button = document.createElement( 'input' );
				button.type = 'button';
				button.value = wgConfigureRemoveRow;
				button.onclick = removeAssocCallback( table, r );
				td.appendChild( button );
				tr.appendChild( td );
			}
		}
		// Button "add a new row"
		var button = document.createElement( 'input' );
		button.type = 'button';
		button.className = 'button-add';
		button.value = wgConfigureAdd;
		button.onclick = createAssocCallback( table );
		table.parentNode.appendChild( button );
	}

	var thumbs = getElementsByClassName( configform, 'input', 'image-selector' );
	for( var t = 0; t < thumbs.length; t++ ){
		var textbox = thumbs[t];
		var conf = textbox.id.substr( 18 );
		var img = document.getElementById( 'image-url-preview-'+conf );

		addHandler( textbox, 'blur', createImageUrlCallback( textbox, img ) );
	}

	// $wgGroupPermissions and $wgAutopromote stuff, only if ajax is enabled
	// ---------------------------------------------------------------------

	if( wgConfigureUseAjax ){
		var tables = getElementsByClassName( configform, 'table', 'ajax-group' );
		for( var t = 0; t < tables.length ; t++ ){
			table = tables[t];
			// Button "remove this row"
			var trs = getElementsByClassName( table, 'tr', 'configure-maintable-row' );
			for( var r = 0; r < trs.length; r++ ){
				tr = trs[r];
				if( r == 0 ){ // header
					var th = document.createElement( 'th' );
					th.appendChild( document.createTextNode( wgConfigureRemove ) );
					tr.appendChild( th );
				} else {
					var td = document.createElement( 'td' );
					td.className = 'button';
					var button = document.createElement( 'input' );
					button.type = 'button';
					button.value = wgConfigureRemoveRow;
					button.onclick = removeAjaxGroupCallback( table, r );
					td.appendChild( button );
					tr.appendChild( td );
				}
			}
			// Button "add a new row"
			var button = document.createElement( 'input' );
			button.type = 'button';
			button.className = 'button-add';
			button.value = wgConfigureAdd;
			button.onclick = createAjaxGroupCallback( table );
			table.parentNode.appendChild( button );
		}

		document.getElementById( 'configure-form' ).onsubmit = function(){
			var tables = getElementsByClassName( configform, 'table', 'ajax-group' );
			for( var t = 0; t < tables.length ; t++ ){
				var table = tables[t];
				var id = table.id;
				var cont = '';
				var trs = getElementsByClassName( table, 'tr', 'configure-maintable-row' );
				for( var r = 1; r < trs.length; r++ ){
					var tr = trs[r];
					if( cont != '' ) cont += "\n";
					cont += tr.id;
				}
				var input = document.createElement( 'input' );
				input.type = 'hidden';
				input.name = 'wp' + id + '-vals';
				input.value = cont;
				table.parentNode.appendChild( input );
			}
		}
	}

	/** Collapsible big lists */
	var biglists = getElementsByClassName( configform, '*', 'configure-biglist' );

	for( var l = 0; l < biglists.length; l++ ) {
		var list = biglists[l];

		list.id = 'configure-biglist-content-'+l;
		list.style.display = 'none';

		var tn = document.createTextNode( wgConfigureBiglistHidden );
		var div = document.createElement( 'div' );
		var toggleLink = document.createElement( 'a' );

		toggleLink.appendChild( document.createTextNode( wgConfigureBiglistShow ) );
		toggleLink.className = 'configure-biglist-toggle-link';
		toggleLink.onclick = createToggleCallback( l );
		toggleLink.id = 'configure-biglist-link-'+l;
		toggleLink.href = 'javascript:';

		div.id = 'configure-biglist-placeholder-'+l;
		div.className = 'configure-biglist-placeholder';
		div.appendChild( tn );
		div.insertBefore( toggleLink, div.childNodes[0] );
		list.parentNode.insertBefore( div, list );

		 // Summaries
		 var summary = document.createElement( 'div' );
		 summary.id = 'configure-biglist-summary-'+l;
		 summary.className = 'configure-biglist-summary';
		 summariseSetting( list, summary );
		 list.parentNode.insertBefore( summary, list );
	}

	/** Search box initialise */
	buildSearchIndex();

	// Insert a little search form just before the configuration form
	document.getElementById( 'configure-search-form' ).style.display = 'block';
	addHandler( document.getElementById( 'configure-search-input' ), 'keyup', function() { doSearch( this.value ); } )
}

function doSearch( query ) {
	query = document.getElementById( 'configure-search-input' ).value.toLowerCase();

	var results = document.getElementById( 'configure-search-results' );

	// Empty the existing results
	while( results.firstChild ) {
		results.removeChild(results.firstChild);
	}

	if ( query == '' ) {
		return;
	}

	var isMatch = function(element) { return element.description.indexOf( query ) !== -1; }
	for( var i=0; i<allSettings.length; ++i ) {
		var data = allSettings[i];
		if ( isMatch( data ) ) {
			var a = document.createElement( 'a' );
			var li = document.createElement( 'li' );

			a.href = '#config-head-'+data.fid+'-'+data.sid;
			addHandler( a, 'click', configToggle );
			a.confSec = data.fid;
			a.confSub = data.sid;
			a.appendChild( document.createTextNode( data.displayDescription ) );
			li.appendChild( a );

			results.appendChild( li );
		}
	}
}

function buildSearchIndex() {
	allSettings = [];

	// For each section...
	var rootElement = document.getElementById( 'configure' );
	var fieldsets = rootElement.getElementsByTagName( 'fieldset' );
	for( var fid=0; fid<fieldsets.length; ++fid ) {
		// For each subsection...
		var fieldset = fieldsets[fid];
		var fieldset_title = getInnerText( fieldset.getElementsByTagName( 'legend' )[0] );
		var subsections = getElementsByClassName( fieldset, 'table', 'configure-table' );
		for( var sid=0; sid<subsections.length; ++sid ) {
			var subsection;
			if (subsections[sid].getElementsByTagName( 'tbody' ).length > 0) {
				subsection = subsections[sid].getElementsByTagName( 'tbody' )[0];
			} else {
				subsection = subsections[sid];
			}
			var heading = document.getElementById( subsection.parentNode.id.replace( 'config-table', 'config-head' ) );

			// For each setting...
			for( var i=0; i<subsection.childNodes.length;++i ) {
				var row = subsection.childNodes[i];
				if( typeof row.ELEMENT_NODE == "undefined" ){
					var wantedType = 1; // ELEMENT_NODE
				} else {
					var wantedType = row.ELEMENT_NODE;
				}
				if ( row.nodeType != wantedType || ( row.tagName != 'tr' && row.tagName != 'TR' ) ) {
					continue;
				}

				var desc_cell = getElementsByClassName( row, 'td', 'configure-left-column' )[0];
				if( typeof desc_cell == "undefined" ){
					continue;
				}

				var description;

				if ( desc_cell.getElementsByTagName( 'p' ).length ) { // Ward off comments like "This setting has been customised"
					description = getInnerText( desc_cell.getElementsByTagName( 'p' )[0] );
				} else {
					description = getInnerText( desc_cell );
				}

				allSettings.push( { 'description': description.toLowerCase(), 'fid':fid+1, 'sid':sid, 'displayDescription': description } );
			}
		}
	}
}

// Summarise the setting contained in 'div' to the summary field 'summary'.
function summariseSetting( div, summary ) {
	// Empty the existing summary
	while(summary.firstChild) {
		summary.removeChild(summary.firstChild);
	}

	// Based on class, do something.
	var elementType = ' '+div.className+' ';

	var isType = function(type) { return elementType.indexOf( ' '+type+' ' ) !== -1; }

	if ( isType('assoc') ) {
		// If it's too big to display as an associative array, it's too big to display as a summary.
	} else if ( isType( 'ns-bool' ) || isType( 'ns-simple' ) || isType( 'group-bool-element' ) || isType( 'group-array-element' ) ) {
		var labels = div.getElementsByTagName( 'label' );
		var matches = [];
		for( var i=0; i<labels.length; ++i ) {
			var label = labels[i];
			var checkbox = document.getElementById( label.htmlFor );
			var idcandidates = label.getElementsByTagName( 'tt' );
			var displayid = label.innerHTML;
			if (idcandidates.length) {
				displayid = '<tt>'+idcandidates[0].innerHTML+'</tt>'; // Ew ew ew ew ew ew
			}

			if (checkbox.checked) {
				matches.push( displayid ); // Yuck
			}
		}

		summary.innerHTML = matches.join( ', ' ); // Be aware of velociraptors.
	} else if ( isType( 'ns-array' ) || isType( 'ns-text' ) || isType( 'configure-rate-limits-action' ) ) {
		// Basic strategy: find all labels, and list the values of their corresponding inputs, if those inputs have a value
		var header_key = undefined;
		var header_value = undefined;

		var headers = div.getElementsByTagName( 'th' );
		header_key = getInnerText( headers[0] );
		header_value = getInnerText( headers[1] );

		var table = document.createElement( 'table' );
		table.className = 'assoc';
		table.appendChild( document.createElement( 'tbody' ) );
		table = table.firstChild;

		var tr = document.createElement( 'tr' );
		var key_th = document.createElement( 'th' );
		var value_th = document.createElement( 'th' );
		key_th.appendChild( document.createTextNode( header_key ) );
		value_th.appendChild( document.createTextNode( header_value ) );

		tr.appendChild( key_th );
		tr.appendChild( value_th );
		table.appendChild( tr );

		var rows = false;

		if ( isType( 'configure-rate-limits-action' ) ) {
			var allRows = div.getElementsByTagName( 'tr' );
			for( var i=0; i<allRows.length; ++i ) {
				var row = allRows[i];
				var idparts = row.id.split( '-' );
				var action = idparts[2];
				var type = idparts[3];
				var typeDesc = getInnerText( row.getElementsByTagName( 'td' )[0] );
				var periodField = document.getElementById( row.id+'-period' );
				var countField = document.getElementById( row.id+'-count' );

				if ( periodField && periodField.value>0 ) {
					rows = true;

					tr = document.createElement( 'tr' );
					var key_td = document.createElement( 'td' );
					var value_td = document.createElement( 'td' );

					// Create a cute summary.
					var summ = wgConfigureThrottleSummary;
					summ = summ.replace( '$1', countField.value );
					summ = summ.replace( '$2', periodField.value );
					key_td.appendChild( document.createTextNode( typeDesc ) );
					value_td.appendChild( document.createTextNode( summ ) );

					tr.appendChild( key_td );
					tr.appendChild( value_td );

					table.appendChild( tr );
				}
			}
		} else {
			var labels = div.getElementsByTagName( 'label' );
			for( var i=0; i<labels.length; ++i ) {
				var label = labels[i];
				var arrayfield = document.getElementById( label.htmlFor );

				if ( arrayfield && arrayfield.value ) {
					rows = true;

					tr = document.createElement( 'tr' );
					var key_td = document.createElement( 'td' );
					var value_td = document.createElement( 'td' );

					key_td.appendChild( document.createTextNode( getInnerText( label ) ) );
					value_td.appendChild( document.createTextNode( arrayfield.value ) );

					tr.appendChild( key_td );
					tr.appendChild( value_td );

					table.appendChild( tr );
				}
			}
		}

		if (!rows) {
			tr = document.createElement( 'tr' );
			var td = document.createElement( 'td' );
			td.setAttribute( 'colspan', 2 );
			td.appendChild( document.createTextNode( wgConfigureSummaryNone ) );
			tr.appendChild( td );
			table.appendChild( tr );
		}

		summary.appendChild( table );
	} else if ( isType( 'promotion-conds-element' ) ) {
	} else if ( isType( 'configure-rate-limits-action' ) ) {
	} else {
		summary.appendChild( document.createTextNode( 'Useless type:'+elementType ) );
	}
}

// Collapsible stuff
function createToggleCallback( id ){
	return function(){
		var content = document.getElementById( 'configure-biglist-content-'+id );
		var toggleLink = document.getElementById( 'configure-biglist-link-'+id );
		var div = document.getElementById( 'configure-biglist-placeholder-'+id );
		var summary = document.getElementById( 'configure-biglist-summary-'+id );
		var act;
		var newLinkText;
		var newPlaceholderText;

		if (toggleLink.firstChild.nodeValue == wgConfigureBiglistShow) {
			act = 'show';
			newLinkText = wgConfigureBiglistHide;
			content.style.display = 'block';
			summary.style.display = 'none';
			newPlaceholderText = wgConfigureBiglistShown;
		} else {
			act = 'hide';
			newLinkText = wgConfigureBiglistShow;
			content.style.display = 'none';
			summary.style.display = 'block';
			summariseSetting( content, summary );
			newPlaceholderText = wgConfigureBiglistHidden
		}

		toggleLink.removeChild( toggleLink.firstChild );
		toggleLink.appendChild( document.createTextNode( newLinkText ) );

		div.removeChild( div.childNodes[1] );
		div.appendChild( document.createTextNode( newPlaceholderText ) );
	}
}

// ------------------
// Assoc tables stuff
// ------------------

/**
 * This is actually a damn hack to break the reference to table variable when
 * used directly
 *
 * @param Dom object representing a table
 */
function createAssocCallback( table ){
	return function(){
		addAssocRow( table );
	}
}

/**
 * same as before
 *
 * @param Dom object representing a table
 */
function removeAssocCallback( table, r ){
	return function(){
		removeAssocRow( table, r );
	}
}

/**
 * Add a new row in a associative table
 *
 * @param Dom object representing a table
 */
function addAssocRow( table ){
	var r = table.getElementsByTagName( 'tr' ).length;
	var startName = 'wp' + table.id;
	var tr = document.createElement( 'tr' );

	var td1 = document.createElement( 'td' );
	var key = document.createElement( 'input' );
	key.type = 'text';
	key.name = startName + '-key-' + (r - 1);
	td1.appendChild( key );

	var td2 = document.createElement( 'td' );
	var val = document.createElement( 'input' );
	val.type = 'text';
	val.name = startName + '-val-' + (r - 1);
	td2.appendChild( val );

	var td3 = document.createElement( 'td' );
	td3.className = 'button';
	var button = document.createElement( 'input' );
	button.type = 'button';
	button.className = 'button-add';
	button.value = wgConfigureRemoveRow;
	button.onclick = removeAssocCallback( table, r );
	td3.appendChild( button );

	tr.appendChild( td1 );
	tr.appendChild( td2 );
	tr.appendChild( td3 );
	table.appendChild( tr );
}

/**
 * Remove a new row in a associative
 *
 * @param Dom object representing a table
 * @param integer
 */
function removeAssocRow( table, r ){
	var trs = table.getElementsByTagName( 'tr' );
	var tr = trs[r];
	tr.parentNode.removeChild( tr );
	fixAssocTable( table );
}

/**
 * Fix an associative table
 *
 * @param Dom object representing a table
 */
function fixAssocTable( table ){
	var startName = 'wp' + table.id;
	var trs = table.getElementsByTagName( 'tr' );
	for( var r = 1; r < trs.length; r++ ){
		var tr = trs[r];
		var inputs = tr.getElementsByTagName( 'input' );
		inputs[0].name = startName + '-key-' + (r - 1);
		inputs[1].name = startName + '-val-' + (r - 1);
		inputs[2].onclick = removeAssocCallback( table, r );
	}
}

// ----------------------
// Ajax group table stuff
// ----------------------

/**
 * This is actually a damn hack to break the reference to table variable when
 * used directly
 *
 * @param Dom object representing a table
 */
function createAjaxGroupCallback( table ){
	return function(){
		addAjaxGroupRow( table );
	}
}

/**
 * same as before
 *
 * @param Dom object representing a table
 */
function removeAjaxGroupCallback( table, r ){
	return function(){
		removeAjaxGroupRow( table, r );
	}
}

/**
 * Add a new row in a "group-bool" table
 *
 * @param Dom object representing a table
 */
function addAjaxGroupRow( table ){
	r = getElementsByClassName( table, 'tr', 'configure-maintable-row' ).length;
	startName = 'wp' + table.id;
	var groupname = prompt( wgConfigurePromptGroup );
	var tbody = table.getElementsByTagName( 'tbody' )[0];
	if( groupname == null )
		return;

	var tr = document.createElement( 'tr' );
	tr.className = 'configure-maintable-row';
	tr.id = startName + '-' + groupname;

	var td1 = document.createElement( 'td' );
	td1.appendChild( document.createTextNode( groupname ) );

	var td2 = document.createElement( 'td' );
    error = false;
	sajax_do_call( 'efConfigureAjax', [ table.id, groupname ], function( x ){
		var resp = x.responseText;
		if( resp == '<err#>' || x.status != 200 )
			error = true;
		td2.innerHTML = resp;
	} );
	if( error ){
		alert( wgConfigureGroupExists );
		return;
	}

	var td3 = document.createElement( 'td' );
	td3.className = 'button';
	var button = document.createElement( 'input' );
	button.type = 'button';
	button.className = 'button-add';
	button.value = wgConfigureRemoveRow;
	button.onclick = removeAjaxGroupCallback( table, r );
	td3.appendChild( button );

	tr.appendChild( td1 );
	tr.appendChild( td2 );
	tr.appendChild( td3 );
	tbody.appendChild( tr );
}

/**
 * Remove a new row in a "ajax-group" table
 *
 * @param Dom object representing a table
 * @param integer
 */
function removeAjaxGroupRow( table, r ){
	var trs = getElementsByClassName( table, 'tr', 'configure-maintable-row' );
	var tr = trs[r];
	var tbody = table.getElementsByTagName( 'tbody' )[0];
	tbody.removeChild( tr );
}

/**
 * Fix an "group-bool" table
 *
 * @param Dom object representing a table
 */
function fixAjaxGroupTable( table ){
	var startName = 'wp' + table.id;
	var trs = getElementsByClassName( table, 'tr', 'configure-maintable-row' );
	for( var r = 1; r < trs.length; r++ ){
		var tr = trs[r];
		var inputs = tr.getElementsByTagName( 'input' );
		inputs[inputs.length - 1].onclick = removeAjaxGroupCallback( table, r );
	}
}

// ---------
// TOC stuff
// ---------

/**
 * Helper for TOC
 */
function configToggle() {
	var oldsecid = this.parentNode.parentNode.selectedid;
	var confSec = this.confSec;
	var confSub = this.confSub;
	var toc = document.getElementById( 'configtoc' );
	var oldSec = toc.confSec;
	var oldId = 'config-section-' + oldSec;
	document.getElementById( oldId ).style.display = "none";
	document.getElementById( 'toc-link-'+oldId ).className = '';
	var newId = 'config-section-' + confSec;
	document.getElementById( newId ).style.display = "block";
	document.getElementById( 'toc-link-'+newId ).className = 'selected';

	for( var i = 0; i < toc.subLen[confSec]; i++ ){
		var headId = 'config-head-' + confSec + '-' + i;
		var tableId = 'config-table-' + confSec + '-' + i;
		var head = document.getElementById( headId );
		head.style.display = ( confSub == -1 || confSub == i ) ? "block" : "none";
		var table = document.getElementById( tableId );
		table.style.display = ( confSub == -1 || confSub == i ) ? "block" : "none";
	}
	toc.confSec = confSec;
	toc.confSub = confSub;
	return false;
}

/**
 * Toggle the TOC
 */
function configTocToggleElement(){
	var id = this.tocId;
	var tocId = "config-toc-" + id;
	var toc = document.getElementById( tocId );
	if( this.collapsed ){
		toc.style.display = "block";
		this.removeChild( this.firstChild );
		this.appendChild( document.createTextNode( '[−]' ) );
		this.collapsed = false;
	} else {
		toc.style.display = "none";
		this.removeChild( this.firstChild );
		this.appendChild( document.createTextNode( '[+]' ) );
		this.collapsed = true;
	}
}

/**
 * Toggle the entire TOC
 */
function configTocToggle(){
	var toc = document.getElementById( 'configtoc' );
	if( toc.style.display == "none" ){
		toc.parentNode.className = 'config-col-toc';
		toc.style.display = "block";
		this.removeChild( this.firstChild );
		this.appendChild( getArrowImg( 'l' ) );
	} else {
		toc.parentNode.className = 'config-col-toc-hidden';
		toc.style.display = "none";
		this.removeChild( this.firstChild );
		this.appendChild( getArrowImg( 'r' ) );
	}
}

/**
 * Handle [Get thumbnail URL] button clicks
 */
function createImageUrlCallback( textbox, img ) {
	return function() {
		sajax_do_call( 'wfAjaxGetFileUrl',
			[textbox.value],
			function(response) {
				var text = response.responseText;
				// basic error handling
				if( text.substr( 0, 9 ) == "<!DOCTYPE" ) {
					img.src = textbox.value;
				} else {
					img.src = response.responseText;
				}
			}
		);
	}
}

/**
 * Get an image object representing an arrow
 * @param dir String: arrow direction, one of the following strings:
 *            - u: up
 *            - d: down
 *            - l: left
 *            - r: right
 */
function getArrowImg( dir ){
	var img = document.createElement( 'img' );
	img.src = stylepath + "/common/images/Arr_" + dir + ".png";
	return img;
}

hookEvent( "load", setupConfigure );
