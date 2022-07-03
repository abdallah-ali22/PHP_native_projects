<?php include("includes/init.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php

if(empty($_GET['id'])) {
    redirect("users.php");
}
else {
    $user = User::search_by_id($_GET['id']) ;
    if($user) {
        $session->message("The {$user->username} user has been deleted");
        $user->delete();
        
    }
    redirect("users.php");
}

?>