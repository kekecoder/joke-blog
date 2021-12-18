<div class="jokelist">
  <ul class="categories">
    <?php foreach ($categories as $category): ?>
      <li>
        <a href="/joke/list?category=<?=$category->id?>"><?=$category->name?></a>
      </li>
    <?php endforeach?>
  </ul>
</div>
  <div class="jokes">
    <p><?=$totalJokes?> jokes has been submitted</p>
        <h1>Internet Joke Database</h1>
        <p>welcome to the Internet Joke Database</p>
        <?php foreach ($jokes as $joke): ?>
  <blockquote class="jokes">
    <p>
      <?=htmlspecialchars($joke->joketext, ENT_QUOTES, 'UTF-8')?> <br>
          (by <a href="mailto:<?php echo htmlspecialchars($joke->getAuthor()->authoremail) ?>"><?php echo htmlspecialchars($joke->getAuthor()->authorname) ?></a>)
          on <?php
$date = new DateTime($joke->jokedate);
echo $date->format('jS F Y');
?>
  <?php if ($userId == $joke->authorid): ?>
          <a href="/joke/edit?id=<?=$joke->id?>">Edit Joke</a>

      <form action="/joke/delete" method="post">
        <input type="hidden" name="id" value="<?=$joke->id?>">
        <input type="submit" value="Delete" class="block-submit">
      </form>
      <?php endif?>
    </p>
  </blockquote>
  <?php endforeach;?>
  </div>