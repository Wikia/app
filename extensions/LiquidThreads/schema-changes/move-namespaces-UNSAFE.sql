-- This schema change is seriously scary. Don't run it unless you know what you're doing!
-- It assumes that the LiquidThreads namespaces are namespaces 16-19, and that you want
--  to move your data from those ones to namespaces 90-93.

update page set page_namespace=90 where page_namespace=16;
update page set page_namespace=91 where page_namespace=17;
update page set page_namespace=92 where page_namespace=18;
update page set page_namespace=93 where page_namespace=19;
