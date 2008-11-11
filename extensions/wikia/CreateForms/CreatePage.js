var $ = YAHOO.util.Dom.get;


function $El(name) {
	return new YAHOO.util.Element(name);
}

var $D = YAHOO.util.Dom;
var $E = YAHOO.util.Event;
var $$ = YAHOO.util.Dom.getElementsByClassName;

var Class = {
  create: function() {
    return function() {
      this.initialize.apply(this, arguments);
    }
  }
}


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
		YAHOO.util.Dom.setStyle("tag-" + tagnumber, 'color', "#cccccc");
		//Element.setStyle($("tag-" + tagnumber),{'color':  "#cccccc" });
		$("tag-" + tagnumber).innerHTML = tagname;
		$("pageCtg").value += (($("pageCtg").value)?", ":"") + tagname;
	}	
	
	var CreatePage = Class.create();
	CreatePage.prototype = {
		initialize: function( category_main) {
			this.category_main = category_main
			this.namespace = "";
			this.pageCode = "";
			this.category_wiki = "";
		},
		checkPageTitleExists:function(PageNamespace,PageTitle){
			oXMLHTTP = XMLHttp();
	
			oXMLHTTP.open("GET","index.php?action=ajax&rs=wfPageTitleExists&rsargs[]="+PageTitle, false );
			oXMLHTTP.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			oXMLHTTP.send('');
		
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
					pgtxt += "{{Opinion Top}}" + nLG + nLG
		  			//+ "by ~~~" + "" + nLG + nLG
					break;
				case "NEWS":
					pgtxt += "{{News Top}}" + nLG + nLG;
					break;
				case "QUESTIONS":
					pgtxt += "{{Questions Top}}" + nLG + nLG;
					break;
				case "ARTICLES":
					pgtxt += "{{Article Top}}" + nLG + nLG
					+ "by ~~~" + "" + nLG + nLG
					break;
				case "STORIES":
					pgtxt += "{{Stories Top}}" + nLG + nLG
					+ "by ~~~" + "" + nLG + nLG
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
			//pgtxt += "__NOEDITSECTION__" + nLG
			pgtxt += "[[Category: " + this.category_main + "]]" + nLG
			if(this.category_main.toUpperCase()!="NEWS")pgtxt += "[[Category: " + this.category_main + " by User " + document.editform.usr.value + "]] " +  nLG
			if( wgBlogDates ){
				pgtxt += "[[Category: {{subst:CURRENTMONTHNAME}} {{subst:CURRENTDAY}}, {{subst:CURRENTYEAR}}]]" + nLG
				pgtxt += "[[Category: {{subst:CURRENTMONTHNAME}} {{subst:CURRENTYEAR}}]]" + nLG
			}
			pgtxt += this.parseCategories(this.categories);
			
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
			this.title = $("title").value
			this.title = this.title.replace(/&/gi,"%26");
			this.title = this.title.replace(/\?/gi,"%3F");
			
			if( $("namespace").value) this.namespace = $("namespace").value 
		
			if( this.namespace ){
				this.title = this.namespace + ":" + this.title
			}
			if( this.title.indexOf("#") > -1){
				alert("The # character cannot be used in page titles");
				return;
			} 
			needToConfirm = false;
			if(typeof(wikiwyg)=="object"){
				wiki_text = new Wikiwyg.Wikitext
				var user_html = ""
				wikiwyg.current_mode.toHtml(
					function(html) {
						html =  wiki_text.cleanText(html)
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
				if($("pageBody"))this.body = $("pageBody").value;
			}
			this.categories = $("pageCtg").value
			this.setCategoriesWiki();
			this.constructPage();
			document.editform.action="/index.php?title=" + this.title.replace(/ /gi,"_") + "&action=submit"
			if( this.checkPageTitleExists(this.namespace,this.title)==true){
				alert("The page title already exists. Please choose another one to distinguish your page.");
				return;
			} 
			document.editform.wpTextbox1.value = this.pageCode;
			document.editform.submit();
		}
	}

	function createPage2(){
		page = new CreatePage($("pageType").value )
		page.submitPage();
	}
