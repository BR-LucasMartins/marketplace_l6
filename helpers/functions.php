<?php

function filterItemsByStore($items, $storeId)
{
    return array_filter($items, function($line) use($storeId){

        return $line['store_id'] == $storeId;
        
    });
}

function formatMoneyToDatabase($price){

    return str_replace(['.', ','], ['', '.'], $price);


}