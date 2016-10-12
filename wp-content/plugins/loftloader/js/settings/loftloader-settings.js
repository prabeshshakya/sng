(function($){
	$(document).ready(function(){
		var customImageSrc = $('.preloader-preview-image').val() ? $('.preloader-preview-image').val() : loftloader_vars.img_base +  'loftloader-logo.png';
		// Custom media uploader
		window.loftloader_set_image = {
			target: '',
			frame: false,
			mediaFrame: function(){
				if(!this.frame){
					this.frame = wp.media({
						id: 'loftloader-image-uploader',
						frame: 'post', 
						state: 'insert',
						editing: true,
						library: {
							type : 'image'
						},
						multiple: false  // Set this to true to allow multiple files to be selected
					})
					.on('insert', function(){
						if(window.loftloader_set_image.target){
							var state   = window.loftloader_set_image.frame.state(),
								oImage  = state.get('selection').first(),
								jImage  = oImage.toJSON();
							if((jImage.type == 'image') && (jImage.subtype != 'svg+xml')){
								var display = state.display(oImage).toJSON(),
									sSize   = (display && display.size && jImage.sizes && jImage.sizes[display.size]) ? display.size : 'full',
									sImage  = (display && display.size && jImage.sizes && jImage.sizes[display.size]) ? jImage.sizes[display.size] : jImage,
									image   = {url: sImage.url, id: jImage.id, caption: jImage.caption, type: jImage.subtype};

								window.loftloader_set_image.target.siblings('input.admin-image-id').val(jImage.id).end().trigger('loftloader.image.change', image);
							}
							window.loftloader_set_image.target = false;
						}
					})
					.on('open', function(){
						var selection = window.loftloader_set_image.frame.state().get('selection'),
							image_id  = window.loftloader_set_image.target.siblings('input.admin-image-id').val();
						selection.reset();
						if(image_id && (image_id !== '')){
							var attachment = wp.media.attachment(image_id);
							attachment.fetch(); 
							selection.add(attachment ? [attachment] : []);
						}
					});
				}
				return this.frame;
			},
			open: function(){
				this.mediaFrame().open();
			}
		};
		// set image button events handler
		$('body').on('click', '.loader-set-image', function(e){
			e.preventDefault();
			window.loftloader_set_image.target = $(this);
			window.loftloader_set_image.open();
		})
		.on('loftloader.image.change', '.loader-set-image', function(e, image){
			e.preventDefault(); 
			if(image && image.url){
				var $parent = $(this).parent();
				$parent.find('img').length ? $parent.find('img').attr('src', image.url) : $parent.prepend($('<div>').addClass('bg-img-holder').append($('<img>').attr('src', image.url)));
				$(this).addClass('hide').siblings('.bg-img-remove').removeClass('hide').siblings('input.admin-image-url').val(image.url);
				customImageSrc = image.url;
				$('#preloader-animation').trigger('change');
			}
		})
		.on('click', '.bg-img-remove', function(e){
			e.preventDefault();
			$(this).addClass('hide').siblings('input').val('').siblings('.loader-set-image').removeClass('hide').siblings('.bg-img-holder').remove();
			customImageSrc = loftloader_vars.img_base +  'loftloader-logo.png';
			$(this).siblings('input.admin-image-url').val(customImageSrc);
			$('#preloader-animation').trigger('change');
		})
		.on('click', '.bg-img-holder img', function(e){
			$(this).parent().siblings('.loader-set-image').trigger('click');
		})
		.on('click', '.button.button-primary', function(e){
			if($(this).hasClass('reset')){
				e.preventDefault();
				if(confirm(loftloader_vars.confirm_text)){
					var data = {'action' : loftloader_vars.ajax.action, 'nonce' : loftloader_vars.ajax.nonce};
					$.post(loftloader_vars.ajax.url, data).done(function(response){ console.log(response);
						response.success ? window.location.href = window.location.href : alert(loftloader_vars.fail_text);
					}).fail(function(){	alert(loftloader_vars.fail_text); });
				}
			}
		});

		$('.loader-ui-slider').each(function(){
			$(this).slider({
				range: "min",
				value: $(this).data('default'),
				min: $(this).data('min'),
				max: $(this).data('max'),
				step: $(this).data('step'),
				slide: function(event, ui){
					if($(this).siblings('label').find('input').hasClass('opacity-amount')){
						$(this).siblings('label').find('input').val(ui.value + '%');
						$(this).parents('.preview-section').find('.preview-wrapper .loader-section').css('opacity' , ui.value/100);
					}
				},
				create: function(event, ui){
					$(this).parents('.preview-section').find('.preview-wrapper .loader-section').css('opacity' , $(this).attr('data-default')/100);
				}
			});
		});
		$('.loader-color-picker').wpColorPicker({
			change: function(e, ui){
				var color = $(this).wpColorPicker('color');
				switch($(this).attr('id')){
					case 'preloader-background-color':
						loftloader_generate_css_background(color)
						break;
					case 'preloader-animation-color':
						loftloader_generate_css_animation(color);
						break;
				}
			}
		});
		$('.loader-color-picker').trigger('change');

		$('.loftloader-enabled').on('change', function(e){
			var on = $(this).attr('checked') ? true : false,
				$homepage = $('.loftloader-enable-homepage-only').parents('li').first();
			on ? $homepage.removeClass('hide') : $homepage.addClass('hide');
		}).trigger('change');

		// Custom image/logo width for 'pl-imgloading'
		$('.preloader-custom-image-width input').change(function(e){
			if($('#preloader-animation').val() == 'pl-imgloading'){
				var $loader = $('#loader'),
					width = $(this).val() ? parseInt($(this).val()) : false,
					min = $(this).attr('min') ? parseInt($(this).attr('min')) : 0,
					max = $(this).attr('max') ? parseInt($(this).attr('max')) : 400;
				((min <= width) && (width <= max)) ? $loader.css('width', width) : $loader.css('width', '');
			}
		});
		// Select Animation
		$('#preloader-animation').on('change', function() {
			var customImage = $('<img>').attr('src', customImageSrc);
			var selectedAnimation = $(this).val();
			$('.preview-wrapper #loftloader-wrapper').removeAttr('class').addClass(selectedAnimation);
			switch(selectedAnimation){
				case 'pl-frame':
					$('#loader span').css({'background-image': '', 'background-size': ''});
					!$('#loader img').length ? $('#loader span').after(customImage) : $('#loader img').attr('src', customImageSrc);
					break;
				case 'pl-imgloading':
					var backgroundImg = 'url('+ customImageSrc +')';
					$('#loader span').css('background-image' , backgroundImg);
					!$('#loader img').length ? $('#loader span').after(customImage) : $('#loader img').attr('src', customImageSrc);
					$('#loader span').css('background-size', 'cover');
					$('.preloader-custom-image-width input').trigger('change');
					break;
				default:
					if($('#loader img').length){
						$('#loader img').remove();
						$('#loader span').css({'background-image': '', 'background-size': ''});
					}
					break;
					
			}
		})
		.on('change', function(e){
			var selectedVal  = $(this).val(), $width = $('.preloader-custom-image-width input');
			$('li.preloader_animation').addClass('hide');
			$('li.preloader_animation-' + selectedVal).removeClass('hide');
			(selectedVal == 'pl-imgloading') ? $width.attr('required', '') : $width.removeAttr('required');
			(selectedVal == 'pl-imgloading') ? '' : $('#loader').css('width', '');
		}).trigger('change');

		var firstElement  = $('.preview-frame #loftloader-wrapper').find('.loader-section').first();
		var secondElement = $('.preview-frame #loftloader-wrapper').find('.loader-section').last();
		$('#preloader-background-style').on('change', function(e){
			switch($(this).find('option:selected').val()){
				case 'fade':
					secondElement.addClass('hide');
					firstElement.removeAttr('class').addClass('loader-section section-fade');
					break;
				case 'slide-left-right':
					firstElement.removeAttr('class').addClass('loader-section section-left');
					secondElement.removeAttr('class').addClass('loader-section section-right');
					break;
				case 'slide-up':
					firstElement.removeAttr('class').addClass('loader-section section-slide-up');
					secondElement.addClass('hide');
					break;
				case 'slide-up-down':
					firstElement.removeAttr('class').addClass('loader-section section-up');
					secondElement.removeAttr('class').addClass('loader-section section-down');
					break;
			}
		}).trigger('change');

		function loftloader_generate_css_animation(color){
			var currentStyle = $('#preloader-animation').val();
			var currentColor = color;
			var newStyle	 = '';

			newStyle += '#loftloader-wrapper.pl-sun #loader span, #loftloader-wrapper.pl-sun #loader span:before {background-color: ' + currentColor + ';}';
			newStyle += '#loftloader-wrapper.pl-circles #loader span, #loftloader-wrapper.pl-circles #loader:before, #loftloader-wrapper.pl-circles #loader:after {background: ' + currentColor + ';}';
			newStyle += '#loftloader-wrapper.pl-wave #loader span, #loftloader-wrapper.pl-wave #loader:before, #loftloader-wrapper.pl-wave #loader:after {background: ' + currentColor + ';}';
			newStyle += '#loftloader-wrapper.pl-square #loader span {border: 4px solid ' + currentColor + ';}';
			newStyle += '#loftloader-wrapper.pl-frame #loader:before, #loftloader-wrapper.pl-frame #loader:after, #loftloader-wrapper.pl-frame #loader span:before, #loftloader-wrapper.pl-frame #loader span:after {background-color: ' + currentColor + ';}';

			if($('body').find('#preview-animation-color').length > 0){
				$('body').find('#preview-animation-color').html(newStyle);
			}
			else{
				$('<style>' + newStyle + '</style>').attr('id', 'preview-animation-color').appendTo($('body'));
			}
		}
		function loftloader_generate_css_background(color){
			firstElement.css('background-color', color);
			secondElement.css('background-color', color);
		}
		loftloader_generate_css_animation($('#preloader-animation-color').val());
		loftloader_generate_css_background($('#preloader-background-color').val());
	});
})(jQuery);