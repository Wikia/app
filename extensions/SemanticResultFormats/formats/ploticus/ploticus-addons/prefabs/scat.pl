// ploticus data display engine.  Software, documentation, and examples.  
// Copyright 1998-2002 Stephen C. Grubb  (scg@jax.org).
// Covered by GPL; see the file 'Copyright' for details. 
// http://ploticus.sourceforge.net

//// SCAT - do a scatterplot of two variables with pearson coefficient and regression line

//// set scat-specific defaults..
#if @CM_UNITS = 1
  #setifnotgiven rectangle = "2.5 2.5 10 10"
  #setifnotgiven ptsize = "0.1"
  #set LBLDIST = 1.38
  #set REGLBL = 1.5
  #set PTLBL = 0.18
  #set TAILS = 0.05
#else
  #setifnotgiven rectangle = "1 1 4 4"
  #setifnotgiven ptsize = "0.04"
  #set LBLDIST = 0.55
  #set REGLBL = 0.6
  #set PTLBL = 0.07
  #set TAILS = 0.02
#endif
#setifnotgiven ptshape = "circle"
#setifnotgiven ptcolor = "blue"
#setifnotgiven ptcolor2 = "red"
#setifnotgiven ptcolor3 = "green"
#setifnotgiven ptcolor4 = "black"
#setifnotgiven corrcolor = "green"
#setifnotgiven xerr = ""
#setifnotgiven err2 = ""
#setifnotgiven xerr2 = ""
#setifnotgiven errcolor = "gray(0.7)"
#setifnotgiven id = ""
#setifnotgiven idcolor = "orange"

#setifnotgiven x2 = ""
#setifnotgiven y2 = ""
#setifnotgiven ptshape2 = square
#setifnotgiven color2 = red
#setifnotgiven x3 = ""
#setifnotgiven y3 = ""
#setifnotgiven ptshape3 = diamond
#setifnotgiven color3 = black
#setifnotgiven x4 = ""
#setifnotgiven y4 = ""
#setifnotgiven ptshape4 = triangle
#setifnotgiven color4 = powderblue
#setifnotgiven ptstyle = filled
#if @ptstyle !in filled,outline
  #set ptstyle = filled
#endif

// this is correct... used in legend labels etc..
#setifnotgiven name = ""
#setifnotgiven name2 = ""
#setifnotgiven name3 = ""
#setifnotgiven name4 = ""

#if @CM_UNITS = 1
  #setifnotgiven legend = "max+1.5 max" 
#else
  #setifnotgiven legend = "max+0.6 max" 
#endif

//// load standard vars..
#include $chunk_setstd

//// read data..
#include $chunk_read

//// required vars..
#musthave x y

#if @cats = yes
  #proc categories
   axis: x
   datafield: @x
#endif
   

//// set up plotting area..
#include $chunk_area
#if @xrange != ""
  xrange: @xrange
#elseif @cats = yes
  xscaletype: categories
  // xcategories: @x
  // following added 9/2/02 scg
  // catcompmethod: exact

#else
  xautorange: datafields=@x,@x2,@x3,@x4 incmult=2.0 nearest=@xnearest 
#endif
#if @yrange != ""
  yrange: @yrange
#else
  yautorange: datafields=@y,@y2,@y3,@y4 incmult=2.0 nearest=@ynearest 
#endif

//// x axis
#include $chunk_xaxis
stubcull: yes

//// y axis
#include $chunk_yaxis
stubcull: yes
labeldistance: @LBLDIST

//// title
#include $chunk_title

//// user pre-plot include
#if @include1 != ""
  #include @include1
#endif


//// do regression line and correlation..
#if @corr = yes
  #proc curvefit
  curvetype: regression
  xfield: @x
  yfield: @y
  linedetails: color=@corrcolor width=0.5
  #ifspec maxinpoints
//// JQN 2/16/09 - changed location and textdetails so left-justified coz Annotations dont show up in vector formats
  #proc annotate
  location: @DATAXMIN min-@REGLBL
  textdetails: align=L size=8 color=@corrcolor
  text: r = @CORRELATION
	@REGRESSION_LINE
#endif


//// do labels..
#if @id != ""
  #proc scatterplot
  xfield: @x
  yfield: @y
  #if @id != ""  
    labelfield: @id
  #endif
  textdetails: size=6 color=@idcolor adjust=0,@PTLBL
  #ifspec cluster
#endif



//// do error bars..
#if @err != ""
 #proc bars
  locfield: @x
  lenfield: @y
  errbarfield: @err
  thinbarline: color=@errcolor width=0.5
  tails: @TAILS
  truncate: yes
  #ifspec ptselect select
  #saveas EB
#endif
  
#if @xerr != ""
  #proc bars
  #clone EB
  locfield: @y
  lenfield: @x
  horizontalbars: yes
  errbarfield: @xerr
  #ifspec ptselect select
#endif

//// do 2nd set of error bars..
#if @err2 != ""
 #proc bars
  #clone EB
  locfield: @x2
  lenfield: @y2
  errbarfield: @err2
  #ifspec ptselect2 select
#endif
  
#if @xerr2 != ""
  #proc bars
  #clone EB
  locfield: @y2
  lenfield: @x2
  errbarfield: @xerr2
  horizontalbars: yes
  #ifspec ptselect2 select
#endif

// scat prefab will always attempt to use pix* shapes..
#if @ptshape !like pix*
  #set ptshape = "pix" @ptshape
#endif

//// do the data points last so they are on top of the rest of the stuff..
#proc scatterplot
xfield: @x
yfield: @y
symbol: shape=@ptshape style=@ptstyle radius=@ptsize color=@ptcolor
#ifspec clickmapurl
#ifspec clickmaplabel
legendlabel: @name
#ifspec ptselect select
#ifspec cluster


//// optional 2nd set of points...
#if @x2 != "" && @y2 != ""
  #if @ptshape2 !like pix*
    #set ptshape2 = "pix" @ptshape2
  #endif

  #proc scatterplot
  xfield: @x2
  yfield: @y2
  symbol: shape=@ptshape2 style=@ptstyle radius=@ptsize color=@ptcolor2
  legendlabel: @name2
  #ifspec ptselect2 select
  #ifspec cluster
#endif

//// optional 3d set of points...
#if @x3 != "" && @y3 != ""
  #if @ptshape3 !like pix*
    #set ptshape3 = "pix" @ptshape3
  #endif

  #proc scatterplot
  xfield: @x3
  yfield: @y3
  symbol: shape=@ptshape3 style=@ptstyle radius=@ptsize color=@ptcolor3
  legendlabel: @name3
  #ifspec ptselect3 select
  #ifspec cluster
#endif

//// optional 4th set of points...
#if @x4 != "" && @y4 != ""
  #if @ptshape4 !like pix*
    #set ptshape4 = "pix" @ptshape4
  #endif

  #proc scatterplot
  xfield: @x4
  yfield: @y4
  symbol: shape=@ptshape4 style=@ptstyle radius=@ptsize color=@ptcolor4
  legendlabel: @name4
  #ifspec ptselect4 select
  #ifspec cluster
#endif

// do legend
#if @name != "#usefname" || @header = yes
  #proc legend
  location: @legend
  #ifspec legendfmt format
  #ifspec legendsep sep
  #ifspec legwrap wraplen
  #ifspec legbreak extent
  #ifspec legtitle title
  #ifspec legbox backcolor
  #ifspec legframe frame
  #ifspec legtextdet textdetails

#endif


//// user post-plot include..
#if @include2 != ""
  #include @include2
#endif
