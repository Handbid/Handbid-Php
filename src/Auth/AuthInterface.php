<?php
/**
 * @copyright Copyright (c) 2014-2015 Handbid Inc.
 * @category handbid
 * @package Handbid2-WordPress
 * @license Proprietary
 * @link http://www.handbid.com/
 * @author Master of Code (worldclass@masterofcode.com)
 */

namespace Handbid\Auth;

interface AuthInterface
{
    public function hasToken();
    public function token();
    public function setToken($token);

    public function fetchToken(\Handbid\Rest\RestInterface $rest);
    public function refreshToken(\Handbid\Rest\RestInterface $rest);
    public function initRequest(&$method, &$url, &$query, &$postData, &$headers);
    public function clearToken();

}