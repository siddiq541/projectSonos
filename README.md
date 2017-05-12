Read Me

The Sonos Music Service is a bespoke web based music management system for Sonos speakers, with Active Directory and Spotify integration. The three main parts of the system can be split up into it’s user management, it’s Spotify search engine, and it’s Sonos controller. It includes song recommendations based on the content added by it’s users, in order to always keep the tunes rockin’!

User Management
Register
As a first time user you will be required to register with the music system before you can use it. To do this:
Navigate to the system’s URL
Click login
Enter your Active Directory credentials
Agree to the T&Cs
Click register

You should now be redirected to the home screen. Please note, login will only work with Active Directory accounts with the correct application permissions. Please contact the system installer if you have any issues.

Login
If you have already registered your account the login should be very quick.
To do this:
Navigate to the system’s URL
Click login

You should now be redirected to the home screen.

Edit Your Account
You can edit your system display name. 
To do this, from the home page:
	Click your name on the tab above the song queue
	Edit your display name
	Click save

 To change your login details, you need to do it within Active Directory.

Edit Other Accounts
If you have Administrator privileges you can do the following to other users accounts:
	Request new users as standard or administrator accounts
	Remove accounts
	Change user display names

To do all this navigate to the manage accounts tab above the song queue.
     Spotify Search Engine

The spotify search engine talks to the spotify api to generate search results, and communicates to the sonos controller when the ‘Add to Queue’ button is pressed. 

Three Search Bars
The search engine provides three different ways to search for a song.

Search by Artist
After providing an artist name in the ‘Search by Artist’ search bar and pressing enter, the search engine will connect to spotify and provide the result as a link beneath the search bar. If you find the artist that you are searching for, press on the artist’s name (a link) and the details of the artist will be provided. Details include:

The top albums of this artist
- The albums will also be links, which provides songs in that particular album that can be added to the queue
 The recommended top songs of this artist
- There will be an ‘Add to Queue’ button at the end of each song which adds    the song to the queue 
Search by Album
After providing an album name in the ‘Search by Album’ search bar and pressing enter, the search engine will connect to spotify and provide the result as a link beneath the search bar. If you find the album that you are searching for, press on the album’s name (a link) and the details of the album will be provided. Details include:

Songs that are in that particular album, there will be an ‘Add to Queue’ button at the end of each song which adds the song to the queue 

Search by Song 
After providing a song name in the ‘Search by Song’ search bar and pressing enter, the search engine will connect to spotify and provide the result as a list beneath the search bar, with an ‘Add to Queue’ button at the end of each song which adds the song to the queue.



Sonos Controller

Queue

The Queue will display on the main page, showing at the top the current music that is playing, and also displaying the user who added the music alongside this.

If the user shows as ‘Streaming’, the song has been added by the streaming service. If the user shows as blank, the music has been added from an external source (e.g. The Official Sonos Controller). Changing the queue from another source should be avoided, as it will disrupt the integrity of which users have added which tracks. Due to this, if the Sonos queue is changed from an external source, this data will be lost.

Dashboard



The Dashboard allows you to control the Sonos speakers. You are able to play and pause music from here, as well skipping to a certain point in a track, and controlling the volume (including muting and unmuting) for all speakers or each speaker individually. The system will automatically detect your speakers to give you control to this. 

Each time a track is played, each user will have one vote. The vote will be taken into account in the streaming service when generating recommendations. If a song reaches past it’s dislike threshold, it will be skipped.

Streaming Service

If there are no songs left in the queue, the system will automatically add a song to the queue. The song is taken from a list of generated recommendations, which are based on the history of tracks that have been added by users. The frequency (number of times a song has been played) and the popularity (the votes) are taken into account. When the list of generated recommendations runs out, the system will automatically generate more.

Note: A song must initially be added to start the system, the streaming service will not function before this.

Settings

Settings can only be changed by an admin and can be found as a tab on the homepage. They include:
Dislike threshold - the number of dislikes before a song is skipped
The number of days before a track is removed from the track history (this is done every time recommendations are generated)
The name of the main Sonos controller - This can be found in the Official Sonos App, it will be the name of your original speaker. If you don’t know which one this is, any speaker on the network will still work.
Spotify Client and Secret - these are required to generate recommendations. A premium account is not needed. To get these, you will need to register your application (generaterecommendations.php must be added as a redirect url).
	
Known Bugs

Known bugs include:
Queue refresh is based on count. If a song is removed at the same time another is added, the queue may not detect a change and will not refresh.
Web browser stopping inactive windows/tabs. If the streaming service stops, it will be because the browser has stopped the service from polling for updates on the Sonos. This should not become an issue with multiple users, but if it does, try using Google Chrome.
Some songs are not available to play on the Sonos through spotify. If this song is the last one in the queue, the music will stop when the track before it finishes.



From everyone at Team 35; Keep the tunes rockin’!