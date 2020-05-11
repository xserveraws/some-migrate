<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
?>
<?php

 	include('database.php');
 	$user_check=$_GET['id'];
 	$ses_sql=mysqli_query($conn,"select  *  from  user  where  id='$user_check'  ");
 	$row=mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
 	$id=$row['id'];
 	$fname=$row['fname'];
 	$lname=$row['lname'];
 	$gender=$row['gender'];
 	$email=$row['email'];
 	$phone=$row['phone'];
 	$photoprofile=$row['photoprofile'];
 	$photocover=$row['photocover'];
  $bio=$row['bio'];
  $username=$row['username'];
  $activated=$row['activated'];

  if($activated == '0'){
    echo '<script type="text/javascript">alert("This account is deactivated!");</script>';
    die;
  }

  if($photoprofile==""){
    $photoprofile = "images/basic/photoprofile.png";
  }
  if($photocover==""){
    $photocover = "images/basic/photocover.png";
  }

  $mainid=$_SESSION['id'];

  $query = mysqli_query($conn,"SELECT * FROM relationship WHERE useroneid='$mainid' AND usertwoid='$id'");
  $row1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
  $useroneid = $row1['useroneid'];
  $usertwoid = $row1['usertwoid'];
  $status = $row1['status'];
  $actionuserid = $row1['actionuserid'];
  
?>


<html>
<head>
<link rel="icon" type="image/png" href="images/icon/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Profile: <?php echo $fname;?> <?php echo $lname;?></title>
<link rel="icon" href="assets/icons/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/styleprofile.css">
  <link type="text/css" rel="stylesheet" media="all" href="assets/css/chat.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/post.css">

</head>
<body>

<script type="text/javascript" src="assets/jscript/jquery.js"></script>
<script type="text/javascript" src="assets/jscript/chat.js"></script>

<nav>
		<section class="nav-container">
			<aside class="logo"><a href="index.php"><img src="images/logos/logo.jpg"></a></aside>
			<aside class="menu">
			<div class="dropdown">
				<a href='profile.php?id=<?php echo $_SESSION["id"]; ?>'>
        <img style="width: 100%; height: 100%;max-width: 20px;max-height: 20px; object-fit: cover;" src="
        <?php
        include('database.php');
        $user_check=$_SESSION['id'];
        $ses_sql=mysqli_query($conn,"select  *  from  user  where  id='$user_check'  ");
        $row=mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
        $photologprofile=$row['photoprofile'];
        echo $photologprofile;
        ?>
        ">
        </a>
        <a href="#" id="loginregister">Account<img width="12" height="10" src="images/basic/arrow.jpg"></img></a>
				<div class="dropdown-content">
          <a href="home.php">Feed</a>
					<b><a href='profile.php?id=
					<?php
						echo $_SESSION["id"];
					?>
					'>Profile</a></b>
					<a href="messages.php">Message</a>
					<a href="settings.php">Settings</a>
          <a href="requestlist.php">Follow Requests</a>
					<a href="reportbugs.php">Report Bugs</a>
					<a href="logout.php">Log Out</a>
				</div>
			</div>
			</aside>
		</section>
	</nav>
