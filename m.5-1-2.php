<!DOCTYPE html>
<html="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission5</title>
    </head>
    <body>

<?php

// データベース接続
$dsn="データベース名";
$user="ユーザー名";
$password="パスワード";
$pdo = new PDO($dsn,$user,$password,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES => false,]);

// テーブル作成
$sql="CREATE TABLE IF NOT EXISTS mission5 "
." ("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."password TEXT,"
. "date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP "
.");";
$stmt = $pdo->query($sql);

?>

<?php

if(isset($_POST["name"])){$name=$_POST["name"];}
if(isset($_POST["comment"])){$comment=$_POST["comment"];}
$date=date("Y/m/d/H/i/s");
if(isset($_POST["delete"])){$delete=$_POST["delete"];}
if(isset($_POST["edit"]))$edit=$_POST["edit"];
if(isset($_POST["editnum"])){$editnum=$_POST["editnum"];}
if(isset($_POST["password1"])){$password1=$_POST["password1"];}
if(isset($_POST["password2"])){$password2=$_POST["password2"];}
if(isset($_POST["password3"])){$password3=$_POST["password3"];}
    
   
// データ書き込み
if(isset($name)&&isset($comment)&&isset($editnum)&&isset($password1)){
    if($name !=""&&$comment != ""&&$editnum==""&&$password1!==""){
            $password=$password1;
            $sql = $pdo -> prepare("INSERT INTO mission5 (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> bindParam(':date', $date, PDO::PARAM_STR);
            $sql -> bindParam(':password', $password, PDO::PARAM_STR);
            $sql -> execute();
    }
}   
    
?>
<?php
// データ消去
if(isset($delete)&&isset($password2)){
    if($delete != "" && $password2 != ""){
        $sql = 'SELECT * FROM mission5';
	    $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            if($delete==$row['id']&&$password2==$row['password']){ 
            $id=$delete;
            $sql = 'delete from mission5 where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            }
        }
    }
}
?>
<?php
// データ編集
if(isset($edit)&&isset($password3)){
    if($edit!=""&&$password3!=""){
        $sql = 'SELECT * FROM mission5';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
        foreach ($results as $row){
            if($edit==$row["id"]&&$password3==$row["password"]){
                $editcomment=$row["comment"];
                $editname=$row["name"];
                $editnumber=$row["id"];
                $editpassword=$row["password"];
            }
        }
    }
}
    
if(isset($editnum)&&isset($name)&&isset($comment)&&isset($password1)){
    if($editnum != "" && $name != "" && $comment != "" && $password1 != ""){
    $id = $editnum;
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $password = $password1;
    $date=date("Y/m/d/ H:i:s");
    $sql = 'UPDATE mission5 SET name=:name,comment=:comment,date=:date,password=:password WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->execute();        
    }
}

    ?>

<span style="font-size:50px">おすすめの映画を書き込んで！</span><br><br>
名前と映画名とパスワードを入力<br>
    <!--入力フォーム-->
        <form action="" method="post">
        <input type="text" name="name" placeholder="名前" value="<?php if(isset($editname)){echo $editname;}?>"><br>
        <input  type="text" name="comment" placeholder="映画名やコメント" value="<?php if(isset($editcomment)){echo $editcomment;}?>"><br>
        <input type="text" name="password1" placeholder="パスワード" value="<?php if(isset($editpassword)){echo $editpassword;}?>">
        <input type="submit" name="submit">
        <input type="hidden" name="editnum" value="<?php if(isset($editnumber)){echo $editnumber;}?>">
        <br>
        </form>
削除したい投稿番号とパスワードを入力<br>
    <!--削除フォーム-->
    <form action="" method="post">
        <input type="number" name="delete" placeholder="削除番号入力"><br>
        <input type="text" name="password2" placeholder="あなたの決めたパスワード">
        <input type="submit" value="削除">
    </form>
編集したい投稿番号とパスワードを入力<br>
    <!--編集フォーム-->
    <form action="" method="post">
        <input type="number" name="edit" placeholder="編集番号入力"><br>
        <input type="text" name="password3" placeholder="あなたの決めたパスワード" >
        <input type="submit" value="編集">
       
    </form>
 
<?php   
// データの表示
$sql = 'SELECT * FROM mission5';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row["id"].',';
		echo $row["name"].',';
        echo $row["comment"].',';
        echo $row["date"].',';
        echo "<hr>";
    }
?>
</body>
</html>