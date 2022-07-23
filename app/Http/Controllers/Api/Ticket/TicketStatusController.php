<?php

namespace App\Http\Controllers\Api\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\TicketRequest;
use App\Http\Requests\Ticket\TicketStatusRequest;
use App\Http\Resources\Ticket\TicketStatusResource;
use App\Models\TicketStatus;
use Illuminate\Http\Request;

/**
 * TICKET STATUS COLORS
 * 
 * Ticket status ranglari uchun API
 */
class TicketStatusController extends Controller
{   
    /**
     * Barhca ticket status ranlagri ro'yhati
     */
    public function index()
    {
        $ticketStatuses = TicketStatus::latest()->get();
        
        return TicketStatusResource::collection($ticketStatuses);
    }
    
    /**
     * Yangi ticket status joylash
     */
    public function store(TicketStatusRequest $request)
    {
        $ticketStatus = TicketStatus::create([
            'name' => $request->input('ticket_status_name'),
            'color' => $request->input('ticket_status_color')
        ]);
        
        return new TicketStatusResource($ticketStatus);
    }
    
    /**
     * Mavjud ticket statusni o'zgartirish
     */
    public function update(TicketStatusRequest $request, $id)
    {
        $ticketStatus = TicketStatus::findOrFail($id);
        
        $ticketStatus->update([
            'name' => $request->input('ticket_status_name'),
            'color' => $request->input('ticket_status_color')
        ]);

        return new TicketStatusResource($ticketStatus);
    }

    /**
     * Mavjud ticket statusni ochirib tashlash
     */
    public function destroy($id)
    {
        $ticketStatus = TicketStatus::findOrFail($id);
        
        $ticketStatus->delete();

        return response()->json([
            'data' => 'Deleted Successfully'
        ]);
    }
}
