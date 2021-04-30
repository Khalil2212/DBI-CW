<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM film_actor ORDER BY actor_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$Film_As = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_Film_As = $pdo->query('SELECT COUNT(*) FROM film_actor')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Film_Actor File</h2>
	<a href="create_film_actor.php" class="create-button">Create a city</a>
	<table>
        <thead>
            <tr>
                <td>actor_id</td>
                <td>film_id</td>
                <td>Last_Update</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Film_As as $Film_A): ?>
            <tr>
                <td><?=$Film_A['actor_id']?></td>
                <td><?=$Film_A['film_id']?></td>
                <td><?=$Film_A['last_update']?></td>
                <td class="actions">
                    <a href="update_film_actor.php?actor_id=<?=$Film_A['actor_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i>Edit</a>
                    <a href="delete_film_actor.php?actor_id=<?=$Film_A['actor_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i>Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read_film_actor.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_Film_As): ?>
		<a href="read_film_actor.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>