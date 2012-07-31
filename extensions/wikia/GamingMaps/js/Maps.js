var Maps = {
  init:function (objCallBack) {

    console.log(objCallBack);

    var defMarkers = objCallBack.defMarkers; //definition marks and layers
    var IMGname = objCallBack.attr.img; //Img map
    var overlayMaps = {}; //empty object is used for puting layers on map
    var baseLayers; //base layers, radiobuttons, only one layer trun on
    var aMarkers = objCallBack.markers; // get from content markers to generate
    var Layers = new Array(); // array object layers
    var popup = new L.Popup();
    var aPolygons = objCallBack.polygons;
    //console.log(objCallBack);
    var map = new L.Map('map', {
      worldCopyJump:false
    }); // generet object map with options, worldCopyJump disable autoposition

    var LeafIcon = L.Icon.extend({ // create icon with options
      iconUrl: defMarkers[defMarkers.length-1][2],
      iconSize: new L.Point(35, 35),
      shadowSize: new L.Point(0, 0),
      iconAnchor: new L.Point(8,8),
      popupAnchor: new L.Point(1, -6)
    });

    for(var i=0; i<defMarkers.length;i++)
    {
      create_layer(defMarkers[i]);
    }

    for (var i in aMarkers) { // genereate each markers
      create_marker(aMarkers[i],map);
    }

    for(var i in aPolygons){
      create_polygon(aPolygons[i],map);
    }

    add_layer_to_map();

    // function get size of object
    Object.size = function(obj) {
      var size = 0, key;
      for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
      }
      return size;
    };

    // check if layer group has markers
    for(var i=0; i<Layers.length; i++){
      var name = Layers[i].sLayerName;
      if(Object.size(Layers[i].group._layers)>0){
        overlayMaps[name] = Layers[i].group;
      }
    }

    var layersControl = new L.Control.Layers(baseLayers,overlayMaps); // adding control layers (righttop panel)
    map.addControl(layersControl);


   /* aIMGname = IMGname.split('.');

    IMGname = aIMGname[0]+'1.'+aIMGname[1];*/


    console.log()

    var cloudmadeUrl = wgServer + '/wikia.php?controller=GamingMaps&method=getTile&x={x}&y={y}&z={z}&imgName='+IMGname+'&revision=123', // location images for map
      cloudmadeAttribution = objCallBack.attr.name,
      cloudmade = new L.TileLayer(cloudmadeUrl, {
        attribution: cloudmadeAttribution,
        continuousWorld: false,
        maxZoom: 10,
        minZoom: 1,
        noWrap:true,
        tileSize: 256,
        reuseTiles: true
      });

    // set view start position on map
    map.setView(new L.LatLng(0.0, 0.0), 1).addLayer(cloudmade);

    function get_popup_content(title, callback){
      //return wgServer + '/wikia.php?controller=GamingMaps&method=getForMap&title='+ title;
      $.nirvana.sendRequest({
        controller: 'GamingMaps',
        method: 'getForMap',
        format: 'html',
        type: 'get',
        data: {title: title},
        callback: callback
      } );
    }

    // iMarkerX, iMarkerY, sMarkerType, sMarkenName, sMarkerLink <- structur array aMarkers
    function create_marker(aMarker, map) {
      var markerLocation = new L.LatLng(convert_Y_intoR(aMarker.lat), convert_X_intoR(aMarker.lon)),
        marker = new L.Marker(markerLocation, {icon:set_marker_Icon(aMarker.id)}); // dynamic set icon and add marker to layer
      set_marker_Icon(aMarker.id, marker);
      if(aMarker.title.length>0){
        get_popup_content(aMarker.title,function(html){
          marker.bindPopup(html);
          });
      }else{
        marker.bindPopup(aMarker.content);
      }
      //marker.bindPopup("<b>" + aMarker[3]); // message in popup, get from <gamingmaps>'s contet
    }

    // function create Layers Object
    function create_layer(defMarkLayer){
      if(!layer_exist(defMarkLayer.name))
      {
        var newLayer = new Object();
        newLayer.sLayerName = defMarkLayer.name;
        newLayer.Icon = new Array(defMarkLayer.id, new LeafIcon(defMarkLayer.img));
        newLayer.group = new L.LayerGroup();
        newLayer.view = defMarkLayer.view;
        Layers.push(newLayer);
      }
    }

    function layer_exist(name){
      for(var j=0; j<Layers.length; j++)
      {
        if(Layers[j]==name)
        {
          return true;
        }
      }
      return false;
    }

    // function to set icon and layers marker
    function set_marker_Icon(type, marker)
    {
      var icon;
      var flaga = false;
      for(var i= 0; i<Layers.length; i++){
        if(Layers[i].Icon[0]==type){
          flaga = true;
          icon = Layers[i].Icon[1];
          if(marker)Layers[i].group.addLayer(marker);
          break;
        }
      }
      if(flaga==false){
        icon = Layers[Layers.length-1].Icon[1];
        if(marker)Layers[Layers.length-1].group.addLayer(marker);
      }
      return icon;
    }

    function create_polygon(polygon, map){
      var polygonLocation = polygon[1];
      for(var i=0; i<polygonLocation.length; i++)
      {
        polygonLocation[i] = new L.LatLng(convert_Y_intoR(polygonLocation[i][0]), convert_X_intoR(polygonLocation[i][1]));
      }
      var newPolygon = new L.Polygon(polygonLocation , {stroke: true});
      newPolygon.bindPopup("<b>" + polygon[2]);
      set_polygon_Layer(polygon[0], newPolygon);
    }

    function set_polygon_Layer(type, polygon)
    {
      var flaga = false;
      for(var i= 0; i<Layers.length; i++){
        if(Layers[i].Icon[0]==type){
          flaga = true;
          Layers[i].group.addLayer(polygon);
          break;
        }
      }
      if(flaga==false){
        Layers[Layers.length-1].group.addLayer(polygon);
      }
    }

    function add_layer_to_map(){
      for(var i=0; i<Layers.length; i++){
        if(Layers[i].view=="true")
        {
          map.addLayer(Layers[i].group);
        }
      }
    }

    // function for convert lat and lng markers
    // conver x and y to 180 360
    function convert_Y_intoR(x)
    {
      var wynik;
      if(x>50)
      {
        x = 100-x;
        wynik = 8*Math.pow(10,-18)*Math.pow(x,6) + 2*Math.pow(10,-7)*Math.pow(x,5) - 5*Math.pow(10,-5)*Math.pow(x,4) + 0.0041*Math.pow(x,3) - 0.0961*Math.pow(x,2) + 1.5035*x - 90.093;
        wynik = wynik*(-1);
      }else{
        wynik = 8*Math.pow(10,-18)*Math.pow(x,6) + 2*Math.pow(10,-7)*Math.pow(x,5) - 5*Math.pow(10,-5)*Math.pow(x,4) + 0.0041*Math.pow(x,3) - 0.0961*Math.pow(x,2) + 1.5035*x - 90.093;
        if(x==50)
        {
          wynik=wynik-7;
        }
      }

      //console.log(x + "  " + wynik);

      return  wynik.toFixed(3);
    }

    function convert_X_intoR(x)
    {
      return  (((x/100)*360) -180).toFixed(3);
    }

    // convert x and y to % of the map
    function convert_X_intoPr(x)
    {
      if(x<0)
      {
        x = 180 + parseFloat(x);
      }else{
        x= parseFloat(x) +180;
      }
      return ((x/360)*100).toFixed(3);
    }

    function convert_Y_intoPr(x)
    {




      if(parseFloat(x)>0)
      {
        wynik = 8*Math.pow(10,-22)*Math.pow(x,6) + 3*Math.pow(10,-9)*Math.pow(x,5) - 2*Math.pow(10,-16)*Math.pow(x,4) +1*Math.pow(10,-5)*Math.pow(x,3) -2*Math.pow(10,-11)*Math.pow(x,2) + 0.2891*x + 50;
      }else{
        wynik = 8*Math.pow(10,-22)*Math.pow(x,6) + 3*Math.pow(10,-9)*Math.pow(x,5) - 2*Math.pow(10,-16)*Math.pow(x,4) +1*Math.pow(10,-5)*Math.pow(x,3) -2*Math.pow(10,-11)*Math.pow(x,2) + 0.2891*x + 50;
        if(parseFloat(x)==0)
        {
          wynik=parseFloat(wynik)-7;
        }
      }

      if(wynik>100)
      {
        wynik=100;
      }

      if(wynik<0){
        wynik=0;
      }

      return wynik.toFixed(3);

     /* var wynik = 8*Math.pow(10,-22)*Math.pow(x,6) + 3*Math.pow(10,-9)*Math.pow(x,5) - 2*Math.pow(10,-16)*Math.pow(x,4) +1*Math.pow(10,-5)*Math.pow(x,3) -2*Math.pow(10,-11)*Math.pow(x,2) + 0.2891*x + 50;
      if(wynik>100)
      {
        wynik=100;
      }
      if(wynik<0){
        wynik=0;
      }
      if(x==50){
        wynik=wynik-7;
      }
      return wynik.toFixed(3);*/
    }

    // helper for users, show popup with % codrs of map, used for coretly put markers
    map.on('click', onMapClick);

    function onMapClick(e) {
      var pY = convert_Y_intoPr(e.latlng.lat.toFixed(3));
      var pX = convert_X_intoPr(e.latlng.lng.toFixed(3));

      var latlngStr = "(  lat='" + pY + "' lon='" + pX  + "'  )";
      popup.setLatLng(e.latlng);
      popup.setContent("You clicked the map at " + latlngStr);
      map.openPopup(popup);
    }
    // disable default set view when popup is open
    var flaga = false;
    map.on('popupopen', function(e){
      flaga = true;
    })
    map.on('popupclose', function(e){
      flaga = false;
    })
    // function used for setting default viev map when user go out bounds
    map.on('moveend', function(e){
      if(!(map.getZoom()!=1) && !flaga)
      {
        map.setView(new L.LatLng(0.0, 0.0), 1).addLayer(cloudmade);
      }
    })

    map.on('moveend', function(e){
      if(!(map.getZoom()!=1) && !flaga)
      {
        map.setView(new L.LatLng(0.0, 0.0), 1).addLayer(cloudmade);
      }
    })
  }
  //wgArticlePath.replace('$1',wgPageName);
};