<?php

function foo() {
    echo "inside of foo\n";
    return true;
}

function bar() {
    echo "inside of bar\n";
    return true;
}

if ( foo() || bar() ) {
    echo "inside of the if statement\n";
}
