<?php

if ( !defined( 'MEDIAWIKI' ) ) {
        die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$wgMathStatFunctionsMagic = array();

$wgMathStatFunctionsMagic['en'] = array(
        'const'         => array( 0, 'const' ),
        'median'        => array( 0, 'median' ),
        'mean'          => array( 0, 'mean' ),
        'exp'           => array( 0, 'exp' ),
        'log'           => array( 0, 'log' ),
        'ln'            => array( 0, 'ln' ),
        'tan'           => array( 0, 'tan' ),
        'atan'          => array( 0, 'atan', 'arctan' ),
        'tanh'          => array( 0, 'tanh' ),
        'atanh'         => array( 0, 'atanh', 'arctanh' ),
        'cot'           => array( 0, 'cot' ),
        'acot'          => array( 0, 'acot', 'arccot' ),
        'cos'           => array( 0, 'cos', ),
        'acos'          => array( 0, 'acos', 'arccos' ),
        'cosh'          => array( 0, 'cosh', ),
        'acosh'         => array( 0, 'acosh', 'arccosh' ),
        'sec'           => array( 0, 'sec' ),
        'asec'          => array( 0, 'asec', 'arcsec' ),
        'sin'           => array( 0, 'sin' ),
        'asin'          => array( 0, 'asin', 'arcsin' ),
        'sinh'          => array( 0, 'sinh' ),
        'asinh'         => array( 0, 'asinh', 'arcsinh' ),
        'csc'           => array( 0, 'csc' ),
        'acsc'          => array( 0, 'acsc', 'arccsc' ),
);
