<head>
  <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
  <title> Deskboard | Newsletter</title>
</head>


<?php
  require_once '../controllers/PostController.php';
  require_once '../controllers/connection.php';
  $title = "HOME";
  function get_content() {
  
  if(isset($_GET["filter"])){
    $posts = get_own_posts($_SESSION['user_details']['user_id']);
  }else{
    $posts = index();
  }


  global $cn;
  $query = "SELECT * FROM `tags`";
  $stmt = $cn->prepare($query);
  $stmt->execute();
  $result = $stmt->get_result();
  $tags = $result->fetch_all(MYSQLI_ASSOC); 
?>

<section>
  <div class="container">
    <div class="row">
      <h1 class="col-sm-6 offset-sm-3">Newsletter</h1>
      <div class="col-sm-6 offset-sm-3">
        <?php if(isset($_SESSION['user_details'])): ?>
        <form class="mt-5" action="/web.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="action" value="add_post">
          <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control">
          </div>
          <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
          </div>
          <div class="mb-3">
            <label>Description</label>
            <textarea class="form-control" name="description" rows="5"></textarea>
          </div>
          <div class="mb-3">
            <label>Tags</label>
            <select name="tag_id" class="form-select">
              <?php foreach ($tags as $tag):  ?>
                <option value=" <?php echo $tag['tag_id'] ?>">
                  <?php echo $tag["name"]; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <button class="btn btn-primary">Submit</button>
        </form>
        <?php endif; ?>
      </div>
    </div>

    <div class="row col-sm-6 offset-sm-3">
      <div class="text-wrap">
        <?php if(isset($_SESSION["user_details"])):?>
          <a class="badge bubble-1 p-2 text-decoration-none" href="/">View All</a>
          <a class="badge bubble-2 p-2 text-decoration-none" href="?filter=own">View My Posts</a>
        <?php endif; ?>
      </div>

      <?php foreach($posts as $post): ?>
      <div class="card mt-4">
        <div class="card-header">
          <img src="<?php echo $post['image'] ?>" class="card-img-top img-fluid">
        </div>
        <div class="card-body">
          <h5 class="card-title"><?php echo $post["title"] ?></h5>
          <p class="card-text"><?php echo $post["description"] ?></p>
          
          <?php if(isset($_SESSION["user_details"]) && $_SESSION["user_details"]["user_id"] == $post["user_id"] ):  ?>
          <button
            class="btn btn-warning"
            data-bs-toggle="modal"
            data-bs-target="#editModal-<?php echo $post['user_id'] ?>">
            Edit
          </button>

          <div class="modal fade" id="editModal-<?php echo $post['user_id'] ?>">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                  <form method="POST" enctype="multipart/form-data" action="/web.php">
                    <div class="mb-3">
                      <label>Title</label>
                      <input 
                        type="text" 
                        name="title" 
                        value="<?php echo $post['title']?>"
                        class="form-control">
                    </div>
                    <div class="mb-3">
                      <label>Image</label>
                      <input 
                        type="file" 
                        name="image"
                        class="form-control"
                        value="<?php echo $post['image'] ?>">
                    </div>
                    <div class="mb-3">
                      <label>Description</label>
                      <textarea 
                        name="description"
                        class="form-control"
                        rows="5"><?php echo $post['description']?></textarea>
                    </div>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo $post['id']?>">
                    <button class="btn btn-primary">Submit<button>
                    <button
                      class="btn btn-secondary"
                      data-bs-dismiss="modal"
                      type="button">
                      Cancel
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>


          <button 
          class="btn btn-danger" data-bs-toggle="modal"
          data-bs-target="#deleteModal-<?php echo $post['user_id'] ?>">Delete</button>

          <div class="modal fade" id="deleteModal-<?php echo $post['user_id'] ?>">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">
                    Are you sure you want to delete <?php echo $post["title"]; ?>?
                  </h5>
                </div>
                <div class="modal-footer">
                  <a href="/web.php?id=<?php echo $post['id'] ?>" class="btn btn-sucess">Confirm</a>
                  <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>

        </div>
        <div class="card-footer text-muted">
          <small>Tags: <?php echo $post['name'] ?></small>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>

<script type="text/javascript">
  let filter = document.getElementById("filter");
  filter.onchange = function(){
    filter.parentElement.submit();
  }
</script>
  
<?php  
  }
  require_once 'partials/layout.php';
?>