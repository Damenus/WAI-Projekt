<?php

function &get_list()
{
    if (!isset($_SESSION['list'])) {
        $_SESSION['list'] = []; 
    }

    return $_SESSION['list'];
}
