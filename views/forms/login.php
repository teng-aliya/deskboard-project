<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/form-style.css">

    <title>Deskboard | LOGIN</title>
  </head>
  <body>

   <div class="container">
     <div class="row">
      <div class="p-5 col-md-10 offset-1">
        <h1 class="text-center">WELCOME</h1>
      </div>
      <div class="card mt-5 offset-md-6 mx-auto p-5">
          <form action="../../web.php" method="POST">
            <input type="hidden" name="action" value="login">
            <div class="mb-3">
              <label class="form-label border-bottom border-warning text-white">Username</label>
              <input type="text" class="form-control" name="username">
            </div>
            <div class="mb-3">
              <label class="form-label border-bottom border-warning text-white">Password</label>
              <input type="password" class="form-control" name="password">
            </div>
            <div class="mb-3 offset-md-5">
              <button class="btn">LOGIN</button>
              <br>
              <a href="register.php" class="mt-3 px-auto btn">REGISTER</a>
            </div>
        </form>
      </div>
     </div>
   </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  </body>
</html>