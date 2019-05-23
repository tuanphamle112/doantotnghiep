$(document).ready(function() {
    $('#imgInp').change(function() {
        readURL(this);
        $('#img-upload').attr('style', 'width:100%;height:300px');
        $('.mainFileContainer').attr('style', 'border:1px solid #ccc');
        $('.mainFileContainer i,span').attr('style', 'font-size:16px;');
    }); 

    $('.ingredient-field').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault(e);
            $('.add-ingredient').trigger( 'click');
        }
    });

    $('.add-ingredient').on('click', function(e) {
        e.preventDefault(e);
        $quantity = $('.ingredient-quantity');
        $unit = $('.ingredient-unit');
        $name = $('.input-ingredient-name');

        checkIngredient($quantity.val(), $unit.val(), $name.val());

        $quantity.val('');
        $unit.val('');
        $name.val('');
        $('.ingredient-quantity').focus();
    });
    //checkfile upload or not
    $('.next-step').on('click', function(e) {
        if ($('#input-701').val() != '' && $('.upload-status').val() == '') {
            e.preventDefault();
            $('.wrap-file-input .image-error').attr('style', 'display:block !important');
        }
    });
    // file input
    $('#input-701').fileinput({
        uploadUrl: "/create-recipe/upload-step-image",
        uploadAsync: false,
        autoReplace: true,
        maxFileCount: 6,
        allowedFileExtensions: ["jpg", "png", "jpeg"],
        autoOrientImage: false,
        showBrowse: false,
        browseOnZoneClick: true,
        uploadExtraData: function () {
            return {
                recipe_number: $("input[name='recipe_number']").val(),
                step_number: $("input[name='step_number']").val(),
                id: $("input[name='recipe_id']").val()
            }
        },
        ajaxSettings: { 
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } 
        },
    });
    $('body').on('fileuploaded', '#input-701', function (event, key, XMLRequest, data) { 
        $('.wrap-file-input image-error').attr('style', 'display:none !important');
        $('.upload-status').val('uploaded');

    });
    var previewConfig = [];
    var images = [];
    if ($('.step-image').val().trim() != '') {
        var imageString = $('.step-image').val();
        var images = imageString.split(',');
        for (var i = 0;i < images.length; i ++) {
            var configObject = {
                url: '/update-recipe/delete-step-image',
                extra: {
                    imageName: images[i],
                    imageString: imageString,
                    recipeId: $('input[name="recipe_id"]').val(),
                    stepId: $('input[name="step_number"]').val(),
                    '_token': $('meta[name="csrf-token"]').attr('content')
                }
            }
            previewConfig.push(configObject);
            images[i] = '/uploads/recipes/' + images[i];
        }
    }

    var fileInputOption = {
        uploadUrl: '/update-recipe/upload-step-image',
        uploadAsync: false,
        overwriteInitial: false,
        initialPreview: images,
        initialPreviewConfig: previewConfig,
        maxFileCount: 6,
        removeIcon: '<i class="fa fa-trash-o"></i> ',
        allowedFileExtensions: ["jpg", "png", "jpeg"],
        initialPreviewAsData: true,
        initialPreviewFileType: 'image',
        autoOrientImage: false,
        showBrowse: false,
        browseOnZoneClick: true,
        uploadExtraData: function () {
            return {
                recipe_number: $("input[name='recipe_number']").val(),
                step_number: $("input[name='step_number']").val(),
                id: $("input[name='recipe_id']").val()
            }
        },
        ajaxSettings: { 
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } 
        },
    }

    //upload file input
    $('#input-702').fileinput(fileInputOption);

    $('body').on('filedeleted', '#input-702', function (event, key, XMLRequest, data) { 
        var image_cutted = XMLRequest.responseJSON.imageCutted; 
        location.reload();
        $('.step-image').val(image_cutted);
    });
    // read url main image
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img-upload').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    function checkIngredient(quantity, unit, name) {
        var messages = [];
        var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;

        if ($('.ingredients').val() == '') {
            var ingredientCurrently = [];
        } else {
            var ingredientCurrently = $('.ingredients').val().split(',');
        }

        if (format.test(unit.trim()) || format.test(name.trim())) {
            messages.push(Lang.get('validation.ingredient_character'));
        }
        if(quantity.trim() == '') {
            messages.push(Lang.get('validation.ingredient_quantity'));
        }
        if(unit.trim() == '') {
            messages.push(Lang.get('validation.ingredient_unit'));
        }
        if(name.trim() == '') {
            messages.push(Lang.get('validation.ingredient_name'));
        }

        if (messages.length === 0) {
            var inputString = quantity.trim() + ' ' + unit.trim() + ' ' + name.trim();
            $('.filling-error').removeClass('error-active');
            var appendValue = "<div class='ingredient-item' data-ingre='" + inputString.trim() + "'><i class='fa fa-check-circle'></i><b>" + quantity.trim() + " </b><b>" + unit.trim() + " </b><span>" + name.trim() + " </span><i class='fa fa-times-circle close-ingredient' onclick='removeIngredientDiv(this)'></i></div>";
            $('.ingredient-container').append(appendValue);
            ingredientCurrently.push(inputString);

        } else {
            $('.filling-error').addClass('error-active');
            checkInputIngreError(messages);
        }

        $(".ingredients").val(ingredientCurrently);
    }

    function checkInputIngreError(messages)
    {
        $('.ingredient-error').html("");
        messages.forEach(function(item) {
            $('.ingredient-error').append('<span>' + item + '</span><br>');
        });
    }
});

function removeIngredientDiv (e1)
{
    var itemContent = $(e1).closest(".ingredient-item").data('ingre');
    var ingredientsRemoved = $(".ingredients").val().split(',');
    $(e1).closest(".ingredient-item").remove(); 
    ingredientsRemoved.splice(ingredientsRemoved.indexOf(itemContent), 1);
    $(".ingredients").val(ingredientsRemoved)
}
