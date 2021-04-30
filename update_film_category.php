<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['film_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $F_ID = isset($_POST['film_id']) ? $_POST['film_id'] : NULL;
        $C_ID = isset($_POST['category_id']) ? $_POST['category_id'] : '';
        $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE film_category SET film_id = ?, category_id = ?, last_update = ? WHERE film_id = ?');
        $stmt->execute([$F_ID, $G_ID, $Last_update,$_GET['film_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM film_category WHERE film_id = ?');
    $stmt->execute([$_GET['film_id']]);
    $Cat = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$Cat) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Film_Category #<?=$Cat['film_id']?></h2>
    <form action="update_film_category.php?film_id=<?=$Cat['film_id']?>" method="post">
        <label for="film_id">Film_Id</label>
        <label for="category_id">Category_Id</label>
        <input type="text" name="film_id" value="<?=$Cat['film_id']?>" id="film_id">
        <input type="text" name="category_id" placeholder="1" value="<?=$Cat['category_id']?>" id="category_id">
        <label for="last_update">Last_update</label>
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i', strtotime($Cat['last_update']))?>" id="last_update">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>