
function imageSwap(divID, type, on, path) {
	
	if (on==1) {
		$(divID).src = path+'/common/'+type+'-on.gif';
	} else {
		$(divID).src = path+'/common/'+type+'.gif';
	}
	
	
}
