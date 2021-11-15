<?php if (isset($error)):
    echo '<div class="errors">' . $error . '</div';
endif?>

<form action="" method="post">
    <label for="email">Enter Your Email Address</label>
    <input type="text" name="authoremail" id="email">

    <label for="password">Your Password</label>
    <input type="password" name="password" id="password">

    <input type="submit" value="Login" name="login">
</form>

<p>Don't have an account? <a href="/author/register">Click here to register</a>.</p>
