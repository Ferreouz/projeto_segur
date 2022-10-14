<?php
session_start();
session_destroy();
header('Location: /segur/index');
exit;