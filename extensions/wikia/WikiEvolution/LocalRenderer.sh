#!/bin/sh

echo "Set Wiki name : "
read wikiname

echo "Running gource..."
xvfb-run -a -s "-screen 0 1360x768x24" ./LocalRendererDo.sh $wikiname

echo "Done."
