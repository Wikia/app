// This code is originally from www.daltonlp.com,
// with slight modifications by EMM to make it suck less.

// global variables used for color selects

var mouse_x;
var mouse_y;
var color_selects = new Array(0);
var scrolling = true;

function set_scrolling() {
  scrolling = true;
}

function XBrowserAddHandler(target,eventName,handlerName) {
  if ( target.addEventListener ) {
    target.addEventListener(eventName, function(e){target[handlerName](e);}, false);
  } else if ( target.attachEvent ) {
    target.attachEvent("on" + eventName, function(e){target[handlerName](e);});
  } else {
    var originalHandler = target["on" + eventName];
    if ( originalHandler ) {
      target["on" + eventName] = function(e){originalHandler(e);target[handlerName](e);};
    } else {
      target["on" + eventName] = target[handlerName];
    }
  }
}

function generic_h_select_box_mousedown() {
  var id = this.id.match(/(.+?)_/);
  id = RegExp.$1;
  color_selects[id].h_select_box_mousedown();
}

function generic_h_select_box_mouseup() {
  var id="";
  if (this.id) id = this.id;

  var id = this.id.match(/(.+?)_/);
  id = RegExp.$1;
  color_selects[id].h_select_box_mouseup();
}

function generic_sv_select_box_mousedown() {
  var id = this.id.match(/(.+?)_/);
  id = RegExp.$1;
  color_selects[id].sv_select_box_mousedown();
}

function generic_sv_select_box_mouseup() {
  var id = this.id.match(/(.+?)_/);
  id = RegExp.$1;
  color_selects[id].sv_select_box_mouseup();
}

function generic_ok_button_click() {
  var id = this.id.match(/(.+?)_/);
  id = RegExp.$1;
  color_selects[id].hide();
}

