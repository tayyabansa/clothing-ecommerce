<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, ensure we have a category_id column
        if (!Schema::hasColumn('products', 'category_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            });
        }

        // If there's a category column, migrate the data
        if (Schema::hasColumn('products', 'category')) {
            // Get all products
            $products = Product::all();
            
            foreach ($products as $product) {
                if ($product->category) {
                    // Try to find or create the category
                    $category = Category::firstOrCreate(
                        ['name' => $product->category],
                        [
                            'slug' => Str::slug($product->category),
                            'is_active' => true
                        ]
                    );
                    
                    // Update the product with the new category_id
                    $product->category_id = $category->id;
                    $product->save();
                }
            }

            // Remove the old category column
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // If we need to rollback, we'll add back the category column
        if (!Schema::hasColumn('products', 'category')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('category')->nullable();
            });

            // Migrate data back
            $products = Product::all();
            foreach ($products as $product) {
                if ($product->category_id) {
                    $category = Category::find($product->category_id);
                    if ($category) {
                        $product->category = $category->name;
                        $product->save();
                    }
                }
            }
        }
    }
};
