<?php

$connect = new PDO('mysql:host=localhost;dbname=praktika', 'root', '');

$error = '';
$comment_name = '';
$email = '';
$comment_content = '';


if(empty($_POST["comment_name"]))
{
    $error .= '<p class="text-danger">Name is required</p>';
}
else
{
    $comment_name = $_POST["comment_name"];
}

if(empty($_POST["comment_email"]))
{
    $error .= '<p class="text-danger">Email is required</p>';
}
else
{
    $email = $_POST["comment_email"];
}

if(empty($_POST["comment_content"]))
{
    $error .= '<p class="text-danger">Comment is required</p>';
}
else
{
    $comment_content = $_POST["comment_content"];
}

if($error == '')
{
    $query = "
 INSERT INTO comment 
 (Parent_Comment_ID, Comment, Name, Email) 
 VALUES (:parent_comment_id, :comment, :comment_name, :email)
 ";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':parent_comment_id' => $_POST["comment_id"],
            ':comment'    => $comment_content,
            ':comment_name' => $comment_name,
            ':email' => $email
        )
    );
    $error = '<label class="text-success">Comment Added</label>';
}

$data = array(
    'error'  => $error
);

echo json_encode($data);

?>
