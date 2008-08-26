#!/bin/bash

#
# Adjust the paths and issue the following command first!
#
# ogrinfo -summary -ro gltp:/vrf/home/daniel/vmap/v0soa/vmaplv0/soamafr > summary.info

for file in $( cat summary.info )
do
  emit=${file%@*}

  echo HALLO
  echo "generating layer" $file "emit" $emit

  rm one.shp two.shp tre.shp for.shp
  ogr2ogr one.shp gltp:/vrf/home/daniel/vmap/v0noa/vmaplv0/noamer "$file" -nln "$emit" "$file"
  ogr2ogr two.shp gltp:/vrf/home/daniel/vmap/v0soa/vmaplv0/soamafr "$file" -nln "$emit" "$file"
  ogr2ogr tre.shp gltp:/vrf/home/daniel/vmap/v0eur/vmaplv0/eurnasia "$file" -nln "$emit" "$file"
  ogr2ogr for.shp gltp:/vrf/home/daniel/vmap/v0sas/vmaplv0/sasaus "$file" -nln "$emit" "$file"

  echo "merging $emit"

  rm "shp/$emit.shp"
  ogr2ogr "shp/$emit.shp" one.shp -nln "$emit" one
  ogr2ogr -update -append "shp/$emit.shp" two.shp -nln "$emit" two -nln "$emit" "$file"
  ogr2ogr -update -append "shp/$emit.shp" tre.shp -nln "$emit" tre -nln "$emit" "$file"
  ogr2ogr -update -append "shp/$emit.shp" for.shp -nln "$emit" for -nln "$emit" "$file"

  echo "done $file"
  # ogr2ogr -f PostgreSQL PG:dbname=vmap0 "$emit.shp" -lco OVERWRITE=yes
done

