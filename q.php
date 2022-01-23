<html>

<head>
  <style>
    body {
      font-family: sans-serif;
      background-color: #00c800;
      font-size: 72px;
      color: #ffffff;
    }
    
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  margin: 4px 2px;
  cursor: pointer;
}


.button10 {font-size: 10px;}
.button120 {font-size: 120px;}
.button720 {font-size: 720px;}
.button1024 {font-size: 1024px;}
.button1920 {font-size: 1920px;}
</style>

    <script>
      //get current size of render window
      var width = window.innerWidth;
      var height = window.innerHeight;
      
      </script>

</head>


<body>
    <!-- <script src="playerMinified.js"></script> -->
    <p id="debug"></p>
<?php
  //get interactive parameter from URL
  $interactive = $_GET['interactive'];
  //sanitize interactive parameter
  $interactive = filter_var($interactive, FILTER_SANITIZE_STRING);
  //if interactive parameter is true, then display confirm button
  if ($interactive == "true") {
      echo "<button class='button button120' id='confirm' onclick='confirm()'>Confirm Interactive Session</button>";
  }
  //hide button if confirm button is clicked
  echo "<script>
  function confirm() {
    document.getElementById('confirm').style.display = 'none';
  }
  </script>";
?>
  

    <script src="player.js"></script>
    <div class="vidbox">
      <video id="video" autoplay="autoplay" width="1920" height="1080 src=""> </video>
    </div>


   
</body>

</html>