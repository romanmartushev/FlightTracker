<h1>Flight Tracker</h1>
<p>Uses docker for local development</p>
<p>Uses composer and npm for package managing</p>
<h2>Development</h2>
<p>First run <code>composer install</code> then <code>npm install</code></p>
<p>Then <code>php artisan key:generate</code>. IF this does not work run <code>docker-compose up</code> then <code>docker-compose exec code php artisan key:genrate</code> then you might have to restart your containers or re-build</p>
<p>Finally <code>docker-compose up</code></p>

<p>This app uses google flights api which I believe at this moment is no loger supported. Needs to be changed in order for the app to work again.</p>