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
            foreach ($request->ticket_statuses as $ticket_status) {
                $ticket->ticketStatus()->attach($ticket_status);
            }
        }
        
        if ($request->ticket_users !== null) {
            foreach ($request->ticket_users as $ticket_user) {
                $ticket->ticketUser()->attach($ticket_user);
            }
        }

        if ($request->ticket_tags !== null) {
            foreach ($request->ticket_tags as $ticket_tag) {
                $ticket->ticketTag()->attach($ticket_tag);
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
            $ticket->ticketUser()->attach($user);
        }
        
        return response()->json([
            "data" => "Attached Successfully"
        ]);
    }
    
    /**
    * Ticketdan hodimni chiqarib tashlash.  
    * "uesrs" : [1, 2, 3, 4]
    */
    public function detachUserFromTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        foreach ($request->ticket_users as $user) {
            $ticket->ticketUser()->detach($user);
        }
        
        return response()->json([
            "data" => "Detached Successfully"
        ]);
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
        
        return response()->json([
            "data" => "Attached Successfully"
        ]);
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
        
        return response()->json([
            "data" => "Detached Successfully"
        ]);
    }
    
    /**
    * Ticketga yangi tag(lar) qo'shsih
    * "ticket_tags" : [1, 3, 5]
    */
    public function attachTagToTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        foreach ($request->ticket_tags as $tags) {
            $ticket->ticketTag()->attach($tags);
        }

        return response()->json([
            "data" => "Attached Successfully"
        ]);
    }
    
    /**
    * Ticketdan taglarni o'chirish.
    * "ticket_tags" : [1, 3, 5]
    */
    public function detachTicketTagFromTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        foreach ($request->ticket_tags as $tags) {
            $ticket->ticketTag()->detach($tags);
        }
           
        return response()->json([
            "data" => "Detached Successfully"
        ]);
    }
    
}
