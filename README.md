# Twitch Notes
<img src="http://glacial-coast-30412.herokuapp.com/images/laravel.png" width="100"><img src="http://glacial-coast-30412.herokuapp.com/images/vue.png" width="100"><img src="http://glacial-coast-30412.herokuapp.com/images/twitch.png" width="100">

## Project deployed
[Twitch notes deployed on heroku](http://glacial-coast-30412.herokuapp.com)

## Project tech stack
The application was made with Laravel and Vue.js. The Backend of the platform was designed with Laravel and the notes management was made with Vue.js, this frontend framework allows interaction with the application without reloading the page, so the live stream isn’t reloaded and interrupted.

* `Laravel 5.8` for backend.
* `Vue.js 2.6.8` for notes management components.
* `Bulma 0.7.4` for frontend as css framework.
* `PostgreSQL 11` as database.
* `AWS S3` for images storage.

## Project motivations
This application was designed as proof of concept to explore the integration of Laravel and Twitch API. The application pretends to give stream consumers a tool, since there are a lot of tools for streamers but not enough for content consumers. Currently Twitch allows streamers to create markers so they can highlight moments during live streaming, so this application intends to allow consumers do the same.

## Project description
Twitcher Notes is an application where you can create personal notes during live streams of your favorite streamers. By adding the nickname of your favorites streamers you are going to be able to add a time markers with a note and a stream screenshot while you are watching the live stream. You can revisit your ideas and comments created during streams for education, analysis, or fun.

The final goal is to display created notes on stored videos, so you can see each note popping up on reruns during the exact time where you created it during live stream. 

### Features
These are the current features and sections developed:

* Log in using your twitch account.
* Form to add a streamer nickname.
* List of streamers added.
* Display avatar and nickname of the streamer.
* Display a green icon with a camera if the streamer is live streaming.
* Display yellow icon with the number of notes created.
* Delete the streamer. 
* Display 10 latest notes created if any.
* Go to the single page for the streamer through the streamer link.
* Display the live stream and chat of the streamer.
* Form to create notes.
* Display cards for each note with edit and delete options.
* Display the 10 latest videos stored representing the latest events streamed.

#### Main page
![Application running](http://glacial-coast-30412.herokuapp.com/images/twitch-notes-ss.png)

#### Streamer page
![Streamer page](http://glacial-coast-30412.herokuapp.com/images/twitch-streamer.png)

### Limitations
Twitch API has some limitations. There is no way to link the current live stream with the video that is going to be stored for the stream, a workaround to this limitation is to assume that latest video created is the video for the stream, but this only works if the streamer has activated 'Archive broadcasts' option.

Another limitation is that the screenshot retrieved from the stream when a note isn't taken at the current time, it is cached like 10 minutes so the image of the note doesn't really represent the moment when the note was created.

## How to run the project
Make sure you have installed `composer`, `npm` and `Node.js`, also a database server running like `PostgreSQL` or `MySQL`.

```
# Install Laravel dependencies
composer install

# Set env vars
cp .env.example .env

# Create tables in the database
php artisan migrate

# install app JS package dependencies
npm install

# Run Vue on developer mode
npm run dev

# Go to http://localhost to see the app running
```

## Next steps
This project is a WIP so here you can find listed some future features:

* Link note during live stream to related stored video.
* Add notes to past events.
* Create a marker before adding text to the note, so the time of creation will be more accurate.
* Search and paginate notes.
* Watch stored videos with notes popping up at the time it was created during stream.
* Share notes with friends: this feature requires more social network functionalities such as connect users.

## Architecture and scaling
The considerations for the proposed architecture are taking into account the finished application with all future features finished (see Next steps) and the application going from 100 reqs/day to 900MM reqs/day over 6 months. 

AWS services like EC2 and AuroraDB have the advantage of auto scaling, so everytime the demand of your application increases, services can scale automatically. Additionally With services like a CDN and load balancers, scaling a platform has become an easy task.

Elasticsearch is used to make faster indexing and search, but it can provoke a possible bottleneck during the writing process, so for that reason SQS is used through a lambda function, to avoid the insertion in Aurora to be delayed by inserting and indexing in Elasticsearch.

The proposed architecture for production on AWS is as follows:

![AWS Architecture](http://glacial-coast-30412.herokuapp.com/images/tnotes-arch.png)

## Conclusions
Since this was a PoC for the technical feasibility, the idea is yet to be validated with users to know if they would use a tool like this. The gaming and streaming industry is still growing and evolving, so some new discoveries could be made by experimenting.
