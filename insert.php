<h3><center>
    <?php include('links.php');?>
</center></h3>

<?php
$mypic = $_FILES['upload']['name'];
$temp = $_FILES['upload']['tmp_name'];
$type = $_FILES['upload']['type'];

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];

if($name && $email && $password && $cpassword){
	if(preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z]+\.)+[a-zA-Z]{2,6}$/i", $email)){
		if(strlen($password) > 3 ){
			if($password == $cpassword){
				$link = mysqli_connect("localhost", "root", "termopane", "testsite");	
				if (mysqli_connect_errno()){
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}	
				$username = mysqli_query($link,"SELECT name FROM users WHERE name='$name'");
				$count = mysqli_num_rows($username);
				$remail = mysqli_query($link,"SELECT name FROM users WHERE email='$email'");
				$checkemail = mysqli_num_rows($remail);		
				if($checkemail != 0){
					echo "This email is already registered! Please type another email.";
				} else {
					if( $count != 0 ){
						echo "This name is already registered! Please type another name.";
					} else {
						if(true){  //($type == "image/jpeg") || ($type == "image/jpg") || ($type == "image/bmp")
							$directory = "./profiles/$name/images";
							mkdir($directory, 0777, true);
							move_uploaded_file($temp, "profiles/$name/images/$mypic");
							echo"This will be your profile picture!<p><img border='1' width='50' height='50' src='profiles/$name/images/$mypic'/><p>";
							$passwordmd5 = md5($password);
							mysqli_query($link,"INSERT INTO users (name,email,password) VALUES ('$name','$email','$passwordmd5')");
							echo "You have succesfully registred!<a href='home.php'>Login now</a>";
						} else { 
							echo "This file has to be jpeg, jpg or bmp";
						}
					}
				}
			} else {
				echo "Your passwords don't match";
			}
		} else {
			echo "Your password is too short! You need to type a password betwen 4 and 15 characters";
		}
	} else {
		echo "Please type a valid email!";
	}
} else {
	echo "You have to complete the form!";
}
	
include('links.php');	
?>