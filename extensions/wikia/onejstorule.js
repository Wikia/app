
//start prototype / scriptac helper

var $ = YAHOO.util.Dom.get;


function $El(name) {
	return new YAHOO.util.Element(name);
}

var $D = YAHOO.util.Dom;
var $E = YAHOO.util.Event;
var $$ = YAHOO.util.Dom.getElementsByClassName;

var Class = {
  create: function() {
    return function() {
      this.initialize.apply(this, arguments);
    }
  }
}
var $A = Array.from = function(iterable) {
  if (!iterable) return [];
  if (iterable.toArray) {
    return iterable.toArray();
  } else {
    var results = [];
    for (var i = 0, length = iterable.length; i < length; i++)
      results.push(iterable[i]);
    return results;
  }
}
Function.prototype.bind = function() {
  var __method = this, args = $A(arguments), object = args.shift();
  return function() {
    return __method.apply(object, args.concat($A(arguments)));
  }
}

YAHOO.util.Dom.getDimensions = function(element){
    element = YAHOO.util.Dom.get(element);
    var display = YAHOO.util.Dom.getStyle( element, 'display');
    
    if (display != 'none' && display != null) // Safari bug
      return {width: element.offsetWidth, height: element.offsetHeight};

    // All *Width and *Height properties give 0 on elements with display none,
    // so enable the element temporarily
    var els = element.style;
    var originalVisibility = els.visibility;
    var originalPosition = els.position;
    var originalDisplay = els.display;
    els.visibility = 'hidden';
    els.position = 'absolute';
    els.display = 'block';

    var originalWidth = element.clientWidth;
    var originalHeight = element.clientHeight;
    els.display = originalDisplay;
    els.position = originalPosition;
    els.visibility = originalVisibility;
  
    return {width: originalWidth, height: originalHeight};
}

function Element_Show() { 
	this.setStyle('display', 'block');
	this.setStyle('visibility', 'visible');

}

function Element_Hide() { 
	this.setStyle('display', 'none');
	this.setStyle('visibility', 'hidden');
}

YAHOO.util.Element.prototype.hide = Element_Hide;
YAHOO.util.Element.prototype.show = Element_Show;

YAHOO.util.Element.remove = function(el) {
    element = $(el);
    element.parentNode.removeChild(element);
}

/*
* scriptaculous functionality
*/
YAHOO.widget.Effects = function() {
    return {
        version: '0.8'
    }
}();

YAHOO.widget.Effects.Hide = function(inElm) {
    this.element = YAHOO.util.Dom.get(inElm);

    YAHOO.util.Dom.setStyle(this.element, 'display', 'none');
    YAHOO.util.Dom.setStyle(this.element, 'visibility', 'hidden');
}

YAHOO.widget.Effects.Show = function(inElm) {
    this.element = YAHOO.util.Dom.get(inElm);

    YAHOO.util.Dom.setStyle(this.element, 'display', 'block');
    YAHOO.util.Dom.setStyle(this.element, 'visibility', 'visible');
}

YAHOO.widget.Effects.Fade = function(inElm, opts) {
    this.element = YAHOO.util.Dom.get(inElm);

    var attributes = {
        opacity: { from: 1, to: 0 }
    };
    /**
    * Custom Event fired after the effect completes
    * @type Object
    */
    this.onEffectComplete = new YAHOO.util.CustomEvent('oneffectcomplete', this);

    var ease = ((opts && opts.ease) ? opts.ease : YAHOO.util.Easing.easeOut);
    var secs = ((opts && opts.seconds) ? opts.seconds : 1);
    var delay = ((opts && opts.delay) ? opts.delay : false);

    /**
    * YUI Animation Object
    * @type Object
    */
    this.effect = new YAHOO.util.Anim(this.element, attributes, secs, ease);
    this.effect.onComplete.subscribe(function() {
        YAHOO.widget.Effects.Hide(this.element);
        this.onEffectComplete.fire();
    }, this, true);
    if (!delay) {
        this.effect.animate();
    }
}

YAHOO.widget.Effects.Fade.prototype.animate = function() {
    this.effect.animate();
}

YAHOO.widget.Effects.Appear = function(inElm, opts) {
    this.element = YAHOO.util.Dom.get(inElm);

    YAHOO.util.Dom.setStyle(this.element, 'opacity', '0');
    YAHOO.widget.Effects.Show(this.element);
    var attributes = {
        opacity: { from: 0, to: 1 }
    };
    /**
    * Custom Event fired after the effect completes
    * @type Object
    */
    this.onEffectComplete = new YAHOO.util.CustomEvent('oneffectcomplete', this);
    
    var ease = ((opts && opts.ease) ? opts.ease : YAHOO.util.Easing.easeOut);
    var secs = ((opts && opts.seconds) ? opts.seconds : 3);
    var delay = ((opts && opts.delay) ? opts.delay : false);

    /**
    * YUI Animation Object
    * @type Object
    */
    this.effect = new YAHOO.util.Anim(this.element, attributes, secs, ease);
    this.effect.onComplete.subscribe(function() {
        this.onEffectComplete.fire();
    }, this, true);
    if (!delay) {
        this.effect.animate();
    }
}

YAHOO.widget.Effects.Appear.prototype.animate = function() {
    this.effect.animate();
}


