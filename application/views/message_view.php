<?php
if(strlen($this->session->flashdata('message')) > 0) {
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="alert <?php echo $this->session->flashdata('color'); ?> dark">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo $this->session->flashdata('message'); ?>
			</div>
		</div>
	</div>
	<?php
}
?>
<script>
	$(function () {
		$(".close").click(function(){
			<?php unset($_SESSION['message']);?>
		});
		$(window).on('beforeunload', function(){
			<?php unset($_SESSION['message']);?>
		});
	})
</script>
