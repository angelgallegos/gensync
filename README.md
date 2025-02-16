# Genpo Async Synchronizer

## Prerequisites
This is a laravel project, some preliminary steps are required:

Install dependencies:

`composer install`

Migrations:

`php artisan migrate`

Seeding data:

`php artisan db:seed --class=ConfigurationSeeder`

The project is also dockerized as to not have to install required tools, languages, etc.

Run containers:

`docker compose up`

## Concept
The idea behind this project is to create the data in the generic project in an async way as such there are 2 queues that will handle
the data syncing one item at a time and another to handle the attaching of a contact to a profile.

Given the previous there is the need to have a queue listener active:

`php artisan queue:listen database`

*Note: In this case the queue driver is the database, so the migration is included, but can be changed to any of the available drivers in laravel(Amazon SQS, Redis, Beanstalk...)

And there are also three schedule tasks that will dispatch the corresponding jobs, so a cron that executes the laravel schedule:run command with relatively short frequency is required,
but for the purpose of testing this also can be achieved with the next bash command :):

`while true; do php artisan schedule:run; sleep 60; done`

Once the queues are listening and the scheduled task running the actual process of syncing the data can be started by importing the data on the csv files:

`php artisan import:data {dataType} {absolutePath}`

Where the `dataType` param can be one of: `company`, `contacts` and the `absolutePath` should be the absolute path to the csv file(e.g."/path/to/{csv}.csv")

In the dockerized env those file are mounted to the folder: /var/www/data

And that is it, the task and queues should then pick the imported data and sync it to Genpo. 


### Note
The Genpo token and channel_id are not included, can be set on .env file with keys: `GENPO_TOKEN`, `GENPO_CREATE_CONTACT_CHANNEL_ID`

.env.example file included
