<?php
/**
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 2.1 of the License, or (at your option) any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
* Lesser General Public License for more details.
*
* You should have received a copy of the GNU Lesser General Public
* License along with this library; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*
* Copy of GNU Lesser General Public License at: http://www.gnu.org/copyleft/lesser.txt
* Contact author at: hveluwenkamp@myrealbox.com
*
*/

/**
* Takes an array or multiple arrays of data and outputs a graph in SVG format.
* The SVG language allows for a high degree of control of the output,
* thus this class is intended to be extended.
*
* @author Herman Veluwenkamp
* @version 1.2alpha
*/
class svgGraph {

    /**
    * Total width of svg graphic.
    * @type integer
    * @public
    */
    var $graphicWidth          =  0;

    /**
    * Total height of svg graphic.
    * @type integer
    * @public
    */
    var $graphicHeight         =  0;

    /**
    * Width of plot area.
    * @type integer
    * @public
    */
    var $plotWidth             =  0;

    /**
    * Height of plot area.
    * @type integer
    * @public
    */
    var $plotHeight            =  0;

    /**
    * Offset of plot area from left of graphic area.
    * @type integer
    * @public
    */
    var $plotOffsetX           =  0;

    /**
    * Offset of plot area from top of graphic area.
    * @type integer
    * @public
    */
    var $plotOffsetY           =  0;

    /**
    * Padding between outer border of graphic area and text (title and labels).
    * @type integer
    * @public
    */
    var $outerPadding          =  0;

    /**
    * Padding between bottom border of plot area and text (tags).
    * @type integer
    * @public
    */
    var $innerPaddingX         =  0;

    /**
    * Padding between left border of plot area and text (tags).
    * @type integer
    * @public
    */
    var $innerPaddingY         =  0;

    /**
    * Array of data holding values for X axis
    * @type string
    * @public
    */
    var $dataX                 =  array();

    /**
    * Two dimensional array holding values for Y axis. The key for each array must be unique.
    * @type string
    * @public
    */
    var $dataY                 =  array();

    /**
    * Presentation attributes for plot.
    * @type string
    * @public
    */
	var $backgroundStyle      =  '';

    /**
    * Title for Graph.
    * @type string
    * @public
    */
    var $title                 =  '';

    /**
    * Presentation attributes for title.
    * @type string
    * @public
    */
    var $styleTitle            =  '';

    /**
    * Default presentation attributes for title.
    * @type string
    * @public
    */
    var $styleTitleDefault     =  '';

    /**
    * Label for X axis.
    * @type string
    * @public
    */
    var $labelX                =  '';

    /**
    * Presentation attributes for label.
    * @type string
    * @public
    */
    var $styleLabelX           =  '';

    /**
    * Default presentation attributes for label.
    * @type string
    * @public
    */
    var $styleLabelXDefault    =  '';

    /**
    * Label for Y axis.
    * @type string
    * @public
    */
    var $labelY                =  '';

    /**
    * Presentation attributes for label.
    * @type string
    * @public
    */
    var $styleLabelY           =  '';

    /**
    * Default presentation attributes for label.
    * @type string
    * @public
    */
    var $styleLabelYDefault    =  '';

    /**
    * Offset of first X axis gridline from lower-left of plot area as a
    * fraction of normal gridline spacing.
    * @type integer
    * @public
    */
    var $offsetGridlinesX      =  0;

    /**
    * Offset of first Y axis gridline from lower-left of plot area as a
    * fraction of normal gridline spacing.
    * @type integer
    * @public
    */
    var $offsetGridlinesY      =  0;

    /**
    * Minimum value for Y axis values. If a lower value is found in data then
    * this value is not used.
    * @type integer
    * @public
    */
    var $minY                  =  0;

    /**
    * Maximum value for Y axis values. If a higher value is found in data then
    * this value is not used.
    * @type integer
    * @public
    */
    var $maxY                  =  0;

    /**
    * Resolution for Y axis tags. See notes for method <code>_findRange</code>.
    * @type integer
    * @public
    */
    var $resolutionY           =  0;

    /**
    * Number of decimal places to show for Y axis tags.
    * @type integer
    * @public
    */
    var $decimalPlacesY        =  0;

