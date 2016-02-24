var labelType, useGradients, nativeTextSupport, animate;

(function() {
  var ua = navigator.userAgent,
      iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
      typeOfCanvas = typeof HTMLCanvasElement,
      nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
      textSupport = nativeCanvasSupport 
        && (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
  //I'm setting this based on the fact that ExCanvas provides text support for IE
  //and that as of today iPhone/iPad current text support is lame
  labelType = (!nativeCanvasSupport || (textSupport && !iStuff))? 'Native' : 'HTML';
  nativeTextSupport = labelType == 'Native';
  useGradients = nativeCanvasSupport;
  animate = !(iStuff || !nativeCanvasSupport);
})();

var Log = {
  elem: false,
  write: function(text){
    if (!this.elem) 
      this.elem = document.getElementById('log');
    this.elem.innerHTML = text;
    this.elem.style.left = (500 - this.elem.offsetWidth / 2) + 'px';
  }
};


function init(json, userSettings){
  // init data
    
  // end
  // init ForceDirected
  
  
  /*
  var settings = {
      "divID": "infovis",
      "edgeColor": "#23A4FF",
      "edgeWidth": 2,
      "edgeLength": 150,
      "navigation": true,
      "zooming": false,
      "panning": "avoid nodes",
      "labelcolor": "#000000"
  };
  */
  
  var settings = userSettings;
  var divID = '#progress-'+settings.d_id;
  var prg_bar = jQuery(divID);
  
  //alert(settings.edgeColor)
  
  var fd = new $jit.ForceDirected({
    //id of the visualization container
    injectInto: settings.divID,
    //Enable zooming and panning
    //by scrolling and DnD
    Navigation: {
      enable: settings.navigation,
      //Enable panning events only if we're dragging the empty
      //canvas (and not a node).
      panning: settings.panning,
      zooming: settings.zooming //zoom speed. higher is more sensible
    },
    // Change node and edge styles such as
    // color and width.
    // These properties are also set per node
    // with dollar prefixed data-properties in the
    // JSON structure.
    Node: {
      overridable: true,
      color: '#005588',
      dim: 7
    },
    Edge: {
      overridable: false,
      color: settings.edgeColor,
      lineWidth: settings.edgeWidth
    },
    //Native canvas text styling
    Label: {
      type: labelType, //Native or HTML
      size: 16,
      style: 'normal',
      textAlign: 'center',
      color: settings.labelColor
    },
    //Add Tips
    Tips: {
      enable: true,
      onShow: function(tip, node) {
        //count connections
        var count = 0;
        node.eachAdjacency(function() { count++; });
        //display node info in tooltip 
        
        var tipHTML = "<div class=\"tip-title\">" + node.name + "</div>"
          + "<div class=\"tip-text\"><b>connections:</b> " + count + "</div>"
          + "<div class=\"tip-text\"><ol>";
        
        
        var counter = 0;
        
        node.eachAdjacency(function(adj){
        	counter ++;
        	var nodeToName = adj.nodeTo.name;
        	var nodeFromName = adj.nodeFrom.name;
        	var edgeType = adj.nodeTo.getData("edgeType");
			tipHTML += "<li>"+nodeToName+"</li>";
			//tipHTML += "<li>Connection "+ counter +": "+nodeFromName +" "+ edgeType+" " +nodeToName+"</li>";
			//list.push(adj.nodeTo.name);
        });
        
		tipHTML += "</ol></div>";
        tip.innerHTML = tipHTML;
      }
    },
    // Add node events
    Events: {
      enable: true,
      type: 'Native',
      //Change cursor style when hovering a node
      onMouseEnter: function() {
        fd.canvas.getElement().style.cursor = '';
      },
      onMouseLeave: function() {
        fd.canvas.getElement().style.cursor = '';
      },
      //Update node positions when dragged
      onDragMove: function(node, eventInfo, e) {
          var pos = eventInfo.getPos();
          node.pos.setc(pos.x, pos.y);
          fd.plot();
      },
      //Implement the same handler for touchscreens
      onTouchMove: function(node, eventInfo, e) {
        $jit.util.event.stop(e); //stop default touchmove event
        this.onDragMove(node, eventInfo, e);
      },
      //Add also a click handler to nodes
      onClick: function(node) {
        if(!node) return;
        // Build the right column relations list.
        // This is done by traversing the clicked node connections.
        var html = "<h4>" + node.name + "</h4><b> connections:</b>",
            list = [];
        node.eachAdjacency(function(adj){
          list.push(adj.nodeTo.name);
        });
        
        //append connections information
        //$jit.id('inner-details').innerHTML = html + list.join("</li><li>") + "</li></ul>";
        window.location = node.getData("url");
      }
    },
    //Number of iterations for the FD algorithm
    iterations: 200,
    //Edge length
    levelDistance: settings.edgeLength,
    // Add text to the labels. This method is only triggered
    // on label creation and only for DOM labels (not native canvas ones).
    onCreateLabel: function(domElement, node){
      domElement.innerHTML = node.name;
      var style = domElement.style;
      style.fontSize = "0.8em";
      style.color = "#ddd";
    },
    // Change node styles when DOM labels are placed
    // or moved.
    onPlaceLabel: function(domElement, node){
      var style = domElement.style;
      var left = parseInt(style.left);
      var top = parseInt(style.top);
      var w = domElement.offsetWidth;
      style.left = (left - w / 2) + 'px';
      style.top = (top + 10) + 'px';
      style.display = '';
    }
  });
  // load JSON data.
  fd.loadJSON(json);
  // compute positions incrementally and animate.
  fd.computeIncremental({
    iter: 40,
    property: 'end',
    onStep: function(perc){
      //alert(divID);
      prg_bar.progressBar(perc);
      //alert(perc + '% loaded…');
      //Log.write(perc + '% loaded...');
    },
    onComplete: function(){
      //Log.write('done');
      prg_bar.progressBar(100);
      var divID = '#progress-'+settings.d_id;
      var t = setTimeout("jQuery('"+divID+"').hide('slow');", 3000);
      //var t = setTimeout("", 3000);
      fd.animate({
        modes: ['linear'],
        transition: $jit.Trans.Elastic.easeOut,
        duration: 3000
      });
    }
  });
  // end
}