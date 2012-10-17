#!/bin/sh

wikiname=$1

resolution=1360x720
seconds_per_day=0.01
auto_skip_seconds=0.1
elasticity=0.05
framerate=25
bitrate=4000K
extension=avi

gource -$resolution --log-format custom $wikiname/gource.log --seconds-per-day $seconds_per_day --auto-skip-seconds $auto_skip_seconds --multi-sampling --stop-at-end --elasticity $elasticity -b 000000  --hide filenames,dirnames,progress --user-friction .2 --background-image background_logo.png --logo  $wikiname/wordmark.png --user-image-dir $wikiname/avatars --output-ppm-stream - --output-framerate $framerate | avconv -y -r $framerate -f image2pipe -vcodec ppm -i - -b $bitrate $wikiname/$wikiname.$extension