    /**
    * Number of grid lines corresponding to X axis.
    * @type integer
    * @public
    */
    var $numGridlinesX         =  0;

    /**
    * Number of grid lines corresponding to Y axis.
    * @type integer
    * @public
    */
    var $numGridlinesY         =  0;

    /**
    * Presentation attributes for grid corresponding to X axis.
    * @type string
    * @public
    */
    var $styleGridX            =  '';

    /**
    * Default presentation attributes for grid corresponding to X axis.
    * @type string
    * @public
    */
    var $styleGridXDefault     =  '';

    /**
    * Presentation attributes for grid corresponding to Y axis.
    * @type string
    * @public
    */
    var $styleGridY            =  '';

    /**
    * Default presentation attributes for grid corresponding to X axis.
    * @type string
    * @public
    */
    var $styleGridYDefault     =  '';

    /**
    * Presentation attributes for box around plot area.
    * @type string
    * @public
    */
    var $styleBox              =  '';

    /**
    * Default presentation attributes for box around plot area.
    * @type string
    * @public
    */
    var $styleBoxDefault       =  '';

    /**
    * Presentation attributes for X axis tags.
    * @type string
    * @public
    */
    var $styleTagsX            =  '';

    /**
    * Default presentation attributes for X axis tags.
    * @type string
    * @public
    */
    var $styleTagsXDefault     =  '';

    /**
    * X axis tags rotation. Negative/Anticlockwise.
    * Increase innerPaddingX to prevent overlap with plot area.
    * @type integer
    * @public
    */
    var $rotTagsX              =  0;

    /**
    * Presentation attributes for Y axis tags.
    * @type string
    * @public
    */
    var $styleTagsY            =  '';

    /**
    * Default presentation attributes for Y axis tags.
    * @type string
    * @public
    */
    var $styleTagsYDefault     =  '';

    /**
    * Y axis tags rotation. Negative/Anticlockwise.
    * Increase innerPaddingY to prevent overlap with plot area.
    * @type integer
    * @public
    */
    var $rotTagsY              =  0;

    /**
    * Default presentation attributes for line plots.
    * @type string
    * @public
    */
    var $styleLineDefault      =  '';

    /**
    * Default presentation attributes for bar plots.
    * @type string
    * @public
    */
    var $styleBarDefault       =  '';

    /**
    * Default presentation attributes for polyline plots (inside group tag).
    * @type string
    * @public
    */
    var $stylePolylineDefault  = '';

    /**
    * Extra SVG to add to graph. e.g. Filters, Defs, Title.
    * Note: Title is useful to add if image is viewed out of context.
    * <dt><code>$svg</code><dd>
    * String holding SVG text.
    * </dl>
    * @type string
    * @public
    */
    var $extraSVG              =  '';

    /**
    * SVG XML result.
    * @type string
    * @public
    */
    var $svg                   =  '';

    /**
    * Contains error messages.
    * @type string
    * @public
    */
    var $error                 =  '';


  /**
  * Define static variables used in the class.
  * @returns void
  */
  function svgGraph() {
	if( !defined("DECIMAL_POINT") )
		define("DECIMAL_POINT", ".");
	if( !defined("THOUSANDS_SEPARATOR") )
		define("THOUSANDS_SEPARATOR", ",");
  }

