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

defined('BASEPATH') OR exit('No direct script access allowed');


class Delivery_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_delivery_boy($tid)
    {
       
        $query = $this->db->query("SELECT bti.*, dby.phone, dby.boy_name FROM geopos_delivery_boy_to_invoice bti LEFT JOIN geopos_delivery_boys dby ON (dby.boy_id=bti.boy_id) WHERE invoice_id='" . $tid . "' LIMIT 1");

        $result = $query->row_array();
        return $result;
    }

    public function getAllDeliveryBoys()
    {
       
        $query = $this->db->query("SELECT * FROM geopos_delivery_boys");

        $result = $query->result_array();
        return $result;
    }

    public function assignDeliveryBoyToInvoice($boyId, $invoiceId) {
        $data = array(
            'boy_id' => $boyId,
            'invoice_id' => $invoiceId
        );
        $this->db->insert('geopos_delivery_boy_to_invoice', $data);
    }

    public function updateDeliveryBoyToInvoice($boyId, $invoiceId) {
        $data = array(
            'boy_id' => $boyId,
            'invoice_id' => $invoiceId
        );

        $this->db->set($data);
        $this->db->where('invoice_id=', $invoiceId);
        $this->db->update('geopos_delivery_boy_to_invoice');
    }
    
    public function upsertDeliveryBoyToInvoice($boyId, $invoiceId) {

        $query = $this->db->query("SELECT * FROM geopos_delivery_boy_to_invoice WHERE invoice_id=" . $invoiceId);
        $result = $query->row_array();
        if($result == null){
            $this->assignDeliveryBoyToInvoice($boyId, $invoiceId);
        }else{
            $this->updateDeliveryBoyToInvoice($boyId, $invoiceId);
        }
    }

}