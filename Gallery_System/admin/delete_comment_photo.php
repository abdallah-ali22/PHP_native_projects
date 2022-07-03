<?php include("includes/init.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php

if(empty($_GET['id'])) {
    redirect("comments.php");
}
else {
    $comment = Comment::search_by_id($_GET['id']) ;
    if($comment) {
        $comment->delete();
    }
    redirect("comment_photo.php?id={$comment->photo_id}");
}

?>