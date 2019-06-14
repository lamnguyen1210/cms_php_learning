
<?php  

function confirmQuery($result)
{
	global $connection;

	if(!$result)
	{
		die("QUERY FAILED ." . mysqli_error($connection));
	}

}

function insert_categories()
{
	global $connection;
	
	if(isset($_POST['submit']))
	{
		$cat_title = $_POST['cat_title'];

		if($cat_title == "" || empty($cat_title))
		{
			echo "This field should not be empty";
		}
		else
		{
			$query = "INSERT INTO categories(cat_title) ";
			$query .= "VALUES('{$cat_title}')";

			$create_category_query = mysqli_query($connection,$query);

			if(!$create_category_query)
			{
				die('QUERY FAILED' . mysql_error($connection,$query));
			}
		}
	}
}

function findAllCategories()
{
	global $connection;

	$query = "SELECT * FROM categories";
	$select_categories = mysqli_query($connection, $query);

	while($row = mysqli_fetch_assoc($select_categories))
	{
		$cat_id = $row['cat_id'];
		$cat_title = $row['cat_title'];

		echo "<tr>";
		echo "<td>{$cat_id}</td>";
		echo "<td>{$cat_title}</td>";
		echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
		echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
		echo "</tr>";
	} 
}

function delete_categories()
{
	global $connection;
	if(isset($_GET['delete']))
	{
		$the_cat_id = $_GET['delete'];

		$query = "DELETE FROM categories WHERE cat_id = '{$the_cat_id}'";
		$delete_query = mysqli_query($connection,$query);
        header("Location: categories.php"); //click delete 1 time
    } 
}

function escape($string){
	global $connection;

	return mysqli_real_escape_string($connection, trim($string));
}

function is_admin($username = ''){
	global $connection;

	$query = "SELECT user_role FROM users WHERE username = '$username'";
	$result = mysqli_query($connection, $query);
	confirmQuery($result);

	$row = mysqli_fetch_array($result);

	if($row['user_role'] == 'admin'){
		return true;
	}
	else{
		return false;
	}
}

function username_exists($username){
	global $connection;

	$query = "SELECT username FROM users WHERE username = '$username'";
	$result = mysqli_query($connection, $query);
	confirmQuery($result);

	if(mysqli_num_rows($result) > 0){
		return true;
	}
	else{
		return false;
	}
}

function email_exists($email){
	global $connection;

	$query = "SELECT user_email FROM users WHERE user_email = '$email'";
	$result = mysqli_query($connection, $query);
	confirmQuery($result);

	if(mysqli_num_rows($result) > 0){
		return true;
	}
	else{
		return false;
	}
}

function redirect($location){
	return header("Location: " . $location);
}

function register_user($username, $email, $password){
	// $username = $_POST['username'] ;
	// $email = $_POST['email'];
	// $password = $_POST['password'];

	if(username_exists($username)){
		$message = "user exists";
	}
	else if(!empty($username) && !empty($email) && !empty($password)){
		$username = mysqli_real_escape_string($connection, $username);
		$email = mysqli_real_escape_string($connection, $email);
		$password = mysqli_real_escape_string($connection, $password);

		$password = password_hash($password, PASSWORD_DEFAULT, array('cost' => 12));

    // $query = "SELECT randSalt FROM users";
    // $select_randsalt_query = mysqli_query($connection, $query);

    // if(!$select_randsalt_query){
    //     die("QUERY FAILED!" . mysqli_error($connection));
    // }

    // $row = mysqli_fetch_array($select_randsalt_query);
    // $salt = $row['randSalt'];

		$query = "INSERT INTO users(username, user_email, user_password, user_role) ";
		$query .= "VALUES('{$username}', '{$email}', '{$password}', 'subcriber')";
		$register_user_query = mysqli_query($connection, $query);
		if(!$register_user_query){
			die("QUERY FAILED" . mysqli_error($connection) . ' ' . mysqli_errno($connection));
		}

		$message = "Your registration has been submitted";

	}
	else
	{
		$message = "Fields cannot be empty";
	} 

	echo "<h4>$message</h4>";
}

function login_user($username, $password){
	global $connection;
	$username = trim($username);
	$password = trim($password);

	$username = mysqli_real_escape_string($connection, $username);
	$password = mysqli_real_escape_string($connection, $password);

	$query = "SELECT * FROM users WHERE username = '$username' ";
	$select_user_query = mysqli_query($connection, $query);
	if( !$select_user_query ){
		die("QUERY FAILED" . mysqli_error($connection));
	}

	while($row = mysqli_fetch_array($select_user_query)){
		$db_user_id = $row['user_id'];
		$db_username = $row['username'];
		$db_user_password = $row['user_password'];
		$db_user_firstname = $row['user_firstname'];
		$db_user_lastname = $row['user_lastname'];
		$db_user_role = $row['user_role'];
	}

	if(password_verify($password, $db_user_password)){
		$_SESSION['username'] = $db_username;
		$_SESSION['firstname'] = $db_user_firstname;
		$_SESSION['lastname'] = $db_user_lastname;
		$_SESSION['user_role'] = $db_user_role;

		header("Location: ../admin");
	} 
	else
	{
		header("Location: ../index.php");		
	}
}

?>