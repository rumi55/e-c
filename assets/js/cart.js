$(document).ready(function(){

	function refreshCartData()
	{
		$.ajax({
			url: 'mod/cart_data.php',
			dataType: 'json',
			success: function(results){
				$.each(results,function(key,value){
					$("#shporta ."+key+" span").text(value);
				});

				},
				error:function (data){
					alert('gabim ne rifresikimin e te dhenave ne shporte');
				}
		
		});
	}

	function refreshMainCartData()
	{
		$.ajax({
			url: 'mod/cart_view.php',
			dataType: 'html',
			success: function(data) {
				$('#shoping_cart').html(data);
				initBinds();
					
			},
			error: function (data){
				alert('Gabim ne rifreskimin e te dhenave ne shporten kryesore');
			}

		});
	}


	//proceed to paypal
	if ($('.paypal').length > 0) {

		$('.paypal').click(function() {

			var token = $(this).attr('id');
			var image = "<div style=\"text-align:center\">";
			image = image + "<img src=\"assets/images/loadinfo.net.gif\"";
			image = image + " alt=\"Proceeding to PayPal\"/>";
			image = image + "<br/>Please wait while we are redirecting you to PayPal..";
			image = image + "</div><div id=\"frm_pp\"></div>";

			$("#big_basket").fadeOut(200, function(){
				$(this).html(image).fadeIn(200, function(){

					send2PP(token);
				});
			});
		});
	}


	function send2PP(token){
		$.ajax({
			type: 'POST',
			url: 'mod/paypal.php',
			data: ({ token : token}),
			dataType: 'html',
			success: function(data){
				$('#frm_pp').html(data);
				
				//submit form automatically
				$('#frm_paypal').submit();
			}, 
			error: function(){
				alert('An error has occurred');
			}
		});
	}








	if ($(".shto_ne_shport").length > 0) 
		{
			$(".shto_ne_shport").on("click", function(){

				 var trigger = $(this);
				 var param= trigger.attr("rel");
				 var item =param.split("_");
				 

				 $.ajax({

				 	type: 'POST',
				 	url: 'mod/cart.php',	
				 	data: ({id : item[0], active : item[1]}),
				 	dataType: 'json',

				 	success: function(data){
				 		var new_id = item[0] + "_" + data.active;

				 		if (data.active !=item[1])
				 		 {

				 		 	if (data.active==0)
				 		 	 {
				 		 	 	trigger.attr("rel",new_id);
				 		 	 	trigger.text("Largo nga shporta");
				 		 	 	trigger.addClass("red");
				 		 	 } else{
				 		 	 	trigger.attr("rel",new_id);
				 		 	 	trigger.text("Shto ne shport");
				 		 	 	trigger.removeClass("red");
				 		 	 }

				 		 	 refreshCartData();
				 		 };
				 	},

				 	error: function(data){
				 		alert("gabim");
				 	}
				 });

				 return false;
			});
		}

	//ekzekutohet kur te lodohet scripta
	initBinds();


	function initBinds()
	{
		if($('.remove_cart').length > 0)
		{
			$('.remove_cart').bind('click', removeFromCart);
		}

		if($('.update_cart').length > 0)
		{	
			$('.update_cart').bind('click', updateCart);

		}

		if($('.fload_qty').length > 0)
		{	$('.fload_qty').bind('keypress', function(e){
				var code = e.keyCode ? e.keyCode : e.which;
				//a eshte shtypur enter 'codi'
				if(code == 13)
				{
					updateCart();
				}
			});
		}
	}


	// largo nga shporta
	function removeFromCart()
	{
		var item = $(this).attr('rel');
		

		$.ajax({
			type: 'POST',
			url: 'mod/cart_remove.php',
			dataType: 'html',
			data: ({id:item}),
			success: function(){
				refreshCartData();
				refreshMainCartData();
			},
			error: function(){
				alert("gabim largimi i produktit nga shporta");
			}
		});
	}

	function updateCart()
	{
		$('#frm_shopingcart :input').each( function(){
			var sid = $(this).attr('id').split('-');
			var value = $(this).val();
			
			$.ajax({
				type: 'POST',
				url: 'mod/cart_qty.php',
				data: ({id:sid[1], qty:value}),
				success: function(){
					
					refreshCartData();
					refreshMainCartData();
				},
				error: function(data){
					alert("gabim ndryshimi i sasis se produktit");
				}
			});
		});
	}



	if ($(".del_product").length > 0) 
	{
		$(".del_product").on('click', function (){
			var del_id = $(this).attr('id');
			if(confirm("A jeni i sigurt se doni ta fshini kete produkt?") )
			{
					$.ajax({
						type: 'POST',
						url: '../mod/delete_product.php',
						data: ({id:del_id}),
						success: function(data){
							alert('Produki u fshi me sukses');
						},
						error: function(data){
							alert('Produkti nuk u fshi');
						}

					});
					$(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
					.animate({ opacity: "hide" }, "slow");
			}
			return false;
		});
	}


	if ($(".del_category").length > 0) 
	{
		$(".del_category").on('click', function (){
			var del_id = $(this).attr('id');
			if(confirm("A jeni i sigurt se doni ta fshini kete kategori?") )
			{
					$.ajax({
						type: 'POST',
						url: '../mod/delete_category.php',
						data: ({id:del_id}),
						success: function(data){
							alert('Produki u fshi me sukses');
						},
						error: function(data){
							alert('Produkti nuk u fshi');
						}

					});
					$(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
					.animate({ opacity: "hide" }, "slow");
			}
			return false;
		});
	}




});