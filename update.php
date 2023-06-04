<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $Nama = isset($_POST['Nama']) ? $_POST['Nama'] : '';
        $NIDN = isset($_POST['NIDN']) ? $_POST['NIDN'] : '';
        $Jenjang_Pendidikan = isset($_POST['Jenjang_Pendidikan']) ? $_POST['Jenjang_Pendidikan'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE dosen SET id = ?, Nama = ?, NIDN = ?, Jenjang_Pendidikan = ? WHERE id = ?');
        $stmt->execute([$id, $Nama, $NIDN, $Jenjang_Pendidikan, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM dosen WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>



<?=template_header('Read')?>

<div class="content update">
    <h2>Update Dosen #<?=$contact['id']?></h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" value="<?=$contact['id']?>" id="id" readonly>
        <br>
        <label for="Nama">Nama</label>
        <input type="text" name="Nama" value="<?=$contact['Nama']?>" id="Nama">
        <br>
        <label for="NIDN">NIDN</label>
        <input type="text" name="NIDN" value="<?=$contact['NIDN']?>" id="NIDN">
        <br>
        <label for="Jenjang_Pendidikan">Jenjang Pendidikan</label>
        <select name="Jenjang_Pendidikan" id="Jenjang_Pendidikan">
            <option value="S2" <?=($contact['Jenjang_Pendidikan'] == 'S2') ? 'selected' : ''?>>S2</option>
            <option value="S3" <?=($contact['Jenjang_Pendidikan'] == 'S3') ? 'selected' : ''?>>S3</option>
        </select><br>
        <div class="submit-button">
          <input type="submit" value="Update">
        </div>
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>