<ul>
    <li><a href="/">Home</a></li>
    <li><a href="/joke/list">Jokes List</a></li>
    <li><a href="/joke/edit">Add a new Joke</a></li>

    <?php if ($loggedIn): ?>
        <li><a href="/logout">Log Out</a></li>
        <?php else: ?>
        <li><a href="/login">Log In</a></li>
    <?php endif?>
</ul>
