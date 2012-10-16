#!/bin/sh

echo "Set Wiki name : "
read wikiname

resolution=1360x720
seconds_per_day=0.01
auto_skip_seconds=0.1
elasticity=0.05
framerate=25
bitrate=4000K
extension=avi

echo "Running gource..."
xvfb-run -a -s "-screen 0 1360x768x24" gource -$resolution --log-format custom $wikiname/gource.log --seconds-per-day $seconds_per_day --auto-skip-seconds $auto_skip_seconds --multi-sampling --stop-at-end --elasticity $elasticity -b 000000  --hide filenames,dirnames,progress --user-friction .2 --background-image background_logo.png --logo  $wikiname/wordmark.png --user-image-dir $wikiname/avatars --output-ppm-stream $wikiname/$wikiname.ppm --output-framerate $framerate

echo "Generating movie..."
avconv -y -r $framerate -f image2pipe -vcodec ppm -i $wikiname/$wikiname.ppm -b $bitrate $wikiname/$wikiname.$extension

echo "Done."
