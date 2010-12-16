/*======================================================================
 *  Collection
 *======================================================================
 */
Exhibit.Collection = function(id, database) {
    this._id = id;
    this._database = database;
    
    this._listeners = new SimileAjax.ListenerQueue();
    this._facets = [];
    this._updating = false;
    
    this._items = null;
    this._restrictedItems = null;
};

Exhibit.Collection.create = function(id, configuration, database) {
    var collection = new Exhibit.Collection(id, database);
    
    if ("itemTypes" in configuration) {
        collection._itemTypes = configuration.itemTypes;
        collection._update = Exhibit.Collection._typeBasedCollection_update;
    } else {
        collection._update = Exhibit.Collection._allItemsCollection_update;
    }
    
    var update = function() { collection._update(); };
    collection._listener = { 
        onAfterLoadingItems: update,
        onAfterRemovingAllStatements: update
    };
    database.addListener(collection._listener);
    
    collection._update();
    
    return collection;
};

Exhibit.Collection.create2 = function(id, configuration, uiContext) {
    var database = uiContext.getDatabase();
    
    if ("expression" in configuration) {
        var collection = new Exhibit.Collection(id, database);
        
        collection._expression = Exhibit.ExpressionParser.parse(configuration.expression);
        collection._baseCollection = ("baseCollectionID" in configuration) ? 
            uiContext.getExhibit().getCollection(configuration.baseCollectionID) : 
            uiContext.getCollection();
            
        collection._update = Exhibit.Collection._basedCollection_update;
        
        collection._listener = { onItemsChanged: function() { collection._update(); } };
        collection._baseCollection.addListener(collection._listener);
        
        collection._update();
        
        return collection;
    } else {
        return Exhibit.Collection.create(id, configuration, database);
    }
};

Exhibit.Collection.createFromDOM = function(id, elmt, database) {
    var collection = new Exhibit.Collection(id, database);
    
    var itemTypes = Exhibit.getAttribute(elmt, "itemTypes", ",");
    if (itemTypes != null && itemTypes.length > 0) {
        collection._itemTypes = itemTypes;
        collection._update = Exhibit.Collection._typeBasedCollection_update;
    } else {
        collection._update = Exhibit.Collection._allItemsCollection_update;
    }
    
    var update = function() { collection._update(); };
    collection._listener = { 
        onAfterLoadingItems: update,
        onAfterRemovingAllStatements: update
    };
    database.addListener(collection._listener);
        
    collection._update();
    
    return collection;
};

Exhibit.Collection.createFromDOM2 = function(id, elmt, uiContext) {
    var database = uiContext.getDatabase();
    
    var expressionString = Exhibit.getAttribute(elmt, "expression");
    if (expressionString != null && expressionString.length > 0) {
        var collection = new Exhibit.Collection(id, database);
    
        collection._expression = Exhibit.ExpressionParser.parse(expressionString);
        
        var baseCollectionID = Exhibit.getAttribute(elmt, "baseCollectionID");
        collection._baseCollection = (baseCollectionID != null && baseCollectionID.length > 0) ? 
            uiContext.getExhibit().getCollection(baseCollectionID) : 
            uiContext.getCollection();
            
        collection._update = Exhibit.Collection._basedCollection_update;
        
        collection._listener = { onItemsChanged: function() { collection._update(); } };
        collection._baseCollection.addListener(collection._listener);
        
        collection._update();
        
        return collection;
    } else {
        return Exhibit.Collection.createFromDOM(id, elmt, database);
    }
};

Exhibit.Collection.createAllItemsCollection = function(id, database) {
    var collection = new Exhibit.Collection(id, database);
    
    var update = function() { collection._update(); };
    collection._listener = { 
        onAfterLoadingItems: update,
        onAfterRemovingAllStatements: update
    };
    database.addListener(collection._listener);
    
    collection._update = Exhibit.Collection._allItemsCollection_update;
    collection._update();
    
    return collection;
};

/*======================================================================
 *  Implementation
 *======================================================================
 */
Exhibit.Collection._allItemsCollection_update = function() {
    this._items = this._database.getAllItems();
    this._onRootItemsChanged();
};

Exhibit.Collection._typeBasedCollection_update = function() {
    var newItems = new Exhibit.Set();
    for (var i = 0; i < this._itemTypes.length; i++) {
        this._database.getSubjects(this._itemTypes[i], "type", newItems);
    }
    
    this._items = newItems;
    this._onRootItemsChanged();
};

