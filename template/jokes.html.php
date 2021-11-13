      <p><?=$totalJokes?> jokes has been submitted</p>
        <h1>Internet Joke Database</h1>
        <p>welcome to the Internet Joke Database</p>
        <?php foreach ($jokes as $joke): ?>
  <blockquote class="jokes">
    <p>
      <?=htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8')?> <br>
          (by <a href="mailto:<?php echo htmlspecialchars($joke['authoremail']) ?>"><?php echo htmlspecialchars($joke['authorname']) ?></a>)
          on <?php
$date = new DateTime($joke['jokedate']);
echo $date->format('jS F Y');
?>
          <a href="/joke/edit?id=<?=$joke['jokeid']?>">Edit Joke</a>

      <form action="/joke/delete" method="post">
        <input type="hidden" name="jokeid" value="<?=$joke['jokeid']?>">
        <input type="submit" value="Delete" class="block-submit">
      </form>
    </p>
  </blockquote>
  <?php endforeach;?>