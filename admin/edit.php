<?php 
  require_once "../config/config.php";
  session_start() ;

// validation session data //
  if(empty($_SESSION['user_id']) and empty($_SESSION['logged_in'])){
    header('location: login.php');
  }
// validation session data //

// show edit info in title and content using get method //
  $id = $_GET['id'];

  $stmt  = $pdo -> prepare("SELECT * FROM posts WHERE id = $id");

  $stmt -> execute();
  $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
// show edit info in title and content using get method //


// update process using post method //
  if(isset($_POST['update_btn'])){

    $idHidden = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

      if($_FILES['image']['name'] != "" ){
        $img_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $target_file = '../image/' .$img_name;

        $img_type = pathinfo($target_file, PATHINFO_EXTENSION);

          if($img_type != 'jpg' and $img_type != 'png' and $img_type != 'jpeg'){
            echo "<script>alert('Your image must be jpg or png or jprg!!')</script>";
          }else{
             move_uploaded_file( $tmp_name , $target_file);

             $stmt = $pdo -> prepare("UPDATE posts SET title='$title', content='$content', image='$img_name' WHERE id= '$idHidden' ");
             $data = $stmt -> execute();
                if($data){
                  echo "<script>alert('Successfully updated');
                        window.location.href = '../admin/index.php';
                        </script>";
                }
          }
      }else{
        $stmt = $pdo -> prepare("UPDATE posts SET title='$title', content='$content' WHERE id= '$idHidden' ");
        $data = $stmt -> execute();
           if($data){
             echo "<script>alert('Successfully updated');
                   window.location.href = '../admin/index.php';
                   </script>";
           }
      }

  }
// update process using post method //

?>

<?php
  require_once '../admin/layout/header.php';
?> 

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
               <div class='card-body'>

                  <form action="" method='post' enctype='multipart/form-data'>

                      <input type="hidden" name ='id' value='<?php echo $result[0]['id'] ?>'>

                      <div class='form-group'>
                        <label for="" class='mx-2 fw-bold'>Title</label>
                        <input type="text" name='title' class='form-control' value='<?php echo $result[0]['title']; ?>'>
                      </div>
                      <div class='form-group'>
                        <label for="" class='mx-2 fw-bold'>Content</label><br>
                        <textarea name="content" class='form-control' id="" rows='8' cols='100' ><?php echo $result[0]['content']; ?></textarea>
                      </div>
                      <div class='form-group'>
                        <label for="image" class='mx-2 fw-bold'>Image</label> <br>
                        <img src="../image/<?php echo  $result[0]['image']; ?>" alt="" width='150' height='150'> <br> <br>
                        <input type="file" name='image' value=''> 
                      </div>

                      <div class='form-group'>

                        <input type="submit" name='update_btn' class='btn btn-success' value='Update'>
                        <a href="./index.php" type='button' class='btn btn-primary'>Back</a>

                      </div>

                  </form>
               </div>
              </div>      
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

<?php 
   require_once "../admin/layout/footer.php";
?>

     
    