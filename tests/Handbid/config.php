<?php
/**
 * @copyright Copyright (c) 2014-2015 Handbid Inc.
 * @category handbid
 * @package Handbid2-WordPress
 * @license Proprietary
 * @link http://www.handbid.com/
 * @author Master of Code (worldclass@masterofcode.com)
 */

//update this to match whatever your environment settings are
$config = [
    'consumerKey'    => '6697aaa674a82c2d58d96921822db0de',
    'consumerSecret' => 'c676e62fe495bea2e97d35f2c4a627f0',
    'orgId'          => '4dd1f245ba3a20245b00002a',
    'options'        => [
        'endpoint' => 'http://hbs.local'
    ],
    'managerEmail'      => 'demo@handbid.com',
    'managerPassword'   => 'password'
];

$config = (object) $config;