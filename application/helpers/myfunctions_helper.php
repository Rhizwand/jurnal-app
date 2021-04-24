<?php

function load_templates_view($path = '', $data = [])
{
  $thiz = get_instance();
  $data['user'] = $thiz->db->get_where('user', ['email' => $thiz->session->userdata('email')])->row_array();
  $thiz->load->view('templates/header', $data);
  $thiz->load->view('templates/sidebar', $data);
  $thiz->load->view('templates/topbar', $data);
  $thiz->load->view($path, $data);
  $thiz->load->view('templates/footer');
}
