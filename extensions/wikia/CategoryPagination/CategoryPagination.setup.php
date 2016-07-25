<?php

// Autoload Category Page classes
$wgAutoloadClasses[ 'CategoryPaginationPage' ] = __DIR__ . '/CategoryPaginationPage.class.php';
$wgAutoloadClasses[ 'CategoryPaginationViewer' ] = __DIR__ . '/CategoryPaginationViewer.class.php';
$wgAutoloadClasses[ 'CategoryPaginationHooks' ] = __DIR__ . '/CategoryPaginationHooks.class.php';

// Hooks
$wgHooks['ArticleFromTitle'][] = 'CategoryPaginationHooks::onArticleFromTitle';
$wgHooks['CategoryViewerGetSectionPagingLinks'][] = 'CategoryPaginationHooks::onCategoryViewerGetSectionPagingLinks';
