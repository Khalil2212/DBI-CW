<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['film_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $F_ID = isset($_POST['film_id']) ? $_POST['film_id'] : NULL;
        $Title = isset($_POST['title']) ? $_POST['title'] : '';
        $Last_update = isset($_POST['description']) ? $_POST['description'] :'';
        // Update the record
        $stmt = $pdo->prepare('UPDATE film_text SET film_id = ?, title = ?, last_update = ? WHERE film_id = ?');
        $stmt->execute([$F_ID, $Title, $Last_update,$_GET['film_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM film_text WHERE film_id = ?');
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
	<h2>Update Film_Text #<?=$Cat['film_id']?></h2>
    <form action="update_film_text.php?film_id=<?=$Cat['film_id']?>" method="post">
        <label for="film_id">Film_Id</label>
        <label for="title">Title</label>
        <input type="text" name="film_id" value="<?=$Cat['film_id']?>" id="film_id">
        <input type="text" name="title" placeholder="1" value="<?=$Cat['title']?>" id="title">
        <label for="description">Description</label>
        <input type="text" name="description" placeholder="1" value="<?=$Cat['description']?>" id="description">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>