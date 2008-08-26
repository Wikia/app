<?php

/*
 * Nice Category List extension.
 *
 * This extension implements a new tag, <ncl>, which generates a list of all
 * pages and sub-categories in a given category.  The list can display multiple
 * levels of sub-categories, and has several options for the display style.
 *
 * Usage:
 *   <ncl [options]>Category:Some Category</ncl>
 *
 * The following options are available:
 *   maxdepth         Maximum category depth; default 32
 *   style            'bullet' to show category contents as bullet lists
 *                    'compact' for a more compact listing
 *   showcats         Non-0 to display sub-category links in "bottom" (ie.
 *                    maxdepth) categories (default 0).
 *   showarts         Non-0 to display articles in categories (default 1).
 *   headings         'head' to display category headings as Wiki headings;
 *                    'bullet' to display category headings as large bullets
 *                    ('bullet' works well with 'style=compact').
 *   headstart        With 'headings=head', the heading level to list
 *                    top-level categories with (level increases for sub-cats).
 *
 * Examples:
 * 1. This:
 *      <ncl>Category:Some Category</ncl>
 *    generates a full, recursive listing.
 *
 * 2. Use this in a template:
 *      <ncl style=compact maxdepth=2 headings=bullet headstart=2
 *                            showcats=1 showarts=1>Category:{{PAGENAME}}</ncl>
 *    and include it in major category pages to provide a nice 2-level (or however
 *    many you like) index of the category.
 *
 * 3. This:
 *      <ncl style=compact headings=bullet headstart=2 showcats=1
 *                            showarts=0>Category:Categories</ncl>
 *    generates a full category listing, with indentation indicating category
 *    containment.
 *
 * Caveat: When used in a template, the category list will not refresh
 * immediately when reloaded; edit and save the article to see updates.
 */

if (!defined('MEDIAWIKI')) die();

$wgExtensionFunctions[] = 'wfNiceCategoryList';
$wgExtensionCredits['parserhook'][] = array(
  'name' =>        'NiceCategoryList',
  'author' =>      'Kichik, Johan the Ghost',
  'url' =>         'http://meta.wikimedia.org/wiki/NiceCategoryList_extension',
  'description' => 'generate a category page showing all pages in a category, including subcategories',
);


/*
 * Setup Nice Category List extension.
 * Sets a parser hook for <ncl></ncl>.
 */
function wfNiceCategoryList() {
    new NiceCategoryList();
}


/*
 * Simple class to hold category's title, links list,
 * and categories list.
 */
class NiceCategoryList_Links {

    private $title;
    private $articles = array();
    private $categories = array();
    private $subcats = array();

    public function __construct($title) {
        $this->title = $title;
    }


    public function addCategory($title, $links) {
        $this->subcats[] = $title;
        if ($links)
                $this->categories[] = $links;
    }


    public function addArticle($title) {
        $this->articles[] = $title;
    }


    /*
     * Get the title of this category.
     */
    public function getTitle() {
        return $this->title;
    }


    /*
     * Get the titles of the sub-categories of this category.
     */
    public function getCatTitles() {
        return $this->subcats;
    }


    /*
     * Get the titles of the articles in this category.
     */
    public function getArtTitles() {
        return $this->articles;
    }


    /*
     * Get the link records of the sub-categories of this category,
     * if we have them.
     * Returns an array of NiceCategoryList_Links objects.
     */
    public function getCategories() {
        return $this->categories;
    }


    /*
     * Return true iff we have link records for the sub-categories
     * of this category.
     */
    public function hasCatLinks() {
        return count($this->categories) > 0;
    }


    /*
     * Title comparison function
     */
    private function titleCmp($a, $b) {
        return $a->getText() > $b->getText();
    }

    /*
     * NiceCategoryList_Links comparison function
     */
    private function categoryCmp($a, $b) {
        return self::titleCmp($a->title, $b->title);
    }

    /*
     * Sort links and categories alphabetically.
     */
    public function sort() {
        usort($this->articles, array(&$this, "titleCmp"));
        usort($this->categories, array(&$this, "categoryCmp"));
    }

}


class NiceCategoryList {

