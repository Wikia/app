<?php
/**
* Extension to svgGraph. 
* Defines default presentation attributes to use for all graphs instantiating this class.<br>
* <pre>
* Here are some style attributes to get started with.
*
* A &lt;color&gt; can be a numerical RGB specification.
* eg: rgb(0-100%, 0-100%, 0-100%) | rgb(0..255,0..255,0..255) | #rgb | #rrggbb )
*  
* Presentation attributes for filling and stroking:
* fill               (none | currentColor | &lt;color&gt; )
* fill-opacity       % Opacity Value;
* stroke             (none | currentColor | &lt;color&gt; )
* stroke-dasharray   % Stroke Dash Array
* stroke-dashoffset  % Stroke Dash Offset
* stroke-linecap     (butt | round | square | inherit)
* stroke-linejoin    (miter | round | bevel | inherit)
* stroke-miterlimit  % StrokeMiterLimitValue;
* stroke-opacity     % Opacity
* stroke-width       % Stroke Width
* 
* Presentation attributes for graphics:
* shape-rendering    (auto | optimizeSpeed | crispEdges | geometricPrecision | inherit)
* text-rendering     (auto | optimizeSpeed | optimizeLegibility | geometricPrecision | inherit)
* 
* Font Selection attributes:
* font-family        (serif | sans-serif | monospace) 
* font-style         (normal | italic | oblique | inherit)
* font-variant       (normal | small-caps | inherit)
* font-weight        (normal | bold | bolder | lighter | 100..900 | inherit)
* 
* </pre>
*/
class svgGraph1 extends svgGraph { var
  $graphicWidth           = 400,
  $graphicHeight          = 300,
  
  $plotWidth              = 300,
  $plotHeight             = 200,
  $plotOffsetX            = 60,
  $plotOffsetY            = 40,
  
  $styleTitleDefault      = 'text-rendering: optimizeSpeed; ',
  $styleLabelXDefault     = 'text-rendering: optimizeSpeed; ',
  $styleLabelYDefault     = 'text-rendering: optimizeSpeed; ',
  
  $styleTagsXDefault      = 'text-rendering: optimizeLegibility; ',
  $styleTagsYDefault      = 'text-rendering: optimizeLegibility; ',
  
  $styleGridXDefault      = 'shape-rendering: crispEdges; stroke:#ccc; stroke-width:1; ',
  $styleGridYDefault      = 'shape-rendering: crispEdges; stroke:#ccc; stroke-width:1; ',
  $styleBoxDefault        = 'shape-rendering: crispEdges; stroke:#000; stroke-width:1; ',
  
  $styleLineDefault       =  'shape-rendering: geometricPrecision; stroke-linecap: round; ', // smooth lines with round edges
  $stylePolylineDefault   =  'shape-rendering: geometricPrecision; fill:none; ', // don't fill area in
  $styleBarDefault        =  'shape-rendering: crispEdges; stroke:#000; stroke-width:1; ', //crisp black border

  $error                  =  '';
}

?>