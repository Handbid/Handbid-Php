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

class Bidder extends StoreAbstract
{

    public $_base = 'bidder';
    public $_profileCache = null;
    public $_bidCache = [];

    public function myProfile()
    {

        if (!$this->_rest->auth()->hasToken()) {
            return null;
        }

        try {

            if (!$this->_profileCache) {


                $response = $this->_rest->get(
                    'bidder/index',
                    [],
                    [],
                    false);

                if(!$response) {
                    return null;
                }

                $this->_profileCache = $response;

            }

            $profile = clone $this->_profileCache;
            unset($profile->_restMetaData, $profile->favoriteItems);

        } catch (Excetion $e) {
            $profile = null;
        }

        return $profile;
    }

    public function updateProfile($values)
    {

        if(!$this->myProfile()) {
            throw new \Exception('You must be logged in to update your profile.');
        }

        $photo = null;

        if(isset($values['photo']) && $values['photo']) {

            //if this is an array, i'm going to assume it was a straight passthrough from $_FILES
            if(is_array($values)) {

                if(empty($values['photo']['name'])) {
                } else {
                    if(class_exists('CURLFiles', false)) {
                        $photo = new \CURLFile($values['photo']['tmp_name'], $values['photo']['type'], $values['photo']['name']);
                    } else {


                        if (!function_exists('curl_file_create')) {
                            function curl_file_create($filename, $mimetype = '', $postname = '') {
                                return "@$filename;filename="
                                . ($postname ?: basename($filename))
                                . ($mimetype ? ";type=$mimetype" : '');
                            }
                        }

                        $photo = curl_file_create($values['photo']['tmp_name'], $values['photo']['type'], $values['photo']['name']);

                    }
                }

                unset($values['photo']);

            } else {

                $photo = $values['photo'];
                throw new \Exception('Not finished');

                if(!file_exists($photo)) {
                    throw new \Exception('I could not find a photo at ' + $photo);
                }

                $photo = '@' . $photo . ';filename=' . basename($photo);
                unset($values['photo']);

            }


        }

        if(isset($values['password']) && empty($values['password2'])) {

            unset($values['password']);

            if(isset($values['password2'])) {
                unset($values['password2']);
            }

        }


        if(isset($values['password']) && isset($values['password2'])) {

            $values['password][new'] = $values['password'];
            $values['password][confirm'] = $values['password'];
            unset($values['password']);
        }

        $post = $this->preparePostVars($values);
        if($photo) {
            $post['photo[file]'] = $photo;
        }

        $profile = $this->_rest->put('bidder/update', $post);

        //update auth
//        $this->_rest->auth()->setToken($profile->data->token);

        return $profile;

    }

    public function updateProfileData($values){

        if(!$this->myProfile()) {
            throw new \Exception('You must be logged in to update your profile.');
        }
        $post = $this->preparePostVars($values);
        $profile = $this->_rest->put('bidder/update', $post);
        return $profile;
    }

    public function login($values) {
        try {

            $post = $this->preparePostVars($values);
            $profile = $this->_rest->post('auth/login', $post);

            if($profile->success) {
                $this->setCookie($profile);
            }

            return $profile;

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function resetPass($identifier) {
        try {

            $resp = $this->_rest->get('auth/reset?identifier='.$identifier);

            return $resp;

        } catch (\Exception $e) {
            return $e;
        }
    }

    public function register($values) {
        try {

            $post = $this->preparePostVars($values);

            $profile = $this->_rest->post('auth/register', $post);

            if($profile->success == true) {

                $newValues = [
                    'username' => $profile->data->username,
                    'password' => $profile->data->pin
                ];

                $profile = $this->login($newValues);
            }

            return $profile;


        } catch (\Exception $e) {

        }
    }

    public function setCookie($profile) {
        $token = $profile->data->token;
        $token = preg_replace("/Authorization: Bearer /", "", $token);
        setcookie('handbid-auth', 'Authorization: Bearer ' . $token, time()+3600*24*100, COOKIEPATH, COOKIE_DOMAIN);
        setcookie('PHPSESSID', $token, time()+3600*24*100, COOKIEPATH, COOKIE_DOMAIN);
    }

    public function getProvinces() {
        try {

            $provinces = $this->_rest->get('province/index', []);
            return $provinces;

        } catch (\Exception $e) {
            return [];
        }
    }

    public function getCountries() {
        try {

            $provinces = $this->_rest->get('country/index', []);
            return $provinces;

        } catch (\Exception $e) {
            return [];
        }
    }

    public function getMyAuctions() {
        try {

            $myAuctions = $this->_rest->get('bidder/auctions', []);
            return $myAuctions;

        } catch (\Exception $e) {
            return [];
        }
    }

    public function addActiveAuction($auctionID) {
        try {

            $addedAuction = $this->_rest->post('auction/add/'.$auctionID, []);
            return $addedAuction;

        } catch (\Exception $e) {
            return [];
        }
    }


}
