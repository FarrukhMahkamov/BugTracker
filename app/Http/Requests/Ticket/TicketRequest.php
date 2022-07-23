<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'ticket_title' => 'required|min:3|max:255|unique:tickets,title,' . $this->id,
            'ticket_description' => 'required|min:5|max:5000',
            'project_id' => 'required|exists:projects,id'
        ];
    }
}
