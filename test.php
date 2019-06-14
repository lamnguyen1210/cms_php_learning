<?php 

$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "";
$db['db_name'] = "cms_php";

foreach($db as $key => $value)
{
	define(strtoupper($key), $value);
}

$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

// if($connection)
// {
// 	echo "We are connected";
// }

$query = "SELECT * FROM users WHERE user_id = 6";
$select_1_user = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($select_1_user);

echo $username = $row['username'];
echo "<br>";
echo $user_password = password_verify('123456', $row['user_password']);


?>