<section class="content">
	<?php if(isset($error) && !empty($error)) echo $error;?>

	<div class="">
		<div class="box box-success">
			<box class="box-header with-border">
				<h3 class="box-title">Danh sách kết quả tìm kiếm: </h3>
			</box>
			<div class="box-body">
				<?php  
					  if(isset($listtest) && !empty($listtest)){?>
						<div class="row">
							<?php	  $i = 0;
							  foreach($listtest as $key=>$val){
								$i++;?>
								<div class="col-md-3">
									<div class="box <?php if($i <5) echo 'box-success'; else if($i < 9) echo 'box-danger'; else echo 'box-info';?> box-solid">
										<div class="box-header">
											<a href="test/testdetail/<?php echo $val['id'];?>"><h3 class="box-title"><?php echo $val['name'];?></h3></a>
										</div>
										<div class="box-body">
											<p><?php echo $val['decription'];?></p>
										</div>
									</div>
								</div>
								<?php if(($i%4) == 0) echo '<div class="clearfix"></div>';?>
						<?php	}?>
						</div>

				  	<?php }?>
			</div>
		</div>
	</div>
</section>