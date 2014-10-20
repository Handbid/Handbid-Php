<?php

namespace Handbid\Store\Legacy;

use Handbid\Store\Legacy\StoreAbstract;

class Bidder extends StoreAbstract
{

    public $_profileCache = null;
    public $_bidCache = [];

    public function myProfile()
    {

        if (!$this->_rest->auth()->hasToken()) {
            return null;
        }

        try {

            if (!$this->_profileCache) {
                $response = $this->_rest->get('profile');
                if(!$response) {
                    return null;
                }
                $this->_profileCache = $response->Users[0];
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

        $profile = $this->myProfile();
        $photo = null;

        if(isset($values['photo']) && $values['photo']) {

            //if this is an array, i'm going to assume it was a straight passthrough from $_FILES
            if(is_array($values)) {

                if(empty($values['photo']['name'])) {
                } else {
                    $photo = new \CURLFile($values['photo']['tmp_name'], $values['photo']['type'], $values['photo']['name']);
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

        $profile = $this->_rest->post('models/User/' . $profile->_id, $post)->User;

        //update auth
        $this->_rest->auth()->setToken($profile->_auth->ironframe);

        return $profile;

    }



}