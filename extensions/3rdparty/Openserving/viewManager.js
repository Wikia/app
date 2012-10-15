	function submitView(){
		err = "";
		req = ["domain|View Name", "ctg|Categories","color1|Color 1","color2|Color 2","color3|Color 3","bordercolor1|Border Color 1"]
		for(x=0;x<=req.length-1;x++){
			fld = req[x].split("|")
			if(eval("document.form1." + fld[0]) && eval("document.form1." + fld[0] + ".value") == ""){
				err+= fld[1] + " is required\n";
			}
		}
		
 
		if(!err){
			document.form1.submit();
		}else{
			alert(err)
		}
	}