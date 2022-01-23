<html>

<head>
    <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.6/build/pure-min.css" integrity="sha384-Uu6IeWbM+gzNVXJcM9XV3SohHtmWE+3VGi496jvgX1jyvDTXfdK+rfZc8C1Aehk5" crossorigin="anonymous">
    <!-- Include local copy of noSleep code from https://github.com/richtr/NoSleep.js 
to ensure browser window on deck device stays awake.
I need to reference the license I think, I'm new at this -->
    <script src="noSleep.min.js"></script>
</head>

<body>

    <div>


        <style scoped="">
            .button-success,
            .button-error,
            .button-warning,
            .button-secondary {
                color: white;
                border-radius: 4px;
                text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
            }

            .button-success {
                background: rgb(28, 184, 65);
                /* this is a green */
            }

            .button-error {
                background: rgb(202, 60, 60);
                /* this is a maroon */
            }

            .button-warning {
                background: rgb(223, 117, 20);
                /* this is an orange */
            }

            .button-secondary {
                background: rgb(66, 184, 221);
                /* this is a light blue */
            }

            .button-xsmall {
                font-size: 70%;
            }

            .button-small {
                font-size: 85%;
            }

            .button-large {
                font-size: 110%;
            }

            .button-xlarge {
                font-size: 250%;
                width: 100%;
                height: 10%;
            }
        </style>
        <span>SCENES</span>
        <div id="scenes">
            <button class="scene button-success pure-button button-xlarge" value="Profile">PROFILE</button><br />
            <button class="button-error pure-button button-xlarge" value="Chat">CHAT</button><br />
            <button class="button-warning pure-button button-xlarge" value="Game">GAME</button><br />

        </div>
        <span>MEDIA</span>
        <div id="media">
            <button class="scene button-success pure-button button-xlarge" command="play" param="greg.wav">Greg</button><br />
            <button class="button-error pure-button button-xlarge" command="play" param="coffee.wav">Coffee</button><br />
            <button class="button-warning pure-button button-xlarge" command="play" param="laugh.wav">Laugh</button><br />
            <button class="button-warning pure-button button-xlarge" command="video" param="rr.mp4">Rick</button><br />
        </div>


        <script>
            //get query parameters from URL
            var urlParams = new URLSearchParams(window.location.search);
            var streamID = urlParams.get('streamID');


            var noSleep = new NoSleep();

            function enableNoSleep() {
                noSleep.enable();
                document.removeEventListener('touchstart', enableNoSleep, false);
            }

            // Enable wake lock.
            // (must be wrapped in a user input event handler e.g. a mouse or touch handler)
            document.addEventListener('touchstart', enableNoSleep, false);


            const scenes = document.getElementById('scenes');
            scenes.addEventListener("click", function(event) {
                const isButton = event.target.nodeName === 'BUTTON';
                if (isButton) {
                    scene = event.target.value;
               

                    changeScene(scene, streamID);
                }

            });


            const media = document.getElementById('media');
            media.addEventListener("click", function(event) {
                const isButton = event.target.nodeName === 'BUTTON';
                if (isButton) {
                    //scene = event.target.value;

                    var command = event.target.getAttribute("command");
                    var param = event.target.getAttribute("param");
                  

                    playMedia(command, param, streamID);
                }

            });

            function changeScene(scene, streamID) {
                //ajax call to url

                const ajaxRequest = new XMLHttpRequest();
                var url = "sceneSwitcher.php?scene=" + scene + "&streamID=" + streamID;
                ajaxRequest.open("GET", url, true);
                ajaxRequest.send();


            }

            function playMedia(command, param, streamID) {
                //ajax call to url
                const ajaxRequest = new XMLHttpRequest();
                var url = "sc.php?command=" + command + "&param=" + param + "&streamID=" + streamID;
                ajaxRequest.open("GET", url, true);
                ajaxRequest.send();
            }
        </script>
    </div>

</body>

</html>