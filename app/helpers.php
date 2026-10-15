<?php
if (!function_exists('peso')) {
    function peso($n): string { $n=(float)$n; return '₱'.number_format($n, floor($n)==$n ? 0 : 2); }
}
