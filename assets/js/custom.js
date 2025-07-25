
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
    console.log("follow button is clicked");
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
            console.log('response');  //not workiing
            if (response.status) {
                $(button).text("Follow");
                $(button).attr('userId:', user_id_v);
                $(button).attr('disabled:', false);
                $(button).removeClass('unfollowbtn btn-danger').addClass('followbtn btn-primary');
            }
        }
    });
};

