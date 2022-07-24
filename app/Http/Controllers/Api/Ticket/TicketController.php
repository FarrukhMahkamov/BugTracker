<?php

namespace App\Http\Controllers\Api\Ticket;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\TicketRequest;
use App\Http\Resources\Ticket\TicketResource;

/**
* TICKETLAR
* 
* Ticketlar uchun API
*/
class TicketController extends Controller
{   
    public function index()
    {
        $tickets = Ticket::latest()->get();
        
        return TicketResource::collection($tickets);
    }
    
    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        return new TicketResource($ticket);
    }
    
    public function store(TicketRequest $request)
    {
        $ticket = Ticket::create([
            'title' => $request->input('ticket_title'),
            'description' => $request->input('ticket_description'),
            'project_id' => $request->input('project_id') 
        ]);

        if ($request->ticket_statuses !== null) {

            $ticketStatuses = $request->ticket_statuses;

            foreach ($ticketStatuses as $ticketStatus) {
                $ticket->ticketStatus()->attach($ticketStatus["id"]);
            }
          
        }
        
        if ($request->users !== null) {
            $users = $request->ticket_users;

            foreach ($users as $user) {
                $ticket->users()->attach($user['id']);
            }

        }
 
        return new TicketResource($ticket);
    }
    
    public function update(TicketRequest $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        $ticket->update([
            'title' => $request->input('ticket_title'),
            'description' => $request->input('ticket_description'),
            'project_id' => $request->input('project_id') 
        ]);
        
        return new TicketResource($ticket);
    }
    
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        $ticket->delete();
        
        return response()->json([ 
            'data' => 'Deleted Successfully'
        ]);
    }
    
    /**
     * Ticketga yangi hodimi biriktirish. 
     *  "uesrs" : [1, 2, 3, 4]
     */
    public function attachUsersToTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        foreach ($request->ticket_users as $user) {
            $ticket->users()->attach($user);
        }
    }

    /**
     * Ticketdan hodimni chiqarib tashlash.  
     * "uesrs" : [1, 2, 3, 4]
     */
    public function detachUserFromTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        foreach ($request->ticket_users as $user) {
            $ticket->users()->detach($user);
        }
    }

    /**
     *  Ticketga yangi status biriktirish.
     * "ticket_statuses" : [1, 2, 3, 4, 5]
     */
    public function attachStatusToTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        foreach ($request->ticket_statuses as $ticket_status) {
            $ticket->ticketStatus()->attach($ticket_status);
        }
    }

    /**
     *  Ticketdan ticket statusni olib tashlash.
     * "ticket_statuses" : [1, 2, 3, 4, 5]
     */
    public function detachTicketStatusFromTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        foreach ($request->ticket_statuses as $ticket_status) {
            $ticket->ticketStatus()->detach($ticket_status);
        }
    }
    
}
