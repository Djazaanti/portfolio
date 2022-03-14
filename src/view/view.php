<?php
use Oc\Blog\model\UserModel;
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Page view.php</h1>
    <section>
        <div>
            <p>Contenu de view.php</p>
            <?php  $UserModel = new UserModel();
                $row = $UserModel->getusers();
                var_dump($row);
                foreach($user as $row){
                    print_r($user);
                ?><p> les users devraient s'afficher juste ci-après </br>
                <?php //echo $user['id']; echo $user['pseudo'];
                } ?></p>
        </div>
    </section>
</body>
</html>