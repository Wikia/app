
if(typeof(CreatePage) == 'function'){
    CreatePage.prototype = Object.extend(new CreatePage(), {
	/*
	Start of Page Content
	*/
	constructMainCategoryPageTop:function(){
				
			pgtxt = "";
			switch (this.category_main.toUpperCase()){
				case "SCHOOLS":
					pgtxt += "{{Schools Top}}" + nLG + nLG;
					break;
				case "ORGANIZATIONS":
					pgtxt += "{{Organizations Top}}" + nLG + nLG;
					break;
				case "BUSINESSES":
					pgtxt += "{{Businesses Top}}" + nLG + nLG;
					break;
				case "ARTICLES":
					pgtxt += "{{Article Top}}" + nLG + nLG
					+ "by user ~~~" + "" + nLG + nLG
					break;
				default : pgtxt += "{{" + this.category_main + " Top}}" + nLG + nLG;
			}
			return pgtxt;
	},
		
	/*
	Start Content after User Input (main body text)
	*/
	constructMainCategoryPageBottom:function(){
			pgtxt = "";
			pgtxt += "{{" + this.category_main.replace("Articles","Article") + " Bottom}}"
			return pgtxt
	},
	
        constructPageBottom: function() {	
		state_name = "";
		city_name = "";
		if($("state") && $F("state")) {
			state_name = $F("state");
			this.category_wiki += "[[Category: " + $F("state") + " " + $F("pageType") + "]]" + nLG;
			tagA = this.categories.split(",")
			for(x=0;x<=tagA.length-1;x++){
				this.category_wiki += "[[Category: " + $F("state") + " " + tagA[x].replace(/^\s*|\s*$/g,"") + " " + $F("pageType") + "]]" + nLG;
			}
		}
		if($("city") && $F("city")){
			city_name = $F("city");
			this.category_wiki += "[[Category: " + $F("city") + ", " + $F("state") + " " + $F("pageType") + "]]" + nLG;
			tagA = this.categories.split(",")
			for(x=0;x<=tagA.length-1;x++){
				this.category_wiki += "[[Category: " + $F("city") + ", " + $F("state") + " " + tagA[x].replace(/^\s*|\s*$/g,"") + " " + $F("pageType") + "]]" + nLG;
			}
		}
	 	if(! $F("state") && !$("city")) this.category_wiki += "[[Category: National" + " " + $F("pageType") + "]]" + nLG;
		if(this.category_main.toUpperCase()=="BUSINESSES" || this.category_main.toUpperCase()=="SCHOOLS" || this.category_main.toUpperCase()=="ORGANIZATIONS"){
			this.title = this.title + " (" + ((city_name)?city_name + ", ":"") + ((state_name)?state_name:"") + ")";
		}
		return "";
	}
    });
}
	
	
	function getCities(state){
		var url = "index.php?title=Special:LocalAction&action=1&state=" + state;
		var myAjax = new Ajax.Request(
			url, 
			{
				method: 'post', 
				parameters: "",
				onSuccess: function(originalRequest) {
					 if(originalRequest.responseText){
						 $("cities-label").show();
						 cities_array = originalRequest.responseText.split("|")
						 cities_select = "<select id=\"city\" name=\"city\"><option value=\"\"></option>"
						 for(x=0;x<=cities_array.length-1;x++){
						 	cities_select += "<option value=\"" + cities_array[x] + "\">" + cities_array[x] + "</option>";
						 }
						 cities_select += "</select>";
						 $("cities").innerHTML = "" + cities_select
					}else{
						alert("error")
					}
				}
			});
	}
	
	function searchLocation(){
		if($("state") && $("city") && $F("zip") + $F("city") + $F("state") == ""){
			alert("Please select an option");
			return;
		}
		if($F("zip")){
			loc = $F("zip");
		}else{
			loc = $F("state");
			if($F("city"))loc = $F("city") + ", " + loc; 
		}
		window.location = "/index.php?title=Special:Search&search=" + loc
	}
	
	