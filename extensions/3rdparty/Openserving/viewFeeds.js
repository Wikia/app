var Feed = Class.create();

Feed.prototype = {

   initialize: function( ul, items) {

		this.ul = ul;
		this.items = items;
		
		this.title = "";
		this.categories = ""
		this.count = 5;
		this.orderBy = "PublishedDate";
		
		//default for later use
		this.showDetails = 0;
		this.showPic = 0;
		this.showBlurb = 0;
		this.showCtg = 0;
		
		this.initLinks();
		this.makeSortable();
   },

   initLinks:function(){
   		//enable edit links
		Event.unloadCache();
		document.getElementsByClassName("editFeed").each(function(item) {
      		Event.observe(item, 'click',  function(){this.edit(item.getAttribute("id").replace("el_","")) }.bind(this)  );
    	}.bind(this));
		
		//enable delete links
		document.getElementsByClassName("deleteFeed").each(function(item) {
      		Event.observe(item, 'click',  function(){this.deleteItem(item.getAttribute("id").replace("dl_","") ) }.bind(this)  );
    	}.bind(this));
   },
   
   makeSortable:function(){
   	  Sortable.create( this.ul,{dropOnEmpty:true,constraint:false,onUpdate:this.reOrderItems.bind(this),tag:'div'} ); 
   },
   
   add:function(){
   		this.id = "";
   		this.title = "";
		this.count = 5;
		this.categories = "";
		this.orderBy = "PublishedDate";
   		this.openEdit();
   },
   
   openEdit: function( ) {
  		this.editWindow = document.createElement('div');
		$(this.editWindow).addClassName("editWindow");
		document.body.appendChild(this.editWindow); 
		this.editWindow.hide();
		Effect.Appear(this.editWindow);
		Element.setStyle(this.editWindow,{'top':  (document.documentElement.scrollTop + 10) + 'px' });
		txt = "<a href=javascript:; id=close class=feedClose><img src=images/close.gif border=0></a><br>"
		txt +=	"<form><span class=formTitle>Title</span><br><input type=text class=feedForm id=title value='" + this.title + "' style='width:275px'><br>";
		txt +=		"<span class=formTitle>Items to Show</span><br><select id=feedCount class=feedForm>";
		for(x=1;x<=10;x++){txt+="<option value=" + x + ((this.count==x)?" selected ":"") + ">" + x + "</option>";}
		txt +=	"</select><br>";
		txt += "<span class=formTitle>Order by</span><br><select id=feedOrderBy class=feedForm ><option value=PublishedDate " + ((this.orderBy=="PublishedDate")?"selected":"") + ">Published Date</option><option value=New " + ((this.orderBy=="New")?"selected":"") + ">Create Date</option><option value=Votes " + ((this.orderBy=="Votes")?"selected":"") + ">Votes</option><option value=Comments>Comments</option></select><br>"
		txt +=		"<span class=formTitle>Categories</span><br><textarea id=feedCtg class=feedForm rows=3 style='width:275px'>" + this.categories + "</textarea><br>";
		txt += 		"<input type=button id=submit value=Save ></form>";
		$(this.editWindow).innerHTML = txt;

		Event.observe($("close"), 'click',this.closeEdit.bind(this))
		Event.observe($("submit"), 'click',this.save.bind(this))
   },
   /*
   	setEditPos: function(evt){
		var doc = document.documentElement;
		Element.setStyle(this.editWindow,{'top': evt.clientY + doc.scrollTop + 'px' });
	},
	*/
   closeEdit:function(){
   		Effect.Fade(this.editWindow);
   }, 
   
   edit:function(id){
   		if(this.editWindow)this.closeEdit();
  		var editItem = this.items.find( function(test){
			//alert(test.id + "==" + id)
			return (test.id == parseInt(id) );
		});
   		this.id = editItem.id;
   		this.title = editItem.title
		this.count = editItem.count
		this.categories = editItem.categories
		this.itemOrder = editItem.itemOrder
		this.orderBy = editItem.orderBy
		this.openEdit();
   },
 
   save:function(){
   		this.title = $F("title")
		this.categories = $F("feedCtg")
		this.count = $F("feedCount")
		this.orderBy = $F("feedOrderBy")
		if(!this.id)this.itemOrder = this.items.length
		this.addToDB();
		this.items[this.itemOrder] = {id:this.id,title:this.title,categories:this.categories,count:this.count,itemOrder:this.itemOrder,orderBy:this.orderBy}
   },
   
   addToPage:function( ){
   	  var li = document.createElement('div');
	  $(this.ul).appendChild(li); 
 
	  this.itemOrder = this.items.length - 1
	  this.items[this.itemOrder].id = this.id
 
	  li.setAttribute("id","item_" + this.id)
	  Element.addClassName(li, "feedItem");
	  this.getFeedContent(this.id);
   },
   
   addToDB:function(){
   		//var url = "extensions/feedAction.php?Action=1";
		var url = "index.php?title=Special:FeedAction&Action=1";
		var pars = 'id=' + ((this.id)?this.id:0) + '&feedtitle=' + this.title + '&ctg=' + this.categories + '&show=' + this.count + '&order=' + this.order+ '&det=' + this.showDetails+ '&pic=' + this.showPic+ '&blb=' + this.showBlurb + '&showctg=' + this.showCtg + '&orderby=' + this.orderBy
		
		var myAjax = new Ajax.Request(
			//'status',
			url, 
			{
				method: 'post', 
				parameters: pars,
				onComplete:function (originalRequest){
					if(!this.id){
						this.id = originalRequest.responseText;
						this.addToPage();
					}else{
						this.getFeedContent(this.id);
					}
				}.bind(this)
		});
   },
   
   deleteItem:function(id){
     	var deleteItem = this.items.find( function(test){
			//alert(test.id + "==" + id)
			return (test.id == parseInt(id) );
		});

   		this.deleteFromPage(  deleteItem.itemOrder );
		this.deleteFromDB(  id );
   },
   
   deleteFromPage:function( num ){
   		Element.remove( $("item_" + this.items[num].id) );
   		this.items[num] = null;
		this.items = this.items.compact();
   },
   
   deleteFromDB:function(id){
   		//var url = "extensions/feedAction.php?Action=2";
		var url = "index.php?title=Special:FeedAction&Action=2";
		var pars = 'feed_id=' + id 
		var myAjax = new Ajax.Request(
			//"status",
			url, 
			{
				method: 'post', 
				parameters: pars
		});
   }, 
   
   getFeedContent:function(to){
   		//var url = "extensions/ListPagesAction.php";
		var url = "index.php?title=Special:ListPagesAction";
		var pars = 'pg=1&shw=' + this.count + '&ctg=' + this.categories + '&ord=' + this.orderBy + "&lv=1&shwvb=1&det=1&shwdt=0&shwst=0&pub=" + ((this.orderBy=="New")?"-1":"1") + "&shwctg=NO&shwpic=NO&shwb=0&bfs=0";
		var myAjax = new Ajax.Updater(
		"item_" + to, 
		url, 
		{
			method: 'post', 
			parameters: pars,
			onComplete:function(originalRequest){
				new Insertion.Top($("item_" + this.id),"<table cellpadding=0 cellspacing=0 width=100%><tr><td><div class=feedtitle>" + this.title + "</div></td><td align=right valign=top><a href=javascript:; class=editFeed id=el_" + this.id + " >edit<a> | <a href=javascript:; class=deleteFeed id=dl_" + this.id + ">remove</a></td></tr></table>")
				this.initLinks();
				this.closeEdit();
				this.makeSortable();
			}.bind(this)
	  
		});
		
		  
   },

   reOrderItems:function(){
		orderSerialize = "";
		x=0;
		document.getElementsByClassName("feedItem").each(function(item) {	
			orderSerialize+= ((orderSerialize)?"&":"") + "items[" + item.getAttribute("id").replace("item_","") + "]=" + x
			x++;
		}.bind(this));
		//var url = "extensions/feedAction.php?Action=3";
		var url = "index.php?title=Special:FeedAction&Action=3";
		var pars = orderSerialize
		var myAjax = new Ajax.Request(
			//"status",
			url, 
			{
				method: 'post', 
				parameters: pars
		});
		
   }
   
};	

var TheFeed;
function addFeed(){
	TheFeed.add();
}

function start(){
 if($("listpages")){
 TheFeed = new Feed( "listpages",feedItems );
}
 }