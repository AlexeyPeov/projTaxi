<?php

namespace App\Services;


use App\Framework\ORM;
use App\Models\Customer;
use App\Models\Order;
use stdClass;

class OrderService
{
    private ORM $orm;

    public function __construct(ORM $orm)
    {
        $this->orm = $orm;
    }

    public function getORM () : ORM {
        return $this->orm;
    }

    //CUSTOMER

    public function createOrder(array $request): void
    {
        //check if exists
        $customer = $this->orm->findByValue(
            'customers',
            'phone_number',
            $request['phoneNumber']
        );

        if (!$customer) {
            $customer = $this->orm->createModel('customers');
            $customer->phone_number = $request['phoneNumber'];
            $customer->first_name = $request['firstName'];
            $customer->personal_discount = 0;
            $customer->order_count = 1;
        } else {
            $customer->order_count += 1;
            $customer->updated_at = date('Y-m-d H:i:s');
            $customer->personal_discount = Customer::calculatePersonalDiscount($customer->order_count);
        }

        $customer = $this->orm->push('customers', $customer);

        //creating order

        $order = $this->orm->createModel('orders');

        $order->customer_id = $customer->id;
        $order->status = Order::STATE_NEW;
        $order->class = $request['carClass'];
        $order->price = Order::calculatePrice($order->class, $customer->personal_discount);
        $order->point_a = $request['pointA'];
        $order->point_b = $request['pointB'];
        $order->review_given = false;
        $this->orm->push('orders', $order);

        //then start session
        $_SESSION['id'] = $customer->id;



        //$customer = $this->orm->findByValue('customers', 'phoneNumber');
        // если нет - создать, и закинуть в датабазу
        /*if ($customer == null) {
            $customer = new Customer(
                null,
                $firstName,
                $secondName,
                $birthday,
                0,
                $phoneNum,
                0,
                0,
                false
            );
            $this->customerRepository->save($customer);
            $customer = $this->customerRepository->findByPhoneNum($phoneNum); //чтобы не было проблем с id = null
        }

        //плюсуем кол-во поездок, расчитываем скидку
        $customer->updateOrderCount();

        //датабаза обновляет значения полей
        $this->customerRepository->save($customer);

        //создать заказ
        $order = new Order(
            null,
            Order::STATE_NEW,
            $customer->getId(),
            null,
            $class,
            0,
            $pointA,
            $pointB,
            null,
            false,
            false
        );

        $order->calculatePrice($customer);//посчитать цену
        $order->calculateDayCreated();//поставить день создания(текущие дата и время)

        $this->orderRepository->save($order); */
    }


