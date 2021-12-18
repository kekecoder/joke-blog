<?php

if (!empty($errors)): ?>
    <div class="errors">
        <p>Your account cannot be created, please check the following:</p>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?=$error?></li>
            <?php endforeach?>
        </ul>
    </div>
<?php endif;?>

<form action="" method="post" class="forms">
    <label for="email">Email Address</label>
    <input type="text" name="author[authoremail]" id="email" value="<?=$author['authoremail'] ?? ''?>" class="form-control">

    <label for="name">Your Name</label>
    <input type="text" name="author[authorname]" id="name" value="<?=$author['authorname'] ?? ''?>" class="form-control">

    <label for="password">Password</label>
    <input type="password" name="author[password]" id="password" class="form-control">

    <input type="submit" value="Register" name="submit" class="submit reg">
</form>
