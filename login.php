<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="apple-touch-icon" sizes="57x57" href="/images/Fa/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/Fa/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/Fa/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/Fa/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/Fa/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/Fa/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/Fa/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/Fa/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/Fa/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/images/Fa/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/Fa/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/Fa/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/Fa/favicon-16x16.png">
    <link rel="manifest" href="/images/Fa/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/Fa/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <title>Login</title>
    <link href="/../panel/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/../panel/dist/css/dashboard.css" rel="stylesheet">
    <link href="/../panel/dist/css/login.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="/../panel/dist/js/holder.js"></script>
    <script src="/../panel/dist/js/jquery.custom-scrollbar.js"></script>

    <link type="text/css" rel="stylesheet" href="./dist./jquery.custom-scrollbar.css"/>
    <link rel="stylesheet" href="/../panel/FontAwesome/css/font-awesome.css">
    <link rel="stylesheet" href="/../panel/FontAwesome/css/font-awesome.min.css">
</head>
<body>
	<div class="panel-body col-md-12">
		<div class="col-md-4 col-md-offset-4 ">

			<h1>myRemote</h1>

				<div class="panel panel-info" style="min-height: 300px;">
					<div class="panel-heading"><h3 class="panel-title">Login</h3></div>
					   <div class="panel-body">
							<form id="login" action="login.php" method="POST" autocomplete="off"class="form-outline" role="form">
								<label for="username">Username:</label>
								<input class="form-control" name="username" type="Text" placeholder="Username" autocomplete="off" autofocus value="<?php if (isset($_POST["username"])) { echo $_POST["username"];}?>">
								<br>
								<label for="password">Password:</label>
								<input class="form-control" name="password" type="Password" placeholder="Password" autocomplete="off" value="<?php if (isset($_POST["password"])) { echo $_POST["password"];}?>">
								<br>
								<div class="btn-group btn-group-justified" role="group">
								<div class="btn-group" role="group">
								<button class="btn btn-primary" name="go">Login</button>
								</div>
								</div>
							</form>
						</div>
				</div>

				<?php
				//details
				session_start();
				if($_SESSION['user'] != ''){
					header("Location:./index.php");
				}else{
					//echo "<script>alert('hey');</script>";
				}
				if($_SERVER['REQUEST_METHOD'] == 'POST'){
					error_reporting('E_ALL');
					include('../db_con/db_UDB.php');
					//variabelen
					$email=stripslashes($_POST['username']);
					$password=stripslashes($_POST['password']);

					if(isset($_POST) && $email!='' && $password!=''){
					 $email=stripslashes($_POST['username']);
					 $password=stripslashes($_POST['password']);
					 $sql=$dbh->prepare("SELECT id,ul,pw,psalt, username, banned FROM users WHERE username='$email'");
					// $info = mysql_fetch_array($sql);
					 $sql->execute(array($email));
					 while($r=$sql->fetch()){
					  $p=$r['pw'];
					  $p_salt=$r['psalt'];
					  $id=$r['id'];
					  $ul=$r['ul'];
					  $username=$r['username'];
					  $ban=$r['banned'];
						echo '<script>Alert("Wrong");</script>';
					 }

					 $site_salt="NoH4Ck3RH3R310101010<3";
					 $salted_hash = hash('sha256',$password.$site_salt.$p_salt);
					 if($p==$salted_hash){
					  $_SESSION['userlevel'] = $ul;
					  $_SESSION['username'] = $username;
					  $_SESSION['user'] = $user;
					  $_SESSION['id'] = $id;
					  if ($ban == 0){
					  if ($ul == 'UsSZbKS7kK'){
					 	$username=stripslashes($_POST['username']);
					 	$location='404';
						if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
							$IP = $_SERVER['HTTP_CLIENT_IP'];
						} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        		     		$IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        		    	} else {
        		        	$IP = $_SERVER['REMOTE_ADDR'];
        		    	}
        		    	include_once('../db_con/db_UDB.php');
        		    	$refdate = date('H:i:s');
        		    	$login = "INSERT INTO loggedin (ip,username,location,userlevel,time_stamp)
		            	VALUES ('".$IP."','".$username."','".$location."','".$ul."','".$refdate."')";
	            		$link->query($login) or trigger_error("Fout: " .mysqli_error($link), E_USER_ERROR);

	            		include_once('../db_con/db_UDB.php');
	            		$actual = date("n");
	            		$sqli1 = "SELECT * FROM m_log WHERE month='$actual'";
		    			$query3 = mysqli_query($link, $sqli1) or trigger_error("Fout: " .mysqli_error($link), E_USER_ERROR);
	            		while($row = mysqli_fetch_assoc($query3)) {
	            			$value = $row['logins'];
	            			$login = ++$value;
	            			echo $login;
	            			$sqli2 = "UPDATE m_log SET logins='$login' WHERE month='$actual'";
		            		$link->query($sqli2) or trigger_error("Fout: " .mysqli_error($link), E_USER_ERROR);
	            		}
					 	header('Location:./index.php');
					  }
					  elseif($ul == 'admin'){ //fake data
					 	$username=stripslashes($_POST['username']);
					 	$location='404';
						if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
							$IP = $_SERVER['HTTP_CLIENT_IP'];
						} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        		     		$IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        		    	} else {
        		        	$IP = $_SERVER['REMOTE_ADDR'];
        		    	}
        				include_once('../db_con/db_UDB.php');
        		    	$refdate = date('H:i:s');
        		    	$login = "INSERT INTO loggedin (ip,username,location,userlevel,time_stamp)
		            	VALUES ('".$IP."','".$username."','".$location."','".$ul."','".$refdate."')";
	            		$link->query($login) or trigger_error("Fout: " .mysqli_error($link), E_USER_ERROR);

					  	include_once('../db_con/db_UDB.php');
	            		$actual = date("n");
	            		$sqli1 = "SELECT * FROM m_log WHERE month='$actual'";
		    			$query3 = mysqli_query($link, $sqli1) or trigger_error("Fout: " .mysqli_error($link), E_USER_ERROR);
	            		while($row = mysqli_fetch_assoc($query3)) {
	            			$value = $row['logins'];
	            			$login = ++$value;
	            			echo $login;
	            			$sqli2 = "UPDATE m_log SET logins='$login' WHERE month='$actual'";
		            		$link->query($sqli2) or trigger_error("Fout: " .mysqli_error($link), E_USER_ERROR);
	            		}
					  	header('Location:./index.php');
					  }
					  elseif($ul == 'user'){ //fake data
					 	$username=stripslashes($_POST['username']);
					 	$location='404';
						if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
							$IP = $_SERVER['HTTP_CLIENT_IP'];
						} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        		     		$IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        		    	} else {
        		        	$IP = $_SERVER['REMOTE_ADDR'];
        		    	}
        		    	include_once('../db_con/db_UDB.php');
        		    	$refdate = date('H:i:s');
        		    	$login = "INSERT INTO loggedin (ip,username,location,userlevel,time_stamp)
		            	VALUES ('".$IP."','".$username."','".$location."','".$ul."','".$refdate."')";
	            		$link->query($login) or trigger_error("Fout: " .mysqli_error($link), E_USER_ERROR);

					  	include_once('../db_con/db_UDB.php');
	            		$actual = date("n");
	            		$sqli1 = "SELECT * FROM m_log WHERE month='$actual'";
		    			$query3 = mysqli_query($link, $sqli1) or trigger_error("Fout: " .mysqli_error($link), E_USER_ERROR);
	            		while($row = mysqli_fetch_assoc($query3)) {
	            			$value = $row['logins'];
	            			$login = ++$value;
	            			echo $login;
	            			$sqli2 = "UPDATE m_log SET logins='$login' WHERE month='$actual'";
		            		$link->query($sqli2) or trigger_error("Fout: " .mysqli_error($link), E_USER_ERROR);
	            		}
					  	header('Location:./index.php');
					  }
					  }elseif($ban == 1){
					  	header('Location:/banned.php');
					  }
					 }else{
					  echo "<div class='alert alert-danger dangeralert'>Wrong username or password.</div>";
					 }
					}
				}
				?>
				<div class="panel-body col-md-12 mrlogo">
					<div class="panel panel-info mrlogo">
						<div class="panel-body mrlogo">
					 		<img src="./images/logo/myremotelogo.png" class="img-responsive mrlogo col-md-24"/>
				    	</div>
		      		</div>
				</div>

		</div>
	</div>
</body>
</html>