  /**
  * Initialises the variables used for drawing points, lines, grid, and ticks in the plotting area.
  * @return Boolean - FALSE if an error was encountered while processing data.
  * @returns boolean
  */
  function init() {
    $this->svg       = ''; // complete SVG of graph
    $this->svgText   = ''; // SVG for outer text labels and title
    $this->svgPlot   = ''; // SVG for plot including tag text
    $this->numGridlinesX = sizeof($this->dataX);
    if ($this->numGridlinesX == 0) {
      $this->error = 'No data to plot. Check data.';
      return FALSE;
    }
    if ($this->numGridlinesY == 0) {
      $this->error = 'No range for Y values. Check number of Y ticks.';
      return FALSE;
    }
    $width = $this->plotWidth - 1;
    $height = $this->plotHeight - 1;

     // find range of all y values
    $allDataY = array();
    foreach ($this->dataY as $i => $dataY) $allDataY = array_merge($allDataY, $dataY);
    $this->allDataY = $allDataY;
    $data = $this->_findRange($allDataY, $this->minY, $this->maxY, $this->resolutionY);
    $this->dataMinY = $data['min'];
    $this->dataMaxY = $data['max'];
    if (($this->dataMaxY - $this->dataMinY) == 0) {
      $this->error = 'No range to plot. Check data.';
      return FALSE; // data error
    }
    // find spacing for ticks and grid lines
    $this->deltaTicksX = $width / ($this->numGridlinesX - 1 + (2 * $this->offsetGridlinesX));
    $this->deltaTicksY = $height / ($this->numGridlinesY - 1 + (2 * $this->offsetGridlinesY));
    $this->factorY = $height / ($this->dataMaxY - $this->dataMinY);

    // format text for tags on Y axis
    //$deltaTagsY = $this->dataMaxY / ($this->numGridlinesY - 1 + (2 * $this->offsetGridlinesY));
    $deltaTagsY = ($this->dataMaxY -  $this->dataMinY) / ($this->numGridlinesY - 1 + (2 * $this->offsetGridlinesY));
    //$factorTagsY = $this->dataMaxY / ($this->dataMaxY - $this->dataMinY);
    for ($i=0; $i<$this->numGridlinesY; $i++) {
      $text = $this->dataMinY + $deltaTagsY * ($i +  $this->offsetGridlinesY);
      $this->tagsY[$i] = number_format($text, $this->decimalPlacesY, DECIMAL_POINT, THOUSANDS_SEPARATOR);
    }
    $this->tagsY = array_reverse($this->tagsY);
    if (empty($this->tagsY)) {
      $this->error = 'No Y axis data.';
      return FALSE;
    }
    return TRUE;
  }

  /**
  * Calls functions to draw title, labels, tags, grid lines, and box of graph.
  * @returns void
  */
  function drawGraph() {
    $this->drawOuterText();
    $this->drawGridX();
    $this->drawGridY();
    $this->drawBox();
    $this->drawTagsX();
    $this->drawTagsY();
  }

  /**
  * Draw the title and axis labels around the outside of the graphic area.
  * @returns void
  */
  function drawOuterText() {
    $outerPadding = $this->outerPadding;

    // draw title
    if (!empty($this->title)) { // check if there is something to draw
      $offset         = $this->graphicWidth / 2;
      $transform      = "transform='translate(0, $outerPadding)'";
      $this->svgText .= "<text text-anchor='middle' $transform x='$offset' y='1em' ";
      $this->svgText .= "style='{$this->styleTitleDefault}{$this->styleTitle}'>";
      $this->svgText .= "{$this->title}</text>\n";
    }

    //draw label Y
    if (!empty($this->labelY)) { // check if there is something to draw
      $offset         = $this->plotOffsetY + ($this->plotHeight / 2);
      $transform      = "transform='translate($outerPadding, 0) rotate(-90 0 $offset)'";
      $this->svgText .= "<text text-anchor='middle' $transform x='0' y='$offset' dy='1em' ";
      $this->svgText .= "style='{$this->styleLabelYDefault}{$this->styleLabelY}'>";
      $this->svgText .= "{$this->labelY}</text>\n";
    }

    //draw label X
    if (!empty($this->labelX)) { // check if there is something to draw
      $offset         = $this->plotOffsetX + ($this->plotWidth / 2);
      $transform      = "transform='translate(0, -$outerPadding)'";
      $this->svgText .= "<text text-anchor='middle' $transform x='$offset' y='{$this->graphicHeight}' ";
      $this->svgText .= "style='{$this->styleLabelXDefault}{$this->styleLabelX}'>";
      $this->svgText .= "{$this->labelX}</text>\n";
    }
  }

  /**
  * Draws the grid lines from top to bottom in the plotting area.
  * @returns void
  */
  function drawGridX() {
    $this->svgPlot .= "<g style='{$this->styleGridXDefault}{$this->styleGridX}'>\n";
    $top = 0;
    $bottom = $this->plotHeight - 1;
    foreach ($this->dataX as $i => $x) {
      $u = $this->deltaTicksX * ($i +  $this->offsetGridlinesX);
      $this->svgPlot .= "<line x1='$u' y1='$top' x2='$u' y2='$bottom'/>\n";
    }
    $this->svgPlot .= "</g>\n";
  }

