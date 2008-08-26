.RP
.DA
.TL
WikiTeX %VERSION% README
.AU
Peter Danenberg <pcd at wikitex dot org>
.AB
Covers installation and expansion of the WikiTeX system.
.AE
.XS 1
1. Introduction
.XA 1
2. Acquisition
.XA 1
	2.1 CVS
.XA 2
	2.2 FTP
.XA 2
	2.3 HTTP
.XA 2
	2.4 Subversion
.XA 2
3. Installation
.XA 2
	3.1. Prerequisites
.XA 2
	3.2. Installation
.XA 3
	3.2.1. Batik, gschem
.XA 4
4. Hacking
.XA 4
	4.1. Getting Started
.XA 4
	4.2. Extending WikiTeX
.XA 5
5. Help
.XA 5
6. Colophon
.XA 6
7. Copyright
.XE
.PX
.NH 1
Introduction
.RS
.PP
WikiTeX extends MediaWiki by allowing authors to manipulate graphical objects directly in their articles; support so far includes: math, music, chess, chemistry, go, plotting, relational diagrams and schematic capture.
.PP
Visit http://wikitex.org to learn more; or to see WikiTeX in action:
.QP
http://wikisophia.org
.RE
.NH 1
Acquisition
.RS
.NH 2
CVS
.RS
.PP
WikiTeX can be CVS'ed from MediaWiki's facility at SourceForge:*
.RE
.LD
\%cvs -d:pserver:anonymous@cvs.sf.net:/cvsroot/wikipedia \\
co wikitex
.DE
.FS *
For actual development snapshots see Subversion below.
.FE
.NH 2
FTP
.RS
.PP
The latest stable releases can be downloaded from:
.QP
ftp://wikitex.org
.RE
.NH 2
HTTP
.RS
.PP
The latest releases can be browsed and downloaded from:
.QP
http://wikitex.org/wikitex
.RE
.NH 2
Subversion
.RS
.PP
Use your Subversion client (http://subversion\:.tigris.org) to get the latest development snapshot:
.LD
svn co http://svn.wikitex.org/wikitex/trunk wikitex
.DE
or visit http://svn.wikitex.org/wikitex to browse the codebase via web.
.RE
.RE
.NH 1
Installation
.RS
.NH 2
Prerequisites
.RS
.PP
In a nutshell, WikiTeX requires a successful installation of:
.RS
.IP \(bu
LaTeX (latex-project.org)
.IP \(bu
MediaWiki (wikipedia.sf.net)
.IP \(bu
ImageMagick (imagemagick.org)
.IP \(bu
dvipng (dvipng.sf.net)
.RE
.LP
Lilypond (lilypond.org), Gnuplot (gnuplot.info), Graphviz (graphviz.org) and gschem (geda.seul.org) are required for music, plot, graph and schem; and as many of the packages under \(sc3.2.5 (see below) whose classes you would like to support.
.PP
At least LaTeX and ImageMagick are standard Linux fare; and you may find some optional packages pre-installed, too.
.RE
.NH 2
Installation
.RS
.PP
Verify or install the essential prerequisites per \(sc3.1 above; then, working from MediaWiki's base installation directory, perform the following:
.nr i 0 1
.IP \n+i.
Create /extensions/wikitex and copy thither the distribution.
.IP \n+i.
Add the following line to /LocalSettings.php before the terminal '?>':
.QP
include\ \%'./extensions/wikitex/wikitex.php';
.IP \n+i.
Render /extensions/wikitex/tmp scribable to the web server:*
.FS *
Consult your server config for the appropriate user and group id.
.FE
.QP
chown\ nobody:nobody\ \%/extensions/wikitex/tmp
.IP \n+i.
Disable PHP in /extensions/wikitex/tmp by issuing:
.RS
.QP
php_flag engine off
.LP
from .htaccess in the same directory; disable CGI, if necessary.
.RE
.IP \n+i.
Install as many of the following packages whose classes you would like to support, or add your own (see Expanding WikiTeX):
.RE
.KS
.TS
expand;
c c c c
l l l l .
Class	Package	Author	URL
_
amsmath	AMS-LaTeX	Amer. Math. Soc.	ams.org
batik	SVG Java	Apache	apache.org
chem	XyMTeX	Shinsaku Fujita	kit.ac.jp
chess	Skak	Torben Hoffmann	ctan.org
feyn	Feynman	Michael Levine	ctan.org
go	Go	Daniel Bump	stanford.edu
graph	Graphviz	Emden Gansner	research.att.com
greek	Ibycus	Pierre MacKay	tug.org
ling	AVM	Christopher Manning	stanford.edu
	Parsetree	Eirik Hektoen	essex.ac.uk
music	Lilypond	Han-Wen Nienhuys	lilypond.org
plot	Gnuplot	Nikos Drakos	gnuplot.info
ppch	PPCH-TeX	Hans Hagen	pragma-ade.com
svg	SVG lite	ImageMagick	imagemagick.org
schem	gschem	Ales Hvezda	seul.org
teng	Tengwar	Ivan Derzhanski	quettar.org
tipa	TIPA	Rei Fukui	ctan.org
.TE
.KE
.RS
.IP \n+i.
Lastly, ensure that your server's $PATH variable includes /usr/bin and /usr/local/bin, or wherever your binaries are installed.
.NH 3
Batik, gschem
.RS
.PP
Batik and gschem require a framebuffer which, whether or not WikiTeX runs on a headless server, is best accomplished using a virtual framebuffer such as Xvfb.*
.FS *
VNC has been used to similar ends, but with added overhead and vulnerability.
.FE
.PP
Xvfb is included with Xorg and XFree86, but may not be installed by default on some Linux distros; consult the xvfb script which came with WikiTeX.
.nr i 0 1
.IP \n+i.
Verify xvfb for path-correctness.
.IP \n+i.
Start Xvfb manually by issuing:
.RS
.QP
\&./xvfb start
.LP
or at boot-time:
.RS
.nr j 0 1
.af j a
.IP \n+j.
Copy xvfb to /etc/init.d
.IP \n+j.
Link xvfb to rc.d:
.RE
.LP
ln\ -s\ /etc/init.d/xvfb\ /etc/rc2.d/S98xvfb
.RE
.IP \n+i.
Add the following to apachectl or equivalent:
.QP
.RS
\%DISPLAY=localhost:1.0
.br
\%export DISPLAY
.RE
.RE
.RE
.RE
.NH 1
Hacking WikiTeX
.RS
.NH 2
Getting Started
.RS
.PP
Join the WikiTeX-l mailing list, where you can communicate with other users and developers:
.QP
http://lists.wikitex.org/wikitex-l
.LP
and familiarize yourself with Subversion (http://subversion.tigris.org), our collaborative development tool.
.RE
.NH 2
Extending WikiTeX
.RS
.PP
Adding novel packages to WikiTeX can be achieved in several discrete steps; after you have downloaded and installed the package:
.nr i 0 1
.IP \n+i.
Devise a class name for the package, and add a template to /extensions/wikitex in this form:
.RS
.QP
wikitex.<classname>.inc.<ext>
.RE
.IP
The template should expose said package to the renderer; see the current templates for examples.
.IP \n+i.
Unless the class requires non-standard processing (confer Lilypond's midi), skip to step three; else, add a new function in wikitex.sh under <class>.
.IP
Consult wikitex.sh for examples.
.IP \n+i.
Lastly, if the package contains undesirable or insecure directives, add them to:
.RS
.QP
\%objRend::strPost()::arrBlack[<class>]
.LP
in wikitex.php; the which see for details.
.RE
.RE
.RE
.NH 1
Getting Help
.RS
.PP
A great way to meet users and developers is by joining WikiTeX-l (see 4.1 above); alternatively, visit:
.QP
http://archives.wikitex.org/wikitex-l
.LP
to browse the archives.
.RE
.NH 1
Colophon
.RS
.PP
This document was prepared in GNU troff using the ms macro package; preprocessed with tbl, the table formatter; and lastly filtered through col to remove reverse line feeds and tabs:
.QP
groff -ms -t -Tascii SOURCE | col -bx > OUT
.RE
.bp
