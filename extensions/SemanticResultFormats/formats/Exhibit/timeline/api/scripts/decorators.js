/*==================================================
 *  Span Highlight Decorator
 *==================================================
 */

Timeline.SpanHighlightDecorator = function(params) {
    // When evaluating params, test against null. Not "p in params". Testing against
    // null enables caller to explicitly request the default. Testing against "in" means
    // that the param has to be ommitted to get the default.
    this._unit = params.unit != null ? params.unit : SimileAjax.NativeDateUnit;
    this._startDate = (typeof params.startDate == "string") ?
        this._unit.parseFromObject(params.startDate) : params.startDate;
    this._endDate = (typeof params.endDate == "string") ?
        this._unit.parseFromObject(params.endDate) : params.endDate;
    this._startLabel = params.startLabel != null ? params.startLabel : ""; // not null!
    this._endLabel   = params.endLabel   != null ? params.endLabel   : ""; // not null!
    this._color = params.color;
    this._cssClass = params.cssClass != null ? params.cssClass : null;
    this._opacity = params.opacity != null ? params.opacity : 100;
         // Default z is 10, behind everything but background grid.
         // If inFront, then place just behind events, in front of everything else
    this._zIndex = (params.inFront != null && params.inFront) ? 113 : 10;
};

Timeline.SpanHighlightDecorator.prototype.initialize = function(band, timeline) {
    this._band = band;
    this._timeline = timeline;

    this._layerDiv = null;
};

Timeline.SpanHighlightDecorator.prototype.paint = function() {
    if (this._layerDiv != null) {
        this._band.removeLayerDiv(this._layerDiv);
    }
    this._layerDiv = this._band.createLayerDiv(this._zIndex);
    this._layerDiv.setAttribute("name", "span-highlight-decorator"); // for debugging
    this._layerDiv.style.display = "none";

    var minDate = this._band.getMinDate();
    var maxDate = this._band.getMaxDate();

    if (this._unit.compare(this._startDate, maxDate) < 0 &&
        this._unit.compare(this._endDate, minDate) > 0) {

        minDate = this._unit.later(minDate, this._startDate);
        maxDate = this._unit.earlier(maxDate, this._endDate);

        var minPixel = this._band.dateToPixelOffset(minDate);
        var maxPixel = this._band.dateToPixelOffset(maxDate);

        var doc = this._timeline.getDocument();

        var createTable = function() {
            var table = doc.createElement("table");
            table.insertRow(0).insertCell(0);
            return table;
        };

        var div = doc.createElement("div");
        div.className='timeline-highlight-decorator'
        if(this._cssClass) {
        	  div.className += ' ' + this._cssClass;
        }
        if(this._color != null) {
        	  div.style.backgroundColor = this._color;
        }
        if (this._opacity < 100) {
            SimileAjax.Graphics.setOpacity(div, this._opacity);
        }
        this._layerDiv.appendChild(div);

        var tableStartLabel = createTable();
        tableStartLabel.className = 'timeline-highlight-label timeline-highlight-label-start'
        var tdStart =  tableStartLabel.rows[0].cells[0]
        tdStart.innerHTML = this._startLabel;
        if (this._cssClass) {
        	  tdStart.className = 'label_' + this._cssClass;
        }
        this._layerDiv.appendChild(tableStartLabel);

        var tableEndLabel = createTable();
        tableEndLabel.className = 'timeline-highlight-label timeline-highlight-label-end'
        var tdEnd = tableEndLabel.rows[0].cells[0]
        tdEnd.innerHTML = this._endLabel;
        if (this._cssClass) {
        	   tdEnd.className = 'label_' + this._cssClass;
        }
        this._layerDiv.appendChild(tableEndLabel);

        if (this._timeline.isHorizontal()){
            div.style.left = minPixel + "px";
            div.style.width = (maxPixel - minPixel) + "px";

            tableStartLabel.style.right = (this._band.getTotalViewLength() - minPixel) + "px";
            tableStartLabel.style.width = (this._startLabel.length) + "em";

            tableEndLabel.style.left = maxPixel + "px";
            tableEndLabel.style.width = (this._endLabel.length) + "em";

        } else {
            div.style.top = minPixel + "px";
            div.style.height = (maxPixel - minPixel) + "px";

            tableStartLabel.style.bottom = minPixel + "px";
            tableStartLabel.style.height = "1.5px";

            tableEndLabel.style.top = maxPixel + "px";
            tableEndLabel.style.height = "1.5px";
        }
    }
    this._layerDiv.style.display = "block";
};

Timeline.SpanHighlightDecorator.prototype.softPaint = function() {
};

/*==================================================
 *  Point Highlight Decorator
 *==================================================
 */

Timeline.PointHighlightDecorator = function(params) {
    this._unit = params.unit != null ? params.unit : SimileAjax.NativeDateUnit;
    this._date = (typeof params.date == "string") ?
        this._unit.parseFromObject(params.date) : params.date;
    this._width = params.width != null ? params.width : 10;
      // Since the width is used to calculate placements (see minPixel, below), we
      // specify width here, not in css.
    this._color = params.color;
    this._cssClass = params.cssClass != null ? params.cssClass : '';
    this._opacity = params.opacity != null ? params.opacity : 100;
};

Timeline.PointHighlightDecorator.prototype.initialize = function(band, timeline) {
    this._band = band;
    this._timeline = timeline;
    this._layerDiv = null;
};

Timeline.PointHighlightDecorator.prototype.paint = function() {
    if (this._layerDiv != null) {
        this._band.removeLayerDiv(this._layerDiv);
    }
    this._layerDiv = this._band.createLayerDiv(10);
    this._layerDiv.setAttribute("name", "span-highlight-decorator"); // for debugging
    this._layerDiv.style.display = "none";

    var minDate = this._band.getMinDate();
    var maxDate = this._band.getMaxDate();

    if (this._unit.compare(this._date, maxDate) < 0 &&
        this._unit.compare(this._date, minDate) > 0) {

        var pixel = this._band.dateToPixelOffset(this._date);
        var minPixel = pixel - Math.round(this._width / 2);

        var doc = this._timeline.getDocument();

        var div = doc.createElement("div");
        div.className='timeline-highlight-point-decorator';
        div.className += ' ' + this._cssClass;

        if(this._color != null) {
        	  div.style.backgroundColor = this._color;
        }
        if (this._opacity < 100) {
            SimileAjax.Graphics.setOpacity(div, this._opacity);
        }
        this._layerDiv.appendChild(div);

        if (this._timeline.isHorizontal()) {
            div.style.left = minPixel + "px";
            div.style.width = this._width + "px";
        } else {
            div.style.top = minPixel + "px";
            div.style.height = this._width + "px";
        }
    }
    this._layerDiv.style.display = "block";
};

Timeline.PointHighlightDecorator.prototype.softPaint = function() {
};
