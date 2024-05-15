<?php

// get the post date
$post_date = get_the_date('Y-m-d H:i:s');
// convert post date to timestamp
$post_timestamp = strtotime($post_date);
// get current date and time
$current_timestamp = time();
// calculate the difference in hours
$difference_in_hours = ($current_timestamp - $post_timestamp) / 3600;

// if the difference is less than or equal to 48 hours, display the badge
if($difference_in_hours <= 48) {
    echo '<span class="badge">Recently Published</span>';
}
?>