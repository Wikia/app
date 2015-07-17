/*==================================================
 *  Exhibit.ExhibitXMLImporter
 *==================================================
 */
 
 

Exhibit.ExhibitXMLImporter = { };

Exhibit.importers["application/xml"] = Exhibit.ExhibitXMLImporter;

Exhibit.ExhibitXMLImporter.getXMLDocument = function (docURL) {
	
	var xmlDoc = null;
	$.ajax({
		   url: docURL,
		   type: 'GET',
		   dataType: 'xml',
		   async: false, //Need this due to failure of getting XMLDoc from server
		   success: function(data) { xmlDoc = data;}
		   });
	if (xmlDoc)
	{
		return xmlDoc;
	}
	else
	{
		alert('ERROR FINDING XML DOC');
		return;
	}
}


//APPENDS PROPERTIES (NAME SPECIFIED BY USER) TO ARRAY
Exhibit.ExhibitXMLImporter.appendUserPropertyToArray = function(node,configuration,objectToAppend)
{
	
	var referenceIndex = configuration.propertyTags.indexOf(node.nodeName);
	var array = objectToAppend[configuration.propertyNames[referenceIndex]];
	// check if property list has been initialized
	if  (typeof objectToAppend[configuration.propertyNames[referenceIndex]] == 'string')
	{
		array = [array];
		array.push(node.textContent);
	}
	else
	{
		array.push(node.textContent);
	}
	return array;
}

// APPENDS PROPERTIES (NAME NOT SPECIFIED BY USER) TO ARRAY
Exhibit.ExhibitXMLImporter.appendPropertyToArray = function(node,configuration,objectToAppend)
{
	var array = objectToAppend[node.nodeName];
	
	
	if (typeof array == 'string')
	{
		array = [array];
		array.push(node.textContent);
	}
	else
	{
		array.push(node.textContent);
		
	}
	return array;
}

//GETS ALL ITEMS OF CONFIGURATION.ITEMTAG[INDEX]
Exhibit.ExhibitXMLImporter.getItems = function(xmlDoc, object,index,configuration) 
{
	var self = this;
	$(configuration.itemTag[index],xmlDoc).each( function()
																	 {
																		 var propertyList = [];
																		 var queue = [];
																		 $(this).children().each(function() {
																										  queue.push(this);
																										  }
																								  );								  
																		objectToAppend = {};
																		while (queue.length)
																		{
																			var node = queue.pop();
																			var nodeType = self.determineType(node,configuration);
																			
																			if (nodeType == 'property')
																			{
																				// IF MULTIPLE PROPERTIES OF SAME NODENAME, APPEND TO ARRAY
																				if (propertyList.indexOf(node.nodeName)>=0)
																				{
																					// check if user specified property name
																					if (configuration.propertyTags.indexOf(node.nodeName)>=0)
																					{
																						objectToAppend[configuration.propertyNames[index]]= self.appendUserPropertyToArray(node,configuration,objectToAppend);
																						
																					}
																					else // Use tag name as property name
																					{	
																						objectToAppend[node.nodeName]= self.appendPropertyToArray(node,configuration,objectToAppend);
																					}
																					
																				}
																				else //IF SINGLE VALUE APPEND TO STRING VALUE
																				{
																				// APPLY USER SPECIFIED PROPERTY NAMES
																					if (configuration.propertyTags.indexOf(node.nodeName)>=0)
																					{
																						var referenceIndex = configuration.propertyTags.indexOf(node.nodeName);
																						objectToAppend[configuration.propertyNames[referenceIndex]] = node.textContent;
																					}
																					//ELSE, USE TAG NODENAME
																					else
																					{
																						objectToAppend[node.nodeName] = node.textContent;
																					}
																				}
																				propertyList.push(node.nodeName);
																			}
																			else if (nodeType == 'Item')
																			{
																				var referenceIndex = configuration.itemTag.indexOf(node.nodeName);
																				var tempObject = self.configureItem(node,{},configuration,referenceIndex);
				
																				objectToAppend[tempObject.type] = tempObject.label;
																			}
																			else if (nodeType == 'fakeItem')
																			{
																				$(node).children().each(function() 
																												 {
																												 queue.push(this);
																												 }
																										);																				
																			}
																			else
																			{
																				alert('error: nodetype not understood');
																			}
																		}
																		objectToAppend = self.configureItem(this, objectToAppend,configuration,index);
																		object.items.push(objectToAppend);
																	 }
															)
													
	
	return object;
}

