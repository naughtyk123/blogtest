<h1>How to SetUp</h1>
<br>
<ul>
    <li>
        first remove .example from .env.example
    </li>
    <li>
        then run a composer install 
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
</ul>

