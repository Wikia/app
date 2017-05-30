<?php

namespace PageHeader;

use \RequestContext;

class PageTitle
{

    /* @var string */
    public $title;

    /* @var string */
    public $prefix;

    /* @var \WikiaGlobalRegistry */
    private $wg;

    /* @var int */
    private $namespace;

    const PREFIX_LESS_NAMESPACES = [NS_MEDIAWIKI, NS_TEMPLATE, NS_CATEGORY, NS_FILE];

    /**
     * @param \WikiaApp $app
     */
    public function __construct($app)
    {
        $this->wg = $app->wg;
        $this->MWTitle = RequestContext::getMain()->getTitle();

        $this->namespace = $this->MWTitle->getNamespace();
        $this->title = $this->handleTitle($app);
        $this->prefix = $this->handlePrefix();
    }

    private function handleTitle(\WikiaApp $app): string {
        if (\WikiaPageType::isMainPage()) {
            return $this->titleMainPage();
        } else if (in_array($this->namespace, \BodyController::getUserPagesNamespaces())) {
            return $this->titleUserPages();
        } else if ($this->MWTitle->isTalkPage() || $this->shouldNotDisplayNamespacePrefix($this->namespace)) {
            return htmlspecialchars( $this->wg->Title->getText() );
        }

        return $app->getSkinTemplateObj()->data['title'];
    }

    private function handlePrefix() {
        if ($this->MWTitle->isTalkPage()) {
            return $this->wg->ContLang->getNsText(NS_TALK);
        }

        return null;
    }


    /**
     * @return bool
     */
    private function shouldNotDisplayNamespacePrefix($namespace): bool {
        return in_array($namespace,
            array_merge(self::PREFIX_LESS_NAMESPACES, $this->wg->SuppressNamespacePrefix)
        );
    }


    /**
     * @return string
     */
    private function titleUserPages() {
        $title = explode(':', $this->title, 2); // User:Foo/World_Of_Warcraft:_Residers_in_Shadows (BAC-494)
        if (count($title) >= 2 && $this->wg->Title->getNsText() == str_replace(' ', '_', $title[0])) // in case of error page (showErrorPage) $title is just a string (cannot explode it)
            $this->title = $title[1];

        return 'UserPage!';
    }

    /**
     * @return string
     */
    private function titleMainPage(): string {
        return wfMessage('oasis-home')->escaped();
    }
}