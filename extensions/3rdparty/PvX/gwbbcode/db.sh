#!/bin/bash
rm -rf pvx_db_1.php
rm -rf pvx_db_2.php
wget http://dev.rb.no/theme/pvx_db_1.php
wget http://dev.rb.no/theme/pvx_db_2.php
rm -rf skill_db_1.php
rm -rf skill_db_2.php
mv pvx_db_1.php skill_db_1.php
mv pvx_db_2.php skill_db_2.php

