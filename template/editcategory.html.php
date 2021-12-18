<form action="" method="post" class="forms">
    <input type="hidden" name="category[id]" value="<?=$category->id ?? ''?>">
    <label for="category">Enter Category Name</label>
    <input type="text" id="categoryname" name="category[name]" value="<?=$category->name ?? ''?>">
    <input type="submit" value="Save" name="submit" class="submit">
</form>