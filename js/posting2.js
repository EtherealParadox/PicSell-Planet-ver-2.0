window.newFileList = [];

$(document).on('click', '.remove', function() {
    var remove_element = $(this);
    var id = remove_element.val();
    remove_element.closest('.imageCont').remove();
    var input = document.getElementById('imgUpload');
    var files = input.files;
    if (files.length) {
        if (typeof files[id] !== 'undefined') {
            window.newFileList.push(files[id].name)
        }
    }
    document.getElementById('removed_images').value = JSON.stringify(window.newFileList);
    enableDisable();
    valueRemover();
    //fileAlert();
});

$(document).on('change', '#imgUpload', function (event) {
    var files = document.getElementById("imgUpload");
    var total_file = document.getElementById("imgUpload").files.length;
    if(total_file < 5)
    {
        for (var i = 0; i < total_file; i++) {
            //$('#imgPreview').append("<div class='col-md-2 margin-top10 appendedImg'><img style='width: 130px; height: 130px; object-fit: cover;' src='" + URL.createObjectURL(event.target.files[i]) + "'><button class='btn btn-block btn-danger margin-top5 btnRemove' value='" + i + "'>Remove</button></div>");
            $('#imgPreview').append("<div class='imageCont'><img class='imageThumb' src='" + URL.createObjectURL(event.target.files[i]) + "'><input type='hidden' id='arr_images' name='arr_images[]' value='"+ files.files[i].name +"'><button class='remove' value='" + i + "'>&#x2716;</button></div>");
            var files2 = files.files;
            if (files2.length) {
                if (typeof files2[i] !== 'undefined') {
                    window.newFileList.splice(files2[i].name)
                }
            }
            document.getElementById('removed_images').value = JSON.stringify(window.newFileList);
        }
    }
    //fileAlert();
    //enableDisable();
});

const btn=document.querySelector('input[type=submit]');
document.querySelector('form').addEventListener('change',function(ev){
    if(ev.target.type=='file')
    {
        // I collect the inps here to allow for dynamic pages (varying number of inputs):
        const inps=[...document.querySelectorAll('input[type=file]')];
        btn.disabled=inps.some(inps=>{ // check whether the condition has been violated at least once
        if (inps.files.length>inps.dataset.max){ // show warning for first violation
            //console.log(`You are only allowed to upload a maximum of ${inps.dataset.max} files for ${inps.name}!`);
            let text = `You are only allowed to upload a maximum of ${inps.dataset.max} files`;
            var fileAlert = document.getElementById("fileAlerts");
            fileAlert.innerText = text;
            $("#fileAlerts").show().delay(1000).fadeOut();
            //fileAlert.style.display = "block";
            return true;
        }
        })
    }
});


function enableDisable() 
{
    var imgPreview = document.getElementById("imgPreview");
    var btnSubmit = document.getElementById("submitPostButton");
    if ($(imgPreview).children().length > 0 && $(imgPreview).children().length < 5 ) 
    {
        btnSubmit.disabled = false;
    }
    else
    {
        btnSubmit.disabled = true;
    }
}

function valueRemover()
{
    var imgUpload = document.getElementById("imgUpload");
    var removedImages = document.getElementById("removed_images");
    if($(imgPreview).children().length === 0)
    {
        imgUpload.value = '';
        removedImages.value = '';
    }
}

function emptyInput()
{
    var imgUpload = document.getElementById("imgUpload");
    imgUpload.value = '';
}

document.getElementById('imgUpload').onclick = function() {
    const myNode = document.getElementById("imgPreview");
    myNode.innerHTML = '';
    valueRemover();
};