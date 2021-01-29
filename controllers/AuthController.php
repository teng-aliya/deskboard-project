<?php  
require_once 'connection.php';
require_once 'vendor/autoload.php';

//REGISTER
function register($request) {
	global $cn;
    $errors = 0;
    $username = $request['username'];
    $firstname = $request['firstname'];
    $lastname = $request['lastname'];
    $email = $request['email'];
    $password = $request['password'];	
    $password2 = $request['password2'];

    $status_id = 4;

    $img_name = $_FILES['image']['name'];
	$img_size = $_FILES['image']['size'];
	$img_tmpname = $_FILES['image']['tmp_name'];
	$img_type = pathinfo($img_name, PATHINFO_EXTENSION);
	$img_path = "/assets/profile/$img_name";

	$is_img = false;
    
    foreach($_POST as $key => $value){
        if(strlen($value) == 0 && empty($value)){
            $errors++;
            die("Please fill out all fields");
        }
    }

    if(strlen($password) < 8){
        echo "Password must be greater than 8 characters";
        $errors++;
    }

    if($password != $password2){
        echo "Password do not match";
        $errors++;
    }

    if($username || $email){
        $query = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $cn->prepare($query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_all(MYSQLI_ASSOC);
        
        if($user){
            echo "Username already exists";
            $errors++;
            $cn->close();
            $stmt->close();
        }
    }

    if($img_type == "jpg" || $img_type == "png" || $img_type == "jpeg" || $img_type == "svg" || $img_type == "gif"){
	$is_img = true;
	} else{
		echo "Please upload an image file";
	}

    if($errors === 0 && $is_img && $img_size > 0){
    	move_uploaded_file($img_tmpname, $_SERVER["DOCUMENT_ROOT"] . $img_path);
        $pass = password_hash($password,PASSWORD_DEFAULT);
        $query = "INSERT INTO users(status_id, firstname, lastname, username, password, image, email) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $cn->prepare($query);
        $stmt->bind_param("issssss", $status_id, $firstname, $lastname, $username, $pass, $img_path, $email);
        $stmt->execute();
        $stmt->close();
        $cn->close();
        

        //Create the transport
         $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
         ->setUsername('teng.aliya@gmail.com')
         ->setPassword('Soramajiko2');

        //create the mailer using your created transport
         $mailer = new Swift_Mailer($transport);

        //create a message
         $message = (new Swift_Message("B2-ECOM Registration"))
         ->setFrom(['teng.aliya@gmail.com' => 'Admin'])
         ->setTo([$email => $firstname])
         ->setBody("Thank you for creating an account in B2-ECOM");

        // $result = $mailer->send($message);
        header("Location: /views/forms/login.php");
    }

}

//LOGIN
function login($request) {
	global $cn;
	$username = $request['username'];
    $password = $request['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $cn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user && password_verify($password, $user['password'])){
        session_start();
        $_SESSION["user_details"] = $user;
        header("Location: /index.php");
    } else{
        echo "Please check your credentials";
        echo "<br>";
        echo "<a href='/views/forms/login.php'>Go to login</a>";
    }
}

//LOGOUT
function logout() {
	session_start();

	session_unset();

	session_destroy();

	header('Location: /views/forms/login.php');
}