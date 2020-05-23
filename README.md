# WoltLab Plugin-Store: Daily download stats
With help of this little PHP-project, it's possible to track the daily downloads for all of your packages from the official WoltLab plugin-store.
Add your plugins to the database (or use `add.php`) and run daily `fetch_data.php?id=all` with help of a cronjob.

All what you need is the entry-ID of your plugin from the pluginstore, this ID can be found here: `https://pluginstore.woltlab.com/file/XXXX`

The project is based on [PaperCSS](https://www.getpapercss.com) and [CanvasJS](https://canvasjs.com) is used for generating the graphes.

## Install-guide:
* Create a new database and import the database-schema from `database.sql`
* Upload the php-files to your webspace
* Add a daily cronjob for `fetch_data.php?id=all`
* Add your plugins and have fun with the statistics
