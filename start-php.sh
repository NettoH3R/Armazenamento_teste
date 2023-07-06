#!/bin/bash
echo "upload_max_filesize = 100M" >> /etc/php/8.2/cli/php.ini
echo "post_max_size = 100M" >> /etc/php/8.2/cli/php.ini
apache2-foreground