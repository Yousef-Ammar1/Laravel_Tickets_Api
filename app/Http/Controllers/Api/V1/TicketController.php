<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filter\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Models\Ticket;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\User;
use App\Policies\V1\TicketPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketController extends ApiController
{
    protected $policyClass = TicketPolicy::class;






    /**
     * Get all tickets.
     *
     * @group Managing Tickets
     *
     * @queryParam sort string Data field(s) to sort by. Seprate multiple fields with a comma. Denote descending sort with a minus sign. Example: sort=title, -createdAt
     * @queryParam filter[status] Filter by status code: A, C, H. No-example.
     * @queryParam filter[title] Filter by title. Wildcard characters are supported. Example: *fix*
     *
     */
    public function index(TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::filter($filters)->paginate(5));
    }



    /**
     * Create a ticket.
     *
     * Creates a new ticket. Users can only create tickets for themselves. Managers can create tickets for any user.
     *
     *
     * @group Managing Tickets
     * 
     *
     */
    public function store(StoreTicketRequest $request)
    {
        try {
            // Policy
            $this->isAble('store', Ticket::class);

            return new TicketResource(Ticket::create($request->mappedAttributesd()));

        } catch (AuthorizationException $e) {
            return $this->error('You are not authorized to update this resource.', 401);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {

        if ($this->include('author')) {
            $ticket->load('user');
        }

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, $ticket_id)
    {
        try {

            $ticket = Ticket::findOrFail($ticket_id);
            // Policy
            $this->isAble('update', $ticket);

            $ticket->update($request->mappedAttributes());

            return new TicketResource($ticket);

        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket not found.', 404);
        } catch (AuthorizationException $e) {
            return $this->error('You are not authorized to update this resource.', 401);
        }


    }

    public function replace(ReplaceTicketRequest $request, $ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);
            // Policy
            $this->isAble('replace', $ticket);

            $ticket->update($request->mappedAttributes());



        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket not found.', 404);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);
            // Policy
            $this->isAble('delete', $ticket);

            $ticket->delete();

            return $this->ok('Ticket successfully deleted');
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket not found.', 404);
        }
    }
}
