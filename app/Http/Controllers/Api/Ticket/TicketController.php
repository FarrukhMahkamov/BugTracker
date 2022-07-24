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

        if ($request->ticket_statuses !== null) {

            $ticketStatuses = $request->ticket_statuses;
            $ticket->ticketStatus()->detach();

            foreach ($ticketStatuses as $ticketStatus) { 
                $ticket->ticketStatus()->attach($ticketStatus["id"]);
            }
          
        }
        
        if ($request->ticket_users !== null) {
            
            $users = $request->ticket_users;
            $ticket->users()->detach();

            foreach ($users as $user) {
                $ticket->users()->attach($user['id']);
            }

        }
        
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
}
