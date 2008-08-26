.DA
.TL
WikiTeX %VERSION% NEWS
.AU
Peter Danenberg <pcd at wikitex dot org>
.SH
Thu Mar 10 01:26:39 PST 2005	Peter Danenberg
.RS
.PP
Skak by Torben Hoffmann has replaced Piet Tutelaers' package as the <chess> renderer; Skak is backwards compatible and allows, amongst other things:
.RS
.IP \(bu
SAN and PGN notation
.IP \(bu
large boards (with \\largeboard)
.IP \(bu
move arrows (with \\printarrow)
.RE
.LP
see the docs for details.
.RE
.SH
Tue Mar  8 16:53:39 PST 2005	Peter Danenberg
.RS
.PP
<schem> added; id est, schematic capture with gschem (geda.seul.org).  PPCH has been deprecated; XyMTeX, meanwhile, has taken its place as the <chem> renderer.
.PP
Effort is underway to replace our ad-hoc blacklists with chroot-based security; adieu, \(lqdirecta non grata!\(rq
.PP
Lastly, verbose errors now declare not only the whence, but the why of defects.
.RE
.SH
Sun Feb  6 14:21:48 PST 2005	Peter Danenberg
.RS
.PP
We've disassociated our versioning from MediaWiki, and started with a pristine 1.0; so that, should we bundle in the future, our release cycles can be distinct.
.RE
.SH
Sat Jan 29 00:34:09 PST 2005	Peter Danenberg
.RS
.PP
Changes almost too numerous to enumerate; but some of the more exciting:
.IP \(bu
Gnuplot and Graphviz: <plot> and <graph>, respectively
.IP \(bu
Multi-page output for music, go and chess
.IP \(bu
More detailed, helpful error messages
.PP
The installation process, to boot, is less error-prone; no Python: but the bash interface has been refactored.
.RE
.SH
Tue Jan 25 11:23:48 PST 2005	Peter Danenberg
.RS
.PP
This candidate both maintains by tightening down our blacklist (thanks, Johannes Berg); and innovates by introducing Jan-Aoke Larsson's dvipng.  dvipng replaces dvi2bitmap; resulting in cleaner, faster renders.
.PP
<math></math> becomes <amsmath></amsmath> in the stand-alone version, to avoid conflicting with texvc; in pre-packaged WikiTeX, it replaces texvc.
.PP
I'd also like to un-cobweb that bash interface with Python before we go live.
.RE
.SH
Mon Oct  4 01:56:23 PDT 2004	Peter Danenberg
.RS
.PP
In order to plumb their several virtues' depth, the Batik toolkit ("heavy SVG"), will be available alongside ImageMagick; its more efficient kin.
.PP
Batik may be invoked by <batik></batik>; and <svg></svg>, ImageMagick.
.RE
.SH
Sun Oct  3 17:38:03 PDT 2004	Peter Danenberg
.RS
.PP
SVG is finally here; and we opted for Batik's SVG kit (xml.apache.org/batik) which, though very full-featured, suffers from a Java-like retardation.  It were mere oeconomy that ever importuned us to return to ImageMagick's SVG subset.
.RE
.SH
Mon Sep  6 03:20:26 PDT 2004	Peter Danenberg
.RS
.PP
With the introduction of XML-like tags, we have cleared a major hurdle towards integration with Media\%Wiki; next on the list, parameters of the form:
.QP
<music tempo="80"></music>
.LP
WikiTeX' vulnerability to attack must also be thoroughly sounded.
.RE
.SH
Sun May 30 00:00:00 PDT 2004	Peter Danenberg
.RS
.PP
We're  refactoring WikiTeX from the ground up to implement tags of the form:
.QP 
<class [parm: value]>content</class>
.LP 
and likely of an external parser; where a lex/yacc  solution
might  be attractive.  (Finite state recognition is probably
what we're looking  for,  however,  rather  than  look-ahead
left-to-right parsing; i.e. top-down recursive descent.)
.PP
If  WikiTeX'  sum scope, on the other hand, resembles a
glue-script with regular-expression grinding,*
.FS *
Raymond,  Eric  Steven.   The Art of Unix Programming (faqs.org/docs/artu).
.FE
we might not need  to  look  past  Perl; PHP, in any case, just passes as
lexer/parser: but we'd like something more robust and, above
all, to separate application from interface.
.RE
.bp
