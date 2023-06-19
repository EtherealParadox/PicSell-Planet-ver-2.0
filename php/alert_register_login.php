<?php
    function alertPopup_rg()
    {
        echo "
        <script type='text/javascript'>
            function alertShowing()
            {
                get_popup = document.getElementById('alerts_rg');
                get_popup.style.display = 'block';
                setTimeout(function(){
                    get_popup.style.display = 'none';
                }, 3000);
                
            }
            window.onload = alertShowing;
        </script>
        ";
    }

    function alertPopup_lg()
    {
        echo "
        <script type='text/javascript'>
            function alertShowing()
            {
                get_popup = document.getElementById('alerts_lg');
                get_popup.style.display = 'block';
                setTimeout(function(){
                    get_popup.style.display = 'none';
                }, 5000);
            }
            window.onload = alertShowing;
        </script>
        ";
    }
?>