<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM actor ORDER BY actor_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$Actors = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_actors = $pdo->query('SELECT COUNT(*) FROM actor')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Actor File</h2>
	<a href="create_actor.php" class="create-button">Create Actor</a>
	<table>
        <thead>
            <tr>
                <td>Actor_id</td>
                <td>First_Name</td>
                <td>Last_Name</td>
                <td>Last_Update</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Actors as $Actor): ?>
            <tr>
                <td><?=$Actor['actor_id']?></td>
                <td><?=$Actor['first_name']?></td>
                <td><?=$Actor['last_name']?></td>
                <td><?=$Actor['last_update']?></td>
                <td class="actions">
                    <a href="update_actor.php?actor_id=<?=$Actor['actor_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i>Edit</a>
                    <a href="delete_actor.php?actor_id=<?=$Actor['actor_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i>Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read_actor.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_actors): ?>
		<a href="read_actor.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>