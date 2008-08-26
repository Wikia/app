MediaWiki RDF extension

version 0.7
26 Nov 2006

This is the README file for the RDF extension for MediaWiki
software. The extension is only useful if you've got a MediaWiki
installation; it can only be installed by the administrator of the site.

The extension adds RDF (= Resource Definition Framework) support to
MediaWiki. It will show RDF data about a page with a new special page,
Special:Rdf. It allows users to add custom RDF statements to a page
between <rdf> ... </rdf> tags. Administrators and programmers can add
new automated RDF models, too.

This is an early version of the extension and it's almost sure to
have bugs. See the BUGS section below for info on how to report
problems.

== License ==

Copyright 2005, 2006 Evan Prodromou <evan@wikitravel.org>.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

== Installation ==

You have to have MediaWiki 1.5.x installed for this software to work.
Sorry, but that's the version I've got installed, so it's the one this
software works with.

You also have to install RAP, the RDF API for PHP
(www.wiwiss.fu-berlin.de/suhl/bizer/rdfapi/) . I used version 0.92,
plus some custom hacks to make the N3 parser less fragile. You have to
apply a patch to the distribution if you want RDF to work; it's
included in this distribution. (Future versions of RAP will have these
enhancements).

You should be able to move the directory created by unpacking the
MwRDF archive to the extensions subdirectory of your MediaWiki
installation. Then add these lines to your LocalSettings.php:

  define("RDFAPI_INCLUDE_DIR", "/full/path/to/rdfapi-php/api/");
  require_once("extensions/Rdf/Rdf.php");

== 60-second intro to RDF ==

RDF is a framework for making statements about resources. Statements
are in the form:

    subject predicate object
    
Here, "subject" is a "resource" such as a person, place, idea, Web
page, picture, concept, or whatever. "Predicates" are names of
properties of a resource, like its color, shape, texture, size,
history, or relationships to other "resources". The object is the
value of the property. So "car color red" would be a statement about a
car; "Evan hasBrother Nate" would be a statement about a person.

Of course, it's important to be definite about which resources and
which properties we're discussing. In the Web world, each "resource"
is identified with a URI (usually an URL).

For electronic resources, this is usually pretty easy; the main page
of English-language Wikipedia, for example, has the URI
"http://en.wikipedia.org/wiki/Main_Page". However, for analog subjects
like people or ideas or physical objects, this can be a little
trickier.

There's no general solution, but the typical workaround is to use real
or made-up URIs to "stand in" for offline entities. For example, you
could use the URI for my Wikitravel user page,
"http://wikitravel.org/en/User:Evan", as the URI for me. Or you could
use my email address in URI form, like "mailto:evan@wikitravel.org".

People who need to agree on statements often create 'vocabularies' or
'schemas' that map concepts, object, and relationships to URIs. By
popularizing such a mapping, we can all agree about what a particular
URI "means".

