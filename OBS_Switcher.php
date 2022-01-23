<html>

<head>
</head>

<body>

    <script>
        function main() {
            var scene = getScenes();


        }


        //ajax call get data from 
        function getScenes() {
            const ajaxRequest = new XMLHttpRequest();
            var sceneData;
            var url = "https://ashenfieldx.live/sc/sceneSwitcher.php?streamID=AshenfieldX929239-34-DEV";
            ajaxRequest.open("GET", url, true);
            try {
                ajaxRequest.send();
                ajaxRequest.onload = function() {
                    var sceneData = JSON.parse(ajaxRequest.responseText);
                    //console.log("SceneData:" + sceneData.nextScene);
                    //get Current OBS Scene
                    window.obsstudio.getCurrentScene(function(scene) {
                        console.log("Current: " + scene.name)
                        console.log("Next: " + sceneData.nextScene);

                        //if current scene is not the same as the next scene, then change scene})
                        if (scene.name != sceneData.nextScene && sceneData.nextScene != "undefined") {

                            try {
                                window.obsstudio.setCurrentScene(sceneData.nextScene);
                            } catch (err) {
                                console.log("error");
                            }

                        }
                    });
                }
                // console.log(ajaxRequest);
            } catch (e) {
                console.log(e);
            }
            // console.log(ajaxRequest);
            //read the response and save it to a string 


            return sceneData;

        }


        function setCurrentSceneToNext() {

            var myScene;
            window.obsstudio.getCurrentScene(function(data) {
                myScene = data.name
            });
            console.log("myScene: " + myScene);

            const ajaxRequest = new XMLHttpRequest();
            var sceneData;
            var url = "https://ashenfieldx.live/sc/sceneSwitcher.php?streamID=AshenfieldX929239-34-DEV&scene=" + myScene;
            ajaxRequest.open("GET", url, true);
            ajaxRequest.send();
            console.log(ajaxRequest);
            // Promise.resolve = true;
            console.log("Setting Scene to: " + myScene);
            return myScene;

        }
        // Promise to wait for the scene to be set to current scene
        // Before setting the next scene process begin
        let sceneUpdate = new Promise(function(resolve, reject) {
            try {
                console.log("Promise");
                console.log(setCurrentSceneToNext());
                
                resolve('Success');
            } catch (err) {
                reject(err);
            }
        });

        sceneUpdate.then((data) => {

            console.log("sceneUpdate: " + data);
            setInterval(main, 2500);
        });

        // setCurrentSceneToNext().then((data) => {
        //     console.log(data);
        //     setInterval(main, 2500);
        // });
    </script>

</body>

</html>