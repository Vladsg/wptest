<?php
add_action('wp_ajax_latestNews', 'latestNews');
add_action('wp_ajax_nopriv_latestNews', 'latestNews');
add_action('wp_ajax_formSend', 'formSend', 10, 1);
add_action('wp_ajax_nopriv_formSend', 'formSend', 10, 1);
function formSend()
{
    $fields = get_fields(20);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    if (empty($email) || !is_email($email)) {
        die(json_encode(['status' => 'error', 'message' => 'Email некорректен!']));
    }
    if (empty($message)) {
        die(json_encode(['status' => 'error', 'message' => 'Вы не ввели сообщение!']));
    }
    $title = $name;
    if (empty($name)) {
        $title = $email;
    } else {
        $title .= ' ('.$email.')';
    }
    $post = wp_insert_post([
        'post_title' => $title,
        'post_type' => 'messages',
        'post_status' => 'publish',
        'post_content' => $message,
    ]);
    update_field('name', $name,$post);
    update_field('email', $email,$post);
    $headers = 'From: ' . $_SERVER['HTTP_HOST'] . ' <no-reply@' . $_SERVER['HTTP_HOST'] . '>' . "\r\n"; // Раскомментировать после переноса на домен
    $send = wp_mail($fields['contacts_email'], '', $message, $headers);
    if (!$send) {
        die(json_encode(['status' => 'error', 'message' => 'Сообщение не было отправлено!']));
    }
    die(json_encode(['status' => 'success']));
}