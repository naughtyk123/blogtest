<h1>How to SetUp</h1>
<br>
<ul>
    <li>
        first remove .example from .env.example
        and change db name and pass word to your preference
    </li>
    <li>
        then run a composer install 
    </li>
    <li>
        if .env dont have a key run php artisan key:generate
    </li>
    <li>
        then vender publish  "php artisan vendor:publish --all"
    </li>
    <li>
        then run "php artisan migrate"
    </li>
    <li>
        then run "php artisan db:seed CategorySeeder"
    </li>
    <li>
        now run php artisan serve and coppy the url and enter it in browser
    </li>
    <l
</ul>

