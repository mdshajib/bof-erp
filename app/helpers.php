<?php

if (! function_exists('pagination_stats')) {
    function pagination_stats($lists): object
    {
        $i = $lists->perPage() * ($lists->currentPage() - 1);

        $obj = new stdClass();

        $obj->from  = $i + 1;
        $obj->to    = $i + $lists->perPage();
        $obj->total = $lists->total();

        return $obj;
    }
}
