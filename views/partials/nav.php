 <?php
  $uri = $_SERVER['REQUEST_URI'];
  if ($uri == "/index.php") {
    require_once 'controllers/connection.php';
  }else{
    require_once '../controllers/connection.php';
  }
  $query = "SELECT * FROM users INNER JOIN status ON users.status_id = status.status_id";
  $stmt = $cn->prepare($query);
  $stmt->execute();
  $result = $stmt->get_result();
  $users = $result->fetch_all(MYSQLI_ASSOC);

  $user_id = $_SESSION["user_details"]["user_id"];

  $user_query = "SELECT * FROM users INNER JOIN status ON users.status_id = status.status_id WHERE users.user_id = $user_id";
  $user_stmt = $cn->prepare($user_query);
  $user_stmt->execute();
  $user_result = $user_stmt->get_result();
  $current_user = $user_result->fetch_assoc();

  $status_query = "SELECT * FROM `status`";
  $status_stmt = $cn->prepare($status_query);
  $status_stmt->execute();
  $status_result = $status_stmt->get_result();
  $statuses = $status_result->fetch_all(MYSQLI_ASSOC);
?>

<header class="navbar sticky-top flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 text-uppercase text-reset" href="/index.php">Deskboard</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <form method="POST" action="/web.php">
          <input type="hidden" name="action" value="logout">
          <button class="nav-link btn text-reset text-uppercase text-white" type="submit">Sign out</button>
        </form>
      </li>
    </ul>
  </header>

    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <div class="card">
              <div class="card-body">
                <img class="img-fluid rounded-circle" style="width: 60px; height: 60px;" src="<?php echo $_SESSION['user_details']['image']; ?>">
                <a class="nav-link d-inline-block" href="/views/profile.php?id=<?php echo $user_id ?>">
                  <?php echo $current_user['firstname']?>
                  <?php echo " " ?>
                  <?php echo $current_user['lastname'] ?>
                  <small class="d-block"><?php echo $current_user['username'] ?></small>
                </a>
             </div>
            </div>
          </li>
          <br>
          <?php foreach ($users as $user):?>
          <li class="nav-item">
              <a class="nav-link" href="/views/room.php?id=<?php echo $user['user_id'] ?>">
              <?php 
              echo $user['firstname'];
              echo " ";
              echo $user['lastname'];
              ?>
              <?php if ($user['status_name'] == 'Online'):?>
              <span class="badge bg-success">
                <?php echo $user['status_name']; ?>
              </span>
              <?php else: ?>
                <span class="badge bg-danger">
                  <?php echo $user['status_name']; ?>
                </span>
              <?php endif ?>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Bulletin Board</span>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="/views/newsletter.php">
              Newsletter
            </a>
          </li>
        </ul>
      </div>
    </nav>

<script type="text/javascript">
</script>