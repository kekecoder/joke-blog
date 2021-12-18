<?php if (isset($error)):
    echo '<div class="errors">' . $error . '</div';
endif?>

<form action="" method="post" class="forms">
    <label for="email">Enter Your Email Address</label>
    <input type="text" name="authoremail" id="email" class="form-control">

    <label for="password">Your Password</label>
    <input type="password" name="password" id="password" class="form-control">

    <input type="submit" value="Login" name="login" class="submit reg">
    <p>Don't have an account? <a href="/author/register">Click here to register</a>.</p>
</form>
