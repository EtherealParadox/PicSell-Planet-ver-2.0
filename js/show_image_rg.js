        
    function showID()
    {
        var id_src = document.getElementById('id_upload_hidden').value
        var id_src_name = document.getElementById('id_upload_name_hidden').value
        if(id_src=="")
        {
            Swal.fire({
                customClass: {
                    cancelButton: 'swal2PP_cancel',
                },
                html: `
                    <h3 style="margin-bottom: 10px; text-align: center;">ID Image</h3>
                    <h2 style="text-align: center;">No Image Yet...</h2>
                `,
                toast: true,
                position: "center",
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: "Close",
            })
        }
        else
        {
            Swal.fire({
                customClass: {
                    cancelButton: 'swal2PP_cancel',
                },
                html: `
                    <h4 style="margin-bottom: 10px; text-align: center;">ID Image</h4>
                    <div style="text-align: center;">
                        <img id="previewID" src="` + id_src + `">
                    </div>
                    <h3 style="margin-bottom: 10px; text-align: center;">` + id_src_name + `</h3>
                `,
                toast: true,
                position: "center",
                width: '600px',
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: "Close",
            })
        }
    }

    function showPermit()
    {
        var permit_src = document.getElementById('permit_upload_hidden').value
        var permit_src_name = document.getElementById('permit_upload_name_hidden').value
        if(permit_src=="")
        {
            Swal.fire({
                customClass: {
                    cancelButton: 'swal2PP_cancel',
                },
                html: `
                    <h3 style="margin-bottom: 10px; text-align: center;">Permit Image</h3>
                    <h2 style="text-align: center;">No Image Yet...</h2>
                `,
                toast: true,
                position: "center",
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: "Close",
            })
        }
        else
        {
            Swal.fire({
                customClass: {
                    cancelButton: 'swal2PP_cancel',
                },
                html: `
                    <h4 style="margin-bottom: 10px; text-align: center;">Permit Image</h4>
                    <div style="text-align: center;">
                        <img id="previewID" src="` + permit_src + `">
                    </div>
                    <h3 style="margin-bottom: 10px; text-align: center;">` + permit_src_name + `</h3>
                `,
                toast: true,
                position: "center",
                width: '600px',
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: "Close",
            })
        }
    }

    function showPP()
    {
        var pp_src = document.getElementById('pfp_upload_hidden').value
        var pp_src_name = document.getElementById('pfp_upload_name_hidden').value
        if(pp_src=="")
        {
            Swal.fire({
                customClass: {
                    cancelButton: 'swal2PP_cancel',
                },
                html: `
                    <h3 style="margin-bottom: 10px; text-align: center;">PP Image</h3>
                    <h2 style="text-align: center;">No Image Yet...</h2>
                `,
                toast: true,
                position: "center",
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: "Close",
            })
        }
        else
        {
            Swal.fire({
                customClass: {
                    cancelButton: 'swal2PP_cancel',
                },
                html: `
                    <h3 style="margin-bottom: 10px; text-align: center;">PP Image</h3>
                    <div style="text-align: center;">
                        <img id="previewPP" src="` + pp_src + `">
                    </div>
                    <h3 style="margin-bottom: 10px; text-align: center;">` + pp_src_name + `</h3>
                `,
                toast: true,
                position: "center",
                width: '500px',
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: "Close",
            })
        }
    }