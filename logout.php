<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <?php
    session_start();
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
    ?>
</body>
</html>