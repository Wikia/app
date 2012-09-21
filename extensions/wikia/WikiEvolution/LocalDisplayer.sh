
echo "Set Wiki name : "
read wikiname


resolution=1360x720
seconds_per_day=0.01
auto_skip_seconds=0.1
elasticity=0.05


gource -$resolution --log-format custom $wikiname/gource.log --seconds-per-day $seconds_per_day --auto-skip-seconds $auto_skip_seconds --multi-sampling --stop-at-end --elasticity $elasticity -b 000000  --hide filenames,dirnames,progress --user-friction .2 --background-image background_logo.png --logo  $wikiname/wordmark.png --user-image-dir $wikiname/avatars



echo "Done."

