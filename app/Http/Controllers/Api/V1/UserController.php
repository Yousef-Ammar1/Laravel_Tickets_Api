<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filter\V1\AuthorFilter;
use App\Http\Requests\Api\V1\ReplaceUserRequest;
use App\Models\User;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\Ticket;
use App\Policies\V1\UserPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends ApiController
{
    protected $policyClass = UserPolicy::class;


    /**
     * Display a listing of the resource.
     */
    public function index(AuthorFilter $filter)
    {

        return UserResource::collection(
            User::filter($filter)->paginate(100)
        );
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            // Policy
            $this->isAble('store', User::class);

            return new UserResource(User::create($request->mappedAttributes()));

        } catch (AuthorizationException $e) {
            return $this->error('You are not authorized to create this resource.', 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        if ($this->include('tickets')) {
            return new UserResource($user->load('tickets'));
        }

        return new UserResource($user);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $user_id)
    {
        try {

            $user = User::findOrFail($user_id);
            // Policy
            $this->isAble('update', $user);

            $user->update($request->mappedAttributes());

            return new UserResource($user);

        } catch (ModelNotFoundException $e) {
            return $this->error('User not found.', 404);
        } catch (AuthorizationException $e) {
            return $this->error('You are not authorized to update this resource.', 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function replace(ReplaceUserRequest $request, $user_id)
    {
        try {
            $user = User::findOrFail($user_id);
            // Policy
            $this->isAble('replace', $user);

            $user->update($request->mappedAttributes());

            return new UserResource($user);

        } catch (ModelNotFoundException $e) {
            return $this->error('User not found.', 404);
        }

    }

    public function destroy($user_id)
    {
        try {
            $user = User::findOrFail($user_id);
            // Policy
            $this->isAble('delete', $user);

            $user->delete();

            return $this->ok('User successfully deleted');
        } catch (ModelNotFoundException $e) {
            return $this->error('User not found.', 404);
        }
    }
}