YAHOO.widget.Effects.BlindUp = function(inElm, opts) {
    var ease = ((opts && opts.ease) ? opts.ease : YAHOO.util.Easing.easeOut);
    var secs = ((opts && opts.seconds) ? opts.seconds : 1);
    var delay = ((opts && opts.delay) ? opts.delay : false);
    var ghost = ((opts && opts.ghost) ? opts.ghost : false);

    this.element = YAHOO.util.Dom.get(inElm);
    this._height = $D.getDimensions(this.element).height;
    this._top = parseInt($D.getStyle(this.element, 'top'));

    this._opts = opts;

    YAHOO.util.Dom.setStyle(this.element, 'overflow', 'hidden');
    var attributes = {
        height: { to: 0 }
    };
    if (ghost) {
        attributes.opacity = {
            to : 0,
            from: 1
        }
    }

    /**
    * Custom Event fired after the effect completes
    * @type Object
    */
    this.onEffectComplete = new YAHOO.util.CustomEvent('oneffectcomplete', this);


    if (opts && opts.bind && (opts.bind == 'bottom')) {
        var attributes = {
            height: { from: 0, to: parseInt(this._height)},
            top: { from: (this._top + parseInt(this._height)), to: this._top }
        };
        if (ghost) {
            attributes.opacity = {
                to : 1,
                from: 0
            }
        }
    }

    /**
    * YUI Animation Object
    * @type Object
    */
	this.effect = new YAHOO.util.Anim(this.element, attributes, secs, ease);
	
	this.effect.onComplete.subscribe(function() {
		if (this._opts && this._opts.bind && (this._opts.bind == 'bottom')) {
			YAHOO.util.Dom.setStyle(this.element, 'top', this._top + 'px');
		} else {
			    
			YAHOO.widget.Effects.Hide(this.element);
			YAHOO.util.Dom.setStyle(this.element, 'height', this._height+"px");
		}
		YAHOO.util.Dom.setStyle(this.element, 'opacity', 1);
		this.onEffectComplete.fire();
	}, this, true);
	
	if (!delay) {
		this.animate();
	}
}
/**
* Preps the style of the element before running the Animation.
*/
YAHOO.widget.Effects.BlindUp.prototype.prepStyle = function() {
    if (this._opts && this._opts.bind && (this._opts.bind == 'bottom')) {
	
        YAHOO.util.Dom.setStyle(this.element, 'height', '0px');
        YAHOO.util.Dom.setStyle(this.element, 'top', this._height);
    }

    YAHOO.util.Dom.setStyle(this.element, 'height', this._height+'px');
    YAHOO.widget.Effects.Show(this.element);
}
/**
* Fires off the embedded Animation.
*/
YAHOO.widget.Effects.BlindUp.prototype.animate = function() {
	this.prepStyle();
	this.effect.animate();
}

YAHOO.widget.Effects.BlindDown = function(inElm, opts) {
    var ease = ((opts && opts.ease) ? opts.ease : YAHOO.util.Easing.easeOut);
    var secs = ((opts && opts.seconds) ? opts.seconds : 1);
    var delay = ((opts && opts.delay) ? opts.delay : false);
    var ghost = ((opts && opts.ghost) ? opts.ghost : false);

    this.element = YAHOO.util.Dom.get(inElm);

    this._opts = opts;
    this._height = parseInt($D.getDimensions(this.element).height );
   
    this._top = parseInt($D.getStyle(this.element, 'top'));
    
    YAHOO.util.Dom.setStyle(this.element, 'overflow', 'hidden');
    var attributes = {
        height: { from: 0, to: this._height }
    };
    if (ghost) {
        attributes.opacity = {
            to : 1,
            from: 0
        }
    }
    /**
    * Custom Event fired after the effect completes
    * @type Object
    */
    this.onEffectComplete = new YAHOO.util.CustomEvent('oneffectcomplete', this);


    if (opts && opts.bind && (opts.bind == 'bottom')) {
        var attributes = {
            height: { to: 0, from: parseInt(this._height)},
            top: { to: (this._top + parseInt(this._height)), from: this._top }
        };
        if (ghost) {
            attributes.opacity = {
                to : 0,
                from: 1
            }
        }
    }

    /**
    * YUI Animation Object
    * @type Object
    */

    this.effect = new YAHOO.util.Anim(this.element, attributes, secs, ease);
    
    if (opts && opts.bind && (opts.bind == 'bottom')) {
        this.effect.onComplete.subscribe(function() {
            YAHOO.widget.Effects.Hide(this.element);
            YAHOO.util.Dom.setStyle(this.element, 'top', this._top + 'px');
            YAHOO.util.Dom.setStyle(this.element, 'height', this._height + 'px');
            YAHOO.util.Dom.setStyle(this.element, 'opacity', 1);
            this.onEffectComplete.fire();
        }, this, true);
    } else {
        this.effect.onComplete.subscribe(function() {
            YAHOO.util.Dom.setStyle(this.element, 'opacity', 1);
            this.onEffectComplete.fire();
        }, this, true);
    }
    if (!delay) {
        this.animate();
    }
}
/**
* Preps the style of the element before running the Animation.
*/
YAHOO.widget.Effects.BlindDown.prototype.prepStyle = function() {
    if (this._opts && this._opts.bind && (this._opts.bind == 'bottom')) {
    } else {
	   
        YAHOO.util.Dom.setStyle(this.element, 'height', '0px');
    }
  
    YAHOO.widget.Effects.Show(this.element);
}
/**
* Fires off the embedded Animation.
*/
YAHOO.widget.Effects.BlindDown.prototype.animate = function() {
    this.prepStyle();
    this.effect.animate();
}


