<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
?>
<?php

include 'database.php';
		$connect = mysqli_connect("localhost", "root", "") or die ("Couldn't connect to the database");
    mysqli_select_db($conn,"some") or die ("Couldn't find the database");

		$post_id=$_GET["postid"];

       $commentload=mysqli_query($conn,"select  *  from  comments  where  postid='$post_id'  ");
              $countcomments=mysqli_num_rows($commentload);
?>

<html>
<body>
<table>
<?php
              if($countcomments == 0){
                $usercomment="";
                $viewfullcomments="";
              }else{
              while($rowcomments=mysqli_fetch_array($commentload)){

              $commentid=$rowcomments['commentid'];
              $commenterid=$rowcomments['commenterid'];
              $commentbody=$rowcomments['comment'];
              $commenttime=$rowcomments['time'];

                      $commenterinfos=mysqli_query($conn,"select  *  from  user  where  id='$commenterid'  ");
                      $rowcommenterinf=mysqli_fetch_array($commenterinfos);
                      $commenterfname=$rowcommenterinf['fname'];
                      $commenterlname=$rowcommenterinf['lname'];
                      $commenterphotoprofile=$rowcommenterinf['photoprofile'];


            $usercomment="<tr><td colspan='1'><img style='width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;' src='".$commenterphotoprofile."'></img> ".$commenterfname.' '.$commenttime.'<br>'.$commentbody."</td></tr>";


            echo $usercomment;


              }
            }

?>
<td><form method='post' action='postreaction.php?id=<?php echo $post_id; ?>'><input type='text' name='commentbody'><input type='submit' name='postcom'></form></td>
</table>
</body>
</html>