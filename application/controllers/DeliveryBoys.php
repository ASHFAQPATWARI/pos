
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

class DeliveryBoys extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('delivery_model');
    }

    public function assignboy()
    {

        $tid = $this->input->get('tid');
        $boyId = $this->input->get('boyid');
        $this->delivery_model->assignDeliveryBoyToInvoice($boyId,$tid);
        
        redirect('pos_invoices/view?id=' . $tid);
    }

    public function updateboy()
    {

        $tid = $this->input->get('tid');
        $boyId = $this->input->get('boyid');
        $this->delivery_model->updateDeliveryBoyToInvoice($boyId,$tid);
        
        redirect('pos_invoices/view?id=' . $tid);
    }
    
    
    public function upsertboy()
    {

        $tid = $this->input->get('tid');
        $boyId = $this->input->get('boyid');
        $this->delivery_model->upsertDeliveryBoyToInvoice($boyId,$tid);
        
        //redirect('pos_invoices/view?id=' . $tid);
    }
}