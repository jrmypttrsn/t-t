<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperationController extends Controller
{
    /**
     * Paginate the authenticated user's operations.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // paginate the authorized user's operations with 5 per page
        $operations = Auth::user()
            ->operations()->paginate(15);

        // return the task index view with paginated tasks
        return view('operations', [
            'operations' => $operations
        ]);
    }

    /**
     * Store a new incomplete task for the authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //  validate the given request
        $this->validate($request, [
            'title' => 'required|string|max:255',
        ]);

        // create a new incomplete task with the given title
        Auth::user()->operations()->create([
            'title' => $request->input('title'),
            'is_complete' => false,
        ]);

        // flash a success message to the session
        session()->flash('status', 'Operation created!');

        // redirect to operations index
        return redirect('/operations');
    }

    /**
     * Mark the given task as complete and redirect to operations index.
     *
     * @param Operation $operation
     * @return \Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Operation $operation)
    {
        // check if the authenticated user can complete the task
        $this->authorize('complete', $operation);

        // mark the task as complete and save it
        $operation->is_complete = true;
        $operation->save();

        // flash a success message to the session
        session()->flash('status', 'Operation completed!');

        // redirect to operations index
        return redirect('/operations');
    }

}
