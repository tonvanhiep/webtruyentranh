<?php
define('HOST', 'localhost');
define('USENAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'PROJECT_WEB_TRUYEN');



$connect = mysqli_connect(HOST, USENAME, PASSWORD, DATABASE);

if(!$connect) {
    echo "<br>" . "KẾT NỐI DATABASE CHƯA SẴN SÀNG";
} else {
    echo "KẾT NỐI DATABASE SẴN SÀNG";
    mysqli_close($connect);
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATABASE</title>
</head>
<body>
    
</body>
</html>