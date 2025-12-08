"use strict";

let getYesWord = $('#message-yes-word').data('text');
let getNoWord = $('#message-no-word').data('text');
let messageAreYouSureDeleteThis = $('#message-are-you-sure-delete-this').data('text');
let messageYouWillNotAbleRevertThis = $('#message-you-will-not-be-able-to-revert-this').data('text');

function handleBannerTypeChange() {
    let inputValue = $('#banner_type_select').val() ? $('#banner_type_select').val().toString() : '';
    
    if (inputValue === "Main Banner") {
        $('.input-field-for-main-banner').removeClass('d-none');
    } else {
        $('.input-field-for-main-banner').addClass('d-none');
    }
    
    // Handle Hero Slider multiple image upload
    if (inputValue === "Hero Slider") {
        $('.single-image-upload').addClass('d-none');
        $('.multiple-image-upload').removeClass('d-none');
        $('.single_file_input').removeAttr('required').val('').removeAttr('name');
        $('.multiple_file_input').attr('required', 'required').attr('name', 'images[]');
        $('.hero-slider-url-note').removeClass('d-none');
    } else {
        $('.single-image-upload').removeClass('d-none');
        $('.multiple-image-upload').addClass('d-none');
        $('.multiple_file_input').removeAttr('required').val('').removeAttr('name');
        $('.single_file_input').attr('required', 'required').attr('name', 'image');
        $('.hero-slider-url-note').addClass('d-none');
        $('#multiple-images-preview').empty();
    }
}

$('#banner_type_select').on('change', handleBannerTypeChange);

// Initialize on page load
$(document).ready(function() {
    handleBannerTypeChange();
    
    // Handle form reset
    $('.banner_form').on('reset', function() {
        setTimeout(function() {
            handleBannerTypeChange();
        }, 100);
    });
});

$(".js-example-theme-single").select2({theme: "classic"});
$(".js-example-responsive").select2({width: 'resolve'});

$('#main-banner-add').on('click', function () {
    $('#main-banner').slideToggle();
});

$('.action-display-data').on('change', function () {
    let data = $(this).val();
    let elementResourceProduct = $('#resource-product');
    let elementResourceBrand = $('#resource-brand');
    let elementResourceCategory = $('#resource-category');
    let elementResourceShop = $('#resource-shop');

    elementResourceProduct.hide()
    elementResourceBrand.hide()
    elementResourceCategory.hide()
    elementResourceShop.hide()

    if (data === 'product') {
        elementResourceProduct.show()
    } else if (data === 'brand') {
        elementResourceBrand.show()
    } else if (data === 'category') {
        elementResourceCategory.show()
    } else if (data === 'shop') {
        elementResourceShop.show()
    }
})

$('#banner').on('change', function(){
    var input = this;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        let inputImage = $('.input_image');
        reader.onload = (e) => {
            let imageData = e.target.result;
            input.setAttribute("data-title", "");
            let img = new Image();
            img.onload = function () {
                inputImage.css({
                    "background-image": `url('${imageData}')`,
                    "width": "100%",
                    "height": "auto",
                    backgroundPosition: "center",
                    backgroundSize: "contain",
                    backgroundRepeat: "no-repeat",
                });
                inputImage.addClass('hide-before-content')
            };
            img.src = imageData;
        }
        reader.readAsDataURL(input.files[0]);
    }
});

// Handle multiple file upload preview for Hero Slider
$('#banner-multiple').on('change', function(){
    var input = this;
    var previewContainer = $('#multiple-images-preview');
    previewContainer.empty();
    
    if (input.files && input.files.length > 0) {
        Array.from(input.files).forEach(function(file, index) {
            let reader = new FileReader();
            reader.onload = (e) => {
                let imageData = e.target.result;
                let previewItem = $('<div class="position-relative" style="width: 120px; height: 80px; margin: 5px;">' +
                    '<img src="' + imageData + '" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">' +
                    '<span class="badge bg-primary position-absolute top-0 end-0 m-1">' + (index + 1) + '</span>' +
                    '</div>');
                previewContainer.append(previewItem);
            };
            reader.readAsDataURL(file);
        });
    }
});

$('.banner-delete-button').on('click', function () {
    let bannerId = $(this).attr("id");
    Swal.fire({
        title: messageAreYouSureDeleteThis,
        text: messageYouWillNotAbleRevertThis,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: getYesWord,
        cancelButtonText: getNoWord,
        type: 'warning',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: $('#route-admin-banner-delete').data('url'),
                method: 'POST',
                data: {id: bannerId},
                success: function (response) {
                    toastMagic.success(response.message);
                    location.reload();
                }
            });
        }
    })
});

var backgroundImage = $("[data-bg-img]");
backgroundImage.css("background-image", function () {
    return 'url("' + $(this).data("bg-img") + '")';
}).removeAttr("data-bg-img").addClass("bg-img");

$('.most-demanded-product-delete-button').on('click', function () {
    let productId = $(this).attr("id");
    Swal.fire({
        title: $(this).data('warning-text'),
        text:  $(this).data('text'),
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        type: 'warning',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: $('#route-admin-most-demanded-delete').data('url'),
                method: 'POST',
                data: {id: productId},
                success: function (response) {
                    toastMagic.success(response.message);
                    location.reload()
                }
            });
        }
    })
})

$('.most-demanded-status-form').on('submit', function(event){
    event.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            toastMagic.success(response.message);
            setTimeout(function (){
                location.reload()
            },1000);
        }
    });
});
