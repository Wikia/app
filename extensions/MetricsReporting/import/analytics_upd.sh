clear
cd /a/analytics

./analytics_generate_csv_files.sh

mysql  -u analytics -h project2.wikimedia.org -preport < analytics_refresh_from_csv.txt
