<html>
    <head>
        <style type="text/css">
          body
		  {
			background-image:url("download.jpg");
		  }
          div
          {
              margin-left:30%;
              margin-top:8%;
          }
          h1
          {
              color:red;
              font-size:80px;
          }
          h2
          {
              color:red;
              font-size:40px;
          }
        </style>
        <script>
              <?php 
                $hostname="127.0.0.1";
	            $db = "rap";
	            $conn = new PDO("mysql:host=$hostname;dbname=$db","nas3","");
                function comparison($q)
                {
                    $count = 0;
                    if($_POST[$q] == 4) 
                    {
                        $count = $count + 4;
                    }
                    else if($_POST[$q] == 3)
                    {
                        $count = $count + 3;
                    }
                    else if($_POST[$q] == 2)
                    {
                        $count = $count + 2;
                    }
                    else if($_POST[$q] == 1)
                    {
                        $count = $count + 1;
                    }
                    return $count;
                }
                function createpesonality()
                {
                    $q1 = comparison("q1");
                    $q2 = comparison("q2");
                    $q3 = comparison("q3");
                    $q4 = comparison("q4");
                    $q5 = comparison("q5");
                    $person = $q1 + $q2 + $q3 + $q4 + $q5;
                    return $person;
                }
                function playlist()
                {   
                    
                   global $conn;
                   $person = createpesonality();
                   if($person <= 20 && $person > 15 )
                   {
                        $cmd = 'SELECT * FROM `Music` WHERE `PERSONALITY` = "Aggressive"';
                        $result = $conn->prepare($cmd);
		                $result->execute();
		                $Data = $result->fetchAll(PDO::FETCH_NUM);
                   }
                   else if(person <= 15 && $person > 10)
                   {
                        $cmd = 'SELECT * FROM `Music` WHERE `PERSONALITY` = "Calm"';
                        $result = $conn->prepare($cmd);
		                $result->execute();
		                $Data = $result->fetchAll(PDO::FETCH_NUM);
                   }
                   else if(person <= 10 && $person > 5)
                   {
                        $cmd = 'SELECT * FROM `Music` WHERE `PERSONALITY` = "Smart"';
                        $result = $conn->prepare($cmd);
		                $result->execute();
		                $Data = $result->fetchAll(PDO::FETCH_NUM);
                   }
                   else if(person <= 5 && $person > 0)
                   {
                        $cmd = 'SELECT * FROM `Music` WHERE `PERSONALITY` = "Happiness"';
                        $result = $conn->prepare($cmd);
		                $result->execute();
		                $Data = $result->fetchAll(PDO::FETCH_NUM);
                   }
                   return $Data;                      
                }
                ?>
                
            function initialize()
            {
                AudioPlayer = document.getElementById("player");
                AlbumCover = document.getElementById("coverart");
                ArtistName = document.getElementById("artistname");
                SongTitle = document.getElementById("songname");
                playList = <?php echo json_encode(playlist()); ?>;
                songIndex = 0;
                displaysongs();
            }
            function displaysongs()
            {
                AlbumCover.src =  "/Music/images/" + playList[songIndex][4];;
                AudioPlayer.src = "/Music/" + playList[songIndex][3];
                ArtistName.innerHTML = playList[songIndex][0];
                SongTitle.innerHTML = playList[songIndex][1];
                
            }
            function navigateup()
            {
               displaysongs();
               if(songIndex==playList.length-1) 
               {
                    songIndex = -1;
               }
               songIndex++;
            }               
            function navigatedown()
            {
                displaysongs();
                songIndex--;
                if(songIndex == -1)
                {
                    songIndex = 9;
                }
                
            }
        </script>
    </head>
    <body onload = "initialize()">
        <div>
            <h1 id = "songname"></h1>
            <h2 id = "artistname"></h2>   
            <audio id = "player" controls>
                <source  src = "" type="audio/mpeg">
            </audio>
            <img onclick = "navigatedown()" src = "back.jpg" />
            <img class = "coverart" id = "coverart" src=""/>
           <img onclick = "navigateup()" src=  "next.jpg" />
           
        </div>
    </body>
</html>