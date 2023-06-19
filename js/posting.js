$(document).ready(function() 
{
    if (window.File && window.FileList && window.FileReader) 
    {
        $("#imgUpload").on("change", function(e) 
        {
            var files = e.target.files,
            filesLength = files.length;
            for (var i = 0; i < filesLength; i++) 
            {
                var f = files[i]
                var fileReader = new FileReader();
                fileReader.onload = (function(e) 
                {
                    var file = e.target;
                    $("<span class=\"pip\">" +
                        "<img class=\"imageThumb\" src=\"" + e.target.result + "\" />" +
                        "<span class=\"remove\">&#x2716;</span>" +
                        "</span>").insertAfter("#imgPreview");
                    $(".imageThumb").click(function(){
                        $(this).parent(".pip").remove();
                        const input = document.getElementById("imgUpload");
                        var files = input.files;
                        const index = array.indexOf(e.target.result);
                        if (index > -1) { // only splice array when item is found
                            files.splice(index, 1); // 2nd parameter means remove one item only
                        }
                        //input.value = '';
                        enableDisable();
                    });

                // Old code here
                /*$("<img></img>", {
                    class: "imageThumb",
                    src: e.target.result,
                    title: file.name + " | Click to remove"
                }).insertAfter("#files").click(function(){$(this).remove();});*/
                });
                fileReader.readAsDataURL(f);
            }
        });
    } 
    else 
    {
        alert("Your browser doesn't support to File API")
    }

    
});

function enableDisable() {

var imgUpload = document.getElementById("imgUpload");
    var btnSubmit = document.getElementById("submitPostButton");
    if (imgUpload.files.length != 0) {
        btnSubmit.disabled = false;
    } else {
        btnSubmit.disabled = true;
    }

}