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
    // file input
    $("#input-701").fileinput({
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
