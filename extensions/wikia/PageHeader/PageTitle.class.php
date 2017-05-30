<?php

namespace PageHeader;

class PageTitle {

    /* @var string */
    private $title;

    /* @var \WikiaGlobalRegistry */
    private $wg;

    /* @var int */
    private $namespace;

    /**
     * @param \WikiaApp $app
     */
    public function __construct($app) {
        $this->wg = $app->wg;

        $this->title = $app->getSkinTemplateObj()->data['title'];
        $this->namespace = $this->wg->Title->getNamespace();
    }

    /**
     * @return string
     */
    private function titleSpecial() {
        return $this->title;
    }

    /**
     * @return string
     */
    private function titleArticle() {
        // remove namespaces prefix from title
        $namespaces = [ NS_MEDIAWIKI, NS_TEMPLATE, NS_CATEGORY, NS_FILE ];

        if (
            in_array( $this->namespace,
                array_merge( $namespaces, $this->wg->SuppressNamespacePrefix )
            )
        ) {
            $title = $this->wg->Title->getText();
        }

        return $this->title;
    }

    /**
     * @return string
     */
    private function titleForum() {
        return $this->wg->Title->getText();
    }

    /**
     * @return string
     */
    private function titleUserPages() {
        $title = explode( ':', $this->title, 2 ); // User:Foo/World_Of_Warcraft:_Residers_in_Shadows (BAC-494)
        if ( count( $title ) >= 2 && $this->wg->Title->getNsText() == str_replace( ' ', '_', $title[0] ) ) // in case of error page (showErrorPage) $title is just a string (cannot explode it)
            $this->title = $title[1];

        return 'UserPage!';
    }

    /**
     * @return string
     */
    private function titleMainPage() {
        return wfMessage( 'oasis-home' )->escaped();
    }

    /**
     * @return string
     */
    private function titleTalkPage() {
        $title = \Xml::element( 'strong', [ ], $this->wg->ContLang->getNsText( NS_TALK ) . ':' );
        $title .= htmlspecialchars( $this->wg->Title->getText() );

        return $title;
    }

    /**
     * @return string
     */
    public function __toString() {

        if ( \WikiaPageType::isMainPage() ) {
            return $this->titleMainPage();
        }

        if ( in_array( $this->namespace, \BodyController::getUserPagesNamespaces() ) ) {
            return $this->titleUserPages();
        }

        if ( $this->wg->Title->isTalkPage() ) {
            return $this->titleTalkPage();
        }

        switch ($this->namespace) {
            case NS_SPECIAL:
                return $this->titleSpecial();
            default:
                return $this->titleArticle();
        }
    }
}