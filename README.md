# MauPedia.com
Example Class

Usage
---------
```php
require('src/MauPedia.php');

$MP = new MauPedia('your_maupedia_apiid', 'your_maupedia_apikey', 'your_maupedia_secretkey');

// PROFILE
echo json_encode($MP->profile(), JSON_PRETTY_PRINT);

// Prabayar
echo json_encode($MP->order('prabayar', ['service' => '', 'data_no' => '']), JSON_PRETTY_PRINT); // Create Order
echo json_encode($MP->status('prabayar', 'ID_Transaksi'), JSON_PRETTY_PRINT); // Check Status
echo json_encode($MP->services('prabayar'), JSON_PRETTY_PRINT); // Data Layanan

// Pascabayar
echo json_encode($MP->order('pascabayar', ['service' => '', 'data_no' => '']), JSON_PRETTY_PRINT); // Create Order
echo json_encode($MP->status('pascabayar', 'ID_Transaksi'), JSON_PRETTY_PRINT); // Check Status
echo json_encode($MP->services('pascabayar'), JSON_PRETTY_PRINT); // Data Layanan

// SOCMED
echo json_encode($MP->order('socmed', ['service' => '', 'data_no' => '']), JSON_PRETTY_PRINT); // Create Order
echo json_encode($MP->status('socmed', 'ID_Transaksi'), JSON_PRETTY_PRINT); // Check Status
echo json_encode($MP->services('socmed'), JSON_PRETTY_PRINT); // Data Layanan

// GAME
echo json_encode($MP->order('game', ['service' => '', 'data_no' => '']), JSON_PRETTY_PRINT); // Create Order
echo json_encode($MP->status('game', 'ID_Transaksi'), JSON_PRETTY_PRINT); // Check Status
echo json_encode($MP->services('game'), JSON_PRETTY_PRINT); // Data Layanan

// DEPOSIT
echo json_encode($MP->deposit('request', ['method' => '', 'quantity' => '', 'sender' => '']), JSON_PRETTY_PRINT); // Create Deposit
echo json_encode($MP->deposit('check', 'ID_Transaksi'), JSON_PRETTY_PRINT); // Check Status
echo json_encode($MP->deposit('cancel', 'ID_Transaksi'), JSON_PRETTY_PRINT); // Cancel Deposit
echo json_encode($MP->deposit('method'), JSON_PRETTY_PRINT); // Metode Deposit

```