For example, the Dublin Core Metadata Initiative (DCMI)
(http://www.dublincore.org/) has a schema for very simple metadata,
such as you'd find on a library card. They've defined (among other
things), that the idea of authoring or creating something is
represented by the URL http://purl.org/dc/elements/1.1/creator. So
you could say:

    http://www.fsf.org http://purl.org/dc/elements/1.1/creator mailto:rms@gnu.org

... means that the creator of the Free Software Foundation is Richard
Stallman.

There are a lot of RDF models out there; you can also create your own
if you want.

RDF statements can be encoded in a number of different ways. By far
the most popular is as XML, sometimes called "RDF/XML". "Turtle" is
another format, which uses plain text rather than XML; and "Ntriples"
is still another.

== Models ==

For any given resource you can describe it from many different
perspectives. For example, you can describe a man in terms of his
academic career, his job experience, his family members, his body
parts' size and weight, his location in space, his membership in
organizations, his hobbies and interests, etc.

In this extension, we use the term "model" to describe a perspective
on a resource. For example, listing the links to and from a page is
one model; its edit history is another model. You can choose which
models you want to know about when querying the system for RDF
statements about a subject, and only statements in that model are
returned.

This is mostly a concession to performance; it doesn't make sense to
calculate information about the history of a page if calling program
isn't going to use it.

There are a number of models built into this extension; you can also
add your own, if you know how to code PHP. The models have short
little codenames for easy access, listed below.

Models built in:

  * dcmes: Dublin Core Metadata Element Set (DCMES) data. Mostly
    information about who edited a page, when, and other simple stuff.
    Titles, format, etc. This is a common vocabulary that's very
    useful for general-purpose bots.
  * cc: Creative Commons metadata. Gives license information; there
    are a few tools and search engines that use this data.
  * linksto, linksfrom, links: Internal wiki links to and from a page.
    "links" is a shortcut for both.
  * image: DCMES information about images in a page.
  * history: version history of a page; who edited the page and when.
  * interwiki: links to different language versions of a page.
  * categories: which categories a page is in.
  * inpage: a special model for blocks of RDF embedded into the source
    code of MediaWiki pages; see "In-page RDF" below for info.
  
== Special:RDF ==

You can view RDF for a page using the [[Special:Rdf]] feature. It
should be listed on the list of special pages as "Rdf". Enter the
title of the page you want RDF for in the title box, and choose one or
more of the RDF models from the multiselect box. You can also select
which output format you want; XML is probably most useful and can be
viewed in a browser.

The Special:Rdf page can also be called directly, with the following
parameters:

  * target: title of the article to get RDF info about. If no target
    URL is provided, the special page shows the input form.
  * modelnames: comma-separated list of model names, like
    "links,cc,history". Default is a list of standard models,
    configurable per-site (see below).
  * format: output format; one of 'xml', 'turtle' and 'ntriples'.
    Default is XML.

== In-page RDF ==

Any user can make additional RDF statements about any resource by
adding an in-page RDF block to the page. The RDF needs to be in Turtle
format (http://www.dajobe.org/2004/01/turtle/), which is extremely
simple. It's a subset of Notation3
(http://www.w3.org/DesignIssues/Notation3.html), for which there is a
good introduction. (http://www.w3.org/2000/10/swap/Primer.html)

RDF blocks are delimited by the tag "<rdf>". They're invisible for
normal output, but they can provide information for RDF-reading items.
Here's an example:

  Mathematics is ''very'' hard.
  
  <rdf>
  <> dc:subject "Mathematics"@en .
  </rdf>

Here, the rdf block says that the subject of the article is
"Mathematics". Note that <> in Turtle means "this document". Another
example:

  Chilean wines are quite delicious.
  
  <rdf>
  <> dc:source <http://example.org/chileanwines.html> .
  <http://example.org/chileanwines.html>
      dc:creator "Bob Smith" .
  </rdf>

Here, we've said that the article's source is another Web page on
another server; we can also say that that other Web page's author is
Bob Smith.

In-page RDF is displayed whenever the "inpage" model is requested for
Special:RDF; it's one of the defaults. It's also useful for people
making MediaWiki extensions; you can have users add information in
in-page RDF, and then extract it and read it using the function
MwRdfGetModel(). This lets users add data that isn't for presentation
but perhaps for automated tools to use.

Note also that MediaWiki templates are expanded when in-page RDF is
queries. So if the syntax of Turtle is daunting, you can add templates
that make it easier. For example, we could create a template
Template:Source for showing source documents:

  <rdf>
  <> dc:source <{{{1}}}> .
  <{{{1}}}> dc:creator "{{{2|anonymous}}}" .
  </rdf>

We could then make the same statement as above with a template
transclusion:

  {{source|http://example.org/chileanwines.html|Bob Smith}}

Note that a number of namespaces are pre-defined for your RDF blocks.
Some basic namespaces are provided by RAP; you can define custom
namespaces with the global variable $wgRdfNamespaces . In addition,
each of the article namespaces is mapped to a namespace prefix in
Turtle, so you can say something like this:

   <rdf>
       Wikitravel_talk:Spelling dc:subject Wikitravel:Spelling .
       
       :Montreal dc:spatial "Montreal" .
   </rdf>

Note that the default prefix (":") is the article namespace.

== Customization ==

There are a few customization variables available, mostly for
programmers.

$wgRdfDefaultModels -- an array of names of the default models to use
		    when no model name is specified.
$wgRdfNamespaces -- You can add custom namespaces to this associative
		 array, of the form 'prefix' => 'uri' .
$wgRdfModelFunctions -- an associative array mapping model names to
		    functions that generate the model. See below for
		    how to add a new model.
$wgRdfOutputFunctions -- A map of output format to functions that
		      generate that output. You can add new output
		      formats by adding to this array.
$wgRdfCacheExpiry -- time in seconds to expire cached items

== Extending ==

You can add new RDF models to the framework by creating a model
function and adding it to the $wgRdfModelFunctions array. The function
will get a single MediaWiki Article object as a parameter; it should
return a single RAP Model object (a collection of statements) as a
result. For example,

    function CharacterCount($article) {
        # create a new model
        $model = ModelFactory::getDefaultModel();
	# get the article source
	$text = $article->getContent(true);
	# ... and its size
	$size = mb_strlen($text);
	# Get the resource for this article
	$ar = MwRdfArticleResource($article);
	# Add a statement to the model
	$model->add(new Statement($ar, new Resource("http://example.org/charcount"),
				  new Literal($size)));
	# return the model
	return $model;
    }

You can then give the model a name like so:

$wgRdfModelFunctions['charcount'] = 'CharacterCount';

You can add a message to the site describing your model like so:

$wgMessageCache->addMessages(array('rdf-charcount' => 'Count of characters'));

You can also create model-outputting functions if you so desire; they
should accept a RAP model as input and make output as they would to
the Web. This is probably only useful if you want a specific RDF
encoding mechanism that's not RDF/XML, Turtle, or Ntriples; for
example, TriG or TriX.

== Future ==

These are some future directions I'd like to see things go:

* Store statements in DB: statements could be stored in the database
  when the page is saved and retrieved when needed. This would make it
  possible to do extended queries based on information about *all* pages.
* Performance: there wasn't much performance tuning and there are
  probably way too many DB hits and reads and such.
* Semantic tuning: I'd like to make sure that the statements in the
  standard models are accurate and useful.

== Bugs ==

Send bug reports, patches, and feature requests to Evan Prodromou
<evan@wikitravel.org> .
