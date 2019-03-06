#!/bin/bash

CMD="SERVER_ID=177 php -d display_errors migrateImagesToGcsForWikis.php --wiki-prefix=ciachouploads --dry-run"
echo -e "\t$CMD"
$CMD

