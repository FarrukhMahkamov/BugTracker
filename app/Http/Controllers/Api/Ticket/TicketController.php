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
            "data" => [
                "message" => "Deleted successfully"
                ]
            ], 204);
        }
    }
    