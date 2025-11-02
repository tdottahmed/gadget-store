<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderShipment;
use Exception;
use SteadFast\SteadFastCourierLaravelPackage\Facades\SteadfastCourier;

class SteadFastCourierService
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle(): array
    {
        try {
            $shippingAddress = is_string($this->order->shipping_address_data) ? json_decode($this->order->shipping_address_data, true) : $this->order->shipping_address_data;

            if (empty($shippingAddress)) {
                throw new Exception('Shipping address data not found or invalid.');
            }
            $cod_amount = ($this->order->order_amount ?? 0) + ($this->order->shipping_cost ?? 0);

            $orderData = [
                'invoice'           => $this->order->id,
                'recipient_name'    => $shippingAddress->contact_person_name ?? '',
                'recipient_phone'   => $shippingAddress->phone ?? '',
                'recipient_address' => $this->formatAddress($shippingAddress),
                'cod_amount'        => $cod_amount,
                'note'              => $this->order->order_note ?? '',
            ];

            $response = SteadfastCourier::placeOrder($orderData);

            if (!isset($response['status']) || $response['status'] != 200) {
                return [
                    'success' => false,
                    'message' => 'Failed to create courier order',
                    'response' => $response
                ];
            }
            $this->updateOrderShipment($response);
            return [
                'success' => true,
                'message' => 'Order shipment created successfully',
                'data'    => $response
            ];
        } catch (Exception $e) {
            logger('Steadfast Error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ];
        }
    }

    /**
     * Format address for Steadfast API
     */
    private function formatAddress($address): string
    {
        if (is_array($address)) {
            $address = (object) $address;
        }

        return trim(sprintf(
            "%s, %s, %s",
            $address->contact_person_name ?? '',
            $address->address ?? '',
            $address->city ?? ''
        ));
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
            'order_status' => 'delivered',
        ]);

        return $shipment;
    }
}
