<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <link rel="stylesheet" href="/css/joke.css">
</head>
<body>
    <!-- header begins from here -->
    <header>
        <h1>Internet Joke Database</h1>
    </header>
    <!-- header end from here -->

    <!-- nav begins from here -->
    <nav>
        <?php include __DIR__ . '/nav.html.php';?>
    </nav>
    <!-- nav ends here -->
    <!-- main begins here -->
    <main>
        <?=$output?>
    </main>
    <!-- main ends here -->
    <!-- footer begins from here -->
    <footer>
        <?php include __DIR__ . '/footer.html.php';?>
    </footer>
    <!-- footer ends here -->
</body>
</html>