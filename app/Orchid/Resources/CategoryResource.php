<?php

namespace App\Orchid\Resources;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\TD;

class CategoryResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Category::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('name')
                ->title('Category Name')
                ->placeholder('Enter Category Name...')
                ->required(),
        ];
    }


    public function rules(Model $model): array
    {
        // Validation 

        return [
            'name' => 'required|string',
        ];
    }


    public function onSave(ResourceRequest $resourceRequest, Model $model)
    {
        // Check if this is a new post (create) or an existing one (edit)
        if (!$model->exists) {
            // If $model doesn't exist, it's a new post, so we create one
            $category = new Category();
        } else {
            // If $model exists, we're editing an existing post
            $category = $model;
        }
    
        // Populate fields
        $category->name = $resourceRequest->input('name');
    
        // Save post to the database
        $category->save();
    
        // Redirect or return response (optional)
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('name'),

            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

            TD::make('updated_at', 'Update date')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                }),
        ];
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
