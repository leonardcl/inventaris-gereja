<?php 
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Inventaris</title>

    <link rel='stylesheet' href='resource/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
    
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="display-3">Login Inventaris</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card">
                <article class="card-body">
                <!-- <a href="" class="float-right btn btn-outline-primary">Sign up</a> -->
                <h4 class="card-title mb-4 mt-1">Sign in</h4>
                    <form method='POST' action='signin.php'>
                    <div class="form-group">
                        <label>Username</label>
                        <input name="username" class="form-control" placeholder="username" type="test" autofocus>
                    </div> <!-- form-group// -->
                    <div class="form-group">
                        <!-- <a class="float-right" href="#">Forgot?</a> -->
                        <label>Password</label>
                        <input class="form-control" placeholder="******" type="password" name="password">
                    </div> <!-- form-group// --> 
                    <div class="form-group">
                        <?php 
                        if (isset($_GET['status'])) {
                            
                        
                            if ($_GET['status']=='gagal') {
                                # warning
                                echo "<div class='alert alert-danger' role='alert'>Wrong username or password</div>";
                            }
                            elseif ($_GET['status']=='logout') {
                                 echo "<div class='alert alert-success' role='alert'>Logout Success</div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block" name='btn_submit'> Login  </button>
                    </div> <!-- form-group// -->                                                           
                </form>
                </article>
            </div> <!-- card.// -->
        </div>
    
    </div>

</div>
<script src="resource/jquery-3.3.1.slim.min.js" ></script>
<script src="resource/popper.min.js" ></script>
<script src="resource/bootstrap.min.js" ></script>
<script src="resource/bootstrap.bundle.min.js"></script> 
</body>
</html>