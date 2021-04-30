<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM film ORDER BY film_id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$Films = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_Films = $pdo->query('SELECT COUNT(*) FROM film')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Film File</h2>
	<a href="create_film.php" class="create-button">Create Film</a>
	<table>
        <thead>
            <tr>
                <td>Film_ID</td>
                <td>Title</td>
                <td>Description</td>
                <td>Release_Year</td>
                <td>Language_ID</td>
                <td>Original_Language_ID</td>
                <td>Rental_Duration</td>
                <td>Rental_Rate</td>
                <td>Length</td>
                <td>Replacement_Cost</td>
                <td>Rating</td>
                <td>Special_features</td>
                <td>Last_Update</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Films as $film): ?>
            <tr>
                <td><?=$film['film_id']?></td>
                <td><?=$film['title']?></td>
                <td><?=$film['description']?></td>
                <td><?=$film['release_year']?></td>
                <td><?=$film['language_id']?></td>
                <td><?=$film['original_language_id']?></td>
                <td><?=$film['rental_duration']?></td>
                <td><?=$film['rental_rate']?></td>
                <td><?=$film['length']?></td>
                <td><?=$film['replacement_cost']?></td>
                <td><?=$film['rating']?></td>
                <td><?=$film['special_features']?></td>
                <td><?=$film['last_update']?></td>
                <td class="actions">
                    <a href="update_film.php?film_id=<?=$film['film_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i>Edit</a>
                    <a href="delete_film.php?film_id=<?=$film['film_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i>Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read_film.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_Films): ?>
		<a href="read_film.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>