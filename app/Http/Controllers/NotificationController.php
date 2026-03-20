<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Controlador para operações de leitura de notificações do utilizador autenticado.
class NotificationController extends Controller
{
    // Marca uma notificação individual como lida e, opcionalmente, redireciona para um destino seguro.
    public function markAsRead(Request $request, DatabaseNotification $notification): RedirectResponse
    {
        // Garante que o utilizador só pode marcar as suas próprias notificações.
        if ((int) $notification->notifiable_id !== (int) Auth::id()) {
            abort(403);
        }

        $notification->markAsRead();

        $redirectTo = trim((string) $request->input('redirect_to', ''));

        if ($redirectTo !== '') {
            // Permite redirecionamento absoluto apenas dentro do mesmo domínio.
            if (Str::startsWith($redirectTo, url('/'))) {
                return redirect()->to($redirectTo);
            }

            // Permite redirecionamento relativo interno.
            if (Str::startsWith($redirectTo, '/')) {
                return redirect()->to($redirectTo);
            }
        }

        return back();
    }

    // Marca todas as notificações não lidas do utilizador atual.
    public function markAllAsRead(): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            $user->unreadNotifications->markAsRead();
        }

        return back();
    }
}



