<?php 
  require_once "../config/config.php";
  session_start() ;

  if(empty($_SESSION['user_id']) and empty($_SESSION['logged_in'])){
    header('location: login.php');
  }

?>

<?php
  require_once '../admin/layout/header.php';
?>

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <diva class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Blogs Listening</h3>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                  <a href="./create.php" type="button" class="btn btn-success my-3">New Blog Posts</a>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th style="width: 40px">Actions</th>
                      </tr>
                    </thead>
                  <!-- for showing list in index pages -->
                    <tbody>
                     <?php 
                    //  pagination 
                    if(!empty($_GET['pageno'])){
                        $pageno = $_GET['pageno'];
                    }else{
                      $pageno = 1 ;
                    }
                    $numofrec = 1;

                    $offset = ($pageno -1) * $numofrec;

                    if(empty($_POST['search'])){
                        
                      $stmt = $pdo -> prepare("SELECT * FROM posts ORDER BY id DESC");
                      $stmt -> execute();
                      $rawresult =  $stmt -> fetchAll(PDO::FETCH_ASSOC); 

                      $totalpages = ceil(count($rawresult) / $numofrec);

                      $stmt = $pdo -> prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset, $numofrec");
                      $stmt -> execute();
                      $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);

                    }else{
                      $search = $_POST['search'];
                      
                      $stmt = $pdo -> prepare("SELECT * FROM posts WHERE title LIKE '% $search%' ORDER BY id DESC");
                      $stmt -> execute();
                      $rawresult =  $stmt -> fetchAll(PDO::FETCH_ASSOC); 

                      $totalpages = ceil(count($rawresult) / $numofrec);

                      $stmt = $pdo -> prepare("SELECT * FROM posts WHERE title LIKE '% $search%' ORDER BY id DESC LIMIT $offset, $numofrec");
                      $stmt -> execute();
                      $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                    }
                     
                      if($result){
                        $i = 1;
                        foreach($result as $item){
                      ?>
                       <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $item['title']; ?></td>
                          <td>
                             <?php echo substr($item['content'], 0, 50 ) ; ?>
                          </td>
                          <td>
                              <div class="btn-group">
                                <a href="./edit.php?id=<?php echo $item['id']; ?>" type="button" class="btn btn-primary mx-1 rounded">Edit</a>
                                <a href="./delete.php?id=<?php echo $item['id']; ?>" type="button" class="btn btn-danger mx-1 rounded" onclick="return confirm('Are you sure you want to delete this item')">Delete</a>
                              </div>
                          </td>
                      </tr>

                     <?php
                        $i++;
                        }
                      }
                     ?>
                    </tbody>
                   <!-- for showing list in index pages -->

                  </table> <br> 
                <!-- for pagination -->
                  <div class='float-right'>
                     <nav aria-label="Page navigation example">
                          <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                            <li class="page-item <?php if($pageno <= 1){echo"disabled";} ?>">
                               <a class="page-link" href="<?php if($pageno <= 1){echo "#";}else{echo"?pageno=".($pageno-1) ;} ?>">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                            <li class="page-item <?php if($pageno >= $totalpages){echo"disabled";} ?>">
                               <a class="page-link" href="<?php if($pageno >= $totalpages){echo'#';}else{echo"?pageno=".($pageno+1);} ?>">Next</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="?pageno=<?php echo $totalpages ; ?>">Last</a></li>
                          </ul>
                      </nav> 
                  </div>
                <!-- for pagination -->
    
                </div> 
                <!-- card_body     -->
                
              </div>
              <!-- /.card -->
            </diva>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

<?php 
   require_once "../admin/layout/footer.php";
?>

     
    