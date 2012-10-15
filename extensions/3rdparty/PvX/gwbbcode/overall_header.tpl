<style type="text/css">
<!--
.translucent 
{
  background:#161411;   /* Needed there so that following background classes can overide it */
  filter:alpha(opacity=93,style=0);
  -moz-opacity:.93;
  opacity:.93;
  padding: 5px;
  width: 460px;   /* Needed otherwise Nosebleed blows the popup up */
  height: auto;
}

.skill_link {color: #0000FF;}

.gwno_border {padding: 0; margin: 0;}
table.gwborder {width: 466px;}
img.no_link {border: none;}
.table_image {vertical-align: top; text-align: center; font-size: 10pt; padding-right: 10px;}
.skill_text {vertical-align: top;}
.skill_name {font-size: 15px; font-weight: 700; color: #bfb38b; float: left;}
.skill_desc {text-align: left; font-size: 11px; color: white; line-height: 20px; clear: both; display: block; padding-top: 5px;}
.skill_camp {font-weight: bold; color: #aad38b; font-size: 9px;}
.skill_pve {color: #b0b080; font-size: 9px;}
.expert {color: #A1AEFF; padding-left: 2px;}
.elite_skill {background-color: #6B6226;}
.normal_skill {background-color: #161411;}

.build_name {text-align: left; font-size: 11pt; font-weight: 700; color: #bfb38b; padding-bottom: 5px;}
.build_desc {text-align: left; font-size: 11px; color: white; line-height: 20px;}
.build_lilname {font-size: 10px; padding: 0px; line-height: 12px;}
.attribute {padding-left: 20px; font-size: 12px; color: white; line-height: 20px;}

.skill_requirements {display: inline; padding: 0; margin: 0; list-style-type: none;}
.skill_requirements li {display: inline; float: right; margin-right: 5px; font-weight: bold; font-size: 12px; color: white;}
span.variable {color: #88FF88; font-weight: bold;}


.table_image, .skill_name, .skill_desc, .skill_camp, .expert, .build_name, .build_desc, .attribute, .skill_requirements, .skill_requirements li, span.variable {
   font-family: verdana, Helvetica, sans-serif;
}

/* Border declarations for Build tooltips by Kills Less */
.gwborder_topleft {background-image: url({gwbbcode_root_path}/img_border/topleft.gif); width: 3px; height: 3px;}
.gwborder_top {background-image: url({gwbbcode_root_path}/img_border/top.gif); height: 3px;}
.gwborder_topright {background-image: url({gwbbcode_root_path}/img_border/topright.gif); width: 3px; height: 3px;}
.gwborder_left {background-image: url({gwbbcode_root_path}/img_border/left.gif); width: 3px;}
.gwborder_right {background-image: url({gwbbcode_root_path}/img_border/right.gif); width: 3px;}
.gwborder_bottomleft {background-image: url({gwbbcode_root_path}/img_border/bottomleft.gif); width: 3px; height: 3px;}
.gwborder_bottom {background-image: url({gwbbcode_root_path}/img_border/bottom.gif); height: 3px;}
.gwborder_bottomright {background-image: url({gwbbcode_root_path}/img_border/bottomright.gif); width: 3px; height: 3px;}

/* Build Box declarations by Kills Less */
table.gwbuildbox {height: 50px;}
.gwbuildbox_left {filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled='true', sizingMethod='scale', src='{gwbbcode_root_path}/img_border/buildbox_left.png'); width:20px; height: 50px;}
.gwbuildbox_right {filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled='true', sizingMethod='scale', src='{gwbbcode_root_path}/img_border/buildbox_right.png'); width:20px; height: 50px;}
.gwbuildbox_left[class] {background-image: url({gwbbcode_root_path}/img_border/buildbox_left.png); background-repeat: no-repeat; width: 20px; height: 50px}
.gwbuildbox_center {background-image: url({gwbbcode_root_path}/img_border/buildbox_center.png); height: 50px}
.gwbuildbox_right[class] {background-image: url({gwbbcode_root_path}/img_border/buildbox_right.png); background-repeat: no-repeat; width: 20px; height: 50px}


/* Needed otherwise Nosebleed blows the popup up */
table.gwborders {width: 470px;}

/* This is where you can customize the appearance of the tooltip */
div#overDiv {
  position:absolute; visibility:hidden; z-index:10000;
}
-->
</style>

<script type="text/javascript" src="{gwbbcode_root_path}/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>



<script type="text/javascript">
var prevX, prevY, prevId=0, clicked=false, new_click=true, sav_event, d=document;

function switchDiv(id, frame, load) {
   // Initialize menu and loading frame sources
   var menu = iniMenu(frame);

   if(load == menu.alt)
      // Switch from visible to hidden and back if we clicked on that icon before
      menu.style.display = (menu.style.display=="none")?"":"none";
   else
      initDescription(frame, load);
   menu.alt = load;
};

function initDescription(frame, load) {
   // Copy a new description and show it
   var menu = iniMenu(frame);

   if(document.getElementById && !(d.all))
      menu.innerHTML = d.getElementById('load'+load).innerHTML;
   else if(d.all)
      menu.innerHTML = d.frames['load'+load].innerHTML;

   menu.style.display = "";
};


//PICKUP
////////

function pickup(action, id) {
   //Update database
   div('send').src = '{gwbbcode_root_path}/pickup.php?'+action+'='+id+'&rand=' + Math.round(1000*Math.random());

   //Switch between Add and Remove links
   if (action != 'switch') {
      var opp_action = (action=='remove') ? 'add' : 'remove';
      div(action+'_'+id).style.display = 'none';
      div(opp_action+'_'+id).style.display = '';
   }
}

function pickup_set(userlist, id) {
   var divs = document.getElementsByTagName('span');
   for (var i=0; i<divs.length; i++)
      if ((typeof(divs[i].id) != 'undefined') && (divs[i].id == 'pickup_'+id))
         divs[i].innerHTML = userlist;
}


function iniMenu(frame) {
   if(d.getElementById && !(d.all))
      return d.getElementById('show'+frame);
   else if(d.all)
      return d.all['show'+frame];
};

function div(name) {
   var d = document;
   if(d.getElementById && !(d.all))
      return d.getElementById(name);
   else if(d.all)
      return d.all[name];
};


//TEMPLATE

function switch_template(load) {
   var style = div('gws_template'+load).style;
   if (style.display == 'none') {
      //Show selected template code
      style.display = '';
      div('gws_template_input'+load).select();
      div('gws_template_input'+load).focus();
      //and hide all others
      var divs = document.getElementsByTagName('DIV');
      for (var i=0; i<divs.length; i++) {
         if (   /^gws_template[0-9]/.test(divs[i].id)
             && divs[i].id != 'gws_template'+load
             && divs[i].style.display == '') {
            switch_template(divs[i].id.match(/\d+/)[0]);
         }
      }
   }
   else {
      style.display = 'none';
   }
   return false;
}


//JavaScript Function by Shawn Olson
//Copyright 2004
//http://www.shawnolson.net
//If you copy any functions from this page into your scripts, you must provide credit to Shawn Olson & http://www.shawnolson.net
//*******************************************

function change_css(theClass,element,value) {
   //documentation for this script at http://www.shawnolson.net/a/503/
   var cssRules;
   if (document.all)
      cssRules = 'rules';
   else if (document.getElementById)
      cssRules = 'cssRules';

   for (var S = 0; S < document.styleSheets.length; S++)
      for (var R = 0; R < document.styleSheets[S][cssRules].length; R++)
         if (document.styleSheets[S][cssRules][R].selectorText == theClass)
            document.styleSheets[S][cssRules][R].style[element] = value;
}
</script>

