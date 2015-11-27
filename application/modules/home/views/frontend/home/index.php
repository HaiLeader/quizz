<!-- Main Content -->
<section class="content">
	<div class='row'>
	<?php 	if(isset($list_cate) && !empty($list_cate)){
				$i = 0;
				foreach($list_cate as $key=>$val){ 
					$i++;?>
					<div class="col-md-3">
						<div class="box <?php if($i <5) echo 'box-success'; else if($i < 9) echo 'box-danger'; else echo 'box-info';?> box-solid">
							<div class="box-header with-border">
								<a href='listtest/'><h3 class="box-title"><?php echo $val['name'];?></h3></a>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse">
										<i class="fa fa-minus"></i>
									</button>
								</div>
							</div>
						<div class="box-body no-padding">
							<h4><?php echo $val['decription'];?></h4>
						</div>
						</div>
					</div>
			<?php
				}
			}?>
	</div>
</section>