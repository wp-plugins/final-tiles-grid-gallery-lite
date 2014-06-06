var FTG = function ($) {
	var _loading = null;

	return {
		show_loading: function () {
			_loading = $("<div><p class='loading'></div>").dialog({
                modal: true,
                dialogClass: "noTitle"
            });
		},
		hide_loading: function () {
			if(_loading) {
				_loading.dialog("destroy");
				_loading = null;
			}
		},
		delete_image: function (id) {
			FTG.show_loading();
			$.post(ajaxurl, {
                action: 'delete_image',                
                FinalTilesGalleryLite: $('#FinalTilesGalleryLite').val(),
                id: id
            }, function () {
                FTG.load_images();
            });
		},
		load_images: function () {
			if(!_loading)
				FTG.show_loading();

			$.post(ajaxurl, {
                action: 'list_images',
                FinalTilesGalleryLite: $('#FinalTilesGalleryLite').val(),
                gid: $("#gallery-id").val()
            }, function (html) {
                $("#image-list").empty().append(html).sortable({
                    update: function () {
                        FTG.show_loading();
                        var ids = [];
                        $("#image-list .item").each(function () {
                            ids.push($(this).data("id"));
                        });
                        var data = {
                            action: 'sort_images',
                            FinalTilesGalleryLite: $('#FinalTilesGalleryLite').val(),
                            ids: ids.join(',')
                        };
                        $.post(ajaxurl, data, function () {
                            FTG.hide_loading();
                        });
                    }
                });

                $("#image-list .remove").click(function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var $item = $(this).parents(".item:first");
                    var id = $item.data("id");

                    var data = {
                        action: 'delete_image',
                        FinalTilesGalleryLite: $('#FinalTilesGalleryLite').val(),
                        id: id
                    };

                    FTG.show_loading();
                    $.post(ajaxurl, data, function () {
                        $item.remove();
                        FTG.hide_loading();                        
                    });
                });

                $("#image-list .checkbox").click(function () {
                    $(this).toggleClass("checked");
                    $(this).parents(".item:first").toggleClass("selected");
                });
                
                FTG.hide_loading();
            });
		},
		edit_image: function(form) {
			var data = {};
            form.find("input[type=text], input:checked, textarea, input[type=hidden]").each(function() {
                data[$(this).attr("name")] = $(this).val();
            });
            data.action = 'save_image';
            data.type = 'edit';
            data.FinalTilesGalleryLite = $('#FinalTilesGalleryLite').val();

            FTG.show_loading();
            $.ajax({
                url: ajaxurl,
                data: data,
                dataType: "json",
                type: "post",
                error: function(a,b,c) {
                    FTG.hide_loading();
                },
                success: function(r) {                        
                    if(r.success) {
                        FTG.load_images();
                    } else {
                    	FTG.hide_loading();
                    }
                }
            });
		},
		add_image: function () {
			var data = {};
            $("#add_image_form input[type=text], #add_image_form input:checked, #add_image_form textarea, #add_image_form input[type=hidden]").each(function() {
                data[$(this).attr("name")] = $(this).val();
            });
            data.action = 'save_image';
            data.type = $(this).data("type");
            if(data.img_id == "") {
                var p = $("<div title='Attention'>Select an image to add</div>").dialog({
                    modal: true,
                    buttons: {
                        Close: function () {
                            p.dialog("destroy");
                        }
                    }
                });
                return false;
            }

            FTG.show_loading();
            $.ajax({
                url: ajaxurl,
                data: data,
                dataType: "json",
                type: "post",
                error: function(a,b,c) {
                    FTG.hide_loading();
                },
                success: function(r) {                        
                    if(r.success) {
                        FTG.load_images();
                        $("#add_image_form .img img").remove();
                        $("[name=img_id],[name=img_url],[name=url],[name=image_caption]").val("");
                    }
                }
            });
		},
        
        init_gallery: function () {
            

        },
        save_gallery: function() {
            var data = {};
            data.action = 'save_gallery';
            
            $(".form-fields").find("input[type=text], select, input:checked, input[type=hidden], textarea").each(function () {
            	var value = $(this).val();
    	
            	if($.isArray(value))
            		value = value[0];
                data[$(this).attr("name")] = value;
            });
            
            data.FinalTilesGalleryLite = $("[name=FinalTilesGalleryLite]").val();
            data.ftg_gallery_edit = $("[name=ftg_gallery_edit]").val();

            if(parseInt(data.gridCellSize) < 2)
                data.gridCellSize = 2;
            
            if(data.galleryName == "") {
                var p = $("<div title='Attention'>Insert a name for the gallery</div>").dialog({
                    modal: true,
                    buttons: {
                        Close: function () {
                            p.dialog("destroy");
                        }
                    }
                });
                return false;
            }

            FTG.show_loading();

            $.ajax({
                url: ajaxurl,
                data: data,
                dataType: "json",
                type: "post",
                error: function(a,b,c) {
                    FTG.hide_loading();
                },
                success: function(r) {
                    if(data.ftg_gallery_edit)
                        FTG.hide_loading();
                    else
                        location.href = "?page=edit-gallery";                     
                }
            });
        },
		bind: function () {			
			$("#add-submit").click(function (e) {
                e.preventDefault();
                FTG.add_image();
            });
            $("#add-gallery, #edit-gallery").click(function (e) {
                e.preventDefault();
                FTG.save_gallery();
            });
            
            $("#image-list").on("click", ".item .thumb", function () {
	            $(this).parents(".item").toggleClass("selected");
	            $(this).parents(".item").find(".checkbox").toggleClass("checked");
            });
            $("#image-list").on("click", ".edit", function (e) {
            	e.preventDefault();
            	
                var $item = $(this).parents(".item");
                var panel = $("#image-panel-model").clone().attr("id", "image-panel");
                panel.css({
                    marginTop: $(window).scrollTop() - (246 / 2),
                    marginLeft: -(600 / 2)
                });

                $("[name=target]", panel).val($("[name=target]", $item).val());
	            $("[name=link]", panel).val($("[name=link]", $item).val());
                $(".figure", panel).append($("img", $item).clone());
                $(".sizes", panel).append($("select", $item).clone());
                $("textarea", panel).val($("pre", $item).html());
                $(".copy", $item).clone().appendTo(panel);

                
                $("body").append("<div class='overlay' style='display:none' />");
                $(".overlay").fadeIn();
                panel.appendTo("body").fadeIn();

                var link = $item.find("[name=link]").val();
                
                $(".buttons a", panel).click(function (e) {
                    e.preventDefault();
                    
                    switch($(this).data("action")) {
                        case "save":
                            var data = {
                                action : 'save_image',
                                FinalTilesGalleryLite : $('#FinalTilesGalleryLite').val()
                            };
                            $("input[type=text], input[type=hidden], input[type=radio]:checked, input[type=checkbox]:checked, textarea, select", panel).each(function () {
                                if($(this).attr("name"))
                                    data[$(this).attr("name")] = $(this).val();
                            });

                            

                            $("#image-panel .close").trigger("click");
                            FTG.show_loading();
                            $.ajax({
                                url: ajaxurl,
                                data: data,
                                dataType: "json",
                                type: "post",
                                error: function(a,b,c) {
                                	console.log(a,b,c);
                                    FTG.hide_loading();
                                },
                                success: function(r) {    
                                	console.log("ok");                                
                                    FTG.hide_loading();
                                    FTG.load_images();
                                }
                            });                            
                            break;
                        case "cancel":
                            $("#image-panel .close").trigger("click");
                            break;
                    }
                });

                $("#image-panel .close, .overlay").click(function (e) {
                    e.preventDefault();
                    panel.fadeOut(function () {
                        $(this).remove();
                    });
                    $(".overlay").fadeOut(function () {
                        $(this).remove();
                    });
                });
            });
            $("body").on("click", "[name=click_action]", function () {
                if($(this).val() == "url") {
                    $(this).siblings("[name=url]").get(0).disabled = false;
                } else {
                    $(this).siblings("[name=url]").val("").get(0).disabled = true;
                }
            });

            $(".bulk a").click(function (e) {
                e.preventDefault();

                var $bulk = $(".bulk");

                switch($(this).data("action"))
                {
                    case "select":
                        $("#images .item").addClass("selected");
                        $("#images .item .checkbox").addClass("checked");
                        break;
                    case "deselect":
                        $("#images .item").removeClass("selected");
                        $("#images .item .checkbox").removeClass("checked");
                        break;
                    case "toggle":
                        $("#images .item").toggleClass("selected");
                        $("#images .item .checkbox").toggleClass("checked");
                        break;                    
                    case "remove":
                        var selected = [];
                        $("#images .item.selected").each(function (i, o) {
                            selected.push($(o).data("id"));
                        });
                        if(selected.length == 0) {
                            alert("No images selected");
                        } else {
                            $(".panel", $bulk).hide();
                            $(".panel strong", $bulk).text("Confirm");
                            $(".panel .text", $bulk).text("You selected " + selected.length + " images to remove, proceed ?");

                            $(".cancel", $bulk).unbind("click").click(function (e) {
                                e.preventDefault();
                                $(".panel", $bulk).slideUp();
                            });

                            $(".proceed", $bulk).unbind("click").click(function (e) {
                                e.preventDefault();
                                $(".panel", $bulk).slideUp();

                                var data = {
                                    action: 'delete_image',
                                    FinalTilesGalleryLite: $('#FinalTilesGalleryLite').val(),
                                    id: selected.join(",")
                                };

                                FTG.show_loading();
                                $.post(ajaxurl, data, function () {
                                    $("#images .item.selected").remove();
                                    FTG.hide_loading();                        
                                });
                            });

                            $(".panel", $bulk).slideDown();
                        }
                        break;
                }
            });
            
            $(".open-media-panel").on("click", function() {
                tgm_media_frame = wp.media.frames.tgm_media_frame = wp.media({
                    multiple: true,
                    library: {
                        type: 'image'
                    }
                });

                tgm_media_frame.on('select', function() {
                    var selection = tgm_media_frame.state().get('selection');
                    var images = [];
                    
                    var errors = 0;
                    selection.map( function( attachment ) {
                    
                        attachment = attachment.toJSON();
                        
                        if(! attachment.sizes) {
                        	errors++;
                        	return;
						}

                        var obj = {
                            description: attachment.caption,
                            imageId: attachment.id
                        };
						
						var currentImageSize = $(".current-image-size").val();
						
                        if(attachment.sizes[currentImageSize])
                            obj.imagePath = attachment.sizes[currentImageSize].url
                        else
                            obj.imagePath = attachment.url;

                        if(attachment.sizes.full)
                            obj.altImagePath = attachment.sizes.full.url;
                        
                        if(images.length + $("#image-list .item").length < ("localizati").length * 2)
                            images.push(obj);
                    });
					
					if(errors) {
						alert(errors + " images could not be added because the selected size is not available");
					}
					
                    var data = {
                        action : 'add_image',
                        enc_images : JSON.stringify(images),
                        galleryId: $("#gallery-id").val(),
                        FinalTilesGalleryLite : $('#FinalTilesGalleryLite').val()
                    };

                    FTG.show_loading();
                    $.ajax({
                        url: ajaxurl,
                        data: data,
                        dataType: "json",
                        type: "post",
                        error: function(a,b,c) {
                            FTG.hide_loading();
                            alert("error adding images");
                        },
                        success: function(r) {                        
                            if(r.success) {
                                FTG.hide_loading();
                                FTG.load_images();
                            }
                        }
                    });
                });

                tgm_media_frame.open();
            });
		}
	}
}(jQuery);
jQuery(function () {
	FTG.bind();
});