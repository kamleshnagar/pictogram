
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
            if (response.status) {
                $(button).attr('disabled', false);
                $(button).attr('class', 'bi bi-heart-fill text-danger unlike_btn');
                $('#likeCount_' + post_id_v).html(response.like_count);
                $('#modalLikeCount_' + post_id_v).html(response.like_count);
                // location.reload();

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
                $('#modalLikeCount_' + post_id_v).html(response.like_count);
                // location.reload();
            } else {
                $(button).attr('disabled', false);
                alert('Something went wrong, please try again later.');
            }
        }
    })
};


// //Refresghing likes in modal
$(document).on('click', '.like_count', function () {
    let postId = $(this).data('post-id');
    let modalBody = $('#likesModalBody' + postId);



    modalBody.html('<div class="text-center py-3">Loading likes...</div>');

    $.ajax({
        url: 'assets/php/ajax.php?get_like_list',
        type: 'POST',
        data: {
            post_id: postId
        },
        success: function (response) {
            modalBody.html(response);
        },
        error: function () {
            modalBody.html('<p class="text-danger">Failed to load likes. Please try again.</p>');
        }
    });
});




//for adding comment
$(document).on("click", ".add-comment", function (e) {
    e.preventDefault();
    let button = this;

    let comment_v = $(button).siblings('.comment-input').val();
    if (comment_v == '') {
        return 0;
    }
    let post_id_v = $(this).data('postId');

    $(button).attr('disabled', true);
    $(button).siblings('.comment-input').attr('disabled', true);
    let cs = $(this).data('cs');
    let page = $(this).data('page');



    $.ajax({
        url: 'assets/php/ajax.php?addcomment',
        method: 'POST',
        dataType: 'json',
        data: { post_id: post_id_v, comment: comment_v },
        success: function (response) {
            if (response.status) {
                $(button).attr('disabled', false);
                $(button).siblings('.comment-input').attr('disabled', false);
                $(button).siblings('.comment-input').val('');
                $('#' + cs).append(response.comment);
                $('.nce').hide();
                if (page == 'wall') {
                    location.reload();
                }

            } else {
                $(button).attr('disabled', true);
                $(button).siblings('.comment-input').attr('disabled', false);
                alert('Something went wrong, please try again later.');
            }
        }
    })
});


// for notifications like, post, comment

$(document).on("click", ".notification", function (e) {
    e.preventDefault();
    $('#footer_content').load('assets/pages/footer.php #footer_content>*');
    let button = this;
    if ($(button).data('c-id')) {
        let c_id = $(button).data('c-id'),
            modal = $($(button).data('bs-target')),
            target = $('#comment_' + c_id);

        console.log('comment id is ' + c_id);

        // Wait for modal to finish showing
        modal.one('shown.bs.modal', function () {
            if (target.length) {
                modal.find('.flash-highlight').removeClass('flash-highlight');
                modal.find('.overflow-auto').animate({
                    scrollTop: target.position().top - 50
                }, 500);
                target.addClass('flash-highlight');
            }
        });

    }

    if ($(button).data('n-id')) {
        let n_id = $(button).data('n-id');
        $.ajax({
            url: 'assets/php/ajax.php?notification',
            method: 'POST',
            dataType: 'json',
            data: { n_id: n_id },
            success: function (response) {
                if (response.status) {
                    $(button).find('.dot').addClass('d-none');
                    $(button).addClass('bg-light');
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                } else {
                    console.log('something error');
                }
            }
        })
    } else {
        console.log('n_id not given');
    }
});

// for searching user 
$("#searchBox").on("keyup", function () {
    let user = $(this).val().trim();
    if (user.length > 0) {
        $.ajax({
            url: "assets/php/ajax.php",
            method: "POST",
            data: { search: user },
            success: function (data) {
                $("#searchResults").html(data);
            }
        });
    } else {
        $("#searchResults").html("");
    }
})

// for notification count
function fetchNotifCount() {

    fetch("assets/php/ajax.php?getNotifCount")
        .then(res => res.text())
        .then(count => {
            count = parseInt(count) || 0;
            let badge = document.getElementById("notifCount");
            let num = document.getElementById("notifNum");

            if (count > 0) {
                badge.classList.remove("d-none");
                num.textContent = count;
                unread = count;

            } else {
                badge.classList.add("d-none");
                num.textContent = "";
            }
        })
        .catch(err => console.error("Notification fetch error:", err));
}

// for notifications modal body
function fetchNotifications() {

    $.ajax({
        url: 'assets/php/ajax.php?getNotifications',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log("fetching notifications");
            if (response.notifications) {
                $('#notifications_box').html(response.notifications);
            } else {
                $('#notifications_box').html('<p class="text-muted">No notifications</p>');
            }
        },
        error: function (xhr, status, err) {
            $('#notifications_box').html('<p class="text-danger">Error loading notifications</p>');
            console.error("AJAX error:", status, err);
            console.error("Response text:", xhr.responseText);
        }

    });
}

