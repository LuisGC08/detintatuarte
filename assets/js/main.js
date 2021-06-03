$(document).ready(function () {

	/*  Show/Hidden Submenus */
	$('.nav-btn-submenu').on('click', function (e) {
		e.preventDefault();
		var SubMenu = $(this).next('ul');
		var iconBtn = $(this).children('.fa-chevron-down');
		if (SubMenu.hasClass('show-nav-lateral-submenu')) {
			$(this).removeClass('active');
			iconBtn.removeClass('fa-rotate-180');
			SubMenu.removeClass('show-nav-lateral-submenu');
		} else {
			$(this).addClass('active');
			iconBtn.addClass('fa-rotate-180');
			SubMenu.addClass('show-nav-lateral-submenu');
		}
	});

	/*  Show/Hidden Nav Lateral */
	$('.show-nav-lateral').on('click', function (e) {
		e.preventDefault();
		var NavLateral = $('.nav-lateral');
		var PageConten = $('.page-content');
		if (NavLateral.hasClass('active')) {
			NavLateral.removeClass('active');
			PageConten.removeClass('active');
		} else {
			NavLateral.addClass('active');
			PageConten.addClass('active');
		}
	});

	/*  Exit system buttom */
	$('.btn-exit-system').on('click', function (e) {
		e.preventDefault();
		Swal.fire({
			title: '¿Quieres cerrar la sesión?',
			text: "Usted va a cerrar la sesión",
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#44F70B',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, exit!',
			cancelButtonText: 'No, cancelar'
		}).then((result) => {
			if (result.value) {
				window.location = "index.php";
			}
		});
	});
	$('.btn-exit-cliente').on('click', function (e) {
		e.preventDefault();
		window.location = "index.php?controller=carrito&action=cerrar";

	});
});
(function ($) {
	$(window).on("load", function () {
		$(".nav-lateral-content").mCustomScrollbar({
			theme: "lateral-thin",
			scrollbarPosition: "inside",
			autoHideScrollbar: true,
			scrollButtons: { enable: true }
		});
		$(".page-content").mCustomScrollbar({
			theme: "light-thin",
			scrollbarPosition: "inside",
			autoHideScrollbar: true,
			scrollButtons: { enable: true }
		});
	});
})(jQuery);
