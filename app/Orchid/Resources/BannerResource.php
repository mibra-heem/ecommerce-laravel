<?php

namespace App\Orchid\Resources;

use Orchid\Crud\Resource;
use Orchid\Screen\TD;
use App\Models\Banner;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;

class BannerResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Banner::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('image')
                ->title('Image')
                ->type('file'),
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
            TD::make('id'),
            TD::make('image')
                ->render(function ($model){
                    return $model->image ? "<img src='".asset($model->image)."' alt='Image' style='width: 100px; height: auto;'/>" : 'No image';
                }),

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


    public function rules(Model $model): array
    {
        return [
            'image' => 'required|image|max:8192',
        ];
        
    }


    public function onSave(ResourceRequest $resourceRequest, Model $model)
    {
    
        // Check if this is a new post (create) or an existing one (edit)
        if (!$model->exists) {
            // If $model doesn't exist, it's a new post, so we create one
            $banner = new Banner();
        } else {
            // If $model exists, we're editing an existing post
            $banner = $model;
        }
    

        // Handle image upload
        if ($resourceRequest->hasFile('model.image')) {
            $path = $resourceRequest->file('model.image')->store('uploads/banner/images', 'public');
            $banner->image = 'storage/' . $path;
        }
    
        // Save post to the database
        $banner->save();
    
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
