<?php
    include 'db_connect.php';

    // Set your timezone
    date_default_timezone_set('Asia/Manila');

    // Get prev & next month
    if (isset($_GET['ym'])) {
        $ym = $_GET['ym'];
    } else {
        // This month
        $ym = date('Y-m', time());
    }

    // Check format
    $timestamp = strtotime($ym . '-01');
    if ($timestamp === false) {
        $ym = date('Y-m');
        $timestamp = strtotime($ym . '-01');
    }

    // Year
    $year = date('Y', $timestamp);


    // Month
    $month = date('m', $timestamp);
    $c_month = date('Y-m', time());

    // Today
    $today = date('Y-m-d', time());

    // For H3 title
    $html_title = date('F Y', $timestamp);

    // Create prev & next month link     mktime(hour,minute,second,month,day,year)
    $prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
    $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));
    // You can also use strtotime!
    // $prev = date('Y-m', strtotime('-1 month', $timestamp));
    // $next = date('Y-m', strtotime('+1 month', $timestamp));

    // Number of days in the month
    $day_count = date('t', $timestamp);
    
    // 0:Sun 1:Mon 2:Tue ...
    $str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
    //$str = date('w', $timestamp);


    // Create Calendar!!
    $weeks = array();
    $week = '';

    // Add empty cell
    $week .= str_repeat('<td class="empty"></td>', $str);

    $user = $_SESSION['login_user_id'];
    $lensman_id = $_GET['l_id'];
    $srvc_id = $_GET['srvc_id'];
    $avail = $conn->query("SELECT sa.* FROM tbl_service_avail sa LEFT JOIN tbl_service_packages sp ON sa.service_id = sp.service_id  WHERE sp.user_id = '$lensman_id'");
    $avail_id = array(); $avail_id_downpayment = array(); $avail_id_conf = array(); $avail_id_comp = array(); 
    $avail_id_canc = array();
    $availed = array();
    $downpayment = array();
    $confirmed = array();
    $completed = array();
    $cancelled = array();
    $resched = array();
    $availed_others = array();

    function funcdiff($date2, $date1) {
        $date1 = new DateTime($date1);
        $date2 = new DateTime($date2);
        $datediff   = $date2->diff($date1->modify('-1 day'));
        return $datediff->d;
    }

    function createRange($startDate, $endDate) {
        $tmpDate = new DateTime($startDate);
        $tmpEndDate = new DateTime($endDate);
    
        $outArray = array();
        do {
            $outArray[] = $tmpDate->format('Y-m-j');
        } while ($tmpDate->modify('+1 day') <= $tmpEndDate);
    
        return $outArray;
    }

    while($row=$avail->fetch_assoc())
    {
        date_default_timezone_set('Asia/Manila');
        $s_nt = date('Y-m-d', strtotime($row['avail_starting_date_time']));
        $e_nt = date('Y-m-d', strtotime($row['avail_ending_date_time']));
        #0 - Pending, 1 - Downpayment, 2 - Confirmed, 3 - Completed, 4 - Cancelled, 5 - Reschedule
        if($row['service_id'] == $srvc_id)
        {
            if($row['user_id'] == $user)
            {
                if($row['avail_status'] == 0)
                {
                    $availed[] = $s_nt;
                    $avail_id[$s_nt] = $row['avail_id'];
                }
                if($row['avail_status'] == 1)
                {
                    $downpayment[] = $s_nt;
                    $avail_id_downpayment[$s_nt] = $row['avail_id'];
                }
                if($row['avail_status'] == 2)
                {
                    $confirmed[] = $s_nt;
                    $avail_id_conf[$s_nt] = $row['avail_id'];
                }
                if($row['avail_status'] == 3)
                {
                    $completed[] = $s_nt;
                    $avail_id_comp[$s_nt] = $row['avail_id'];
                }
                if($row['avail_status'] == 4)
                {
                    $cancelled[] = $s_nt;
                    $avail_id_canc[$s_nt] = $row['avail_id'];
                }
                if($row['avail_status'] == 5)
                {
                    $resched[] = $s_nt;
                    $avail_id_resched[$s_nt] = $row['avail_id'];
                }
            }
            else
            {
                if($row['avail_status'] != 3 && $row['avail_status'] != 4)
                {
                    $availed_others[] = $s_nt;
                }
            }
        }
        else
        {
            if($row['avail_status'] != 3 && $row['avail_status'] != 4)
            {
                $availed_others[] = $s_nt;
            }
        }
        //$data_id = $row['avail_id'];
    }

    
    
    for ( $day = 1; $day <= $day_count; $day++, $str++)
    {
        ($day>9) ? $d = '-' : $d = '-0';
        $date = $ym . $d . $day;

        if($today > $date)
        {
            $week .= '<td  class="past">' . $day;
        }
        elseif($today == $date) 
        {
            if(in_array($date, $availed))
            {
                $a_id = $avail_id[$date];
                $week .= '<td class="availed" id="availed" onclick="showAvail('.$a_id.')">' . $day . " (Today) <div style='text-align:center; color: black;'><img class='srvc_icn' src='../assets/icons/own_avail.png'></i></div>";
            }
            else if(in_array($date, $downpayment))
            {
                $avail_id_downpayment = $avail_id_downpayment[$date];
                $week .= '<td class="availed_downpayment" id="downpayment" onclick="showAvail('.$avail_id_downpayment.')">' . $day . " (Today) <div style='text-align:center; color: black;'><img class='srvc_icn' src='../assets/icons/downpayment.png'></div>";
            }
            else if(in_array($date, $confirmed))
            {
                $a_id_conf = $avail_id_conf[$date];
                $week .= '<td class="availed_confirmed" id="confirmed" onclick="showAvail('.$a_id_conf.')">' . $day . " (Today) <div style='text-align:center; color: black;'><img class='srvc_icn' src='../assets/icons/own_avail.png'></div>";
            }
            else if(in_array($date, $completed))
            {
                $a_id_comp = $avail_id_comp[$date];
                $week .= '<td class="availed_completed" id="completed" onclick="showAvail('.$a_id_comp.')">' . $day . " (Today) <div style='text-align:center; color: black;'><img class='srvc_icn' src='../assets/icons/own_avail.png'></div>";
            }
            else if(in_array($date, $cancelled))
            {
                $a_id_canc = $avail_id_canc[$date];
                $week .= '<td class="availed_cancelled" id="availed_cancelled" onclick="showAvail('.$a_id_canc.')">' . $day . " (Today) <div style='text-align:center; color: black;'><img class='srvc_icn' src='../assets/icons/avail_cancel.png'></div>";
            }
            elseif(in_array($date, $resched))
            {
                $a_id_resched = $avail_id_resched[$date];
                $week .= '<td class="availed_resched" id="availed_resched" onclick="showAvail('.$a_id_resched.')">' . $day . "<div style='text-align:center; color: black;'><img class='srvc_icn' src='../assets/icons/avail_resched.png'></div>";
            }
            else
            {
                $week .= '<td  id='.$date.'>' . $day . ' (Today)';
            }
        }
        elseif(in_array($date, $availed))
        {
            $a_id = $avail_id[$date];
            $week .= '<td class="availed" id="availed" onclick="showAvail('.$a_id.')">' . $day . "<div style='text-align:center; color: black;'><img class='srvc_icn' src='../assets/icons/own_avail.png'></div>";
        }
        else if(in_array($date, $downpayment))
        {
            $avail_id_downpayment = $avail_id_downpayment[$date];
            $week .= '<td class="availed_downpayment" id="downpayment" onclick="showAvail('.$avail_id_downpayment.')">' . $day . "<div style='text-align:center; color: black;'><img class='srvc_icn' src='../assets/icons/downpayment.png'></div>";
        }
        elseif(in_array($date, $confirmed))
        {
            $a_id_conf = $avail_id_conf[$date];
            $week .= '<td class="availed_confirmed" id="confirmed" onclick="showAvail('.$a_id_conf.')">' . $day . "<div style='text-align:center; color: black;'><img class='srvc_icn' src='../assets/icons/own_avail.png'></div>";
        }
        elseif(in_array($date, $completed))
        {
            $a_id_comp = $avail_id_comp[$date];
            $week .= '<td class="availed_completed" id="completed" onclick="showAvail('.$a_id_comp.')">' . $day . "<div style='text-align:center; color: black;'><img class='srvc_icn' src='../assets/icons/own_avail.png'></div>";
        }
        elseif(in_array($date, $cancelled))
        {
            $a_id_canc = $avail_id_canc[$date];
            $week .= '<td class="availed_cancelled" id="availed_cancelled" onclick="showAvail('.$a_id_canc.')">' . $day . "<div style='text-align:center; color: black;'><img class='srvc_icn' src='../assets/icons/avail_cancel.png'></div>";
        }
        elseif(in_array($date, $resched))
        {
            $a_id_resched = $avail_id_resched[$date];
            $week .= '<td class="availed_resched" id="availed_resched" onclick="showAvail('.$a_id_resched.')">' . $day . "<div style='text-align:center; color: black;'><img class='srvc_icn' src='../assets/icons/avail_resched.png'></div>";
        }
        elseif(in_array($date, $availed_others))
        {
            $week .= '<td class="availed_others">' . $day;
        }
        else 
        {
            $week .= '<td>' . $day;
        }
        $week .= '</td>';

        // End of the week OR End of the month
        if ($str % 7 == 6 || $day == $day_count) {

            if ($day == $day_count) {
                // Add empty cell
                $week .= str_repeat('<td class="empty"></td>', 6 - ($str % 7));
            }

            $weeks[] = '<tr>' . $week . '</tr>';

            // Prepare for new week
            $week = '';
        }

        
    }