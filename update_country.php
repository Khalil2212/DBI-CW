<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['country_id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $CountryID = isset($_POST['country_id']) ? $_POST['country_id'] : NULL;
        $Country = isset($_POST['country']) ? $_POST['country'] : '';
        $Last_update = isset($_POST['last_update']) ? $_POST['last_update'] :date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE country SET country_id = ?, country = ?, last_update = ? WHERE country_id = ?');
        $stmt->execute([$CountryID, $Country, $Last_update,$_GET['country_id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM country WHERE country_id = ?');
    $stmt->execute([$_GET['country_id']]);
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
	<h2>Update country #<?=$Cat['country_id']?></h2>
    <form action="update_country.php?country_id=<?=$Cat['country_id']?>" method="post">
        <label for="country_id">Country_ID</label>
        <label for="country">Country</label>
        <input type="text" name="country_id" value="<?=$Cat['country_id']?>" id="country_id">
        <input type="text" name="country" value="<?=$Cat['country']?>" id="country">
        <label for="last_update">Last_update</label>
        <input type="datetime-local" name="last_update" value="<?=date('Y-m-d\TH:i', strtotime($Cat['last_update']))?>" id="last_update">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>