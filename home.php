<?php
session_start();
if(!isset($_SESSION['email'])) {
  echo "Your session is running " . $_SESSION['email'];
  header('Location: index.php');
}
?>
<?php

 	include('database.php');
 	$user_check=$_SESSION['id'];
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

  $mainid=$_SESSION['id'];

  if($photoprofile==""){
    $photoprofile = "images/basic/photoprofile.png";
  }
  if($photocover==""){
    $photocover = "images/basic/photocover.png";
  }
?>
<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/png" href="images/icon/favicon.ico">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
	<title>Welcome to SoMe <?php echo $fname ?></title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link type="text/css" rel="stylesheet" media="all" href="assets/css/chat.css" />
  <link type="text/css" rel="stylesheet" media="all" href="assets/css/post.css" />
	<script type="text/javascript"></script>
	<script src="assets/jscript/search.js"></script>
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
       		 echo $photoprofile;
     		   ?>
      		  "></img>
     		   </a>
				<a href="#" id="loginregister">Account<img width="12" height="10" src="images/basic/arrow.jpg"></img></a>
				<div class="dropdown-content">
				<b><a href="home.php">Feed</a></b>
          <a href='profile.php?id=<?php echo $_SESSION["id"]; ?> '>Profile</a>
          <a href="settings.php">Settings</a>
          <a href="requestlist.php">Follow Requests</a>
          <a href="reportbugs.php">Report Bugs</a>
          <a href="logout.php">Log Out</a>
				</div>
			</div>
			</aside>
		</section>
	</nav>
