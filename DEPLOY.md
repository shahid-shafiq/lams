## Deploying the application to Namecheap

Create a compressed app.zip package.
Log into Namecheap account open cPanel.
Go to FileManager from cPanel.
Upload the app.zip to home location.
Extract to /home/ [lams8].
Files will be extracted into /home/app.
Copy app/public_html folder.

## Edit index.php
- **Register The Auto Loader**
Update the location of the autoloader as follows:
require __DIR__.'/../../<app>/vendor/autoload.php';

- **Turn On The Lights**
Update the location in the $app variable as follows:
$app = require_once __DIR__.'/../../<app>/bootstrap/app.php';

## Update configuration
- **DB settings in the .env file**
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=akqimljs_cake818
DB_USERNAME=akqimljs_cake818
DB_PASSWORD=6(cf07peS]

- **Modify config/app.php file**
'url' => env('APP_URL', 'https://akqisb.org/<app>'),

**==========================**
**It should work as expected**
**==========================**
