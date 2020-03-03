<?php

namespace App\Service\Cart;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\BouquetRepository;

class CartService{

    protected $session;
    protected $bouquetRepository;

    public function __construct(SessionInterface $session, BouquetRepository $bouquetRepository){
        $this->session = $session;
        $this->bouquetRepository = $bouquetRepository;

    }
    public function add(int $id){
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;

        }

        $this->session->set('panier', $panier);
    }


    public function less(int $id){
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id])){
            $panier[$id]--;
        }else{
            $panier[$id] = 1;

        }

        $this->session->set('panier', $panier);
    }

    public function remove(int $id){
        $panier = $this->session->get('panier', []);
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }
        $this->session->set('panier', $panier);
    }

    public function getFullCart(): array {
        $panier = $this->session->get('panier', []);

        $panierData = [];

        foreach($panier as $id => $quantity){
            $panierData[] = [
                'product' => $this->bouquetRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $panierData;
    }

    public function getTotal(): float {
        $total = 0;
        foreach($this->getFullCart() as $item){
            $total += $item['product']->getPrix() * $item['quantity'];
        }
        return $total;
    } 
}
?>