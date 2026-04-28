<!-- Footer Section Begin -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="{{ route('home') }}" style="text-decoration:none; font-size:24px; font-weight:800; color:#fff; letter-spacing:2px; text-transform:uppercase;">Fashion <span style="color:#c8a96e;">Marketplace</span></a>
                    </div>
                    <p>Your one-stop shop for Men's, Women's, and Kids' clothing.</p>
                    <a href="#"><img src="{{ asset('img/payment.png') }}" alt=""></a>
                </div>
            </div>
            <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                <div class="footer__widget">
                    <h6>Shopping</h6>
                    <ul>
                        <li><a href="#">Men's Clothing</a></li>
                        <li><a href="#">Women's Clothing</a></li>
                        <li><a href="#">Kids' Clothing</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6">
                <div class="footer__widget">
                    <h6>Support</h6>
                    <ul>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Return & Exchanges</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                <div class="footer__widget">
                    <h6>Newsletter</h6>
                    <div class="footer__newslatter">
                        <p>Be the first to know about new arrivals and promos!</p>
                        <form action="#">
                            <input type="text" placeholder="Your email">
                            <button type="submit"><span class="icon_mail_alt"></span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="footer__copyright__text">
                    <p>Copyright &copy; {{ date('Y') }} Fashion Marketplace. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->