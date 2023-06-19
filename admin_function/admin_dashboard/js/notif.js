        /* When the user clicks on the button, 
        toggle between hiding and showing the dropdown content */
        function showNotif() {
            document.getElementById("myDropdown-notif").classList.toggle("show-notif");
            
            var dropdowns = document.getElementsByClassName("dropdown-content-notif");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show-notif')) {
                    $.ajax(
                    {
                        type: "GET",
                        url:"admin_ajax.php?action=update_notif_status_adm",
                        success: function (resp) {
                            console.log(resp);
                        }
                    });
                }
                else{
                    location.reload();
                }
            }
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn-notif') && !event.target.matches('.notif-btn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content-notif");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show-notif')) {
                        openDropdown.classList.remove('show-notif');
                        location.reload();
                    }
                }
            }
        }