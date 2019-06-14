<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="resource/icon.png" />
    <title>MASUK - INVENTARIS</title>
    <link href="http://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='resource/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
</head>

<style>
body{
    font-family: 'Trebuchet MS', serif;
}
</style>

<body>
<br><br><br><br>
<div class="container">
    <div class="row">
    <div class="col-md-6 offset-md-3">
    <div class="card card-body">
        <h3 class="card-title mb-4 mt-1">

        <table>
        <tr>
        <th><img src="resource/logo0.png" style="width:100%;margin-top:0px; margin-right:0px;"></th>
        <th><b style="margin-left:20px;"> MASUK INVENTARIS <br></b>
        <b style="margin-left:20px;"> GKPB MDC SIDOARJO</b></th></tr>
        </table>
        </h3>
            <form method='POST' action='signin.php'>
                <div class="form-group">
                    <label>Nama Pengguna</label>
                    <input name="username" class="form-control" placeholder="Nama Pengguna" type="test" autofocus>
                </div>
                <div class="form-group">
                    <label>Kata Sandi</label>
                    <div class="input-group">
                        <input id="password-field" class="form-control" placeholder="******" name="password" type="password" data-toggle="password"/>
                        <div style="background-color: #e6e6e6;" toggle="#password-field" class="col-1 btn fa fa-fw fa-eye field-icon toggle-password"style="margin-left:0px;"></div>
                    </div>
                </div>
                <div class="form-group">
                    <?php 
                        if (isset($_GET['status'])) {
                            if ($_GET['status']=='gagal') {
                                echo "<div class='alert alert-danger' role='alert'>Nama pengguna atau kata sandi salah!</div>";
                            }
                            elseif ($_GET['status']=='logout') {
                                 echo "<div class='alert alert-success' role='alert'>Sukses Keluar</div>";
                            }
                        }
                    ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block" name='btn_submit'>Masuk</button>
                </div>                                                        
            </form>
    </div>
    </div>
    </div>
</div>

<script src="resource/popper.min.js" ></script>
<script src="resource/bootstrap.min.js" ></script>
<script src="resource/bootstrap.bundle.min.js"></script> 
<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
    input.attr("type", "text");
    } else {
    input.attr("type", "password");
    }});
</script>

</body>
</html>