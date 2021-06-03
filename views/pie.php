<?php
if (isset($cliente)) {

	echo '<script src="views/js/app.js" type="module"></script>';

}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!--=============================================
	=            Include JavaScript files           =
	==============================================-->
<!-- jQuery V3.4.1 -->
<script src="assets/js/jquery-3.4.1.min.js"></script>

<!-- popper -->
<script src="assets/js/popper.min.js"></script>

<!-- Bootstrap V4.3 -->
<script src="assets/js/bootstrap.min.js"></script>

<!-- jQuery Custom Content Scroller V3.1.5 -->
<script src="assets/js/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- Bootstrap Material Design V4.0 -->
<script src="assets/js/bootstrap-material-design.min.js"></script>
<script>
	$(document).ready(function() {
		$('body').bootstrapMaterialDesign();
	});
</script>

<script src="assets/js/main.js"></script>
</body>

</html>