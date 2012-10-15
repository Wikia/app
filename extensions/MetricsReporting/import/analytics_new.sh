clear
cd /a/analytics
# rm *test*.csv
# mysql  --user=root --password=changerootwhenpriyankareturns < analytics_create_and_load_from_csv.txt > mysql_log.txt
  mysql  -u analytics -h project2.wikimedia.org -preport < analytics_create_and_load_from_csv.txt > mysql_log.txt
