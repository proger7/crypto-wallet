<!-- FOOTER -->
		<footer>
			<div class="container">
				
				<div class="footer-bottom">
					<div class="left">
						<nav class="clearfix">
							<ul class="list-inline">
								<li><a href="<?php echo $settings['url']; ?>page/terms-of-services"><?php echo $lang['terms_of_services']; ?></a></li>
								<li><a href="<?php echo $settings['url']; ?>page/privacy-policy"><?php echo $lang['privacy_policy']; ?></a></li>
								<li><a href="<?php echo $settings['url']; ?>faq"><?php echo $lang['faq_short']; ?></a></li>
								<li><a href="<?php echo $settings['url']; ?>contact-us"><?php echo $lang['contact_us']; ?></a></li>
							</ul>
						</nav>
						<p class="copyright-text">&copy; <?php echo date('Y') ?> <a href="http://mirak.no">www.mirak.no</a>. All Rights Reserved.</p>
					</div>
					<ul class="right list-inline social-icons social-icons-bordered social-icons-small social-icons-fullrounded">
						<li><a href="<?php echo $settings['fb_link']; ?>"><i class="fa fa-facebook"></i></a></li>
						<li><a href="<?php echo $settings['tw_link']; ?>"><i class="fa fa-twitter"></i></a></li>
					</ul>
				</div>
			</div>
		</footer>
		<!-- END FOOTER -->
		<div class="back-to-top">
			<a href="#top"><i class="fa fa-chevron-up"></i></a>
		</div>
	</div>
	<!-- END WRAPPER -->
	<!-- JAVASCRIPT -->
	<script src="<?php echo $settings['url']; ?>assets/js/jquery-2.1.1.min.js"></script>
	<script src="<?php echo $settings['url']; ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo $settings['url']; ?>assets/js/bootstrap-notify.min.js"></script>
	<script src="<?php echo $settings['url']; ?>assets/js/plugins/easing/jquery.easing.min.js"></script>
	<script src="<?php echo $settings['url']; ?>assets/js/plugins/morphext/morphext.min.js"></script>
	<script src="<?php echo $settings['url']; ?>assets/js/plugins/owl-carousel/owl.carousel.min.js"></script>
	<script src="<?php echo $settings['url']; ?>assets/js/bravana.js"></script>
	<script src="<?php echo $settings['url']; ?>assets/js/bravana.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function () {
            $.fn.selectpicker.Constructor.BootstrapVersion = '3';

            $('.selectpicker').selectpicker({
                iconBase: 'fa'
            });
        });
    </script>

	<input type="hidden" id="url" value="<?php echo $settings['url']; ?>">
</body>

</html>
