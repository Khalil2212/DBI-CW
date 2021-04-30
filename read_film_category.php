<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM film_category ORDER BY film_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$Film_CS = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_Film_CS = $pdo->query('SELECT COUNT(*) FROM film_category')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Film_Category File</h2>
	<a href="create_film_category.php" class="create-button">Create a category</a>
	<table>
        <thead>
            <tr>
                <td>Film_id</td>
                <td>Category_id</td>
                <td>Last_Update</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Film_CS as $Film_C): ?>
            <tr>
                <td><?=$Film_C['film_id']?></td>
                <td><?=$Film_C['category_id']?></td>
                <td><?=$Film_C['last_update']?></td>
                <td class="actions">
                    <a href="update_film_Category.php?film_id=<?=$Film_C['film_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i>Edit</a>
                    <a href="delete_film_category.php?film_id=<?=$Film_C['film_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i>Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read_film_category.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_Film_CS): ?>
		<a href="read_film_category.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>