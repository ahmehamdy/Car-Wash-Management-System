<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\CarWash;
use App\Models\Order;
use App\Actions\Order\CreateOrderAction;
use App\Actions\Order\UpdateOrderAction;
use App\Actions\Order\UpdateStatusAction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class OrderController extends Controller
{
    public function __construct(
        private CreateOrderAction $createAction,
        private UpdateOrderAction $updateAction,
        private UpdateStatusAction $updateStatus
    ) {}
    use AuthorizesRequests;

    public function index()
    {
        $userId = auth()->id();

        $totalOrders = Order::where('user_id', $userId)->count();
        $pendingOrders = Order::where('user_id', $userId)->where('status', 'pending')->count();
        $inProgressOrders = Order::where('user_id', $userId)->whereIn('status', ['confirmed', 'in-progress'])->count();
        $completedOrders = Order::where('user_id', $userId)->where('status', 'completed')->count();

        $recentOrders = Order::with('carwash', 'services')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('client.order.index', compact(
            'totalOrders',
            'pendingOrders',
            'inProgressOrders',
            'completedOrders',
            'recentOrders',
        ));
    }

    public function create(CarWash $carWash)
    {
        $services = $carWash->services();
        return view('client.order.create', compact('carWash', 'services'));
    }

    public function store(StoreOrderRequest $request, CarWash $carWash)
    {
        // $this->authorize('create');
        $data = $request->validated();

        $order = $this->createAction->execute(auth()->user(), $carWash, $data);

        return redirect()->route('client.order.showMyOrder', $order->id)
            ->with('success', 'تم إنشاء الطلب بنجاح');
    }

    public function showMyOrder(Order $order)
    {
        $order = Order::with('carwash', 'services')
            ->where('user_id', auth()->id())
            ->findOrFail($order);
        return view('client.order.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('client.order.edit', compact('order'));
    }

    public function updateMyOrder(UpdateOrderRequest $request, Order $order)
    {
        $data = $request->validated();

        $order = $this->updateAction->execute($order, $data, auth()->user());

        return response()->json([
            'success' => true,
            'redirect_url' => route('client.listMyOrders'),
        ]);
    }

    public function selectStatus(CarWash $carWash)
    {
        $this->authorize('viewCarWashOrder', $carWash);
        $stats = [
            'total' => $carWash->orders()->count(),
            'pending' => $carWash->orders()->where('status', 'pending')->count(),
            'confirmed' => $carWash->orders()->where('status', 'confirmed')->count(),
            'in_progress' => $carWash->orders()->where('status', 'in-progress')->count(),
            'completed' => $carWash->orders()->where('status', 'completed')->count(),
            'cancelled' => $carWash->orders()->where('status', 'cancelled')->count(),
            'today' => $carWash->orders()
                ->whereDate('created_at', now()->toDateString())
                ->count()
        ];
        return view('owner.orders.selectStatus', compact('stats', 'carWash'));
    }


    public function showCarwashOrder(CarWash $carWash, $status = null)
    {
        $this->authorize('viewCarWashOrder', $carWash);
        $query = $carWash->orders()->with(['user', 'services']);

        $orders = $query->where('status', $status)->latest()->paginate(15);

        $statusColors = [
            'pending' => 'warning',
            'accepted' => 'info',
            'in-progress' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            'all' => 'secondary',
            'today' => 'success',
            'search' => 'info'
        ];
        $statusText = [
            'pending' => 'قيد الانتظار',
            'confirmed' => 'مقبولة',
            'in-progress' => 'قيد التنفيذ',
            'completed' => 'مكتملة',
            'cancelled' => 'ملغية',
            'all' => 'جميع الطلبات',
            'today' => 'طلبات اليوم'
        ];
        $allowedTransitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['in-progress', 'cancelled'],
            'in-progress' => ['completed', 'cancelled'],
            'completed' => [],
            'cancelled' => [],
        ];

        return view('owner.orders.index', compact(
            'orders',
            'carWash',
            'status',
            'statusText',
            'statusColors',
            'allowedTransitions'
        ));
    }

    public function updateStatus(UpdateStatusRequest $request, Order $order)
    {
        $this->authorize('updateStatus', $order);

        $validated = $request->validated();

        $allowedTransitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['in-progress', 'cancelled'],
            'in-progress' => ['completed', 'cancelled'],
            'completed' => [],
            'cancelled' => [],
        ];

        $currentStatus = $order->status;
        $newStatus = $validated['status'];

        if (!in_array($newStatus, $allowedTransitions[$currentStatus] ?? [])) {
            return redirect()->back()
                ->with('error', 'تحول الحالة غير مسموح به. الحالة الحالية: ' .
                    ($statusText[$currentStatus] ?? $currentStatus) .
                    ' → الحالة الجديدة: ' .
                    ($statusText[$newStatus] ?? $newStatus));
        }

        $order->update(['status' => $newStatus]);

        $successMessages = [
            'pending_to_confirmed' => 'تم قبول الطلب بنجاح',
            'pending_to_cancelled' => 'تم رفض الطلب بنجاح',
            'confirmed_to_in-progress' => 'تم بدء تنفيذ الطلب',
            'confirmed_to_cancelled' => 'تم إلغاء الطلب بعد القبول',
            'in-progress_to_completed' => 'تم إكمال الطلب بنجاح',
            'in-progress_to_cancelled' => 'تم إيقاف الطلب أثناء التنفيذ',
        ];

        $transitionKey = $currentStatus . '_to_' . $newStatus;
        $successMessage = $successMessages[$transitionKey] ?? 'تم تحديث حالة الطلب بنجاح';

        return redirect()->back()->with('success', $successMessage);
    }

    public function deleteMyOrder(Order $order)
    {
        $this->authorize('delete', $order);
        $order->delete();
        return response()->json([
            'message' => 'order deleted'
        ], 200);
    }
}
