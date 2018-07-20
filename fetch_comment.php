<?php

$connect = new PDO('mysql:host=localhost;dbname=praktika', 'root', '');

$query = "
SELECT * FROM comment 
WHERE Parent_Comment_ID = '0' 
ORDER BY Comment_ID ASC
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';
foreach($result as $row)
{
    $output .= '
 <div class="panel panel-default">
  <div class="panel-heading">By <b>'.$row["Name"].'</b> on <i>'.$row["Date"].'</i></div>
  <div class="panel-body">'.$row["Comment"].'</div>
  <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["Comment_ID"].'">Reply</button></div>
 </div>
 ';
    $output .= get_reply_comment($connect, $row["Comment_ID"]);
}

echo $output;

function get_reply_comment($connect, $parent_id = 0, $marginleft = 0)
{
    $query = "
 SELECT * FROM comment WHERE Parent_Comment_ID = '".$parent_id."'
 ";

    $output = '';
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $count = $statement->rowCount();
    if($parent_id == 0)
    {
        $marginleft = 0;
    }
    else
    {
        $marginleft = $marginleft + 48;
    }
    if($count > 0)
    {
        foreach($result as $row)
        {
            $output .= '
   <div class="panel panel-default" style="margin-left:'.$marginleft.'px">
    <div class="panel-heading">By <b>'.$row["Name"].'</b> on <i>'.$row["Date"].'</i></div>
    <div class="panel-body">'.$row["Comment"].'</div>
   </div>
   ';
            $output .= get_reply_comment($connect, $row["Comment_ID"], $marginleft);
        }
    }
    return $output;
}

?>
