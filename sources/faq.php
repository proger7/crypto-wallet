
		<div id="page-header-services" class="page-header has-background-image">
			<div class="overlay"></div>
			<div class="container">
				<h1 class="page-title"><?php echo $lang['faq']; ?></h1>
			</div>
		</div>
		<!-- END PAGE HEADER WITH BACKGROUND IMAGE -->
		<!-- PAGE CONTENT -->
		<div class="page-content no-margin-bottom">
			<!-- SERVICES -->
			<section>
				<div class="container">
					<div class="row margin-top-20">
						<?php
					$query = $db->query("SELECT * FROM btc_faq ORDER BY id");
					if($query->num_rows>0) {
						while($row = $query->fetch_assoc()) {
							?>
							<div class="col-md-12">
								<h4>Q? <?php echo $row['question']; ?></h4>
								<h5>A: <?php echo $row['answer']; ?></h4>
							</div>
							<?php
						}
					} else {
						echo '<div class="col-md-12">'.$lang[info_1].'</div>'; 
					}
					?>
					</div>
				</div>
			</section>
			<!-- END SERVICES -->