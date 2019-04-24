$(document).ready(function() {

    // variable area
    var $step_item = $('.wrap-step-box .step-box');
    var $previewImage = $('.preview-images-zone .preview-image');

    var step_num = $step_item.length - 1;
    var step_num_not_decrease = step_num;
    var step_div = $step_item.first().wrap('<p/>').parent().html(); // get div step as a string to append

    if ($(".all-ingredients").val() == "") {
        var allIngredients = [];
    } else {
        var allIngredients = $(".all-ingredients").val().split(",");
    }
    
    for (i = 1; i <= step_num; i++) {
        if ($previewImage.length > 0) {
            $previewImage.closest('.wrap-preview').find(".button-clear").attr('style', 'display:block !important');
            $previewImage.closest('.preview-images-zone').attr('style', 'border:1px solid #ddd');
        }
    }

    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
    });

    $('.btn-file :file').on('fileselect', function(event, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
            log = label;
        
        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    
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

    $("#imgInp").change(function() {
        readURL(this);
        $('#img-upload').attr('style', 'width:100%;height:300px');
        $('.mainFileContainer').attr('style', 'border:1px solid #ccc');
        $('.mainFileContainer i,span').attr('style', 'font-size:16px;');
    }); 	
    // end main image

    $(".how-to-fill").click(function () {
        $(".understood").addClass("active");
        $(this).removeClass("active");
        $(".filling-instruction").show();
    });

    $(".understood").click(function () {
        $(".how-to-fill").addClass("active");
        $(this).removeClass("active");
        $(".filling-instruction").hide();
    });

    function checkInputIngreError(parentClass,message)
    {
        $(parentClass + " .filling-error").html("");
        $(parentClass + " .filling-error").addClass("active");
        message.forEach(function(item) {
            $(parentClass + " .filling-error").append("<span>" + item + "</span><br>");
        });
    }

    function checkInputError(parentClass,message)
    {
        $("." + parentClass + " .filling-error").html("");
        $("." + parentClass + " .filling-error").addClass("active");
        $("." + parentClass + " .filling-error").append("<span>" + message + "</span><br>");
    }

    $(".wrap-create-form").submit(function(e) {

        var stepNumNotDecrease = $(".step_num_not_decrease").val();

        var stepContentName = "";
        var stepArrayChecking = [];
        var $noStep = $('.no-step');
        var $stepBox = $('.wrap-step-box .step-box');
        if ($stepBox.length < 2) {
            $noStep.addClass("active");
            e.preventDefault();
        }

        for (var i = 1; i <= stepNumNotDecrease; i++) {
            stepContentClass = "step-content-" + i;
            stepContentvalue = $("." + stepContentClass).val();
            $closetErrorElement = $("." + stepContentClass).next('.filling-error'); 

            if (typeof stepContentvalue == 'undefined') {
                continue;
            }
            stepArrayChecking.push(i);
            if (stepContentvalue.trim() == "") {
                $closetErrorElement.addClass("active");
                e.preventDefault();
            } else {
                $closetErrorElement.removeClass("active");
            }
        }

        if (allIngredients.length == 0) {
            e.preventDefault();
            $(".ingredient-input .filling-error").html("");
            $(".ingredient-input .filling-error").append("<span>" + Lang.get('validation.ingredients') + "</span><br>");
            $(".ingredient-input .filling-error").addClass("active");
        } else {
            $(".ingredient-input .filling-error").html("");
        }
        inputValidation(e);
    });

    function inputValidation(e)
    {

        var message = [];
        var listOfParentClass = [
            "recipe-name",
            "recipe-description",
        ];
        var listOfErrorsMessage = [
            Lang.get('validation.recipe_name'),
            Lang.get('validation.recipe_description'),
        ];
        for (var i = 0; i < listOfParentClass.length; i++) {
            if ($("." + listOfParentClass[i] + " .input-error").val().trim() == "") {
                e.preventDefault();
                checkInputError(listOfParentClass[i], listOfErrorsMessage[i]);
            } else {
                $("." + listOfParentClass[i] + " .filling-error").removeClass("active");
            }
        }
    }


    function inputModifying (e)
    {
        var message = [];
        var inputString = $(".ingredient-input input.ingredient-field").val();
        var ingredient = inputString.trim().split(" ");
        var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/; // ingredient field does not contain these character
       
        if (format.test(inputString.trim())) {
            message.push(Lang.get('validation.ingredient_character'));
        }
        if (isNaN(ingredient[0])) {
            message.push(Lang.get('validation.ingredient_quantity'));
        }
        if (ingredient.length <= 2) {
            message.push(Lang.get('validation.ingredient_name'));
        }
        if (message.length === 0) {
            $(".ingredient-input .filling-error").removeClass("active");
            var indexOfSecondSpace = inputString.indexOf(' ', inputString.indexOf(' ') + 1);
            var ingredientName = inputString.substring(indexOfSecondSpace);
    
            var appendValue = "<div class='ingredient-item'><i class='fa fa-check-circle'></i><b>" + ingredient[0] + " </b><b>" + ingredient[1] + " </b><span>" + ingredientName + " </span><i class='fa fa-times-circle close-ingredient' onclick='removeIngredientDiv(this)'></i></div>";
            $(".all-ingredient").append(appendValue);
            allIngredients.push(inputString);
        } else {
            checkInputIngreError(".ingredient-input", message);
        }

        $(".all-ingredients").val(allIngredients);
    }

    

    $('.ingredient-field').on('keypress', function (e) {
        
        if (e.which === 13) {
            e.preventDefault(e);
           //Disable textbox to prevent multiple submit
           $(this).attr("disabled", "disabled");
           inputModifying();
           $(".ingredient-input input.ingredient-field").val('');

           //Enable the textbox again if needed.
           $(this).removeAttr("disabled");
        }
    });


    
    $('.add-more-btn').click(function () {
        step_num ++;
        step_num_not_decrease ++;
        var mapObj = {
            stepCount : step_num,
            stepContent : "step" + step_num + "[content]",
            stepName : "step" + step_num + "[name]",
            stepTime : "step" + step_num + "[time]",
            stepNote : "step" + step_num + "[note]",
            stepFile : "step_files" + step_num + "[]",
            stepFileHidden: "step_file_hidden" + step_num
        };

        
        step_div_replaced = step_div.replace(/stepCount|stepContent|stepName|stepTime|stepNote|stepFile|stepFileHidden/gi, function(x) {
            return mapObj[x];
        });

        $('.wrap-step-box').append(step_div_replaced);
        $('.step-num').val(step_num);
        $('.step_num_not_decrease').val(step_num_not_decrease);
    });

    $(document).on('click', '.btn-delete-step', function() {
        $(this).parent('.step-box').remove();
        step_num--;
        $('.step-num').val(step_num);
    });

    $(document).on('click', '.button-clear', function(e) {
        $(e.target).closest('.button-clear').attr("style", "display:none !important");
        $(e.target).closest('.wrap-preview').find('.preview-images-zone').find(".preview-image").remove();
        $(e.target).closest('.wrap-preview').find('.preview-images-zone').attr("style", "border:none;");
        $(e.target).closest('.wrap-preview').find('.input-clear').val('cleared');
        $(e.target).closest('.wrap-upload-image').find(".step-hidden-files").val("");
        $(e.target).closest('.wrap-preview').find('.image-num').val("");
        $(e.target).closest('.wrap-upload-image').find(".picture-overlay").attr('style', 'display:none')
    });

});
// Image js
function readImageUpdate() {
    var $output = $(event.target).closest(".wrap-upload-image").find(".preview-images-zone");
    var $clearButton = $(event.target).closest(".wrap-upload-image").find(".button-clear");
    var $clearInput = $(event.target).closest(".wrap-upload-image").find(".input-clear");
    var $overlay = $(event.target).closest(".wrap-upload-image").find(".picture-overlay");

    var num = $output.find('.image-num').val();
    if (window.File && window.FileList && window.FileReader) {
        var files = event.target.files; //FileList object
        $clearInput.val("");
        if ($output.data("type") == "new" && num < 6) {
            $output.find(".preview-image").remove();
        }

        for (let i = 0; i < files.length; i++) {

            var file = files[i];

            if (!file.type.match('image')) continue;
            
            var picReader = new FileReader();
            
            picReader.addEventListener('load', function (event) {
                var picFile = event.target;
                
                var html =  '<div class="preview-image preview-show-' + num + '">' +
                            '<div class="image-zone"><img id="pro-img-' + num + '" src="' + picFile.result + '"></div>' +
                            '</div>';
                
                if (num < 6) {
                    $output.append(html);
                    num++;
                }
            });
            picReader.readAsDataURL(file);
            $('.wrap-preview').attr('style', 'display:block;');
            $output.attr('style', 'border:1px solid #ddd');
            $clearButton.attr('style', 'display:block ');
            $overlay.attr('style', 'display: block')
        }
        $("#pro-image").val('');
    } else {
        console.log('Browser not support');
    }
}
// End image js

function readImage() {
    var num = 1;

    if (window.File && window.FileList && window.FileReader) {
        var files = event.target.files; //FileList object
        var output = $(event.target).closest(".wrap-upload-image").find(".preview-images-zone");
        output.html("");
        for (let i = 0; i < files.length; i++) {

            var file = files[i];

            if (!file.type.match('image')) continue;
            
            var picReader = new FileReader();
            
            picReader.addEventListener('load', function (event) {
                var picFile = event.target;
                
                var html =  '<div class="preview-image preview-show-' + num + '">' +
                            '<div class="image-zone"><img id="pro-img-' + num + '" src="' + picFile.result + '"></div>' +
                            '</div>';
                if (num <= 6) {
                    output.append(html);
                }
                num ++;
            });
            
            picReader.readAsDataURL(file);
            $('.wrap-preview').attr('style', 'display:block;');
        }
        $("#pro-image").val('');
    } else {
        console.log('Browser not support');
    }
}
// End image js

// Self custom js
function removeIngredientDiv (e1)
{
    $(e1).closest('.ingredient-item').remove(); 
}
// End self custom js
