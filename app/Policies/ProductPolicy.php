<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;

class ProductPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('products.view') || $user->hasRole('Super Admin');
    }

    public function view(User $user, Product $product)
    {
        return $user->hasPermissionTo('products.view') || $user->hasRole('Super Admin');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('products.create') || $user->hasRole('Super Admin');
    }

    public function update(User $user, Product $product)
    {
        return $user->hasPermissionTo('products.update') || $user->hasRole('Super Admin');
    }

    public function delete(User $user, Product $product)
    {
        return $user->hasPermissionTo('products.delete') || $user->hasRole('Super Admin');
    }
}
