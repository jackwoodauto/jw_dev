
 <?php if($_SESSION['page']['footer_type']==1){ ?>
<!--id footer gives it a massive margin-top of 4000px -->
<footer class="dark" style="margin-top: 20px !important;">

			<!-- Copyrights
			============================================= -->
			<div id="copyrights">

				<div class="container clearfix">

					<div class="col_half">
						<img src="../../imgs/quotecheck/quotecheck_logo.png" alt="Footer Logo" class="footer-logo">

						Copyrights &copy; <?php echo(date("Y")); ?> All Rights Reserved by Automation Squared Ltd.
					</div>

					<div class="col_half col_last tright">
						<div class="copyrights-menu copyright-links fright clearfix">
							<a href="https://www.quotecheck.tech">Home</a>/<a href="#">About</a>/<a href="#">FAQs</a>/<a href="https://www.quotecheck.tech/contact">Contact</a> <br />
						</div>
						<div class="fright clearfix">
							<a href="#" class="social-icon si-small si-borderless nobottommargin si-facebook">
								<i class="icon-facebook"></i>
								<i class="icon-facebook"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless nobottommargin si-twitter">
								<i class="icon-twitter"></i>
								<i class="icon-twitter"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless nobottommargin si-gplus">
								<i class="icon-gplus"></i>
								<i class="icon-gplus"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless nobottommargin si-pinterest">
								<i class="icon-pinterest"></i>
								<i class="icon-pinterest"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless nobottommargin si-vimeo">
								<i class="icon-vimeo"></i>
								<i class="icon-vimeo"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless nobottommargin si-github">
								<i class="icon-github"></i>
								<i class="icon-github"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless nobottommargin si-yahoo">
								<i class="icon-yahoo"></i>
								<i class="icon-yahoo"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless nobottommargin si-linkedin">
								<i class="icon-linkedin"></i>
								<i class="icon-linkedin"></i>
							</a>
						</div>
					</div>

				</div>

			</div><!-- #copyrights end -->

		</footer>
		<?php } ?>
	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>



	<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="/resources/canvas/HTML/js/plugins.js"></script>

	<!-- Boostrap
	============================================= -->
	<script type="text/javascript" src="/resources/canvas/HTML/js/components/bs-filestyle.js"></script>

	<!-- Bootstrap Switch Plugin -->
	<script type="text/javascript" src="/resources/canvas/HTML/js/components/bs-switches.js"></script>

	<!-- Other Scripts
	============================================= -->
	<script type="text/javascript" src="/resources/canvas/HTML/js/functions.js"></script>

	<script type="text/javascript" src="/resources/bloodhound.js"></script>
	<script type="text/javascript" src="/resources/canvas/HTML/js/components/typehead.js"></script>

	<!-- Quotecheck JavaScripts
	============================================= -->
	<script type="text/javascript" src="/resources/qc_global_v1.js"></script>
  <script type="text/javascript" src="/resources/qc_login_v1.js"></script>


	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-27846692-13', 'auto');
	  ga('send', 'pageview');

	</script>
	<script>

	$(document).ready(function(e) {

		$(".file-input-qc").fileinput({
        showUpload: false,
				allowedFileExtensions: ["pdf","jpeg","jpg","png","gif"]
			});
		});

	</script>

	<script type="text/javascript">

		jQuery(window).load(function(){

			var $container = $('#portfolio');

			$container.infinitescroll({
				loading: {
					finishedMsg: '<i class="icon-line-check"></i>',
					msgText: '<i class="icon-line-loader icon-spin"></i>',
					img: "/resources/canvas/HTML/images/preloader-dark.gif",
					speed: 'normal'
				},
				state: {
					isDone: false
				},
				nextSelector: "#load-next-posts a",
				navSelector: "#load-next-posts",
				itemSelector: "article.portfolio-item"
			},
			function( newElements ) {
				$container.isotope( 'appended', $( newElements ) );
				//SEMICOLON.widget.masonryThumbs();
				//SEMICOLON.widget.loadFlexSlider();

				var t = setTimeout( function(){ $container.isotope('layout'); }, 500 );

			});
		});


	</script>

  <?php



		foreach ($additional_footer_code_array as $key => $value){

			echo($value);

		}

		unset($additional_footer_code_array);

		foreach ($additional_footer_scripts as $key => $file){

			include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/$file");

		}

		unset($additional_footer_scripts);

	?>

</body>
</html>
