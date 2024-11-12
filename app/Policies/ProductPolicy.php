<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;


class ProductPolicy
{
    /**
     * Determine if the user can view a product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return bool
     */
    public function view(User $user, Product $product)
    {
        return true; // Allow all users to view the product
    }

    /**
     * Determine if the user can update the product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return bool
     */
    public function update(User $user, Product $product)
    {
        return $user->id === $product->user_id; // Only the creator can update
    }

    /**
     * Determine if the user can delete the product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return bool
     */
    public function delete(User $user, Product $product)
    {
        return $user->id === $product->user_id; // Only the creator can delete
    }

    /**
     * Determine if the user can create a product.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return true; // Only authenticated users can create products
    }
}
