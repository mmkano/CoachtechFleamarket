<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\CategoryItem;
use App\Models\Condition;
use App\Models\Brand;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_items()
    {
        $category = CategoryItem::factory()->create(['name' => 'Electronics']);
        $condition = Condition::factory()->create(['name' => 'New']);
        $brand = Brand::factory()->create(['name' => 'BrandA']);
        $item1 = Item::factory()->create([
            'name' => 'Item 1',
            'description' => 'Description 1',
            'category_item_id' => $category->id,
            'condition_id' => $condition->id,
            'brand_id' => $brand->id,
            'price' => 100
        ]);
        $item2 = Item::factory()->create([
            'name' => 'Item 2',
            'description' => 'Description 2',
            'category_item_id' => $category->id,
            'condition_id' => $condition->id,
            'brand_id' => $brand->id,
            'price' => 200
        ]);

        $response = $this->get(route('items.search', [
            'search' => 'Item',
            'category' => $category->id,
            'condition' => $condition->id,
            'brands' => [$brand->id],
            'min_price' => 50,
            'max_price' => 150
        ]));

        $response->assertStatus(200);

        $response->assertViewHas('items', function ($items) use ($item1) {
            return $items->contains($item1) && !$items->contains('Item 2');
        });

        $response->assertViewHas('searchTerm', 'Item');
        $response->assertViewHas('selectedCategory', 'Electronics');
        $response->assertViewHas('selectedCondition', 'New');
        $response->assertViewHas('selectedBrands', [$brand->id]);
        $response->assertViewHas('minPrice', 50);
        $response->assertViewHas('maxPrice', 150);
    }

    public function test_search_by_category()
    {
        $category1 = CategoryItem::factory()->create(['name' => 'Electronics']);
        $category2 = CategoryItem::factory()->create(['name' => 'Furniture']);

        $response = $this->get(route('items.search.category'));

        $response->assertStatus(200);

        $response->assertViewHas('categories', function ($categories) use ($category1, $category2) {
            return $categories->contains($category1) && $categories->contains($category2);
        });
    }

    public function test_search_by_condition()
    {
        $condition1 = Condition::factory()->create(['name' => 'New']);
        $condition2 = Condition::factory()->create(['name' => 'Used']);

        $response = $this->get(route('items.search.condition'));

        $response->assertStatus(200);

        $response->assertViewHas('conditions', function ($conditions) use ($condition1, $condition2) {
            return $conditions->contains($condition1) && $conditions->contains($condition2);
        });
    }

    public function test_search_by_brand()
    {
        $brand1 = Brand::factory()->create(['name' => 'BrandA']);
        $brand2 = Brand::factory()->create(['name' => 'BrandB']);

        $response = $this->get(route('items.search.brand'));

        $response->assertStatus(200);

        $response->assertViewHas('brands', function ($brands) use ($brand1, $brand2) {
            return $brands->contains($brand1) && $brands->contains($brand2);
        });
    }
}