    ////////////////////////////////////////////////////////////////////////
    // Configuration
    ////////////////////////////////////////////////////////////////////////

    /*
     * Default settings for the category list.
     */
    private $settings = array(
        'maxdepth'  => 32,           // Sanity stop level.
        'style'     => 'bullet',     // Default style for "leaf" level.
        'showcats'  => 0,            // Non-0 to display sub-cat links in a category.
        'showarts'  => 1,            // Non-0 to display article links in a category.
        'headings'  => 'head',       // Show category headings as headings.
        'headstart' => 1,            // Heading level to start at.
        'sort'      => 0,            // Non-0 to sort the list alphabetically;
                                     // else sort the list according to the
                                     // index key.
    );


    ////////////////////////////////////////////////////////////////////////
    // Constructor
    ////////////////////////////////////////////////////////////////////////

    /*
     * Setup Nice Category List extension.
     * Sets a parser hook for <ncl></ncl>.
     */
    public function __construct() {
            global $wgParser;
            $wgParser->setHook('ncl', array(&$this, 'hookNcl'));
    }


    ////////////////////////////////////////////////////////////////////////
    // Hook
    ////////////////////////////////////////////////////////////////////////

    /*
     * The hook function.  Handles <ncl></ncl>.
     *     $category   The tag's text content (between <ncl> and </ncl>);
     *                 this is the name of the category we want to index.
     *     $argv       List of tag parameters; these can be any of the settings
     *                 in $this->settings.
     *     $parser     Parser handle.
     */
    public function hookNcl($category, $argv, &$parser) {
        // Get any user-specified parameters, and save them in $this->settings.
        foreach (array_keys($argv) as $key)
            $this->settings[$key] = $argv[$key];

        // Replace variables in $category by calling the parser on it.  This
        // allows it to use {{PAGENAME}}, etc.
        $localParser = new Parser();
        $category = $localParser->parse($category, $parser->mTitle, $parser->mOptions, false);
        $category = $category->getText();

        // Make a Title objhect for the requested category.
        $title = Title::newFromText($category);
        if (!$title)
                return '<p>Failed to create title!</p>';

        // Get the database handle, and get all the category links for
        // this category.
        $dbr =& wfGetDB(DB_SLAVE);
        $catData = $this->searchCategory($dbr, $title, 0);

        // Generate the category listing.
        $output = $this->outputCategory($catData);

        // There's no need for a TOC, so suppress it.
        $output .= "__NOTOC__\n";

        // Convert the listing wikitext into HTML and return it.
        $localParser = new Parser();
        $output = $localParser->parse($output, $parser->mTitle, $parser->mOptions);
        return $output->getText();
    }


    ////////////////////////////////////////////////////////////////////////
    // Database Access
    ////////////////////////////////////////////////////////////////////////

    /*
     * Get all of the direct and indirect members of a given category: ie.
     * all of the articles and categories which belong to that category
     * and its children.
     *     $dbr        The database handle
     *     $catTitle   The Title object for the category to search
     *     $depth      Our current recursion depth: starts at 0
     *     $processed  List of categories that have been searched to date
     *                 (to prevent looping)
     *
     * Returns null if this category has already been searched; otherwise,
     * a NiceCategoryList_Links object for the given category, containing all
     * the sub-categories and member articles.
     */
    private function searchCategory($dbr, $catTitle, $depth, $processed = array()) {
        // Avoid endless recursion by making sure we haven't been here before.
        if (in_array($catTitle->getText(), $processed))
            return null;
        $processed[] = $catTitle->getText();

        // Get all of the category links for this category.
        $links = $this->getCategoryLinks($dbr, $catTitle);

        // Build a list of items which belong to this category.
        $cl = new NiceCategoryList_Links($catTitle);
        foreach ($links as $l) {
                // Make a Title for this item.
            $title = Title::makeTitle($l->page_namespace, $l->page_title);

            if ($title->getNamespace() == NS_CATEGORY) {
                // This item is itself a category: recurse to find all its
                // links, unless we've hit maxdepth.
                $subLinks = null;
                if ($depth + 1 < $this->settings['maxdepth'])
                    $subLinks = $this->searchCategory($dbr, $title,
                                                      $depth + 1, $processed);

                // Record the subcategory name, and its links if we got any.
                $cl->addCategory($title, $subLinks);
            } else {
                // This is a regular page; just add it to the list.
                $cl->addArticle($title);
            }
        }

        // Sort the item lists, if requested.  (Thanks, Jej.)
        if ($this->settings['sort'])
            $cl->sort();

        return $cl;
    }


