<?php
/**
 * @package        Arastta eCommerce
 * @copyright      Copyright (C) 2015-2016 Arastta Association. All rights reserved. (arastta.org)
 * @license        GNU General Public License version 3; see LICENSE.txt
 */

class ModelPaymentIyzicoCheckoutInstallment extends Model
{
    /**
     * Get method
     *
     */
    public function getMethod($address, $total)
    {
        $this->load->language('payment/iyzico_checkout_installment');

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $this->config->get('iyzico_checkout_installment_geo_zone_id') . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");

        if ($this->config->get('iyzico_checkout_installment_total') > 0 && $this->config->get('iyzico_checkout_installment_total') > $total) {
            $status = false;
        } elseif (!$this->config->get('iyzico_checkout_installment_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        $method_data = array();

        if ($status) {
            $method_data = array(
                'code'       => 'iyzico_checkout_installment',
                'title'      => $this->language->get('text_title'),
                'terms'      => '',
                'sort_order' => $this->config->get('iyzico_checkout_installment_sort_order')
            );
        }

        return $method_data;
    }

    /**
     * Create refund item for iyzico transaction
     *
     */
    public function createRefundItemEntry($data)
    {
        $query_string = "INSERT INTO " . DB_PREFIX . "iyzico_order_refunds SET";

        $data_array   = array();

        foreach ($data as $key => $value) {
            $data_array[] = "`$key` = '" . $this->db->escape($value) . "'";
        }

        $data_string = implode(", ", $data_array);

        $query_string .= $data_string;

        $query_string .= ";";

        $this->db->query($query_string);

        return $this->db->getLastId();
    }

    /**
     * Create order entry for iyzico transaction
     *
     */
    public function createOrderEntry($data)
    {
        $query_string = "INSERT INTO " . DB_PREFIX . "iyzico_order SET";

        $data_array   = array();

        foreach ($data as $key => $value) {
            $data_array[] = "`$key` = '" . $this->db->escape($value) . "'";
        }

        $data_string = implode(", ", $data_array);

        $query_string .= $data_string;

        $query_string .= ";";

        $this->db->query($query_string);

        return $this->db->getLastId();
    }

    /**
     * Update order entry for iyzico transaction
     *
     */
    public function updateOrderEntry($data, $id)
    {
        $query_string = "UPDATE " . DB_PREFIX . "iyzico_order SET";

        $data_array   = array();

        foreach ($data as $key => $value) {
            $data_array[] = "`$key` = '" . $this->db->escape($value) . "'";
        }

        $data_string = implode(", ", $data_array);

        $query_string .= $data_string;

        $query_string .= " WHERE `iyzico_order_id` = {$id};";

        return $this->db->query($query_string);
    }
}