Exhibit.Collection._basedCollection_update = function() {
    this._items = this._expression.evaluate(
        { "value" : this._baseCollection.getRestrictedItems() }, 
        { "value" : "item" }, 
        "value",
        this._database
    ).values;
    
    this._onRootItemsChanged();
};

Exhibit.Collection.prototype.getID = function() {
    return this._id;
};

Exhibit.Collection.prototype.dispose = function() {
    if ("_baseCollection" in this) {
        this._baseCollection.removeListener(this._listener);
        this._baseCollection = null;
        this._expression = null;
    } else {
        this._database.removeListener(this._listener);
    }
    this._database = null;
    this._listener = null;
    
    this._listeners = null;
    this._items = null;
    this._restrictedItems = null;
};

Exhibit.Collection.prototype.addListener = function(listener) {
    this._listeners.add(listener);
};

Exhibit.Collection.prototype.removeListener = function(listener) {
    this._listeners.remove(listener);
};

Exhibit.Collection.prototype.addFacet = function(facet) {
    this._facets.push(facet);
    
    if (facet.hasRestrictions()) {
        this._computeRestrictedItems();
        this._updateFacets(null);
        this._listeners.fire("onItemsChanged", []);
    } else {
        facet.update(this.getRestrictedItems());
    }
};

Exhibit.Collection.prototype.removeFacet = function(facet) {
    for (var i = 0; i < this._facets.length; i++) {
        if (facet == this._facets[i]) {
            this._facets.splice(i, 1);
            if (facet.hasRestrictions()) {
                this._computeRestrictedItems();
                this._updateFacets(null);
                this._listeners.fire("onItemsChanged", []);
            }
            break;
        }
    }
};

Exhibit.Collection.prototype.clearAllRestrictions = function() {
    var restrictions = [];
    
    this._updating = true;
    for (var i = 0; i < this._facets.length; i++) {
        restrictions.push(this._facets[i].clearAllRestrictions());
    }
    this._updating = false;
    
    this.onFacetUpdated(null);
    
    return restrictions;
};

Exhibit.Collection.prototype.applyRestrictions = function(restrictions) {
    this._updating = true;
    for (var i = 0; i < this._facets.length; i++) {
        this._facets[i].applyRestrictions(restrictions[i]);
    }
    this._updating = false;
    
    this.onFacetUpdated(null);
};

Exhibit.Collection.prototype.getAllItems = function() {
    return new Exhibit.Set(this._items);
};

Exhibit.Collection.prototype.countAllItems = function() {
    return this._items.size();
};

Exhibit.Collection.prototype.getRestrictedItems = function() {
    return new Exhibit.Set(this._restrictedItems);
};

Exhibit.Collection.prototype.countRestrictedItems = function() {
    return this._restrictedItems.size();
};

Exhibit.Collection.prototype.onFacetUpdated = function(facetChanged) {
    if (!this._updating) {
        this._computeRestrictedItems();
        this._updateFacets(facetChanged);
        this._listeners.fire("onItemsChanged", []);
    }
}

Exhibit.Collection.prototype._onRootItemsChanged = function() {
    this._listeners.fire("onRootItemsChanged", []);
    
    this._computeRestrictedItems();
    this._updateFacets(null);
    
    this._listeners.fire("onItemsChanged", []);
};

Exhibit.Collection.prototype._updateFacets = function(facetChanged) {
    var restrictedFacetCount = 0;
    for (var i = 0; i < this._facets.length; i++) {
        if (this._facets[i].hasRestrictions()) {
            restrictedFacetCount++;
        }
    }
    
    for (var i = 0; i < this._facets.length; i++) {
        var facet = this._facets[i];
        if (facet.hasRestrictions()) {
            if (restrictedFacetCount <= 1) {
                facet.update(this.getAllItems());
            } else {
                var items = this.getAllItems();
                for (var j = 0; j < this._facets.length; j++) {
                    if (i != j) {
                        items = this._facets[j].restrict(items);
                    }
                }
                facet.update(items);
            }
        } else {
            facet.update(this.getRestrictedItems());
        }
    }
};

Exhibit.Collection.prototype._computeRestrictedItems = function() {
    this._restrictedItems = this._items;
    for (var i = 0; i < this._facets.length; i++) {
        var facet = this._facets[i];
        if (facet.hasRestrictions()) {
            this._restrictedItems = facet.restrict(this._restrictedItems);
        }
    }
};
