<?php  

if(isset($_POST['checkBoxArray'])){

    foreach($_POST['checkBoxArray'] as $postValueId){
        $bulk_options = $_POST['bulk_options'];

        switch($bulk_options){
            case 'published':
            $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id={$postValueId}";

            $update_to_published_status = mysqli_query($connection, $query);
            break;
        }
    }

}

?>

<!-- Button to Open the Modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Open modal
</button> -->

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <!-- Modal body -->
    <div class="modal-body">
        <h2>Are you sure you want to delete this post?</h2>
    </div>

    <!-- Modal footer -->
    <div class="modal-footer">
        <a href="" class="btn btn-danger modal_delete_link">Delete</a>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
    </div>

</div>
</div>
</div>


<form action="" method="post">

   <!-- tao bang posts -->
   <table class="table table-bordered table-hover">

    <div id="bulkOptionsContainer" class="col-xs-4">

        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="published">Pulish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
        </select>

    </div>
    
    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a class="btn btn-primary" href="add_post.php">Add New</a>
    </div>

    <thead>
        <tr>
            <th><input id="selectAllBoxes" type="checkbox"></th>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $per_page = 8;
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        else{
            $page = "";
        }

        if($page == "" || $page == 1){
            $page_1 = 0;
        }
        else{
            $page_1 = ($page * $per_page) - $per_page;
        }

        $post_query_count = "SELECT * FROM posts";
        $find_count = mysqli_query($connection, $post_query_count);
        $count = mysqli_num_rows($find_count);

        $count = ceil($count/$per_page);

        $query = "SELECT * FROM posts LIMIT $page_1, $per_page";
        $select_posts = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_posts))
        {
            $post_id = $row['post_id'];
            $post_category_id = $row['post_category_id'];
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_status = $row['post_status'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];

            echo "<tr>";

            ?>

            <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>

            <?php

            echo "<td>$post_id</td>";
            echo "<td>$post_author</td>";
            echo "<td>$post_title</td>";

            $query = "SELECT * FROM categories WHERE cat_id= $post_category_id";
            $select_categories_id = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_categories_id))
            {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
            }


            echo "<td>$cat_title</td>";



            echo "<td>$post_status</td>";
            echo "<td><img width='100' height='80' src='../images/$post_image' alt='image'></td>";
            echo "<td>$post_tags</td>";

            $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
            $send_comment_query = mysqli_query($connection, $query);

            $count_comments = mysqli_num_rows($send_comment_query);

            echo "<td>$count_comments</td>";
            echo "<td>$post_date</td>";
            echo "<td>
            <a rel='$post_id' class='delete_link' href='javascript:void(0)'><button class='btn btn-primary'>Delete</button></a></td>";
            // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?');\" href='posts.php?delete={$post_id} '>Delete</a></td>";
            echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'><button class='btn btn-danger'>Edit</button></a></td>";
            echo "</tr>";
        } 
        ?>

        <?php  

        if(isset($_GET['delete']))
        {
            $the_post_id = $_GET['delete'];

            $query = "DELETE FROM posts WHERE post_id = '$the_post_id' ";
            $delete_query = mysqli_query($connection, $query);
            header("Location: posts.php");
        }

        ?>
    </tbody>
</table>
<div class="text-center">
    <ul class="pagination">

        <?php
        if(!isset($_GET['page'])){
            echo "<li><a class='active_link' href='posts.php?page=1'>1</a></li>";
            for($i = 2; $i <= $count ; $i++){
                echo "<li><a href='posts.php?page={$i}'>{$i}</a></li>";
            }
        }
        else{
          for($i = 1; $i <= $count ; $i++){
            if($i == $page){
                echo "<li><a class='active_link' href='posts.php?page={$i}'>{$i}</a></li>";
            }
            else{
                echo "<li><a href='posts.php?page={$i}'>{$i}</a></li>";
            }
        }  
    }

    ?>
</ul>
</div>
</form>

<script type="text/javascript">
    $(document).ready(function(){
        $(".delete_link").on("click",function(){
            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete="+ id +" ";
            console.log(id);

            $(".modal_delete_link").attr("href", delete_url);

            $("#myModal").modal('show');
        });
    });
</script>