<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['city_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $CityID = isset($_POST['city_id']) ? $_POST['city_id'] : NULL;
        $City = isset($_POST['city']) ? $_POST['city'] : '';
        $Country = isset($_POST['country_id']) ? $_POST['country_id'] : '';
        $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE city SET city_id = ?, city = ?, country = ?, last_update = ? WHERE city_id = ?');
        $stmt->execute([$CityID, $City, $Country, $Last_update,$_GET['city_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM city WHERE city_id = ?');
    $stmt->execute([$_GET['city_id']]);
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
	<h2>Update city #<?=$Cat['city_id']?></h2>
    <form action="update_city.php?city_id=<?=$Cat['city_id']?>" method="post">
        <label for="city_id">City_ID</label>
        <label for="city">City</label>
        <input type="text" name="city_id" value="<?=$Cat['city_id']?>" id="city_id">
        <input type="text" name="city" value="<?=$Cat['city']?>" id="city">
        <label for="country_id">Country_ID</label>
        <label for="last_update">Last_update</label>
        <input type="text" name="country_id" value="<?=$Cat['country_id']?>" id="country_id">
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i', strtotime($Cat['last_update']))?>" id="last_update">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>