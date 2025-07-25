
let input = document.querySelector('#select_post_img');

input.addEventListener("change", preview);

function preview() {
    let fileobject = this.files[0];
    let filereader = new FileReader();

    filereader.readAsDataURL(fileobject);
    filereader.onload = function () {
        let img_src = filereader.result;
        let image = document.querySelector('#post_img');
        image.setAttribute('src', img_src);
        image.setAttribute('style', 'display:""');
    }
}





// Follow button handler
$(document).on("click", ".followbtn", function () {
    let user_id_v = $(this).data('userId');
    let button = this;
    $(button).attr('disabled:', true);
    $.ajax({
        url: 'assets/php/ajax.php?follow',
        method: 'POST',
        dataType: 'json',
        data: { user_id: user_id_v },
        success: function (response) {
            if (response.status) {
                $(button).text('Unfollow');
                $(button).attr('userId:', user_id_v);
                $(button).attr('disabled:', false);
                $(button).removeClass('followbtn btn-primary').addClass('unfollowbtn btn-danger');
                $(document).on("click", ".unfollowbtn", unfollow);
                console.log("Successfully followed");
            }
        }
    });
});




// Unfollow button handler
function unfollow() {

    let user_id_v = $(this).data('userId');
    let button = this;
    $(button).attr('disabled:', true);
    $.ajax({
        url: 'assets/php/ajax.php?unfollow',
        method: 'POST',
        dataType: 'json',
        data: { user_id: user_id_v },
        success: function (response) {
            if (response.status) {
                $(button).text("Follow");
                $(button).attr('userId:', user_id_v);
                $(button).attr('disabled:', false);
                $(button).removeClass('unfollowbtn btn-danger').addClass('followbtn btn-primary');
                console.log("Successfully unfollowed");
            }
        }
    });
};

//post validation
$(document).on("click", ".post-btn", function (e) {
    e.preventDefault();

    let postText = $('#exampleFormControlTextarea1').val().trim();
    let postImg = $('#select_post_img')[0].files[0];
    let postImgError = $('#post_img_error');


    if (!postText && !postImg) {
        postImgError.html("<p class='text-danger'>Please enter a post text or select an image.</p>");
        return;
    } else {
        postImgError.html(""); // Clear error
    }

    let formData = new FormData();
    
    formData.append('post_text', postText);
    formData.append('post_img', postImg);
    if (postImg) {
        formData.append('post_img', postImg);
    }
    console.log(formData);
 $.ajax({
        url: 'assets/php/ajax.php?addpost',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
           
            if (response.status) {
                
                $('#exampleFormControlTextarea1').val('');
                $('#select_post_img').val('');
                $('#post_img').hide().attr('src', '');
               
                 window.location.href = response.redirect;

            } else {
                postImgError.html("<p class='text-danger'>" + response.message + "</p>");
            }
        },
        error: function () {
            postImgError.html("<p class='text-danger'>Something went wrong.</p>");
        }
    });
});