<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['film_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $CityID = isset($_POST['film_id']) ? $_POST['film_id'] : NULL;
        $City = isset($_POST['rental_duration']) ? $_POST['rental_duration'] : '';
        $Country = isset($_POST['rent_rate']) ? $_POST['rent_rate'] : '';
        $stor = isset($_POST['replacement_cost']) ? $_POST['replacement_cost'] :'';
        // Update the record
        $stmt = $pdo->prepare('UPDATE film_rental SET film_id = ?, rental_duration = ?, rent_rate = ?, replacement_cost = ? WHERE film_id = ?');
        $stmt->execute([$CityID, $City, $Country, $stor,$_GET['film_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM film_rental WHERE film_id = ?');
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
	<h2>Update Record #<?=$Cat['film_id']?></h2>
    <form action="update_film_rental.php?film_id=<?=$Cat['film_id']?>" method="post">
        <label for="film_id">film_id</label>
        <label for="rental_duration">rental_duration</label>
        <input type="text" name="film_id" value="<?=$Cat['film_id']?>" id="film_id">
        <input type="text" name="rental_duration" value="<?=$Cat['rental_duration']?>" id="rental_duration">
        <label for="rent_rate">rent_rate</label>
        <label for="replacement_cost">replacement_cost</label>
        <input type="text" name="rent_rate" value="<?=$Cat['rent_rate']?>" id="rent_rate">
        <input type="text" name="replacement_cost" value="<?=$Cat['replacement_cost']?>" id="replacement_cost">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>