<div class="container">
  <header>
  <a href="changephoto.php">
  <?php
  echo "<img class='profile' style='width: 100%; height: 100%;max-width: 250px;max-height: 250px; object-fit: cover;' src='".$photoprofile."'/> ";
  ?>
  </a>
  <a href="changecover.php">
  <?php
  echo "<img class='cover' style='width: 100%; height: 100%;max-width: 700px;max-height: 250px; object-fit: cover;' src='".$photocover."'/> ";
  ?>
  </a>
  </header>
  <div class="sidebar1">
    <ul class="navi">
    <b><li><a href='profile.php?id=<?php echo $_GET["id"]; ?>'>Wall</a></li></b>
    <li><a href='photos.php?id=<?php echo $_GET["id"]; ?>'>Photos</a></li>
    <li><a href="followers.php?id=<?php echo $_GET["id"]; ?>">Followers</a></li>
    <li><a href="following.php?id=<?php echo $_GET["id"]; ?>">Following</a></li>
					<?php 
          if($email == $_SESSION['email']){
            echo "<li><a href='infos.php?id=".$id." '>Infos</a></li>";
            
            echo "<li><a href='settings.php'>Settings</a></li>";
          }
            else
              echo "<li><a href='infos.php?id=".$id." '>Infos</a></li>";
          ?>
    </ul>
    <aside>
    <?php
    if(($_SESSION['id'] != $id) AND ($useroneid == $mainid AND $usertwoid == $id AND $status == '0' AND $actionuserid == $mainid)){
    ?>
    <form method="post" action="friendreq.php?id=<?php echo $_GET["id"]; ?>">
    <input type="submit" name="addfriend" value="Waiting">
    <input type="submit" name="block" value="Block">
    
    </form>
    <?php
    }elseif(($_SESSION['id'] != $id) AND ($useroneid==$mainid AND $usertwoid==$id AND $status=='1')){
    ?>
    <form method="post" action="friendreq.php?id=<?php echo $_GET["id"]; ?>">
    <input type="submit" name="unfollow" value="Unfollow">
    <input type="submit" name="block" value="Block">
    
    </form>
    <?php
    }elseif(($_SESSION['id'] != $id) AND ($useroneid==$id AND $usertwoid==$mainid AND $status=='0')){
    ?>
    <form method="post" action="friendreq.php?id=<?php echo $_GET["id"]; ?>">
    <input type="submit" name="addfriend" value="Follow">
    <input type="submit" name="block" value="Block">
    </form>
    <?php
    }elseif(($_SESSION['id'] != $id) AND ($useroneid==$mainid AND $usertwoid==$id AND $status=='3')){
    echo "<script> window.open('profile.php?id=".$useroneid."', '_self')</script>"; 
    ?>
    <?php
    }else{ 
    if($_SESSION['id'] != $id){ ?>
    <form method="post" action="friendreq.php?id=<?php echo $_GET["id"]; ?>">
    <input type="submit" name="addfriend" value="Follow">
    <input type="submit" name="block" value="Block">
    
    </form>
    <?php
    }
    }
 
    ?>
    Send message to <?php echo $fname; ?><h2><a href="javascript:void(0)" onclick="javascript:chatWith('<?php echo $username; ?>')" alt="Chat With <?php echo $fname; ?>">
    <img align="left" src="images/basic/message-icon.png" width="25" height="25">
    </a></h2><br/>
    <strong>Bio</strong><br>
    <?php echo $bio ?>
    </aside>
  </div>
  <article class="content">
    <h1><?php echo $fname;?> <?php echo $lname;?></h1>
    <section>
    <h2>Wall:</h2>
    <form action="post.php?id=<?php echo $_GET["id"]; ?>" method="post">
    <textarea style="resize:none" cols="50" rows="5" name="status" placeholder="What's on your mind?"></textarea><br>
    <input type="submit" value="Post" name="post">
    </form>
    <form action="posttimelinephoto.php?id=<?php echo $_GET["id"]; ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Photo" name="uploadphoto">
    </form>
    <hr>
    <?php
    $connect = mysqli_connect("localhost", "root", "") or die ("Couldn't connect to the database");
    mysqli_select_db($conn,"some") or die ("Couldn't find the database");
    $uspo = mysqli_query($conn,"SELECT * FROM posts WHERE onuser='".$_GET['id']."' ORDER BY status_time DESC");
    $posts = "";
    $countpost = mysqli_num_rows($uspo);

    if($countpost == 0){
      $posts = '';
    }else{
      while($rowposts = mysqli_fetch_array($uspo)){
        $post_id = $rowposts['post_id'];
        $user_post_id = $rowposts['user_id_p'];
        $onuser = $rowposts['onuser'];
        $status = $rowposts['status'];
        $statusimage = $rowposts['status_image'];
        $statustime = $rowposts['status_time'];

              $posterid=$user_post_id;
              $posterinfos=mysqli_query($conn,"select  *  from  user  where  id='$posterid'  ");
              $rowposter=mysqli_fetch_array($posterinfos);
              $posterid=$rowposter['id'];
              $posterfname=$rowposter['fname'];
              $posterlname=$rowposter['lname'];
              $posterphotoprofile=$rowposter['photoprofile'];

                $likesinfos=mysqli_query($conn,"select  *  from  likes  where postid='$post_id' and likestatus='1' ");
                $countlikes = mysqli_num_rows($likesinfos);

                $likesdata=mysqli_query($conn,"select likeuseroneid from likes where likeuseroneid='$mainid' and postid='$post_id' and likestatus='1' ");
                $rowlikes=mysqli_fetch_array($likesdata);
                $ifiliked=$rowlikes['likeuseroneid'];

              $viewcomms="<a href='viewfullconvertation.php?postid=".$post_id."'>View full comments</a>";

              $commentload=mysqli_query($conn,"select  *  from  comments  where  postid='$post_id'  ");
              $countcomments=mysqli_num_rows($commentload);
              if($countcomments == 0){
                $usercomment="";
                $viewfullcomments="";
              }else{
              while($rowcomments=mysqli_fetch_array($commentload)){

              $commentid=$rowcomments['commentid'];
              $commenterid=$rowcomments['commenterid'];
              $commentbody=$rowcomments['comment'];

                      $commenterinfos=mysqli_query($conn,"select  *  from  user  where  id='$commenterid'  ");
                      $rowcommenterinf=mysqli_fetch_array($commenterinfos);
                      $commenterfname=$rowcommenterinf['fname'];
                      $commenterlname=$rowcommenterinf['lname'];
                      $commenterphotoprofile=$rowcommenterinf['photoprofile'];


                      $usercomment="<tr><td colspan='1'><img style='width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;' src='".$commenterphotoprofile."'></img> ".$commenterfname.' '.$commenterlname.': '.$commentbody."</td>";
                      $viewfullcomments="<td colspan='1'>".$viewcomms."<br>(".$countcomments.") comments. </td></tr>";


                     

              }
            }

        if($id == $_SESSION['id'] AND $posterid == $_SESSION['id']){
          if($ifiliked==$mainid){
                  if($statusimage=='NULL'){
                $posts .= '<table style="max-width: 600px;" border="1" width="100%"><tr><td>
                <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br>'.$statustime.'<br>
            
              <form action="unlike.php?id='.$post_id.'" method="post">
              <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
              <form action="postreaction.php?id='.$post_id.'" method="post">
              <input type="text" name="commentbody" placeholder="comment..."/>
              <input type="submit" value="Post" name="postcom"/>
              </form></td>
              <td><form method="post" action="postcontrol.php?id='.$post_id.'"><input type="submit" value="Edit" name="edit"><input type="submit" value="Delete" name="delete"></form></td>
              </tr>
              '.$usercomment.$viewfullcomments.'
              </table>
              <hr>';}else{
                $posts .= '<table style="max-width: 600px;" border="1" width="100%"><tr><td>
                <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br><img id="myImg" style="width: 100%; height: 100%;max-width: 650px;max-height: 400px; object-fit: cover;" src="'.$statusimage.'" alt="'.$status.'"></img><br>'.$statustime.'<br>
            
              <form action="unlike.php?id='.$post_id.'" method="post">
              <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
              <form action="postreaction.php?id='.$post_id.'" method="post">
              <input type="text" name="commentbody" placeholder="comment..."/>
              <input type="submit" value="Post" name="postcom"/>
              </form></td>
              <td><form method="post" action="postcontrol.php?id='.$post_id.'"><input type="submit" value="Edit Description" name="edit"><input type="submit" value="Delete" name="delete"></form></td>
              </tr>
              '.$usercomment.$viewfullcomments.'
              </table>
              <hr>';
              }
            }else{
                if($statusimage=='NULL'){
                $posts .= '<table style="max-width: 600px;" border="1" width="100%"><tr><td>
                <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br>'.$statustime.'<br>
            
              <form action="like.php?id='.$post_id.'" method="post">
              <input type="submit" value="Like" name="like"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
              <form action="postreaction.php?id='.$post_id.'" method="post">
              <input type="text" name="commentbody" placeholder="comment..."/>
              <input type="submit" value="Post" name="postcom"/>
              </form></td>
              <td><form method="post" action="postcontrol.php?id='.$post_id.'"><input type="submit" value="Edit" name="edit"><input type="submit" value="Delete" name="delete"></form></td>
              </tr>
              '.$usercomment.$viewfullcomments.'
              </table>
              <hr>';}else{
                $posts .= '<table style="max-width: 600px;" border="1" width="100%"><tr><td>
                <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br><img id="myImg" style="width: 100%; height: 100%;max-width: 650px;max-height: 400px; object-fit: cover;" src="'.$statusimage.'" alt="'.$status.'"></img><br>'.$statustime.'<br>
            
              <form action="like.php?id='.$post_id.'" method="post">
              <input type="submit" value="Like" name="like"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
              <form action="postreaction.php?id='.$post_id.'" method="post">
              <input type="text" name="commentbody" placeholder="comment..."/>
              <input type="submit" value="Post" name="postcom"/>
              </form></td>
              <td><form method="post" action="postcontrol.php?id='.$post_id.'"><input type="submit" value="Edit Description" name="edit"><input type="submit" value="Delete" name="delete"></form></td>
              </tr>
              '.$usercomment.$viewfullcomments.'
              </table>
              <hr>';
              }
            }
        }elseif($id == $_SESSION['id'] AND $posterid!=$_SESSION['id']){
          if($ifiliked==$mainid){
                  if($statusimage=='NULL'){
                $posts .= '<table style="max-width: 600px; "  border="1" width="100%"><tr><td>
                <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br>'.$statustime.'<br>
            
              <form action="unlike.php?id='.$post_id.'" method="post">
              <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
              <form action="postreaction.php?id='.$post_id.'" method="post">
              <input type="text" name="commentbody" placeholder="comment..."/>
              <input type="submit" value="Post" name="postcom"/>
              </form></td>
                <td><form action="postcontrol.php?id='.$post_id.'" method="post"><input type="submit" value="Delete" name="delete"></form></td>
              </tr>
              '.$usercomment.$viewfullcomments.'
              </table><hr>';}else{
                $posts .= '<table style="max-width: 600px;" border="1" width="100%"><tr><td>
                <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br><img id="myImg" style="width: 100%; height: 100%;max-width: 650px;max-height: 400px; object-fit: cover;" src="'.$statusimage.'" alt="'.$status.'"></img><br>'.$statustime.'<br>
            
              <form action="unlike.php?id='.$post_id.'" method="post">
              <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
              <form action="postreaction.php?id='.$post_id.'" method="post">
              <input type="text" name="commentbody" placeholder="comment..."/>
              <input type="submit" value="Post" name="postcom"/>
              </form></td>
                <td><form action="postcontrol.php?id='.$post_id.'" method="post"><input type="submit" value="Delete" name="delete"></form></td>
              </tr>
              '.$usercomment.$viewfullcomments.'
              </table><hr>';
              }
            }else{
                  if($statusimage=='NULL'){
                $posts .= '<table style="max-width: 600px; "  border="1" width="100%"><tr><td>
                <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br>'.$statustime.'<br>
            
              <form action="like.php?id='.$post_id.'" method="post">
              <input type="submit" value="Like" name="like"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
              <form action="postreaction.php?id='.$post_id.'" method="post">
              <input type="text" name="commentbody" placeholder="comment..."/>
              <input type="submit" value="Post" name="postcom"/>
              </form></td>
                <td><form action="postcontrol.php?id='.$post_id.'" method="post"><input type="submit" value="Delete" name="delete"></form></td>
              </tr>
              '.$usercomment.$viewfullcomments.'
              </table><hr>';}else{
                $posts .= '<table style="max-width: 600px;" border="1" width="100%"><tr><td>
                <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br><img id="myImg" style="width: 100%; height: 100%;max-width: 650px;max-height: 400px; object-fit: cover;" src="'.$statusimage.'" alt="'.$status.'"></img><br>'.$statustime.'<br>
            
              <form action="like.php?id='.$post_id.'" method="post">
              <input type="submit" value="Like" name="like"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
              <form action="postreaction.php?id='.$post_id.'" method="post">
              <input type="text" name="commentbody" placeholder="comment..."/>
              <input type="submit" value="Post" name="postcom"/>
              </form></td>
                <td><form action="postcontrol.php?id='.$post_id.'" method="post"><input type="submit" value="Delete" name="delete"></form></td>
              </tr>
              '.$usercomment.$viewfullcomments.'
              </table><hr>';
              }              
            }
        }elseif($id!=$_SESSION['id'] AND $posterid==$_SESSION['id']){
          if($ifiliked==$mainid){
                    if($statusimage=='NULL'){
                  $posts .= '<table style="max-width: 600px; "  border="1" width="100%"><tr><td>
                  <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br>'.$statustime.'<br>
              
                <form action="unlike.php?id='.$post_id.'" method="post">
                <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                <form action="postreaction.php?id='.$post_id.'" method="post">
                <input type="text" name="commentbody" placeholder="comment..."/>
                <input type="submit" value="Post" name="postcom"/>
                </form></td>
                <td><form action="postcontrol.php?id='.$post_id.'" method="post"><input type="submit" value="Edit" name="edit"><input type="submit" value="Delete" name="delete"></form></td>
                </tr>
                '.$usercomment.$viewfullcomments.'
                </table><hr>';}else{
                  $posts .= '<table style="max-width: 600px;" border="1" width="100%"><tr><td>
                  <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br><img id="myImg" style="width: 100%; height: 100%;max-width: 650px;max-height: 400px; object-fit: cover;" src="'.$statusimage.'" alt="'.$status.'"></img><br>'.$statustime.'<br>
              
                <form action="unlike.php?id='.$post_id.'" method="post">
                <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                <form action="postreaction.php?id='.$post_id.'" method="post">
                <input type="text" name="commentbody" placeholder="comment..."/>
                <input type="submit" value="Post" name="postcom"/>
                </form></td>
                <td><form action="postcontrol.php?id='.$post_id.'" method="post"><input type="submit" value="Edit" name="edit"><input type="submit" value="Delete" name="delete"></form></td>
                </tr>
                '.$usercomment.$viewfullcomments.'
                </table><hr>';
                }
          }else{
                    if($statusimage=='NULL'){
                  $posts .= '<table style="max-width: 600px; "  border="1" width="100%"><tr><td>
                  <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br>'.$statustime.'<br>
              
                <form action="like.php?id='.$post_id.'" method="post">
                <input type="submit" value="Like" name="like"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                <form action="postreaction.php?id='.$post_id.'" method="post">
                <input type="text" name="commentbody" placeholder="comment..."/>
                <input type="submit" value="Post" name="postcom"/>
                </form></td>
                <td><form action="postcontrol.php?id='.$post_id.'" method="post"><input type="submit" value="Edit" name="edit"><input type="submit" value="Delete" name="delete"></form></td>
                </tr>
                '.$usercomment.$viewfullcomments.'
                </table><hr>';}else{
                  $posts .= '<table style="max-width: 600px;" border="1" width="100%"><tr><td>
                  <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br><img id="myImg" style="width: 100%; height: 100%;max-width: 650px;max-height: 400px; object-fit: cover;" src="'.$statusimage.'" alt="'.$status.'"></img><br>'.$statustime.'<br>
              
                <form action="like.php?id='.$post_id.'" method="post">
                <input type="submit" value="Like" name="like"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                <form action="postreaction.php?id='.$post_id.'" method="post">
                <input type="text" name="commentbody" placeholder="comment..."/>
                <input type="submit" value="Post" name="postcom"/>
                </form></td>
                <td><form action="postcontrol.php?id='.$post_id.'" method="post"><input type="submit" value="Edit" name="edit"><input type="submit" value="Delete" name="delete"></form></td>
                </tr>
                '.$usercomment.$viewfullcomments.'
                </table><hr>';
                }            
          }
        }else{
          if($ifiliked==$mainid){
                    if($statusimage=='NULL'){
                  $posts .= '<table border="1" style="max-width: 600px;"  width="100%"><tr><td>
                  <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br>'.$statustime.'<br>
              
                <form action="unlike.php?id='.$post_id.'" method="post">
                <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                <form action="postreaction.php?id='.$post_id.'" method="post">
                <input type="text" name="commentbody" placeholder="comment..."/>
                <input type="submit" value="Post" name="postcom"/>
                </form></td>
                '.$usercomment.$viewfullcomments.'
                </table><hr>';}else{
                  $posts .= '<table style="max-width: 600px;" border="1" width="100%"><tr><td>
                  <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br><img id="myImg" style="width: 100%; height: 100%;max-width: 650px;max-height: 400px; object-fit: cover;" src="'.$statusimage.'" alt="'.$status.'"></img><br>'.$statustime.'<br>
              
                <form action="unlike.php?id='.$post_id.'" method="post">
                <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                <form action="postreaction.php?id='.$post_id.'" method="post">
                <input type="text" name="commentbody" placeholder="comment..."/>
                <input type="submit" value="Post" name="postcom"/>
                </form></td></tr>
                '.$usercomment.$viewfullcomments.'
                </table><hr>';
              }
          }else{
                    if($statusimage=='NULL'){
                  $posts .= '<table border="1" style="max-width: 600px;"  width="100%"><tr><td>
                  <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br>'.$statustime.'<br>
              
                <form action="like.php?id='.$post_id.'" method="post">
                <input type="submit" value="Like" name="like"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                <form action="postreaction.php?id='.$post_id.'" method="post">
                <input type="text" name="commentbody" placeholder="comment..."/>
                <input type="submit" value="Post" name="postcom"/>
                </form></td>
                '.$usercomment.$viewfullcomments.'
                </table><hr>';}else{
                  $posts .= '<table style="max-width: 600px;" border="1" width="100%"><tr><td>
                  <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br><img id="myImg" style="width: 100%; height: 100%;max-width: 650px;max-height: 400px; object-fit: cover;" src="'.$statusimage.'" alt="'.$status.'"></img><br>'.$statustime.'<br>
              
                <form action="like.php?id='.$post_id.'" method="post">
                <input type="submit" value="Like" name="like"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                <form action="postreaction.php?id='.$post_id.'" method="post">
                <input type="text" name="commentbody" placeholder="comment..."/>
                <input type="submit" value="Post" name="postcom"/>
                </form></td></tr>
                '.$usercomment.$viewfullcomments.'
                </table><hr>';
                }        
          }
        }
      }
    }
    ?>
    <?php echo $posts; ?>


    </section>
  </article>
  <footer>
  </footer>
  </div>
<div class="footer">
<font color="white" size="2">
<form method="get" action="search.php" class="searchbox">
<input type="text" class="search" placeholder="Search for friends..." name="search">
</form>
</font>
</div>
</body>
</html>