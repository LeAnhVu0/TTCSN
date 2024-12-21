<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đơn Hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .container {
            margin: 20px auto;
            max-width: 1200px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #e7f3fe;
            border-radius: 8px;
        }
        .summary-item {
            flex: 1;
            text-align: center;
            padding: 10px;
            border: 1px solid #b3d7ff;
            border-radius: 5px;
            background-color: #f9fbfc;
            margin: 0 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: black;
        }
        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 5px;
        }
        .cancel-btn {
            background-color: #dc3545;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .status-title {
            margin-top: 20px;
            font-size: 1.5em;
            color: #333;
        }
        a{
            text-decoration: none;
            color: black;
        }
    </style>
</head>
<body>

<div class="container">
<?php
    include('qldh/index.php');
       if(isset($_GET['value']))
       {
        $tam=$_GET['value'];
       } 
       else
       {
        $tam ='';
       }
       if($tam=='duyetdh')
       {
        include('qldh/duyetdh.php');
       }
       elseif($tam=='dhthanhcong')
       {
        include('qldh/dhthanhcong.php');
       }
       elseif($tam=='huydh')
       {
        include('qldh/huydonhang.php');
       }
       ?>
</div>
</body>
</html>