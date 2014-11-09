(function($) {

	$(document).ready(function() {

		$('a.reforme-voto').live('click', function(){
			var action = jQuery(this).data('action');
			var post_id = jQuery(this).data('post_id');
			var return_post_id = jQuery(this).data('return_post_id') ? jQuery(this).data('return_post_id') : false;
            var $container = $(this).parent('.reforme-voto-container');

			jQuery.ajax({
				type: 'POST',
				url: vars.ajaxurl,
				data: {
					action: 'reforme_voto',
					reforme_action:  action,
                    post_id: post_id,
                    return_post_id: return_post_id
				}, 
				success: function( response ){
					var response = JSON.parse(response);
                    alert(response.msg);
                    $container.html(response.html);
				}
			});
		});

	});

})(jQuery);
