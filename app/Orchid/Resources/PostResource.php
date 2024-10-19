<?php

namespace App\Orchid\Resources;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Orchid\Crud\Resource;
use Orchid\Screen\TD;
use Illuminate\Support\Str;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class PostResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Post::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('title')
                ->title('Title')
                ->placeholder('Enter post title')
                ->required(),
            TextArea::make('body')
                ->title('Body')
                ->placeholder('Describe the post...')
                ->required(),
            Input::make('image') // Ensure this is also in layout
                ->title('Image')
                ->type('file')
                ->required()
        ];
    }

    /**
     * Define the layout of the resource.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                // Input::make('title')->title('Title'),
                // TextArea::make('body')->title('Body'),
                // Input::make('image') // Ensure this is also in layout
                //     ->title('Image')
                //     ->type('file'),
            ]),
        ];
    }


    public function onSave(ResourceRequest $resourceRequest, Model $model)
{
    // This will print in both create and edit scenarios
    // die('Triggering the onSave method');

    // Validate form data
    $resourceRequest->validate([
        'title' => 'required|max:255',
        'body' => 'required|max:4096',
        'model.image' => 'required|image|max:2048'
    ]);

    // Check if this is a new post (create) or an existing one (edit)
    if (!$model->exists) {
        // If $model doesn't exist, it's a new post, so we create one
        $post = new Post();
    } else {
        // If $model exists, we're editing an existing post
        $post = $model;
    }

    // Populate fields
    $post->title = $resourceRequest->input('title');
    $post->body = $resourceRequest->input('body');

    // Handle image upload
    if ($resourceRequest->hasFile('model.image')) {
        $path = $resourceRequest->file('model.image')->store('uploads/post/images', 'public');
        $post->image = 'storage/' . $path;
    }

    // Save post to the database
    $post->save();

    // Redirect or return response (optional)
}




//     public function create(Request $request)
// {
//     dd($request->all());
//     // Call the save method here for creating a new post
//     return $this->save($request);
// }

// public function update(Request $request, int $id)
// {
//     // Call the save method here for updating an existing post
//     return $this->save($request, $id);
// }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id')->sort(),
            TD::make('title', 'Title')
                ->render(function ($model) {
                    return $model->title;
                }),
            TD::make('body', 'Body')
                ->render(function ($model) {
                    return Str::words($model->body, 10);
                }),
            TD::make('image', 'Image')
                ->render(function ($model) {
                    return $model->image ? "<img src='".asset($model->image)."' alt='Image' style='width: 100px; height: auto;'/>" : 'No image';
                }),
                
        ];
    }

    /**
     * Edit the specified post.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(int $id)
    {
        $post = Post::findOrFail($id);
        return redirect()->route('platform.resource.edit', ['id' => $post->id])
            ->with('post', $post); // pass post to the edit form
    }

    /**
     * Delete the specified post.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        Post::destroy($id);
        return redirect()->route('platform.resource.list')->with('success', 'Post deleted successfully.');
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

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [];
    }
}

