//for the Special:SortPermissions page

//Adds a new column (sort type) to the table
function addColumn() {
	var table = document.getElementById('sorttable');
	var ste = document.getElementById('sorttypes');
	var colname = document.getElementById('wpNewType').value;
	if(!colname || colname == '') return;
	var rows = table.getElementsByTagName('tr');
	var dupcheck = getElementsByClassName(document, 'input', 'type-'+colname);
	if(dupcheck.length > 0) return;
	types[numtypes] = colname;
	numtypes++;
	for(var i=0;i<rows.length;i++) {
		var td = document.createElement('td');
		var btn = document.createElement('input');
		var rowname = rows[i].id;
		btn.type = 'radio';
		btn.name = rowname;
		btn.id = rowname + '-' + colname;
		btn.value = colname;
		btn.className = 'type-' + colname;
		var lbl = document.createElement('label');
		lbl.htmlFor = rowname + '-' + colname;
		var text = document.createTextNode(colname);
		lbl.appendChild(text);
		td.appendChild(btn);
		td.appendChild(lbl);
		rows[i].appendChild(td);
	}
	ste.value = ste.value + '|' + colname;
}

//Adds a new row (permission) to the table
function addRow() {
	var table = document.getElementById('sorttable');
	var rowname = document.getElementById('wpNewPerm').value;
	if(!rowname || rowname == '') return;
	var dupcheck = document.getElementById('right-' + rowname);
	if(dupcheck) return;
	var tr = document.createElement('tr');
	tr.id = 'right-'+rowname;
	var td = [];
	td[0] = document.createElement('td');
	var text = document.createTextNode(rowname+' (');
	var link = document.createElement('a');
	link.href = "javascript:removePerm('"+rowname+"');";
	var linktext = document.createTextNode(remove);
	link.appendChild(linktext);
	var ta = document.createTextNode(')');
	td[0].appendChild(text);
	td[0].appendChild(link);
	td[0].appendChild(ta);
	tr.appendChild(td[0]);
	for(var i=1;i<=numtypes;i++) {
		td[i] = document.createElement('td');
		var btn = document.createElement('input');
		btn.type = 'radio';
		btn.name = 'right-' + rowname;
		btn.id = rowname + '-' + types[i-1];
		btn.value = types[i-1];
		var lbl = document.createElement('label');
		lbl.htmlFor = rowname + '-' + types[i-1];
		var text = document.createTextNode(types[i-1]);
		lbl.appendChild(text);
		td[i].appendChild(btn);
		td[i].appendChild(lbl);
		tr.appendChild(td[i]);
	}
	table.appendChild(tr);
}

//removes a row (permission) from the table
function removePerm(perm) {
	var tr = document.getElementById('right-'+perm);
	if(!tr) return;
	var table = tr.parentNode;
	table.removeChild(tr);
}

//deletes a sort type
function delType() {
	var table = document.getElementById('sorttable');
	var ste = document.getElementById('sorttypes');
	var colname = document.getElementById('wpDelType').value;
	if(!colname || colname == '') return;
	var rows = table.getElementsByTagName('tr');
	var found = false;
	for(var i=0;i<rows.length;i++) {
		var cells = rows[i].getElementsByTagName('td');
		for(var j=0;j<cells.length;j++) {
			var input = cells[j].getElementsByTagName('input')[0];
			if(!input) continue;
			if(input.value == colname) {
				rows[i].removeChild(cells[j]);
				found = true;
				break;
			}
		}
	}
	if(!found) return;
	for(var i=0;i<types.length;i++) {
		if(types[i] == colname) {
			types.splice(i, 1);
			break;
		}
	}
	numtypes--;
	var ts = ste.value.split('|');
	for(var i=0;i<ts.length;i++) {
		if(ts[i] == colname) {
			ts.splice(i,1);
			break;
		}
	}
	ste.value = ts.join('|');
}