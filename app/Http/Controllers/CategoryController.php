<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::where('parent_id', '=', null)->get()->sortBy('order');
        $allCategories = Category::all();

        return view('category.index', compact('categories', 'allCategories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $input = $request->all();

        if (empty($input['parent_id'])) {
            $input['parent_id'] = null;
        }

        if (Category::where('parent_id','=',$input['parent_id'])->get()->isEmpty()){
            Category::create([
                'name' => $input['name'],
                'parent_id' => $input['parent_id'],
                'order' => 0,
            ]);
        }else{
            Category::create([
                'name' => $input['name'],
                'parent_id' => $input['parent_id'],
                'order' => Category::where('parent_id','=',$input['parent_id'])
                        ->orderBy('order','desc')->first()->order+1
            ]);
        }

        return back()->with('store', 'Dodano nową kategorię :)');
    }

    public function destroy(Request $request)
    {
        $category = Category::findOrFail($request->categoryToDelete);;
        $category->delete();
        return back()->with('destroy', 'Usunięto kategorię :(');

    }

    public function update(Request $request)
    {
        if ($request->node == $request->categoryToUpdate) {
            return back()->with('updateLoop', 'Nie możesz przenieśc do tego samego węzła');
        } elseif (Category::findOrFail($request->categoryToUpdate)->parent_id == null) {
            return back()->with('updateMain', 'Nie możesz zmienić węzła głównego');
        } else {
            Category::findOrFail($request->categoryToUpdate)->update([
                'parent_id' => $request->node,
            ]);
            return back()->with('update', 'Zaktualizowano węzeł :)');
        }
    }

    public function change(Request $request)
    {
        $sourceCategory = Category::findOrFail($request->sourceCategory);
        $targetCategory = Category::findOrFail($request->targetCategory);

        if ($sourceCategory->parent_id != $targetCategory->parent_id) {
            return back()->with('change-fail', 'Nie możesz przenieśc do tego samego węzła');
        }

        $sourceCategory->move($targetCategory);


        return back()->with('change-ok', 'Zaktualizowano kategorię');
    }
}
