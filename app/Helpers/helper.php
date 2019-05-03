<?php
// this helper file contain function that can use anywhere
if (! function_exists('changeLink')) {
    function changeLink($link)
    {
        $newLink = str_replace(' ', '-', $link);
        
        return $newLink;
    }
}
if (! function_exists('explodeIngredients')) {
    function explodeComma($string)
    {
        $data = explode(',', $string);

        return $data;
    }
}
if (! function_exists('quantityIngredients')) {
    function quantityIngredients($ingredient)
    {
        $data = [];
        $ingredientArray = explode(' ', $ingredient);
        $ingredientQuantity = implode(' ', [$ingredientArray[0], $ingredientArray[1]]);
        $ingredientName = implode(' ', array_slice($ingredientArray, 2));
        $data['quantity'] = $ingredientQuantity;
        $data['name'] = $ingredientName;

        return $data;
    }
}
