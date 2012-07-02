function wHELPERS(){
}
wHELPERS.prototype.addEvent=function(_1,_2,fn){
if(!_1){
return;
}
if(_1.attachEvent){
_1["e"+_2+fn]=fn;
_1[_2+fn]=function(){
_1["e"+_2+fn](window.event);
};
_1.attachEvent("on"+_2,_1[_2+fn]);
}else{
if(_1.addEventListener){
_1.addEventListener(_2,fn,false);
}else{
var _4=_1["on"+_2];
if(_4){
_1["on"+_2]=function(e){
_4(e);
fn(e);
};
}else{
_1["on"+_2]=fn;
}
}
}
};
wHELPERS.prototype.removeEvent=function(_6,_7,fn){
if(_6.detachEvent){
_6.detachEvent("on"+_7,_6[_7+fn]);
_6[_7+fn]=null;
}else{
if(_6.removeEventListener){
_6.removeEventListener(_7,fn,false);
}else{
_6["on"+_7]=null;
}
}
};
wHELPERS.prototype.getSourceElement=function(e){
if(!e){
e=window.event;
}
if(e.target){
var _a=e.target;
}else{
var _a=e.srcElement;
}
if(!_a){
return null;
}
if(_a.nodeType==3){
_a=_a.parentNode;
}
if(_a.tagName.toUpperCase()=="LABEL"&&e.type=="click"){
if(_a.getAttribute("for")){
_a=document.getElementById(_a.getAttribute("for"));
}
}
return _a;
};
wHELPERS.prototype.preventEvent=function(e){
if(!e){
e=window.event;
}
if(e.preventDefault){
e.preventDefault();
}else{
e.returnValue=false;
}
return false;
};
wHELPERS.prototype.stopPropagation=function(e){
if(!e){
var e=window.event;
}
e.cancelBubble=true;
if(e.stopPropagation){
e.stopPropagation();
}
};
wHELPERS.prototype.randomId=function(){
var _d=(new Date()).getTime();
_d=_d.toString().substr(6);
for(var i=0;i<6;i++){
_d+=String.fromCharCode(48+Math.floor((Math.random()*10)));
}
return "id-"+_d;
};
wHELPERS.prototype.activateStylesheet=function(_f){
if(document.getElementsByTagName){
var ss=document.getElementsByTagName("link");
}else{
if(document.styleSheets){
var ss=document.styleSheets;
}
}
for(var i=0;ss[i];i++){
if(ss[i].href.indexOf(_f)!=-1){
ss[i].disabled=true;
ss[i].disabled=false;
}
}
};
wHELPERS.prototype.hasClass=function(_12,_13){
if(_12&&_12.className){
if((" "+_12.className+" ").indexOf(" "+_13+" ")!=-1){
return true;
}
}
return false;
};
wHELPERS.prototype.hasClassPrefix=function(_14,_15){
if(_14&&_14.className){
if((" "+_14.className).indexOf(" "+_15)!=-1){
return true;
}
}
return false;
};
wHELPERS.prototype.getTop=function(obj){
var cur=0;
if(obj.offsetParent){
while(obj.offsetParent){
if((new wHELPERS()).getComputedStyle(obj,"position")=="relative"){
return cur;
}
cur+=obj.offsetTop;
obj=obj.offsetParent;
}
}
return cur;
};
wHELPERS.prototype.getLeft=function(obj){
var cur=0;
if(obj.offsetParent){
while(obj.offsetParent){
if((new wHELPERS()).getComputedStyle(obj,"position")=="relative"){
return cur;
}
cur+=obj.offsetLeft;
obj=obj.offsetParent;
}
}
return cur;
};
wHELPERS.prototype.getComputedStyle=function(_1a,_1b){
if(window.getComputedStyle){
return window.getComputedStyle(_1a,"").getPropertyValue(_1b);
}else{
if(_1a.currentStyle){
return _1a.currentStyle[_1b];
}
}
return false;
};
var wHelpers=wHELPERS;
if(!Array.prototype.push){
Array.prototype.push=function(){
for(var i=0;i<arguments.length;++i){
this[this.length]=arguments[i];
}
return this.length;
};
}
var Fat={make_hex:function(r,g,b){
r=r.toString(16);
if(r.length==1){
r="0"+r;
}
g=g.toString(16);
if(g.length==1){
g="0"+g;
}
b=b.toString(16);
if(b.length==1){
b="0"+b;
}
return "#"+r+g+b;
},fade_element:function(id,fps,_22,_23,to){
if(!fps){
fps=30;
}
if(!_22){
_22=3000;
}
if(!_23||_23=="#"){
_23="#FFFF33";
}
if(!to){
to=this.get_bgcolor(id);
}
var _25=Math.round(fps*(_22/1000));
var _26=_22/_25;
var _27=_26;
var _28=0;
if(_23.length<7){
_23+=_23.substr(1,3);
}
if(to.length<7){
to+=to.substr(1,3);
}
var rf=parseInt(_23.substr(1,2),16);
var gf=parseInt(_23.substr(3,2),16);
var bf=parseInt(_23.substr(5,2),16);
var rt=parseInt(to.substr(1,2),16);
var gt=parseInt(to.substr(3,2),16);
var bt=parseInt(to.substr(5,2),16);
var r,g,b,h;
while(_28<_25){
r=Math.floor(rf*((_25-_28)/_25)+rt*(_28/_25));
g=Math.floor(gf*((_25-_28)/_25)+gt*(_28/_25));
b=Math.floor(bf*((_25-_28)/_25)+bt*(_28/_25));
h=this.make_hex(r,g,b);
setTimeout("Fat.set_bgcolor('"+id+"','"+h+"')",_27);
_28++;
_27=_26*_28;
}
setTimeout("Fat.set_bgcolor('"+id+"','"+to+"')",_27);
},set_bgcolor:function(id,c){
var o=document.getElementById(id);
if(o){
o.style.backgroundColor=c;
}
},get_bgcolor:function(id){
var o=document.getElementById(id);
while(o){
var c;
if(window.getComputedStyle){
c=window.getComputedStyle(o,null).getPropertyValue("background-color");
}
if(o.currentStyle){
c=o.currentStyle.backgroundColor;
}
if((c!=""&&c!="transparent")||o.tagName=="BODY"){
break;
}
o=o.parentNode;
}
if(c==undefined||c==""||c=="transparent"){
c="#FFFFFF";
}
var rgb=c.match(/rgb\s*\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*\)/);
if(rgb){
c=this.make_hex(parseInt(rgb[1]),parseInt(rgb[2]),parseInt(rgb[3]));
}
return c;
}};
if(wHELPERS){
var wFORMS={debugLevel:0,helpers:new wHELPERS(),behaviors:{},onLoadComplete:new Array(),onLoadHandler:function(){
for(var _37 in wFORMS.behaviors){
wFORMS.debug("wForms/loaded behavior: "+_37);
}
for(var i=0;i<document.forms.length;i++){
wFORMS.debug("wForms/initialize: "+(document.forms[i].name||document.forms[i].id));
wFORMS.addBehaviors(document.forms[i]);
}
},addBehaviors:function(_39){
if(!_39){
return;
}
var _3a=arguments[1]?arguments[1]:true;
if(!_39.nodeType){
_39=document.getElementById(_39);
}
if(_39.nodeType==1){
for(var _3b in wFORMS.behaviors){
wFORMS.behaviors[_3b].evaluate(_39);
}
if(_3a){
for(var i=_39.childNodes.length-1;i>=0;i--){
wFORMS.addBehaviors(_39.childNodes[i]);
}
}
if(_39.tagName.toUpperCase()=="FORM"){
wFORMS.debug("wForms/processed: "+_39.id);
for(var i=0;i<wFORMS.onLoadComplete.length;i++){
wFORMS.onLoadComplete[i]();
}
if(wFORMS.onLoadComplete.length>0){
wFORMS.onLoadComplete=new Array();
}
}
}
},hasBehavior:function(_3d){
if(wFORMS.behaviors[_3d]){
return true;
}
return false;
},debug:function(txt){
msgLevel=arguments[1]||10;
if(wFORMS.debugLevel>0&&msgLevel>=wFORMS.debugLevel){
if(!wFORMS.debugOutput){
wFORMS.initDebug();
}
if(wFORMS.debugOutput){
wFORMS.debugOutput.innerHTML+="<br />"+txt;
}
}
},initDebug:function(){
var _3f=document.getElementById("debugOutput");
if(!_3f){
_3f=document.createElement("div");
_3f.id="debugOutput";
_3f.style.position="absolute";
_3f.style.right="10px";
_3f.style.top="10px";
_3f.style.zIndex="300";
_3f.style.fontSize="x-small";
_3f.style.fontFamily="courier";
_3f.style.backgroundColor="#DDD";
_3f.style.padding="5px";
if(document.body){
wFORMS.debugOutput=document.body.appendChild(_3f);
}
}
if(wFORMS.debugOutput){
wFORMS.debugOutput.ondblclick=function(){
this.innerHTML="";
};
}
}};
wFORMS.utilities=wFORMS.helpers;
var wf=wFORMS;
wf.utilities.getSrcElement=wFORMS.helpers.getSourceElement;
wf.utilities.XBrowserPreventEventDefault=wFORMS.helpers.preventEvent;
wFORMS.helpers.activateStylesheet("wforms-jsonly.css");
wFORMS.helpers.addEvent(window,"load",wFORMS.onLoadHandler);
}else{
alert("Sorry, whelpers.js is not correctly loaded. The wFORMS Extension is not active.");
}
if(wFORMS){
wFORMS.idSuffix_fieldHint="-H";
wFORMS.className_inactiveFieldHint="field-hint-inactive";
wFORMS.className_activeFieldHint="field-hint";
wFORMS.behaviors["hint"]={name:"hint",evaluate:function(_40){
if(_40.id||_40.name){
var _41=document.getElementById(_40.id+wFORMS.idSuffix_fieldHint);
if(!_41){
_41=document.getElementById(_40.name+wFORMS.idSuffix_fieldHint);
}
if(_41){
switch(_40.tagName.toUpperCase()){
case "SELECT":
case "TEXTAREA":
case "INPUT":
wFORMS.helpers.addEvent(_40,"focus",wFORMS.behaviors["hint"].run);
wFORMS.helpers.addEvent(_40,"blur",wFORMS.behaviors["hint"].remove);
break;
default:
wFORMS.helpers.addEvent(_40,"mouseover",wFORMS.behaviors["hint"].run);
wFORMS.helpers.addEvent(_40,"mouseout",wFORMS.behaviors["hint"].remove);
break;
}
}
}
},run:function(e){
var _43=wFORMS.helpers.getSourceElement(e);
var _44=document.getElementById(_43.id+wFORMS.idSuffix_fieldHint);
if(!_44){
_44=document.getElementById(_43.name+wFORMS.idSuffix_fieldHint);
}
if(_44){
_44.className=_44.className.replace(wFORMS.className_inactiveFieldHint,wFORMS.className_activeFieldHint);
_44.style.top=(wFORMS.helpers.getTop(_43)+_43.offsetHeight).toString()+"px";
if(_43.tagName.toUpperCase()=="SELECT"){
_44.style.left=(wFORMS.helpers.getLeft(_43)+(_43.offsetWidth-8)).toString()+"px";
}else{
_44.style.left=(wFORMS.helpers.getLeft(_43)).toString()+"px";
}
}
},remove:function(e){
var _46=wFORMS.helpers.getSourceElement(e);
var _47=document.getElementById(_46.id+wFORMS.idSuffix_fieldHint);
if(!_47){
_47=document.getElementById(_46.name+wFORMS.idSuffix_fieldHint);
}
if(_47){
_47.className=_47.className.replace(wFORMS.className_activeFieldHint,wFORMS.className_inactiveFieldHint);
}
}};
}
if(wFORMS){
wFORMS.classNamePrefix_switch="switch";
wFORMS.className_switchIsOn="swtchIsOn";
wFORMS.className_switchIsOff="swtchIsOff";
wFORMS.classNamePrefix_offState="offstate";
wFORMS.classNamePrefix_onState="onstate";
wFORMS.switchScopeRootTag="";
wFORMS.switchTriggers={};
wFORMS.switchTargets={};
wFORMS.behaviors["switch"]={evaluate:function(_48){
if(wFORMS.helpers.hasClassPrefix(_48,wFORMS.classNamePrefix_switch)){
if(!_48.id){
_48.id=wFORMS.helpers.randomId();
}
var _49=wFORMS.behaviors["switch"].getSwitchNames(_48);
for(var i=0;i<_49.length;i++){
if(!wFORMS.switchTriggers[_49[i]]){
wFORMS.switchTriggers[_49[i]]=new Array();
}
wFORMS.switchTriggers[_49[i]].push(_48.id);
}
switch(_48.tagName.toUpperCase()){
case "OPTION":
var _4b=_48.parentNode;
while(_4b&&_4b.tagName.toUpperCase()!="SELECT"){
var _4b=_4b.parentNode;
}
if(!_4b){
alert("Error: invalid markup in SELECT field ?");
return false;
}
if(!_4b.id){
_4b.id=wFORMS.helpers.randomId();
}
if(!_4b.getAttribute("rel")||_4b.getAttribute("rel").indexOf("wfHandled")==-1){
_4b.setAttribute("rel",(_4b.getAttribute("rel")||"")+" wfHandled");
wFORMS.helpers.addEvent(_4b,"change",wFORMS.behaviors["switch"].run);
}
break;
case "INPUT":
if(_48.type&&_48.type.toLowerCase()=="radio"){
var _4c=_48.form;
for(var j=0;j<_4c[_48.name].length;j++){
var _4e=_4c[_48.name][j];
if(_4e.type.toLowerCase()=="radio"){
if(!_4e.getAttribute("rel")||_4e.getAttribute("rel").indexOf("wfHandled")==-1){
wFORMS.helpers.addEvent(_4e,"click",wFORMS.behaviors["switch"].run);
_4e.setAttribute("rel",(_4e.getAttribute("rel")||"")+" wfHandled");
}
}
}
}else{
wFORMS.helpers.addEvent(_48,"click",wFORMS.behaviors["switch"].run);
}
break;
default:
wFORMS.helpers.addEvent(_48,"click",wFORMS.behaviors["switch"].run);
break;
}
}
if(wFORMS.helpers.hasClassPrefix(_48,wFORMS.classNamePrefix_offState)||wFORMS.helpers.hasClassPrefix(_48,wFORMS.classNamePrefix_onState)){
if(!_48.id){
_48.id=wFORMS.helpers.randomId();
}
var _49=wFORMS.behaviors["switch"].getSwitchNames(_48);
for(var i=0;i<_49.length;i++){
if(!wFORMS.switchTargets[_49[i]]){
wFORMS.switchTargets[_49[i]]=new Array();
}
wFORMS.switchTargets[_49[i]].push(_48.id);
}
}
if(_48.tagName&&_48.tagName.toUpperCase()=="FORM"){
wFORMS.onLoadComplete.push(wFORMS.behaviors["switch"].init);
}
},init:function(){
for(var _4f in wFORMS.switchTriggers){
for(var i=0;i<wFORMS.switchTriggers[_4f].length;i++){
var _51=document.getElementById(wFORMS.switchTriggers[_4f][i]);
if(wFORMS.behaviors["switch"].isTriggerOn(_51,_4f)){
if(_51.tagName.toUpperCase()=="OPTION"){
var _51=_51.parentNode;
while(_51&&_51.tagName.toUpperCase()!="SELECT"){
var _51=_51.parentNode;
}
}
wFORMS.behaviors["switch"].run(_51);
}
}
}
},run:function(e){
var _53=wFORMS.helpers.getSourceElement(e);
if(!_53){
_53=e;
}
var _54=new Array();
var _55=new Array();
switch(_53.tagName.toUpperCase()){
case "SELECT":
for(var i=0;i<_53.options.length;i++){
if(i==_53.selectedIndex){
_54=_54.concat(wFORMS.behaviors["switch"].getSwitchNames(_53.options[i]));
}else{
_55=_55.concat(wFORMS.behaviors["switch"].getSwitchNames(_53.options[i]));
}
}
break;
case "INPUT":
if(_53.type.toLowerCase()=="radio"){
for(var i=0;i<_53.form[_53.name].length;i++){
var _57=_53.form[_53.name][i];
if(_57.checked){
_54=_54.concat(wFORMS.behaviors["switch"].getSwitchNames(_57));
}else{
_55=_55.concat(wFORMS.behaviors["switch"].getSwitchNames(_57));
}
}
}else{
if(_53.checked||wFORMS.helpers.hasClass(_53,wFORMS.className_switchIsOn)){
_54=_54.concat(wFORMS.behaviors["switch"].getSwitchNames(_53));
}else{
_55=_55.concat(wFORMS.behaviors["switch"].getSwitchNames(_53));
}
}
break;
default:
break;
}
for(var i=0;i<_55.length;i++){
var _58=wFORMS.behaviors["switch"].getElementsBySwitchName(_55[i]);
for(var j=0;j<_58.length;j++){
var _5a=wFORMS.switchTriggers[_55[i]];
var _5b=true;
for(var k=0;k<_5a.length;k++){
var _5d=document.getElementById(_5a[k]);
if(wFORMS.behaviors["switch"].isTriggerOn(_5d,_55[i])){
if(wFORMS.behaviors["switch"].isWithinSwitchScope(_5d,_58[j])){
_5b=false;
}
}
}
if(_5b){
wFORMS.behaviors["switch"].switchState(_58[j],wFORMS.classNamePrefix_onState,wFORMS.classNamePrefix_offState);
}
}
}
for(var i=0;i<_54.length;i++){
var _58=wFORMS.behaviors["switch"].getElementsBySwitchName(_54[i]);
for(var j=0;j<_58.length;j++){
if(wFORMS.behaviors["switch"].isWithinSwitchScope(_53,_58[j])){
wFORMS.behaviors["switch"].switchState(_58[j],wFORMS.classNamePrefix_offState,wFORMS.classNamePrefix_onState);
}
}
}
},remove:function(e){
var _5f=wFORMS.helpers.getSourceElement(e);
},getSwitchNames:function(_60){
var _61=new Array();
var _62=_60.className.split(" ");
for(var i=0;i<_62.length;i++){
if(_62[i].indexOf(wFORMS.classNamePrefix_switch)==0){
_61.push(_62[i].substr(wFORMS.classNamePrefix_switch.length+1));
}
if(_62[i].indexOf(wFORMS.classNamePrefix_onState)==0){
_61.push(_62[i].substr(wFORMS.classNamePrefix_onState.length+1));
}else{
if(_62[i].indexOf(wFORMS.classNamePrefix_offState)==0){
_61.push(_62[i].substr(wFORMS.classNamePrefix_offState.length+1));
}
}
}
return _61;
},switchState:function(_64,_65,_66){
if(!_64||_64.nodeType!=1){
return;
}
if(_64.className){
_64.className=_64.className.replace(_65,_66);
}
if(wFORMS.helpers.hasClass(_64,wFORMS.className_switchIsOff)){
_64.className=_64.className.replace(wFORMS.className_switchIsOff,wFORMS.className_switchIsOn);
}else{
if(wFORMS.helpers.hasClass(_64,wFORMS.className_switchIsOn)){
_64.className=_64.className.replace(wFORMS.className_switchIsOn,wFORMS.className_switchIsOff);
}
}
},getElementsBySwitchName:function(_67){
var _68=new Array();
if(wFORMS.switchTargets[_67]){
for(var i=0;i<wFORMS.switchTargets[_67].length;i++){
var _6a=document.getElementById(wFORMS.switchTargets[_67][i]);
if(_6a){
_68.push(_6a);
}
}
}
return _68;
},isTriggerOn:function(_6b,_6c){
if(!_6b){
return false;
}
if(_6b.tagName.toUpperCase()=="OPTION"){
var _6d=_6b.parentNode;
while(_6d&&_6d.tagName.toUpperCase()!="SELECT"){
var _6d=_6d.parentNode;
}
if(!_6d){
return false;
}
if(_6d.selectedIndex==-1){
return false;
}
if(wFORMS.helpers.hasClass(_6d.options[_6d.selectedIndex],wFORMS.classNamePrefix_switch+"-"+_6c)){
return true;
}
}else{
if(_6b.checked||wFORMS.helpers.hasClass(_6b,wFORMS.className_switchIsOn)){
return true;
}
}
return false;
},isWithinSwitchScope:function(_6e,_6f){
if(wFORMS.hasBehavior("repeat")&&wFORMS.limitSwitchScope==true){
var _70=_6e;
while(_70&&_70.tagName&&_70.tagName.toUpperCase()!="FORM"&&!wFORMS.helpers.hasClass(_70,wFORMS.className_repeat)&&!wFORMS.helpers.hasClass(_70,wFORMS.className_delete)){
_70=_70.parentNode;
}
if(wFORMS.helpers.hasClass(_70,wFORMS.className_repeat)||wFORMS.helpers.hasClass(_70,wFORMS.className_delete)){
var _71=_6f;
while(_71&&_71.tagName&&_71.tagName.toUpperCase()!="FORM"&&!wFORMS.helpers.hasClass(_71,wFORMS.className_repeat)&&!wFORMS.helpers.hasClass(_71,wFORMS.className_delete)){
_71=_71.parentNode;
}
if(_70==_71){
return true;
}else{
return false;
}
}else{
return true;
}
}else{
return true;
}
}};
}
if(wFORMS){
wFORMS.preventSubmissionOnEnter=false;
wFORMS.showAlertOnError=true;
wFORMS.className_required="required";
wFORMS.className_validationError_msg="errMsg";
wFORMS.className_validationError_fld="errFld";
wFORMS.classNamePrefix_validation="validate";
wFORMS.idSuffix_fieldError="-E";
wFORMS.arrErrorMsg=new Array();
wFORMS.arrErrorMsg[0]="This field is required. ";
wFORMS.arrErrorMsg[1]="The text must use alphabetic characters only (a-z, A-Z). Numbers are not allowed. ";
wFORMS.arrErrorMsg[2]="This does not appear to be a valid email address.";
wFORMS.arrErrorMsg[3]="Please enter an integer.";
wFORMS.arrErrorMsg[4]="Please enter a float (ex. 1.9).";
wFORMS.arrErrorMsg[5]="Unsafe password. Your password should be between 4 and 12 characters long and use a combinaison of upper-case and lower-case letters.";
wFORMS.arrErrorMsg[6]="Please use alpha-numeric characters only [a-z 0-9].";
wFORMS.arrErrorMsg[7]="This does not appear to be a valid date.";
wFORMS.arrErrorMsg[8]="%% error(s) detected. Your form has not been submitted yet.\nPlease check the information you provided.";
wFORMS.behaviors["validation"]={evaluate:function(_72){
if(_72.tagName.toUpperCase()=="FORM"){
if(wFORMS.functionName_formValidation.toString()==wFORMS.functionName_formValidation){
wFORMS.functionName_formValidation=eval(wFORMS.functionName_formValidation);
}
wFORMS.helpers.addEvent(_72,"submit",wFORMS.functionName_formValidation);
}
},init:function(){
},run:function(e){
var _74=wFORMS.helpers.getSourceElement(e);
if(!_74){
_74=e;
}
if(wFORMS.preventSubmissionOnEnter){
if(_74.type&&_74.type.toLowerCase()=="text"){
return wFORMS.preventEvent(e);
}
}
while(_74&&_74.tagName.toUpperCase()!="FORM"){
_74=_74.parentNode;
}
var _75=wFORMS.behaviors["validation"].validateElement(_74,true);
if(_75>0){
if(wFORMS.showAlertOnError){
wFORMS.behaviors["validation"].showAlert(_75);
}
return wFORMS.helpers.preventEvent(e);
}
return true;
},remove:function(){
},validateElement:function(_76){
var _77=wFORMS.behaviors["validation"];
if(wFORMS.hasBehavior("switch")&&wFORMS.helpers.hasClassPrefix(_76,wFORMS.classNamePrefix_offState)){
return 0;
}
if(wFORMS.hasBehavior("paging")&&wFORMS.helpers.hasClass(_76,wFORMS.className_paging)&&!wFORMS.helpers.hasClass(_76,wFORMS.className_pagingCurrent)){
return 0;
}
var _78=0;
if(!_77.checkRequired(_76)){
_77.showError(_76,wFORMS.arrErrorMsg[0]);
_78++;
}else{
if(wFORMS.helpers.hasClassPrefix(_76,wFORMS.classNamePrefix_validation)){
var _79=_76.className.split(" ");
for(j=0;j<_79.length;j++){
switch(_79[j]){
case "validate-alpha":
if(!_77.isAlpha(_76.value)){
_77.showError(_76,wFORMS.arrErrorMsg[1]);
_78++;
}
break;
case "validate-alphanum":
if(!_77.isAlphaNum(_76.value)){
_77.showError(_76,wFORMS.arrErrorMsg[6]);
_78++;
}
break;
case "validate-date":
if(!_77.isDate(_76.value)){
_77.showError(_76,wFORMS.arrErrorMsg[7]);
_78++;
}
break;
case "validate-time":
break;
case "validate-email":
if(!_77.isEmail(_76.value)){
_77.showError(_76,wFORMS.arrErrorMsg[2]);
_78++;
}
break;
case "validate-integer":
if(!_77.isInteger(_76.value)){
_77.showError(_76,wFORMS.arrErrorMsg[3]);
_78++;
}
break;
case "validate-float":
if(!_77.isFloat(_76.value)){
_77.showError(_76,wFORMS.arrErrorMsg[4]);
_78++;
}
break;
case "validate-strongpassword":
if(!_77.isPassword(_76.value)){
_77.showError(_76,wFORMS.arrErrorMsg[5]);
_78++;
}
break;
}
}
}
}
if(_78==0){
var _7a=new RegExp(wFORMS.className_validationError_fld,"gi");
_76.className=_76.className.replace(_7a,"");
var _7b=document.getElementById(_76.id+wFORMS.idSuffix_fieldError);
if(_7b){
_7b.parentNode.removeChild(_7b);
}
}
var _7c=arguments[1]?arguments[1]:true;
if(_7c){
for(var i=0;i<_76.childNodes.length;i++){
if(_76.childNodes[i].nodeType==1){
_78+=_77.validateElement(_76.childNodes[i],_7c);
}
}
}
return _78;
},checkRequired:function(_7e){
if(wFORMS.helpers.hasClass(_7e,wFORMS.className_required)){
var _7f=wFORMS.behaviors["validation"];
switch(_7e.tagName.toUpperCase()){
case "INPUT":
switch(_7e.getAttribute("type").toLowerCase()){
case "checkbox":
return _7e.checked;
break;
case "radio":
return _7e.checked;
break;
default:
return !_7f.isEmpty(_7e.value);
}
break;
case "SELECT":
return !_7f.isEmpty(_7e.options[_7e.selectedIndex].value);
break;
case "TEXTAREA":
return !_7f.isEmpty(_7e.value);
break;
default:
return _7f.checkOneRequired(_7e);
break;
}
}
return true;
},checkOneRequired:function(_80){
var _81=false;
if(_80.nodeType!=1){
return false;
}
if(_80.tagName.toUpperCase()=="INPUT"){
switch(_80.type.toLowerCase()){
case "checkbox":
_81=_80.checked;
break;
case "radio":
_81=_80.checked;
break;
default:
_81=_80.value;
}
}else{
_81=_80.value;
}
if(_81&&!wFORMS.behaviors["validation"].isEmpty(_81)){
return true;
}
for(var i=0;i<_80.childNodes.length;i++){
if(wFORMS.behaviors["validation"].checkOneRequired(_80.childNodes[i])){
return true;
}
}
return false;
},isEmpty:function(s){
var _84=/^\s+$/;
return ((s==null)||(s.length==0)||_84.test(s));
},isAlpha:function(s){
var _86=/^[a-zA-Z]+$/;
return wFORMS.behaviors["validation"].isEmpty(s)||_86.test(s);
},isAlphaNum:function(s){
var _88=/\W/;
return wFORMS.behaviors["validation"].isEmpty(s)||!_88.test(s);
},isDate:function(s){
var _8a=new Date(s);
return wFORMS.behaviors["validation"].isEmpty(s)||!isNaN(_8a);
},isEmail:function(s){
var _8c=/\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/;
return wFORMS.behaviors["validation"].isEmpty(s)||_8c.test(s);
},isInteger:function(s){
var _8e=/^[+]?\d+$/;
return wFORMS.behaviors["validation"].isEmpty(s)||_8e.test(s);
},isFloat:function(s){
return wFORMS.behaviors["validation"].isEmpty(s)||!isNaN(parseFloat(s));
},isPassword:function(s){
return wFORMS.behaviors["validation"].isEmpty(s);
},showError:function(_91,_92){
if(_91.className.indexOf(wFORMS.className_validationError_fld)!=-1){
return;
}
if(!_91.id){
_91.id=wFORMS.helpers.randomId();
}
_91.className+=" "+wFORMS.className_validationError_fld;
var _93=document.createTextNode(" "+_92);
var fe=document.getElementById(_91.id+wFORMS.idSuffix_fieldError);
if(!fe){
fe=document.createElement("div");
fe.setAttribute("id",_91.id+wFORMS.idSuffix_fieldError);
var fl=document.getElementById(_91.id+wFORMS.idSuffix_fieldLabel);
if(fl){
fl.parentNode.insertBefore(fe,fl.nextSibling);
}else{
_91.parentNode.insertBefore(fe,_91.nextSibling);
}
}
fe.appendChild(_93);
fe.className+=" "+wFORMS.className_validationError_msg;
},showAlert:function(_96){
alert(wFORMS.arrErrorMsg[8].replace("%%",_96));
}};
wFORMS.functionName_formValidation=wFORMS.behaviors["validation"].run;
wFORMS.formValidation=wFORMS.behaviors["validation"].run;
}
if(wFORMS){
wFORMS.className_paging="wfPage";
wFORMS.className_pagingCurrent="wfCurrentPage";
wFORMS.className_pagingButtons="wfPageButton";
wFORMS.className_hideSubmit="wfHideSubmit";
wFORMS.idPrefix_pageIndex="wfPgIndex-";
wFORMS.runValidationOnPageNext=true;
if(!wFORMS.arrMsg){
wFORMS.arrMsg=new Array();
}
wFORMS.arrMsg[4]="Next Page";
wFORMS.arrMsg[5]="Previous Page";
wFORMS.behaviors["paging"]={evaluate:function(_97){
if(wFORMS.helpers.hasClass(_97,wFORMS.className_paging)){
var _98=parseInt(_97.id.replace(/[\D]*/,""));
if(_98>1){
var _99=document.createElement("input");
_99.setAttribute("value",wFORMS.arrMsg[5]);
_99.setAttribute("type","button");
_99.className=wFORMS.className_pagingButtons;
_97.appendChild(_99);
wFORMS.helpers.addEvent(_99,"click",wFORMS.behaviors["paging"].pagingPrevious);
}else{
_97.className+=" "+wFORMS.className_pagingCurrent;
var _9a=_97.parentNode;
while(_9a&&_9a.tagName.toUpperCase()!="FORM"){
_9a=_9a.parentNode;
}
var _9b=_9a.getElementsByTagName("input");
for(var i=0;i<_9b.length;i++){
if(_9b[i].type&&_9b[i].type.toLowerCase()=="submit"){
_9b[i].className+=" "+wFORMS.className_hideSubmit;
}
}
wFORMS.helpers.addEvent(_9a,"submit",function(e){
var _9e=wFORMS.helpers.getSourceElement(e);
if(_9e.type&&_9e.type.toLowerCase()=="text"){
return wFORMS.preventEvent(e);
}
});
wFORMS.preventSubmissionOnEnter=true;
}
if(document.getElementById(wFORMS.idPrefix_pageIndex+(_98+1).toString())){
var _99=document.createElement("input");
_99.setAttribute("value",wFORMS.arrMsg[4]);
_99.setAttribute("type","button");
_99.className=wFORMS.className_pagingButtons;
_97.appendChild(_99);
wFORMS.helpers.addEvent(_99,"click",wFORMS.behaviors["paging"].pagingNext);
}
}
},pagingNext:function(e){
var _a0=wFORMS.helpers.getSourceElement(e);
if(!_a0){
_a0=e;
}
var _a1=_a0.parentNode;
var _a2=parseInt(_a1.id.replace(/[\D]*/,""))+1;
var _a3=document.getElementById(wFORMS.idPrefix_pageIndex+_a2.toString());
if(_a3){
if(!wFORMS.hasBehavior("validation")||(wFORMS.hasBehavior("validation")&&!wFORMS.runValidationOnPageNext)||(wFORMS.hasBehavior("validation")&&wFORMS.runValidationOnPageNext&&wFORMS.functionName_formValidation(e))){
_a1.className=_a1.className.replace(wFORMS.className_pagingCurrent,"");
_a3.className+=" "+wFORMS.className_pagingCurrent;
_a2++;
_a3=document.getElementById(wFORMS.idPrefix_pageIndex+_a2.toString());
if(!_a3){
var _a4=_a1.parentNode;
while(_a4&&_a4.tagName.toUpperCase()!="FORM"){
_a4=_a4.parentNode;
}
var _a5=_a4.getElementsByTagName("input");
for(var i=0;i<_a5.length;i++){
if(_a5[i].type&&_a5[i].type.toLowerCase()=="submit"){
_a5[i].className=_a5[i].className.replace(wFORMS.className_hideSubmit,"");
wFORMS.debug("submit class "+_a5[i].className);
}
}
}
}
}
},pagingPrevious:function(e){
var _a8=wFORMS.helpers.getSourceElement(e);
if(!_a8){
_a8=e;
}
var _a9=_a8.parentNode;
var _aa=parseInt(_a9.id.replace(/[\D]*/,""))-1;
var _ab=document.getElementById(wFORMS.idPrefix_pageIndex+_aa.toString());
if(_ab){
_a9.className=_a9.className.replace(wFORMS.className_pagingCurrent,"");
_ab.className+=" "+wFORMS.className_pagingCurrent;
var _ac=_a9.parentNode;
while(_ac&&_ac.tagName.toUpperCase()!="FORM"){
_ac=_ac.parentNode;
}
var _ad=_ac.getElementsByTagName("input");
for(var i=0;i<_ad.length;i++){
if(_ad[i].type&&_ad[i].type.toLowerCase()=="submit"&&!wFORMS.helpers.hasClass(_ad[i],wFORMS.className_hideSubmit)){
_ad[i].className+=" "+wFORMS.className_hideSubmit;
}
}
}
}};
}
if(wFORMS){
wFORMS.className_repeat="repeat";
wFORMS.className_delete="removeable";
wFORMS.className_duplicateLink="duplicateLink";
wFORMS.className_removeLink="removeLink";
wFORMS.className_preserveRadioName="preserveRadioName";
wFORMS.idSuffix_repeatCounter="-RC";
wFORMS.idSuffix_duplicateLink="-wfDL";
wFORMS.preserveRadioName=false;
wFORMS.limitSwitchScope=true;
if(!wFORMS.arrMsg){
wFORMS.arrMsg=new Array();
}
wFORMS.arrMsg[0]="More";
wFORMS.arrMsg[1]="Will duplicate this question or section.";
wFORMS.arrMsg[2]="Remove";
wFORMS.arrMsg[3]="Will remove this question or section.";
wFORMS.behaviors["repeat"]={evaluate:function(_af){
if(wFORMS.helpers.hasClass(_af,wFORMS.className_repeat)){
var _b0;
if(_af.id){
_b0=document.getElementById(_af.id+wFORMS.idSuffix_duplicateLink);
}
if(!_b0){
_b0=document.createElement("a");
var _b1=document.createElement("span");
var _b2=document.createTextNode(wFORMS.arrMsg[0]);
_b0.setAttribute("href","#");
_b0.className=wFORMS.className_duplicateLink;
_b0.setAttribute("title",wFORMS.arrMsg[1]);
if(_af.tagName.toUpperCase()=="TR"){
var n=_af.lastChild;
while(n&&n.nodeType!=1){
n=n.previousSibling;
}
if(n&&n.nodeType==1){
n.appendChild(_b0);
}
}else{
_af.appendChild(_b0);
}
_b1.appendChild(_b2);
_b0.appendChild(_b1);
}
var _b4=document.getElementById(_af.id+wFORMS.idSuffix_repeatCounter);
if(!_b4){
if(document.all&&!window.opera){
var _b5=_af.id+wFORMS.idSuffix_repeatCounter;
if(navigator.appVersion.indexOf("MSIE")!=-1&&navigator.appVersion.indexOf("Windows")==-1){
_b4=document.createElement("INPUT NAME=\""+_b5+"\"");
}else{
_b4=document.createElement("<INPUT NAME=\""+_b5+"\"></INPUT>");
}
_b4.type="hidden";
_b4.id=_b5;
_b4.value="1";
}else{
_b4=document.createElement("INPUT");
_b4.setAttribute("type","hidden");
_b4.setAttribute("value","1");
_b4.setAttribute("name",_af.id+wFORMS.idSuffix_repeatCounter);
_b4.setAttribute("id",_af.id+wFORMS.idSuffix_repeatCounter);
}
var _b6=_af.parentNode;
while(_b6&&_b6.tagName.toUpperCase()!="FORM"){
_b6=_b6.parentNode;
}
_b6.appendChild(_b4);
}
wFORMS.helpers.addEvent(_b0,"click",wFORMS.behaviors["repeat"].duplicateFieldGroup);
}
if(wFORMS.helpers.hasClass(_af,wFORMS.className_delete)){
var _b7=document.createElement("a");
var _b1=document.createElement("span");
var _b2=document.createTextNode(wFORMS.arrMsg[2]);
_b7.setAttribute("href","#");
_b7.className=wFORMS.className_removeLink;
_b7.setAttribute("title",wFORMS.arrMsg[3]);
if(_af.tagName.toUpperCase()=="TR"){
var n=_af.lastChild;
while(n&&n.nodeType!=1){
n=n.previousSibling;
}
if(n&&n.nodeType==1){
n.appendChild(_b7);
}
}else{
_af.appendChild(_b7);
}
_b1.appendChild(_b2);
_b7.appendChild(_b1);
wFORMS.helpers.addEvent(_b7,"click",wFORMS.behaviors["repeat"].removeFieldGroup);
}
},duplicateFieldGroup:function(e){
var _b9=wFORMS.helpers.getSourceElement(e);
if(!_b9){
_b9=e;
}
var _ba=wFORMS.helpers.hasClass(_b9,wFORMS.className_preserveRadioName)?true:wFORMS.preserveRadioName;
var _b9=_b9.parentNode;
while(_b9&&!wFORMS.helpers.hasClass(_b9,wFORMS.className_repeat)){
_b9=_b9.parentNode;
}
if(_b9){
counterField=document.getElementById(_b9.id+wFORMS.idSuffix_repeatCounter);
if(!counterField){
return;
}
var _bb=parseInt(counterField.value)+1;
var _bc="-"+_bb.toString();
var _bd=wFORMS.behaviors["repeat"].replicateTree(_b9,null,_bc,_ba);
var _be=_b9.nextSibling;
while(_be&&(_be.nodeType==3||wFORMS.helpers.hasClass(_be,wFORMS.className_delete))){
_be=_be.nextSibling;
}
_b9.parentNode.insertBefore(_bd,_be);
_bd.className=_b9.className.replace(wFORMS.className_repeat,wFORMS.className_delete);
document.getElementById(_b9.id+wFORMS.idSuffix_repeatCounter).value=_bb;
wFORMS.addBehaviors(_bd);
}
return wFORMS.helpers.preventEvent(e);
},removeFieldGroup:function(e){
var _c0=wFORMS.helpers.getSourceElement(e);
if(!_c0){
_c0=e;
}
var _c0=_c0.parentNode;
while(_c0&&!wFORMS.helpers.hasClass(_c0,wFORMS.className_delete)){
_c0=_c0.parentNode;
}
_c0.parentNode.removeChild(_c0);
return wFORMS.helpers.preventEvent(e);
},removeRepeatCountSuffix:function(str){
return str.replace(/-\d$/,"");
},replicateTree:function(_c2,_c3,_c4,_c5){
if(_c2.nodeType==3){
if(_c2.parentNode.tagName.toUpperCase()!="TEXTAREA"){
var _c6=document.createTextNode(_c2.data);
}
}else{
if(_c2.nodeType==1){
if(wFORMS.helpers.hasClass(_c2,wFORMS.className_duplicateLink)||wFORMS.helpers.hasClass(_c2,wFORMS.className_removeLink)){
return null;
}
if(wFORMS.helpers.hasClass(_c2,wFORMS.className_delete)){
return null;
}
if(wFORMS.helpers.hasClass(_c2,wFORMS.className_repeat)&&_c3!=null){
_c4=_c4.replace("-","__");
}
if(!document.all||window.opera){
var _c6=document.createElement(_c2.tagName);
}else{
var _c7=_c2.tagName;
if(_c2.name){
if(_c2.tagName.toUpperCase()=="INPUT"&&_c2.type.toLowerCase()=="radio"&&_c5){
_c7+=" NAME='"+_c2.name+"' ";
}else{
_c7+=" NAME='"+wFORMS.behaviors["repeat"].removeRepeatCountSuffix(_c2.name)+_c4+"' ";
}
}
if(_c2.type){
_c7+=" TYPE='"+_c2.type+"' ";
}
if(_c2.selected){
_c7+=" SELECTED='SELECTED' ";
}
if(_c2.checked){
_c7+=" CHECKED='CHECKED' ";
}
if(navigator.appVersion.indexOf("MSIE")!=-1&&navigator.appVersion.indexOf("Windows")==-1){
var _c6=document.createElement(_c7);
}else{
var _c6=document.createElement("<"+_c7+"></"+_c2.tagName+">");
}
try{
_c6.type=_c2.type;
}
catch(e){
}
}
for(var i=0;i<_c2.attributes.length;i++){
var _c9=_c2.attributes[i];
if(_c9.specified||_c9.nodeName.toLowerCase()=="value"){
if(_c9.nodeName.toLowerCase()=="id"||_c9.nodeName.toLowerCase()=="name"||_c9.nodeName.toLowerCase()=="for"){
if(wFORMS.hasBehavior("hint")&&_c9.nodeValue.indexOf(wFORMS.idSuffix_fieldHint)!=-1){
var _ca=_c9.nodeValue;
_ca=wFORMS.behaviors["repeat"].removeRepeatCountSuffix(_ca.substr(0,_ca.indexOf(wFORMS.idSuffix_fieldHint)))+_c4+wFORMS.idSuffix_fieldHint;
}else{
if(_c2.tagName.toUpperCase()=="INPUT"&&_c2.getAttribute("type",false).toLowerCase()=="radio"&&_c9.nodeName.toLowerCase()=="name"&&_c5){
var _ca=_c9.nodeValue;
}else{
var _ca=_c9.nodeValue+_c4;
}
}
}else{
if(_c9.nodeName.toLowerCase()=="value"&&_c2.tagName.toUpperCase()=="INPUT"&&(_c2.type.toLowerCase()=="text"||_c2.type.toLowerCase()=="password"||_c2.type.toLowerCase()=="file")){
var _ca="";
}else{
if(_c9.nodeName.toLowerCase()=="rel"&&_c9.nodeValue.indexOf("wfHandled")!=-1){
var _ca=_c9.nodeValue.replace("wfHandled","");
}else{
var _ca=_c9.nodeValue;
}
}
}
switch(_c9.nodeName.toLowerCase()){
case "class":
_c6.className=_ca;
break;
case "style":
if(_c2.style&&_c2.style.cssText){
_c6.style.cssText=_c2.style.cssText;
}
break;
case "onclick":
_c6.onclick=_c2.onclick;
break;
case "onchange":
_c6.onchange=_c2.onchange;
break;
case "onsubmit":
_c6.onsubmit=_c2.onsubmit;
break;
case "onmouseover":
_c6.onmouseover=_c2.onmouseover;
break;
case "onmouseout":
_c6.onmouseout=_c2.onmouseout;
break;
case "onmousedown":
_c6.onmousedown=_c2.onmousedown;
break;
case "onmouseup":
_c6.onmouseup=_c2.onmouseup;
break;
case "ondblclick":
_c6.ondblclick=_c2.ondblclick;
break;
case "onkeydown":
_c6.onkeydown=_c2.onkeydown;
break;
case "onkeyup":
_c6.onkeyup=_c2.onkeyup;
break;
case "onblur":
_c6.onblur=_c2.onblur;
break;
case "onfocus":
_c6.onfocus=_c2.onfocus;
break;
default:
_c6.setAttribute(_c9.name,_ca,0);
}
}
}
}
}
if(_c3&&_c6){
_c3.appendChild(_c6);
}
for(var i=0;i<_c2.childNodes.length;i++){
wFORMS.behaviors["repeat"].replicateTree(_c2.childNodes[i],_c6,_c4,_c5);
}
return _c6;
}};
}

