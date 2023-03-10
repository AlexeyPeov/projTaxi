<?php

namespace App\Services;


class OrderService
{
    private OrderRepository $orderRepository;
    private CustomerRepository $customerRepository;
    private TaxiDriverRepository $taxiDriverRepository;
    private CarRepository $carRepository;

    public function __construct(
        OrderRepository      $orderRepository,
        CustomerRepository   $customerRepository,
        TaxiDriverRepository $taxiDriverRepository,
        CarRepository        $carRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->taxiDriverRepository = $taxiDriverRepository;
        $this->carRepository = $carRepository;
    }

    public function getCustomerRepository(): CustomerRepository
    {
        return $this->customerRepository;
    }

    public function getOrderRepository(): OrderRepository
    {
        return $this->orderRepository;
    }

    public function getCarRepository(): CarRepository
    {
        return $this->carRepository;
    }

    public function getTaxiDriverRepository(): TaxiDriverRepository
    {
        return $this->taxiDriverRepository;
    }

    public function setCustomerRepository(CustomerRepository $customerRepository): void
    {
        $this->customerRepository = $customerRepository;
    }

    public function setOrderRepository(OrderRepository $orderRepository): void
    {
        $this->orderRepository = $orderRepository;
    }

    public function setCarRepository(CarRepository $carRepository): void
    {
        $this->carRepository = $carRepository;
    }

    public function setTaxiDriverRepository(TaxiDriverRepository $taxiDriverRepository): void
    {
        $this->taxiDriverRepository = $taxiDriverRepository;
    }

    //CUSTOMER

    public function createOrder(
        string    $firstName,
        ?string   $secondName,
        ?DateTime $birthday,
        string    $phoneNum,
        string    $pointA,
        string    $pointB,
        int       $class
    )
    {
        //проверить был ли клиент уже
        $customer = $this->customerRepository->findByPhoneNum($phoneNum);

        // если нет - создать, и закинуть в датабазу
        if ($customer == null) {
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

        $this->orderRepository->save($order);
    }

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
}