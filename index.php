<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>analytics</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/highcharts.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/main.js"></script>
    <script src="js/highcharts.js"></script>
</head>
<body>
<?php
    $params = ['requst' => 'login'];

function _auth(){
    $login = 'test';
    $password = 'test';

    if ( isset($_POST['log_value'], $_POST['pass_value'], $_POST['pass_btn']) ) {
        if ($password == $_POST['pass_value'] && $login == $_POST['log_value'])
        {
            $_SESSION['unique_sdfcdrgbtrhbgfnb'] = true;
        } else {
            $_SESSION['sdfcdrgbtrhbgfnb'] = false;
            echo '<script language="javascript">';
            echo 'alert("Failed password")';
            echo '</script>';
        }
    }
    if ($_SESSION['unique_sdfcdrgbtrhbgfnb'] !== true) {
        echo '<form style="margin: 15% auto auto auto; width: 500px; height: 290px; background-image: url(../assets/images/authbg.jpg);" method="POST">'.
            '<div style="padding: 120px 0 0 40px;"><label for="log_value">Enter login:</label><br><input type="text" name="log_value" size="30" /><br>'.'
            <label for="pass_value">Enter password:</label><br><input type="password" name="pass_value" size="30" /><br>
            '.'<input style="margin-top: 5px" type="submit" value="Enter" name="pass_btn" /></div>'.
            '</form>';
        die();
    }
}
_auth();
?>
<div class="container main">
<!--    <div class="row">-->
<!--        <form class="form-horizontal" role="form" action="">-->
<!--            <div class="form-group">-->
<!--                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>-->
<!--                <div class="col-sm-10">-->
<!--                    <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="name">-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="form-group">-->
<!--                <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>-->
<!--                <div class="col-sm-10">-->
<!--                    <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password">-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="form-group">-->
<!--                <div class="col-sm-offset-2 col-sm-10">-->
<!--                    <div class="checkbox">-->
<!--                        <label>-->
<!--                            <input type="checkbox"> Запомнить меня-->
<!--                        </label>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="form-group">-->
<!--                <div class="col-sm-offset-2 col-sm-10">-->
<!--                    <button type="submit" class="btn btn-default" id="submit">Войти</button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </form>-->
<!--    </div>-->
    <div class="row">
        <div id="content"></div>
        <div id="content2"></div>
    </div>
</div>

<script>
    var params = '<?php echo json_encode($params) ?>';
    params = JSON.parse(params);
    params.date = 'year';
    Init(params);
</script>
</body>
</html>
