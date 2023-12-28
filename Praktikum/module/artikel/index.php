<?php
include("../../class/database.php");
include("../../class/formlibrary.php");

$config = include("../../class/config.php");

$db = new Database($config['host'], $config['username'], $config['password'], $config['db_name']);
$q = "";
$sql = 'SELECT * FROM data_barang';

if (isset($_GET['q'])) {
    $q = $_GET['q'];

    $sql .= " WHERE nama LIKE '%{$q}%'";
}

$title = 'Data Barang';
$result = $db->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>

</head>

<body>
        <?php require('../../template/header.php'); ?>
        <h2>Data Barang</h2>
        <div class="main" style="padding-bottom: 20px;">
            <a class="tambah" href="tambah.php">Tambah Barang</a>
        </div>
        <div class="main" style="padding-bottom: 20px;">
        <form action="index.php" method="get">
            <div class="search">
                <label for="q" style="font-weight: bold; color:var(--darkblue); font-size: 15px;">Cari Data: </label>
                <input type="text" id="q" name="q" class="input-q" style="height: 20px; border: 1px solid var(--blue); border-radius: 4px; padding: 5px; box-shadow: 0 0 3px #000000;" value="<?php echo $q ?>" autocomplete="off">
                <input type="submit" name="submit" value="Cari" class="btn btn-primary" style="background-color: rgb(100, 149, 237); color: #ffffff; padding: 6px 24px; font-weight: 700; border: 1px solid var(--white); border-radius: 6px; cursor: pointer;">
            </div>
        </form>
    </div>
        <div class="main">
        <?php
        $limit = 1;

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $sql = "SELECT * FROM data_barang LIMIT $offset, $limit";
        $result = $db->query($sql);

        $total_data = $db->query("SELECT COUNT(*) AS total FROM data_barang")->fetch_assoc()['total'];
        $total_pages = ceil($total_data / $limit);

        echo formlibrary::generateTable($result);

        echo "<div class='pagination' style='margin: 0 auto; width: 100%; padding: 10px 0; list-style: none; display: flex; justify-content: center;'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='?page=$i' style='background-color: var(--white); color: var(--magenta); padding: 5px 10px; border: 1px solid #ccc; border-radius: 4px; cursor: pointer; text-decoration: none;'>$i</a>";
        }
        echo "</div>";
        ?>
        </div>
        <?php require('../../template/footer.php'); ?>
    </div>
</body>

</html>

<?php
// Jangan lupa untuk menutup koneksi setelah selesai menggunakannya
$db->closeConnection();
?>