<div id="login" class="container-fluid">
    <div id="login-form" class="quizbox">
        <?php if (isset($login_error)) :?>
        <div class="alert error">
            <strong>Error: </strong><?php echo $login_error; ?>
        </div>
        <?php endif; ?>
        <form action="" method="post">
            <h3>Username</h3>
            <input type="text" class="input-block-level" name="username" <?php if (isset($username)) : ?>value="<?php echo $username; ?>"<?php endif; ?> />
            <h3>Password</h3>
            <input type="password" class="input-block-level" name="password" />
            <br />
            <button class="btn btn-large btn-primary" type="submit">Login</button>
        </form>

    </div>
</div>
<?php echo Asset::js('//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js'); ?>
<?php echo Asset::js('bootstrap.min.js'); ?>