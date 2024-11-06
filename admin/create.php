<?php 
  require_once "../config/config.php";
  session_start() ;

  if(empty($_SESSION['user_id']) and empty($_SESSION['logged_in'])){
    header('location: login.php');
  }


  if(isset($_POST['submit_btn'])){

   $img_name = $_FILES['image']['name'];
   $tmp_name =  $_FILES['image']['tmp_name'];

   $target_file = '../image/' .$img_name;

   $img_type = pathinfo($target_file,PATHINFO_EXTENSION);
    
    if($img_type != 'png' and $img_type != 'jpg' and $img_type != 'jpeg'){

      echo "<script>alert('Image Error! Image must be png, jpg, jpeg format!')</script>";

    }else{

      move_uploaded_file($tmp_name , $target_file );

      $stmt = $pdo -> prepare("INSERT INTO posts(title, content, image, author_id) VALUE (:title, :content, :image, :author_id)");
      $result = $stmt -> execute([
        ':title' => $_POST['title'],
        ':content' => $_POST['content'],
        ':image' => $img_name,
        ':author_id' => $_SESSION['user_id'],
      ]);

          if($result){
            echo "<script>alert('successfully added....');
                  window.location.href = '../admin/index.php';
            </script>";
          }
    }
   
  }

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

                  <form action="" class='' method='post' enctype='multipart/form-data'>
                      <div class='form-group'>
                        <label for="" class='mx-2 fw-bold'>Title</label>
                        <input type="text" name='title' class='form-control' value='' required>
                      </div>
                      <div class='form-group'>
                        <label for="" class='mx-2 fw-bold'>Content</label><br>
                        <textarea name="content" class='form-control' id="" rows='8' cols='100' value='' required></textarea>
                      </div>
                      <div class='form-group'>
                        <label for="image" class='mx-2 fw-bold'>Image</label> <br>
                        <img src="" alt="" id='image' style='width:150px;' class='mb-3'> <br>
                        <input type="file" name='image' value='' onchange="loadfile(event)"  required>
                      </div>

                      <div class='form-group'>

                        <input type="submit" name='submit_btn' class='btn btn-success' value='SUBMIT'>
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

<script src = './layout/app.js'></script>

     
    