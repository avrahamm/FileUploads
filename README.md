# FileUploads

There is a file uploads application.

<b>Steps to reproduce</b>.
 git clone https://github.com/avrahamm/FileUploads.git
 cd FilesUploads
 composer install
 cp .env.example .env
 php artisan key:generate
 php artisan migrate
 
 Create DB and priveleged user,
 Open .env file and set your DB credentials,
for example:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ewave
DB_USERNAME=avraham
DB_PASSWORD=123456

I worked on Windows with XAMP, and configured virtual host - you can make your choise.

## Description:
<p>
There is laravel application uses Laravel out of the box authentication system.
There is Uploads Form page and Uploads List page with download links.
Files are uploaded on Uploads Form page, encrypted and saved in DB.
Files may be downloaded from Uploads List page.
File names and file types are restricted to rules to keep the app secure.

</p>