  /**
  * Draws the grid lines from right to left in the plotting area.
  * @returns void
  */
  function drawGridY() {
    $this->svgPlot .= "<g style='{$this->styleGridYDefault}{$this->styleGridX}'>\n";
    $left = 0;
    $right = $this->plotWidth - 1;
    for ($i = 0; $i < $this->numGridlinesY; $i++) {
      $v = $this->deltaTicksY * ($i +  $this->offsetGridlinesY);
      $this->svgPlot .= "<line x1='$left' y1='$v' x2='$right' y2='$v'/>\n";
    }
    $this->svgPlot .= "</g>\n";
  }

  /**
  * Draws the box around the plotting area.
  * @returns void
  */
  function drawBox() {
    $width = $this->plotWidth - 1;
    $height = $this->plotHeight - 1;
    $this->svgPlot .= "<g style='{$this->styleBoxDefault}{$this->styleBox}'>\n";
    $this->svgPlot .= "<line x1='0' y1='0' x2='$width' y2='0'/>\n";
    $this->svgPlot .= "<line x1='0' y1='$height' x2='$width' y2='$height'/>\n";
    $this->svgPlot .= "<line x1='$width' y1='0' x2='$width' y2='$height'/>\n";
    $this->svgPlot .= "<line x1='0' y1='0' x2='0' y2='$height'/>\n";
    $this->svgPlot .= "</g>\n";
  }

  /**
  * Draws the axis tag text outside the plotting area on the x axis.
  * @returns void
  */
  function drawTagsX() {
    $this->svgPlot .= "<g style='{$this->styleTagsXDefault}{$this->styleTagsX}'>\n";
    $bottom = $this->plotHeight - 1;
    $innerPadding = $this->innerPaddingX;

    foreach ($this->dataX as $i => $text) {
      $u = $this->deltaTicksX * ($i +  $this->offsetGridlinesX);

      if ($this->rotTagsX == 0) {
        $transform = "transform='translate(0, $innerPadding)'";
        $this->svgPlot .= "<text text-anchor='middle' $transform dy='1em' x='$u' y='$bottom'>$text</text>\n";
      } else if($this->rotTagsX > 0) {
        $transform = "transform='translate(0, $innerPadding) rotate({$this->rotTagsX} $u $bottom)'";
        $this->svgPlot .= "<text text-anchor='start' $transform x='$u' y='$bottom'>$text</text>\n";
      } else {
        $transform = "transform='translate(0, $innerPadding) rotate({$this->rotTagsX} $u $bottom)'";
        $this->svgPlot .= "<text text-anchor='end' $transform x='$u' y='$bottom'>$text</text>\n";
      }
    }
    $this->svgPlot .= "</g>\n";
  }

  /**
  * Draws the axis tag text outside the plotting area on the y axis.
  * @returns void
  */
  function drawTagsY() {
    if (empty($this->tagsY)) return; // no data to plot. error should be picked up by init method.
    $this->svgPlot .= "<g style='{$this->styleTagsYDefault}{$this->styleTagsY}'>\n";
    $innerPadding = $this->innerPaddingY;
    foreach ($this->tagsY as $i => $text) {
      $v = $this->deltaTicksY * ($i +  $this->offsetGridlinesY);
      if ($this->rotTagsY == 0) {
        $transform = "transform='translate(-$innerPadding, 0)'";
        $this->svgPlot .= "<text text-anchor='end' $transform x='0' dy='0.5em' y='$v'>$text</text>\n";
      } else {
        $transform = "transform='translate(-$innerPadding, 0) rotate({$this->rotTagsY} 0 $v)'";
        $this->svgPlot .= "<text text-anchor='end' $transform x='0' dy='0.5em' y='$v'>$text</text>\n";
      }
    }
    $this->svgPlot .= "</g>\n";
  }

