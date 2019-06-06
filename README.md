# FileUploads
## Description:
<p>
There is a file uploads application developped in Laravel 5.8
The application uses Laravel out of the box authentication system.  </br>
There is Uploads Form page and Uploads List page with download links.  </br>
Files are uploaded on Uploads Form page, encrypted and saved in DB.  </br>
Files may be downloaded from Uploads List page.  </br>
File names and file types are restricted to rules to keep the app secure.
The file to upload must be a file of type: pdf, doc, docx, jpeg, jpg, png, gif.
Also, File Name may contain latin alphanumeric chars and dots only without spaces!
For example, "apple3.png" is legal filename.
Yet "Insert into", "1 OR Delete * " are illegal filenames.
</p>


<b>Steps to reproduce</b>. </br>
 git clone https://github.com/avrahamm/FileUploads.git
 <p>
 cd FilesUploads
</p>
<p>
 composer install
</p>
<p>
 cp .env.example .env
</p>
<p>
 php artisan key:generate
</p>
<p>
 php artisan migrate
</p>
<p>
 
 Create DB and priveleged user, </br>
 Open .env file and set your DB credentials, </br>
for example: </br>
DB_CONNECTION=mysql  </br>
DB_HOST=127.0.0.1  </br>
DB_PORT=3306  </br>
DB_DATABASE=ewave  </br>
DB_USERNAME=avraham  </br>
DB_PASSWORD=123456  </br>

Optionally, you can replace APP_NAME=Uploads </br>

I worked on Windows with XAMP, and configured virtual host - you can make your choise.  </br>
