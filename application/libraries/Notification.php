<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function success($message)
    {
        $this->CI->session->set_flashdata("notifikasi", "<script>toastr.success('$message');</script>");
    }

    public function info($message)
    {
        $this->CI->session->set_flashdata("notifikasi", "<script>toastr.info(' $message')</script>");
    }

    public function warning($message)
    {
        $this->CI->session->set_flashdata("notifikasi", "<script>toastr.warning('$message')</script>");
    }

    public function error($message)
    {
        $this->CI->session->set_flashdata("notifikasi", "<script>toastr.error('$message')</script>");
    }

   
}