YAHOO.widget.Effects.BlindRight = function(inElm, opts) {
    var ease = ((opts && opts.ease) ? opts.ease : YAHOO.util.Easing.easeOut);
    var secs = ((opts && opts.seconds) ? opts.seconds : 1);
    var delay = ((opts && opts.delay) ? opts.delay : false);
    var ghost = ((opts && opts.ghost) ? opts.ghost : false);
    this.element = YAHOO.util.Dom.get(inElm);

    this._width = parseInt(YAHOO.util.Dom.getStyle(this.element, 'width'));
    this._left = parseInt(YAHOO.util.Dom.getStyle(this.element, 'left'));
    this._opts = opts;

    YAHOO.util.Dom.setStyle(this.element, 'overflow', 'hidden');
    /**
    * Custom Event fired after the effect completes
    * @type Object
    */
    this.onEffectComplete = new YAHOO.util.CustomEvent('oneffectcomplete', this);

    var attributes = {
        width: { from: 0, to: this._width }
    };
    if (ghost) {
        attributes.opacity = {
            to : 1,
            from: 0
        }
    }

    if (opts && opts.bind && (opts.bind == 'right')) {
        var attributes = {
            width: { to: 0 },
            /*left: { from: parseInt, to: this._width }*/
            left: { to: this._left + parseInt(this._width), from: this._left }
        };
        if (ghost) {
            attributes.opacity = {
                to : 0,
                from: 1
            }
        }
    }
    /**
    * YUI Animation Object
    * @type Object
    */
    this.effect = new YAHOO.util.Anim(this.element, attributes, secs, ease);
    if (opts && opts.bind && (opts.bind == 'right')) {
        this.effect.onComplete.subscribe(function() {
            YAHOO.widget.Effects.Hide(this.element);
            YAHOO.util.Dom.setStyle(this.element, 'width', this._width + 'px');
            YAHOO.util.Dom.setStyle(this.element, 'left', this._left + 'px');
            this._width = null;
            YAHOO.util.Dom.setStyle(this.element, 'opacity', 1);
            this.onEffectComplete.fire();
        }, this, true);
    } else {
        this.effect.onComplete.subscribe(function() {
            YAHOO.util.Dom.setStyle(this.element, 'opacity', 1);
            this.onEffectComplete.fire();
        }, this, true);
    }
    if (!delay) {
        this.animate();
    }
}
/**
* Preps the style of the element before running the Animation.
*/
YAHOO.widget.Effects.BlindRight.prototype.prepStyle = function() {
    if (this._opts && this._opts.bind && (this._opts.bind == 'right')) {
    } else {
        YAHOO.util.Dom.setStyle(this.element, 'width', '0');
    }
}
/**
* Fires off the embedded Animation.
*/
YAHOO.widget.Effects.BlindRight.prototype.animate = function() {
    this.prepStyle();
    this.effect.animate();
}

YAHOO.widget.Effects.BlindLeft = function(inElm, opts) {
    var ease = ((opts && opts.ease) ? opts.ease : YAHOO.util.Easing.easeOut);
    var secs = ((opts && opts.seconds) ? opts.seconds : 1);
    var delay = ((opts && opts.delay) ? opts.delay : false);
    var ghost = ((opts && opts.ghost) ? opts.ghost : false);
    this.ghost = ghost;

    this.element = YAHOO.util.Dom.get(inElm);
    this._width = YAHOO.util.Dom.getStyle(this.element, 'width');
    this._left = parseInt(YAHOO.util.Dom.getStyle(this.element, 'left'));


    this._opts = opts;
    YAHOO.util.Dom.setStyle(this.element, 'overflow', 'hidden');
    var attributes = {
        width: { to: 0 }
    };
    if (ghost) {
        attributes.opacity = {
            to : 0,
            from: 1
        }
    }
    
    /**
    * Custom Event fired after the effect completes
    * @type Object
    */
    this.onEffectComplete = new YAHOO.util.CustomEvent('oneffectcomplete', this);


    if (opts && opts.bind && (opts.bind == 'right')) {
        var attributes = {
            width: { from: 0, to: parseInt(this._width) },
            left: { from: this._left + parseInt(this._width), to: this._left }
        };
        if (ghost) {
            attributes.opacity = {
                to : 1,
                from: 0
            }
        }
    }
    
    /**
    * YUI Animation Object
    * @type Object
    */
    this.effect = new YAHOO.util.Anim(this.element, attributes, secs, ease);
    if (opts && opts.bind && (opts.bind == 'right')) {
        this.effect.onComplete.subscribe(function() {
            this.onEffectComplete.fire();
        }, this, true);
    } else {
        this.effect.onComplete.subscribe(function() {
            YAHOO.widget.Effects.Hide(this.element);
            YAHOO.util.Dom.setStyle(this.element, 'width', this._width);
            YAHOO.util.Dom.setStyle(this.element, 'left', this._left + 'px');
            YAHOO.util.Dom.setStyle(this.element, 'opacity', 1);
            this._width = null;
            this.onEffectComplete.fire();
        }, this, true);
    }
    if (!delay) {
        this.animate();
    }
}
/**
* Preps the style of the element before running the Animation.
*/
YAHOO.widget.Effects.BlindLeft.prototype.prepStyle = function() {
    if (this._opts && this._opts.bind && (this._opts.bind == 'right')) {
        YAHOO.widget.Effects.Hide(this.element);
        YAHOO.util.Dom.setStyle(this.element, 'width', '0px');
        YAHOO.util.Dom.setStyle(this.element, 'left', parseInt(this._width));
        if (this.ghost) {
            YAHOO.util.Dom.setStyle(this.element, 'opacity', 0);
        }
        YAHOO.widget.Effects.Show(this.element);
    }
}
/**
* Fires off the embedded Animation.
*/
YAHOO.widget.Effects.BlindLeft.prototype.animate = function() {
    this.prepStyle();
    this.effect.animate();
}


