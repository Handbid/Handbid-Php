<?php
/**
 * @copyright Copyright (c) 2014-2015 Handbid Inc.
 * @category handbid
 * @package Handbid2-WordPress
 * @license Proprietary
 * @link http://www.handbid.com/
 * @author Master of Code (worldclass@masterofcode.com)
 */

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Receipt extends StoreAbstract
{
    public $_base = 'bidder/receipts';
    public $_resultKey = 'Receipt';
    public $_receiptCache = [];

    public function byAuction($auctionId)
    {

        return $this->_rest->get(
            'auction/myreceipt' . $auctionId,
            [
            ],
            [],
            false
        );
    }

    public function allReceipts($invoice_id = false)
    {
        $query = ($invoice_id) ? ['query' => ['receiptGuid' => $invoice_id]] : [];

        return $this->_rest->get(
            'receipt/index',
            $query,
            [],
            false
        );
    }

    public function makePayment($values)
    {
        $post = $this->preparePostVars($values);
        return $this->_rest->post(
            'transaction/create', $post
        );
    }

    public function sendInvoice($invoice_id, $values)
    {
        $post = $this->preparePostVars($values);
        return $this->_rest->post(
            'receipt/send/' . $invoice_id, $post
        );
    }
}