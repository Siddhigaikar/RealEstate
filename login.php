<?php
session_start();
include 'db.php';
if($_SERVER["REQUEST_METHOD"]==="POST"){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $sql=$conn->prepare("select id,name,password from users where email=?");
    if(!$sql){
        die("Prepare failed:" . $conn->error);
    }
    $sql->bind_param('s',$email);
    $sql->execute();
    $sql->bind_result($id,$name,$dbpassword);
    $sql->fetch();
    if($dbpassword && password_verify($password,$dbpassword)){
        $_SESSION['name']=$name;
        $_SESSION['id']=$id;
        $_SESSION['email']=$email;
        header("Location:dashboard.php");
        exit();

    }else{
        echo "<script>alert('Invalid email or password');</script>";
    }

}



?>

<!doctype html>
<html lang="en" data-bs-theme="light">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Bootstrap CSS v5.3.8 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <header>
            <!-- place navbar here -->
        </header>
        <main>
            <h3 class="text-center">Login With Us</h3>
            <div
                class="container border shadow rounded col-5 p-3"
            >
                <form method="POST">
                    

                    <div class="mb-3">
                        <label for="" class="form-label">Email</label>
                        <input
                            type="text"
                            class="form-control"
                            name="email"
                            id=""
                            aria-describedby="helpId"
                            placeholder=""
                        />
                        
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control"
                            name="password"
                            id=""
                            aria-describedby="helpId"
                            placeholder=""
                        />
                        
                    </div>
                    

                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                    >
                        Login
                    </button>
                    
                    
                    

                </form>
                <p class="text-center">Don't have an account?<a href="register.php">Register</a></p>
            </div>
            
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Bundle (includes Popper) -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"
        ></script>
    </body>
</html>