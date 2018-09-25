<?php
					$prefix = protect($_GET['prefix']);
						$query = $db->query("SELECT * FROM btc_pages WHERE prefix='$prefix'");
						if($query->num_rows==0) { header("Location: $settings[url]"); }
							$row = $query->fetch_assoc();
							?>
							<!-- PAGE HEADER WITH BACKGROUND IMAGE -->
		<div id="page-header-services" class="page-header has-background-image">
			<div class="overlay"></div>
			<div class="container">
				<h1 class="page-title"><?php echo $row['title']; ?></h1>
			</div>
		</div>
		<!-- END PAGE HEADER WITH BACKGROUND IMAGE -->
		<!-- PAGE CONTENT -->
		<div class="page-content no-margin-bottom">
			<!-- SERVICES -->
			<section>
				<div class="container">
					<div class="row margin-top-20">
						<div class="col-md-12">
							<?php echo $row['content']; ?>
						</div>
					</div>
				</div>
			</section>
			<!-- END SERVICES -->