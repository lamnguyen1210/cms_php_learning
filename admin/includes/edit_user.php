<?php  

if(isset($_GET['edit_user']))
{
	$the_user_id = $_GET['edit_user'];

	$query = "SELECT * FROM users WHERE user_id= $the_user_id";
	$select_users_query = mysqli_query($connection, $query);

	while($row = mysqli_fetch_assoc($select_users_query))
	{
		$username = $row['username'];
		$user_password = $row['user_password'];
		$user_firstname = $row['user_firstname'];
		$user_lastname = $row['user_lastname'];
		$user_email = $row['user_email'];
		$user_role = $row['user_role'];
		// $user_image = $row['user_image'];
	}
	if(isset($_POST['edit_user']))
	{
		$username = $_POST['username'];
		$user_password = $_POST['user_password'];
		$user_firstname = $_POST['user_firstname'];
		$user_lastname = $_POST['user_lastname'];
		$user_email = $_POST['user_email'];
		$user_role = $_POST['user_role'];
		// $user_image = $row['user_image'];

		// move_uploaded_file($user_image_temp, "../images/$user_image");

		// if(empty($user_image))
		// {
		// 	$query = "SELECT * FROM users WHERE user_id = $the_user_id";
		// 	$select_image = mysqli_query($connection, $query);

		// 	while($row = mysqli_fetch_array($select_image))
		// 	{
		// 		$user_image = $row['user_image'];
		// 	}

		// }


		$query ="UPDATE users SET ";
		$query .="user_firstname = '$user_firstname', ";
		$query .="user_lastname = '$user_lastname', ";
		$query .="user_role = '$user_role', ";
		$query .="username = '$username', ";
		$query .="user_email = '$user_email', ";
		$query .="user_password = '$user_password' ";
		$query .="WHERE user_id = $the_user_id";

		$update_user = mysqli_query($connection, $query);

		confirmQuery($update_user);	
	}
}


?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form_group">
		<label for="user_author">First name</label>
		<input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname">
	</div>

	<div class="form_group">
		<label for="user_lastname">Last name</label>
		<input type="text" value="<?php echo $user_lastname; ?>" class="form-control" name="user_lastname">
	</div>

	<div class="form_group">
		<label for="firstname">User role</label>
		<br>
		<select name="user_role" id="">
			<option value="subcriber"><?php echo $user_role; ?></option>
			<?php  
			if($user_role == 'admin')
			{
				echo "<option value='subcriber'>subcriber</option>";
			}
			else
			{
				echo "<option value='admin'>admin</option>";
			}
			?>	
		</select>
	</div>

	<!-- <div class="form_group">
		<label for="user_image">user Image</label>
		<input type="file" class="form-control" name="user_image">
	</div> -->

	<div class="form_group">
		<label for="username">Username</label>
		<input type="text" value="<?php echo $username; ?>" class="form-control" name="username">
	</div>

	<div class="form_group">
		<label for="user_email">Email</label>
		<input type="text" value="<?php echo $user_email; ?>" class="form-control" name="user_email">
	</div>

	<div class="form_group">
		<label for="user_password">Password</label>
		<input type="password" value="<?php echo $user_password; ?>" class="form-control" name="user_password">
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="edit_user" value="Update user">
	</div>
</form>