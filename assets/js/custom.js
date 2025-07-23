let input = document.querySelector('#select_post_img');

input.addEventListener("change", preview);

function preview(){
    let fileobject = this.files[0];
    let filereader = new FileReader();

    filereader.readAsDataURL(fileobject);
    filereader.onload = function(){
        let img_src = filereader.result;
        let image = document.querySelector('#post_img');
        image.setAttribute('src', img_src);
        image.setAttribute('style', 'display:""');
    }
}

