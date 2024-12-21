<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý Sản Phẩm và Danh Mục</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: rgb(250, 248, 250);
      margin: 0;
      
    }

    .container {
      width: 100%;
      max-width: 800px;
      margin: auto;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }

    h2 {
      text-align: center;
      color: #3498db;
    }

    button {
      background-color: #3498db;
      color: #ffffff;
      border: none;
      padding: 10px;
      border-radius: 5px;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
      margin-top: 10px;
    }

    button:hover {
      background-color: #2980b9;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table,
    th,
    td {
      border: 1px solid #ddd;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #007bff;
      color: white;
    }
    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      color: #333;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      resize: vertical;
    }
  </style>
</head>

<body>
  <div class="container">
    <?php
       if(isset($_GET['value']))
       {
        $tam=$_GET['value'];
       } 
       else
       {
        $tam ='';
       }
       if($tam=='themdm')
       {
        include('qlsp/themdm.php');
       }
       elseif($tam=='themsp')
       {
        include('qlsp/themsp.php');
       }
      //  elseif($tam==$row['MaSP'])
      //  {
      //   include('qlsp/suasp.php');
      //  }
       else
       {
        include('qlsp/index.php');
       }
       ?>
  </div>
</body>

</html>