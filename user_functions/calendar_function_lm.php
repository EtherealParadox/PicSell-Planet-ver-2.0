<?php
    // Set your timezone
    date_default_timezone_set('Asia/Manila');
    
    $avail_cal = $conn->query("SELECT a.* FROM tbl_service_packages s LEFT JOIN tbl_service_avail a ON s.service_id = a.service_id WHERE s.user_id = {$_SESSION['login_user_id']}");
    $availed = array(); $availed_others = array();

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

    while($row=$avail_cal->fetch_assoc())
    {
        $start = strtotime($row['avail_starting_date_time']);
        $end = strtotime($row['avail_ending_date_time']);
        $s_nt = date('Y-m-d', $start);
        $e_nt = date('Y-m-d', $end);

        ($s_nt == $e_nt) ? $sameMonth = "same" : $sameMonth = "not";
    
        // Get the month/s of schedule
        if (isset($_GET['ym'])) {
            $ym = $_GET['ym'];
        } else {
            // Starting Month Client Added
            $ym = date('Y-m', strtotime($row['avail_starting_date_time']));
        }

        if( $row['service_id'] == $_GET['srvc_id'])
        {
            if($row['user_id'] == $user_id)
            {
                if($row['avail_id'] == $_GET['avail_id'])
                {
                    if($s_nt == $e_nt)
                    {
                        $availed[] = $s_nt;
                    }
                    else
                    {
                        for($i = 0; $i < funcdiff($row['avail_ending_date_time'], $row['avail_starting_date_time']); $i++)
                        {
                            $availed[] = createRange($row['avail_starting_date_time'], $row['avail_ending_date_time'])[$i];
                        }
                    }
                }
                else
                {
                    if($row['avail_status'] != 3 && $row['avail_status'] != 4)
                    {
                        if($s_nt == $e_nt)
                        {
                            $availed_others[] = $s_nt;
                        }
                        else
                        {
                            for($i = 0; $i < funcdiff($row['avail_ending_date_time'], $row['avail_starting_date_time']); $i++)
                            {
                                $availed_others[] = createRange($row['avail_starting_date_time'], $row['avail_ending_date_time'])[$i];
                            }
                        }
                    }
                }
            }
            else
            {
                if($row['avail_status'] != 3 && $row['avail_status'] != 4)
                {
                    if($s_nt == $e_nt)
                    {
                        $availed_others[] = $s_nt;
                    }
                    else
                    {
                        for($i = 0; $i < funcdiff($row['avail_ending_date_time'], $row['avail_starting_date_time']); $i++)
                        {
                            $availed_others[] = createRange($row['avail_starting_date_time'], $row['avail_ending_date_time'])[$i];
                        }
                    }
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
    $start_month = date('Y-m', $start);
    $end_month = date('Y-m', $end);
    
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
    
    for ( $day = 1; $day <= $day_count; $day++, $str++) {
    
        ($day>9) ? $d = '-' : $d = '-0';
        $date = $ym . $d . $day;
    
        if($today > $date)
        {
            $week .= '<td  class="past">' . $day;
        }
        elseif($today == $date)
        {
            $week .= '<td  id='.$date.'>' . $day . ' (Today)';
        }
        elseif(in_array($date, $availed)) 
        {
            $week .= '<td class="availed">' . $day;
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