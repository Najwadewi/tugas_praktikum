<?php
session_start();
ob_start();

if (empty($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu');</script>";
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <header>
        <div>Dashboard</div>
        <div class="username">
            <?php
                $username = $_SESSION['username'];
                echo "<h2>Hi, $username</h2>";
            ?>
        </div>
    </header>

    <div class="container">
        <aside>
            <ul class="menu">
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="tabel-makanan.php">Makanan Khas</a></li>
                <li><a href="logout.php">Keluar</a></li>
            </ul>
        </aside>

        <section class="main">
            <section class="content">
                <h1>Daftar Makanan Khas Sulawesi Selatan</h1>

                <form id="food-form">
                    <h2>Tambah Makanan</h2>

                    <label for="food-name">Nama Makanan</label>
                    <input type="text" id="food-name" name="food-name" placeholder="Masukkan nama makanan...">

                    <label for="food-desc">Deskripsi Makanan</label>
                    <input type="text" id="food-desc" name="food-desc" placeholder="Masukkan deskripsi makanan">

                    <label for="food-image">Gambar Makanan</label>
                    <input type="file" id="food-image" name="food-image">

                    <div class="add-button">
                        <button type="submit" id="submit-btn">Tambah</button>
                    </div>
                </form>

                <table id="food-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Makanan</th>
                            <th>Gambar</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Coto Makassar</td>
                            <td><img src="assets/coto-makassar.jpg" alt="Coto Makassar" width="100"></td>
                            <td>Hidangan sup tradisional khas Makassar, terbuat dari daging sapi dan rempah khas.</td>
                            <td>
                                <button class="edit-btn" onclick="editRow(this)">Edit</button>
                                <button class="delete-btn" onclick="deleteRow(this)">Hapus</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Pallubasa</td>
                            <td><img src="assets/pallubasa.jpg" alt="Pallubasa" width="100"></td>
                            <td>Makanan khas Makassar, mirip dengan Coto Makassar namun dengan tambahan kelapa parut.
                            </td>
                            <td>
                                <button class="edit-btn" onclick="editRow(this)">Edit</button>
                                <button class="delete-btn" onclick="deleteRow(this)">Hapus</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Pisang Ijo</td>
                            <td><img src="assets/pisang-ijo.jpg" alt="Pisang Ijo" width="100"></td>
                            <td>Hidangan penutup berbahan dasar pisang yang dibalut dengan adonan tepung berwarna hijau.
                            </td>
                            <td>
                                <button class="edit-btn" onclick="editRow(this)">Edit</button>
                                <button class="delete-btn" onclick="deleteRow(this)">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
    </div>
    </div>
    <script>
        let editingRow = null;

        const foodForm = document.getElementById('food-form');
        const foodTable = document.getElementById('food-table').getElementsByTagName('tbody')[0];
        const submitBtn = document.getElementById('submit-btn');

        foodForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const foodName = document.getElementById('food-name').value.trim();
            const foodDesc = document.getElementById('food-desc').value.trim();
            const foodImage = document.getElementById('food-image').files[0];

            if (!foodName || !foodDesc || (!editingRow && !foodImage)) {
                alert("Nama, Deskripsi, dan Gambar harus diisi");
                return;
            }

            if (editingRow) {
                editingRow.cells[1].textContent = foodName;
                editingRow.cells[3].textContent = foodDesc;

                if (foodImage) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        editingRow.cells[2].innerHTML = `<img src="${e.target.result}" alt="${foodName}" width="100">`;

                        submitBtn.textContent = "Tambah";
                        foodForm.reset();
                        editingRow = null;
                    };
                    reader.readAsDataURL(foodImage);
                } else {
                    submitBtn.textContent = "Tambah";
                    foodForm.reset();
                    editingRow = null;
                }

                return;
            }


            const newRow = foodTable.insertRow();
            const cellNo = newRow.insertCell(0);
            const cellName = newRow.insertCell(1);
            const cellImage = newRow.insertCell(2);
            const cellDesc = newRow.insertCell(3);
            const cellAction = newRow.insertCell(4);

            cellNo.textContent = foodTable.rows.length;
            cellName.textContent = foodName;
            cellDesc.textContent = foodDesc;

            const reader = new FileReader();
            reader.onload = function (e) {
                cellImage.innerHTML = `<img src="${e.target.result}" alt="${foodName}" width="100">`;
            };
            reader.readAsDataURL(foodImage);

            cellAction.innerHTML = `
                <button class="edit-btn" onclick="editRow(this)">Edit</button>
                <button class="delete-btn" onclick="deleteRow(this)">Hapus</button>
            `;

            foodForm.reset();
        });

        function deleteRow(button) {
            const row = button.parentElement.parentElement;
            const confirmDelete = confirm("Apakah Anda yakin ingin menghapus data ini?");
            if (confirmDelete) {
                row.remove();
                const rows = foodTable.rows;
                for (let i = 0; i < rows.length; i++) {
                    rows[i].cells[0].textContent = i + 1;
                }
            }
        }

        function editRow(button) {
            const row = button.parentElement.parentElement;
            editingRow = row;

            document.getElementById('food-name').value = row.cells[1].textContent;
            document.getElementById('food-desc').value = row.cells[3].textContent;

            submitBtn.textContent = "Simpan";
        }
    </script>

    <footer>
        Copyright &copy; 2024
    </footer>
</body>

</html>