
## Currency converter

This is the submission of the technical test. Thanks for your time.

## Running the app

Open the project directory and run:  
 
`docker-compose up -d --build`  

This will build the necessary images for the web server and databases. 
We have 3 containers running: web server, database and test database.

Copy the env values. `cp .env.example .env` I've added the correct values for both of the databases so there shouldn't be any problems running it.

Run `docker-compose exec web`. You'll have a terminal within the web container, then run `composer install` to install all the dependencies. Run `php artisan migrate` as well.

Get back to the project directory and run:  `php artisan key:generate`

## Testing database
The testing databases runs in a separate container. You'll need to do a migration first before running any tests. 
`php artisan migrate --database=testing`.

When running tests cd into the web container with `docker-compose exec web`

## Some considerations
I wasn't exactly sure about the exact logic behind the 'favorites' editing functionality.

It didn't make sense to me to update the exchange values using today's rate from a user perspective as that would simply be sort of like using the main form.
So I've used a historical rates endpoint from floatrates as well to use the rates at that date.

e.g. 
`GBP 1, EUR 1.08, Rate 1.08, 2020-09-01`

If I edit this on 2020-09-10 and change the target currency to USD it will use the GBP/USD rate as it was on 2020-09-01. Though, this may not be the correct interpretation.

Perhaps only the actual conversion amount can be changed, but it wasn't clear what _individual favourites values_ meant in the doc. 
My assumption was all of them including the base/target currencies.




