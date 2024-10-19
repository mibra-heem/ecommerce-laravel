<?php

namespace App\Orchid\Resources;

use App\Models\Category;
use Orchid\Crud\Resource;
use Orchid\Screen\TD;
use App\Models\Product;
use Illuminate\Support\Str;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Illuminate\Database\Eloquent\Model;


class ProductResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Product::class;


    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return 'Product';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {

        $categories = Category::pluck('name', 'id');
        return [
            Input::make('name')
                ->title('Product Name')
                ->placeholder('Enter Product Name...')
                ->required(),
            Select::make('category_id')
                ->title('Category')
                ->options($categories)
                ->addOption('', 'Select a Category'),
            Input::make('image') // Ensure this is also in layout
                ->title('Image')
                ->type('file'),
            TextArea::make('descr') 
                ->title('Description'),
            Input::make('brand') 
                ->title('Brand'),
            Input::make('rating') 
                ->title('Rating')
        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id')
            ->render(function ($model){
                return $model->id;
            }),
            TD::make('name'),
            TD::make('category_id'),
            TD::make('image')
                ->render(function ($model){
                    return $model->image ? "<img src='".asset($model->image)."' alt='Image' style='width: 100px; height: auto;'/>" : 'No image';
                }),
            TD::make('descr')
                ->render(function ($model){
                    return Str::words($model->descr, 10);
                }),
            TD::make('brand'),
            TD::make('rating'),
            
            // TD::make('created_at', 'Date of creation')
            //     ->render(function ($model) {
            //         return $model->created_at->toDateTimeString();
            //     }),

            // TD::make('updated_at', 'Update date')
            //     ->render(function ($model) {
            //         return $model->updated_at->toDateTimeString();
            //     }),
        ];
    }


    public function rules(Model $model): array
    {
        // Validation 

        return [
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image',
            'descr' => 'nullable|string',
            'brand' => 'nullable|string',
            'rating' => 'nullable|integer|min:1|max:5',
        ];
    }


    public function onSave(ResourceRequest $resourceRequest, Model $model)
    {
    
        // Check if this is a new post (create) or an existing one (edit)
        if (!$model->exists) {
            // If $model doesn't exist, it's a new post, so we create one
            $product = new Product();
        } else {
            // If $model exists, we're editing an existing post
            $product = $model;
        }
    
        // Populate fields
        $product->name = $resourceRequest->input('name');
        $product->category_id = $resourceRequest->input('category_id');
        $product->descr = $resourceRequest->input('descr');
        $product->brand = $resourceRequest->input('brand');
        $product->rating = $resourceRequest->input('rating');
        // Handle image upload
        if ($resourceRequest->hasFile('model.image')) {
            $path = $resourceRequest->file('model.image')->store('uploads/products/images', 'public');
            $product->image = 'storage/' . $path;
        }
    
        // Save post to the database
        $product->save();
    
        // Redirect or return response (optional)
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }
}
