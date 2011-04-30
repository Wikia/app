$(
function()
{
    $("#postTitle").keydown(function (e) {
    	if(e.keyCode == 9){
    		if (typeof FCK != "undefined" ) {
    			FCK.Focus();
    			return false;
    		}
    		
    		if (typeof RTE != "undefined" ) {
    			RTE.instance.focus();
    			return false;
    		}
    		
    		$("#wpTextbox1").focus();
    		return false;
    	};
    });
}
);