//observer for notifNum text changes
function observeNotifNum() {
    let notifNumEl = document.getElementById("notifNum");

    if (notifNumEl) {
        let observer = new MutationObserver(() => {
            console.log("notifNum changed");
            $("#footer_content").load("assets/pages/footer.php #footer_content>*");
            fetchNotifications();
        });

        observer.observe(notifNumEl, { childList: true, characterData: true, subtree: true });
    }
}
observeNotifNum();

$(document).on("click", "#notifications", function (e) {
    e.preventDefault();
    fetchNotifications();
})


$(document).on("click", "#messages", function (e) {
    e.preventDefault();
    syncmsg();
})





let chatting_user_id = 0;
let AUTO_SCROLL_THRESHOLD = 150;
function popchat(user_id) {

    $('#chatter_username').text('@loading');
    $('#chatter_name').text('loading...');
    $('#chatter_pic').attr('src', 'assets/images/profile/default_profile.jpg');
    $('#linkusername').attr('href', '');
    chatting_user_id = user_id;
    $('#sendmsg').attr('data-user-id', user_id);
    updateMsgReadStatus(user_id);
    syncmsg();


};

function updateMsgReadStatus(user_id) {
    $.ajax({
        url: 'assets/php/ajax.php?markAsRead',
        method: 'POST',
        dataType: 'json',
        data: { chatter_id: user_id },
        success: function (response) {
            if (response.status) {
                let $msgdot = $('.msgdot');

                if (!$msgdot.hasClass('d-none') && $msgdot.hasClass('bg-light')) {
                    return;
                }

                $msgdot.addClass('d-none');
                $msgdot.addClass('bg-light');
            }
        }
    })
}

$('#msginputform').on('submit', function (e) {
    e.preventDefault();

    let user_id = chatting_user_id;
    let msg = $('#msginput').val().trim();

    if ((msg === '') || !(msg)) return;

    $('#sendmsg').attr('disabled', true);
    $('#msginput').attr('disabled', true);

    $.ajax({
        url: 'assets/php/ajax.php?sendMessage',
        method: 'POST',
        dataType: 'json',
        data: { user_id: user_id, msg: msg },

        success: function (response) {
            if (response.status) {
                $('#sendmsg').attr('disabled', false);
                $('#msginput').attr('disabled', false).val('').focus();
                syncmsg();
                setTimeout(() => scrollToBottom(true), 150);
            }
        }
    })
})


function syncmsg() {

    $.ajax({
        url: 'assets/php/ajax.php?getMessages',
        method: 'POST',
        dataType: 'json',
        data: { chatter_id: chatting_user_id },
        success: function (response) {
            if (response.chatlist) {
                $('#chatlist').html(response.chatlist);
                if (response.newmsgcount > 0) {
                    $('#msgCount').removeClass('d-none');
                    $('#msgNum').text(response.newmsgcount);

                } else {
                    $('#msgCount').addClass('d-none');
                    $('#msgNum').text('');
                }

                if (chatting_user_id != 0) {
                    let $mb = $('#chatbox .modal-body');
                    let $chatBox = $('#chat_box');
                    let wasNearBottom = isUserNearBottom();
                    let oldScrollHeight = $mb.length ? $mb[0].scrollHeight : 0;
                    $chatBox.html(response.chat.msgs);
                    let newScrollHeight = $mb.length ? $mb[0].scrollHeight : 0;
                    if (newScrollHeight > oldScrollHeight && wasNearBottom) {
                        scrollToBottom(true);
                    }
                    if ($('#chatbox').hasClass('show')) {
                        updateMsgReadStatus(chatting_user_id);
                    }
                }

            } else {
                $('#chatlist').html('<p class="text-muted">No Messages</p>');
            }
            if (response.chat.userdata) {
                $('#chatter_username').text('@' + response.chat.userdata.username);
                $('#chatter_name').text(response.chat.userdata.first_name + ' ' + response.chat.userdata.last_name);
                $('#chatter_pic').attr('src', 'assets/images/profile/' + response.chat.userdata.profile_pic);
                $('#linkusername').attr('href', '?u=' + response.chat.userdata.username);

            }
            if (response.bs) {
                $('#msginputform').hide();
                $('#blockederror').show();
            } else {
                $('#msginputform').show();
                $('#blockederror').hide();
            }

        },
    })

}

setInterval(() => {
    fetchNotifCount();
    syncmsg();
}, 2500);

function getModalBody() {
    return
}

function isUserNearBottom() {
    let $mb = $('#chatbox .modal-body');
    if (!$mb.length) return true;
    let st = $mb.scrollTop();
    let ch = $mb[0].clientHeight;
    let sh = $mb[0].scrollHeight;
    return (st + ch + AUTO_SCROLL_THRESHOLD >= sh);
}
function scrollToBottom(force = false) {
    let $mb = $('#chatbox .modal-body');
    if (!$mb.length) return;
    if (force || isUserNearBottom()) {
        $mb.scrollTop($mb[0].scrollHeight);
    }
}
$('#chatbox').on('shown.bs.modal', function () {
    scrollToBottom(true);
});