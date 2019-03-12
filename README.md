# Twitch Notes
<img src="http://glacial-coast-30412.herokuapp.com/images/laravel.png" width="100"><img src="http://glacial-coast-30412.herokuapp.com/images/vue.png" width="100"><img src="http://glacial-coast-30412.herokuapp.com/images/twitch.png" width="100">

## Project deployed
[Twitch notes deployed on heroku](http://glacial-coast-30412.herokuapp.com)

## Project tech stack
The application was made with Laravel and Vue.js. The Backend of the platform was designed with Laravel and the notes management was made with Vue.js, this frontend framework allows interaction with the application without reloading the page, so the live stream isn’t reloaded and interrupted.


`Laravel 5.8` for backend.

`Vue.js 2.6.8` for notes management components.

`Bulma 0.7.4` for frontend as css framework.

`PostgreSQL 11` as database.

`AWS S3` for images storage.

## Project motivations
This application was designed as proof of concept to explore the integration of Laravel and Twitch API. The application pretends to fulfill some users needs, since there are a lot of tools for streamers but not enough for content consumers.

## Project description
Twitcher Notes is an application where you can create personal notes during live streams of your favorite streamers. You can add the nickname of your favorites streamers and then you are going to be able to add notes while you are watching the live stream, these notes are going to take a screenshot of the livestream to display it as a card. You can revisit your ideas and comments created during streams for education, analysis, or entertainment purposes.

Currently Twitch allows streamers to create markers so they can highlight moments during live streaming, so this application intends to allow the consumers do the same.

The goal is to display created notes on stored videos, so you can see each note appearing during the exact time where you created it during live stream. 

### Features/Sections
* You require a Twitch account to login.
* Once logged you are going to see a form where you can add a streamer nickname.
* Streamers added are going to be displayed on a table under the form.
* On the left side of the table you can see the avatar and nickname of the streamer.
* If the streamer is live streaming right now you are going to see a green icon with a camera.
* On the right side you are going to see a yellow icon with the number of notes created.
* A button to delete the streamer is going to be available. 
* On the right side of the page, you are going to see the 10 latest notes created if any.
* If you click the streamer’s nickname you are going to be redirected to the single page for the streamer.
* On streamer's page the live stream and chat are going to be displayed.
* Below you are going to see notes created for the streamer.
* On the right side the 10 latest videos stored representing the latest events streamed.

![Application running](http://glacial-coast-30412.herokuapp.com/images/twitch-notes-ss.png)

![Streamer page](http://glacial-coast-30412.herokuapp.com/images/twitch-streamer.png)

### Limitations
Twitch API has some limitations. There is no way to link the current live stream with the video that is going to be stored for the stream, a workaround to this limitation is to assume that latest video created is the video for the stream, but this only works if the streamer has activated 'Archive broadcasts' option.

Another limitation is the Screenshot retrieved from the stream when a note is created because isn't taken at the current time, it is cached like 10 minutes so the image of the note doesn't really represents the moment when the note was created.

## Next steps
* Link note with stored video.
* Add notes to past events.
* Create marker before adding text to the note, so the time of creation will be more accurate.
* Search and paginate notes.
* Watch stored videos with notes popping up at the time it was created during stream.
* Share notes with friends: this feature requires more social network functionalities such as connect users.

## How to run the project
Make sure you have installed `composer`, `npm` and `Node.js`, also a database server running like `PostgreSQL` or `MySQL`.

```
# Install Laravel dependencies
composer install

# Set env vars
cp .env.example .env

# Create tables in databse
php artisan migrate

# install app JS package dependencies
npm install

# Run Vue on developer mode
npm run dev

# Go to http://localhost to see the app running
```

## Architecture
The proposed architecture for the platform on AWS is as follows:

![AWS Architecture](http://glacial-coast-30412.herokuapp.com/images/tnotes.jpg)

## Scaling the platform
With a lot of traffic and requests the load to the EC2 instances could be very costly and pron to failure. To scale going, for example, from 100 reqs/day to 900MM reqs/day over 6 months, a good approach could be creating a serverless architecture using AWS Lambda functions, saving a lot of resources and with the advantage of auto escaling. To create lambdas we could use Lumen, a lighter version of laravel. The frontend could be developed entirely with Vue.js and stored on S3 as static files, to save procesing resources.
