<?php

namespace App\Http\Resources\Ticket;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ticket_title' => $this->title,
            'ticket_description' => $this->description,
            'project_id' => $this->project_id,
            'project_name' => $this->project->name,
            'ticket_statuses' => TicketStatusResource::collection($this->ticketStatus),
            'ticket_users' => TicketUsersResource::collection($this->ticketUser),
            'ticket_tags' => TicketTagResource::collection($this->ticketTag),
        ];
    }
}
