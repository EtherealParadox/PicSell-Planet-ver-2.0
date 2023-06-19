    //#region ID image section
        var chk_id_src = document.getElementById('id_upload_hidden').value
        if(chk_id_src=='')
        {
            const btn_id = document.getElementById('prev_btn_ID');
            btn_id.style.color = 'red';
        }
        else
        {
            const btn_id = document.getElementById('prev_btn_ID');
            btn_id.style.color = 'green';
        }

        var chk_id_name = document.getElementById('id_upload_name_hidden').value
        if(chk_id_name!='')
        {
            var old_txt = chk_id_name
            var file_name = old_txt.substring(0, 20) + '...';
            document.getElementById("idLabel").innerHTML = file_name
        }

        function imgActionID(element)
        {
            const btn = document.getElementById('prev_btn_ID');
            btn.style.color = 'green';

            var file = element.files[0];
            document.getElementById("id_upload_name_hidden").value = file.name

            if(file.name.length > 20)
            {
                var old_txt = file.name
                var file_name = old_txt.substring(0, 20) + '...';
                document.getElementById("idLabel").innerHTML = file_name
            }
            else
            {
                var file_name = file.name;
                document.getElementById("idLabel").innerHTML = file_name
            }
            

            const reader = new FileReader()
            reader.onload = (e) => {
                document.getElementById("id_upload_hidden").value = reader.result
            }
            reader.readAsDataURL(file)
        }
    //#endregion

    //#region Permit Image section
        var chk_permit_src = document.getElementById('permit_upload_hidden').value
        if(chk_permit_src=='')
        {
            const btn_pp = document.getElementById('prev_btn_Permit');
            btn_pp.style.color = 'red';
        }
        else
        {
            const btn_pp = document.getElementById('prev_btn_Permit');
            btn_pp.style.color = 'green';
        }

        var chk_permit_name = document.getElementById('permit_upload_name_hidden').value
        if(chk_permit_name!='')
        {
            var old_txt = chk_permit_name
            var file_name = old_txt.substring(0, 20) + '...';
            document.getElementById("permitLabel").innerHTML = file_name
        }

        function imgActionPermit(element)
        {
            const btn = document.getElementById('prev_btn_Permit');
            btn.style.color = 'green';

            var file = element.files[0];
            document.getElementById("permit_upload_name_hidden").value = file.name

            if(file.name.length > 20)
            {
                var old_txt = file.name
                var file_name = old_txt.substring(0, 20) + '...';
                document.getElementById("permitLabel").innerHTML = file_name
            }
            else
            {
                var file_name = file.name;
                document.getElementById("permitLabel").innerHTML = file_name
            }
            

            const reader = new FileReader()
            reader.onload = (e) => {
                document.getElementById("permit_upload_hidden").value = reader.result
            }
            reader.readAsDataURL(file)
        }
    //#endregion

    //#region Profile Image section 
        var chk_pp_src = document.getElementById('pfp_upload_hidden').value
        if(chk_pp_src=='')
        {
            const btn_pp = document.getElementById('prev_btn_PP');
            btn_pp.style.color = 'red';
        }
        else
        {
            const btn_pp = document.getElementById('prev_btn_PP');
            btn_pp.style.color = 'green';
        }

        var chk_pp_name = document.getElementById('pfp_upload_name_hidden').value
        if(chk_pp_name!='')
        {
            var old_txt = chk_pp_name
            var file_name = old_txt.substring(0, 20) + '...';
            document.getElementById("ppLabel").innerHTML = file_name
        }

        function imgActionPP(element)
        {
            const btn = document.getElementById('prev_btn_PP');
            btn.style.color = 'green';

            var file = element.files[0];
            document.getElementById("pfp_upload_name_hidden").value = file.name

            if(file.name.length > 20)
            {
                var old_txt = file.name
                var file_name = old_txt.substring(0, 20) + '...';
                document.getElementById("ppLabel").innerHTML = file_name
            }
            else
            {
                var file_name = file.name;
                document.getElementById("ppLabel").innerHTML = file_name
            }
            

            const reader = new FileReader()
            reader.onload = (e) => {
                document.getElementById("pfp_upload_hidden").value = reader.result
            }
            reader.readAsDataURL(file)
        }
    //#endregion