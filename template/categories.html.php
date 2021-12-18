<h2>Categories</h2>

<a href="/category/edit">Add a new Category</a>

<?php foreach ($categories as $category): ?>
    <blockquote>
        <p>
            <?=htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8')?>

            <a href="/category/edit?id=<?=$category->id?>">Edit</a>

            <form action="/category/delete" method="post">
                <input type="hidden" name="id" value="<?=$category->id?>">
                <input type="submit" value="Delete" class="block-submit">
            </form>
        </p>
    </blockquote>
<?php endforeach?>
