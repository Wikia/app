// Port of getTarget and resolveTextNode function (altogether) from YUI Event lib
// @author: Inez
// TODO: Move it to some more general place because it is not realted only to tracking
function getTarget(ev) {
	var t = ev.target || ev.srcElement;
	if(t && 3 == t.nodeType) {
		t = t.parentNode;
	}
	return t;
}

$(document).click(function(e){
//	var target = getTarget(e);
//	console.log(target.id);
});

// macbre: temporary fix
var WET = {
	byStr: function(str) {
		$().log(str, 'tracker');
	},
	byId: function(str) {
		$().log(str, 'tracker');
	}
};
