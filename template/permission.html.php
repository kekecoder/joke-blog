<h2>Edit <?=$author->authorname?>'s Permission</h2>

<form action="" method="post" class="forms">
    <?php foreach ($permission as $name => $value): ?>
        <div>
            <input type="checkbox" value="<?=$value?>" name="permission[]"
                <?php if ($author->hasPermission($value)): ?>
                    echo 'checked';
                <?php endif?>
            >
            <label for=""><?=$name?></label>

            <input type="submit" value="Submit">
        </div>
    <?php endforeach?>
</form>