<style>

    /* FOOTER MERCEDES */
.merc-footer {
    background: #0b0b0b;
    color: #e6e6e6;
    padding: 50px 0 20px;
    font-family: 'Poppins', sans-serif;
    margin-top: 50px;
    box-shadow: 0 -4px 25px rgba(0,0,0,0.4);
}

.footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 35px;
}

.footer-col h3, 
.footer-col h4 {
    color: #ffcc00;
    margin-bottom: 18px;
    font-weight: 600;
}

.footer-col p, 
.footer-col a {
    color: #e6e6e6;
    font-size: 15px;
    margin-bottom: 10px;
    display: block;
    text-decoration: none;
    transition: 0.3s ease;
}

.footer-col a:hover {
    color: #ffcc00;
    padding-left: 4px;
}

.footer-social a {
    font-size: 22px;
    color: #e6e6e6;
    margin-right: 15px;
    transition: 0.3s ease;
}

.footer-social a:hover {
    color: #ffcc00;
    transform: translateY(-3px);
}

.footer-bottom {
    border-top: 1px solid #333;
    margin-top: 30px;
    padding-top: 15px;
    text-align: center;
    font-size: 14px;
    color: #b5b5b5;
}

</style>
<footer class="merc-footer">
    <div class="container">

        <div class="footer-grid">

            <!-- Cột 1 -->
            <div class="footer-col">
                <h3>MERCEDES SHOWROOM</h3>
                <p>Xe sang – Bảo hành chính hãng</p>
                <p><i class="fa-solid fa-location-dot"></i>Vĩnh Long, Quốc Lộ 1A, Trường đại học Cữu Long</p>
                <p><i class="fa-solid fa-phone"></i> 0909 999 888</p>
                <p><i class="fa-solid fa-envelope"></i> NgocTy@mercedes.com</p>
            </div>

            <!-- Cột 2 -->
            <div class="footer-col">
                <h4>Liên kết nhanh</h4>
                <a href="index.php">Trang chủ</a>
                <a href="products.php">Sản phẩm</a>
                <a href="#">Giới thiệu</a>
                <a href="#">Liên hệ</a>
            </div>

            <!-- Cột 3 -->
            <div class="footer-col">
                <h4>Theo dõi chúng tôi ngay nào</h4>
                <div class="footer-social">
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            © 2025 Mercedes Showroom - All rights reserved.
        </div>
        
    </div>
</footer>
