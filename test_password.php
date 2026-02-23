<?php
$hash = '$2y$10$H2S1uK8FfK/mM4Qx5yF9qOjHh4E27sF7FJZ0zwI1UcK9Fz6WJ6e6G';
$plain = 'California';

if (password_verify($plain, $hash)) {
    echo "Password matches!";
} else {
    echo "Password does NOT match!";
}
?>
