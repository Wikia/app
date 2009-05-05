/**
 * Copyright (c) 2005 - 2009, James Auldridge
 * All rights reserved.
 *
 * Licensed under the BSD, MIT, and GPL (your choice!) Licenses:
 *  http://code.google.com/p/cookies/wiki/License
 *
 * Version 2.0.1
 */

var jaaulde=window.jaaulde||{};jaaulde.utils=jaaulde.utils||{};jaaulde.utils.cookies=(function()
{var cookies=[];var defaultOptions={hoursToLive:null,path:'/',domain:null,secure:false};var resolveOptions=function(options)
{var returnValue;if(typeof options!=='object'||options===null)
{returnValue=defaultOptions;}
else
{returnValue={hoursToLive:(typeof options.hoursToLive==='number'&&options.hoursToLive>0?options.hoursToLive:defaultOptions.hoursToLive),path:(typeof options.path==='string'&&options.path!=''?options.path:defaultOptions.path),domain:(typeof options.domain==='string'&&options.domain!=''?options.domain:defaultOptions.domain),secure:(typeof options.secure==='boolean'&&options.secure?options.secure:defaultOptions.secure)};}
return returnValue;};var assembleOptionsString=function(options)
{options=resolveOptions(options);return((typeof options.hoursToLive=='number'?'; expires='+expiresGMTString(options.hoursToLive):'')+'; path='+options.path+
(typeof options.domain==='string'?'; domain='+options.domain:'')+
(options.secure===true?'; secure':''));};var expiresGMTString=function(hoursToLive)
{var dateObject=new Date();dateObject.setTime(dateObject.getTime()+(hoursToLive*60*60*1000));return dateObject.toGMTString();};var splitCookies=function()
{cookies=[];var pair,name,separated=document.cookie.split(';');for(var i=0;i<separated.length;i++)
{pair=separated[i].split('=');name=pair[0].replace(/^\s*/,'').replace(/\s*$/,'');value=decodeURIComponent(pair[1]);cookies[name]=value;}
return cookies;};var constructor=function(){};constructor.prototype.get=function(cookieName)
{var returnValue;splitCookies();if(typeof cookieName==='string')
{returnValue=(typeof cookies[cookieName]!=='undefined')?cookies[cookieName]:null;}
else if(typeof cookieName==='object'&&cookieName!==null)
{returnValue=[];for(var item in cookieName)
{returnValue[cookieName[item]]=(typeof cookies[cookieName[item]]!=='undefined')?cookies[cookieName[item]]:null;}}
else
{returnValue=cookies;}
return returnValue;};constructor.prototype.set=function(cookieName,value,options)
{if(typeof value==='undefined'||value===null)
{if(typeof options!=='object'||options===null)
{options={};}
value='';options.hoursToLive=-8760;}
var optionsString=assembleOptionsString(options);document.cookie=cookieName+'='+encodeURIComponent(value)+optionsString;};constructor.prototype.del=function(cookieName,options)
{if(typeof options!=='object'||options===null)
{options={};}
this.set(cookieName,null,options);};constructor.prototype.test=function()
{var returnValue=false,testName='cT',testValue='data';this.set(testName,testValue);if(this.get(testName)==testValue)
{this.del(testName);returnValue=true;}
return returnValue;};constructor.prototype.setOptions=function(options)
{if(typeof options!=='object')
{options=null;}
defaultOptions=resolveOptions(options);}
return new constructor();})();(function()
{if(typeof jQuery!=='undefined')
{jQuery.cookies=jaaulde.utils.cookies;var extensions={cookify:function(options)
{return this.each(function()
{var name='',value='',nameAttrs=['name','id'],iteration=0,inputType;while(iteration<nameAttrs.length&&(typeof name!=='string'||name===''))
{name=jQuery(this).attr(nameAttrs[iteration]);iteration++;}
if(typeof name==='string'||name!=='')
{inputType=jQuery(this).attr('type').toLowerCase();if(inputType!=='radio'&&inputType!=='checkbox')
{value=jQuery(this).attr('value');if(typeof value!=='string'||value==='')
{value=null;}
jQuery.cookies.set(name,value,options);}}
iteration=0;});},cookieFill:function()
{return this.each(function()
{var name='',value,nameAttrs=['name','id'],iteration=0,nodeType;while(iteration<nameAttrs.length&&(typeof name!=='string'||name===''))
{name=jQuery(this).attr(nameAttrs[iteration]);iteration++;}
if(typeof name==='string'&&name!=='')
{value=jQuery.cookies.get(name);if(value!==null)
{nodeType=this.nodeName.toLowerCase();if(nodeType==='input'||nodeType==='textarea')
{jQuery(this).attr('value',value);}
else
{jQuery(this).html(value);}}}
iteration=0;});},cookieBind:function(options)
{return this.each(function(){$(this).cookieFill().change(function()
{$(this).cookify(options);});});}};jQuery.each(extensions,function(i)
{jQuery.fn[i]=this;});}})();