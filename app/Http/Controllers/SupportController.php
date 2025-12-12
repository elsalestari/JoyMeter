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
     * Routes to different views based on role
     */
    public function index(): View
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            // Admin: lihat semua tiket dari karyawan
            $tickets = SupportTicket::with('user')
                ->whereHas('user', function($query) {
                    $query->where('role', 'staff'); // Hanya tiket dari karyawan
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
                'resolved' => SupportTicket::where('status', 'resolved')
                    ->whereHas('user', function($query) {
                        $query->where('role', 'staff');
                    })->count(),
            ];

            // Route ke view admin
            return view('support.admin.index', compact('tickets', 'stats'));
        } else {
            // Karyawan: hanya tiket sendiri
            $tickets = SupportTicket::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            
            $stats = [
                'total' => SupportTicket::where('user_id', $user->id)->count(),
                'open' => SupportTicket::where('user_id', $user->id)->where('status', 'open')->count(),
                'in_progress' => SupportTicket::where('user_id', $user->id)->where('status', 'in_progress')->count(),
                'resolved' => SupportTicket::where('user_id', $user->id)->where('status', 'resolved')->count(),
            ];

            // Route ke view staff
            return view('support.staff.index', compact('tickets', 'stats'));
        }
    }

    /**
     * Show FAQ page
     * Routes to different views based on role
     */
    public function faq(): View
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return view('support.admin.faq');
        }
        
        return view('support.staff.faq');
    }

    /**
     * Show guides page
     * Routes to different views based on role
     */
    public function guides(): View
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return view('support.admin.guides');
        }
        
        return view('support.staff.guides');
    }

    /**
     * Show troubleshooting page
     * Routes to different views based on role
     */
    public function troubleshooting(): View
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
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

        // Filter untuk admin: lihat semua tiket dari karyawan
        // Filter untuk karyawan: hanya tiket sendiri
        if ($user->role === 'admin') {
            $query->whereHas('user', function($q) {
                $q->where('role', 'staff'); // Hanya tiket dari karyawan
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
     * Show create ticket form (Hanya Karyawan)
     */
    public function createTicket(): View
    {
        // Hanya karyawan yang bisa buat tiket
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Hanya karyawan yang dapat membuat tiket support.');
        }

        return view('support.tickets.create');
    }

    /**
     * Store new ticket (Hanya Karyawan)
     */
    public function storeTicket(Request $request): RedirectResponse
    {
        // Hanya karyawan yang bisa buat tiket
        if (Auth::user()->role !== 'staff') {
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
        // Karyawan hanya bisa lihat tiket sendiri
        // Admin bisa lihat semua tiket dari karyawan
        if (Auth::user()->role === 'staff' && $ticket->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke tiket ini.');
        }

        // Admin hanya bisa lihat tiket dari karyawan
        if (Auth::user()->role === 'admin' && $ticket->user->role !== 'staff') {
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
        if (Auth::user()->role !== 'admin') {
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
        if (Auth::user()->role !== 'admin') {
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
        
        // Auto update status jika masih open
        if ($ticket->status === 'open') {
            $ticket->status = 'in_progress';
        }

        $ticket->save();

        return redirect()->back()
            ->with('success', 'Balasan berhasil dikirim ke karyawan.');
    }
}