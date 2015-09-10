<?php

/*

---------------------------------------
License Setup
---------------------------------------

Please add your license key, which you've received
via email after purchasing Kirby on http://getkirby.com/buy

It is not permitted to run a public website without a
valid license key. Please read the End User License Agreement
for more information: http://getkirby.com/license

*/

c::set('license', 'put your kirby license key here');


/* 

---------------------------------------
Smartypants Setup 
---------------------------------------

Smartypants is a typography plugin, which
helps to improve things like quotes and ellipsises
and all those nifty little typography details. 

You can read more about it here: 
http://michelf.com/projects/php-smartypants/typographer/

Smartypants is switched off by default. 
As soon as it is switched on it will affect all 
texts which are parsed by kirbytext()

*/

// smartypants
c::set('smartypants', true);
c::set('smartypants.attr', 1);
c::set('smartypants.doublequote.open', '&#8220;');
c::set('smartypants.doublequote.close', '&#8221;');
c::set('smartypants.space.emdash', ' ');
c::set('smartypants.space.endash', ' ');
c::set('smartypants.space.colon', '&#160;');
c::set('smartypants.space.semicolon', '&#160;');
c::set('smartypants.space.marks', '&#160;');
c::set('smartypants.space.frenchquote', '&#160;');
c::set('smartypants.space.thousand', '&#160;');
c::set('smartypants.space.unit', '&#160;');
c::set('smartypants.skip', 'pre|code|kbd|script|math');


/*
---------------------------------------
Languages
--------------------------------------

*/

c::set('language.detect', true);
c::set('languages', array(
  array(
    'code'    => 'en',
    'name'    => 'English',
    'default' => true,
    'locale'  => 'en_US',
    'url'     => '/',
  ),
  array(
    'code'    => 'fr',
    'name'    => 'Français',
    'locale'  => 'fr_FR',
    'url'     => '/fr',
  ),
));


/*
---------------------------------------
User roles
--------------------------------------

*/

c::set('roles', array(
  array(
    'id'      => 'customer',
    'name'    => 'Customer',
    'default' => true,
    'panel'   => false
  ),
  array(
    'id'      => 'admin',
    'name'    => 'Admin',
    'panel'   => true
  ),
  array(
    'id'      => 'wholesaler',
    'name'    => 'Wholesaler',
    'panel'   => false
  )
));


/*

---------------------------------------
Routes
--------------------------------------

*/

c::set('routes', array(
  array(
    'pattern' => 'logout',
    'action'  => function() {
      if($user = site()->user()) {
        s::start();
        s::set('cart', array()); // Empty the cart
        $user->logout();
      }
      return go('/');
    }
  ),
  array(
    'pattern' => 'shop/cart/empty',
    'action' => function() {
      s::start();
      s::set('cart', array()); // Empty the cart
      // Send along a status message
      return go('shop/cart');
    }
  ),
  array(
    'pattern' => 'shop/cart/process',
    'method' => 'GET|POST',
    'action' => function() {
      snippet('cart.process');
    }
  ),
  array(
    'pattern' => 'shop/cart/notify',
    'method' => 'POST',
    'action' => function() {
      snippet('payment.success.paypal');
      return true;
    }
  ),
  array(
    'pattern' => 'shop/cart/return',
    'method' => 'POST',
    'action' => function() {
      $cart = Cart::getCart();
      $cart->emptyItems();
      return go('shop/orders?txn_id='.get('custom'));
    }
  ),
  array(
    'pattern' => '(:all)/shop/orders/pdf',
    'method' => 'POST',
    'action' => function($lang) {
      snippet('orders.pdf', ['lang' => $lang]);
      return true;
    }
  ),
));