    /*
     * Get all of the direct members of a given category.
     *     $dbr        The database handle
     *     $title      The Title object for the category to search
     *
     * Returns an array of objects, each representing one member of the named
     * caregory.  Each object contains the following fields from the database:
     *      page_title
     *      page_namespace
     *      cl_sortkey
     */
    private function getCategoryLinks($dbr, $title) {
            // Query the database.
        $res = $dbr->select(
            array('page', 'categorylinks'),
            array('page_title', 'page_namespace', 'cl_sortkey'),
            array('cl_from = page_id', 'cl_to' => $title->getDBKey()),
            '',
            array('ORDER BY' => 'cl_sortkey')
        );
        if ($res === false)
                return array();

        // Convert the results list into an array.
        $list = array();
        while ($x = $dbr->fetchObject($res))
                $list[] = $x;

        // Free the results.
        $dbr->freeResult($res);

        return $list;
    }


    ////////////////////////////////////////////////////////////////////////
    // Output
    ////////////////////////////////////////////////////////////////////////

    /*
     * Generate output for the list.
     */
    function outputCategory($category, $level = 0) {
        global $wgContLang;

        $output = '';

        // The second level and onwards has a heading.
        // The heading gets smaller as the level grows.
        if ($level > 0) {
            $title = $category->getTitle();
            $ptitle = $title->getPrefixedText();
            $title = $wgContLang->convert($title->getText());
            $link = "[[:" . $ptitle . "|'''" . $title . "''']]";

            // Do the heading.  If settings['headings'] == 'head', then
            // the heading is a real Wiki heading; otherwise, it's a nested
            // bullet item.
            if ($this->settings['headings'] == 'head') {
                $heading = str_repeat('=', $level + $this->settings['headstart']);
                $output .= $heading . $title . $heading . "\n";
            } else {
                $stars = str_repeat('*', $level);
                if ($level <= 1)
                    $output .= "<big>\n" . $stars . " " . $link . "</big>\n";
                else
                    $output .= $stars . " " . $link . "\n";
            }
        }

        // Now generate the category output.  We put the various items in
        // $pieces at first.
        $pieces = array();

        // Output each subcategory's name, if we don't have a real
        // listing of its contents (because we hit maxdepth), and
        // if settings['showcats'].
        if ($this->settings['showcats'] && !$category->hasCatLinks()) {
                $subCatTitles = $category->getCatTitles();
            foreach ($subCatTitles as $title) {
                $ptitle = $title->getPrefixedText();
                $title = $wgContLang->convert($title->getText());
                $disp = "[[:" . $ptitle . "|'''" . $title . "''']]";
                $pieces[] = $disp;
            }
        }

        // Output each article in the category, if settings['showarts'].
        if ($this->settings['showarts']) {
                $articleTitles = $category->getArtTitles();
            foreach ($articleTitles as $link) {
                $ptitle = $link->getPrefixedText();
                $title = $link->getText();
                $disp = "[[:" . $ptitle . "|" . $title . "]]";
                $pieces[] = $disp;
            }
        }

        // If we got some items, then display them in the requested style.
        if (count($pieces) > 0) {
            if ($this->settings['style'] == 'bullet')
                $output .= "* " . implode("\n* ", $pieces) . "\n";
            else {
                $pre = $level == 0 ? "<big>" : str_repeat('*', $level - 1) . ':';
                $post = $level == 0 ? "</big>" : '';
                $output .= $pre . implode(" • ", $pieces) . $post . "<br>\n";
            }
        }

        // Recurse into each subcategory.
        $subCategories = $category->getCategories();
        foreach ($subCategories as $cat)
            $output .= $this->outputCategory($cat, $level + 1);

        return $output;
    }

}

?>
