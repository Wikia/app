# this should be run from lib/Swagger/ AFTER generating code

rm -rf test/ docs/Api/ docs/Model/ LICENSE ../LICENSE .travis.yml autoload.php git_push.sh .php_cs composer.json phpunit.xml.dist README_*
git checkout -- README.md
