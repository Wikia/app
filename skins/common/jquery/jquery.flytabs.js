// FlyTabs version 1.01 - 12/12/2008
// Copyright © Milan Adamovsky
// E-mail  : milan@adamovsky.com   
// Website : http://www.adamovsky.com/flytabs                                 
// License : Must give credit to use in any way (e.g. commercially, personally, academically).
// I kept the notice short so you will keep this notice in here. Thanks!

(function($) {

 var _data = new Object();

 if (!_data['tabs'])
  _data['tabs'] = new Object();
 
 if (!_data['core'])
  _data['core'] = new Object();

 var _selector = '';
 var _temp_selector = '';
 var init = $.prototype.init; 
 // init rewrite code borrowed from Brandon Aaron
 $.prototype.init = function(selector, context) {

   var r = init.apply(this, arguments);
	
   if (selector && selector.selector)
     r.context = selector.context, r.selector = selector.selector;
		
   if ( typeof selector == 'string' )
    {
     r.context = context || document, r.selector = selector;
     _temp_selector = r.selector; // added closure
    }
  return r;
 };

 $.prototype.init.prototype = $.prototype;

 $.fn.flyTabs = {
   config : function(args) { 
    _selector = _temp_selector;
    return _config(args);
   },
   addTab : function(args) { 
    _selector = _temp_selector;
    return _addTab(args);
   },
   clearTabs : function(args) { 
    _selector = _temp_selector;
    return _clearTabs(args);
   },
   countTabs : function(args) { 
    _selector = _temp_selector;
    return _countTabs(args);
   },
   getTab : function(args) { 
    _selector = _temp_selector;
    return _getTab(args);
   },
   pinTab : function(args) { 
    _selector = _temp_selector;
    return _pinTab(args);
   },
   removeTab : function(args) { 
    _selector = _temp_selector;
    return _removeTab(args);
   }
  };

 // aliases
 $.fn.flyTabs['delTab'] = $.fn.flyTabs.removeTab;
 $.fn.flyTabs['deleteTab'] = $.fn.flyTabs.removeTab;
 $.fn.flyTabs['remTab'] = $.fn.flyTabs.removeTab;

 function _init (selector) {

   $(selector).each(function () { 

    var tabElement = '#' + this.id + ' li a';

// this needs to be worked on to support adding tabs to
// existing hard-coded HTML lists.
//    _bindEvents(this, tabElement, selector);

    _preparePanes(this, tabElement, selector);

   });

   function _preparePanes (parentThis) {

    if (document.getElementById(parentThis.id + '_wrapper'))
      return(0);

    var config = _getConfig();
    var tabId = parentThis.id;

    if (!(document.getElementById(tabId + '_wrapper')))
      $(parentThis)['after']('<div id="' + tabId + '_wrapper" class="fly_wrapper"><div id="' + tabId + '_content" class="fly_content" style="display:block"></div></div>');

    var _content_height = parseInt($('#' + tabId + '_content').css("padding-top")) + parseInt($('#' + tabId + '_content').css("padding-bottom")) + parseInt($('#' + tabId + '_content').css("height"));
    var _pane_height = parseInt($('#' + tabId + '_wrapper').css("height"));
    var _min_height = parseInt($('#' + tabId + '_wrapper').css("min-height"));

    _data['core']['initHeight'] = _pane_height == _content_height ? null : _pane_height;
    _data['core']['minHeight'] = _min_height;

    if (config.html)
     {
      if (!$.browser.msie)
        $('#' + tabId + '_wrapper').css({ 'overflow' : 'auto' });
      $('#' + tabId + '_content').html(config.html);
     }

   };

  return (selector);  
 };
 function _config (args) {

    var config = $(_selector).data('config');

    if (config)
     {
      alert('Config has already been defined for ' + _selector);
     }

    var opts = $.extend({
                         'align': 'top',
                         'effect': 'yes',
                         'html': ''
                        }, args);   

    $(_selector).data('config', opts);

    return (opts);

 };
 function _handleAlign (level, index) {

    var config = _getConfig();
    switch(config.align) {
     case ('left') :
      _setLeftCSS({'level' : level, 'index' : index});
      break;
     default :
      _setTopCSS({'level' : level, 'index' : index});
      break;
    }

 };

 function _adjustWrapper(args) {

   var config = _getConfig();
   var tabsId = args['tabsId'];

   if (config.html && !$.browser.msie)
    {
     if (!_data['core']['minHeight'])
       $('#' + tabsId + '_wrapper').css({ 'min-height' : ((_data['core']['initHeight'] || _findDim('scrollHeight')) + ($.browser.msie ? 7 : 2)) + "px", 'margin-left': $('#' + tabsId).width() + parseInt($('#' + tabsId).css("padding-left"))  + parseInt($('#' + tabsId).css("padding-right")) + "px" });
    }
   else
     $('#' + tabsId + '_wrapper').css({ 'height' : ((_data['core']['initHeight'] || _findDim('scrollHeight')) + ($.browser.msie ? 7 : 2)) + "px", 'margin-left' : $('#' + tabsId).width() + parseInt($('#' + tabsId).css("padding-left"))  + parseInt($('#' + tabsId).css("padding-right")) + "px" });

   if ($.browser.msie)
     $('#' + tabsId + '_wrapper').css({'left' : "-3px"});
   else 
     _adjustTabs(args);
 };

 function _adjustTabs(args) {

   var tabsId = args['tabsId'];

   var tabsWidth = $('#' + tabsId).width() - parseInt($('#' + tabsId).css("padding-left"));

   $('#' + tabsId + ' li').each(function () {
       var _totalPadding = parseInt($(this).css("padding-left")) + parseInt($(this).css("padding-right"));
       var _tabLeft = parseInt($(this).css("left"));
       var _diff = (tabsWidth - $(this).width() - _totalPadding + 1);
       if (_diff > 0)
         $(this).css({ "left" : _tabLeft > _diff ? _tabLeft : _diff });
    });

 };

 function _setLeftCSS(args) {

    var level = args['level'];
    var index = args['index'];

    var $tabs = $(_selector);
    var tabData = _data['tabs'][_selector][index];   // this is only set if individual tab is selected


    $tabs.each(function() {

      var vars = new _Vars({ 'tabs' : '#' + this.id });
      var tabsId = this.id;

      var tabId;

      if (tabData)
       {
        tabId = tabData.id;
        vars.setTab('#' + tabData.id);
       }

      switch(level) {
       case(1): // no icon tab
       default:
        _adjustWrapper({"tabsId" : tabsId});
        $('#' + tabsId).css({ "margin": "0px", "padding-left" : "5px", "float" : "left", "textAlign" : "right" });
        $('#' + tabsId + ' li').css({ "border-right" : "0px", "margin-top" : "0px" });
        var tabWidth = parseInt($('#' + tabsId + ' li').width());
        var tabHeight = parseInt($('#' + tabsId + ' li').height());

        if ($.browser.msie)
         {
          var tabBorderRight = parseInt($('#' + tabsId + ' li').css("borderRight")) || 0;
          var tabBorderLeft = parseInt($('#' + tabsId + ' li').css("borderLeft")) || 0;
          var tabPaddingRight = parseInt($('#' + tabsId + ' li').css("paddingRight")) || 0;
          var tabPaddingLeft = parseInt($('#' + tabsId + ' li').css("paddingLeft")) || 0;

          $('#' + tabsId + ' li').css({ "border-top-width": "1px"});
          tabWidth = tabWidth + tabPaddingRight + tabPaddingLeft + tabBorderLeft + tabBorderRight;
         }

        $('#' + tabsId + ' li').css({ "height" : tabHeight + "px", "width": tabWidth + "px" });
        $('#' + tabsId + ' li').css({ "margin-bottom" : ($.browser.msie ? 2 : 3) + "px" });

        $('#' + tabsId + ' li').css({ "display": "block", "margin-bottom" : ($.browser.msie ? 2 : 3) + "px" });
        $('#' + tabsId + ' .tabOn').css({ "left": "1px", "padding-top": "0px", "top": ($.browser.msie ? 1 : 1) + "px" });
        $('#' + tabsId + ' .tabOff').css({ "left": "0px", "top": "1px" });
        $('#' + tabsId + ' .tabOff a').css({ "display": "block" });
        break;
       case(2): // icon enabled
        var tabWidth = parseInt($('#' + tabId).width());
        var tabHeight = parseInt($('#' + tabId).height());
        $('#' + tabId + 'Img').load(function() { 
          imgHeight = this.height; 
          imgWidth = this.width;
          var _padding = parseInt((imgHeight / 2) - (tabHeight / 2));
          _padding = _padding < 0 ? (tabHeight > 0 ? (tabHeight / 4) : 0) : _padding;
          if ($.browser.msie)
            $('#' + tabId).css({ "height" : (imgHeight + 2) + "px", "overflow" : "hidden"});
          $('#' + tabId).css({ "width" : (tabWidth + ($.browser.msie ? imgWidth : 0)) + "px", "position": "relative", "padding-top" : _padding + "px", "padding-bottom" : _padding + "px", "padding-left" : imgWidth + "px"});
          _adjustWrapper({"tabsId" : tabsId});
         });
        $('#' + tabId + 'Img').css({"display" : 'none'});
        break;
       case(3): // mouseenter
        // gotta be here for IE
        break;
       case(4): // mouseleave
        // gotta be here for IE
        break;
       case(5): // pin tab clicked
        $('#' + tabId).css({"left" : (vars.tab.css.left() + 1) + "px"});
        break;
       case(6): // clear pinned
        $('#' + tabId).css({"left" : (vars.tab.css.left() - 1) + "px"});
        break;
       case(7): // pin tab defined
        // gotta be here for IE
        break;
      }
 
      _adjustWrapper({"tabsId" : tabsId});

     });

 };

 function _Vars(args) {
  
  var tabsId = args['tabs'] || '';
  var tabId = args['tab'] || '';

  this.setTabs = function (tabsId, o) {

   if (!tabsId)
    return(0);

   o = o || this;
   o.tabs = new Object();
   o.tabs.id = tabsId; 
   o.tabs.offset = new Object();   
   o.tabs.offset.left = function () { return ($(o.tabs.id).offset().left); };
   o.tabs.top = function () { return ($(o.tabs.id).offset().top); };
   o.tabs.css = new Object();
   o.tabs.css.left = function () { return (parseInt($(o.tabs.id).css("left")) || 0); };
   o.tabs.css.top = function () { return (parseInt($(o.tabs.id).css("top")) || 0); };
   o.tabs.height = function () { return ($(o.tabs.id).height()); };
   o.tabs.bottom = function () { return (o.tabs.top() + o.tabs.height()); };
   o.tabs.wrapper = new Object();
   o.tabs.wrapper.id = o.tabs.id + '_wrapper'; 
   o.tabs.wrapper.original = new Object();
   o.tabs.wrapper.original.css = new Object();
   o.tabs.wrapper.original.css.borderTopWidth = function () { return (parseInt($(o.tabs.wrapper.id).css("border-top-width"))); };
   o.tabs.wrapper.original.offset = new Object();
   o.tabs.wrapper.original.offset.top = function () { return ($(o.tabs.wrapper.id).offset().top); };
   o.tabs.wrapper.original.top = function () { return (o.tabs.wrapper.original.offset.top() + o.tabs.wrapper.original.css.borderTopWidth()); };
   o.tabs.wrapper.original.difference = function () { return (o.tabs.wrapper.original.top() - o.tabs.bottom()); };
  
  };

  this.setTab = function (tabId, o) {

   if (!tabId)
    return(0);

   o = o || this;
   o.tab = new Object();
   o.tab.id = tabId;
   o.tab.height = function () { return (parseInt($(o.tab.id).height())); };
   o.tab.offset = new Object();
   o.tab.offset.left = function () { return ($(o.tab.id).offset().left); };
   o.tab.offset.top = function () { return ($(o.tab.id).offset().top); };
   o.tab.original = new Object();
   o.tab.original.css = new Object();
   o.tab.original.css.left = '';
   o.tab.css = new Object();
   o.tab.css.left = function () {
                                  var _cssLeft = (parseInt($(o.tab.id).css("left")) || 0); 
                                  o.tab.original.css.left = o.tab.original.css.left != '' ? o.tab.original.css.left : _cssLeft; 
                                  return (_cssLeft); 
                                };
   o.tab.css.top = function () { return (parseInt($(o.tab.id).css("top")) || 0); };
   o.tab.css.marginLeft = function () { return (parseInt($(o.tab.id).css("margin-left")) || 0); };
   o.tab.css.paddingLeft = function () { return (parseInt($(o.tab.id).css("padding-left")) || 0); };
   o.tab.css.paddingTop = function () { return (parseInt($(o.tab.id).css("padding-top")) || 0); };
   o.tab.css.paddingBottom = function () { return (parseInt($(o.tab.id).css("padding-bottom")) || 0); };
   o.tab.css.borderTopWidth = function () { return (parseInt($(o.tab.id).css("border-top-width")) || 0); };
   o.tab.css.borderBottomWidth = function () { return (parseInt($(o.tab.id).css("border-bottom-width")) || 0); };
   o.tab.full = new Object();
   o.tab.full.left =  function () { return (o.tab.css.left()); };
   o.tab.full.height =  function () { return (o.tab.height() + o.tab.css.paddingTop() + o.tab.css.paddingBottom() + o.tab.css.borderTopWidth() + o.tab.css.borderBottomWidth()); };
   o.tab.bottom = function () { return (o.tab.offset.top() + o.tab.full.height()); };

  };

  if (tabsId)
   this.setTabs(tabsId, this); 

  if (tabId)
   this.setTab(tabId, this);

  return (this);

 };

 function _setTopCSS(args) {

    function _tabsReAlign () {

     var setTop = '';
     for (var _tabs in _data['tabs'])
      {
       if ($(_tabs + '_wrapper').offset() != undefined)  // needs to be here for nested tabs to work
        {
          var config = _getConfig(_tabs);  // this is needed for FireFox
          if (config.align == 'top' || config.align == '')
           {
            var vars = new _Vars({ "tabs" : _tabs });
            var diff = vars.tabs.wrapper.original.difference();
  
            if ((setTop != '') && (diff != setTop))
              $(vars.tabs.id).css({ "top" : (vars.tabs.css.top() + (diff - setTop) + (($.browser.mozilla  && ($.browser.version.substr(0,3) == '1.9')) ? -2 : 0)) + "px" });
   
            setTop = diff;
           }
        }
      }

    };

    var level = args['level'];
    var index = args['index'];

    var $tabs = $(_selector);
    var tabData = _data['tabs'][_selector][index];   // this is only set if individual tab is selected

    _tabsReAlign();

    $tabs.each(function() {
      
      var vars = new _Vars({ "tabs" : '#' + this.id });
      var origTabsBottom = vars.tabs.bottom();

      var origTabTopCSS, tabId;

      if (tabData)
       {
        tabId = tabData.id;
        vars.setTab('#' + tabData.id);
        origTabTopCSS = vars.tab.css.top();
       }

      switch(level)
       {
        case(1): // no icon
         var borderBottomWidth = vars.tab.css.borderBottomWidth();
         $('#' + tabId).css({ "border-bottom" : 'none' }); // we don't want to put this in 'default' for arithmetical reasons
         $('#' + tabId).css({ "top" : (origTabTopCSS + borderBottomWidth) + 'px'});         
         break;
        case(2): // icon enabled
         var tabHeight = vars.tab.height();
         var imgHeight = $(this).find('img').height();
 
         // These are the values of tab before any resizing. Needed for alignment arithmetic.
         var origTabBottom = vars.tab.bottom();

         $('#' + tabId + 'Img').load(function() { 
          imgHeight = this.height; 
          imgWidth = this.width;

           var _padding = parseInt((imgHeight / 2) - (tabHeight / 2));
            _padding = _padding < 0 ? (tabHeight > 0 ? (tabHeight / 4) : 0) : _padding;

            $('#' + tabId).css({ "position": "relative", "padding-top" : _padding + "px", "padding-bottom" : _padding + "px"});

            if ($.browser.msie)
             {
              var _move = ((imgHeight / 2) - ($('#' + tabId + ' a').height() / 2));
              $(this).css({ "top" : _move + 'px' });

              $(this).css({ "display" : "none" });
              $('#' + tabId).css({ "height" : (imgHeight + 2) + "px", "overflow" : "hidden" });
              $('#' + tabId + ' a').css({ "padding-left" : imgHeight + "px" });
              $('#' + tabId).css({ "top" : (vars.tab.css.top() - origTabTopCSS) + 'px' });
              $('#' + tabId).css({ "border-bottom" : 'none' });
             }
            else
             {
              $('#' + tabId).css({ "border-bottom" : 'none' });  // this must be here for arithmetic reasons

              var tabsDiff = vars.tabs.bottom() - origTabsBottom;
              var _alignBottom = origTabBottom - vars.tab.bottom() + origTabTopCSS + tabsDiff;
              $('#' + tabId).css({ "top" : _alignBottom + "px" });
             }

         });

        break;

       case(3): // mouseenter
        break;         
       case(4): // mouseleave
        break;
       case(5): // pin tab clicked

        if (tabData.icon)
         {
          $('#' + tabId).css({"top" : (vars.tab.css.top() + 1) + "px"}); 
          $('#' + tabId).addClass("tabOn");  // needed for IE6
         }
        else
         {
          $('#' + tabId).css({"top" : (vars.tab.css.top() + 1) + "px"});
         }

        break;
       case(6): // clear pinned
        $('#' + tabId).css({"top" : (vars.tab.css.top() - 1) + "px"});
        break;
       case(7): // pin tab defined
        if (tabData.icon)
         {
          $('#' + tabId + 'Img').load(function() { 
            $('#' + tabId).css({"top" : (vars.tab.css.top() + 1) + "px"});
          });
         }
        else
         {
          $('#' + tabId).css({"top" : (vars.tab.css.top() + 1) + "px"});
         }
        break;
       default:
        break;
      }
     });

 };
 function _findDim (attr, sel) {

    var select = sel || _selector;

    var total = 0;
    $(select).each(function() {
          total += this[attr];
     });   

   return (total);

 };
 function _getConfig (selector) {

    selector = selector || _selector;

    var config = $(selector).data('config');

    if (!config)
     config = $(selector).flyTabs.config();

    return (config);

 };
 function _addTab (args) {

    _init(_selector); 

    var $tabs = $(_selector);

    $tabs.each(function() {

     var $children = $(this).children();
     var newIndex = args ? (args.index || $children.length) : $children.length;
     var tabElement = '#' + this.id + ' li';

     var opts = $.extend({
                          'caption': "tabName" + newIndex,
                          'id': this.id + "-tabID" + newIndex,
                          'html': "Tab " + newIndex,
                          'index': newIndex,
                          'status': 'off',
                          'icon': null,
                          'code': function () {},
                          'url': '#'
                         }, args);   


     if (!_data['tabs'][_selector])
       _data['tabs'][_selector] = new Array();

     _data['tabs'][_selector][newIndex] = opts;

     var indexedElement = $children.get(opts.index);

     var statusClass = opts.status == 'on' ? 'On' : 'Off';

     var icon = opts.icon ? '<img id="' + opts.id + 'Img" src="' + opts.icon + '" />' : '';

     if (indexedElement)
      {
       $('<li id="' + opts.id + '" class="tab' + statusClass + '"><a href="javascript:return(false);" xhref="' + opts.url + '">' + icon + 
                               opts.caption +  '</a></li>').insertBefore(indexedElement);
       _bindEvents(this, tabElement, _selector);
      }
     else
      {
       $('<li id="' + opts.id + '" class="tab' + statusClass + '"><a onclick="return(false);" href="javascript:return(false);" xhref="' + opts.url + '">' + icon + 
                              opts.caption + '</a></li>').appendTo(this);

       _bindEvents(this, tabElement, _selector);

      }

     if (icon)
      {
       $('#' + opts.id).css({ "background-image" : "url('" + $('#' + opts.id + 'Img').attr('src') + "')", "background-repeat" : "no-repeat"});
       _handleAlign(2, newIndex);
      }
     else
      {
       _handleAlign(1, newIndex);
      }

     if (opts.status == 'pinned')
       $(_selector).flyTabs.pinTab({'index' : newIndex, defined : 1 }) && $(_selector).flyTabs.getTab(newIndex);

    });
    _handleAlign();

   return ($(_selector));

 };

 function _clearTabs (args) {

    var tabElement = _selector + ' li';
    $(tabElement).each(function () {
       var index = $(tabElement).index(this);
       if ($(this).attr("defaultClass"))
         $(this).removeAttr("defaultClass");
       if ($(this).hasClass("tabPinned"))
        {
         _handleAlign(6, index)
         $(this).removeClass("tabPinned");
         $(this).addClass("tabOff");

        }

       if ($(this).hasClass("tabOn"))
        {
         $(this).addClass("tabOff");
         $(this).removeClass("tabOn");

         _handleAlign(3, index)
        }
      });

   return ($(_selector));

 };

 function _countTabs (args) {

    var tabElement = _selector + ' li';
    return $(tabElement).length;

 };

 function _getTab(myIndex) {

   var config = _getConfig();

   function _loadTab(args) {
 
    var data = args['data'];
    var _this = args['this'];
    var parentThis = args['parentThis'];
    var myIndex = args['index'];

    if(data.url == '#')
     {
      $(_this).html(data.html);
      if ($.browser.msie) 
        $(_this).css({ "display" : 'block' });
      $(_this).show("slow", function() {
       $("#" + parentThis.id + "_wrapper").removeClass("loading");
       data.code();
      });
     }
    else
     {
      if ($.browser.msie) 
        $(_this).css({ "display" : 'block' });
      $(_this).load($(parentThis).children().eq(myIndex).find("a").attr("xhref"), {}, function(){
        $(_this).show("slow", function() {
         $("#" + parentThis.id + "_wrapper").removeClass("loading");
          data.code();
        });
      });
     }

   };

   var $tabs = $(_selector);

   var data = _data['tabs'][_selector][myIndex];

    $tabs.each(function() {
      // hack note: the order of following lines must be preserved for IE compat.
      //            buggy jQuery causes flicker otherwise.
      var parentThis = this;

      if (config.effect == 'no')
       {
        _loadTab({
                  'this' : "#" + this.id + "_content",
                  'data' : data,
                  'parentThis' : parentThis,
                  'index' : myIndex
                });
       }
      else
       {
        var _wrapper_overflow =  $("#" + this.id + "_wrapper").css("overflow") || 'auto';
        var _content_overflow =  $("#" + this.id + "_content").css("overflow") || 'auto';

        if ($.browser.msie)
          $("#" + this.id + "_wrapper").css({ "overflow" : 'hidden' }) && $("#" + this.id + "_content").css({ "overflow" : 'hidden' });

        $("#" + this.id + "_wrapper").addClass("loading");
        $("#" + this.id + "_content").hide("slow", function(){

         if ($.browser.msie)
          $("#" + parentThis.id + "_wrapper").css({ "overflow" : _wrapper_overflow }) && $("#" + this.id + "_content").css({ "overflow" : _content_overflow });

          _loadTab({
                    'this' : this,
                    'data' : data,
                    'parentThis' : parentThis,
                    'index' : myIndex
                  });

        });
      };
    });

   return ($(_selector));

 };

 function _pinTab (args) {  

   var myIndex = args['index'];
   var viaInit = args['defined'];

   var $tabs = $(_selector);

   var data = _data['tabs'][_selector][myIndex];

    $tabs.each(function() {
      var tabElement = $(this).children().eq(myIndex);

      if (tabElement.attr("defaultClass"))
        tabElement.removeAttr("defaultClass");
      if (tabElement.hasClass("tabOff"))
        tabElement.removeClass("tabOff");
      if (tabElement.hasClass("tabOn"))
        tabElement.removeClass("tabOn");
 
      tabElement.addClass("tabPinned");
      tabElement.attr("defaultClass", tabElement.attr("class"));
     });

    _handleAlign(viaInit ? 7 : 5, myIndex);

   return ($(_selector));

 };

 function _removeTab (args) {

   var $tabs = $(_selector);

   $tabs.each(function() {

     var $children = $(this).children();

     var newIndex = args ? (args.index || $children.length) : $children.length;

     var opts = $.extend({
                          'index': newIndex
                         }, args);   

     if ($children.get(opts.index))
      {
       $($children.get(opts.index)).remove();
       _data['tabs'][_selector] = $.grep(_data['tabs'][_selector], function(n, i) {
                             return (i != opts.index);
                            });
      }
     else
       alert('Could not find index ' + opts.index + ' in ' + _selector);

    });

   return ($(_selector));
  
 };

 function _bindEvents (parentThis, tabElement, currentSelector) {

    if (!tabElement)
     {
      return -1;
     }

    $(tabElement).unbind('mouseenter');
    $(tabElement).unbind('mouseleave');
    $(tabElement).unbind('click');

    $(tabElement).bind("mouseenter", function(e){

       if ($(this).hasClass("tabPinned"))
         return(0);

       if (!$(this).attr("defaultClass"))
        {
         $(this).attr("defaultClass", $(this).attr("class"));
        }
       $(this).addClass("tabOn");
       $(this).removeClass("tabOff");

       _selector = currentSelector;

        var index = $(tabElement).index(this);
       _handleAlign(3, index)
      });

    $(tabElement).bind("mouseleave", function(e){
       if ($(this).hasClass("tabPinned"))
         return(0);
       if ($(this).attr("defaultClass") != "tabOn")
        {
         $(this).addClass("tabOff");
         $(this).removeClass("tabOn");
        }
       _selector = currentSelector;

        var index = $(tabElement).index(this);
       _handleAlign(4, index)
      });

    $(tabElement).click(function(){
  
        if ($(this).hasClass("tabPinned"))
         return(0);

        $("#modalDiv").remove();
        $("#modalDivOverlay").remove();

        $(currentSelector).flyTabs.clearTabs();

        var index = $(tabElement).index(this);
        $(currentSelector).flyTabs.pinTab({'index' : index});
        $(currentSelector).flyTabs.getTab(index);
  
     });

 };
 
})(jQuery);




