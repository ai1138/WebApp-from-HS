<?php
	$hostname="127.0.0.1";
	$db = "rap";
	$conn = new PDO("mysql:host=$hostname;dbname=$db","nas3","");
	if (array_key_exists("newuser", $_POST))
		registerNewUser($_POST['uname'], $_POST['pword']);
	else
		loginUser($_POST['uname'], $_POST['pword']);
	
	function registerNewUser($uname, $pword)
	{
		global $conn;
		$doc = new DOMDocument();
		$doc->loadHTMLFile("signin.html");
		$cmd = "SELECT * FROM `Users` WHERE `Username` = '$uname'";
		$result = $conn->prepare($cmd);
		$result->execute();
		
		if($result->rowCount() > 0)
		{
			echo "<div style ='padding-up:80%;font:31px/41px Arial,tahoma,sans-serif;color:#ff0000'> This User Exists</div>";
			echo $doc->saveHTML();
		}
		else
		{
			$cmd = "INSERT INTO `Users` VALUES ('$uname', '$pword')";
			$result = $conn->prepare($cmd);
			$result->execute();
			echo "<div style ='padding-up:80%;font:31px/21px Arial,tahoma,sans-serif;color:#ff0000'> Sign in now</div>";
			echo $doc->saveHTML();
		}
	}
	
	function loginUser($uname, $pword)
	{
		global $conn;
		$doc = new DOMDocument();
		$doc->loadHTMLFile("signin.html");
		$docHome = new DOMDocument();
		$docHome -> loadHTMLFile("home.html");
		$cmd = "SELECT `Password` FROM `Users` WHERE `Username` = '$uname'";
		$result = $conn->prepare($cmd);
		$result->execute();
		if ($result->rowCount() == 0)
		{
			echo "<div style ='padding-up:80%;font:31px/21px Arial,tahoma,sans-serif;color:#ff0000'> Sorry but user doesnt exist</div>";
			echo $doc->saveHTML();
		}
		else
		{
			$data = $result->fetch();
			if ($data['Password'] == $pword)
			{
				echo $docHome->saveHTML();			
			}
			else
			{
				echo "<div style = 'padding-up:80%;font:31px/21px Arial,tahoma,sans-serif;color:#ff0000'> Sorry but that password is wrong</div>";
				echo $doc->saveHTML();
			}
		}
	}
?>