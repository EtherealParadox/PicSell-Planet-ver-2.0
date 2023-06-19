    <?php

    require 'myAdmin.php';

    //Total of Dashboard

    function getTotalCustomer(){
        $myAdmin = new myAdmin();
        $records = $myAdmin->totalCustomer();
    }
    function getTotalLensman(){
        $myAdmin = new myAdmin();
        $records = $myAdmin->totalLensman();
    }
    function getTotalPost(){
        $myAdmin = new myAdmin();
        $records = $myAdmin->totalPost();
    }
    function getTotalServices(){
        $myAdmin = new myAdmin();
        $records = $myAdmin->totalServices();
    }
    function getTotalProducts(){
        $myAdmin = new myAdmin();
        $records = $myAdmin->totalProducts();
    }
    //Start of Dashboard Admin

    function getAllDashPost()
    {
        echo '
                <table>
                <tr>
                    <th>Post Id</th>
                    <th>Post Content</th>
                    <th>Post Date</th>
                    <th>User Name</th>
                    <th>Action</th>
                </tr>
            ';
        $myAdmin = new myAdmin();
        $records = $myAdmin->tblPost();
        if (isset($records)) {
            foreach ($records as $row) {
                echo '<tr>';
                echo '<td>' . $row['post_id'] . '</td>';
                echo '<td>' . $row['post_content'] . '</td>';
                echo '<td>' . $row['post_date'] . '</td>';
                echo '<td>' . $row['user_name'] . '</td>';
                echo '<td><a href="?post_id=' . $row['post_id'] . '" class="btn" /*href="admin_dashboard.php?posts_editing_id=' . $row['post_id'] . '"*/>View</a></td>';
                echo '</tr>';
            }
        }
        echo '
                </table>
            ';
    }

    function getAllDashCustomer()
    {
        echo '
                <table>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
            ';
        $myAdmin = new myAdmin();
        $records = $myAdmin->tblDashCustomer();
        if (isset($records)) {
            foreach ($records as $row) {
                echo '<tr>';
                echo '<td>' . $row['user_id'] . '</td>';
                echo '<td>' . $row['user_name'] . '</td>';
                echo '<td><a href="?user_id=' . $row['user_id'] . '" class="btn" /*href="admin_dashboard.php?posts_editing_id=' . $row['user_id'] . '"*/>View</a></td>';
                echo '</tr>';
            }
        }
        echo '
                </table>
            ';
    }

    //End of Dashboard Admin

    function getAllPost()
    {
        /*echo '
                <table>
                <tr>
                    <th>Post Id</th>
                    <th>Post Content</th>
                    <th>Post Date</th>
                    <th>User Name</th>
                    <th colspan=2>Action</th>
                </tr>
            ';*/
        $myAdmin = new myAdmin();
        $records = $myAdmin->tblPost();
        if (isset($records)) {
            foreach ($records as $row) {
                (!empty($row['post_content'])) ? $post_content = $row['post_content'] : $post_content = "-User did not put any message-";
                echo '<tr>';
                echo '<td>' . $row['post_id'] . '</td>';
                echo '<td>' . $post_content . '</td>';
                echo '<td>' . $row['post_date'] . '</td>';
                echo '<td>' . $row['user_name'] . '</td>';
                echo '<td><a href="?post_id=' . $row['post_id'] . '" class="btn" /*href="admin_dashboard.php?posts_editing_id=' . $row['post_id'] . '"*/>View</a></td>';
                echo '<td onclick="archive('. $row['post_id'] .')"><a href="#" class="btn text-danger" href="admin_dashboard.php?posts_deleting_id=' . $row['post_id'] . '">Archive</a></td>';
                echo '</tr>';
            }
        }
        /*echo '
                </table>
            ';*/
    }

    function getAllServices()
    {
        /*echo '
                <table>
                <tr>
                    <th>Service ID</th>
                    <th>Service Type</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>User Name</th>
                    <th colspan=2>Action</th>
                </tr>
            ';*/
        $myAdmin = new myAdmin();
        $records = $myAdmin->tblServices();
        if (isset($records)) {
            foreach ($records as $row) {
                echo '<tr>';
                echo '<td>' . $row['service_id'] . '</td>';
                echo '<td>' . $row['service_name'] . '</td>';
                echo '<td>' . $row['service_price'] . '</td>';
                echo '<td>' . $row['service_description'] . '</td>';
                echo '<td>' . $row['user_name'] . '</td>';
                echo '<td><a href="?service_id=' . $row['service_id'] . '" class="btn" /*href="admin_dashboard.php?posts_editing_id=' . $row['service_id'] . '"*/>View</a></td>';
                echo '<td onclick="archive('. $row['service_id'] .')"><a href="#" class="btn text-danger" href="admin_dashboard.php?posts_deleting_id=' . $row['service_id'] . '">Archive</a></td>';
                echo '</tr>';
            }
        }
        /*echo '
                </table>
            ';*/
    }

    function getAllProducts()
    {
        /*echo '
                <table>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>User Name</th>
                    <th colspan=2>Action</th>
                </tr>
            ';*/
        $myAdmin = new myAdmin();
        $records = $myAdmin->tblProduct();
        if (isset($records)) {
            foreach ($records as $row) {
                echo '<tr>';
                echo '<td>' . $row['product_id'] . '</td>';
                echo '<td>' . $row['product_name'] . '</td>';
                echo '<td>' . $row['product_price'] . '</td>';
                echo '<td>' . $row['product_description'] . '</td>';
                echo '<td>' . $row['user_name'] . '</td>';
                echo '<td><a href="?product_id=' . $row['product_id'] . '" class="btn" /*href="admin_dashboard.php?posts_editing_id=' . $row['product_id'] . '"*/>View</a></td>';
                echo '<td onclick="archive('. $row['product_id'] .')"><a href="#" class="btn text-danger" href="admin_dashboard.php?posts_deleting_id=' . $row['product_id'] . '">Archive</a></td>';
                echo '</tr>';
            }
        }
        /*echo '
                </table>
            ';*/
    }

    function getAllFeedback()
    {
        /*echo '
                <table>
                <tr>
                    <th>Feedback ID</th>
                    <th>Rate</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>User Name</th>
                    <th colspan=2>Action</th>
                </tr>
            ';*/
        $myAdmin = new myAdmin();
        $records = $myAdmin->tblFeedback();
        if (isset($records)) {
            foreach ($records as $row) {
                (!empty($row['feedback_message'])) ? $fdbk_msg = $row['feedback_message'] : $fdbk_msg = "-User did not leave any message-";
                echo '<tr>';
                echo '<td>' . $row['feedback_id'] . '</td>';
                echo '<td>' . $row['feedback_rate'] . ' <i class="fas fa-star" style="color: #f3da35"></i></td>';
                echo '<td>' . $fdbk_msg . '</td>';
                echo '<td>' . $row['feedback_date'] . '</td>';
                echo '<td>' . $row['user_name'] . '</td>';
                echo '<td><a href="?feedback_id=' . $row['feedback_id'] . '" class="btn" /*href="admin_dashboard.php?posts_editing_id=' . $row['feedback_id'] . '"*/>View</a></td>';
                echo '<td onclick="archive('. $row['feedback_id'] .')"><a href="#" class="btn text-danger" href="admin_dashboard.php?posts_deleting_id=' . $row['feedback_id'] . '">Archive</a></td>';
                echo '</tr>';
            }
        }
        /*echo '
                </table>
            ';*/
    }

    function getAllAccounts()
    {
        /*echo '
                <table>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Address</th>
                    <th>Sex</th>
                    <th>Birthday</th>
                    <th>Contact</th>
                    <th colspan=2>Action</th>
                </tr>
            ';*/
        $myAdmin = new myAdmin();
        $records = $myAdmin->tblAccounts();
        if (isset($records)) {
            foreach ($records as $row) {
                echo '<tr>';
                echo '<td>' . $row['user_id'] . '</td>';
                echo '<td>' . $row['user_name'] . '</td>';
                echo '<td>' . $row['user_email'] . '</td>';
                echo '<td>' . $row['user_type'] . '</td>';
                echo '<td>' . $row['user_address'] . '</td>';
                echo '<td>' . $row['user_sex'] . '</td>';
                echo '<td>' . $row['user_contact'] . '</td>';
                echo '<td>' . $row['user_archive_status'] . '</td>';
                echo '<td><a href="?user_id=' . $row['user_id'] . '" class="btn" /*href="admin_dashboard.php?posts_editing_id=' . $row['user_id'] . '"*/>View</a></td>';
                echo '<td onclick="archive('. $row['user_id'] .')"><a class="btn text-danger">Archive</a></td>';
                echo '</tr>';
            }
        }
        /*echo '
                </table>
            ';*/
    }