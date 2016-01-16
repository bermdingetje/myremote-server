<html>
    <form action="#" method="post">
        Name: <textarea name="img"></textarea><br>
        <input type="submit">
    </form>
        
</html>
<?php
    error_reporting(E_all);
    if(isset($_POST['img'])){
        $img = $_POST['img'];
        try {
            include_once('../db_con/db_image.php');
            $statement = $dbh->prepare("INSERT INTO base64(user_id, base64_str)
                   VALUES(:id, :str)");
            $statement->execute(array(
                "id" => "9",
                "str" => "$img"
            ));
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
?>
