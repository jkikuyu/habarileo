<?php
//session_start();
	class Login{
		private $user;
		private $pass;
	
	public function show_login(){
		require "lang/en.php";

		?>
		<!DOCTYPE html>
		<html lang="en">

			<head>
				<meta charset="utf-8">
				<title>Login</title>
				<link rel="stylesheet" type="text/css" href="styles/style.css" />
				<script type = "text/javascript" src = "js/article.js" ></script>
			
			</head>
			<body class="align">
			  	<?php if(isset($_SESSION["errors"])){

	  				$error = $_SESSION["errors"];
					echo "<script>";
			 			echo "disp_err(". $error ."')";
			 		echo "</script>";
				}
				?>
				<div class="grid">
					<form class= "login form" action="" method="post">
						
						<header class="login_header">
							<h3 class="login_title">login Form</h3>
						</header>

						<div class="imgcontainer">
							<img src="images/avatar.png" alt="Avatar" class="avatar">
						</div>
			  			
			  			<div class="login_body" id="test">
			  					<div name="errors" id="error" style="display:none">
			  						dfddfdfdf

									
			  					</div>

			 	  				<div class="form-field">
								<input type="text" name="username" placeholder =  "<?php echo $lang["username"];?>" required value= "<?php if(isset($_SESSION["username"])) {echo $_SESSION["username"]; unset($_SESSION["username"]);} ?>"/>
			

							</div>
				  			<div class="form-field">
								<input type="password" name="password" placeholder= "<?php echo $lang["password"];?>" required/>
							</div>

			  			</div>

						<footer class="login_footer">
			
							<button type="submit" name="login">login </button>
			
							<input type="checkbox" name="itsme" checked="checked"> Remember me


						</footer>

					</form>

				</div>

			</body>


		</html>

	<?php
	}


	public function checkValidUser($objDB){

		//$conn = $_SESSION["dbconn"];

		$user = $_POST["username"];
		$pass =$_POST["password"];

		
		$sql = "select userid, user_name, password,usertype from users where user_name= '". $user. "'";

		$result = $objDB->getResults($sql);

		$_SESSION['errors'] = "Username  or password does not exist";

		if($result){
			$row = array();
			foreach($result AS $row){
				
				if (trim($row["password"]) ===$pass){
					if(isset($_SESSION["errors"])) unset($_SESSION["errors"]);

					$_SESSION["username"] = $user;
					$_SESSION["userId"] = $row["userid"];
					return true;
				}
				else{
					return false;
				}
			}
		}
		else{
			return false;
		}


	}
}
/*
<?php if (isset($_SESSION['errors'])): ?>
    <div class="form-errors">
        <?php foreach($_SESSION['errors'] as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
*/

?>
