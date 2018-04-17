#!/bin/bash

dir=$1

./vendor/bin/php-cs-fixer fix $dir --level=psr2 --fixers=-psr0,no_empty_lines_after_phpdocs,no_blank_lines_after_class_opening,operators_spaces,phpdoc_params,phpdoc_scalar,unused_use,align_double_arrow,multiline_array_trailing_comma,list_commas,phpdoc_separation,single_quote
