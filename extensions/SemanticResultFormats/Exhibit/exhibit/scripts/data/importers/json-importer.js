Exhibit.jsonImporter = { };

Exhibit.importers["application/general-json"] = Exhibit.jsonImporter;

Exhibit.jsonImporter.getjsonDocument = function (docURL)
{

	var jsonDoc = null;
	$.ajax({
		   url: docURL,
		   type: 'GET',
		   dataType: 'json',
		   async: false, //Need this due to failure of getting jsonDoc from server
		   success: function(data) { jsonDoc = data;}
		   });
	if (jsonDoc)
	{
		return jsonDoc;
	}
	else
	{
		alert('ERROR FINDING JSON DOC');
		return null;
	};
};

Exhibit.jsonImporter.findFirstItems = function(json,configuration)
{
	if (json instanceof Array)
	{
	    return json.length > 0 ? Exhibit.jsonImporter.findFirstItems(json[0],configuration) : null;
	}
	else
	{
		var visited = [];
		var listOfItems = [];
		for (child in json)
		{
			visited.push(json[child]);
			if (configuration.itemTag.indexOf(child)>=0)
			{
				for (var i = 0; i < json[child].length; i++)
				{
				    var subChild = json[child][i];
					subChild.index = configuration.itemTag.indexOf(child);
					listOfItems.push(subChild);
				};
			};
		};
		if (listOfItems.length)
		{
			return listOfItems;
		}
		else
			return Exhibit.jsonImporter.findFirstItems(visited,configuration);
	}
};


Exhibit.jsonImporter.getItems = function(json,exhibitJSON,configuration)
{
	var itemQueue;
	var root = json;
	if (root instanceof Array)
		itemQueue = root;
	else
		itemQueue = [root];

	while (itemQueue.length>0)
	{

		var myObject = itemQueue.shift();
		var index = myObject.index;
		var objectToAppend = {};

		var propertyQueue = [];
		for (propertyKey in myObject)
		{
			propertyQueue.push(propertyKey)
		};

		while (propertyQueue.length>0)
		{
			var key = propertyQueue.shift();

			var keyID = key.split('.').pop();

			// TEST IF Property
			if (configuration.itemTag.indexOf(keyID)==-1)
			{
				var propertyValue = eval('myObject.' + key);
				if (keyID=='index') { }
					// remain silent
				else if (propertyValue instanceof Array)
				{
					objectToAppend[keyID] = propertyValue;
				}
				// Fake Item
				else if (propertyValue instanceof Object)
				{
					for (newProperty in propertyValue)
					{
						propertyQueue.push(key + '.' + newProperty);
					}
				}
				// Rename property Tag
				else if (keyID == configuration.propertyTags[index])
				{
					var referenceIndex = configuration.propertyTags.indexOf(keyID);
					var newKey = configuration.propertyNames[referenceIndex];
					objectToAppend[newKey] = propertyValue;
				}
				// Label property
				else if (keyID == configuration.propertyLabel[index])
				{
					objectToAppend.label = propertyValue;
				}
				// arbitrary property
				else
				{
					objectToAppend[keyID] = propertyValue;
				}
				if (configuration.itemType[index])
				{
					objectToAppend.type = configuration.itemType[index];
				}
				else
				{
					objectToAppend.type='Item';
				};

			}
			// MUST BE Item
			else
			{
				newObject = eval('myObject.' + key);
				if (newObject instanceof Array)
				{
					for (var i = 0; i < newObject.length; i++)
					{
					    var object = newObject[i];
						object.index = configuration.itemTag.indexOf(keyID);
						// PARENT RELATION
						if (configuration.parentRelation[object.index])
							object[configuration.parentRelation[object.index]] = objectToAppend.label;
						else
							object['is a child of'] = objectToAppend.label;
						itemQueue.push(object);
					}
				}
				else
				{
					newObject.index = configuration.itemTag.indexOf(keyID);
					if (configuration.parentRelation[newObject.index])
						newObject[configuration.parentRelation[newObject.index]] = objectToAppend.label;
					else
						newObject['isChildOf'] = objectToAppend.label;
					itemQueue.push(newObject);
				}


			};
		};
		exhibitJSON.items.push(objectToAppend);
	}
	return exhibitJSON;

};

Exhibit.jsonImporter.configure = function()
{
	var configuration =
	{
		'itemTag': [],
		'propertyLabel': [],
		'itemType': [],
		'parentRelation': [],
		'propertyTags': [],
		'propertyNames': []


	};

	// get itemTag, propertyLabel, itemType, and parentRelation
	$('link').each( function()
							 {
								 if (this.hasAttribute('ex:itemTag'))
								 {
									 configuration.itemTag = Exhibit.getAttribute(this,'ex:itemTag',',');
								 };
								 if (this.hasAttribute('ex:setPropertyAsLabel'))
								 {
									configuration.propertyLabel = Exhibit.getAttribute(this,'ex:setPropertyAsLabel',',');
								 };
								 if (this.hasAttribute('ex:itemType'))
								 {
									 configuration.itemType = Exhibit.getAttribute(this,'ex:itemType',',');
								 };
								 if (this.hasAttribute('ex:parentRelation'))
								 {
									 configuration.parentRelation = Exhibit.getAttribute(this,'ex:parentRelation',',');
								 };
								 if (this.hasAttribute('ex:propertyNames'))
								 {
									 configuration.propertyNames = Exhibit.getAttribute(this,'ex:propertyNames',',');
								 };
								 if (this.hasAttribute('ex:propertyTags'))
								 {
									 configuration.propertyTags = Exhibit.getAttribute(this,'ex:propertyTags',',');
								 };

							 }
					);

	return configuration;
}


Exhibit.jsonImporter.load = function (link,database,cont)
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
				jsonDoc = Exhibit.jsonImporter.getjsonDocument(url);
				var configuration = self.configure();
                o = {
					'items': []
					};
				var root = self.findFirstItems(jsonDoc,configuration);
				o = Exhibit.jsonImporter.getItems(root,o,configuration);


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