YAHOO.widget.Effects.Pulse = function(inElm, opts) {
    this.element = YAHOO.util.Dom.get(inElm);

    this._counter = 0;
    this._maxCount = 9;
    var attributes = {
        opacity: { from: 1, to: 0 }
    };

    if (opts && opts.maxcount) {
        this._maxCount = opts.maxcount;
    }
    
    /**
    * Custom Event fired after the effect completes
    * @type Object
    */
    this.onEffectComplete = new YAHOO.util.CustomEvent('oneffectcomplete', this);

    var ease = ((opts && opts.ease) ? opts.ease : YAHOO.util.Easing.easeIn);
    var secs = ((opts && opts.seconds) ? opts.seconds : .25);
    var delay = ((opts && opts.delay) ? opts.delay : false);

    /**
    * YUI Animation Object
    * @type Object
    */
    this.effect = new YAHOO.util.Anim(this.element, attributes, secs, ease);
    this.effect.onComplete.subscribe(function() {
        if (this.done) {
            this.onEffectComplete.fire();
        } else {
            if (this._counter < this._maxCount) {
                this._counter++;
                if (this._on) {
                    this._on = null;
                    this.effect.attributes = { opacity: { to: 0 } }
                } else {
                    this._on = true;
                    this.effect.attributes = { opacity: { to: 1 } }
                }
                this.effect.animate();
            } else {
                this.done = true;
                this._on = null;
                this._counter = null;
                this.effect.attributes = { opacity: { to: 1 } }
                this.effect.animate();
            }
        }
    }, this, true);
    if (!delay) {
        this.effect.animate();
    }
}
/**
* Fires off the embedded Animation.
*/
YAHOO.widget.Effects.Pulse.prototype.animate = function() {
    this.effect.animate();
}

/**
* This effect makes the object expand & dissappear.
* @param {String/HTMLElement} inElm HTML element to apply the effect to
* @param {Object} options Pass in an object of options for this effect, you can choose the Easing and the Duration
* <code> <br>var options = (<br>
*   delay: true<br>
*   topOffset: 8<br>
*   leftOffset: 8<br>
*   shadowColor: #ccc<br>
*   shadowOpacity: .75<br>
* )</code>
* @return Animation Object
* @type Object
*/
YAHOO.widget.Effects.Shadow = function(inElm, opts) {
    var delay = ((opts && opts.delay) ? opts.delay : false);
    var topOffset = ((opts && opts.top) ? opts.top : 8);
    var leftOffset = ((opts && opts.left) ? opts.left : 8);
    var shadowColor = ((opts && opts.color) ? opts.color : '#ccc');
    var shadowOpacity = ((opts && opts.opacity) ? opts.opacity : .75);

    this.element = YAHOO.util.Dom.get(inElm);

    
    if (YAHOO.util.Dom.get(this.element.id + '_shadow')) {
        this.shadow = YAHOO.util.Dom.get(this.element.id + '_shadow');
    } else {
        this.shadow = document.createElement('div');
        this.shadow.id = this.element.id + '_shadow';
        this.element.parentNode.appendChild(this.shadow);
    }

    var h = parseInt($T.getHeight(this.element));
    var w = parseInt(YAHOO.util.Dom.getStyle(this.element, 'width'));
    var z = this.element.style.zIndex;
    if (!z) {
        z = 1;
        this.element.style.zIndex = z;
    }

    YAHOO.util.Dom.setStyle(this.element, 'overflow', 'hidden');
    YAHOO.util.Dom.setStyle(this.shadow, 'height', h + 'px');
    YAHOO.util.Dom.setStyle(this.shadow, 'width', w + 'px');
    YAHOO.util.Dom.setStyle(this.shadow, 'background-color', shadowColor);
    YAHOO.util.Dom.setStyle(this.shadow, 'opacity', 0);
    YAHOO.util.Dom.setStyle(this.shadow, 'position', 'absolute');
    this.shadow.style.zIndex = (z - 1);
    var xy = YAHOO.util.Dom.getXY(this.element);

    /**
    * Custom Event fired after the effect completes
    * @type Object
    */
    this.onEffectComplete = new YAHOO.util.CustomEvent('oneffectcomplete', this);
    
    
    var attributes = {
        opacity: { from: 0, to: shadowOpacity },
        top: {
            from: xy[1],
            to: (xy[1] + topOffset)
        },
        left: {
            from: xy[0],
            to: (xy[0] + leftOffset)
        }
    };

    /**
    * YUI Animation Object
    * @type Object
    */
    this.effect = new YAHOO.util.Anim(this.shadow, attributes);
    this.effect.onComplete.subscribe(function() {
        this.onEffectComplete.fire();
    }, this, true);
    if (!delay) {
        this.animate();
    }
}
/**
* Fires off the embedded Animation.
*/
YAHOO.widget.Effects.Shadow.prototype.animate = function() {
    this.effect.animate();
}
/**
* String function for reporting to YUI Logger
*/
YAHOO.widget.Effects.Shadow.prototype.toString = function() {
    return 'Effect Shadow [' + this.element.id + ']';
}



if (!YAHOO.Tools) {
    $T = {
        getHeight: function(el) {
            return YAHOO.util.Dom.getStyle(el, 'height');
        }
    }
}


