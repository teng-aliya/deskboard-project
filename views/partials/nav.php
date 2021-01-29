  <header class="navbar sticky-top flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 text-uppercase text-reset" href="/index.php">Deskboard</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <form method="POST" action="/web.php">
          <input type="hidden" name="logout">
          <a class="nav-link text-reset text-uppercase text-white" type="submit">Sign out</a>
        </form>
      </li>
    </ul>
  </header>

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
    ?>

    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link border-bottom" href="/views/profile.php?id=<?php echo $user_id ?>">
             My Profile
            </a>
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
              <span class="badge badge-red"><?php echo $user['status_name']; ?></span>
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