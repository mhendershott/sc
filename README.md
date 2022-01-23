# Stream Commander #


> WARNING: this is very raw at the moment.  Really just in the personal proof of concept phase.
> No warranty to functionality or security is offered or should be expected.


This is a work in progress project for a custom system that allows 
video and audio to be played on a stream via a browser source in the 
OBS scene.
Additionally, this leverages the control features of the [obs-browser](https://github.com/obsproject/obs-browser)
implementation to allow commands to be sent to OBS to change scenes.

## FILES

<table>
  <tr><td>config.php.example</td><td>An example config file to hold configuration.  Should be copied to config.php</td></tr>
  <tr><td>cleanupViewers.php</td><td>To be run in a cron script to periodically clean up viewers table</td></tr>
    <tr><td>OBS_Switcher.php</td><td>Runs in OBS browser source with advanced permissions to change scenes on demand</td></tr>
    <tr><td>deck.php</td><td>example of a remote control deck web page to change scenes and play media</td></tr>
    <tr><td>functions.php</td><td>Container for general use server side functions</td></tr>
    <tr><td>getqueue.php</td><td>Server side file to get current queue for specific viewport and return JSON</td></tr>
    <tr><td>player.js</td><td>Main js file to control play and register viewers</td></tr>
    <tr><td>q.php</td><td>Runs as an OBS browser source to play content</td></tr>
    <tr><td>removeCommand</td><td>Runs server side to remove command from a queue after it has been run</td></tr>
    <tr><td>sc.php</td><td>Command ingestor.  Target for bot commands, or other calls to add commands to queue</td></tr>
      <tr><td>sceneSwitcher.php</td><td>Server Side for processing scene switch commands</td></tr>
  <tr><td>viewerRegister.php</td><td>Server Side for processing viewer registration</td></tr>
  </table> 
