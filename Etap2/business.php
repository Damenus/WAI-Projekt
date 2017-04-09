<?php

function get_db()
{
    $mongo = new MongoClient(
        "mongodb://localhost:27017/",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
            'db' => 'wai',
        ]);

    $db = $mongo->wai;

    return $db;
}

function get_products()
{
    $db = get_db();
    return $db->products->find();
}

function get_product($id)
{
    $db = get_db();
    return $db->products->findOne(['_id' => new MongoId($id)]);
}

function save_product($product)
{
    $db = get_db();    
    $db->products->insert($product);
    return true;
}

function get_user_by_login($login)
{
    $db = get_db();
    $users = $db->users->findOne(['login' => $login]);
    return $users;
}

function save_user($user)
{
    $db = get_db();
    $db->users->insert($user);
    return true;
}

function login_user($login)
{
    $db = get_db();
    $user = $db->users->findOne(['login' => $login]);
	return $user;
}

	

