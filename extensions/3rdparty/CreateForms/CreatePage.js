var wikiwyg_divs = [];
var wikiwyg;

var needToConfirm = true;
window.onbeforeunload = confirmExit;
function confirmExit(){
  	if (needToConfirm){
   		return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";    
  	}
}
  
function initWikywyg() {
    if(!Wikiwyg.browserIsSupported)window.location=window.location+'_Standard';
    wikiwyg = new Wikiwyg();
    var divs = [];
    divs.push($("wikiwyg"));
    var config = {
        doubleClickToEdit: true,
       modeClasses: [
        'Wikiwyg.Wysiwyg',
        'Wikiwyg.Wikitext'

    ],
    javascriptLocation: 'extensions/Wikiwyg/lib/',
    toolbar: {
		imagesLocation: 'extensions/Wikiwyg/images/'
            },
        wysiwyg: {
                iframeId: 'iframe1'  
        }
     };
    wikiwyg.createWikiwygArea($("wikiwyg"), config);
    wikiwyg_divs.push(wikiwyg);
    setTimeout("wikiwyg.editMode();",200);
}

var nLG = String.fromCharCode(13)+String.fromCharCode(10)

	function XMLHttp(){
		if (window.XMLHttpRequest){ //Moz
			var xt = new XMLHttpRequest();
		}else{ //IE
			var xt = new ActiveXObject('Microsoft.XMLHTTP');
		}
		return xt
	}
	
	function insertTag(tagname,tagnumber){
		Element.setStyle($("tag-" + tagnumber),{'color':  "#cccccc" });
		$("tag-" + tagnumber).innerHTML = tagname;
		$("pageCtg").value += (($F("pageCtg"))?", ":"") + tagname;
	}	
	
	var CreatePage = Class.create();
	CreatePage.prototype = {
		initialize: function( category_main) {
			this.category_main = category_main
			this.pageCode = "";
			this.category_wiki = "";
		},
		checkPageTitleExists:function(PageTitle){
			return false;
			oXMLHTTP = XMLHttp();
			oXMLHTTP.open("POST","extensions/CreatePageChk.php", false );
			oXMLHTTP.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			oXMLHTTP.send('pagetitle=' + PageTitle);
	
			if(oXMLHTTP.responseText.indexOf("OK")==-1){
				return true;
			}else{
				return false;
			}
		},
		getCategory:function(tag,category){
			return "[[Category: " + ((tag)?tag+" ":"") + category + "]]";
		},
		parseCategories:function(alltags){
			tagA = alltags.split(",")
			wikiTags = ""
			for(x=0;x<=tagA.length-1;x++){
				wikiTags+= this.getCategory(tagA[x].replace(/^\s*|\s*$/g,""),this.category_main) + nLG;
			}
			return wikiTags;
		},
		parseSources:function(alltags){
			tagA = alltags.split(",") 
			wikiTags = ""
			theSource = ""
			for(x=0;x<=tagA.length-1;x++){
				theSource = tagA[x].replace(/^\s*|\s*$/g,"")
				wikiTags+= "* " + theSource + nLG;
			}
			return wikiTags;
		},
		
		/*
		*
		*
		* BEGIN CONTENT FUNCTIONS
		*
		*
		*/
		
		/*
		Start of Page Content
		*/
		constructMainCategoryPageTop:function(){
			pgtxt = "";
			switch (this.category_main.toUpperCase()){
				case "OPINIONS":
					pgtxt += "{{Opinion Top}}" + nLG
		  			+ "by user ~~~" + "" + nLG + nLG
					break;
				case "NEWS":
					pgtxt += "{{News Top}}" + nLG + nLG;
					break;
				case "QUESTIONS":
					pgtxt += "{{Questions Top}}" + nLG + nLG;
					break;
				case "ARTICLES":
					pgtxt += "{{Article Top}}" + nLG + nLG
					+ "by user ~~~" + "" + nLG + nLG
					break;
				case "STORIES":
					pgtxt += "{{Stories Top}}" + nLG + nLG
					+ "by user ~~~" + "" + nLG + nLG
					break;
				default : pgtxt += "{{" + this.category_main + " Top}}" + nLG + nLG;
			}
			return pgtxt;
		},
		
		/*
		Cotains main content from User Input
		*/
		constructPageMain:function(){
			return  "<!--start text-->" + nLG + this.body + nLG + nLG;
		},
		
		/*
		Start Content after User Input (main body text)
		*/
		constructMainCategoryPageBottom:function(){
			pgtxt = "";
			switch (this.category_main.toUpperCase()){
				case "OPINIONS":
					pgtxt += "{{Comments}}"
					break;
				case "NEWS":
					pgtxt += "{{Comments}}"
					break;
				case "QUESTIONS":
					pgtxt += "{{Comments}}"
					break;
				case "ARTICLES":
					pgtxt += "{{Comments}}"
					break;
				default : pgtxt += "{{" + this.category_main + " Bottom}}" + nLG
			}
			return pgtxt
		},
		
		setCategoriesWiki:function(){
			pgtxt = "";
			pgtxt += "__NOTOC__" + nLG
			pgtxt += "__NOEDITSECTION__" + nLG
			pgtxt += "[[Category: " + this.category_main + "]]" + nLG
			if(this.category_main.toUpperCase()!="NEWS")pgtxt += "[[Category: " + this.category_main + " by User " + document.editform.usr.value + "]] " +  nLG
			pgtxt += "[[Category: {{subst:CURRENTMONTHNAME}} {{subst:CURRENTDAY}}, {{subst:CURRENTYEAR}}]]" + nLG
			
			pgtxt += this.parseCategories(this.categories);
			
			//bring in default category for openserving readers
			if (document.editform.viewname )pgtxt += "[[Category: " + document.editform.pageType.value + " by " + document.editform.viewname.value + " Readers]] " +  nLG
			//bring in default categories for openserving default
  			if (document.editform.viewctg )pgtxt += this.parseCategories(document.editform.viewctg.value,"")
			this.category_wiki = pgtxt
		},
		
		getCategoriesWiki:function(){
			return nLG + this.category_wiki
		},
		
		/*
		*
		FUNCTIONS THAT WILL BE OVERRIDDEN
		*
		*/
		
		/*
		Executed After Main Category Top
		*/
		constructPageTop:function(){
			return "";
		},
		
		/*
		Executed After Main Category Bottom
		*/
		constructPageBottom:function(){
			return "";
		},
	
		constructPage:function(){
			this.pageCode += this.constructMainCategoryPageTop()
			this.pageCode += this.constructPageTop()
			this.pageCode += this.constructPageMain()
			this.pageCode += this.constructMainCategoryPageBottom()
			this.pageCode += this.constructPageBottom()
			this.pageCode += this.getCategoriesWiki()
		},
	
		/*
		*
		*
		* END CONTENT FUNCTIONS
		*
		*
		*/
		
		submitPage:function(){
			this.title = $F("title")
			needToConfirm = false;
			if(typeof(wikiwyg)=="object"){
				wiki_text = new Wikiwyg.Wikitext
				var user_html = ""
				wikiwyg.current_mode.toHtml(
					function(html) {
						if (Wikiwyg.is_ie)html =  wiki_text.cleanText(html)
						html = html.replace(/<br[^>]+./gi,"<br>") //fix brs
						html = html.replace(/<br><br>/gi,"<p>") //make real line breaks
						wiki_text.convertHtmlToWikitext(
							html,
							function(wikitext) {
								user_html = wikitext
							}
						);
					}
				);
				this.body = user_html;
			}else{
				this.body = $F("pageBody");
			}
			this.categories = $F("pageCtg")
			this.setCategoriesWiki();
			this.constructPage();
			document.editform.action="/index.php?title=" + this.title.replace(/ /gi,"_") + "&action=submit"
			if( this.checkPageTitleExists(this.title)==true){
				alert("The page title already exists. Please choose another one to distinguish your page.");
				return;
			} 
			document.editform.wpTextbox1.value = this.pageCode;
			document.editform.submit();
		}
	}

	function createPage2(){
		page = new CreatePage($F("pageType") )
		page.submitPage();
	}
