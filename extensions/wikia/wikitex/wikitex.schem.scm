;Copyright (C) 2004 Ales Hvezda
;Modified by Peter Danenberg
;
;This program is free software; you can redistribute it and/or modify
;it under the terms of the GNU General Public License as published by
;the Free Software Foundation; either version 2 of the License, or
;(at your option) any later version.
(image-size 800 600)
(image-color "disabled")

; You need call this after you call any rc file function
(gschem-use-rc-values)

; filename is specified on the command line
(gschem-image "")

(gschem-exit)
