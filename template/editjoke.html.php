
<title><?=$title?></title>
<?php if ($userId == $joke['authorid']): ?>
    <form action="" method="post">
        <input type="hidden" name="joke[jokeid]" value="<?=$joke['jokeid'] ?? ''?>">
        <label for="joketext">Type your joke here:</label>
        <textarea name="joke[joketext]"><?=$joke['joketext'] ?? ''?></textarea>
        <input type="submit" value="Update Joke" class="submit">
    </form>
<?php else: ?>
    <p>You may only edit jokes that you posted</p>
<?php endif?>
