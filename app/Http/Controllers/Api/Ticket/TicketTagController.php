<?php

namespace App\Http\Controllers\Api\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\TicketTagRequest;
use App\Http\Resources\Ticket\TicketTagResource;
use App\Models\TicketTag;
use Illuminate\Http\Request;

/**
 * @group TICKET TAGS
 * 
 * Taglar uchun api
 */
class TicketTagController extends Controller
{   
    /**
     * Barcha taglar ro'yhati
     */
    public function index()
    {
        $ticketTags = TicketTag::latest()->get();

        return TicketTagResource::collection($ticketTags);
    }

    /**
     * Yangi tag joylash
     */
    public function store(TicketTagRequest $request)
    {
        $ticketTag = TicketTag::create([
            "name" => $request->input('ticket_tag_name'),
            "color" => $request->input('ticket_tag_color')
        ]);

        return new TicketTagResource($ticketTag);
    }

    /**
     * Mavjud tagni o'zgartirish
     */
    public function update(TicketTagRequest $request, $id)
    {
        $ticketTag = TicketTag::findOrFail($id);

        $ticketTag->update([
            "name" => $request->input('ticket_tag_name'),
            "color" => $request->input('ticket_tag_color')
        ]);

        return new TicketTagResource($ticketTag);
    }

    /**
     * Mavjud tagni ochirish
     */
    public function destroy($id)
    {
        $ticketTag = TicketTag::findOrFail($id);

        $ticketTag->delete();

        return response()->json([
            "data" => "Deleted Successfully"
        ]);
    }
}
