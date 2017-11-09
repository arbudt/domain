<?php

define('path_httpd_vhost', 'C:\xampp\apache\conf\extra');
define('path_hosts', 'C:\Windows\System32\drivers\etc');
define('path_doc_root', 'D:\server\public_html');

$file_vhost = path_httpd_vhost . "\httpd-vhosts.conf";
$virtualHost = file_get_contents($file_vhost);

echo '<pre>';
echo htmlentities($virtualHost);
echo '</pre>';

$file_host = path_hosts . "\hosts";
$host = file_get_contents($file_host);

echo '<pre>';
echo htmlentities($host);
echo '</pre>';


if (!empty($_POST['nama_domain'])) {
    $namaDomain = trim($_POST['nama_domain']);
    $pathDomain = trim($_POST['path_domain']);

    $directoryAddDomain = str_replace('\\', '/', path_doc_root) . "/" . $pathDomain;

    $addVirtualHost = '
        <VirtualHost ' . $namaDomain . ':80>
            ServerAdmin webmaster@' . $namaDomain . '
            DocumentRoot "' . $directoryAddDomain . '"
            ServerName ' . $namaDomain . '
            ServerAlias www.' . $namaDomain . '
            ErrorLog "logs/' . $namaDomain . '.log"
            CustomLog "logs/' . $namaDomain . '.log" common
            <Directory "' . $directoryAddDomain . '">
                Options Indexes FollowSymLinks Includes ExecCGI
                AllowOverride All
                Order allow,deny
                Allow from all
                Require all granted
            </Directory>
        </VirtualHost>
        ';

    $virtualHost .= $addVirtualHost;
    // Write the contents back to the file
    file_put_contents($file_vhost, $virtualHost);
    $addHost = "\n10.1.1.15 " . $namaDomain;
    $host .= $addHost;
    file_put_contents($file_host, $host);
    if (file_exists(path_doc_root)) {
        $directoryDomain = path_doc_root . "\\" . $pathDomain;

        if (!file_exists($directoryDomain)) {
            mkdir($directoryDomain, 0777, true);
            echo 'create dir domain<br>';
        }

        $pathFileIndex = $directoryDomain . '/index.php';
        if (!file_exists($pathFileIndex)) {
            $contentIndex = '<!DOCTYPE html>
            <html>
                    <head>
                            <meta charset="UTF-8">
                            <title>' . $namaDomain . '</title>
                    </head>
                    <body>
                            <h3>Selamat Datang di ' . $namaDomain . '</h3>
                    </body>
            </html>';

            $handle = fopen($pathFileIndex, 'w');
            if (fwrite($handle, $contentIndex)) {
                chmod($pathFileIndex, 0777);
                fclose($handle);
                echo 'berhasil create halaman web<br>';
                /*
                 * restart apache
                 */
//                $cmd = 'C:\xampp\apache\bin>httpd.exe -k restart';
//                $run = shell_exec($cmdStop);
//                if ($run) {
//                    echo 'berhasil restart';
//                } else {
//                    echo 'gagal restart';
//                }
                $cmdStop = 'C:\xampp>xampp_stop.exe';
                $runStop = shell_exec($cmdStop);
                if (!$runStop) {
                    echo 'gagal stop ' . $runStop . '<br>';
                } else {
                    echo 'berhasil stop<br>';
                    $cmdStart = 'C:\xampp>xampp_start.exe';
                    $runStart = shell_exec($cmdStart);
                    if (!$runStart) {
                        echo 'gagal start<br>';
                    } else {
                        echo 'berhasil start<br>';
                    }
                }
            } else {
                fclose($handle);
                echo 'tidak berhasil create halaman web<br>';
            }
        } else {
            echo 'halaman web sudah ada<br>';
        }
    } else {
        echo 'tidak ditemukan document root : ' . path_doc_root . '<br>';
    }
}

echo '<a href="index.php">Kembali</a>';
