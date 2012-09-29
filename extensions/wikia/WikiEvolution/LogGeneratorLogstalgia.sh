
echo "Set Wiki id : "
read wiki_id

SERVER_ID=$wiki_id php EvolutionLogstalgiaMaintenance.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php
