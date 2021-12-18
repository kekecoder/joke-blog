<h2>User List</h2>

<table>
    <thead>
        <th>Name</th>
        <th>Email</th>
        <th>Edit</th>
    </thead>
    <tbody>
        <?php foreach($authors as $author): ?>
            <tr>
                <td><?=$author->authorname?></td>
                <td><?=$author->authoremail?></td>
                <td>
                    <a href="/author/permission?id=<?=$author->id?>">Edit</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>