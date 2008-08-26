
    CreatePage.prototype = Object.extend(new CreatePage(), {
	constructPageTop:function(){
		pgtxt = "";
		pgtxt += "{{Law Proposal Top}}" + nLG
		+ "by user ~~~" + nLG + nLG
		return pgtxt;
	},
        constructMainCategoryPageBottom: function() {	
		pgtxt = ""
		pgtxt += "===Justification===" + nLG + nLG
		pgtxt += $F("justification") + nLG + nLG
		pgtxt += "{{Comments}}" + nLG + nLG
		return pgtxt;
        }
    });
