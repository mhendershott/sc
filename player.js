async function main() {

 
    //  Enable/Disable debug messages
    var debug = false;

    var q = getQ();

if (q[0]) {
    // get first element in array
    var id = q[0]["id"];
    var command = q[0]["command"];
    var param = q[0]["param"];
    // var param = q[0].param;
}
   //myDebug(command);
    myDebug(id + " " + command + " " + param);
    //process the command
    if (command == "play") {
        //play the audio
        var audio = new Audio(param);
        audio.play();
       // remove the command from the queue
       
       try {
            //remove the command from the queue
            deletePayload(id);
        } catch (e) {
            myDebug(e);
        }

    } // else if play html video file from directory
    else if (command == "video") {
        //play the video
        myDebug(id + " " + command + " " + param);
        var video = document.getElementById("video");
        video.src = param;
        video.play();
        video.addEventListener("ended", function() {
            console.log("The video has just ended!");
            // Let's redirect now
            video.src = "";
            video.play();
        }, true);
        // remove the command from the queue
        try {
            deletePayload(id);
        } catch (e) {
            myDebug(e);
        }


 
    }


    myDebug(q); //debug



    // Functions 
    function myDebug(msg) {
        if (debug) {
            console.log(msg);
        }

    }

    function getQ() {
        //read a url and save it to a variable , random for cache avoidance
        // var url = "https://ashenfieldx.live/sc/command.txt?viewerID="+vid+"t=" + Math.random();
        var url = "https://ashenfieldx.live/sc/getqueue.php?viewerID="+vid+"&t=" + Math.random();
        //create an ajax request
        const ajaxRequest = new XMLHttpRequest();

        ajaxRequest.open("GET", url, false);
        try {
            ajaxRequest.send();
        } catch (e) {
            console.log(e);
        }

        //read the response and save it to a string 
        var response = ajaxRequest.responseText;
        
        //convert the formatted string to a json object
        var responseObject = JSON.parse(response);

        //ensure array is sorted by id number
              

        responseObject.sort(function(a, b) {
            return a.id- b.id;
        });
        return responseObject;
    }
    //function to remove a command from the queue

    function deletePayload(seq) {
        const ajaxRequest = new XMLHttpRequest();
    
        var url = "https://ashenfieldx.live/sc/removeCommand.php?commandID="+seq+"&t="+ Math.random();
        ajaxRequest.open("GET", url, true);
        try {
            ajaxRequest.send();
        } catch (e) {
            console.log(e);
        }
    }
 

} // end main()


function viewerID() {

    var viewerID = uuidv4();

    const ajaxRequest = new XMLHttpRequest();
        var url = "https://ashenfieldx.live/sc/viewerRegister.php?viewerID=" + viewerID +"&t="+ Math.random();
        ajaxRequest.open("GET", url, true);
        try {
            ajaxRequest.send();
        } catch (e) {
            console.log(e);
        }

        return viewerID;
}

async function viewerHeartbeat() {
    const ajaxRequest = new XMLHttpRequest();
    var url = "https://ashenfieldx.live/sc/viewerRegister.php?viewerID=" + vid +"&t="+ Math.random();
    ajaxRequest.open("GET", url, true);
    try {
        ajaxRequest.send();
    } catch (e) {
        console.log(e);
    }

}

function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16 | 0,
            v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

//get browser size
function getBrowserSize() {
    var w = window,
        d = document,
        e = d.documentElement,
        g = d.getElementsByTagName('body')[0],
        x = w.innerWidth || e.clientWidth || g.clientWidth,
        y = w.innerHeight || e.clientHeight || g.clientHeight;
    return [x , y]
}

//set video player size to browser size
function setVideoSize() {
    var size = getBrowserSize();
    var video = document.getElementById("video");
    video.width = size[0];
    video.height = size[1];
}



//set video player size to browser size if window is resized
window.onresize = function() {
    setVideoSize();
}

//Initialize heartbeat
var vid = viewerID();
viewerHeartbeat();


// Asynchronous call to main() and viewerheartbeat()

// run main() every 2.5 seconds
setInterval(main, 2500);
//Begin heartbeat
setInterval(viewerHeartbeat, 50000);
var scene = "start";

//window.obsstudio.setCurrentScene(scene);