  /**
  * Draw a line from one point to the next continuously without stopping to draw markers.
  * This method is used for drawing lines with markers on the end, for example, an arrow indicating trend.
  * <br><br>
  * The format parameter array for the selected dataset can have two members:<br>
  * 'style' - Style for line,<br>
  * 'attributes' - Attributes to place inside polyline tag.
  * @param $whichDataSet Which set of data to draw. This is the index of the data array to be used.
  * @return BOOLEAN FALSE if no style is defined for the data set selected.
  * @returns boolean
  */
  function polyLine($whichDataSet) {
    if (empty($this->format[$whichDataSet]['style'])) {
      $this->error = 'No style defined for data plot.';
      return FALSE; // data error
    }
    $attributes = empty($this->format[$whichDataSet]['attributes']) ?
                  '' : $this->format[$whichDataSet]['attributes'];

    $this->svgPlot .= "<g style='{$this->stylePolylineDefault}{$this->format[$whichDataSet]['style']}'>\n";
    $this->svgPlot .= "<polyline $attributes ";
    $u = 0;
    $v = 0;
    foreach ($this->dataX as $i => $x) {
      $y = $this->dataY[$whichDataSet][$i];
      $u = $this->deltaTicksX * ($i +  $this->offsetGridlinesX);
      $v = $this->factorY * ($y - $this->dataMinY);
      // $v = $this->plotHeight - $v;
      $v = ($this->plotHeight - $v) - 1;
      if ($i==0) $this->svgPlot .= "points='$u,$v";
      else  $this->svgPlot .= " $u,$v ";
      $oldU = $u;
      $oldV = $v;
    }
    $this->svgPlot .= "'/>\n</g>\n";
    return TRUE;
  }

  /**
  * Draw line from one point to the next stopping at each.
  * This method is used for drawing lines with markers at each plot point.
  * <br><br>
  * The format parameter array for the selected dataset can have two members:<br>
  * 'style' - Style for line,<br>
  * 'attributes' - Attributes to place inside line tag.
  * @param $whichDataSet Which set of data to draw. This is the index of the data array to be used.
  * @returns void
  */
  function line($whichDataSet) {
    if (empty($this->format[$whichDataSet]['style'])) {
      $this->error = 'No style defined for data plot. Check parameters.';
      return FALSE; // data error
    }

    $attributes = empty($this->format[$whichDataSet]['attributes']) ?
                  '' : $this->format[$whichDataSet]['attributes'];
    $this->svgPlot .= "<g style='{$this->styleLineDefault}{$this->format[$whichDataSet]['style']}'>\n";
    $u = 0;
    $v = 0;
    foreach ($this->dataX as $i => $x) {
      $y = $this->dataY[$whichDataSet][$i];
      $u = $this->deltaTicksX * ($i +  $this->offsetGridlinesX);
      $v = $this->factorY * ($y - $this->dataMinY);
	  // $v = $this->plotHeight - $v;
      $v = ($this->plotHeight - $v) - 1;
      if ($i==0) {
        $oldU = $u;
        $oldV = $v;
      }
      $this->svgPlot .= "<line $attributes x1='$oldU' y1='$oldV' x2='$u' y2='$v'/>\n";
      $oldU = $u;
      $oldV = $v;
    }
    $this->svgPlot .= "</g>\n";
    return TRUE;
  }

