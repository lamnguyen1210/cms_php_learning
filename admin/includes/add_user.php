<?php  

if(isset($_POST['create_user']))
{
	$user_firstname = $_POST['user_firstname'];
	$user_lastname = $_POST['user_lastname'];
	$user_role = $_POST['user_role'];
	
	// $user_image = $_FILES['user_image']['name'];
	// $user_image_temp = $_FILES['user_image']['tmp_name'];
	
	$username = $_POST['username'];
	$user_email = $_POST['user_email'];
	$user_password = $_POST['user_password'];
	// $user_date = date('d-m-y');

	// move_uploaded_file($user_image_temp, "../images/$user_image");

	$query ="INSERT INTO users(user_firstname,user_lastname,user_role,username,user_email,user_password) ";
	$query .= "VALUES('$user_firstname','$user_lastname','$user_role','$username','$user_email','$user_password')";
	
	$create_user_query = mysqli_query($connection, $query);
	
	confirmQuery($create_user_query);	
}

?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form_group">
		<label for="user_author">First name</label>
		<input type="text" class="form-control" name="user_firstname">
	</div>

	<div class="form_group">
		<label for="user_lastname">Last name</label>
		<input type="text" class="form-control" name="user_lastname">
	</div>

	<div class="form_group">
		<label for="title">User role</label>
		<br>
		<select name="user_role" id="">
			<option value="subcriber">Select Options</option>
			<option value="admin">Admin</option>
			<option value="subcriber">Subcriber</option>
		</select>
	</div>

	<!-- <div class="form_group">
		<label for="user_image">user Image</label>
		<input type="file" class="form-control" name="user_image">
	</div> -->

	<div class="form_group">
		<label for="username">Username</label>
		<input type="text" class="form-control" name="username">
	</div>

	<div class="form_group">
		<label for="user_email">Email</label>
		<input type="text" class="form-control" name="user_email">
	</div>

	<div class="form_group">
		<label for="user_password">Password</label>
		<input type="password" class="form-control" name="user_password">
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="create_user" value="Create user">
	</div>
</form>