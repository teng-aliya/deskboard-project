<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
<title> Deskboard | HOME</title>
<?php 
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');
function get_content(){
	require 'controllers/connection.php';
?>

<div class="container col-6 offset-3 my-4">
	<h1 class="offset-4">Deskboard</h1>
	<div class="px-3 my-3 card">
		<div class="card-header">
			<h1 class="card-text">Notes</h1>
		</div>
		<div class="card-body">
			<ul class="list-group list-group-flush">
			    <li class="list-group-item">Nothing due yet <a href="#" class="badge badge-red text-decoration-none">Check Calendar</a></li>
			    <li class="list-group-item">No new newsletter <a href="/views/newsletter" class="badge badge-red text-decoration-none">Check Newsletter</a></li>
		  	</ul>
		</div>
	</div>
</div>
<?php 
}
require_once 'views/partials/layout.php';
 ?>