/**
* @class
* This is a namespace call, nothing here to see.
* @constructor
*/
YAHOO.widget.Effects.ContainerEffect = function() {
}
/**
* @constructor
* Container Effect:<br>
*   Show: BlindUp (binded)<br>
*   Hide: BlindDown (binded)<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindUpDownBinded = function(overlay, dur) {
    var bupdownbinded = new YAHOO.widget.ContainerEffect(overlay, 
        { attributes: {
            effect: 'BlindUp',
            opts: {
                bind: 'bottom'
            }
        },
            duration: dur
        }, {
            attributes: {
                effect: 'BlindDown',
                opts: {
                    bind: 'bottom'
                }
            },
            duration: dur
        },
            overlay.element,
            YAHOO.widget.Effects.Container
        );
    bupdownbinded.init();
    return bupdownbinded;
}
/**
* @constructor
* Container Effect:<br>
*   Show: BlindUp<br>
*   Hide: BlindDown<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindUpDown = function(overlay, dur) {
    var bupdown = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'BlindDown' }, duration: dur }, { attributes: { effect: 'BlindUp' }, duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    bupdown.init();
    return bupdown;
}
/**
* @constructor
* Container Effect:<br>
*   Show: BlindLeft (binded)<br>
*   Hide: BlindRight (binded)<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindLeftRightBinded = function(overlay, dur) {
    var bleftrightbinded = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'BlindLeft', opts: {bind: 'right'} }, duration: dur }, { attributes: { effect: 'BlindRight', opts: { bind: 'right' } }, duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    bleftrightbinded.init();
    return bleftrightbinded;
}
/**
* @constructor
* Container Effect:<br>
*   Show: BlindLeft<br>
*   Hide: BlindRight<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindLeftRight = function(overlay, dur) {
    var bleftright = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'BlindRight' }, duration: dur }, { attributes: { effect: 'BlindLeft' } , duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    bleftright.init();
    return bleftright;
}
/**
* @constructor
* Container Effect:<br>
*   Show: BlindRight<br>
*   Hide: Fold<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindRightFold = function(overlay, dur) {
    var brightfold = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'BlindRight' }, duration: dur }, { attributes: { effect: 'Fold' }, duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    brightfold.init();
    return brightfold;
}
/**
* @constructor
* Container Effect:<br>
*   Show: BlindLeft (binded)<br>
*   Hide: Fold<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindLeftFold = function(overlay, dur) {
    var bleftfold = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'BlindLeft', opts: { bind: 'right' } }, duration: dur }, { attributes: { effect: 'Fold' }, duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    bleftfold.init();
    return bleftfold;
}
/**
* @constructor
* Container Effect:<br>
*   Show: UnFold<br>
*   Hide: Fold<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.UnFoldFold = function(overlay, dur) {
    var bunfold = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'UnFold' }, duration: dur }, { attributes: { effect: 'Fold' }, duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    bunfold.init();
    return bunfold;
}
/**
* @constructor
* Container Effect:<br>
*   Show: BlindDown<br>
*   Hide: BlindDrop<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindDownDrop = function(overlay, dur) {
    var bdowndrop = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'BlindDown' }, duration: dur }, { attributes: { effect: 'Drop' }, duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    bdowndrop.init();
    return bdowndrop;
}

/**
* @constructor
* Container Effect:<br>
*   Show: BlindUp (binded)<br>
*   Hide: BlindDrop<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindUpDrop = function(overlay, dur) {
    var bupdrop = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'BlindUp', opts: { bind: 'bottom' } }, duration: dur }, { attributes: { effect: 'Drop' }, duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    bupdrop.init();
    return bupdrop;
}

/**
* @constructor
* Container Effect:<br>
*   Show: BlindUp (binded)<br>
*   Hide: BlindDown (binded)<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindUpDownBindedGhost = function(overlay, dur) {
    var bupdownbinded = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'BlindUp', opts: {ghost: true, bind: 'bottom' } }, duration: dur }, { attributes: { effect: 'BlindDown', opts: { ghost: true, bind: 'bottom'} }, duration: dur }, overlay.element, YAHOO.widget.Effects.Container);
    bupdownbinded.init();
    return bupdownbinded;
}
/**
* @constructor
* Container Effect:<br>
*   Show: BlindUp<br>
*   Hide: BlindDown<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindUpDownGhost = function(overlay, dur) {
    var bupdown = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'BlindDown', opts: { ghost: true } }, duration: dur }, { attributes: { effect: 'BlindUp', opts: { ghost: true } }, duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    bupdown.init();
    return bupdown;
}
/**
* @constructor
* Container Effect:<br>
*   Show: BlindLeft (binded)<br>
*   Hide: BlindRight (binded)<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindLeftRightBindedGhost = function(overlay, dur) {
    var bleftrightbinded = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'BlindLeft', opts: {bind: 'right', ghost: true } }, duration: dur }, { attributes: { effect: 'BlindRight', opts: { bind: 'right', ghost: true } }, duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    bleftrightbinded.init();
    return bleftrightbinded;
}
/**
* @constructor
* Container Effect:<br>
*   Show: BlindLeft<br>
*   Hide: BlindRight<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindLeftRightGhost = function(overlay, dur) {
    var bleftright = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'BlindRight', opts: { ghost: true } }, duration: dur }, { attributes: { effect: 'BlindLeft', opts: { ghost: true } } , duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    bleftright.init();
    return bleftright;
}
/**
* @constructor
* Container Effect:<br>
*   Show: BlindRight<br>
*   Hide: Fold<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindRightFoldGhost = function(overlay, dur) {
    var brightfold = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'BlindRight', opts: { ghost: true } }, duration: dur }, { attributes: { effect: 'Fold', opts: { ghost: true } }, duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    brightfold.init();
    return brightfold;
}
/**
* @constructor
* Container Effect:<br>
*   Show: BlindLeft (binded)<br>
*   Hide: Fold<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindLeftFoldGhost = function(overlay, dur) {
    var bleftfold = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'BlindLeft', opts: { bind: 'right', ghost: true } }, duration: dur }, { attributes: { effect: 'Fold', opts: { ghost: true } }, duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    bleftfold.init();
    return bleftfold;
}
/**
* @constructor
* Container Effect:<br>
*   Show: UnFold<br>
*   Hide: Fold<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.UnFoldFoldGhost = function(overlay, dur) {
    var bleftfold = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'UnFold', opts: { ghost: true } }, duration: dur }, { attributes: { effect: 'Fold', opts: { ghost: true } }, duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    bleftfold.init();
    return bleftfold;
}

/**
* @constructor
* Container Effect:<br>
*   Show: BlindDown<br>
*   Hide: BlindDrop<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindDownDropGhost = function(overlay, dur) {
    var bdowndrop = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'BlindDown', opts: { ghost: true } }, duration: dur }, { attributes: { effect: 'Drop' }, duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    bdowndrop.init();
    return bdowndrop;
}

/**
* @constructor
* Container Effect:<br>
*   Show: BlindUp (binded)<br>
*   Hide: BlindDrop<br>
* @return Container Effect Object
* @type Object
*/
YAHOO.widget.Effects.ContainerEffect.BlindUpDropGhost = function(overlay, dur) {
    var bupdrop = new YAHOO.widget.ContainerEffect(overlay, { attributes: { effect: 'BlindUp', opts: { bind: 'bottom', ghost: true } }, duration: dur }, { attributes: { effect: 'Drop' }, duration: dur }, overlay.element, YAHOO.widget.Effects.Container );
    bupdrop.init();
    return bupdrop;
}



