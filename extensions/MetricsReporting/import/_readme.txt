This folder contain bash and perl files to create and fill database 'analytics', a.o. for monthly dashboard.

== analytics_new.sh ==
Defines the database and tables and loads data from existing csv files.
It executes SQL from analytics_create_and_load_from_csv.txt

== analytics_upd.sh ==
Prepares new csv files (delegated to analytics_generate_csv_files.sh),
and empties/reloads all tables for which csv files are in this folder.   
It executes SQL from analytics_refresh_from_csv.txt

== CSV files ==
CSV files and where they are generated:

analytics_in_binaries.csv          <- AnalyticsPrepBinariesData.pl
analytics_in_comscore.csv          <- AnalyticsPrepComscoreData.pl                
analytics_in_comscore_regions.csv  <- manual
analytics_in_language_names.csv   
analytics_in_offline.csv           <- manual
analytics_in_page_views.csv        <- /home/ezachte/wikistats/pageviews_monthly.sh (file copy after that)
analytics_in_wikistats.csv         <- AnalyticsPrepWikiCountsOutput.pl
