<?php

#
# PageObjectModel is a set of classes that allow easy manipulation of MediaWiki page source.
#

require_once( dirname( __FILE__ ) . '/POM/Element.php' );
require_once( dirname( __FILE__ ) . '/POM/Page.php' );
require_once( dirname( __FILE__ ) . '/POM/Parser.php' );
require_once( dirname( __FILE__ ) . '/POM/CommentParser.php' );
require_once( dirname( __FILE__ ) . '/POM/Comment.php' );
require_once( dirname( __FILE__ ) . '/POM/LinkParser.php' );
require_once( dirname( __FILE__ ) . '/POM/Link.php' );
require_once( dirname( __FILE__ ) . '/POM/TemplateParser.php' );
require_once( dirname( __FILE__ ) . '/POM/Template.php' );
require_once( dirname( __FILE__ ) . '/POM/TemplateCollection.php' );
require_once( dirname( __FILE__ ) . '/POM/TextNode.php' );