DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

PROD_USER=`cat /usr/wikia/docroot/DB.sjc-dev.yml | grep user | awk 'BEGIN {FS=" "}{print $2}' | head -2 | tail -1`
PROD_PASS=`cat /usr/wikia/docroot/DB.sjc-dev.yml | grep password | awk 'BEGIN {FS=" "}{print $2}' | head -2 | tail -1`

DEV_USER=`cat ../syncDevData.php | grep "wgDBdevboxUser =" | awk 'BEGIN {FS=" "}{print $3}' | tr -d "'" | tr -d ";"`
DEV_PASS=`cat ../syncDevData.php | grep "wgDBdevboxUser =" | awk 'BEGIN {FS=" "}{print $3}' | tr -d "'" | tr -d ";"`

echo "Coping data from production servers"
mysqldump -u $PROD_USER -p$PROD_PASS -h 10.8.42.20 --databases video151 | mysql -u $DEV_USER -p$DEV_PASS -h 10.8.36.112
echo "Video copied from production"

cd $DIR
sh doAll.sh 298117 | tee legonxt.log.txt