<?php
require ('stripe-php-master/init.php');
$PublishableKey = "pk_test_51IjlWhBZKoh50aXE775GtKbv5UY4XqvBtc0SGUjgBpa9c52YdoqNyuZ9viNUQOoGwIMqtgThskNqUVwO476Ptuaj00rcqPY7kr";
$SecretKey = "sk_test_51IjlWhBZKoh50aXElmixvFyRng7CBEXY3mhqjRLs96HiZ11BUdYQZt6XRVkMnet1aRogZ6eioSA4Dz7krc5OuEYl00YSzF4vl8";

\stripe\stripe::setApiKey($SecretKey);

?>