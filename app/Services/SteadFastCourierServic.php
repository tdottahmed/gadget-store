<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderShipment;
use Exception;
use SteadFast\SteadFastCourierLaravelPackage\Facades\SteadfastCourier;

class SteadFastCourierServic
{
    protected $order;
    protected $shipping_address;

    public function __construct(Order $order, $shipping_address)
    {
        $this->order = $order;
        $this->shipping_address = $shipping_address;
    }

    public function handle(): array
    {
        try {
            $cod_amount = $this->order->orderDetails->sum('price') + $this->order->orderDetails()->sum('shipping_cost');
            $orderData = [
                'invoice' => $this->order->code,
                'recipient_name' => $this->shipping_address->name,
                'recipient_phone' => $this->shipping_address->phone,
                'recipient_address' => $this->formatAddress(),
                'cod_amount' => $cod_amount,
                'note' => $this->order->additional_info
            ];
            $response = SteadfastCourier::placeOrder($orderData);

            if (!isset($response['status']) || $response['status'] != 200) {
                return [
                    'success' => false,
                    'message' => 'Failed to create courier order'
                ];
            }

            $this->updateOrderShipment($response);
            return [
                'success' => true,
                'message' => 'Order shipment created successfully',
                'data' => $response
            ];

        } catch (Exception $e) {
            logger('Something went Wrong with the Steadfast'.$e->getMessage());
            return [
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ];
        }
    }

    protected function updateOrderShipment($response): OrderShipment
    {
        $shipment = OrderShipment::create([
            'order_id' => $this->order->id,
            'invoice_no' => $response['consignment']['invoice'],
            'consignment_no' => $response['consignment']['consignment_id'],
            'tracking_code' => $response['consignment']['tracking_code'],
            'carrier' => 'steadfast',
            'status' => $response['consignment']['status'],
            'recipient_name' => $response['consignment']['recipient_name'],
            'recipient_address' => $response['consignment']['recipient_address'],
            'recipient_phone' => $response['consignment']['recipient_phone'],
            'phone' => $response['consignment']['alternative_phone'],
            'note' => $response['consignment']['note']
        ]);

        $this->order->update([
            'delivery_status' => 'processing',
        ]);

        return $shipment;
    }

    protected function formatAddress(): string
    {
        return implode(', ', array_filter([
            $this->shipping_address->address,
            $this->shipping_address->city,
            $this->shipping_address->state,
            $this->shipping_address->postal_code
        ]));
    }
}
