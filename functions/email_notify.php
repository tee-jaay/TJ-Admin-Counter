<?php
// send email
function tj_admin_counter_send_email() {
    $admins = get_users(array('role' => 'administrator'));

    // Check if there is more than one admin and an email has not been sent today
    if (count($admins) > 1 && !get_transient('admin_counter_email_sent')) {
        $to = $admins[0]->user_email; // Use the email of the first admin as an example
        $subject = 'Multiple Admins Alert';
        $message = 'There are currently more than 1 administrators on your site.';
        $headers = array('Content-Type: text/html; charset=UTF-8');

        // Send email
        wp_mail($to, $subject, $message, $headers);

        // Set transient to avoid sending multiple emails in a day
        set_transient('admin_counter_email_sent', true, DAY_IN_SECONDS);
    }
}