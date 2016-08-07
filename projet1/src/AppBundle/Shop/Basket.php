<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/07/16
 * Time: 16:16
 */

namespace AppBundle\Shop;


use Symfony\Component\HttpFoundation\Session\Session;

/*
 * BASKET as a SERVICE / SESSION
 * -----------------------------
 * 1. SERVICE => we have declared our Basket class as a Service so that different controller
 *    may be able to call our basket, whenever they want
 *
 * 2. SESSION => our basket uses the Session service so that it can keep the product list in memory
 *    No matter where it is use, the product list keeps alive even when the user changes page
 *
 */
class Basket
{
    private $products;
    private $session;

    //--the service has been declared to take a @session object as parameter
    public function __construct(Session $session)
    {
        //-- save the session into the basket instance
        $this->session = $session;

        //-- if the session already exists, we retrieve the list of product
        //-- otherwise, we initialize it
        if($this->session->get("basket_products") != null){
            $this->products = $this->session->get("basket_products");
        }else{
            $this->products = [];
        }
   }

    public function add($animal)
    {
        //-- if the slot doesn't exist, we initialize it
        if(!isset($this->products[$animal->getId()]))
            $this->products[$animal->getId()] = 0;

        //-- increase the amount of items
        $this->products[$animal->getId()] += 1;

        //-- update the session's instance
        $this->session->set("basket_products", $this->products);

        //-- commit the session
        $this->session->save();
    }
}