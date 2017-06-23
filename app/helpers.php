<?php

function sql_filter($sql)
{
    return str_replace(
        ["'", '"', '&', '|', '@', '%', '*', '(', ')', '-', '\\'],
        ['', '', '', '', '', '', '', '', '', '', ''],
        $sql);
}
