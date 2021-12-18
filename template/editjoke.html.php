<?php

if (!empty($errors)): ?>
    <div class="errors">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?=$error?></li>
            <?php endforeach?>
        </ul>
    </div>
<?php endif;?>

<?php if (empty($joke->id) || $userId == $joke->authorid): ?>
    <form action="" method="post" class="forms">
        <input type="hidden" name="joke[id]" value="<?=$joke->id ?? ''?>">
        <label for="joketext">Type your joke here:</label>
        <textarea name="joke[joketext]"><?=$joke->joketext ?? ''?></textarea>
        <p>Select Categories for this joke:</p>
        <?php foreach ($categories as $category): ?>
            <?php if ($joke && $joke->hasCategory($category->id)): ?>
                <input type="checkbox" checked name="category[]" id="" value="<?=$category->id?>">
            <?php else: ?>
                <input type="checkbox" name="category[]" id="" value="<?=$category->id?>">
            <?php endif;?>
            <label for=""><?=$category->name?></label>
        <?php endforeach?>
        <input type="submit" value="Save" class="submit">
    </form>
<?php else: ?>
<p>You may only edit jokes that you posted</p>
<?php endif?>
