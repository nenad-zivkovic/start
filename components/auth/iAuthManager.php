<?php
namespace app\components\auth;

interface iAuthManager
{
    public function userIsMember();
    
    public function protectPage();
}