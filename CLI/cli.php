<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname='mvc';

 $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
   
   if(! $conn ) {
      die('Could not connect: ' . mysqli_error());
   }

$username = trim(readline('> Username: '));
echo "> Password:";
echo "\033[30;40m";
$password = trim(readline(''));
echo "\033[0m";

$qry = "select * from mvc.users where username='".$username."'";
$result = mysqli_query($conn,$qry);
//$row = mysqli_fetch_assoc($result);
if($row = mysqli_fetch_assoc($result)){
	
	$hash = trim($row['password']);

	if (password_verify($password, $hash)) {
		echo "Logged in successfully\r\n";
		echo "--------------------------------------------\r\n";
		echo "Please type any one instruction\r\n";
		echo "profile show\r\n";
		echo "profile edit password\r\n";
		echo "bye\r\n";
		echo "--------------------------------------------\r\n";
		$login_time = date("Y-m-d h:i:s");
		label1:	$input = strtolower(trim(readline('> ')));
	
		$timezones = timezone_identifiers_list();	
		
		$created_date = new DateTime($row['created'], new DateTimeZone($timezones[$row['timezone']]) );
		$modified_date = new DateTime($row['modified'], new DateTimeZone($timezones[$row['timezone']]) );
				
		if($input == "profile show"){
			echo "--------------------------------------------\r\n";
			echo "Username : ".$row['username']."\r\n";
			echo "Email : ".$row['email']."\r\n";
			echo "Phone : ".$row['phone']."\r\n";
			echo "Address : ".$row['address']."\r\n";
			echo "City : ".$row['city']."\r\n";
			echo "State : ".$row['state']."\r\n";
			echo "Country : ".$row['country']."\r\n";
			echo "Zipcode : ".$row['zipcode']."\r\n";
			echo "Timezone : ".$row['timezone']."\r\n";
			echo "Created Date : ".$created_date->format('Y-m-d H:i:s')."\r\n";
			echo "Modified Date : ".$modified_date->format('Y-m-d H:i:s')."\r\n";
			echo "--------------------------------------------\r\n";
			echo "Please type any one instruction\r\n";
			echo "profile show\r\n";
			echo "profile edit password\r\n";
			echo "bye\r\n";
			echo "--------------------------------------------\r\n";
			goto label1;
		}else if($input == "profile edit password"){
			label2:	echo "New Password :";
			echo "\033[30;40m";
			$new_password = readline(' ');
			echo "\033[0m";
			
			$number = preg_match('@[0-9]@', $new_password);
			$uppercase = preg_match('@[A-Z]@', $new_password);
			$lowercase = preg_match('@[a-z]@', $new_password);
			$specialChars = preg_match('@[^\w]@', $new_password);
			
			if(strlen($new_password) < 6 || !$number || !$uppercase || !$lowercase || !$specialChars) {
				echo "Password must be at least 6 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character \r\n";
				goto label2;
			} else {
				$upd_qry = "update mvc.users set password='".password_hash($new_password, PASSWORD_DEFAULT)."' where id='".$row['id']."'";
				$upd_result = mysqli_query($conn,$upd_qry);
				if($upd_result){
					echo "Password has been updated \r\n";
				} else {
					echo "Password has not been updated\r\n";
				}
			}
			echo "--------------------------------------------\r\n";
			echo "Please type any one instruction\r\n";
			echo "profile show\r\n";
			echo "profile edit password\r\n";
			echo "bye\r\n";
			echo "--------------------------------------------\r\n";
			goto label1;
		}else if($input == "bye"){
			$strEnd = date("Y-m-d h:i:s");
			$dteStart = new DateTime($login_time);
			$dteEnd   = new DateTime($strEnd);
			$dteDiff  = $dteStart->diff($dteEnd);
			echo "Logged out successfully\r\n";
			echo "Login Date and Time : ".$login_time."\n";
			echo "Date and Time : ".$dteDiff->format("%H:%I:%S")."\n";
			echo "Total memory usage : ".memory_get_usage() . "\n";
			echo "Thank You\r\n";
			echo "--------------------------------------------\r\n";
			echo "--------------------------------------------\r\n";
			exit;
		} else {
			echo "Invalid commond\r\n";
			goto label1;
		}
		exit;
	} else {
		echo 'Invalid password\r\n';
		exit;
	}
	
} else {
	echo "Username is wrong\r\n";
	exit;
}

?>