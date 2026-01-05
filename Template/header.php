<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECOMMERCE Header</title>

    <!-- Bootstrap CSS -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
        rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        /* FONT */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    background: #f5f7fa;
}

/* ========== HEADER MERCEDES ========== */
header {
    background: #111;
    color: white;
    padding: 18px 0;
    border-bottom: 3px solid #ffcc00;
    box-shadow: 0 3px 10px rgba(0,0,0,0.35);
}

header h1 {
    font-size: 28px;
    font-weight: 700;
    letter-spacing: 1px;
    color: #ffcc00;
}

header .subtitle {
    font-size: 13px;
    color: #ccc;
}

/* ========== MENU MERCEDES ========== */
.menu-wrap {
    width: 100%;
    background: #000;
    padding: 12px 0;
    margin-top: 10px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.35);
}

.menu-wrap ul {
    margin: 0;
    padding: 0;
    list-style: none;
    display: flex;
    gap: 28px;
    align-items: center;
}

.menu-wrap ul li {
    position: relative;
}

.menu-wrap ul li a {
    text-decoration: none;
    color: #f7f7f7;
    font-weight: 600;
    font-size: 16px;
    padding: 10px 6px;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: 0.3s;
}

.menu-wrap ul li a:hover {
    color: #ffcc00;
}

/* ========== DROPDOWN ========== */
.dropdown2:hover .dropdown-content2 {
    display: block;
}

.dropdown-content2 {
    display: none;
    position: absolute;
    top: 45px;
    background: #1a1a1a;
    min-width: 200px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.5);
    z-index: 1000;
}

.dropdown-content2 a {
    padding: 12px 15px;
    color: #eee;
    border-bottom: 1px solid #333;
    font-size: 15px;
}

.dropdown-content2 a:hover {
    background: #333;
    color: #ffcc00;
}

.dropdown-content2 a:last-child {
    border-bottom: none;
}

/* ========== RESPONSIVE ========== */
@media(max-width: 768px) {
    .menu-wrap ul {
        flex-direction: column;
        gap: 15px;
    }

    .dropdown-content2 {
        position: static;
        width: 100%;
        box-shadow: none;
    }
}

    </style>
</head>
<body>

    <header class="py-3">
    <div class="container d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center">
        <img src="images/logo.jpg" alt="logo" width="110" style="margin-right:16px">
        <div>
          <h1 style="margin:0; font-size:46px; letter-spacing:1px;">MERCEDES SHOWROOM</h1>
          <div style="font-size:13px; color:#666">Xe sang – Bảo hành chính hãng</div>
        </div>
      </div>
      <div>
        <!-- nút giỏ hàng / login nếu cần -->
      </div>
    </div>
  </header>