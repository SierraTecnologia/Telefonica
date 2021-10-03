<?php

namespace Telefonica\Http\Controllers\Admin;

use Siravel\Models\Blog\Article;
use Siravel\Models\Blog\Category;
use Telefonica\Models\Digital\Phone;
use Stalker\Models\Photo;
use Stalker\Models\PhotoAlbum;
use Illuminate\Http\Request;

class PhoneController extends Controller
{


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {

        $phones = Phone::all();
        return view('telefonica::admin.phones.index',  compact('phones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        return view('telefonica::admin.phones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        Phone::create(['name' => $request->name]);

        return redirect('phones');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Request $request, $id)
    {
        $phone = Phone::findOrFail($id);

        return view('telefonica::admin.phones.edit', compact('phone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $phone = Phone::findOrFail($request->phone_id);

        $phone->name = $request->name;

        $phone->update();

        return redirect('phones');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id)
    {
        $phone = Phone::findOrFail($id);

        $phone->delete();

        return redirect('phones');
    }
}