<div>
<font color="white">
<section>
<center>
News Feed:
<hr>
</center>
<?php
    $connect = mysqli_connect("localhost", "root", "") or die ("Couldn't connect to the database");
    mysqli_select_db($connect,"some") or die ("Couldn't find the database");
    $uspo = mysqli_query($conn,"SELECT * FROM posts WHERE onuser='$mainid' OR onuser IN(SELECT usertwoid FROM relationship WHERE status='1' AND actionuserid=$mainid) ORDER BY status_time DESC");
    $posts = "";
    $photoposts="";
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
              $rowposter=mysqli_fetch_array($posterinfos,MYSQLI_ASSOC);
              $posterid=$rowposter['id'];
              $posterfname=$rowposter['fname'];
              $posterlname=$rowposter['lname'];
              $posterphotoprofile=$rowposter['photoprofile'];

              $onuserinfos=mysqli_query($conn,"select  *  from  user  where  id='$onuser'  ");
              $rowonuser=mysqli_fetch_array($onuserinfos,MYSQLI_ASSOC);
              $onuserid=$rowonuser['id'];
              $onuserfname=$rowonuser['fname'];
              $onuserlname=$rowonuser['lname'];
              $onuserphotoprofile=$rowonuser['photoprofile'];

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
            if($onuser==$mainid AND $posterid==$mainid){
              if($ifiliked==$mainid){
                          if($statusimage=='NULL'){
                        $posts .= '<a href="profile.php?id='.$posterid.'"><img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'</a><br>'.$status.'<br>'.$statustime.'<br>
                      <form method="post" action="postcontrol.php?id='.$post_id.'"><input type="submit" value="Edit" name="edit"><input type="submit" value="Delete" name="delete"></form>
                      <form action="unlike.php?id='.$post_id.'" method="post">
                        <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                        <form action="postreaction.php?id='.$post_id.'" method="post">
                        <input type="text" name="commentbody" placeholder="comment..."/>
                        <input type="submit" value="Post" name="postcom"/>
                        </form>
                        
                            '.$usercomment.' '.$viewfullcomments.'
                        
                        <hr>';
                          }else{
                          $posts="";
                          $photoposts .= '
                          <a href="profile.php?id='.$posterid.'"><img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'</a><br>'.$status.'<br><img id="myImg" style="width: 100%; height: 100%;max-width: 650px;max-height: 400px; object-fit: cover;" src="'.$statusimage.'" alt="'.$status.'"></img><br>'.$statustime.'<br>
                      
                        <form action="unlike.php?id='.$post_id.'" method="post">
                        <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                        <form action="postreaction.php?id='.$post_id.'" method="post">
                        <input type="text" name="commentbody" placeholder="comment..."/>
                        <input type="submit" value="Post" name="postcom"/>
                        </form>
                        
                            '.$usercomment.' '.$viewfullcomments.'
                        
                        <hr>';
                  }
                }else{
                          if($statusimage=='NULL'){
                          $posts .= '<a href="profile.php?id='.$posterid.'"><img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'</a><br>'.$status.'<br>'.$statustime.'<br>
                        <form method="post" action="postcontrol.php?id='.$post_id.'"><input type="submit" value="Edit" name="edit"><input type="submit" value="Delete" name="delete"></form>
                        <form action="like.php?id='.$post_id.'" method="post">
                          <input type="submit" value="Like" name="like"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                          <form action="postreaction.php?id='.$post_id.'" method="post">
                          <input type="text" name="commentbody" placeholder="comment..."/>
                          <input type="submit" value="Post" name="postcom"/>
                          </form>
                          
                              '.$usercomment.' '.$viewfullcomments.'
                          
                          <hr>';
                          }else{
                            $posts="";
                            $photoposts .= '
                            <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br><img id="myImg" style="width: 100%; height: 100%;max-width: 650px;max-height: 400px; object-fit: cover;" src="'.$statusimage.'" alt="'.$status.'"></img><br>'.$statustime.'<br>
                        
                          <form action="like.php?id='.$post_id.'" method="post">
                          <input type="submit" value="Like" name="like"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                          <form action="postreaction.php?id='.$post_id.'" method="post">
                          <input type="text" name="commentbody" placeholder="comment..."/>
                          <input type="submit" value="Post" name="postcom"/>
                          </form>
                          
                              '.$usercomment.' '.$viewfullcomments.'
                          
                          <hr>';
                            }
              }
            }elseif($onuser==$mainid AND $posterid!=$mainid){//an postarei allos xrhsths sto profile mou
                        if($ifiliked==$mainid){
                            $posts .= '<a href="profile.php?id='.$posterid.'"><img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'</a> ->  <a href="profile.php?id='.$onuserid.'">'.$onuserfname.' '.$onuserlname.'</a><br>'.$status.'<br>'.$statustime.'<form action="postcontrol.php?id='.$post_id.'" method="post"><input type="submit" value="Delete" name="delete"></form>
                            <form action="unlike.php?id='.$post_id.'" method="post">
                          <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                          <form action="postreaction.php?id='.$post_id.'" method="post">
                          <input type="text" name="commentbody" placeholder="comment..."/>
                          <input type="submit" value="Post" name="postcom"/>
                          </form>
                          
                              '.$usercomment.' '.$viewfullcomments.'
                          
                          <hr>';
                        }else{
                            $posts .= '<a href="profile.php?id='.$posterid.'"><img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'</a> ->  <a href="profile.php?id='.$onuserid.'">'.$onuserfname.' '.$onuserlname.'</a><br>'.$status.'<br>'.$statustime.'<form action="postcontrol.php?id='.$post_id.'" method="post"><input type="submit" value="Delete" name="delete"></form>
                            <form action="like.php?id='.$post_id.'" method="post">
                          <input type="submit" value="Like" name="like"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                          <form action="postreaction.php?id='.$post_id.'" method="post">
                          <input type="text" name="commentbody" placeholder="comment..."/>
                          <input type="submit" value="Post" name="postcom"/>
                          </form>
                          
                              '.$usercomment.' '.$viewfullcomments.'
                          
                          <hr>';
                      }
                }elseif($onuser!=$mainid AND $posterid==$mainid){//an postarw egw status se allon xrhsth
                          if($ifiliked==$mainid){
                             $posts .= '<a href="profile.php?id='.$posterid.'"><img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'</a> ->  <a href="profile.php?id='.$onuserid.'">'.$onuserfname.' '.$onuserlname.'</a><br>'.$status.'<br>'.$statustime.'<form action="postcontrol.php?id='.$post_id.'" method="post"><input type="submit" value="Edit" name="edit"><input type="submit" value="Delete" name="delete"></form>
                             <form action="unlike.php?id='.$post_id.'" method="post">
                            <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                            <form action="postreaction.php?id='.$post_id.'" method="post">
                            <input type="text" name="commentbody" placeholder="comment..."/>
                            <input type="submit" value="Post" name="postcom"/>
                            </form>
                            
                                '.$usercomment.' '.$viewfullcomments.'
                            
                            <hr>';
                            }else{
                              $posts .= '<a href="profile.php?id='.$posterid.'"><img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'</a> ->  <a href="profile.php?id='.$onuserid.'">'.$onuserfname.' '.$onuserlname.'</a><br>'.$status.'<br>'.$statustime.'<form action="postcontrol.php?id='.$post_id.'" method="post"><input type="submit" value="Edit" name="edit"><input type="submit" value="Delete" name="delete"></form>
                             <form action="like.php?id='.$post_id.'" method="post">
                            <input type="submit" value="Like" name="like"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                            <form action="postreaction.php?id='.$post_id.'" method="post">
                            <input type="text" name="commentbody" placeholder="comment..."/>
                            <input type="submit" value="Post" name="postcom"/>
                            </form>
                            
                                '.$usercomment.' '.$viewfullcomments.'
                            
                            <hr>';
                            }

                }elseif($onuser!=$mainid AND $posterid!=$mainid AND $onuserid!=$posterid){//an anevasei status enas following mas se allon xrhsth
                    if($ifiliked==$mainid){
                    $posts .= '<a href="profile.php?id='.$posterid.'"><img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'</a> -> <a href="profile.php?id='.$onuserid.'">'.$onuserfname.' '.$onuserlname.'</a><br>'.$status.'<br>'.$statustime.'
                    
                    <form action="unlike.php?id='.$post_id.'" method="post">
                      <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                      <form action="postreaction.php?id='.$post_id.'" method="post">
                      <input type="text" name="commentbody" placeholder="comment..."/>
                      <input type="submit" value="Post" name="postcom"/>
                      </form>
                      <td><form method="post" action="postcontrol.php?id='.$post_id.'"><input type="submit" value="Delete" name="delete"></form>
                      
                      '.$usercomment.' '.$viewfullcomments.'
                      
                      <hr>';
                    }else{
                    $posts .= '<a href="profile.php?id='.$posterid.'"><img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'</a> -> <a href="profile.php?id='.$onuserid.'">'.$onuserfname.' '.$onuserlname.'</a><br>'.$status.'<br>'.$statustime.'
                    <form action="unlike.php?id='.$post_id.'" method="post">
                      <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                      <form action="postreaction.php?id='.$post_id.'" method="post">
                      <input type="text" name="commentbody" placeholder="comment..."/>
                      <input type="submit" value="Post" name="postcom"/>
                      </form>
                      
                          '.$usercomment.' '.$viewfullcomments.'
                      
                      <hr>';}
    }else{
                  if($ifiliked==$mainid){
                          if($statusimage=='NULL'){
                          $posts .= '<a href="profile.php?id='.$posterid.'"><img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'</a><br>'.$status.'<br>'.$statustime.'<br>
                        <form method="post" action="postcontrol.php?id='.$post_id.'"><input type="submit" value="Edit" name="edit"><input type="submit" value="Delete" name="delete"></form>
                        <form action="unlike.php?id='.$post_id.'" method="post">
                          <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                          <form action="postreaction.php?id='.$post_id.'" method="post">
                          <input type="text" name="commentbody" placeholder="comment..."/>
                          <input type="submit" value="Post" name="postcom"/>
                          </form>
                          
                              '.$usercomment.' '.$viewfullcomments.'
                          
                          <hr>';
                          }else{
                            $posts="";
                            $photoposts .= '
                            <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br><img id="myImg" style="width: 100%; height: 100%;max-width: 650px;max-height: 400px; object-fit: cover;" src="'.$statusimage.'" alt="'.$status.'"></img><br>'.$statustime.'<br>
                        
                          <form action="unlike.php?id='.$post_id.'" method="post">
                          <input type="submit" value="Unlike" name="unlike"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                          <form action="postreaction.php?id='.$post_id.'" method="post">
                          <input type="text" name="commentbody" placeholder="comment..."/>
                          <input type="submit" value="Post" name="postcom"/>
                          </form>
                          
                              '.$usercomment.' '.$viewfullcomments.'
                          
                          <hr>';
                            }
                  }else{
                          if($statusimage=='NULL'){
                          $posts .= '<a href="profile.php?id='.$posterid.'"><img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'</a><br>'.$status.'<br>'.$statustime.'<br>
                        <form method="post" action="postcontrol.php?id='.$post_id.'"><input type="submit" value="Edit" name="edit"><input type="submit" value="Delete" name="delete"></form>
                        <form action="like.php?id='.$post_id.'" method="post">
                          <input type="submit" value="Like" name="like"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                          <form action="postreaction.php?id='.$post_id.'" method="post">
                          <input type="text" name="commentbody" placeholder="comment..."/>
                          <input type="submit" value="Post" name="postcom"/>
                          </form>
                          
                              '.$usercomment.' '.$viewfullcomments.'
                          
                          <hr>';
                          }else{
                            $posts="";
                            $photoposts .= '
                            <img style="width: 100%; height: 100%;max-width: 35px;max-height: 35px; object-fit: cover;" src="'.$posterphotoprofile.'"></img> '.$posterfname.' '.$posterlname.'<br>'.$status.'<br><img id="myImg" style="width: 100%; height: 100%;max-width: 650px;max-height: 400px; object-fit: cover;" src="'.$statusimage.'" alt="'.$status.'"></img><br>'.$statustime.'<br>
                        
                          <form action="like.php?id='.$post_id.'" method="post">
                          <input type="submit" value="Like" name="like"/><a href="wholikethis.php?id='.$post_id.'">'.$countlikes.' likes </a></form>
                          <form action="postreaction.php?id='.$post_id.'" method="post">
                          <input type="text" name="commentbody" placeholder="comment..."/>
                          <input type="submit" value="Post" name="postcom"/>
                          </form>
                          
                              '.$usercomment.' '.$viewfullcomments.'
                          
                          <hr>';
                            }
                  }
              } 
          }
    }
    ?>
    <div class="left-side">
    <?php echo $posts; ?>
    </div>
    <div class="right-side">
    <?php echo $photoposts; ?>
    </div>
</section>
</font>
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