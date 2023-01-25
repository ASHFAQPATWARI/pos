
<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') or exit('No direct script access allowed');

class CashCalculator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('dashboard_model');
    }

    public function index()
    {
        $today = date("Y-m-d");
        $yesterday = date('Y/m/d',strtotime("-1 days"));
        //get yesterday closing bal
        $this->db->select('tom_opening_bal');
        $this->db->from('geopos_cash_counter');
        $this->db->where('cash_date', $yesterday);
        $query = $this->db->get();
        $yesEntry = $query->row_array();
        $data['closing_bal'] = $yesEntry['tom_opening_bal'];
        //-----
        $data['todayinexp'] = $this->dashboard_model->todayInexp($today);
        $this->load->view('fixed/header', $head);
        $this->load->view('cashcalculator/calculate', $data);
        $this->load->view('fixed/footer');

    }

    public function save_cash()
    {
        $opening_bal = numberClean($this->input->post('opening_bal', true));
        $payment_gateway = numberClean($this->input->post('payment_gateway', true));
        $wallet = numberClean($this->input->post('wallet', true));
        $bank = numberClean($this->input->post('bank', true));
        $income = numberClean($this->input->post('income', true));
        $expense = numberClean($this->input->post('expense', true));
        $expected_cash = numberClean($this->input->post('hide_expected_cash', true));
        $actual_cash = numberClean($this->input->post('actual_cash', true));
        $home_cash = numberClean($this->input->post('home_cash', true));
        $tom_opening_bal = $actual_cash - $home_cash;

        $data = array(
            'opening_bal' => $opening_bal,
            'payment_gateway' => $payment_gateway,
            'wallet' => $wallet,
            'bank' => $bank,
            'income' => $income,
            'expense' => $expense,
            'expected_cash' => $expected_cash,
            'actual_cash' => $actual_cash,
            'home_cash' => $home_cash,
            'tom_opening_bal' => $tom_opening_bal,
            'cash_date' => date("Y-m-d"),
        );

        $this->db->insert('geopos_cash_counter', $data);
        $tttid = $this->db->insert_id();
        echo json_encode(array('status' => 'Success', 'message' => 'Cash Saved to directory'));
    }
    
    public function getCash(){
        $query = $this->db->query("SELECT * FROM geopos_cash_counter ORDER BY cash_date DESC LIMIT 10");
        foreach ($query->result_array() as $row) {
            echo '<tr><td>' . $row['cash_date'] . '</td><td>' . $row['opening_bal'] . '</td><td>' . $row['payment_gateway'] . '</td><td>' . $row['wallet'] . '</td><td>' . $row['bank'] . '</td><td>' . $row['income'] . '</td><td>' . $row['expense'] . '</td><td>' . $row['expected_cash'] . '</td><td>' . $row['actual_cash'] . '</td><td>' . $row['home_cash'] . '</td><td>' . $row['tom_opening_bal'] . '</td></tr>';
        }
    }
}