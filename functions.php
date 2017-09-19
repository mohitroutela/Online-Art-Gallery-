<?php
session_start();
$username="";
$email="";
$errors=array();

//connect to the database
$db = mysqli_connect('localhost', 'root', '', 'multi_login');

 //if the register button is clicked 
	if(isset($_POST['reg_user']))
	{
		register();
	}



	function register(){
		global $db, $errors, $username, $email;



      $username = mysqli_real_escape_string($db,$_POST['username']);
      $email = mysqli_real_escape_string($db,$_POST['email']);
      $password_1 = mysqli_real_escape_string($db,$_POST['password_1']);
      $password_2 = mysqli_real_escape_string($db,$_POST['password_2']);
      
	
		if(empty($username))
		{
		 array_push($errors, "username is required");
		}
		if(empty($email))
		{
		 array_push($errors, "email is required");
		}
		if(empty($password_1))
		{
		 array_push($errors, "password  is required");
		}
		if($password_1 != $password_2)
		{
			array_push($errors,"the two password do not match");
		}
		if(count($errors)==0)
		{
			$password = md5($password_1);//encrypt the password before saving in the database
			if(isset($_POST['user_type']))
			{
				$user_type=mysqli_real_escape_string($db,$_POST['user_type']);
				$query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', '$user_type', '$password')";
					  mysqli_query($db,$query);
					  $_SESSION['success']  = "New user successfully created!!";
					  header('location:  home.php');



			}
			else{
				$query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', 'user', '$password')";
			mysqli_query($db, $query);

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);//The mysqli_insert_id() function returns the id (generated with AUTO_INCREMENT) used in the last query.
			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: index3.php');
			}





			/*ql = "INSERT INTO users (username, email, password) 
				  VALUES('$username', '$email', '$password')";
				  mysqli_query($db,$sql);
				  $_SESSION['username'] = $username;
				  $_SESSION['success'] = "you are now logged in ";
				  header('Location: index.php')*/

		}
	}


	function getUserById($id)
	{
		global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);//The mysqli_fetch_assoc() function fetches a result row as an associative array.
	return $user;



	}

	function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}

	//log user in from login page
   /*if (isset($_POST['Login'])) {
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);

	if (empty($username)) {
		array_push($errors, "Username is required");
	                       }
	if (empty($password)) {
		array_push($errors, "Password is required");
	                       }
	if (count($errors) == 0) {
		$password = md5($password);
		$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) {
			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('Location: index.php');
		}else {
			array_push($errors, "Wrong username/password combination");
			header('location: ')
		}
  							}
						}
	if (isset($_GET['logout'])) 
	{
		session_destroy();
		unset($_SESSION['username']);
		header('Location: index.php');
		
	}*/
	function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}


if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

if (isset($_POST['login_btn'])) {
	login();
}


function login(){
	global $db, $username, $errors;

	// grap form values
	$username = mysqli_real_escape_string($db,$_POST['username']);
      $password = mysqli_real_escape_string($db,$_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {
		$password = md5($password);

		$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['user_type'] == 'admin') {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: admin/home.php');		  
			}else{
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: index3.php');
			}
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}


if(isset($_POST['register_btn']))
	{
		register();
	}


	if (isset($_GET['logout'])) {
		
	session_destroy();
	unset($_SESSION['user']);
	header("location: login1.php");
}








  ?>