/**
* @class
* This is a wrapper function to convert my YAHOO.widget.Effect into a YAHOO.widget.ContainerEffects object
* @constructor
* @return Animation Effect Object
* @type Object
*/
YAHOO.widget.Effects.Container = function(el, attrs, dur) {
    var opts = { delay: true };
    if (attrs.opts) {
        for (var i in attrs.opts) {
            opts[i] = attrs.opts[i];
        }
    }
    //var eff = eval('new YAHOO.widget.Effects.' + attrs.effect + '("' + el.id + '", {delay: true' + opts + '})');
    var func = eval('YAHOO.widget.Effects.' + attrs.effect);
    var eff = new func(el, opts);
    
    /**
    * Empty event handler to make ContainerEffects happy<br>
    * May try to attach them to my effects later
    * @type Object
    */
    //eff.onStart = new YAHOO.util.CustomEvent('onstart', this);
    eff.onStart = eff.effect.onStart;
    /**
    * Empty event handler to make ContainerEffects happy<br>
    * May try to attach them to my effects later
    * @type Object
    */
    //eff.onTween = new YAHOO.util.CustomEvent('ontween', this);
    eff.onTween = eff.effect.onTween;
    /**
    * Empty event handler to make ContainerEffects happy<br>
    * May try to attach them to my effects later
    * @type Object
    */
    //eff.onComplete = new YAHOO.util.CustomEvent('oncomplete', this);
    eff.onComplete = eff.onEffectComplete;
    return eff;
}

//end prototype scriptac helper

//menu nav

var last_clicked = ""

function submenu(id){
	
	//clear all tab classes
	on_tabs = $$("tab-on")
	for(x = 0 ; x<= on_tabs.length-1 ; x++)$(on_tabs[x]).className="tab-off"
	
	on_tabs = $$("sub-menu")
	for(x = 0 ; x<= on_tabs.length-1 ; x++)YAHOO.widget.Effects.Hide($(on_tabs[x]))
		
	//hide submenu that might have been previously clicked
	if (last_clicked)YAHOO.widget.Effects.Hide("submenu-"+last_clicked)

	//update tab class you clicked on/show its submenu
	if( $D.hasClass("menu-"+id,"tab-off") ) $D.addClass( ("menu-"+id),"tab-on" );
		
	YAHOO.widget.Effects.Show("submenu-"+id)

	last_clicked = id
}

function editMenuToggle() {
	
	var submenu = document.getElementById("edit-sub-menu-id")
	
	if (submenu.style.display == "block") {
		submenu.style.display = "none"
	} else {
		submenu.style.display = "block"
	}
}

//end menu nav

