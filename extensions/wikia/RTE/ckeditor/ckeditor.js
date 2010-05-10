/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

if(!window.CKEDITOR)
{window.CKEDITOR=(function()
{var CKEDITOR={timestamp:'',version:'20100510',revision:'r22314',_:{},status:'unloaded',basePath:(function()
{var path=window.CKEDITOR_BASEPATH||'';if(!path)
{var scripts=document.getElementsByTagName('script');for(var i=0;i<scripts.length;i++)
{var match=scripts[i].src.match(/(^|.*[\\\/])ckeditor(?:_basic)?(?:_source)?.js(?:\?.*)?$/i);if(match)
{path=match[1];break;}}}
if(path.indexOf('://')==-1)
{if(path.indexOf('/')===0)
path=location.href.match(/^.*?:\/\/[^\/]*/)[0]+path;else
path=location.href.match(/^[^\?]*\/(?:)/)[0]+path;}
if(!path)
throw'The CKEditor installation path could not be automatically detected. Please set the global variable "CKEDITOR_BASEPATH" before creating editor instances.';return path;})(),getUrl:function(resource)
{if(resource.indexOf('://')==-1&&resource.indexOf('/')!==0)
resource=this.basePath+resource;if(this.timestamp&&resource.charAt(resource.length-1)!='/')
resource+=(resource.indexOf('?')>=0?'&':'?')+'t='+this.timestamp;return resource;}};var newGetUrl=window.CKEDITOR_GETURL;if(newGetUrl)
{var originalGetUrl=CKEDITOR.getUrl;CKEDITOR.getUrl=function(resource)
{return newGetUrl.call(CKEDITOR,resource)||originalGetUrl.call(CKEDITOR,resource);};}
return CKEDITOR;})();}
if(!CKEDITOR.event)
{CKEDITOR.event=function()
{};CKEDITOR.event.implementOn=function(targetObject,isTargetPrototype)
{var eventProto=CKEDITOR.event.prototype;for(var prop in eventProto)
{if(targetObject[prop]==undefined)
targetObject[prop]=eventProto[prop];}};CKEDITOR.event.prototype=(function()
{var getPrivate=function(obj)
{var _=(obj.getPrivate&&obj.getPrivate())||obj._||(obj._={});return _.events||(_.events={});};var eventEntry=function(eventName)
{this.name=eventName;this.listeners=[];};eventEntry.prototype={getListenerIndex:function(listenerFunction)
{for(var i=0,listeners=this.listeners;i<listeners.length;i++)
{if(listeners[i].fn==listenerFunction)
return i;}
return-1;}};return{on:function(eventName,listenerFunction,scopeObj,listenerData,priority)
{var events=getPrivate(this),event=events[eventName]||(events[eventName]=new eventEntry(eventName));if(event.getListenerIndex(listenerFunction)<0)
{var listeners=event.listeners;if(!scopeObj)
scopeObj=this;if(isNaN(priority))
priority=10;var me=this;var listenerFirer=function(editor,publisherData,stopFn,cancelFn)
{var ev={name:eventName,sender:this,editor:editor,data:publisherData,listenerData:listenerData,stop:stopFn,cancel:cancelFn,removeListener:function()
{me.removeListener(eventName,listenerFunction);}};listenerFunction.call(scopeObj,ev);return ev.data;};listenerFirer.fn=listenerFunction;listenerFirer.priority=priority;for(var i=listeners.length-1;i>=0;i--)
{if(listeners[i].priority<=priority)
{listeners.splice(i+1,0,listenerFirer);return;}}
listeners.unshift(listenerFirer);}},fire:(function()
{var stopped=false;var stopEvent=function()
{stopped=true;};var canceled=false;var cancelEvent=function()
{canceled=true;};return function(eventName,data,editor)
{var event=getPrivate(this)[eventName];var previousStopped=stopped,previousCancelled=canceled;stopped=canceled=false;if(event)
{var listeners=event.listeners;if(listeners.length)
{listeners=listeners.slice(0);for(var i=0;i<listeners.length;i++)
{var retData=listeners[i].call(this,editor,data,stopEvent,cancelEvent);if(typeof retData!='undefined')
data=retData;if(stopped||canceled)
break;}}}
var ret=canceled||(typeof data=='undefined'?false:data);stopped=previousStopped;canceled=previousCancelled;return ret;};})(),fireOnce:function(eventName,data,editor)
{var ret=this.fire(eventName,data,editor);delete getPrivate(this)[eventName];return ret;},removeListener:function(eventName,listenerFunction)
{var event=getPrivate(this)[eventName];if(event)
{var index=event.getListenerIndex(listenerFunction);if(index>=0)
event.listeners.splice(index,1);}},hasListeners:function(eventName)
{var event=getPrivate(this)[eventName];return(event&&event.listeners.length>0);}};})();}
if(!CKEDITOR.editor)
{CKEDITOR.ELEMENT_MODE_NONE=0;CKEDITOR.ELEMENT_MODE_REPLACE=1;CKEDITOR.ELEMENT_MODE_APPENDTO=2;CKEDITOR.editor=function(instanceConfig,element,mode,data)
{this._={instanceConfig:instanceConfig,element:element,data:data};this.elementMode=mode||CKEDITOR.ELEMENT_MODE_NONE;CKEDITOR.event.call(this);this._init();};CKEDITOR.editor.replace=function(elementOrIdOrName,config)
{var element=elementOrIdOrName;if(typeof element!='object')
{element=document.getElementById(elementOrIdOrName);if(!element)
{var i=0,textareasByName=document.getElementsByName(elementOrIdOrName);while((element=textareasByName[i++])&&element.tagName.toLowerCase()!='textarea')
{}}
if(!element)
throw'[CKEDITOR.editor.replace] The element with id or name "'+elementOrIdOrName+'" was not found.';}
element.style.visibility='hidden';return new CKEDITOR.editor(config,element,CKEDITOR.ELEMENT_MODE_REPLACE);};CKEDITOR.editor.appendTo=function(elementOrId,config,data)
{var element=elementOrId;if(typeof element!='object')
{element=document.getElementById(elementOrId);if(!element)
throw'[CKEDITOR.editor.appendTo] The element with id "'+elementOrId+'" was not found.';}
return new CKEDITOR.editor(config,element,CKEDITOR.ELEMENT_MODE_APPENDTO,data);};CKEDITOR.editor.prototype={_init:function()
{var pending=CKEDITOR.editor._pending||(CKEDITOR.editor._pending=[]);pending.push(this);},fire:function(eventName,data)
{return CKEDITOR.event.prototype.fire.call(this,eventName,data,this);},fireOnce:function(eventName,data)
{return CKEDITOR.event.prototype.fireOnce.call(this,eventName,data,this);}};CKEDITOR.event.implementOn(CKEDITOR.editor.prototype,true);}
if(!CKEDITOR.env)
{CKEDITOR.env=(function()
{var agent=navigator.userAgent.toLowerCase();var opera=window.opera;var env={ie:(!+"\v1"),opera:(!!opera&&opera.version),webkit:(agent.indexOf(' applewebkit/')>-1),air:(agent.indexOf(' adobeair/')>-1),mac:(agent.indexOf('macintosh')>-1),quirks:(document.compatMode=='BackCompat'),mobile:(agent.indexOf('mobile')>-1),isCustomDomain:function()
{return this.ie&&document.domain!=window.location.hostname;}};env.gecko=(navigator.product=='Gecko'&&!env.webkit&&!env.opera);var version=0;if(env.ie)
{version=parseFloat(agent.match(/msie (\d+)/)[1]);env.ie8=!!document.documentMode;env.ie8Compat=document.documentMode==8;env.ie7Compat=((version==7&&!document.documentMode)||document.documentMode==7);env.ie6Compat=(version<7||env.quirks);}
if(env.gecko)
{var geckoRelease=agent.match(/rv:([\d\.]+)/);if(geckoRelease)
{geckoRelease=geckoRelease[1].split('.');version=geckoRelease[0]*10000+(geckoRelease[1]||0)*100+(geckoRelease[2]||0)*1;}}
if(env.opera)
version=parseFloat(opera.version());if(env.air)
version=parseFloat(agent.match(/ adobeair\/(\d+)/)[1]);if(env.webkit)
version=parseFloat(agent.match(/ applewebkit\/(\d+)/)[1]);env.version=version;env.isCompatible=!env.mobile&&((env.ie&&version>=6)||(env.gecko&&version>=10801)||(env.opera&&version>=9.5)||(env.air&&version>=1)||(env.webkit&&version>=522)||false);env.cssClass='cke_browser_'+(env.ie?'ie':env.gecko?'gecko':env.opera?'opera':env.air?'air':env.webkit?'webkit':'unknown');if(env.quirks)
env.cssClass+=' cke_browser_quirks';if(env.ie)
{env.cssClass+=' cke_browser_ie'+(env.version<7?'6':env.version>=8?'8':'7');if(env.quirks)
env.cssClass+=' cke_browser_iequirks';}
if(env.gecko&&version<10900)
env.cssClass+=' cke_browser_gecko18';return env;})();}
if(CKEDITOR.status=='unloaded')
{(function()
{CKEDITOR.event.implementOn(CKEDITOR);CKEDITOR.loadFullCore=function()
{if(CKEDITOR.status!='basic_ready')
{CKEDITOR.loadFullCore._load=true;return;}
delete CKEDITOR.loadFullCore;var script=document.createElement('script');script.type='text/javascript';script.src=CKEDITOR.basePath+'ckeditor.js';script.src=CKEDITOR.basePath+'ckeditor_source.js';document.getElementsByTagName('head')[0].appendChild(script);};CKEDITOR.loadFullCoreTimeout=0;CKEDITOR.replaceClass='ckeditor';CKEDITOR.replaceByClassEnabled=true;var createInstance=function(elementOrIdOrName,config,creationFunction,data)
{if(CKEDITOR.env.isCompatible)
{if(CKEDITOR.loadFullCore)
CKEDITOR.loadFullCore();var editor=creationFunction(elementOrIdOrName,config,data);CKEDITOR.add(editor);return editor;}
return null;};CKEDITOR.replace=function(elementOrIdOrName,config)
{return createInstance(elementOrIdOrName,config,CKEDITOR.editor.replace);};CKEDITOR.appendTo=function(elementOrId,config,data)
{return createInstance(elementOrId,config,CKEDITOR.editor.appendTo,data);};CKEDITOR.add=function(editor)
{var pending=this._.pending||(this._.pending=[]);pending.push(editor);};CKEDITOR.replaceAll=function()
{var textareas=document.getElementsByTagName('textarea');for(var i=0;i<textareas.length;i++)
{var config=null;var textarea=textareas[i];var name=textarea.name;if(!textarea.name&&!textarea.id)
continue;if(typeof arguments[0]=='string')
{var classRegex=new RegExp('(?:^| )'+arguments[0]+'(?:$| )');if(!classRegex.test(textarea.className))
continue;}
else if(typeof arguments[0]=='function')
{config={};if(arguments[0](textarea,config)===false)
continue;}
this.replace(textarea,config);}};(function()
{var onload=function()
{var loadFullCore=CKEDITOR.loadFullCore,loadFullCoreTimeout=CKEDITOR.loadFullCoreTimeout;if(CKEDITOR.replaceByClassEnabled)
CKEDITOR.replaceAll(CKEDITOR.replaceClass);CKEDITOR.status='basic_ready';if(loadFullCore&&loadFullCore._load)
loadFullCore();else if(loadFullCoreTimeout)
{setTimeout(function()
{if(CKEDITOR.loadFullCore)
CKEDITOR.loadFullCore();},loadFullCoreTimeout*1000);}};if(window.addEventListener)
window.addEventListener('load',onload,false);else if(window.attachEvent)
window.attachEvent('onload',onload);})();CKEDITOR.status='basic_loaded';})();}
CKEDITOR.dom={};(function()
{var functions=[];CKEDITOR.tools={arrayCompare:function(arrayA,arrayB)
{if(!arrayA&&!arrayB)
return true;if(!arrayA||!arrayB||arrayA.length!=arrayB.length)
return false;for(var i=0;i<arrayA.length;i++)
{if(arrayA[i]!=arrayB[i])
return false;}
return true;},clone:function(obj)
{var clone;if(obj&&(obj instanceof Array))
{clone=[];for(var i=0;i<obj.length;i++)
clone[i]=this.clone(obj[i]);return clone;}
if(obj===null||(typeof(obj)!='object')||(obj instanceof String)||(obj instanceof Number)||(obj instanceof Boolean)||(obj instanceof Date)||(obj instanceof RegExp))
{return obj;}
clone=new obj.constructor();for(var propertyName in obj)
{var property=obj[propertyName];clone[propertyName]=this.clone(property);}
return clone;},capitalize:function(str)
{return str.charAt(0).toUpperCase()+str.substring(1).toLowerCase();},extend:function(target)
{var argsLength=arguments.length,overwrite,propertiesList;if(typeof(overwrite=arguments[argsLength-1])=='boolean')
argsLength--;else if(typeof(overwrite=arguments[argsLength-2])=='boolean')
{propertiesList=arguments[argsLength-1];argsLength-=2;}
for(var i=1;i<argsLength;i++)
{var source=arguments[i];for(var propertyName in source)
{if(overwrite===true||target[propertyName]==undefined)
{if(!propertiesList||(propertyName in propertiesList))
target[propertyName]=source[propertyName];}}}
return target;},prototypedCopy:function(source)
{var copy=function()
{};copy.prototype=source;return new copy();},isArray:function(object)
{return(!!object&&object instanceof Array);},isEmpty:function(object)
{for(var i in object)
{if(object.hasOwnProperty(i))
return false;}
return true;},cssStyleToDomStyle:(function()
{var test=document.createElement('div').style;var cssFloat=(typeof test.cssFloat!='undefined')?'cssFloat':(typeof test.styleFloat!='undefined')?'styleFloat':'float';return function(cssName)
{if(cssName=='float')
return cssFloat;else
{return cssName.replace(/-./g,function(match)
{return match.substr(1).toUpperCase();});}};})(),buildStyleHtml:function(css)
{css=[].concat(css);var item,retval=[];for(var i=0;i<css.length;i++)
{item=css[i];if(/@import|[{}]/.test(item))
retval.push('<style>'+item+'</style>');else
retval.push('<link type="text/css" rel=stylesheet href="'+item+'">');}
return retval.join('');},htmlEncode:function(text)
{var standard=function(text)
{var span=new CKEDITOR.dom.element('span');span.setText(text);return span.getHtml();};var fix1=(standard('\n').toLowerCase()=='<br>')?function(text)
{return standard(text).replace(/<br>/gi,'\n');}:standard;var fix2=(standard('>')=='>')?function(text)
{return fix1(text).replace(/>/g,'&gt;');}:fix1;var fix3=(standard('  ')=='&nbsp; ')?function(text)
{return fix2(text).replace(/&nbsp;/g,' ');}:fix2;this.htmlEncode=fix3;return this.htmlEncode(text);},htmlEncodeAttr:function(text)
{return text.replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/,'&gt;');},escapeCssSelector:function(cssSelectText)
{return cssSelectText.replace(/[\s#:.,$*^\[\]()~=+>]/g,'\\$&');},getNextNumber:(function()
{var last=0;return function()
{return++last;};})(),override:function(originalFunction,functionBuilder)
{return functionBuilder(originalFunction);},setTimeout:function(func,milliseconds,scope,args,ownerWindow)
{if(!ownerWindow)
ownerWindow=window;if(!scope)
scope=ownerWindow;return ownerWindow.setTimeout(function()
{if(args)
func.apply(scope,[].concat(args));else
func.apply(scope);},milliseconds||0);},trim:(function()
{var trimRegex=/(?:^[ \t\n\r]+)|(?:[ \t\n\r]+$)/g;return function(str)
{return str.replace(trimRegex,'');};})(),ltrim:(function()
{var trimRegex=/^[ \t\n\r]+/g;return function(str)
{return str.replace(trimRegex,'');};})(),rtrim:(function()
{var trimRegex=/[ \t\n\r]+$/g;return function(str)
{return str.replace(trimRegex,'');};})(),indexOf:(Array.prototype.indexOf)?function(array,entry)
{return array.indexOf(entry);}:function(array,entry)
{for(var i=0,len=array.length;i<len;i++)
{if(array[i]===entry)
return i;}
return-1;},bind:function(func,obj)
{return function(){return func.apply(obj,arguments);};},createClass:function(definition)
{var $=definition.$,baseClass=definition.base,privates=definition.privates||definition._,proto=definition.proto,statics=definition.statics;if(privates)
{var originalConstructor=$;$=function()
{var _=this._||(this._={});for(var privateName in privates)
{var priv=privates[privateName];_[privateName]=(typeof priv=='function')?CKEDITOR.tools.bind(priv,this):priv;}
originalConstructor.apply(this,arguments);};}
if(baseClass)
{$.prototype=this.prototypedCopy(baseClass.prototype);$.prototype.constructor=$;$.prototype.base=function()
{this.base=baseClass.prototype.base;baseClass.apply(this,arguments);this.base=arguments.callee;};}
if(proto)
this.extend($.prototype,proto,true);if(statics)
this.extend($,statics,true);return $;},addFunction:function(fn,scope)
{return functions.push(function()
{fn.apply(scope||this,arguments);})-1;},removeFunction:function(ref)
{functions[ref]=null;},callFunction:function(ref)
{var fn=functions[ref];return fn&&fn.apply(window,Array.prototype.slice.call(arguments,1));},cssLength:(function()
{var decimalRegex=/^\d+(?:\.\d+)?$/;return function(length)
{return length+(decimalRegex.test(length)?'px':'');};})(),repeat:function(str,times)
{return new Array(times+1).join(str);},tryThese:function()
{var returnValue;for(var i=0,length=arguments.length;i<length;i++)
{var lambda=arguments[i];try
{returnValue=lambda();break;}
catch(e){}}
return returnValue;}};})();CKEDITOR.dtd=(function()
{var X=CKEDITOR.tools.extend,A={isindex:1,fieldset:1},B={input:1,button:1,select:1,textarea:1,label:1},C=X({a:1},B),D=X({iframe:1},C),E={hr:1,ul:1,menu:1,div:1,blockquote:1,noscript:1,table:1,center:1,address:1,dir:1,pre:1,h5:1,dl:1,h4:1,noframes:1,h6:1,ol:1,h1:1,h3:1,h2:1},F={ins:1,del:1,script:1,style:1},G=X({b:1,acronym:1,bdo:1,'var':1,'#':1,abbr:1,code:1,br:1,i:1,cite:1,kbd:1,u:1,strike:1,s:1,tt:1,strong:1,q:1,samp:1,em:1,dfn:1,span:1},F),H=X({sub:1,img:1,object:1,sup:1,basefont:1,map:1,applet:1,font:1,big:1,small:1},G),I=X({p:1},H),J=X({iframe:1},H,B),K={img:1,noscript:1,br:1,kbd:1,center:1,button:1,basefont:1,h5:1,h4:1,samp:1,h6:1,ol:1,h1:1,h3:1,h2:1,form:1,font:1,'#':1,select:1,menu:1,ins:1,abbr:1,label:1,code:1,table:1,script:1,cite:1,input:1,iframe:1,strong:1,textarea:1,noframes:1,big:1,small:1,span:1,hr:1,sub:1,bdo:1,'var':1,div:1,object:1,sup:1,strike:1,dir:1,map:1,dl:1,applet:1,del:1,isindex:1,fieldset:1,ul:1,b:1,acronym:1,a:1,blockquote:1,i:1,u:1,s:1,tt:1,address:1,q:1,pre:1,p:1,em:1,dfn:1},L=X({a:1},J),M={tr:1},N={'#':1},O=X({param:1},K),P=X({form:1},A,D,E,I),Q={li:1},R={style:1,script:1},S={base:1,link:1,meta:1,title:1},T=X(S,R),U={head:1,body:1},V={html:1};var block={address:1,blockquote:1,center:1,dir:1,div:1,dl:1,fieldset:1,form:1,h1:1,h2:1,h3:1,h4:1,h5:1,h6:1,hr:1,isindex:1,menu:1,noframes:1,ol:1,p:1,pre:1,table:1,ul:1};return{$nonBodyContent:X(V,U,S),$block:block,$blockLimit:{body:1,div:1,td:1,th:1,caption:1,form:1},$inline:L,$body:X({script:1,style:1},block),$cdata:{script:1,style:1},$empty:{area:1,base:1,br:1,col:1,hr:1,img:1,input:1,link:1,meta:1,param:1},$listItem:{dd:1,dt:1,li:1},$list:{ul:1,ol:1,dl:1},$nonEditable:{applet:1,button:1,embed:1,iframe:1,map:1,object:1,option:1,script:1,textarea:1,param:1},$removeEmpty:{abbr:1,acronym:1,address:1,b:1,bdo:1,big:1,cite:1,code:1,del:1,dfn:1,em:1,font:1,i:1,ins:1,label:1,kbd:1,q:1,s:1,samp:1,small:1,span:1,strike:1,strong:1,sub:1,sup:1,tt:1,u:1,'var':1},$tabIndex:{a:1,area:1,button:1,input:1,object:1,select:1,textarea:1},$tableContent:{caption:1,col:1,colgroup:1,tbody:1,td:1,tfoot:1,th:1,thead:1,tr:1},html:U,head:T,style:N,script:N,body:P,base:{},link:{},meta:{},title:N,col:{},tr:{td:1,th:1},img:{},colgroup:{col:1},noscript:P,td:P,br:{},th:P,center:P,kbd:L,button:X(I,E),basefont:{},h5:L,h4:L,samp:L,h6:L,ol:Q,h1:L,h3:L,option:N,h2:L,form:X(A,D,E,I),select:{optgroup:1,option:1},font:L,ins:L,menu:Q,abbr:L,label:L,table:{thead:1,col:1,tbody:1,tr:1,colgroup:1,caption:1,tfoot:1},code:L,script:N,tfoot:M,cite:L,li:P,input:{},iframe:P,strong:L,textarea:N,noframes:P,big:L,small:L,span:L,hr:{},dt:L,sub:L,optgroup:{option:1},param:{},bdo:L,'var':L,div:P,object:O,sup:L,dd:P,strike:L,area:{},dir:Q,map:X({area:1,form:1,p:1},A,F,E),applet:O,dl:{dt:1,dd:1},del:L,isindex:{},fieldset:X({legend:1},K),thead:M,ul:Q,acronym:L,b:L,a:J,blockquote:P,caption:L,i:L,u:L,tbody:M,s:L,address:X(D,I),tt:L,legend:L,q:L,pre:X(G,C),p:L,em:L,dfn:L};})();CKEDITOR.dom.event=function(domEvent)
{this.$=domEvent;};CKEDITOR.dom.event.prototype={getKey:function()
{return this.$.keyCode||this.$.which;},getKeystroke:function()
{var keystroke=this.getKey();if(this.$.ctrlKey||this.$.metaKey)
keystroke+=CKEDITOR.CTRL;if(this.$.shiftKey)
keystroke+=CKEDITOR.SHIFT;if(this.$.altKey)
keystroke+=CKEDITOR.ALT;return keystroke;},preventDefault:function(stopPropagation)
{var $=this.$;if($.preventDefault)
$.preventDefault();else
$.returnValue=false;if(stopPropagation)
this.stopPropagation();},stopPropagation:function()
{var $=this.$;if($.stopPropagation)
$.stopPropagation();else
$.cancelBubble=true;},getTarget:function()
{var rawNode=this.$.target||this.$.srcElement;return rawNode?new CKEDITOR.dom.node(rawNode):null;}};CKEDITOR.CTRL=1000;CKEDITOR.SHIFT=2000;CKEDITOR.ALT=4000;CKEDITOR.dom.domObject=function(nativeDomObject)
{if(nativeDomObject)
{this.$=nativeDomObject;}};CKEDITOR.dom.domObject.prototype=(function()
{var getNativeListener=function(domObject,eventName)
{return function(domEvent)
{if(typeof CKEDITOR!='undefined')
domObject.fire(eventName,new CKEDITOR.dom.event(domEvent));};};return{getPrivate:function()
{var priv;if(!(priv=this.getCustomData('_')))
this.setCustomData('_',(priv={}));return priv;},on:function(eventName)
{var nativeListeners=this.getCustomData('_cke_nativeListeners');if(!nativeListeners)
{nativeListeners={};this.setCustomData('_cke_nativeListeners',nativeListeners);}
if(!nativeListeners[eventName])
{var listener=nativeListeners[eventName]=getNativeListener(this,eventName);if(this.$.addEventListener)
this.$.addEventListener(eventName,listener,!!CKEDITOR.event.useCapture);else if(this.$.attachEvent)
this.$.attachEvent('on'+eventName,listener);}
return CKEDITOR.event.prototype.on.apply(this,arguments);},removeListener:function(eventName)
{CKEDITOR.event.prototype.removeListener.apply(this,arguments);if(!this.hasListeners(eventName))
{var nativeListeners=this.getCustomData('_cke_nativeListeners');var listener=nativeListeners&&nativeListeners[eventName];if(listener)
{if(this.$.removeEventListener)
this.$.removeEventListener(eventName,listener,false);else if(this.$.detachEvent)
this.$.detachEvent('on'+eventName,listener);delete nativeListeners[eventName];}}},removeAllListeners:function()
{var nativeListeners=this.getCustomData('_cke_nativeListeners');for(var eventName in nativeListeners)
{var listener=nativeListeners[eventName];if(this.$.removeEventListener)
this.$.removeEventListener(eventName,listener,false);else if(this.$.detachEvent)
this.$.detachEvent('on'+eventName,listener);delete nativeListeners[eventName];}}};})();(function(domObjectProto)
{var customData={};domObjectProto.equals=function(object)
{return(object&&object.$===this.$);};domObjectProto.setCustomData=function(key,value)
{var expandoNumber=this.getUniqueId(),dataSlot=customData[expandoNumber]||(customData[expandoNumber]={});dataSlot[key]=value;return this;};domObjectProto.getCustomData=function(key)
{var expandoNumber=this.$._cke_expando,dataSlot=expandoNumber&&customData[expandoNumber];return dataSlot&&dataSlot[key];};domObjectProto.removeCustomData=function(key)
{var expandoNumber=this.$._cke_expando,dataSlot=expandoNumber&&customData[expandoNumber],retval=dataSlot&&dataSlot[key];if(typeof retval!='undefined')
delete dataSlot[key];return retval||null;};domObjectProto.clearCustomData=function()
{this.removeAllListeners();var expandoNumber=this.$._cke_expando;expandoNumber&&delete customData[expandoNumber];};domObjectProto.getUniqueId=function()
{return this.$._cke_expando||(this.$._cke_expando=CKEDITOR.tools.getNextNumber());};CKEDITOR.event.implementOn(domObjectProto);})(CKEDITOR.dom.domObject.prototype);CKEDITOR.dom.window=function(domWindow)
{CKEDITOR.dom.domObject.call(this,domWindow);};CKEDITOR.dom.window.prototype=new CKEDITOR.dom.domObject();CKEDITOR.tools.extend(CKEDITOR.dom.window.prototype,{focus:function()
{if(CKEDITOR.env.webkit&&this.$.parent)
this.$.parent.focus();this.$.focus();},getViewPaneSize:function()
{var doc=this.$.document,stdMode=doc.compatMode=='CSS1Compat';return{width:(stdMode?doc.documentElement.clientWidth:doc.body.clientWidth)||0,height:(stdMode?doc.documentElement.clientHeight:doc.body.clientHeight)||0};},getScrollPosition:function()
{var $=this.$;if('pageXOffset'in $)
{return{x:$.pageXOffset||0,y:$.pageYOffset||0};}
else
{var doc=$.document;return{x:doc.documentElement.scrollLeft||doc.body.scrollLeft||0,y:doc.documentElement.scrollTop||doc.body.scrollTop||0};}}});CKEDITOR.dom.document=function(domDocument)
{CKEDITOR.dom.domObject.call(this,domDocument);};CKEDITOR.dom.document.prototype=new CKEDITOR.dom.domObject();CKEDITOR.tools.extend(CKEDITOR.dom.document.prototype,{appendStyleSheet:function(cssFileUrl)
{if(this.$.createStyleSheet)
this.$.createStyleSheet(cssFileUrl);else
{var link=new CKEDITOR.dom.element('link');link.setAttributes({rel:'stylesheet',type:'text/css',href:cssFileUrl});this.getHead().append(link);}},appendStyleText:function(cssStyleText)
{if(this.$.createStyleSheet)
{var styleSheet=this.$.createStyleSheet("");styleSheet.cssText=cssStyleText;}
else
{var style=new CKEDITOR.dom.element('style',this);style.append(new CKEDITOR.dom.text(cssStyleText,this));this.getHead().append(style);}},createElement:function(name,attribsAndStyles)
{var element=new CKEDITOR.dom.element(name,this);if(attribsAndStyles)
{if(attribsAndStyles.attributes)
element.setAttributes(attribsAndStyles.attributes);if(attribsAndStyles.styles)
element.setStyles(attribsAndStyles.styles);}
return element;},createText:function(text)
{return new CKEDITOR.dom.text(text,this);},focus:function()
{this.getWindow().focus();},getById:function(elementId)
{var $=this.$.getElementById(elementId);return $?new CKEDITOR.dom.element($):null;},getByAddress:function(address,normalized)
{var $=this.$.documentElement;for(var i=0;$&&i<address.length;i++)
{var target=address[i];if(!normalized)
{$=$.childNodes[target];continue;}
var currentIndex=-1;for(var j=0;j<$.childNodes.length;j++)
{var candidate=$.childNodes[j];if(normalized===true&&candidate.nodeType==3&&candidate.previousSibling&&candidate.previousSibling.nodeType==3)
{continue;}
currentIndex++;if(currentIndex==target)
{$=candidate;break;}}}
return $?new CKEDITOR.dom.node($):null;},getElementsByTag:function(tagName,namespace)
{if(!CKEDITOR.env.ie&&namespace)
tagName=namespace+':'+tagName;return new CKEDITOR.dom.nodeList(this.$.getElementsByTagName(tagName));},getHead:function()
{var head=this.$.getElementsByTagName('head')[0];head=new CKEDITOR.dom.element(head);return(this.getHead=function()
{return head;})();},getBody:function()
{var body=new CKEDITOR.dom.element(this.$.body);return(this.getBody=function()
{return body;})();},getDocumentElement:function()
{var documentElement=new CKEDITOR.dom.element(this.$.documentElement);return(this.getDocumentElement=function()
{return documentElement;})();},getWindow:function()
{var win=new CKEDITOR.dom.window(this.$.parentWindow||this.$.defaultView);return(this.getWindow=function()
{return win;})();}});CKEDITOR.dom.node=function(domNode)
{if(domNode)
{switch(domNode.nodeType)
{case CKEDITOR.NODE_DOCUMENT:return new CKEDITOR.dom.document(domNode);case CKEDITOR.NODE_ELEMENT:return new CKEDITOR.dom.element(domNode);case CKEDITOR.NODE_TEXT:return new CKEDITOR.dom.text(domNode);}
CKEDITOR.dom.domObject.call(this,domNode);}
return this;};CKEDITOR.dom.node.prototype=new CKEDITOR.dom.domObject();CKEDITOR.NODE_ELEMENT=1;CKEDITOR.NODE_DOCUMENT=9;CKEDITOR.NODE_TEXT=3;CKEDITOR.NODE_COMMENT=8;CKEDITOR.NODE_DOCUMENT_FRAGMENT=11;CKEDITOR.POSITION_IDENTICAL=0;CKEDITOR.POSITION_DISCONNECTED=1;CKEDITOR.POSITION_FOLLOWING=2;CKEDITOR.POSITION_PRECEDING=4;CKEDITOR.POSITION_IS_CONTAINED=8;CKEDITOR.POSITION_CONTAINS=16;CKEDITOR.tools.extend(CKEDITOR.dom.node.prototype,{appendTo:function(element,toStart)
{element.append(this,toStart);return element;},clone:function(includeChildren,cloneId)
{var $clone=this.$.cloneNode(includeChildren);if(!cloneId)
{var removeIds=function(node)
{if(node.nodeType!=CKEDITOR.NODE_ELEMENT)
return;node.removeAttribute('id',false);node.removeAttribute('_cke_expando',false);var childs=node.childNodes;for(var i=0;i<childs.length;i++)
removeIds(childs[i]);};removeIds($clone);}
return new CKEDITOR.dom.node($clone);},hasPrevious:function()
{return!!this.$.previousSibling;},hasNext:function()
{return!!this.$.nextSibling;},insertAfter:function(node)
{node.$.parentNode.insertBefore(this.$,node.$.nextSibling);return node;},insertBefore:function(node)
{node.$.parentNode.insertBefore(this.$,node.$);return node;},insertBeforeMe:function(node)
{this.$.parentNode.insertBefore(node.$,this.$);return node;},getAddress:function(normalized)
{var address=[];var $documentElement=this.getDocument().$.documentElement;var node=this.$;while(node&&node!=$documentElement)
{var parentNode=node.parentNode;var currentIndex=-1;if(parentNode)
{for(var i=0;i<parentNode.childNodes.length;i++)
{var candidate=parentNode.childNodes[i];if(normalized&&candidate.nodeType==3&&candidate.previousSibling&&candidate.previousSibling.nodeType==3)
{continue;}
currentIndex++;if(candidate==node)
break;}
address.unshift(currentIndex);}
node=parentNode;}
return address;},getDocument:function()
{var document=new CKEDITOR.dom.document(this.$.ownerDocument||this.$.parentNode.ownerDocument);return(this.getDocument=function()
{return document;})();},getIndex:function()
{var $=this.$;var currentNode=$.parentNode&&$.parentNode.firstChild;var currentIndex=-1;while(currentNode)
{currentIndex++;if(currentNode==$)
return currentIndex;currentNode=currentNode.nextSibling;}
return-1;},getNextSourceNode:function(startFromSibling,nodeType,guard)
{if(guard&&!guard.call)
{var guardNode=guard;guard=function(node)
{return!node.equals(guardNode);};}
var node=(!startFromSibling&&this.getFirst&&this.getFirst()),parent;if(!node)
{if(this.type==CKEDITOR.NODE_ELEMENT&&guard&&guard(this,true)===false)
return null;node=this.getNext();}
while(!node&&(parent=(parent||this).getParent()))
{if(guard&&guard(parent,true)===false)
return null;node=parent.getNext();}
if(!node)
return null;if(guard&&guard(node)===false)
return null;if(nodeType&&nodeType!=node.type)
return node.getNextSourceNode(false,nodeType,guard);return node;},getPreviousSourceNode:function(startFromSibling,nodeType,guard)
{if(guard&&!guard.call)
{var guardNode=guard;guard=function(node)
{return!node.equals(guardNode);};}
var node=(!startFromSibling&&this.getLast&&this.getLast()),parent;if(!node)
{if(this.type==CKEDITOR.NODE_ELEMENT&&guard&&guard(this,true)===false)
return null;node=this.getPrevious();}
while(!node&&(parent=(parent||this).getParent()))
{if(guard&&guard(parent,true)===false)
return null;node=parent.getPrevious();}
if(!node)
return null;if(guard&&guard(node)===false)
return null;if(nodeType&&node.type!=nodeType)
return node.getPreviousSourceNode(false,nodeType,guard);return node;},getPrevious:function(evaluator)
{var previous=this.$,retval;do
{previous=previous.previousSibling;retval=previous&&new CKEDITOR.dom.node(previous);}
while(retval&&evaluator&&!evaluator(retval))
return retval;},getNext:function(evaluator)
{var next=this.$,retval;do
{next=next.nextSibling;retval=next&&new CKEDITOR.dom.node(next);}
while(retval&&evaluator&&!evaluator(retval))
return retval;},getParent:function()
{var parent=this.$.parentNode;return(parent&&parent.nodeType==1)?new CKEDITOR.dom.node(parent):null;},getParents:function(closerFirst)
{var node=this;var parents=[];do
{parents[closerFirst?'push':'unshift'](node);}
while((node=node.getParent()))
return parents;},getCommonAncestor:function(node)
{if(node.equals(this))
return this;if(node.contains&&node.contains(this))
return node;var start=this.contains?this:this.getParent();do
{if(start.contains(node))
return start;}
while((start=start.getParent()));return null;},getPosition:function(otherNode)
{var $=this.$;var $other=otherNode.$;if($.compareDocumentPosition)
return $.compareDocumentPosition($other);if($==$other)
return CKEDITOR.POSITION_IDENTICAL;if(this.type==CKEDITOR.NODE_ELEMENT&&otherNode.type==CKEDITOR.NODE_ELEMENT)
{if($.contains)
{if($.contains($other))
return CKEDITOR.POSITION_CONTAINS+CKEDITOR.POSITION_PRECEDING;if($other.contains($))
return CKEDITOR.POSITION_IS_CONTAINED+CKEDITOR.POSITION_FOLLOWING;}
if('sourceIndex'in $)
{return($.sourceIndex<0||$other.sourceIndex<0)?CKEDITOR.POSITION_DISCONNECTED:($.sourceIndex<$other.sourceIndex)?CKEDITOR.POSITION_PRECEDING:CKEDITOR.POSITION_FOLLOWING;}}
var addressOfThis=this.getAddress(),addressOfOther=otherNode.getAddress(),minLevel=Math.min(addressOfThis.length,addressOfOther.length);for(var i=0;i<=minLevel-1;i++)
{if(addressOfThis[i]!=addressOfOther[i])
{if(i<minLevel)
{return addressOfThis[i]<addressOfOther[i]?CKEDITOR.POSITION_PRECEDING:CKEDITOR.POSITION_FOLLOWING;}
break;}}
return(addressOfThis.length<addressOfOther.length)?CKEDITOR.POSITION_CONTAINS+CKEDITOR.POSITION_PRECEDING:CKEDITOR.POSITION_IS_CONTAINED+CKEDITOR.POSITION_FOLLOWING;},getAscendant:function(name,includeSelf)
{var $=this.$;if(!includeSelf)
$=$.parentNode;while($)
{if($.nodeName&&$.nodeName.toLowerCase()==name)
return new CKEDITOR.dom.node($);$=$.parentNode;}
return null;},hasAscendant:function(name,includeSelf)
{var $=this.$;if(!includeSelf)
$=$.parentNode;while($)
{if($.nodeName&&$.nodeName.toLowerCase()==name)
return true;$=$.parentNode;}
return false;},move:function(target,toStart)
{target.append(this.remove(),toStart);},remove:function(preserveChildren)
{var $=this.$;var parent=$.parentNode;if(parent)
{if(preserveChildren)
{for(var child;(child=$.firstChild);)
{parent.insertBefore($.removeChild(child),$);}}
parent.removeChild($);}
return this;},replace:function(nodeToReplace)
{this.insertBefore(nodeToReplace);nodeToReplace.remove();},trim:function()
{this.ltrim();this.rtrim();},ltrim:function()
{var child;while(this.getFirst&&(child=this.getFirst()))
{if(child.type==CKEDITOR.NODE_TEXT)
{var trimmed=CKEDITOR.tools.ltrim(child.getText()),originalLength=child.getLength();if(!trimmed)
{child.remove();continue;}
else if(trimmed.length<originalLength)
{child.split(originalLength-trimmed.length);this.$.removeChild(this.$.firstChild);}}
break;}},rtrim:function()
{var child;while(this.getLast&&(child=this.getLast()))
{if(child.type==CKEDITOR.NODE_TEXT)
{var trimmed=CKEDITOR.tools.rtrim(child.getText()),originalLength=child.getLength();if(!trimmed)
{child.remove();continue;}
else if(trimmed.length<originalLength)
{child.split(trimmed.length);this.$.lastChild.parentNode.removeChild(this.$.lastChild);}}
break;}
if(!CKEDITOR.env.ie&&!CKEDITOR.env.opera)
{child=this.$.lastChild;if(child&&child.type==1&&child.nodeName.toLowerCase()=='br')
{child.parentNode.removeChild(child);}}}});CKEDITOR.dom.nodeList=function(nativeList)
{this.$=nativeList;};CKEDITOR.dom.nodeList.prototype={count:function()
{return this.$.length;},getItem:function(index)
{var $node=this.$[index];return $node?new CKEDITOR.dom.node($node):null;}};CKEDITOR.dom.element=function(element,ownerDocument)
{if(typeof element=='string')
element=(ownerDocument?ownerDocument.$:document).createElement(element);CKEDITOR.dom.domObject.call(this,element);};CKEDITOR.dom.element.get=function(element)
{return element&&(element.$?element:new CKEDITOR.dom.element(element));};CKEDITOR.dom.element.prototype=new CKEDITOR.dom.node();CKEDITOR.dom.element.createFromHtml=function(html,ownerDocument)
{var temp=new CKEDITOR.dom.element('div',ownerDocument);temp.setHtml(html);return temp.getFirst().remove();};CKEDITOR.dom.element.setMarker=function(database,element,name,value)
{var id=element.getCustomData('list_marker_id')||(element.setCustomData('list_marker_id',CKEDITOR.tools.getNextNumber()).getCustomData('list_marker_id')),markerNames=element.getCustomData('list_marker_names')||(element.setCustomData('list_marker_names',{}).getCustomData('list_marker_names'));database[id]=element;markerNames[name]=1;return element.setCustomData(name,value);};CKEDITOR.dom.element.clearAllMarkers=function(database)
{for(var i in database)
CKEDITOR.dom.element.clearMarkers(database,database[i],true);};CKEDITOR.dom.element.clearMarkers=function(database,element,removeFromDatabase)
{var names=element.getCustomData('list_marker_names'),id=element.getCustomData('list_marker_id');for(var i in names)
element.removeCustomData(i);element.removeCustomData('list_marker_names');if(removeFromDatabase)
{element.removeCustomData('list_marker_id');delete database[id];}};CKEDITOR.tools.extend(CKEDITOR.dom.element.prototype,{type:CKEDITOR.NODE_ELEMENT,addClass:function(className)
{var c=this.$.className;if(c)
{var regex=new RegExp('(?:^|\\s)'+className+'(?:\\s|$)','');if(!regex.test(c))
c+=' '+className;}
this.$.className=c||className;},removeClass:function(className)
{var c=this.getAttribute('class');if(c)
{var regex=new RegExp('(?:^|\\s+)'+className+'(?=\\s|$)','i');if(regex.test(c))
{c=c.replace(regex,'').replace(/^\s+/,'');if(c)
this.setAttribute('class',c);else
this.removeAttribute('class');}}},hasClass:function(className)
{var regex=new RegExp('(?:^|\\s+)'+className+'(?=\\s|$)','');return regex.test(this.getAttribute('class'));},append:function(node,toStart)
{if(typeof node=='string')
node=this.getDocument().createElement(node);if(toStart)
this.$.insertBefore(node.$,this.$.firstChild);else
this.$.appendChild(node.$);return node;},appendHtml:function(html)
{if(!this.$.childNodes.length)
this.setHtml(html);else
{var temp=new CKEDITOR.dom.element('div',this.getDocument());temp.setHtml(html);temp.moveChildren(this);}},appendText:function(text)
{if(this.$.text!=undefined)
this.$.text+=text;else
this.append(new CKEDITOR.dom.text(text));},appendBogus:function()
{var lastChild=this.getLast();while(lastChild&&lastChild.type==CKEDITOR.NODE_TEXT&&!CKEDITOR.tools.rtrim(lastChild.getText()))
lastChild=lastChild.getPrevious();if(!lastChild||!lastChild.is||!lastChild.is('br'))
{var bogus=CKEDITOR.env.opera?this.getDocument().createText(''):this.getDocument().createElement('br');CKEDITOR.env.gecko&&bogus.setAttribute('type','_moz');this.append(bogus);}},breakParent:function(parent)
{var range=new CKEDITOR.dom.range(this.getDocument());range.setStartAfter(this);range.setEndAfter(parent);var docFrag=range.extractContents();range.insertNode(this.remove());docFrag.insertAfterNode(this);},contains:CKEDITOR.env.ie||CKEDITOR.env.webkit?function(node)
{var $=this.$;return node.type!=CKEDITOR.NODE_ELEMENT?$.contains(node.getParent().$):$!=node.$&&$.contains(node.$);}:function(node)
{return!!(this.$.compareDocumentPosition(node.$)&16);},focus:function()
{try
{this.$.focus();}
catch(e)
{}},getHtml:function()
{var retval=this.$.innerHTML;return CKEDITOR.env.ie?retval.replace(/<\?[^>]*>/g,''):retval;},getOuterHtml:function()
{if(this.$.outerHTML)
{return this.$.outerHTML.replace(/<\?[^>]*>/,'');}
var tmpDiv=this.$.ownerDocument.createElement('div');tmpDiv.appendChild(this.$.cloneNode(true));return tmpDiv.innerHTML;},setHtml:function(html)
{return(this.$.innerHTML=html);},setText:function(text)
{CKEDITOR.dom.element.prototype.setText=(this.$.innerText!=undefined)?function(text)
{return this.$.innerText=text;}:function(text)
{return this.$.textContent=text;};return this.setText(text);},getAttribute:(function()
{var standard=function(name)
{return this.$.getAttribute(name,2);};if(CKEDITOR.env.ie&&(CKEDITOR.env.ie7Compat||CKEDITOR.env.ie6Compat))
{return function(name)
{switch(name)
{case'class':name='className';break;case'tabindex':var tabIndex=standard.call(this,name);if(tabIndex!==0&&this.$.tabIndex===0)
tabIndex=null;return tabIndex;break;case'checked':{var attr=this.$.attributes.getNamedItem(name),attrValue=attr.specified?attr.nodeValue:this.$.checked;return attrValue?'checked':null;}
case'hspace':return this.$.hspace;case'style':return this.$.style.cssText;}
return standard.call(this,name);};}
else
return standard;})(),getChildren:function()
{return new CKEDITOR.dom.nodeList(this.$.childNodes);},getComputedStyle:CKEDITOR.env.ie?function(propertyName)
{return this.$.currentStyle[CKEDITOR.tools.cssStyleToDomStyle(propertyName)];}:function(propertyName)
{return this.getWindow().$.getComputedStyle(this.$,'').getPropertyValue(propertyName);},getDtd:function()
{var dtd=CKEDITOR.dtd[this.getName()];this.getDtd=function()
{return dtd;};return dtd;},getElementsByTag:CKEDITOR.dom.document.prototype.getElementsByTag,getTabIndex:CKEDITOR.env.ie?function()
{var tabIndex=this.$.tabIndex;if(tabIndex===0&&!CKEDITOR.dtd.$tabIndex[this.getName()]&&parseInt(this.getAttribute('tabindex'),10)!==0)
tabIndex=-1;return tabIndex;}:CKEDITOR.env.webkit?function()
{var tabIndex=this.$.tabIndex;if(tabIndex==undefined)
{tabIndex=parseInt(this.getAttribute('tabindex'),10);if(isNaN(tabIndex))
tabIndex=-1;}
return tabIndex;}:function()
{return this.$.tabIndex;},getText:function()
{return this.$.textContent||this.$.innerText||'';},getWindow:function()
{return this.getDocument().getWindow();},getId:function()
{return this.$.id||null;},getNameAtt:function()
{return this.$.name||null;},getName:function()
{var nodeName=this.$.nodeName.toLowerCase();if(CKEDITOR.env.ie)
{var scopeName=this.$.scopeName;if(typeof scopeName!='undefined'&&scopeName!='HTML')
nodeName=scopeName.toLowerCase()+':'+nodeName;}
return(this.getName=function()
{return nodeName;})();},getValue:function()
{return this.$.value;},getFirst:function(evaluator)
{var first=this.$.firstChild,retval=first&&new CKEDITOR.dom.node(first);if(retval&&evaluator&&!evaluator(retval))
retval=retval.getNext(evaluator);return retval;},getLast:function(evaluator)
{var last=this.$.lastChild,retval=last&&new CKEDITOR.dom.node(last);if(retval&&evaluator&&!evaluator(retval))
retval=retval.getPrevious(evaluator);return retval;},getStyle:function(name)
{return this.$.style[CKEDITOR.tools.cssStyleToDomStyle(name)];},is:function()
{var name=this.getName();for(var i=0;i<arguments.length;i++)
{if(arguments[i]==name)
return true;}
return false;},isEditable:function()
{var name=this.getName();var dtd=!CKEDITOR.dtd.$nonEditable[name]&&(CKEDITOR.dtd[name]||CKEDITOR.dtd.span);return(dtd&&dtd['#']);},isIdentical:function(otherElement)
{if(this.getName()!=otherElement.getName())
return false;var thisAttribs=this.$.attributes,otherAttribs=otherElement.$.attributes;var thisLength=thisAttribs.length,otherLength=otherAttribs.length;if(!CKEDITOR.env.ie&&thisLength!=otherLength)
return false;for(var i=0;i<thisLength;i++)
{var attribute=thisAttribs[i];if((!CKEDITOR.env.ie||(attribute.specified&&attribute.nodeName!='_cke_expando'))&&attribute.nodeValue!=otherElement.getAttribute(attribute.nodeName))
return false;}
if(CKEDITOR.env.ie)
{for(i=0;i<otherLength;i++)
{attribute=otherAttribs[i];if(attribute.specified&&attribute.nodeName!='_cke_expando'&&attribute.nodeValue!=this.getAttribute(attribute.nodeName))
return false;}}
return true;},isVisible:function()
{var isVisible=!!this.$.offsetHeight&&this.getComputedStyle('visibility')!='hidden',elementWindow,elementWindowFrame;if(isVisible&&(CKEDITOR.env.webkit||CKEDITOR.env.opera))
{elementWindow=this.getWindow();if(!elementWindow.equals(CKEDITOR.document.getWindow())&&(elementWindowFrame=elementWindow.$.frameElement))
{isVisible=new CKEDITOR.dom.element(elementWindowFrame).isVisible();}}
return isVisible;},hasAttributes:CKEDITOR.env.ie&&(CKEDITOR.env.ie7Compat||CKEDITOR.env.ie6Compat)?function()
{var attributes=this.$.attributes;for(var i=0;i<attributes.length;i++)
{var attribute=attributes[i];switch(attribute.nodeName)
{case'class':if(this.getAttribute('class'))
return true;case'_cke_expando':continue;default:if(attribute.specified)
return true;}}
return false;}:function()
{var attributes=this.$.attributes;return(attributes.length>1||(attributes.length==1&&attributes[0].nodeName!='_cke_expando'));},hasAttribute:function(name)
{var $attr=this.$.attributes.getNamedItem(name);return!!($attr&&$attr.specified);},hide:function()
{this.setStyle('display','none');},moveChildren:function(target,toStart)
{var $=this.$;target=target.$;if($==target)
return;var child;if(toStart)
{while((child=$.lastChild))
target.insertBefore($.removeChild(child),target.firstChild);}
else
{while((child=$.firstChild))
target.appendChild($.removeChild(child));}},show:function()
{this.setStyles({display:'',visibility:''});},setAttribute:(function()
{var standard=function(name,value)
{this.$.setAttribute(name,value);return this;};if(CKEDITOR.env.ie&&(CKEDITOR.env.ie7Compat||CKEDITOR.env.ie6Compat))
{return function(name,value)
{if(name=='class')
this.$.className=value;else if(name=='style')
this.$.style.cssText=value;else if(name=='tabindex')
this.$.tabIndex=value;else if(name=='checked')
this.$.checked=value;else
standard.apply(this,arguments);return this;};}
else
return standard;})(),setAttributes:function(attributesPairs)
{for(var name in attributesPairs)
this.setAttribute(name,attributesPairs[name]);return this;},setValue:function(value)
{this.$.value=value;return this;},removeAttribute:(function()
{var standard=function(name)
{this.$.removeAttribute(name);};if(CKEDITOR.env.ie&&(CKEDITOR.env.ie7Compat||CKEDITOR.env.ie6Compat))
{return function(name)
{if(name=='class')
name='className';else if(name=='tabindex')
name='tabIndex';standard.call(this,name);};}
else
return standard;})(),removeAttributes:function(attributes)
{if(CKEDITOR.tools.isArray(attributes))
{for(var i=0;i<attributes.length;i++)
this.removeAttribute(attributes[i]);}
else
{for(var attr in attributes)
attributes.hasOwnProperty(attr)&&this.removeAttribute(attr);}},removeStyle:function(name)
{this.setStyle(name,'');if(this.$.style.removeAttribute)
this.$.style.removeAttribute(CKEDITOR.tools.cssStyleToDomStyle(name));if(!this.$.style.cssText)
this.removeAttribute('style');},setStyle:function(name,value)
{this.$.style[CKEDITOR.tools.cssStyleToDomStyle(name)]=value;return this;},setStyles:function(stylesPairs)
{for(var name in stylesPairs)
this.setStyle(name,stylesPairs[name]);return this;},setOpacity:function(opacity)
{if(CKEDITOR.env.ie)
{opacity=Math.round(opacity*100);this.setStyle('filter',opacity>=100?'':'progid:DXImageTransform.Microsoft.Alpha(opacity='+opacity+')');}
else
this.setStyle('opacity',opacity);},unselectable:CKEDITOR.env.gecko?function()
{this.$.style.MozUserSelect='none';}:CKEDITOR.env.webkit?function()
{this.$.style.KhtmlUserSelect='none';}:function()
{if(CKEDITOR.env.ie||CKEDITOR.env.opera)
{var element=this.$,e,i=0;element.unselectable='on';while((e=element.all[i++]))
{switch(e.tagName.toLowerCase())
{case'iframe':case'textarea':case'input':case'select':break;default:e.unselectable='on';}}}},getPositionedAncestor:function()
{var current=this;while(current.getName()!='html')
{if(current.getComputedStyle('position')!='static')
return current;current=current.getParent();}
return null;},getDocumentPosition:function(refDocument)
{var x=0,y=0,body=this.getDocument().getBody(),quirks=this.getDocument().$.compatMode=='BackCompat';var doc=this.getDocument();if(document.documentElement["getBoundingClientRect"])
{var box=this.$.getBoundingClientRect(),$doc=doc.$,$docElem=$doc.documentElement;var clientTop=$docElem.clientTop||body.$.clientTop||0,clientLeft=$docElem.clientLeft||body.$.clientLeft||0,needAdjustScrollAndBorders=true;if(CKEDITOR.env.ie)
{var inDocElem=doc.getDocumentElement().contains(this),inBody=doc.getBody().contains(this);needAdjustScrollAndBorders=(quirks&&inBody)||(!quirks&&inDocElem);}
if(needAdjustScrollAndBorders)
{x=box.left+(!quirks&&$docElem.scrollLeft||body.$.scrollLeft);x-=clientLeft;y=box.top+(!quirks&&$docElem.scrollTop||body.$.scrollTop);y-=clientTop;}}
else
{var current=this,previous=null,offsetParent;while(current&&!(current.getName()=='body'||current.getName()=='html'))
{x+=current.$.offsetLeft-current.$.scrollLeft;y+=current.$.offsetTop-current.$.scrollTop;if(!current.equals(this))
{x+=(current.$.clientLeft||0);y+=(current.$.clientTop||0);}
var scrollElement=previous;while(scrollElement&&!scrollElement.equals(current))
{x-=scrollElement.$.scrollLeft;y-=scrollElement.$.scrollTop;scrollElement=scrollElement.getParent();}
previous=current;current=(offsetParent=current.$.offsetParent)?new CKEDITOR.dom.element(offsetParent):null;}}
if(refDocument)
{var currentWindow=this.getWindow(),refWindow=refDocument.getWindow();if(!currentWindow.equals(refWindow)&&currentWindow.$.frameElement)
{var iframePosition=(new CKEDITOR.dom.element(currentWindow.$.frameElement)).getDocumentPosition(refDocument);x+=iframePosition.x;y+=iframePosition.y;}}
if(!document.documentElement["getBoundingClientRect"])
{if(CKEDITOR.env.gecko&&!quirks)
{x+=this.$.clientLeft?1:0;y+=this.$.clientTop?1:0;}}
return{x:x,y:y};},scrollIntoView:function(alignTop)
{var win=this.getWindow(),winHeight=win.getViewPaneSize().height;var offset=winHeight*-1;if(alignTop)
offset+=winHeight;else
{offset+=this.$.offsetHeight||0;offset+=parseInt(this.getComputedStyle('marginBottom')||0,10)||0;}
var elementPosition=this.getDocumentPosition();offset+=elementPosition.y;offset=offset<0?0:offset;var currentScroll=win.getScrollPosition().y;if(offset>currentScroll||offset<currentScroll-winHeight)
win.$.scrollTo(0,offset);},setState:function(state)
{switch(state)
{case CKEDITOR.TRISTATE_ON:this.addClass('cke_on');this.removeClass('cke_off');this.removeClass('cke_disabled');break;case CKEDITOR.TRISTATE_DISABLED:this.addClass('cke_disabled');this.removeClass('cke_off');this.removeClass('cke_on');break;default:this.addClass('cke_off');this.removeClass('cke_on');this.removeClass('cke_disabled');break;}},getFrameDocument:function()
{var $=this.$;try
{$.contentWindow.document;}
catch(e)
{$.src=$.src;if(CKEDITOR.env.ie&&CKEDITOR.env.version<7)
{window.showModalDialog('javascript:document.write("'+'<script>'+'window.setTimeout('+'function(){window.close();}'+',50);'+'</script>")');}}
return $&&new CKEDITOR.dom.document($.contentWindow.document);},copyAttributes:function(dest,skipAttributes)
{var attributes=this.$.attributes;skipAttributes=skipAttributes||{};for(var n=0;n<attributes.length;n++)
{var attribute=attributes[n];var attrName=attribute.nodeName.toLowerCase(),attrValue;if(attrName in skipAttributes)
continue;if(attrName=='checked'&&(attrValue=this.getAttribute(attrName)))
dest.setAttribute(attrName,attrValue);else if(attribute.specified||(CKEDITOR.env.ie&&attribute.nodeValue&&attrName=='value'))
{attrValue=this.getAttribute(attrName);if(attrValue===null)
attrValue=attribute.nodeValue;dest.setAttribute(attrName,attrValue);}}
if(this.$.style.cssText!=='')
dest.$.style.cssText=this.$.style.cssText;},renameNode:function(newTag)
{if(this.getName()==newTag)
return;var doc=this.getDocument();var newNode=new CKEDITOR.dom.element(newTag,doc);this.copyAttributes(newNode);this.moveChildren(newNode);this.$.parentNode.replaceChild(newNode.$,this.$);newNode.$._cke_expando=this.$._cke_expando;this.$=newNode.$;},getChild:function(indices)
{var rawNode=this.$;if(!indices.slice)
rawNode=rawNode.childNodes[indices];else
{while(indices.length>0&&rawNode)
rawNode=rawNode.childNodes[indices.shift()];}
return rawNode?new CKEDITOR.dom.node(rawNode):null;},getChildCount:function()
{return this.$.childNodes.length;},disableContextMenu:function()
{this.on('contextmenu',function(event)
{if(!event.data.getTarget().hasClass('cke_enable_context_menu'))
event.data.preventDefault();});}});CKEDITOR.command=function(editor,commandDefinition)
{this.uiItems=[];this.exec=function(data)
{if(this.state==CKEDITOR.TRISTATE_DISABLED)
return false;if(!RTE.loaded){return false;}
if(this.editorFocus)
editor.focus();return(commandDefinition.exec.call(this,editor,data)!==false);};CKEDITOR.tools.extend(this,commandDefinition,{modes:{wysiwyg:1},editorFocus:true,state:CKEDITOR.TRISTATE_OFF});CKEDITOR.event.call(this);};CKEDITOR.command.prototype={enable:function()
{if(this.state==CKEDITOR.TRISTATE_DISABLED)
this.setState((!this.preserveState||(typeof this.previousState=='undefined'))?CKEDITOR.TRISTATE_OFF:this.previousState);},disable:function()
{this.setState(CKEDITOR.TRISTATE_DISABLED);},setState:function(newState)
{if(this.state==newState)
return false;this.previousState=this.state;this.state=newState;this.fire('state');return true;},toggleState:function()
{if(this.state==CKEDITOR.TRISTATE_OFF)
this.setState(CKEDITOR.TRISTATE_ON);else if(this.state==CKEDITOR.TRISTATE_ON)
this.setState(CKEDITOR.TRISTATE_OFF);}};CKEDITOR.event.implementOn(CKEDITOR.command.prototype,true);CKEDITOR.ENTER_P=1;CKEDITOR.ENTER_BR=2;CKEDITOR.ENTER_DIV=3;CKEDITOR.config={customConfig:'config.js',autoUpdateElement:true,baseHref:'',contentsCss:CKEDITOR.basePath+'contents.css',contentsLangDirection:'ltr',language:'',defaultLanguage:'en',enterMode:CKEDITOR.ENTER_P,forceEnterMode:false,shiftEnterMode:CKEDITOR.ENTER_BR,corePlugins:'',docType:'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',bodyId:'',bodyClass:'',fullPage:false,height:200,plugins:'about,a11yhelp,basicstyles,blockquote,button,clipboard,colorbutton,colordialog,contextmenu,div,elementspath,enterkey,entities,filebrowser,find,flash,font,format,forms,horizontalrule,htmldataprocessor,image,indent,justify,keystrokes,link,list,maximize,newpage,pagebreak,pastefromword,pastetext,popup,preview,print,removeformat,resize,save,scayt,smiley,showblocks,showborders,sourcearea,stylescombo,table,tabletools,specialchar,tab,templates,toolbar,undo,wysiwygarea,wsc',extraPlugins:'',removePlugins:'',protectedSource:[],tabIndex:0,theme:'default',skin:'kama',width:'',baseFloatZIndex:10000};CKEDITOR.focusManager=function(editor)
{if(editor.focusManager)
return editor.focusManager;this.hasFocus=false;this._={editor:editor};return this;};CKEDITOR.focusManager.prototype={focus:function()
{if(this._.timer)
clearTimeout(this._.timer);if(!this.hasFocus)
{if(CKEDITOR.currentInstance)
CKEDITOR.currentInstance.focusManager.forceBlur();var editor=this._.editor;var firstChild=editor.container.getChild(1);if(firstChild){firstChild.addClass('cke_focus');}
this.hasFocus=true;editor.fire('focus');}},blur:function()
{var focusManager=this;if(focusManager._.timer)
clearTimeout(focusManager._.timer);focusManager._.timer=setTimeout(function()
{delete focusManager._.timer;focusManager.forceBlur();},100);},forceBlur:function()
{if(this.hasFocus)
{var editor=this._.editor;var firstChild=editor.container.getChild(1);if(firstChild){firstChild.removeClass('cke_focus');}
this.hasFocus=false;editor.fire('blur');}}};(function()
{var loadedLangs={};CKEDITOR.lang={languages:{'af':1,'ar':1,'bg':1,'bn':1,'bs':1,'ca':1,'cs':1,'cy':1,'da':1,'de':1,'el':1,'en-au':1,'en-ca':1,'en-gb':1,'en':1,'eo':1,'es':1,'et':1,'eu':1,'fa':1,'fi':1,'fo':1,'fr-ca':1,'fr':1,'gl':1,'gu':1,'he':1,'hi':1,'hr':1,'hu':1,'is':1,'it':1,'ja':1,'km':1,'ko':1,'lt':1,'lv':1,'mn':1,'ms':1,'nb':1,'nl':1,'no':1,'pl':1,'pt-br':1,'pt':1,'ro':1,'ru':1,'sk':1,'sl':1,'sr-latn':1,'sr':1,'sv':1,'th':1,'tr':1,'uk':1,'vi':1,'zh-cn':1,'zh':1},load:function(languageCode,defaultLanguage,callback)
{if(!languageCode||!CKEDITOR.lang.languages[languageCode])
languageCode=this.detect(defaultLanguage,languageCode);if(!this[languageCode])
{CKEDITOR.scriptLoader.load(CKEDITOR.getUrl('lang/'+languageCode+'.js'),function()
{callback(languageCode,this[languageCode]);},this);}
else
callback(languageCode,this[languageCode]);},detect:function(defaultLanguage,probeLanguage)
{var languages=this.languages;probeLanguage=probeLanguage||navigator.userLanguage||navigator.language;var parts=probeLanguage.toLowerCase().match(/([a-z]+)(?:-([a-z]+))?/),lang=parts[1],locale=parts[2];if(languages[lang+'-'+locale])
lang=lang+'-'+locale;else if(!languages[lang])
lang=null;CKEDITOR.lang.detect=lang?function(){return lang;}:function(defaultLanguage){return defaultLanguage;};return lang||defaultLanguage;}};})();CKEDITOR.scriptLoader=(function()
{var uniqueScripts={};var waitingList={};return{load:function(scriptUrl,callback,scope,noCheck,showBusy)
{var isString=(typeof scriptUrl=='string');if(isString)
scriptUrl=[scriptUrl];if(!scope)
scope=CKEDITOR;var scriptCount=scriptUrl.length,completed=[],failed=[];var doCallback=function(success)
{if(callback)
{if(isString)
callback.call(scope,success);else
callback.call(scope,completed,failed);}};if(scriptCount===0)
{doCallback(true);return;}
var checkLoaded=function(url,success)
{(success?completed:failed).push(url);if(--scriptCount<=0)
{showBusy&&CKEDITOR.document.getDocumentElement().removeStyle('cursor');doCallback(success);}};var onLoad=function(url,success)
{uniqueScripts[url]=1;var waitingInfo=waitingList[url];delete waitingList[url];for(var i=0;i<waitingInfo.length;i++)
waitingInfo[i](url,success);};var loadScript=function(url)
{if(noCheck!==true&&uniqueScripts[url])
{checkLoaded(url,true);return;}
var waitingInfo=waitingList[url]||(waitingList[url]=[]);waitingInfo.push(checkLoaded);if(waitingInfo.length>1)
return;var script=new CKEDITOR.dom.element('script');script.setAttributes({type:'text/javascript',src:url});if(callback)
{if(CKEDITOR.env.ie)
{script.$.onreadystatechange=function()
{if(script.$.readyState=='loaded'||script.$.readyState=='complete')
{script.$.onreadystatechange=null;onLoad(url,true);}};}
else
{script.$.onload=function()
{setTimeout(function(){onLoad(url,true);},0);};script.$.onerror=function()
{onLoad(url,false);};}}
script.appendTo(CKEDITOR.document.getHead());};showBusy&&CKEDITOR.document.getDocumentElement().setStyle('cursor','wait');for(var i=0;i<scriptCount;i++)
{loadScript(scriptUrl[i]);}},loadCode:function(code)
{var script=new CKEDITOR.dom.element('script');script.setAttribute('type','text/javascript');script.appendText(code);script.appendTo(CKEDITOR.document.getHead());}};})();CKEDITOR.resourceManager=function(basePath,fileName)
{this.basePath=basePath;this.fileName=fileName;this.registered={};this.loaded={};this.externals={};this._={waitingList:{}};};CKEDITOR.resourceManager.prototype={add:function(name,definition)
{if(this.registered[name])
throw'[CKEDITOR.resourceManager.add] The resource name "'+name+'" is already registered.';CKEDITOR.fire(name+CKEDITOR.tools.capitalize(this.fileName)+'Ready',this.registered[name]=definition||{});},get:function(name)
{return this.registered[name]||null;},getPath:function(name)
{var external=this.externals[name];return CKEDITOR.getUrl((external&&external.dir)||this.basePath+name+'/');},getFilePath:function(name)
{var external=this.externals[name];return CKEDITOR.getUrl(this.getPath(name)+
((external&&(typeof external.file=='string'))?external.file:this.fileName+'.js'));},addExternal:function(names,path,fileName)
{names=names.split(',');for(var i=0;i<names.length;i++)
{var name=names[i];this.externals[name]={dir:path,file:fileName};}},load:function(names,callback,scope)
{if(!CKEDITOR.tools.isArray(names))
names=names?[names]:[];var loaded=this.loaded,registered=this.registered,urls=[],urlsNames={},resources={};for(var i=0;i<names.length;i++)
{var name=names[i];if(!name)
continue;if(!loaded[name]&&!registered[name])
{var url=this.getFilePath(name);urls.push(url);if(!(url in urlsNames))
urlsNames[url]=[];urlsNames[url].push(name);}
else
resources[name]=this.get(name);}
CKEDITOR.scriptLoader.load(urls,function(completed,failed)
{if(failed.length)
{throw'[CKEDITOR.resourceManager.load] Resource name "'+urlsNames[failed[0]].join(',')
+'" was not found at "'+failed[0]+'".';}
for(var i=0;i<completed.length;i++)
{var nameList=urlsNames[completed[i]];for(var j=0;j<nameList.length;j++)
{var name=nameList[j];resources[name]=this.get(name);loaded[name]=1;}}
callback.call(scope,resources);},this);}};CKEDITOR.plugins=new CKEDITOR.resourceManager('plugins/','plugin');CKEDITOR.plugins.load=CKEDITOR.tools.override(CKEDITOR.plugins.load,function(originalLoad)
{return function(name,callback,scope)
{var allPlugins={};var loadPlugins=function(names)
{originalLoad.call(this,names,function(plugins)
{CKEDITOR.tools.extend(allPlugins,plugins);var requiredPlugins=[];for(var pluginName in plugins)
{var plugin=plugins[pluginName],requires=plugin&&plugin.requires;if(requires)
{for(var i=0;i<requires.length;i++)
{if(!allPlugins[requires[i]])
requiredPlugins.push(requires[i]);}}}
if(requiredPlugins.length)
loadPlugins.call(this,requiredPlugins);else
{for(pluginName in allPlugins)
{plugin=allPlugins[pluginName];if(plugin.onLoad&&!plugin.onLoad._called)
{plugin.onLoad();plugin.onLoad._called=1;}}
if(callback)
callback.call(scope||window,allPlugins);}},this);};loadPlugins.call(this,name);};});CKEDITOR.plugins.setLang=function(pluginName,languageCode,languageEntries)
{var plugin=this.get(pluginName),pluginLang=plugin.lang||(plugin.lang={});pluginLang[languageCode]=languageEntries;};(function()
{var loaded={};var loadImage=function(image,callback)
{var doCallback=function()
{img.removeAllListeners();loaded[image]=1;callback();};var img=new CKEDITOR.dom.element('img');img.on('load',doCallback);img.on('error',doCallback);img.setAttribute('src',image);};CKEDITOR.imageCacher={load:function(images,callback)
{var pendingCount=images.length;var checkPending=function()
{if(--pendingCount===0)
callback();};for(var i=0;i<images.length;i++)
{var image=images[i];if(loaded[image])
checkPending();else
loadImage(image,checkPending);}}};})();CKEDITOR.skins=(function()
{var loaded={};var preloaded={};var paths={};var loadPart=function(editor,skinName,part,callback)
{var skinDefinition=loaded[skinName];if(!editor.skin)
{editor.skin=skinDefinition;if(skinDefinition.init)
skinDefinition.init(editor);}
var appendSkinPath=function(fileNames)
{for(var n=0;n<fileNames.length;n++)
{fileNames[n]=CKEDITOR.getUrl(paths[skinName]+fileNames[n]);}};function fixCSSTextRelativePath(cssStyleText,baseUrl)
{return cssStyleText.replace(/url\s*\(([\s'"]*)(.*?)([\s"']*)\)/g,function(match,opener,path,closer)
{if(/^\/|^\w?:/.test(path))
return match;else
return'url('+baseUrl+opener+path+closer+')';});}
if(!preloaded[skinName])
{var preload=skinDefinition.preload;if(preload&&preload.length>0)
{appendSkinPath(preload);CKEDITOR.imageCacher.load(preload,function()
{preloaded[skinName]=1;loadPart(editor,skinName,part,callback);});return;}
preloaded[skinName]=1;}
part=skinDefinition[part];var partIsLoaded=!part||!!part._isLoaded;if(partIsLoaded)
callback&&callback();else
{var pending=part._pending||(part._pending=[]);pending.push(callback);if(pending.length>1)
return;var cssIsLoaded=!part.css||!part.css.length;var jsIsLoaded=!part.js||!part.js.length;var checkIsLoaded=function()
{if(cssIsLoaded&&jsIsLoaded)
{part._isLoaded=1;for(var i=0;i<pending.length;i++)
{if(pending[i])
pending[i]();}}};if(!cssIsLoaded)
{var cssPart=part.css;if(CKEDITOR.tools.isArray(cssPart))
{appendSkinPath(cssPart);for(var c=0;c<cssPart.length;c++)
CKEDITOR.document.appendStyleSheet(cssPart[c]);}
else
{cssPart=fixCSSTextRelativePath(cssPart,CKEDITOR.getUrl(paths[skinName]));CKEDITOR.document.appendStyleText(cssPart);}
part.css=cssPart;cssIsLoaded=1;}
if(!jsIsLoaded)
{appendSkinPath(part.js);CKEDITOR.scriptLoader.load(part.js,function()
{jsIsLoaded=1;checkIsLoaded();});}
checkIsLoaded();}};return{add:function(skinName,skinDefinition)
{loaded[skinName]=skinDefinition;skinDefinition.skinPath=paths[skinName]||(paths[skinName]=CKEDITOR.getUrl('_source/'+'skins/'+skinName+'/'));},load:function(editor,skinPart,callback)
{var skinName=editor.skinName,skinPath=editor.skinPath;if(loaded[skinName])
loadPart(editor,skinName,skinPart,callback);else
{paths[skinName]=skinPath;CKEDITOR.scriptLoader.load(CKEDITOR.getUrl(skinPath+'skin.js'),function()
{loadPart(editor,skinName,skinPart,callback);});}}};})();CKEDITOR.themes=new CKEDITOR.resourceManager('themes/','theme');CKEDITOR.ui=function(editor)
{if(editor.ui)
return editor.ui;this._={handlers:{},items:{},editor:editor};return this;};CKEDITOR.ui.prototype={add:function(name,type,definition)
{this._.items[name]={type:type,command:definition.command||null,args:Array.prototype.slice.call(arguments,2)};},create:function(name)
{var item=this._.items[name],handler=item&&this._.handlers[item.type],command=item&&item.command&&this._.editor.getCommand(item.command);var result=handler&&handler.create.apply(this,item.args);if(command)
command.uiItems.push(result);return result;},addHandler:function(type,handler)
{this._.handlers[type]=handler;}};(function()
{var nameCounter=0;var getNewName=function()
{var name='editor'+(++nameCounter);return(CKEDITOR.instances&&CKEDITOR.instances[name])?getNewName():name;};var loadConfigLoaded={};var loadConfig=function(editor)
{var customConfig=editor.config.customConfig;if(!customConfig)
return false;customConfig=CKEDITOR.getUrl(customConfig);var loadedConfig=loadConfigLoaded[customConfig]||(loadConfigLoaded[customConfig]={});if(loadedConfig.fn)
{loadedConfig.fn.call(editor,editor.config);if(CKEDITOR.getUrl(editor.config.customConfig)==customConfig||!loadConfig(editor))
editor.fireOnce('customConfigLoaded');}
else
{CKEDITOR.scriptLoader.load(customConfig,function()
{if(CKEDITOR.editorConfig)
loadedConfig.fn=CKEDITOR.editorConfig;else
loadedConfig.fn=function(){};loadConfig(editor);});}
return true;};var initConfig=function(editor,instanceConfig)
{editor.on('customConfigLoaded',function()
{if(instanceConfig)
{if(instanceConfig.on)
{for(var eventName in instanceConfig.on)
{editor.on(eventName,instanceConfig.on[eventName]);}}
CKEDITOR.tools.extend(editor.config,instanceConfig,true);delete editor.config.on;}
onConfigLoaded(editor);});if(instanceConfig&&instanceConfig.customConfig!=undefined)
editor.config.customConfig=instanceConfig.customConfig;if(!loadConfig(editor))
editor.fireOnce('customConfigLoaded');};var onConfigLoaded=function(editor)
{var skin=editor.config.skin.split(','),skinName=skin[0],skinPath=CKEDITOR.getUrl(skin[1]||('skins/'+skinName+'/'));editor.skinName=skinName;editor.skinPath=skinPath;editor.skinClass='cke_skin_'+skinName;editor.tabIndex=editor.config.tabIndex||editor.element.getAttribute('tabindex')||0;editor.fireOnce('configLoaded');loadSkin(editor);};var loadLang=function(editor)
{CKEDITOR.lang.load(editor.config.language,editor.config.defaultLanguage,function(languageCode,lang)
{editor.langCode=languageCode;editor.lang=CKEDITOR.tools.prototypedCopy(lang);if(CKEDITOR.env.gecko&&CKEDITOR.env.version<10900&&editor.lang.dir=='rtl')
editor.lang.dir='ltr';loadPlugins(editor);});};var loadPlugins=function(editor)
{var config=editor.config,plugins=config.plugins,extraPlugins=config.extraPlugins,removePlugins=config.removePlugins;if(extraPlugins)
{var removeRegex=new RegExp('(?:^|,)(?:'+extraPlugins.replace(/\s*,\s*/g,'|')+')(?=,|$)','g');plugins=plugins.replace(removeRegex,'');plugins+=','+extraPlugins;}
if(removePlugins)
{removeRegex=new RegExp('(?:^|,)(?:'+removePlugins.replace(/\s*,\s*/g,'|')+')(?=,|$)','g');plugins=plugins.replace(removeRegex,'');}
CKEDITOR.plugins.load(plugins.split(','),function(plugins)
{var pluginsArray=[];var languageCodes=[];var languageFiles=[];editor.plugins=plugins;for(var pluginName in plugins)
{var plugin=plugins[pluginName],pluginLangs=plugin.lang,pluginPath=CKEDITOR.plugins.getPath(pluginName),lang=null;plugin.path=pluginPath;if(pluginLangs)
{lang=(CKEDITOR.tools.indexOf(pluginLangs,editor.langCode)>=0?editor.langCode:pluginLangs[0]);if(!plugin.lang[lang])
{languageFiles.push(CKEDITOR.getUrl(pluginPath+'lang/'+lang+'.js'));}
else
{CKEDITOR.tools.extend(editor.lang,plugin.lang[lang]);lang=null;}}
languageCodes.push(lang);pluginsArray.push(plugin);}
CKEDITOR.scriptLoader.load(languageFiles,function()
{var methods=['beforeInit','init','afterInit'];for(var m=0;m<methods.length;m++)
{for(var i=0;i<pluginsArray.length;i++)
{var plugin=pluginsArray[i];if(m===0&&languageCodes[i]&&plugin.lang)
CKEDITOR.tools.extend(editor.lang,plugin.lang[languageCodes[i]]);if(plugin[methods[m]])
plugin[methods[m]](editor);}}
editor.fire('pluginsLoaded');loadTheme(editor);});});};var loadSkin=function(editor)
{CKEDITOR.skins.load(editor,'editor',function()
{loadLang(editor);});};var loadTheme=function(editor)
{var theme=editor.config.theme;CKEDITOR.themes.load(theme,function()
{var editorTheme=editor.theme=CKEDITOR.themes.get(theme);editorTheme.path=CKEDITOR.themes.getPath(theme);editorTheme.build(editor);if(editor.config.autoUpdateElement)
attachToForm(editor);});};var attachToForm=function(editor)
{var element=editor.element;if(editor.elementMode==CKEDITOR.ELEMENT_MODE_REPLACE&&element.is('textarea'))
{var form=element.$.form&&new CKEDITOR.dom.element(element.$.form);if(form)
{function onSubmit()
{editor.updateElement();}
form.on('submit',onSubmit);if(!form.$.submit.nodeName)
{form.$.submit=CKEDITOR.tools.override(form.$.submit,function(originalSubmit)
{return function()
{editor.updateElement();if(originalSubmit.apply)
originalSubmit.apply(this,arguments);else
originalSubmit();};});}
editor.on('destroy',function()
{form.removeListener('submit',onSubmit);});}}};function updateCommandsMode()
{var command,commands=this._.commands,mode=this.mode;for(var name in commands)
{command=commands[name];command[command.startDisabled?'disable':command.modes[mode]?'enable':'disable']();}}
CKEDITOR.editor.prototype._init=function()
{var element=CKEDITOR.dom.element.get(this._.element),instanceConfig=this._.instanceConfig;delete this._.element;delete this._.instanceConfig;this._.commands={};this._.styles=[];this.element=element;this.name=(element&&(this.elementMode==CKEDITOR.ELEMENT_MODE_REPLACE)&&(element.getId()||element.getNameAtt()))||getNewName();if(this.name in CKEDITOR.instances)
throw'[CKEDITOR.editor] The instance "'+this.name+'" already exists.';this.config=CKEDITOR.tools.prototypedCopy(CKEDITOR.config);this.ui=new CKEDITOR.ui(this);this.focusManager=new CKEDITOR.focusManager(this);CKEDITOR.fire('instanceCreated',null,this);this.on('mode',updateCommandsMode,null,null,1);initConfig(this,instanceConfig);};})();CKEDITOR.tools.extend(CKEDITOR.editor.prototype,{addCommand:function(commandName,commandDefinition)
{return this._.commands[commandName]=new CKEDITOR.command(this,commandDefinition);},addCss:function(css)
{this._.styles.push(css);},destroy:function(noUpdate)
{if(!noUpdate)
this.updateElement();if(this.mode)
{this._.modes[this.mode].unload(this.getThemeSpace('contents'));}
this.theme.destroy(this);var toolbars,index=0,j,items,instance;if(this.toolbox)
{toolbars=this.toolbox.toolbars;for(;index<toolbars.length;index++)
{items=toolbars[index].items;for(j=0;j<items.length;j++)
{instance=items[j];if(instance.clickFn)CKEDITOR.tools.removeFunction(instance.clickFn);if(instance.keyDownFn)CKEDITOR.tools.removeFunction(instance.keyDownFn);if(instance.index)CKEDITOR.ui.button._.instances[instance.index]=null;}}}
if(this.contextMenu)
CKEDITOR.tools.removeFunction(this.contextMenu._.functionId);if(this._.filebrowserFn)
CKEDITOR.tools.removeFunction(this._.filebrowserFn);this.fire('destroy');CKEDITOR.remove(this);CKEDITOR.fire('instanceDestroyed',null,this);},execCommand:function(commandName,data)
{var command=this.getCommand(commandName);var eventData={name:commandName,commandData:data,command:command};if(command&&command.state!=CKEDITOR.TRISTATE_DISABLED)
{if(this.fire('beforeCommandExec',eventData)!==true)
{eventData.returnValue=command.exec(eventData.commandData);if(!command.async&&this.fire('afterCommandExec',eventData)!==true)
return eventData.returnValue;}}
return false;},getCommand:function(commandName)
{return this._.commands[commandName];},getData:function()
{this.fire('beforeGetData');var eventData=this._.data;if(typeof eventData!='string')
{var element=this.element;if(element&&this.elementMode==CKEDITOR.ELEMENT_MODE_REPLACE)
eventData=element.is('textarea')?element.getValue():element.getHtml();else
eventData='';}
eventData={dataValue:eventData};this.fire('getData',eventData);return eventData.dataValue;},getSnapshot:function()
{var data=this.fire('getSnapshot');if(typeof data!='string')
{var element=this.element;if(element&&this.elementMode==CKEDITOR.ELEMENT_MODE_REPLACE)
data=element.is('textarea')?element.getValue():element.getHtml();}
return data;},loadSnapshot:function(snapshot)
{this.fire('loadSnapshot',snapshot);},setData:function(data,callback)
{if(callback)
{this.on('dataReady',function(evt)
{evt.removeListener();callback.call(evt.editor);});}
var eventData={dataValue:data};this.fire('setData',eventData);this._.data=eventData.dataValue;this.fire('afterSetData',eventData);},insertHtml:function(data)
{this.fire('insertHtml',data);},insertElement:function(element)
{this.fire('insertElement',element);},checkDirty:function()
{return(this.mayBeDirty&&this._.previousValue!==this.getSnapshot());},resetDirty:function()
{if(this.mayBeDirty)
this._.previousValue=this.getSnapshot();},updateElement:function()
{var element=this.element;if(element&&this.elementMode==CKEDITOR.ELEMENT_MODE_REPLACE)
{var data=this.getData();if(this.config.htmlEncodeOutput)
data=CKEDITOR.tools.htmlEncode(data);if(element.is('textarea'))
element.setValue(data);else
element.setHtml(data);}}});CKEDITOR.on('loaded',function()
{var pending=CKEDITOR.editor._pending;if(pending)
{delete CKEDITOR.editor._pending;for(var i=0;i<pending.length;i++)
pending[i]._init();}});CKEDITOR.htmlParser=function()
{this._={htmlPartsRegex:new RegExp('<(?:(?:\\/([^>]+)>)|(?:!--([\\S|\\s]*?)-->)|(?:([^\\s>]+)\\s*((?:(?:[^"\'>]+)|(?:"[^"]*")|(?:\'[^\']*\'))*)\\/?>))','g')};};(function()
{var attribsRegex=/([\w\-:.]+)(?:(?:\s*=\s*(?:(?:"([^"]*)")|(?:'([^']*)')|([^\s>]+)))|(?=\s|$))/g,emptyAttribs={checked:1,compact:1,declare:1,defer:1,disabled:1,ismap:1,multiple:1,nohref:1,noresize:1,noshade:1,nowrap:1,readonly:1,selected:1};CKEDITOR.htmlParser.prototype={onTagOpen:function(){},onTagClose:function(){},onText:function(){},onCDATA:function(){},onComment:function(){},parse:function(html)
{var parts,tagName,nextIndex=0,cdata;while((parts=this._.htmlPartsRegex.exec(html)))
{var tagIndex=parts.index;if(tagIndex>nextIndex)
{var text=html.substring(nextIndex,tagIndex);if(cdata)
cdata.push(text);else
this.onText(text);}
nextIndex=this._.htmlPartsRegex.lastIndex;if((tagName=parts[1]))
{tagName=tagName.toLowerCase();if(cdata&&CKEDITOR.dtd.$cdata[tagName])
{this.onCDATA(cdata.join(''));cdata=null;}
if(!cdata)
{this.onTagClose(tagName);continue;}}
if(cdata)
{cdata.push(parts[0]);continue;}
if((tagName=parts[3]))
{tagName=tagName.toLowerCase();var attribs={},attribMatch,attribsPart=parts[4],selfClosing=!!(attribsPart&&attribsPart.charAt(attribsPart.length-1)=='/');if(attribsPart)
{while((attribMatch=attribsRegex.exec(attribsPart)))
{var attName=attribMatch[1].toLowerCase(),attValue=attribMatch[2]||attribMatch[3]||attribMatch[4]||'';if(!attValue&&emptyAttribs[attName])
attribs[attName]=attName;else
attribs[attName]=attValue;}}
this.onTagOpen(tagName,attribs,selfClosing);if(!cdata&&CKEDITOR.dtd.$cdata[tagName])
cdata=[];continue;}
if((tagName=parts[2]))
this.onComment(tagName);}
if(html.length>nextIndex)
this.onText(html.substring(nextIndex,html.length));}};})();CKEDITOR.htmlParser.comment=function(value)
{this.value=value;this._={isBlockLike:false};};CKEDITOR.htmlParser.comment.prototype={type:CKEDITOR.NODE_COMMENT,writeHtml:function(writer,filter)
{var comment=this.value;if(filter)
{if(!(comment=filter.onComment(comment,this)))
return;if(typeof comment!='string')
{comment.parent=this.parent;comment.writeHtml(writer,filter);return;}}
writer.comment(comment);}};(function()
{var spacesRegex=/[\t\r\n ]{2,}|[\t\r\n]/g;CKEDITOR.htmlParser.text=function(value)
{this.value=value;this._={isBlockLike:false};};CKEDITOR.htmlParser.text.prototype={type:CKEDITOR.NODE_TEXT,writeHtml:function(writer,filter)
{var text=this.value;if(filter&&!(text=filter.onText(text,this)))
return;writer.text(text);}};})();(function()
{CKEDITOR.htmlParser.cdata=function(value)
{this.value=value;};CKEDITOR.htmlParser.cdata.prototype={type:CKEDITOR.NODE_TEXT,writeHtml:function(writer)
{writer.write(this.value);}};})();CKEDITOR.htmlParser.fragment=function()
{this.children=[];this.parent=null;this._={isBlockLike:true,hasInlineStarted:false};};(function()
{var optionalClose={colgroup:1,dd:1,dt:1,li:1,option:1,p:1,td:1,tfoot:1,th:1,thead:1,tr:1};var nonBreakingBlocks=CKEDITOR.tools.extend({table:1,ul:1,ol:1,dl:1},CKEDITOR.dtd.table,CKEDITOR.dtd.ul,CKEDITOR.dtd.ol,CKEDITOR.dtd.dl),listBlocks=CKEDITOR.dtd.$list,listItems=CKEDITOR.dtd.$listItem;CKEDITOR.htmlParser.fragment.fromHtml=function(fragmentHtml,fixForBody)
{var parser=new CKEDITOR.htmlParser(),html=[],fragment=new CKEDITOR.htmlParser.fragment(),pendingInline=[],pendingBRs=[],currentNode=fragment,inPre=false,returnPoint;function checkPending(newTagName)
{var pendingBRsSent;if(pendingInline.length>0)
{for(var i=0;i<pendingInline.length;i++)
{var pendingElement=pendingInline[i],pendingName=pendingElement.name,pendingDtd=CKEDITOR.dtd[pendingName],currentDtd=currentNode.name&&CKEDITOR.dtd[currentNode.name];if((!currentDtd||currentDtd[pendingName])&&(!newTagName||!pendingDtd||pendingDtd[newTagName]||!CKEDITOR.dtd[newTagName]))
{if(!pendingBRsSent)
{sendPendingBRs();pendingBRsSent=1;}
pendingElement=pendingElement.clone();pendingElement.parent=currentNode;currentNode=pendingElement;pendingInline.splice(i,1);i--;}}}}
function sendPendingBRs()
{while(pendingBRs.length)
currentNode.add(pendingBRs.shift());}
function addElement(element,target,enforceCurrent)
{target=target||currentNode||fragment;if(fixForBody&&!target.type)
{var elementName,realElementName;if(element.attributes&&(realElementName=element.attributes['_cke_real_element_type']))
elementName=realElementName;else
elementName=element.name;if(elementName&&!(elementName in CKEDITOR.dtd.$body)&&!(elementName in CKEDITOR.dtd.$nonBodyContent))
{var savedCurrent=currentNode;currentNode=target;parser.onTagOpen(fixForBody,{});target=currentNode;if(enforceCurrent)
currentNode=savedCurrent;}}
if(element._.isBlockLike&&element.name!='pre')
{var length=element.children.length,lastChild=element.children[length-1],text;if(lastChild&&lastChild.type==CKEDITOR.NODE_TEXT)
{if(!(text=CKEDITOR.tools.rtrim(lastChild.value)))
element.children.length=length-1;else
lastChild.value=text;}}
target.add(element);if(element.returnPoint)
{currentNode=element.returnPoint;delete element.returnPoint;}}
parser.onTagOpen=function(tagName,attributes,selfClosing)
{var element=new CKEDITOR.htmlParser.element(tagName,attributes);if(element.isUnknown&&selfClosing)
element.isEmpty=true;if(CKEDITOR.dtd.$removeEmpty[tagName])
{pendingInline.push(element);return;}
else if(tagName=='pre')
inPre=true;else if(tagName=='br'&&inPre)
{currentNode.add(new CKEDITOR.htmlParser.text('\n'));return;}
var currentName=currentNode.name;var currentDtd=currentName&&(CKEDITOR.dtd[currentName]||(currentNode._.isBlockLike?CKEDITOR.dtd.div:CKEDITOR.dtd.span));if(currentDtd&&!element.isUnknown&&!currentNode.isUnknown&&!currentDtd[tagName])
{var reApply=false,addPoint;if(tagName in listBlocks&&currentName in listBlocks)
{var children=currentNode.children,lastChild=children[children.length-1];if(!(lastChild&&lastChild.name in listItems))
addElement((lastChild=new CKEDITOR.htmlParser.element('li')),currentNode);returnPoint=currentNode,addPoint=lastChild;}
else if(tagName==currentName)
{addElement(currentNode,currentNode.parent);}
else
{if(nonBreakingBlocks[currentName])
{if(!returnPoint)
returnPoint=currentNode;}
else
{addElement(currentNode,currentNode.parent,true);if(!optionalClose[currentName])
{pendingInline.unshift(currentNode);}}
reApply=true;}
if(addPoint)
currentNode=addPoint;else
currentNode=currentNode.returnPoint||currentNode.parent;if(reApply)
{parser.onTagOpen.apply(this,arguments);return;}}
checkPending(tagName);sendPendingBRs();element.parent=currentNode;element.returnPoint=returnPoint;returnPoint=0;if(element.isEmpty)
addElement(element);else
currentNode=element;};parser.onTagClose=function(tagName)
{for(var i=pendingInline.length-1;i>=0;i--)
{if(tagName==pendingInline[i].name)
{pendingInline.splice(i,1);return;}}
var pendingAdd=[],newPendingInline=[],candidate=currentNode;while(candidate.type&&candidate.name!=tagName)
{if(!candidate._.isBlockLike)
newPendingInline.unshift(candidate);pendingAdd.push(candidate);candidate=candidate.parent;}
if(candidate.type)
{for(i=0;i<pendingAdd.length;i++)
{var node=pendingAdd[i];addElement(node,node.parent);}
currentNode=candidate;if(currentNode.name=='pre')
inPre=false;if(candidate._.isBlockLike)
sendPendingBRs();addElement(candidate,candidate.parent);if(candidate==currentNode)
currentNode=currentNode.parent;pendingInline=pendingInline.concat(newPendingInline);}
if(tagName=='body')
fixForBody=false;};parser.onText=function(text)
{if(!currentNode._.hasInlineStarted&&!inPre)
{text=CKEDITOR.tools.ltrim(text);if(text.length===0)
return;}
sendPendingBRs();checkPending();if(fixForBody&&(!currentNode.type||currentNode.name=='body')&&CKEDITOR.tools.trim(text))
{this.onTagOpen(fixForBody,{});}
if(!inPre)
text=text.replace(/[\t\r\n ]{2,}|[\t\r\n]/g,' ');currentNode.add(new CKEDITOR.htmlParser.text(text));};parser.onCDATA=function(cdata)
{currentNode.add(new CKEDITOR.htmlParser.cdata(cdata));};parser.onComment=function(comment)
{currentNode.add(new CKEDITOR.htmlParser.comment(comment));};parser.parse(fragmentHtml);sendPendingBRs();while(currentNode.type)
{var parent=currentNode.parent,node=currentNode;if(fixForBody&&(!parent.type||parent.name=='body')&&!CKEDITOR.dtd.$body[node.name])
{currentNode=parent;parser.onTagOpen(fixForBody,{});parent=currentNode;}
parent.add(node);currentNode=parent;}
return fragment;};CKEDITOR.htmlParser.fragment.prototype={add:function(node)
{var len=this.children.length,previous=len>0&&this.children[len-1]||null;if(previous)
{if(node._.isBlockLike&&previous.type==CKEDITOR.NODE_TEXT)
{previous.value=CKEDITOR.tools.rtrim(previous.value);if(previous.value.length===0)
{this.children.pop();this.add(node);return;}}
previous.next=node;}
node.previous=previous;node.parent=this;this.children.push(node);this._.hasInlineStarted=node.type==CKEDITOR.NODE_TEXT||(node.type==CKEDITOR.NODE_ELEMENT&&!node._.isBlockLike);},writeHtml:function(writer,filter)
{var isChildrenFiltered;this.filterChildren=function()
{var writer=new CKEDITOR.htmlParser.basicWriter();this.writeChildrenHtml.call(this,writer,filter,true);var html=writer.getHtml();this.children=new CKEDITOR.htmlParser.fragment.fromHtml(html).children;isChildrenFiltered=1;};!this.name&&filter&&filter.onFragment(this);this.writeChildrenHtml(writer,isChildrenFiltered?null:filter);},writeChildrenHtml:function(writer,filter)
{for(var i=0;i<this.children.length;i++)
this.children[i].writeHtml(writer,filter);}};})();CKEDITOR.htmlParser.element=function(name,attributes)
{this.name=name;this.attributes=attributes||(attributes={});this.children=[];var tagName=attributes._cke_real_element_type||name;var dtd=CKEDITOR.dtd,isBlockLike=!!(dtd.$nonBodyContent[tagName]||dtd.$block[tagName]||dtd.$listItem[tagName]||dtd.$tableContent[tagName]||dtd.$nonEditable[tagName]||tagName=='br'),isEmpty=!!dtd.$empty[name];this.isEmpty=isEmpty;this.isUnknown=!dtd[name];this._={isBlockLike:isBlockLike,hasInlineStarted:isEmpty||!isBlockLike};};(function()
{var sortAttribs=function(a,b)
{a=a[0];b=b[0];return a<b?-1:a>b?1:0;};CKEDITOR.htmlParser.element.prototype={type:CKEDITOR.NODE_ELEMENT,add:CKEDITOR.htmlParser.fragment.prototype.add,clone:function()
{return new CKEDITOR.htmlParser.element(this.name,this.attributes);},writeHtml:function(writer,filter)
{var attributes=this.attributes;var element=this,writeName=element.name,a,newAttrName,value;var isChildrenFiltered;element.filterChildren=function()
{if(!isChildrenFiltered)
{var writer=new CKEDITOR.htmlParser.basicWriter();CKEDITOR.htmlParser.fragment.prototype.writeChildrenHtml.call(element,writer,filter);element.children=new CKEDITOR.htmlParser.fragment.fromHtml(writer.getHtml()).children;isChildrenFiltered=1;}};if(filter)
{while(true)
{if(!(writeName=filter.onElementName(writeName)))
return;element.name=writeName;if(!(element=filter.onElement(element)))
return;element.parent=this.parent;if(element.name==writeName)
break;if(element.type!=CKEDITOR.NODE_ELEMENT)
{element.writeHtml(writer,filter);return;}
writeName=element.name;if(!writeName)
{this.writeChildrenHtml.call(element,writer,isChildrenFiltered?null:filter);return;}}
attributes=element.attributes;}
writer.openTag(writeName,attributes);var attribsArray=[];for(var i=0;i<2;i++)
{for(a in attributes)
{newAttrName=a;value=attributes[a];if(i==1)
attribsArray.push([a,value]);else if(filter)
{while(true)
{if(!(newAttrName=filter.onAttributeName(a)))
{delete attributes[a];break;}
else if(newAttrName!=a)
{delete attributes[a];a=newAttrName;continue;}
else
break;}
if(newAttrName)
{if((value=filter.onAttribute(element,newAttrName,value))===false)
delete attributes[newAttrName];else
attributes[newAttrName]=value;}}}}
if(writer.sortAttributes)
attribsArray.sort(sortAttribs);var len=attribsArray.length;for(i=0;i<len;i++)
{var attrib=attribsArray[i];writer.attribute(attrib[0],attrib[1]);}
writer.openTagClose(writeName,element.isEmpty);if(!element.isEmpty)
{this.writeChildrenHtml.call(element,writer,isChildrenFiltered?null:filter);writer.closeTag(writeName);}},writeChildrenHtml:function(writer,filter)
{CKEDITOR.htmlParser.fragment.prototype.writeChildrenHtml.apply(this,arguments);}};})();(function()
{CKEDITOR.htmlParser.filter=CKEDITOR.tools.createClass({$:function(rules)
{this._={elementNames:[],attributeNames:[],elements:{$length:0},attributes:{$length:0}};if(rules)
this.addRules(rules,10);},proto:{addRules:function(rules,priority)
{if(typeof priority!='number')
priority=10;addItemsToList(this._.elementNames,rules.elementNames,priority);addItemsToList(this._.attributeNames,rules.attributeNames,priority);addNamedItems(this._.elements,rules.elements,priority);addNamedItems(this._.attributes,rules.attributes,priority);this._.text=transformNamedItem(this._.text,rules.text,priority)||this._.text;this._.comment=transformNamedItem(this._.comment,rules.comment,priority)||this._.comment;this._.root=transformNamedItem(this._.root,rules.root,priority)||this._.root;},onElementName:function(name)
{return filterName(name,this._.elementNames);},onAttributeName:function(name)
{return filterName(name,this._.attributeNames);},onText:function(text)
{var textFilter=this._.text;return textFilter?textFilter.filter(text):text;},onComment:function(commentText,comment)
{var textFilter=this._.comment;return textFilter?textFilter.filter(commentText,comment):commentText;},onFragment:function(element)
{var rootFilter=this._.root;return rootFilter?rootFilter.filter(element):element;},onElement:function(element)
{var filters=[this._.elements['^'],this._.elements[element.name],this._.elements.$],filter,ret;for(var i=0;i<3;i++)
{filter=filters[i];if(filter)
{ret=filter.filter(element,this);if(ret===false)
return null;if(ret&&ret!=element)
return this.onNode(ret);if(element.parent&&!element.name)
break;}}
return element;},onNode:function(node)
{var type=node.type;return type==CKEDITOR.NODE_ELEMENT?this.onElement(node):type==CKEDITOR.NODE_TEXT?new CKEDITOR.htmlParser.text(this.onText(node.value)):type==CKEDITOR.NODE_COMMENT?new CKEDITOR.htmlParser.comment(this.onComment(node.value)):null;},onAttribute:function(element,name,value)
{var filter=this._.attributes[name];if(filter)
{var ret=filter.filter(value,element,this);if(ret===false)
return false;if(typeof ret!='undefined')
return ret;}
return value;}}});function filterName(name,filters)
{for(var i=0;name&&i<filters.length;i++)
{var filter=filters[i];name=name.replace(filter[0],filter[1]);}
return name;}
function addItemsToList(list,items,priority)
{if(typeof items=='function')
items=[items];var i,j,listLength=list.length,itemsLength=items&&items.length;if(itemsLength)
{for(i=0;i<listLength&&list[i].pri<priority;i++)
{}
for(j=itemsLength-1;j>=0;j--)
{var item=items[j];if(item)
{item.pri=priority;list.splice(i,0,item);}}}}
function addNamedItems(hashTable,items,priority)
{if(items)
{for(var name in items)
{var current=hashTable[name];hashTable[name]=transformNamedItem(current,items[name],priority);if(!current)
hashTable.$length++;}}}
function transformNamedItem(current,item,priority)
{if(item)
{item.pri=priority;if(current)
{if(!current.splice)
{if(current.pri>priority)
current=[item,current];else
current=[current,item];current.filter=callItems;}
else
addItemsToList(current,item,priority);return current;}
else
{item.filter=item;return item;}}}
function callItems(currentEntry)
{var isObject=(typeof currentEntry=='object');for(var i=0;i<this.length;i++)
{var item=this[i],ret=item.apply(window,arguments);if(typeof ret!='undefined')
{if(ret===false)
return false;if(isObject&&ret!=currentEntry)
return ret;}}
return null;}})();CKEDITOR.htmlParser.basicWriter=CKEDITOR.tools.createClass({$:function()
{this._={output:[]};},proto:{openTag:function(tagName,attributes)
{this._.output.push('<',tagName);},openTagClose:function(tagName,isSelfClose)
{if(isSelfClose)
this._.output.push(' />');else
this._.output.push('>');},attribute:function(attName,attValue)
{if(typeof attValue=='string')
attValue=CKEDITOR.tools.htmlEncodeAttr(attValue);this._.output.push(' ',attName,'="',attValue,'"');},closeTag:function(tagName)
{this._.output.push('</',tagName,'>');},text:function(text)
{this._.output.push(text);},comment:function(comment)
{this._.output.push('<!--',comment,'-->');},write:function(data)
{this._.output.push(data);},reset:function()
{this._.output=[];this._.indent=false;},getHtml:function(reset)
{var html=this._.output.join('');if(reset)
this.reset();return html;}}});delete CKEDITOR.loadFullCore;CKEDITOR.instances={};CKEDITOR.document=new CKEDITOR.dom.document(document);CKEDITOR.add=function(editor)
{CKEDITOR.instances[editor.name]=editor;editor.on('focus',function()
{if(CKEDITOR.currentInstance!=editor)
{CKEDITOR.currentInstance=editor;CKEDITOR.fire('currentInstance');}});editor.on('blur',function()
{if(CKEDITOR.currentInstance==editor)
{CKEDITOR.currentInstance=null;CKEDITOR.fire('currentInstance');}});};CKEDITOR.remove=function(editor)
{delete CKEDITOR.instances[editor.name];};CKEDITOR.TRISTATE_ON=1;CKEDITOR.TRISTATE_OFF=2;CKEDITOR.TRISTATE_DISABLED=0;CKEDITOR.dom.comment=CKEDITOR.tools.createClass({base:CKEDITOR.dom.node,$:function(text,ownerDocument)
{if(typeof text=='string')
text=(ownerDocument?ownerDocument.$:document).createComment(text);this.base(text);},proto:{type:CKEDITOR.NODE_COMMENT,getOuterHtml:function()
{return'<!--'+this.$.nodeValue+'-->';}}});(function()
{var pathBlockElements={address:1,blockquote:1,dl:1,h1:1,h2:1,h3:1,h4:1,h5:1,h6:1,p:1,pre:1,li:1,dt:1,dd:1};var pathBlockLimitElements={body:1,div:1,table:1,tbody:1,tr:1,td:1,th:1,caption:1,form:1};var checkHasBlock=function(element)
{var childNodes=element.getChildren();for(var i=0,count=childNodes.count();i<count;i++)
{var child=childNodes.getItem(i);if(child.type==CKEDITOR.NODE_ELEMENT&&CKEDITOR.dtd.$block[child.getName()])
return true;}
return false;};CKEDITOR.dom.elementPath=function(lastNode)
{var block=null;var blockLimit=null;var elements=[];var e=lastNode;while(e)
{if(e.type==CKEDITOR.NODE_ELEMENT)
{if(!this.lastElement)
this.lastElement=e;var elementName=e.getName();if(CKEDITOR.env.ie&&e.$.scopeName!='HTML')
elementName=e.$.scopeName.toLowerCase()+':'+elementName;if(!blockLimit)
{if(!block&&pathBlockElements[elementName])
block=e;if(pathBlockLimitElements[elementName])
{if(!block&&elementName=='div'&&!checkHasBlock(e))
block=e;else
blockLimit=e;}}
elements.push(e);if(elementName=='body')
break;}
e=e.getParent();}
this.block=block;this.blockLimit=blockLimit;this.elements=elements;};})();CKEDITOR.dom.elementPath.prototype={compare:function(otherPath)
{var thisElements=this.elements;var otherElements=otherPath&&otherPath.elements;if(!otherElements||thisElements.length!=otherElements.length)
return false;for(var i=0;i<thisElements.length;i++)
{if(!thisElements[i].equals(otherElements[i]))
return false;}
return true;}};CKEDITOR.dom.text=function(text,ownerDocument)
{if(typeof text=='string')
text=(ownerDocument?ownerDocument.$:document).createTextNode(text);this.$=text;};CKEDITOR.dom.text.prototype=new CKEDITOR.dom.node();CKEDITOR.tools.extend(CKEDITOR.dom.text.prototype,{type:CKEDITOR.NODE_TEXT,getLength:function()
{return this.$.nodeValue.length;},getText:function()
{return this.$.nodeValue;},split:function(offset)
{if(CKEDITOR.env.ie&&offset==this.getLength())
{var next=this.getDocument().createText('');next.insertAfter(this);return next;}
var doc=this.getDocument();var retval=new CKEDITOR.dom.text(this.$.splitText(offset),doc);if(CKEDITOR.env.ie8)
{var workaround=new CKEDITOR.dom.text('',doc);workaround.insertAfter(retval);workaround.remove();}
return retval;},substring:function(indexA,indexB)
{if(typeof indexB!='number')
return this.$.nodeValue.substr(indexA);else
return this.$.nodeValue.substring(indexA,indexB);}});CKEDITOR.dom.documentFragment=function(ownerDocument)
{ownerDocument=ownerDocument||CKEDITOR.document;this.$=ownerDocument.$.createDocumentFragment();};CKEDITOR.tools.extend(CKEDITOR.dom.documentFragment.prototype,CKEDITOR.dom.element.prototype,{type:CKEDITOR.NODE_DOCUMENT_FRAGMENT,insertAfterNode:function(node)
{node=node.$;node.parentNode.insertBefore(this.$,node.nextSibling);}},true,{'append':1,'appendBogus':1,'getFirst':1,'getLast':1,'appendTo':1,'moveChildren':1,'insertBefore':1,'insertAfterNode':1,'replace':1,'trim':1,'type':1,'ltrim':1,'rtrim':1,'getDocument':1,'getChildCount':1,'getChild':1,'getChildren':1});(function()
{function iterate(rtl,breakOnFalse)
{if(this._.end)
return null;var node,range=this.range,guard,userGuard=this.guard,type=this.type,getSourceNodeFn=(rtl?'getPreviousSourceNode':'getNextSourceNode');if(!this._.start)
{this._.start=1;range.trim();if(range.collapsed)
{this.end();return null;}}
if(!rtl&&!this._.guardLTR)
{var limitLTR=range.endContainer,blockerLTR=limitLTR.getChild(range.endOffset);this._.guardLTR=function(node,movingOut)
{return((!movingOut||!limitLTR.equals(node))&&(!blockerLTR||!node.equals(blockerLTR))&&(node.type!=CKEDITOR.NODE_ELEMENT||!movingOut||node.getName()!='body'));};}
if(rtl&&!this._.guardRTL)
{var limitRTL=range.startContainer,blockerRTL=(range.startOffset>0)&&limitRTL.getChild(range.startOffset-1);this._.guardRTL=function(node,movingOut)
{return((!movingOut||!limitRTL.equals(node))&&(!blockerRTL||!node.equals(blockerRTL))&&(node.type!=CKEDITOR.NODE_ELEMENT||!movingOut||node.getName()!='body'));};}
var stopGuard=rtl?this._.guardRTL:this._.guardLTR;if(userGuard)
{guard=function(node,movingOut)
{if(stopGuard(node,movingOut)===false)
return false;return userGuard(node,movingOut);};}
else
guard=stopGuard;if(this.current)
node=this.current[getSourceNodeFn](false,type,guard);else
{if(rtl)
{node=range.endContainer;if(range.endOffset>0)
{node=node.getChild(range.endOffset-1);if(guard(node)===false)
node=null;}
else
node=(guard(node,true)===false)?null:node.getPreviousSourceNode(true,type,guard);}
else
{node=range.startContainer;node=node.getChild(range.startOffset);if(node)
{if(guard(node)===false)
node=null;}
else
node=(guard(range.startContainer,true)===false)?null:range.startContainer.getNextSourceNode(true,type,guard);}}
while(node&&!this._.end)
{this.current=node;if(!this.evaluator||this.evaluator(node)!==false)
{if(!breakOnFalse)
return node;}
else if(breakOnFalse&&this.evaluator)
return false;node=node[getSourceNodeFn](false,type,guard);}
this.end();return this.current=null;}
function iterateToLast(rtl)
{var node,last=null;while((node=iterate.call(this,rtl)))
last=node;return last;}
CKEDITOR.dom.walker=CKEDITOR.tools.createClass({$:function(range)
{this.range=range;this._={};},proto:{end:function()
{this._.end=1;},next:function()
{return iterate.call(this);},previous:function()
{return iterate.call(this,true);},checkForward:function()
{return iterate.call(this,false,true)!==false;},checkBackward:function()
{return iterate.call(this,true,true)!==false;},lastForward:function()
{return iterateToLast.call(this);},lastBackward:function()
{return iterateToLast.call(this,true);},reset:function()
{delete this.current;this._={};}}});var blockBoundaryDisplayMatch={block:1,'list-item':1,table:1,'table-row-group':1,'table-header-group':1,'table-footer-group':1,'table-row':1,'table-column-group':1,'table-column':1,'table-cell':1,'table-caption':1},blockBoundaryNodeNameMatch={hr:1};CKEDITOR.dom.element.prototype.isBlockBoundary=function(customNodeNames)
{var nodeNameMatches=CKEDITOR.tools.extend({},blockBoundaryNodeNameMatch,customNodeNames||{});return blockBoundaryDisplayMatch[this.getComputedStyle('display')]||nodeNameMatches[this.getName()];};CKEDITOR.dom.walker.blockBoundary=function(customNodeNames)
{return function(node,type)
{return!(node.type==CKEDITOR.NODE_ELEMENT&&node.isBlockBoundary(customNodeNames));};};CKEDITOR.dom.walker.listItemBoundary=function()
{return this.blockBoundary({br:1});};CKEDITOR.dom.walker.bookmarkContents=function(node)
{},CKEDITOR.dom.walker.bookmark=function(contentOnly,isReject)
{function isBookmarkNode(node)
{return(node&&node.getName&&node.getName()=='span'&&node.hasAttribute('_fck_bookmark'));}
return function(node)
{var isBookmark,parent;isBookmark=(node&&!node.getName&&(parent=node.getParent())&&isBookmarkNode(parent));isBookmark=contentOnly?isBookmark:isBookmark||isBookmarkNode(node);return isReject^isBookmark;};};CKEDITOR.dom.walker.whitespaces=function(isReject)
{return function(node)
{var isWhitespace=node&&(node.type==CKEDITOR.NODE_TEXT)&&!CKEDITOR.tools.trim(node.getText());return isReject^isWhitespace;};};CKEDITOR.dom.walker.invisible=function(isReject)
{var whitespace=CKEDITOR.dom.walker.whitespaces();return function(node)
{var isInvisible=whitespace(node)||node.is&&!node.$.offsetHeight;return isReject^isInvisible;};};var tailNbspRegex=/^[\t\r\n ]*(?:&nbsp;|\xa0)$/,isNotWhitespaces=CKEDITOR.dom.walker.whitespaces(true),isNotBookmark=CKEDITOR.dom.walker.bookmark(false,true),fillerEvaluator=function(element)
{return isNotBookmark(element)&&isNotWhitespaces(element);};CKEDITOR.dom.element.prototype.getBogus=function()
{var tail=this.getLast(fillerEvaluator);if(tail&&(!CKEDITOR.env.ie?tail.is&&tail.is('br'):tail.getText&&tailNbspRegex.test(tail.getText())))
{return tail;}
return false;};})();CKEDITOR.dom.range=function(document)
{this.startContainer=null;this.startOffset=null;this.endContainer=null;this.endOffset=null;this.collapsed=true;this.document=document;};(function()
{var updateCollapsed=function(range)
{range.collapsed=(range.startContainer&&range.endContainer&&range.startContainer.equals(range.endContainer)&&range.startOffset==range.endOffset);};var execContentsAction=function(range,action,docFrag)
{range.optimizeBookmark();var startNode=range.startContainer;var endNode=range.endContainer;var startOffset=range.startOffset;var endOffset=range.endOffset;var removeStartNode;var removeEndNode;if(endNode.type==CKEDITOR.NODE_TEXT)
endNode=endNode.split(endOffset);else
{if(endNode.getChildCount()>0)
{if(endOffset>=endNode.getChildCount())
{endNode=endNode.append(range.document.createText(''));removeEndNode=true;}
else
endNode=endNode.getChild(endOffset);}}
if(startNode.type==CKEDITOR.NODE_TEXT)
{startNode.split(startOffset);if(startNode.equals(endNode))
endNode=startNode.getNext();}
else
{if(!startOffset)
{startNode=startNode.getFirst().insertBeforeMe(range.document.createText(''));removeStartNode=true;}
else if(startOffset>=startNode.getChildCount())
{startNode=startNode.append(range.document.createText(''));removeStartNode=true;}
else
startNode=startNode.getChild(startOffset).getPrevious();}
var startParents=startNode.getParents();var endParents=endNode.getParents();var i,topStart,topEnd;for(i=0;i<startParents.length;i++)
{topStart=startParents[i];topEnd=endParents[i];if(!topStart.equals(topEnd))
break;}
var clone=docFrag,levelStartNode,levelClone,currentNode,currentSibling;for(var j=i;j<startParents.length;j++)
{levelStartNode=startParents[j];if(clone&&!levelStartNode.equals(startNode))
levelClone=clone.append(levelStartNode.clone());currentNode=levelStartNode.getNext();while(currentNode)
{if(currentNode.equals(endParents[j])||currentNode.equals(endNode))
break;currentSibling=currentNode.getNext();if(action==2)
clone.append(currentNode.clone(true));else
{currentNode.remove();if(action==1)
clone.append(currentNode);}
currentNode=currentSibling;}
if(clone)
clone=levelClone;}
clone=docFrag;for(var k=i;k<endParents.length;k++)
{levelStartNode=endParents[k];if(action>0&&!levelStartNode.equals(endNode))
levelClone=clone.append(levelStartNode.clone());if(!startParents[k]||levelStartNode.$.parentNode!=startParents[k].$.parentNode)
{currentNode=levelStartNode.getPrevious();while(currentNode)
{if(currentNode.equals(startParents[k])||currentNode.equals(startNode))
break;currentSibling=currentNode.getPrevious();if(action==2)
clone.$.insertBefore(currentNode.$.cloneNode(true),clone.$.firstChild);else
{currentNode.remove();if(action==1)
clone.$.insertBefore(currentNode.$,clone.$.firstChild);}
currentNode=currentSibling;}}
if(clone)
clone=levelClone;}
if(action==2)
{var startTextNode=range.startContainer;if(startTextNode.type==CKEDITOR.NODE_TEXT)
{startTextNode.$.data+=startTextNode.$.nextSibling.data;startTextNode.$.parentNode.removeChild(startTextNode.$.nextSibling);}
var endTextNode=range.endContainer;if(endTextNode.type==CKEDITOR.NODE_TEXT&&endTextNode.$.nextSibling)
{endTextNode.$.data+=endTextNode.$.nextSibling.data;endTextNode.$.parentNode.removeChild(endTextNode.$.nextSibling);}}
else
{if(topStart&&topEnd&&(startNode.$.parentNode!=topStart.$.parentNode||endNode.$.parentNode!=topEnd.$.parentNode))
{var endIndex=topEnd.getIndex();if(removeStartNode&&topEnd.$.parentNode==startNode.$.parentNode)
endIndex--;range.setStart(topEnd.getParent(),endIndex);}
range.collapse(true);}
if(removeStartNode)
startNode.remove();if(removeEndNode&&endNode.$.parentNode)
endNode.remove();};var inlineChildReqElements={abbr:1,acronym:1,b:1,bdo:1,big:1,cite:1,code:1,del:1,dfn:1,em:1,font:1,i:1,ins:1,label:1,kbd:1,q:1,samp:1,small:1,span:1,strike:1,strong:1,sub:1,sup:1,tt:1,u:1,'var':1};function getCheckStartEndBlockEvalFunction(isStart)
{var hadBr=false,bookmarkEvaluator=CKEDITOR.dom.walker.bookmark(true);return function(node)
{if(bookmarkEvaluator(node))
return true;if(node.type==CKEDITOR.NODE_TEXT)
{if(CKEDITOR.tools.trim(node.getText()).length)
return false;}
else if(node.type==CKEDITOR.NODE_ELEMENT)
{if(node.$.nodeType==CKEDITOR.NODE_COMMENT){return false;}
if(!inlineChildReqElements[node.getName()])
{if(!isStart&&!CKEDITOR.env.ie&&node.getName()=='br'&&!hadBr)
hadBr=true;else
return false;}}
return true;};}
function elementBoundaryEval(node)
{return node.type!=CKEDITOR.NODE_TEXT&&node.getName()in CKEDITOR.dtd.$removeEmpty||!CKEDITOR.tools.trim(node.getText())||node.getParent().hasAttribute('_fck_bookmark');}
var whitespaceEval=new CKEDITOR.dom.walker.whitespaces(),bookmarkEval=new CKEDITOR.dom.walker.bookmark();function nonWhitespaceOrBookmarkEval(node)
{return!whitespaceEval(node)&&!bookmarkEval(node);}
CKEDITOR.dom.range.prototype={clone:function()
{var clone=new CKEDITOR.dom.range(this.document);clone.startContainer=this.startContainer;clone.startOffset=this.startOffset;clone.endContainer=this.endContainer;clone.endOffset=this.endOffset;clone.collapsed=this.collapsed;return clone;},collapse:function(toStart)
{if(toStart)
{this.endContainer=this.startContainer;this.endOffset=this.startOffset;}
else
{this.startContainer=this.endContainer;this.startOffset=this.endOffset;}
this.collapsed=true;},cloneContents:function()
{var docFrag=new CKEDITOR.dom.documentFragment(this.document);if(!this.collapsed)
execContentsAction(this,2,docFrag);return docFrag;},deleteContents:function()
{if(this.collapsed)
return;execContentsAction(this,0);},extractContents:function()
{var docFrag=new CKEDITOR.dom.documentFragment(this.document);if(!this.collapsed)
execContentsAction(this,1,docFrag);return docFrag;},createBookmark:function(serializable)
{var startNode,endNode;var baseId;var clone;startNode=this.document.createElement('span');startNode.setAttribute('_fck_bookmark',1);startNode.setStyle('display','none');startNode.setHtml('&nbsp;');if(serializable)
{baseId='cke_bm_'+CKEDITOR.tools.getNextNumber();startNode.setAttribute('id',baseId+'S');}
if(!this.collapsed)
{endNode=startNode.clone();endNode.setHtml('&nbsp;');if(serializable)
endNode.setAttribute('id',baseId+'E');clone=this.clone();clone.collapse();clone.insertNode(endNode);}
clone=this.clone();clone.collapse(true);clone.insertNode(startNode);if(endNode)
{this.setStartAfter(startNode);this.setEndBefore(endNode);}
else
this.moveToPosition(startNode,CKEDITOR.POSITION_AFTER_END);return{startNode:serializable?baseId+'S':startNode,endNode:serializable?baseId+'E':endNode,serializable:serializable};},createBookmark2:function(normalized)
{var startContainer=this.startContainer,endContainer=this.endContainer;var startOffset=this.startOffset,endOffset=this.endOffset;var child,previous;if(!startContainer||!endContainer)
return{start:0,end:0};if(normalized)
{if(startContainer.type==CKEDITOR.NODE_ELEMENT)
{child=startContainer.getChild(startOffset);if(child&&child.type==CKEDITOR.NODE_TEXT&&startOffset>0&&child.getPrevious().type==CKEDITOR.NODE_TEXT)
{startContainer=child;startOffset=0;}}
while(startContainer.type==CKEDITOR.NODE_TEXT&&(previous=startContainer.getPrevious())&&previous.type==CKEDITOR.NODE_TEXT)
{startContainer=previous;startOffset+=previous.getLength();}
if(!this.isCollapsed)
{if(endContainer.type==CKEDITOR.NODE_ELEMENT)
{child=endContainer.getChild(endOffset);if(child&&child.type==CKEDITOR.NODE_TEXT&&endOffset>0&&child.getPrevious().type==CKEDITOR.NODE_TEXT)
{endContainer=child;endOffset=0;}}
while(endContainer.type==CKEDITOR.NODE_TEXT&&(previous=endContainer.getPrevious())&&previous.type==CKEDITOR.NODE_TEXT)
{endContainer=previous;endOffset+=previous.getLength();}}}
return{start:startContainer.getAddress(normalized),end:this.isCollapsed?null:endContainer.getAddress(normalized),startOffset:startOffset,endOffset:endOffset,normalized:normalized,is2:true};},moveToBookmark:function(bookmark)
{if(bookmark.is2)
{var startContainer=this.document.getByAddress(bookmark.start,bookmark.normalized),startOffset=bookmark.startOffset;var endContainer=bookmark.end&&this.document.getByAddress(bookmark.end,bookmark.normalized),endOffset=bookmark.endOffset;this.setStart(startContainer,startOffset);if(endContainer)
this.setEnd(endContainer,endOffset);else
this.collapse(true);}
else
{var serializable=bookmark.serializable,startNode=serializable?this.document.getById(bookmark.startNode):bookmark.startNode,endNode=serializable?this.document.getById(bookmark.endNode):bookmark.endNode;this.setStartBefore(startNode);startNode.remove();if(endNode)
{this.setEndBefore(endNode);endNode.remove();}
else
this.collapse(true);}},getBoundaryNodes:function()
{var startNode=this.startContainer,endNode=this.endContainer,startOffset=this.startOffset,endOffset=this.endOffset,childCount;if(startNode.type==CKEDITOR.NODE_ELEMENT)
{childCount=startNode.getChildCount();if(childCount>startOffset)
startNode=startNode.getChild(startOffset);else if(childCount<1)
startNode=startNode.getPreviousSourceNode();else
{startNode=startNode.$;while(startNode.lastChild)
startNode=startNode.lastChild;startNode=new CKEDITOR.dom.node(startNode);startNode=startNode.getNextSourceNode()||startNode;}}
if(endNode.type==CKEDITOR.NODE_ELEMENT)
{childCount=endNode.getChildCount();if(childCount>endOffset)
endNode=endNode.getChild(endOffset).getPreviousSourceNode(true);else if(childCount<1)
endNode=endNode.getPreviousSourceNode();else
{endNode=endNode.$;while(endNode.lastChild)
endNode=endNode.lastChild;endNode=new CKEDITOR.dom.node(endNode);}}
if(startNode.getPosition(endNode)&CKEDITOR.POSITION_FOLLOWING)
startNode=endNode;return{startNode:startNode,endNode:endNode};},getCommonAncestor:function(includeSelf,ignoreTextNode)
{var start=this.startContainer,end=this.endContainer,ancestor;if(start.equals(end))
{if(includeSelf&&start.type==CKEDITOR.NODE_ELEMENT&&this.startOffset==this.endOffset-1)
ancestor=start.getChild(this.startOffset);else
ancestor=start;}
else
ancestor=start.getCommonAncestor(end);return ignoreTextNode&&!ancestor.is?ancestor.getParent():ancestor;},optimize:function()
{var container=this.startContainer;var offset=this.startOffset;if(container.type!=CKEDITOR.NODE_ELEMENT)
{if(!offset)
this.setStartBefore(container);else if(offset>=container.getLength())
this.setStartAfter(container);}
container=this.endContainer;offset=this.endOffset;if(container.type!=CKEDITOR.NODE_ELEMENT)
{if(!offset)
this.setEndBefore(container);else if(offset>=container.getLength())
this.setEndAfter(container);}},optimizeBookmark:function()
{var startNode=this.startContainer,endNode=this.endContainer;if(startNode.is&&startNode.is('span')&&startNode.hasAttribute('_fck_bookmark'))
this.setStartAt(startNode,CKEDITOR.POSITION_BEFORE_START);if(endNode&&endNode.is&&endNode.is('span')&&endNode.hasAttribute('_fck_bookmark'))
this.setEndAt(endNode,CKEDITOR.POSITION_AFTER_END);},trim:function(ignoreStart,ignoreEnd)
{var startContainer=this.startContainer,startOffset=this.startOffset,collapsed=this.collapsed;if((!ignoreStart||collapsed)&&startContainer&&startContainer.type==CKEDITOR.NODE_TEXT)
{if(!startOffset)
{startOffset=startContainer.getIndex();startContainer=startContainer.getParent();}
else if(startOffset>=startContainer.getLength())
{startOffset=startContainer.getIndex()+1;startContainer=startContainer.getParent();}
else
{var nextText=startContainer.split(startOffset);startOffset=startContainer.getIndex()+1;startContainer=startContainer.getParent();if(this.startContainer.equals(this.endContainer))
this.setEnd(nextText,this.endOffset-this.startOffset);else if(startContainer.equals(this.endContainer))
this.endOffset+=1;}
this.setStart(startContainer,startOffset);if(collapsed)
{this.collapse(true);return;}}
var endContainer=this.endContainer;var endOffset=this.endOffset;if(!(ignoreEnd||collapsed)&&endContainer&&endContainer.type==CKEDITOR.NODE_TEXT)
{if(!endOffset)
{endOffset=endContainer.getIndex();endContainer=endContainer.getParent();}
else if(endOffset>=endContainer.getLength())
{endOffset=endContainer.getIndex()+1;endContainer=endContainer.getParent();}
else
{endContainer.split(endOffset);endOffset=endContainer.getIndex()+1;endContainer=endContainer.getParent();}
this.setEnd(endContainer,endOffset);}},enlarge:function(unit)
{switch(unit)
{case CKEDITOR.ENLARGE_ELEMENT:if(this.collapsed)
return;var commonAncestor=this.getCommonAncestor();var body=this.document.getBody();var startTop,endTop;var enlargeable,sibling,commonReached;var needsWhiteSpace=false;var isWhiteSpace;var siblingText;var container=this.startContainer;var offset=this.startOffset;if(container.type==CKEDITOR.NODE_TEXT)
{if(offset)
{container=!CKEDITOR.tools.trim(container.substring(0,offset)).length&&container;needsWhiteSpace=!!container;}
if(container)
{if(!(sibling=container.getPrevious()))
enlargeable=container.getParent();}}
else
{if(offset)
sibling=container.getChild(offset-1)||container.getLast();if(!sibling)
enlargeable=container;}
while(enlargeable||sibling)
{if(enlargeable&&!sibling)
{if(!commonReached&&enlargeable.equals(commonAncestor))
commonReached=true;if(!body.contains(enlargeable))
break;if(!needsWhiteSpace||enlargeable.getComputedStyle('display')!='inline')
{needsWhiteSpace=false;if(commonReached)
startTop=enlargeable;else
this.setStartBefore(enlargeable);}
sibling=enlargeable.getPrevious();}
while(sibling)
{isWhiteSpace=false;if(sibling.type==CKEDITOR.NODE_TEXT)
{siblingText=sibling.getText();if(/[^\s\ufeff]/.test(siblingText))
sibling=null;isWhiteSpace=/[\s\ufeff]$/.test(siblingText);}
else
{if(sibling.$.offsetWidth>0&&!sibling.getAttribute('_fck_bookmark'))
{if(needsWhiteSpace&&CKEDITOR.dtd.$removeEmpty[sibling.getName()])
{siblingText=sibling.getText();if((/[^\s\ufeff]/).test(siblingText))
sibling=null;else
{var allChildren=sibling.$.all||sibling.$.getElementsByTagName('*');for(var i=0,child;child=allChildren[i++];)
{if(!CKEDITOR.dtd.$removeEmpty[child.nodeName.toLowerCase()])
{sibling=null;break;}}}
if(sibling)
isWhiteSpace=!!siblingText.length;}
else
sibling=null;}}
if(isWhiteSpace)
{if(needsWhiteSpace)
{if(commonReached)
startTop=enlargeable;else if(enlargeable)
this.setStartBefore(enlargeable);}
else
needsWhiteSpace=true;}
if(sibling)
{var next=sibling.getPrevious();if(!enlargeable&&!next)
{enlargeable=sibling;sibling=null;break;}
sibling=next;}
else
{enlargeable=null;}}
if(enlargeable)
enlargeable=enlargeable.getParent();}
container=this.endContainer;offset=this.endOffset;enlargeable=sibling=null;commonReached=needsWhiteSpace=false;if(container.type==CKEDITOR.NODE_TEXT)
{container=!CKEDITOR.tools.trim(container.substring(offset)).length&&container;needsWhiteSpace=!(container&&container.getLength());if(container)
{if(!(sibling=container.getNext()))
enlargeable=container.getParent();}}
else
{sibling=container.getChild(offset);if(!sibling)
enlargeable=container;}
while(enlargeable||sibling)
{if(enlargeable&&!sibling)
{if(!commonReached&&enlargeable.equals(commonAncestor))
commonReached=true;if(!body.contains(enlargeable))
break;if(!needsWhiteSpace||enlargeable.getComputedStyle('display')!='inline')
{needsWhiteSpace=false;if(commonReached)
endTop=enlargeable;else if(enlargeable)
this.setEndAfter(enlargeable);}
sibling=enlargeable.getNext();}
while(sibling)
{isWhiteSpace=false;if(sibling.type==CKEDITOR.NODE_TEXT)
{siblingText=sibling.getText();if(/[^\s\ufeff]/.test(siblingText))
sibling=null;isWhiteSpace=/^[\s\ufeff]/.test(siblingText);}
else
{if(sibling.$.offsetWidth>0&&!sibling.getAttribute('_fck_bookmark'))
{if(needsWhiteSpace&&CKEDITOR.dtd.$removeEmpty[sibling.getName()])
{siblingText=sibling.getText();if((/[^\s\ufeff]/).test(siblingText))
sibling=null;else
{allChildren=sibling.$.all||sibling.$.getElementsByTagName('*');for(i=0;child=allChildren[i++];)
{if(!CKEDITOR.dtd.$removeEmpty[child.nodeName.toLowerCase()])
{sibling=null;break;}}}
if(sibling)
isWhiteSpace=!!siblingText.length;}
else
sibling=null;}}
if(isWhiteSpace)
{if(needsWhiteSpace)
{if(commonReached)
endTop=enlargeable;else
this.setEndAfter(enlargeable);}}
if(sibling)
{next=sibling.getNext();if(!enlargeable&&!next)
{enlargeable=sibling;sibling=null;break;}
sibling=next;}
else
{enlargeable=null;}}
if(enlargeable)
enlargeable=enlargeable.getParent();}
if(startTop&&endTop)
{commonAncestor=startTop.contains(endTop)?endTop:startTop;this.setStartBefore(commonAncestor);this.setEndAfter(commonAncestor);}
break;case CKEDITOR.ENLARGE_BLOCK_CONTENTS:case CKEDITOR.ENLARGE_LIST_ITEM_CONTENTS:var walkerRange=new CKEDITOR.dom.range(this.document);body=this.document.getBody();walkerRange.setStartAt(body,CKEDITOR.POSITION_AFTER_START);walkerRange.setEnd(this.startContainer,this.startOffset);var walker=new CKEDITOR.dom.walker(walkerRange),blockBoundary,tailBr,defaultGuard=CKEDITOR.dom.walker.blockBoundary((unit==CKEDITOR.ENLARGE_LIST_ITEM_CONTENTS)?{br:1}:null),boundaryGuard=function(node)
{var retval=defaultGuard(node);if(!retval)
blockBoundary=node;return retval;},tailBrGuard=function(node)
{var retval=boundaryGuard(node);if(!retval&&node.is&&node.is('br'))
tailBr=node;return retval;};walker.guard=boundaryGuard;enlargeable=walker.lastBackward();blockBoundary=blockBoundary||body;this.setStartAt(blockBoundary,!blockBoundary.is('br')&&(!enlargeable&&this.checkStartOfBlock()||enlargeable&&blockBoundary.contains(enlargeable))?CKEDITOR.POSITION_AFTER_START:CKEDITOR.POSITION_AFTER_END);walkerRange=this.clone();walkerRange.collapse();walkerRange.setEndAt(body,CKEDITOR.POSITION_BEFORE_END);walker=new CKEDITOR.dom.walker(walkerRange);walker.guard=(unit==CKEDITOR.ENLARGE_LIST_ITEM_CONTENTS)?tailBrGuard:boundaryGuard;blockBoundary=null;enlargeable=walker.lastForward();blockBoundary=blockBoundary||body;this.setEndAt(blockBoundary,(!enlargeable&&this.checkEndOfBlock()||enlargeable&&blockBoundary.contains(enlargeable))?CKEDITOR.POSITION_BEFORE_END:CKEDITOR.POSITION_BEFORE_START);if(tailBr)
this.setEndAfter(tailBr);}},shrink:function(mode)
{if(!this.collapsed)
{mode=mode||CKEDITOR.SHRINK_TEXT;var walkerRange=this.clone();var startContainer=this.startContainer,endContainer=this.endContainer,startOffset=this.startOffset,endOffset=this.endOffset,collapsed=this.collapsed;var moveStart=1,moveEnd=1;if(startContainer&&startContainer.type==CKEDITOR.NODE_TEXT)
{if(!startOffset)
walkerRange.setStartBefore(startContainer);else if(startOffset>=startContainer.getLength())
walkerRange.setStartAfter(startContainer);else
{walkerRange.setStartBefore(startContainer);moveStart=0;}}
if(endContainer&&endContainer.type==CKEDITOR.NODE_TEXT)
{if(!endOffset)
walkerRange.setEndBefore(endContainer);else if(endOffset>=endContainer.getLength())
walkerRange.setEndAfter(endContainer);else
{walkerRange.setEndAfter(endContainer);moveEnd=0;}}
var walker=new CKEDITOR.dom.walker(walkerRange);walker.evaluator=function(node)
{return node.type==(mode==CKEDITOR.SHRINK_ELEMENT?CKEDITOR.NODE_ELEMENT:CKEDITOR.NODE_TEXT);};var currentElement;walker.guard=function(node,movingOut)
{if(mode==CKEDITOR.SHRINK_ELEMENT&&node.type==CKEDITOR.NODE_TEXT)
return false;if(movingOut&&node.equals(currentElement))
return false;if(!movingOut&&node.type==CKEDITOR.NODE_ELEMENT)
currentElement=node;};if(moveStart)
{var textStart=walker[mode==CKEDITOR.SHRINK_ELEMENT?'lastForward':'next']();textStart&&this.setStartBefore(textStart);}
if(moveEnd)
{walker.reset();var textEnd=walker[mode==CKEDITOR.SHRINK_ELEMENT?'lastBackward':'previous']();textEnd&&this.setEndAfter(textEnd);}
return!!(moveStart||moveEnd);}},shrink:function(mode)
{if(!this.collapsed)
{mode=mode||CKEDITOR.SHRINK_TEXT;var walkerRange=this.clone();var startContainer=this.startContainer,endContainer=this.endContainer,startOffset=this.startOffset,endOffset=this.endOffset,collapsed=this.collapsed;var moveStart=1,moveEnd=1;if(startContainer&&startContainer.type==CKEDITOR.NODE_TEXT)
{if(!startOffset)
walkerRange.setStartBefore(startContainer);else if(startOffset>=startContainer.getLength())
walkerRange.setStartAfter(startContainer);else
{walkerRange.setStartBefore(startContainer);moveStart=0;}}
if(endContainer&&endContainer.type==CKEDITOR.NODE_TEXT)
{if(!endOffset)
walkerRange.setEndBefore(endContainer);else if(endOffset>=endContainer.getLength())
walkerRange.setEndAfter(endContainer);else
{walkerRange.setEndAfter(endContainer);moveEnd=0;}}
var walker=new CKEDITOR.dom.walker(walkerRange);walker.evaluator=function(node)
{return node.type==(mode==CKEDITOR.SHRINK_ELEMENT?CKEDITOR.NODE_ELEMENT:CKEDITOR.NODE_TEXT);};var currentElement;walker.guard=function(node,movingOut)
{if(mode==CKEDITOR.SHRINK_ELEMENT&&node.type==CKEDITOR.NODE_TEXT)
return false;if(movingOut&&node.equals(currentElement))
return false;if(!movingOut&&node.type==CKEDITOR.NODE_ELEMENT)
currentElement=node;return true;};if(moveStart)
{var textStart=walker[mode==CKEDITOR.SHRINK_ELEMENT?'lastForward':'next']();textStart&&this.setStartBefore(textStart);}
if(moveEnd)
{walker.reset();var textEnd=walker[mode==CKEDITOR.SHRINK_ELEMENT?'lastBackward':'previous']();textEnd&&this.setEndAfter(textEnd);}
return!!(moveStart||moveEnd);}},insertNode:function(node)
{this.optimizeBookmark();this.trim(false,true);var startContainer=this.startContainer;var startOffset=this.startOffset;if(typeof startContainer.getChild!='function'){var nextNode=new CKEDITOR.dom.element(startContainer.$.previousSibling);}
else{var nextNode=startContainer.getChild(startOffset);}
if(nextNode)
node.insertBefore(nextNode);else
startContainer.append(node);if(node.getParent().equals(this.endContainer))
this.endOffset++;this.setStartBefore(node);},moveToPosition:function(node,position)
{this.setStartAt(node,position);this.collapse(true);},selectNodeContents:function(node)
{this.setStart(node,0);this.setEnd(node,node.type==CKEDITOR.NODE_TEXT?node.getLength():node.getChildCount());},setStart:function(startNode,startOffset)
{this.startContainer=startNode;this.startOffset=startOffset;if(!this.endContainer)
{this.endContainer=startNode;this.endOffset=startOffset;}
updateCollapsed(this);},setEnd:function(endNode,endOffset)
{this.endContainer=endNode;this.endOffset=endOffset;if(!this.startContainer)
{this.startContainer=endNode;this.startOffset=endOffset;}
updateCollapsed(this);},setStartAfter:function(node)
{this.setStart(node.getParent(),node.getIndex()+1);},setStartBefore:function(node)
{this.setStart(node.getParent(),node.getIndex());},setEndAfter:function(node)
{this.setEnd(node.getParent(),node.getIndex()+1);},setEndBefore:function(node)
{this.setEnd(node.getParent(),node.getIndex());},setStartAt:function(node,position)
{switch(position)
{case CKEDITOR.POSITION_AFTER_START:this.setStart(node,0);break;case CKEDITOR.POSITION_BEFORE_END:if(node.type==CKEDITOR.NODE_TEXT)
this.setStart(node,node.getLength());else
this.setStart(node,node.getChildCount());break;case CKEDITOR.POSITION_BEFORE_START:this.setStartBefore(node);break;case CKEDITOR.POSITION_AFTER_END:this.setStartAfter(node);}
updateCollapsed(this);},setEndAt:function(node,position)
{switch(position)
{case CKEDITOR.POSITION_AFTER_START:this.setEnd(node,0);break;case CKEDITOR.POSITION_BEFORE_END:if(node.type==CKEDITOR.NODE_TEXT)
this.setEnd(node,node.getLength());else
this.setEnd(node,node.getChildCount());break;case CKEDITOR.POSITION_BEFORE_START:this.setEndBefore(node);break;case CKEDITOR.POSITION_AFTER_END:this.setEndAfter(node);}
updateCollapsed(this);},fixBlock:function(isStart,blockTag)
{var bookmark=this.createBookmark(),fixedBlock=this.document.createElement(blockTag);this.collapse(isStart);this.enlarge(CKEDITOR.ENLARGE_BLOCK_CONTENTS);this.extractContents().appendTo(fixedBlock);fixedBlock.trim();if(!CKEDITOR.env.ie)
fixedBlock.appendBogus();this.insertNode(fixedBlock);this.moveToBookmark(bookmark);return fixedBlock;},splitBlock:function(blockTag)
{var startPath=new CKEDITOR.dom.elementPath(this.startContainer),endPath=new CKEDITOR.dom.elementPath(this.endContainer);var startBlockLimit=startPath.blockLimit,endBlockLimit=endPath.blockLimit;var startBlock=startPath.block,endBlock=endPath.block;var elementPath=null;if(!startBlockLimit.equals(endBlockLimit))
return null;if(blockTag!='br')
{if(!startBlock)
{startBlock=this.fixBlock(true,blockTag);endBlock=new CKEDITOR.dom.elementPath(this.endContainer).block;}
if(!endBlock)
endBlock=this.fixBlock(false,blockTag);}
var isStartOfBlock=startBlock&&this.checkStartOfBlock(),isEndOfBlock=endBlock&&this.checkEndOfBlock();this.deleteContents();if(startBlock&&startBlock.equals(endBlock))
{if(isEndOfBlock)
{elementPath=new CKEDITOR.dom.elementPath(this.startContainer);this.moveToPosition(endBlock,CKEDITOR.POSITION_AFTER_END);endBlock=null;}
else if(isStartOfBlock)
{elementPath=new CKEDITOR.dom.elementPath(this.startContainer);this.moveToPosition(startBlock,CKEDITOR.POSITION_BEFORE_START);startBlock=null;}
else
{endBlock=this.splitElement(startBlock);if(!CKEDITOR.env.ie&&!startBlock.is('ul','ol'))
startBlock.appendBogus();}}
return{previousBlock:startBlock,nextBlock:endBlock,wasStartOfBlock:isStartOfBlock,wasEndOfBlock:isEndOfBlock,elementPath:elementPath};},splitElement:function(toSplit)
{if(!this.collapsed)
return null;this.setEndAt(toSplit,CKEDITOR.POSITION_BEFORE_END);var documentFragment=this.extractContents();var clone=toSplit.clone(false);documentFragment.appendTo(clone);clone.insertAfter(toSplit);this.moveToPosition(toSplit,CKEDITOR.POSITION_AFTER_END);return clone;},checkBoundaryOfElement:function(element,checkType)
{var walkerRange=this.clone();walkerRange[checkType==CKEDITOR.START?'setStartAt':'setEndAt']
(element,checkType==CKEDITOR.START?CKEDITOR.POSITION_AFTER_START:CKEDITOR.POSITION_BEFORE_END);var walker=new CKEDITOR.dom.walker(walkerRange),retval=false;walker.evaluator=elementBoundaryEval;return walker[checkType==CKEDITOR.START?'checkBackward':'checkForward']();},checkStartOfBlock:function()
{var startContainer=this.startContainer,startOffset=this.startOffset;if(startOffset&&startContainer.type==CKEDITOR.NODE_TEXT)
{var textBefore=CKEDITOR.tools.ltrim(startContainer.substring(0,startOffset));if(textBefore.length)
return false;}
this.trim();var path=new CKEDITOR.dom.elementPath(this.startContainer);var walkerRange=this.clone();walkerRange.collapse(true);walkerRange.setStartAt(path.block||path.blockLimit,CKEDITOR.POSITION_AFTER_START);var walker=new CKEDITOR.dom.walker(walkerRange);walker.evaluator=getCheckStartEndBlockEvalFunction(true);return walker.checkBackward();},checkEndOfBlock:function()
{var endContainer=this.endContainer,endOffset=this.endOffset;if(endContainer.type==CKEDITOR.NODE_TEXT)
{var textAfter=CKEDITOR.tools.rtrim(endContainer.substring(endOffset));if(textAfter.length)
return false;}
this.trim();var path=new CKEDITOR.dom.elementPath(this.endContainer);var walkerRange=this.clone();walkerRange.collapse(false);walkerRange.setEndAt(path.block||path.blockLimit,CKEDITOR.POSITION_BEFORE_END);var walker=new CKEDITOR.dom.walker(walkerRange);walker.evaluator=getCheckStartEndBlockEvalFunction(false);return walker.checkForward();},moveToElementEditablePosition:function(el,isMoveToEnd)
{var isEditable;if(CKEDITOR.dtd.$empty[el.getName()])
return false;while(el&&el.type==CKEDITOR.NODE_ELEMENT)
{isEditable=el.isEditable();if(isEditable)
this.moveToPosition(el,isMoveToEnd?CKEDITOR.POSITION_BEFORE_END:CKEDITOR.POSITION_AFTER_START);else if(CKEDITOR.dtd.$inline[el.getName()])
{this.moveToPosition(el,isMoveToEnd?CKEDITOR.POSITION_AFTER_END:CKEDITOR.POSITION_BEFORE_START);return true;}
if(CKEDITOR.dtd.$empty[el.getName()])
el=el[isMoveToEnd?'getPrevious':'getNext'](nonWhitespaceOrBookmarkEval);else
el=el[isMoveToEnd?'getLast':'getFirst'](nonWhitespaceOrBookmarkEval);if(el&&el.type==CKEDITOR.NODE_TEXT)
{this.moveToPosition(el,isMoveToEnd?CKEDITOR.POSITION_AFTER_END:CKEDITOR.POSITION_BEFORE_START);return true;}}
return isEditable;},moveToElementEditStart:function(target)
{return this.moveToElementEditablePosition(target);},moveToElementEditEnd:function(target)
{return this.moveToElementEditablePosition(target,true);},getEnclosedNode:function()
{var walkerRange=this.clone(),walker=new CKEDITOR.dom.walker(walkerRange),isNotBookmarks=CKEDITOR.dom.walker.bookmark(true),isNotWhitespaces=CKEDITOR.dom.walker.whitespaces(true),evaluator=function(node)
{return isNotWhitespaces(node)&&isNotBookmarks(node);};walkerRange.evaluator=evaluator;var node=walker.next();walker.reset();return node&&node.equals(walker.previous())?node:null;},getTouchedStartNode:function()
{var container=this.startContainer;if(this.collapsed||container.type!=CKEDITOR.NODE_ELEMENT)
return container;return container.getChild(this.startOffset)||container;},getTouchedEndNode:function()
{var container=this.endContainer;if(this.collapsed||container.type!=CKEDITOR.NODE_ELEMENT)
return container;return container.getChild(this.endOffset-1)||container;}};})();CKEDITOR.POSITION_AFTER_START=1;CKEDITOR.POSITION_BEFORE_END=2;CKEDITOR.POSITION_BEFORE_START=3;CKEDITOR.POSITION_AFTER_END=4;CKEDITOR.ENLARGE_ELEMENT=1;CKEDITOR.ENLARGE_BLOCK_CONTENTS=2;CKEDITOR.ENLARGE_LIST_ITEM_CONTENTS=3;CKEDITOR.START=1;CKEDITOR.END=2;CKEDITOR.STARTEND=3;CKEDITOR.SHRINK_ELEMENT=1;CKEDITOR.SHRINK_TEXT=2;(function()
{if(CKEDITOR.env.webkit)
{CKEDITOR.env.hc=false;return;}
var useSpacer=CKEDITOR.env.ie&&CKEDITOR.env.version<7,useBlank=CKEDITOR.env.ie&&CKEDITOR.env.version==7;var backgroundImageUrl=useSpacer?(CKEDITOR.basePath+'images/spacer.gif?20100510'):useBlank?'about:blank':'data:image/png;base64,';var hcDetect=CKEDITOR.dom.element.createFromHtml('<div style="width:0px;height:0px;'+'position:absolute;left:-10000px;'+'background-image:url('+backgroundImageUrl+')"></div>',CKEDITOR.document);hcDetect.appendTo(CKEDITOR.document.getHead());try
{CKEDITOR.env.hc=(hcDetect.getComputedStyle('background-image')=='none');}
catch(e)
{CKEDITOR.env.hc=false;}
if(CKEDITOR.env.hc)
CKEDITOR.env.cssClass+=' cke_hc';hcDetect.remove();})();CKEDITOR.plugins.load(CKEDITOR.config.corePlugins.split(','),function()
{CKEDITOR.status='loaded';CKEDITOR.fire('loaded');var pending=CKEDITOR._.pending;if(pending)
{delete CKEDITOR._.pending;for(var i=0;i<pending.length;i++)
CKEDITOR.add(pending[i]);}});CKEDITOR.skins.add('kama',(function()
{var preload=[],uiColorStylesheetId='cke_ui_color';if(CKEDITOR.env.ie&&CKEDITOR.env.version<7)
{preload.push('icons.png?20100510','images/sprites_ie6.png?20100510','images/dialog_sides.gif?20100510');}
return{preload:preload,editor:{css:['editor.css']},dialog:{css:['dialog.css']},templates:{css:['templates.css']},margins:[0,0,0,0],init:function(editor)
{if(editor.config.width&&!isNaN(editor.config.width))
editor.config.width-=12;var uiColorMenus=[];var uiColorRegex=/\$color/g;var uiColorMenuCss="/* UI Color Support */\
.cke_skin_kama .cke_menuitem .cke_icon_wrapper\
{\
 background-color: $color !important;\
 border-color: $color !important;\
}\
\
.cke_skin_kama .cke_menuitem a:hover .cke_icon_wrapper,\
.cke_skin_kama .cke_menuitem a:focus .cke_icon_wrapper,\
.cke_skin_kama .cke_menuitem a:active .cke_icon_wrapper\
{\
 background-color: $color !important;\
 border-color: $color !important;\
}\
\
.cke_skin_kama .cke_menuitem a:hover .cke_label,\
.cke_skin_kama .cke_menuitem a:focus .cke_label,\
.cke_skin_kama .cke_menuitem a:active .cke_label\
{\
 background-color: $color !important;\
}\
\
.cke_skin_kama .cke_menuitem a.cke_disabled:hover .cke_label,\
.cke_skin_kama .cke_menuitem a.cke_disabled:focus .cke_label,\
.cke_skin_kama .cke_menuitem a.cke_disabled:active .cke_label\
{\
 background-color: transparent !important;\
}\
\
.cke_skin_kama .cke_menuitem a.cke_disabled:hover .cke_icon_wrapper,\
.cke_skin_kama .cke_menuitem a.cke_disabled:focus .cke_icon_wrapper,\
.cke_skin_kama .cke_menuitem a.cke_disabled:active .cke_icon_wrapper\
{\
 background-color: $color !important;\
 border-color: $color !important;\
}\
\
.cke_skin_kama .cke_menuitem a.cke_disabled .cke_icon_wrapper\
{\
 background-color: $color !important;\
 border-color: $color !important;\
}\
\
.cke_skin_kama .cke_menuseparator\
{\
 background-color: $color !important;\
}\
\
.cke_skin_kama .cke_menuitem a:hover,\
.cke_skin_kama .cke_menuitem a:focus,\
.cke_skin_kama .cke_menuitem a:active\
{\
 background-color: $color !important;\
}";if(CKEDITOR.env.webkit)
{uiColorMenuCss=uiColorMenuCss.split('}').slice(0,-1);for(var i=0;i<uiColorMenuCss.length;i++)
uiColorMenuCss[i]=uiColorMenuCss[i].split('{');}
function getStylesheet(document)
{var node=document.getById(uiColorStylesheetId);if(!node)
{node=document.getHead().append('style');node.setAttribute("id",uiColorStylesheetId);node.setAttribute("type","text/css");}
return node;}
function updateStylesheets(styleNodes,styleContent,replace)
{var r,i,content;for(var id=0;id<styleNodes.length;id++)
{if(CKEDITOR.env.webkit)
{for(i=0;i<styleContent.length;i++)
{content=styleContent[i][1];for(r=0;r<replace.length;r++)
content=content.replace(replace[r][0],replace[r][1]);styleNodes[id].$.sheet.addRule(styleContent[i][0],content);}}
else
{content=styleContent;for(r=0;r<replace.length;r++)
content=content.replace(replace[r][0],replace[r][1]);if(CKEDITOR.env.ie)
styleNodes[id].$.styleSheet.cssText+=content;else
styleNodes[id].$.innerHTML+=content;}}}
var uiColorRegexp=/\$color/g;CKEDITOR.tools.extend(editor,{uiColor:null,getUiColor:function()
{return this.uiColor;},setUiColor:function(color)
{var cssContent,uiStyle=getStylesheet(CKEDITOR.document),cssId='.cke_editor_'+CKEDITOR.tools.escapeCssSelector(editor.name);var cssSelectors=[cssId+" .cke_wrapper",cssId+"_dialog .cke_dialog_contents",cssId+"_dialog a.cke_dialog_tab",cssId+"_dialog .cke_dialog_footer"].join(',');var cssProperties="background-color: $color !important;";if(CKEDITOR.env.webkit)
cssContent=[[cssSelectors,cssProperties]];else
cssContent=cssSelectors+'{'+cssProperties+'}';return(this.setUiColor=function(color)
{var replace=[[uiColorRegexp,color]];editor.uiColor=color;updateStylesheets([uiStyle],cssContent,replace);updateStylesheets(uiColorMenus,uiColorMenuCss,replace);})(color);}});editor.on('menuShow',function(event)
{var panel=event.data[0];var iframe=panel.element.getElementsByTag('iframe').getItem(0).getFrameDocument();if(!iframe.getById('cke_ui_color'))
{var node=getStylesheet(iframe);uiColorMenus.push(node);var color=editor.getUiColor();if(color)
updateStylesheets([node],uiColorMenuCss,[[uiColorRegexp,color]]);}});if(editor.config.uiColor)
editor.setUiColor(editor.config.uiColor);}};})());(function()
{CKEDITOR.dialog?dialogSetup():CKEDITOR.on('dialogPluginReady',dialogSetup);function dialogSetup()
{CKEDITOR.dialog.on('resize',function(evt)
{var data=evt.data,width=data.width,height=data.height,dialog=data.dialog,contents=dialog.parts.contents;if(data.skin!='kama')
return;contents.setStyles({width:width+'px',height:height+'px'});setTimeout(function()
{var innerDialog=dialog.parts.dialog.getChild([0,0,0]),body=innerDialog.getChild(0);var el=innerDialog.getChild(2);el.setStyle('width',(body.$.offsetWidth)+'px');el=innerDialog.getChild(7);el.setStyle('width',(body.$.offsetWidth-28)+'px');el=innerDialog.getChild(4);el.setStyle('height',(body.$.offsetHeight-31-14)+'px');el=innerDialog.getChild(5);el.setStyle('height',(body.$.offsetHeight-31-14)+'px');},100);});}})();(function()
{var pluginName='a11yhelp',commandName='a11yHelp';CKEDITOR.plugins.add(pluginName,{availableLangs:{en:1},init:function(editor)
{var plugin=this;editor.addCommand(commandName,{exec:function()
{var langCode=editor.langCode;langCode=plugin.availableLangs[langCode]?langCode:'en';CKEDITOR.scriptLoader.load(CKEDITOR.getUrl(plugin.path+'lang/'+langCode+'.js'),function()
{CKEDITOR.tools.extend(editor.lang,plugin.lang[langCode]);editor.openDialog(commandName);});},modes:{wysiwyg:1,source:1},canUndo:false});CKEDITOR.dialog.add(commandName,this.path+'dialogs/a11yhelp.js');}});})();CKEDITOR.plugins.add('basicstyles',{requires:['styles','button'],init:function(editor)
{var addButtonCommand=function(buttonName,buttonLabel,commandName,styleDefiniton)
{var style=new CKEDITOR.style(styleDefiniton);editor.attachStyleStateChange(style,function(state)
{editor.getCommand(commandName).setState(state);});editor.addCommand(commandName,new CKEDITOR.styleCommand(style));editor.ui.addButton(buttonName,{label:buttonLabel,command:commandName});};var config=editor.config;var lang=editor.lang;addButtonCommand('Bold',lang.bold,'bold',config.coreStyles_bold);addButtonCommand('Italic',lang.italic,'italic',config.coreStyles_italic);addButtonCommand('Underline',lang.underline,'underline',config.coreStyles_underline);addButtonCommand('Strike',lang.strike,'strike',config.coreStyles_strike);addButtonCommand('Subscript',lang.subscript,'subscript',config.coreStyles_subscript);addButtonCommand('Superscript',lang.superscript,'superscript',config.coreStyles_superscript);}});CKEDITOR.config.coreStyles_bold={element:'strong',overrides:'b'};CKEDITOR.config.coreStyles_italic={element:'em',overrides:'i'};CKEDITOR.config.coreStyles_underline={element:'u'};CKEDITOR.config.coreStyles_strike={element:'strike'};CKEDITOR.config.coreStyles_subscript={element:'sub'};CKEDITOR.config.coreStyles_superscript={element:'sup'};(function()
{function getState(editor,path)
{var firstBlock=path.block||path.blockLimit;if(!firstBlock||firstBlock.getName()=='body')
return CKEDITOR.TRISTATE_OFF;if(firstBlock.getAscendant('blockquote',true))
return CKEDITOR.TRISTATE_ON;return CKEDITOR.TRISTATE_OFF;}
function onSelectionChange(evt)
{var editor=evt.editor,command=editor.getCommand('blockquote');command.state=getState(editor,evt.data.path);command.fire('state');}
function noBlockLeft(bqBlock)
{for(var i=0,length=bqBlock.getChildCount(),child;i<length&&(child=bqBlock.getChild(i));i++)
{if(child.type==CKEDITOR.NODE_ELEMENT&&child.isBlockBoundary())
return false;}
return true;}
var commandObject={exec:function(editor)
{var state=editor.getCommand('blockquote').state,selection=editor.getSelection(),range=selection&&selection.getRanges()[0];if(!range)
return;var bookmarks=selection.createBookmarks();if(CKEDITOR.env.ie)
{var bookmarkStart=bookmarks[0].startNode,bookmarkEnd=bookmarks[0].endNode,cursor;if(bookmarkStart&&bookmarkStart.getParent().getName()=='blockquote')
{cursor=bookmarkStart;while((cursor=cursor.getNext()))
{if(cursor.type==CKEDITOR.NODE_ELEMENT&&cursor.isBlockBoundary())
{bookmarkStart.move(cursor,true);break;}}}
if(bookmarkEnd&&bookmarkEnd.getParent().getName()=='blockquote')
{cursor=bookmarkEnd;while((cursor=cursor.getPrevious()))
{if(cursor.type==CKEDITOR.NODE_ELEMENT&&cursor.isBlockBoundary())
{bookmarkEnd.move(cursor);break;}}}}
var iterator=range.createIterator(),block;if(state==CKEDITOR.TRISTATE_OFF)
{var paragraphs=[];while((block=iterator.getNextParagraph()))
paragraphs.push(block);if(paragraphs.length<1)
{var para=editor.document.createElement(editor.config.enterMode==CKEDITOR.ENTER_P?'p':'div'),firstBookmark=bookmarks.shift();range.insertNode(para);para.append(new CKEDITOR.dom.text('\ufeff',editor.document));range.moveToBookmark(firstBookmark);range.selectNodeContents(para);range.collapse(true);firstBookmark=range.createBookmark();paragraphs.push(para);bookmarks.unshift(firstBookmark);}
var commonParent=paragraphs[0].getParent(),tmp=[];for(var i=0;i<paragraphs.length;i++)
{block=paragraphs[i];commonParent=commonParent.getCommonAncestor(block.getParent());}
var denyTags={table:1,tbody:1,tr:1,ol:1,ul:1};while(denyTags[commonParent.getName()])
commonParent=commonParent.getParent();var lastBlock=null;while(paragraphs.length>0)
{block=paragraphs.shift();while(!block.getParent().equals(commonParent))
block=block.getParent();if(!block.equals(lastBlock))
tmp.push(block);lastBlock=block;}
while(tmp.length>0)
{block=tmp.shift();if(block.getName()=='blockquote')
{var docFrag=new CKEDITOR.dom.documentFragment(editor.document);while(block.getFirst())
{docFrag.append(block.getFirst().remove());paragraphs.push(docFrag.getLast());}
docFrag.replace(block);}
else
paragraphs.push(block);}
var bqBlock=editor.document.createElement('blockquote');bqBlock.insertBefore(paragraphs[0]);while(paragraphs.length>0)
{block=paragraphs.shift();bqBlock.append(block);}}
else if(state==CKEDITOR.TRISTATE_ON)
{var moveOutNodes=[],database={};while((block=iterator.getNextParagraph()))
{var bqParent=null,bqChild=null;while(block.getParent())
{if(block.getParent().getName()=='blockquote')
{bqParent=block.getParent();bqChild=block;break;}
block=block.getParent();}
if(bqParent&&bqChild&&!bqChild.getCustomData('blockquote_moveout'))
{moveOutNodes.push(bqChild);CKEDITOR.dom.element.setMarker(database,bqChild,'blockquote_moveout',true);}}
CKEDITOR.dom.element.clearAllMarkers(database);var movedNodes=[],processedBlockquoteBlocks=[];database={};while(moveOutNodes.length>0)
{var node=moveOutNodes.shift();bqBlock=node.getParent();if(!node.getPrevious())
node.remove().insertBefore(bqBlock);else if(!node.getNext())
node.remove().insertAfter(bqBlock);else
{node.breakParent(node.getParent());processedBlockquoteBlocks.push(node.getNext());}
if(!bqBlock.getCustomData('blockquote_processed'))
{processedBlockquoteBlocks.push(bqBlock);CKEDITOR.dom.element.setMarker(database,bqBlock,'blockquote_processed',true);}
movedNodes.push(node);}
CKEDITOR.dom.element.clearAllMarkers(database);for(i=processedBlockquoteBlocks.length-1;i>=0;i--)
{bqBlock=processedBlockquoteBlocks[i];if(noBlockLeft(bqBlock))
bqBlock.remove();}
if(editor.config.enterMode==CKEDITOR.ENTER_BR)
{var firstTime=true;while(movedNodes.length)
{node=movedNodes.shift();if(node.getName()=='div')
{docFrag=new CKEDITOR.dom.documentFragment(editor.document);var needBeginBr=firstTime&&node.getPrevious()&&!(node.getPrevious().type==CKEDITOR.NODE_ELEMENT&&node.getPrevious().isBlockBoundary());if(needBeginBr)
docFrag.append(editor.document.createElement('br'));var needEndBr=node.getNext()&&!(node.getNext().type==CKEDITOR.NODE_ELEMENT&&node.getNext().isBlockBoundary());while(node.getFirst())
node.getFirst().remove().appendTo(docFrag);if(needEndBr)
docFrag.append(editor.document.createElement('br'));docFrag.replace(node);firstTime=false;}}}}
selection.selectBookmarks(bookmarks);editor.focus();}};CKEDITOR.plugins.add('blockquote',{init:function(editor)
{editor.addCommand('blockquote',commandObject);editor.ui.addButton('Blockquote',{label:editor.lang.blockquote,command:'blockquote'});editor.on('selectionChange',onSelectionChange);},requires:['domiterator']});})();CKEDITOR.plugins.add('button',{beforeInit:function(editor)
{editor.ui.addHandler(CKEDITOR.UI_BUTTON,CKEDITOR.ui.button.handler);}});CKEDITOR.UI_BUTTON=1;CKEDITOR.ui.button=function(definition)
{CKEDITOR.tools.extend(this,definition,{title:definition.label,className:definition.className||(definition.command&&'cke_button_'+definition.command)||'',click:definition.click||function(editor)
{editor.execCommand(definition.command);}});this._={};};CKEDITOR.ui.button.handler={create:function(definition)
{return new CKEDITOR.ui.button(definition);}};CKEDITOR.ui.button.prototype={canGroup:true,render:function(editor,output)
{var env=CKEDITOR.env,id=this._.id='cke_'+CKEDITOR.tools.getNextNumber(),classes='',command=this.command,clickFn,index;this._.editor=editor;var instance={id:id,button:this,editor:editor,focus:function()
{var element=CKEDITOR.document.getById(id);element.focus();},execute:function()
{this.editor.fire('buttonClick',{button:this.button});this.button.click(editor);}};instance.clickFn=clickFn=CKEDITOR.tools.addFunction(instance.execute,instance);instance.index=index=CKEDITOR.ui.button._.instances.push(instance)-1;if(this.modes)
{editor.on('mode',function()
{if(!RTE.loaded){this.setState(CKEDITOR.TRISTATE_DISABLED);return;}
this.setState(this.modes[editor.mode]?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED);},this);}
else if(command)
{command=editor.getCommand(command);if(command)
{command.on('state',function()
{if(!RTE.loaded){this.setState(CKEDITOR.TRISTATE_DISABLED);return;}
this.setState(command.state);},this);classes+='cke_'+(command.state==CKEDITOR.TRISTATE_ON?'on':command.state==CKEDITOR.TRISTATE_DISABLED?'disabled':'off');}}
if(!command)
classes+='cke_off';if(this.className)
classes+=' '+this.className;output.push('<span class="cke_button '+classes+(this.wrapperClassName?(' '+this.wrapperClassName):'')+'">','<a id="',id,'"'+' class="',classes,'"',env.gecko&&env.version>=10900&&!env.hc?'':'" href="javascript:void(\''+(this.title||'').replace("'"+'')+'\')"',' title="',this.title,'"'+' tabindex="-1"'+' hidefocus="true"'+' role="button"'+' aria-labelledby="'+id+'_label"'+
(this.hasArrow?' aria-haspopup="true"':''));if(env.opera||(env.gecko&&env.mac))
{output.push(' onkeypress="return false;"');}
if(env.gecko)
{output.push(' onblur="this.style.cssText = this.style.cssText;"');}
output.push(' onkeydown="return CKEDITOR.ui.button._.keydown(',index,', event);"'+' onfocus="return CKEDITOR.ui.button._.focus(',index,', event);"'+' onclick="CKEDITOR.tools.callFunction(',clickFn,', this); return false;">'+'<span class="cke_icon"');if(this.icon)
{var offset=(this.iconOffset||0)*-16;output.push(' style="background-image:url(',CKEDITOR.getUrl(this.icon),');background-position:0 '+offset+'px;"');}
output.push('></span>'+'<span id="',id,'_label" class="cke_label">',this.label,'</span>');if(this.hasArrow)
{output.push('<span class="cke_buttonarrow">'
+(CKEDITOR.env.hc?'&#9660;':'')
+'</span>');}
output.push('</a>','</span>');if(this.onRender)
this.onRender();return instance;},setState:function(state)
{if(this._.state==state)
return false;this._.state=state;var element=CKEDITOR.document.getById(this._.id);if(element)
{element.setState(state);state==CKEDITOR.TRISTATE_DISABLED?element.setAttribute('aria-disabled',true):element.removeAttribute('aria-disabled');state==CKEDITOR.TRISTATE_ON?element.setAttribute('aria-pressed',true):element.removeAttribute('aria-pressed');return true;}
else
return false;}};CKEDITOR.ui.button._={instances:[],keydown:function(index,ev)
{var instance=CKEDITOR.ui.button._.instances[index];if(instance.onkey)
{ev=new CKEDITOR.dom.event(ev);return(instance.onkey(instance,ev.getKeystroke())!==false);}},focus:function(index,ev)
{var instance=CKEDITOR.ui.button._.instances[index],retVal;if(instance.onfocus)
retVal=(instance.onfocus(instance,new CKEDITOR.dom.event(ev))!==false);if(CKEDITOR.env.gecko&&CKEDITOR.env.version<10900)
ev.preventBubble();return retVal;}};CKEDITOR.ui.prototype.addButton=function(name,definition)
{this.add(name,CKEDITOR.UI_BUTTON,definition);};(function()
{var execIECommand=function(editor,command)
{var doc=editor.document,body=doc.getBody();var enabled=false;var onExec=function()
{enabled=true;};body.on(command,onExec);(CKEDITOR.env.version>7?doc.$:doc.$.selection.createRange())['execCommand'](command);body.removeListener(command,onExec);return enabled;};var tryToCutCopy=CKEDITOR.env.ie?function(editor,type)
{return execIECommand(editor,type);}:function(editor,type)
{try
{return editor.document.$.execCommand(type);}
catch(e)
{return false;}};var cutCopyCmd=function(type)
{this.type=type;this.canUndo=(this.type=='cut');};cutCopyCmd.prototype={exec:function(editor,data)
{var success=tryToCutCopy(editor,this.type);if(!success)
alert(editor.lang.clipboard[this.type+'Error']);return success;}};var pasteCmd={canUndo:false,exec:CKEDITOR.env.ie?function(editor)
{editor.focus();if(!editor.document.getBody().fire('beforepaste')&&!execIECommand(editor,'paste'))
{editor.fire('pasteDialog');return false;}}:function(editor)
{try
{if(!editor.document.getBody().fire('beforepaste')&&!editor.document.$.execCommand('Paste',false,null))
{throw 0;}}
catch(e)
{setTimeout(function()
{editor.fire('pasteDialog');},0);return false;}}};var onKey=function(event)
{if(this.mode!='wysiwyg')
return;switch(event.data.keyCode)
{case CKEDITOR.CTRL+86:case CKEDITOR.SHIFT+45:var body=this.document.getBody();if(!CKEDITOR.env.ie&&body.fire('beforepaste'))
event.cancel();else if(CKEDITOR.env.opera||CKEDITOR.env.gecko&&CKEDITOR.env.version<10900)
body.fire('paste');return;case CKEDITOR.CTRL+88:case CKEDITOR.SHIFT+46:var editor=this;this.fire('saveSnapshot');setTimeout(function()
{editor.fire('saveSnapshot');},0);}};function getClipboardData(evt,mode,callback)
{var doc=this.document;if(CKEDITOR.env.ie&&doc.getById('cke_pastebin'))
return;if(mode=='text'&&evt.data&&evt.data.$.clipboardData)
{var plain=evt.data.$.clipboardData.getData('text/plain');if(plain)
{evt.data.preventDefault();callback(plain);return;}}
var sel=this.getSelection(),range=new CKEDITOR.dom.range(doc);var pastebin=new CKEDITOR.dom.element(mode=='text'?'textarea':'div',doc);pastebin.setAttribute('id','cke_pastebin');CKEDITOR.env.webkit&&pastebin.append(doc.createText('\xa0'));doc.getBody().append(pastebin);pastebin.setStyles({position:'absolute',left:'-1000px',top:sel.getStartElement().getDocumentPosition().y+'px',width:'1px',height:'1px',overflow:'hidden'});var bms=sel.createBookmarks();if(mode=='text')
{if(CKEDITOR.env.ie)
{var ieRange=doc.getBody().$.createTextRange();ieRange.moveToElementText(pastebin.$);ieRange.execCommand('Paste');evt.data.preventDefault();}
else
{doc.$.designMode='off';pastebin.$.focus();}}
else
{range.setStartAt(pastebin,CKEDITOR.POSITION_AFTER_START);range.setEndAt(pastebin,CKEDITOR.POSITION_BEFORE_END);range.select(true);}
window.setTimeout(function()
{mode=='text'&&!CKEDITOR.env.ie&&(doc.$.designMode='on');pastebin.remove();var bogusSpan;pastebin=(CKEDITOR.env.webkit&&(bogusSpan=pastebin.getFirst())&&(bogusSpan.is&&bogusSpan.hasClass('Apple-style-span'))?bogusSpan:pastebin);sel.selectBookmarks(bms);callback(pastebin['get'+(mode=='text'?'Value':'Html')]());},0);}
CKEDITOR.plugins.add('clipboard',{requires:['dialog','htmldataprocessor'],init:function(editor)
{editor.on('paste',function(evt)
{var data=evt.data;if(data['html'])
editor.insertHtml(data['html']);else if(data['text'])
editor.insertText(data['text']);},null,null,1000);editor.on('pasteDialog',function(evt)
{setTimeout(function()
{editor.openDialog('paste');},0);});function addButtonCommand(buttonName,commandName,command,ctxMenuOrder)
{var lang=editor.lang[commandName];editor.addCommand(commandName,command);editor.ui.addButton(buttonName,{label:lang,command:commandName});if(editor.addMenuItems)
{editor.addMenuItem(commandName,{label:lang,command:commandName,group:'clipboard',order:ctxMenuOrder});}}
addButtonCommand('Cut','cut',new cutCopyCmd('cut'),1);addButtonCommand('Copy','copy',new cutCopyCmd('copy'),4);addButtonCommand('Paste','paste',pasteCmd,8);CKEDITOR.dialog.add('paste',CKEDITOR.getUrl(this.path+'dialogs/paste.js'));editor.on('key',onKey,editor);var mode=editor.config.forcePasteAsPlainText?'text':'html';if(editor.contextMenu)
{var depressBeforePasteEvent;function stateFromNamedCommand(command)
{CKEDITOR.env.ie&&command=='Paste'&&(depressBeforePasteEvent=1);var retval=editor.document.$.queryCommandEnabled(command)?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED;depressBeforePasteEvent=0;return retval;}
editor.contextMenu.addListener(function()
{return{cut:stateFromNamedCommand('Cut'),copy:stateFromNamedCommand('Cut'),paste:CKEDITOR.env.webkit?CKEDITOR.TRISTATE_OFF:stateFromNamedCommand('Paste')};});}}});})();CKEDITOR.plugins.add('colorbutton',{requires:['panelbutton','floatpanel','styles'],init:function(editor)
{var config=editor.config,lang=editor.lang.colorButton;var clickFn;if(!CKEDITOR.env.hc)
{addButton('TextColor','fore',lang.textColorTitle);addButton('BGColor','back',lang.bgColorTitle);}
function addButton(name,type,title)
{editor.ui.add(name,CKEDITOR.UI_PANELBUTTON,{label:title,title:title,className:'cke_button_'+name.toLowerCase(),modes:{wysiwyg:1},panel:{css:editor.skin.editor.css,attributes:{role:'listbox','aria-label':lang.panelTitle}},onBlock:function(panel,block)
{block.autoSize=true;block.element.addClass('cke_colorblock');block.element.setHtml(renderColors(panel,type));var keys=block.keys;keys[39]='next';keys[40]='next';keys[9]='next';keys[37]='prev';keys[38]='prev';keys[CKEDITOR.SHIFT+9]='prev';keys[32]='click';}});}
function renderColors(panel,type)
{var output=[],colors=config.colorButton_colors.split(','),total=colors.length+(config.colorButton_enableMore?2:1);var clickFn=CKEDITOR.tools.addFunction(function(color,type)
{if(color=='?')
{var applyColorStyle=arguments.callee;function onColorDialogClose(evt)
{this.removeListener('ok',onColorDialogClose);this.removeListener('cancel',onColorDialogClose);evt.name=='ok'&&applyColorStyle(this.getContentElement('picker','selectedColor').getValue(),type);}
editor.openDialog('colordialog',function()
{this.on('ok',onColorDialogClose);this.on('cancel',onColorDialogClose);});return;}
editor.focus();panel.hide();editor.fire('saveSnapshot');new CKEDITOR.style(config['colorButton_'+type+'Style'],{color:'inherit'}).remove(editor.document);if(color)
{var colorStyle=config['colorButton_'+type+'Style'];colorStyle.childRule=type=='back'?function(){return false;}:function(element){return element.getName()!='a';};new CKEDITOR.style(colorStyle,{color:color}).apply(editor.document);}
editor.fire('saveSnapshot');});output.push('<a class="cke_colorauto" _cke_focus=1 hidefocus=true'+' title="',lang.auto,'"'+' onclick="CKEDITOR.tools.callFunction(',clickFn,',null,\'',type,'\');return false;"'+' href="javascript:void(\'',lang.auto,'\')"'+' role="option" aria-posinset="1" aria-setsize="',total,'">'+'<table role="presentation" cellspacing=0 cellpadding=0 width="100%">'+'<tr>'+'<td>'+'<span class="cke_colorbox" style="background-color:#000"></span>'+'</td>'+'<td colspan=7 align=center>',lang.auto,'</td>'+'</tr>'+'</table>'+'</a>'+'<table role="presentation" cellspacing=0 cellpadding=0 width="100%">');for(var i=0;i<colors.length;i++)
{if((i%8)===0)
output.push('</tr><tr>');var parts=colors[i].split('/'),colorName=parts[0],colorCode=parts[1]||colorName;if(!parts[1])
colorName='#'+colorName;var colorLabel=editor.lang.colors[colorCode]||colorCode;output.push('<td>'+'<a class="cke_colorbox" _cke_focus=1 hidefocus=true'+' title="',colorLabel,'"'+' onclick="CKEDITOR.tools.callFunction(',clickFn,',\'',colorName,'\',\'',type,'\'); return false;"'+' href="javascript:void(\'',colorLabel,'\')"'+' role="option" aria-posinset="',(i+2),'" aria-setsize="',total,'">'+'<span class="cke_colorbox" style="background-color:#',colorCode,'"></span>'+'</a>'+'</td>');}
if(config.colorButton_enableMore)
{output.push('</tr>'+'<tr>'+'<td colspan=8 align=center>'+'<a class="cke_colormore" _cke_focus=1 hidefocus=true'+' title="',lang.more,'"'+' onclick="CKEDITOR.tools.callFunction(',clickFn,',\'?\',\'',type,'\');return false;"'+' href="javascript:void(\'',lang.more,'\')"',' role="option" aria-posinset="',total,'" aria-setsize="',total,'">',lang.more,'</a>'+'</td>');}
output.push('</tr></table>');return output.join('');}}});CKEDITOR.config.colorButton_enableMore=true;CKEDITOR.config.colorButton_colors='000,800000,8B4513,2F4F4F,008080,000080,4B0082,696969,'+'B22222,A52A2A,DAA520,006400,40E0D0,0000CD,800080,808080,'+'F00,FF8C00,FFD700,008000,0FF,00F,EE82EE,A9A9A9,'+'FFA07A,FFA500,FFFF00,00FF00,AFEEEE,ADD8E6,DDA0DD,D3D3D3,'+'FFF0F5,FAEBD7,FFFFE0,F0FFF0,F0FFFF,F0F8FF,E6E6FA,FFF';CKEDITOR.config.colorButton_foreStyle={element:'span',styles:{'color':'#(color)'},overrides:[{element:'font',attributes:{'color':null}}]};CKEDITOR.config.colorButton_backStyle={element:'span',styles:{'background-color':'#(color)'}};(function()
{CKEDITOR.plugins.colordialog={init:function(editor)
{editor.addCommand('colordialog',new CKEDITOR.dialogCommand('colordialog'));CKEDITOR.dialog.add('colordialog',this.path+'dialogs/colordialog.js');}};CKEDITOR.plugins.add('colordialog',CKEDITOR.plugins.colordialog);})();CKEDITOR.plugins.add('contextmenu',{requires:['menu'],beforeInit:function(editor)
{editor.contextMenu=new CKEDITOR.plugins.contextMenu(editor);editor.addCommand('contextMenu',{exec:function()
{editor.contextMenu.show(editor.document.getBody());}});}});CKEDITOR.plugins.contextMenu=CKEDITOR.tools.createClass({$:function(editor)
{this.id='cke_'+CKEDITOR.tools.getNextNumber();this.editor=editor;this._.listeners=[];this._.functionId=CKEDITOR.tools.addFunction(function(commandName)
{this._.panel.hide();editor.focus();editor.execCommand(commandName);},this);this.definition={panel:{className:editor.skinClass+' cke_contextmenu',attributes:{'aria-label':editor.lang.contextmenu.options}}};},_:{onMenu:function(offsetParent,corner,offsetX,offsetY)
{var menu=this._.menu,editor=this.editor;editor.fire('contextMenuOnOpen',{menu:menu});if(menu)
{menu.hide();menu.removeAll();}
else
{menu=this._.menu=new CKEDITOR.menu(editor,this.definition);menu.onClick=CKEDITOR.tools.bind(function(item)
{menu.hide();editor.fire('contextMenuOnClick',{menu:menu,item:item});if(item.onClick)
item.onClick();else if(item.command)
editor.execCommand(item.command);},this);menu.onEscape=function()
{var parent=this.parent;if(parent)
{parent._.panel.hideChild();var parentBlock=parent._.panel._.panel._.currentBlock,parentFocusIndex=parentBlock._.focusIndex;parentBlock._.markItem(parentFocusIndex);}
else if(keystroke==27)
{this.hide();editor.focus();}
return false;};}
var listeners=this._.listeners,includedItems=[];var selection=this.editor.getSelection(),element=selection&&selection.getStartElement();menu.onHide=CKEDITOR.tools.bind(function()
{menu.onHide=null;if(CKEDITOR.env.ie)
{var selection=editor.getSelection();selection&&selection.unlock();}
this.onHide&&this.onHide();},this);for(var i=0;i<listeners.length;i++)
{var listenerItems=listeners[i](element,selection);if(listenerItems)
{for(var itemName in listenerItems)
{var item=this.editor.getMenuItem(itemName);if(item)
{item.state=listenerItems[itemName];menu.add(item);}}}}
menu.items.length&&menu.show(offsetParent,corner||(editor.lang.dir=='rtl'?2:1),offsetX,offsetY);}},proto:{addTarget:function(element,nativeContextMenuOnCtrl)
{if(CKEDITOR.env.opera)
{var contextMenuOverrideButton;element.on('mousedown',function(evt)
{evt=evt.data;if(evt.$.button!=2)
{if(evt.getKeystroke()==CKEDITOR.CTRL+1)
element.fire('contextmenu',evt);return;}
if(nativeContextMenuOnCtrl&&(evt.$.ctrlKey||evt.$.metaKey))
return;var target=evt.getTarget();if(!contextMenuOverrideButton)
{var ownerDoc=target.getDocument();contextMenuOverrideButton=ownerDoc.createElement('input');contextMenuOverrideButton.$.type='button';ownerDoc.getBody().append(contextMenuOverrideButton);}
contextMenuOverrideButton.setAttribute('style','position:absolute;top:'+(evt.$.clientY-2)+'px;left:'+(evt.$.clientX-2)+'px;width:5px;height:5px;opacity:0.01');});element.on('mouseup',function(evt)
{if(contextMenuOverrideButton)
{contextMenuOverrideButton.remove();contextMenuOverrideButton=undefined;element.fire('contextmenu',evt.data);}});}
element.on('contextmenu',function(event)
{var domEvent=event.data;if(nativeContextMenuOnCtrl&&(CKEDITOR.env.webkit?holdCtrlKey:domEvent.$.ctrlKey||domEvent.$.metaKey))
return;if(CKEDITOR.env.ie)
{var selection=this.editor.getSelection();selection&&selection.lock();}
domEvent.preventDefault();domEvent.stopPropagation();var offsetParent=domEvent.getTarget().getDocument().getDocumentElement(),offsetX=domEvent.$.clientX,offsetY=domEvent.$.clientY;CKEDITOR.tools.setTimeout(function()
{this.show(offsetParent,null,offsetX,offsetY);},0,this);},this);if(CKEDITOR.env.webkit)
{var holdCtrlKey,onKeyDown=function(event)
{holdCtrlKey=event.data.$.ctrlKey||event.data.$.metaKey;},resetOnKeyUp=function()
{holdCtrlKey=0;};element.on('keydown',onKeyDown);element.on('keyup',resetOnKeyUp);element.on('contextmenu',resetOnKeyUp);}},addListener:function(listenerFn)
{this._.listeners.push(listenerFn);},show:function(offsetParent,corner,offsetX,offsetY)
{this.editor.focus();this._.onMenu(offsetParent||CKEDITOR.document.getDocumentElement(),corner,offsetX||0,offsetY||0);}}});(function()
{CKEDITOR.plugins.add('div',{requires:['editingblock','domiterator','styles'],init:function(editor)
{var lang=editor.lang.div;editor.addCommand('creatediv',new CKEDITOR.dialogCommand('creatediv'));editor.addCommand('editdiv',new CKEDITOR.dialogCommand('editdiv'));editor.addCommand('removediv',{exec:function(editor)
{var selection=editor.getSelection(),ranges=selection&&selection.getRanges(),range,bookmarks=selection.createBookmarks(),walker,toRemove=[];function findDiv(node)
{var path=new CKEDITOR.dom.elementPath(node),blockLimit=path.blockLimit,div=blockLimit.is('div')&&blockLimit;if(div&&!div.getAttribute('_cke_div_added'))
{toRemove.push(div);div.setAttribute('_cke_div_added');}}
for(var i=0;i<ranges.length;i++)
{range=ranges[i];if(range.collapsed)
findDiv(selection.getStartElement());else
{walker=new CKEDITOR.dom.walker(range);walker.evaluator=findDiv;walker.lastForward();}}
for(i=0;i<toRemove.length;i++)
toRemove[i].remove(true);selection.selectBookmarks(bookmarks);}});editor.ui.addButton('CreateDiv',{label:lang.toolbar,command:'creatediv'});if(editor.addMenuItems)
{editor.addMenuItems({editdiv:{label:lang.edit,command:'editdiv',group:'div',order:1},removediv:{label:lang.remove,command:'removediv',group:'div',order:5}});if(editor.contextMenu)
{editor.contextMenu.addListener(function(element,selection)
{if(!element)
return null;var elementPath=new CKEDITOR.dom.elementPath(element),blockLimit=elementPath.blockLimit;if(blockLimit&&blockLimit.getAscendant('div',true))
{return{editdiv:CKEDITOR.TRISTATE_OFF,removediv:CKEDITOR.TRISTATE_OFF};}
return null;});}}
CKEDITOR.dialog.add('creatediv',this.path+'dialogs/div.js');CKEDITOR.dialog.add('editdiv',this.path+'dialogs/div.js');}});})();(function()
{CKEDITOR.plugins.add('enterkey',{requires:['keystrokes','indent'],init:function(editor)
{var specialKeys=editor.specialKeys;specialKeys[13]=enter;specialKeys[CKEDITOR.SHIFT+13]=shiftEnter;}});CKEDITOR.plugins.enterkey={enterBlock:function(editor,mode,range,forceMode)
{range=range||getRange(editor);var doc=range.document;if(range.checkStartOfBlock()&&range.checkEndOfBlock())
{var path=new CKEDITOR.dom.elementPath(range.startContainer),block=path.block;if(block.is('li')||block.getParent().is('li'))
{editor.execCommand('outdent');return;}}
var blockTag=(mode==CKEDITOR.ENTER_DIV?'div':'p');var splitInfo=range.splitBlock(blockTag);if(!splitInfo)
return;var previousBlock=splitInfo.previousBlock,nextBlock=splitInfo.nextBlock;var isStartOfBlock=splitInfo.wasStartOfBlock,isEndOfBlock=splitInfo.wasEndOfBlock;var node;if(nextBlock)
{node=nextBlock.getParent();if(node.is('li'))
{nextBlock.breakParent(node);nextBlock.move(nextBlock.getNext(),true);}}
else if(previousBlock&&(node=previousBlock.getParent())&&node.is('li'))
{previousBlock.breakParent(node);range.moveToElementEditStart(previousBlock.getNext());previousBlock.move(previousBlock.getPrevious());}
if(!isStartOfBlock&&!isEndOfBlock)
{if(nextBlock.is('li')&&(node=nextBlock.getFirst(CKEDITOR.dom.walker.invisible(true)))&&node.is&&node.is('ul','ol'))
(CKEDITOR.env.ie?doc.createText('\xa0'):doc.createElement('br')).insertBefore(node);if(nextBlock){var firstChild=nextBlock.getFirst();if(firstChild.$.nodeType!=CKEDITOR.NODE_COMMENT){nextBlock.setAttribute('_rte_empty_lines_before',1);}
nextBlock.setAttribute('_rte_fromparser',1);range.moveToElementEditStart(nextBlock);}}
else
{var newBlock;if(previousBlock)
{if(previousBlock.is('li')||!(forceMode||headerTagRegex.test(previousBlock.getName())))
{newBlock=previousBlock.clone();}}
else if(nextBlock)
newBlock=nextBlock.clone();if(!newBlock)
newBlock=doc.createElement(blockTag);if(newBlock.is('dl')){newBlock=new CKEDITOR.dom.element('p');}
var elementPath=splitInfo.elementPath;if(elementPath)
{for(var i=0,len=elementPath.elements.length;i<len;i++)
{var element=elementPath.elements[i];if(element.equals(elementPath.block)||element.equals(elementPath.blockLimit))
break;if(CKEDITOR.dtd.$removeEmpty[element.getName()])
{element=element.clone();newBlock.moveChildren(element);newBlock.append(element);}}}
if(!CKEDITOR.env.ie)
newBlock.appendBogus();newBlock.setAttribute('_rte_new_node',true);range.insertNode(newBlock);if(CKEDITOR.env.ie&&isStartOfBlock&&(!isEndOfBlock||!previousBlock.getChildCount()))
{range.moveToElementEditStart(isEndOfBlock?previousBlock:newBlock);range.select();}
range.moveToElementEditStart(isStartOfBlock&&!isEndOfBlock?nextBlock:newBlock);}
if(!CKEDITOR.env.ie)
{if(nextBlock)
{var tmpNode=doc.createElement('span');tmpNode.setHtml('&nbsp;');range.insertNode(tmpNode);tmpNode.scrollIntoView();range.deleteContents();}
else
{newBlock.scrollIntoView();}}
range.select();},enterBr:function(editor,mode,range,forceMode)
{range=range||getRange(editor);var doc=range.document;var blockTag=(mode==CKEDITOR.ENTER_DIV?'div':'p');var isEndOfBlock=range.checkEndOfBlock();var elementPath=new CKEDITOR.dom.elementPath(editor.getSelection().getStartElement());var startBlock=elementPath.block,startBlockTag=startBlock&&elementPath.block.getName();var isPre=false;if(!forceMode&&startBlockTag=='li')
{enterBlock(editor,mode,range,forceMode);return;}
if(!forceMode&&isEndOfBlock&&headerTagRegex.test(startBlockTag))
{doc.createElement('br').insertAfter(startBlock);if(CKEDITOR.env.gecko)
doc.createText('').insertAfter(startBlock);range.setStartAt(startBlock.getNext(),CKEDITOR.env.ie?CKEDITOR.POSITION_BEFORE_START:CKEDITOR.POSITION_AFTER_START);}
else
{var lineBreak;isPre=(startBlockTag=='pre');if(isPre&&!CKEDITOR.env.gecko)
lineBreak=doc.createText(CKEDITOR.env.ie?'\r':'\n');else{lineBreak=doc.createElement('br');lineBreak.setAttribute('_rte_shift_enter',true);}
range.deleteContents();range.insertNode(lineBreak);if(!CKEDITOR.env.ie)
doc.createText('\ufeff').insertAfter(lineBreak);if(isEndOfBlock&&!CKEDITOR.env.ie)
lineBreak.getParent().appendBogus();if(!CKEDITOR.env.ie)
lineBreak.getNext().$.nodeValue='';if(CKEDITOR.env.ie)
range.setStartAt(lineBreak,CKEDITOR.POSITION_AFTER_END);else
range.setStartAt(lineBreak.getNext(),CKEDITOR.POSITION_AFTER_START);if(!CKEDITOR.env.ie)
{var dummy=null;if(!CKEDITOR.env.gecko)
{dummy=doc.createElement('span');dummy.setHtml('&nbsp;');}
else
dummy=doc.createElement('br');dummy.insertBefore(lineBreak.getNext());dummy.scrollIntoView();dummy.remove();}}
range.collapse(true);range.select(isPre);}};var plugin=CKEDITOR.plugins.enterkey,enterBr=plugin.enterBr,enterBlock=plugin.enterBlock,headerTagRegex=/^h[1-6]$/;function shiftEnter(editor)
{return enter(editor,editor.config.shiftEnterMode,true);}
function enter(editor,mode,forceMode)
{forceMode=editor.config.forceEnterMode||forceMode;if(editor.mode!='wysiwyg')
return false;if(!mode)
mode=editor.config.enterMode;setTimeout(function()
{editor.fire('saveSnapshot');if(mode==CKEDITOR.ENTER_BR||editor.getSelection().getStartElement().hasAscendant('pre',true))
enterBr(editor,mode,null,forceMode);else
enterBlock(editor,mode,null,forceMode);},0);return true;}
function getRange(editor)
{var ranges=editor.getSelection().getRanges();for(var i=ranges.length-1;i>0;i--)
{ranges[i].deleteContents();}
return ranges[0];}})();(function()
{var entities='nbsp,gt,lt,quot,'+'iexcl,cent,pound,curren,yen,brvbar,sect,uml,copy,ordf,laquo,'+'not,shy,reg,macr,deg,plusmn,sup2,sup3,acute,micro,para,middot,'+'cedil,sup1,ordm,raquo,frac14,frac12,frac34,iquest,times,divide,'+'fnof,bull,hellip,prime,Prime,oline,frasl,weierp,image,real,trade,'+'alefsym,larr,uarr,rarr,darr,harr,crarr,lArr,uArr,rArr,dArr,hArr,'+'forall,part,exist,empty,nabla,isin,notin,ni,prod,sum,minus,lowast,'+'radic,prop,infin,ang,and,or,cap,cup,int,there4,sim,cong,asymp,ne,'+'equiv,le,ge,sub,sup,nsub,sube,supe,oplus,otimes,perp,sdot,lceil,'+'rceil,lfloor,rfloor,lang,rang,loz,spades,clubs,hearts,diams,'+'circ,tilde,ensp,emsp,thinsp,zwnj,zwj,lrm,rlm,ndash,mdash,lsquo,'+'rsquo,sbquo,ldquo,rdquo,bdquo,dagger,Dagger,permil,lsaquo,rsaquo,'+'euro';var latin='Agrave,Aacute,Acirc,Atilde,Auml,Aring,AElig,Ccedil,Egrave,Eacute,'+'Ecirc,Euml,Igrave,Iacute,Icirc,Iuml,ETH,Ntilde,Ograve,Oacute,Ocirc,'+'Otilde,Ouml,Oslash,Ugrave,Uacute,Ucirc,Uuml,Yacute,THORN,szlig,'+'agrave,aacute,acirc,atilde,auml,aring,aelig,ccedil,egrave,eacute,'+'ecirc,euml,igrave,iacute,icirc,iuml,eth,ntilde,ograve,oacute,ocirc,'+'otilde,ouml,oslash,ugrave,uacute,ucirc,uuml,yacute,thorn,yuml,'+'OElig,oelig,Scaron,scaron,Yuml';var greek='Alpha,Beta,Gamma,Delta,Epsilon,Zeta,Eta,Theta,Iota,Kappa,Lambda,Mu,'+'Nu,Xi,Omicron,Pi,Rho,Sigma,Tau,Upsilon,Phi,Chi,Psi,Omega,alpha,'+'beta,gamma,delta,epsilon,zeta,eta,theta,iota,kappa,lambda,mu,nu,xi,'+'omicron,pi,rho,sigmaf,sigma,tau,upsilon,phi,chi,psi,omega,thetasym,'+'upsih,piv';function buildTable(entities)
{var table={},regex=[];var specialTable={nbsp:'\u00A0',shy:'\u00AD',gt:'\u003E',lt:'\u003C'};entities=entities.replace(/\b(nbsp|shy|gt|lt|amp)(?:,|$)/g,function(match,entity)
{table[specialTable[entity]]='&'+entity+';';regex.push(specialTable[entity]);return'';});entities=entities.split(',');var div=document.createElement('div'),chars;div.innerHTML='&'+entities.join(';&')+';';chars=div.innerHTML;div=null;for(var i=0;i<chars.length;i++)
{var charAt=chars.charAt(i);table[charAt]='&'+entities[i]+';';regex.push(charAt);}
table.regex=regex.join('');return table;}
CKEDITOR.plugins.add('entities',{afterInit:function(editor)
{var config=editor.config;if(!config.entities)
return;var dataProcessor=editor.dataProcessor,htmlFilter=dataProcessor&&dataProcessor.htmlFilter;if(htmlFilter)
{var selectedEntities=entities;if(config.entities_latin)
selectedEntities+=','+latin;if(config.entities_greek)
selectedEntities+=','+greek;if(config.entities_additional)
selectedEntities+=','+config.entities_additional;var entitiesTable=buildTable(selectedEntities);var entitiesRegex='['+entitiesTable.regex+']';delete entitiesTable.regex;if(config.entities_processNumerical)
entitiesRegex='[^ -~]|'+entitiesRegex;entitiesRegex=new RegExp(entitiesRegex,'g');function getChar(character)
{return entitiesTable[character]||('&#'+character.charCodeAt(0)+';');}
htmlFilter.addRules({text:function(text)
{return text.replace(entitiesRegex,getChar);}});}}});})();CKEDITOR.config.entities=true;CKEDITOR.config.entities_latin=true;CKEDITOR.config.entities_greek=true;CKEDITOR.config.entities_processNumerical=false;CKEDITOR.config.entities_additional='#39';CKEDITOR.plugins.add('find',{init:function(editor)
{var forms=CKEDITOR.plugins.find;editor.ui.addButton('Find',{label:editor.lang.findAndReplace.find,command:'find'});var findCommand=editor.addCommand('find',new CKEDITOR.dialogCommand('find'));findCommand.canUndo=false;editor.ui.addButton('Replace',{label:editor.lang.findAndReplace.replace,command:'replace'});var replaceCommand=editor.addCommand('replace',new CKEDITOR.dialogCommand('replace'));replaceCommand.canUndo=false;CKEDITOR.dialog.add('find',this.path+'dialogs/find.js');CKEDITOR.dialog.add('replace',this.path+'dialogs/find.js');},requires:['styles']});CKEDITOR.config.find_highlight={element:'span',styles:{'background-color':'#004','color':'#fff'}};(function()
{function addCombo(editor,comboName,styleType,lang,entries,defaultLabel,styleDefinition)
{var config=editor.config;var names=entries.split(';'),values=[];var styles={};for(var i=0;i<names.length;i++)
{var parts=names[i];if(parts)
{parts=parts.split('/');var vars={},name=names[i]=parts[0];vars[styleType]=values[i]=parts[1]||name;styles[name]=new CKEDITOR.style(styleDefinition,vars);styles[name]._.definition.name=name;}
else
names.splice(i--,1);}
editor.ui.addRichCombo(comboName,{label:lang.label,title:lang.panelTitle,className:'cke_'+(styleType=='size'?'fontSize':'font'),panel:{css:editor.skin.editor.css.concat(config.contentsCss),multiSelect:false,attributes:{'aria-label':lang.panelTitle}},init:function()
{this.startGroup(lang.panelTitle);for(var i=0;i<names.length;i++)
{var name=names[i];this.add(name,styles[name].buildPreview(),name);}},onClick:function(value)
{editor.focus();editor.fire('saveSnapshot');var style=styles[value];if(this.getValue()==value)
style.remove(editor.document);else
style.apply(editor.document);editor.fire('saveSnapshot');},onRender:function()
{editor.on('selectionChange',function(ev)
{var currentValue=this.getValue();var elementPath=ev.data.path,elements=elementPath.elements;for(var i=0,element;i<elements.length;i++)
{element=elements[i];for(var value in styles)
{if(styles[value].checkElementRemovable(element,true))
{if(value!=currentValue)
this.setValue(value);return;}}}
this.setValue('',defaultLabel);},this);}});}
CKEDITOR.plugins.add('font',{requires:['richcombo','styles'],init:function(editor)
{var config=editor.config;addCombo(editor,'Font','family',editor.lang.font,config.font_names,config.font_defaultLabel,config.font_style);addCombo(editor,'FontSize','size',editor.lang.fontSize,config.fontSize_sizes,config.fontSize_defaultLabel,config.fontSize_style);}});})();CKEDITOR.config.font_names='Arial/Arial, Helvetica, sans-serif;'+'Comic Sans MS/Comic Sans MS, cursive;'+'Courier New/Courier New, Courier, monospace;'+'Georgia/Georgia, serif;'+'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;'+'Tahoma/Tahoma, Geneva, sans-serif;'+'Times New Roman/Times New Roman, Times, serif;'+'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;'+'Verdana/Verdana, Geneva, sans-serif';CKEDITOR.config.font_defaultLabel='';CKEDITOR.config.font_style={element:'span',styles:{'font-family':'#(family)'},overrides:[{element:'font',attributes:{'face':null}}]};CKEDITOR.config.fontSize_sizes='8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;72/72px';CKEDITOR.config.fontSize_defaultLabel='';CKEDITOR.config.fontSize_style={element:'span',styles:{'font-size':'#(size)'},overrides:[{element:'font',attributes:{'size':null}}]};CKEDITOR.plugins.add('format',{combo:false,requires:['richcombo','styles'],init:function(editor)
{var config=editor.config,lang=editor.lang.format;var tags=config.format_tags.split(';');var styles={};for(var i=0;i<tags.length;i++)
{var tag=tags[i];styles[tag]=new CKEDITOR.style(config['format_'+tag]);}
var disabledElements=config.format_disabled.split(';');var onSelectionChange=function(ev){var currentTag=this.getValue();var elementPath=ev.data.path;var nodeName=elementPath.block?elementPath.block.getName():'';if(jQuery.inArray(nodeName,disabledElements)>-1){this.setState(CKEDITOR.TRISTATE_DISABLED);return;}
else{this.setState(CKEDITOR.TRISTATE_OFF);}
for(var tag in styles)
{if(styles[tag].checkActive(elementPath))
{if(tag!=currentTag)
this.setValue(tag,editor.lang.format['tag_'+tag]);return;}}
this.setValue('');};var self=this;editor.on('selectionChange',function(ev){onSelectionChange.apply(self.combo,[ev]);});editor.ui.addRichCombo('Format',{label:lang.label,title:lang.panelTitle,className:'cke_format',panel:{css:editor.skin.editor.css.concat(config.contentsCss),multiSelect:false,attributes:{'aria-label':lang.panelTitle}},init:function()
{this.startGroup(lang.panelTitle);for(var tag in styles)
{var label=lang['tag_'+tag];this.add(tag,'<'+tag+'>'+label+'</'+tag+'>',label);}},onClick:function(value)
{editor.focus();editor.fire('saveSnapshot');styles[value].apply(editor.document);setTimeout(function()
{editor.fire('saveSnapshot');},0);},onRender:function()
{self.combo=this;}});}});CKEDITOR.config.format_tags='p;h1;h2;h3;h4;h5;h6;pre;address;div';CKEDITOR.config.format_p={element:'p'};CKEDITOR.config.format_div={element:'div'};CKEDITOR.config.format_pre={element:'pre'};CKEDITOR.config.format_address={element:'address'};CKEDITOR.config.format_h1={element:'h1'};CKEDITOR.config.format_h2={element:'h2'};CKEDITOR.config.format_h3={element:'h3'};CKEDITOR.config.format_h4={element:'h4'};CKEDITOR.config.format_h5={element:'h5'};CKEDITOR.config.format_h6={element:'h6'};CKEDITOR.config.format_disabled='li;dt;dd';(function()
{var tailNbspRegex=/^[\t\r\n ]*(?:&nbsp;|\xa0)$/;var protectedSourceMarker='{cke_protected}';function isRawBr(node){return node.type==CKEDITOR.NODE_ELEMENT&&node.name=='br'&&(typeof node.attributes['_rte_washtml']=='undefined');}
function lastNoneSpaceChild(block)
{var lastIndex=block.children.length,last=block.children[lastIndex-1];while(last&&last.type==CKEDITOR.NODE_TEXT&&!CKEDITOR.tools.trim(last.value))
last=block.children[--lastIndex];return last;}
function trimFillers(block,fromSource)
{var children=block.children,lastChild=lastNoneSpaceChild(block);if(lastChild)
{if((fromSource||!CKEDITOR.env.ie)&&isRawBr(lastChild))
children.pop();if(lastChild.type==CKEDITOR.NODE_TEXT&&tailNbspRegex.test(lastChild.value))
children.pop();}}
function blockNeedsExtension(block)
{var lastChild=lastNoneSpaceChild(block);return!lastChild||isRawBr(lastChild)||block.name=='form'&&lastChild.name=='input';}
function extendBlockForDisplay(block)
{trimFillers(block,true);if(blockNeedsExtension(block))
{if(CKEDITOR.env.ie)
block.add(new CKEDITOR.htmlParser.text('\xa0'));else
block.add(new CKEDITOR.htmlParser.element('br',{}));}}
function extendBlockForOutput(block)
{trimFillers(block);if(blockNeedsExtension(block))
block.add(new CKEDITOR.htmlParser.text('\xa0'));}
var dtd=CKEDITOR.dtd;var blockLikeTags=CKEDITOR.tools.extend({},dtd.$block,dtd.$listItem,dtd.$tableContent);for(var i in blockLikeTags)
{if(!('br'in dtd[i]))
delete blockLikeTags[i];}
delete blockLikeTags.pre;var defaultDataFilterRules={attributeNames:[[(/^on/),'_cke_pa_on']]};var defaultDataBlockFilterRules={elements:{}};for(i in blockLikeTags)
defaultDataBlockFilterRules.elements[i]=extendBlockForDisplay;var defaultHtmlFilterRules={elementNames:[[(/^cke:/),''],[(/^\?xml:namespace$/),'']],attributeNames:[[(/^_cke_(saved|pa)_/),''],[(/^_cke.*/),''],['hidefocus','']],elements:{$:function(element)
{var attribs=element.attributes;if(attribs)
{if(attribs.cke_temp)
return false;var attributeNames=['name','href','src'],savedAttributeName;for(var i=0;i<attributeNames.length;i++)
{savedAttributeName='_cke_saved_'+attributeNames[i];savedAttributeName in attribs&&(delete attribs[attributeNames[i]]);}}
return element;},embed:function(element)
{var parent=element.parent;if(parent&&parent.name=='object')
{var parentWidth=parent.attributes.width,parentHeight=parent.attributes.height;parentWidth&&(element.attributes.width=parentWidth);parentHeight&&(element.attributes.height=parentHeight);}},param:function(param)
{param.children=[];param.isEmpty=true;return param;},a:function(element)
{if(!(element.children.length||element.attributes.name||element.attributes._cke_saved_name))
{return false;}},body:function(element)
{delete element.attributes.spellcheck;delete element.attributes.contenteditable;},style:function(element)
{var child=element.children[0];child&&child.value&&(child.value=CKEDITOR.tools.trim(child.value));if(!element.attributes.type)
element.attributes.type='text/css';},title:function(element)
{element.children[0].value=element.attributes['_cke_title'];}},attributes:{'class':function(value,element)
{return CKEDITOR.tools.ltrim(value.replace(/(?:^|\s+)cke_[^\s]*/g,''))||false;}},comment:function(contents)
{if(contents.substr(0,protectedSourceMarker.length)==protectedSourceMarker)
{if(contents.substr(protectedSourceMarker.length,3)=='{C}')
contents=contents.substr(protectedSourceMarker.length+3);else
contents=contents.substr(protectedSourceMarker.length);return new CKEDITOR.htmlParser.cdata(decodeURIComponent(contents));}
return contents;}};var defaultHtmlBlockFilterRules={elements:{}};for(i in blockLikeTags)
defaultHtmlBlockFilterRules.elements[i]=extendBlockForOutput;if(CKEDITOR.env.ie)
{defaultHtmlFilterRules.attributes.style=function(value,element)
{return value.toLowerCase();};}
var protectAttributeRegex=/<(?:a|area|img|input)[\s\S]*?\s((?:href|src|name)\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|(?:[^ "'>]+)))/gi;var protectElementsRegex=/(?:<style(?=[ >])[^>]*>[\s\S]*<\/style>)|(?:<(:?link|meta|base)[^>]*>)/gi,encodedElementsRegex=/<cke:encoded>([^<]*)<\/cke:encoded>/gi;var protectElementNamesRegex=/(<\/?)((?:object|embed|param|html|body|head|title)[^>]*>)/gi,unprotectElementNamesRegex=/(<\/?)cke:((?:html|body|head|title)[^>]*>)/gi;var protectSelfClosingRegex=/<cke:(param|embed)([^>]*?)\/?>(?!\s*<\/cke:\1)/gi;function protectAttributes(html)
{return html.replace(protectAttributeRegex,'$& _cke_saved_$1');}
function protectElements(html)
{return html.replace(protectElementsRegex,function(match)
{return'<cke:encoded>'+encodeURIComponent(match)+'</cke:encoded>';});}
function unprotectElements(html)
{return html.replace(encodedElementsRegex,function(match,encoded)
{return decodeURIComponent(encoded);});}
function protectElementsNames(html)
{return html.replace(protectElementNamesRegex,'$1cke:$2');}
function unprotectElementNames(html)
{return html.replace(unprotectElementNamesRegex,'$1$2');}
function protectSelfClosingElements(html)
{return html.replace(protectSelfClosingRegex,'<cke:$1$2></cke:$1>');}
function protectRealComments(html)
{return html.replace(/<!--(?!{cke_protected})[\s\S]+?-->/g,function(match)
{return'<!--'+protectedSourceMarker+'{C}'+
encodeURIComponent(match).replace(/--/g,'%2D%2D')+'-->';});}
function unprotectRealComments(html)
{return html.replace(/<!--\{cke_protected\}\{C\}([\s\S]+?)-->/g,function(match,data)
{return decodeURIComponent(data);});}
function protectSource(data,protectRegexes)
{var protectedHtml=[],tempRegex=/<\!--\{cke_temp(comment)?\}(\d*?)-->/g;var regexes=[(/<script[\s\S]*?<\/script>/gi),/<noscript[\s\S]*?<\/noscript>/gi].concat(protectRegexes);data=data.replace((/<!--[\s\S]*?-->/g),function(match)
{return'<!--{cke_tempcomment}'+(protectedHtml.push(match)-1)+'-->';});for(var i=0;i<regexes.length;i++)
{data=data.replace(regexes[i],function(match)
{match=match.replace(tempRegex,function($,isComment,id)
{return protectedHtml[id];});return'<!--{cke_temp}'+(protectedHtml.push(match)-1)+'-->';});}
data=data.replace(tempRegex,function($,isComment,id)
{return'<!--'+protectedSourceMarker+
(isComment?'{C}':'')+
encodeURIComponent(protectedHtml[id]).replace(/--/g,'%2D%2D')+'-->';});return data;}
CKEDITOR.plugins.add('htmldataprocessor',{requires:['htmlwriter'],init:function(editor)
{var dataProcessor=editor.dataProcessor=new CKEDITOR.htmlDataProcessor(editor);dataProcessor.writer.forceSimpleAmpersand=editor.config.forceSimpleAmpersand;dataProcessor.dataFilter.addRules(defaultDataFilterRules);dataProcessor.dataFilter.addRules(defaultDataBlockFilterRules);dataProcessor.htmlFilter.addRules(defaultHtmlFilterRules);dataProcessor.htmlFilter.addRules(defaultHtmlBlockFilterRules);}});CKEDITOR.htmlDataProcessor=function(editor)
{this.editor=editor;this.writer=new CKEDITOR.htmlWriter();this.dataFilter=new CKEDITOR.htmlParser.filter();this.htmlFilter=new CKEDITOR.htmlParser.filter();};CKEDITOR.htmlDataProcessor.prototype={toHtml:function(data,fixForBody)
{data=protectSource(data,this.editor.config.protectedSource);data=protectAttributes(data);data=protectElements(data);data=protectElementsNames(data);data=protectSelfClosingElements(data);var div=new CKEDITOR.dom.element('div');div.setHtml('a'+data);data=div.getHtml().substr(1);data=unprotectElementNames(data);data=unprotectElements(data);data=unprotectRealComments(data);var fragment=CKEDITOR.htmlParser.fragment.fromHtml(data,fixForBody),writer=new CKEDITOR.htmlParser.basicWriter();fragment.writeHtml(writer,this.dataFilter);data=writer.getHtml(true);data=protectRealComments(data);return data;},toDataFormat:function(html,fixForBody)
{var writer=this.writer,fragment=CKEDITOR.htmlParser.fragment.fromHtml(html,fixForBody);writer.reset();fragment.writeHtml(writer,this.htmlFilter);return writer.getHtml(true);}};})();CKEDITOR.config.forceSimpleAmpersand=false;(function()
{var listNodeNames={ol:1,ul:1};function setState(editor,state)
{editor.getCommand(this.name).setState(state);}
function onSelectionChange(evt)
{var elements=evt.data.path.elements,listNode,listItem,editor=evt.editor;var path=evt.data.path;var nodeName=path.block?path.block.getName():'';if((/h\d/).test(nodeName)){return setState.call(this,editor,CKEDITOR.TRISTATE_DISABLED);}
if(nodeName=='p'){var align=path.block.getStyle('text-align');if((align=='center')||(align=='right')){return setState.call(this,editor,CKEDITOR.TRISTATE_DISABLED);}}
for(var i=0;i<elements.length;i++)
{if(elements[i].getName()=='li')
{listItem=elements[i];continue;}
if(listNodeNames[elements[i].getName()])
{listNode=elements[i];break;}}
if(listNode)
{if(this.name=='outdent')
return setState.call(this,editor,CKEDITOR.TRISTATE_OFF);else
{while(listItem&&(listItem=listItem.getPrevious(CKEDITOR.dom.walker.whitespaces(true))))
{if(listItem.getName&&listItem.getName()=='li')
return setState.call(this,editor,CKEDITOR.TRISTATE_OFF);}
return setState.call(this,editor,CKEDITOR.TRISTATE_DISABLED);}}
if(!this.useIndentClasses&&this.name=='indent')
return setState.call(this,editor,CKEDITOR.TRISTATE_OFF);var path=evt.data.path,firstBlock=path.block||path.blockLimit;if(!firstBlock)
return setState.call(this,editor,CKEDITOR.TRISTATE_DISABLED);if(this.useIndentClasses)
{var indentClass=firstBlock.$.className.match(this.classNameRegex),indentStep=0;if(indentClass)
{indentClass=indentClass[1];indentStep=this.indentClassMap[indentClass];}
if((this.name=='outdent'&&!indentStep)||(this.name=='indent'&&indentStep==editor.config.indentClasses.length))
return setState.call(this,editor,CKEDITOR.TRISTATE_DISABLED);return setState.call(this,editor,CKEDITOR.TRISTATE_OFF);}
else
{var indent=parseInt(firstBlock.getStyle(this.indentCssProperty),10);if(isNaN(indent))
indent=0;if(indent<=0)
return setState.call(this,editor,CKEDITOR.TRISTATE_DISABLED);return setState.call(this,editor,CKEDITOR.TRISTATE_OFF);}}
function indentList(editor,range,listNode)
{var startContainer=range.startContainer,endContainer=range.endContainer;while(startContainer&&!startContainer.getParent().equals(listNode))
startContainer=startContainer.getParent();while(endContainer&&!endContainer.getParent().equals(listNode))
endContainer=endContainer.getParent();if(!startContainer||!endContainer)
return;var block=startContainer,itemsToMove=[],stopFlag=false;while(!stopFlag)
{if(block.equals(endContainer))
stopFlag=true;itemsToMove.push(block);block=block.getNext();}
if(itemsToMove.length<1)
return;var listParents=listNode.getParents(true);for(var i=0;i<listParents.length;i++)
{if(listParents[i].getName&&listNodeNames[listParents[i].getName()])
{listNode=listParents[i];break;}}
var indentOffset=this.name=='indent'?1:-1,startItem=itemsToMove[0],lastItem=itemsToMove[itemsToMove.length-1],database={};var listArray=CKEDITOR.plugins.list.listToArray(listNode,database);listArray[lastItem.getCustomData('listarray_index')].toIndent=true;var baseIndent=listArray[lastItem.getCustomData('listarray_index')].indent;for(i=startItem.getCustomData('listarray_index');i<=lastItem.getCustomData('listarray_index');i++)
{listArray[i].indent+=indentOffset;var listRoot=listArray[i].parent;listArray[i].parent=new CKEDITOR.dom.element(listRoot.getName(),listRoot.getDocument());}
for(i=lastItem.getCustomData('listarray_index')+1;i<listArray.length&&listArray[i].indent>baseIndent;i++)
listArray[i].indent+=indentOffset;var newList=CKEDITOR.plugins.list.arrayToList(listArray,database,null,editor.config.enterMode,0);if(this.name=='outdent')
{var parentLiElement;if((parentLiElement=listNode.getParent())&&parentLiElement.is('li'))
{var children=newList.listNode.getChildren(),pendingLis=[],count=children.count(),child;for(i=count-1;i>=0;i--)
{if((child=children.getItem(i))&&child.is&&child.is('li'))
pendingLis.push(child);}}}
if(newList)
newList.listNode.replace(listNode);if(pendingLis&&pendingLis.length)
{for(i=0;i<pendingLis.length;i++)
{var li=pendingLis[i],followingList=li;while((followingList=followingList.getNext())&&followingList.is&&followingList.getName()in listNodeNames)
{li.append(followingList);}
li.insertAfter(parentLiElement);}}
CKEDITOR.dom.element.clearAllMarkers(database);}
function indentBlock(editor,range)
{var iterator=range.createIterator(),enterMode=editor.config.enterMode;iterator.enforceRealBlocks=true;iterator.enlargeBr=enterMode!=CKEDITOR.ENTER_BR;var block;while((block=iterator.getNextParagraph()))
{if(this.useIndentClasses)
{var indentClass=block.$.className.match(this.classNameRegex),indentStep=0;if(indentClass)
{indentClass=indentClass[1];indentStep=this.indentClassMap[indentClass];}
if(this.name=='outdent')
indentStep--;else
indentStep++;indentStep=Math.min(indentStep,editor.config.indentClasses.length);indentStep=Math.max(indentStep,0);var className=CKEDITOR.tools.ltrim(block.$.className.replace(this.classNameRegex,''));if(indentStep<1)
block.$.className=className;else
block.$.className=CKEDITOR.tools.ltrim(className+' '+editor.config.indentClasses[indentStep-1]);}
else
{var currentOffset=parseInt(block.getStyle(this.indentCssProperty),10);if(isNaN(currentOffset))
currentOffset=0;currentOffset+=(this.name=='indent'?1:-1)*editor.config.indentOffset;currentOffset=Math.max(currentOffset,0);currentOffset=Math.ceil(currentOffset/editor.config.indentOffset)*editor.config.indentOffset;block.setStyle(this.indentCssProperty,currentOffset?currentOffset+editor.config.indentUnit:'');if(block.getAttribute('style')==='')
block.removeAttribute('style');}}}
function indentCommand(editor,name)
{this.name=name;this.useIndentClasses=editor.config.indentClasses&&editor.config.indentClasses.length>0;if(this.useIndentClasses)
{this.classNameRegex=new RegExp('(?:^|\\s+)('+editor.config.indentClasses.join('|')+')(?=$|\\s)');this.indentClassMap={};for(var i=0;i<editor.config.indentClasses.length;i++)
this.indentClassMap[editor.config.indentClasses[i]]=i+1;}
else
this.indentCssProperty=editor.config.contentsLangDirection=='ltr'?'margin-left':'margin-right';this.startDisabled=name=='outdent';}
indentCommand.prototype={exec:function(editor)
{var selection=editor.getSelection(),range=selection&&selection.getRanges()[0];if(!selection||!range)
return;var bookmarks=selection.createBookmarks(true),nearestListBlock=range.getCommonAncestor();while(nearestListBlock&&!(nearestListBlock.type==CKEDITOR.NODE_ELEMENT&&listNodeNames[nearestListBlock.getName()]))
nearestListBlock=nearestListBlock.getParent();if(nearestListBlock)
indentList.call(this,editor,range,nearestListBlock);else
indentBlock.call(this,editor,range);editor.focus();editor.forceNextSelectionCheck();selection.selectBookmarks(bookmarks);}};CKEDITOR.plugins.add('indent',{init:function(editor)
{var indent=new indentCommand(editor,'indent'),outdent=new indentCommand(editor,'outdent');editor.addCommand('indent',indent);editor.addCommand('outdent',outdent);editor.ui.addButton('Indent',{label:editor.lang.indent,command:'indent'});editor.ui.addButton('Outdent',{label:editor.lang.outdent,command:'outdent'});editor.on('selectionChange',CKEDITOR.tools.bind(onSelectionChange,indent));editor.on('selectionChange',CKEDITOR.tools.bind(onSelectionChange,outdent));},requires:['domiterator','list']});})();CKEDITOR.tools.extend(CKEDITOR.config,{indentOffset:40,indentUnit:'px',indentClasses:null});CKEDITOR.plugins.add('keystrokes',{beforeInit:function(editor)
{editor.keystrokeHandler=new CKEDITOR.keystrokeHandler(editor);editor.specialKeys={};},init:function(editor)
{var keystrokesConfig=editor.config.keystrokes,blockedConfig=editor.config.blockedKeystrokes;var keystrokes=editor.keystrokeHandler.keystrokes,blockedKeystrokes=editor.keystrokeHandler.blockedKeystrokes;for(var i=0;i<keystrokesConfig.length;i++)
{keystrokes[keystrokesConfig[i][0]]=keystrokesConfig[i][1];}
for(i=0;i<blockedConfig.length;i++)
{blockedKeystrokes[blockedConfig[i]]=1;}}});CKEDITOR.keystrokeHandler=function(editor)
{if(editor.keystrokeHandler)
return editor.keystrokeHandler;this.keystrokes={};this.blockedKeystrokes={};this._={editor:editor};return this;};(function()
{var cancel;var onKeyDown=function(event)
{event=event.data;var keyCombination=event.getKeystroke();var command=this.keystrokes[keyCombination];var editor=this._.editor;cancel=(editor.fire('key',{keyCode:keyCombination})===true);if(!cancel)
{if(command)
{var data={from:'keystrokeHandler'};cancel=(editor.execCommand(command,data)!==false);}
if(!cancel)
{var handler=editor.specialKeys[keyCombination];cancel=(handler&&handler(editor)===true);if(!cancel)
cancel=!!this.blockedKeystrokes[keyCombination];}}
if(cancel)
event.preventDefault(true);return!cancel;};var onKeyPress=function(event)
{if(cancel)
{cancel=false;event.data.preventDefault(true);}};CKEDITOR.keystrokeHandler.prototype={attach:function(domObject)
{domObject.on('keydown',onKeyDown,this);if(CKEDITOR.env.opera||(CKEDITOR.env.gecko&&CKEDITOR.env.mac))
domObject.on('keypress',onKeyPress,this);}};})();CKEDITOR.config.blockedKeystrokes=[CKEDITOR.CTRL+66,CKEDITOR.CTRL+73,CKEDITOR.CTRL+85];CKEDITOR.config.keystrokes=[[CKEDITOR.ALT+121,'toolbarFocus'],[CKEDITOR.ALT+122,'elementsPathFocus'],[CKEDITOR.SHIFT+121,'contextMenu'],[CKEDITOR.CTRL+CKEDITOR.SHIFT+121,'contextMenu'],[CKEDITOR.CTRL+90,'undo'],[CKEDITOR.CTRL+89,'redo'],[CKEDITOR.CTRL+CKEDITOR.SHIFT+90,'redo'],[CKEDITOR.CTRL+76,'link'],[CKEDITOR.CTRL+66,'bold'],[CKEDITOR.CTRL+73,'italic'],[CKEDITOR.CTRL+85,'underline'],[CKEDITOR.ALT+109,'toolbarCollapse'],[CKEDITOR.ALT+48,'a11yHelp']];(function()
{var listNodeNames={ol:1,ul:1},emptyTextRegex=/^[\n\r\t ]*$/;CKEDITOR.plugins.list={listToArray:function(listNode,database,baseArray,baseIndentLevel,grandparentNode)
{if(!listNodeNames[listNode.getName()])
return[];if(!baseIndentLevel)
baseIndentLevel=0;if(!baseArray)
baseArray=[];for(var i=0,count=listNode.getChildCount();i<count;i++)
{var listItem=listNode.getChild(i);if(listItem.$.nodeName.toLowerCase()!='li')
continue;var itemObj={'parent':listNode,indent:baseIndentLevel,element:listItem,contents:[]};if(!grandparentNode)
{itemObj.grandparent=listNode.getParent();if(itemObj.grandparent&&itemObj.grandparent.$.nodeName.toLowerCase()=='li')
itemObj.grandparent=itemObj.grandparent.getParent();}
else
itemObj.grandparent=grandparentNode;if(database)
CKEDITOR.dom.element.setMarker(database,listItem,'listarray_index',baseArray.length);baseArray.push(itemObj);for(var j=0,itemChildCount=listItem.getChildCount(),child;j<itemChildCount;j++)
{child=listItem.getChild(j);if(child.type==CKEDITOR.NODE_ELEMENT&&listNodeNames[child.getName()])
CKEDITOR.plugins.list.listToArray(child,database,baseArray,baseIndentLevel+1,itemObj.grandparent);else
itemObj.contents.push(child);}}
return baseArray;},arrayToList:function(listArray,database,baseIndex,paragraphMode)
{if(!baseIndex)
baseIndex=0;if(!listArray||listArray.length<baseIndex+1)
return null;var doc=listArray[baseIndex].parent.getDocument(),retval=new CKEDITOR.dom.documentFragment(doc),rootNode=null,currentIndex=baseIndex,indentLevel=Math.max(listArray[baseIndex].indent,0),currentListItem=null,paragraphName=(paragraphMode==CKEDITOR.ENTER_P?'p':'div');while(true)
{var item=listArray[currentIndex];if(item.indent==indentLevel)
{if(!rootNode||listArray[currentIndex].parent.getName()!=rootNode.getName())
{rootNode=listArray[currentIndex].parent.clone(false,true);if(item.toIndent){rootNode.removeAttribute('_rte_empty_lines_before');rootNode.setAttribute('_rte_new_node',true);}
retval.append(rootNode);}
currentListItem=rootNode.append(item.element.clone(false,true));for(var i=0;i<item.contents.length;i++)
currentListItem.append(item.contents[i].clone(true,true));currentIndex++;}
else if(item.indent==Math.max(indentLevel,0)+1)
{var listData=CKEDITOR.plugins.list.arrayToList(listArray,null,currentIndex,paragraphMode);currentListItem.append(listData.listNode);currentIndex=listData.nextIndex;}
else if(item.indent==-1&&!baseIndex&&item.grandparent)
{currentListItem;if(listNodeNames[item.grandparent.getName()])
currentListItem=item.element.clone(false,true);else
{if(paragraphMode!=CKEDITOR.ENTER_BR&&item.grandparent.getName()!='td')
currentListItem=doc.createElement(paragraphName);else
currentListItem=new CKEDITOR.dom.documentFragment(doc);}
for(i=0;i<item.contents.length;i++)
currentListItem.append(item.contents[i].clone(true,true));if(currentListItem.type==CKEDITOR.NODE_DOCUMENT_FRAGMENT&&currentIndex!=listArray.length-1)
{if(currentListItem.getLast()&&currentListItem.getLast().type==CKEDITOR.NODE_ELEMENT&&currentListItem.getLast().getAttribute('type')=='_moz')
currentListItem.getLast().remove();currentListItem.appendBogus();}
if(currentListItem.type==CKEDITOR.NODE_ELEMENT&&currentListItem.getName()==paragraphName&&currentListItem.$.firstChild)
{currentListItem.trim();var firstChild=currentListItem.getFirst();if(firstChild.type==CKEDITOR.NODE_ELEMENT&&firstChild.isBlockBoundary())
{var tmp=new CKEDITOR.dom.documentFragment(doc);currentListItem.moveChildren(tmp);currentListItem=tmp;}}
var currentListItemName=currentListItem.$.nodeName.toLowerCase();if(!CKEDITOR.env.ie&&(currentListItemName=='div'||currentListItemName=='p'))
currentListItem.appendBogus();retval.append(currentListItem);rootNode=null;currentIndex++;}
else
return null;if(listArray.length<=currentIndex||Math.max(listArray[currentIndex].indent,0)<indentLevel)
break;}
if(database)
{var currentNode=retval.getFirst();while(currentNode)
{if(currentNode.type==CKEDITOR.NODE_ELEMENT)
CKEDITOR.dom.element.clearMarkers(database,currentNode);currentNode=currentNode.getNextSourceNode();}}
return{listNode:retval,nextIndex:currentIndex};}};function setState(editor,state)
{editor.getCommand(this.name).setState(state);}
function onSelectionChange(evt)
{var path=evt.data.path,blockLimit=path.blockLimit,elements=path.elements,element;var nodeName=path.block?path.block.getName():'';if((/h\d/).test(nodeName)){return setState.call(this,evt.editor,CKEDITOR.TRISTATE_DISABLED);}
for(var i=0;i<elements.length&&(element=elements[i])&&!element.equals(blockLimit);i++)
{if(listNodeNames[elements[i].getName()])
{return setState.call(this,evt.editor,this.type==elements[i].getName()?CKEDITOR.TRISTATE_ON:CKEDITOR.TRISTATE_OFF);}}
return setState.call(this,evt.editor,CKEDITOR.TRISTATE_OFF);}
function changeListType(editor,groupObj,database,listsCreated)
{var listArray=CKEDITOR.plugins.list.listToArray(groupObj.root,database),selectedListItems=[];for(var i=0;i<groupObj.contents.length;i++)
{var itemNode=groupObj.contents[i];itemNode=itemNode.getAscendant('li',true);if(!itemNode||itemNode.getCustomData('list_item_processed'))
continue;selectedListItems.push(itemNode);CKEDITOR.dom.element.setMarker(database,itemNode,'list_item_processed',true);}
var fakeParent=groupObj.root.getDocument().createElement(this.type);for(i=0;i<selectedListItems.length;i++)
{var listIndex=selectedListItems[i].getCustomData('listarray_index');listArray[listIndex].parent=fakeParent;}
var newList=CKEDITOR.plugins.list.arrayToList(listArray,database,null,editor.config.enterMode);var child,length=newList.listNode.getChildCount();for(i=0;i<length&&(child=newList.listNode.getChild(i));i++)
{if(child.getName()==this.type)
listsCreated.push(child);}
newList.listNode.replace(groupObj.root);}
function createList(editor,groupObj,listsCreated)
{var contents=groupObj.contents,doc=groupObj.root.getDocument(),listContents=[];if(contents.length==1&&contents[0].equals(groupObj.root))
{var divBlock=doc.createElement('div');contents[0].moveChildren&&contents[0].moveChildren(divBlock);contents[0].append(divBlock);contents[0]=divBlock;}
var commonParent=groupObj.contents[0].getParent();for(var i=0;i<contents.length;i++)
commonParent=commonParent.getCommonAncestor(contents[i].getParent());for(i=0;i<contents.length;i++)
{var contentNode=contents[i],parentNode;while((parentNode=contentNode.getParent()))
{if(parentNode.equals(commonParent))
{listContents.push(contentNode);break;}
contentNode=parentNode;}}
if(listContents.length<1)
return;var insertAnchor=listContents[listContents.length-1].getNext(),listNode=doc.createElement(this.type);editor.fire('listCreated',{listNode:listNode});listsCreated.push(listNode);while(listContents.length)
{var contentBlock=listContents.shift(),listItem=doc.createElement('li');contentBlock.moveChildren(listItem);contentBlock.remove();listItem.appendTo(listNode);if(!CKEDITOR.env.ie)
listItem.appendBogus();}
if(insertAnchor)
listNode.insertBefore(insertAnchor);else
listNode.appendTo(commonParent);}
function removeList(editor,groupObj,database)
{var listArray=CKEDITOR.plugins.list.listToArray(groupObj.root,database),selectedListItems=[];for(var i=0;i<groupObj.contents.length;i++)
{var itemNode=groupObj.contents[i];itemNode=itemNode.getAscendant('li',true);if(!itemNode||itemNode.getCustomData('list_item_processed'))
continue;selectedListItems.push(itemNode);CKEDITOR.dom.element.setMarker(database,itemNode,'list_item_processed',true);}
var lastListIndex=null;for(i=0;i<selectedListItems.length;i++)
{var listIndex=selectedListItems[i].getCustomData('listarray_index');listArray[listIndex].indent=-1;lastListIndex=listIndex;}
for(i=lastListIndex+1;i<listArray.length;i++)
{if(listArray[i].indent>listArray[i-1].indent+1)
{var indentOffset=listArray[i-1].indent+1-listArray[i].indent;var oldIndent=listArray[i].indent;while(listArray[i]&&listArray[i].indent>=oldIndent)
{listArray[i].indent+=indentOffset;i++;}
i--;}}
var newList=CKEDITOR.plugins.list.arrayToList(listArray,database,null,editor.config.enterMode);var docFragment=newList.listNode,boundaryNode,siblingNode;function compensateBrs(isStart)
{if((boundaryNode=docFragment[isStart?'getFirst':'getLast']())&&!(boundaryNode.is&&boundaryNode.isBlockBoundary())&&(siblingNode=groupObj.root[isStart?'getPrevious':'getNext']
(CKEDITOR.dom.walker.whitespaces(true)))&&!(siblingNode.is&&siblingNode.isBlockBoundary({br:1})))
editor.document.createElement('br')[isStart?'insertBefore':'insertAfter'](boundaryNode);}
compensateBrs(true);compensateBrs();docFragment.replace(groupObj.root);}
function listCommand(name,type)
{this.name=name;this.type=type;}
listCommand.prototype={exec:function(editor)
{editor.focus();var doc=editor.document,selection=editor.getSelection(),ranges=selection&&selection.getRanges();if(!ranges||ranges.length<1)
return;if(this.state==CKEDITOR.TRISTATE_OFF)
{var body=doc.getBody();body.trim();if(!body.getFirst())
{var paragraph=doc.createElement(editor.config.enterMode==CKEDITOR.ENTER_P?'p':(editor.config.enterMode==CKEDITOR.ENTER_DIV?'div':'br'));paragraph.appendTo(body);ranges=[new CKEDITOR.dom.range(doc)];if(paragraph.is('br'))
{ranges[0].setStartBefore(paragraph);ranges[0].setEndAfter(paragraph);}
else
ranges[0].selectNodeContents(paragraph);selection.selectRanges(ranges);}
else
{var range=ranges.length==1&&ranges[0],enclosedNode=range&&range.getEnclosedNode();if(enclosedNode&&enclosedNode.is&&this.type==enclosedNode.getName())
{setState.call(this,editor,CKEDITOR.TRISTATE_ON);}}}
var bookmarks=selection.createBookmarks(true);var listGroups=[],database={};while(ranges.length>0)
{range=ranges.shift();var boundaryNodes=range.getBoundaryNodes(),startNode=boundaryNodes.startNode,endNode=boundaryNodes.endNode;if(startNode.type==CKEDITOR.NODE_ELEMENT&&startNode.getName()=='td')
range.setStartAt(boundaryNodes.startNode,CKEDITOR.POSITION_AFTER_START);if(endNode.type==CKEDITOR.NODE_ELEMENT&&endNode.getName()=='td')
range.setEndAt(boundaryNodes.endNode,CKEDITOR.POSITION_BEFORE_END);var iterator=range.createIterator(),block;iterator.forceBrBreak=(this.state==CKEDITOR.TRISTATE_OFF);while((block=iterator.getNextParagraph()))
{var path=new CKEDITOR.dom.elementPath(block),pathElements=path.elements,pathElementsCount=pathElements.length,listNode=null,processedFlag=false,blockLimit=path.blockLimit,element;for(var i=pathElementsCount-1;i>=0&&(element=pathElements[i]);i--)
{if(listNodeNames[element.getName()]&&blockLimit.contains(element))
{blockLimit.removeCustomData('list_group_object');var groupObj=element.getCustomData('list_group_object');if(groupObj)
groupObj.contents.push(block);else
{groupObj={root:element,contents:[block]};listGroups.push(groupObj);CKEDITOR.dom.element.setMarker(database,element,'list_group_object',groupObj);}
processedFlag=true;break;}}
if(processedFlag)
continue;var root=blockLimit;if(root.getCustomData('list_group_object'))
root.getCustomData('list_group_object').contents.push(block);else
{groupObj={root:root,contents:[block]};CKEDITOR.dom.element.setMarker(database,root,'list_group_object',groupObj);listGroups.push(groupObj);}}}
var listsCreated=[];while(listGroups.length>0)
{groupObj=listGroups.shift();if(this.state==CKEDITOR.TRISTATE_OFF)
{if(listNodeNames[groupObj.root.getName()])
changeListType.call(this,editor,groupObj,database,listsCreated);else
createList.call(this,editor,groupObj,listsCreated);}
else if(this.state==CKEDITOR.TRISTATE_ON&&listNodeNames[groupObj.root.getName()])
removeList.call(this,editor,groupObj,database);}
for(i=0;i<listsCreated.length;i++)
{listNode=listsCreated[i];var mergeSibling,listCommand=this;(mergeSibling=function(rtl){var sibling=listNode[rtl?'getPrevious':'getNext'](CKEDITOR.dom.walker.whitespaces(true));if(sibling&&sibling.getName&&sibling.getName()==listCommand.type)
{sibling.remove();sibling.moveChildren(listNode,rtl?true:false);}})();mergeSibling(true);}
CKEDITOR.dom.element.clearAllMarkers(database);selection.selectBookmarks(bookmarks);editor.focus();}};var dtd=CKEDITOR.dtd;var tailNbspRegex=/[\t\r\n ]*(?:&nbsp;|\xa0)$/;function indexOfFirstChildElement(element,tagNameList)
{var child,children=element.children,length=children.length;for(var i=0;i<length;i++)
{child=children[i];if(child.name&&(child.name in tagNameList))
return i;}
return length;}
function getExtendNestedListFilter(isHtmlFilter)
{return function(listItem)
{var children=listItem.children,firstNestedListIndex=indexOfFirstChildElement(listItem,dtd.$list),firstNestedList=children[firstNestedListIndex],nodeBefore=firstNestedList&&firstNestedList.previous,tailNbspmatch;if(nodeBefore&&(nodeBefore.name&&nodeBefore.name=='br'||nodeBefore.value&&(tailNbspmatch=nodeBefore.value.match(tailNbspRegex))))
{var fillerNode=nodeBefore;if(!(tailNbspmatch&&tailNbspmatch.index)&&fillerNode==children[0])
children[0]=(isHtmlFilter||CKEDITOR.env.ie)?new CKEDITOR.htmlParser.text('\xa0'):new CKEDITOR.htmlParser.element('br',{});else if(fillerNode.name=='br')
children.splice(firstNestedListIndex-1,1);else
fillerNode.value=fillerNode.value.replace(tailNbspRegex,'');}};}
var defaultListDataFilterRules={elements:{}};for(var i in dtd.$listItem)
defaultListDataFilterRules.elements[i]=getExtendNestedListFilter();var defaultListHtmlFilterRules={elements:{}};for(i in dtd.$listItem)
defaultListHtmlFilterRules.elements[i]=getExtendNestedListFilter(true);CKEDITOR.plugins.add('list',{init:function(editor)
{var numberedListCommand=new listCommand('numberedlist','ol'),bulletedListCommand=new listCommand('bulletedlist','ul');editor.addCommand('numberedlist',numberedListCommand);editor.addCommand('bulletedlist',bulletedListCommand);editor.ui.addButton('NumberedList',{label:editor.lang.numberedlist,command:'numberedlist'});editor.ui.addButton('BulletedList',{label:editor.lang.bulletedlist,command:'bulletedlist'});editor.on('selectionChange',CKEDITOR.tools.bind(onSelectionChange,numberedListCommand));editor.on('selectionChange',CKEDITOR.tools.bind(onSelectionChange,bulletedListCommand));},afterInit:function(editor)
{var dataProcessor=editor.dataProcessor;if(dataProcessor)
{dataProcessor.dataFilter.addRules(defaultListDataFilterRules);dataProcessor.htmlFilter.addRules(defaultListHtmlFilterRules);}},requires:['domiterator']});})();(function()
{CKEDITOR.plugins.add('pastefromword',{init:function(editor)
{var forceFromWord=0;var resetFromWord=function()
{setTimeout(function(){forceFromWord=0;},0);};editor.addCommand('pastefromword',{canUndo:false,exec:function()
{forceFromWord=1;if(editor.execCommand('paste')===false)
{editor.on('dialogHide',function(evt)
{evt.removeListener();resetFromWord();});}}});editor.ui.addButton('PasteFromWord',{label:editor.lang.pastefromword.toolbar,command:'pastefromword'});editor.on('paste',function(evt)
{var data=evt.data,mswordHtml;if((mswordHtml=data['html'])&&(forceFromWord||(/(class=\"?Mso|style=\"[^\"]*\bmso\-|w:WordDocument)/).test(mswordHtml)))
{var isLazyLoad=this.loadFilterRules(function()
{if(isLazyLoad)
editor.fire('paste',data);else if(!editor.config.pasteFromWordPromptCleanup||(forceFromWord||confirm(editor.lang.pastefromword.confirmCleanup)))
{data['html']=CKEDITOR.cleanWord(mswordHtml,editor);}});isLazyLoad&&evt.cancel();}},this);},loadFilterRules:function(callback)
{var isLoaded=CKEDITOR.cleanWord;if(isLoaded)
callback();else
{var filterFilePath=CKEDITOR.getUrl(CKEDITOR.config.pasteFromWordCleanupFile||(this.path+'filter/default.js'));CKEDITOR.scriptLoader.load(filterFilePath,callback,null,false,true);}
return!isLoaded;}});})();(function()
{var pasteTextCmd={exec:function(editor)
{var clipboardText=CKEDITOR.tools.tryThese(function()
{var clipboardText=window.clipboardData.getData('Text');if(!clipboardText)
throw 0;return clipboardText;},function()
{window.netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");var clip=window.Components.classes["@mozilla.org/widget/clipboard;1"].getService(window.Components.interfaces.nsIClipboard);var trans=window.Components.classes["@mozilla.org/widget/transferable;1"].createInstance(window.Components.interfaces.nsITransferable);trans.addDataFlavor("text/unicode");clip.getData(trans,clip.kGlobalClipboard);var str={},strLength={},clipboardText;trans.getTransferData("text/unicode",str,strLength);str=str.value.QueryInterface(window.Components.interfaces.nsISupportsString);clipboardText=str.data.substring(0,strLength.value/2);return clipboardText;});if(!clipboardText)
{editor.openDialog('pastetext');return false;}
else
editor.fire('paste',{'text':clipboardText});return true;}};function doInsertText(doc,text)
{if(CKEDITOR.env.ie)
{var selection=doc.selection;if(selection.type=='Control')
selection.clear();selection.createRange().pasteHTML(text);}
else
doc.execCommand('inserthtml',false,text);}
CKEDITOR.plugins.add('pastetext',{init:function(editor)
{var commandName='pastetext',command=editor.addCommand(commandName,pasteTextCmd);editor.ui.addButton('PasteText',{label:editor.lang.pasteText.button,command:commandName});CKEDITOR.dialog.add(commandName,CKEDITOR.getUrl(this.path+'dialogs/pastetext.js'));if(editor.config.forcePasteAsPlainText)
{editor.on('beforeCommandExec',function(evt)
{if(evt.data.name=='paste')
{editor.execCommand('pastetext');evt.cancel();}},null,null,0);}},requires:['clipboard']});function doEnter(editor,mode,times,forceMode)
{while(times--)
{CKEDITOR.plugins.enterkey[mode==CKEDITOR.ENTER_BR?'enterBr':'enterBlock']
(editor,mode,null,forceMode);}}
CKEDITOR.editor.prototype.insertText=function(text)
{this.focus();this.fire('saveSnapshot');var mode=this.getSelection().getStartElement().hasAscendant('pre',true)?CKEDITOR.ENTER_BR:this.config.enterMode,isEnterBrMode=mode==CKEDITOR.ENTER_BR,doc=this.document.$,self=this,line;text=CKEDITOR.tools.htmlEncode(text.replace(/\r\n|\r/g,'\n'));var startIndex=0;text.replace(/\n+/g,function(match,lastIndex)
{line=text.substring(startIndex,lastIndex);startIndex=lastIndex+match.length;line.length&&doInsertText(doc,line);var lineBreakNums=match.length,enterBlockTimes=isEnterBrMode?0:Math.floor(lineBreakNums/2),enterBrTimes=isEnterBrMode?lineBreakNums:lineBreakNums%2;doEnter(self,mode,enterBlockTimes);doEnter(self,CKEDITOR.ENTER_BR,enterBrTimes,isEnterBrMode?false:true);});line=text.substring(startIndex,text.length);line.length&&doInsertText(doc,line);this.fire('saveSnapshot');};})();CKEDITOR.plugins.add('popup');CKEDITOR.tools.extend(CKEDITOR.editor.prototype,{popup:function(url,width,height)
{width=width||'80%';height=height||'70%';if(typeof width=='string'&&width.length>1&&width.substr(width.length-1,1)=='%')
width=parseInt(window.screen.width*parseInt(width,10)/100,10);if(typeof height=='string'&&height.length>1&&height.substr(height.length-1,1)=='%')
height=parseInt(window.screen.height*parseInt(height,10)/100,10);if(width<640)
width=640;if(height<420)
height=420;var top=parseInt((window.screen.height-height)/2,10),left=parseInt((window.screen.width-width)/2,10),options='location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes'+',width='+width+',height='+height+',top='+top+',left='+left;var popupWindow=window.open('',null,options,true);if(!popupWindow)
return false;try
{popupWindow.moveTo(left,top);popupWindow.resizeTo(width,height);popupWindow.focus();popupWindow.location.href=url;}
catch(e)
{popupWindow=window.open(url,null,options,true);}
return true;}});(function()
{var previewCmd={modes:{wysiwyg:1,source:1},canUndo:false,exec:function(editor)
{var sHTML,config=editor.config,baseTag=config.baseHref?'<base href="'+config.baseHref+'"/>':'',isCustomDomain=CKEDITOR.env.isCustomDomain();if(config.fullPage)
{sHTML=editor.getData().replace(/<head>/,'$&'+baseTag).replace(/[^>]*(?=<\/title>)/,editor.lang.preview);}
else
{var bodyHtml='<body ',body=editor.document&&editor.document.getBody();if(body)
{if(body.getAttribute('id'))
bodyHtml+='id="'+body.getAttribute('id')+'" ';if(body.getAttribute('class'))
bodyHtml+='class="'+body.getAttribute('class')+'" ';}
bodyHtml+='>';sHTML=editor.config.docType+'<html dir="'+editor.config.contentsLangDirection+'">'+'<head>'+
baseTag+'<title>'+editor.lang.preview+'</title>'+
CKEDITOR.tools.buildStyleHtml(editor.config.contentsCss)+'</head>'+bodyHtml+
editor.getData()+'</body></html>';}
var iWidth=640,iHeight=420,iLeft=80;try
{var screen=window.screen;iWidth=Math.round(screen.width*0.8);iHeight=Math.round(screen.height*0.7);iLeft=Math.round(screen.width*0.1);}
catch(e){}
var sOpenUrl='';if(isCustomDomain)
{window._cke_htmlToLoad=sHTML;sOpenUrl='javascript:void( (function(){'+'document.open();'+'document.domain="'+document.domain+'";'+'document.write( window.opener._cke_htmlToLoad );'+'document.close();'+'window.opener._cke_htmlToLoad = null;'+'})() )';}
var oWindow=window.open(sOpenUrl,null,'toolbar=yes,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width='+
iWidth+',height='+iHeight+',left='+iLeft);if(!isCustomDomain)
{oWindow.document.open();oWindow.document.write(sHTML);oWindow.document.close();}}};var pluginName='preview';CKEDITOR.plugins.add(pluginName,{init:function(editor)
{editor.addCommand(pluginName,previewCmd);editor.ui.addButton('Preview',{label:editor.lang.preview,command:pluginName});}});})();CKEDITOR.plugins.add('print',{init:function(editor)
{var pluginName='print';var command=editor.addCommand(pluginName,CKEDITOR.plugins.print);editor.ui.addButton('Print',{label:editor.lang.print,command:pluginName});}});CKEDITOR.plugins.print={exec:function(editor)
{if(CKEDITOR.env.opera)
return;else if(CKEDITOR.env.gecko)
editor.window.$.print();else
editor.document.$.execCommand("Print");},canUndo:false,modes:{wysiwyg:!(CKEDITOR.env.opera)}};CKEDITOR.plugins.add('removeformat',{requires:['selection'],init:function(editor)
{editor.addCommand('removeFormat',CKEDITOR.plugins.removeformat.commands.removeformat);editor.ui.addButton('RemoveFormat',{label:editor.lang.removeFormat,command:'removeFormat'});}});CKEDITOR.plugins.removeformat={commands:{removeformat:{exec:function(editor)
{var tagsRegex=editor._.removeFormatRegex||(editor._.removeFormatRegex=new RegExp('^(?:'+editor.config.removeFormatTags.replace(/,/g,'|')+')$','i'));var removeAttributes=editor._.removeAttributes||(editor._.removeAttributes=editor.config.removeFormatAttributes.split(','));var ranges=editor.getSelection().getRanges();for(var i=0,range;range=ranges[i];i++)
{if(range.collapsed)
continue;range.enlarge(CKEDITOR.ENLARGE_ELEMENT);var bookmark=range.createBookmark();var startNode=bookmark.startNode;var endNode=bookmark.endNode;var breakParent=function(node)
{var path=new CKEDITOR.dom.elementPath(node);var pathElements=path.elements;for(var i=1,pathElement;pathElement=pathElements[i];i++)
{if(pathElement.equals(path.block)||pathElement.equals(path.blockLimit))
break;if(tagsRegex.test(pathElement.getName()))
node.breakParent(pathElement);}};breakParent(startNode);breakParent(endNode);var currentNode=startNode.getNextSourceNode(true,CKEDITOR.NODE_ELEMENT);while(currentNode)
{if(currentNode.equals(endNode))
break;var nextNode=currentNode.getNextSourceNode(false,CKEDITOR.NODE_ELEMENT);if(!(currentNode.getName()=='img'&&currentNode.getAttribute('_cke_realelement')))
{if(tagsRegex.test(currentNode.getName()))
currentNode.remove(true);else
currentNode.removeAttributes(removeAttributes);}
currentNode=nextNode;}
range.moveToBookmark(bookmark);}
editor.getSelection().selectRanges(ranges);}}}};CKEDITOR.config.removeFormatTags='b,big,code,del,dfn,em,font,i,ins,kbd,q,samp,small,span,strike,strong,sub,sup,tt,u,var';CKEDITOR.config.removeFormatAttributes='class,style,lang,width,height,align,hspace,valign';CKEDITOR.plugins.add('resize',{init:function(editor)
{var config=editor.config;if(config.resize_enabled)
{var container=null;var origin,startSize;function dragHandler(evt)
{var dx=evt.data.$.screenX-origin.x;var dy=evt.data.$.screenY-origin.y;var internalWidth=startSize.width+dx*(editor.lang.dir=='rtl'?-1:1);var internalHeight=startSize.height+dy;editor.resize(Math.max(config.resize_minWidth,Math.min(internalWidth,config.resize_maxWidth)),Math.max(config.resize_minHeight,Math.min(internalHeight,config.resize_maxHeight)));}
function dragEndHandler(evt)
{CKEDITOR.document.removeListener('mousemove',dragHandler);CKEDITOR.document.removeListener('mouseup',dragEndHandler);if(editor.document)
{editor.document.removeListener('mousemove',dragHandler);editor.document.removeListener('mouseup',dragEndHandler);}}
var mouseDownFn=CKEDITOR.tools.addFunction(function($event)
{if(!container)
container=editor.getResizable();startSize={width:container.$.offsetWidth||0,height:container.$.offsetHeight||0};origin={x:$event.screenX,y:$event.screenY};CKEDITOR.document.on('mousemove',dragHandler);CKEDITOR.document.on('mouseup',dragEndHandler);if(editor.document)
{editor.document.on('mousemove',dragHandler);editor.document.on('mouseup',dragEndHandler);}});editor.on('destroy',function(){CKEDITOR.tools.removeFunction(mouseDownFn);});editor.on('themeSpace',function(event)
{if(event.data.space=='bottom')
{event.data.html+='<div class="cke_resizer"'+' title="'+CKEDITOR.tools.htmlEncode(editor.lang.resize)+'"'+' onmousedown="CKEDITOR.tools.callFunction('+mouseDownFn+', event)"'+'></div>';}},editor,null,100);}}});CKEDITOR.config.resize_minWidth=750;CKEDITOR.config.resize_minHeight=250;CKEDITOR.config.resize_maxWidth=3000;CKEDITOR.config.resize_maxHeight=3000;CKEDITOR.config.resize_enabled=true;CKEDITOR.plugins.add('smiley',{requires:['dialog'],init:function(editor)
{editor.config.smiley_path=editor.config.smiley_path||(this.path+'images/');editor.addCommand('smiley',new CKEDITOR.dialogCommand('smiley'));editor.ui.addButton('Smiley',{label:editor.lang.smiley.toolbar,command:'smiley'});CKEDITOR.dialog.add('smiley',this.path+'dialogs/smiley.js');}});CKEDITOR.config.smiley_images=['regular_smile.gif?20100510','sad_smile.gif?20100510','wink_smile.gif?20100510','teeth_smile.gif?20100510','confused_smile.gif?20100510','tounge_smile.gif?20100510','embaressed_smile.gif?20100510','omg_smile.gif?20100510','whatchutalkingabout_smile.gif?20100510','angry_smile.gif?20100510','angel_smile.gif?20100510','shades_smile.gif?20100510','devil_smile.gif?20100510','cry_smile.gif?20100510','lightbulb.gif?20100510','thumbs_down.gif?20100510','thumbs_up.gif?20100510','heart.gif?20100510','broken_heart.gif?20100510','kiss.gif?20100510','envelope.gif?20100510'];CKEDITOR.config.smiley_descriptions=['smiley','sad','wink','laugh','frown','cheeky','blush','surprise','indecision','angry','angle','cool','devil','crying','enlightened','no','yes','heart','broken heart','kiss','mail'];(function()
{var cssTemplate='.%2 p,'+'.%2 div,'+'.%2 pre,'+'.%2 address,'+'.%2 blockquote,'+'.%2 h1,'+'.%2 h2,'+'.%2 h3,'+'.%2 h4,'+'.%2 h5,'+'.%2 h6'+'{'+'background-repeat: no-repeat;'+'border: 1px dotted gray;'+'padding-top: 8px;'+'padding-left: 8px;'+'}'+'.%2 p'+'{'+'%1p.png?20100510);'+'}'+'.%2 div'+'{'+'%1div.png?20100510);'+'}'+'.%2 pre'+'{'+'%1pre.png?20100510);'+'}'+'.%2 address'+'{'+'%1address.png?20100510);'+'}'+'.%2 blockquote'+'{'+'%1blockquote.png?20100510);'+'}'+'.%2 h1'+'{'+'%1h1.png?20100510);'+'}'+'.%2 h2'+'{'+'%1h2.png?20100510);'+'}'+'.%2 h3'+'{'+'%1h3.png?20100510);'+'}'+'.%2 h4'+'{'+'%1h4.png?20100510);'+'}'+'.%2 h5'+'{'+'%1h5.png?20100510);'+'}'+'.%2 h6'+'{'+'%1h6.png?20100510);'+'}';var cssTemplateRegex=/%1/g,cssClassRegex=/%2/g;var commandDefinition={preserveState:true,editorFocus:false,exec:function(editor)
{this.toggleState();this.refresh(editor);},refresh:function(editor)
{var funcName=(this.state==CKEDITOR.TRISTATE_ON)?'addClass':'removeClass';editor.document.getBody()[funcName]('cke_show_blocks');}};CKEDITOR.plugins.add('showblocks',{requires:['wysiwygarea'],init:function(editor)
{var command=editor.addCommand('showblocks',commandDefinition);command.canUndo=false;if(editor.config.startupOutlineBlocks)
command.setState(CKEDITOR.TRISTATE_ON);editor.addCss(cssTemplate.replace(cssTemplateRegex,'background-image: url('+CKEDITOR.getUrl(this.path)+'images/block_').replace(cssClassRegex,'cke_show_blocks '));editor.ui.addButton('ShowBlocks',{label:editor.lang.showBlocks,command:'showblocks'});editor.on('mode',function()
{if(command.state!=CKEDITOR.TRISTATE_DISABLED)
command.refresh(editor);});editor.on('contentDom',function()
{if(command.state!=CKEDITOR.TRISTATE_DISABLED)
command.refresh(editor);});}});})();CKEDITOR.config.startupOutlineBlocks=false;(function()
{var showBorderClassName='cke_show_border',cssStyleText,cssTemplate=(CKEDITOR.env.ie6Compat?['.%1 table.%2,','.%1 table.%2 td, .%1 table.%2 th,','{','border : #d3d3d3 1px dotted','}']:['.%1 table.%2,','.%1 table.%2 > tr > td, .%1 table.%2 > tr > th,','.%1 table.%2 > tbody > tr > td, .%1 table.%2 > tbody > tr > th,','.%1 table.%2 > thead > tr > td, .%1 table.%2 > thead > tr > th,','.%1 table.%2 > tfoot > tr > td, .%1 table.%2 > tfoot > tr > th','{','border : #d3d3d3 1px dotted','}']).join('');cssStyleText=cssTemplate.replace(/%2/g,showBorderClassName).replace(/%1/g,'cke_show_borders ');var commandDefinition={preserveState:true,editorFocus:false,exec:function(editor)
{this.toggleState();this.refresh(editor);},refresh:function(editor)
{var funcName=(this.state==CKEDITOR.TRISTATE_ON)?'addClass':'removeClass';editor.document.getBody()[funcName]('cke_show_borders');}};CKEDITOR.plugins.add('showborders',{requires:['wysiwygarea'],modes:{'wysiwyg':1},init:function(editor)
{var command=editor.addCommand('showborders',commandDefinition);command.canUndo=false;if(editor.config.startupShowBorders!==false)
command.setState(CKEDITOR.TRISTATE_ON);editor.addCss(cssStyleText);editor.on('mode',function()
{if(command.state!=CKEDITOR.TRISTATE_DISABLED)
command.refresh(editor);},null,null,100);editor.on('contentDom',function()
{if(command.state!=CKEDITOR.TRISTATE_DISABLED)
command.refresh(editor);});},afterInit:function(editor)
{var dataProcessor=editor.dataProcessor,dataFilter=dataProcessor&&dataProcessor.dataFilter,htmlFilter=dataProcessor&&dataProcessor.htmlFilter;if(dataFilter)
{dataFilter.addRules({elements:{'table':function(element)
{var attributes=element.attributes,cssClass=attributes['class'],border=parseInt(attributes.border,10);if(!border||border<=0)
attributes['class']=(cssClass||'')+' '+showBorderClassName;}}});}
if(htmlFilter)
{htmlFilter.addRules({elements:{'table':function(table)
{var attributes=table.attributes,cssClass=attributes['class'];cssClass&&(attributes['class']=cssClass.replace(showBorderClassName,'').replace(/\s{2}/,' ').replace(/^\s+|\s+$/,''));}}});}}});CKEDITOR.on('dialogDefinition',function(ev)
{var dialogName=ev.data.name;if(dialogName=='table'||dialogName=='tableProperties')
{var dialogDefinition=ev.data.definition,infoTab=dialogDefinition.getContents('info'),borderField=infoTab.get('txtBorder'),originalCommit=borderField.commit;borderField.commit=CKEDITOR.tools.override(originalCommit,function(org)
{return function(data,selectedTable)
{org.apply(this,arguments);var value=parseInt(this.getValue(),10);selectedTable[(!value||value<=0)?'addClass':'removeClass'](showBorderClassName);};});}});})();CKEDITOR.plugins.add('sourcearea',{requires:['editingblock'],init:function(editor)
{var sourcearea=CKEDITOR.plugins.sourcearea,win=CKEDITOR.document.getWindow();editor.on('editingBlockReady',function()
{var textarea,onResize;editor.addMode('source',{load:function(holderElement,data)
{if(CKEDITOR.env.ie&&CKEDITOR.env.version<8)
holderElement.setStyle('position','relative');editor.textarea=textarea=new CKEDITOR.dom.element('textarea');textarea.setAttributes({dir:'ltr',tabIndex:editor.tabIndex,'role':'textbox','aria-label':editor.lang.editorTitle.replace('%1',editor.name)});textarea.addClass('cke_source');textarea.addClass('cke_enable_context_menu');var styles={width:CKEDITOR.env.ie7Compat?'99%':'100%',height:'100%',resize:'none',outline:'none','text-align':'left'};if(CKEDITOR.env.ie)
{onResize=function()
{textarea.hide();textarea.setStyle('height',holderElement.$.clientHeight+'px');textarea.setStyle('width',holderElement.$.clientWidth+'px');textarea.show();};editor.on('resize',onResize);win.on('resize',onResize);setTimeout(onResize,0);}
else
{textarea.on('mousedown',function(evt)
{evt.data.stopPropagation();});}
holderElement.setHtml('');holderElement.append(textarea);textarea.setStyles(styles);editor.fire('ariaWidget',textarea);textarea.on('blur',function()
{editor.focusManager.blur();});textarea.on('focus',function()
{editor.focusManager.focus();});editor.mayBeDirty=true;this.loadData(data);var keystrokeHandler=editor.keystrokeHandler;if(keystrokeHandler)
keystrokeHandler.attach(textarea);setTimeout(function()
{editor.mode='source';editor.fire('mode');},(CKEDITOR.env.gecko||CKEDITOR.env.webkit)?100:0);},loadData:function(data)
{textarea.setValue(data);editor.fire('dataReady');},getData:function()
{return textarea.getValue();},getSnapshotData:function()
{return textarea.getValue();},unload:function(holderElement)
{textarea.clearCustomData();editor.textarea=textarea=null;if(onResize)
{editor.removeListener('resize',onResize);win.removeListener('resize',onResize);}
if(CKEDITOR.env.ie&&CKEDITOR.env.version<8)
holderElement.removeStyle('position');},focus:function()
{textarea.focus();}});});editor.addCommand('source',sourcearea.commands.source);if(editor.ui.addButton)
{editor.ui.addButton('Source',{label:editor.lang.source,command:'source'});}
editor.on('mode',function()
{editor.getCommand('source').setState(editor.mode=='source'?CKEDITOR.TRISTATE_ON:CKEDITOR.TRISTATE_OFF);});}});CKEDITOR.plugins.sourcearea={commands:{source:{modes:{wysiwyg:1,source:1},exec:function(editor)
{if(editor.mode=='wysiwyg')
editor.fire('saveSnapshot');editor.getCommand('source').setState(CKEDITOR.TRISTATE_DISABLED);editor.setMode(editor.mode=='source'?'wysiwyg':'source');},canUndo:false}}};(function()
{CKEDITOR.plugins.add('stylescombo',{requires:['richcombo','styles'],init:function(editor)
{var config=editor.config,lang=editor.lang.stylesCombo,styles={},stylesList=[];function loadStylesSet(callback)
{editor.getStylesSet(function(stylesDefinitions)
{if(!stylesList.length)
{var style,styleName;for(var i=0;i<stylesDefinitions.length;i++)
{var styleDefinition=stylesDefinitions[i];styleName=styleDefinition.name;style=styles[styleName]=new CKEDITOR.style(styleDefinition);style._name=styleName;stylesList.push(style);}
stylesList.sort(sortStyles);}
callback&&callback();});}
editor.ui.addRichCombo('Styles',{label:lang.label,title:lang.panelTitle,className:'cke_styles',panel:{css:editor.skin.editor.css.concat(config.contentsCss),multiSelect:true,attributes:{'aria-label':lang.panelTitle}},init:function()
{var combo=this;loadStylesSet(function()
{var style,styleName;var lastType;for(var i=0;i<stylesList.length;i++)
{style=stylesList[i];styleName=style._name;var type=style.type;if(type!=lastType)
{combo.startGroup(lang['panelTitle'+String(type)]);lastType=type;}
combo.add(styleName,style.type==CKEDITOR.STYLE_OBJECT?styleName:style.buildPreview(),styleName);}
combo.commit();combo.onOpen();});},onClick:function(value)
{editor.focus();editor.fire('saveSnapshot');var style=styles[value],selection=editor.getSelection();var elementPath=new CKEDITOR.dom.elementPath(selection.getStartElement());if(style.type==CKEDITOR.STYLE_INLINE&&style.checkActive(elementPath))
style.remove(editor.document);else
style.apply(editor.document);editor.fire('saveSnapshot');},onRender:function()
{editor.on('selectionChange',function(ev)
{var currentValue=this.getValue();var elementPath=ev.data.path,elements=elementPath.elements;for(var i=0,element;i<elements.length;i++)
{element=elements[i];for(var value in styles)
{if(styles[value].checkElementRemovable(element,true))
{if(value!=currentValue)
this.setValue(value);return;}}}
this.setValue('');},this);},onOpen:function()
{if(CKEDITOR.env.ie||CKEDITOR.env.webkit)
editor.focus();var selection=editor.getSelection();var element=selection.getSelectedElement(),elementPath=new CKEDITOR.dom.elementPath(element||selection.getStartElement());var counter=[0,0,0,0];this.showAll();this.unmarkAll();for(var name in styles)
{var style=styles[name],type=style.type;if(style.checkActive(elementPath))
this.mark(name);else if(type==CKEDITOR.STYLE_OBJECT&&!style.checkApplicable(elementPath))
{this.hideItem(name);counter[type]--;}
counter[type]++;}
if(!counter[CKEDITOR.STYLE_BLOCK])
this.hideGroup(lang['panelTitle'+String(CKEDITOR.STYLE_BLOCK)]);if(!counter[CKEDITOR.STYLE_INLINE])
this.hideGroup(lang['panelTitle'+String(CKEDITOR.STYLE_INLINE)]);if(!counter[CKEDITOR.STYLE_OBJECT])
this.hideGroup(lang['panelTitle'+String(CKEDITOR.STYLE_OBJECT)]);}});editor.on('instanceReady',function(){loadStylesSet();});}});function sortStyles(styleA,styleB)
{var typeA=styleA.type,typeB=styleB.type;return typeA==typeB?0:typeA==CKEDITOR.STYLE_OBJECT?-1:typeB==CKEDITOR.STYLE_OBJECT?1:typeB==CKEDITOR.STYLE_BLOCK?1:-1;}})();CKEDITOR.plugins.add('table',{init:function(editor)
{var table=CKEDITOR.plugins.table,lang=editor.lang.table;editor.addCommand('table',new CKEDITOR.dialogCommand('table'));editor.addCommand('tableProperties',new CKEDITOR.dialogCommand('tableProperties'));editor.ui.addButton('Table',{label:lang.toolbar,command:'table'});CKEDITOR.dialog.add('table',this.path+'dialogs/table.js');CKEDITOR.dialog.add('tableProperties',this.path+'dialogs/table.js');if(editor.addMenuItems)
{editor.addMenuItems({table:{label:lang.menu,command:'tableProperties',group:'table',order:5},tabledelete:{label:lang.deleteTable,command:'tableDelete',group:'table',order:1}});}
if(editor.contextMenu)
{editor.contextMenu.addListener(function(element,selection)
{if(!element)
return null;var isTable=element.is('table')||element.hasAscendant('table');if(isTable)
{return{tabledelete:CKEDITOR.TRISTATE_OFF,table:CKEDITOR.TRISTATE_OFF};}
return null;});}}});(function()
{function removeRawAttribute($node,attr)
{if(CKEDITOR.env.ie)
$node.removeAttribute(attr);else
delete $node[attr];}
var cellNodeRegex=/^(?:td|th)$/;function getSelectedCells(selection)
{var bookmarks=selection.createBookmarks();var ranges=selection.getRanges();var retval=[];var database={};function moveOutOfCellGuard(node)
{if(retval.length>0)
return;if(node.type==CKEDITOR.NODE_ELEMENT&&cellNodeRegex.test(node.getName())&&!node.getCustomData('selected_cell'))
{CKEDITOR.dom.element.setMarker(database,node,'selected_cell',true);retval.push(node);}}
for(var i=0;i<ranges.length;i++)
{var range=ranges[i];if(range.collapsed)
{var startNode=range.getCommonAncestor();var nearestCell=startNode.getAscendant('td',true)||startNode.getAscendant('th',true);if(nearestCell)
retval.push(nearestCell);}
else
{var walker=new CKEDITOR.dom.walker(range);var node;walker.guard=moveOutOfCellGuard;while((node=walker.next()))
{var parent=node.getParent();if(parent&&cellNodeRegex.test(parent.getName())&&!parent.getCustomData('selected_cell'))
{CKEDITOR.dom.element.setMarker(database,parent,'selected_cell',true);retval.push(parent);}}}}
CKEDITOR.dom.element.clearAllMarkers(database);selection.selectBookmarks(bookmarks);return retval;}
function getFocusedCell(cellsToDelete){var i=0,last=cellsToDelete.length-1,database={},cell,focusedCell,tr;while((cell=cellsToDelete[i++]))
CKEDITOR.dom.element.setMarker(database,cell,'delete_cell',true);i=0;while((cell=cellsToDelete[i++]))
{if((focusedCell=cell.getPrevious())&&!focusedCell.getCustomData('delete_cell')||(focusedCell=cell.getNext())&&!focusedCell.getCustomData('delete_cell'))
{CKEDITOR.dom.element.clearAllMarkers(database);return focusedCell;}}
CKEDITOR.dom.element.clearAllMarkers(database);tr=cellsToDelete[0].getParent();if((tr=tr.getPrevious()))
return tr.getLast();tr=cellsToDelete[last].getParent();if((tr=tr.getNext()))
return tr.getChild(0);return null;}
function clearRow($tr)
{var $cells=$tr.cells;for(var i=0;i<$cells.length;i++)
{$cells[i].innerHTML='';if(!CKEDITOR.env.ie)
(new CKEDITOR.dom.element($cells[i])).appendBogus();}}
function insertRow(selection,insertBefore)
{var row=selection.getStartElement().getAscendant('tr');if(!row)
return;var newRow=row.clone(true);newRow.insertBefore(row);clearRow(insertBefore?newRow.$:row.$);}
function deleteRows(selectionOrRow)
{if(selectionOrRow instanceof CKEDITOR.dom.selection)
{var cells=getSelectedCells(selectionOrRow),cellsCount=cells.length,rowsToDelete=[],cursorPosition,previousRowIndex,nextRowIndex;for(var i=0;i<cellsCount;i++)
{var row=cells[i].getParent(),rowIndex=row.$.rowIndex;!i&&(previousRowIndex=rowIndex-1);rowsToDelete[rowIndex]=row;i==cellsCount-1&&(nextRowIndex=rowIndex+1);}
var table=row.getAscendant('table'),rows=table.$.rows,rowCount=rows.length;cursorPosition=new CKEDITOR.dom.element(nextRowIndex<rowCount&&table.$.rows[nextRowIndex]||previousRowIndex>0&&table.$.rows[previousRowIndex]||table.$.parentNode);for(i=rowsToDelete.length;i>=0;i--)
{if(rowsToDelete[i])
deleteRows(rowsToDelete[i]);}
return cursorPosition;}
else if(selectionOrRow instanceof CKEDITOR.dom.element)
{table=selectionOrRow.getAscendant('table');if(table.$.rows.length==1)
table.remove();else
selectionOrRow.remove();}
return 0;}
function insertColumn(selection,insertBefore)
{var startElement=selection.getStartElement();var cell=startElement.getAscendant('td',true)||startElement.getAscendant('th',true);if(!cell)
return;var table=cell.getAscendant('table');var cellIndex=cell.$.cellIndex;for(var i=0;i<table.$.rows.length;i++)
{var $row=table.$.rows[i];if($row.cells.length<(cellIndex+1))
continue;cell=new CKEDITOR.dom.element($row.cells[cellIndex].cloneNode(false));if(!CKEDITOR.env.ie)
cell.appendBogus();var baseCell=new CKEDITOR.dom.element($row.cells[cellIndex]);if(insertBefore)
cell.insertBefore(baseCell);else
cell.insertAfter(baseCell);}}
function deleteColumns(selectionOrCell)
{if(selectionOrCell instanceof CKEDITOR.dom.selection)
{var colsToDelete=getSelectedCells(selectionOrCell);for(var i=colsToDelete.length;i>=0;i--)
{if(colsToDelete[i])
deleteColumns(colsToDelete[i]);}}
else if(selectionOrCell instanceof CKEDITOR.dom.element)
{var table=selectionOrCell.getAscendant('table');var cellIndex=selectionOrCell.$.cellIndex;for(i=table.$.rows.length-1;i>=0;i--)
{var row=new CKEDITOR.dom.element(table.$.rows[i]);if(!cellIndex&&row.$.cells.length==1)
{deleteRows(row);continue;}
if(row.$.cells[cellIndex])
row.$.removeChild(row.$.cells[cellIndex]);}}}
function insertCell(selection,insertBefore)
{var startElement=selection.getStartElement();var cell=startElement.getAscendant('td',true)||startElement.getAscendant('th',true);if(!cell)
return;var newCell=cell.clone();if(!CKEDITOR.env.ie)
newCell.appendBogus();if(insertBefore)
newCell.insertBefore(cell);else
newCell.insertAfter(cell);}
function deleteCells(selectionOrCell)
{if(selectionOrCell instanceof CKEDITOR.dom.selection)
{var cellsToDelete=getSelectedCells(selectionOrCell);var table=cellsToDelete[0]&&cellsToDelete[0].getAscendant('table');var cellToFocus=getFocusedCell(cellsToDelete);for(var i=cellsToDelete.length-1;i>=0;i--)
deleteCells(cellsToDelete[i]);if(cellToFocus)
placeCursorInCell(cellToFocus,true);else if(table)
table.remove();}
else if(selectionOrCell instanceof CKEDITOR.dom.element)
{var tr=selectionOrCell.getParent();if(tr.getChildCount()==1)
tr.remove();else
selectionOrCell.remove();}}
function trimCell(cell)
{var bogus=cell.getBogus();bogus&&bogus.remove();cell.trim();}
function placeCursorInCell(cell,placeAtEnd)
{var range=new CKEDITOR.dom.range(cell.getDocument());if(!range['moveToElementEdit'+(placeAtEnd?'End':'Start')](cell))
{range.selectNodeContents(cell);range.collapse(placeAtEnd?false:true);}
range.select(true);}
function buildTableMap(table)
{var aRows=table.$.rows;var r=-1;var aMap=[];for(var i=0;i<aRows.length;i++)
{r++;!aMap[r]&&(aMap[r]=[]);var c=-1;for(var j=0;j<aRows[i].cells.length;j++)
{var oCell=aRows[i].cells[j];c++;while(aMap[r][c])
c++;var iColSpan=isNaN(oCell.colSpan)?1:oCell.colSpan;var iRowSpan=isNaN(oCell.rowSpan)?1:oCell.rowSpan;for(var rs=0;rs<iRowSpan;rs++)
{if(!aMap[r+rs])
aMap[r+rs]=new Array();for(var cs=0;cs<iColSpan;cs++)
{aMap[r+rs][c+cs]=aRows[i].cells[j];}}
c+=iColSpan-1;}}
return aMap;}
function cellInRow(tableMap,rowIndex,cell)
{var oRow=tableMap[rowIndex];if(typeof cell=='undefined')
return oRow;for(var c=0;oRow&&c<oRow.length;c++)
{if(cell.is&&oRow[c]==cell.$)
return c;else if(c==cell)
return new CKEDITOR.dom.element(oRow[c]);}
return cell.is?-1:null;}
function cellInCol(tableMap,colIndex,cell)
{var oCol=[];for(var r=0;r<tableMap.length;r++)
{var row=tableMap[r];if(typeof cell=='undefined')
oCol.push(row[colIndex]);else if(cell.is&&row[colIndex]==cell.$)
return r;else if(r==cell)
return new CKEDITOR.dom.element(row[colIndex]);}
return(typeof cell=='undefined')?oCol:cell.is?-1:null;}
function mergeCells(selection,mergeDirection,isDetect)
{var cells=getSelectedCells(selection);var commonAncestor;if((mergeDirection?cells.length!=1:cells.length<2)||(commonAncestor=selection.getCommonAncestor())&&commonAncestor.type==CKEDITOR.NODE_ELEMENT&&commonAncestor.is('table'))
{return false;}
var cell,firstCell=cells[0],table=firstCell.getAscendant('table'),map=buildTableMap(table),mapHeight=map.length,mapWidth=map[0].length,startRow=firstCell.getParent().$.rowIndex,startColumn=cellInRow(map,startRow,firstCell);if(mergeDirection)
{var targetCell;try
{targetCell=map[mergeDirection=='up'?(startRow-1):mergeDirection=='down'?(startRow+1):startRow][mergeDirection=='left'?(startColumn-1):mergeDirection=='right'?(startColumn+1):startColumn];}
catch(er)
{return false;}
if(!targetCell||firstCell.$==targetCell)
return false;cells[(mergeDirection=='up'||mergeDirection=='left')?'unshift':'push'](new CKEDITOR.dom.element(targetCell));}
var doc=firstCell.getDocument(),lastRowIndex=startRow,totalRowSpan=0,totalColSpan=0,frag=!isDetect&&new CKEDITOR.dom.documentFragment(doc),dimension=0;for(var i=0;i<cells.length;i++)
{cell=cells[i];var tr=cell.getParent(),cellFirstChild=cell.getFirst(),colSpan=cell.$.colSpan,rowSpan=cell.$.rowSpan,rowIndex=tr.$.rowIndex,colIndex=cellInRow(map,rowIndex,cell);dimension+=colSpan*rowSpan;totalColSpan=Math.max(totalColSpan,colIndex-startColumn+colSpan);totalRowSpan=Math.max(totalRowSpan,rowIndex-startRow+rowSpan);if(!isDetect)
{if(trimCell(cell),cell.getChildren().count())
{if(rowIndex!=lastRowIndex&&cellFirstChild&&!(cellFirstChild.isBlockBoundary&&cellFirstChild.isBlockBoundary({br:1})))
{var last=frag.getLast(CKEDITOR.dom.walker.whitespaces(true));if(last&&!(last.is&&last.is('br')))
frag.append(new CKEDITOR.dom.element('br'));}
cell.moveChildren(frag);}
i?cell.remove():cell.setHtml('');}
lastRowIndex=rowIndex;}
if(!isDetect)
{frag.moveChildren(firstCell);if(!CKEDITOR.env.ie)
firstCell.appendBogus();if(totalColSpan>=mapWidth)
firstCell.removeAttribute('rowSpan');else
firstCell.$.rowSpan=totalRowSpan;if(totalRowSpan>=mapHeight)
firstCell.removeAttribute('colSpan');else
firstCell.$.colSpan=totalColSpan;var trs=new CKEDITOR.dom.nodeList(table.$.rows),count=trs.count();for(i=count-1;i>=0;i--)
{var tailTr=trs.getItem(i);if(!tailTr.$.cells.length)
{tailTr.remove();count++;continue;}}
return firstCell;}
else
return(totalRowSpan*totalColSpan)==dimension;}
function verticalSplitCell(selection,isDetect)
{var cells=getSelectedCells(selection);if(cells.length>1)
return false;else if(isDetect)
return true;var cell=cells[0],tr=cell.getParent(),table=tr.getAscendant('table'),map=buildTableMap(table),rowIndex=tr.$.rowIndex,colIndex=cellInRow(map,rowIndex,cell),rowSpan=cell.$.rowSpan,newCell,newRowSpan,newCellRowSpan,newRowIndex;if(rowSpan>1)
{newRowSpan=Math.ceil(rowSpan/2);newCellRowSpan=Math.floor(rowSpan/2);newRowIndex=rowIndex+newRowSpan;var newCellTr=new CKEDITOR.dom.element(table.$.rows[newRowIndex]),newCellRow=cellInRow(map,newRowIndex),candidateCell;newCell=cell.clone();for(var c=0;c<newCellRow.length;c++)
{candidateCell=newCellRow[c];if(candidateCell.parentNode==newCellTr.$&&c>colIndex)
{newCell.insertBefore(new CKEDITOR.dom.element(candidateCell));break;}
else
candidateCell=null;}
if(!candidateCell)
newCellTr.append(newCell,true);}
else
{newCellRowSpan=newRowSpan=1;newCellTr=tr.clone();newCellTr.insertAfter(tr);newCellTr.append(newCell=cell.clone());var cellsInSameRow=cellInRow(map,rowIndex);for(var i=0;i<cellsInSameRow.length;i++)
cellsInSameRow[i].rowSpan++;}
if(!CKEDITOR.env.ie)
newCell.appendBogus();cell.$.rowSpan=newRowSpan;newCell.$.rowSpan=newCellRowSpan;if(newRowSpan==1)
cell.removeAttribute('rowSpan');if(newCellRowSpan==1)
newCell.removeAttribute('rowSpan');return newCell;}
function horizontalSplitCell(selection,isDetect)
{var cells=getSelectedCells(selection);if(cells.length>1)
return false;else if(isDetect)
return true;var cell=cells[0],tr=cell.getParent(),table=tr.getAscendant('table'),map=buildTableMap(table),rowIndex=tr.$.rowIndex,colIndex=cellInRow(map,rowIndex,cell),colSpan=cell.$.colSpan,newCell,newColSpan,newCellColSpan;if(colSpan>1)
{newColSpan=Math.ceil(colSpan/2);newCellColSpan=Math.floor(colSpan/2);}
else
{newCellColSpan=newColSpan=1;var cellsInSameCol=cellInCol(map,colIndex);for(var i=0;i<cellsInSameCol.length;i++)
cellsInSameCol[i].colSpan++;}
newCell=cell.clone();newCell.insertAfter(cell);if(!CKEDITOR.env.ie)
newCell.appendBogus();cell.$.colSpan=newColSpan;newCell.$.colSpan=newCellColSpan;if(newColSpan==1)
cell.removeAttribute('colSpan');if(newCellColSpan==1)
newCell.removeAttribute('colSpan');return newCell;}
var contextMenuTags={thead:1,tbody:1,tfoot:1,td:1,tr:1,th:1};CKEDITOR.plugins.tabletools={init:function(editor)
{var lang=editor.lang.table;editor.addCommand('cellProperties',new CKEDITOR.dialogCommand('cellProperties'));CKEDITOR.dialog.add('cellProperties',this.path+'dialogs/tableCell.js');editor.addCommand('tableDelete',{exec:function(editor)
{var selection=editor.getSelection();var startElement=selection&&selection.getStartElement();var table=startElement&&startElement.getAscendant('table',true);if(!table)
return;selection.selectElement(table);var range=selection.getRanges()[0];range.collapse();selection.selectRanges([range]);if(table.getParent().getChildCount()==1)
table.getParent().remove();else
table.remove();}});editor.addCommand('rowDelete',{exec:function(editor)
{var selection=editor.getSelection();placeCursorInCell(deleteRows(selection));}});editor.addCommand('rowInsertBefore',{exec:function(editor)
{var selection=editor.getSelection();insertRow(selection,true);}});editor.addCommand('rowInsertAfter',{exec:function(editor)
{var selection=editor.getSelection();insertRow(selection);}});editor.addCommand('columnDelete',{exec:function(editor)
{var selection=editor.getSelection();deleteColumns(selection);}});editor.addCommand('columnInsertBefore',{exec:function(editor)
{var selection=editor.getSelection();insertColumn(selection,true);}});editor.addCommand('columnInsertAfter',{exec:function(editor)
{var selection=editor.getSelection();insertColumn(selection);}});editor.addCommand('cellDelete',{exec:function(editor)
{var selection=editor.getSelection();deleteCells(selection);}});editor.addCommand('cellMerge',{exec:function(editor)
{placeCursorInCell(mergeCells(editor.getSelection()),true);}});editor.addCommand('cellMergeRight',{exec:function(editor)
{placeCursorInCell(mergeCells(editor.getSelection(),'right'),true);}});editor.addCommand('cellMergeDown',{exec:function(editor)
{placeCursorInCell(mergeCells(editor.getSelection(),'down'),true);}});editor.addCommand('cellVerticalSplit',{exec:function(editor)
{placeCursorInCell(verticalSplitCell(editor.getSelection()));}});editor.addCommand('cellHorizontalSplit',{exec:function(editor)
{placeCursorInCell(horizontalSplitCell(editor.getSelection()));}});editor.addCommand('cellInsertBefore',{exec:function(editor)
{var selection=editor.getSelection();insertCell(selection,true);}});editor.addCommand('cellInsertAfter',{exec:function(editor)
{var selection=editor.getSelection();insertCell(selection);}});if(editor.addMenuItems)
{editor.addMenuItems({tablecell:{label:lang.cell.menu,group:'tablecell',order:1,getItems:function()
{var selection=editor.getSelection(),cells=getSelectedCells(selection);return{tablecell_insertBefore:CKEDITOR.TRISTATE_OFF,tablecell_insertAfter:CKEDITOR.TRISTATE_OFF,tablecell_delete:CKEDITOR.TRISTATE_OFF,tablecell_merge:mergeCells(selection,null,true)?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED,tablecell_merge_right:mergeCells(selection,'right',true)?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED,tablecell_merge_down:mergeCells(selection,'down',true)?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED,tablecell_split_vertical:verticalSplitCell(selection,true)?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED,tablecell_split_horizontal:horizontalSplitCell(selection,true)?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED,tablecell_properties:cells.length>0?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED};}},tablecell_insertBefore:{label:lang.cell.insertBefore,group:'tablecell',command:'cellInsertBefore',order:5},tablecell_insertAfter:{label:lang.cell.insertAfter,group:'tablecell',command:'cellInsertAfter',order:10},tablecell_delete:{label:lang.cell.deleteCell,group:'tablecell',command:'cellDelete',order:15},tablecell_merge:{label:lang.cell.merge,group:'tablecell',command:'cellMerge',order:16},tablecell_merge_right:{label:lang.cell.mergeRight,group:'tablecell',command:'cellMergeRight',order:17},tablecell_merge_down:{label:lang.cell.mergeDown,group:'tablecell',command:'cellMergeDown',order:18},tablecell_split_horizontal:{label:lang.cell.splitHorizontal,group:'tablecell',command:'cellHorizontalSplit',order:19},tablecell_split_vertical:{label:lang.cell.splitVertical,group:'tablecell',command:'cellVerticalSplit',order:20},tablecell_properties:{label:lang.cell.title,group:'tablecellproperties',command:'cellProperties',order:21},tablerow:{label:lang.row.menu,group:'tablerow',order:1,getItems:function()
{return{tablerow_insertBefore:CKEDITOR.TRISTATE_OFF,tablerow_insertAfter:CKEDITOR.TRISTATE_OFF,tablerow_delete:CKEDITOR.TRISTATE_OFF};}},tablerow_insertBefore:{label:lang.row.insertBefore,group:'tablerow',command:'rowInsertBefore',order:5},tablerow_insertAfter:{label:lang.row.insertAfter,group:'tablerow',command:'rowInsertAfter',order:10},tablerow_delete:{label:lang.row.deleteRow,group:'tablerow',command:'rowDelete',order:15},tablecolumn:{label:lang.column.menu,group:'tablecolumn',order:1,getItems:function()
{return{tablecolumn_insertBefore:CKEDITOR.TRISTATE_OFF,tablecolumn_insertAfter:CKEDITOR.TRISTATE_OFF,tablecolumn_delete:CKEDITOR.TRISTATE_OFF};}},tablecolumn_insertBefore:{label:lang.column.insertBefore,group:'tablecolumn',command:'columnInsertBefore',order:5},tablecolumn_insertAfter:{label:lang.column.insertAfter,group:'tablecolumn',command:'columnInsertAfter',order:10},tablecolumn_delete:{label:lang.column.deleteColumn,group:'tablecolumn',command:'columnDelete',order:15}});}
if(editor.contextMenu)
{editor.contextMenu.addListener(function(element,selection)
{if(!element)
return null;while(element)
{if(element.getName()in contextMenuTags)
{return{tablecell:CKEDITOR.TRISTATE_OFF,tablerow:CKEDITOR.TRISTATE_OFF,tablecolumn:CKEDITOR.TRISTATE_OFF};}
element=element.getParent();}
return null;});}},getSelectedCells:getSelectedCells};CKEDITOR.plugins.add('tabletools',CKEDITOR.plugins.tabletools);})();CKEDITOR.plugins.add('specialchar',{init:function(editor)
{var pluginName='specialchar';CKEDITOR.dialog.add(pluginName,this.path+'dialogs/specialchar.js');editor.addCommand(pluginName,new CKEDITOR.dialogCommand(pluginName));editor.ui.addButton('SpecialChar',{label:editor.lang.specialChar.toolbar,command:pluginName});}});(function()
{var meta={editorFocus:false,modes:{wysiwyg:1,source:1}};var blurCommand={exec:function(editor)
{editor.container.focusNext(true,editor.tabIndex);}};var blurBackCommand={exec:function(editor)
{editor.container.focusPrevious(true,editor.tabIndex);}};CKEDITOR.plugins.add('tab',{requires:['keystrokes'],init:function(editor)
{var tabSpaces=editor.config.tabSpaces||0,tabText='';while(tabSpaces--)
tabText+='\xa0';if(tabText)
{editor.on('key',function(ev)
{if(ev.data.keyCode==9)
{editor.insertHtml(tabText);ev.cancel();}});}
if(CKEDITOR.env.webkit)
{editor.on('key',function(ev)
{var keyCode=ev.data.keyCode;if(keyCode==9&&!tabText)
{ev.cancel();editor.execCommand('blur');}
if(keyCode==(CKEDITOR.SHIFT+9))
{editor.execCommand('blurBack');ev.cancel();}});}
editor.addCommand('blur',CKEDITOR.tools.extend(blurCommand,meta));editor.addCommand('blurBack',CKEDITOR.tools.extend(blurBackCommand,meta));}});})();CKEDITOR.dom.element.prototype.focusNext=function(ignoreChildren,indexToUse)
{var $=this.$,curTabIndex=(indexToUse===undefined?this.getTabIndex():indexToUse),passedCurrent,enteredCurrent,elected,electedTabIndex,element,elementTabIndex;if(curTabIndex<=0)
{element=this.getNextSourceNode(ignoreChildren,CKEDITOR.NODE_ELEMENT);while(element)
{if(element.isVisible()&&element.getTabIndex()===0)
{elected=element;break;}
element=element.getNextSourceNode(false,CKEDITOR.NODE_ELEMENT);}}
else
{element=this.getDocument().getBody().getFirst();while((element=element.getNextSourceNode(false,CKEDITOR.NODE_ELEMENT)))
{if(!passedCurrent)
{if(!enteredCurrent&&element.equals(this))
{enteredCurrent=true;if(ignoreChildren)
{if(!(element=element.getNextSourceNode(true,CKEDITOR.NODE_ELEMENT)))
break;passedCurrent=1;}}
else if(enteredCurrent&&!this.contains(element))
passedCurrent=1;}
if(!element.isVisible()||(elementTabIndex=element.getTabIndex())<0)
continue;if(passedCurrent&&elementTabIndex==curTabIndex)
{elected=element;break;}
if(elementTabIndex>curTabIndex&&(!elected||!electedTabIndex||elementTabIndex<electedTabIndex))
{elected=element;electedTabIndex=elementTabIndex;}
else if(!elected&&elementTabIndex===0)
{elected=element;electedTabIndex=elementTabIndex;}}}
if(elected)
elected.focus();};CKEDITOR.dom.element.prototype.focusPrevious=function(ignoreChildren,indexToUse)
{var $=this.$,curTabIndex=(indexToUse===undefined?this.getTabIndex():indexToUse),passedCurrent,enteredCurrent,elected,electedTabIndex=0,elementTabIndex;var element=this.getDocument().getBody().getLast();while((element=element.getPreviousSourceNode(false,CKEDITOR.NODE_ELEMENT)))
{if(!passedCurrent)
{if(!enteredCurrent&&element.equals(this))
{enteredCurrent=true;if(ignoreChildren)
{if(!(element=element.getPreviousSourceNode(true,CKEDITOR.NODE_ELEMENT)))
break;passedCurrent=1;}}
else if(enteredCurrent&&!this.contains(element))
passedCurrent=1;}
if(!element.isVisible()||(elementTabIndex=element.getTabIndex())<0)
continue;if(curTabIndex<=0)
{if(passedCurrent&&elementTabIndex===0)
{elected=element;break;}
if(elementTabIndex>electedTabIndex)
{elected=element;electedTabIndex=elementTabIndex;}}
else
{if(passedCurrent&&elementTabIndex==curTabIndex)
{elected=element;break;}
if(elementTabIndex<curTabIndex&&(!elected||elementTabIndex>electedTabIndex))
{elected=element;electedTabIndex=elementTabIndex;}}}
if(elected)
elected.focus();};(function()
{CKEDITOR.plugins.add('templates',{requires:['dialog'],init:function(editor)
{CKEDITOR.dialog.add('templates',CKEDITOR.getUrl(this.path+'dialogs/templates.js'));editor.addCommand('templates',new CKEDITOR.dialogCommand('templates'));editor.ui.addButton('Templates',{label:editor.lang.templates.button,command:'templates'});}});var templates={},loadedTemplatesFiles={};CKEDITOR.addTemplates=function(name,definition)
{templates[name]=definition;};CKEDITOR.getTemplates=function(name)
{return templates[name];};CKEDITOR.loadTemplates=function(templateFiles,callback)
{var toLoad=[];for(var i=0;i<templateFiles.length;i++)
{if(!loadedTemplatesFiles[templateFiles[i]])
{toLoad.push(templateFiles[i]);loadedTemplatesFiles[templateFiles[i]]=1;}}
if(toLoad.length>0)
CKEDITOR.scriptLoader.load(toLoad,callback);else
setTimeout(callback,0);};})();CKEDITOR.config.templates='default';CKEDITOR.config.templates_files=[CKEDITOR.getUrl('plugins/templates/templates/default.js')];CKEDITOR.config.templates_replaceContent=true;(function()
{CKEDITOR.plugins.add('undo',{requires:['selection','wysiwygarea'],init:function(editor)
{var undoManager=new UndoManager(editor);var undoCommand=editor.addCommand('undo',{exec:function()
{if(undoManager.undo())
{editor.selectionChange();editor.fire('afterUndo');}},state:CKEDITOR.TRISTATE_DISABLED,canUndo:false});var redoCommand=editor.addCommand('redo',{exec:function()
{if(undoManager.redo())
{editor.selectionChange();editor.fire('afterRedo');}},state:CKEDITOR.TRISTATE_DISABLED,canUndo:false});undoManager.onChange=function()
{undoCommand.setState(undoManager.undoable()?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED);redoCommand.setState(undoManager.redoable()?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED);};function recordCommand(event)
{if(undoManager.enabled&&event.data.command.canUndo!==false)
undoManager.save();}
editor.on('beforeCommandExec',recordCommand);editor.on('afterCommandExec',recordCommand);editor.on('saveSnapshot',function()
{undoManager.save();});editor.on('contentDom',function()
{editor.document.on('keydown',function(event)
{if(!event.data.$.ctrlKey&&!event.data.$.metaKey)
undoManager.type(event);});});editor.on('beforeModeUnload',function()
{editor.mode=='wysiwyg'&&undoManager.save(true);});editor.on('mode',function()
{undoManager.enabled=editor.mode=='wysiwyg';undoManager.onChange();});editor.ui.addButton('Undo',{label:editor.lang.undo,command:'undo'});editor.ui.addButton('Redo',{label:editor.lang.redo,command:'redo'});editor.resetUndo=function()
{undoManager.reset();editor.fire('saveSnapshot');};}});function Image(editor)
{var contents=editor.getSnapshot(),selection=contents&&editor.getSelection();CKEDITOR.env.ie&&contents&&(contents=contents.replace(/\s+_cke_expando=".*?"/g,''));this.contents=contents;this.bookmarks=selection&&selection.createBookmarks2(true);}
var protectedAttrs=/\b(?:href|src|name)="[^"]*?"/gi;Image.prototype={equals:function(otherImage,contentOnly)
{var thisContents=this.contents,otherContents=otherImage.contents;if(CKEDITOR.env.ie&&(CKEDITOR.env.ie7Compat||CKEDITOR.env.ie6Compat))
{thisContents=thisContents.replace(protectedAttrs,'');otherContents=otherContents.replace(protectedAttrs,'');}
if(thisContents!=otherContents)
return false;if(contentOnly)
return true;var bookmarksA=this.bookmarks,bookmarksB=otherImage.bookmarks;if(bookmarksA||bookmarksB)
{if(!bookmarksA||!bookmarksB||bookmarksA.length!=bookmarksB.length)
return false;for(var i=0;i<bookmarksA.length;i++)
{var bookmarkA=bookmarksA[i],bookmarkB=bookmarksB[i];if(bookmarkA.startOffset!=bookmarkB.startOffset||bookmarkA.endOffset!=bookmarkB.endOffset||!CKEDITOR.tools.arrayCompare(bookmarkA.start,bookmarkB.start)||!CKEDITOR.tools.arrayCompare(bookmarkA.end,bookmarkB.end))
{return false;}}}
return true;}};function UndoManager(editor)
{this.editor=editor;this.reset();}
var editingKeyCodes={8:1,46:1},modifierKeyCodes={16:1,17:1,18:1},navigationKeyCodes={37:1,38:1,39:1,40:1};UndoManager.prototype={type:function(event)
{var keystroke=event&&event.data.getKey(),isModifierKey=keystroke in modifierKeyCodes,isEditingKey=keystroke in editingKeyCodes,wasEditingKey=this.lastKeystroke in editingKeyCodes,sameAsLastEditingKey=isEditingKey&&keystroke==this.lastKeystroke,isReset=keystroke in navigationKeyCodes,wasReset=this.lastKeystroke in navigationKeyCodes,isContent=(!isEditingKey&&!isReset),modifierSnapshot=(isEditingKey&&!sameAsLastEditingKey),startedTyping=!(isModifierKey||this.typing)||(isContent&&(wasEditingKey||wasReset));if(startedTyping||modifierSnapshot)
{var beforeTypeImage=new Image(this.editor);CKEDITOR.tools.setTimeout(function()
{var currentSnapshot=this.editor.getSnapshot();if(CKEDITOR.env.ie)
currentSnapshot=currentSnapshot.replace(/\s+_cke_expando=".*?"/g,'');if(beforeTypeImage.contents!=currentSnapshot)
{this.typing=true;if(!this.save(false,beforeTypeImage,false))
this.snapshots.splice(this.index+1,this.snapshots.length-this.index-1);this.hasUndo=true;this.hasRedo=false;this.typesCount=1;this.modifiersCount=1;this.onChange();}},0,this);}
this.lastKeystroke=keystroke;if(isEditingKey)
{this.typesCount=0;this.modifiersCount++;if(this.modifiersCount>25)
{this.save(false,null,false);this.modifiersCount=1;}}
else if(!isReset)
{this.modifiersCount=0;this.typesCount++;if(this.typesCount>25)
{this.save(false,null,false);this.typesCount=1;}}},reset:function()
{this.lastKeystroke=0;this.snapshots=[];this.index=-1;this.limit=this.editor.config.undoStackSize;this.currentImage=null;this.hasUndo=false;this.hasRedo=false;this.resetType();},resetType:function()
{this.typing=false;delete this.lastKeystroke;this.typesCount=0;this.modifiersCount=0;},fireChange:function()
{this.hasUndo=!!this.getNextImage(true);this.hasRedo=!!this.getNextImage(false);this.resetType();this.onChange();},save:function(onContentOnly,image,autoFireChange)
{var snapshots=this.snapshots;if(!image)
image=new Image(this.editor);if(image.contents===false)
return false;if(this.currentImage&&image.equals(this.currentImage,onContentOnly))
return false;snapshots.splice(this.index+1,snapshots.length-this.index-1);if(snapshots.length==this.limit)
snapshots.shift();this.index=snapshots.push(image)-1;this.currentImage=image;if(autoFireChange!==false)
this.fireChange();return true;},restoreImage:function(image)
{this.editor.loadSnapshot(image.contents);if(image.bookmarks)
this.editor.getSelection().selectBookmarks(image.bookmarks);else if(CKEDITOR.env.ie)
{var $range=this.editor.document.getBody().$.createTextRange();$range.collapse(true);$range.select();}
this.index=image.index;this.snapshots.splice(this.index,1,(this.currentImage=new Image(this.editor)));this.fireChange();},getNextImage:function(isUndo)
{var snapshots=this.snapshots,currentImage=this.currentImage,image,i;if(currentImage)
{if(isUndo)
{for(i=this.index-1;i>=0;i--)
{image=snapshots[i];if(!currentImage.equals(image,true))
{image.index=i;return image;}}}
else
{for(i=this.index+1;i<snapshots.length;i++)
{image=snapshots[i];if(!currentImage.equals(image,true))
{image.index=i;return image;}}}}
return null;},redoable:function()
{return this.enabled&&this.hasRedo;},undoable:function()
{return this.enabled&&this.hasUndo;},undo:function()
{if(this.undoable())
{this.save(true);var image=this.getNextImage(true);if(image)
return this.restoreImage(image),true;}
return false;},redo:function()
{if(this.redoable())
{this.save(true);if(this.redoable())
{var image=this.getNextImage(false);if(image)
return this.restoreImage(image),true;}}
return false;}};})();CKEDITOR.config.undoStackSize=20;(function()
{var nonExitableElementNames={table:1,pre:1};var emptyParagraphRegexp=/\s*<(p|div|address|h\d|center)[^>]*>\s*(?:<br[^>]*>|&nbsp;|\u00A0|&#160;)?\s*(:?<\/\1>)?\s*(?=$|<\/body>)/gi;function onInsertHtml(evt)
{if(this.mode=='wysiwyg')
{this.focus();this.fire('saveSnapshot');var selection=this.getSelection(),data=evt.data;if(this.dataProcessor)
data=this.dataProcessor.toHtml(data);if(CKEDITOR.env.ie)
{var selIsLocked=selection.isLocked;if(selIsLocked)
selection.unlock();var $sel=selection.getNative();if($sel.type=='Control')
$sel.clear();$sel.createRange().pasteHTML(data);if(selIsLocked)
this.getSelection().lock();}
else
this.document.$.execCommand('inserthtml',false,data);CKEDITOR.tools.setTimeout(function()
{this.fire('saveSnapshot');},0,this);}}
function onInsertElement(evt)
{if(this.mode=='wysiwyg')
{this.focus();this.fire('saveSnapshot');var element=evt.data,elementName=element.getName(),isBlock=CKEDITOR.dtd.$block[elementName];var selection=this.getSelection(),ranges=selection.getRanges();var selIsLocked=selection.isLocked;if(selIsLocked)
selection.unlock();var range,clone,lastElement,bookmark;for(var i=ranges.length-1;i>=0;i--)
{range=ranges[i];range.deleteContents();clone=!i&&element||element.clone(true);var current,dtd;if(isBlock)
{while((current=range.getCommonAncestor(false,true))&&(dtd=CKEDITOR.dtd[current.getName()])&&!(dtd&&dtd[elementName]))
{if(current.getName()in CKEDITOR.dtd.span)
range.splitElement(current);else if(range.checkStartOfBlock()&&range.checkEndOfBlock())
{range.setStartBefore(current);range.collapse(true);current.remove();}
else
range.splitBlock();}}
range.insertNode(clone);if(!lastElement)
lastElement=clone;}
range.moveToPosition(lastElement,CKEDITOR.POSITION_AFTER_END);var next=lastElement.getNextSourceNode(true);if(next&&next.type==CKEDITOR.NODE_ELEMENT)
range.moveToElementEditStart(next);selection.selectRanges([range]);if(selIsLocked)
this.getSelection().lock();CKEDITOR.tools.setTimeout(function(){this.fire('saveSnapshot');},0,this);}}
function restoreDirty(editor)
{if(!editor.checkDirty())
setTimeout(function(){editor.resetDirty();});}
var isNotWhitespace=CKEDITOR.dom.walker.whitespaces(true),isNotBookmark=CKEDITOR.dom.walker.bookmark(false,true);function isNotEmpty(node)
{return isNotWhitespace(node)&&isNotBookmark(node);}
function isNbsp(node)
{return node.type==CKEDITOR.NODE_TEXT&&CKEDITOR.tools.trim(node.getText()).match(/^(?:&nbsp;|\xa0)$/);}
function restoreSelection(selection)
{if(selection.isLocked)
{selection.unlock();setTimeout(function(){selection.lock();},0);}}
function onSelectionChangeFixBody(evt)
{var editor=evt.editor,path=evt.data.path,blockLimit=path.blockLimit,selection=evt.data.selection,range=selection.getRanges()[0],body=editor.document.getBody(),enterMode=editor.config.enterMode;if(enterMode!=CKEDITOR.ENTER_BR&&range.collapsed&&blockLimit.getName()=='body'&&!path.block)
{restoreDirty(editor);CKEDITOR.env.ie&&restoreSelection(selection);var fixedBlock=range.fixBlock(true,editor.config.enterMode==CKEDITOR.ENTER_DIV?'div':'p');if(CKEDITOR.env.ie)
{var first=fixedBlock.getFirst(isNotEmpty);first&&isNbsp(first)&&first.remove();}
if(fixedBlock.getOuterHtml().match(emptyParagraphRegexp))
{var previousElement=fixedBlock.getPrevious(isNotWhitespace),nextElement=fixedBlock.getNext(isNotWhitespace);if(previousElement&&previousElement.getName&&!(previousElement.getName()in nonExitableElementNames)&&range.moveToElementEditStart(previousElement)||nextElement&&nextElement.getName&&!(nextElement.getName()in nonExitableElementNames)&&range.moveToElementEditStart(nextElement))
{fixedBlock.remove();}}
range.select();if(!CKEDITOR.env.ie)
editor.selectionChange();}
var walkerRange=new CKEDITOR.dom.range(editor.document),walker=new CKEDITOR.dom.walker(walkerRange);walkerRange.selectNodeContents(body);walker.evaluator=function(node)
{return node.type==CKEDITOR.NODE_ELEMENT&&(node.getName()in nonExitableElementNames);};walker.guard=function(node,isMoveout)
{return!((node.type==CKEDITOR.NODE_TEXT&&isNotWhitespace(node))||isMoveout);};if(walker.previous())
{restoreDirty(editor);CKEDITOR.env.ie&&restoreSelection(selection);var paddingBlock;if(enterMode!=CKEDITOR.ENTER_BR)
paddingBlock=body.append(new CKEDITOR.dom.element(enterMode==CKEDITOR.ENTER_P?'p':'div'));else
paddingBlock=body;if(!CKEDITOR.env.ie)
paddingBlock.appendBogus();}}
CKEDITOR.plugins.add('wysiwygarea',{requires:['editingblock'],init:function(editor)
{var fixForBody=(editor.config.enterMode!=CKEDITOR.ENTER_BR)?editor.config.enterMode==CKEDITOR.ENTER_DIV?'div':'p':false;var frameLabel=editor.lang.editorTitle.replace('%1',editor.name);editor.on('editingBlockReady',function()
{var mainElement,iframe,isLoadingData,isPendingFocus,frameLoaded,fireMode;var isCustomDomain=CKEDITOR.env.isCustomDomain();var createIFrame=function(data)
{if(iframe)
iframe.remove();frameLoaded=0;var setDataFn=!CKEDITOR.env.gecko&&CKEDITOR.tools.addFunction(function(doc)
{CKEDITOR.tools.removeFunction(setDataFn);doc.write(data);});var srcScript='document.open();'+
(isCustomDomain?('document.domain="'+document.domain+'";'):'')+
(CKEDITOR.env.gecko?'':('parent.CKEDITOR.tools.callFunction('+setDataFn+',document);'))+'document.close();';iframe=CKEDITOR.dom.element.createFromHtml('<iframe'+' style="width:100%;height:100%"'+' frameBorder="0"'+' src="javascript:void(function(){'+encodeURIComponent(srcScript)+'}())"'+' tabIndex="'+editor.tabIndex+'"'+' allowTransparency="true"'+'></iframe>');CKEDITOR.env.gecko&&iframe.on('load',function(ev)
{ev.removeListener();var doc=iframe.getFrameDocument().$;doc.open();doc.write(data);doc.close();});mainElement.append(iframe);};var activationScript='<script id="cke_actscrpt" type="text/javascript" cke_temp="1">'+
(isCustomDomain?('document.domain="'+document.domain+'";'):'')+'parent.CKEDITOR._["contentDomReady'+editor.name+'"]( window );'+'</script>';var contentDomReady=function(domWindow)
{if(frameLoaded)
return;frameLoaded=1;editor.fire('ariaWidget',iframe);var domDocument=domWindow.document,body=domDocument.body;var script=domDocument.getElementById("cke_actscrpt");script.parentNode.removeChild(script);delete CKEDITOR._['contentDomReady'+editor.name];body.spellcheck=!editor.config.disableNativeSpellChecker;if(CKEDITOR.env.ie)
{body.hideFocus=true;body.disabled=true;body.contentEditable=true;body.removeAttribute('disabled');}
else
domDocument.designMode='on';try{domDocument.execCommand('enableObjectResizing',false,!editor.config.disableObjectResizing);}catch(e){}
try{domDocument.execCommand('enableInlineTableEditing',false,!editor.config.disableNativeTableHandles);}catch(e){}
domWindow=editor.window=new CKEDITOR.dom.window(domWindow);domDocument=editor.document=new CKEDITOR.dom.document(domDocument);if(!(CKEDITOR.env.ie||CKEDITOR.env.opera))
{domDocument.on('mousedown',function(ev)
{var control=ev.data.getTarget();if(control.is('img','hr','input','textarea','select'))
editor.getSelection().selectElement(control);});}
if(CKEDITOR.env.webkit)
{domDocument.on('click',function(ev)
{if(ev.data.getTarget().is('input','select'))
ev.data.preventDefault();});domDocument.on('mouseup',function(ev)
{if(ev.data.getTarget().is('input','textarea'))
ev.data.preventDefault();});}
if(CKEDITOR.env.ie&&domDocument.$.compatMode=='CSS1Compat')
{var htmlElement=domDocument.getDocumentElement();htmlElement.on('mousedown',function(evt)
{if(evt.data.getTarget().equals(htmlElement))
ieFocusGrabber.focus();});}
var focusTarget=(CKEDITOR.env.ie||CKEDITOR.env.webkit)?domWindow:domDocument;focusTarget.on('blur',function()
{editor.focusManager.blur();});focusTarget.on('focus',function()
{if(CKEDITOR.env.gecko)
{var first=body;while(first.firstChild)
first=first.firstChild;if(!first.nextSibling&&('BR'==first.tagName)&&first.hasAttribute('_moz_editor_bogus_node'))
{restoreDirty(editor);var keyEventSimulate=domDocument.$.createEvent("KeyEvents");keyEventSimulate.initKeyEvent('keypress',true,true,domWindow.$,false,false,false,false,0,32);domDocument.$.dispatchEvent(keyEventSimulate);var bogusText=domDocument.getBody().getFirst();if(editor.config.enterMode==CKEDITOR.ENTER_BR)
domDocument.createElement('br',{attributes:{'_moz_dirty':""}}).replace(bogusText);else
bogusText.remove();}}
editor.focusManager.focus();});var keystrokeHandler=editor.keystrokeHandler;if(keystrokeHandler)
keystrokeHandler.attach(domDocument);if(CKEDITOR.env.ie)
{domDocument.on('keydown',function(evt)
{var keyCode=evt.data.getKeystroke();if(keyCode in{8:1,46:1})
{var sel=editor.getSelection(),control=sel.getSelectedElement();if(control)
{editor.fire('saveSnapshot');var bookmark=sel.getRanges()[0].createBookmark();control.remove();sel.selectBookmarks([bookmark]);editor.fire('saveSnapshot');evt.data.preventDefault();}}});if(domDocument.$.compatMode=='CSS1Compat')
{var pageUpDownKeys={33:1,34:1};domDocument.on('keydown',function(evt)
{if(evt.data.getKeystroke()in pageUpDownKeys)
{setTimeout(function()
{editor.getSelection().scrollIntoView();},0);}});}}
if(editor.contextMenu)
editor.contextMenu.addTarget(domDocument,editor.config.browserContextMenuOnCtrl!==false);setTimeout(function()
{editor.fire('contentDom');if(fireMode)
{editor.mode='wysiwyg';editor.fire('mode');fireMode=false;}
isLoadingData=false;if(isPendingFocus)
{editor.focus();isPendingFocus=false;}
setTimeout(function()
{editor.fire('dataReady');},0);if(CKEDITOR.env.ie)
{setTimeout(function()
{if(editor.document)
{var $body=editor.document.$.body;$body.runtimeStyle.marginBottom='0px';$body.runtimeStyle.marginBottom='';}},1000);}},0);};editor.addMode('wysiwyg',{load:function(holderElement,data,isSnapshot)
{mainElement=holderElement;if(CKEDITOR.env.ie&&CKEDITOR.env.quirks)
holderElement.setStyle('position','relative');editor.mayBeDirty=true;fireMode=true;if(isSnapshot)
this.loadSnapshotData(data);else
this.loadData(data);},loadData:function(data)
{isLoadingData=true;var config=editor.config,fullPage=config.fullPage,docType=config.docType;var headExtra='<style type="text/css" cke_temp="1">'+
editor._.styles.join('\n')+'</style>';!fullPage&&(headExtra=CKEDITOR.tools.buildStyleHtml(editor.config.contentsCss)+
headExtra);var baseTag=config.baseHref?'<base href="'+config.baseHref+'" cke_temp="1" />':'';if(fullPage)
{data=data.replace(/<!DOCTYPE[^>]*>/i,function(match)
{editor.docType=docType=match;return'';});}
if(editor.dataProcessor)
data=editor.dataProcessor.toHtml(data,fixForBody);if(fullPage)
{if(!(/<body[\s|>]/).test(data))
data='<body>'+data;if(!(/<html[\s|>]/).test(data))
data='<html>'+data+'</html>';if(!(/<head[\s|>]/).test(data))
data=data.replace(/<html[^>]*>/,'$&<head><title></title></head>');baseTag&&(data=data.replace(/<head>/,'$&'+baseTag));data=data.replace(/<\/head\s*>/,headExtra+'$&');data=docType+data;}
else
{data=config.docType+'<html dir="'+config.contentsLangDirection+'">'+'<title>'+frameLabel+'</title>'+'<head>'+
baseTag+
headExtra+'</head>'+'<body'+(config.bodyId?' id="'+config.bodyId+'"':'')+
(config.bodyClass?' class="'+config.bodyClass+'"':'')+'>'+
data+'</html>';}
data+=activationScript;CKEDITOR._['contentDomReady'+editor.name]=contentDomReady;this.onDispose();createIFrame(data);},getData:function()
{var config=editor.config,fullPage=config.fullPage,docType=fullPage&&editor.docType,doc=iframe.getFrameDocument();var data=fullPage?doc.getDocumentElement().getOuterHtml():doc.getBody().getHtml();if(editor.dataProcessor)
data=editor.dataProcessor.toDataFormat(data,fixForBody);if(config.ignoreEmptyParagraph)
data=data.replace(emptyParagraphRegexp,'');if(docType)
data=docType+'\n'+data;return data;},getSnapshotData:function()
{return iframe.getFrameDocument().getBody().getHtml();},loadSnapshotData:function(data)
{iframe.getFrameDocument().getBody().setHtml(data);},onDispose:function()
{if(!editor.document)
return;editor.document.getDocumentElement().clearCustomData();editor.document.getBody().clearCustomData();editor.window.clearCustomData();editor.document.clearCustomData();iframe.clearCustomData();},unload:function(holderElement)
{this.onDispose();editor.window=editor.document=iframe=mainElement=isPendingFocus=null;editor.fire('contentDomUnload');},focus:function()
{if(isLoadingData)
isPendingFocus=true;else if(editor.window)
{editor.window.focus();editor.selectionChange();}}});editor.on('insertHtml',onInsertHtml,null,null,20);editor.on('insertElement',onInsertElement,null,null,20);editor.on('selectionChange',onSelectionChangeFixBody,null,null,1);});var titleBackup;editor.on('contentDom',function()
{var title=editor.document.getElementsByTag('title').getItem(0);title.setAttribute('_cke_title',editor.document.$.title);editor.document.$.title=frameLabel;});if(CKEDITOR.env.ie)
{var ieFocusGrabber;editor.on('uiReady',function()
{ieFocusGrabber=editor.container.append(CKEDITOR.dom.element.createFromHtml('<span tabindex="-1" style="position:absolute; left:-10000" role="presentation"></span>'));ieFocusGrabber.on('focus',function()
{editor.focus();});});editor.on('destroy',function()
{ieFocusGrabber.clearCustomData();});}}});if(CKEDITOR.env.gecko)
{(function()
{var body=document.body;if(!body)
window.addEventListener('load',arguments.callee,false);else
{body.setAttribute('onpageshow',body.getAttribute('onpageshow')
+';event.persisted && CKEDITOR.tools.callFunction('+
CKEDITOR.tools.addFunction(function()
{var allInstances=CKEDITOR.instances,editor,doc;for(var i in allInstances)
{editor=allInstances[i];doc=editor.document;if(doc)
{doc.$.designMode='off';doc.$.designMode='on';}}})+')');}})();}})();CKEDITOR.config.disableObjectResizing=false;CKEDITOR.config.disableNativeTableHandles=true;CKEDITOR.config.disableNativeSpellChecker=true;CKEDITOR.config.ignoreEmptyParagraph=true;CKEDITOR.DIALOG_RESIZE_NONE=0;CKEDITOR.DIALOG_RESIZE_WIDTH=1;CKEDITOR.DIALOG_RESIZE_HEIGHT=2;CKEDITOR.DIALOG_RESIZE_BOTH=3;(function()
{function isTabVisible(tabId)
{return!!this._.tabs[tabId][0].$.offsetHeight;}
function getPreviousVisibleTab()
{var tabId=this._.currentTabId,length=this._.tabIdList.length,tabIndex=CKEDITOR.tools.indexOf(this._.tabIdList,tabId)+length;for(var i=tabIndex-1;i>tabIndex-length;i--)
{if(isTabVisible.call(this,this._.tabIdList[i%length]))
return this._.tabIdList[i%length];}
return null;}
function getNextVisibleTab()
{var tabId=this._.currentTabId,length=this._.tabIdList.length,tabIndex=CKEDITOR.tools.indexOf(this._.tabIdList,tabId);for(var i=tabIndex+1;i<tabIndex+length;i++)
{if(isTabVisible.call(this,this._.tabIdList[i%length]))
return this._.tabIdList[i%length];}
return null;}
CKEDITOR.dialog=function(editor,dialogName)
{var definition=CKEDITOR.dialog._.dialogDefinitions[dialogName];definition=CKEDITOR.tools.extend(definition(editor),defaultDialogDefinition);definition=CKEDITOR.tools.clone(definition);definition=new definitionObject(this,definition);var doc=CKEDITOR.document;var themeBuilt=editor.theme.buildDialog(editor);this._={editor:editor,element:themeBuilt.element,name:dialogName,contentSize:{width:0,height:0},size:{width:0,height:0},updateSize:false,contents:{},buttons:{},accessKeyMap:{},tabs:{},tabIdList:[],currentTabId:null,currentTabIndex:null,pageCount:0,lastTab:null,tabBarMode:false,focusList:[],currentFocusIndex:0,hasFocus:false};this.parts=themeBuilt.parts;CKEDITOR.tools.setTimeout(function()
{editor.fire('ariaWidget',this.parts.contents);},0,this);this.parts.dialog.setStyles({position:CKEDITOR.env.ie6Compat?'absolute':'fixed',top:0,left:0,visibility:'hidden'});CKEDITOR.event.call(this);this.definition=definition=CKEDITOR.fire('dialogDefinition',{name:dialogName,definition:definition},editor).definition;if(definition.onLoad)
this.on('load',definition.onLoad);if(definition.onShow)
this.on('show',definition.onShow);if(definition.onHide)
this.on('hide',definition.onHide);if(definition.onOk)
{this.on('ok',function(evt)
{if(definition.onOk.call(this,evt)===false)
evt.data.hide=false;});}
if(definition.onCancel)
{this.on('cancel',function(evt)
{if(definition.onCancel.call(this,evt)===false)
evt.data.hide=false;});}
var me=this;var iterContents=function(func)
{var contents=me._.contents,stop=false;for(var i in contents)
{for(var j in contents[i])
{stop=func.call(this,contents[i][j]);if(stop)
return;}}};this.on('ok',function(evt)
{iterContents(function(item)
{if(item.validate)
{var isValid=item.validate(this);if(typeof isValid=='string')
{var editor=this.getDialog()._.editor;RTE.tools.alert(editor.lang.errorPopupTitle,isValid);isValid=false;}
if(isValid===false)
{var dialog=item.getDialog();dialog.fire('notvalid',{item:item});if(item.select)
item.select();else
item.focus();evt.data.hide=false;evt.stop();return true;}}});},this,null,0);this.on('cancel',function(evt)
{iterContents(function(item)
{if(item.isChanged())
{if(!confirm(editor.lang.common.confirmCancel))
evt.data.hide=false;return true;}});},this,null,0);this.parts.close.on('click',function(evt)
{this.fire('close',{close:true});if(this.fire('cancel',{hide:true}).hide!==false)
this.hide();},this);function setupFocus()
{var focusList=me._.focusList;focusList.sort(function(a,b)
{if(a.tabIndex!=b.tabIndex)
return b.tabIndex-a.tabIndex;else
return a.focusIndex-b.focusIndex;});var size=focusList.length;for(var i=0;i<size;i++)
focusList[i].focusIndex=i;}
function changeFocus(forward)
{var focusList=me._.focusList,offset=forward?1:-1;if(focusList.length<1)
return;var current=me._.currentFocusIndex;try
{focusList[current].getInputElement().$.blur();}
catch(e){}
var startIndex=(current+offset+focusList.length)%focusList.length,currentIndex=startIndex;while(!focusList[currentIndex].isFocusable())
{currentIndex=(currentIndex+offset+focusList.length)%focusList.length;if(currentIndex==startIndex)
break;}
focusList[currentIndex].focus();if(focusList[currentIndex].type=='text')
focusList[currentIndex].select();}
this.changeFocus=changeFocus;var processed;function focusKeydownHandler(evt)
{if(me!=CKEDITOR.dialog._.currentTop)
return;var keystroke=evt.data.getKeystroke();processed=0;if(keystroke==9||keystroke==CKEDITOR.SHIFT+9)
{var shiftPressed=(keystroke==CKEDITOR.SHIFT+9);if(me._.tabBarMode)
{var nextId=shiftPressed?getPreviousVisibleTab.call(me):getNextVisibleTab.call(me);me.selectPage(nextId);me._.tabs[nextId][0].focus();}
else
{changeFocus(!shiftPressed);}
processed=1;}
else if(keystroke==CKEDITOR.ALT+121&&!me._.tabBarMode&&me.getPageCount()>1)
{me._.tabBarMode=true;me._.tabs[me._.currentTabId][0].focus();processed=1;}
else if((keystroke==37||keystroke==39)&&me._.tabBarMode)
{nextId=(keystroke==37?getPreviousVisibleTab.call(me):getNextVisibleTab.call(me));me.selectPage(nextId);me._.tabs[nextId][0].focus();processed=1;}
else if((keystroke==13||keystroke==32)&&me._.tabBarMode)
{this.selectPage(this._.currentTabId);this._.tabBarMode=false;this._.currentFocusIndex=-1;changeFocus(true);processed=1;}
if(processed)
{evt.stop();evt.data.preventDefault();}}
function focusKeyPressHandler(evt)
{processed&&evt.data.preventDefault();}
var dialogElement=this._.element;this.on('show',function()
{dialogElement.on('keydown',focusKeydownHandler,this,null,0);if(CKEDITOR.env.opera||(CKEDITOR.env.gecko&&CKEDITOR.env.mac))
dialogElement.on('keypress',focusKeyPressHandler,this);if(CKEDITOR.env.ie6Compat)
{var coverDoc=coverElement.getChild(0).getFrameDocument();coverDoc.on('keydown',focusKeydownHandler,this,null,0);}});this.on('hide',function()
{dialogElement.removeListener('keydown',focusKeydownHandler);if(CKEDITOR.env.opera||(CKEDITOR.env.gecko&&CKEDITOR.env.mac))
dialogElement.removeListener('keypress',focusKeyPressHandler);});this.on('iframeAdded',function(evt)
{var doc=new CKEDITOR.dom.document(evt.data.iframe.$.contentWindow.document);doc.on('keydown',focusKeydownHandler,this,null,0);});this.on('show',function()
{setupFocus();if(editor.config.dialog_startupFocusTab&&me._.tabIdList.length>1)
{me._.tabBarMode=true;me._.tabs[me._.currentTabId][0].focus();}
else if(!this._.hasFocus)
{this._.currentFocusIndex=-1;if(definition.onFocus)
{var initialFocus=definition.onFocus.call(this);initialFocus&&initialFocus.focus();}
else
changeFocus(true);if(this._.editor.mode=='wysiwyg'&&CKEDITOR.env.ie)
{var $selection=editor.document.$.selection,$range=$selection.createRange();if($range)
{if($range.parentElement&&$range.parentElement().ownerDocument==editor.document.$||$range.item&&$range.item(0).ownerDocument==editor.document.$)
{var $myRange=document.body.createTextRange();$myRange.moveToElementText(this.getElement().getFirst().$);$myRange.collapse(true);$myRange.select();}}}}},this,null,0xffffffff);if(CKEDITOR.env.ie6Compat)
{this.on('load',function(evt)
{var outer=this.getElement(),inner=outer.getFirst();inner.remove();inner.appendTo(outer);},this);}
initDragAndDrop(this);initResizeHandles(this);(new CKEDITOR.dom.text(definition.title,CKEDITOR.document)).appendTo(this.parts.title);for(var i=0;i<definition.contents.length;i++)
this.addPage(definition.contents[i]);this.parts['tabs'].on('click',function(evt)
{var target=evt.data.getTarget();if(target.hasClass('cke_dialog_tab'))
{var id=target.$.id;this.selectPage(id.substr(0,id.lastIndexOf('_')));if(this._.tabBarMode)
{this._.tabBarMode=false;this._.currentFocusIndex=-1;changeFocus(true);}
evt.data.preventDefault();}},this);var buttonsHtml=[],buttons=CKEDITOR.dialog._.uiElementBuilders.hbox.build(this,{type:'hbox',className:'cke_dialog_footer_buttons',widths:[],children:definition.buttons},buttonsHtml).getChild();this.parts.footer.setHtml(buttonsHtml.join(''));for(i=0;i<buttons.length;i++)
this._.buttons[buttons[i].id]=buttons[i];};function Focusable(dialog,element,index)
{this.element=element;this.focusIndex=index;this.tabIndex=0;this.isFocusable=function()
{return!element.getAttribute('disabled')&&element.isVisible();};this.focus=function()
{dialog._.currentFocusIndex=this.focusIndex;this.element.focus();};element.on('keydown',function(e)
{if(e.data.getKeystroke()in{32:1,13:1})
this.fire('click');});element.on('focus',function()
{this.fire('mouseover');});element.on('blur',function()
{this.fire('mouseout');});}
CKEDITOR.dialog.prototype={resize:(function()
{return function(width,height)
{if(this._.contentSize&&this._.contentSize.width==width&&this._.contentSize.height==height)
return;CKEDITOR.dialog.fire('resize',{dialog:this,skin:this._.editor.skinName,width:width,height:height},this._.editor);this._.contentSize={width:width,height:height};this._.updateSize=true;};})(),getSize:function()
{if(!this._.updateSize)
return this._.size;var element=this._.element.getFirst();var size=this._.size={width:element.$.offsetWidth||0,height:element.$.offsetHeight||0};this._.updateSize=!size.width||!size.height;return size;},move:(function()
{var isFixed;return function(x,y)
{var element=this._.element.getFirst();if(isFixed===undefined)
isFixed=element.getComputedStyle('position')=='fixed';if(isFixed&&this._.position&&this._.position.x==x&&this._.position.y==y)
return;this._.position={x:x,y:y};if(!isFixed)
{var scrollPosition=CKEDITOR.document.getWindow().getScrollPosition();x+=scrollPosition.x;y+=scrollPosition.y;}
element.setStyles({'left':(x>0?x:0)+'px','top':(y>0?y:0)+'px'});};})(),getPosition:function(){return CKEDITOR.tools.extend({},this._.position);},show:function()
{var editor=this._.editor;if(editor.mode=='wysiwyg'&&CKEDITOR.env.ie)
{var selection=editor.getSelection();selection&&selection.lock();}
var element=this._.element;var definition=this.definition;if(!(element.getParent()&&element.getParent().equals(CKEDITOR.document.getBody())))
element.appendTo(CKEDITOR.document.getBody());else
return;if(CKEDITOR.env.gecko&&CKEDITOR.env.version<10900)
{var dialogElement=this.parts.dialog;dialogElement.setStyle('position','absolute');setTimeout(function()
{dialogElement.setStyle('position','fixed');},0);}
this.resize(definition.minWidth,definition.minHeight);this.selectPage(this.definition.contents[0].id);this.reset();if(CKEDITOR.dialog._.currentZIndex===null)
CKEDITOR.dialog._.currentZIndex=this._.editor.config.baseFloatZIndex;this._.element.getFirst().setStyle('z-index',CKEDITOR.dialog._.currentZIndex+=10);if(CKEDITOR.dialog._.currentTop===null)
{CKEDITOR.dialog._.currentTop=this;this._.parentDialog=null;addCover(this._.editor);element.on('keydown',accessKeyDownHandler);element.on(CKEDITOR.env.opera?'keypress':'keyup',accessKeyUpHandler);for(var event in{keyup:1,keydown:1,keypress:1})
element.on(event,preventKeyBubbling);}
else
{this._.parentDialog=CKEDITOR.dialog._.currentTop;var parentElement=this._.parentDialog.getElement().getFirst();parentElement.$.style.zIndex-=Math.floor(this._.editor.config.baseFloatZIndex/2);CKEDITOR.dialog._.currentTop=this;}
registerAccessKey(this,this,'\x1b',null,function()
{this.fireOnce('close',{esc:true});this.getButton('cancel')&&this.getButton('cancel').click();});this._.hasFocus=false;CKEDITOR.tools.setTimeout(function()
{var viewSize=CKEDITOR.document.getWindow().getViewPaneSize();var dialogSize=this.getSize();this.move((viewSize.width-definition.minWidth)/2,(viewSize.height-dialogSize.height)/2);this.parts.dialog.setStyle('visibility','');this.fireOnce('load',{});this.fire('show',{});this._.editor.fire('dialogShow',this);this.foreach(function(contentObj){contentObj.setInitValue&&contentObj.setInitValue();});},100,this);},foreach:function(fn)
{for(var i in this._.contents)
{for(var j in this._.contents[i])
fn(this._.contents[i][j]);}
return this;},reset:(function()
{var fn=function(widget){if(widget.reset)widget.reset();};return function(){this.foreach(fn);return this;};})(),setupContent:function()
{var args=arguments;this.foreach(function(widget)
{if(widget.setup)
widget.setup.apply(widget,args);});},commitContent:function()
{var args=arguments;this.foreach(function(widget)
{if(widget.commit)
widget.commit.apply(widget,args);});},hide:function()
{this.fire('hide',{});this._.editor.fire('dialogHide',this);var element=this._.element;if(!element.getParent())
return;element.remove();this.parts.dialog.setStyle('visibility','hidden');unregisterAccessKey(this);if(!this._.parentDialog)
removeCover();else
{var parentElement=this._.parentDialog.getElement().getFirst();parentElement.setStyle('z-index',parseInt(parentElement.$.style.zIndex,10)+Math.floor(this._.editor.config.baseFloatZIndex/2));}
CKEDITOR.dialog._.currentTop=this._.parentDialog;if(!this._.parentDialog)
{CKEDITOR.dialog._.currentZIndex=null;element.removeListener('keydown',accessKeyDownHandler);element.removeListener(CKEDITOR.env.opera?'keypress':'keyup',accessKeyUpHandler);for(var event in{keyup:1,keydown:1,keypress:1})
element.removeListener(event,preventKeyBubbling);var editor=this._.editor;editor.focus();if(editor.mode=='wysiwyg'&&CKEDITOR.env.ie)
{var selection=editor.getSelection();selection&&selection.unlock(true);}}
else
CKEDITOR.dialog._.currentZIndex-=10;this.foreach(function(contentObj){contentObj.resetInitValue&&contentObj.resetInitValue();});},addPage:function(contents)
{var pageHtml=[],titleHtml=contents.label?' title="'+CKEDITOR.tools.htmlEncode(contents.label)+'"':'',elements=contents.elements,vbox=CKEDITOR.dialog._.uiElementBuilders.vbox.build(this,{type:'vbox',className:'cke_dialog_page_contents',children:contents.elements,expand:!!contents.expand,padding:contents.padding,style:contents.style||'width: 100%; height: 100%;'},pageHtml);var page=CKEDITOR.dom.element.createFromHtml(pageHtml.join(''));page.setAttribute('role','tabpanel');var env=CKEDITOR.env;var tabId=contents.id+'_'+CKEDITOR.tools.getNextNumber(),tab=CKEDITOR.dom.element.createFromHtml(['<a class="cke_dialog_tab"',(this._.pageCount>0?' cke_last':'cke_first'),titleHtml,(!!contents.hidden?' style="display:none"':''),' id="',tabId,'"',env.gecko&&env.version>=10900&&!env.hc?'':' href="javascript:void(0)"',' tabIndex="-1"',' hidefocus="true"',' role="tab">',contents.label,'</a>'].join(''));page.setAttribute('aria-labelledby',tabId);this._.tabs[contents.id]=[tab,page];this._.tabIdList.push(contents.id);!contents.hidden&&this._.pageCount++;this._.lastTab=tab;this.updateStyle();var contentMap=this._.contents[contents.id]={},cursor,children=vbox.getChild();while((cursor=children.shift()))
{contentMap[cursor.id]=cursor;if(typeof(cursor.getChild)=='function')
children.push.apply(children,cursor.getChild());}
page.setAttribute('name',contents.id);page.appendTo(this.parts.contents);tab.unselectable();this.parts.tabs.append(tab);if(contents.accessKey)
{registerAccessKey(this,this,'CTRL+'+contents.accessKey,tabAccessKeyDown,tabAccessKeyUp);this._.accessKeyMap['CTRL+'+contents.accessKey]=contents.id;}},selectPage:function(id)
{for(var i in this._.tabs)
{var tab=this._.tabs[i][0],page=this._.tabs[i][1];if(i!=id)
{tab.removeClass('cke_dialog_tab_selected');page.hide();}
page.setAttribute('aria-hidden',i!=id);}
var selected=this._.tabs[id];selected[0].addClass('cke_dialog_tab_selected');selected[1].show();this._.currentTabId=id;this._.currentTabIndex=CKEDITOR.tools.indexOf(this._.tabIdList,id);},updateStyle:function()
{this.parts.dialog[(this._.pageCount===1?'add':'remove')+'Class']('cke_single_page');},hidePage:function(id)
{var tab=this._.tabs[id]&&this._.tabs[id][0];if(!tab||this._.pageCount==1)
return;else if(id==this._.currentTabId)
this.selectPage(getPreviousVisibleTab.call(this));tab.hide();this._.pageCount--;this.updateStyle();},showPage:function(id)
{var tab=this._.tabs[id]&&this._.tabs[id][0];if(!tab)
return;tab.show();this._.pageCount++;this.updateStyle();},getElement:function()
{return this._.element;},getName:function()
{return this._.name;},getContentElement:function(pageId,elementId)
{var page=this._.contents[pageId];return page&&page[elementId];},getValueOf:function(pageId,elementId)
{return this.getContentElement(pageId,elementId).getValue();},setValueOf:function(pageId,elementId,value)
{return this.getContentElement(pageId,elementId).setValue(value);},getButton:function(id)
{return this._.buttons[id];},click:function(id)
{return this._.buttons[id].click();},disableButton:function(id)
{return this._.buttons[id].disable();},enableButton:function(id)
{return this._.buttons[id].enable();},getPageCount:function()
{return this._.pageCount;},getParentEditor:function()
{return this._.editor;},getSelectedElement:function()
{return this.getParentEditor().getSelection().getSelectedElement();},addFocusable:function(element,index){if(typeof index=='undefined')
{index=this._.focusList.length;this._.focusList.push(new Focusable(this,element,index));}
else
{this._.focusList.splice(index,0,new Focusable(this,element,index));for(var i=index+1;i<this._.focusList.length;i++)
this._.focusList[i].focusIndex++;}}};CKEDITOR.tools.extend(CKEDITOR.dialog,{add:function(name,dialogDefinition)
{if(!this._.dialogDefinitions[name]||typeof dialogDefinition=='function')
this._.dialogDefinitions[name]=dialogDefinition;},exists:function(name)
{return!!this._.dialogDefinitions[name];},getCurrent:function()
{return CKEDITOR.dialog._.currentTop;},okButton:(function()
{var retval=function(editor,override)
{override=override||{};return CKEDITOR.tools.extend({id:'ok',type:'button',label:editor.lang.common.ok,'class':'cke_dialog_ui_button_ok',onClick:function(evt)
{var dialog=evt.data.dialog;if(dialog.fire('ok',{hide:true}).hide!==false)
dialog.hide();}},override,true);};retval.type='button';retval.override=function(override)
{return CKEDITOR.tools.extend(function(editor){return retval(editor,override);},{type:'button'},true);};return retval;})(),cancelButton:(function()
{var retval=function(editor,override)
{override=override||{};return CKEDITOR.tools.extend({id:'cancel',type:'button',label:editor.lang.common.cancel,'class':'cke_dialog_ui_button_cancel',onClick:function(evt)
{var dialog=evt.data.dialog;dialog.fireOnce('cancelClicked');if(dialog.fire('cancel',{hide:true}).hide!==false)
dialog.hide();}},override,true);};retval.type='button';retval.override=function(override)
{return CKEDITOR.tools.extend(function(editor){return retval(editor,override);},{type:'button'},true);};return retval;})(),addUIElement:function(typeName,builder)
{this._.uiElementBuilders[typeName]=builder;}});CKEDITOR.dialog._={uiElementBuilders:{},dialogDefinitions:{},currentTop:null,currentZIndex:null};CKEDITOR.event.implementOn(CKEDITOR.dialog);CKEDITOR.event.implementOn(CKEDITOR.dialog.prototype,true);var defaultDialogDefinition={resizable:CKEDITOR.DIALOG_RESIZE_BOTH,minWidth:600,minHeight:400,buttons:[CKEDITOR.dialog.cancelButton,CKEDITOR.dialog.okButton]};CKEDITOR.env.mac&&defaultDialogDefinition.buttons.reverse();var getById=function(array,id,recurse)
{for(var i=0,item;(item=array[i]);i++)
{if(item.id==id)
return item;if(recurse&&item[recurse])
{var retval=getById(item[recurse],id,recurse);if(retval)
return retval;}}
return null;};var addById=function(array,newItem,nextSiblingId,recurse,nullIfNotFound)
{if(nextSiblingId)
{for(var i=0,item;(item=array[i]);i++)
{if(item.id==nextSiblingId)
{array.splice(i,0,newItem);return newItem;}
if(recurse&&item[recurse])
{var retval=addById(item[recurse],newItem,nextSiblingId,recurse,true);if(retval)
return retval;}}
if(nullIfNotFound)
return null;}
array.push(newItem);return newItem;};var removeById=function(array,id,recurse)
{for(var i=0,item;(item=array[i]);i++)
{if(item.id==id)
return array.splice(i,1);if(recurse&&item[recurse])
{var retval=removeById(item[recurse],id,recurse);if(retval)
return retval;}}
return null;};var definitionObject=function(dialog,dialogDefinition)
{this.dialog=dialog;var contents=dialogDefinition.contents;for(var i=0,content;(content=contents[i]);i++)
contents[i]=new contentObject(dialog,content);CKEDITOR.tools.extend(this,dialogDefinition);};definitionObject.prototype={getContents:function(id)
{return getById(this.contents,id);},getButton:function(id)
{return getById(this.buttons,id);},addContents:function(contentDefinition,nextSiblingId)
{return addById(this.contents,contentDefinition,nextSiblingId);},addButton:function(buttonDefinition,nextSiblingId)
{return addById(this.buttons,buttonDefinition,nextSiblingId);},removeContents:function(id)
{removeById(this.contents,id);},removeButton:function(id)
{removeById(this.buttons,id);}};function contentObject(dialog,contentDefinition)
{this._={dialog:dialog};CKEDITOR.tools.extend(this,contentDefinition);}
contentObject.prototype={get:function(id)
{return getById(this.elements,id,'children');},add:function(elementDefinition,nextSiblingId)
{return addById(this.elements,elementDefinition,nextSiblingId,'children');},remove:function(id)
{removeById(this.elements,id,'children');}};function initDragAndDrop(dialog)
{var lastCoords=null,abstractDialogCoords=null,element=dialog.getElement().getFirst(),editor=dialog.getParentEditor(),magnetDistance=editor.config.dialog_magnetDistance,margins=editor.skin.margins||[0,0,0,0];if(typeof magnetDistance=='undefined')
magnetDistance=20;function mouseMoveHandler(evt)
{var dialogSize=dialog.getSize(),viewPaneSize=CKEDITOR.document.getWindow().getViewPaneSize(),x=evt.data.$.screenX,y=evt.data.$.screenY,dx=x-lastCoords.x,dy=y-lastCoords.y,realX,realY;lastCoords={x:x,y:y};abstractDialogCoords.x+=dx;abstractDialogCoords.y+=dy;if(abstractDialogCoords.x+margins[3]<magnetDistance)
realX=-margins[3];else if(abstractDialogCoords.x-margins[1]>viewPaneSize.width-dialogSize.width-magnetDistance)
realX=viewPaneSize.width-dialogSize.width+margins[1];else
realX=abstractDialogCoords.x;if(abstractDialogCoords.y+margins[0]<magnetDistance)
realY=-margins[0];else if(abstractDialogCoords.y-margins[2]>viewPaneSize.height-dialogSize.height-magnetDistance)
realY=viewPaneSize.height-dialogSize.height+margins[2];else
realY=abstractDialogCoords.y;dialog.move(realX,realY);evt.data.preventDefault();}
function mouseUpHandler(evt)
{CKEDITOR.document.removeListener('mousemove',mouseMoveHandler);CKEDITOR.document.removeListener('mouseup',mouseUpHandler);if(CKEDITOR.env.ie6Compat)
{var coverDoc=coverElement.getChild(0).getFrameDocument();coverDoc.removeListener('mousemove',mouseMoveHandler);coverDoc.removeListener('mouseup',mouseUpHandler);}}
dialog.parts.title.on('mousedown',function(evt)
{dialog._.updateSize=true;lastCoords={x:evt.data.$.screenX,y:evt.data.$.screenY};CKEDITOR.document.on('mousemove',mouseMoveHandler);CKEDITOR.document.on('mouseup',mouseUpHandler);abstractDialogCoords=dialog.getPosition();if(CKEDITOR.env.ie6Compat)
{var coverDoc=coverElement.getChild(0).getFrameDocument();coverDoc.on('mousemove',mouseMoveHandler);coverDoc.on('mouseup',mouseUpHandler);}
evt.data.preventDefault();},dialog);}
function initResizeHandles(dialog)
{var definition=dialog.definition,minWidth=definition.minWidth||0,minHeight=definition.minHeight||0,resizable=definition.resizable,margins=dialog.getParentEditor().skin.margins||[0,0,0,0];function topSizer(coords,dy)
{coords.y+=dy;}
function rightSizer(coords,dx)
{coords.x2+=dx;}
function bottomSizer(coords,dy)
{coords.y2+=dy;}
function leftSizer(coords,dx)
{coords.x+=dx;}
var lastCoords=null,abstractDialogCoords=null,magnetDistance=dialog._.editor.config.magnetDistance,parts=['tl','t','tr','l','r','bl','b','br'];function mouseDownHandler(evt)
{var partName=evt.listenerData.part,size=dialog.getSize();abstractDialogCoords=dialog.getPosition();CKEDITOR.tools.extend(abstractDialogCoords,{x2:abstractDialogCoords.x+size.width,y2:abstractDialogCoords.y+size.height});lastCoords={x:evt.data.$.screenX,y:evt.data.$.screenY};CKEDITOR.document.on('mousemove',mouseMoveHandler,dialog,{part:partName});CKEDITOR.document.on('mouseup',mouseUpHandler,dialog,{part:partName});if(CKEDITOR.env.ie6Compat)
{var coverDoc=coverElement.getChild(0).getFrameDocument();coverDoc.on('mousemove',mouseMoveHandler,dialog,{part:partName});coverDoc.on('mouseup',mouseUpHandler,dialog,{part:partName});}
evt.data.preventDefault();}
function mouseMoveHandler(evt)
{var x=evt.data.$.screenX,y=evt.data.$.screenY,dx=x-lastCoords.x,dy=y-lastCoords.y,viewPaneSize=CKEDITOR.document.getWindow().getViewPaneSize(),partName=evt.listenerData.part;if(partName.search('t')!=-1)
topSizer(abstractDialogCoords,dy);if(partName.search('l')!=-1)
leftSizer(abstractDialogCoords,dx);if(partName.search('b')!=-1)
bottomSizer(abstractDialogCoords,dy);if(partName.search('r')!=-1)
rightSizer(abstractDialogCoords,dx);lastCoords={x:x,y:y};var realX,realY,realX2,realY2;if(abstractDialogCoords.x+margins[3]<magnetDistance)
realX=-margins[3];else if(partName.search('l')!=-1&&abstractDialogCoords.x2-abstractDialogCoords.x<minWidth+magnetDistance)
realX=abstractDialogCoords.x2-minWidth;else
realX=abstractDialogCoords.x;if(abstractDialogCoords.y+margins[0]<magnetDistance)
realY=-margins[0];else if(partName.search('t')!=-1&&abstractDialogCoords.y2-abstractDialogCoords.y<minHeight+magnetDistance)
realY=abstractDialogCoords.y2-minHeight;else
realY=abstractDialogCoords.y;if(abstractDialogCoords.x2-margins[1]>viewPaneSize.width-magnetDistance)
realX2=viewPaneSize.width+margins[1];else if(partName.search('r')!=-1&&abstractDialogCoords.x2-abstractDialogCoords.x<minWidth+magnetDistance)
realX2=abstractDialogCoords.x+minWidth;else
realX2=abstractDialogCoords.x2;if(abstractDialogCoords.y2-margins[2]>viewPaneSize.height-magnetDistance)
realY2=viewPaneSize.height+margins[2];else if(partName.search('b')!=-1&&abstractDialogCoords.y2-abstractDialogCoords.y<minHeight+magnetDistance)
realY2=abstractDialogCoords.y+minHeight;else
realY2=abstractDialogCoords.y2;dialog.move(realX,realY);dialog.resize(realX2-realX,realY2-realY);evt.data.preventDefault();}
function mouseUpHandler(evt)
{CKEDITOR.document.removeListener('mouseup',mouseUpHandler);CKEDITOR.document.removeListener('mousemove',mouseMoveHandler);if(CKEDITOR.env.ie6Compat)
{var coverDoc=coverElement.getChild(0).getFrameDocument();coverDoc.removeListener('mouseup',mouseUpHandler);coverDoc.removeListener('mousemove',mouseMoveHandler);}}}
var resizeCover;var coverElement;var addCover=function(editor)
{var win=CKEDITOR.document.getWindow();if(!coverElement)
{var backgroundColorStyle=editor.config.dialog_backgroundCoverColor||'white';var html=['<div style="position: ',(CKEDITOR.env.ie6Compat?'absolute':'fixed'),'; z-index: ',editor.config.baseFloatZIndex,'; top: 0px; left: 0px; ',(!CKEDITOR.env.ie6Compat?'background-color: '+backgroundColorStyle:''),'" id="cke_dialog_background_cover">'];if(CKEDITOR.env.ie6Compat)
{var isCustomDomain=CKEDITOR.env.isCustomDomain(),iframeHtml='<html><body style=\\\'background-color:'+backgroundColorStyle+';\\\'></body></html>';html.push('<iframe'+' hidefocus="true"'+' frameborder="0"'+' id="cke_dialog_background_iframe"'+' src="javascript:');html.push('void((function(){'+'document.open();'+
(isCustomDomain?'document.domain=\''+document.domain+'\';':'')+'document.write( \''+iframeHtml+'\' );'+'document.close();'+'})())');html.push('"'+' style="'+'position:absolute;'+'left:0;'+'top:0;'+'width:100%;'+'height: 100%;'+'progid:DXImageTransform.Microsoft.Alpha(opacity=0)">'+'</iframe>');}
html.push('</div>');coverElement=CKEDITOR.dom.element.createFromHtml(html.join(''));}
var element=coverElement;var resizeFunc=function()
{var size=win.getViewPaneSize();element.setStyles({width:size.width+'px',height:size.height+'px'});};var scrollFunc=function()
{var pos=win.getScrollPosition(),cursor=CKEDITOR.dialog._.currentTop;element.setStyles({left:pos.x+'px',top:pos.y+'px'});do
{var dialogPos=cursor.getPosition();cursor.move(dialogPos.x,dialogPos.y);}while((cursor=cursor._.parentDialog));};resizeCover=resizeFunc;win.on('resize',resizeFunc);resizeFunc();if(CKEDITOR.env.ie6Compat)
{var myScrollHandler=function()
{scrollFunc();arguments.callee.prevScrollHandler.apply(this,arguments);};win.$.setTimeout(function()
{myScrollHandler.prevScrollHandler=window.onscroll||function(){};window.onscroll=myScrollHandler;},0);scrollFunc();}
var opacity=editor.config.dialog_backgroundCoverOpacity;element.setOpacity(typeof opacity!='undefined'?opacity:0.5);element.appendTo(CKEDITOR.document.getBody());};var removeCover=function()
{if(!coverElement)
return;var win=CKEDITOR.document.getWindow();coverElement.remove();win.removeListener('resize',resizeCover);if(CKEDITOR.env.ie6Compat)
{win.$.setTimeout(function()
{var prevScrollHandler=window.onscroll&&window.onscroll.prevScrollHandler;window.onscroll=prevScrollHandler||null;},0);}
resizeCover=null;};var accessKeyProcessors={};var accessKeyDownHandler=function(evt)
{var ctrl=evt.data.$.ctrlKey||evt.data.$.metaKey,alt=evt.data.$.altKey,shift=evt.data.$.shiftKey,key=String.fromCharCode(evt.data.$.keyCode),keyProcessor=accessKeyProcessors[(ctrl?'CTRL+':'')+(alt?'ALT+':'')+(shift?'SHIFT+':'')+key];if(!keyProcessor||!keyProcessor.length)
return;keyProcessor=keyProcessor[keyProcessor.length-1];keyProcessor.keydown&&keyProcessor.keydown.call(keyProcessor.uiElement,keyProcessor.dialog,keyProcessor.key);evt.data.preventDefault();};var accessKeyUpHandler=function(evt)
{var ctrl=evt.data.$.ctrlKey||evt.data.$.metaKey,alt=evt.data.$.altKey,shift=evt.data.$.shiftKey,key=String.fromCharCode(evt.data.$.keyCode),keyProcessor=accessKeyProcessors[(ctrl?'CTRL+':'')+(alt?'ALT+':'')+(shift?'SHIFT+':'')+key];if(!keyProcessor||!keyProcessor.length)
return;keyProcessor=keyProcessor[keyProcessor.length-1];if(keyProcessor.keyup)
{keyProcessor.keyup.call(keyProcessor.uiElement,keyProcessor.dialog,keyProcessor.key);evt.data.preventDefault();}};var registerAccessKey=function(uiElement,dialog,key,downFunc,upFunc)
{var procList=accessKeyProcessors[key]||(accessKeyProcessors[key]=[]);procList.push({uiElement:uiElement,dialog:dialog,key:key,keyup:upFunc||uiElement.accessKeyUp,keydown:downFunc||uiElement.accessKeyDown});};var unregisterAccessKey=function(obj)
{for(var i in accessKeyProcessors)
{var list=accessKeyProcessors[i];for(var j=list.length-1;j>=0;j--)
{if(list[j].dialog==obj||list[j].uiElement==obj)
list.splice(j,1);}
if(list.length===0)
delete accessKeyProcessors[i];}};var tabAccessKeyUp=function(dialog,key)
{if(dialog._.accessKeyMap[key])
dialog.selectPage(dialog._.accessKeyMap[key]);};var tabAccessKeyDown=function(dialog,key)
{};var preventKeyBubblingKeys={27:1,13:1};var preventKeyBubbling=function(e)
{if(e.data.getKeystroke()in preventKeyBubblingKeys)
e.data.stopPropagation();};(function()
{CKEDITOR.ui.dialog={uiElement:function(dialog,elementDefinition,htmlList,nodeNameArg,stylesArg,attributesArg,contentsArg)
{if(arguments.length<4)
return;var nodeName=(nodeNameArg.call?nodeNameArg(elementDefinition):nodeNameArg)||'div',html=['<',nodeName,' '],styles=(stylesArg&&stylesArg.call?stylesArg(elementDefinition):stylesArg)||{},attributes=(attributesArg&&attributesArg.call?attributesArg(elementDefinition):attributesArg)||{},innerHTML=(contentsArg&&contentsArg.call?contentsArg.call(this,dialog,elementDefinition):contentsArg)||'',domId=this.domId=attributes.id||CKEDITOR.tools.getNextNumber()+'_uiElement',id=this.id=elementDefinition.id,i;attributes.id=domId;var classes={};if(elementDefinition.type)
classes['cke_dialog_ui_'+elementDefinition.type]=1;if(elementDefinition.className)
classes[elementDefinition.className]=1;var attributeClasses=(attributes['class']&&attributes['class'].split)?attributes['class'].split(' '):[];for(i=0;i<attributeClasses.length;i++)
{if(attributeClasses[i])
classes[attributeClasses[i]]=1;}
var finalClasses=[];for(i in classes)
finalClasses.push(i);attributes['class']=finalClasses.join(' ');if(elementDefinition.title)
attributes.title=elementDefinition.title;var styleStr=(elementDefinition.style||'').split(';');for(i in styles)
styleStr.push(i+':'+styles[i]);if(elementDefinition.hidden)
styleStr.push('display:none');for(i=styleStr.length-1;i>=0;i--)
{if(styleStr[i]==='')
styleStr.splice(i,1);}
if(styleStr.length>0)
attributes.style=(attributes.style?(attributes.style+'; '):'')+styleStr.join('; ');for(i in attributes)
html.push(i+'="'+CKEDITOR.tools.htmlEncode(attributes[i])+'" ');html.push('>',innerHTML,'</',nodeName,'>');htmlList.push(html.join(''));(this._||(this._={})).dialog=dialog;if(typeof(elementDefinition.isChanged)=='boolean')
this.isChanged=function(){return elementDefinition.isChanged;};if(typeof(elementDefinition.isChanged)=='function')
this.isChanged=elementDefinition.isChanged;CKEDITOR.event.implementOn(this);this.registerEvents(elementDefinition);if(this.accessKeyUp&&this.accessKeyDown&&elementDefinition.accessKey)
registerAccessKey(this,dialog,'CTRL+'+elementDefinition.accessKey);var me=this;dialog.on('load',function()
{if(me.getInputElement())
{me.getInputElement().on('focus',function()
{dialog._.tabBarMode=false;dialog._.hasFocus=true;me.fire('focus');},me);}});if(this.keyboardFocusable)
{this.tabIndex=elementDefinition.tabIndex||0;this.focusIndex=dialog._.focusList.push(this)-1;this.on('focus',function()
{dialog._.currentFocusIndex=me.focusIndex;});}
CKEDITOR.tools.extend(this,elementDefinition);},hbox:function(dialog,childObjList,childHtmlList,htmlList,elementDefinition)
{if(arguments.length<4)
return;this._||(this._={});var children=this._.children=childObjList,widths=elementDefinition&&elementDefinition.widths||null,height=elementDefinition&&elementDefinition.height||null,styles={},i;var innerHTML=function()
{var html=['<tbody><tr class="cke_dialog_ui_hbox">'];for(i=0;i<childHtmlList.length;i++)
{var className='cke_dialog_ui_hbox_child',styles=[];if(i===0)
className='cke_dialog_ui_hbox_first';if(i==childHtmlList.length-1)
className='cke_dialog_ui_hbox_last';html.push('<td class="',className,'" role="presentation" ');if(widths)
{if(widths[i])
styles.push('width:'+CKEDITOR.tools.cssLength(widths[i]));}
else
styles.push('width:'+Math.floor(100/childHtmlList.length)+'%');if(height)
styles.push('height:'+CKEDITOR.tools.cssLength(height));if(elementDefinition&&elementDefinition.padding!=undefined)
styles.push('padding:'+CKEDITOR.tools.cssLength(elementDefinition.padding));if(styles.length>0)
html.push('style="'+styles.join('; ')+'" ');html.push('>',childHtmlList[i],'</td>');}
html.push('</tr></tbody>');return html.join('');};var attribs={role:'presentation'};elementDefinition&&elementDefinition.align&&(attribs.align=elementDefinition.align);CKEDITOR.ui.dialog.uiElement.call(this,dialog,elementDefinition||{type:'hbox'},htmlList,'table',styles,attribs,innerHTML);},vbox:function(dialog,childObjList,childHtmlList,htmlList,elementDefinition)
{if(arguments.length<3)
return;this._||(this._={});var children=this._.children=childObjList,width=elementDefinition&&elementDefinition.width||null,heights=elementDefinition&&elementDefinition.heights||null;var innerHTML=function()
{var html=['<table role="presentation" cellspacing="0" border="0" '];html.push('style="');if(elementDefinition&&elementDefinition.expand)
html.push('height:100%;');html.push('width:'+CKEDITOR.tools.cssLength(width||'100%'),';');html.push('"');html.push('align="',CKEDITOR.tools.htmlEncode((elementDefinition&&elementDefinition.align)||(dialog.getParentEditor().lang.dir=='ltr'?'left':'right')),'" ');html.push('><tbody>');for(var i=0;i<childHtmlList.length;i++)
{var styles=[];html.push('<tr><td role="presentation" ');if(width)
styles.push('width:'+CKEDITOR.tools.cssLength(width||'100%'));if(heights)
styles.push('height:'+CKEDITOR.tools.cssLength(heights[i]));else if(elementDefinition&&elementDefinition.expand)
styles.push('height:'+Math.floor(100/childHtmlList.length)+'%');if(elementDefinition&&elementDefinition.padding!=undefined)
styles.push('padding:'+CKEDITOR.tools.cssLength(elementDefinition.padding));if(styles.length>0)
html.push('style="',styles.join('; '),'" ');html.push(' class="cke_dialog_ui_vbox_child">',childHtmlList[i],'</td></tr>');}
html.push('</tbody></table>');return html.join('');};CKEDITOR.ui.dialog.uiElement.call(this,dialog,elementDefinition||{type:'vbox'},htmlList,'div',null,{role:'presentation'},innerHTML);}};})();CKEDITOR.ui.dialog.uiElement.prototype={getElement:function()
{return CKEDITOR.document.getById(this.domId);},getInputElement:function()
{return this.getElement();},getDialog:function()
{return this._.dialog;},setValue:function(value)
{this.getInputElement().setValue(value);this.fire('change',{value:value});return this;},getValue:function()
{return this.getInputElement().getValue();},isChanged:function()
{return false;},selectParentTab:function()
{var element=this.getInputElement(),cursor=element,tabId;while((cursor=cursor.getParent())&&cursor.$.className.search('cke_dialog_page_contents')==-1)
{}
if(!cursor)
return this;tabId=cursor.getAttribute('name');if(this._.dialog._.currentTabId!=tabId)
this._.dialog.selectPage(tabId);return this;},focus:function()
{this.selectParentTab().getInputElement().focus();return this;},registerEvents:function(definition)
{var regex=/^on([A-Z]\w+)/,match;var registerDomEvent=function(uiElement,dialog,eventName,func)
{dialog.on('load',function()
{uiElement.getInputElement().on(eventName,func,uiElement);});};for(var i in definition)
{if(!(match=i.match(regex)))
continue;if(this.eventProcessors[i])
this.eventProcessors[i].call(this,this._.dialog,definition[i]);else
registerDomEvent(this,this._.dialog,match[1].toLowerCase(),definition[i]);}
return this;},eventProcessors:{onLoad:function(dialog,func)
{dialog.on('load',func,this);},onShow:function(dialog,func)
{dialog.on('show',func,this);},onHide:function(dialog,func)
{dialog.on('hide',func,this);}},accessKeyDown:function(dialog,key)
{this.focus();},accessKeyUp:function(dialog,key)
{},disable:function()
{var element=this.getInputElement();element.setAttribute('disabled','true');element.addClass('cke_disabled');},enable:function()
{var element=this.getInputElement();element.removeAttribute('disabled');element.removeClass('cke_disabled');},isEnabled:function()
{return!this.getInputElement().getAttribute('disabled');},isVisible:function()
{return this.getInputElement().isVisible();},isFocusable:function()
{if(!this.isEnabled()||!this.isVisible())
return false;return true;}};CKEDITOR.ui.dialog.hbox.prototype=CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.uiElement,{getChild:function(indices)
{if(arguments.length<1)
return this._.children.concat();if(!indices.splice)
indices=[indices];if(indices.length<2)
return this._.children[indices[0]];else
return(this._.children[indices[0]]&&this._.children[indices[0]].getChild)?this._.children[indices[0]].getChild(indices.slice(1,indices.length)):null;}},true);CKEDITOR.ui.dialog.vbox.prototype=new CKEDITOR.ui.dialog.hbox();(function()
{var commonBuilder={build:function(dialog,elementDefinition,output)
{var children=elementDefinition.children,child,childHtmlList=[],childObjList=[];for(var i=0;(i<children.length&&(child=children[i]));i++)
{var childHtml=[];childHtmlList.push(childHtml);childObjList.push(CKEDITOR.dialog._.uiElementBuilders[child.type].build(dialog,child,childHtml));}
return new CKEDITOR.ui.dialog[elementDefinition.type](dialog,childObjList,childHtmlList,output,elementDefinition);}};CKEDITOR.dialog.addUIElement('hbox',commonBuilder);CKEDITOR.dialog.addUIElement('vbox',commonBuilder);})();CKEDITOR.dialogCommand=function(dialogName)
{this.dialogName=dialogName;};CKEDITOR.dialogCommand.prototype={exec:function(editor)
{editor.openDialog(this.dialogName);},canUndo:false,editorFocus:CKEDITOR.env.ie};(function()
{var notEmptyRegex=/^([a]|[^a])+$/,integerRegex=/^\d*$/,numberRegex=/^\d*(?:\.\d+)?$/;CKEDITOR.VALIDATE_OR=1;CKEDITOR.VALIDATE_AND=2;CKEDITOR.dialog.validate={functions:function()
{return function()
{var value=this&&this.getValue?this.getValue():arguments[0];var msg=undefined,relation=CKEDITOR.VALIDATE_AND,functions=[],i;for(i=0;i<arguments.length;i++)
{if(typeof(arguments[i])=='function')
functions.push(arguments[i]);else
break;}
if(i<arguments.length&&typeof(arguments[i])=='string')
{msg=arguments[i];i++;}
if(i<arguments.length&&typeof(arguments[i])=='number')
relation=arguments[i];var passed=(relation==CKEDITOR.VALIDATE_AND?true:false);for(i=0;i<functions.length;i++)
{if(relation==CKEDITOR.VALIDATE_AND)
passed=passed&&functions[i](value);else
passed=passed||functions[i](value);}
if(!passed)
{if(msg!==undefined){var editor=this.getDialog()._.editor;RTE.tools.alert(editor.lang.errorPopupTitle,msg);}
if(this&&(this.select||this.focus))
(this.select||this.focus)();return false;}
return true;};},regex:function(regex,msg)
{return function()
{var value=this&&this.getValue?this.getValue():arguments[0];if(!regex.test(value))
{if(msg!==undefined){var editor=this.getDialog()._.editor;RTE.tools.alert(editor.lang.errorPopupTitle,msg);}
if(this&&(this.select||this.focus))
{if(this.select)
this.select();else
this.focus();}
return false;}
return true;};},notEmpty:function(msg)
{return this.regex(notEmptyRegex,msg);},integer:function(msg)
{return this.regex(integerRegex,msg);},'number':function(msg)
{return this.regex(numberRegex,msg);},equals:function(value,msg)
{return this.functions(function(val){return val==value;},msg);},notEqual:function(value,msg)
{return this.functions(function(val){return val!=value;},msg);}};})();})();CKEDITOR.tools.extend(CKEDITOR.editor.prototype,{openDialog:function(dialogName,callback)
{var dialogDefinitions=CKEDITOR.dialog._.dialogDefinitions[dialogName],dialogSkin=this.skin.dialog;if(typeof dialogDefinitions=='function'&&dialogSkin._isLoaded)
{var storedDialogs=this._.storedDialogs||(this._.storedDialogs={});var dialog=storedDialogs[dialogName]||(storedDialogs[dialogName]=new CKEDITOR.dialog(this,dialogName));callback&&callback.call(dialog,dialog);dialog.show();return dialog;}
else if(dialogDefinitions=='failed')
throw new Error('[CKEDITOR.dialog.openDialog] Dialog "'+dialogName+'" failed when loading definition.');var body=CKEDITOR.document.getBody(),cursor=body.$.style.cursor,me=this;body.setStyle('cursor','wait');function onDialogFileLoaded(success)
{var dialogDefinition=CKEDITOR.dialog._.dialogDefinitions[dialogName],skin=me.skin.dialog;if(!skin._isLoaded||loadDefinition&&typeof success=='undefined')
return;if(typeof dialogDefinition!='function')
CKEDITOR.dialog._.dialogDefinitions[dialogName]='failed';me.openDialog(dialogName,callback);body.setStyle('cursor',cursor);}
if(typeof dialogDefinitions=='string')
{var loadDefinition=1;CKEDITOR.scriptLoader.load(CKEDITOR.getUrl(dialogDefinitions),onDialogFileLoaded);}
CKEDITOR.skins.load(this,'dialog',onDialogFileLoaded);return null;}});CKEDITOR.plugins.add('dialog',{requires:['dialogui']});CKEDITOR.plugins.add('styles',{requires:['selection']});CKEDITOR.editor.prototype.attachStyleStateChange=function(style,callback)
{var styleStateChangeCallbacks=this._.styleStateChangeCallbacks;if(!styleStateChangeCallbacks)
{styleStateChangeCallbacks=this._.styleStateChangeCallbacks=[];this.on('selectionChange',function(ev)
{for(var i=0;i<styleStateChangeCallbacks.length;i++)
{var callback=styleStateChangeCallbacks[i];var currentState=callback.style.checkActive(ev.data.path)?CKEDITOR.TRISTATE_ON:CKEDITOR.TRISTATE_OFF;if(callback.state!==currentState)
{callback.fn.call(this,currentState);callback.state!==currentState;}}});}
styleStateChangeCallbacks.push({style:style,fn:callback});};CKEDITOR.STYLE_BLOCK=1;CKEDITOR.STYLE_INLINE=2;CKEDITOR.STYLE_OBJECT=3;(function()
{var blockElements={address:1,div:1,h1:1,h2:1,h3:1,h4:1,h5:1,h6:1,p:1,pre:1};var objectElements={a:1,embed:1,hr:1,img:1,li:1,object:1,ol:1,table:1,td:1,tr:1,th:1,ul:1,dl:1,dt:1,dd:1,form:1};var semicolonFixRegex=/\s*(?:;\s*|$)/;CKEDITOR.style=function(styleDefinition,variablesValues)
{if(variablesValues)
{styleDefinition=CKEDITOR.tools.clone(styleDefinition);replaceVariables(styleDefinition.attributes,variablesValues);replaceVariables(styleDefinition.styles,variablesValues);}
var element=this.element=(styleDefinition.element||'*').toLowerCase();this.type=(element=='#'||blockElements[element])?CKEDITOR.STYLE_BLOCK:objectElements[element]?CKEDITOR.STYLE_OBJECT:CKEDITOR.STYLE_INLINE;this._={definition:styleDefinition};};CKEDITOR.style.prototype={apply:function(document)
{applyStyle.call(this,document,false);},remove:function(document)
{applyStyle.call(this,document,true);},applyToRange:function(range)
{return(this.applyToRange=this.type==CKEDITOR.STYLE_INLINE?applyInlineStyle:this.type==CKEDITOR.STYLE_BLOCK?applyBlockStyle:this.type==CKEDITOR.STYLE_OBJECT?applyObjectStyle:null).call(this,range);},removeFromRange:function(range)
{return(this.removeFromRange=this.type==CKEDITOR.STYLE_INLINE?removeInlineStyle:null).call(this,range);},applyToObject:function(element)
{setupElement(element,this);},checkActive:function(elementPath)
{switch(this.type)
{case CKEDITOR.STYLE_BLOCK:return this.checkElementRemovable(elementPath.block||elementPath.blockLimit,true);case CKEDITOR.STYLE_OBJECT:case CKEDITOR.STYLE_INLINE:var elements=elementPath.elements;for(var i=0,element;i<elements.length;i++)
{element=elements[i];if(this.type==CKEDITOR.STYLE_INLINE&&(element==elementPath.block||element==elementPath.blockLimit))
continue;if(this.type==CKEDITOR.STYLE_OBJECT&&!(element.getName()in objectElements))
continue;if(this.checkElementRemovable(element,true))
return true;}}
return false;},checkApplicable:function(elementPath)
{switch(this.type)
{case CKEDITOR.STYLE_INLINE:case CKEDITOR.STYLE_BLOCK:break;case CKEDITOR.STYLE_OBJECT:return elementPath.lastElement.getAscendant(this.element,true);}
return true;},checkElementRemovable:function(element,fullMatch)
{if(!element)
return false;var def=this._.definition,attribs;if(element.getName()==this.element)
{if(!fullMatch&&!element.hasAttributes())
return true;attribs=getAttributesForComparison(def);if(attribs._length)
{for(var attName in attribs)
{if(attName=='_length')
continue;var elementAttr=element.getAttribute(attName)||'';if(attName=='style'?compareCssText(attribs[attName],normalizeCssText(elementAttr,false)):attribs[attName]==elementAttr)
{if(!fullMatch)
return true;}
else if(fullMatch)
return false;}
if(fullMatch)
return true;}
else
return true;}
var override=getOverrides(this)[element.getName()];if(override)
{if(!(attribs=override.attributes))
return true;for(var i=0;i<attribs.length;i++)
{attName=attribs[i][0];var actualAttrValue=element.getAttribute(attName);if(actualAttrValue)
{var attValue=attribs[i][1];if(attValue===null||(typeof attValue=='string'&&actualAttrValue==attValue)||attValue.test(actualAttrValue))
return true;}}}
return false;},buildPreview:function()
{var styleDefinition=this._.definition,html=[],elementName=styleDefinition.element;if(elementName=='bdo')
elementName='span';html=['<',elementName];var attribs=styleDefinition.attributes;if(attribs)
{for(var att in attribs)
{html.push(' ',att,'="',attribs[att],'"');}}
var cssStyle=CKEDITOR.style.getStyleText(styleDefinition);if(cssStyle)
html.push(' style="',cssStyle,'"');html.push('>',styleDefinition.name,'</',elementName,'>');return html.join('');}};CKEDITOR.style.getStyleText=function(styleDefinition)
{var stylesDef=styleDefinition._ST;if(stylesDef)
return stylesDef;stylesDef=styleDefinition.styles;var stylesText=(styleDefinition.attributes&&styleDefinition.attributes['style'])||'',specialStylesText='';if(stylesText.length)
stylesText=stylesText.replace(semicolonFixRegex,';');for(var style in stylesDef)
{var styleVal=stylesDef[style],text=(style+':'+styleVal).replace(semicolonFixRegex,';');if(styleVal=='inherit')
specialStylesText+=text;else
stylesText+=text;}
if(stylesText.length)
stylesText=normalizeCssText(stylesText);stylesText+=specialStylesText;return(styleDefinition._ST=stylesText);};function applyInlineStyle(range)
{var document=range.document;if(range.collapsed)
{var collapsedElement=getElement(this,document);range.insertNode(collapsedElement);range.moveToPosition(collapsedElement,CKEDITOR.POSITION_BEFORE_END);return;}
var elementName=this.element;var def=this._.definition;var isUnknownElement;var dtd=CKEDITOR.dtd[elementName]||(isUnknownElement=true,CKEDITOR.dtd.span);var bookmark=range.createBookmark();range.enlarge(CKEDITOR.ENLARGE_ELEMENT);range.trim();var boundaryNodes=range.getBoundaryNodes();var firstNode=boundaryNodes.startNode;var lastNode=boundaryNodes.endNode.getNextSourceNode(true);if(!lastNode)
{var marker;lastNode=marker=document.createText('');lastNode.insertAfter(range.endContainer);}
var lastParent=lastNode.getParent();if(lastParent&&lastParent.getAttribute('_fck_bookmark'))
lastNode=lastParent;if(lastNode.equals(firstNode))
{lastNode=lastNode.getNextSourceNode(true);if(!lastNode)
{lastNode=marker=document.createText('');lastNode.insertAfter(firstNode);}}
var currentNode=firstNode;var styleRange;while(currentNode)
{var applyStyle=false;if(currentNode.equals(lastNode))
{currentNode=null;applyStyle=true;}
else
{var nodeType=currentNode.type;var nodeName=nodeType==CKEDITOR.NODE_ELEMENT?currentNode.getName():null;if(nodeName&&currentNode.getAttribute('_fck_bookmark'))
{currentNode=currentNode.getNextSourceNode(true);continue;}
if(!nodeName||(dtd[nodeName]&&(currentNode.getPosition(lastNode)|CKEDITOR.POSITION_PRECEDING|CKEDITOR.POSITION_IDENTICAL|CKEDITOR.POSITION_IS_CONTAINED)==(CKEDITOR.POSITION_PRECEDING+CKEDITOR.POSITION_IDENTICAL+CKEDITOR.POSITION_IS_CONTAINED)&&(!def.childRule||def.childRule(currentNode))))
{var currentParent=currentNode.getParent();if(currentParent&&((currentParent.getDtd()||CKEDITOR.dtd.span)[elementName]||isUnknownElement)&&(!def.parentRule||def.parentRule(currentParent)))
{if(!styleRange&&(!nodeName||!CKEDITOR.dtd.$removeEmpty[nodeName]||(currentNode.getPosition(lastNode)|CKEDITOR.POSITION_PRECEDING|CKEDITOR.POSITION_IDENTICAL|CKEDITOR.POSITION_IS_CONTAINED)==(CKEDITOR.POSITION_PRECEDING+CKEDITOR.POSITION_IDENTICAL+CKEDITOR.POSITION_IS_CONTAINED)))
{styleRange=new CKEDITOR.dom.range(document);styleRange.setStartBefore(currentNode);}
if(nodeType==CKEDITOR.NODE_TEXT||(nodeType==CKEDITOR.NODE_ELEMENT&&!currentNode.getChildCount()))
{var includedNode=currentNode;var parentNode;while(!includedNode.$.nextSibling&&(parentNode=includedNode.getParent(),dtd[parentNode.getName()])&&(parentNode.getPosition(firstNode)|CKEDITOR.POSITION_FOLLOWING|CKEDITOR.POSITION_IDENTICAL|CKEDITOR.POSITION_IS_CONTAINED)==(CKEDITOR.POSITION_FOLLOWING+CKEDITOR.POSITION_IDENTICAL+CKEDITOR.POSITION_IS_CONTAINED)&&(!def.childRule||def.childRule(parentNode)))
{includedNode=parentNode;}
styleRange.setEndAfter(includedNode);if(!includedNode.$.nextSibling)
applyStyle=true;}}
else
applyStyle=true;}
else
applyStyle=true;currentNode=currentNode.getNextSourceNode();}
if(applyStyle&&styleRange&&!styleRange.collapsed)
{var styleNode=getElement(this,document);var parent=styleRange.getCommonAncestor();while(styleNode&&parent)
{if(parent.getName()==elementName)
{for(var attName in def.attributes)
{if(styleNode.getAttribute(attName)==parent.getAttribute(attName))
styleNode.removeAttribute(attName);}
for(var styleName in def.styles)
{if(styleNode.getStyle(styleName)==parent.getStyle(styleName))
styleNode.removeStyle(styleName);}
if(!styleNode.hasAttributes())
{styleNode=null;break;}}
parent=parent.getParent();}
if(styleNode)
{styleRange.extractContents().appendTo(styleNode);removeFromInsideElement(this,styleNode);styleRange.insertNode(styleNode);mergeSiblings(styleNode);if(!CKEDITOR.env.ie)
styleNode.$.normalize();}
styleRange=null;}}
marker&&marker.remove();range.moveToBookmark(bookmark);range.shrink(CKEDITOR.SHRINK_TEXT);}
function removeInlineStyle(range)
{range.enlarge(CKEDITOR.ENLARGE_ELEMENT);var bookmark=range.createBookmark(),startNode=bookmark.startNode;if(range.collapsed)
{var startPath=new CKEDITOR.dom.elementPath(startNode.getParent()),boundaryElement;for(var i=0,element;i<startPath.elements.length&&(element=startPath.elements[i]);i++)
{if(element==startPath.block||element==startPath.blockLimit)
break;if(this.checkElementRemovable(element))
{var endOfElement=range.checkBoundaryOfElement(element,CKEDITOR.END),startOfElement=!endOfElement&&range.checkBoundaryOfElement(element,CKEDITOR.START);if(startOfElement||endOfElement)
{boundaryElement=element;boundaryElement.match=startOfElement?'start':'end';}
else
{mergeSiblings(element);removeFromElement(this,element);}}}
if(boundaryElement)
{var clonedElement=startNode;for(i=0;;i++)
{var newElement=startPath.elements[i];if(newElement.equals(boundaryElement))
break;else if(newElement.match)
continue;else
newElement=newElement.clone();newElement.append(clonedElement);clonedElement=newElement;}
clonedElement[boundaryElement.match=='start'?'insertBefore':'insertAfter'](boundaryElement);}}
else
{var endNode=bookmark.endNode,me=this;function breakNodes()
{var startPath=new CKEDITOR.dom.elementPath(startNode.getParent()),endPath=new CKEDITOR.dom.elementPath(endNode.getParent()),breakStart=null,breakEnd=null;for(var i=0;i<startPath.elements.length;i++)
{var element=startPath.elements[i];if(element==startPath.block||element==startPath.blockLimit)
break;if(me.checkElementRemovable(element))
breakStart=element;}
for(i=0;i<endPath.elements.length;i++)
{element=endPath.elements[i];if(element==endPath.block||element==endPath.blockLimit)
break;if(me.checkElementRemovable(element))
breakEnd=element;}
if(breakEnd)
endNode.breakParent(breakEnd);if(breakStart)
startNode.breakParent(breakStart);}
breakNodes();var currentNode=startNode.getNext();while(!currentNode.equals(endNode))
{var nextNode=currentNode.getNextSourceNode();if(currentNode.type==CKEDITOR.NODE_ELEMENT&&this.checkElementRemovable(currentNode))
{if(currentNode.getName()==this.element)
removeFromElement(this,currentNode);else
removeOverrides(currentNode,getOverrides(this)[currentNode.getName()]);if(nextNode.type==CKEDITOR.NODE_ELEMENT&&nextNode.contains(startNode))
{breakNodes();nextNode=startNode.getNext();}}
currentNode=nextNode;}}
range.moveToBookmark(bookmark);}
function applyObjectStyle(range)
{var root=range.getCommonAncestor(true,true),element=root.getAscendant(this.element,true);element&&setupElement(element,this);}
function applyBlockStyle(range)
{var bookmark=range.createBookmark(true);var iterator=range.createIterator();iterator.enforceRealBlocks=true;var block;var doc=range.document;var previousPreBlock;while((block=iterator.getNextParagraph()))
{var newBlock=getElement(this,doc);replaceBlock(block,newBlock);}
range.moveToBookmark(bookmark);}
function replaceBlock(block,newBlock)
{var newBlockIsPre=newBlock.is('pre');var blockIsPre=block.is('pre');var isToPre=newBlockIsPre&&!blockIsPre;var isFromPre=!newBlockIsPre&&blockIsPre;if(isToPre)
newBlock=toPre(block,newBlock);else if(isFromPre)
newBlock=fromPres(splitIntoPres(block),newBlock);else
block.moveChildren(newBlock);newBlock.replace(block);if(newBlockIsPre)
{mergePre(newBlock);}}
function mergePre(preBlock)
{var previousBlock;if(!((previousBlock=preBlock.getPreviousSourceNode(true,CKEDITOR.NODE_ELEMENT))&&previousBlock.is&&previousBlock.is('pre')))
return;var mergedHtml=replace(previousBlock.getHtml(),/\n$/,'')+'\n\n'+
replace(preBlock.getHtml(),/^\n/,'');if(CKEDITOR.env.ie)
preBlock.$.outerHTML='<pre>'+mergedHtml+'</pre>';else
preBlock.setHtml(mergedHtml);previousBlock.remove();}
function splitIntoPres(preBlock)
{var duoBrRegex=/(\S\s*)\n(?:\s|(<span[^>]+_fck_bookmark.*?\/span>))*\n(?!$)/gi,blockName=preBlock.getName(),splitedHtml=replace(preBlock.getOuterHtml(),duoBrRegex,function(match,charBefore,bookmark)
{return charBefore+'</pre>'+bookmark+'<pre>';});var pres=[];splitedHtml.replace(/<pre\b.*?>([\s\S]*?)<\/pre>/gi,function(match,preContent){pres.push(preContent);});return pres;}
function replace(str,regexp,replacement)
{var headBookmark='',tailBookmark='';str=str.replace(/(^<span[^>]+_fck_bookmark.*?\/span>)|(<span[^>]+_fck_bookmark.*?\/span>$)/gi,function(str,m1,m2){m1&&(headBookmark=m1);m2&&(tailBookmark=m2);return'';});return headBookmark+str.replace(regexp,replacement)+tailBookmark;}
function fromPres(preHtmls,newBlock)
{var docFrag=new CKEDITOR.dom.documentFragment(newBlock.getDocument());for(var i=0;i<preHtmls.length;i++)
{var blockHtml=preHtmls[i];blockHtml=blockHtml.replace(/(\r\n|\r)/g,'\n');blockHtml=replace(blockHtml,/^[ \t]*\n/,'');blockHtml=replace(blockHtml,/\n$/,'');blockHtml=replace(blockHtml,/^[ \t]+|[ \t]+$/g,function(match,offset,s)
{if(match.length==1)
return'&nbsp;';else if(!offset)
return CKEDITOR.tools.repeat('&nbsp;',match.length-1)+' ';else
return' '+CKEDITOR.tools.repeat('&nbsp;',match.length-1);});blockHtml=blockHtml.replace(/\n/g,'<br>');blockHtml=blockHtml.replace(/[ \t]{2,}/g,function(match)
{return CKEDITOR.tools.repeat('&nbsp;',match.length-1)+' ';});var newBlockClone=newBlock.clone();newBlockClone.setHtml(blockHtml);docFrag.append(newBlockClone);}
return docFrag;}
function toPre(block,newBlock)
{var preHtml=block.getHtml();preHtml=replace(preHtml,/(?:^[ \t\n\r]+)|(?:[ \t\n\r]+$)/g,'');preHtml=preHtml.replace(/[ \t\r\n]*(<br[^>]*>)[ \t\r\n]*/gi,'$1');preHtml=preHtml.replace(/([ \t\n\r]+|&nbsp;)/g,' ');preHtml=preHtml.replace(/<br\b[^>]*>/gi,'\n');if(CKEDITOR.env.ie)
{var temp=block.getDocument().createElement('div');temp.append(newBlock);newBlock.$.outerHTML='<pre>'+preHtml+'</pre>';newBlock=temp.getFirst().remove();}
else
newBlock.setHtml(preHtml);return newBlock;}
function removeFromElement(style,element)
{var def=style._.definition,attributes=CKEDITOR.tools.extend({},def.attributes,getOverrides(style)[element.getName()]),styles=def.styles,removeEmpty=CKEDITOR.tools.isEmpty(attributes)&&CKEDITOR.tools.isEmpty(styles);for(var attName in attributes)
{if((attName=='class'||style._.definition.fullMatch)&&element.getAttribute(attName)!=normalizeProperty(attName,attributes[attName]))
continue;removeEmpty=element.hasAttribute(attName);element.removeAttribute(attName);}
for(var styleName in styles)
{if(style._.definition.fullMatch&&element.getStyle(styleName)!=normalizeProperty(styleName,styles[styleName],true))
continue;removeEmpty=removeEmpty||!!element.getStyle(styleName);element.removeStyle(styleName);}
removeEmpty&&removeNoAttribsElement(element);}
function removeFromInsideElement(style,element)
{var def=style._.definition,attribs=def.attributes,styles=def.styles,overrides=getOverrides(style);var innerElements=element.getElementsByTag(style.element);for(var i=innerElements.count();--i>=0;)
removeFromElement(style,innerElements.getItem(i));for(var overrideElement in overrides)
{if(overrideElement!=style.element)
{innerElements=element.getElementsByTag(overrideElement);for(i=innerElements.count()-1;i>=0;i--)
{var innerElement=innerElements.getItem(i);removeOverrides(innerElement,overrides[overrideElement]);}}}}
function removeOverrides(element,overrides)
{var attributes=overrides&&overrides.attributes;if(attributes)
{for(var i=0;i<attributes.length;i++)
{var attName=attributes[i][0],actualAttrValue;if((actualAttrValue=element.getAttribute(attName)))
{var attValue=attributes[i][1];if(attValue===null||(attValue.test&&attValue.test(actualAttrValue))||(typeof attValue=='string'&&actualAttrValue==attValue))
element.removeAttribute(attName);}}}
removeNoAttribsElement(element);}
function removeNoAttribsElement(element)
{if(!element.hasAttributes())
{var firstChild=element.getFirst();var lastChild=element.getLast();element.remove(true);if(firstChild)
{mergeSiblings(firstChild);if(lastChild&&!firstChild.equals(lastChild))
mergeSiblings(lastChild);}}}
function mergeSiblings(element)
{if(!element||element.type!=CKEDITOR.NODE_ELEMENT||!CKEDITOR.dtd.$removeEmpty[element.getName()])
return;mergeElements(element,element.getNext(),true);mergeElements(element,element.getPrevious());}
function mergeElements(element,sibling,isNext)
{if(sibling&&sibling.type==CKEDITOR.NODE_ELEMENT)
{var hasBookmark=sibling.getAttribute('_fck_bookmark');if(hasBookmark)
sibling=isNext?sibling.getNext():sibling.getPrevious();if(sibling&&sibling.type==CKEDITOR.NODE_ELEMENT&&element.isIdentical(sibling))
{var innerSibling=isNext?element.getLast():element.getFirst();if(hasBookmark)
(isNext?sibling.getPrevious():sibling.getNext()).move(element,!isNext);sibling.moveChildren(element,!isNext);sibling.remove();if(innerSibling)
mergeSiblings(innerSibling);}}}
function getElement(style,targetDocument)
{var el;var def=style._.definition;var elementName=style.element;if(elementName=='*')
elementName='span';el=new CKEDITOR.dom.element(elementName,targetDocument);return setupElement(el,style);}
function setupElement(el,style)
{var def=style._.definition;var attributes=def.attributes;var styles=CKEDITOR.style.getStyleText(def);if(attributes)
{for(var att in attributes)
{el.setAttribute(att,attributes[att]);}}
if(styles)
el.setAttribute('style',styles);return el;}
var varRegex=/#\((.+?)\)/g;function replaceVariables(list,variablesValues)
{for(var item in list)
{list[item]=list[item].replace(varRegex,function(match,varName)
{return variablesValues[varName];});}}
function getAttributesForComparison(styleDefinition)
{var attribs=styleDefinition._AC;if(attribs)
return attribs;attribs={};var length=0;var styleAttribs=styleDefinition.attributes;if(styleAttribs)
{for(var styleAtt in styleAttribs)
{length++;attribs[styleAtt]=styleAttribs[styleAtt];}}
var styleText=CKEDITOR.style.getStyleText(styleDefinition);if(styleText)
{if(!attribs['style'])
length++;attribs['style']=styleText;}
attribs._length=length;return(styleDefinition._AC=attribs);}
function getOverrides(style)
{if(style._.overrides)
return style._.overrides;var overrides=(style._.overrides={}),definition=style._.definition.overrides;if(definition)
{if(!CKEDITOR.tools.isArray(definition))
definition=[definition];for(var i=0;i<definition.length;i++)
{var override=definition[i];var elementName;var overrideEl;var attrs;if(typeof override=='string')
elementName=override.toLowerCase();else
{elementName=override.element?override.element.toLowerCase():style.element;attrs=override.attributes;}
overrideEl=overrides[elementName]||(overrides[elementName]={});if(attrs)
{var overrideAttrs=(overrideEl.attributes=overrideEl.attributes||new Array());for(var attName in attrs)
{overrideAttrs.push([attName.toLowerCase(),attrs[attName]]);}}}}
return overrides;}
function normalizeProperty(name,value,isStyle)
{var temp=new CKEDITOR.dom.element('span');temp[isStyle?'setStyle':'setAttribute'](name,value);return temp[isStyle?'getStyle':'getAttribute'](name);}
function normalizeCssText(unparsedCssText,nativeNormalize)
{var styleText;if(nativeNormalize!==false)
{var temp=new CKEDITOR.dom.element('span');temp.setAttribute('style',unparsedCssText);styleText=temp.getAttribute('style')||'';}
else
styleText=unparsedCssText;return styleText.replace(/\s*([;:])\s*/,'$1').replace(/([^\s;])$/,'$1;').replace(/,\s+/g,',').toLowerCase();}
function parseStyleText(styleText)
{var retval={};styleText.replace(/&quot;/g,'"').replace(/\s*([^ :;]+)\s*:\s*([^;]+)\s*(?=;|$)/g,function(match,name,value)
{retval[name]=value;});return retval;}
function compareCssText(source,target)
{typeof source=='string'&&(source=parseStyleText(source));typeof target=='string'&&(target=parseStyleText(target));for(var name in source)
{if(!(name in target&&(target[name]==source[name]||source[name]=='inherit'||target[name]=='inherit')))
{return false;}}
return true;}
function applyStyle(document,remove)
{document.fire('applyStyle',{style:this.element,remove:remove});var selection=document.getSelection();var ranges=selection.getRanges();var func=remove?this.removeFromRange:this.applyToRange;for(var i=0;i<ranges.length;i++)
func.call(this,ranges[i]);selection.selectRanges(ranges);}})();CKEDITOR.styleCommand=function(style)
{this.style=style;};CKEDITOR.styleCommand.prototype.exec=function(editor)
{editor.focus();var doc=editor.document;if(doc)
{if(this.state==CKEDITOR.TRISTATE_OFF)
this.style.apply(doc);else if(this.state==CKEDITOR.TRISTATE_ON)
this.style.remove(doc);}
return!!doc;};CKEDITOR.stylesSet=new CKEDITOR.resourceManager('','stylesSet');CKEDITOR.addStylesSet=CKEDITOR.tools.bind(CKEDITOR.stylesSet.add,CKEDITOR.stylesSet);CKEDITOR.loadStylesSet=function(name,url,callback)
{CKEDITOR.stylesSet.addExternal(name,url,'');CKEDITOR.stylesSet.load(name,callback);};CKEDITOR.editor.prototype.getStylesSet=function(callback)
{if(!this._.stylesDefinitions)
{var editor=this,configStyleSet=editor.config.stylesCombo_stylesSet||editor.config.stylesSet||'default';if(configStyleSet instanceof Array)
{editor._.stylesDefinitions=configStyleSet;callback(configStyleSet);return;}
var partsStylesSet=configStyleSet.split(':'),styleSetName=partsStylesSet[0],externalPath=partsStylesSet[1],pluginPath=CKEDITOR.plugins.registered.styles.path;CKEDITOR.stylesSet.addExternal(styleSetName,externalPath?partsStylesSet.slice(1).join(':'):pluginPath+'styles/'+styleSetName+'.js','');CKEDITOR.stylesSet.load(styleSetName,function(stylesSet)
{editor._.stylesDefinitions=stylesSet[styleSetName];callback(editor._.stylesDefinitions);});}
else
callback(this._.stylesDefinitions);};CKEDITOR.plugins.add('domiterator');(function()
{function iterator(range)
{if(arguments.length<1)
return;this.range=range;this.forceBrBreak=false;this.enlargeBr=true;this.enforceRealBlocks=false;this._||(this._={});}
var beginWhitespaceRegex=/^[\r\n\t ]+$/,isBookmark=CKEDITOR.dom.walker.bookmark();iterator.prototype={getNextParagraph:function(blockTag)
{var block;var range;var isLast;var removePreviousBr,removeLastBr;if(!this._.lastNode)
{range=this.range.clone();range.enlarge(this.forceBrBreak||!this.enlargeBr?CKEDITOR.ENLARGE_LIST_ITEM_CONTENTS:CKEDITOR.ENLARGE_BLOCK_CONTENTS);var walker=new CKEDITOR.dom.walker(range),ignoreBookmarkTextEvaluator=CKEDITOR.dom.walker.bookmark(true,true);walker.evaluator=ignoreBookmarkTextEvaluator;this._.nextNode=walker.next();walker=new CKEDITOR.dom.walker(range);walker.evaluator=ignoreBookmarkTextEvaluator;var lastNode=walker.previous();this._.lastNode=lastNode.getNextSourceNode(true);if(this._.lastNode&&this._.lastNode.type==CKEDITOR.NODE_TEXT&&!CKEDITOR.tools.trim(this._.lastNode.getText())&&this._.lastNode.getParent().isBlockBoundary())
{var testRange=new CKEDITOR.dom.range(range.document);testRange.moveToPosition(this._.lastNode,CKEDITOR.POSITION_AFTER_END);if(testRange.checkEndOfBlock())
{var path=new CKEDITOR.dom.elementPath(testRange.endContainer);var lastBlock=path.block||path.blockLimit;this._.lastNode=lastBlock.getNextSourceNode(true);}}
if(!this._.lastNode)
{this._.lastNode=this._.docEndMarker=range.document.createText('');this._.lastNode.insertAfter(lastNode);}
range=null;}
var currentNode=this._.nextNode;lastNode=this._.lastNode;this._.nextNode=null;while(currentNode)
{var closeRange=false;var includeNode=(currentNode.type!=CKEDITOR.NODE_ELEMENT),continueFromSibling=false;if(!includeNode)
{var nodeName=currentNode.getName();if(currentNode.isBlockBoundary(this.forceBrBreak&&{br:1}))
{if(nodeName=='br')
includeNode=true;else if(!range&&!currentNode.getChildCount()&&nodeName!='hr')
{block=currentNode;isLast=currentNode.equals(lastNode);break;}
if(range)
{range.setEndAt(currentNode,CKEDITOR.POSITION_BEFORE_START);if(nodeName!='br')
this._.nextNode=currentNode;}
closeRange=true;}
else
{if(currentNode.getFirst())
{if(!range)
{range=new CKEDITOR.dom.range(this.range.document);range.setStartAt(currentNode,CKEDITOR.POSITION_BEFORE_START);}
currentNode=currentNode.getFirst();continue;}
includeNode=true;}}
else if(currentNode.type==CKEDITOR.NODE_TEXT)
{if(beginWhitespaceRegex.test(currentNode.getText()))
includeNode=false;}
if(includeNode&&!range)
{range=new CKEDITOR.dom.range(this.range.document);range.setStartAt(currentNode,CKEDITOR.POSITION_BEFORE_START);}
isLast=((!closeRange||includeNode)&&currentNode.equals(lastNode));if(range&&!closeRange)
{while(!currentNode.getNext()&&!isLast)
{var parentNode=currentNode.getParent();if(parentNode.isBlockBoundary(this.forceBrBreak&&{br:1}))
{closeRange=true;isLast=isLast||(parentNode.equals(lastNode));break;}
currentNode=parentNode;includeNode=true;isLast=(currentNode.equals(lastNode));continueFromSibling=true;}}
if(includeNode)
range.setEndAt(currentNode,CKEDITOR.POSITION_AFTER_END);currentNode=currentNode.getNextSourceNode(continueFromSibling,null,lastNode);isLast=!currentNode;if((closeRange||isLast)&&range)
{var boundaryNodes=range.getBoundaryNodes(),startPath=new CKEDITOR.dom.elementPath(range.startContainer);if(boundaryNodes.startNode.getParent().equals(startPath.blockLimit)&&isBookmark(boundaryNodes.startNode)&&isBookmark(boundaryNodes.endNode))
{range=null;this._.nextNode=null;}
else
break;}
if(isLast)
break;}
if(!block)
{if(!range)
{this._.docEndMarker&&this._.docEndMarker.remove();this._.nextNode=null;return null;}
startPath=new CKEDITOR.dom.elementPath(range.startContainer);var startBlockLimit=startPath.blockLimit,checkLimits={div:1,th:1,td:1};block=startPath.block;if(!block&&!this.enforceRealBlocks&&checkLimits[startBlockLimit.getName()]&&range.checkStartOfBlock()&&range.checkEndOfBlock())
block=startBlockLimit;else if(!block||(this.enforceRealBlocks&&block.getName()=='li'))
{block=this.range.document.createElement(blockTag||'p');range.extractContents().appendTo(block);block.trim();range.insertNode(block);removePreviousBr=removeLastBr=true;}
else if(block.getName()!='li')
{if(!range.checkStartOfBlock()||!range.checkEndOfBlock())
{block=block.clone(false);range.extractContents().appendTo(block);block.trim();var splitInfo=range.splitBlock();removePreviousBr=!splitInfo.wasStartOfBlock;removeLastBr=!splitInfo.wasEndOfBlock;range.insertNode(block);}}
else if(!isLast)
{this._.nextNode=(block.equals(lastNode)?null:range.getBoundaryNodes().endNode.getNextSourceNode(true,null,lastNode));}}
if(removePreviousBr)
{var previousSibling=block.getPrevious();if(previousSibling&&previousSibling.type==CKEDITOR.NODE_ELEMENT)
{if(previousSibling.getName()=='br')
previousSibling.remove();else if(previousSibling.getLast()&&previousSibling.getLast().$.nodeName.toLowerCase()=='br')
previousSibling.getLast().remove();}}
if(removeLastBr)
{var bookmarkGuard=CKEDITOR.dom.walker.bookmark(false,true);var lastChild=block.getLast();if(lastChild&&lastChild.type==CKEDITOR.NODE_ELEMENT&&lastChild.getName()=='br')
{if(CKEDITOR.env.ie||lastChild.getPrevious(bookmarkGuard)||lastChild.getNext(bookmarkGuard))
lastChild.remove();}}
if(!this._.nextNode)
{this._.nextNode=(isLast||block.equals(lastNode))?null:block.getNextSourceNode(true,null,lastNode);}
return block;}};CKEDITOR.dom.range.prototype.createIterator=function()
{return new iterator(this);};})();CKEDITOR.plugins.add('panelbutton',{requires:['button'],beforeInit:function(editor)
{editor.ui.addHandler(CKEDITOR.UI_PANELBUTTON,CKEDITOR.ui.panelButton.handler);}});CKEDITOR.UI_PANELBUTTON=4;(function()
{var clickFn=function(editor)
{var _=this._;if(_.state==CKEDITOR.TRISTATE_DISABLED)
return;this.createPanel(editor);if(_.on)
{_.panel.hide();return;}
_.panel.showBlock(this._.id,this.document.getById(this._.id),4);};CKEDITOR.ui.panelButton=CKEDITOR.tools.createClass({base:CKEDITOR.ui.button,$:function(definition)
{var panelDefinition=definition.panel;delete definition.panel;this.base(definition);this.document=(panelDefinition&&panelDefinition.parent&&panelDefinition.parent.getDocument())||CKEDITOR.document;panelDefinition.block={attributes:panelDefinition.attributes};this.hasArrow=true;this.click=clickFn;this._={panelDefinition:panelDefinition};},statics:{handler:{create:function(definition)
{return new CKEDITOR.ui.panelButton(definition);}}},proto:{createPanel:function(editor)
{var _=this._;if(_.panel)
return;var panelDefinition=this._.panelDefinition||{},panelBlockDefinition=this._.panelDefinition.block,panelParentElement=panelDefinition.parent||CKEDITOR.document.getBody(),panel=this._.panel=new CKEDITOR.ui.floatPanel(editor,panelParentElement,panelDefinition),block=panel.addBlock(_.id,panelBlockDefinition),me=this;panel.onShow=function()
{if(me.className)
this.element.getFirst().addClass(me.className+'_panel');_.oldState=me._.state;me.setState(CKEDITOR.TRISTATE_ON);_.on=1;if(me.onOpen)
me.onOpen();};panel.onHide=function()
{if(me.className)
this.element.getFirst().removeClass(me.className+'_panel');me.setState(_.oldState);_.on=0;if(me.onClose)
me.onClose();};panel.onEscape=function()
{panel.hide();me.document.getById(_.id).focus();};if(this.onBlock)
this.onBlock(panel,block);block.onHide=function()
{_.on=0;me.setState(CKEDITOR.TRISTATE_OFF);};}}});})();CKEDITOR.plugins.add('floatpanel',{requires:['panel']});(function()
{var panels={};var isShowing=false;function getPanel(editor,doc,parentElement,definition,level)
{var key=doc.getUniqueId()+'-'+parentElement.getUniqueId()+'-'+editor.skinName+'-'+editor.lang.dir+
((editor.uiColor&&('-'+editor.uiColor))||'')+
((definition.css&&('-'+definition.css))||'')+
((level&&('-'+level))||'');var panel=panels[key];if(!panel)
{panel=panels[key]=new CKEDITOR.ui.panel(doc,definition);panel.element=parentElement.append(CKEDITOR.dom.element.createFromHtml(panel.renderHtml(editor),doc));panel.element.setStyles({display:'none',position:'absolute'});}
return panel;}
CKEDITOR.ui.floatPanel=CKEDITOR.tools.createClass({$:function(editor,parentElement,definition,level)
{definition.forceIFrame=true;var doc=parentElement.getDocument(),panel=getPanel(editor,doc,parentElement,definition,level||0),element=panel.element,iframe=element.getFirst().getFirst();this.element=element;this._={panel:panel,parentElement:parentElement,definition:definition,document:doc,iframe:iframe,children:[],dir:editor.lang.dir};},proto:{addBlock:function(name,block)
{return this._.panel.addBlock(name,block);},addListBlock:function(name,multiSelect)
{return this._.panel.addListBlock(name,multiSelect);},getBlock:function(name)
{return this._.panel.getBlock(name);},showBlock:function(name,offsetParent,corner,offsetX,offsetY)
{var panel=this._.panel,block=panel.showBlock(name);this.allowBlur(false);isShowing=true;var element=this.element,iframe=this._.iframe,definition=this._.definition,position=offsetParent.getDocumentPosition(element.getDocument()),rtl=this._.dir=='rtl';var left=position.x+(offsetX||0),top=position.y+(offsetY||0);if(rtl&&(corner==1||corner==4))
left+=offsetParent.$.offsetWidth;else if(!rtl&&(corner==2||corner==3))
left+=offsetParent.$.offsetWidth-1;if(corner==3||corner==4)
top+=offsetParent.$.offsetHeight-1;this._.panel._.offsetParentId=offsetParent.getId();element.setStyles({top:top+'px',left:'-3000px',opacity:'0',display:''});element.getFirst().removeStyle('width');if(!this._.blurSet)
{var focused=CKEDITOR.env.ie?iframe:new CKEDITOR.dom.window(iframe.$.contentWindow);CKEDITOR.event.useCapture=true;focused.on('blur',function(ev)
{if(!this.allowBlur())
return;var target;if(CKEDITOR.env.ie&&!this.allowBlur()||(target=ev.data.getTarget())&&target.getName&&target.getName()!='iframe')
return;if(this.visible&&!this._.activeChild&&!isShowing)
this.hide();},this);focused.on('focus',function()
{this._.focused=true;this.hideChild();this.allowBlur(true);},this);CKEDITOR.event.useCapture=false;this._.blurSet=1;}
panel.onEscape=CKEDITOR.tools.bind(function(keystroke)
{if(this.onEscape&&this.onEscape(keystroke)===false)
return false;},this);CKEDITOR.tools.setTimeout(function()
{if(rtl)
left-=element.$.offsetWidth;var panelLoad=CKEDITOR.tools.bind(function()
{var target=element.getFirst();if(block.autoSize)
{var widthNode=block.element.$;if(CKEDITOR.env.gecko||CKEDITOR.env.opera)
widthNode=widthNode.parentNode;if(CKEDITOR.env.ie)
widthNode=widthNode.document.body;var width=widthNode.scrollWidth;if(CKEDITOR.env.ie&&CKEDITOR.env.quirks&&width>0)
width+=(target.$.offsetWidth||0)-(target.$.clientWidth||0);width+=4;target.setStyle('width',width+'px');block.element.addClass('cke_frameLoaded');var height=block.element.$.scrollHeight;if(CKEDITOR.env.ie&&CKEDITOR.env.quirks&&height>0)
height+=(target.$.offsetHeight||0)-(target.$.clientHeight||0);target.setStyle('height',height+'px');panel._.currentBlock.element.setStyle('display','none').removeStyle('display');}
else
target.removeStyle('height');var panelElement=panel.element,panelWindow=panelElement.getWindow(),windowScroll=panelWindow.getScrollPosition(),viewportSize=panelWindow.getViewPaneSize(),panelSize={'height':panelElement.$.offsetHeight,'width':panelElement.$.offsetWidth};if(rtl?left<0:left+panelSize.width>viewportSize.width+windowScroll.x)
left+=(panelSize.width*(rtl?1:-1));if(top+panelSize.height>viewportSize.height+windowScroll.y)
top-=panelSize.height;element.setStyles({top:top+'px',left:left+'px',opacity:'1'});},this);panel.isLoaded?panelLoad():panel.onLoad=panelLoad;CKEDITOR.tools.setTimeout(function()
{iframe.$.contentWindow.focus();this.allowBlur(true);},0,this);},0,this);this.visible=1;if(this.onShow)
this.onShow.call(this);isShowing=false;},hide:function()
{if(this.visible&&(!this.onHide||this.onHide.call(this)!==true))
{this.hideChild();this.element.setStyle('display','none');this.visible=0;}},allowBlur:function(allow)
{var panel=this._.panel;if(allow!=undefined)
panel.allowBlur=allow;return panel.allowBlur;},showAsChild:function(panel,blockName,offsetParent,corner,offsetX,offsetY)
{if(this._.activeChild==panel&&panel._.panel._.offsetParentId==offsetParent.getId())
return;this.hideChild();panel.onHide=CKEDITOR.tools.bind(function()
{CKEDITOR.tools.setTimeout(function()
{if(!this._.focused)
this.hide();},0,this);},this);this._.activeChild=panel;this._.focused=false;panel.showBlock(blockName,offsetParent,corner,offsetX,offsetY);if(CKEDITOR.env.ie7Compat||(CKEDITOR.env.ie8&&CKEDITOR.env.ie6Compat))
{setTimeout(function()
{panel.element.getChild(0).$.style.cssText+='';},100);}},hideChild:function()
{var activeChild=this._.activeChild;if(activeChild)
{delete activeChild.onHide;delete this._.activeChild;activeChild.hide();}}}});CKEDITOR.on('instanceDestroyed',function()
{var isLastInstance=CKEDITOR.tools.isEmpty(CKEDITOR.instances);for(var i in panels)
{var panel=panels[i];if(isLastInstance)
panel.destroy();else
panel.element.hide();}
isLastInstance&&(panels={});});})();CKEDITOR.plugins.add('menu',{beforeInit:function(editor)
{var groups=editor.config.menu_groups.split(','),groupsOrder=editor._.menuGroups={},menuItems=editor._.menuItems={};for(var i=0;i<groups.length;i++)
groupsOrder[groups[i]]=i+1;editor.addMenuGroup=function(name,order)
{groupsOrder[name]=order||100;};editor.addMenuItem=function(name,definition)
{if(groupsOrder[definition.group])
menuItems[name]=new CKEDITOR.menuItem(this,name,definition);};editor.addMenuItems=function(definitions)
{for(var itemName in definitions)
{this.addMenuItem(itemName,definitions[itemName]);}};editor.getMenuItem=function(name)
{return menuItems[name];};},requires:['floatpanel']});(function()
{CKEDITOR.menu=CKEDITOR.tools.createClass({$:function(editor,definition)
{definition=this._.definition=definition||{};this.id='cke_'+CKEDITOR.tools.getNextNumber();this.editor=editor;this.items=[];this._.level=definition.level||1;var panelDefinition=CKEDITOR.tools.extend({},definition.panel,{css:editor.skin.editor.css,level:this._.level-1,block:{}});var attrs=panelDefinition.block.attributes=(panelDefinition.attributes||{});!attrs.role&&(attrs.role='menu');this._.panelDefinition=panelDefinition;},_:{showSubMenu:function(index)
{var menu=this._.subMenu,item=this.items[index],subItemDefs=item.getItems&&item.getItems();if(!subItemDefs)
{this._.panel.hideChild();return;}
var block=this._.panel.getBlock(this.id);block._.focusIndex=index;if(menu)
menu.removeAll();else
{menu=this._.subMenu=new CKEDITOR.menu(this.editor,CKEDITOR.tools.extend({},this._.definition,{level:this._.level+1},true));menu.parent=this;menu.onClick=CKEDITOR.tools.bind(this.onClick,this);menu.onEscape=this.onEscape;}
for(var subItemName in subItemDefs)
{var subItem=this.editor.getMenuItem(subItemName);if(subItem)
{subItem.state=subItemDefs[subItemName];menu.add(subItem);}}
var element=this._.panel.getBlock(this.id).element.getDocument().getById(this.id+String(index));menu.show(element,2);}},proto:{add:function(item)
{if(!item.order)
item.order=this.items.length;this.items.push(item);},removeAll:function()
{this.items=[];},show:function(offsetParent,corner,offsetX,offsetY)
{var items=this.items,editor=this.editor,panel=this._.panel,element=this._.element;if(!panel)
{panel=this._.panel=new CKEDITOR.ui.floatPanel(this.editor,CKEDITOR.document.getBody(),this._.panelDefinition,this._.level);panel.onEscape=CKEDITOR.tools.bind(function(keystroke)
{if(this.onEscape&&this.onEscape(keystroke)===false)
return false;},this);panel.onHide=CKEDITOR.tools.bind(function()
{this.onHide&&this.onHide();},this);var block=panel.addBlock(this.id,this._.panelDefinition.block);block.autoSize=true;var keys=block.keys;keys[40]='next';keys[9]='next';keys[38]='prev';keys[CKEDITOR.SHIFT+9]='prev';keys[32]='click';keys[(editor.lang.dir=='rtl'?37:39)]='click';element=this._.element=block.element;element.addClass(editor.skinClass);var elementDoc=element.getDocument();elementDoc.getBody().setStyle('overflow','hidden');elementDoc.getElementsByTag('html').getItem(0).setStyle('overflow','hidden');this._.itemOverFn=CKEDITOR.tools.addFunction(function(index)
{clearTimeout(this._.showSubTimeout);this._.showSubTimeout=CKEDITOR.tools.setTimeout(this._.showSubMenu,editor.config.menu_subMenuDelay,this,[index]);},this);this._.itemOutFn=CKEDITOR.tools.addFunction(function(index)
{clearTimeout(this._.showSubTimeout);},this);this._.itemClickFn=CKEDITOR.tools.addFunction(function(index)
{var item=this.items[index];if(item.state==CKEDITOR.TRISTATE_DISABLED)
{this.hide();return;}
if(item.getItems)
this._.showSubMenu(index);else
this.onClick&&this.onClick(item);},this);}
sortItems(items);var output=['<div class="cke_menu" role="presentation">'];var length=items.length,lastGroup=length&&items[0].group;for(var i=0;i<length;i++)
{var item=items[i];if(lastGroup!=item.group)
{output.push('<div class="cke_menuseparator" role="separator"></div>');lastGroup=item.group;}
item.render(this,i,output);}
output.push('</div>');element.setHtml(output.join(''));if(this.parent)
this.parent._.panel.showAsChild(panel,this.id,offsetParent,corner,offsetX,offsetY);else
panel.showBlock(this.id,offsetParent,corner,offsetX,offsetY);editor.fire('menuShow',[panel]);},hide:function()
{this._.panel&&this._.panel.hide();}}});function sortItems(items)
{items.sort(function(itemA,itemB)
{if(itemA.group<itemB.group)
return-1;else if(itemA.group>itemB.group)
return 1;return itemA.order<itemB.order?-1:itemA.order>itemB.order?1:0;});}})();CKEDITOR.menuItem=CKEDITOR.tools.createClass({$:function(editor,name,definition)
{CKEDITOR.tools.extend(this,definition,{order:0,className:'cke_button_'+name});this.group=editor._.menuGroups[this.group];this.editor=editor;this.name=name;},proto:{render:function(menu,index,output)
{var id=menu.id+String(index),state=(typeof this.state=='undefined')?CKEDITOR.TRISTATE_OFF:this.state;var classes=' cke_'+(state==CKEDITOR.TRISTATE_ON?'on':state==CKEDITOR.TRISTATE_DISABLED?'disabled':'off');var htmlLabel=this.label;if(this.className)
classes+=' '+this.className;var hasSubMenu=this.getItems;output.push('<span class="cke_menuitem">'+'<a id="',id,'"'+' class="',classes,'" href="javascript:void(\'',(this.label||'').replace("'",''),'\')"'+' title="',this.label,'"'+' tabindex="-1"'+'_cke_focus=1'+' hidefocus="true"'+' role="menuitem"'+
(hasSubMenu?'aria-haspopup="true"':'')+
(state==CKEDITOR.TRISTATE_DISABLED?'aria-disabled="true"':'')+
(state==CKEDITOR.TRISTATE_ON?'aria-pressed="true"':''));if(CKEDITOR.env.opera||(CKEDITOR.env.gecko&&CKEDITOR.env.mac))
{output.push(' onkeypress="return false;"');}
if(CKEDITOR.env.gecko)
{output.push(' onblur="this.style.cssText = this.style.cssText;"');}
var offset=(this.iconOffset||0)*-16;output.push(' onmouseover="CKEDITOR.tools.callFunction(',menu._.itemOverFn,',',index,');"'+' onmouseout="CKEDITOR.tools.callFunction(',menu._.itemOutFn,',',index,');"'+' onclick="CKEDITOR.tools.callFunction(',menu._.itemClickFn,',',index,'); return false;"'+'>'+'<span class="cke_icon_wrapper"><span class="cke_icon"'+
(this.icon?' style="background-image:url('+CKEDITOR.getUrl(this.icon)+');background-position:0 '+offset+'px;"':'')+'></span></span>'+'<span class="cke_label">');if(hasSubMenu)
{output.push('<span class="cke_menuarrow">','<span>&#',(this.editor.lang.dir=='rtl'?'9668':'9658'),';</span>','</span>');}
output.push(htmlLabel,'</span>'+'</a>'+'</span>');}}});CKEDITOR.config.menu_subMenuDelay=400;CKEDITOR.config.menu_groups='clipboard,'+'form,'+'tablecell,tablecellproperties,tablerow,tablecolumn,table,'+'anchor,link,image,flash,'+'checkbox,radio,textfield,hiddenfield,imagebutton,button,select,textarea,div';(function()
{var getMode=function(editor,mode)
{return editor._.modes&&editor._.modes[mode||editor.mode];};var isHandlingData;CKEDITOR.plugins.add('editingblock',{init:function(editor)
{if(!editor.config.editingBlock)
return;editor.on('themeSpace',function(event)
{if(event.data.space=='contents')
event.data.html+='<br>';});editor.on('themeLoaded',function()
{editor.fireOnce('editingBlockReady');});editor.on('uiReady',function()
{editor.setMode(editor.config.startupMode);});editor.on('afterSetData',function()
{if(!isHandlingData)
{function setData()
{isHandlingData=true;getMode(editor).loadData(editor.getData());isHandlingData=false;}
if(editor.mode)
setData();else
{editor.on('mode',function()
{setData();editor.removeListener('mode',arguments.callee);});}}});editor.on('beforeGetData',function()
{if(!isHandlingData&&editor.mode)
{isHandlingData=true;editor.setData(getMode(editor).getData());isHandlingData=false;}});editor.on('getSnapshot',function(event)
{if(editor.mode)
event.data=getMode(editor).getSnapshotData();});editor.on('loadSnapshot',function(event)
{if(editor.mode)
getMode(editor).loadSnapshotData(event.data);});editor.on('mode',function(event)
{event.removeListener();if(editor.config.startupFocus)
editor.focus();setTimeout(function(){editor.fireOnce('instanceReady');CKEDITOR.fire('instanceReady',null,editor);});});}});CKEDITOR.editor.prototype.mode='';CKEDITOR.editor.prototype.addMode=function(mode,modeEditor)
{modeEditor.name=mode;(this._.modes||(this._.modes={}))[mode]=modeEditor;};CKEDITOR.editor.prototype.setMode=function(mode)
{var data,holderElement=this.getThemeSpace('contents'),isDirty=this.checkDirty();if(this.mode)
{if(mode==this.mode)
return;this.fire('beforeModeUnload');var currentMode=getMode(this);data=currentMode.getData();currentMode.unload(holderElement);this.mode='';}
holderElement.setHtml('');var modeEditor=getMode(this,mode);if(!modeEditor)
throw'[CKEDITOR.editor.setMode] Unknown mode "'+mode+'".';if(!isDirty)
{this.on('mode',function()
{this.resetDirty();this.removeListener('mode',arguments.callee);});}
modeEditor.load(holderElement,(typeof data)!='string'?this.getData():data);};CKEDITOR.editor.prototype.focus=function()
{var mode=getMode(this);if(mode)
mode.focus();};})();CKEDITOR.config.startupMode='wysiwyg';CKEDITOR.config.startupFocus=false;CKEDITOR.config.editingBlock=true;(function()
{function checkSelectionChange()
{try
{var sel=this.getSelection();if(!sel)
return;var firstElement=sel.getStartElement();var currentPath=new CKEDITOR.dom.elementPath(firstElement);if(!currentPath.compare(this._.selectionPreviousPath))
{this._.selectionPreviousPath=currentPath;this.fire('selectionChange',{selection:sel,path:currentPath,element:firstElement});}}
catch(e)
{}}
var checkSelectionChangeTimer,checkSelectionChangeTimeoutPending;function checkSelectionChangeTimeout()
{checkSelectionChangeTimeoutPending=true;if(checkSelectionChangeTimer)
return;checkSelectionChangeTimeoutExec.call(this);checkSelectionChangeTimer=CKEDITOR.tools.setTimeout(checkSelectionChangeTimeoutExec,200,this);}
function checkSelectionChangeTimeoutExec()
{checkSelectionChangeTimer=null;if(checkSelectionChangeTimeoutPending)
{CKEDITOR.tools.setTimeout(checkSelectionChange,0,this);checkSelectionChangeTimeoutPending=false;}}
var selectAllCmd={modes:{wysiwyg:1,source:1},exec:function(editor)
{switch(editor.mode)
{case'wysiwyg':editor.document.$.execCommand('SelectAll',false,null);break;case'source':var textarea=editor.textarea.$;if(CKEDITOR.env.ie)
{textarea.createTextRange().execCommand('SelectAll');}
else
{textarea.selectionStart=0;textarea.selectionEnd=textarea.value.length;}
textarea.focus();}},canUndo:false};CKEDITOR.plugins.add('selection',{init:function(editor)
{editor.on('contentDom',function()
{var doc=editor.document,body=doc.getBody();if(CKEDITOR.env.ie)
{var savedRange,saveEnabled;body.on('focusin',function(evt)
{if(evt.data.$.srcElement.nodeName!='BODY')
return;if(savedRange)
{try
{savedRange.select();}
catch(e)
{}
savedRange=null;}});body.on('focus',function()
{saveEnabled=true;saveSelection();});body.on('beforedeactivate',function(evt)
{if(evt.data.$.toElement)
return;saveEnabled=false;});if(CKEDITOR.env.ie&&CKEDITOR.env.version<8)
{doc.getWindow().on('blur',function(evt)
{editor.document.$.selection.empty();});}
body.on('mousedown',disableSave);body.on('mouseup',function()
{saveEnabled=true;setTimeout(function()
{saveSelection(true);},0);});body.on('keydown',disableSave);body.on('keyup',function()
{saveEnabled=true;saveSelection();});doc.on('selectionchange',saveSelection);function disableSave()
{saveEnabled=false;}
function saveSelection(testIt)
{if(saveEnabled)
{var doc=editor.document,sel=doc&&doc.$.selection;if(testIt&&sel&&sel.type=='None')
{if(!doc.$.queryCommandEnabled('InsertImage'))
{CKEDITOR.tools.setTimeout(saveSelection,50,this,true);return;}}
savedRange=sel&&sel.createRange();checkSelectionChangeTimeout.call(editor);}}}
else
{doc.on('mouseup',checkSelectionChangeTimeout,editor);doc.on('keyup',checkSelectionChangeTimeout,editor);}});editor.addCommand('selectAll',selectAllCmd);editor.ui.addButton('SelectAll',{label:editor.lang.selectAll,command:'selectAll'});editor.selectionChange=checkSelectionChangeTimeout;}});CKEDITOR.editor.prototype.getSelection=function()
{return this.document&&this.document.getSelection();};CKEDITOR.editor.prototype.forceNextSelectionCheck=function()
{delete this._.selectionPreviousPath;};CKEDITOR.dom.document.prototype.getSelection=function()
{var sel=new CKEDITOR.dom.selection(this);return(!sel||sel.isInvalid)?null:sel;};CKEDITOR.SELECTION_NONE=1;CKEDITOR.SELECTION_TEXT=2;CKEDITOR.SELECTION_ELEMENT=3;CKEDITOR.dom.selection=function(document)
{var lockedSelection=document.getCustomData('cke_locked_selection');if(lockedSelection)
return lockedSelection;this.document=document;this.isLocked=false;this._={cache:{}};if(CKEDITOR.env.ie)
{var range=this.getNative().createRange();if(!range||(range.item&&range.item(0).ownerDocument!=this.document.$)||(range.parentElement&&range.parentElement().ownerDocument!=this.document.$))
{this.isInvalid=true;}}
return this;};var styleObjectElements={img:1,hr:1,li:1,table:1,tr:1,td:1,th:1,embed:1,object:1,ol:1,ul:1,a:1,input:1,form:1,select:1,textarea:1,button:1,fieldset:1,th:1,thead:1,tfoot:1};CKEDITOR.dom.selection.prototype={getNative:CKEDITOR.env.ie?function()
{return this._.cache.nativeSel||(this._.cache.nativeSel=this.document.$.selection);}:function()
{return this._.cache.nativeSel||(this._.cache.nativeSel=this.document.getWindow().$.getSelection());},getType:CKEDITOR.env.ie?function()
{var cache=this._.cache;if(cache.type)
return cache.type;var type=CKEDITOR.SELECTION_NONE;try
{var sel=this.getNative(),ieType=sel.type;if(ieType=='Text')
type=CKEDITOR.SELECTION_TEXT;if(ieType=='Control')
type=CKEDITOR.SELECTION_ELEMENT;if(sel.createRange().parentElement)
type=CKEDITOR.SELECTION_TEXT;}
catch(e){}
return(cache.type=type);}:function()
{var cache=this._.cache;if(cache.type)
return cache.type;var type=CKEDITOR.SELECTION_TEXT;var sel=this.getNative();if(!sel)
type=CKEDITOR.SELECTION_NONE;else if(sel.rangeCount==1)
{var range=sel.getRangeAt(0),startContainer=range.startContainer;if(startContainer==range.endContainer&&startContainer.nodeType==1&&(range.endOffset-range.startOffset)==1&&styleObjectElements[startContainer.childNodes[range.startOffset].nodeName.toLowerCase()])
{type=CKEDITOR.SELECTION_ELEMENT;}}
return(cache.type=type);},getRanges:CKEDITOR.env.ie?(function()
{var getBoundaryInformation=function(range,start)
{range=range.duplicate();range.collapse(start);var parent=range.parentElement();var siblings=parent.childNodes;var testRange;for(var i=0;i<siblings.length;i++)
{var child=siblings[i];if(child.nodeType==1)
{testRange=range.duplicate();testRange.moveToElementText(child);var comparisonStart=testRange.compareEndPoints('StartToStart',range),comparisonEnd=testRange.compareEndPoints('EndToStart',range);testRange.collapse();if(comparisonStart>0)
break;else if(!comparisonStart||comparisonEnd==1&&comparisonStart==-1)
return{container:parent,offset:i};else if(!comparisonEnd)
return{container:parent,offset:i+1};testRange=null;}}
if(!testRange)
{testRange=range.duplicate();testRange.moveToElementText(parent);testRange.collapse(false);}
testRange.setEndPoint('StartToStart',range);var distance=testRange.text.replace(/(\r\n|\r)/g,'\n').length;try
{while(distance>0)
distance-=siblings[--i].nodeValue.length;}
catch(e)
{distance=0;}
if(distance===0)
{return{container:parent,offset:i};}
else
{return{container:siblings[i],offset:-distance};}};return function()
{var cache=this._.cache;if(cache.ranges)
return cache.ranges;var sel=this.getNative(),nativeRange=sel&&sel.createRange(),type=this.getType(),range;if(!sel)
return[];if(type==CKEDITOR.SELECTION_TEXT)
{range=new CKEDITOR.dom.range(this.document);var boundaryInfo=getBoundaryInformation(nativeRange,true);range.setStart(new CKEDITOR.dom.node(boundaryInfo.container),boundaryInfo.offset);boundaryInfo=getBoundaryInformation(nativeRange);range.setEnd(new CKEDITOR.dom.node(boundaryInfo.container),boundaryInfo.offset);return(cache.ranges=[range]);}
else if(type==CKEDITOR.SELECTION_ELEMENT)
{var retval=this._.cache.ranges=[];for(var i=0;i<nativeRange.length;i++)
{var element=nativeRange.item(i),parentElement=element.parentNode,j=0;range=new CKEDITOR.dom.range(this.document);for(;j<parentElement.childNodes.length&&parentElement.childNodes[j]!=element;j++)
{}
range.setStart(new CKEDITOR.dom.node(parentElement),j);range.setEnd(new CKEDITOR.dom.node(parentElement),j+1);retval.push(range);}
return retval;}
return(cache.ranges=[]);};})():function()
{var cache=this._.cache;if(cache.ranges)
return cache.ranges;var ranges=[];var sel=this.getNative();if(!sel)
return[];for(var i=0;i<sel.rangeCount;i++)
{var nativeRange=sel.getRangeAt(i);var range=new CKEDITOR.dom.range(this.document);range.setStart(new CKEDITOR.dom.node(nativeRange.startContainer),nativeRange.startOffset);range.setEnd(new CKEDITOR.dom.node(nativeRange.endContainer),nativeRange.endOffset);ranges.push(range);}
return(cache.ranges=ranges);},getStartElement:function()
{var cache=this._.cache;if(cache.startElement!==undefined)
return cache.startElement;var node,sel=this.getNative();switch(this.getType())
{case CKEDITOR.SELECTION_ELEMENT:return this.getSelectedElement();case CKEDITOR.SELECTION_TEXT:var range=this.getRanges()[0];if(range)
{if(!range.collapsed)
{range.optimize();while(true)
{var startContainer=range.startContainer,startOffset=range.startOffset;if(startOffset==(startContainer.getChildCount?startContainer.getChildCount():startContainer.getLength())&&!startContainer.isBlockBoundary())
range.setStartAfter(startContainer);else break;}
node=range.startContainer;if(node.type!=CKEDITOR.NODE_ELEMENT)
return node.getParent();node=node.getChild(range.startOffset);if(!node||node.type!=CKEDITOR.NODE_ELEMENT)
return range.startContainer;var child=node.getFirst();while(child&&child.type==CKEDITOR.NODE_ELEMENT)
{node=child;child=child.getFirst();}
return node;}}
if(CKEDITOR.env.ie)
{range=sel.createRange();range.collapse(true);node=range.parentElement();}
else
{node=sel.anchorNode;if(node&&node.nodeType!=1)
node=node.parentNode;}}
return cache.startElement=(node?new CKEDITOR.dom.element(node):null);},getSelectedElement:function()
{var cache=this._.cache;if(cache.selectedElement!==undefined)
return cache.selectedElement;var self=this;var node=CKEDITOR.tools.tryThese(function()
{return self.getNative().createRange().item(0);},function()
{var range=self.getRanges()[0];range.shrink(CKEDITOR.SHRINK_ELEMENT);var enclosed;if(range.startContainer.equals(range.endContainer)&&(range.endOffset-range.startOffset)==1&&styleObjectElements[(enclosed=range.startContainer.getChild(range.startOffset)).getName()])
{return enclosed.$;}});return cache.selectedElement=(node?new CKEDITOR.dom.element(node):null);},lock:function()
{this.getRanges();this.getStartElement();this.getSelectedElement();this._.cache.nativeSel={};this.isLocked=true;this.document.setCustomData('cke_locked_selection',this);},unlock:function(restore)
{var doc=this.document,lockedSelection=doc.getCustomData('cke_locked_selection');if(lockedSelection)
{doc.setCustomData('cke_locked_selection',null);if(restore)
{var selectedElement=lockedSelection.getSelectedElement(),ranges=!selectedElement&&lockedSelection.getRanges();this.isLocked=false;this.reset();doc.getBody().focus();if(selectedElement)
this.selectElement(selectedElement);else
this.selectRanges(ranges);}}
if(!lockedSelection||!restore)
{this.isLocked=false;this.reset();}},reset:function()
{this._.cache={};},selectElement:function(element)
{if(this.isLocked)
{var range=new CKEDITOR.dom.range(this.document);range.setStartBefore(element);range.setEndAfter(element);this._.cache.selectedElement=element;this._.cache.startElement=element;this._.cache.ranges=[range];this._.cache.type=CKEDITOR.SELECTION_ELEMENT;return;}
if(CKEDITOR.env.ie)
{this.getNative().empty();try
{range=this.document.$.body.createControlRange();range.addElement(element.$);range.select();}
catch(e)
{range=this.document.$.body.createTextRange();range.moveToElementText(element.$);range.select();}
finally
{this.document.fire('selectionchange');}
this.reset();}
else
{range=this.document.$.createRange();range.selectNode(element.$);var sel=this.getNative();sel.removeAllRanges();sel.addRange(range);this.reset();}},selectRanges:function(ranges)
{if(this.isLocked)
{this._.cache.selectedElement=null;this._.cache.startElement=ranges[0].getTouchedStartNode();this._.cache.ranges=ranges;this._.cache.type=CKEDITOR.SELECTION_TEXT;return;}
if(CKEDITOR.env.ie)
{if(ranges[0])
ranges[0].select();this.reset();}
else
{var sel=this.getNative();sel.removeAllRanges();for(var i=0;i<ranges.length;i++)
{var range=ranges[i];var nativeRange=this.document.$.createRange();var startContainer=range.startContainer;if(range.collapsed&&(CKEDITOR.env.gecko&&CKEDITOR.env.version<10900)&&startContainer.type==CKEDITOR.NODE_ELEMENT&&!startContainer.getChildCount())
{startContainer.appendText('');}
nativeRange.setStart(startContainer.$,range.startOffset);nativeRange.setEnd(range.endContainer.$,range.endOffset);sel.addRange(nativeRange);}
this.reset();}},createBookmarks:function(serializable)
{var retval=[],ranges=this.getRanges(),length=ranges.length,bookmark;for(var i=0;i<length;i++)
{retval.push(bookmark=ranges[i].createBookmark(serializable,true));serializable=bookmark.serializable;var bookmarkStart=serializable?this.document.getById(bookmark.startNode):bookmark.startNode,bookmarkEnd=serializable?this.document.getById(bookmark.endNode):bookmark.endNode;for(var j=i+1;j<length;j++)
{var dirtyRange=ranges[j],rangeStart=dirtyRange.startContainer,rangeEnd=dirtyRange.endContainer;rangeStart.equals(bookmarkStart.getParent())&&dirtyRange.startOffset++;rangeStart.equals(bookmarkEnd.getParent())&&dirtyRange.startOffset++;rangeEnd.equals(bookmarkStart.getParent())&&dirtyRange.endOffset++;rangeEnd.equals(bookmarkEnd.getParent())&&dirtyRange.endOffset++;}}
return retval;},createBookmarks2:function(normalized)
{var bookmarks=[],ranges=this.getRanges();for(var i=0;i<ranges.length;i++)
bookmarks.push(ranges[i].createBookmark2(normalized));return bookmarks;},selectBookmarks:function(bookmarks)
{var ranges=[];for(var i=0;i<bookmarks.length;i++)
{var range=new CKEDITOR.dom.range(this.document);range.moveToBookmark(bookmarks[i]);ranges.push(range);}
this.selectRanges(ranges);return this;},getCommonAncestor:function()
{var ranges=this.getRanges(),startNode=ranges[0].startContainer,endNode=ranges[ranges.length-1].endContainer;return startNode.getCommonAncestor(endNode);},scrollIntoView:function()
{var start=this.getStartElement();start.scrollIntoView();}};})();(function()
{var notWhitespaces=CKEDITOR.dom.walker.whitespaces(true);var fillerTextRegex=/\ufeff|\u00a0/;CKEDITOR.dom.range.prototype.select=CKEDITOR.env.ie?function(forceExpand)
{var collapsed=this.collapsed;var isStartMarkerAlone;var dummySpan;var bookmark=this.createBookmark();var startNode=bookmark.startNode;var endNode;if(!collapsed)
endNode=bookmark.endNode;var ieRange=this.document.$.body.createTextRange();ieRange.moveToElementText(startNode.$);ieRange.moveStart('character',1);if(endNode)
{var ieRangeEnd=this.document.$.body.createTextRange();ieRangeEnd.moveToElementText(endNode.$);ieRange.setEndPoint('EndToEnd',ieRangeEnd);ieRange.moveEnd('character',-1);}
else
{var next=startNode.getNext(notWhitespaces);isStartMarkerAlone=(!(next&&next.getText&&next.getText().match(fillerTextRegex))&&(forceExpand||!startNode.hasPrevious()||(startNode.getPrevious().is&&startNode.getPrevious().is('br'))));dummySpan=this.document.createElement('span');dummySpan.setHtml('&#65279;');dummySpan.insertBefore(startNode);if(isStartMarkerAlone)
{this.document.createText('\ufeff').insertBefore(startNode);}}
this.setStartBefore(startNode);startNode.remove();if(collapsed)
{if(isStartMarkerAlone)
{ieRange.moveStart('character',-1);ieRange.select();this.document.$.selection.clear();}
else
ieRange.select();this.moveToPosition(dummySpan,CKEDITOR.POSITION_BEFORE_START);dummySpan.remove();}
else
{this.setEndBefore(endNode);endNode.remove();ieRange.select();}
this.document.fire('selectionchange');}:function()
{var startContainer=this.startContainer;if(this.collapsed&&startContainer.type==CKEDITOR.NODE_ELEMENT&&!startContainer.getChildCount())
startContainer.append(new CKEDITOR.dom.text(''));var nativeRange=this.document.$.createRange();nativeRange.setStart(startContainer.$,this.startOffset);try
{nativeRange.setEnd(this.endContainer.$,this.endOffset);}
catch(e)
{if(e.toString().indexOf('NS_ERROR_ILLEGAL_VALUE')>=0)
{this.collapse(true);nativeRange.setEnd(this.endContainer.$,this.endOffset);}
else
throw(e);}
var selection=this.document.getSelection().getNative();selection.removeAllRanges();selection.addRange(nativeRange);};})();(function()
{var htmlFilterRules={elements:{$:function(element)
{var attributes=element.attributes,realHtml=attributes&&attributes._cke_realelement,realFragment=realHtml&&new CKEDITOR.htmlParser.fragment.fromHtml(decodeURIComponent(realHtml)),realElement=realFragment&&realFragment.children[0];if(realElement&&element.attributes._cke_resizable)
{var style=element.attributes.style;if(style)
{var match=/(?:^|\s)width\s*:\s*(\d+)/i.exec(style),width=match&&match[1];match=/(?:^|\s)height\s*:\s*(\d+)/i.exec(style);var height=match&&match[1];if(width)
realElement.attributes.width=width;if(height)
realElement.attributes.height=height;}}
return realElement;}}};CKEDITOR.plugins.add('fakeobjects',{requires:['htmlwriter'],afterInit:function(editor)
{var dataProcessor=editor.dataProcessor,htmlFilter=dataProcessor&&dataProcessor.htmlFilter;if(htmlFilter)
htmlFilter.addRules(htmlFilterRules);}});})();CKEDITOR.editor.prototype.createFakeElement=function(realElement,className,realElementType,isResizable)
{var lang=this.lang.fakeobjects;var attributes={'class':className,src:CKEDITOR.getUrl('images/spacer.gif?20100510'),_cke_realelement:encodeURIComponent(realElement.getOuterHtml()),_cke_real_node_type:realElement.type,alt:lang[realElementType]||lang.unknown};if(realElementType)
attributes._cke_real_element_type=realElementType;if(isResizable)
attributes._cke_resizable=isResizable;return this.document.createElement('img',{attributes:attributes});};CKEDITOR.editor.prototype.createFakeParserElement=function(realElement,className,realElementType,isResizable)
{var lang=this.lang.fakeobjects,html;var writer=new CKEDITOR.htmlParser.basicWriter();realElement.writeHtml(writer);html=writer.getHtml();var attributes={'class':className,src:CKEDITOR.getUrl('images/spacer.gif?20100510'),_cke_realelement:encodeURIComponent(html),_cke_real_node_type:realElement.type,alt:lang[realElementType]||lang.unknown};if(realElementType)
attributes._cke_real_element_type=realElementType;if(isResizable)
attributes._cke_resizable=isResizable;return new CKEDITOR.htmlParser.element('img',attributes);};CKEDITOR.editor.prototype.restoreRealElement=function(fakeElement)
{if(fakeElement.getAttribute('_cke_real_node_type')!=CKEDITOR.NODE_ELEMENT)
return null;return CKEDITOR.dom.element.createFromHtml(decodeURIComponent(fakeElement.getAttribute('_cke_realelement')),this.document);};CKEDITOR.plugins.add('richcombo',{requires:['floatpanel','listblock','button'],beforeInit:function(editor)
{editor.ui.addHandler(CKEDITOR.UI_RICHCOMBO,CKEDITOR.ui.richCombo.handler);}});CKEDITOR.UI_RICHCOMBO=3;CKEDITOR.ui.richCombo=CKEDITOR.tools.createClass({$:function(definition)
{CKEDITOR.tools.extend(this,definition,{title:definition.label,modes:{wysiwyg:1}});var panelDefinition=this.panel||{};delete this.panel;this.id=CKEDITOR.tools.getNextNumber();this.document=(panelDefinition&&panelDefinition.parent&&panelDefinition.parent.getDocument())||CKEDITOR.document;panelDefinition.className=(panelDefinition.className||'')+' cke_rcombopanel';panelDefinition.block={multiSelect:panelDefinition.multiSelect,attributes:panelDefinition.attributes};this._={panelDefinition:panelDefinition,items:{},state:CKEDITOR.TRISTATE_OFF};},statics:{handler:{create:function(definition)
{return new CKEDITOR.ui.richCombo(definition);}}},proto:{renderHtml:function(editor)
{var output=[];this.render(editor,output);return output.join('');},render:function(editor,output)
{var env=CKEDITOR.env;var id='cke_'+this.id;var clickFn=CKEDITOR.tools.addFunction(function($element)
{var _=this._;if(_.state==CKEDITOR.TRISTATE_DISABLED)
return;this.createPanel(editor);if(_.on)
{_.panel.hide();return;}
if(!_.committed)
{_.list.commit();_.committed=1;}
var value=this.getValue();if(value)
_.list.mark(value);else
_.list.unmarkAll();_.panel.showBlock(this.id,new CKEDITOR.dom.element($element),4);},this);var instance={id:id,combo:this,focus:function()
{var element=CKEDITOR.document.getById(id).getChild(1);element.focus();},clickFn:clickFn};editor.on('mode',function()
{this.setState(this.modes[editor.mode]?CKEDITOR.TRISTATE_OFF:CKEDITOR.TRISTATE_DISABLED);},this);var keyDownFn=CKEDITOR.tools.addFunction(function(ev,element)
{ev=new CKEDITOR.dom.event(ev);var keystroke=ev.getKeystroke();switch(keystroke)
{case 13:case 32:case 40:CKEDITOR.tools.callFunction(clickFn,element);break;default:instance.onkey(instance,keystroke);}
ev.preventDefault();});instance.keyDownFn=keyDownFn;output.push('<span class="cke_rcombo">','<span id=',id);if(this.className)
output.push(' class="',this.className,' cke_off"');output.push('>','<span id="'+id+'_label" class=cke_label>',this.label,'</span>','<a hidefocus=true title="',this.title,'" tabindex="-1"',env.gecko&&env.version>=10900&&!env.hc?'':' href="javascript:void(\''+this.label+'\')"',' role="button" aria-labelledby="',id,'_label" aria-describedby="',id,'_text" aria-haspopup="true"');if(CKEDITOR.env.opera||(CKEDITOR.env.gecko&&CKEDITOR.env.mac))
{output.push(' onkeypress="return false;"');}
if(CKEDITOR.env.gecko)
{output.push(' onblur="this.style.cssText = this.style.cssText;"');}
output.push(' onkeydown="CKEDITOR.tools.callFunction( ',keyDownFn,', event, this );"'+' onclick="CKEDITOR.tools.callFunction(',clickFn,', this); return false;">'+'<span>'+'<span id="'+id+'_text" class="cke_text cke_inline_label">'+this.label+'</span>'+'</span>'+'<span class=cke_openbutton>'+(CKEDITOR.env.hc?'<span>&#9660;</span>':'')+'</span>'+'</a>'+'</span>'+'</span>');if(this.onRender)
this.onRender();return instance;},createPanel:function(editor)
{if(this._.panel)
return;var panelDefinition=this._.panelDefinition,panelBlockDefinition=this._.panelDefinition.block,panelParentElement=panelDefinition.parent||CKEDITOR.document.getBody(),panel=new CKEDITOR.ui.floatPanel(editor,panelParentElement,panelDefinition),list=panel.addListBlock(this.id,panelBlockDefinition),me=this;panel.onShow=function()
{editor.fire('panelShow',{panel:this,me:me});if(me.className)
this.element.getFirst().addClass(me.className+'_panel');me.setState(CKEDITOR.TRISTATE_ON);list.focus(!me.multiSelect&&me.getValue());me._.on=1;if(me.onOpen)
me.onOpen();};panel.onHide=function()
{if(me.className)
this.element.getFirst().removeClass(me.className+'_panel');me.setState(CKEDITOR.TRISTATE_OFF);me._.on=0;if(me.onClose)
me.onClose();};panel.onEscape=function()
{panel.hide();me.document.getById('cke_'+me.id).getFirst().getNext().focus();};list.onClick=function(value,marked)
{editor.fire('panelClick',{panel:this,me:me,value:value});me.document.getWindow().focus();if(me.onClick)
me.onClick.call(me,value,marked);if(marked)
me.setValue(value,me._.items[value]);else
me.setValue('');panel.hide();};this._.panel=panel;this._.list=list;panel.getBlock(this.id).onHide=function()
{me._.on=0;me.setState(CKEDITOR.TRISTATE_OFF);};if(this.init)
this.init();},setValue:function(value,text)
{this._.value=value;var textElement=this.document.getById('cke_'+this.id+'_text');if(!(value||text))
{text=this.label;textElement.addClass('cke_inline_label');}
else
textElement.removeClass('cke_inline_label');textElement.setHtml(typeof text!='undefined'?text:value);},getValue:function()
{return this._.value||'';},unmarkAll:function()
{this._.list.unmarkAll();},mark:function(value)
{this._.list.mark(value);},hideItem:function(value)
{this._.list.hideItem(value);},hideGroup:function(groupTitle)
{this._.list.hideGroup(groupTitle);},showAll:function()
{this._.list.showAll();},add:function(value,html,text)
{this._.items[value]=text||value;this._.list.add(value,html,text);},startGroup:function(title)
{this._.list.startGroup(title);},commit:function()
{this._.list.commit();},setState:function(state)
{if(this._.state==state)
return;this.document.getById('cke_'+this.id).setState(state);this._.state=state;}}});CKEDITOR.ui.prototype.addRichCombo=function(name,definition)
{this.add(name,CKEDITOR.UI_RICHCOMBO,definition);};CKEDITOR.plugins.add('htmlwriter');CKEDITOR.htmlWriter=CKEDITOR.tools.createClass({base:CKEDITOR.htmlParser.basicWriter,$:function()
{this.base();this.indentationChars='\t';this.selfClosingEnd=' />';this.lineBreakChars='\n';this.forceSimpleAmpersand=false;this.sortAttributes=true;this._.indent=false;this._.indentation='';this._.rules={};var dtd=CKEDITOR.dtd;for(var e in CKEDITOR.tools.extend({},dtd.$nonBodyContent,dtd.$block,dtd.$listItem,dtd.$tableContent))
{this.setRules(e,{indent:true,breakBeforeOpen:true,breakAfterOpen:true,breakBeforeClose:!dtd[e]['#'],breakAfterClose:true});}
this.setRules('br',{breakAfterOpen:true});this.setRules('title',{indent:false,breakAfterOpen:false});this.setRules('style',{indent:false,breakBeforeClose:true});this.setRules('pre',{indent:false});},proto:{openTag:function(tagName,attributes)
{var rules=this._.rules[tagName];if(this._.indent)
this.indentation();else if(rules&&rules.breakBeforeOpen)
{this.lineBreak();this.indentation();}
this._.output.push('<',tagName);},openTagClose:function(tagName,isSelfClose)
{var rules=this._.rules[tagName];if(isSelfClose)
this._.output.push(this.selfClosingEnd);else
{this._.output.push('>');if(rules&&rules.indent)
this._.indentation+=this.indentationChars;}
if(rules&&rules.breakAfterOpen)
this.lineBreak();},attribute:function(attName,attValue)
{if(typeof attValue=='string')
{this.forceSimpleAmpersand&&(attValue=attValue.replace(/&amp;/g,'&'));attValue=CKEDITOR.tools.htmlEncodeAttr(attValue);}
this._.output.push(' ',attName,'="',attValue,'"');},closeTag:function(tagName)
{var rules=this._.rules[tagName];if(rules&&rules.indent)
this._.indentation=this._.indentation.substr(this.indentationChars.length);if(this._.indent)
this.indentation();else if(rules&&rules.breakBeforeClose)
{this.lineBreak();this.indentation();}
this._.output.push('</',tagName,'>');if(rules&&rules.breakAfterClose)
this.lineBreak();},text:function(text)
{if(this._.indent)
{this.indentation();text=CKEDITOR.tools.ltrim(text);}
this._.output.push(text);},comment:function(comment)
{if(this._.indent)
this.indentation();this._.output.push('<!--',comment,'-->');},lineBreak:function()
{if(this._.output.length>0)
this._.output.push(this.lineBreakChars);this._.indent=true;},indentation:function()
{this._.output.push(this._.indentation);this._.indent=false;},setRules:function(tagName,rules)
{var currentRules=this._.rules[tagName];if(currentRules)
CKEDITOR.tools.extend(currentRules,rules,true);else
this._.rules[tagName]=rules;}}});CKEDITOR.plugins.add('menubutton',{requires:['button','contextmenu'],beforeInit:function(editor)
{editor.ui.addHandler(CKEDITOR.UI_MENUBUTTON,CKEDITOR.ui.menuButton.handler);}});CKEDITOR.UI_MENUBUTTON=5;(function()
{var clickFn=function(editor)
{var _=this._;if(_.state===CKEDITOR.TRISTATE_DISABLED)
return;_.previousState=_.state;var menu=_.menu;if(!menu)
{menu=_.menu=new CKEDITOR.plugins.contextMenu(editor);menu.definition.panel.attributes['aria-label']=editor.lang.common.options;menu.onHide=CKEDITOR.tools.bind(function()
{this.setState(_.previousState);},this);if(this.onMenu)
{menu.addListener(this.onMenu);}}
if(_.on)
{menu.hide();return;}
this.setState(CKEDITOR.TRISTATE_ON);menu.show(CKEDITOR.document.getById(this._.id),4);};CKEDITOR.ui.menuButton=CKEDITOR.tools.createClass({base:CKEDITOR.ui.button,$:function(definition)
{var panelDefinition=definition.panel;delete definition.panel;this.base(definition);this.hasArrow=true;this.click=clickFn;},statics:{handler:{create:function(definition)
{return new CKEDITOR.ui.menuButton(definition);}}}});})();CKEDITOR.plugins.add('dialogui');(function()
{var initPrivateObject=function(elementDefinition)
{this._||(this._={});this._['default']=this._.initValue=elementDefinition['default']||'';this._.required=elementDefinition['required']||false;var args=[this._];for(var i=1;i<arguments.length;i++)
args.push(arguments[i]);args.push(true);CKEDITOR.tools.extend.apply(CKEDITOR.tools,args);return this._;},textBuilder={build:function(dialog,elementDefinition,output)
{return new CKEDITOR.ui.dialog.textInput(dialog,elementDefinition,output);}},commonBuilder={build:function(dialog,elementDefinition,output)
{return new CKEDITOR.ui.dialog[elementDefinition.type](dialog,elementDefinition,output);}},containerBuilder={build:function(dialog,elementDefinition,output)
{var children=elementDefinition.children,child,childHtmlList=[],childObjList=[];for(var i=0;(i<children.length&&(child=children[i]));i++)
{var childHtml=[];childHtmlList.push(childHtml);childObjList.push(CKEDITOR.dialog._.uiElementBuilders[child.type].build(dialog,child,childHtml));}
return new CKEDITOR.ui.dialog[elementDefinition.type](dialog,childObjList,childHtmlList,output,elementDefinition);}},commonPrototype={isChanged:function()
{return this.getValue()!=this.getInitValue();},reset:function()
{this.setValue(this.getInitValue());},setInitValue:function()
{this._.initValue=this.getValue();},resetInitValue:function()
{this._.initValue=this._['default'];},getInitValue:function()
{return this._.initValue;}},commonEventProcessors=CKEDITOR.tools.extend({},CKEDITOR.ui.dialog.uiElement.prototype.eventProcessors,{onChange:function(dialog,func)
{if(!this._.domOnChangeRegistered)
{dialog.on('load',function()
{this.getInputElement().on('change',function(){this.fire('change',{value:this.getValue()});},this);},this);this._.domOnChangeRegistered=true;}
this.on('change',func);}},true),eventRegex=/^on([A-Z]\w+)/,cleanInnerDefinition=function(def)
{for(var i in def)
{if(eventRegex.test(i)||i=='title'||i=='type')
delete def[i];}
return def;};CKEDITOR.tools.extend(CKEDITOR.ui.dialog,{labeledElement:function(dialog,elementDefinition,htmlList,contentHtml)
{if(arguments.length<4)
return;var _=initPrivateObject.call(this,elementDefinition);_.labelId=CKEDITOR.tools.getNextNumber()+'_label';var children=this._.children=[];var innerHTML=function()
{var html=[];if(elementDefinition.labelLayout!='horizontal')
html.push('<label class="cke_dialog_ui_labeled_label" ',' id="'+_.labelId+'"',' for="'+_.inputId+'"',' style="'+elementDefinition.labelStyle+'">',elementDefinition.label,'</label>','<div class="cke_dialog_ui_labeled_content" role="presentation">',contentHtml.call(this,dialog,elementDefinition),'</div>');else
{var hboxDefinition={type:'hbox',widths:elementDefinition.widths,padding:0,children:[{type:'html',html:'<label class="cke_dialog_ui_labeled_label"'+' id="'+_.labelId+'"'+' for="'+_.inputId+'"'+' style="'+elementDefinition.labelStyle+'">'+
CKEDITOR.tools.htmlEncode(elementDefinition.label)+'</span>'},{type:'html',html:'<span class="cke_dialog_ui_labeled_content">'+
contentHtml.call(this,dialog,elementDefinition)+'</span>'}]};CKEDITOR.dialog._.uiElementBuilders.hbox.build(dialog,hboxDefinition,html);}
return html.join('');};CKEDITOR.ui.dialog.uiElement.call(this,dialog,elementDefinition,htmlList,'div',null,{role:'presentation'},innerHTML);},textInput:function(dialog,elementDefinition,htmlList)
{if(arguments.length<3)
return;initPrivateObject.call(this,elementDefinition);var domId=this._.inputId=CKEDITOR.tools.getNextNumber()+'_textInput',attributes={'class':'cke_dialog_ui_input_'+elementDefinition.type,id:domId,type:'text'},i;if(elementDefinition.validate)
this.validate=elementDefinition.validate;if(elementDefinition.maxLength)
attributes.maxlength=elementDefinition.maxLength;if(elementDefinition.size)
attributes.size=elementDefinition.size;var me=this,keyPressedOnMe=false;dialog.on('load',function()
{me.getInputElement().on('keydown',function(evt)
{if(evt.data.getKeystroke()==13)
keyPressedOnMe=true;});me.getInputElement().on('keyup',function(evt)
{if(evt.data.getKeystroke()==13&&keyPressedOnMe)
{dialog.getButton('ok')&&setTimeout(function()
{dialog.getButton('ok').click();},0);keyPressedOnMe=false;}},null,null,1000);});var innerHTML=function()
{var html=['<div class="cke_dialog_ui_input_',elementDefinition.type,'" role="presentation"'];if(elementDefinition.width)
html.push('style="width:'+elementDefinition.width+'" ');html.push('><input ');attributes['aria-labelledby']=this._.labelId;this._.required&&(attributes['aria-required']=this._.required);for(var i in attributes)
html.push(i+'="'+attributes[i]+'" ');html.push(' /></div>');return html.join('');};CKEDITOR.ui.dialog.labeledElement.call(this,dialog,elementDefinition,htmlList,innerHTML);},textarea:function(dialog,elementDefinition,htmlList)
{if(arguments.length<3)
return;initPrivateObject.call(this,elementDefinition);var me=this,domId=this._.inputId=CKEDITOR.tools.getNextNumber()+'_textarea',attributes={};if(elementDefinition.validate)
this.validate=elementDefinition.validate;attributes.rows=elementDefinition.rows||5;attributes.cols=elementDefinition.cols||20;var innerHTML=function()
{attributes['aria-labelledby']=this._.labelId;this._.required&&(attributes['aria-required']=this._.required);var html=['<div class="cke_dialog_ui_input_textarea" role="presentation"><textarea class="cke_dialog_ui_input_textarea" id="',domId,'" '];for(var i in attributes)
html.push(i+'="'+CKEDITOR.tools.htmlEncode(attributes[i])+'" ');html.push('>',CKEDITOR.tools.htmlEncode(me._['default']),'</textarea></div>');return html.join('');};CKEDITOR.ui.dialog.labeledElement.call(this,dialog,elementDefinition,htmlList,innerHTML);},checkbox:function(dialog,elementDefinition,htmlList)
{if(arguments.length<3)
return;var _=initPrivateObject.call(this,elementDefinition,{'default':!!elementDefinition['default']});if(elementDefinition.validate)
this.validate=elementDefinition.validate;var innerHTML=function()
{var myDefinition=CKEDITOR.tools.extend({},elementDefinition,{id:elementDefinition.id?elementDefinition.id+'_checkbox':CKEDITOR.tools.getNextNumber()+'_checkbox'},true),html=[];var labelId=CKEDITOR.tools.getNextNumber()+'_label';var attributes={'class':'cke_dialog_ui_checkbox_input',type:'checkbox','aria-labelledby':labelId};cleanInnerDefinition(myDefinition);if(elementDefinition['default'])
attributes.checked='checked';_.checkbox=new CKEDITOR.ui.dialog.uiElement(dialog,myDefinition,html,'input',null,attributes);html.push(' <label id="',labelId,'" for="',attributes.id,'">',CKEDITOR.tools.htmlEncode(elementDefinition.label),'</label>');return html.join('');};CKEDITOR.ui.dialog.uiElement.call(this,dialog,elementDefinition,htmlList,'span',null,null,innerHTML);},radio:function(dialog,elementDefinition,htmlList)
{if(arguments.length<3)
return;initPrivateObject.call(this,elementDefinition);if(!this._['default'])
this._['default']=this._.initValue=elementDefinition.items[0][1];if(elementDefinition.validate)
this.validate=elementDefinition.valdiate;var children=[],me=this;var innerHTML=function()
{var inputHtmlList=[],html=[],commonAttributes={'class':'cke_dialog_ui_radio_item','aria-labelledby':this._.labelId},commonName=elementDefinition.id?elementDefinition.id+'_radio':CKEDITOR.tools.getNextNumber()+'_radio';for(var i=0;i<elementDefinition.items.length;i++)
{var item=elementDefinition.items[i],title=item[2]!==undefined?item[2]:item[0],value=item[1]!==undefined?item[1]:item[0],inputId=CKEDITOR.tools.getNextNumber()+'_radio_input',labelId=inputId+'_label',inputDefinition=CKEDITOR.tools.extend({},elementDefinition,{id:inputId,title:null,type:null},true),labelDefinition=CKEDITOR.tools.extend({},inputDefinition,{title:title},true),inputAttributes={type:'radio','class':'cke_dialog_ui_radio_input',name:commonName,value:value,'aria-labelledby':labelId},inputHtml=[];if(me._['default']==value)
inputAttributes.checked='checked';cleanInnerDefinition(inputDefinition);cleanInnerDefinition(labelDefinition);children.push(new CKEDITOR.ui.dialog.uiElement(dialog,inputDefinition,inputHtml,'input',null,inputAttributes));inputHtml.push(' ');new CKEDITOR.ui.dialog.uiElement(dialog,labelDefinition,inputHtml,'label',null,{id:labelId,'for':inputAttributes.id},item[0]);inputHtmlList.push(inputHtml.join(''));}
new CKEDITOR.ui.dialog.hbox(dialog,[],inputHtmlList,html);return html.join('');};CKEDITOR.ui.dialog.labeledElement.call(this,dialog,elementDefinition,htmlList,innerHTML);this._.children=children;},button:function(dialog,elementDefinition,htmlList)
{if(!arguments.length)
return;if(typeof elementDefinition=='function')
elementDefinition=elementDefinition(dialog.getParentEditor());initPrivateObject.call(this,elementDefinition,{disabled:elementDefinition.disabled||false});CKEDITOR.event.implementOn(this);var me=this;dialog.on('load',function(eventInfo)
{var element=this.getElement();(function()
{element.on('click',function(evt)
{me.fire('click',{dialog:me.getDialog()});evt.data.preventDefault();});element.on('keydown',function(evt)
{if(evt.data.getKeystroke()in{32:1,13:1})
{me.click();evt.data.preventDefault();}});})();element.unselectable();},this);if(typeof elementDefinition['class']!='undefined'){elementDefinition['class']=elementDefinition['class'].replace(/cke_dialog_ui_button_cancel/,'secondary').replace(/cke_dialog_ui_button_(\w+)/,'')
+' wikia-button';}
if(typeof elementDefinition['className']!='undefined'){elementDefinition['className']+=' wikia-button';if(typeof elementDefinition['buttonType']!='undefined'){elementDefinition['className']+=' '+elementDefinition['buttonType'];}}
else{elementDefinition['className']='wikia-button';}
var outerDefinition=CKEDITOR.tools.extend({},elementDefinition);delete outerDefinition.style;var labelId=CKEDITOR.tools.getNextNumber()+'_label';CKEDITOR.ui.dialog.uiElement.call(this,dialog,outerDefinition,htmlList,'a',null,{style:elementDefinition.style,href:'javascript:void(0)',title:elementDefinition.label,hidefocus:'true','class':elementDefinition['class'],role:'button','aria-labelledby':labelId},'<span id="'+labelId+'" class="cke_dialog_ui_button">'+
CKEDITOR.tools.htmlEncode(elementDefinition.label)+'</span>');},select:function(dialog,elementDefinition,htmlList)
{if(arguments.length<3)
return;var _=initPrivateObject.call(this,elementDefinition);if(elementDefinition.validate)
this.validate=elementDefinition.validate;_.inputId=CKEDITOR.tools.getNextNumber()+'_select';var innerHTML=function()
{var myDefinition=CKEDITOR.tools.extend({},elementDefinition,{id:elementDefinition.id?elementDefinition.id+'_select':CKEDITOR.tools.getNextNumber()+'_select'},true),html=[],innerHTML=[],attributes={'id':_.inputId,'class':'cke_dialog_ui_input_select','aria-labelledby':this._.labelId};if(elementDefinition.size!=undefined)
attributes.size=elementDefinition.size;if(elementDefinition.multiple!=undefined)
attributes.multiple=elementDefinition.multiple;cleanInnerDefinition(myDefinition);for(var i=0,item;i<elementDefinition.items.length&&(item=elementDefinition.items[i]);i++)
{innerHTML.push('<option value="',CKEDITOR.tools.htmlEncode(item[1]!==undefined?item[1]:item[0]),'" /> ',CKEDITOR.tools.htmlEncode(item[0]));}
_.select=new CKEDITOR.ui.dialog.uiElement(dialog,myDefinition,html,'select',null,attributes,innerHTML.join(''));return html.join('');};CKEDITOR.ui.dialog.labeledElement.call(this,dialog,elementDefinition,htmlList,innerHTML);},file:function(dialog,elementDefinition,htmlList)
{if(arguments.length<3)
return;if(elementDefinition['default']===undefined)
elementDefinition['default']='';var _=CKEDITOR.tools.extend(initPrivateObject.call(this,elementDefinition),{definition:elementDefinition,buttons:[]});if(elementDefinition.validate)
this.validate=elementDefinition.validate;var innerHTML=function()
{_.frameId=CKEDITOR.tools.getNextNumber()+'_fileInput';var isCustomDomain=CKEDITOR.env.isCustomDomain();var html=['<iframe'+' frameborder="0"'+' allowtransparency="0"'+' class="cke_dialog_ui_input_file"'+' id="',_.frameId,'"'+' title="',elementDefinition.label,'"'+' src="javascript:void('];html.push(isCustomDomain?'(function(){'+'document.open();'+'document.domain=\''+document.domain+'\';'+'document.close();'+'})()':'0');html.push(')">'+'</iframe>');return html.join('');};dialog.on('load',function()
{var iframe=CKEDITOR.document.getById(_.frameId),contentDiv=iframe.getParent();contentDiv.addClass('cke_dialog_ui_input_file');});CKEDITOR.ui.dialog.labeledElement.call(this,dialog,elementDefinition,htmlList,innerHTML);},fileButton:function(dialog,elementDefinition,htmlList)
{if(arguments.length<3)
return;var _=initPrivateObject.call(this,elementDefinition),me=this;if(elementDefinition.validate)
this.validate=elementDefinition.validate;var myDefinition=CKEDITOR.tools.extend({},elementDefinition);var onClick=myDefinition.onClick;myDefinition.className=(myDefinition.className?myDefinition.className+' ':'')+'cke_dialog_ui_button';myDefinition.onClick=function(evt)
{var target=elementDefinition['for'];if(!onClick||onClick.call(this,evt)!==false)
{dialog.getContentElement(target[0],target[1]).submit();this.disable();}};dialog.on('load',function()
{dialog.getContentElement(elementDefinition['for'][0],elementDefinition['for'][1])._.buttons.push(me);});CKEDITOR.ui.dialog.button.call(this,dialog,myDefinition,htmlList);},html:(function()
{var myHtmlRe=/^\s*<[\w:]+\s+([^>]*)?>/,theirHtmlRe=/^(\s*<[\w:]+(?:\s+[^>]*)?)((?:.|\r|\n)+)$/,emptyTagRe=/\/$/;return function(dialog,elementDefinition,htmlList)
{if(arguments.length<3)
return;var myHtmlList=[],myHtml,theirHtml=elementDefinition.html,myMatch,theirMatch;if(theirHtml.charAt(0)!='<')
theirHtml='<span>'+theirHtml+'</span>';var focus=elementDefinition.focus;if(focus)
{var oldFocus=this.focus;this.focus=function()
{oldFocus.call(this);typeof focus=='function'&&focus.call(this);this.fire('focus');};if(elementDefinition.isFocusable)
{var oldIsFocusable=this.isFocusable;this.isFocusable=oldIsFocusable;}
this.keyboardFocusable=true;}
CKEDITOR.ui.dialog.uiElement.call(this,dialog,elementDefinition,myHtmlList,'span',null,null,'');myHtml=myHtmlList.join('');myMatch=myHtml.match(myHtmlRe);theirMatch=theirHtml.match(theirHtmlRe)||['','',''];if(emptyTagRe.test(theirMatch[1]))
{theirMatch[1]=theirMatch[1].slice(0,-1);theirMatch[2]='/'+theirMatch[2];}
htmlList.push([theirMatch[1],' ',myMatch[1]||'',theirMatch[2]].join(''));};})(),fieldset:function(dialog,childObjList,childHtmlList,htmlList,elementDefinition)
{var legendLabel=elementDefinition.label;var innerHTML=function()
{var html=[];legendLabel&&html.push('<legend>'+legendLabel+'</legend>');for(var i=0;i<childHtmlList.length;i++)
html.push(childHtmlList[i]);return html.join('');};this._={children:childObjList};CKEDITOR.ui.dialog.uiElement.call(this,dialog,elementDefinition,htmlList,'fieldset',null,null,innerHTML);}},true);CKEDITOR.ui.dialog.html.prototype=new CKEDITOR.ui.dialog.uiElement;CKEDITOR.ui.dialog.labeledElement.prototype=CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.uiElement,{setLabel:function(label)
{var node=CKEDITOR.document.getById(this._.labelId);if(node.getChildCount()<1)
(new CKEDITOR.dom.text(label,CKEDITOR.document)).appendTo(node);else
node.getChild(0).$.nodeValue=label;return this;},getLabel:function()
{var node=CKEDITOR.document.getById(this._.labelId);if(!node||node.getChildCount()<1)
return'';else
return node.getChild(0).getText();},eventProcessors:commonEventProcessors},true);CKEDITOR.ui.dialog.button.prototype=CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.uiElement,{click:function()
{if(!this._.disabled)
return this.fire('click',{dialog:this._.dialog});this.getElement().$.blur();return false;},enable:function()
{this._.disabled=false;var element=this.getElement();element&&element.removeClass('disabled');},disable:function()
{this._.disabled=true;this.getElement().addClass('disabled');},isVisible:function()
{return this.getElement().getFirst().isVisible();},isEnabled:function()
{return!this._.disabled;},eventProcessors:CKEDITOR.tools.extend({},CKEDITOR.ui.dialog.uiElement.prototype.eventProcessors,{onClick:function(dialog,func)
{this.on('click',func);}},true),accessKeyUp:function()
{this.click();},accessKeyDown:function()
{this.focus();},keyboardFocusable:true},true);CKEDITOR.ui.dialog.textInput.prototype=CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.labeledElement,{getInputElement:function()
{return CKEDITOR.document.getById(this._.inputId);},focus:function()
{var me=this.selectParentTab();setTimeout(function()
{var element=me.getInputElement();element&&element.$.focus();},0);},select:function()
{var me=this.selectParentTab();setTimeout(function()
{var e=me.getInputElement();if(e)
{e.$.focus();e.$.select();}},0);},accessKeyUp:function()
{this.select();},setValue:function(value)
{!value&&(value='');return CKEDITOR.ui.dialog.uiElement.prototype.setValue.call(this,value);},keyboardFocusable:true},commonPrototype,true);CKEDITOR.ui.dialog.textarea.prototype=new CKEDITOR.ui.dialog.textInput();CKEDITOR.ui.dialog.select.prototype=CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.labeledElement,{getInputElement:function()
{return this._.select.getElement();},add:function(label,value,index)
{var option=new CKEDITOR.dom.element('option',this.getDialog().getParentEditor().document),selectElement=this.getInputElement().$;option.$.text=label;option.$.value=(value===undefined||value===null)?label:value;if(index===undefined||index===null)
{if(CKEDITOR.env.ie)
selectElement.add(option.$);else
selectElement.add(option.$,null);}
else
selectElement.add(option.$,index);return this;},remove:function(index)
{var selectElement=this.getInputElement().$;selectElement.remove(index);return this;},clear:function()
{var selectElement=this.getInputElement().$;while(selectElement.length>0)
selectElement.remove(0);return this;},keyboardFocusable:true},commonPrototype,true);CKEDITOR.ui.dialog.checkbox.prototype=CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.uiElement,{getInputElement:function()
{return this._.checkbox.getElement();},setValue:function(checked)
{this.getInputElement().$.checked=checked;this.fire('change',{value:checked});},getValue:function()
{return this.getInputElement().$.checked;},accessKeyUp:function()
{this.setValue(!this.getValue());},eventProcessors:{onChange:function(dialog,func)
{if(!CKEDITOR.env.ie)
return commonEventProcessors.onChange.apply(this,arguments);else
{dialog.on('load',function()
{var element=this._.checkbox.getElement();element.on('propertychange',function(evt)
{evt=evt.data.$;if(evt.propertyName=='checked')
this.fire('change',{value:element.$.checked});},this);},this);this.on('change',func);}
return null;}},keyboardFocusable:true},commonPrototype,true);CKEDITOR.ui.dialog.radio.prototype=CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.uiElement,{setValue:function(value)
{var children=this._.children,item;for(var i=0;(i<children.length)&&(item=children[i]);i++)
item.getElement().$.checked=(item.getValue()==value);this.fire('change',{value:value});},getValue:function()
{var children=this._.children;for(var i=0;i<children.length;i++)
{if(children[i].getElement().$.checked)
return children[i].getValue();}
return null;},accessKeyUp:function()
{var children=this._.children,i;for(i=0;i<children.length;i++)
{if(children[i].getElement().$.checked)
{children[i].getElement().focus();return;}}
children[0].getElement().focus();},eventProcessors:{onChange:function(dialog,func)
{if(!CKEDITOR.env.ie)
return commonEventProcessors.onChange.apply(this,arguments);else
{dialog.on('load',function()
{var children=this._.children,me=this;for(var i=0;i<children.length;i++)
{var element=children[i].getElement();element.on('propertychange',function(evt)
{evt=evt.data.$;if(evt.propertyName=='checked'&&this.$.checked)
me.fire('change',{value:this.getAttribute('value')});});}},this);this.on('change',func);}
return null;}},keyboardFocusable:true},commonPrototype,true);CKEDITOR.ui.dialog.file.prototype=CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.labeledElement,commonPrototype,{getInputElement:function()
{var frameDocument=CKEDITOR.document.getById(this._.frameId).getFrameDocument();return frameDocument.$.forms.length>0?new CKEDITOR.dom.element(frameDocument.$.forms[0].elements[0]):this.getElement();},submit:function()
{this.getInputElement().getParent().$.submit();return this;},getAction:function(action)
{return this.getInputElement().getParent().$.action;},reset:function()
{var frameElement=CKEDITOR.document.getById(this._.frameId),frameDocument=frameElement.getFrameDocument(),elementDefinition=this._.definition,buttons=this._.buttons;function generateFormField()
{frameDocument.$.open();if(CKEDITOR.env.isCustomDomain())
frameDocument.$.domain=document.domain;var size='';if(elementDefinition.size)
size=elementDefinition.size-(CKEDITOR.env.ie?7:0);frameDocument.$.write(['<html><head><title></title></head><body style="margin: 0; overflow: hidden; background: transparent;">','<form enctype="multipart/form-data" method="POST" action="',CKEDITOR.tools.htmlEncode(elementDefinition.action),'">','<input type="file" name="',CKEDITOR.tools.htmlEncode(elementDefinition.id||'cke_upload'),'" size="',CKEDITOR.tools.htmlEncode(size>0?size:""),'" />','</form>','</body></html>'].join(''));frameDocument.$.close();for(var i=0;i<buttons.length;i++)
buttons[i].enable();}
if(CKEDITOR.env.gecko)
setTimeout(generateFormField,500);else
generateFormField();},getValue:function()
{return'';},eventProcessors:commonEventProcessors,keyboardFocusable:true},true);CKEDITOR.ui.dialog.fileButton.prototype=new CKEDITOR.ui.dialog.button;CKEDITOR.ui.dialog.fieldset.prototype=CKEDITOR.tools.clone(CKEDITOR.ui.dialog.hbox.prototype);CKEDITOR.dialog.addUIElement('text',textBuilder);CKEDITOR.dialog.addUIElement('password',textBuilder);CKEDITOR.dialog.addUIElement('textarea',commonBuilder);CKEDITOR.dialog.addUIElement('checkbox',commonBuilder);CKEDITOR.dialog.addUIElement('radio',commonBuilder);CKEDITOR.dialog.addUIElement('button',commonBuilder);CKEDITOR.dialog.addUIElement('select',commonBuilder);CKEDITOR.dialog.addUIElement('file',commonBuilder);CKEDITOR.dialog.addUIElement('fileButton',commonBuilder);CKEDITOR.dialog.addUIElement('html',commonBuilder);CKEDITOR.dialog.addUIElement('fieldset',containerBuilder);})();CKEDITOR.plugins.add('panel',{beforeInit:function(editor)
{editor.ui.addHandler(CKEDITOR.UI_PANEL,CKEDITOR.ui.panel.handler);}});CKEDITOR.UI_PANEL=2;CKEDITOR.ui.panel=function(document,definition)
{if(definition)
CKEDITOR.tools.extend(this,definition);CKEDITOR.tools.extend(this,{className:'',css:[]});this.id=CKEDITOR.tools.getNextNumber();this.document=document;this._={blocks:{}};};CKEDITOR.ui.panel.handler={create:function(definition)
{return new CKEDITOR.ui.panel(definition);}};CKEDITOR.ui.panel.prototype={renderHtml:function(editor)
{var output=[];this.render(editor,output);return output.join('');},render:function(editor,output)
{var id='cke_'+this.id;output.push('<div class="',editor.skinClass,'"'+' lang="',editor.langCode,'"'+' role="presentation"'+' style="display:none;z-index:'+(editor.config.baseFloatZIndex+1)+'">'+'<div'+' id=',id,' dir=',editor.lang.dir,' role="presentation"'+' class="cke_panel cke_',editor.lang.dir);if(this.className)
output.push(' ',this.className);output.push('">');if(this.forceIFrame||this.css.length)
{output.push('<iframe id="',id,'_frame"'+' frameborder="0"'+' role="application" src="javascript:void(');output.push(CKEDITOR.env.isCustomDomain()?'(function(){'+'document.open();'+'document.domain=\''+document.domain+'\';'+'document.close();'+'})()':'0');output.push(')"></iframe>');}
output.push('</div>'+'</div>');return id;},getHolderElement:function()
{var holder=this._.holder;if(!holder)
{if(this.forceIFrame||this.css.length)
{var iframe=this.document.getById('cke_'+this.id+'_frame'),parentDiv=iframe.getParent(),dir=parentDiv.getAttribute('dir'),className=parentDiv.getParent().getAttribute('class'),langCode=parentDiv.getParent().getAttribute('lang'),doc=iframe.getFrameDocument();doc.$.open();if(CKEDITOR.env.isCustomDomain())
doc.$.domain=document.domain;var onLoad=CKEDITOR.tools.addFunction(CKEDITOR.tools.bind(function(ev)
{this.isLoaded=true;if(this.onLoad)
this.onLoad();},this));doc.$.write('<!DOCTYPE html>'+'<html dir="'+dir+'" class="'+className+'_container" lang="'+langCode+'">'+'<head>'+'<style>.'+className+'_container{visibility:hidden}</style>'+'</head>'+'<body class="cke_'+dir+' cke_panel_frame '+CKEDITOR.env.cssClass+'" style="margin:0;padding:0"'+' onload="( window.CKEDITOR || window.parent.CKEDITOR ).tools.callFunction('+onLoad+');"></body>'+
CKEDITOR.tools.buildStyleHtml(this.css)+'<\/html>');doc.$.close();var win=doc.getWindow();win.$.CKEDITOR=CKEDITOR;doc.on('keydown',function(evt)
{var keystroke=evt.data.getKeystroke(),dir=this.document.getById('cke_'+this.id).getAttribute('dir');if(this._.onKeyDown&&this._.onKeyDown(keystroke)===false)
{evt.data.preventDefault();return;}
if(keystroke==27||keystroke==(dir=='rtl'?39:37))
{if(this.onEscape&&this.onEscape(keystroke)===false)
evt.data.preventDefault();}},this);holder=doc.getBody();}
else
holder=this.document.getById('cke_'+this.id);this._.holder=holder;}
return holder;},addBlock:function(name,block)
{block=this._.blocks[name]=block instanceof CKEDITOR.ui.panel.block?block:new CKEDITOR.ui.panel.block(this.getHolderElement(),block);if(!this._.currentBlock)
this.showBlock(name);return block;},getBlock:function(name)
{return this._.blocks[name];},showBlock:function(name)
{var blocks=this._.blocks,block=blocks[name],current=this._.currentBlock,holder=this.forceIFrame?this.document.getById('cke_'+this.id+'_frame'):this._.holder;holder.getParent().getParent().disableContextMenu();if(current)
{holder.removeAttributes(current.attributes);current.hide();}
this._.currentBlock=block;holder.setAttributes(block.attributes);CKEDITOR.fire('ariaWidget',holder);block._.focusIndex=-1;this._.onKeyDown=block.onKeyDown&&CKEDITOR.tools.bind(block.onKeyDown,block);block.onMark=function(item)
{holder.setAttribute('aria-activedescendant',item.getId()+'_option');};block.onUnmark=function()
{holder.removeAttribute('aria-activedescendant');};block.show();return block;},destroy:function()
{this.element&&this.element.remove();}};CKEDITOR.ui.panel.block=CKEDITOR.tools.createClass({$:function(blockHolder,blockDefinition)
{this.element=blockHolder.append(blockHolder.getDocument().createElement('div',{attributes:{'tabIndex':-1,'class':'cke_panel_block','role':'presentation'},styles:{display:'none'}}));if(blockDefinition)
CKEDITOR.tools.extend(this,blockDefinition);if(!this.attributes.title)
this.attributes.title=this.attributes['aria-label'];this.keys={};this._.focusIndex=-1;this.element.disableContextMenu();},_:{markItem:function(index)
{if(index==-1)
return;var links=this.element.getElementsByTag('a');var item=links.getItem(this._.focusIndex=index);if(CKEDITOR.env.webkit)
item.getDocument().getWindow().focus();item.focus();this.onMark&&this.onMark(item);}},proto:{show:function()
{this.element.setStyle('display','');},hide:function()
{if(!this.onHide||this.onHide.call(this)!==true)
this.element.setStyle('display','none');},onKeyDown:function(keystroke)
{var keyAction=this.keys[keystroke];switch(keyAction)
{case'next':var index=this._.focusIndex,links=this.element.getElementsByTag('a'),link;while((link=links.getItem(++index)))
{if(link.getAttribute('_cke_focus')&&link.$.offsetWidth)
{this._.focusIndex=index;link.focus();break;}}
return false;case'prev':index=this._.focusIndex;links=this.element.getElementsByTag('a');while(index>0&&(link=links.getItem(--index)))
{if(link.getAttribute('_cke_focus')&&link.$.offsetWidth)
{this._.focusIndex=index;link.focus();break;}}
return false;case'click':index=this._.focusIndex;link=index>=0&&this.element.getElementsByTag('a').getItem(index);if(link)
link.$.click?link.$.click():link.$.onclick();return false;}
return true;}}});CKEDITOR.plugins.add('listblock',{requires:['panel'],onLoad:function()
{CKEDITOR.ui.panel.prototype.addListBlock=function(name,definition)
{return this.addBlock(name,new CKEDITOR.ui.listBlock(this.getHolderElement(),definition));};CKEDITOR.ui.listBlock=CKEDITOR.tools.createClass({base:CKEDITOR.ui.panel.block,$:function(blockHolder,blockDefinition)
{blockDefinition=blockDefinition||{};var attribs=blockDefinition.attributes||(blockDefinition.attributes={});(this.multiSelect=!!blockDefinition.multiSelect)&&(attribs['aria-multiselectable']=true);!attribs.role&&(attribs.role='listbox');this.base.apply(this,arguments);var keys=this.keys;keys[40]='next';keys[9]='next';keys[38]='prev';keys[CKEDITOR.SHIFT+9]='prev';keys[32]='click';this._.pendingHtml=[];this._.items={};this._.groups={};},_:{close:function()
{if(this._.started)
{this._.pendingHtml.push('</ul>');delete this._.started;}},getClick:function()
{if(!this._.click)
{this._.click=CKEDITOR.tools.addFunction(function(value)
{var marked=true;if(this.multiSelect)
marked=this.toggle(value);else
this.mark(value);if(this.onClick)
this.onClick(value,marked);},this);}
return this._.click;}},proto:{add:function(value,html,title)
{var pendingHtml=this._.pendingHtml,id='cke_'+CKEDITOR.tools.getNextNumber();if(!this._.started)
{pendingHtml.push('<ul role="presentation" class=cke_panel_list>');this._.started=1;this._.size=this._.size||0;}
this._.items[value]=id;pendingHtml.push('<li id=',id,' class=cke_panel_listItem>'+'<a id="',id,'_option" _cke_focus=1 hidefocus=true'+' title="',title||value,'"'+' href="javascript:void(\'',value,'\')"'+' onclick="CKEDITOR.tools.callFunction(',this._.getClick(),',\'',value,'\'); return false;"',' role="option"'+' aria-posinset="'+(++this._.size)+'">',html||value,'</a>'+'</li>');},startGroup:function(title)
{this._.close();var id='cke_'+CKEDITOR.tools.getNextNumber();this._.groups[title]=id;this._.pendingHtml.push('<h1 role="presentation" id=',id,' class=cke_panel_grouptitle>',title,'</h1>');},commit:function()
{this._.close();this.element.appendHtml(this._.pendingHtml.join(''));var items=this._.items,doc=this.element.getDocument();for(var value in items)
doc.getById(items[value]+'_option').setAttribute('aria-setsize',this._.size);delete this._.size;this._.pendingHtml=[];},toggle:function(value)
{var isMarked=this.isMarked(value);if(isMarked)
this.unmark(value);else
this.mark(value);return!isMarked;},hideGroup:function(groupTitle)
{var group=this.element.getDocument().getById(this._.groups[groupTitle]),list=group&&group.getNext();if(group)
{group.setStyle('display','none');if(list&&list.getName()=='ul')
list.setStyle('display','none');}},hideItem:function(value)
{this.element.getDocument().getById(this._.items[value]).setStyle('display','none');},showAll:function()
{var items=this._.items,groups=this._.groups,doc=this.element.getDocument();for(var value in items)
{doc.getById(items[value]).setStyle('display','');}
for(var title in groups)
{var group=doc.getById(groups[title]),list=group.getNext();group.setStyle('display','');if(list&&list.getName()=='ul')
list.setStyle('display','');}},mark:function(value)
{if(!this.multiSelect)
this.unmarkAll();var itemId=this._.items[value],item=this.element.getDocument().getById(itemId);item.addClass('cke_selected');this.element.getDocument().getById(itemId+'_option').setAttribute('aria-selected',true);this.element.setAttribute('aria-activedescendant',itemId+'_option');this.onMark&&this.onMark(item);},unmark:function(value)
{this.element.getDocument().getById(this._.items[value]).removeClass('cke_selected');this.onUnmark&&this.onUnmark(this._.items[value]);},unmarkAll:function()
{var items=this._.items,doc=this.element.getDocument();for(var value in items)
{doc.getById(items[value]).removeClass('cke_selected');}
this.onUnmark&&this.onUnmark();},isMarked:function(value)
{return this.element.getDocument().getById(this._.items[value]).hasClass('cke_selected');},focus:function(value)
{this._.focusIndex=-1;if(value)
{var selected=this.element.getDocument().getById(this._.items[value]).getFirst();var links=this.element.getElementsByTag('a'),link,i=-1;while((link=links.getItem(++i)))
{if(link.equals(selected))
{this._.focusIndex=i;break;}}
setTimeout(function()
{selected.focus();},0);}}}});}});CKEDITOR.themes.add('default',(function()
{function checkSharedSpace(editor,spaceName)
{var container,element;element=editor.config.sharedSpaces;element=element&&element[spaceName];element=element&&CKEDITOR.document.getById(element);if(element)
{var html='<span class="cke_shared">'+'<span class="'+editor.skinClass+' cke_editor_'+editor.name+'">'+'<span class="'+CKEDITOR.env.cssClass+'">'+'<span class="cke_wrapper cke_'+editor.lang.dir+'">'+'<span class="cke_editor">'+'<div class="cke_'+spaceName+'">'+'</div></span></span></span></span></span>';var mainContainer=element.append(CKEDITOR.dom.element.createFromHtml(html,element.getDocument()));if(element.getCustomData('cke_hasshared'))
mainContainer.hide();else
element.setCustomData('cke_hasshared',1);container=mainContainer.getChild([0,0,0,0]);editor.on('focus',function()
{for(var i=0,sibling,children=element.getChildren();(sibling=children.getItem(i));i++)
{if(sibling.type==CKEDITOR.NODE_ELEMENT&&!sibling.equals(mainContainer)&&sibling.hasClass('cke_shared'))
{sibling.hide();}}
mainContainer.show();});editor.on('destroy',function()
{mainContainer.remove();});}
return container;}
return{build:function(editor,themePath)
{var name=editor.name,element=editor.element,elementMode=editor.elementMode;if(!element||elementMode==CKEDITOR.ELEMENT_MODE_NONE)
return;if(elementMode==CKEDITOR.ELEMENT_MODE_REPLACE)
element.hide();var topHtml=editor.fire('themeSpace',{space:'top',html:''}).html;var contentsHtml=editor.fire('themeSpace',{space:'contents',html:''}).html;var bottomHtml=editor.fireOnce('themeSpace',{space:'bottom',html:''}).html;var height=contentsHtml&&editor.config.height;var tabIndex=editor.config.tabIndex||editor.element.getAttribute('tabindex')||0;if(!contentsHtml)
height='auto';else if(!isNaN(height))
height+='px';var style='';var width=editor.config.width;if(width)
{if(!isNaN(width))
width+='px';style+="width: "+width+";";}
var sharedTop=topHtml&&checkSharedSpace(editor,'top'),sharedBottoms=checkSharedSpace(editor,'bottom');sharedTop&&(sharedTop.setHtml(topHtml),topHtml='');sharedBottoms&&(sharedBottoms.setHtml(bottomHtml),bottomHtml='');var container=CKEDITOR.dom.element.createFromHtml(['<span'+' id="cke_',name,'"'+' onmousedown="return false;"'+' class="',editor.skinClass,' cke_editor_',name,'"'+' dir="',editor.lang.dir,'"'+' title="',(CKEDITOR.env.gecko?' ':''),'"'+' lang="',editor.langCode,'"'+' role="application"'+' aria-labelledby="cke_',name,'_arialbl"'+
(style?' style="'+style+'"':'')+'>'+'<span id="cke_',name,'_arialbl" class="cke_voice_label">'+editor.lang.editor+'</span>'+'<span class="',CKEDITOR.env.cssClass,'" role="presentation">'+'<span class="cke_wrapper cke_',editor.lang.dir,'" role="presentation">'+'<table class="cke_editor" border="0" cellspacing="0" cellpadding="0" role="presentation"><tbody>'+'<tr',topHtml?'':' style="display:none"','><td id="cke_top_',name,'" class="cke_top" role="presentation">',topHtml,'</td></tr>'+'<tr',contentsHtml?'':' style="display:none"','><td id="cke_contents_',name,'" class="cke_contents" style="height:',height,'" role="presentation">',contentsHtml,'</td></tr>'+'<tr',bottomHtml?'':' style="display:none"','><td id="cke_bottom_',name,'" class="cke_bottom" role="presentation">',bottomHtml,'</td></tr>'+'</tbody></table>'+'<style>.',editor.skinClass,'{visibility:hidden;}</style>'+'</span>'+'</span>'+'</span>'].join(''));container.getChild([1,0,0,0,0]).unselectable();container.getChild([1,0,0,0,2]).unselectable();if(elementMode==CKEDITOR.ELEMENT_MODE_REPLACE)
container.insertAfter(element);else
element.append(container);editor.container=container;container.disableContextMenu();editor.fireOnce('themeLoaded');editor.fireOnce('uiReady');},buildDialog:function(editor)
{var baseIdNumber=CKEDITOR.tools.getNextNumber();var element=CKEDITOR.dom.element.createFromHtml(['<div class="cke_editor_'+editor.name.replace('.','\\.')+'_dialog cke_skin_',editor.skinName,'" dir="',editor.lang.dir,'"'+' lang="',editor.langCode,'"'+' role="dialog"'+' aria-labelledby="%title#"'+'>'+'<table class="cke_dialog',' '+CKEDITOR.env.cssClass,' cke_',editor.lang.dir,'" style="position:absolute" role="presentation">'+'<tr><td role="presentation">'+'<div class="%body" role="presentation">'+'<div id="%title#" class="%title" role="presentation"></div>'+'<a id="%close_button#" class="%close_button" href="javascript:void(0)" title="'+editor.lang.common.close+'" role="button"><span class="cke_label">X</span></a>'+'<div id="%tabs#" class="%tabs" role="tablist"></div>'+'<table class="%contents" role="presentation"><tr>'+'<td id="%contents#" class="%contents" role="presentation"></td>'+'</tr></table>'+'<div id="%footer#" class="%footer" role="presentation"></div>'+'</div>'+'<div id="%tl#" class="%tl"></div>'+'<div id="%tc#" class="%tc"></div>'+'<div id="%tr#" class="%tr"></div>'+'<div id="%ml#" class="%ml"></div>'+'<div id="%mr#" class="%mr"></div>'+'<div id="%bl#" class="%bl"></div>'+'<div id="%bc#" class="%bc"></div>'+'<div id="%br#" class="%br"></div>'+'</td></tr>'+'</table>',(CKEDITOR.env.ie?'':'<style>.cke_dialog{visibility:hidden;}</style>'),'</div>'].join('').replace(/#/g,'_'+baseIdNumber).replace(/%/g,'cke_dialog_'));var body=element.getChild([0,0,0,0,0]),title=body.getChild(0),close=body.getChild(1);title.unselectable();close.unselectable();return{element:element,parts:{dialog:element.getChild(0),title:title,close:close,tabs:body.getChild(2),contents:body.getChild([3,0,0,0]),footer:body.getChild(4)}};},destroy:function(editor)
{var container=editor.container;container.clearCustomData();editor.element.clearCustomData();if(CKEDITOR.env.ie)
{container.setStyle('display','none');var $range=document.body.createTextRange();$range.moveToElementText(container.$);try
{$range.select();}
catch(e){}}
if(container)
container.remove();if(editor.elementMode==CKEDITOR.ELEMENT_MODE_REPLACE)
editor.element.show();delete editor.element;}};})());CKEDITOR.editor.prototype.getThemeSpace=function(spaceName)
{var spacePrefix='cke_'+spaceName;var space=this._[spacePrefix]||(this._[spacePrefix]=CKEDITOR.document.getById(spacePrefix+'_'+this.name));return space;};CKEDITOR.editor.prototype.resize=function(width,height,isContentHeight,resizeInner)
{var numberRegex=/^\d+$/;if(numberRegex.test(width))
width+='px';var container=this.container,contents=CKEDITOR.document.getById('cke_contents_'+this.name),outer=resizeInner?container.getChild(1):container;CKEDITOR.env.webkit&&outer.setStyle('display','none');outer.setStyle('width',width);if(CKEDITOR.env.webkit)
{outer.$.offsetWidth;outer.setStyle('display','');}
var delta=isContentHeight?0:(outer.$.offsetHeight||0)-(contents.$.clientHeight||0);contents.setStyle('height',Math.max(height-delta,0)+'px');this.fire('resize');};CKEDITOR.editor.prototype.getResizable=function()
{return this.container.getChild(1);};window.RTE={config:{'alignableElements':['p','div','td','th'],'baseFloatZIndex':500,'bodyId':'bodyContent','coreStyles_bold':{element:'b',overrides:'strong'},'coreStyles_italic':{element:'i',overrides:'em'},'customConfig':'','dialog_backgroundCoverColor':'#000','disableObjectResizing':true,'entities':false,'format_tags':'p;h2;h3;h4;h5;pre','height':400,'language':window.wgUserLanguage,'removePlugins':'about,elementspath,filebrowser,flash,forms,horizontalrule,image,justify,link,maximize,newpage,pagebreak,toolbar,save,scayt,smiley,wsc','resize_enabled':false,'skin':'wikia','startupFocus':CKEDITOR.env.gecko?false:true,'theme':'wikia','toolbar':'Wikia','toolbarCanCollapse':false},instance:false,instanceId:window.RTEInstanceId,loaded:false,loadTime:false,plugins:['comment','dialog','dragdrop','edit-buttons','entities','first-run-notice','gallery','justify','link','linksuggest','media','modeswitch','paste','placeholder','signature','template','temporary-save','toolbar','tools','track','widescreen','toolbar'],log:function(msg){$().log(msg,'RTE');},ajax:function(method,params,callback){if(typeof params!='object'){params={};}
params.method=method;jQuery.post(window.wgScript+'?action=ajax&rs=RTEAjax',params,function(data){if(typeof callback=='function'){callback(data);}},'json');},track:function(action,label,value){var args=['ckeditor'];for(i=0;i<arguments.length;i++)args.push(arguments[i]);WET.byStr(args.join('/'));},init:function(mode){CKEDITOR.timestamp=window.wgStyleVersion;CKEDITOR.dtd.pre.img=1;CKEDITOR.dtd.p.center=1;RTE.config.startupMode=mode;RTE.loadPlugins();$('<div id="RTEStuff" />').appendTo('body');RTE.repositionRTEStuff();$(window).bind('resize',RTE.repositionRTEStuff);RTE.instance=CKEDITOR.replace('wpTextbox1',RTE.config);RTE.loadCss();CKEDITOR.on('instanceReady',RTE.onEditorReady);RTE.instance.on('modeSwitch',function(){RTE.modeSwitch(RTE.instance.mode);});RTE.instance.on('mode',function(){RTE.loading(false);RTE.log('mode "'+this.mode+'" is loaded');});RTE.instance.on('dataReady',function(){if(this.mode=='wysiwyg'){this.fire('wysiwygModeReady');}});RTE.instance.on('wysiwygModeReady',RTE.onWysiwygModeReady);RTE.instance.on('afterUndo',function(){RTE.instance.fire('wysiwygModeReady');});RTE.instance.on('afterRedo',function(){RTE.instance.fire('wysiwygModeReady');});RTE.instance.on('widescreen',RTE.onWidescreen);RTE.loading(true);},loadCss:function(){var css=[window.stylepath+'/monobook/main.css',CKEDITOR.basePath+'../css/RTEcontent.css',window.RTEMWCommonCss];if(typeof WikiaEnableAutoPageCreate!="undefined"){css.push(wgExtensionsPath+'/wikia/AutoPageCreate/AutoPageCreate.css');}
for(var n=0;n<css.length;n++){var cb=((css[n].indexOf('?')>-1)?'':('?'+CKEDITOR.timestamp));RTE.instance.addCss('@import url('+css[n]+cb+');');}
if(CKEDITOR.env.ie&&RTE.config.disableObjectResizing){RTE.instance.addCss('img {behavior:url('+RTE.constants.localPath+'/css/behaviors/disablehandles.htc)}');}},loadPlugins:function(){var extraPlugins=[];for(var p=0;p<RTE.plugins.length;p++){var plugin=RTE.plugins[p];extraPlugins.push('rte-'+plugin);CKEDITOR.plugins.addExternal('rte-'+plugin,CKEDITOR.basePath+'../js/plugins/'+plugin+'/');}
RTE.config.extraPlugins=extraPlugins.join(',');},onEditorReady:function(){RTE.tools.getThemeColors();RTE.instance.dataProcessor.writer.indentationChars='';RTE.instance.dataProcessor.writer.lineBreakChars='';CKEDITOR.plugins.sourcearea.commands.source.exec=function(editor){RTE.log('switching mode');if(editor.mode=='wysiwyg'){editor.fire('saveSnapshot');}
editor.getCommand('source').setState(CKEDITOR.TRISTATE_DISABLED);editor.fire('modeSwitch');}
RTE.repositionRTEStuff();RTE.loaded=true;RTE.loading(false);RTE.loadTime=((new Date()).getTime()-window.wgRTEStart.getTime())/1000;RTE.log('CKeditor v'+window.CKEditorVersion+' ('+
(window.RTEDevMode?'in development mode':CKEDITOR.revision+' build '+CKEDITOR.version)+') is ready in "'+RTE.instance.mode+'" mode (loaded in '+RTE.loadTime+' s)');if(typeof window.EditEnhancements=='function'){EditEnhancements();}
RTE.instance.fire('RTEready');if(!RTE.config.startupFocus){setTimeout(function(){RTE.instance.focus();},100);}},onWysiwygModeReady:function(){RTE.log('onWysiwygModeReady');var body=RTE.getEditor();body.attr('id',RTE.instance.config.bodyId).addClass('lang-'+window.wgContentLanguage);setTimeout(function(){if(CKEDITOR.env.opera){var firstChild=RTE.getEditor().children().eq(0);if(firstChild.is('br')){firstChild.remove();}}},750);},onWidescreen:function(){RTE.repositionRTEStuff();},repositionRTEStuff:function(){var editorPosition=$('#editform').offset();var toolbarPosition=$('#cke_wpTextbox1').position();if(!toolbarPosition){toolbarPosition={top:0};}
$('#RTEStuff').css({'left':parseInt(editorPosition.left)+'px','top':parseInt(editorPosition.top+toolbarPosition.top+$('#cke_top_wpTextbox1').height())+'px'});},getEditor:function(){return jQuery(RTE.instance.document.$.body);},loading:function(loading){if(loading){$('body').addClass('RTEloading');}
else{$('body').removeClass('RTEloading');}},modeSwitch:function(mode){RTE.log('switching from "'+mode+'" mode');var content=RTE.instance.getData();RTE.loading(true);switch(mode){case'wysiwyg':RTE.ajax('html2wiki',{html:content,title:window.wgPageName},function(data){RTE.instance.setMode('source');RTE.instance.setData(data.wikitext);RTE.track('switchMode','wysiwyg2source');});break;case'source':RTE.ajax('wiki2html',{wikitext:content,title:window.wgPageName},function(data){if((typeof window.RTEEdgeCase!='undefined')&&(window.RTEEdgeCase=='nowysiwyg')){RTE.log('article contains __NOWYSIWYG__ magic word');data.edgecase={type:window.RTEEdgeCase,info:{title:window.RTEMessages.edgecase.title,content:window.RTEMessages.edgecase.content}};}
if(data.edgecase){RTE.log('edgecase found!');RTE.tools.alert(data.edgecase.info.title,data.edgecase.info.content);RTE.instance.getCommand('source').setState(CKEDITOR.TRISTATE_ON);RTE.loading(false);RTE.track('switchMode','edgecase',data.edgecase.type);return;}
RTE.instance.setMode('wysiwyg');RTE.instance.setData(data.html);RTE.track('switchMode','source2wysiwyg');});break;}},constants:{localPath:window.RTELocalPath,urlProtocols:window.RTEUrlProtocols,validTitleChars:window.RTEValidTitleChars},messages:window.RTEMessages};CKEDITOR.config.bodyId='';CKEDITOR.config.baseBackgroundColor='#ddd';CKEDITOR.config.baseColor='#000';CKEDITOR.config.toolbar_Wikia=[{msg:'textAppearance',groups:[['Format'],['Bold','Italic','Underline','Strike'],['BulletedList','NumberedList'],['Link','Unlink'],['Outdent','Indent'],['JustifyLeft','JustifyCenter','JustifyRight']]},{msg:'insert',groups:[['Image','Gallery','Video'],['Table'],['Template'],['Signature']]},{msg:'controls',groups:[['Undo','Redo'],['Widescreen'],['Source']]}];CKEDITOR.dom.element.prototype.hasAttributesOriginal=CKEDITOR.dom.element.prototype.hasAttributes;CKEDITOR.dom.element.prototype.hasAttributes=function(){var ret=this.hasAttributesOriginal();if(ret==true){var internalAttribs=['_rte_washtml','_rte_line_start','_rte_empty_lines_before'];for(i=0;i<internalAttribs.length;i++){if(this.hasAttribute(internalAttribs[i])){ret=false;}}}
return ret;}
CKEDITOR.langRegExp=/lang\/([\w\-]+).js/;CKEDITOR.getUrl=function(resource){if(CKEDITOR.langRegExp.test(resource)){var matches=resource.match(CKEDITOR.langRegExp);var lang=matches[1];RTE.log('language "'+lang+'" requested');var url=window.wgServer+wgScript+'?action=ajax&rs=RTEAjax&method=i18n&uselang='+lang+'&cb='+window.wgMWrevId+'-'+window.wgStyleVersion;return url;}
if(resource.indexOf('://')==-1&&resource.indexOf('/')!==0){if(resource.indexOf('_source')==-1){resource='_source/'+resource;}
resource=this.basePath+resource;}
if(this.timestamp&&resource.charAt(resource.length-1)!='/'){resource+=(resource.indexOf('?')>=0?'&':'?')+this.timestamp;}
return resource;}
CKEDITOR.editor.prototype.switchMode=function(mode){if(this.mode==mode){return;}
RTE.log('switchMode("'+mode+'")');this.mode=(mode=='wysiwyg')?'source':'wysiwyg';CKEDITOR.plugins.sourcearea.commands.source.exec(this);}
CKEDITOR.dom.element.prototype.setState=function(state){var node=this.getParent();switch(state)
{case CKEDITOR.TRISTATE_ON:node.addClass('cke_on');node.removeClass('cke_off');node.removeClass('cke_disabled');break;case CKEDITOR.TRISTATE_DISABLED:node.addClass('cke_disabled');node.removeClass('cke_off');node.removeClass('cke_on');break;default:node.addClass('cke_off');node.removeClass('cke_on');node.removeClass('cke_disabled');break;}};jQuery.fn.getData=function(){var json=this.attr('_rte_data');if(!json){return{};}
json=decodeURIComponent(json);var data=$.secureEvalJSON(json)||{};return data;}
jQuery.fn.setData=function(key,value){var data={};if(typeof key=='object'){data=key;}
else if(typeof key=='string'){data[key]=value;}
data=jQuery().extend(true,this.getData(),data);var json=$.toJSON(data);this.attr('_rte_data',encodeURIComponent(json));return data;}
jQuery.fn.setType=function(type){$(this).attr('class','placeholder placeholder-'+type).setData('type',type);}
jQuery(function(){RTE.log('starting...');var mode=window.RTEInitMode?window.RTEInitMode:'wysiwyg';RTE.init(mode);});CKEDITOR.plugins.add('rte-comment',{init:function(editor){CKEDITOR.dialog.add('rte-comment',this.path+'dialogs/comment.js');}});RTE.commentEditor={placeholder:{},dialog:{},showCommentEditor:function(placeholder){RTE.log('calling comment editor...');RTE.commentEditor.placeholder=placeholder;RTE.instance.openDialog('rte-comment');}};CKEDITOR.dialog.add('rte-comment',function(editor)
{return{title:editor.lang.commentEditor.title,resizable:CKEDITOR.DIALOG_RESIZE_NONE,minWidth:400,minHeight:150,contents:[{id:'comment',label:'Comment',elements:[{type:'textarea',id:'content'}]}],onOk:function(){var content=this.getValueOf('comment','content');var placeholder=RTE.commentEditor.placeholder;if(content==''){RTE.log('removing comment');RTE.track('comment','dialog','delete');placeholder.remove();return;}
RTE.log('storing modified comment data: '+content);RTE.track('comment','dialog','save');var wikitext='<!-- '+content+' -->';placeholder.setData({wikitext:wikitext});placeholder.removeData('preview');},onShow:function(){this._.element.addClass('wikiaEditorDialog');this._.element.addClass('commentEditorDialog');var data=RTE.commentEditor.placeholder.getData();wikitext=data.wikitext.replace(/^<!--\s+/,'').replace(/\s+-->$/,'');this.setValueOf('comment','content',wikitext);this.setupTracking('comment',{ok:false});}};});CKEDITOR.plugins.add('rte-dialog',{init:function(editor){CKEDITOR.dialog.prototype.getActiveTab=function(){return this._.currentTabId;};CKEDITOR.dialog.prototype.enableSuggesionsOn=function(field,namespaces){if(typeof window.os_enableSuggestionsOn=='function'){var fieldId=field._.inputId;document.getElementById('RTEFakeForm').submit=function(){};namespaces=(typeof namespaces!='undefined'&&namespaces.length)?namespaces:[];window.wgSearchNamespaces=namespaces;if(typeof window.os_map[fieldId]=='undefined'){RTE.log('enabling MW suggest on "'+fieldId+'"...');window.os_enableSuggestionsOn(fieldId,'RTEFakeForm');var container=$(window.os_createContainer(os_map[fieldId]));var fieldElem=$('#'+fieldId);fieldElem.parent().css('position','relative').append(container);container.css('visibility','hidden');this._.suggestContainer=container;var element=new CKEDITOR.dom.element(fieldElem[0]);var self=this;for(var ev in{keyup:1,keydown:1,keypress:1}){element.on(ev,function(e){var preventKeyBubblingKeys={27:1,13:1};if(e.data.getKeystroke()in preventKeyBubblingKeys){var suggestBox=self._.suggestContainer;if(suggestBox.css('visibility')!='hidden'){self._.dontHide=true;e.data.stopPropagation();suggestBox.css('visibility','hidden');}}});};var eventCallback=function(ev){if(this._.dontHide){RTE.log('dialog hide prevented');ev.data.hide=false;this._.dontHide=false;}};this.on('ok',eventCallback);this.on('cancel',eventCallback);}
else{this._.suggestContainer=$('#'+os_map[fieldId].container);}}};CKEDITOR.dialog.prototype.setLoading=function(loading){var wrapper=this.getElement();wrapper.removeClass('wikiaEditorLoading');if(loading){wrapper.addClass('wikiaEditorLoading');}};CKEDITOR.dialog.prototype.setupTracking=function(name,options){var defaults={cancel:1,close:1,ok:1,error:1};options=$().extend(defaults,options);this._.wikiaTrack={sendEvent:options,sendEvents:true,name:name};var self=this;this.on('cancelClicked',function(ev){self.fireTrackingEvent('cancel',ev);});this.on('close',function(ev){self.fireTrackingEvent('close',ev);});this.on('notvalid',function(ev){self.fireTrackingEvent('error',ev);});var okButton=this.getButton('ok');if(okButton){okButton.on('click',function(ev){self.fireTrackingEvent('ok',ev);});}};CKEDITOR.dialog.prototype.fireTrackingEvent=function(eventName,ev){var wikiaTrack=this._.wikiaTrack;if(wikiaTrack.sendEvents){if(wikiaTrack.sendEvent[eventName]){RTE.track(wikiaTrack.name,'dialog',eventName);if(eventName=='cancel'||eventName=='close'){wikiaTrack.sendEvents=false;}}}};}});CKEDITOR.plugins.add('rte-dragdrop',{timeout:250,onDrop:function(ev){RTE.log('drag&drop finished');setTimeout(function(){RTE.instance.fire('wysiwygModeReady');var droppedElement=RTE.getEditor().find('[_rte_dragged]').removeAttr('_rte_dragged');RTE.log('dropped element:');RTE.log(droppedElement);RTE.instance.fire('saveSnapshot');var content=RTE.instance.getData();if(content==''){RTE.log('undoing drag&drop');RTE.instance.execCommand('undo');}
var extra={pageX:(ev.pageX?ev.pageX:ev.clientX),pageY:(ev.pageY?ev.pageY:ev.clientY)};if(!CKEDITOR.env.ie){droppedElement.trigger('dropped',[extra]);}},this.timeout);},onDrag:function(ev){RTE.instance.fire('saveSnapshot');RTE.log('drag&drop: undo point');var target=$(ev.target);target.attr('_rte_dragged',true);target.trigger('dragged');},onDuringDragDrop:function(ev){var scrollStep=15;var scrollSpace=50;var editorHeight=parseInt($('#cke_contents_wpTextbox1').height());var editorWindow=RTE.instance.window.$;var scrollY=(CKEDITOR.env.ie?editorWindow.document.body.parentNode.scrollTop:editorWindow.scrollY);var cursorY=(ev.pageY?ev.pageY:ev.clientY)-scrollY;if(cursorY<scrollSpace){editorWindow.scrollBy(0,-scrollStep);}
else if(cursorY>=editorHeight-scrollSpace){editorWindow.scrollBy(0,scrollStep);}},init:function(editor){var self=this;editor.on('wysiwygModeReady',function(){$(editor.document.$).unbind('.dnd').bind('dragstart.dnd',self.onDrag).bind('drop',self.onDrop).bind('dragdrop.dnd',self.onDrop).bind('mousedown.dnd',self.onDrag).bind('mouseup.dnd',function(ev){var target=$(ev.target);target.removeAttr('_rte_dragged');ev.preventDefault();}).bind('dblclick.dnd',function(ev){if(CKEDITOR.env.gecko){var target=$(ev.target);if(!!target.filter('img').attr('type')){RTE.tools.removeResizeBox();}}}).bind('dragover.dnd',self.onDuringDragDrop);if(CKEDITOR.env.ie){RTE.getEditor().bind('drop',self.onDrop).bind('dragover',self.onDuringDragDrop);}});}});CKEDITOR.plugins.add('rte-edit-buttons',{init:function(editor){editor.on('instanceReady',function(){var buttons=$('#wpSave,#wpPreview,#wpDiff');buttons.attr('disabled',false);buttons.bind('click',function(){var id=$(this).attr('id');id=id.substring(2).toLowerCase();RTE.track(id,editor.mode+'Mode');});});}});CKEDITOR.plugins.add('rte-entities',{insideEntitySpan:false,init:function(editor){var self=this;editor.on('selectionChange',function(ev){var selection=ev.data.selection;var element=selection.getStartElement();if(element.hasAttribute('_rte_entity')){var entity=element.getAttribute('_rte_entity');RTE.log('entity span: &'+entity+';');self.insideEntitySpan=true;}
else{if(self.insideEntitySpan){RTE.log('entity span: leaving...');}
self.insideEntitySpan=false;}});}});CKEDITOR.plugins.add('rte-first-run-notice',{dismiss:function(ev){RTE.log('first run notice - dismiss');$('#RTEFirstRunNotice').slideUp();setTimeout(RTE.repositionRTEStuff,1000);if(window.wgUserName){RTE.ajax('firstRunNoticeDismiss');}
$.cookies.set('RTENoticeDismissed',1,{hoursToLive:24*365*10,domain:window.RTECookieDomain,path:window.RTECookiePath});RTE.track('firstRunNotice','close');},isDismissed:function(){if(!$('#RTEFirstRunNotice').exists()){RTE.log('first run notice - disabled / user option set');return true;}
var cookieValue=$.cookies.get('RTENoticeDismissed');if(cookieValue==1){RTE.log('first run notice - cookie set');return true;}
return false;},init:function(editor){var self=this;editor.on('instanceReady',function(){if(self.isDismissed()){return;}
var notice=$('#RTEFirstRunNotice');notice.children('#RTEFirstRunNoticeClose').bind('click',self.dismiss);notice.slideDown();setTimeout(RTE.repositionRTEStuff,1000);RTE.log('first run notice - show');RTE.track('firstRunNotice','init');});}});CKEDITOR.plugins.add('rte-gallery',{init:function(editor){var self=this;editor.on('wysiwygModeReady',function(){var gallery=RTE.getEditor().find('.image-gallery');self.setupGallery(gallery);});if(typeof window.WikiaPhotoGallery!='undefined'){editor.addCommand('addphotogallery',{exec:function(editor){WikiaPhotoGallery.showEditor({from:'wysiwyg'});}});editor.ui.addButton('Gallery',{title:editor.lang.photoGallery.add,className:'RTEGalleryButton',command:'addphotogallery'});}
else{RTE.log('WikiaPhotoGallery is not enabled here - disabling "Gallery" button');return;}},setupGallery:function(gallery){gallery.attr('title',RTE.instance.lang.photoGallery.tooltip).unbind('.gallery').bind('edit.gallery',function(ev){var gallery=$(this);WikiaPhotoGallery.showEditor({from:'wysiwyg',gallery:gallery});});}});(function()
{var alignRemoveRegex=/(-moz-|-webkit-|start|auto)/i;function getState(editor,path)
{var firstBlock=path.block||path.blockLimit;var alignableElements=(typeof editor.config.alignableElements=='object')?editor.config.alignableElements:[];if(!firstBlock||(alignableElements.length>1&&alignableElements.indexOf(firstBlock.getName())==-1)){return CKEDITOR.TRISTATE_DISABLED;}
var currentAlign=firstBlock.getComputedStyle('text-align').replace(alignRemoveRegex,'');if((!currentAlign&&this.isDefaultAlign)||currentAlign==this.value){return CKEDITOR.TRISTATE_ON;}
return CKEDITOR.TRISTATE_OFF;}
function onSelectionChange(evt)
{var command=evt.editor.getCommand(this.name);command.state=getState.call(this,evt.editor,evt.data.path);command.fire('state');}
function justifyCommand(editor,name,value)
{this.name=name;this.value=value;var contentDir=editor.config.contentsLangDirection;this.isDefaultAlign=(value=='left'&&contentDir=='ltr')||(value=='right'&&contentDir=='rtl');}
justifyCommand.prototype={exec:function(editor)
{var selection=editor.getSelection();if(!selection)
return;var bookmarks=selection.createBookmarks(),ranges=selection.getRanges();var iterator,block;for(var i=ranges.length-1;i>=0;i--)
{iterator=ranges[i].createIterator();while((block=iterator.getNextParagraph()))
{block.removeAttribute('align');block.removeAttribute('_rte_style');block.removeAttribute('_rte_attribs');if(block.getName()=='p'){block.removeAttribute('_rte_washtml');}
if(block.getName()=='th'){this.isDefaultAlign=(this.value=='center');}
if(this.state==CKEDITOR.TRISTATE_OFF&&!this.isDefaultAlign){block.setStyle('text-align',this.value);}
else{block.removeStyle('text-align');}}}
editor.focus();editor.forceNextSelectionCheck();selection.selectBookmarks(bookmarks);}};CKEDITOR.plugins.add('rte-justify',{init:function(editor)
{var left=new justifyCommand(editor,'justifyleft','left'),center=new justifyCommand(editor,'justifycenter','center'),right=new justifyCommand(editor,'justifyright','right'),justify=new justifyCommand(editor,'justifyblock','justify');editor.addCommand('justifyleft',left);editor.addCommand('justifycenter',center);editor.addCommand('justifyright',right);editor.addCommand('justifyblock',justify);editor.ui.addButton('JustifyLeft',{label:editor.lang.justify.left,command:'justifyleft'});editor.ui.addButton('JustifyCenter',{label:editor.lang.justify.center,command:'justifycenter'});editor.ui.addButton('JustifyRight',{label:editor.lang.justify.right,command:'justifyright'});editor.ui.addButton('JustifyBlock',{label:editor.lang.justify.block,command:'justifyblock'});editor.on('selectionChange',CKEDITOR.tools.bind(onSelectionChange,left));editor.on('selectionChange',CKEDITOR.tools.bind(onSelectionChange,right));editor.on('selectionChange',CKEDITOR.tools.bind(onSelectionChange,center));editor.on('selectionChange',CKEDITOR.tools.bind(onSelectionChange,justify));},requires:['domiterator']});})();CKEDITOR.tools.extend(CKEDITOR.config,{alignableElements:null});CKEDITOR.plugins.add('rte-link',{init:function(editor){editor.addCommand('link',new CKEDITOR.dialogCommand('link'));editor.addCommand('unlink',new CKEDITOR.unlinkCommand());editor.ui.addButton('Link',{label:editor.lang.link.toolbar,command:'link'});editor.ui.addButton('Unlink',{label:editor.lang.unlink,command:'unlink'});CKEDITOR.dialog.add('link',this.path+'dialogs/link.js');if(editor.addMenuItems){editor.addMenuItems({link:{label:editor.lang.link.menu,command:'link',group:'link',order:1},unlink:{label:editor.lang.unlink,command:'unlink',group:'link',order:5}});}
if(editor.contextMenu)
{editor.contextMenu.addListener(function(element,selection)
{if(!element)
return null;var isAnchor=(element.is('img')&&element.getAttribute('_cke_real_element_type')=='anchor');if(!isAnchor)
{if(!(element=CKEDITOR.plugins.link.getSelectedLink(editor)))
return null;isAnchor=(element.getAttribute('name')&&!element.getAttribute('href'));}
return isAnchor?{anchor:CKEDITOR.TRISTATE_OFF}:{link:CKEDITOR.TRISTATE_OFF,unlink:CKEDITOR.TRISTATE_OFF};});}
editor.on('afterPaste',function(){var pastedLinks=RTE.getEditor().find('a').not('a[_rte_data]');if(!pastedLinks.exists()){return;}
RTE.log('pasted links');RTE.log(pastedLinks);pastedLinks.each(function(){var link=$(this);var href=link.attr('href');if(RTE.tools.isExternalLink(href)){return;}
var pageName="";if(href.indexOf('&action=edit')==-1){pageName=link.attr('title');}
else{var matches=href.match('title=(.*)&action=edit');if(matches){pageName=matches[1];pageName=decodeURIComponent(pageName);pageName=pageName.replace(/_/g,' ');}}
if(pageName==""){return;}
RTE.log('local link pointing to "'+pageName+'" found');var data={type:'internal',link:pageName,text:link.text(),noforce:true,wasblank:false};link.setData(data);});});}});CKEDITOR.plugins.link={getSelectedLink:function(editor)
{var range;try{range=editor.getSelection().getRanges()[0];}
catch(e){return null;}
range.shrink(CKEDITOR.SHRINK_TEXT);var root=range.getCommonAncestor();return root.getAscendant('a',true);}};CKEDITOR.unlinkCommand=function(){};CKEDITOR.unlinkCommand.prototype={exec:function(editor)
{var selection=editor.getSelection(),bookmarks=selection.createBookmarks(),ranges=selection.getRanges(),rangeRoot,element;for(var i=0;i<ranges.length;i++)
{rangeRoot=ranges[i].getCommonAncestor(true);element=rangeRoot.getAscendant('a',true);if(!element)
continue;ranges[i].selectNodeContents(element);}
selection.selectRanges(ranges);editor.document.$.execCommand('unlink',false,null);selection.selectBookmarks(bookmarks);}};CKEDITOR.tools.extend(CKEDITOR.config,{linkShowAdvancedTab:true,linkShowTargetTab:true});CKEDITOR.dialog.add('link',function(editor)
{var plugin=CKEDITOR.plugins.link;var setupDialog=function(editor,element)
{RTE.log('opening link dialog');var data=element?$(element.$).getData():null;if(data){if(typeof data.type=='undefined'){RTE.log('pasted link detected');var href=element.getAttribute('href');if(RTE.tools.isExternalLink(href)){data={type:'external',link:href,text:element.getText()};}}
RTE.log(data);var linkTextField=this.getContentElement('external','label');linkTextField.enable();switch(data.type){case'external':this.selectPage('external');this.setValueOf('external','url',data.link);if(data.linktype=='autonumber'){this.setValueOf('external','autonumber',true);linkTextField.disable();}
else{this.setValueOf('external','label',data.text);}
break;case'external-raw':this.selectPage('external');this.setValueOf('external','url',data.link);this.setValueOf('external','label','');break;case'internal':this.selectPage('internal');this.setValueOf('internal','name',data.link);this.setValueOf('internal','label',data.text);break;}}
else{var selectionContent=RTE.tools.getSelectionContent();if(RTE.tools.isExternalLink(selectionContent)){RTE.log('link: using selected text "'+selectionContent+'" for new external link');this.selectPage('external');this.setValueOf('external','url',selectionContent);this.setValueOf('external','label','');}
else{RTE.log('link: using selected text "'+selectionContent+'" for new internal link');this.selectPage('internal');this.setValueOf('internal','name',selectionContent);this.setValueOf('internal','label','');}}
this._.selectedElement=element;this.enableSuggesionsOn(this.getContentElement('internal','name'));};var createNewLink=function(editor){var selection=editor.getSelection(),ranges=selection.getRanges();if(ranges.length==1&&ranges[0].collapsed)
{var text=new CKEDITOR.dom.text('',editor.document);ranges[0].insertNode(text);ranges[0].selectNodeContents(text);selection.selectRanges(ranges);}
var style=new CKEDITOR.style({element:'a',attributes:{'_rte_new_link':true}});style.type=CKEDITOR.STYLE_INLINE;style.apply(editor.document);var node=RTE.getEditor().find('a[_rte_new_link]');node.removeAttr('_rte_new_link');var link=new CKEDITOR.dom.element(node[0]);if(CKEDITOR.env.gecko||CKEDITOR.env.webkit){var dirty=new CKEDITOR.dom.text(' ',editor.document);dirty.insertAfter(link);selection.selectElement(dirty);if(CKEDITOR.env.gecko){dirty.remove();}}
return link;};var lang=editor.lang.link;return{title:editor.lang.link.title,minWidth:500,minHeight:175,contents:[{id:'internal',label:lang.internal.tab,title:lang.internal.tab,elements:[{'type':'text','label':lang.internal.pageName,'id':'name',validate:function(){var activeTab=this.getDialog().getActiveTab();if(activeTab=='external'){return true;}
var re=new RegExp('^(#(.+))|['+RTE.constants.validTitleChars+']+$');var validPageNameFunc=CKEDITOR.dialog.validate.regex(re,editor.lang.link.error.badPageTitle);return validPageNameFunc.apply(this);}},{'type':'text','label':lang.internal.linkText,'id':'label'}]},{id:'external',label:lang.external.tab,title:lang.external.tab,elements:[{'type':'text','label':lang.external.url,'id':'url',validate:function(){var activeTab=this.getDialog().getActiveTab();if(activeTab=='internal'){return true;}
var re=new RegExp('^('+RTE.constants.urlProtocols+')');var validUrlFunc=CKEDITOR.dialog.validate.regex(re,editor.lang.link.error.badUrl);return validUrlFunc.apply(this);}},{'type':'text','label':lang.external.linkText,'id':'label'},{'type':'checkbox','label':lang.external.numberedLink,'id':'autonumber',onChange:function(){var linkTextField=this.getDialog().getContentElement('external','label');if(this.getValue()){linkTextField.disable();}
else{linkTextField.enable();}}}]}],onShow:function()
{this._.element.addClass('wikiaEditorDialog');this._.element.addClass('linkEditorDialog');this.fakeObj=false;var editor=this.getParentEditor(),selection=editor.getSelection(),ranges=selection.getRanges(),element=null,me=this;element=plugin.getSelectedLink(editor);if(element&&element.getAttribute('href'))
selection.selectElement(element);else
element=null;setupDialog.apply(this,[editor,element]);var self=this;var tabs=this._.tabs;tabs.external[0].on('click',function(ev){RTE.track('link','dialog','tab','internal2external');});tabs.internal[0].on('click',function(ev){RTE.track('link','dialog','tab','external2internal');});this.setupTracking('link');},onOk:function()
{if(this._.dontHide){return;}
var type='';var currentTab=this.getActiveTab();if(!this._.selectedElement){RTE.log('creating new link...');var element=createNewLink.apply(this,[editor]);}
else{var element=this._.selectedElement;}
if(!element){return;}
element.removeClass('external');element.removeClass('autonumber');var data={};var href='';if(currentTab=='external'){href=this.getValueOf('external','url');}
else{href=this.getValueOf('internal','name');}
if(href.indexOf(window.wgServer)==0){var re=new RegExp(window.wgArticlePath.replace(/\$1/,'(.*)'));var matches=href.match(re);if(matches){var pageName=matches[1];pageName=decodeURIComponent(pageName);pageName=pageName.replace(/_/g,' ');this.setValueOf('internal','name',pageName);this.setValueOf('internal','label',this.getValueOf('external','label'));currentTab='internal';RTE.log('internal full URL detected: '+href+' > '+pageName);}}
switch(currentTab){case'external':data={'type':'external','link':this.getValueOf('external','url'),'text':this.getValueOf('external','label'),'wikitext':null};type='externalNamed';if(this.getValueOf('external','autonumber')){data.linktype='autonumber';data.text='[1]';element.addClass('autonumber');type='externalNumbered';}
if(data.text==''){data.type='external-raw';type='externalSimple';}
element.setText(data.text!=''?data.text:data.link);element.addClass('external');element.removeClass('new');break;case'internal':data={'type':'internal','link':this.getValueOf('internal','name'),'text':this.getValueOf('internal','label'),'noforce':true,'wikitext':null};if(element.getText()==element.getHtml()){element.setText(data.text!=''?data.text:data.link);}
if(data.text==''){type='internalSimple';}
else{type='internalNamed';}
RTE.tools.checkInternalLink(element,data.link);break;}
$(element.$).setData(data);RTE.log('updating link data');RTE.log([element,$(element.$).getData()]);RTE.tools.renumberExternalLinks();if(typeof this._.suggestContainer!='undefined'){this._.suggestContainer.css('visibility','hidden');}
RTE.track('link','dialog','type',type);}};});CKEDITOR.plugins.add('rte-linksuggest',{dataSource:false,init:function(editor){if(typeof window.LS_PrepareTextarea!='function'){return;}
if(!CKEDITOR.env.ie&&!CKEDITOR.env.gecko){return;}
this.dataSource=new window.YAHOO.widget.DS_XHR(window.wgServer+window.wgScriptPath,["\n"]);this.dataSource.responseType=window.YAHOO.widget.DS_XHR.TYPE_FLAT;this.dataSource.scriptQueryAppend='action=ajax&rs=getLinkSuggest';var self=this;editor.on('instanceReady',function(ev){self.setupLinkSuggest();});editor.on('mode',function(ev){self.setupLinkSuggest();});},setupLinkSuggest:function(){if(RTE.instance.mode!='source'){return;}
var textarea=$(RTE.instance.textarea.$);textarea.attr('id','RTEtextarea');window.LS_PrepareTextarea('RTEtextarea',this.dataSource);}});CKEDITOR.plugins.add('rte-media',{overlays:false,init:function(editor){var self=this;editor.on('instanceReady',function(){self.overlays=$('<div id="RTEMediaOverlays" />');$('#RTEStuff').append(self.overlays);});editor.on('wysiwygModeReady',function(){if(typeof self.overlays=='object'){self.overlays.html('');}
var media=RTE.tools.getMedia();media.removeData('overlay');self.setupMedia(media);var placeholders=RTE.getEditor().find('.media-placeholder');self.setupPlaceholder(placeholders);});editor.on('toolbarReady',function(toolbar){$('#mw-toolbar').children('#mw-editbutton-wmu').click(function(ev){window.WMU_show(ev);});$('#mw-toolbar').children('#mw-editbutton-vet').click(function(ev){window.VET_show(ev);});});editor.addCommand('addimage',{exec:function(editor){RTE.tools.callFunction(window.WMU_show);}});editor.ui.addButton('Image',{title:editor.lang.image.add,className:'RTEImageButton',command:'addimage'});if(typeof window.VET_show=='function'){editor.addCommand('addvideo',{exec:function(editor){RTE.tools.callFunction(window.VET_show);}});editor.ui.addButton('Video',{title:editor.lang.video.add,className:'RTEVideoButton',command:'addvideo'});}
else{RTE.log('VET is not enabled here - disabling "Video" button');return;}
RTE.mediaEditor.plugin=self;},getOverlay:function(image){var self=this;if(!this.overlays){return;}
var overlay=image.data('overlay');if(typeof overlay=='undefined'){var data=image.getData();var isFramed=image.hasClass('thumb')||image.hasClass('frame');var width=parseInt(image.attr('width'));if(isFramed){if(CKEDITOR.env.ie&&CKEDITOR.env.version<=7){width+=2;}
else{width+=8;}}
overlay=$('<div class="RTEMediaOverlay">');overlay.width(width+'px').attr('type',image.attr('type'));overlay.html('<div class="RTEMediaMenu color1">'+'<span class="RTEMediaOverlayEdit">'+RTE.instance.lang.media.edit+'</span> '+'<span class="RTEMediaOverlayDelete">'+RTE.instance.lang.media['delete']+'</span>'+'</div>');var captionContent=data.params.captionParsed||data.params.caption;if(captionContent&&isFramed){var captionTop=parseInt(image.attr('height')+7);var captionWidth=image.attr('width');if(CKEDITOR.env.ie&&CKEDITOR.env.version<=7){captionTop-=25;captionWidth-=6;}
var caption=$('<div>').addClass('RTEMediaCaption').css('top',captionTop+'px').width(captionWidth).html(captionContent);caption.appendTo(overlay);}
overlay.bind('mouseover',function(){self.showOverlay(image);});overlay.bind('mouseout',function(){self.hideOverlay(image);});this.overlays.append(overlay);image.data('overlay',overlay);overlay.find('.RTEMediaOverlayEdit').bind('click',function(ev){overlay.hide();$(image).trigger('edit');RTE.track(self.getTrackingType(image),'menu','edit');});overlay.find('.RTEMediaOverlayDelete').bind('click',function(ev){var type=self.getTrackingType(image);RTE.track(type,'menu','delete');var title=RTE.instance.lang[type].confirmDeleteTitle;var msg=RTE.instance.lang[type].confirmDelete;RTE.tools.confirm(title,msg,function(){RTE.tools.removeElement(image);overlay.remove();});});}
return overlay;},showOverlay:function(image){var overlay=this.getOverlay(image);var position=RTE.tools.getPlaceholderPosition(image);if(image.hasClass('media-placeholder')){position.top+=2;position.left+=2;}
else{if(image.hasClass('thumb')||image.hasClass('frame')){position.top+=6;if(!image.hasClass('alignLeft')){position.left+=18;}}}
overlay.css({'left':position.left+'px','top':parseInt(position.top+2)+'px'});var menu=overlay.children().eq(0);if(position.top>0){menu.show();}
var caption=overlay.children().eq(1);var positionCaption=parseInt(position.top)+parseInt(caption.css('top'))+16;if(positionCaption<RTE.tools.getEditorHeight()){caption.show();}
overlay.show();if(timeoutId=image.data('hideTimeout')){clearTimeout(timeoutId);}},hideOverlay:function(image){var overlay=this.getOverlay(image);image.data('hideTimeout',setTimeout(function(){overlay.children().hide();overlay.hide().removeData('hideTimeout');},100));},setupMedia:function(media){var self=this;if(!media.exists()){return;}
media.attr('_rte_instance',RTE.instanceId);media.unbind('.media');media.bind('mouseover.media',function(){self.showOverlay($(this));});media.bind('mouseout.media',function(){self.hideOverlay($(this));});media.bind('contextmenu.media',function(ev){ev.stopPropagation();});media.bind('dragged.media',function(ev){RTE.track(self.getTrackingType($(this)),'event','move');});RTE.tools.unselectable(media);RTE.getEditor().unbind('dropped.media').bind('dropped.media',function(ev,extra){var target=$(ev.target);if(!target.hasClass('image')&&!target.hasClass('video')&&!target.hasClass('media-placeholder')){return;}
var editorX=parseInt(extra.pageX-$('#editform').offset().left);var editorWidth=parseInt($('#editform').width());var data=target.getData();var newAlign=false;var oldAlign=data.params.align;if(!oldAlign){oldAlign=(target.hasClass('thumb')||target.hasClass('frame'))?'right':'left';if(target.hasClass('alignNone')){oldAlign='left';}}
switch(oldAlign){case'left':if(editorX>parseInt(editorWidth*0.66)){newAlign='right';}
break;case'right':if(editorX<parseInt(editorWidth*0.33)){newAlign='left';}
break;}
if(!newAlign){RTE.log('media alignment detected: '+oldAlign+' (no change)');return;}
RTE.log('media alignment: '+oldAlign+' -> '+newAlign);var wikitext=data.wikitext;var re=new RegExp('\\|'+oldAlign+'(\\||])');if(re.test(wikitext)){wikitext=wikitext.replace(re,"|"+newAlign+"$1");}
else{wikitext=wikitext.replace(/(\||\])/,'|'+newAlign+'$1');}
RTE.log('new wikitext: '+wikitext);data.params.align=newAlign;data.wikitext=wikitext;target.setData(data);target.removeClass('alignNone alignLeft alignRight').addClass(newAlign=='left'?'alignLeft':'alignRight');var type=target.attr('type');if(type=='image-placeholder'){type='imagePlaceholder';}
if(type=='video-placeholder'){type='videoPlaceholder';}
RTE.track(type,'event','switchSide',(newAlign=='right')?'l2r':'r2l');});var mediaWithCaption=media.filter('.withCaption');mediaWithCaption.each(function(){$(this).css('backgroundPosition','5px '+parseInt($(this).attr('height')+10)+'px');});var image=media.filter('img.image');self.setupImage(image);var video=media.filter('img.video');self.setupVideo(video);},setupImage:function(image){image.bind('edit.media',function(ev){RTE.log('Image clicked');RTE.log($(this).getData());RTE.tools.callFunction(window.WMU_show,$(this));});},setupVideo:function(video){video.bind('edit.media',function(ev){RTE.log('Video clicked');RTE.log($(this).getData());RTE.tools.callFunction(window.VET_show,$(this));});},setupPlaceholder:function(placeholder){var self=this;if(!placeholder.exists()){return;}
this.setupMedia(placeholder);placeholder.unbind('.placeholder');placeholder.bind('contextmenu.placeholder',function(ev){ev.stopPropagation();});RTE.getEditor().unbind('dropped.placeholder').bind('dropped.placeholder',function(ev,extra){var target=$(ev.target);target=target.filter('.media-placeholder');self.setupPlaceholder(target);});var images=placeholder.filter('.image-placeholder');images.attr('title',RTE.instance.lang.imagePlaceholder.tooltip);images.bind('edit.placeholder',function(ev){RTE.tools.callFunction(window.WMU_show,$(this),{isPlaceholder:true});});var videos=placeholder.filter('.video-placeholder');videos.attr('title',RTE.instance.lang.videoPlaceholder.tooltip);videos.bind('edit.placeholder',function(ev){RTE.tools.callFunction(window.VET_show,$(this),{isPlaceholder:true});});},getTrackingType:function(media){var type;switch($(media).attr('type')){case'image':type='image';break;case'video':type='video';break;case'image-placeholder':type='imagePlaceholder';break;case'video-placeholder':type='videoPlaceholder';break;case'image-gallery':type='photoGallery';break;}
return type;}});RTE.mediaEditor={plugin:false,addImage:function(wikitext,params){RTE.log('adding an image');var wikitextParams=wikitext.substring(2,wikitext.length-2).split('|');var data={type:'image',title:wikitextParams.shift().replace(/^[^:]+:/,''),params:params,wikitext:wikitext};this._add(wikitext,data);},addVideo:function(wikitext,params){RTE.log('adding a video');var data={type:'video',params:params,wikitext:wikitext};this._add(wikitext,data);},_add:function(wikitext,data){var self=this;RTE.tools.parseRTE(wikitext,function(html){var newMedia=$(html).children('img');newMedia.setData(data);RTE.tools.insertElement(newMedia,true);self.plugin.setupMedia(newMedia);RTE.track(self.plugin.getTrackingType(newMedia),'event','add');});},update:function(media,wikitext,params){var self=this;RTE.tools.parseRTE(wikitext,function(html){var newMedia=$(html).children('img');newMedia.insertAfter(media);media.remove();self.plugin.setupMedia(newMedia);RTE.track(self.plugin.getTrackingType(newMedia),'event','modified');});}};CKEDITOR.plugins.add('rte-modeswitch',{sourceButton:false,init:function(editor){var self=this;editor.on('instanceReady',function(ev){self.updateSourceButtonTooltip();self.updateModeInfo();});editor.on('mode',function(ev){self.updateSourceButtonTooltip();self.updateModeInfo();});},getSourceButton:function(){if(this.sourceButton==false){var sourceCommand=RTE.instance.getCommand('source');var uiItem=sourceCommand.uiItems[0];this.sourceButton=$('#'+uiItem._.id);}
return this.sourceButton;},updateSourceButtonTooltip:function(){var sourceButton=this.getSourceButton();var msgKey=(RTE.instance.mode=='wysiwyg')?'toSource':'toWysiwyg';sourceButton.attr('title',RTE.instance.lang.modeSwitch[msgKey]);},updateModeInfo:function(){$('body').removeClass('rte_wysiwyg').removeClass('rte_source').addClass('rte_'+RTE.instance.mode);$('#RTEMode').attr('value',RTE.instance.mode);}});CKEDITOR.plugins.add('rte-paste',{htmlBeforePaste:'',getHtml:function(){return RTE.instance.document.getBody().getHtml();},track:function(ev){RTE.track('paste',ev);},init:function(editor){var self=this;editor.on('dataReady',function(ev){if(editor.mode!='wysiwyg'){return;}
var body=this.document.getBody();body.on('beforepaste',function(ev){self.htmlBeforePaste=self.getHtml();setTimeout(function(){self.handlePaste.call(self,editor)},250);});});},handlePaste:function(editor){RTE.log('paste detected');var newHTML=this.getHtml();editor.fire('wysiwygModeReady');var diff=this.diff(this.htmlBeforePaste,newHTML);if(typeof diff!='object'||typeof diff.pasted!='string'){return;}
var pasted=diff.pasted;var matches=pasted.match(/_rte_instance="([a-z0-9-]+)"/);if(matches){var instanceId=matches[1];if(instanceId==RTE.instanceId){this.track('inside');}
else{var cityId=parseInt(instanceId.split('-').shift());if(cityId!=parseInt(wgCityId)){this.track('anotherWiki');}
else{this.track('outside');}}}
else{this.track('plainText');}
if(typeof diff.pasted=='string'){if((/<br>/).test(diff.pasted)){RTE.log('paste: detected line breaks in pasted content');var html=diff['new'].replace(/([^>])<br>([^<])/g,'$1<br _rte_washtml="true" />$2');editor.setData(html);}}
setTimeout(function(){editor.fire('afterPaste');},250);},diff:function(o,n){if(o==n){return false;}
var lenDiff=o.length-n.length;var idx={start:0,end:n.length-1};while(o.charAt(idx.start)==n.charAt(idx.start)){if(idx.start>=o.length){return false;}
idx.start++;}
while(o.charAt(idx.end+lenDiff)==n.charAt(idx.end)){if(idx.end<=idx.start){return false;}
idx.end--;}
var prefix=n.substring(0,idx.start+1);var suffix=n.substring(idx.end,n.length);if(/<[^>]*$/.test(prefix)){idx.start=prefix.lastIndexOf('<');}
if(/^[^<]*>/.test(suffix)){idx.end+=suffix.indexOf('>')+1;}
var pasted=n.substring(idx.start,idx.end+1);prefix=n.substring(0,idx.start);suffix=n.substring(idx.end+1,n.length);return{pasted:pasted,prefix:prefix,suffix:suffix,'new':n,'old':o,'start':idx.start,'end':idx.end};}});CKEDITOR.plugins.add('rte-placeholder',{previews:false,init:function(editor){var self=this;editor.on('instanceReady',function(){self.previews=$('<div id="RTEPlaceholderPreviews" />');$('#RTEStuff').append(self.previews);});editor.on('wysiwygModeReady',function(){if(typeof self.previews=='object'){self.previews.html('');}
var placeholders=RTE.tools.getPlaceholders();placeholders.removeData('preview').removeData('info');self.setupPlaceholder(placeholders);});},getPreview:function(placeholder){var self=this;if(!this.previews){return;}
var preview=placeholder.data('preview');if(typeof preview=='undefined'){preview=$('<div>').addClass('RTEPlaceholderPreview RTEPlaceholderPreviewLoading');preview.html('<div class="RTEPlaceholderPreviewInner">&nbsp;</div>');preview.bind('mouseover',function(){self.showPreview(placeholder);});preview.bind('mouseout',function(){self.hidePreview(placeholder);});this.previews.append(preview);placeholder.data('preview',preview);var data=placeholder.getData();var renderPreview=function(info){var title,intro;var className='RTEPlaceholderPreviewOther';var preformattedCode=true;var isEditable=false;var code=data.wikitext.replace(/</g,'&lt;').replace(/>/g,'&gt;');var lang=RTE.instance.lang.hoverPreview;switch(info.type){case'tpl':className='RTEPlaceholderPreviewTemplate';title=info.title.replace(/_/g,' ').replace(/^Template:/,window.RTEMessages.template+':');intro=info.exists?lang.template.intro:lang.template.notExisting;code=info.exists?info.html:data.wikitext;preformattedCode=!info.exists;isEditable=(typeof info.availableParams!='undefined'&&info.availableParams.length);break;case'comment':title=lang.comment.title;intro=lang.comment.intro;code=data.wikitext.replace(/^<!--\s+/,'').replace(/\s+-->$/,'');isEditable=true;break;case'broken-image':className='RTEPlaceholderPreviewBrokenImage';var imageName=data.wikitext.replace(/^\[\[/,'').replace(/]]$/,'').split('|').shift();title=imageName;intro=lang.media.notExisting;break;default:title=lang.codedElement.title;intro=lang.codedElement.intro;break;}
if(title.length>40){title=title.substr(0,40)+RTEMessages.ellipsis;}
if(preformattedCode&&CKEDITOR.env.ie){code=code.replace(/\n/g,'<br />');}
var intro='<div class="RTEPlaceholderPreviewIntro">'+intro+'</div>';var tools='',showEdit=true;if(showEdit&&isEditable){tools+='<img class="sprite edit" src="'+wgBlankImgUrl+'" />'+'<a class="RTEPlaceholderPreviewToolsEdit">'+lang.edit+'</a>';}
tools+='<img class="sprite delete" src="'+wgBlankImgUrl+'" />'+'<a class="RTEPlaceholderPreviewToolsDelete">'+
lang['delete']+'</a>';var html='';html+='<div class="RTEPlaceholderPreviewInner '+className+'">';html+='<div class="RTEPlaceholderPreviewTitleBar color1"><span />'+title+'</div>';html+=intro;html+='<div class="RTEPlaceholderPreviewCode '+
(preformattedCode?'RTEPlaceholderPreviewPreformatted ':'')+'reset">'+code+'</div>';html+='<div class="RTEPlaceholderPreviewTools neutral">'+tools+'</div>';html+='</div>';preview.removeClass('RTEPlaceholderPreviewLoading').html(html).attr('type',info.type);preview.find('.RTEPlaceholderPreviewToolsDelete').bind('click',function(ev){RTE.track(self.getTrackingType($(placeholder)),'hover','delete');RTE.tools.confirm(title,lang.confirmDelete,function(){RTE.tools.removeElement(placeholder);preview.remove();});});if(showEdit&&isEditable){preview.find('.RTEPlaceholderPreviewToolsEdit').bind('click',function(ev){preview.hide();RTE.track(self.getTrackingType($(placeholder)),'hover','edit');$(placeholder).trigger('edit');});}
preview.find('.RTEPlaceholderPreviewCode').bind('click',function(ev){ev.preventDefault();});preview.find('.RTEPlaceholderPreviewTitleBar').children('span').bind('click',function(ev){RTE.track(self.getTrackingType($(placeholder)),'hover','close');self.hidePreview(placeholder,true);});if(data.type=='double-brackets'){placeholder.data('info',info);}
self.expandPlaceholder(placeholder);};switch(data.type){case'double-brackets':RTE.tools.resolveDoubleBrackets(data.wikitext,renderPreview);break;default:renderPreview({type:data.type});}}
return preview;},showPreview:function(placeholder){var preview=this.getPreview(placeholder);var position=RTE.tools.getPlaceholderPosition(placeholder);preview.css({'left':position.left+'px','top':parseInt(position.top+placeholder.height()+6)+'px'});this.previews.children().not(preview).each(function(){$(this).hide();});var self=this;placeholder.data('showTimeout',setTimeout(function(){var visible=preview.css('display')=='block';if(!visible){placeholder.trigger('hover');}
preview.fadeIn();self.expandPlaceholder(placeholder);},150));if(timeoutId=placeholder.data('hideTimeout')){clearTimeout(timeoutId);}},hidePreview:function(placeholder,hideNow){var preview=this.getPreview(placeholder);if(showTimeout=placeholder.data('showTimeout')){clearTimeout(showTimeout);}
if(hideNow){preview.hide();}
else{placeholder.data('hideTimeout',setTimeout(function(){preview.fadeOut();placeholder.removeData('hideTimeout');},1000));}},setupPlaceholder:function(placeholder){var self=this;placeholder=placeholder.not('.placeholder-image-placeholder').not('.placeholder-video-placeholder');if(!placeholder.exists()){return;}
placeholder.unbind('.placeholder');placeholder.bind('mouseover.placeholder',function(){self.showPreview($(this));});placeholder.bind('mouseout.placeholder',function(){self.hidePreview($(this));});placeholder.bind('contextmenu.placeholder',function(ev){ev.stopPropagation();});RTE.tools.unselectable(placeholder);placeholder.bind('edit.placeholder',function(ev){var data=$(this).getData();switch(data.type){case'double-brackets':RTE.templateEditor.showTemplateEditor($(this));break;case'comment':RTE.commentEditor.showCommentEditor($(this));break;}});placeholder.bind('hover.placeholder',function(ev){RTE.track(self.getTrackingType($(this)),'hover','init');});RTE.getEditor().unbind('dropped.placeholder').bind('dropped.placeholder',function(ev){var target=$(ev.target);target=target.filter('img[_rte_placeholder]');self.setupPlaceholder(target);});},getTrackingType:function(placeholder){var type;var data=$(placeholder).getData();switch(data.type){case'double-brackets':type='template';break;case'comment':type='comment';break;default:type='advancedCode';}
return type;},expandPlaceholder:function(placeholder){var preview=this.getPreview(placeholder);var previewArea=preview.find('.RTEPlaceholderPreviewCode');if(previewArea.exists()){var domNode=previewArea[0];var scrollBarIsShown=(domNode.scrollHeight>domNode.clientHeight)||(domNode.scrollWidth>domNode.clientWidth);if(scrollBarIsShown){var height=domNode.scrollHeight;var width=domNode.scrollWidth;var x=parseInt(preview.offset().left)+width+16;var y=parseInt(preview.offset().top)+height+100;var editarea=$('#cke_contents_wpTextbox1');var maxX=parseInt(editarea.offset().left)+editarea.width();var maxY=parseInt(editarea.offset().top)+editarea.height();if(maxX<x){width-=(x-maxX);}
if(maxY<y){height-=(y-maxY);}
width=Math.max(width,350);height=Math.max(height,60);preview.children('.RTEPlaceholderPreviewInner').width(width);previewArea.height(height);previewArea.addClass('RTEPlaceholderPreviewExpanded');}
else{previewArea.removeClass('RTEPlaceholderPreviewExpanded');}}}});CKEDITOR.plugins.add('rte-signature',{init:function(editor){editor.addCommand('addsignature',{exec:function(editor){var sig=RTE.instance.document.createText(editor.config.signature_markup);RTE.tools.insertElement($(sig.$));}});editor.ui.addButton('Signature',{title:editor.lang.signature.add,label:editor.lang.signature.label,className:'RTESignatureButton',command:'addsignature'});}});CKEDITOR.config.signature_markup='~~~~';CKEDITOR.plugins.add('rte-template',{init:function(editor){var self=this;CKEDITOR.dialog.add('rte-template',this.path+'dialogs/template.js');editor.ui.addRichCombo('Template',{label:editor.lang.templateDropDown.label,title:editor.lang.templateDropDown.title,className:'cke_template',multiSelect:false,panel:{css:[CKEDITOR.getUrl(editor.skinPath+'editor.css')].concat(editor.config.contentsCss)},init:function(){this.startGroup(editor.lang.templateDropDown.title);var templates=window.RTETemplatesDropdown;for(t=0;t<templates.length;t++){var value=templates[t].replace(/_/g,' ');var label=window.RTEMessages.template+':'+value;this.add(templates[t],label,value);}
this.add('--other--','<strong>'+editor.lang.templateDropDown.chooseAnotherTpl+'</strong>',editor.lang.templateDropDown.chooseAnotherTpl);},onClick:function(value){RTE.log('template dropdown: "'+value+'"');if(value=='--other--'){RTE.templateEditor.createTemplateEditor(false);}
else{RTE.track('template','dialog','search','dropdown',value);RTE.templateEditor.createTemplateEditor(value);}
var dropdown=this;setTimeout(function(){dropdown.setValue(false);},50);}});}});RTE.templateEditor={placeholder:false,data:{},dialog:{},doPreview:function(callback){RTE.log('generating preview...');$('#templatePreview').html('').addClass('loading');var params={};$('#templateParameters').find('textarea').each(function(){var key=$(this).attr('rel');var value=$(this).attr('value');params[key]=value;});var wikitext=this.data.wikitext=this.generateWikitext(this.data.title,params);RTE.tools.parse(wikitext,function(html){$('#templatePreview').html(html).removeClass('loading');$('#templatePreview').bind('click',function(ev){ev.preventDefault();});if(typeof callback=='function'){callback();}});},generateWikitext:function(name,params){var wikitext,paramsCount=0;wikitext='{{'+name;$.each(params,function(key,value){if(value==''){return;}
wikitext+='\n|';if(parseInt(key)==key){wikitext+=value;}
else{wikitext+=key+' = '+value;}
paramsCount++;});if(paramsCount>0){wikitext+='\n';}
wikitext+='}}';return wikitext;},selectStep:function(stepId){RTE.log('showing step #'+stepId);RTE.log(this.placeholder);var dialog=this.dialog;dialog.selectPage('step'+stepId);var info=this.placeholder.data('info');var data=this.placeholder.getData();$('.templateEditorDialog').find('.cke_dialog_footer').hide();switch(stepId){case 1:var renderFirstStep=function(){var html='';$(window.RTEHotTemplates).each(function(i,template){html+='<li><a rel="'+template+'">'+template.replace(/_/g,' ')+'</a></li>';});$('#templateEditorHotTemplates').html(html);var html='';$(window.RTEMagicWords.magicWords).each(function(i,magic){html+='<li><a rel="'+magic+'">'+magic.toUpperCase()+'</a></li>';});$('#templateEditorMagicWords').html(html);var self=this;$('#templateEditorHotTemplates').find('a').click(function(ev){var templateName=$(this).attr('rel');RTE.templateEditor.selectTemplate(dialog,templateName);});$('#templateEditorMagicWords').find('a').click(function(ev){var name=$(this).attr('rel');RTE.log('adding magic word: '+name);var data={};var isDoubleUnderscore=RTEMagicWords.doubleUnderscores.indexOf(name)>-1;if(isDoubleUnderscore){data.type='double-underscore';data.wikitext='__'+name.toUpperCase()+'__';}
else{data.type='double-brackets';data.title=name.toUpperCase();data.wikitext='{{'+name.toUpperCase()+'}}';}
RTE.log(data);var placeholder=RTE.templateEditor.placeholder;placeholder.setType(data.type);placeholder.setData(data);RTE.templateEditor.usePlaceholder(placeholder);dialog.hide();RTE.templateEditor.commitChanges();});dialog.enableSuggesionsOn(dialog.getContentElement('step1','templateSearchQuery'),[10]);}
if(typeof window.RTEHotTemplates=='undefined'){dialog.setLoading(true);RTE.ajax('getHotTemplates',{},function(hotTemplates){dialog.setLoading(false);window.RTEHotTemplates=hotTemplates;renderFirstStep();});}
else{renderFirstStep();}
break;case 2:$('.templateEditorDialog').find('.cke_dialog_footer').show();var templateName=info.title.replace(/_/g,' ');templateName=templateName.replace(/^Template:/,window.RTEMessages.template+':');$('#templateEditorTemplateName').html(templateName);var viewHref=window.wgServer+window.wgArticlePath.replace(/\$1/,encodeURI(info.title.replace(/ /g,'_')));$('#templateEditorViewLink').attr('href',viewHref);var html='';$.each(info.availableParams,function(i,key){var value=(info.passedParams&&typeof info.passedParams[key]!='undefined')?info.passedParams[key]:'';value=value.replace(/&/g,'&amp;');var keyLabel=!!parseInt(key)?('#'+parseInt(i+1)):key;html+='<dt><label for="templateEditorParameter'+i+'">'+keyLabel+'</label></dt>';html+='<dd><textarea rel="'+key+'" id="templateEditorParameter'+i+'">'+value+'</textarea></dd>';});$('#templateParameters').html(html);this.doPreview();break;}},selectTemplate:function(dialog,templateName){RTE.log('selecting template: '+templateName);var data={title:templateName,wikitext:'{{'+templateName+'}}'};this.placeholder.setType('double-brackets');this.placeholder.setData(data);RTE.templateEditor.usePlaceholder(this.placeholder);dialog.setLoading(true);var self=this;RTE.tools.resolveDoubleBrackets(data.wikitext,function(info){dialog.setLoading(false);self.placeholder.data('info',info);if((typeof info.availableParams!='undefined')&&(info.availableParams.length>0)){RTE.templateEditor.selectStep(2);}
else{RTE.log('given template contains no params - inserting / updating...');RTE.templateEditor.commitChanges();dialog.hide();return;}});},usePlaceholder:function(placeholder){this.placeholder=placeholder;this.data=placeholder.getData();},commitChanges:function(){RTE.log('storing modified template data');RTE.log(this.data);this.placeholder.setData(RTE.templateEditor.data);this.placeholder.removeData('preview');this.placeholder.removeData('info');if(!this.placeholder.parent().exists()){RTE.tools.insertElement(this.placeholder);}
this.placeholder=false;this.data={};},showTemplateEditor:function(placeholder){RTE.log('calling template editor...');RTE.templateEditor.usePlaceholder(placeholder);RTE.instance.openDialog('rte-template');},createTemplateEditor:function(templateName){var placeholder=RTE.tools.createPlaceholder('double-brackets');if(templateName==false){RTE.log('calling template editor to choose a template...');this.showTemplateEditor(placeholder);return;}
RTE.log('calling template editor for new template "'+templateName+'"');var wikitext='{{'+templateName+'}}';placeholder.setData({title:templateName,wikitext:wikitext});var self=this;RTE.tools.resolveDoubleBrackets(wikitext,function(info){placeholder.data('info',info);if((typeof info.availableParams!='undefined')&&(info.availableParams.length>0)){self.showTemplateEditor(placeholder);}
else{RTE.log('given template contains no params - inserting...');RTE.tools.insertElement(placeholder);return;}});}};CKEDITOR.dialog.add('rte-template',function(editor)
{var lang=editor.lang.templateEditor;var magicWordsLink=window.wgArticlePath.replace(/\$1/,lang.dialog.magicWordsLink.replace(/ /g,'_'))
return{title:lang.title,minWidth:760,minHeight:365,buttons:[{id:'chooseAnotherTpl',type:'button',label:lang.editor.chooseAnotherTpl,className:'cke_dialog_choose_another_tpl',buttonType:'secondary',onClick:function(ev){RTE.templateEditor.selectStep(1);}},CKEDITOR.dialog.okButton,CKEDITOR.dialog.cancelButton],contents:[{id:'step1',label:'Step 1',elements:[{type:'hbox',widths:['300px','300px','30px'],children:[{type:'html',className:'templateEditorHeader dark_text_2',html:lang.dialog.search},{id:'templateSearchQuery',style:'margin-top: 7px',type:'text'},{id:'templateDoSearch',type:'button',label:lang.dialog.insert,style:'position: relative; top: 6px',onClick:function(){var dialog=this.getDialog();var templateName=dialog.getValueOf('step1','templateSearchQuery');if(templateName==''){return;}
RTE.templateEditor.selectTemplate(dialog,templateName);RTE.track('template','dialog','search','suggest',templateName);}}]},{type:'html',html:'<hr />'},{type:'html',className:'templateEditorHeader',html:lang.dialog.browse},{type:'hbox',widths:['510px','250px'],children:[{type:'html',html:'<h2>'+lang.dialog.mostFrequentlyUsed+'</h2>'+'<ul id="templateEditorHotTemplates"></ul>'},{type:'html',html:'<h2><a id="templateLinkToHelp" target="_blank" href="'+magicWordsLink+'">'+lang.dialog.magicWords+'</a></h2>'+'<ul id="templateEditorMagicWords"></ul>'}]}]},{id:'step2',label:'Step 2',elements:[{type:'html',html:'<div id="templateEditorIntro">'+'<h1 id="templateEditorTemplateName" class="dark_text_2"></h1>'+'<a id="templateEditorViewLink" href="#" target="_blank">'+lang.editor.viewTemplate+'</a>'+'<p>'+lang.editor.intro+'</p>'+'</div>'},{type:'hbox',widths:['330px','100px','330px'],children:[{type:'html',html:'<h2>'+lang.editor.parameters+'</h2>'+'<dl id="templateParameters"></dl>'},{type:'button',label:lang.editor.previewButton,onClick:function(){var self=this;this.disable();RTE.templateEditor.doPreview.apply(RTE.templateEditor,[function(){self.enable();}]);RTE.track('template','dialog','editor','preview');}},{type:'html',html:'<h2>'+lang.editor.previewTitle+'</h2>'+'<div id="templatePreview" class="reset"></div>'}]}]}],onOk:function(){var step=parseInt(this.getActiveTab().charAt(4));switch(step){case 1:this.getContentElement('step1','templateDoSearch').fire('click');return false;case 2:RTE.templateEditor.doPreview(function(){RTE.templateEditor.commitChanges();});break;case 3:RTE.templateEditor.data.wikitext=$('#templateAdvEditorSource').attr('value');RTE.templateEditor.commitChanges();break;}},onShow:function(){this._.element.addClass('wikiaEditorDialog');this._.element.addClass('templateEditorDialog');RTE.templateEditor.dialog=this;RTE.templateEditor.data=RTE.templateEditor.placeholder.getData();var info=RTE.templateEditor.placeholder.data('info');var step=1;if(typeof info!='undefined'){RTE.log(info);step=2;}
this.getButton('ok').on('click',function(ev){RTE.track('template','dialog','editor','ok');});this.getButton('chooseAnotherTpl').on('click',function(ev){RTE.track('template','dialog','editor','chooseAnother');});RTE.templateEditor.selectStep(step);},onHide:function(){var step=(this.getActiveTab()=='step1')?'search':'editor';RTE.track('template','dialog',step,'close');}};});CKEDITOR.plugins.add('rte-temporary-save',{init:function(editor){editor.on('instanceReady',function(){var mode=$('#RTETemporarySaveType').attr('value');if(mode){RTE.log('restoring temporary save (using "'+mode+'" mode)');var content=$('#RTETemporarySaveContent').attr('value');editor.forceSetMode(mode,content);RTE.track('temporarySave','restore');}});$(window).bind('beforeunload',function(ev){RTE.log('onbeforeunload: performing temporary save');$('#RTETemporarySaveType').attr('value',RTE.instance.mode);$('#RTETemporarySaveContent').attr('value',RTE.instance.getData());RTE.track('temporarySave','store');});}});CKEDITOR.plugins.add('rte-toolbar',{editorContainer:false,updateToolbarLock:false,init:function(editor){var self=this;editor.on('themeSpace',function(event){if(event.data.space=='top')
{var config=editor.config['toolbar_'+editor.config.toolbar];var messages=RTE.instance.lang.bucket;var output=['<table id="cke_toolbar"><tr>'];for(var b=0;b<config.length;b++)
{var bucket=config[b];output.push('<td><span class="headline color1">'+messages[bucket.msg]+'</span>');output.push('<div class="bucket_buttons color1"><div class="color1">');for(var g=0;g<bucket.groups.length;g++)
{output.push('<span class="cke_buttons_group">');var items=bucket.groups[g];var itemsCount=items.length;for(var i=0;i<itemsCount;i++){var itemName=items[i];var item=editor.ui.create(itemName);if(item)
{item.wrapperClassName='';if(i==0){item.wrapperClassName+='cke_button_first ';}
if(i==itemsCount-1){item.wrapperClassName+='cke_button_last ';}
var itemObj=item.render(editor,output);}}
output.push('</span>');}
output.push('</div></div><span class="tagline color1"></span></td>');}
output.push('</tr></table>');output.push('<div id="mw-toolbar"></div>');event.data.html+=output.join('');setTimeout(function(){self.updateToolbar.apply(self);},50);}});editor.on('instanceReady',function(){var toolbar=$('#cke_toolbar');RTE.tools.getThemeColors();toolbar.find('.color1').css({backgroundColor:RTE.config.baseBackgroundColor,color:RTE.config.baseColor});toolbar.parent().parent().attr('id','cke_toolbar_row');$(window).resize(function(){self.updateToolbar.apply(self);});editor.on('widescreen',function(){self.updateToolbar.apply(self);});self.updateToolbar();toolbar.find('td').hover(function(){self.showBucket.apply(this);},function(){self.hideBucket.apply(this);setTimeout(function(){self.updateToolbar.apply(self);},10);});});editor.on('instanceReady',function(){var toolbarWrapper=$('#cke_top_wpTextbox1');RTE.tools.getThemeColors();toolbarWrapper.css({backgroundColor:RTE.config.baseBackgroundColor,color:RTE.config.baseColor});var toolbar=$('#cke_toolbar');var MWtoolbar=$('#mw-toolbar');for(var i=0;i<mwEditButtons.length;i++){mwInsertEditButton(MWtoolbar[0],mwEditButtons[i]);}
for(var i=0;i<mwCustomEditButtons.length;i++){mwInsertEditButton(MWtoolbar[0],mwCustomEditButtons[i]);}
editor.fire('toolbarReady',toolbar);$('#toolbar').remove();self.editorContainer=$(RTE.instance.container.$).find('.cke_contents');});window.insertTags=function(tagOpen,tagClose,sampleText){var txtarea=self.editorContainer.children('textarea')[0];var selText,isSample=false;if(document.selection&&document.selection.createRange){if(document.documentElement&&document.documentElement.scrollTop)
var winScroll=document.documentElement.scrollTop
else if(document.body)
var winScroll=document.body.scrollTop;txtarea.focus();var range=document.selection.createRange();selText=range.text;checkSelectedText();range.text=tagOpen+selText+tagClose;if(isSample&&range.moveStart){if(window.opera)
tagClose=tagClose.replace(/\n/g,'');range.moveStart('character',-tagClose.length-selText.length);range.moveEnd('character',-tagClose.length);}
range.select();if(document.documentElement&&document.documentElement.scrollTop)
document.documentElement.scrollTop=winScroll
else if(document.body)
document.body.scrollTop=winScroll;}else if(txtarea.selectionStart||txtarea.selectionStart=='0'){var textScroll=txtarea.scrollTop;txtarea.focus();var startPos=txtarea.selectionStart;var endPos=txtarea.selectionEnd;selText=txtarea.value.substring(startPos,endPos);checkSelectedText();txtarea.value=txtarea.value.substring(0,startPos)
+tagOpen+selText+tagClose
+txtarea.value.substring(endPos,txtarea.value.length);if(isSample){txtarea.selectionStart=startPos+tagOpen.length;txtarea.selectionEnd=startPos+tagOpen.length+selText.length;}else{txtarea.selectionStart=startPos+tagOpen.length+selText.length+tagClose.length;txtarea.selectionEnd=txtarea.selectionStart;}
txtarea.scrollTop=textScroll;}
function checkSelectedText(){if(!selText){selText=sampleText;isSample=true;}else if(selText.charAt(selText.length-1)==' '){selText=selText.substring(0,selText.length-1);tagClose+=' '}}};},updateToolbar:function(){var self=this;var lockTimeout=250;if(this.updateToolbarLock){setTimeout(function(){self.updateToolbar.apply(self);},lockTimeout+50);return;}
this.updateToolbarLock=true;var anyhidden=false;$('#cke_toolbar').find('td').each(function(){var hidden=0;var cell=$(this);var bucket=cell.children('.bucket_buttons').children('div');if(parseInt(bucket.height())>60){var groups=bucket.children('.cke_buttons_group');var baseline=Math.floor(bucket.offset().top);groups.reverse().each(function(){var nodeTop=Math.floor($(this).offset().top);if(nodeTop<baseline+30){return false;}
hidden+=$(this).children().length;anyhidden=true;});}
if(hidden>0){cell.find(".tagline").html(hidden+' '+RTE.messages.more);cell.addClass('more');}else{cell.find(".tagline").html("");cell.removeClass('more');}});if(anyhidden){$('#cke_toolbar').addClass('more');}else{$('#cke_toolbar').removeClass('more');}
var wrapperHeight=200;$('#cke_toolbar').find('td').each(function(){var cell=$(this);var bucketHeight=0;cell.children().each(function(){bucketHeight+=$(this).height();});wrapperHeight=Math.min(wrapperHeight,bucketHeight);});if(CKEDITOR.env.ie){var toolbarWrapper=$('#cke_top_wpTextbox1').parent();}
else{var toolbarWrapper=$('#cke_top_wpTextbox1');}
toolbarWrapper.height(wrapperHeight);RTE.repositionRTEStuff();setTimeout(function(){self.updateToolbarLock=false;},lockTimeout);},showBucket:function(){var wrapper=$(this).find('.bucket_buttons');var buttons=wrapper.children('div');buttons.css('height','auto');wrapper.parent().addClass('bucket_expanded');},hideBucket:function(){var wrapper=$(this).find('.bucket_buttons');var buttons=wrapper.children('div');wrapper.parent().removeClass('bucket_expanded');buttons.css('height','auto');}});CKEDITOR.plugins.add('rte-tools',{});window.RTE.tools={"alert":function(title,content){window.$.showModal(title,'<p>'+content+'</p>',{className:'RTEModal'});},callFunction:function(fn,element,data){if(typeof fn!='function'){return;}
var ev=jQuery.Event('rte');ev.data=(typeof data=='object')?data:{};ev.data.element=element||false;ev.target=window.document.createElement('div');fn.call(window,ev);},checkInternalLink:function(element,pageName){var anchor='';if(/^#(.+)/.test(pageName)){anchor=pageName;pageName=window.wgPageName;}
RTE.ajax('checkInternalLink',{title:pageName},function(data){if(!data.exists){element.addClass('new');}
else{element.removeClass('new');}
element.setAttribute('href',data.href+anchor);element.setAttribute('title',data.title);});},"confirm":function(title,question,callback){var html='<p>'+question+'</p>'+'<div class="RTEConfirmButtons neutral">'+'<a id="RTEConfirmCancel" class="wikia-button secondary"><span>'+RTE.instance.lang.common.cancel+'</span></a>'+'<a id="RTEConfirmOk" class="wikia-button"><span>'+RTE.instance.lang.common.ok+'</span></a>'+'</div>';$.showModal(title,html,{id:'RTEConfirm',className:'RTEModal',callbackBefore:function(){$('#RTEConfirmOk').click(function(){$('#RTEConfirm').closeModal();if(typeof callback=='function'){callback();}});$('#RTEConfirmCancel').click(function(){$('#RTEConfirm').closeModal();});}});},createPlaceholder:function(type,data){var placeholder=$('<img />',RTE.instance.document.$);placeholder.addClass('placeholder placeholder-'+type);placeholder.attr('src',wgBlankImgUrl).attr('type',type).attr('_rte_placeholder',1).attr('_rte_instance',RTE.instanceId);data=(typeof data=='object')?data:{};data.type=type;placeholder.setData(data);RTE.log('creating new placeholder for "'+type+'"');RTE.log(placeholder);return placeholder;},getEditorHeight:function(){return $('#cke_contents_wpTextbox1').height();},getThemeColors:function(){var colorPicker=$('#RTEColorPicker');if(!colorPicker.exists()){colorPicker=$('<div id="RTEColorPicker">').addClass('color1').appendTo('#RTEStuff').hide();}
RTE.config.baseBackgroundColor=colorPicker.css('backgroundColor');RTE.config.baseColor=colorPicker.css('color');},getImages:function(){var images=RTE.getEditor().find('img.image');return images;},getMedia:function(){var media=RTE.getEditor().find('img.image,img.video');return media;},getPlaceholderPosition:function(placeholder){var position=placeholder.position();var scrollTop;var scrollTopPage=$(window).scrollTop();var scrollTopEditor=RTE.instance.document.$.documentElement.scrollTop;if(CKEDITOR.env.ie){scrollTop=scrollTopEditor;}
else if(CKEDITOR.env.webkit){scrollTopEditor=RTE.instance.document.$.body.scrollTop;scrollTop=scrollTopEditor;}
else{scrollTop=scrollTopPage+scrollTopEditor;if(scrollTopPage>0){position.top+=scrollTopEditor;}}
return{left:parseInt(position.left-10),top:parseInt(position.top-scrollTop)};},getPlaceholders:function(type){var query=type?('img[type='+type+']'):'img.placeholder';var placeholders=RTE.getEditor().find(query);return placeholders;},getSelectionContent:function(){if(CKEDITOR.env.ie){var text=RTE.instance.document.$.selection.createRange().text;}
else{var text=RTE.instance.window.$.getSelection().toString();}
return text;},getVideos:function(){var videos=RTE.getEditor().find('img.video');return videos;},insertElement:function(element,dontReinitialize){RTE.instance.insertElement(new CKEDITOR.dom.element($(element)[0]));if(!dontReinitialize){RTE.instance.fire('wysiwygModeReady');}},isExternalLink:function(href){return this.isExternalLinkRegExp.test(href);},isExternalLinkRegExp:new RegExp('^'+window.RTEUrlProtocols),parseCache:{},parse:function(wikitext,callback){var cache=RTE.tools.parseCache;if(typeof cache[wikitext]!='undefined'){RTE.log('RTE.tools.parse() - cache hit');if(typeof callback=='function'){callback(cache[wikitext]);}
return;}
RTE.ajax('parse',{wikitext:wikitext,title:window.wgPageName},function(json){cache[wikitext]=json.html;if(typeof callback=='function'){callback(json.html);}});},parseRTE:function(wikitext,callback){RTE.ajax('rteparse',{wikitext:wikitext,title:window.wgPageName},function(json){if(typeof callback=='function'){callback(json.html);}});},renumberExternalLinks:function(){RTE.getEditor().find('a.autonumber').each(function(i){$(this).text('['+(i+1)+']');});},removeElement:function(elem){RTE.instance.fire('saveSnapshot');$(elem).remove();RTE.instance.fire('saveSnapshot');},removeResizeBox:function(){setTimeout(function(){if(CKEDITOR.env.gecko){var documentNode=RTE.instance.document.$;documentNode.designMode='off';documentNode.designMode='on';}},50);},resolveDoubleBracketsCache:{},resolveDoubleBrackets:function(wikitext,callback){var cache=RTE.tools.resolveDoubleBracketsCache;if(typeof cache[wikitext]!='undefined'){RTE.log('RTE.tools.resolveDoubleBrackets() - cache hit');if(typeof callback=='function'){callback(cache[wikitext]);}
return;}
RTE.ajax('resolveDoubleBrackets',{wikitext:wikitext,title:window.wgPageName},function(json){cache[wikitext]=json;if(typeof callback=='function'){callback(json);}});},unselectable:function(elem){return;$(elem).each(function(i){var CKelem=new CKEDITOR.dom.element(this);CKelem.unselectable();});}}
CKEDITOR.plugins.add('rte-track',{init:function(editor){var self=this;editor.on('wysiwygModeReady',function(){editor.document.removeListener(self.trackApplyStyle);editor.document.on('applyStyle',self.trackApplyStyle);});editor.on('contextMenuOnOpen',self.trackContextMenuOpen);editor.on('contextMenuOnClick',self.trackContextMenuItem);editor.on('listCreated',self.trackListCreated);editor.on('RTEready',function(){self.trackLoadTime(editor);});editor.on('RTEready',function(){self.trackBrowser('init');});$('#wpSave').click(function(){self.trackBrowser('save');});editor.on('buttonClick',function(ev){var buttonClicked=ev.data.button;RTE.track('toolbar',buttonClicked.command);});editor.on('panelShow',function(ev){var me=ev.data.me;var id=me.className.split('_').pop();RTE.track('toolbar',id+'Menu','open');});editor.on('panelClick',function(ev){var me=ev.data.me;var value=ev.data.value;var id=me.className.split('_').pop();if(id=='template'){if(value=='--other--'){value='other';}
else{var panelItems=me._.items;var idx=0;for(tpl in panelItems){idx++;if(tpl==value){value=idx;break;}}}}
RTE.track('toolbar',id+'Menu',value);});editor.on('instanceReady',function(){$('#mw-toolbar').bind('click',function(ev){var target=$(ev.target).filter('img');if(!target.exists()){return;}
var id=target.attr('id').split('-').pop();RTE.track('source',id);});});},trackApplyStyle:function(ev){var style=ev.data.style;var remove=ev.data.remove;if(style&&!remove){RTE.track('toolbar','format',style);}},trackContextMenuOpen:function(ev){RTE.track('contextMenu','open');},trackContextMenuItem:function(ev){var name=ev.data.item.command;var g,groups=['cell','row','column'];for(g=0;g<groups.length;g++){var group=groups[g];if(name.indexOf(group)==0){RTE.track('contextMenu','action',group,name);return;}}
RTE.track('contextMenu','action',name);},trackListCreated:function(ev){var listNode=ev.data.listNode;var listType=(listNode.getName()=='ul')?'unorderedList':'orderedList';RTE.track('format',listType);},trackLoadTime:function(editor){var trackingLoadTime=parseInt(RTE.loadTime*10)*100;switch(editor.mode){case'source':RTE.track('init','sourceMode',trackingLoadTime);if(window.RTEEdgeCase){RTE.track('init','edgecase',window.RTEEdgeCase);}
break;case'wysiwyg':RTE.track('init','wysiwygMode',trackingLoadTime);break;}},trackBrowser:function(eventName){var env=CKEDITOR.env;var name=(env.ie?'ie':env.gecko?'gecko':env.opera?'opera':env.air?'air':env.webkit?'webkit':'unknown');if(name=='gecko'){var version=parseInt(env.version/10000)+'.'+parseInt(env.version/100%100)+'.'+(env.version%100);}
else{var version=env.version;}
RTE.track('browser',eventName,name,version);}});CKEDITOR.plugins.add('rte-widescreen',{init:function(editor){var toggleFn=window.ToggleWideScreen;var initialState=$('body').hasClass('editingWide')?CKEDITOR.TRISTATE_ON:CKEDITOR.TRISTATE_OFF;editor.addCommand('widescreen',{exec:function(editor){toggleFn.call()
this.toggleState();editor.fire('widescreen');},state:initialState});editor.ui.addButton('Widescreen',{title:editor.lang.widescreen.toggle,className:'RTEWidescreenButton',command:'widescreen'});}});CKEDITOR.themes.add('wikia',(function()
{return{build:function(editor,themePath)
{var name=editor.name,element=editor.element,elementMode=editor.elementMode;if(!element||elementMode==CKEDITOR.ELEMENT_MODE_NONE)
return;if(elementMode==CKEDITOR.ELEMENT_MODE_REPLACE)
element.hide();var topHtml=editor.fire('themeSpace',{space:'top',html:''}).html;var contentsHtml=editor.fire('themeSpace',{space:'contents',html:''}).html;var bottomHtml=editor.fireOnce('themeSpace',{space:'bottom',html:''}).html;var height=contentsHtml&&editor.config.height;var tabIndex=editor.config.tabIndex||editor.element.getAttribute('tabindex')||0;if(!contentsHtml)
height='auto';else if(!isNaN(height))
height+='px';var style='';var width=editor.config.width;if(width)
{if(!isNaN(width))
width+='px';style+="width: "+width+";";}
var container=CKEDITOR.dom.element.createFromHtml(['<span'+' id="cke_',name,'"'+' onmousedown="return false;"'+' class="',editor.skinClass,'"'+' dir="',editor.lang.dir,'"'+' title="',(CKEDITOR.env.gecko?' ':''),'"'+' lang="',editor.langCode,'"'+' tabindex="'+tabIndex+'"'+
(style?' style="'+style+'"':'')+'>'+'<span class="',CKEDITOR.env.cssClass,'">'+'<span class="cke_wrapper cke_',editor.lang.dir,'">'+'<table class="cke_editor" border="0" cellspacing="0" cellpadding="0"><tbody>'+'<tr',topHtml?'':' style="display:none"','><td id="cke_top_',name,'" class="cke_top" style="background-color: '+editor.config.baseBackgroundColor+'; color:'+editor.config.baseColor+'">',topHtml,'</td></tr>'+'<tr',contentsHtml?'':' style="display:none"','><td id="cke_contents_',name,'" class="cke_contents" style="height:',height,'">',contentsHtml,'</td></tr>'+'<tr',bottomHtml?'':' style="display:none"','><td id="cke_bottom_',name,'" class="cke_bottom">',bottomHtml,'</td></tr>'+'</tbody></table>'+'<style>.',editor.skinClass,'{visibility:hidden;}</style>'+'</span>'+'</span>'+'</span>'].join(''));container.getChild([0,0,0,0,0]).unselectable();container.getChild([0,0,0,0,2]).unselectable();if(elementMode==CKEDITOR.ELEMENT_MODE_REPLACE)
container.insertAfter(element);else
element.append(container);editor.container=container;container.disableContextMenu();editor.fireOnce('themeLoaded');editor.fireOnce('uiReady');},buildDialog:function(editor)
{var baseIdNumber=CKEDITOR.tools.getNextNumber();var element=CKEDITOR.dom.element.createFromHtml(['<div id="cke_'+editor.name.replace('.','\\.')+'_dialog" class="cke_skin_',editor.skinName,'" dir="',editor.lang.dir,'"'+' lang="',editor.langCode,'"'+'>'+'<div class="cke_dialog',' '+CKEDITOR.env.cssClass,' cke_',editor.lang.dir,'" style="position:absolute">'+'<div class="%body">'+'<div id="%title#" class="%title"></div>'+'<div id="%close_button#" class="%close_button"></div>'+'<div id="%tabs#" class="%tabs accent"></div>'+'<div id="%contents#" class="%contents"></div>'+'<div id="%footer#" class="%footer"></div>'+'</div>'+'<div id="%tl#" class="%tl"></div>'+'<div id="%tc#" class="%tc"></div>'+'<div id="%tr#" class="%tr"></div>'+'<div id="%ml#" class="%ml"></div>'+'<div id="%mr#" class="%mr"></div>'+'<div id="%bl#" class="%bl"></div>'+'<div id="%bc#" class="%bc"></div>'+'<div id="%br#" class="%br"></div>'+'</div>',(CKEDITOR.env.ie?'':'<style>.cke_dialog{visibility:hidden;}</style>'),'</div>'].join('').replace(/#/g,'_'+baseIdNumber).replace(/%/g,'cke_dialog_'));var body=element.getChild([0,0]);body.getChild(0).unselectable();body.getChild(1).unselectable();body.getChild(0).setStyles({backgroundColor:RTE.config.baseBackgroundColor,color:RTE.config.baseColor});return{element:element,parts:{dialog:element.getChild(0),title:body.getChild(0),close:body.getChild(1),tabs:body.getChild(2),contents:body.getChild(3),footer:body.getChild(4)}};},destroy:function(editor)
{var container=editor.container,panels=editor.panels;if(CKEDITOR.env.ie)
{container.setStyle('display','none');var $range=document.body.createTextRange();$range.moveToElementText(container.$);try
{$range.select();}
catch(e){}}
if(container)
container.remove();for(var i=0;panels&&i<panels.length;i++)
panels[i].remove();if(editor.elementMode==CKEDITOR.ELEMENT_MODE_REPLACE)
{editor.element.show();delete editor.element;}}};})());CKEDITOR.editor.prototype.getThemeSpace=function(spaceName)
{var spacePrefix='cke_'+spaceName;var space=this._[spacePrefix]||(this._[spacePrefix]=CKEDITOR.document.getById(spacePrefix+'_'+this.name));return space;};CKEDITOR.editor.prototype.resize=function(width,height,isContentHeight,resizeInner)
{var numberRegex=/^\d+$/;if(numberRegex.test(width))
width+='px';var contents=CKEDITOR.document.getById('cke_contents_'+this.name);var outer=resizeInner?contents.getAscendant('table').getParent():contents.getAscendant('table').getParent().getParent().getParent();CKEDITOR.env.webkit&&outer.setStyle('display','none');outer.setStyle('width',width);if(CKEDITOR.env.webkit)
{outer.$.offsetWidth;outer.setStyle('display','');}
var delta=isContentHeight?0:(outer.$.offsetHeight||0)-(contents.$.clientHeight||0);contents.setStyle('height',Math.max(height-delta,0)+'px');this.fire('resize');};CKEDITOR.editor.prototype.getResizable=function()
{return this.container.getChild([0,0]);};CKEDITOR.skins.add('wikia',(function()
{var preload=[];if(CKEDITOR.env.ie&&CKEDITOR.env.version<7)
{preload.push('icons.png?20100510','images/sprites_ie6.png?20100510','images/dialog_sides.gif?20100510');}
return{preload:preload,editor:{css:[window.RTEDevMode?'editor.css':'editor.min.css']},dialog:{css:['dialog.css']},templates:{css:['templates.css']},margins:[0,0,0,0],init:function(editor)
{if(editor.config.width&&!isNaN(editor.config.width))
editor.config.width-=12;var uiColorMenus=[];var uiColorRegex=/\$color/g;var uiColorMenuCss="/* UI Color Support */\
.cke_skin_wikia .cke_menuitem .cke_icon_wrapper\
{\
 background-color: $color !important;\
 border-color: $color !important;\
}\
\
.cke_skin_wikia .cke_menuitem a:hover .cke_icon_wrapper,\
.cke_skin_wikia .cke_menuitem a:focus .cke_icon_wrapper,\
.cke_skin_wikia .cke_menuitem a:active .cke_icon_wrapper\
{\
 background-color: $color !important;\
 border-color: $color !important;\
}\
\
.cke_skin_wikia .cke_menuitem a:hover .cke_label,\
.cke_skin_wikia .cke_menuitem a:focus .cke_label,\
.cke_skin_wikia .cke_menuitem a:active .cke_label\
{\
 background-color: $color !important;\
}\
\
.cke_skin_wikia .cke_menuitem a.cke_disabled:hover .cke_label,\
.cke_skin_wikia .cke_menuitem a.cke_disabled:focus .cke_label,\
.cke_skin_wikia .cke_menuitem a.cke_disabled:active .cke_label\
{\
 background-color: transparent !important;\
}\
\
.cke_skin_wikia .cke_menuitem a.cke_disabled:hover .cke_icon_wrapper,\
.cke_skin_wikia .cke_menuitem a.cke_disabled:focus .cke_icon_wrapper,\
.cke_skin_wikia .cke_menuitem a.cke_disabled:active .cke_icon_wrapper\
{\
 background-color: $color !important;\
 border-color: $color !important;\
}\
\
.cke_skin_wikia .cke_menuitem a.cke_disabled .cke_icon_wrapper\
{\
 background-color: $color !important;\
 border-color: $color !important;\
}\
\
.cke_skin_wikia .cke_menuseparator\
{\
 background-color: $color !important;\
}\
\
.cke_skin_wikia .cke_menuitem a:hover,\
.cke_skin_wikia .cke_menuitem a:focus,\
.cke_skin_wikia .cke_menuitem a:active\
{\
 background-color: $color !important;\
}";if(CKEDITOR.env.webkit)
{uiColorMenuCss=uiColorMenuCss.split('}').slice(0,-1);for(var i=0;i<uiColorMenuCss.length;i++)
uiColorMenuCss[i]=uiColorMenuCss[i].split('{');}
function addStylesheet(document)
{var node=document.getHead().append('style');node.setAttribute("id","cke_ui_color");node.setAttribute("type","text/css");return node;}
function updateStylesheets(styleNodes,styleContent,replace)
{var r,i,content;for(var id=0;id<styleNodes.length;id++)
{if(CKEDITOR.env.webkit)
{for(i=0;i<styleNodes[id].$.sheet.rules.length;i++)
styleNodes[id].$.sheet.removeRule(i);for(i=0;i<styleContent.length;i++)
{content=styleContent[i][1];for(r=0;r<replace.length;r++)
content=content.replace(replace[r][0],replace[r][1]);styleNodes[id].$.sheet.addRule(styleContent[i][0],content);}}
else
{content=styleContent;for(r=0;r<replace.length;r++)
content=content.replace(replace[r][0],replace[r][1]);if(CKEDITOR.env.ie)
styleNodes[id].$.styleSheet.cssText=content;else
styleNodes[id].setHtml(content);}}}
var uiColorRegexp=/\$color/g;CKEDITOR.tools.extend(editor,{uiColor:null,getUiColor:function()
{return this.uiColor;},setUiColor:function(color)
{var cssContent,uiStyle=addStylesheet(CKEDITOR.document),cssId='#cke_'+editor.name.replace('.','\\.');var cssSelectors=[cssId+" .cke_wrapper",cssId+"_dialog .cke_dialog_contents",cssId+"_dialog a.cke_dialog_tab",cssId+"_dialog .cke_dialog_footer"].join(',');var cssProperties="background-color: $color !important;";if(CKEDITOR.env.webkit)
cssContent=[[cssSelectors,cssProperties]];else
cssContent=cssSelectors+'{'+cssProperties+'}';return(this.setUiColor=function(color)
{var replace=[[uiColorRegexp,color]];editor.uiColor=color;updateStylesheets([uiStyle],cssContent,replace);updateStylesheets(uiColorMenus,uiColorMenuCss,replace);})(color);}});editor.on('menuShow',function(event)
{var panel=event.data[0];var iframe=panel.element.getElementsByTag('iframe').getItem(0).getFrameDocument();if(!iframe.getById('cke_ui_color'))
{var node=addStylesheet(iframe);uiColorMenus.push(node);var color=editor.getUiColor();if(color)
updateStylesheets([node],uiColorMenuCss,[[uiColorRegexp,color]]);}});if(editor.config.uiColor)
editor.setUiColor(editor.config.uiColor);}};})());if(CKEDITOR.dialog)
{CKEDITOR.dialog.on('resize',function(evt)
{var data=evt.data,width=data.width,height=data.height,dialog=data.dialog,contents=dialog.parts.contents,standardsMode=!CKEDITOR.env.quirks;if(data.skin!='wikia')
return;contents.setStyles((CKEDITOR.env.ie||(CKEDITOR.env.gecko&&CKEDITOR.env.version<10900))?{width:width+'px',height:height+'px'}:{'min-width':width+'px','min-height':height+'px'});if(!CKEDITOR.env.ie)
return;setTimeout(function()
{var body=contents.getParent(),innerDialog=body.getParent();var el=innerDialog.getChild(2);el.setStyle('width',(body.$.offsetWidth)+'px');el=innerDialog.getChild(7);el.setStyle('width',(body.$.offsetWidth-28)+'px');el=innerDialog.getChild(4);el.setStyle('height',(body.$.offsetHeight-31-14)+'px');el=innerDialog.getChild(5);el.setStyle('height',(body.$.offsetHeight-31-14)+'px');},100);});}