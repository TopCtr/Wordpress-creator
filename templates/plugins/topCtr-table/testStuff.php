<?php

function kkk($param) {
    echo '<br>' .$param;
}

function ggg() {

    $meta_keys = array(
        "bonus"
        , "VIPBonus"
        , "payout"
        , "affiliateLink"
        , "platform"
        , "software"
        , "game"
        // Ranking Properties
        , "software-n-graphics-input"
        , "game-variety-input"
        , "bonuses-n-promotions-input"
        , "payment-options-input"
        , "customer-service-input"
        , "user-rating-input"
        , "calculated-sum-input"
        // Payment Options
        , "visa"
        , "visa-electron"
        , "master-card"
        , "maestro"
        , "delta"
        , "paypal"
        , "ukash"
        , "skrill-moneybookers"
        , "web-money"
        , "quickcash"
        , "pay-safe-card"
        , "netelle"
        , "entropay"
        , "ecocard"
        , "clickandbuy"
        , "click2pay"
        , "laser"
        , "diners-club"
    );
    foreach ($meta_keys as $key) {
        //        echo '<br>' . $key;
  //      kkk($key);
    }
}

ggg();