//vote

	
	
	function clickVote(TheVote,PageID,mk) {
		var url = "index.php?action=ajax";
		var params = 'rs=wfVoteClick&rsargs[]=' + TheVote + '&rsargs[]=' + PageID+'&rsargs[]=' + mk
	
		var callback = {
			success: function( oResponse ) {
				YAHOO.util.Dom.setStyle('votebox', 'cursor', "default");
				$("PollVotes").innerHTML = oResponse.responseText;
				$("Answer").innerHTML = "<a href=javascript:unVote(" + PageID + ",'" + mk + "')>" + _UNVOTE_LINK + "</a>";
			}
		};

		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, params);
	}
	
	function unVote(PageID,mk){
		var url = "index.php?action=ajax";
		var params = 'rs=wfVoteDelete&rsargs[]=' + PageID + '&rsargs[]=' + mk;

		var callback = {
			success: function( oResponse ) {
			
				YAHOO.util.Dom.setStyle('votebox', 'cursor', "pointer");
				$("PollVotes").innerHTML = oResponse.responseText;
				$('Answer').innerHTML = "<a href=javascript:clickVote(1," + PageID + ",'" + mk + "')>" + _VOTE_LINK + "</a>";
			}
		};

		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, params);
	}	
	
			
	
	var MaxRating = 5;
	var clearRatingTimer = "";
	var voted_new = new Array();
	
	var id=0;
	var last_id = 0;
	
	function clickVoteStars(TheVote,PageID,mk,id,action){
		voted_new[id] = TheVote
		if(action==3)rsfun="wfVoteStars";
		if(action==5)rsfun="wfVoteStarsMulti";

		var url = "index.php?action=ajax";
		var pars = 'rs=' + rsfun + '&rsargs[]=' + TheVote + '&rsargs[]=' + PageID+'&rsargs[]=' + mk
		var callback = {
			success: function( oResponse ) {
				$('rating_'+id).innerHTML = oResponse.responseText;
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
	}	
	
	function unVoteStars(PageID,mk,id){
		var url = "index.php?action=ajax";
		var pars = 'rs=wfVoteStarsDelete&rsargs[]=' + PageID + '&rsargs[]=' + mk;
		var callback = {
			success: function( oResponse ) {
				$('rating_'+id).innerHTML = oResponse.responseText;
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
	}
	
	
	function startClearRating(id,rating,voted){clearRatingTimer = setTimeout("clearRating('" + id + "',0," + rating + "," + voted + ")", 200);}
	
	function clearRating(id,num,prev_rating,voted){
		if(voted_new[id])voted=voted_new[id];
		
		for (var x=1;x<=MaxRating;x++) {     
			if(voted){
				star_on = "voted";
				old_rating = voted;
			}else{	
				star_on = "on";
				old_rating = prev_rating;
			}
			if(!num && old_rating >= x){
				$("rating_" + id + "_" + x).src = "/images/star_" + star_on + ".gif";
			}else{
				$("rating_" + id + "_" + x).src = "/images/star_off.gif";
			}
		}
	}
	
	function updateRating(id,num,prev_rating) {
		if(clearRatingTimer && last_id==id)clearTimeout(clearRatingTimer);
		clearRating(id,num,prev_rating)
		for (var x=1;x<=num;x++) {
			$("rating_" + id + "_" + x).src = "/images/star_voted.gif";
		}
		last_id = id;
	}

//end vote

//comments

	var submitted = 0;
	function XMLHttp(){
		if (window.XMLHttpRequest){ //Moz
			var xt = new XMLHttpRequest();
		}else{ //IE
			var xt = new ActiveXObject('Microsoft.XMLHTTP');
		}
		return xt
	}

	function show_comment(id){
		fadeOut = new YAHOO.widget.Effects.Fade( ("ignore-"+id));
		fadeOut.onEffectComplete.subscribe(
			function() {
				new YAHOO.widget.Effects.BlindDown( ("comment-"+id) )
			}
		);
	}
	
	function block_user(user_name,user_id,c_id,mk){
		if(!user_name){
			user_name = _COMMENT_BLOCK_ANON;
		}else{
			user_name = _COMMENT_BLOCK_USER + " " + user_name;
		}
		if(confirm(_COMMENT_BLOCK_WARNING + " "+user_name+" ?")){
			var url = "index.php?action=ajax";
			var pars = 'rs=wfCommentBlock&rsargs[]=' + c_id + '&rsargs[]=' + user_id + '&rsargs[]=' + mk
			var callback = {
				success: function( oResponse ) {
					alert(oResponse.responseText)
					window.location.href=window.location
				}
			};
			var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
		}
	}
	
	function cv(cid,vt,mk,vg){
		var url = "index.php?action=ajax";
		var pars = 'rs=wfCommentVote&rsargs[]=' + cid + '&rsargs[]=' + vt + '&rsargs[]=' + mk + '&rsargs[]=' + ((vg)?vg:0) + '&rsargs[]=' + document.commentform.pid.value;
		var callback = {
			success: function( oResponse ) {
				$("Comment" + cid).innerHTML = oResponse.responseText
				$("CommentBtn" + cid).innerHTML = "<img src=/images/common/voted.gif align=absbottom hspace=2><span class=CommentVoted>" + _COMMENT_VOTED + "</span>";
			} 
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
	}	
	 
	function ViewComments(pid,ord,end){
		$("allcomments").innerHTML = _COMMENT_LOADING + "<br><br>";
		var url = wgServer + "/index.php?title=Special:CommentListGet&pid="+pid+"&ord="+ord;
		var pars = '';
		var callback = {
			success: function(oResponse) {
					$("allcomments").innerHTML = oResponse.responseText
					submitted = 0
					if(end)window.location.hash = "end";
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('GET', url, callback, pars);	
	}		

	function FixStr(str){
		str = str.replace(/&/gi,"%26");
		str = str.replace(/\+/gi,"%2B")
		return str;
	}
	
	function submit_comment(){
		if(submitted==0){
			submitted = 1;
			sXMLHTTP = XMLHttp();
			sXMLHTTP.onreadystatechange=function(){
			if(sXMLHTTP.readyState==4){
					if(sXMLHTTP.status==200){
						document.commentform.comment_text.value=''
						ViewComments(document.commentform.pid.value,0,1)
					}
				}
			}
	
			sXMLHTTP.open("POST","index.php?action=ajax", true );
	
			sXMLHTTP.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			sXMLHTTP.send('rs=wfCommentSubmit&rsargs[]=' + document.commentform.pid.value + '&rsargs[]=' + ((!document.commentform.comment_parent_id.value)?0:document.commentform.comment_parent_id.value) + '&rsargs[]='+ FixStr(document.commentform.comment_text.value) + '&rsargs[]=' + document.commentform.sid.value + '&rsargs[]=' + document.commentform.mk.value);
			Cancel_Reply()
		}
	}
	
	function Ob(e,f){
		if(document.all){
			return ((f)? document.all[e].style:document.all[e]);
		}else{
			return ((f)? document.getElementById(e).style:document.getElementById(e));
		}
	}
	
	var isBusy = false;
	var timer;
	var updateDelay = 7000;
	var LatestCommentID = "";
	var CurLatestCommentID = "";
	var pause = 0;
	
	function ToggleLiveComments(status){
		if(status){
			Pause=0
		}else{
			Pause=1
		}
		Ob("spy").innerHTML= "<a href=javascript:ToggleLiveComments(" + ((status)?0:1) + ") style='font-size:10px'>" + ((status)?_COMMENT_PAUSE_REFRESHER:_COMMENT_ENABLE_REFRESHER) + " " + _COMMENT_REFRESHER + "</a>"
		if(!pause){
			LatestCommentID = document.commentform.lastcommentid.value
			timer = setTimeout('checkUpdate()', updateDelay);
		}
	}
	
	function checkUpdate(){
		if (isBusy) {
			return;
		}
		oXMLHTTP = XMLHttp();
		url="index.php?action=ajax&rs=wfCommentLatestID&rsargs[]=" + document.commentform.pid.value;
		oXMLHTTP.open("GET",url,true);
		oXMLHTTP.onreadystatechange=UpdateResults;
		oXMLHTTP.send(null);
		isBusy = true;
		return false;
	}
	
	function UpdateResults(){
		if (!oXMLHTTP || oXMLHTTP.readyState != 4) return;
		if (oXMLHTTP.status == 200){
			//get last new id
			CurLatestCommentID = oXMLHTTP.responseText
			if(CurLatestCommentID != LatestCommentID){
				ViewComments(document.commentform.pid.value,0,1)
				LatestCommentID = CurLatestCommentID
			}
	
		}
		isBusy = false;
		if (!pause) {
			clearTimeout(timer);
			timer = setTimeout('checkUpdate()', updateDelay);
		}
	}
	
	function Reply(parentid,poster){
		$("replyto").innerHTML = _COMMENT_REPLY_TO + " " + poster + " (<a href=javascript:Cancel_Reply()>" + _COMMENT_CANCEL_REPLY + "</a>) <br>"
		document.commentform.comment_parent_id.value = parentid
	}
	
	function Cancel_Reply(){
		$("replyto").innerHTML = ""
		document.commentform.comment_parent_id.value = ""
	}
	
	function ChangeToStep(Stp,Drt){
		$("Step" + Stp).style.visibility="visible"
		$("Step" + Stp).style.display="block";

		$("Step" + (Stp-Drt)).style.visibility="hidden"
		$("Step" + (Stp-Drt)).style.display="none";
	}

//end comments

//listpages

	function ViewPage(pg,id,options){
		var url = "index.php?title=Special:ListPagesAction&x=1";
		var pars = 'pg=' + pg
		for(name in options){pars+= "&" + name + "=" + options[name]}

		var callback = {
			success: function( oResponse ) {
				$("ListPages" + id).innerHTML = oResponse.responseText
			}
			
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
	}		

	function getContent(url,pars,layerTo){
		$(layerTo).innerHTML = "<table height=150 cellpadding=0 cellspacing=0><tr><td valign=top><span style='color:#666666;font-weight:800'>Loading...</span></td></tr></table><br><br>";
		var callback = {
			success: function( oResponse ) {
				$(layerTo).innerHTML = oResponse.responseText
			}
		};	
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
	}
	
//end listpages

function imageSwap(divID, type, on, path) {
	
	if (on==1) {
		$(divID).src = path+'/common/'+type+'-on.gif';
	} else {
		$(divID).src = path+'/common/'+type+'.gif';
	}
	
	
}

var show = 'false';

function show_more_category(el) {
	
	if (show=='false') {
		$(el).style.display = 'block';
		show = 'true';
	} else {
		$(el).style.display = 'none';
		show = 'false';
	}
	
}

//embed poll stuffs
function show_embed_poll( id ){
	$El('loading-poll' + '_' + id).hide();
	$El('poll-display' + '_' + id).show();
}

function poll_embed_vote( id, page_id ){
	choice_id=0;
	poll_form = eval("document.poll_" + id + ".poll_choice");
	for (var i=0; i < poll_form.length; i++){
		if (poll_form[i].checked){
			choice_id = poll_form[i].value;
		}
		
	}
	
	if(choice_id){
		//cast vote
		var url = "index.php?action=ajax";
		var pars = 'rs=wfPollVote&rsargs[]=' + id + '&rsargs[]=' + choice_id
		var callback = {
			success: function( oResponse ) {
				show_poll_results(id, page_id)
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);	
	}
}

function show_poll_results(id, page_id){
	var url = "index.php?action=ajax";
	var pars = 'rs=wfGetPollResults&rsargs[]=' + page_id
	
	var callback = {
		success: function( oResponse ) {
			$("poll-display_" + id).innerHTML = oResponse.responseText
		}
	};
	var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);	
}

