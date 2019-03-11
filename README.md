# Twitch Notes
![](http://glacial-coast-30412.herokuapp.com/images/laravel.png | width=100)
![](http://glacial-coast-30412.herokuapp.com/images/vue.png | width=100)

![](http://glacial-coast-30412.herokuapp.com/images/twitch.png | width=100)

## Project deployed
[Twitch notes deployed on heroku](http://glacial-coast-30412.herokuapp.com)

## Project tech stack
Laravel 5.8

Vue.js 2.6.8

## Project motivations
To explore the integration of Laravel and Twitch API, an application was designed and developed to work as proof of concept. The idea was designed to fulfill users needs, since there are a lot of tools for streamers but not enough for consumers.

## Project description
Twitcher Notes is an application where you can create personal notes during live streams of your favorite streamers. You just have to add the nickname of your favorites streamers and then you are going to be able to add notes while you are watching the live stream. You can revisit your ideas and comments created during streams for education, analysis or entertainment purposes.

Currently Twitch allows streamers to create markers so they can highlight moments during live streaming, so this application intends to allow the consumers do the same.

The goal is to display created notes on stored videos, so you can see each note appears during the exact time where you created it during live stream. Twitch API has some limitations making hard to achieve this goal. One limitation found was that there is no way to link the current live stream with the stored video that is going to be created for the stream, one workaround to this limitation is to assume that latest video created is the video for the stream, but this is only going to work if streamer has activated the storing streams feature.

The applications requires that user has a Twitch account to login it, once logged you are going to see a form where you can add a streamer nickname, once added it’s going to be displayed on a streamers table, on the left side you can see the avatar and nickname of the streamer, if the streamer is live streaming right now you are going to see a green icon with a camera; on the right side you are going to see a yellow icon with the number of notes created, and finally a button to delete the streamer. On the right side of the page, you are going to see the 10 latest notes created if any.

If you click the streamer’s nickname you are going to be redirected to the single page for the streamer, where the live stream and chat is going to be displayed, below you are going to see notes created for the streamer and on the right side the 10 latest videos stored representing the latest events streamed of the streamers.

The notes management was made with Vue.js, since this frontend framework allows to interact withe the application without reloading the page, so the live stream isn’t interrupted.

![Application running](http://glacial-coast-30412.herokuapp.com/images/twitch-notes-ss.png)

## Next steps
Link note with stored video.
Create marker before adding text to the note, so the time of creation will be more accurate.
Watch stored videos with notes popping up at the time it was created during stream.
Share notes with friends: this feature requires more social network functionality such as connect users.

## To run the project
Make sure you have installed `composer`, `npm` and `Node.js`, also a database server running like `MySQL`.

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
