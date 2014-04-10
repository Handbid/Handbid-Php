<?php

namespace Handbid\Auth;

interface AuthInterface
{
    public function __construct($username, $password);
}