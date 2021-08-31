<h1 align="center">
AESEncryptor
</h1>
<h3 align="center">
Demo: <a href="http://aes.ibrahimgad.com/">http://aes.ibrahimgad.com/</a>
</h3>

## Usage
### After cloning the repo

- Run `composer install`.
- If no `.env` was created, create one from `.env.example`.
- Run `php artisan storage:link` to link storage in public.
- Run `php artisan key:generate` to make sure there is an APP_KEY in .env.
- Set  QUEUE_CONNECTION=database in .env.
- Run `php artisan migrate`.
- Either put the project in document root ot run `php artisan serve`.
- Edit APP_URL, ASSET_URL and database details in .env according the run method you choose (internal serve vs another web server).  
- In case of laravel internal server set ASSET_URL same as APP_URL otherwise set it as APP_URL`/public`
- Run and leave running `php artisan queue:work`
- Run and leave running `php artisan schedule:work`
- Open a browser and test.