function color_select(init_color) {
  this.id = color_selects.length;
  // current control position
  this.sv_image="";
  this.x=0;
  this.y=0;
  this.hexcolor="";

  // map methods

  // Time to get funky with the DOM.  Unh.

  // Create a DOM element to hold the color select
  this.color_select_box = document.createElement('div');     // the box around the entire color select
  this.color_select_box.id = this.id+"_color_select_box";
  this.color_select_box.className = "color_select_box";
  this.color_select_box.style.display = "none";

  //document.body.appendChild(this.color_select_box);
  document.getElementsByTagName("body").item(0).appendChild(this.color_select_box);

  // horizontal & vertical s-v cursors
  this.sv_crosshair_horiz_cursor = document.createElement('div');
  this.sv_crosshair_horiz_cursor.id = this.id+"_sv_crosshair_horiz_cursor";
  this.sv_crosshair_horiz_cursor.className = "sv_crosshair_horiz_cursor";
  this.sv_crosshair_horiz_cursor.style.visibility = "hidden";
  this.color_select_box.appendChild(this.sv_crosshair_horiz_cursor);

  this.sv_crosshair_vert_cursor = document.createElement('div');
  this.sv_crosshair_vert_cursor.id = this.id+"_sv_crosshair_vert_cursor";
  this.sv_crosshair_vert_cursor.className = "sv_crosshair_vert_cursor";
  this.sv_crosshair_vert_cursor.style.visibility = "hidden";
  this.color_select_box.appendChild(this.sv_crosshair_vert_cursor);

  // center s-v cursor
  this.sv_crosshair_center_cursor = document.createElement('div');
  this.sv_crosshair_center_cursor.id = this.id+"_sv_crosshair_center_cursor";
  this.sv_crosshair_center_cursor.className = "sv_crosshair_center_cursor";
  this.sv_crosshair_center_cursor.style.visibility = "hidden";
  this.color_select_box.appendChild(this.sv_crosshair_center_cursor);

  this.sv_select_box_bg = document.createElement('div');
  this.sv_select_box_bg.id = this.id+"_sv_select_box_bg";
  this.sv_select_box_bg.className = "sv_select_box_bg";
  this.color_select_box.appendChild(this.sv_select_box_bg);
  this.sv_select_box_bg.style.height="256px";
  this.sv_select_box_bg.style.width="256px";

  this.sv_select_box = document.createElement('div');
  this.sv_select_box.id = this.id+"_sv_select_box";
  this.sv_select_box.className = "sv_select_box";
  this.sv_select_box_bg.appendChild(this.sv_select_box);
  this.sv_select_box.style.height="256px";
  this.sv_select_box.style.width="256px";
  this.sv_select_box.mousedownHandler = generic_sv_select_box_mousedown;
  this.sv_select_box.mouseupHandler = generic_sv_select_box_mouseup;
  XBrowserAddHandler(this.sv_select_box,"mousedown","mousedownHandler");
  XBrowserAddHandler(this.sv_select_box,"mouseup","mouseupHandler");

  this.h_select_box = document.createElement('div');
  this.h_select_box.id = this.id+"_h_select_box";
  this.h_select_box.className = "h_select_box";
  this.h_select_box.mousedownHandler = generic_h_select_box_mousedown;
  this.h_select_box.mouseupHandler = generic_h_select_box_mouseup;
  XBrowserAddHandler(this.h_select_box,"mousedown","mousedownHandler");
  XBrowserAddHandler(this.h_select_box,"mouseup","mouseupHandler");
  this.color_select_box.appendChild(this.h_select_box);

  this.color_box = document.createElement('div');
  this.color_box.id = this.id+"_color_box";
  this.color_box.className = "color_box";
  this.color_select_box.appendChild(this.color_box);

  this.color_value_box = document.createElement('div');
  this.color_value_box.id = this.id+"_color_value_box";
  this.color_value_box.className = "color_value_box";
  this.color_box.appendChild(this.color_value_box);

  // ok button
  this.ok_button = document.createElement('div');
  this.ok_button.id = this.id+"_ok_button";
  this.ok_button.className = "ok_button";
  this.color_select_box.appendChild(this.ok_button);
  this.ok_button.innerHTML = "ok";

  this.ok_button.mouseupHandler = generic_ok_button_click;
  XBrowserAddHandler(this.ok_button,"mouseup","mouseupHandler");

  // hue cursor
  this.hue_cursor = document.createElement('div');
  this.hue_cursor.id = this.id+"_hue_cursor";
  this.hue_cursor.className = "hue_cursor";
  this.h_select_box.appendChild(this.hue_cursor);

  // used for mapping between mouse positions and color parameters
  this.hue_offset=0;
  this.sat_offset=0;
  this.val_offset=0;
  this.color_select_bounding_box = new Array(4);    // upper-left corner x, upper-left corner y, width, height

  // state information for the controls
  this.initialized=false;
  this.active=false;
  //alert('this should appear only twice! ' + this.id);
  this.h_select_box_focus=false;
  this.sv_select_box_focus=false;


  // function to call each time the color is updated
  this.change_update_function = "color_change_update";

  this.hide_update_function = "color_hide_update";

  this.attach_to_element = function(e)
  {
    this.x = docjslib_getRealLeft(e);
    this.y = docjslib_getRealTop(e) + 22;  // clumsy hack.  Won't work for elements higher than 22 px
  }


  this.h_select_box_mousedown = function()
  {
    this.h_select_box_focus = true;
    window.status='(h_select_box_mousedown) ('+mouse_x+','+mouse_y+') ' + this.id + " " + this.h_select_box_focus;
    this.hue_cursor_to_color();
    this.sv_update();
    color_select_update();
  }

  this.h_select_box_mouseup = function()
  {
    this.h_select_box_focus = false;
    //color_select_update(event);
  }

  this.sv_select_box_mousedown = function()
  {
    this.sv_select_box_focus = true;
    window.status='(sv_select_box_mousedown) ('+mouse_x+','+mouse_y+') ' + this.id + " " + this.sv_select_box_focus;
    this.sv_update();
    color_select_update();
  }

  this.sv_select_box_mouseup = function()
  {
    this.sv_select_box_focus = false;
  }

  // these functions are tied to events (usually).
  // they are the entry points for whatever color_select does

  this.show = function()
  {
    // alert ("show color select");
    this.color_select_bounding_box = new Array;

    // in mozilla, insert the saturation-value background image
    if (!document.all && this.sv_image)
      this.sv_select_box.style.backgroundImage = "url('"+this.sv_image+"')";

    // make them visible first so we can substract the position of
    // offsetParent
    this.color_select_box.style.visibility = "visible";
    this.color_select_box.style.display = "block";
    this.color_select_box.style.position = "absolute";
    this.color_select_box.style.left = this.x - docjslib_getRealLeft(this.color_select_box.offsetParent) + "px";
    this.color_select_box.style.top = this.y - docjslib_getRealTop(this.color_select_box.offsetParent) + "px";


    this.sat_offset = docjslib_getRealTop(this.sv_select_box);
    this.val_offset = docjslib_getRealLeft(this.sv_select_box);
    this.hue_offset = docjslib_getRealTop(this.h_select_box);

    this.color_select_bounding_box[0]=this.x;
    this.color_select_bounding_box[1]=this.y;
    this.color_select_bounding_box[2]=300;
    this.color_select_bounding_box[3]=300;

    this.sv_cursor_draw();

    // position hue cursor
    this.hue_cursor.style.left = docjslib_getRealLeft(this.h_select_box) - docjslib_getRealLeft(this.color_select_box)-1;
    this.hue_cursor_draw();

    this.initialized=true;
    this.active=true;
    if (!this.color_select_box.style)
      alert ("color select box style not found!");

    this.update_color_box();
    //alert ("new hsv: "+ this.hue_cursor_pos +" "+this.sat_cursor_pos+" "+this.val_cursor_pos);
    //alert (this.x + " " + this.y);
  }

  this.hide = function()
  {
    if (this.color_select_box)
      this.color_select_box.style.display = "none";

    this.active=false;
    this.unfocus();

    try {  // because the hide_update_function might not be defined
      if (self[this.hide_update_function])
        setTimeout(this.hide_update_function+"(\""+this.hexcolor+"\", \""+this.id+"\")",100);
    } catch (e) {}

  }


  this.toggle_color_select = function()
  {
    if (this.active)
      this.hide();
    else
      this.show();
  }


  this.select_disable = function()
  {
    // This function is IE-only!  Moz doesn't need it, and ignores it.
    // When the mouse is dragged, IE attempts to select the DOM objects,
    // which would be ok, but IE applies a dark highlight to the selection.
    // This makes the color select look flickery and bad.
    // The solution is to disable IE's selection event when it occurs when the mouse is over
    // the color select.

    // But that's not quite enough.  We *do* want to be able to select the #FFFFF hex
    // value.  So we only disable IE selection when the mouse is moving the s-v or hue
    // cursor.

    if (this.h_select_box_focus || this.sv_select_box_focus)
      return true;
    else
      return false;
  }

  this.hue_cursor_to_color = function()
  {
    //alert(this.h_select_box_focus);
    // map from the mouse position to the new hue value

    if (!this.h_select_box_focus) return;

    var new_hue_cursor_pos = mouse_y - this.hue_offset;
    //alert(new_hue_cursor_pos);

    // keep the value sensible
    if (new_hue_cursor_pos > 255)
      new_hue_cursor_pos=255;
    if (new_hue_cursor_pos < 0)
      new_hue_cursor_pos=0;

    this.hue_cursor_pos = new_hue_cursor_pos;
    this.hue_value = 360 - new_hue_cursor_pos/255*360;

    this.hue_cursor_draw();
    this.cursor_to_color();

  }

  this.sv_update = function()
  {
    // map from the mouse position to the new s-v values

    // might be possible to get rid of this
    if (!this.sv_select_box_focus) return;

    var new_sat_cursor_pos = mouse_y - this.sat_offset;
    var new_val_cursor_pos = mouse_x - this.val_offset;

    // keep the values sensible
    if (new_sat_cursor_pos > 255)
      new_sat_cursor_pos = 255;
    if (new_sat_cursor_pos < 0)
      new_sat_cursor_pos = 0;

    if (new_val_cursor_pos > 255)
      new_val_cursor_pos = 255;
    if (new_val_cursor_pos < 0)
      new_val_cursor_pos = 0;

    this.sat_cursor_pos = new_sat_cursor_pos;
    this.val_cursor_pos = new_val_cursor_pos;

    this.sv_cursor_draw();
    this.cursor_to_color();

    return;
  }

  this.hue_cursor_draw = function()
  {
    if (!this.hue_cursor.style) return;
    if (!this.sv_select_box_bg.style) return;

    this.hue_cursor.style.top = this.hue_cursor_pos+1 + "px";

    this.hue_cursor.style.visibility = "visible";

    // update sv_select_box background
    var hsvcolor = new Array(this.hue_value,1,255);
    var rgbcolor = hsv2rgb(hsvcolor);
    var new_color = "rgb("+rgbcolor[0]+", "+rgbcolor[1]+", "+rgbcolor[2]+")";
    this.sv_select_box_bg.style.background = new_color;
  }



  this.sv_cursor_draw = function()
  {
    if (!this.sv_crosshair_horiz_cursor.style) return;
    if (!this.sv_crosshair_vert_cursor.style) return;

    // this is sort of a seat-of-the-pants algorithm for keeping the cursor
    // visible against the s-v background.  There are probably better methods.
    var cursor_color=this.val_cursor_pos;
    if (cursor_color==0) cursor_color=.001;
    cursor_color = Math.round(255/(cursor_color/30));
    if (cursor_color > 255) cursor_color = 255;
    if (cursor_color < 0) cursor_color = 0;

    this.sv_crosshair_vert_cursor.style.backgroundColor = "rgb("+cursor_color+","+cursor_color+","+cursor_color+")";
    this.sv_crosshair_horiz_cursor.style.borderColor = "rgb("+cursor_color+","+cursor_color+","+cursor_color+")";

    // place the s-v cursors.
    this.sv_crosshair_horiz_cursor.style.top = this.sat_cursor_pos+3 + "px";
    this.sv_crosshair_horiz_cursor.style.left = 2 + "px";
    this.sv_crosshair_horiz_cursor.style.visibility = "visible";

    this.sv_crosshair_vert_cursor.style.left = this.val_cursor_pos+3 + "px";
    this.sv_crosshair_vert_cursor.style.visibility = "visible";

    //this.cursor_to_color();
    window.status = (this.sat_cursor_pos+3)+", "+(this.val_cursor_pos+3);

  }

  this.cursor_to_color = function()
  {
    //calculate real h, s & v
    this.hue_value = ((255-this.hue_cursor_pos)/255*360);
    this.sat_value = (255 - this.sat_cursor_pos)/255;
    //this.sat_value = this.sat_cursor_pos;
    this.val_value = this.val_cursor_pos;

    this.update_color_box();
  }


  this.unfocus = function()
  {
    this.sv_select_box_focus=false;
  }


  this.setrgb = function(c)
  {
    //  hsv:  h = 0-360    s = 0 (gray) - 1.0 (pure color)   v = 0 (black) to 255 (white)
    if (!c.match(/#([0-9]|[A-F]){6}/i))  // valid hex #color?
      return false;

    var rgb = hex2rgb(c.substring(1,7));

    hsv = rgb2hsv(rgb);

    this.sethsv(hsv[0],hsv[1],hsv[2]);

    return true;
  }


  this.sethsv = function(h, s, v)
  {
    var hsvcolor;

    this.hue_value = h;
    this.sat_value = s;
    this.val_value = v;

    this.hue_cursor_pos = (360 - this.hue_value)/360*255;
    this.sat_cursor_pos = Math.round(255 - 255*this.sat_value);
    this.val_cursor_pos = this.val_value;

    this.update_color_box();
  }

  this.update_color_box = function()
  {
    var hsvcolor = new Array(this.hue_value,this.sat_value,this.val_value);

    // make them into an rgb color
    var rgbcolor = hsv2rgb(hsvcolor);

    var new_color = "rgb("+rgbcolor[0]+","+rgbcolor[1]+","+rgbcolor[2]+")";

    // and in hex
    this.hexcolor = "#"+baseconverter(rgbcolor[0],10,16,2)+baseconverter(rgbcolor[1],10,16,2)+baseconverter(rgbcolor[2],10,16,2);

    try {  // because the change_update_function might not be defined
      if (self[this.change_update_function])
        setTimeout(this.change_update_function+"(\""+this.hexcolor+"\", \""+this.id+"\")",100);

    } catch (e) {}

    // display it!
    if (this.color_value_box)
      this.color_value_box.innerHTML = this.hexcolor;

    if (this.color_value_box.style)
      this.color_box.style.background = new_color;
  }

  // push the new color select object onto the
  // global array of color select objects.

  // for some reason, the array.push() method
  // doesn't work with objects, only with primitives.

    // initial values
  if (init_color)
    this.setrgb(init_color)
  else
    this.setrgb("#ffffff");

  color_selects[color_selects.length] = this;
}

function color_select_mousedown(event) {
  var cs_active = false;

  for (var l1=0;l1<color_selects.length;l1++)
  {
    var ob = color_selects[l1];
    if (!ob.active) continue;
    cs_active = true;

    // if the mousedown is outside the color_select_box, close it.
    if  (mouse_x < ob.color_select_bounding_box[0] ||
        mouse_y < ob.color_select_bounding_box[1] ||
        mouse_x > (ob.color_select_bounding_box[0]+ob.color_select_bounding_box[2]) ||
        mouse_y > (ob.color_select_bounding_box[1]+ob.color_select_bounding_box[3]))
    {

      scrolling = false;
      setTimeout("color_select_hide("+l1+")",200);
    }
  }

  if (cs_active && event)
  {
    if (event.cancelBubble)
      event.cancelBubble = true;
    else
    {
      if (event.stopPropagation) event.stopPropagation();
      if (event.preventDefault) event.preventDefault();
    }
  }

}

function color_select_hide(num)
{
  if (!scrolling)
    color_selects[num].hide();
  else
    scrolling = false;
}


function color_select_hideall()
{
  //alert("hiding all color selects!");
  for (var l1=0;l1<color_selects.length;l1++)
    color_selects[l1].hide();
}


function color_select_mouseup() {
  //alert('(color_select_mouseup)');

  for (var l1=0;l1<color_selects.length;l1++)
  {
    ob=color_selects[l1];
    ob.unfocus();
    scrolling = false;
  }
}

function get_mouse_coords(e) {
  if (window.getSelection) {  // Moz
    mouse_x=e.pageX;
    mouse_y=e.pageY;
  } else if (document.selection && document.selection.createRange) { // IE
    if (document.documentElement.scrollTop)   // Explorer 6 Strict
    {
      mouse_x = window.event.clientX + document.documentElement.scrollLeft - 4;
      mouse_y = window.event.clientY + document.documentElement.scrollTop - 4;
    }
    else if (document.body) // all other Explorers
    {
      mouse_x=window.event.clientX+document.body.scrollLeft-4;
      mouse_y=window.event.clientY+document.body.scrollTop-4;
    }
  } else { // out of luck below v.4
    var str = "";
    window.status="Sorry, event capture is not possible with your browser.";
    return;
  }
}

function get_mouse_coords_old(e) {
  if (window.event) // IE
  {
    mouse_x=window.event.clientX+document.body.scrollLeft;
    mouse_y=window.event.clientY+document.body.scrollTop;
  }
  else              // moz
  {
    mouse_x=e.pageX;
    mouse_y=e.pageY;
  }
}

function color_select_update(event) {
  var cs_active = false;

  //window.status = color_selects.length+" color selects";
  for (var l1=0;l1<color_selects.length;l1++)
  {
    ob = color_selects[l1];
    if (ob.active) cs_active = true;
    ob.sv_update();
    ob.hue_cursor_to_color();
  }

  if (event && cs_active)
  {
    if (event.cancelBubble)
      event.cancelBubble = true;
    else
    {
	    if (event.stopPropagation) event.stopPropagation();
      if (event.preventDefault) event.preventDefault();
    }
  }
}


// below are miscellanous conversion functions.  Some of them
// are modified versions of someone else's code.

function findowner(evt)
{
  if (evt.target)
    return evt.target;
  else if (evt.srcElement)
    return evt.srcElement;
  else
    return null;
}


function baseconverter (number,ob,nb,desired_length)
{
  // Created 1997 by Brian Risk.  http://members.aol.com/brianrisk
  number += "";  // convert to character, or toUpperCase will fail on some browsers
  number = number.toUpperCase();
  var list = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  var dec = 0;
  for (var i = 0; i <=  number.length; i++)
    dec += (list.indexOf(number.charAt(i))) * (Math.pow(ob , (number.length - i - 1)));
  number = "";
  var magnitude = Math.floor((Math.log(dec))/(Math.log(nb)));
  for (var i = magnitude; i >= 0; i--)
  {
    //--  stupid nedit, thinks the decrement above is a html commment.
    var amount = Math.floor(dec/Math.pow(nb,i));
    number = number + list.charAt(amount);
    dec -= amount*(Math.pow(nb,i));
  }

  var length=number.length;
  if (length<desired_length)
    for (var i=0;i<desired_length-length;i++)
      number = "0"+number;

  return number;
}

function docjslib_getRealTop(imgElem) {
  yPos = imgElem.offsetTop;
  tempEl = imgElem.offsetParent;
  while (tempEl != null) {
    yPos += tempEl.offsetTop;
    tempEl = tempEl.offsetParent;
  }
  return yPos;
}

function docjslib_getRealLeft(imgElem) {
  xPos = imgElem.offsetLeft;
  tempEl = imgElem.offsetParent;
    while (tempEl != null) {
      xPos += tempEl.offsetLeft;
      tempEl = tempEl.offsetParent;
    }
  return xPos;
}

// RGB, each 0 to 255
//  hsv:  h = 0-360    s = 0 (gray) - 1.0 (pure color)   v = 0 (black) to 255 (white)
function rgb2hsv(rgb) {
  var r = rgb[0];
  var g = rgb[1];
  var b = rgb[2];

  var h;
  var s;
  var v = Math.max(Math.max(r, g), b);
  var min = Math.min(Math.min(r, g), b);
  var delta = v - min;

   // Calculate saturation: saturation is 0 if r, g and b are all 0
  if (v == 0)
    s = 0
  else
    s = delta / v;

  if (s==0)
    h=0;  //achromatic.  no hue
  else
  {
    if (r==v)            // between yellow and magenta [degrees]
      h=60*(g-b)/delta;
    else if (g==v)       // between cyan and yellow
      h=120+60*(b-r)/delta;
    else if (b==v)       // between magenta and cyan
      h=240+60*(r-g)/delta;
  }

  if (h<0)
    h+=360;

  return new Array(h,s,v);
}

// RGB, each 0 to 255
//  hsv:  h = 0-360    s = 0 (gray) - 1.0 (pure color)   v = 0 (black) to 255 (white)
function hsv2rgb(hsv) {
  var h = hsv[0];
  var s = hsv[1];
  var v = hsv[2];

  var r;
  var g;
  var b;

  if (s==0) // achromatic (grey)
    return new Array(v,v,v);

  var htemp;

  if (h==360)
    htemp=0;
  else
    htemp=h;

  htemp=htemp/60;
  var i = Math.floor(htemp);   // integer <= h
  var f = htemp - i;           // fractional part of h

  var p = v * (1-s);
  var q = v * (1-(s*f));
  var t = v * (1-(s*(1-f)));

  if (i==0) {r=v;g=t;b=p;}
  if (i==1) {r=q;g=v;b=p;}
  if (i==2) {r=p;g=v;b=t;}
  if (i==3) {r=p;g=q;b=v;}
  if (i==4) {r=t;g=p;b=v;}
  if (i==5) {r=v;g=p;b=q;}

  r=Math.round(r);
  g=Math.round(g);
  b=Math.round(b);

  return new Array(r,g,b);

}

function hex2rgb(h) {

  h = h.replace(/#/,'');
  // RGB, each 0 to 255
  var r = Math.round(parseInt(h.substring(0,2),16));
  var g = Math.round(parseInt(h.substring(2,4),16));
  var b = Math.round(parseInt(h.substring(4,6),16));
  //alert("hex2rgb: "+h+" "+r+" "+g+" "+b);

	var results = new Array(r,g,b);
  return results;
}

function move_test()
{
  alert("move test");
}

function color_select_unfocus()
{
  for (var l1=0;l1<color_selects.length;l1++)
  {
    ob=color_selects[l1];
    ob.unfocus();
  }
}

function cs_select_disable()
{
  for (var l1=0;l1<color_selects.length;l1++)
  {
    ob=color_selects[l1];
    if (ob.select_disable())
      return false;
  }
}

// hook up the appropriate browser events.
if (document.attachEvent)                 // IE uses proprietary event model
{
  document.attachEvent('onmousedown',color_select_mousedown);
  document.attachEvent('onmouseup',color_select_mouseup);
  document.attachEvent('onmouseup',color_select_unfocus);
  document.attachEvent('onmousemove',get_mouse_coords);
  document.attachEvent('onmousemove',color_select_update);
  document.attachEvent('onselectstart',cs_select_disable);  // this event is IE-only
  document.attachEvent('onscroll',set_scrolling);
}
else                                      // Moz uses W3C DOM event model
{
  document.addEventListener('scroll', set_scrolling, false);
  document.addEventListener('resize',color_select_mousedown, false);
  document.addEventListener('mousedown', color_select_mousedown, false);
  document.addEventListener('mouseup', color_select_mouseup, false);
  document.addEventListener('mousemove', get_mouse_coords, false);
  document.addEventListener('mousemove', color_select_update, false);
  document.addEventListener('resize', color_select_hideall, false);
}
