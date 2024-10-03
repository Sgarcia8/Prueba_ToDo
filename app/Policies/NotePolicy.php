<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NotePolicy
{
    /**
     * Determine whether the user can permanently delete the model.
     */
    public function modify(User $user, Note $note): Response
    {   
        //politica que solo le permite al usuario autenticado el poder modificar
        return $user->id === $note->user_id
            ? Response::allow()
            : Response::deny('Esta nota no te pertenece');
    }
}