  /**
  * Draw a bar for each data point from the data set selected.
  * @param $whichDataSet Which set of data to draw. This is the index of the data array to be used.
  * <br><br>
  * The format parameter array for the selected dataset can have three members:<br>
  * 'style' - Style for bar,<br>
  * 'barWidth' - Width of bar as fraction of distance between gridlines.
  *              Values greater than 1 will result in bars overlapping.<br>
  * 'barOffset' - Offset of the bar as fraction of bar width. By default it is centered on the gridline.
  * @return BOOLEAN FALSE if style, barWidth, or barOffset parameters are missing.
  * @returns boolean
  */
  function bar($whichDataSet) {
    if (!isset($this->format[$whichDataSet]['style'])    ||
        !isset($this->format[$whichDataSet]['barWidth']) ||
        !isset($this->format[$whichDataSet]['barOffset']  )) {
      $this->error = 'Style parameters missing for bar plot.';
      return FALSE; // data error
    }
    $this->svgPlot .= "<g style='{$this->styleBarDefault}{$this->format[$whichDataSet]['style']}'>\n";
    $barWidth = $this->format[$whichDataSet]['barWidth'] * $this->deltaTicksX;
    $barOffset = $this->format[$whichDataSet]['barOffset'] * $barWidth;
    $u = 0;
    $v = 0;
    foreach ($this->dataX as $i => $x) {
      $y = $this->dataY[$whichDataSet][$i];
      $u = $this->deltaTicksX * ($i + $this->offsetGridlinesX) - ($barWidth / 2) + $barOffset;
      $v = $this->factorY * ($y - $this->dataMinY);
      $v = $this->plotHeight - $v;
      $height = $this->factorY * ($y - $this->dataMinY) - 1;

      $this->svgPlot .= "<rect x='$u' y='$v' width='$barWidth' height='$height'/>\n";
    }
    $this->svgPlot .= "</g>\n";
    return TRUE;
  }

  /**
  * Find the maximum and minimum values for a set of data.<br>
  * The $resolution variable is used for rounding maximum and minimum values.<br>
  * If maximum value is 8645 then<br>
  * If $resolution is 0, then maximum value becomes 9000.<br>
  * If $resolution is 1, then maximum value becomes 8700.<br>
  * If $resolution is 2, then maximum value becomes 8650.<br>
  * If $resolution is 3, then maximum value becomes 8645.<br>
  * @param $data Data to find the range for
  * @param $min Minimum value to start at. If a lower number is found then this value is not used.
  * @param $max Maximum value to start at. If a larger number is found then this value is not used.
  * @param $resolution Resolution for range.
  * @returns array
  * @private
  */
  function _findRange($data, $min, $max, $resolution) {
    if (sizeof($data) == 0 ) return array('min' => 0, 'max' => 0);
    foreach ($data as $key => $value) {
      if ($value=='none') continue;
      if ($value > $max) $max = $value;
      if ($value < $min) $min = $value;
    }
    if ($max == 0) {
      $factor = 1;
    } else {
      if ($max < 0) $factor = - pow(10, (floor(log10(abs($max))) + $resolution) );
      else $factor = pow(10, (floor(log10(abs($max))) - $resolution) );
    }
    $max = $factor * @ceil($max / $factor);
    $min = $factor * @floor($min / $factor);

    return array('min' => $min, 'max' => $max);
  }

  /**
  * Generate SVG for entire graph.
  * @returns void
  */
  function generateSVG( $params = '' ) {  //enableZoomAndPanControls='false'
    $this->svg  = "<?xml version='1.0' encoding='utf-8'?>\n";
    $this->svg .= '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';
    $this->svg .= "\n<svg width='{$this->graphicWidth}' height='{$this->graphicHeight}' ";
	$this->svg .= $params . ">\n";
	$this->svg .= "<rect width='100%' height='100%' style='{$this->backgroundStyle}'/>";

    if (!empty($this->extraSVG)) {
      $this->svg .= "<!-- Extra SVG -->\n";
      $this->svg .= $this->extraSVG."\n";
      $this->svg .= "<!-- End Extra SVG -->\n";
    }

    if (!empty($this->svgText)) {
      $this->svg .= "<!-- Outer Text -->\n";
      $this->svg .= "<g>\n";
      $this->svg .= $this->svgText."\n";
      $this->svg .= "</g>\n" ;
      $this->svg .= "<!-- End Outer Text -->\n";
    }

    $this->svg .= "<!-- Plot Area -->\n";
    $this->svg .= "<g transform='translate({$this->plotOffsetX},{$this->plotOffsetY})'>\n";
    $this->svg .= $this->svgPlot."\n";
    $this->svg .= "</g>\n" ;
    $this->svg .= "<!-- End Plot Area -->\n";

    $this->svg .= "</svg>\n" ;
  }

  /**
  * Output SVG as XML text including appropriate HTTP header information.
  * @returns void
  */
  function outputSVG() {
    if (empty($this->svg)) $this->generateSVG();
    header("Content-type: image/svg+xml");
    print $this->svg;
  }

}

?>
