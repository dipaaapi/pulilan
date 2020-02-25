<?php include 'functions.php'; ?>
<?php email_send() ?>
<?php include('../pulilan/adminnav.php'); ?>
    <h1> E-mail</h1>

    <!--******************************Content*********************************-->
    <form method="POST"> 
        <input type="email" class="form-control" name="email" placeholder="your email">
        <textarea cols="30" rows="10" type="text" name="fullname" placeholder="Comment..."></textarea>
        <input type="submit" name="send" name="send">
    </form>

    <!--****************************End Content*******************************-->
            
<?php include('../pulilan/adminfooter.php'); ?>