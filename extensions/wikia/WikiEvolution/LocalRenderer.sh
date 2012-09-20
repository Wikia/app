
echo "Set Wiki name : "
read wikiname
echo "Set file extension : "
read extension
echo "Set picture resolution (WIDTHxHEIGHT) : "
read resolution



gource -$resolution --log-format custom $wikiname/gource.log --seconds-per-day 0.00001 --auto-skip-seconds 0.0001 --multi-sampling --stop-at-end --elasticity 0.1 -b 000000  --hide filenames,dirnames,progress --user-friction .2 --background-image background_logo.png --logo  $wikiname/wordmark.png --user-image-dir $wikiname/avatars -s 3  --output-ppm-stream - --output-framerate 60 | avconv -y -r 60 -f image2pipe -vcodec ppm -i - -b 8192K $wikiname/$wikiname.$extension



echo "Done."

