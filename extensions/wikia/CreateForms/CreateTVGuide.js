
if(typeof(CreatePage) == 'function'){
    CreatePage.prototype = Object.extend(new CreatePage(), {
	/*
	Start of Page Content
	*/
	constructMainCategoryPageTop:function(){
			this.title = "TV Guide Spotlight: " + this.title
			pgtxt = "";
			pgtxt += "{{TV Guide Spotlight Article}}" + nLG + nLG;	
			return pgtxt;
	},
	
	
	/*
	Start Content after User Input (main body text)
	*/
	/*
	constructMainCategoryPageBottom:function(){
			pgtxt = "";
			pgtxt += "{{" + this.category_main.replace("Articles","Article") + " Bottom}}"
			return pgtxt
	} 
	*/
    });
}


	
	
