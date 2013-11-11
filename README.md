BitBox
======

BitBox is a web frontend for BitTorrent Sync.  BitBox allows you to share your btsync content on the web, using custom links.  

BitBox uses selective syncing, so only the files you're sharing are downloaded to your disk.  You can easily share files from multiple BitTorrent Sync folders.

-----
##Installation##
BitBox is a CodeIgniter web application.

In order to use BitBox, you'll need a [BitTorrent Sync API key](http://www.bittorrent.com/sync/developers).  

BitBox requires either the pecl_http library for php or mod-xsendfile for Apache. Both can easily be installed via tools like apt-get.  By default, BitBox uses mod-xsendfile - see application/controllers/download.php to switch to pecl_http.  IF you're using mod-xsendfile, be sure your BitBox virtual host has mod-xsendfile enabled.

Start by configuring BTSync on your computer.  You'll need to enable the API with your API key, and confirm that the BTSync client is accessible via the web (port 8888).

Next, create a local MySQL user and database for this application, and populate the information in application/config/database.php.  You should also fill in the top section of application/config/config.php (up through the address for your host).

Download the current release of [CodeIgniter](http://codeigniter.com) and place the system folder and index.php in the BitBox root.

Edit index.php and add the line `include_once './vendor/autoload.php';` to the top of the file.

In the BitBox root, run 
`curl -sS https://getcomposer.org/installer | php`
to install Composer.  Then run `php composer.phar install` to get the php dependencies.

Run `php -r "$(curl -fsSL http://getsparks.org/go-sparks)"` to install CodeIgniter Sparks, then run `php tools/spark install -v1.3.0 curl` to get the Sparks dependencies.

You've now got all the necessary components.  You may need to edit the .htaccess file to match your server (see the normal CodeIgniter instructions for details).

Next run `php doctrineHelper.php orm:schema-tool:create` to create the necessary MySQL tables.

You should now be able to access BitBox via the web, at "youraddress/admin" - the username and password are defined in the config.php file.

Make sure the "application/models/Proxies" folder is writeable by your web server.  

At this point, try adding a BitTorrent Sync folder - paste in the shared secret, and set the absolute path that you'd like to store the files on your server.  Be sure you've got permission to write to that folder.  You should be able to browse the files in that folder, and mark them for sharing.

When a file is shared, BitBox asks BitTorrent Sync to begin syncing.  It can take a few seconds for the download to start.  You can access the sharing URL while the file is still syncing - the download will automatically start when the sync is complete.

-----

##Questions?##

[Get In Touch!](colin@divergentmedia.com)