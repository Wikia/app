/*
Script: Element.Forms.js
	Extends the Element native object to include methods useful in managing inputs.

License:
	http://clientside.cnet.com/wiki/cnet-libraries#license
*/
Element.implement({
	tidy: function(){
		try {
			this.set('value', this.get('value').tidy());
		}catch(e){dbug.log('element.tidy error: %o', e);}
	},
	getTextInRange: function(start, end) {
		return this.get('value').substring(start, end);
	},
	getSelectedText: function() {
		if(Browser.Engine.trident) return document.selection.createRange().text;
		return this.get('value').substring(this.getSelectionStart(), this.getSelectionEnd());
	},
	getBookmarkOffset: function() {
		if(Browser.Engine.trident) {
			var tmp_range = this.createTextRange();
			tmp_range.move("character", 0);
			return tmp_range.getBookmark().charCodeAt(2);
		} else return null;
	},
	getSelectionStart: function() {
		if(Browser.Engine.trident) {
			this.focus();
			var range = document.selection.createRange();
			if (range.compareEndPoints("StartToEnd", range) != 0) range.collapse(true);
			return range.getBookmark().charCodeAt(2) - this.getBookmarkOffset();
		}
		return this.selectionStart;
	},
	getSelectionEnd: function() {
		if(Browser.Engine.trident) {
			var range = document.selection.createRange();
			if (range.compareEndPoints("StartToEnd", range) != 0) range.collapse(false);
			return range.getBookmark().charCodeAt(2) - this.getBookmarkOffset();
		}
		return this.selectionEnd;
	},
	getSelectedRange: function() {
		return {
			start: this.getSelectionStart(),
			end: this.getSelectionEnd()
		}
	},
	setCaretPosition: function(pos) {
		if(pos == 'end') pos = this.get('value').length;
		this.selectRange(pos, pos);
		return this;
	},
	getCaretPosition: function() {
		return this.getSelectedRange().start;
	},
	selectRange: function(start, end) {
		this.focus();
		if(Browser.Engine.trident) {
			var range = this.createTextRange();
			range.collapse(true);
			range.moveStart('character', start);
			range.moveEnd('character', end - start);
			range.select();
			return this;
		}
		this.setSelectionRange(start, end);
		return this;
	},
	insertAtCursor: function(value, select) {
		var start = this.getSelectionStart();
		var end = this.getSelectionEnd();
		this.set('value', this.get('value').substring(0, start) + value + this.get('value').substring(end, this.get('value').length));
 		if($pick(select, true)) this.selectRange(start, start + value.length);
		else this.setCaretPosition(start + value.length);
		return this;
	},
	insertAroundCursor: function(options, select) {
		options = $merge({
			before: '',
			defaultMiddle: 'SOMETHING HERE',
			after: ''
		}, options);
		value = this.getSelectedText() || options.defaultMiddle;
		var start = this.getSelectionStart();
		var end = this.getSelectionEnd();
		if(start == end) {
			var text = this.get('value');
			this.set('value', text.substring(0, start) + options.before + value + options.after + text.substring(end, text.length));
			this.selectRange(start + options.before.length, end + options.before.length + value.length);
			text = null;
		} else {
			text = this.get('value').substring(start, end);
			this.set('value', this.get('value').substring(0, start) + options.before + text + options.after + this.get('value').substring(end, this.get('value').length));
			var selStart = start + options.before.length;
			if($pick(select, true)) this.selectRange(selStart, selStart + text.length);
			else this.setCaretPosition(selStart + text.length);
		}
		return this;
	}
});

Element.Properties.inputValue = {

	get: function(){
			 switch(this.get('tag')) {
			 	case 'select':
					vals = this.getSelected().map(function(op){ return $pick(op.get('value'),op.get('text')) });
					return this.get('multiple')?vals:vals[0];
				case 'input':
					if(['radio','checkbox'].contains(this.get('type')))
						return this.get('checked')?this.get('name'):false;
			 	default:
					return this.get('value');
			 }
	},

	set: function(value){
			switch(this.get('tag')){
				case 'select':
					this.getElements('option').each(function(op){
						op.set('selected', $splat(value).contains($pick(op.get('value'), op.get('text'))));
					});
					break;
				case 'input':
					if (['radio','checkbox'].contains(this.get('type'))) {
						this.set('checked', $type(value)=="boolean"?value:$splat(value).contains(this.get('name')));
						break;
					}
				default:
					this.set('value', value);
			}
			return this;
	},

		erase: function() {
			switch(this.get('tag')) {
				case 'select':
					this.getElements('option').each(function(op) {
						op.set('selected', false);
					});
					break;
				case 'input':
					if (['radio','checkbox'].contains(this.get('type'))) {
						this.set('checked', false);
						break;
					}
				default:
					this.set('value', '');
			}
			return this;
		}
};
