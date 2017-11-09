<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Domain</title>
    </head>
    <body>
        <form method="POST" action="proses.php">
            <label for="nama_domain">Nama Domain</label>
            <input type="text" id="nama_domain" name="nama_domain" required="" value="" maxlength="100"/>
            <label for="path_domain">Path Directory</label>
            <input type="text" name="path_domain" required="" value="" maxlength="100"/>
            <button type="submit">Tambah</button>
        </form>
        <?php
        // put your code here
        ?>
    </body>
</html>
