<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function dd($data)
{
    echo "<pre>";
    print_r($data);
    exit;
}

function paging_tmp()
{
    $data = array(
        'use_page_numbers' => TRUE,
        'page_query_string' => TRUE,
        'query_string_segment' => 'page',
        'full_tag_open' => '<div class="btn-group">',
        'full_tag_close' => '</div>',
        'cur_tag_open' => '<button type="button" class="btn btn-primary btn-sm">',
        'cur_tag_close' => '</button>',
    );
    return $data;
}

function gen_paging($total = 0, $limit = 10)
{
    $ci = &get_instance();
    $base_url = current_url();
    $base_url .= get_query_string('page');
    $config = paging_tmp();
    $config['base_url'] = $base_url;
    $config['total_rows'] = $total;
    $config['per_page'] = $limit;

    $ci->pagination->initialize($config);
    $data = $ci->pagination->create_links();
    return str_replace('<a href', '<a class="btn btn-default btn-sm" href', $data);
}

function get_query_string($remove = '')
{
    $query_string = $_GET;
    if ($remove) {
        if (is_array($remove)) {
            foreach ($remove as $key => $value) {
                unset($query_string[$value]);
            }
        } else {
            unset($query_string[$remove]);
        }
    }
    if ($query_string) {
        return '?' . http_build_query($query_string);
    }
    return '';
}

function gen_total($total, $limit, $offset)
{
    $min = $offset + 1;
    $max = $offset + $limit;
    if ($total < $limit) {
        $max = $total;
    }
    if ($total) {
        if ($min == $max) {
            return 'Menampilkan ' . $min . ' dari ' . $total . ' data';
        } elseif ($max > $total) {
            return 'Menampilkan ' . $total . ' data terakhir';
        } else {
            return 'Menampilkan ' . $min . ' sampai ' . $max . ' dari ' . $total . ' data';
        }
    }
    return 'Tidak ada data';
}
function gen_offset($limit = 10)
{
    $ci = &get_instance();
    $page = 1;
    if ($ci->input->get('page')) {
        $page = $ci->input->get('page');
    }
    return ($page-1)*$limit;
}
function gen_page()
{
    $ci = &get_instance();
    $page = 1;
    if ($ci->input->get('page')) {
        $page = $ci->input->get('page');
    }
    return $page;
}

function format_ymd($date){
    if($date <> '' && $date <> null){
        $x = explode("/",$date);
        return $x[2]."-".$x[1]."-".$x[0];
    }else{
        return "0000-00-00";
    }
}
function format_dmy($date){
    if($date <> '' && $date <> null){
        $x = explode("-",$date);
        return $x[2]."/".$x[1]."/".$x[0];
    }else{
        return "00/00/0000";
    }
}
function format_date($vardate, $type = '')
{
    $hari   = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
    $bulan  = array(1 => 'Januari', 2 => 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $dywk   = date('w', strtotime($vardate));
    $dywk   = $hari[$dywk];
    $dy     = date('j', strtotime($vardate));
    $d      = date('d', strtotime($vardate));
    $mth    = date('n', strtotime($vardate));
    $m      = date('M', strtotime($vardate));
    $mk     = date('m', strtotime($vardate));
    $y      = date('y', strtotime($vardate));
    $mth    = $bulan[$mth];
    $yr     = date('Y', strtotime($vardate));
    $hr     = date('H', strtotime($vardate));
    $mi     = date('i', strtotime($vardate));
    $dk     = date('s', strtotime($vardate));

    switch ($type) {
        case '1':
            return $dywk . ', ' . $dy . ' ' . $mth . ' ' . $yr . '';
            break;
        case '2':
            return $dy . '/' . $m . '/' . $yr;
            break;
        case '3':
            return $hr . ':' . $mi . ':' . $dk;
            break;
        default:
            return $dy . '/' . $m . '/' . $yr . ', ' . $hr . ':' . $mi . ':' . $dk;
            break;
    }
}

function map_menu($v){
    return $v->link;
}

function now_url()
{
    $ci = &get_instance();

    $url = $ci->config->site_url($ci->uri->uri_string());
    return $_SERVER['QUERY_STRING'] ? $url . '?' . $_SERVER['QUERY_STRING'] : $url;
}

function format_uang($str)
{
    return str_replace(',', '', $str);
}
