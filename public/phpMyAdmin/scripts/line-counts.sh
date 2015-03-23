#!/bin/bash
cat > js/line_counts.php <<EOF
<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * An autogenerated file that stores the line counts of javascript files
 *
 * @package PhpMyAdmin
 */

if (! defined('PHPMYADMIN')) {
    exit;
}

define('LINE_COUNTS', true);
\$LINE_COUNT = array();
EOF

php_code=""
for file in `find js -name '*.js'` ; do
  lc=`wc -l $file | sed 's/\([0-9]*\).*/\1/'`
  file=${file:3}
  entry="\$LINE_COUNT[\"$file\"] = $lc;"
  php_code="$php_code\n$entry"
done
echo -e $php_code >> js/line_counts.php
