
document.addEventListener("DOMContentLoaded", function () {
    var input = document.querySelector('#select_post_img');
    if (input) {
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
    }
});


//post validation
$(document).on("click", ".post-btn", function (e) {
    e.preventDefault();

    let postText = $('#exampleFormControlTextarea1').val().trim();
    let postImg = $('#select_post_img')[0].files[0];
    let postImgError = $('#post_img_error');


    if (!postImg) {
        postImgError.html("<p class='text-danger'>Please enter a post text or select an image.</p>");
        return;
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




// Follow button handler
$(document).on("click", ".followbtn", follow);
function follow() {
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
                $(button).attr('disabled:', false);
                $(button).removeClass('followbtn btn-primary').addClass('unfollowbtn btn-danger');
            } else {
                $(button).attr('disabled:', false);
                alert('Something went wrong, please try again later.');
            }
        }
    });
};



// Unfollow button handler
$(document).on("click", ".unfollowbtn", unfollow);

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
                $(button).attr('disabled:', false);
                $(button).removeClass('unfollowbtn btn-danger').addClass('followbtn btn-primary');
                console.log(response);
            } else {
                $(button).attr('disabled:', false);
                alert('Something went wrong, please try again later.');
            }
        }
    });
};


// for like the post
$(document).on("click", ".like_btn", like);
function like() {
    let post_id_v = $(this).data('postId');
    let button = this;
    $(button).attr('disabled', true);
    $.ajax({
        url: 'assets/php/ajax.php?like',
        method: 'POST',
        dataType: 'json',
        data: { post_id: post_id_v },
        success: function (response) {
            console.log(response);
            if (response.status) {
                $(button).attr('disabled', false);
                $(button).attr('class', 'bi bi-heart-fill text-danger unlike_btn');
                $('#likeCount_' + post_id_v).html(response.like_count);

            } else {
                $(button).attr('disabled:', false);
                alert('Something went wrong, please try again later.');
            }
        }
    })
};


// for unlike the post
$(document).on("click", ".unlike_btn", unlike);

function unlike() {
    let post_id_v = $(this).data('postId');
    let button = this;
    $(button).attr('disabled', true);
    $.ajax({
        url: 'assets/php/ajax.php?unlike',
        method: 'POST',
        dataType: 'json',
        data: { post_id: post_id_v },
        success: function (response) {
            if (response.status) {
                $(button).attr('disabled:', false);
                $(button).attr('class', 'bi bi-heart like_btn');
                $('#likeCount_' + post_id_v).html(response.like_count);
            } else {
                $(button).attr('disabled', false);
                alert('Something went wrong, please try again later.');
            }
        }
    })
};

// for refreshing like count
setInterval(function () {
    $('.like_count_refresh').each(function () {
        let postId = $(this).data('postId');
        $.ajax({
            url: 'assets/php/ajax.php?get_like_count',
            method: 'POST',
            dataType: 'json',
            data: { post_id: postId },
            success: function (response) {
                if (response.status) {
                    $('#likeCount_' + postId).text(response.like_count);
                }
            }
        });
    });
},1000); // every 3 seconds

// REFRESH LIKE COUNT when LIKE MODAL opens
// $(document).on('shown.bs.modal', function (e) {
//     let modalId = $(e.target).attr('id'); // e.g. likes12
//     let postId = modalId.replace('likes', '');

//     $.ajax({
//         url: 'assets/php/ajax.php?get_like_count',
//         method: 'POST',
//         dataType: 'json',
//         data: { post_id: postId },
//         success: function (response) {
//             if (response.status) {
//                 $('#likeCount_' + postId).text(response.like_count);
//             }
//         }
//     });
// });