    public function decline(array $request) : void {
        //find order

        $order = $this->orm->findById('orders', $request['orderId']);


        if($request['action'] == 'Decline') {

            // if customer declines
            if(!array_key_exists('taxiDriverId', $request)) {
                $customer = $this->orm->findById('customers', $request['customerId']);
                $customer->order_declined_count += 1;
                $customer->updated_at = date('Y-m-d H:i:s');

                $order->status = Order::STATE_FAILED;
                $order->updated_at = date('Y-m-d H:i:s');
                $this->orm->push('orders', $order);
                $this->orm->push('customers', $customer);

            } else {

                $taxiDriver = $this->orm->findById('taxi_drivers', $request['taxiDriverId']);
                $taxiDriver->order_declined_count += 1;
                $taxiDriver->updated_at = date('Y-m-d H:i:s');

                $order->status = Order::STATE_NEW;
                $order->taxi_driver_id = null;
                $order->updated_at = date('Y-m-d H:i:s');
                $this->orm->push('orders', $order);
                $this->orm->push('taxi_drivers', $taxiDriver);
            }

        } else {
            echo "wrong request params at OrderService.decline()";
            dd($request);
        }
    }
    /*
       public function reviewOrder(int $orderId, int $customerId, int $review): void
       {
           $order = $this->orderRepository->findById($orderId);
           $customer = $this->customerRepository->findById($customerId);

           if (
               $customer !== null &&
               $order !== null &&
               !$order->isReviewGiven() &&
               $order->getCustomerId() == $customerId
           ) {
               if ($review > 5) {
                   $review = 5;
               } elseif ($review < 0) {
                   $review = 0;
               }
               $taxiDriver = $this->taxiDriverRepository->findById($order->getTaxiDriverId());

               $taxiDriver->reviewIsGiven();
               $taxiDriver->addReviewToHeap($review);
               $taxiDriver->displayRating(); // если дали 10 оценок, выводить рейтинг


               $this->taxiDriverRepository->save($taxiDriver);
               $order->reviewGiven();
               $this->orderRepository->save($order);
           }
       }

       public function abortOrderAsCustomer(int $orderId, int $customerId)
       {
           $order = $this->orderRepository->findById($orderId);
           $customer = $this->customerRepository->findById($customerId);
           if (
               $order !== null &&
               $customer !== null &&
               ($order->getStatus() == $order::STATE_NEW || $order->getStatus() == $order::STATE_ACCEPTED) &&
               $order->getCustomerId() == $customerId
           ) {
               $order->failed();
               $customer->declinedOrder();
               $this->orderRepository->save($order);
               $this->customerRepository->save($customer);
           }


       }

       //TAXI DRIVER

       public function takeOrder(int $orderId, int $taxiDriverId)
       {
           $taxiDriver = $this->taxiDriverRepository->findById($taxiDriverId);
           $order = $this->orderRepository->findNewOrderById($orderId);
           if ($taxiDriver !== null) { // если есть таксист, продолжить
               $car = $this->carRepository->findById($taxiDriver->getCarDriving());
               if (
                   $order !== null &&
                   $car->getCarClass() == $order->getClass() &&
                   $order->getOrderStatus() == Order::STATE_NEW
               ) {
                   $order->accepted();
                   $order->setTaxiDriverId($taxiDriverId);
                   $this->orderRepository->save($order);
               }
           }
       } // взять заказ

       public function abortOrderAsTaxiDriver(int $orderId, int $taxiDriverId): void
       {
           $order = $this->orderRepository->findById($orderId);
           $taxiDriver = $this->taxiDriverRepository->findById($taxiDriverId);
           if ($taxiDriver !== null) {// если есть такой таксист
               if (
                   $order !== null &&
                   $order->getStatus() == Order::STATE_ACCEPTED &&
                   $order->getTaxiDriverId() == $taxiDriverId
               ) {
                   $order->stateNew();
                   $order->setTaxiDriverId(null);
                   $this->orderRepository->save($order);
               }
           }

       } //отменить заказ (только STATE_ACCEPTED)

       public function clientTaken(int $orderId, int $taxiDriverId): void
       {
           $order = $this->orderRepository->findById($orderId);
           $taxiDriver = $this->taxiDriverRepository->findById($taxiDriverId);
           if ($taxiDriver !== null) { // если есть таксист
               if (
                   $order !== null &&
                   $order->getStatus() == Order::STATE_ACCEPTED &&
                   $order->getTaxiDriverId() == $taxiDriverId
               ) {
                   $order->inProgress();
                   $this->orderRepository->save($order);
               }
           }
       } // изменить state на STATE_IN_PROGRESS

       public function finishOrder(int $orderId, int $taxiDriverId): void
       {

           $order = $this->orderRepository->findById($orderId);
           $taxiDriver = $this->taxiDriverRepository->findById($taxiDriverId);
           if ($taxiDriver !== null) {
               if (
                   $order !== null &&
                   $order->getStatus() == Order::STATE_IN_PROGRESS &&
                   $order->getTaxiDriverId() == $taxiDriverId
               ) {
                   $order->complete();
                   $this->orderRepository->save($order);
               }
           }


       } // изменить state на STATE_COMPLETE
    */
}