<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    /**
     * Apply middleware to restrict access
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:staff,admin']);
    }

    /**
     * Display support dashboard
     */
    public function index(): View
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            // Admin: lihat semua tiket dari karyawan
            $tickets = SupportTicket::with('user')
                ->whereHas('user', function($query) {
                    $query->where('role', 'staff');
                })
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            
            $stats = [
                'total' => SupportTicket::whereHas('user', function($query) {
                    $query->where('role', 'staff');
                })->count(),
                'open' => SupportTicket::where('status', 'open')
                    ->whereHas('user', function($query) {
                        $query->where('role', 'staff');
                    })->count(),
                'in_progress' => SupportTicket::where('status', 'in_progress')
                    ->whereHas('user', function($query) {
                        $query->where('role', 'staff');
                    })->count(),
                'resolved' => SupportTicket::whereIn('status', ['resolved', 'closed'])
                    ->whereHas('user', function($query) {
                        $query->where('role', 'staff');
                    })->count(),
            ];

            return view('support.admin.index', compact('tickets', 'stats'));
        }
        
        // Karyawan: hanya tiket sendiri
        $tickets = SupportTicket::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $stats = [
            'total' => SupportTicket::where('user_id', $user->id)->count(),
            'open' => SupportTicket::where('user_id', $user->id)->where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('user_id', $user->id)->where('status', 'in_progress')->count(),
            'resolved' => SupportTicket::where('user_id', $user->id)->whereIn('status', ['resolved', 'closed'])->count(),
        ];

        return view('support.staff.index', compact('tickets', 'stats'));
    }

    /**
     * Show FAQ page
     */
    public function faq(): View
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return view('support.admin.faq');
        }
        
        return view('support.staff.faq');
    }

    /**
     * Show guides page
     */
    public function guides(): View
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return view('support.admin.guides');
        }
        
        return view('support.staff.guides');
    }

    /**
     * Show troubleshooting page
     */
    public function troubleshooting(): View
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return view('support.admin.troubleshooting');
        }
        
        return view('support.staff.troubleshooting');
    }

    /**
     * Show ticket list
     */
    public function tickets(Request $request): View
    {
        $user = Auth::user();
        $query = SupportTicket::with(['user', 'admin']);

        if ($user->isAdmin()) {
            $query->whereHas('user', function($q) {
                $q->where('role', 'staff');
            });
        } else {
            $query->where('user_id', $user->id);
        }

        // Filter berdasarkan status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan priority
        if ($request->has('priority') && !empty($request->priority)) {
            $query->where('priority', $request->priority);
        }

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_number', 'LIKE', "%{$search}%")
                  ->orWhere('subject', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('support.tickets.index', compact('tickets'));
    }

    /**
     * Show create ticket form (karyawan only)
     */
    public function createTicket(): View
    {
        if (!Auth::user()->isStaff()) {
            abort(403, 'Hanya karyawan yang dapat membuat tiket support.');
        }

        return view('support.tickets.create');
    }

    /**
     * Store new ticket (karyawan only)
     */
    public function storeTicket(Request $request): RedirectResponse
    {
        if (!Auth::user()->isStaff()) {
            abort(403, 'Hanya karyawan yang dapat membuat tiket support.');
        }

        $validated = $request->validate([
            'category' => ['required', 'in:bug,feature,question,technical,other'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
        ], [
            'category.required' => 'Kategori harus dipilih.',
            'priority.required' => 'Prioritas harus dipilih.',
            'subject.required' => 'Subjek harus diisi.',
            'subject.max' => 'Subjek maksimal 255 karakter.',
            'description.required' => 'Deskripsi harus diisi.',
            'description.min' => 'Deskripsi minimal 10 karakter.',
        ]);

        SupportTicket::create([
            'user_id' => Auth::id(),
            'ticket_number' => SupportTicket::generateTicketNumber(),
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'status' => 'open',
        ]);

        return redirect()->route('support.tickets.index')
            ->with('success', 'Tiket berhasil dibuat. Tim support akan segera merespon.');
    }

    /**
     * Show ticket detail
     */
    public function showTicket(SupportTicket $ticket): View
    {
        $user = Auth::user();
        
        if ($user->isStaff() && $ticket->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke tiket ini.');
        }

        if ($user->isAdmin() && !$ticket->user->isStaff()) {
            abort(403, 'Tiket ini bukan dari karyawan.');
        }

        $ticket->load(['user', 'admin']);

        return view('support.tickets.show', compact('ticket'));
    }

    /**
     * Update ticket status (Admin only)
     */
    public function updateStatus(Request $request, SupportTicket $ticket): RedirectResponse
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => ['required', 'in:open,in_progress,resolved,closed'],
        ]);

        $ticket->status = $validated['status'];
        
        if ($validated['status'] === 'closed') {
            $ticket->closed_at = now();
        }

        $ticket->save();

        return redirect()->back()
            ->with('success', 'Status tiket berhasil diperbarui.');
    }

    /**
     * Reply to ticket (Admin only)
     */
    public function replyTicket(Request $request, SupportTicket $ticket): RedirectResponse
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'admin_reply' => ['required', 'string', 'min:10'],
        ], [
            'admin_reply.required' => 'Balasan harus diisi.',
            'admin_reply.min' => 'Balasan minimal 10 karakter.',
        ]);

        $ticket->admin_reply = $validated['admin_reply'];
        $ticket->admin_id = Auth::id();
        $ticket->replied_at = now();
        
        if ($ticket->status === 'open') {
            $ticket->status = 'in_progress';
        }

        $ticket->save();

        return redirect()->back()
            ->with('success', 'Balasan berhasil dikirim ke karyawan.');
    }
}