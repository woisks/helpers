<?php
declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

if (!function_exists('config_toFile')) {

    /**
     * config_toFile 2019/5/21 14:04
     *
     * @param string $filename
     * @param array  $data
     *
     * @return bool|int
     */
    function config_toFile(string $filename, array $data)
    {
        $path = base_path() . '\config\\' . $filename . '.php';
        $str = '<?php return ' . var_export($data, true) . ';';

        return file_put_contents($path, $str);
    }
}


if (!function_exists('unlink_file')) {

    /**
     * unlink_file 2019/5/21 13:53
     *
     * @param string $file_path_and_name
     *
     * @return void
     */
    function unlink_file(string $file_path_and_name)
    {
        if (file_exists($file_path_and_name)) {

            unlink($file_path_and_name);
        }
    }
}


if (!function_exists('random_numeric')) {

    /**
     * random_numeric max:19 bit 2019/5/15 22:04
     *
     * @param int $numeric
     *
     * @return int
     */
    function random_numeric(int $numeric = 6): int
    {
        return (int)base_random_numeric('1-9', $numeric);
    }
}

if (!function_exists('random_string')) {


    /**
     * random_string 2019/5/10 12:09
     *
     * @param int $numeric
     *
     * @return string
     */
    function random_string(int $numeric = 8): string
    {
        return base_random_numeric('a-z', $numeric);
    }
}

if (!function_exists('create_numeric_uid')) {


    /**
     * create_numeric_uid 2019/5/10 12:09
     *
     * @param int $nodes
     *
     * @return int
     */
    function create_numeric_uid(int $nodes = 1): int
    {
        return (int)(Carbon::now()->timestamp . base_random_numeric('0-9', 7) . $nodes);
    }
}

if (!function_exists('create_numeric_id')) {


    /**
     * create_numeric_id 2019/5/10 12:09
     *
     *
     * @return int
     */
    function create_numeric_id(): int
    {
        return (int)(Carbon::now()->timestamp . base_random_numeric('0-9', 8));

    }
}

if (!function_exists('base_random_numeric')) {


    /**
     * base_random_numeric 2019/5/10 12:09
     *
     * @param string $string
     * @param int    $int
     *
     * @return string
     */
    function base_random_numeric(string $string, int $int): string
    {
        $str = '';
        if ($string == '0-9') {

            $characters = str_repeat('0123456789', $int);
            $str = substr(str_shuffle($characters), 0, $int);
        }
        if ($string == '1-9') {
            $characters = str_repeat('123456789', $int);
            $str = substr(str_shuffle($characters), 0, $int);
        }
        if ($string == 'a-z') {
            $characters = str_repeat('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', $int);
            $str = substr(str_shuffle($characters), 0, $int);
        }

        return $str;
    }
}


if (!function_exists('res')) {


    /**
     * res 2019/5/10 12:09
     *
     * @param int        $code
     * @param string     $msg
     * @param array|null $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function res(int $code, string $msg, array $data = null): JsonResponse
    {
        if (empty($data)) {
            return response()->json(['code' => $code, 'msg' => $msg])->setStatusCode(200);
        }

        return response()->json(['code' => $code, 'msg' => $msg, 'data' => $data])->setStatusCode(200);
    }
}

if (!function_exists('is_email_and_check_dns')) {
    /**
     * is_email_and_check_dns 2019/5/15 21:51
     *
     * @param string $email
     *
     * @return bool
     */
    function is_email_and_check_dns(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $host = $email;

        if ($lastAtPos = strrpos($email, '@')) {
            $host = substr($email, $lastAtPos + 1);
        }

        return check_dns($host);
    }
}
if (!function_exists('check_dns')) {
    /**
     * check_dns 2019/5/15 21:01
     *
     * @param string $host
     *
     * @return bool
     */
    function check_dns(string $host): bool
    {
        $variant = INTL_IDNA_VARIANT_2003;
        if (defined('INTL_IDNA_VARIANT_UTS46')) {
            $variant = INTL_IDNA_VARIANT_UTS46;
        }
        $host = rtrim(idn_to_ascii($host, IDNA_DEFAULT, $variant), '.') . '.';

        if (checkdnsrr($host, 'MX') && (checkdnsrr($host, 'A') || checkdnsrr($host, 'AAAA'))) {
            return true;
        }

        return false;
    }
}
if (!function_exists('is_phone')) {


    /**
     * is_phone 2019/5/10 12:09
     *
     * @param string $phone
     *
     * @return bool
     */
    function is_phone(string $phone): bool
    {
        $search = '/^1(3[0-9]|4[57]|5[0-35-9]|6[6]|7[0135678]|8[0-9])\d{8}$/';
        if (preg_match($search, $phone)) {
            return true;
        }

        return false;
    }
}