//FINDS THE CLOSEST PARENT NODE THAT'S IN CONFIGURATION.ITEMTAG
Exhibit.ExhibitXMLImporter.getParentItem = function(itemNode,configuration)
{
	if (itemNode.parentNode==null)
	{
		return null;
	}
	else if (configuration.itemTag.indexOf(itemNode.parentNode.nodeName)>=0)
	{
		var referenceIndex = configuration.itemTag.indexOf(itemNode.parentNode.nodeName);
		return this.configureItem(itemNode.parentNode,{},configuration,referenceIndex);
	}
	else
	{
		this.getParentItem(itemNode.parentNode,configuration);
	}
}

// SETS LABEL, TYPE, AND PARENT RELATION
Exhibit.ExhibitXMLImporter.configureItem = function(myItem, object,configuration,index)
{
	if (!(object.label) && configuration.propertyLabel[index]!=null) 
	{
		object['label'] = $(configuration.propertyLabel[index],myItem)[0].textContent;
	}
	else //DEFAULT TO FIRST PROPERTY
	{
		object['label'] = $(myItem).children()[0].textContent;
	}
	
	if (!(object.type) && configuration.itemType[index]!=null)
	{
		object['type'] = configuration.itemType[index];
	}
	else //DEFAULT TO NODENAME
	{
		object['type'] = myItem.nodeName;
	}
	
	var parentItem = this.getParentItem(myItem,configuration);
	if (parentItem)
	{
		if (configuration.parentRelation[index])
		{
			object[configuration.parentRelation[index]] = parentItem.label;
		}
		else //DEFAULT TO "IS A CHILD OF"
		{
			object['isChildOf'] = parentItem.label;
		}
	}
	return object;
}
	

Exhibit.ExhibitXMLImporter.configure = function() 
{
	var configuration = 
	{
		'itemTag': [],
		'propertyLabel': [],
		'itemType': [],
		'parentRelation': [],
		'propertyTags': [],
		'propertyNames': []
		

	}

	// get itemTag, propertyLabel, itemType, and parentRelation
	$('link').each( function()
							 {
								 if (this.hasAttribute('ex:itemTag')) 
								 {
									 configuration.itemTag = Exhibit.getAttribute(this,'ex:itemTag',',');
								 }
								 if (this.hasAttribute('ex:setPropertyAsLabel'))
								 {
									configuration.propertyLabel = Exhibit.getAttribute(this,'ex:setPropertyAsLabel',',');
								 }
								 if (this.hasAttribute('ex:itemType'))
								 {
									 configuration.itemType = Exhibit.getAttribute(this,'ex:itemType',',');
								 }
								 if (this.hasAttribute('ex:parentRelation'))
								 {
									 configuration.parentRelation = Exhibit.getAttribute(this,'ex:parentRelation',',');
								 }
								 if (this.hasAttribute('ex:propertyNames'))
								 {
									 configuration.propertyNames = Exhibit.getAttribute(this,'ex:propertyNames',',');
								 }
								 if (this.hasAttribute('ex:propertyTags'))
								 {
									 configuration.propertyTags = Exhibit.getAttribute(this,'ex:propertyTags',',');
								 }
								
							 }
					)
	
	return configuration;
}

Exhibit.ExhibitXMLImporter.determineType = function(node,configuration)
{
	
	if (configuration.itemTag.indexOf(node.nodeName)>=0)
			{
				return "Item";
			}
	
	else if ($(node).children().length == 0)
	{
		return 'property';
	}
	
	else
	{
		return 'fakeItem';
	}
}


																			

Exhibit.ExhibitXMLImporter.load = function (link,database,cont)
{
	var self = this;
	var url = typeof link == "string" ? link : link.href;
	url = Exhibit.Persistence.resolveURL(url);
    var fError = function(statusText, status, xmlhttp) {
        Exhibit.UI.hideBusyIndicator();
        Exhibit.UI.showHelp(Exhibit.l10n.failedToLoadDataFileMessage(url));
        if (cont) cont();
    };
	
	var fDone = function() {
        Exhibit.UI.hideBusyIndicator();
        try {
            var o = null;
            try {
				xmlDoc = Exhibit.ExhibitXMLImporter.getXMLDocument(url);
				var configuration = self.configure();
                o = { 
					'items': []
					};
				for (index in configuration.itemTag)
				{
					o = Exhibit.ExhibitXMLImporter.getItems(xmlDoc,o,index,configuration);
				}
				
            } catch (e) {
                Exhibit.UI.showJsonFileValidation(Exhibit.l10n.badJsonMessage(url, e), url);
            }
            
            if (o != null) {
                database.loadData(o, Exhibit.Persistence.getBaseURL(url));
            }
        } catch (e) {
            SimileAjax.Debug.exception(e, "Error loading Exhibit JSON data from " + url);
        } 

		finally {
            if (cont) cont();
        }
    };
	
	Exhibit.UI.showBusyIndicator();
    SimileAjax.XmlHttp.get(url, fError, fDone);
}
	
						  