if (!function_exists('is_username')) {


    /**
     * is_username 2019/5/10 12:09
     *
     * @param string $username
     *
     * @return bool
     */
    function is_username(string $username): bool
    {
        $search = '/^[a-zA-Z][-_a-zA-Z0-9]+$/';
        if (preg_match($search, $username)) {
            return true;
        }

        return false;
    }
}

if (!function_exists('is_email')) {
    /**
     * is_email 2019/5/15 21:10
     *
     * @param string $email
     *
     * @return bool
     */
    function is_email(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }
}

if (!function_exists('is_number')) {
    /**
     * sk_is_numeric 2019/5/15 21:31
     *
     * @param string $numeric
     *
     * @return bool
     */
    function is_number(string $numeric): bool
    {
        if (filter_var($numeric, FILTER_VALIDATE_INT)) {
            return true;
        }

        return false;
    }
}

if (!function_exists('account_type')) {

    /**
     * account_type 2019/5/10 12:09
     *
     * @param string $username
     *
     * @return string
     */
    function account_type(string $username): string
    {
        switch ($username) {
            case is_phone($username):
                $str = 'phone';
                break;
            case is_email($username):
                $str = 'email';
                break;
            case is_number($username):
                $str = 'numeric';
                break;
            case is_username($username):
                $str = 'username';
                break;
            default:
                $str = 'username';
                break;
        }

        return $str;
    }
}


if (!function_exists('ip_string_decode')) {
    /**
     * ip_string_decode 2019/5/21 16:17
     *
     * @param string $ip2long
     *
     * @return string
     */
    function ip_string_decode(string $ip2long)
    {

        $len = strlen($ip2long);

        if ($len > 30) {
            if (!function_exists('bcadd')) {
                throw new \RuntimeException('BCMATH extension not installed!');
            }
            $bin = '';
            do {
                $ip2long = bcmod($ip2long, '2') . $bin;
                $ip2long = bcdiv($ip2long, '2', 0);
            } while (bccomp($ip2long, '0'));
            $bin = str_pad($bin, 128, '0', STR_PAD_LEFT);
            $ip = [];
            for ($bit = 0; $bit <= 7; $bit++) {
                $bin_part = substr($bin, $bit * 16, 16);
                $ip[] = dechex(bindec($bin_part));
            }
            $ip = implode(':', $ip);

            return (string)strtoupper(inet_ntop(inet_pton($ip)));
        }

        return long2ip((int)$ip2long);
    }
}


if (!function_exists('ip_string_encode')) {
    /**
     * ip_string_encode 2019/5/21 16:17
     *
     * @param string $ip
     *
     * @return string
     */
    function ip_string_encode(string $ip)
    {
        $bool = (bool)filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);

        if ($bool) {

            if (!function_exists('bcadd')) {
                throw new \RuntimeException('BCMATH extension not installed!');
            }

            $ip_n = inet_pton($ip);
            $bin = '';
            for ($bit = strlen($ip_n) - 1; $bit >= 0; $bit--) {
                $bin = sprintf('%08b', ord($ip_n[$bit])) . $bin;
            }

            $dec = '0';
            for ($i = 0; $i < strlen($bin); $i++) {
                $dec = bcmul($dec, '2', 0);
                $dec = bcadd($dec, $bin[$i], 0);
            }

            return $dec;
        }

        return (string)ip2long($ip);

    }
}








